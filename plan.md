# Plan — Editierbarkeit für `waldorf-pfirsichbluete`

Ziel: Die Startseite (und alle weiteren Seiten) müssen von einer **nicht-technischen Person**
bearbeitet werden können — Text, Bilder, Reihenfolge — ohne HTML, ohne Editor-Fehler, ohne
das Layout kaputt zu machen.

Status: geplant, nicht begonnen. Das Theme ist live und visuell fertig.

---

## 1. Ausgangslage

Das Theme sieht korrekt aus, aber der Inhalt ist an drei Stellen eingesperrt:

| Problem | Umfang | Folge im Editor |
|---|---|---|
| `front-page.html` rendert ein **Pattern** statt `wp:post-content` | 1 Template | Seite 12 im Seiten-Editor bearbeitet *nichts*. Der Site-Editor zeigt die Sektionen, aber als Template — für Redakteure der falsche Ort. |
| **23 `wp:html`-Blöcke** in den Patterns | 15 Pattern-Dateien | Rohes HTML im Editor. Keine Vorschau, keine Toolbar, ein Tippfehler zerlegt die Sektion. |
| **12 PHP-Datenarrays** in den Patterns | `aktuelles`, `stimmen`, `anmeldung` (×2), `team`, `verpflegung`, `gruppen`, `jahreslauf`, `kontakt`, `rhythmus` (×2), `downloads` | Termine, Team, FAQ, Downloads etc. sind nur per Code-Deploy änderbar. |
| **10 Fotos** hart in PHP verdrahtet | `waldorf_pb_img('photo-*.jpg')` | Redakteure können kein Bild austauschen. Die Dateien liegen im Theme und haben **keine Attachment-ID**, tauchen also gar nicht in der Mediathek auf. |

Die betroffenen Fotos (alle mit `Beispielbild ·`-Bildunterschrift):

`photo-hero.jpg` (Freispiel im Garten) · `photo-gruppenraum.jpg` · `photo-malecke.jpg` ·
`photo-holz.jpg` · `photo-garten.jpg` · `photo-essen.jpg` · `photo-morgenkreis.jpg` ·
`photo-krippe.jpg` · `photo-waldtag.jpg` · `photo-rhythmus.jpg`

---

## 2. Architekturentscheidung: eigene Blöcke, server-gerendert

**Eigene Blöcke** (`waldorf/*`) statt Core-Blöcke + Patterns. Nur so bekommen Redakteure
Felder statt Markup.

Jeder Block besteht aus `block.json` + `edit.js` + **`render.php`** — also **dynamisch,
nicht statisch `save()`**. Das ist die zentrale technische Entscheidung:

- **Kein gespeichertes Markup ⇒ keine Block-Validierungsfehler.** Wir hatten das Problem
  bereits beim Hero-Bild (`style.layout.aspectRatio` vs. `aspectRatio`). Bei statischen
  Blöcken bricht jede spätere Markup-Änderung alle bestehenden Seiten.
- **CSS und HTML bleiben änderbar**, ohne Inhalte anzufassen. `components.css` bleibt die
  Quelle der Wahrheit fürs Aussehen.
- Im Post gespeichert werden nur **Attribute** (Text, Attachment-ID, Variante) — sauber,
  klein, migrierbar.

### Preis

Ein **Build-Schritt kommt neu ins Repo**: `package.json` + `@wordpress/scripts`. Das Repo
hat heute keinen Bundler. `npm install && npm run build` wird Voraussetzung für die
Theme-Entwicklung. Für den reinen Betrieb nicht — `build/` wird eingecheckt.

---

## 3. Bilder editierbar machen — `waldorf/photo`

Der Block, der die eigentliche Anforderung löst. Ein Block für **alle** Fotos, Form über
ein Attribut:

| Feld | UI | Attribut |
|---|---|---|
| Bild | `MediaPlaceholder` / `MediaReplaceFlow` — Mediathek oder Upload | `id` (Attachment-ID) |
| Bildunterschrift | `RichText` direkt am Bild | `caption` |
| Form | Auswahl im Seitenpanel: Hero · Mosaik 1–4 · Gruppe · Rhythmus · Essen · Person · Rund | `shape` |
| Bildausschnitt | `FocalPointPicker` | `focalPoint` |
| Alternativtext | Textfeld | `alt` (Fallback: Alt-Text aus der Mediathek) |

