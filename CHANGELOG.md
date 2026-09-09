# Changelog

## 0.1.1 - in Entwicklung

### Geändert

- 3D-Brett kann mit der Maus gedreht und gekippt werden
- Mausrad-Zoom für die 3D-Ansicht
- kleinere Koordinatenbeschriftung neben dem Brett
- Buchstaben nur an einer Brettkante, Zahlen nur an einer Brettkante
- Button „Brett drehen“ mit automatisch angepasster Koordinatenrichtung

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
