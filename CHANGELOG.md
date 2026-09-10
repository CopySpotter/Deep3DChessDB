# Changelog

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
