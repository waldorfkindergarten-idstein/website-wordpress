# Waldorf Pfirsichblüte

Block-Theme für den Idsteiner Waldorfkindergarten. Farben, Schriften und
Abstände kommen aus `theme.json`; die Startseite besteht aus redaktionell
bearbeitbaren Gutenberg-Blöcken.

## Startseite bearbeiten

1. Im WordPress-Backend **Seiten > Start** öffnen.
2. Über **Dokumentübersicht > Listenansicht** den gewünschten Abschnitt oder
   Baustein auswählen. Die Namen entsprechen den sichtbaren Bereichen.
3. Text direkt in der Vorschau anklicken und ändern.
4. Änderungen zuerst über **Vorschau** auf Desktop und Mobil prüfen, dann
   **Speichern**.

Abschnitte lassen sich in der Listenansicht mit den Pfeilen oder per Ziehen
umsortieren. Wiederholbare Einträge wie Gruppen, Feste, Teammitglieder,
Tagespunkte, Termine, Fragen und Downloads werden innerhalb ihres benannten
Sammelblocks umsortiert. Wo ein **+** angezeigt wird, können passende Einträge
ergänzt werden; fest geschützte Listen lassen sich nur bearbeiten und
umsortieren.

## Fotos

1. In der Listenansicht **Foto**, **Hero-Foto** oder eine **Gruppenkarte** wählen.
2. In der Block-Werkzeugleiste **Bild ersetzen** auswählen und ein Bild aus der
   Mediathek wählen oder hochladen.
3. Rechts unter **Foto > Bildausschnitt** den Fokuspunkt setzen.
4. Einen sachlichen Alternativtext eintragen. Bei rein dekorativen Bildern darf
   er leer bleiben; dann wird der Alternativtext der Mediathek verwendet.
5. Die Bildunterschrift direkt unter dem Foto bearbeiten. Eine leere
   Bildunterschrift wird nicht ausgegeben.

Die zehn mitgelieferten `photo-*.jpg` werden bei der ersten Migration exakt in
die Mediathek kopiert. Danach sind die Medien redaktionell austauschbar;
Aquarelle, Logo und andere Dekorationen bleiben Theme-Dateien.

## Wiederholbare Inhalte

Gruppenkarten, Feste, Personen, Tagesablauf-Punkte, Termine, FAQs und Downloads
sind normale Blöcke, keine PHP-Listen. Den übergeordneten Sammelblock in der
Listenansicht aufklappen, einen Eintrag auswählen und dessen Felder direkt oder
in der rechten Seitenleiste bearbeiten. Einträge lassen sich innerhalb ihrer
Liste verschieben. Einfügen oder Entfernen ist nur bei Listen möglich, die dafür
ein **+** beziehungsweise das Drei-Punkte-Menü anbieten.

## Downloads

Im Abschnitt **Downloads und Formulare** den Eintrag auswählen und über
**Datei auswählen** beziehungsweise **Datei ersetzen** mit einem Medium
verbinden. Titel und Beschreibung sind direkt bearbeitbar; Typ und Dateigröße
werden aus dem Medium ermittelt.

Bei der Migration werden fünf vorhandene PDFs aus `wordpress/downloads/` in die
Mediathek importiert. Automatisch verknüpft werden nur eindeutige Zuordnungen:

| Download-Block | Datei |
|---|---|
| Anmeldebogen | `anmeldung-familiengruppe.pdf` |
| Gebührenordnung | `beitragsordnung-2022.pdf` |
| Satzung des Vereins | `vereinssatzung.pdf` |

`anmeldung-wiegenstube.pdf` und `anmeldung-kindergarten-u3.pdf` stehen danach
in der Mediathek zur Auswahl. Konzeption, Packliste sowie Ferien und
Schließtage bleiben absichtlich unverknüpft, bis die richtigen Dateien vorliegen.

## Schutzmechanismen

- Abschnittshüllen sind gegen versehentliches Löschen geschützt, bleiben aber
  in der Listenansicht verschiebbar.
- Das innere Layout eines Abschnitts ist gesperrt; Texte, Medien und vorgesehene
  wiederholbare Einträge bleiben bearbeitbar.
- Eigene Waldorf-Blöcke unterstützen kein **Als HTML bearbeiten**.
- Zum Entsperren oder Umbauen der Struktur ist technische Administration nötig;
  nicht über den Code-Editor arbeiten.
- Vor größeren redaktionellen Änderungen eine Vorschau nutzen. WordPress legt
  Revisionen der Seite an.

## Migration und Deployment

Die Migration in `inc/content-migration.php` läuft nach dem Deployment einmalig
vor dem Rendern der Startseite. Sie ermittelt ausschließlich die unter
**Einstellungen > Lesen** konfigurierte statische Startseite, importiert Medien
idempotent und ersetzt nur die bekannte Legacy-Startseite des alten Themes oder
eine vollständig leere Seite. Nicht erkannte Inhalte werden nie überschrieben;
Administratoren sehen stattdessen einen Hinweis.

Bereits vorhandene neue Waldorf-Blöcke werden nicht neu angelegt. Die Migration
ergänzt dort nur fehlende IDs für bekannte Fallback-Fotos und eindeutig
zuordenbare Download-Platzhalter. Vor dem Ersetzen von Legacy-Inhalten wird eine
Revision angefordert. Erst nach erfolgreichem Speichern wird die
Migrationsversion gesetzt.

Uploads und Datenbank sind nicht Teil von Git. Deshalb nach jedem Deployment
im Backend den Migrationshinweis, die Mediathek und **Seiten > Start** prüfen und
anschließend die öffentliche Startseite auf Desktop und Mobil kontrollieren.

## Entwicklung

```bash
docker compose up -d
docker compose down
```

Bei Änderungen unter `src/` im Theme-Verzeichnis:

```bash
npm install
npm run build
npm run lint
```

Die fokussierte Migrationsprüfung läuft aus dem Repository-Stamm mit:

```bash
php tests/verify-content-migration.php
```

Theme lokal aktivieren:

```bash
docker exec waldorf-wp-app wp theme activate waldorf-pfirsichbluete --allow-root
```

## Technischer Aufbau

```text
theme.json              Design-Tokens und globale Block-Einstellungen
functions.php           Theme-Bootstrap und Editor-/Frontend-Assets
inc/                    versionierte Inhalts- und Medienmigration
templates/              Block-Templates; front-page rendert post-content
parts/                  Header und Footer
patterns/               kanonische Standardabschnitte für neue Inhalte
src/blocks/             Quellen der dynamischen redaktionellen Blöcke
build/blocks/           gebaute, von WordPress registrierte Blöcke
assets/css/             gemeinsame Komponentenstile für Frontend und Editor
assets/images/          Fallback-Fotos und Theme-eigene Dekorationen
assets/js/              optionale Frontend-Interaktionen
```
