# Architektur

## Ziel

Das Projekt verbindet einen 3D-Schachbrett-Renderer mit ChessDB, ohne die ursprüngliche chessboard3.js-Bibliothek tiefgreifend umzubauen.

## Komponenten

### `js/chessboard3.js`

Originaler 3D-Brettrenderer. Er kennt Figurenpositionen, aber keine vollständigen Schachregeln und keine komplette FEN-Zustandslogik.

### `js/chessboard3.chessdb.js`

Integrationsschicht für ChessDB. Sie:

- baut API-Anfragen auf,
- normalisiert ChessDB-Antworten,
- stellt `analyze`, `best`, `score`, `pv`, `deepen` und `compute` bereit,
- kann unbekannte Stellungen automatisch einreihen und erneut abfragen.

### `chessdb-proxy.php`

Same-Origin-Proxy zwischen Browser und `https://www.chessdb.cn/cdb.php`.

Gründe:

- Browser-CORS,
- ein klarer kontrollierter Satz erlaubter ChessDB-Actions,
- zentrale Stelle für Timeouts und spätere Caches/Rate-Limits.

### `chessdb-demo.html`

Aktuelle Benutzeroberfläche und Referenzimplementierung für die Integrationsschicht.

## Ablauf einer bekannten Stellung

```text
FEN -> queryall -> ChessDB -> Zugliste -> Tabelle im Browser
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

## Wichtige Grenze des aktuellen Prototyps

Das Brett selbst ist noch keine Schach-Engine. Die eingegebene vollständige FEN ist derzeit die Quelle der Wahrheit. Erst mit einer Regelbibliothek wie `chess.js` kann aus interaktiven Zügen zuverlässig die nächste vollständige FEN erzeugt werden.

## Geplante Zielarchitektur

```text
PGN / Benutzereingabe
        ↓
   Regel-Engine
        ↓
 vollständige FEN
   ↙          ↘
3D-Brett     ChessDB
                ↓
        Analyse / PV / Zugwahl
```
