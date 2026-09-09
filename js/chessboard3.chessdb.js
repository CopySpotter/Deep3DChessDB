/**
 * chessboard3.chessdb.js
 * Small ChessDB client/adapter for chessboard3.js.
 *
 * The board itself only stores piece placement. ChessDB needs a complete FEN
 * (side to move, castling, en-passant, clocks), so callers should normally pass
 * a full FEN or provide getFen().
 */
;(function (root) {
  'use strict';

  function encodeQuery(params) {
    var out = [];
    Object.keys(params).forEach(function (key) {
      if (params[key] === undefined || params[key] === null) return;
      out.push(encodeURIComponent(key) + '=' + encodeURIComponent(String(params[key])));
    });
    return out.join('&');
  }

  function withTimeout(promise, ms) {
    if (!ms || !root.AbortController) return promise(null);
    var controller = new AbortController();
    var timer = setTimeout(function () { controller.abort(); }, ms);
    return promise(controller.signal).then(function (x) {
      clearTimeout(timer);
      return x;
    }, function (err) {
      clearTimeout(timer);
      throw err;
    });
  }

  function ChessDBClient(options) {
    options = options || {};
    this.endpoint = options.endpoint || 'chessdb-proxy.php';
    this.learn = options.learn === true ? 1 : 0;
    this.timeout = options.timeout || 12000;
  }

  ChessDBClient.prototype._request = function (action, fen, extra) {
    if (!fen || typeof fen !== 'string') {
      return Promise.reject(new Error('ChessDB requires a complete FEN string.'));
    }
    var params = { action: action, board: fen, learn: this.learn, json: 1 };
    extra = extra || {};
    Object.keys(extra).forEach(function (key) { params[key] = extra[key]; });
    var url = this.endpoint + (this.endpoint.indexOf('?') === -1 ? '?' : '&') + encodeQuery(params);

    return withTimeout(function (signal) {
      return fetch(url, { method: 'GET', cache: 'no-store', signal: signal || undefined });
    }, this.timeout).then(function (res) {
      if (!res.ok) throw new Error('ChessDB HTTP ' + res.status);
      return res.text();
    }).then(function (text) {
      var trimmed = text.trim();
      if (!trimmed) return { status: 'empty', raw: '' };
      try {
        return JSON.parse(trimmed);
      } catch (e) {
        return { status: 'ok', raw: trimmed };
      }
    });
  };

  ChessDBClient.prototype.queryAll = function (fen, options) {
    return this._request('queryall', fen, options);
  };
  ChessDBClient.prototype.queryBest = function (fen, options) {
    return this._request('querybest', fen, options);
  };
  ChessDBClient.prototype.queryScore = function (fen, options) {
    return this._request('queryscore', fen, options);
  };
  ChessDBClient.prototype.queryPv = function (fen, options) {
    return this._request('querypv', fen, options);
  };
  ChessDBClient.prototype.queue = function (fen) {
    return this._request('queue', fen, { json: 0 });
  };

  function sleep(ms) {
    return new Promise(function (resolve) { setTimeout(resolve, ms); });
  }

  function isUnknown(result) {
    if (!result) return true;
    if (result.status === 'unknown') return true;
    var moves = normalizeMoves(result);
    if (moves.length && moves[0].score == null && result.status !== 'ok') return true;
    return false;
  }

  /**
   * Mirror the official queryc_en flow for unknown positions:
   * queryall(learn=1,showall=1) -> queue once -> poll every 5s until data arrives.
   */
  ChessDBClient.prototype.compute = function (fen, options) {
    options = options || {};
    var self = this;
    var interval = options.interval || 5000;
    var maxAttempts = options.maxAttempts || 12;
    var onProgress = typeof options.onProgress === 'function' ? options.onProgress : function () {};

    function query(attempt) {
      onProgress({ phase: 'query', attempt: attempt, maxAttempts: maxAttempts });
      return self.queryAll(fen, { learn: 1, showall: 1 }).then(function (result) {
        if (!isUnknown(result)) return result;
        if (attempt >= maxAttempts) {
          return { status: 'pending', message: 'ChessDB analysis is still pending.', attempts: attempt, raw: result };
        }
        onProgress({ phase: 'waiting', attempt: attempt, maxAttempts: maxAttempts, seconds: Math.round(interval / 1000) });
        return sleep(interval).then(function () { return query(attempt + 1); });
      });
    }

    return self.queryAll(fen, { learn: 1, showall: 1 }).then(function (first) {
      if (!isUnknown(first)) return first;
      onProgress({ phase: 'queue', attempt: 0, maxAttempts: maxAttempts });
      return self.queue(fen).then(function (queued) {
        if (queued.status !== 'ok') return queued;
        onProgress({ phase: 'queued', attempt: 0, maxAttempts: maxAttempts, seconds: Math.round(interval / 1000) });
        return sleep(interval).then(function () { return query(1); });
      });
    });
  };

  function normalizeMoves(result) {
    if (!result) return [];
    var moves = [];
    if (Array.isArray(result.moves)) moves = result.moves;
    else if (result.data && Array.isArray(result.data.moves)) moves = result.data.moves;

    return moves.map(function (move) {
      if (!move || move.score !== '??') return move;
      var copy = {};
      Object.keys(move).forEach(function (key) { copy[key] = move[key]; });
      copy.score = null;
      return copy;
    });
  }

  /**
   * Attach convenience methods to a ChessBoard3 instance.
   * options.getFen may return the full current FEN.
   */
  function attach(board, options) {
    if (!board) throw new Error('A ChessBoard3 instance is required.');
    options = options || {};
    var client = options.client || new ChessDBClient(options);

    function fullFen(fen) {
      if (fen) return fen;
      if (typeof options.getFen === 'function') return options.getFen();
      // Last-resort display-only composition. It is NOT enough for a real game
      // once side/castling/en-passant state differs from these defaults.
      var pieceFen = typeof board.fen === 'function' ? board.fen() : null;
      if (!pieceFen) throw new Error('No FEN available. Pass a full FEN or getFen().');
      return pieceFen + ' ' + (options.sideToMove || 'w') + ' ' +
        (options.castling || '-') + ' ' + (options.enPassant || '-') + ' ' +
        (options.halfmove || 0) + ' ' + (options.fullmove || 1);
    }

    board.chessdb = {
      client: client,
      analyze: function (fen) { return client.queryAll(fullFen(fen), { showall: 1 }); },
      compute: function (fen, options2) { return client.compute(fullFen(fen), options2); },
      best: function (fen) { return client.queryBest(fullFen(fen)); },
      score: function (fen) { return client.queryScore(fullFen(fen)); },
      pv: function (fen) { return client.queryPv(fullFen(fen)); },
      deepen: function (fen) { return client.queue(fullFen(fen)); },
      moves: function (fen) { return client.queryAll(fullFen(fen)).then(normalizeMoves); }
    };
    return board.chessdb;
  }

  root.ChessDBClient = ChessDBClient;
  root.ChessBoard3ChessDB = {
    attach: attach,
    normalizeMoves: normalizeMoves
  };
})(typeof window !== 'undefined' ? window : this);
