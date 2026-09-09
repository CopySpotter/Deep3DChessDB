# Roadmap

## 0.1.0 – erster funktionsfähiger Prototyp

- [x] 3D-Brett
- [x] vollständige FEN eingeben und laden
- [x] `queryall`
- [x] `querypv`
- [x] `querybest`
- [x] `queryscore`
- [x] `queue` / Deepen
- [x] automatische Wiederholungsabfrage bei unbekannten Stellungen
- [x] PHP-CORS-Proxy
- [x] robuste Behandlung von `??`-Scores
- [x] HTTPS-/HTTP-Fallback im ChessDB-Proxy
- [x] Regel-Engine (`chess.js`)
- [x] legale Drag-and-drop-Züge
- [x] vollständige FEN nach jedem Zug
- [x] ChessDB nach jedem legalen Zug automatisch aktualisieren
- [x] Rochade, en passant und Umwandlung synchronisieren

## 0.2 – Analysebrett ausbauen

- [ ] ChessDB-Kandidatenzüge anklickbar machen
- [ ] Kandidatenzug direkt auf dem 3D-Brett ausführen
- [ ] Brettorientierung / Flip verbessern
- [ ] 3D-Kamera komfortabler drehen und zoomen
- [ ] Status für Schach, Matt und Patt anzeigen
- [ ] laufende ChessDB-Abfragen bei Stellungswechsel sauber abbrechen
- [ ] Bedienung und Darstellung auf kleineren Displays verbessern

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
