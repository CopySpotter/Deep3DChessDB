# Architektur

## Ziel

Deep3DChessDB verbindet einen 3D-Schachbrett-Renderer mit einem vollständigen Regelzustand und ChessDB, ohne die ursprüngliche chessboard3.js-Bibliothek tiefgreifend umzubauen.

## Komponenten

### `js/chessboard3.js`

3D-Brettrenderer. Er verwaltet Figurenpositionen und Drag-and-drop auf dem Brett, kennt aber selbst keine vollständigen Schachregeln.

### `chess.js`

Regelkern im Demo-Frontend. Er ist die Quelle der Wahrheit für:

- Zugrecht,
- legale und illegale Züge,
- Rochade,
- en passant,
- Bauernumwandlung,
- vollständige FEN nach jedem Zug.

### `js/chessboard3.chessdb.js`

Integrationsschicht für ChessDB. Sie:

- baut API-Anfragen auf,
- normalisiert ChessDB-Antworten,
- behandelt unbekannte Scores robust,
- stellt `analyze`, `best`, `score`, `pv`, `deepen` und `compute` bereit,
- kann unbekannte Stellungen automatisch einreihen und erneut abfragen,
- gibt Proxy-Fehler verständlicher an das Frontend weiter.

### `chessdb-proxy.php`

Same-Origin-Proxy zwischen Browser und ChessDB.

Gründe:

- Browser-CORS,
- kontrollierter Satz erlaubter ChessDB-Actions,
- zentrale Stelle für Timeouts und spätere Caches/Rate-Limits,
- HTTPS-Aufruf mit HTTP-Fallback bei Verbindungsproblemen oder 5xx-Antworten.

### `chessdb-demo.html`

Benutzeroberfläche und Referenzimplementierung. Sie verbindet 3D-Brett, chess.js und ChessDB.

## Ablauf eines Benutzerzugs

```text
Benutzer zieht Figur
        ↓
     chess.js
        ↓
legal? ── nein ──> Snapback
  │
  ja
  ↓
vollständige FEN
  ↓
3D-Brett synchronisieren
  ↓
ChessDB queryall
  ↓
Kandidatenzüge / Bewertung / PV
```

## Ablauf einer unbekannten Stellung

```text
FEN
 ↓
queryall(learn=1, showall=1)
 ↓
unknown
 ↓
queue
 ↓
5 Sekunden
 ↓
queryall
 ↓
Wiederholung bis Ergebnis oder Versuchslimit
```

Dieses Verhalten orientiert sich an der offiziellen ChessDB-Abfrageoberfläche.

## Zustandsmodell

`chess.js` ist für den Schachzustand maßgeblich. Das 3D-Brett wird nach legalen Zügen aus diesem Zustand synchronisiert. Damit bleiben auch Sonderzüge und FEN-Zusatzinformationen korrekt.

ChessDB erhält ausschließlich vollständige FENs aus dem Regelzustand und verändert selbst keinen Spielzustand.

## Zielarchitektur

```text
PGN / Benutzereingabe
        ↓
      chess.js
        ↓
 vollständige FEN
   ↙          ↘
3D-Brett     ChessDB
                ↓
        Analyse / PV / Zugwahl
                ↓
       Varianten / Partieanalyse
```
