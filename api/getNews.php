<?php
include("../includes/constants.php");

if (isset($_GET['t']))
{
   $tag  = $_GET['t'];
} else {
   $tag = "";
}
if (isset($_GET['r']))
{
   $nrec = $_GET['r'];
} else {
   $nrec = 15;
}
if (isset($_GET['c']))
{
   $cat = $_GET['c'];
} else {
  $cat = "";
}

$rSet = array();

$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
switch ($cat) {
  case "s":
      $query = $mysqli->prepare("SELECT DISTINCT S.id, S.Title, C.Content, S.UpdateTime, S.Tags, C.link, O.title AS 'Source' FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE (I.unread = 1 OR I.starred = 1) GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id WHERE O.id = ? AND C.Content <> '[unable to retrieve full-text content]' ORDER BY UpdateTime DESC LIMIT ?");
      $query->bind_param("ii", $tag, $nrec);
    break;
  default:
    if ($tag == "top") {
      $query = $mysqli->prepare("SELECT DISTINCT S.id, S.Title, C.Content, S.UpdateTime, S.Tags, C.link, O.title AS 'Source' FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE (I.unread = 1 OR I.starred = 1) GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id ORDER BY UpdateTime DESC LIMIT 5");
    } elseif (substr($tag, 0, 5) == "other") {
      $tag = substr($tag, 5, strlen($tag));
      $query = $mysqli->prepare("SELECT DISTINCT S.id, S.Title, C.Content, S.UpdateTime, S.Tags, C.link, O.title AS 'Source' FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE (I.unread = 1 OR I.starred = 1) GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id WHERE S.Tags <> ? AND C.Content <> '[unable to retrieve full-text content]' ORDER BY UpdateTime DESC LIMIT ?");
      $query->bind_param("si", $tag, $nrec);
    } else {
      $query = $mysqli->prepare("SELECT DISTINCT S.id, S.Title, C.Content, S.UpdateTime, S.Tags, C.link, O.title AS 'Source' FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE (I.unread = 1 OR I.starred = 1) GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id WHERE S.Tags = ? AND C.Content <> '[unable to retrieve full-text content]' ORDER BY UpdateTime DESC LIMIT ?");
      $query->bind_param("si", $tag, $nrec);
    }
}
$query->execute();
$result = $query->get_result();
while($row = mysqli_fetch_assoc($result)){
   $rSet[] = $row;
}
header("Content-Type: application/json");
echo json_encode($rSet);

$result -> free();
$mysqli -> close();
?>