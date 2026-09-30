# Deep3DChessDB

Interaktives 3D-Schachbrett mit **ChessDB-Anbindung** für Stellungsanalyse, Kandidatenzüge und Hauptvarianten.

Deep3DChessDB kombiniert **chessboard3.js** als 3D-Renderer, **chess.js** als Regelkern und die öffentliche **ChessDB Cloud Database** als Analysequelle. Figuren können legal gezogen werden; nach jedem Zug wird die vollständige FEN aktualisiert und ChessDB automatisch neu abgefragt.

![Deep3DChessDB – 3D-Brett mit ChessDB-Analyse](docs/Deep3DChessDB-screenshot.png)

*Deep3DChessDB mit 3D-Brett, FEN-Eingabe und ChessDB-Kandidatenzügen.*

## Aktueller Repository-Stand v0.1.2

Die Entwicklung auf `main` entspricht dem getesteten Stand **v0.1.2**. Ein
eigenständiger GitHub-Release für diese Version ist noch nicht veröffentlicht;
der derzeit verfügbare Release bleibt **v0.1.0**. Diese Unterscheidung ist
bewusst: Der Code- und Dokumentationsstand auf `main` kann weitergeführt
werden, ohne einen Release nachträglich zu behaupten.

- interaktives 3D-Schachbrett auf Basis von chessboard3.js
- legale Drag-and-drop-Züge mit chess.js
- Zugrecht, Rochade, en passant und automatische Damenumwandlung bei manuellen Bauernzügen
- automatische Aktualisierung der vollständigen FEN nach jedem legalen Zug
- automatische ChessDB-Abfrage nach jedem Zug
- ChessDB `queryall`: Kandidatenzüge, Score, Rank, Winrate und Note
- ChessDB `querypv`: Principal Variation / Hauptvariante
- ChessDB `querybest`, `queryscore` und `querysearch`
- `Deepen` / `queue`: Stellung zur weiteren ChessDB-Analyse einreihen
- automatische Behandlung unbekannter Stellungen mit `queue` und 5-Sekunden-Polling
- robuste Behandlung unbekannter Scores ohne `NaN`
- Same-Origin-PHP-Proxy mit HTTPS- und HTTP-Fallback für ChessDB
- 3D-Ansicht mit Maus drehen und kippen
- Mausrad-Zoom
- kleinere Koordinaten als echte 3D-Objecte direkt am Brett
- Buchstaben und Zahlen jeweils nur an einer Brettkante
- Button **Brett drehen** zum Wechsel der Orientierung
- ChessDB-Kandidatenzüge direkt anklickbar
- Kandidatenzüge werden vor Ausführung über `chess.js` legal validiert
- FEN, 3D-Brett und ChessDB-Analyse werden nach Kandidatenzügen automatisch aktualisiert
- sichtbarer Status für Weiß/Schwarz am Zug, Schach, Schachmatt, Patt und Remiszustände

Der v0.1.2-Stand wurde unter Linux im Browser manuell getestet.

## Schnellstart unter Windows

Am einfachsten geht es mit **`start.cmd`** im Projektordner: Doppelklick darauf genügt. Das Skript startet den lokalen PHP-Server auf Port `8011` und öffnet Deep3DChessDB automatisch im Standardbrowser.

Alternativ kann Deep3DChessDB jederzeit direkt aus PowerShell gestartet werden:

```powershell
cd D:\Deep3DChessDB-repo\Deep3DChessDB
php -S 127.0.0.1:8011
```

Dann im Browser öffnen:

```text
http://127.0.0.1:8011/chessdb-demo.html
```

Der Server läuft so lange, wie sein Konsolenfenster geöffnet bleibt. Beenden mit `Strg+C`.

Falls PHP noch nicht installiert ist:

```powershell
winget install --id PHP.PHP.8.4 -e
```

## Schnellstart unter Linux

Falls PHP-CLI noch fehlt:

```bash
sudo apt update
sudo apt install php-cli
```

Dann im Projektordner:

```bash
php -S 127.0.0.1:8011
```

und im Browser:

```text
http://127.0.0.1:8011/chessdb-demo.html
```

## Bedienung

