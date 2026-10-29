<?php
include(__DIR__ . "/includes/constants.php");

if (isset($_POST['s']))
{
   $srx  = (string) $_POST['s'];
} else {
   $srx = '';
}
$rSet = array();

$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
if (substr($srx, 0, 1) == '"') {
   $src = str_replace('"', '', $srx);
   $src = "%" . $src . "%";
} else {
   $src = str_replace(" ", "%", $srx);
   $src = "%" . $src . "%";
}
/* Get the first 15 search results */
$query = $mysqli->prepare("SELECT DISTINCT S.id, S.Title, C.Content, S.UpdateTime, S.Tags, C.link, O.title AS 'Source', C.author FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE I.title LIKE ? OR I.content LIKE ? GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id ORDER BY UpdateTime DESC LIMIT 15");
$query->bind_param("ss", $src, $src);
$query->execute();
$result = $query->get_result();
while($row = mysqli_fetch_assoc($result)){
   $rSet[] = $row;
}
$result -> free();
/* Get the number of articles */
$query = $mysqli->prepare("SELECT COUNT(DISTINCT S.id) AS NoRec FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE I.title LIKE ? OR I.content LIKE ? GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id");
$query->bind_param("ss", $src, $src);
$query->execute();
$result = $query->get_result();
$row = mysqli_fetch_assoc($result);
$NoRec = $row;
$result -> free();
$mysqli -> close();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A personalized newspaper based on Selfoss feed">
    <meta name="author" content="Matthias Karl">
    <title><?php echo esc($npName) ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="icon" href="assets/ico/favicon.ico">
    <script src="assets/js/jquery-3.7.1.min.js" integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs" crossorigin="anonymous"></script>
    <script src="assets/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <meta name="theme-color" content="#563d7c">
    <style>
      .bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
      @media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; } }
    </style>
    <!-- Custom styles for this template -->
    <link href="assets/fonts/fonts.css" rel="stylesheet">    
    <link href="/assets/css/blog.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
<?php include(__DIR__ . "/includes/news_header.php"); ?>
      <!-- content rows start -->
      <div class="row mb-2">
        <!-- Content cards start -->
        <div class="col-md-9">
         <div id="tcontent">
<?php if (count($rSet) == 0) { ?>
          <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <h2 class="mb-0">Search term <?php echo esc($srx) ?> found no records</h2>
            </div>
           </div>
          </div>
<?php } else { ?>
          <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-1 d-flex flex-column position-static">
              <p>A total of <?php echo (int) $NoRec["NoRec"]; ?> records match your search criteria</p>
            </div>
          </div>
<?php } ?>
<?php for ($i = 0; $i < count($rSet); $i++) { ?>
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 h-md-250 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <div><small><a href="<?php echo safe_url($rSet[$i]["link"]); ?>" target="_blank" rel="noopener"><span><?php echo esc($rSet[$i]["Source"]); ?></span></a> - <span class="mb-1 text-muted"><?php echo esc($rSet[$i]["UpdateTime"]); ?> - <?php echo esc($rSet[$i]["author"]) ?></span></small></div>
              <h2 class="mb-0"><a href="article.php?i=<?php echo (int) $rSet[$i]["id"]; ?>" class="text-dark"><?php echo esc($rSet[$i]["Title"]); ?></a></h2>
              <p>&nbsp;</p>
              <p class="card-text mb-auto"><?php echo $rSet[$i]["Content"]; ?></p>
            </div>
           </div>
          </div>
<?php } ?>
         </div>
         <div id="tcontent2">
         </div>
         <div id="infscroll"></div>
        </div>
        <!-- Content cards end -->
        <!-- Other news start -->
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body" id="onstr">Other news</strong>
              <div id="news0"></div>
              <div id="newsgmc" style="display: none;">Show more</div>
            </div>
           </div>
          </div>
        </div>
        <!-- Other news right end -->
      </div>
      <!-- content rows end -->
    </div>
    <!-- Toast start -->    
    <div id="toast-wrapper" class="toast text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="8000" style="position: fixed; bottom: 5px; right: 5px;">
      <div class="toast-body lead p-2" id="toast-body"></div>
    </div>    
    <!-- Toast end -->
    <script language="JavaScript" type="text/javascript" src="assets/js/news.js"></script>
    <script type="text/javascript">
       var imto  = <?php echo (int) $imto ?>;
       var jTags = <?php echo json_encode($jTags, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
       var srxTerm = <?php echo jsv($srx) ?>;
       var cNo   = 0;
       var cnt = 2;
       var mar = 1;
       var cntNews = 0;

       $(document).ready(function(){

         getNews('', 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'srx', cntNews);
         setInterval(function() { getNews('', 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'srx', cntNews); }, <?php echo (int) $artrf; ?> * 1000);

         $(window).on("scroll", function() {
           if (checkDBot('infscroll') && mar == 1) {
              // get more content
              mar = 0;
              cNo = cNo + 14;
              getInfTag(cNo, 'srx' + srxTerm, cnt);
              cnt = cnt + 1;
           }
           if (checkDBot('news'+cntNews)) {
              $('#newsgmc').show('slow');
           }
         });

         $('body').on('click', '#newsgmc', function() {
            $('#newsgmc').hide('slow');
            cntNews += 1;
            getNews('', 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'srx', cntNews);
         });
         $('body').on('click', '#errhide', function() {
            hideMsg('err');
         });

         $('body').on('click', 'button', function() {
            $(this).off('click');
            let vid = $(this).attr('id');
            let hid = vid.substr(4,vid.length);
            hideArticle(hid);
         });
         
       });
    </script>
<?php include(__DIR__ . "/includes/news_footer.php"); ?>
  </body>
</html>