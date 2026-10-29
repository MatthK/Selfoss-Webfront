<?php
include(__DIR__ . "/../includes/constants.php");

if (isset($_GET['i']))
{
   $id = (int) $_GET['i'];
} else {
   $id = 0;
}
if (isset($_GET['s']))
{
   $star  = $_GET['s'];
} else {
   $star = "";
}
header('Content-type: application/json');
$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
if ($star == "1") {
  $starqry = $mysqli->prepare("UPDATE items SET starred = 1 WHERE id = ?");
  $starqry->bind_param("i", $id);
  $starqry->execute();
  $result = $starqry->affected_rows;
  $starqry->close();
  if($result > 0){
      $response_array['status'] = 'success';
  }else {
      $response_array['status'] = 'error';
  }
} elseif ($star == "0") {
  $starqry = $mysqli->prepare("UPDATE items SET starred = 0 WHERE id = ?");
  $starqry->bind_param("i", $id);
  $starqry->execute();
  $result = $starqry->affected_rows;
  $starqry->close();
  if($result > 0){
      $response_array['status'] = 'success';
  }else {
      $response_array['status'] = 'error';
  }
} else {
  $getTitle = $mysqli->prepare("SELECT title FROM items WHERE id = ?");
  $getTitle->bind_param("i", $id);
  $getTitle->execute();
  $result = $getTitle->get_result();
  while($row = mysqli_fetch_assoc($result)){
     $title[] = $row;
  }
  $getTitle->close();
  if (isset($title[0]['title'])) {
    // Mark all items with the same title as read (duplicates across feeds/sources)
    $markRead = $mysqli->prepare("UPDATE items SET unread = 0 WHERE title = ?");
    $markRead->bind_param("s", $title[0]['title']);
    $markRead->execute();
    $result = $markRead->affected_rows;
    $markRead->close();
    if($result > 0){
        $response_array['status'] = 'success';
    }else {
        $response_array['status'] = 'error';
    }
  } else {
    $response_array['status'] = 'error';
  }
}
echo json_encode($response_array);
$mysqli -> close();
?>
