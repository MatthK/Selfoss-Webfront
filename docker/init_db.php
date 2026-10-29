<?php
/**
 * Installs the HTML_UnEncode function the webfront queries rely on.
 * Runs at container start and retries until MySQL is reachable.
 *
 * Reads the SQL definition from /var/www/webfront/db/HTML_UnEncode.sql
 * (single source of truth, same file used for manual installations).
 */

const SQL_FILE = "/var/www/webfront/db/HTML_UnEncode.sql";
const MAX_ATTEMPTS = 60; // ~5 minutes at 5s intervals

$dbserver = getenv("SWF_DB_HOST") ?: "localhost";
$database = getenv("SWF_DB_NAME") ?: "selfoss";
$username = getenv("SWF_DB_USER") ?: "selfoss";
$dbpwd    = getenv("SWF_DB_PASSWORD") ?: "secretPassword";

$sql = file_get_contents(SQL_FILE);
if ($sql === false) {
    fwrite(STDERR, "webfront-init: cannot read " . SQL_FILE . "\n");
    exit(1);
}

for ($attempt = 1; $attempt <= MAX_ATTEMPTS; $attempt++) {
    $mysqli = @new mysqli($dbserver, $username, $dbpwd, $database);
    if ($mysqli->connect_errno) {
        fwrite(STDERR, "webfront-init: database not ready yet ({$mysqli->connect_error}), retrying...\n");
        sleep(5);
        continue;
    }

    $mysqli->query("DROP FUNCTION IF EXISTS `HTML_UnEncode`");

    // Split away the mysql-cli-only DELIMITER statements, then execute the
    // routine definitions (terminated by $$) as single statements.
    $sqlClean = preg_replace("/^\s*DELIMITER.*$/m", "", $sql);
    $statements = explode("$$", $sqlClean);
    $ok = true;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if ($statement === "") {
            continue;
        }
        if (!$mysqli->query($statement)) {
            fwrite(STDERR, "webfront-init: statement failed: (" . $mysqli->errno . ") " . $mysqli->error . "\n");
            $ok = false;
        }
    }
    $mysqli->close();

    if ($ok) {
        echo "webfront-init: HTML_UnEncode function installed\n";
        exit(0);
    }
    sleep(5);
}

fwrite(STDERR, "webfront-init: giving up after " . MAX_ATTEMPTS . " attempts\n");
exit(1);