`render.php` nutzt `wp_get_attachment_image()` — dadurch gibt es **echte `srcset`/`sizes`
und Lazy-Loading**, was die aktuellen hart verdrahteten `<img>`-Tags nicht haben. Die
organischen Blob-Formen bleiben CSS-Klassen, gesteuert über `shape`.

Ohne gesetztes Bild fällt der Block auf das mitgelieferte Theme-Bild zurück — eine frische
Installation sieht also weiterhin korrekt aus.

---

## 4. Phasen

Jede Phase endet mit einem Lauf der Visual-Regression-Prüfung (Abschnitt 5) auf **0.000 %**.

### Phase A — Ein Ort zum Bearbeiten *(klein)*

- `templates/front-page.html`: `wp:pattern` → `wp:post-content`
- Seite 12 („Start") einmalig mit dem Pattern-Inhalt befüllen; der alte, verwaiste
  `waldorf-idstein`-Markup dort wird ersetzt
- Ergebnis: „Seiten → Start bearbeiten" bearbeitet ab sofort die echte Startseite

Das ist die riskanteste Phase des ganzen Umbaus — sie tauscht aus, wie die Startseite
überhaupt zustande kommt. Deshalb liegt die Prüfharness bereits vor Phase A im Repo
(siehe Abschnitt 5), nicht danach.

### Phase B — Werkzeugkette *(klein)*

- `package.json`, `@wordpress/scripts`, `.gitignore`
- Blockregistrierung über `wp_register_block_types_from_metadata_collection()` bzw.
  `register_block_type()` über das `build/`-Manifest
- Eine Block-Kategorie „Waldorf" im Inserter

### Phase C — `waldorf/photo` *(hoher Nutzen, mittlerer Aufwand)*

Der Block aus Abschnitt 3. Danach sind alle 10 `Beispielbild`-Fotos über die Mediathek
austauschbar. **Das ist die Phase, die die eigentliche Anforderung erfüllt** — sie lohnt
sich auch dann, wenn alles Weitere später kommt.

### Phase D — Restliche Blöcke, Sektion für Sektion *(der Hauptteil)*

Ersetzt die 23 `wp:html`-Blöcke und die 12 PHP-Arrays:

| Block | Ersetzt | Felder |
|---|---|---|
| `waldorf/gruppen-karte` | `gruppen.php` | Foto, Tag, Titel, Text, Alter, Zeiten, Link |
| `waldorf/fest` | `jahreslauf.php` | Monat, Titel, Text, Motiv |
| `waldorf/tag` | `rhythmus.php` (Woche) | Wochentag, Titel, Text, Waldtag-Schalter |
| `waldorf/tagesablauf` + `waldorf/tagesablauf-punkt` | `rhythmus.php` (Tag) | Uhrzeit, Titel, Zusatz |
| `waldorf/stimme` | `stimmen.php` | Zitat, Person |
| `waldorf/schritt` | `anmeldung.php` (Schritte) | Titel, Text (Nummer automatisch) |
| `waldorf/faq` | `anmeldung.php` (FAQ) | Frage, Antwort |
| `waldorf/download` | `downloads.php` | **Datei aus Mediathek**, Titel, Beschreibung (Typ + Größe automatisch) |
| `waldorf/termin` | `aktuelles.php` | Datum, Titel, Detail |
| `waldorf/kontaktzeile` | `kontakt.php` | Bezeichnung, Wert |
| `waldorf/getreidetag` | `verpflegung.php` | Tag, Getreide, Hinweis |
| `waldorf/person` | `team.php` | Foto oder Monogramm, Name, Rolle |
| Hero-Bausteine: `waldorf/chip`, `waldorf/fakt`, `waldorf/siegel`, `waldorf/datum` | `hero.php` (7 `wp:html`) | je 1–2 Textfelder |
| `waldorf/mosaik`, `waldorf/jahreszeiten` | `haus.php`, `season.php` | Container mit `InnerBlocks` |

Container nutzen `InnerBlocks` mit `allowedBlocks`, damit ein Gruppen-Raster nur
Gruppen-Karten aufnimmt und nichts anderes.

### Phase E — Mediathek-Import *(klein)*

Die 21 Theme-Bilder haben heute keine Attachment-ID. Ein einmaliger Import registriert sie
als Anhänge und verknüpft die Startseiten-Inhalte damit — erst danach sieht ein Redakteur
das aktuelle Bild überhaupt in der Mediathek und kann es ersetzen.

### Phase F — Leitplanken *(klein)*

- `templateLock` auf den strukturellen Hüllen: Redakteure ändern Inhalt, nicht Layout
- `metadata.name` je Sektion, damit die Listenansicht „Hero", „Werte", „Gruppen" zeigt
  statt „Gruppe / Gruppe / Gruppe"
- Prüfen, dass die Editor-Leinwand `components.css` lädt — der Editor muss aussehen wie
  die Seite

### Phase G — Abnahme *(klein)*

- Vollständiger Vergleichslauf
- `readme.md` um eine kurze Anleitung für Redakteure ergänzen

---

## 5. Wie wir prüfen, dass das Layout gleich bleibt

`tests/visual/` (Playwright + pixelmatch). **Liegt im Repo — eingerichtet, bevor die erste
Phase beginnt**, damit auch Phase A selbst abgesichert ist. Details in
`tests/visual/README.md`.

```bash
cd tests/visual && npm install   # einmalig
npm run capture -- baseline      # vor der Änderung
npm run check                    # nach der Änderung, Exit 1 bei Abweichung
```

- **12 Screenshots**: Startseite / Beitrag / 404 × 390, 768, 1280, 1440 px
- **Pixelvergleich** mit Antialiasing-Toleranz, schreibt markierte Diff-Bilder
- **Geometrie-Fingerabdruck**: 39 Sonden-Selektoren × Position, Größe, Farbe, Schrift,
  Radius. Macht aus „1,2 % der Pixel unterscheiden sich" die Aussage
  `.pb-gcard: h 751.5 → 755.5 (+4)`
- **Determinismus erzwungen**: Animationen aus, Reveals an, Bilder eager + dekodiert,
  `document.fonts.ready` abgewartet, Scroll oben fixiert, Zurück-nach-oben ausgeblendet
- **Exit-Code 1 bei jeder Abweichung** — taugt als Commit-Gate

Im Git liegt nur `baseline/geometry.json` (~46 KB, Text). Die Screenshots sind zusammen
~55 MB und sind ignoriert. Nebeneffekt: Eine Layout-Verschiebung erscheint im Review als
lesbarer Zeilendiff statt als Binärdatei. Ein frischer Clone prüft ohne Baseline-PNGs
zunächst nur die Geometrie und sagt das ausdrücklich.

Belegt: Eine absichtlich eingebaute 4-px-Änderung wurde als
`.pb-gcard: h 751.5 -> 755.5 (+4)` samt aller Folgeverschiebungen gemeldet, Exit 1. Nach
dem Zurücknehmen: 12/12 Screenshots bei `0.000 %`, Geometrie identisch, Exit 0.

**Regel für den Umbau:** Eigene Blöcke sind reines Umverdrahten der Autorenseite — das
gerenderte Markup muss identisch bleiben. Jede Phase endet auf 0.000 %. Beabsichtigte
Änderungen werden ausdrücklich neu als Baseline gesetzt, nie stillschweigend.

**Bekannte Einschränkung:** Die Sektion „Aktuelles" zieht echte Beiträge. Ändern sich
Beitragsdaten, verschiebt sich die Baseline aus einem legitimen Grund. Derzeit stabil.

---

## 6. Was wir uns damit einhandeln

1. **Ein Build-Schritt kommt ins Repo.** `npm install` wird Voraussetzung für die
   Theme-Entwicklung.
2. **Inhalt wandert aus Git in die Datenbank.** Gegenmaßnahme: Die Patterns bleiben als
   ausgelieferte Standardinhalte erhalten, damit eine Neuinstallation korrekt aussieht.
3. **Eigene Blöcke sind mehr Arbeit als Core-Blöcke + Patterns** — aber der einzige Weg zu
   einer Bearbeitung, die für eine nicht-technische Person wirklich funktioniert.

---

## 7. Reihenfolge

**A → B → C** ist die erste sinnvolle Lieferung: Die Startseite wird im normalen
Seiten-Editor bearbeitbar, und alle Bilder werden austauschbar — vor dem langen Rest aus
Phase D.

---

## 8. Offener Punkt

Das Hero-Bild setzt `style.layout.aspectRatio`, während `core/image` `aspectRatio` auf
oberster Ebene erwartet — wahrscheinlich ein Block-Validierungsfehler. Löst sich mit
Phase C von selbst auf, da `waldorf/photo` den `core/image`-Block dort ersetzt.
