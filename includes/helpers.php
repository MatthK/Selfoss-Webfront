<?php

/**
 * Output-escaping helpers used by all pages. Include via constants.php.
 */

/** HTML-escape a value for safe embedding into HTML text or attributes. */
function esc($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, "UTF-8");
}

/** JSON-encode a value for safe embedding into a JavaScript string literal. */
function jsv($value) {
    return json_encode((string) $value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
}

/** Only allow http(s), relative and fragment URLs as link targets. */
function safe_url($url) {
    $url = trim((string) $url);
    if (preg_match("~^(https?://|/|#)~i", $url) === 1) {
        return esc($url);
    }
    return "#";
}
