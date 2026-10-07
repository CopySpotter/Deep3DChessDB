# Regressionstest v0.2.0 – 2D/3D-Umschaltung

Diese Checkliste sichert den neuen v0.2-Arbeitsstand ab. Der bestehende v0.1.2-Regressionstest bleibt unverändert als historische Referenz erhalten.

## Bisheriges Testergebnis

- 2026-10-07: Das klassische 2D-Design wurde abgenommen und bleibt unverändert.

- 2026-10-07: Start unter Linux und Windows bestätigt. Der lokale PHP-Server
  und `chessdb-demo.html` lassen sich auf beiden Systemen starten.
- Der übrige Browser-Regressionscheck ist noch offen; insbesondere sind
  2D/3D-Umschaltung, Synchronisierung und Sonderzüge noch nicht abgenommen.

## 1. Start

- [ ] Repository auf `main` aktualisieren
- [x] lokalen PHP-Server starten (Linux und Windows, 2026-10-07)
- [ ] `chessdb-demo.html` ohne JavaScript-Fehler laden
- [ ] 3D-Ansicht ist beim Start aktiv
- [ ] Umschalter `3D` / `2D` ist sichtbar
- [ ] 2D-Brett zeigt dieselbe Startstellung wie das 3D-Brett

## 2. Reiner Ansichtswechsel

Aus der Startstellung:

- [ ] von 3D auf 2D wechseln
- [ ] von 2D zurück auf 3D wechseln
- [ ] FEN bleibt unverändert
- [ ] Zugrecht bleibt unverändert
- [ ] Spielstatus bleibt unverändert
- [ ] vorhandene ChessDB-Kandidaten bleiben sichtbar
- [ ] keine neue ChessDB-Abfrage nur durch den Ansichtswechsel
- [ ] kein Seiten-Neuladen

## 3. Zug im 2D-Brett

Von der Startstellung:

1. `e2` anklicken
2. `e4` anklicken

Erwartung:

- [ ] `e4` wird ausgeführt
- [ ] FEN wird aktualisiert
- [ ] `Schwarz am Zug.` wird angezeigt
- [ ] ChessDB wird automatisch für die neue Stellung abgefragt
- [ ] nach Wechsel auf 3D steht der weiße Bauer auf e4

Danach im 2D-Brett:

- [ ] illegaler Zug wird nicht ausgeführt
- [ ] Auswahl einer eigenen anderen Figur ersetzt die bisherige Auswahl
- [ ] erneuter Klick auf das ausgewählte Feld hebt die Auswahl auf

## 4. Zug im 3D-Brett und Synchronisation nach 2D

Nach `e2-e4` im 3D-Brett z. B. `e7-e5` spielen.

- [ ] FEN wird aktualisiert
- [ ] ChessDB wird automatisch neu abgefragt
- [ ] nach Wechsel auf 2D steht der schwarze Bauer auf e5
- [ ] Zugrecht und Status stimmen in beiden Ansichten überein

## 5. ChessDB-Kandidatenzug

Eine bekannte Stellung analysieren und einen Kandidatenzug anklicken.

- [ ] Kandidatenzug wird legal über `chess.js` ausgeführt
- [ ] FEN wird aktualisiert
- [ ] 3D-Brett wird aktualisiert
- [ ] 2D-Brett wird aktualisiert
- [ ] alte Kandidatenliste verschwindet
- [ ] neue Stellung wird automatisch analysiert
- [ ] Ansichtswechsel während der sichtbaren Analyse verändert die Stellung nicht

## 6. FEN laden

Eine andere gültige FEN in das Eingabefeld eintragen und `Am Brett anzeigen` wählen.

- [ ] 3D-Brett zeigt die geladene Stellung
- [ ] 2D-Brett zeigt dieselbe Stellung
- [ ] Zugrecht stimmt
- [ ] Schach/Matt/Patt/Remisstatus stimmt

## 7. Brett drehen

- [ ] `Brett drehen` dreht die 3D-Orientierung
- [ ] 2D-Orientierung wird gleichzeitig umgedreht
- [ ] Stellung selbst bleibt unverändert
- [ ] FEN bleibt unverändert
- [ ] erneutes Drehen stellt die ursprüngliche Orientierung wieder her

## 8. Sonderzüge

In geeigneten Teststellungen prüfen:

- [ ] Rochade im 2D-Brett aktualisiert beide Bretter korrekt
- [ ] en passant im 2D-Brett aktualisiert beide Bretter korrekt
- [ ] Bauernumwandlung im 2D-Brett wird derzeit automatisch zur Dame
- [ ] dieselben Sonderzüge funktionieren weiterhin im 3D-Brett

## 9. Spielende

Schachmatt-FEN:

```text
7k/6Q1/6K1/8/8/8/8/8 b - - 0 1
```

Patt-FEN:

```text
7k/5Q2/6K1/8/8/8/8/8 b - - 0 1
```

- [ ] Schachmatt wird in beiden Ansichten korrekt als Status angezeigt
- [ ] Patt wird in beiden Ansichten korrekt als Status angezeigt
- [ ] nach Spielende kann auch im 2D-Brett kein weiterer Zug ausgeführt werden

## 10. Freigabe für den nächsten v0.2-Schritt

Erst wenn die Punkte 1–9 im Browser ohne Regression funktionieren:

- [ ] Roadmap-Punkt „Ansichtswechsel testen“ auf erledigt setzen
- [ ] README auf getesteten 2D/3D-Stand aktualisieren
- [ ] danach mit v0.2.1 Kandidatenanzeige und Analyse-UI weitermachen
