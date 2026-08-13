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

The theme directory is mirrored with deletion so stale block bundles cannot
accumulate. `wordpress/downloads/` is not, so nothing on the server is removed by
surprise. Before uploading, the job proves the remote really is a WordPress install
by entering `wp-content/themes`, so a mistyped path fails instead of quietly creating
a tree in the wrong place.

WordPress runs on a **subdomain with its own document root**, installed by hand — not
through a STRATO one-click setup — so the previous site stays live during the
transition. `SFTP_REMOTE_PATH` must therefore be that subdomain's document root, not
the root of the hosting package.

Because the install is manual, **WordPress core is this project's responsibility**,
not the host's. Core is tracked in this repository but is deliberately not uploaded
by the pipeline: core updates are applied through the WordPress admin, and the copy
here exists so local Docker mirrors the server.

> **Check for drift before trusting local results.** As of 13 August 2026 the server
> runs **7.0.4** and this repository pins **7.0.3** — the server applied a minor
> update on its own. Confirm the current server version with
> `ssh waldorfkindergarten '~/bin/wp core version'` and bring the tracked core and
> the Docker image up to match before relying on local results for anything
> core-sensitive — block markup and block CSS in particular.

Required repository secrets:

| Secret | Value |
|---|---|
| `SFTP_HOST` | STRATO SFTP hostname |
| `SFTP_USER` | SFTP username |
| `SFTP_PASSWORD` | SFTP password |
| `SFTP_REMOTE_PATH` | `/wp` — the WordPress document root, verified on the server |

The SFTP account is chrooted: its root `/` is the hosting package, which still holds
the **old static site** (`index.html`, `bilder/`, `css/`, `gallery/`, `js/`, …).
WordPress lives beside it in `/wp`, which is why nothing here may ever be pointed at
`/`. The deploy account is SFTP-only and has no shell, so the pipeline itself cannot
run commands on the server. A **separate SSH account** exists for maintenance — see
below — but the pipeline deliberately does not use it.

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

## SSH and WP-CLI on the server

There is a **second STRATO account with a real shell**, separate from the SFTP deploy
account. Use it for maintenance and inspection — never for deploying code, which stays
the pipeline's job.

| | |
|---|---|
| Host | `53107580.ssh.w1.strato.hosting` |
| User | `stu772369241` (the SFTP deploy user is a *different* account) |
| Home | `…/htdocs` — the home directory **is** the webspace root |
| WordPress | `~/wp` |

Local access uses a dedicated key and an alias, so no password is typed or scripted:

```bash
ssh waldorfkindergarten            # key: ~/.ssh/waldorfkindergarten
```

To set this up on another machine:

```bash
ssh-keygen -t ed25519 -f ~/.ssh/waldorfkindergarten -C "you@waldorfkindergarten"
ssh-copy-id -i ~/.ssh/waldorfkindergarten.pub stu772369241@53107580.ssh.w1.strato.hosting
```

then add to `~/.ssh/config`:

```
Host waldorfkindergarten
    HostName 53107580.ssh.w1.strato.hosting
    User stu772369241
    IdentityFile ~/.ssh/waldorfkindergarten
    IdentitiesOnly yes
```

No password or private key is stored in this repository.

### WP-CLI

`wp` is installed at `~/bin/wp` on the server:

```bash
ssh waldorfkindergarten '~/bin/wp core version'
ssh waldorfkindergarten '~/bin/wp option get home'
ssh waldorfkindergarten '~/bin/wp post list --post_type=page'
```

**Why it needs a bundled PHP.** Every PHP binary STRATO provides — `/usr/bin/php*`,
`/opt/RZphp*/bin/php`, versions 5.3 through 8.5 — is the **`cgi-fcgi` SAPI**. WP-CLI
refuses to run under CGI. So `~/bin/wp` is a wrapper around a self-contained static
PHP **CLI** build at `~/bin/php-cli` (`static-php-cli`, 8.3.32, *bulk* variant — the
*common* variant omits `mysqli`, which `wpdb` requires):

```sh
exec "$HOME/bin/php-cli" -d memory_limit=512M "$HOME/bin/wp-cli.phar" --path="$HOME/wp" "$@"
```

Both `~/bin/php-cli` and `~/bin/wp-cli.phar` live outside the document root and
outside this repository. If the webspace is ever rebuilt, reinstall them:

```bash
curl -sSL -o ~/bin/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
curl -sSL https://dl.static-php.dev/static-php-cli/bulk/php-8.3.32-cli-linux-x86_64.tar.gz | tar xz -C ~/bin
mv ~/bin/php ~/bin/php-cli && chmod +x ~/bin/php-cli ~/bin/wp-cli.phar
```

### Site language

The site runs **de_DE**. This matters beyond the admin UI: it is what makes
`<html lang="de">` correct for screen readers and search engines, and it is the
precondition for `hyphens: auto` — without it, long German compounds such as
`Verbraucherschlichtungsstelle` cannot be broken and force a horizontal scroll
on narrow phones.

Language packs live in `wp-content/languages/`, which is **not** in git and
**not** deployed by the pipeline, so each environment installs its own. If an
environment is rebuilt, restore it with:

```bash
wp language core install de_DE --activate
```

Locally that fails against the bind mount (the CLI container runs as uid 33 and
cannot write `wp-content/languages` or `wp-content/upgrade`). Either create both
directories writable first, or unzip the pack directly:

```bash
mkdir -p wordpress/wp-content/{languages,upgrade} && chmod 777 wordpress/wp-content/{languages,upgrade}
curl -sSL "https://downloads.wordpress.org/translation/core/$(wp core version)/de_DE.zip" -o /tmp/de.zip
unzip -o /tmp/de.zip -d wordpress/wp-content/languages
wp option update WPLANG de_DE
```

With German core active, `waldorf_pb_translate_navigation_toggles()` in
`functions.php` is redundant — core already renders "Menü" and "Schließen". It
is left in place as a fallback should the locale ever be reset.

### Working on live content

Content is **not** deployed. Once the site is live, production content is the source
of truth and only ever flows *downwards*:

- **Edit content** in wp-admin. Every field in the theme's blocks is editable there.
- **Bulk find/replace** — use WP-CLI (`wp search-replace --dry-run` first); it is
  serialization-safe, unlike raw SQL.
- **Take a backup before touching the database**: `wp db export ~/backup-$(date +%F).sql`
- **Pull production down to local** for development; never push a local database up.

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
