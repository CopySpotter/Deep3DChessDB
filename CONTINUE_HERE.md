# CONTINUE HERE – Deep3DChessDB

Diese Datei ist der verbindliche Einstiegspunkt für die Fortsetzung des Projekts. Bei Widersprüchen mit älteren Chatnotizen oder Erinnerungen gilt der dokumentierte Repository-Stand; Widersprüche werden zuerst geklärt und nicht stillschweigend überschrieben.

## Aktueller Stand

- Arbeitsstand auf `main`: **v0.2.0-alpha.1**.
- Die umschaltbare 2D-/3D-Ansicht ist implementiert.
- 2D- und 3D-Brett teilen Stellung, FEN und ChessDB-Analyse.
- ChessDB-Kandidatenzüge sind anklickbar und werden über `chess.js` validiert.
- Letzter vollständig manuell getesteter Stand: **v0.1.2**.
- Veröffentlichtes Release: **v0.1.0**.

## Nächster verbindlicher Schritt

**Browser-Regressionscheck für v0.2.0 abschließen.**

Prüfen:
1. 2D/3D-Umschaltung ohne Zustandsverlust,
2. Synchronisierung von Zügen, FEN und ChessDB,
3. Brett-Flip,
4. Sonderzüge und Legalität,
5. Bauhaus-SVG-Figuren und 2D-Layout,
6. keine Regression des stabilen 3D-Spiel-/Analysecodes.

Prüfliste: `docs/REGRESSION-v0.2.0.md`.

Erst wenn dieser Stand stabil ist, gilt 0.2.0 als abgeschlossen. Danach folgt v0.2.1 mit Analyse-UI/Kandidatenanzeige.

## Vor dem Weiterarbeiten lesen

1. `CONTINUE_HERE.md`
2. `README.md`
3. `docs/REGRESSION-v0.2.0.md`
4. `ROADMAP.md`
5. `CHANGELOG.md`
6. `docs/ARCHITECTURE.md`

## Abschlusskriterium des nächsten Schritts

Der Regressionscheck ist dokumentiert, alle kritischen Funktionen laufen in den geprüften Browsern stabil, bekannte Abweichungen sind festgehalten und es wurde keine neue Funktion begonnen, bevor v0.2.0 als stabil bestätigt ist.

## Grundregel

ChatGPT oder eine andere KI darf das Projekt beschleunigen, ist aber nicht Teil der Architektur. Projektstand, nächste Aufgabe und Abnahmekriterien müssen im Repository nachvollziehbar bleiben.
