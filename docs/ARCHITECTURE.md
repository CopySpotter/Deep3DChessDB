# Architektur

## Ziel

Deep3DChessDB verbindet einen 3D-Schachbrett-Renderer mit einem vollständigen Regelzustand und ChessDB, ohne die ursprüngliche chessboard3.js-Bibliothek tiefgreifend umzubauen.

## Komponenten

### `js/chessboard3.js`

3D-Brettrenderer. Er verwaltet Figurenpositionen und Drag-and-drop auf dem Brett, kennt aber selbst keine vollständigen Schachregeln.

### `chess.js`

Regelkern im Demo-Frontend. Er ist die Quelle der Wahrheit für:

- Zugrecht,
- legale und illegale Züge,
- Rochade,
- en passant,
- Bauernumwandlung,
- Schach, Schachmatt und Patt,
- vollständige FEN nach jedem Zug.

Auch ChessDB-Zugvorschläge werden niemals direkt in den Brettzustand geschrieben. Sie müssen zuerst durch `chess.js` laufen.

### `js/chessboard3.chessdb.js`

Integrationsschicht für ChessDB. Sie:

- baut API-Anfragen auf,
- normalisiert ChessDB-Antworten,
- behandelt unbekannte Scores robust,
- stellt `analyze`, `best`, `score`, `pv`, `deepen` und `compute` bereit,
- kann unbekannte Stellungen automatisch einreihen und erneut abfragen,
- gibt Proxy-Fehler verständlicher an das Frontend weiter.

### `chessdb-proxy.php`

Same-Origin-Proxy zwischen Browser und ChessDB.

Gründe:

- Browser-CORS,
- kontrollierter Satz erlaubter ChessDB-Actions,
- zentrale Stelle für Timeouts und spätere Caches/Rate-Limits,
- HTTPS-Aufruf mit HTTP-Fallback bei Verbindungsproblemen oder 5xx-Antworten.

### `chessdb-demo.html`

Benutzeroberfläche und Referenzimplementierung. Sie verbindet 3D-Brett, chess.js und ChessDB. Auf dem aktuellen `main` rendert sie ChessDB-Kandidaten als Buttons, führt einen gewählten Kandidaten über `chess.js` aus und aktualisiert anschließend Brett, FEN, Spielstatus und Analyse.

## Ablauf eines manuellen Benutzerzugs

```text
Benutzer zieht Figur
        ↓
     chess.js
        ↓
legal? ── nein ──> Snapback
  │
  ja
  ↓
vollständige FEN + Spielstatus
  ↓
3D-Brett synchronisieren
  ↓
ChessDB queryall
  ↓
Kandidatenzüge / Bewertung / PV
```

## Ablauf eines ChessDB-Kandidatenzugs

```text
ChessDB-Kandidat (UCI)
        ↓
    UCI zerlegen
        ↓
     chess.js
        ↓
legal? ── nein ──> verwerfen / neu analysieren
  │
  ja
  ↓
vollständige FEN + Spielstatus
  ↓
3D-Brett synchronisieren
  ↓
alte Kandidatenliste verwerfen
  ↓
ChessDB für Folgestellung neu abfragen
```

Damit bleibt ChessDB eine Analysequelle. Die externe Datenbank verändert den Spielzustand niemals direkt.

## Ablauf einer unbekannten Stellung

```text
FEN
 ↓
queryall(learn=1, showall=1)
 ↓
unknown
 ↓
queue
 ↓
5 Sekunden
 ↓
queryall
 ↓
Wiederholung bis Ergebnis oder Versuchslimit
```

Dieses Verhalten orientiert sich an der offiziellen ChessDB-Abfrageoberfläche.

## Asynchroner Zustand

Jede neue Analyse erhöht `analysisGeneration`. Antworten älterer Abfragen werden nur übernommen, wenn ihre Generation noch aktuell ist. Dadurch überschreibt eine verspätete ChessDB-Antwort nicht die bereits weitergespielte Stellung.

## Zustandsmodell

`chess.js` ist für den Schachzustand maßgeblich. Das 3D-Brett wird nach legalen manuellen Zügen und nach legalen ChessDB-Kandidatenzügen aus diesem Zustand synchronisiert. Damit bleiben Sonderzüge und FEN-Zusatzinformationen korrekt.

ChessDB erhält ausschließlich vollständige FENs aus dem Regelzustand und verändert selbst keinen Spielzustand.

## Zielarchitektur

```text
PGN / Benutzereingabe / ChessDB-Kandidat
                 ↓
               chess.js
                 ↓
          vollständige FEN
            ↙          ↘
       3D-Brett       ChessDB
                         ↓
                 Analyse / PV
                         ↓
                Varianten / Partieanalyse
```
