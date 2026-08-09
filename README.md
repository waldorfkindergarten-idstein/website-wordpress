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

## Deployment idea

Use local Docker to verify design/theme changes first, then upload only changed files to STRATO via SFTP.

Important: git will version the code/files, but not WordPress database content such as pages, menus, users, and settings.

## Current design and editor status

The `waldorf-pfirsichbluete` block theme contains the completed visual homepage
and editable dynamic content blocks. Its front-page template renders the content
of the static page selected under WordPress **Settings > Reading**.

On first deployment of the cutover, the theme migrates the recognized legacy
homepage and source media into normal Gutenberg page content and Media Library
attachments. The migration never assumes a page or attachment ID and refuses to
overwrite unrecognized editor-owned content. Uploads and database changes remain
deployment state and are not tracked by Git.

Editor and deployment instructions are maintained in
`wordpress/wp-content/themes/waldorf-pfirsichbluete/readme.md`.
