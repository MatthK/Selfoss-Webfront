# selfoss + webfront — your personal "Morning Post"

All-in-one Docker image that bundles the [selfoss](https://github.com/fossar/selfoss) RSS reader with the newspaper-style [Selfoss-Webfront](https://github.com/MatthK/Selfoss-Webfront) UI. Selfoss fetches and stores the full text of your RSS feeds; the webfront turns them into a good-looking personal newspaper. The recommended way to run it is the [docker-compose stack](https://github.com/MatthK/Selfoss-Webfront) in the repository (which adds a MySQL database and ready-made configuration), but the image also works standalone against your own database.

## What's inside

| Component | Version |
|---|---|
| Selfoss | 2.19 (official release) |
| Selfoss-Webfront | newspaper UI, Bootstrap 4.6.2 + jQuery 3.7.1 |
| Base image | `php:8.3-apache` |

- Multi-arch: **linux/amd64** and **linux/arm64** (works on 64-bit Raspberry Pi)
- Feeds are refreshed automatically every 15 minutes (`SELFOSS_UPDATE_INTERVAL`, set `0` to disable)
- The `HTML_UnEncode` SQL function the webfront needs is installed automatically at container start

| Port | Service |
|---|---|
| `80` | the newspaper (webfront) |
| `8080` | selfoss feed management UI |

## Quick start

You need a MySQL (or MariaDB) database with a database and user for selfoss, e.g.:

```sql
CREATE DATABASE selfoss CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
CREATE USER 'selfoss'@'%' IDENTIFIED BY 'your-password';
GRANT ALL PRIVILEGES ON selfoss.* TO 'selfoss'@'%';
```

Then start the image (replace the host and password with yours):

```bash
docker run -d --name selfoss-wf \
  -p 80:80 -p 8080:8080 \
  -e SWF_DB_HOST=mysql.example.com \
  -e SWF_DB_NAME=selfoss \
  -e SWF_DB_USER=selfoss \
  -e SWF_DB_PASSWORD=your-password \
  -e SELFOSS_DB_HOST=mysql.example.com \
  -e SELFOSS_DB_DATABASE=selfoss \
  -e SELFOSS_DB_USERNAME=selfoss \
  -e SELFOSS_DB_PASSWORD=your-password \
  -v selfoss-data:/var/www/html/data \
  matthk72/selfoss-wf:latest
```

- Open `http://<host>:8080/` and add your feeds in selfoss. Use the **RSS Feed (with FullTextRss)** type to get full articles instead of teasers, and give each source one of your category tags.
- The newspaper is then available at `http://<host>/`.

For a complete stack (image + MySQL 8.4 + configuration templates + `.env`), use the [docker-compose setup](https://github.com/MatthK/Selfoss-Webfront#quick-start-with-docker-compose) from the repository.

## Environment variables

| Variable | Purpose | Default |
|---|---|---|
| `SWF_DB_HOST` / `SWF_DB_NAME` / `SWF_DB_USER` / `SWF_DB_PASSWORD` | database used by the **webfront** | `localhost` / `selfoss` / `selfoss` / – |
| `SELFOSS_DB_HOST` / `SELFOSS_DB_DATABASE` / `SELFOSS_DB_USERNAME` / `SELFOSS_DB_PASSWORD` / `SELFOSS_DB_PORT` | database used by **selfoss** (overrides `config.ini`) | – |
| `SELFOSS_UPDATE_INTERVAL` | seconds between automatic feed updates | `900` |

## Volumes and configuration

- `/var/www/html/data` — selfoss data (logs, favicons, thumbnails). Drop your `config.ini` here or mount it (`-v ./config.ini:/var/www/html/data/config.ini`); see the [selfoss documentation](https://selfoss.aditu.de) for all options.
- The webfront's look (newspaper name, the 11 category tags, refresh intervals) is configured in `/var/www/webfront/includes/constants.php` — mount your own copy to customize it. The tag names must match the tags you assigned to your selfoss sources.

### Configuring the database

Two equivalent ways:

1. **Environment variables** (as in the quick start above) — they override the ini file.
2. **Classic `db_*` values in `config.ini`** (`db_type`, `db_host`, `db_database`, `db_username`, `db_password`, `db_port`) — the selfoss-native way.

Whichever you choose, make sure the configuration is complete: without any `db_*` values, selfoss falls back to its default `db_type=sqlite` and will fail with an internal server error.

### Using an existing database

If you point this image at a database from an older selfoss/webfront installation, everything keeps working — sources, items and starred articles are picked up as they are. One note on the `HTML_UnEncode` function the webfront uses for combining duplicate articles: it is installed automatically at startup, but if your database already contains a copy created by a database admin account (common in older manual installs), the installer cannot replace it — you may see a privilege error in the container log. That message is harmless: the existing function is used. To refresh the function with the current definition, run `db/HTML_UnEncode.sql` once as database admin.

## Tags

- `2.0.0`, `2.0` — current release
- `latest` — tracks the most recent release

## Source, issues, license

- Source and issue tracker: [github.com/MatthK/Selfoss-Webfront](https://github.com/MatthK/Selfoss-Webfront)
- Licensed under the [GPL-3.0](https://github.com/MatthK/Selfoss-Webfront/blob/master/LICENSE), like selfoss itself.
- Thanks to the [selfoss](https://github.com/fossar/selfoss) project — without it, this image wouldn't exist.
