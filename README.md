# chessboard3js + ChessDB

3D-Schachbrett auf Basis von **chessboard3.js 0.1.3** mit Anbindung an die öffentliche **ChessDB Cloud Database**.

Der aktuelle Stand ist ein Analyse-Prototyp: Eine vollständige FEN wird auf dem 3D-Brett angezeigt und gegen ChessDB abgefragt. Bekannte Stellungen liefern Kandidatenzüge, Bewertungen und Hauptvarianten. Unbekannte Stellungen können automatisch zur Analyse eingereiht und anschließend erneut abgefragt werden.

![Deep3DChessDB – 3D-Brett mit ChessDB-Analyse](docs/Deep3DChessDB-screenshot.png)

*Deep3DChessDB mit 3D-Brett, FEN-Eingabe und ChessDB-Kandidatenzügen.*

## Aktueller Funktionsumfang

- 3D-Brett mit den originalen chessboard3.js-Modellen
- Eingabe einer vollständigen FEN
- ChessDB `queryall`: Kandidatenzüge, Score, Rank, Winrate, Note
- ChessDB `querypv`: Principal Variation / Hauptvariante
- ChessDB `querybest`, `queryscore`, `querysearch`
- `Deepen` / `queue`: Stellung zur weiteren ChessDB-Analyse einreihen
- automatische Behandlung unbekannter Stellungen nach dem Muster der offiziellen ChessDB-Weboberfläche:
  - `queryall&learn=1&showall=1`
  - bei `unknown`: `queue`
  - danach erneute Abfrage alle 5 Sekunden
- kleiner Same-Origin-PHP-Proxy, weil die ChessDB-API nicht für direkte Browser-CORS-Aufrufe ausgelegt ist

## Schnellstart unter Linux

PHP-CLI installieren, falls noch nicht vorhanden:

```bash
sudo apt update
sudo apt install php-cli
```

Dann im Projektordner:

```bash
php -S 127.0.0.1:8011
```

Im Browser öffnen:

```text
http://127.0.0.1:8011/chessdb-demo.html
```

Port `8011` ist bewusst gewählt, weil `8000` häufig schon von anderen lokalen Diensten belegt ist.

## Test-FEN

Startstellung:

```text
rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1
```

Beispiel einer taktischen Stellung:

```text
3q1rk1/1bp3pp/p1n3p1/8/Bp1P4/6N1/PPP1QnP1/R3R1K1 b - - 0 1
```

## Projektstruktur

```text
.
├── chessdb-demo.html            Demo-Oberfläche
├── chessdb-proxy.php            Same-Origin-Proxy zu chessdb.cn
├── js/
│   ├── chessboard3.js           Originalbibliothek
│   ├── chessboard3.min.js
│   └── chessboard3.chessdb.js   Unsere ChessDB-Integrationsschicht
├── assets/                      3D-Figuren und Fonts
├── docs/
│   └── ARCHITECTURE.md
├── ROADMAP.md
├── CHANGELOG.md
└── LICENSE
```

## Architektur

`chessboard3.js` bleibt ein reiner Brett-Renderer. Die ChessDB-Schicht erwartet deshalb eine **vollständige FEN** einschließlich Zugrecht, Rochaderechten, en-passant-Feld und Zugzählern.

```text
FEN
 ↓
chessdb-demo.html
 ↓
js/chessboard3.chessdb.js
 ↓
chessdb-proxy.php
 ↓
https://www.chessdb.cn/cdb.php
```

Mehr dazu in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md).

## Nächster Entwicklungsschritt

Der Prototyp soll zu einem wirklich spielbaren Analysebrett werden:

1. `chess.js` oder vergleichbare Regel-Engine integrieren.
2. Figuren auf dem 3D-Brett legal ziehen können.
3. Nach jedem Zug automatisch eine vollständige FEN erzeugen.
4. ChessDB automatisch nach jedem Zug aktualisieren.
5. Kandidatenzüge anklickbar machen und auf dem Brett ausführen.
6. PGN laden, navigieren und später komplette Partien analysieren.

Siehe [`ROADMAP.md`](ROADMAP.md).

## Herkunft und Lizenz

- **chessboard3.js**: Copyright 2016 Jason Tiscione; Teile Copyright 2013 Chris Oakman. MIT-Lizenz, siehe [`LICENSE`](LICENSE).
- **ChessDB**: externe Cloud-API von chessdb.cn. Dieses Projekt enthält keine ChessDB-Datenbankkopie und keinen ChessDB-Server. Der veröffentlichte ChessDB-Code steht unter der Unlicense/Public-Domain-Widmung.
- Die zusätzliche Integrationsschicht in diesem Repository wird unter denselben permissiven Bedingungen des beigefügten MIT-Lizenztexts veröffentlicht.

## Status

**Version 0.1.0 – experimenteller Prototyp.**
