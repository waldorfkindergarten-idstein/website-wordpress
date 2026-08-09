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

Code, Theme-Patterns und `wordpress/downloads/` müssen **atomar** als derselbe
Release bereitgestellt werden. Solange die Migrationsversion fehlt, ersetzt ein
Frontend-Filter ausschließlich den Inhalt der echten statischen Startseite durch
das kanonische Fallback-Pattern. Besucher sehen deshalb auch bei einem Fehler
weder eine leere noch die alte Legacy-Seite. Nach erfolgreicher Migration wird
der Filter mit dem Setzen der Versionsoption sofort wirkungslos.
Die gehärtete Cutover-Migration verwendet Version `2`; eine eventuell von einem
frühen Testlauf gesetzte Version `1` wird dadurch sicher erneut geprüft.

Automatische Schreibzugriffe laufen nicht bei anonymen Aufrufen. Erst ein
angemeldeter Administrator mit `manage_options` startet die Migration über
`admin_init`. Nach einem Fehler werden automatische Wiederholungen fünf Minuten
gedrosselt. Der Admin-Hinweis bietet **Jetzt erneut versuchen** als
Nonce-geschützten sofortigen Retry. Vorher immer die gemeldete Ursache beheben.
Für kontrollierte CLI-Deployments bleibt ein direkter Aufruf möglich:

```bash
wp eval '$result = waldorf_pb_run_content_migration(); var_dump( $result );'
```

Die Migration verwendet ausschließlich die unter **Einstellungen > Lesen**
konfigurierte Seite. Legacy-Inhalt wird nur bei einem exakt freigegebenen,
normalisierten SHA-256-Hash ersetzt; zusätzliche oder bearbeitete Legacy-Inhalte
gelten als unbekannt. Bereits migrierte Seiten müssen das vollständige
kanonische Abschnittsschema besitzen. Texte, Medien und Reihenfolge dürfen dabei
redaktionell geändert sein. Unbekannte oder unvollständige Inhalte werden nie
überschrieben. Verifizierte produktive Legacy-Varianten können technisch über
`waldorf_pb_legacy_content_hashes` ergänzt werden; niemals Teil- oder
Substring-Signaturen freigeben.

Vor Medien- oder Seitenänderungen prüft die Migration alle Blockregistrierungen,
Quelldateien, Prüfsummen sowie Upload-Verzeichnisse. Eine im
**Design > Website-Editor > Templates > Startseite** gespeicherte DB-Anpassung
hat Vorrang vor der Theme-Datei und stoppt die Migration. Dort **Startseite**
öffnen, über das Drei-Punkte-Menü die Anpassungen prüfen und mit
**Anpassungen löschen** beziehungsweise **Zurücksetzen** entfernen. Bis dahin
erzwingt das Frontend aus Sicherheitsgründen die Theme-Datei mit dem Fallback.

Vor jedem Seitenupdate entsteht die nicht automatisch geladene Sicherungsoption
`waldorf_pb_content_migration_backup` mit Seiten-ID, Originalinhalt, SHA-256 und
Zeitpunkt. Bei Legacy-Inhalt ist zusätzlich eine positive und inhaltlich
verifizierte WordPress-Revision Pflicht. Nach dem Update werden Zielinhalt,
Sicherung und Revision erneut geprüft; bei Abweichungen wird der Originalinhalt
wiederhergestellt und keine Version gesetzt. Zur Diagnose:

```bash
wp option get waldorf_pb_content_migration_error --format=json
wp option get waldorf_pb_content_migration_backup --format=json
wp option get waldorf_pb_content_migration_version
```

Die Medien tragen stabile Metadaten für Quellname und SHA-256. Vorhandene
markierte Anhänge werden gegen die aktuelle Quelldatei geprüft, nicht blind
wiederverwendet. Das Download-Verzeichnis kann bei abweichendem Deployment über
den Filter `waldorf_pb_download_source_directory` angepasst werden.

Uploads und Datenbank sind nicht Teil von Git. Vor dem atomaren Deployment
Datenbank und Uploads sichern. Danach als Administrator das Backend öffnen, den
Migrationshinweis, die Mediathek und **Seiten > Start** prüfen und anschließend
die öffentliche Startseite auf Desktop und Mobil kontrollieren.

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

Die fokussierte, datenbankfreie Migrationsprüfung läuft aus dem Repository-Stamm
mit. Sie prüft reine Helfer und Quellverträge, ersetzt aber keinen Integrationstest
mit einer WordPress-Datenbank:

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
