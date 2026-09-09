<?php
/**
 * Minimal same-origin proxy for ChessDB.
 *
 * The browser talks only to this local PHP endpoint. The proxy first tries
 * ChessDB over HTTPS and falls back to the HTTP API endpoint documented by
 * ChessDB if HTTPS fails or the upstream returns a 5xx error.
 */
header('Cache-Control: no-store');
header('Content-Type: application/json; charset=utf-8');

$allowed = ['queryall', 'querybest', 'queryscore', 'querypv', 'querysearch', 'queue'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$board = isset($_GET['board']) ? $_GET['board'] : '';

if (!in_array($action, $allowed, true) || $board === '') {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid action or missing board/FEN.'
    ]);
    exit;
}

$params = [
    'action' => $action,
    'board'  => $board,
    'learn'  => (isset($_GET['learn']) && $_GET['learn'] === '1') ? '1' : '0',
];

if ($action !== 'queue') {
    $params['json'] = '1';
}

foreach (['showall', 'endgame', 'egtbmetric'] as $key) {
    if (isset($_GET[$key])) {
        $params[$key] = $_GET[$key];
    }
}

$query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
$urls = [
    'https://www.chessdb.cn/cdb.php?' . $query,
    'http://www.chessdb.cn/cdb.php?' . $query,
];

function statusFromHeaders($headers) {
    if (!is_array($headers)) {
        return 0;
    }

    $status = 0;
    foreach ($headers as $header) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#i', $header, $m)) {
            $status = (int)$m[1];
        }
    }
    return $status;
}

function requestChessDB($url) {
    $result = [
        'body' => false,
        'status' => 0,
        'contentType' => 'application/json; charset=utf-8',
        'error' => '',
        'url' => $url,
    ];

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'Deep3DChessDB/0.1',
        ]);

        $body = curl_exec($ch);
        $result['body'] = $body;
        $result['status'] = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($type) {
            $result['contentType'] = $type;
        }
        if ($body === false) {
            $result['error'] = curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    $ctx = stream_context_create([
        'http' => [
            'timeout' => 20,
            'ignore_errors' => true,
            'header' => "User-Agent: Deep3DChessDB/0.1\r\n",
        ],
    ]);

    $body = @file_get_contents($url, false, $ctx);
    $headers = isset($http_response_header) ? $http_response_header : [];

    $result['body'] = $body;
    $result['status'] = statusFromHeaders($headers);

    foreach ($headers as $header) {
        if (stripos($header, 'Content-Type:') === 0) {
            $result['contentType'] = trim(substr($header, strlen('Content-Type:')));
        }
    }

    if ($body === false) {
        $last = error_get_last();
        $result['error'] = isset($last['message']) ? $last['message'] : 'Unable to reach ChessDB.';
    }

    return $result;
}

$attempts = [];
$response = null;

foreach ($urls as $url) {
    $current = requestChessDB($url);
    $attempts[] = [
        'url' => preg_replace('/board=[^&]*/', 'board=[FEN]', $url),
        'status' => $current['status'],
        'error' => $current['error'],
    ];

    // Accept any real upstream response below 500. A 4xx response is useful
    // information from ChessDB and should be passed through to the browser.
    if ($current['body'] !== false && $current['status'] > 0 && $current['status'] < 500) {
        $response = $current;
        break;
    }
}

if ($response === null) {
    http_response_code(502);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'error',
        'message' => 'ChessDB upstream request failed.',
        'attempts' => $attempts,
    ]);
    exit;
}

$status = $response['status'];
$body = $response['body'];

http_response_code($status >= 200 && $status < 600 ? $status : 502);

if ($action === 'queue') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => trim($body) === 'ok' ? 'ok' : 'upstream',
        'raw' => trim($body),
    ]);
} else {
    header('Content-Type: ' . $response['contentType']);
    echo $body;
}
