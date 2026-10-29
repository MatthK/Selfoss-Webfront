<?php
/**
 * Installs the HTML_UnEncode function the webfront queries rely on.
 * Runs at container start and retries until MySQL is reachable.
 *
 * Reads the SQL definition from /var/www/webfront/db/HTML_UnEncode.sql
 * (single source of truth, same file used for manual installations).
 *
 * Tolerates databases where the function already exists but is owned by
 * another user (e.g. created with the root account in a pre-existing
 * installation): MySQL refuses to let us drop it, so the existing
 * function is kept and used as-is.
 */

const SQL_FILE = "/var/www/webfront/db/HTML_UnEncode.sql";
const MAX_ATTEMPTS = 60; // ~5 minutes at 5s intervals

$dbserver = getenv("SWF_DB_HOST") ?: "localhost";
$database = getenv("SWF_DB_NAME") ?: "selfoss";
$username = getenv("SWF_DB_USER") ?: "selfoss";
$dbpwd    = getenv("SWF_DB_PASSWORD") ?: "secretPassword";

function connect($dbserver, $username, $dbpwd, $database) {
    // PHP 8+ mysqli throws on connection failure, so use try/catch here
    try {
        $mysqli = @new mysqli($dbserver, $username, $dbpwd, $database);
        return $mysqli;
    } catch (mysqli_sql_exception $e) {
        return false;
    }
}

function functionExists($mysqli, $database) {
    $query = $mysqli->prepare(
        "SELECT ROUTINE_NAME FROM information_schema.ROUTINES " .
        "WHERE ROUTINE_SCHEMA = ? AND ROUTINE_NAME = 'HTML_UnEncode' AND ROUTINE_TYPE = 'FUNCTION'");
    $query->bind_param("s", $database);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $query->close();
    return $row !== null;
}

$sql = file_get_contents(SQL_FILE);
if ($sql === false) {
    fwrite(STDERR, "webfront-init: cannot read " . SQL_FILE . "\n");
    exit(1);
}

$mysqli = false;
for ($attempt = 1; $attempt <= MAX_ATTEMPTS; $attempt++) {
    $mysqli = connect($dbserver, $username, $dbpwd, $database);
    if ($mysqli !== false && $mysqli->connect_errno == 0) {
        break;
    }
    if ($attempt == MAX_ATTEMPTS) {
        fwrite(STDERR, "webfront-init: giving up, database is not reachable\n");
        exit(1);
    }
    fwrite(STDERR, "webfront-init: database not ready yet, retrying...\n");
    sleep(5);
}

// Drop the old function so the (possibly fixed) definition can be installed.
// If we may not drop it (function created by an admin user, MySQL >= 8.0.16
// protects root-defined routines) but it still exists, keep and use it.
try {
    $mysqli->query("DROP FUNCTION IF EXISTS `HTML_UnEncode`");
} catch (mysqli_sql_exception $e) {
    // ignored, existence is checked below
}

if (functionExists($mysqli, $database)) {
    echo "webfront-init: HTML_UnEncode function already exists (owned by another user) - using it as-is.\n";
    echo "webfront-init: to refresh it with the current definition, run as DB admin:\n";
    echo "webfront-init:   DROP FUNCTION " . $database . ".HTML_UnEncode;\n";
    echo "webfront-init: then restart this container.\n";
    $mysqli->close();
    exit(0);
}

// Split away the mysql-cli-only DELIMITER statements, then execute the
// routine definitions (terminated by $$) as single statements.
$sqlClean = preg_replace("/^\s*DELIMITER.*$/m", "", $sql);
$statements = explode("$$", $sqlClean);
$ok = true;
$lastError = "";
foreach ($statements as $statement) {
    $statement = trim($statement);
    if ($statement === "") {
        continue;
    }
    try {
        if (!$mysqli->query($statement)) {
            $ok = false;
            $lastError = "(" . $mysqli->errno . ") " . $mysqli->error;
        }
    } catch (mysqli_sql_exception $e) {
        $ok = false;
        $lastError = "(" . $e->getCode() . ") " . $e->getMessage();
    }
}

if ($ok && functionExists($mysqli, $database)) {
    echo "webfront-init: HTML_UnEncode function installed\n";
    $mysqli->close();
    exit(0);
}

fwrite(STDERR, "webfront-init: could not create the HTML_UnEncode function: " . $lastError . "\n");
fwrite(STDERR, "webfront-init: the webfront needs this function. Either\n");
fwrite(STDERR, "webfront-init:  - grant the database user CREATE ROUTINE (and ALTER ROUTINE) on the " . $database . " database, or\n");
fwrite(STDERR, "webfront-init:  - create the function once manually as DB admin using db/HTML_UnEncode.sql\n");
if (strpos($lastError, "1419") !== false || stripos($lastError, "binary logging") !== false) {
    fwrite(STDERR, "webfront-init: note: with binary logging enabled, non-admin users can only create\n");
    fwrite(STDERR, "webfront-init: functions when log_bin_trust_function_creators=1 is set (or binlogging is disabled).\n");
}
$mysqli->close();
exit(1);
