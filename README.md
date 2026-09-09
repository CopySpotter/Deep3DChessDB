# Deep3DChessDB

Interaktives 3D-Schachbrett mit **ChessDB-Anbindung** für Stellungsanalyse, Kandidatenzüge und Hauptvarianten.

Deep3DChessDB kombiniert **chessboard3.js** als 3D-Renderer, **chess.js** als Regelkern und die öffentliche **ChessDB Cloud Database** als Analysequelle. Figuren können legal gezogen werden; nach jedem Zug wird die vollständige FEN aktualisiert und ChessDB automatisch neu abgefragt.

![Deep3DChessDB – 3D-Brett mit ChessDB-Analyse](docs/Deep3DChessDB-screenshot.png)

*Deep3DChessDB mit 3D-Brett, FEN-Eingabe und ChessDB-Kandidatenzügen.*

## Funktionsumfang v0.1.0

- interaktives 3D-Schachbrett auf Basis von chessboard3.js
- legale Drag-and-drop-Züge mit chess.js
- Zugrecht, Rochade, en passant und Bauernumwandlung
- automatische Aktualisierung der vollständigen FEN nach jedem legalen Zug
- automatische ChessDB-Abfrage nach jedem Zug
- ChessDB `queryall`: Kandidatenzüge, Score, Rank, Winrate und Note
- ChessDB `querypv`: Principal Variation / Hauptvariante
- ChessDB `querybest`, `queryscore` und `querysearch`
- `Deepen` / `queue`: Stellung zur weiteren ChessDB-Analyse einreihen
- automatische Behandlung unbekannter Stellungen:
  - `queryall&learn=1&showall=1`
  - bei `unknown`: `queue`
  - danach erneute Abfrage alle 5 Sekunden
- robuste Behandlung unbekannter Scores ohne `NaN`
- Same-Origin-PHP-Proxy mit HTTPS- und HTTP-Fallback für ChessDB
- verständlichere Proxy- und Verbindungsfehler in der Oberfläche

## Schnellstart unter Windows

Im Projektordner:

```powershell
php -S 127.0.0.1:8011
```

Dann im Browser öffnen:

```text
http://127.0.0.1:8011/chessdb-demo.html
```

Falls PHP noch nicht installiert ist, kann PHP unter Windows zum Beispiel über `winget` installiert werden:

```powershell
winget install --id PHP.PHP.8.4 -e
```

Danach die PowerShell neu öffnen.

## Schnellstart unter Linux

Falls PHP-CLI noch fehlt:

```bash
sudo apt update
sudo apt install php-cli
```

Dann:

```bash
php -S 127.0.0.1:8011
```

und im Browser:

```text
http://127.0.0.1:8011/chessdb-demo.html
```

## Bedienung

Eine vollständige FEN kann in das Eingabefeld geschrieben und mit **Am Brett anzeigen** geladen werden. Danach können die Figuren direkt auf dem 3D-Brett gezogen werden. Illegale Züge springen zurück; legale Züge aktualisieren FEN und ChessDB automatisch.

Zusätzlich stehen **ChessDB analysieren**, **PV** und **Deepen** zur Verfügung.

## Test-FEN

Startstellung:

```text
rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1
```

Taktische Teststellung:

```text
3q1rk1/1bp3pp/p1n3p1/8/Bp1P4/6N1/PPP1QnP1/R3R1K1 b - - 0 1
```

## Architektur

```text
Benutzerzug / FEN
       ↓
    chess.js
       ↓
chessboard3.js
       ↓
chessdb-demo.html
       ↓
js/chessboard3.chessdb.js
       ↓
chessdb-proxy.php
       ↓
     ChessDB
```

`chessboard3.js` rendert das 3D-Brett. `chess.js` verwaltet die Schachregeln und erzeugt die korrekte vollständige FEN. Die ChessDB-Schicht fragt die externe Analyse-Datenbank über den lokalen PHP-Proxy ab.

Mehr dazu in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md).

## Projektstruktur

```text
.
├── chessdb-demo.html            Demo und spielbares Analysebrett
├── chessdb-proxy.php            Same-Origin-Proxy zu ChessDB
├── js/
│   ├── chessboard3.js           3D-Renderer
│   ├── chessboard3.min.js
│   └── chessboard3.chessdb.js   ChessDB-Integrationsschicht
├── assets/                      3D-Figuren und Fonts
├── docs/
│   └── ARCHITECTURE.md
├── ROADMAP.md
├── CHANGELOG.md
└── LICENSE
```

## Nächste Schritte

Als Nächstes sollen ChessDB-Kandidatenzüge direkt anklickbar werden, die Brettorientierung verbessert und Schach/Matt/Patt deutlicher angezeigt werden. Danach folgen PGN-Unterstützung, Zugliste und Variantenbaum.

Siehe [`ROADMAP.md`](ROADMAP.md).

## Herkunft und Lizenz

- **chessboard3.js**: Copyright 2016 Jason Tiscione; Teile Copyright 2013 Chris Oakman. MIT-Lizenz, siehe [`LICENSE`](LICENSE).
- **chess.js**: wird im Demo-Frontend als Regel-Engine eingebunden.
- **ChessDB**: externe Cloud-API von chessdb.cn. Dieses Projekt enthält keine ChessDB-Datenbankkopie und keinen ChessDB-Server. Der veröffentlichte ChessDB-Code steht unter der Unlicense/Public-Domain-Widmung.
- Die zusätzliche Integrationsschicht in diesem Repository wird unter den permissiven Bedingungen des beigefügten MIT-Lizenztexts veröffentlicht.

## Status

**Version 0.1.0 – erster funktionsfähiger öffentlicher Prototyp.**
