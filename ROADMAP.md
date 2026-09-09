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

## 0.1.1 – Kamera und Brettdarstellung (aktuell)

- [x] 3D-Brett mit der Maus drehen und kippen
- [x] Mausrad-Zoom
- [x] kleinere Koordinaten außerhalb des Bretts
- [x] Buchstaben und Zahlen jeweils nur an einer Brettkante
- [x] Brett-Flip mit angepassten Koordinaten

## 0.2 – Spielbares Analysebrett

- [x] Regel-Engine (`chess.js`) integrieren
- [x] legale Drag-and-drop-Züge
- [x] vollständige FEN nach jedem Zug
- [x] ChessDB nach jedem Zug automatisch aktualisieren
- [ ] ChessDB-Kandidatenzüge anklickbar machen
- [ ] Status für Schach, Matt, Patt und illegale Züge

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
