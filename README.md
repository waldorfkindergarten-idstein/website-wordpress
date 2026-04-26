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

- `wordpress/wp-content/themes/waldorf-idstein/`
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

## Current design status

The theme is functional, but the homepage still needs a parity pass against the Astro/Vercel reference. The Docker setup is intended to make those visual fixes safer and faster to iterate on locally.
