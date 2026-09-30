# Changelog

## 0.2.0-alpha.1 - 2026-09-30

Erste Vorabversion der umschaltbaren 2D/3D-Brettansicht auf gemeinsamer `chess.js`-Stellung. Der Code ist implementiert und syntaktisch geprüft; der vollständige manuelle Browser-Regressionscheck steht noch aus.

### Hinzugefügt

- zusätzliche 2D-Brettansicht
- geometrische Bauhaus-SVG-Figuren für die 2D-Ansicht
- 2D-Brettgröße und Figurenproportionen optisch angepasst
- eigenständige 2D-Farb- und Glanzdarstellung
- Umschalter zwischen 3D und 2D ohne Seiten-Neuladen
- 2D-Züge per Klick auf Start- und Zielfeld
- Synchronisierung von 2D-Zügen auf FEN, 3D-Brett und ChessDB-Analyse
- Synchronisierung von 3D-Zügen und ChessDB-Kandidatenzügen zurück auf das 2D-Brett
- gemeinsame Brettorientierung beim Button `Brett drehen`
- neue Regressionstest-Checkliste unter `docs/REGRESSION-v0.2.0.md`

### Technisch

- `chess.js` bleibt einzige Quelle der Wahrheit für Stellung, Zugrecht und Legalität
- 2D und 3D teilen dieselbe vollständige FEN und denselben Spielstatus
- reiner Ansichtswechsel verändert weder FEN noch Analysezustand
- JavaScript-Syntaxcheck des geänderten Inline-Codes erfolgreich

### Noch offen

- manueller Browser-Test unter Linux
- Ansichtswechsel während laufender bzw. bereits sichtbarer ChessDB-Analyse prüfen
- Sonderzüge und Brett-Flip in beiden Ansichten regressionsprüfen
- erst danach Roadmap-Punkt 0.2.0 vollständig abschließen

## 0.1.2 - 2026-09-10

Spielbares Analysebrett mit direkt ausführbaren ChessDB-Kandidatenzügen und sichtbarem Spielstatus. Der Stand wurde unter Linux im Browser manuell getestet.

### Hinzugefügt

- `start.cmd` für Windows: startet den lokalen PHP-Server auf Port 8011 und öffnet Deep3DChessDB automatisch im Standardbrowser
- ChessDB-Kandidatenzüge sind direkt anklickbar
- angeklickte ChessDB-Züge werden über `chess.js` legal ausgeführt und auf das 3D-Brett übertragen
- nach einem ChessDB-Kandidatenzug werden FEN und ChessDB-Analyse automatisch aktualisiert
- sichtbarer Spielstatus für Zugrecht, Schach, Schachmatt, Patt und Remiszustände
- Regressionstest-Checkliste unter `docs/REGRESSION-v0.1.2.md`

### Technisch

- `chess.js` bleibt auch bei ChessDB-Zugvorschlägen die alleinige Quelle der Wahrheit für Legalität und vollständige FEN
- veraltete laufende Analyseantworten werden weiterhin über `analysisGeneration` ignoriert
- Bauernumwandlungen aus ChessDB werden ohne problematische Figurenanimation synchronisiert

### Getestet

- manueller Browser-Test unter Linux erfolgreich
- Kandidatenzug aus ChessDB ausführbar
- 3D-Brett, Drag-and-drop, Rotation, Zoom und Brett-Flip weiterhin funktionsfähig
- Spielstatus für Zugrecht und Endzustände funktionsfähig

## 0.1.1 - 2026-09-10

Kleines Darstellungs- und Bedienungsrelease auf Basis des stabilen v0.1.0-Layouts.

### Geändert

- 3D-Brett kann mit der Maus gedreht und gekippt werden
- Mausrad-Zoom für die 3D-Ansicht
- passende OrbitControls aus der Three.js-r80-Generation eingebunden
- Koordinaten bleiben echte 3D-Objekte am Brett und wurden kleiner gesetzt
- Buchstaben nur an einer Brettkante, Zahlen nur an einer Brettkante
- Button „Brett drehen“ zum Wechsel der Orientierung
- Brettlayout selbst bleibt gegenüber v0.1.0 unverändert

## 0.1.0 - 2026-09-10

Erster funktionsfähiger öffentlicher Prototyp von Deep3DChessDB.

### Hinzugefügt

- chessboard3.js als 3D-Basis
- chess.js als Regelkern für legale Züge
- legale Drag-and-drop-Züge auf dem 3D-Brett
- automatische vollständige FEN nach jedem legalen Zug
- automatische ChessDB-Abfrage nach jedem Zug
- ChessDB-Adapter `js/chessboard3.chessdb.js`
- PHP-Proxy zu `chessdb.cn`
- Kandidatenzüge und Bewertungen via `queryall`
- Hauptvariante via `querypv`
- `querybest`, `queryscore` und `querysearch`
- Deepen/Queue
- automatische Analyseanforderung und 5-Sekunden-Polling bei `unknown`
- Synchronisierung von Rochade, en passant und Bauernumwandlung mit dem 3D-Brett
- Windows- und Linux-Schnellstart in der Dokumentation

### Behoben

- unbekannte ChessDB-Scores (`??`) erzeugen kein `NaN` mehr
- ChessDB-Proxy verwendet bei HTTPS-Problemen bzw. 5xx einen HTTP-Fallback
- Proxy-Fehler werden im Frontend mit konkreterer Ursache angezeigt

### Status

v0.1.0 ist ein früher Prototyp, aber die Kernkette funktioniert vollständig:

`legaler Benutzerzug → FEN → ChessDB → Kandidatenzüge / Bewertung / PV`