Eine vollständige FEN kann in das Eingabefeld geschrieben und mit **Am Brett anzeigen** geladen werden. Danach können die Figuren direkt auf dem 3D-Brett gezogen werden. Illegale Züge springen zurück; legale Züge aktualisieren FEN und ChessDB automatisch.

Die freie Brettfläche kann mit gedrückter Maustaste gedreht und gekippt werden. Mit dem Mausrad wird gezoomt. **Brett drehen** wechselt die Orientierung zwischen Weiß und Schwarz.

ChessDB-Kandidatenzüge werden als Buttons angezeigt. Ein Klick führt den jeweiligen Zug über `chess.js` aus und startet danach automatisch die Analyse der Folgestellung.

Zusätzlich stehen **ChessDB analysieren**, **PV** und **Deepen** zur Verfügung.

## Test-FEN

Startstellung:

```text
rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1
```

Schachmatt-Test:

```text
7k/6Q1/6K1/8/8/8/8/8 b - - 0 1
```

Patt-Test:

```text
7k/5Q2/6K1/8/8/8/8/8 b - - 0 1
```

## Architektur

```text
Benutzerzug / FEN / ChessDB-Kandidat
              ↓
           chess.js
              ↓
        vollständige FEN
          ↙        ↘
chessboard3.js    ChessDB
```

`chessboard3.js` rendert das 3D-Brett. `chess.js` verwaltet die Schachregeln und ist die Quelle der Wahrheit für Legalität und vollständige FEN. Die ChessDB-Schicht fragt die externe Analyse-Datenbank über den lokalen PHP-Proxy ab.

Mehr dazu in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md).

## Projektstruktur

```text
.
├── start.cmd                    Windows-One-Click-Start
├── chessdb-demo.html            Demo und spielbares Analysebrett
├── chessdb-proxy.php            Same-Origin-Proxy zu ChessDB
├── js/
│   ├── chessboard3.js           3D-Renderer
│   ├── chessboard3.min.js
│   └── chessboard3.chessdb.js   ChessDB-Integrationsschicht
├── assets/                      3D-Figuren und Fonts
├── docs/
│   ├── ARCHITECTURE.md
│   └── REGRESSION-v0.1.2.md
├── ROADMAP.md
├── CHANGELOG.md
└── LICENSE
```

## Nächste Schritte

Die umschaltbare **2D-Ansicht** ist auf `main` inzwischen implementiert. 2D-
und 3D-Brett verwenden dieselbe `chess.js`-Stellung, dieselbe vollständige
FEN und dieselbe ChessDB-Analyse. Züge im 2D-Brett, 3D-Brett und aus der
ChessDB-Kandidatenliste werden in beiden Ansichten synchronisiert.

Der Browser-Regressionscheck für die neue 2D/3D-Umschaltung ist noch offen.
Die Prüfliste liegt in `docs/REGRESSION-v0.2.0.md`. Erst nach diesem Test
gilt der Schritt 0.2.0 als vollständig abgeschlossen.

Danach folgen in v0.2.1 die bessere Kandidatenanzeige, die klare Kennzeichnung
der besten Empfehlung, die Hervorhebung von Start- und Zielfeld sowie eine
einheitliche Status- und Analyseanzeige. Erst danach sind PGN-Unterstützung,
Zugliste, Navigation und Variantenbaum vorgesehen.

Siehe [`ROADMAP.md`](ROADMAP.md).

## Herkunft und Lizenz

- **chessboard3.js**: Copyright 2016 Jason Tiscione; Teile Copyright 2013 Chris Oakman. MIT-Lizenz, siehe [`LICENSE`](LICENSE).
- **chess.js**: wird im Demo-Frontend als Regel-Engine eingebunden.
- **ChessDB**: externe Cloud-API von chessdb.cn. Dieses Projekt enthält keine ChessDB-Datenbankkopie und keinen ChessDB-Server. Der veröffentlichte ChessDB-Code steht unter der Unlicense/Public-Domain-Widmung.
- Die zusätzliche Integrationsschicht in diesem Repository wird unter den permissiven Bedingungen des beigefügten MIT-Lizenztexts veröffentlicht.

## Status

**`main`: v0.2-Arbeitsstand – 2D/3D-Umschaltung implementiert, Browser-
Regression dafür noch offen. Der letzte vollständig manuell getestete Stand
ist v0.1.2; veröffentlicht ist derzeit Release v0.1.0.**
