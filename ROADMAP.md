# Roadmap

## 0.1 – ChessDB-FEN-Prototyp

- [x] 3D-Brett
- [x] vollständige FEN eingeben
- [x] `queryall`
- [x] `querypv`
- [x] `querybest`
- [x] `queryscore`
- [x] `queue` / Deepen
- [x] automatische Wiederholungsabfrage bei unbekannten Stellungen
- [x] PHP-CORS-Proxy

## 0.1.1 – Kamera und Brettdarstellung

- [x] 3D-Brett mit der Maus drehen und kippen
- [x] Mausrad-Zoom
- [x] kleinere Koordinaten direkt am 3D-Brett
- [x] Buchstaben und Zahlen jeweils nur an einer Brettkante
- [x] Brett-Flip
- [x] ursprüngliches v0.1.0-Brettlayout beibehalten

## 0.1.2 – Spielbares Analysebrett

- [x] Regel-Engine (`chess.js`) integrieren
- [x] legale Drag-and-drop-Züge
- [x] vollständige FEN nach jedem Zug
- [x] ChessDB nach jedem Zug automatisch aktualisieren
- [x] ChessDB-Kandidatenzüge anklickbar machen
- [x] angeklickten ChessDB-Zug über `chess.js` legal ausführen
- [x] FEN und Analyse nach Kandidatenzug automatisch aktualisieren
- [x] Status für Zugrecht, Schach, Matt, Patt und Remiszustände
- [x] Regressionstest-Checkliste anlegen
- [x] Release-Dokumentation für v0.1.2 vorbereiten
- [x] manuellen Regressionstest auf Linux/Browser durchführen

## 0.2 – Nächster Entwicklungsschritt

- [ ] Kandidatenzüge optisch hervorheben
- [ ] beste ChessDB-Empfehlung klar kennzeichnen
- [ ] Spielstatus und Analyseanzeige weiter vereinheitlichen

## 0.3 – Varianten und Partie

- [ ] PGN laden
- [ ] Zugliste
- [ ] vor/zurück navigieren
- [ ] ChessDB-PV als Variante übernehmen
- [ ] Variantenbaum
- [ ] PGN exportieren

## 0.4 – Analyse

- [ ] kompletten Partieverlauf gegen ChessDB prüfen
- [ ] gespielten Zug mit bestem ChessDB-Zug vergleichen
- [ ] kritische Stellungen markieren
- [ ] Bewertungssprünge anzeigen
- [ ] lokaler Cache für ChessDB-Antworten

## Später

- [ ] Lichess Cloud Eval als zweite Quelle
- [ ] lokaler Stockfish-Fallback
- [ ] ChessDB vs. Stockfish vergleichen
- [ ] erklärender Analyse-Coach
