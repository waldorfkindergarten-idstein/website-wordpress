# Waldorfkindergarten WordPress

This repository contains the local WordPress codebase that mirrors the STRATO deployment closely enough for file-based development.

## Local Docker setup

1. Copy `.env.example` to `.env`.
2. Adjust the passwords in `.env` if you want.
3. Start the stack:

```bash
docker compose up -d
```

4. Open:

- WordPress: `http://localhost:8080`
- Adminer: `http://localhost:8081`

The local WordPress container serves the files from `./wordpress`, so theme/plugin/file changes are visible locally before you upload them to STRATO.

## First local install

On first boot, WordPress will ask for the normal setup values because the local database is empty.

Recommended local values:

- Site title: `Waldorfkindergarten Idstein Local`
- Username: your preferred local admin username
- Password: a local-only password
- Email: your email address

## What should go into git

Track:

- `wordpress/wp-content/themes/waldorf-pfirsichbluete/`
- intentional plugins in `wordpress/wp-content/plugins/`
- `wordpress/downloads/`
- this Docker setup and docs

Do not track:

- `wordpress/wp-config.php`
- `wordpress/.htaccess`
- `wordpress/wp-content/languages/`
- caches, upgrades, secrets

## Build step

The theme's blocks are compiled. `wordpress/wp-content/themes/waldorf-pfirsichbluete/build/`
is **not** in git — CI builds it and uploads it from there. A fresh clone therefore
has no registered blocks and the front page renders empty section by section until
you build once:

```bash
cd wordpress/wp-content/themes/waldorf-pfirsichbluete
npm install
npm run build      # or: npm run start, to rebuild on change
```

## Deployment

Pushing to `main` builds, lints, runs the migration contract checks, and uploads
to STRATO over SFTP — see `.github/workflows/`. Only two paths are ever uploaded:

- `wordpress/wp-content/themes/waldorf-pfirsichbluete/` (minus `src/`, `node_modules/`
  and the npm manifests)
- `wordpress/downloads/`

WordPress core is never deployed from this repository; STRATO keeps and updates its
own. The theme directory is mirrored with deletion so stale block bundles cannot
accumulate, and the workflow refuses to run if the computed remote path is not the
theme directory.

Required repository secrets:

| Secret | Value |
|---|---|
| `SFTP_HOST` | STRATO SFTP hostname |
| `SFTP_USER` | SFTP username |
| `SFTP_PASSWORD` | SFTP password |
| `SFTP_REMOTE_PATH` | WordPress document root on the server, e.g. `/htdocs` |

Three things the pipeline deliberately does not do:

- **It is not atomic.** Files land one at a time, so there is a brief window of
  mixed versions. The theme's front-page fallback filter exists to cover it.
- **It carries no database state.** Pages, menus, users, options and the Media
  Library are deployment state and are not versioned here.
- **It does not run the content migration.** Afterwards, sign in as an
  administrator, follow the migration notice, and check **Seiten > Start** and the
  public front page on desktop and mobile.

Before the first real launch, work through the checklist in
`wordpress/wp-content/themes/waldorf-pfirsichbluete/readme.md`.

The visual regression suite (`tests/visual`) is not part of CI: it drives a browser
against a populated WordPress instance and its baseline tracks real content. It stays
a local gate — run `npm run check` there before merging anything that touches layout.

## Current design and editor status

The `waldorf-pfirsichbluete` block theme contains the completed visual homepage
and editable dynamic content blocks. Its front-page template renders the content
of the static page selected under WordPress **Settings > Reading**.

After the atomic cutover deployment, the public homepage uses a canonical safe
fallback until an authenticated administrator triggers the migration. The theme
then migrates only exactly recognized legacy content and source media into normal
Gutenberg page content and Media Library attachments. It never assumes a page or
attachment ID and refuses to overwrite unrecognized editor-owned content.
Uploads and database changes remain deployment state and are not tracked by Git.

Editor and deployment instructions are maintained in
`wordpress/wp-content/themes/waldorf-pfirsichbluete/readme.md`.
