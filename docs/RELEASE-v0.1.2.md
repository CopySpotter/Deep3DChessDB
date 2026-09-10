# Release-Vorbereitung v0.1.2

## Ziel

v0.1.2 macht aus dem bisherigen Analysebrett ein stärker interaktives ChessDB-Frontend: Kandidatenzüge können direkt ausgeführt werden und der aktuelle Spielzustand wird sichtbar angezeigt.

## Enthalten

- anklickbare ChessDB-Kandidatenzüge
- Ausführung jedes Kandidatenzugs ausschließlich über `chess.js`
- automatische Synchronisierung von 3D-Brett und vollständiger FEN
- automatische ChessDB-Neuanalyse der Folgestellung
- sichtbarer Status für Zugrecht, Schach, Schachmatt, Patt und Remiszustände
- bestehende v0.1.1-Funktionen bleiben erhalten: 3D-Rotation, Zoom, Brett-Flip und kompakte 3D-Koordinaten
- Windows-One-Click-Start über `start.cmd`

## Release-Gate

Der Code- und Dokumentationsstand ist für v0.1.2 vorbereitet. Vor dem Tag muss nur noch der manuelle Browser-Regressionstest aus `docs/REGRESSION-v0.1.2.md` vollständig durchlaufen werden. Insbesondere sind Kandidatenklicks, manuelle Züge, Orbit/Zoom/Flip, Schachmatt/Patt sowie ChessDB-Analyse/PV/Deepen zu prüfen.

## Vorgesehener Release-Titel

**Deep3DChessDB v0.1.2 – Playable ChessDB analysis board**

## Kurzbeschreibung

v0.1.2 ergänzt anklickbare ChessDB-Kandidatenzüge und einen sichtbaren Spielstatus. Gewählte Kandidaten laufen durch `chess.js`, sodass Legalität und vollständige FEN weiterhin aus einer einzigen verlässlichen Zustandsquelle stammen. Nach jedem Zug werden Brett und ChessDB automatisch aktualisiert.

## Tagging nach erfolgreichem Test

```bash
git pull
git tag -a v0.1.2 -m "Deep3DChessDB v0.1.2"
git push origin v0.1.2
```
