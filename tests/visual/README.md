# Visual-Regression-Prüfung

Sichert ab, dass Umbauten am Theme das Layout **nicht** verändern. Gedacht als Gate für den
Umbau auf eigene Blöcke (siehe `plan.md` im Repo-Root), aber für jede CSS- oder
Template-Änderung nützlich.

## Einrichtung

```bash
cd tests/visual
npm install          # lädt auch Chromium
```

Vorausgesetzt wird eine laufende Instanz unter `http://localhost:8080`
(`docker compose up -d` im Repo-Root). Andere Adresse:

```bash
npm run capture -- baseline http://localhost:9000
# oder
WALDORF_BASE_URL=http://localhost:9000 npm run check
```

## Benutzung

Vor der Änderung — Baseline aufnehmen:

```bash
npm run capture -- baseline
```

Nach der Änderung — prüfen:

```bash
npm run check
```

`check` nimmt `verify` auf und vergleicht es gegen `baseline`. Exit-Code 1 bei jeder
Abweichung, taugt also als Commit-Gate.

Einzelne Läufe vergleichen:

```bash
npm run capture -- vorher
npm run capture -- nachher
npm run compare -- vorher nachher
```

## Was geprüft wird

**12 Screenshots** — Startseite / Beitrag / 404 × 390, 768, 1280, 1440 px, jeweils
`fullPage`.

**Pixelvergleich** über pixelmatch, Toleranz 0.12 pro Pixel gegen Antialiasing, Schwelle
0,1 % veränderte Pixel. Unterschiede landen als markiertes Diff-Bild in
`diff-<baseline>-vs-<candidate>/`.

**Geometrie-Fingerabdruck** über 39 Sonden-Selektoren × Position, Größe, Farbe, Schrift,
Radius. Das ist der Teil, der die eigentliche Arbeit macht: Aus „1,2 % der Pixel
unterscheiden sich" wird

```
home-1280 .pb-gcard: h 751.5 -> 755.5 (+4)
```

Die Aufnahme wird dafür deterministisch gemacht — Animationen und Übergänge aus,
Scroll-Reveals erzwungen, Bilder auf `eager` plus dekodiert, `document.fonts.ready`
abgewartet, Scrollposition oben fixiert, der zustandsabhängige Zurück-nach-oben-Knopf
ausgeblendet. Ohne das erzeugt schon ein zweiter Lauf ohne jede Codeänderung Diffs.

## Was im Git liegt

Nur `baseline/geometry.json` (~46 KB). Die Screenshots sind zusammen etwa 55 MB — die
Startseiten-PNGs allein 12–14 MB, weil die Papiertextur Rauschen ist und sich kaum
komprimieren lässt. Sie sind in `.gitignore`.

Das hat einen angenehmen Nebeneffekt: `geometry.json` ist Text und damit im Review als
Diff lesbar. Eine Layout-Verschiebung taucht im Pull Request als Zeilendifferenz auf,
nicht als Binärdatei.

Folge: Ein frischer Clone hat **keine** Pixel-Baseline. `compare` sagt das ausdrücklich und
prüft dann nur die Geometrie. Für volle Abdeckung einmal aus einem bekannt guten Stand
`npm run capture -- baseline` laufen lassen.

## Grenzen

- Die Sektion „Aktuelles" zieht echte Beiträge. Ändern sich Beitragsdaten, verschiebt sich
  die Baseline aus einem legitimen Grund.
- Geprüft werden drei Seitentypen. Neue Templates gehören in `PAGES` in `capture.mjs`.
- Zustände hinter Interaktion (offenes Menü, aufgeklapptes FAQ) werden nicht erfasst.

## Selbsttest

Die Harness wurde gegen eine absichtlich eingebaute 4-px-Änderung geprüft. Gemeldet wurde
`.pb-gcard: h 751.5 -> 755.5 (+4)` samt aller Folgeverschiebungen, Exit 1. Nach dem
Zurücknehmen: 12/12 Screenshots bei `0.000 %`, Geometrie identisch, Exit 0.
