# Waldorf Pfirsichblüte

Block theme (full-site editing) für den Idsteiner Waldorfkindergarten.
Umsetzung des Entwurfs aus `design.html` — Aquarell-Ästhetik in Pflaume, Pfirsich
und Creme, mit handschriftlichen Akzenten und organischen Bildformen.

## Aufbau

```
theme.json              Alle Design-Tokens: Farben, Schriften, Abstände, Radien, Schatten
style.css               Nur der Theme-Header (Block-Themes stylen über theme.json)
functions.php           Asset-Laden, Block-Styles, Pattern-Kategorien
templates/              index · front-page · page · page-full · single · archive · search · 404
parts/                  header · footer
patterns/               15 Seitenabschnitte + `front-page` (setzt sie zusammen)
assets/css/             components.css — was theme.json nicht ausdrücken kann
assets/fonts/           Petrona, Nunito Sans, Caveat (variable woff2, selbst gehostet)
assets/images/          Fotos, Aquarell-Motive, Papierstruktur, Logo
assets/js/              theme.js — Sticky-Header, Reveal, Nach-oben-Button
```

## Design-Tokens

Alles Gestalterische liegt in `theme.json` und ist im Website-Editor unter
**Design → Stile** anpassbar. Wer dort eine Farbe ändert, ändert sie überall —
auch in `components.css`, weil diese Datei ausschließlich über die
CSS-Custom-Properties von WordPress arbeitet:

| Token | Wert | CSS-Variable |
|---|---|---|
| Pflaume | `#781246` | `--wp--preset--color--plum` |
| Pfirsich | `#efc3ae` | `--wp--preset--color--peach` |
| Creme | `#F6EFE3` | `--wp--preset--color--cream` |
| Tinte | `#3a2a2e` | `--wp--preset--color--ink` |
| Überschriften | Petrona | `--wp--preset--font-family--serif` |
| Fließtext | Nunito Sans | `--wp--preset--font-family--sans` |
| Akzente | Caveat | `--wp--preset--font-family--hand` |

## Abschnitte bearbeiten

Die Startseite besteht aus 15 Patterns. Im Editor lassen sie sich einzeln
einfügen (Kategorie **Waldorf: Seitenabschnitte**), umsortieren oder entfernen.
Die Reihenfolge der Startseite steht in `patterns/front-page.php`.

Inhalte mit Wiederholungen (Gruppen, Feste, Tagesablauf, Termine, Downloads)
liegen als PHP-Arrays am Kopf der jeweiligen Pattern-Datei — dort ändern, nicht
im Markup.

## Block-Style-Varianten

| Block | Variante | Wirkung |
|---|---|---|
| Button | Zurückhaltend | Heller Glas-Button mit Rand statt Pflaume |
| Gruppe | Karte | Creme-Karte mit Rand und Hover-Anhebung |
| Gruppe | Milchglas | Halbtransparent mit Weichzeichner |
| Bild | Organische Form | Weiche, asymmetrische Silhouette |
| Liste | Mit Pfirsich-Punkten | Punkte statt Aufzählungszeichen |
| Trenner | Handgezeichnet | Gezeichnete Linie statt Strich |

## Fotos

Alle mitgelieferten Fotos sind **Beispielbilder** und tragen sichtbar den
Hinweis „Beispielbild“. Eigene Bilder ersetzen sie 1:1 an derselben Stelle.
Die Bildunterschriften sind normale `<figcaption>`-Elemente und im Editor
direkt überschreibbar. Sollen sie site-weit verschwinden, genügt die Klasse
`pb-no-labels` am `<body>`.

## Schriften

Selbst gehostet, keine Verbindung zu Google-Servern (DSGVO). Es sind
Variable Fonts: eine Datei deckt alle Schnitte einer Familie ab. Latin und
Latin-Extended sind getrennt, damit Browser nur laden, was sie brauchen.

## Barrierefreiheit

- Sichtbarer Fokus-Rahmen auf allen Links (`:focus-visible`, 2px Pflaume)
- `prefers-reduced-motion` schaltet Animationen und Hover-Verschiebungen ab
- FAQ nutzt natives `<details>`/`<summary>` — funktioniert ohne JavaScript
- `theme.js` ist reine Zugabe; ohne JavaScript bleibt alles lesbar und bedienbar

## Entwicklung

```bash
docker compose up -d          # http://localhost:8080
docker compose down           # stoppen
```

Theme wechseln:

```bash
docker exec waldorf-wp-app wp theme activate waldorf-pfirsichbluete --allow-root
docker exec waldorf-wp-app wp theme activate waldorf-idstein --allow-root   # zurück
```
