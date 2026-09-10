# Regressionstest v0.1.2

Diese Checkliste sichert den Stand vor dem Tag `v0.1.2` ab. Testziel ist nicht nur die neue Kandidatenzug-Funktion, sondern auch, dass v0.1.1 nicht beschädigt wurde.

## 1. Start und Grunddarstellung

- [ ] Repository auf `main` aktualisieren
- [ ] lokalen PHP-Server starten
- [ ] `chessdb-demo.html` ohne JavaScript-Fehler laden
- [ ] 3D-Brett und Figuren vollständig sichtbar
- [ ] kleine Koordinaten direkt am 3D-Brett sichtbar
- [ ] Buchstaben nur an einer Brettkante, Zahlen nur an einer Brettkante

## 2. 3D-Bedienung

- [ ] freie Brettfläche mit gedrückter Maustaste drehen/kippen
- [ ] Mausrad zoomt
- [ ] Figuren bleiben trotz OrbitControls normal ziehbar
- [ ] `Brett drehen` wechselt die Orientierung
- [ ] Koordinaten bleiben nach Rotation/Flip sinnvoll sichtbar

## 3. Manuelle Schachzüge

Von der Startstellung aus mindestens `e2-e4`, `e7-e5`, `g1-f3` spielen.

- [ ] nur die jeweils zugberechtigte Farbe kann gezogen werden
- [ ] illegaler Zug springt zurück
- [ ] legaler Zug bleibt am Zielfeld
- [ ] FEN ändert sich nach jedem legalen Zug
- [ ] ChessDB wird danach automatisch neu abgefragt

Zusätzlich prüfen:

- [ ] Rochade synchronisiert beide Figuren
- [ ] en passant wird korrekt dargestellt
- [ ] Bauernumwandlung funktioniert weiterhin als automatische Damenumwandlung

## 4. ChessDB-Kandidatenzüge

Startstellung oder eine bekannte analysierte Stellung verwenden.

- [ ] Kandidatenzüge erscheinen als anklickbare Buttons
- [ ] Klick auf einen Kandidatenzug führt genau diesen Zug aus
- [ ] Zug wird über `chess.js` legal validiert
- [ ] FEN entspricht danach der Folgestellung
- [ ] 3D-Brett entspricht der FEN
- [ ] Kandidatenliste der alten Stellung verschwindet
- [ ] ChessDB analysiert die neue Stellung automatisch
- [ ] mehrfaches Fortsetzen durch Kandidatenklicks funktioniert

## 5. Spielstatus

### Schachmatt

FEN:

```text
7k/6Q1/6K1/8/8/8/8/8 b - - 0 1
```

Erwartung:

```text
Schachmatt – Weiß gewinnt.
```

- [ ] Schachmatt wird korrekt angezeigt

### Patt

FEN:

```text
7k/5Q2/6K1/8/8/8/8/8 b - - 0 1
```

Erwartung:

```text
Patt – Remis.
```

- [ ] Patt wird korrekt angezeigt

### Zugrecht

Startstellung:

- [ ] `Weiß am Zug.` wird angezeigt
- [ ] nach `e2-e4` wird `Schwarz am Zug.` angezeigt

## 6. ChessDB-Funktionen

- [ ] `ChessDB analysieren` liefert Kandidaten
- [ ] `PV` liefert eine Hauptvariante oder eine verständliche Antwort
- [ ] `Deepen` reiht eine Stellung ein
- [ ] unbekannte Stellung wird eingereiht und automatisch erneut abgefragt
- [ ] keine sichtbaren `NaN`-Scores
- [ ] Proxyfehler werden verständlich angezeigt

## Freigabe

`v0.1.2` erst taggen, wenn alle für den Browser relevanten Punkte manuell geprüft sind und keine Regression gegenüber v0.1.1 aufgefallen ist.
