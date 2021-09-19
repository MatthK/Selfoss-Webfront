<?php
include("includes/constants.php");

$sql = <<<EOS
    CREATE FUNCTION `HTML_UnEncode`(X VARCHAR(1024)) RETURNS VARCHAR(1024) CHARSET utf8mb4 DETERMINISTIC
    BEGIN 

    DECLARE TextString VARCHAR(1024) CHARSET utf8mb4 ; 
    SET TextString = X ; 

    #quotation mark 
    IF INSTR( X , '&quot;' ) 
    THEN SET TextString = REPLACE(TextString, '&quot;','"') ; 
    END IF ; 

    #apostrophe  
    IF INSTR( X , '&apos;' ) 
    THEN SET TextString = REPLACE(TextString, '&apos;','"') ; 
    END IF ; 

    #ampersand 
    IF INSTR( X , '&amp;' ) 
    THEN SET TextString = REPLACE(TextString, '&amp;','&') ; 
    END IF ; 

    #less-than 
    IF INSTR( X , '&lt;' ) 
    THEN SET TextString = REPLACE(TextString, '&lt;','<') ; 
    END IF ; 

    #greater-than 
    IF INSTR( X , '&gt;' ) 
    THEN SET TextString = REPLACE(TextString, '&gt;','>') ; 
    END IF ; 

    #non-breaking space 
    IF INSTR( X , '&nbsp;' ) 
    THEN SET TextString = REPLACE(TextString, '&nbsp;',' ') ; 
    END IF ; 

    IF INSTR( X , '&#39;' ) 
    THEN SET TextString = REPLACE(TextString, '&#39;','''') ; 
    END IF ; 

    RETURN TextString ; 

    END;
    
EOS;
$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if (!$mysqli->query("DROP FUNCTION IF EXISTS `HTML_UnEncode`") ||
    !$mysqli->query($sql)) {
    echo "Function creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
} else {
    echo "Function created";
}

?>