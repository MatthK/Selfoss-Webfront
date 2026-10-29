#!/bin/sh
set -e

# Data directories may be missing on a fresh data volume
# (config.ini may be a read-only bind mount, so it is not touched)
mkdir -p /var/www/html/data/logs /var/www/html/data/favicons /var/www/html/data/thumbnails
chown -R www-data:www-data /var/www/html/data/logs /var/www/html/data/favicons /var/www/html/data/thumbnails

# Install/refresh the HTML_UnEncode function the webfront queries rely on.
# Runs in the background and retries until MySQL is up (the database
# container initializes in parallel and restarts once during first setup).
php /usr/local/bin/webfront-init.php &

# Periodically refresh the selfoss sources. Set SELFOSS_UPDATE_INTERVAL=0
# to disable (e.g. when you trigger updates from selfoss itself).
if [ "${SELFOSS_UPDATE_INTERVAL}" -gt 0 ] 2>/dev/null; then
    (
        sleep "${SELFOSS_UPDATE_INTERVAL}"
        while true; do
            php /var/www/html/cliupdate.php || true
            sleep "${SELFOSS_UPDATE_INTERVAL}"
        done
    ) &
fi

exec apache2-foreground
