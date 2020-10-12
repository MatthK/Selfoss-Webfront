<?php
include("includes/constants.php");

if (isset($_GET['t']))
{
   $tag  = $_GET['t'];
} else {
   $tag = 'world';
}

$rSet = array();

$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$query  = $mysqli->prepare("SELECT DISTINCT S.id, S.title, C.content, S.updatetime, S.tags, C.link, O.title AS 'source', C.author FROM (SELECT HTML_UnEncode(I.title) as 'Title', MIN(I.datetime) AS 'UpdateTime', CASE WHEN LOCATE(',', GROUP_CONCAT(S.tags)) > 0 THEN LEFT(GROUP_CONCAT(S.tags), LOCATE(',', GROUP_CONCAT(S.tags))-1) ELSE GROUP_CONCAT(S.tags) END AS 'Tags', MIN(I.id) AS 'id' FROM items I INNER JOIN sources S ON I.source = S.id WHERE (I.unread = 1 OR I.starred = 1) GROUP BY HTML_UnEncode(I.title)) S INNER JOIN items C ON S.Title = HTML_UnEncode(C.title) AND S.UpdateTime = C.DateTime INNER JOIN sources O ON C.source = O.id WHERE S.Tags = ? AND C.Content <> '[unable to retrieve full-text content]' ORDER BY UpdateTime DESC LIMIT 15");
$query->bind_param("s", $tag);
$query->execute();
$result = $query->get_result();
while($row = mysqli_fetch_assoc($result)){
   $rSet[] = $row;
}
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
    <title><?php echo $npName ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/bootstrap-4.5.2-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="icon" href="assets/ico/favicon.ico">
    <script src="assets/js/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="assets/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <meta name="theme-color" content="#563d7c">
    <style>
      .bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
      @media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; } }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=UnifrakturMaguntia&display=swap" rel="stylesheet">    
    <link href="/assets/css/blog.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
<?php include("includes/news_header.php"); ?>
      <!-- top row start -->
      <div class="row mb-4">
        <!-- Header left start -->
        <div class="col-md-6">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-500 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <div><small><a href="<?php echo $rSet[0]["link"]; ?>l" target="_blank"><span><?php echo $rSet[0]["source"]; ?></span></a> - <span class="mb-1 text-muted"><?php echo $rSet[0]["updatetime"]; ?> - <?php echo $rSet[0]["author"] ?></span></small></div>
              <h2 class="mb-0"><a href="article.php?i=<?php echo $rSet[0]["id"]; ?>" class="text-dark"><?php echo $rSet[0]["title"]; ?></a></h2>
              <p>&nbsp;</p>
              <p class="card-text mb-auto"><?php echo $rSet[0]["content"]; ?></p>
            </div>
           </div>
          </div>
        </div>
        <!-- Header left end -->
        <!-- Header right start -->
        <div class="col-md-6">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-500 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <div><small><a href="<?php echo $rSet[1]["link"]; ?>l" target="_blank"><span><?php echo $rSet[1]["source"]; ?></span></a> - <span class="mb-1 text-muted"><?php echo $rSet[1]["updatetime"]; ?> - <?php echo $rSet[1]["author"] ?></span></small></div>
              <h2 class="mb-0"><a href="article.php?i=<?php echo $rSet[1]["id"]; ?>" class="text-dark"><?php echo $rSet[1]["title"]; ?></a></h2>
              <p>&nbsp;</p>
              <p class="card-text mb-auto"><?php echo $rSet[1]["content"]; ?></p>
            </div>
           </div>
          </div>
        </div>
        <!-- Header right end -->
      </div>
      <!-- top row end -->
      <!-- content rows start -->
      <div class="row mb-4">
        <!-- Content cards start -->
        <div class="col-md-9">
         <div id="tcontent">
<?php for ($i = 2; $i < count($rSet); $i++) { ?>        
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <div><small><a href="<?php echo $rSet[$i]["link"]; ?>" target="_blank"><span><?php echo $rSet[$i]["source"]; ?></span></a> - <span class="mb-1 text-muted"><?php echo $rSet[$i]["updatetime"]; ?> - <?php echo $rSet[$i]["author"] ?></span></small></div>
              <h2 class="mb-0"><a href="article.php?i=<?php echo $rSet[$i]["id"]; ?>" class="text-dark"><?php echo $rSet[$i]["title"]; ?></a></h2>
              <p>&nbsp;</p>
              <p class="card-text mb-auto"><?php echo $rSet[$i]["content"]; ?></p>
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
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body" id="onstr">Other news</strong>
              <div id="other<?php echo $tag; ?>news0"></div>
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
    <script language="JavaScript" type="text/javascript" src="assets/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js/news.js"></script>
    <script type="text/javascript">
       var imto  = <?php echo $imto ?>;
       var jTags = <?php echo $jTags; ?>
       var cNo   = 0;
       var cnt = 2;       
       var mar = 1;
       var tagName = jTags[jTags.findIndex(x => x.tag === '<?php echo strtolower($tag); ?>')].name;
       var cntNews = 0;
       
       $(document).ready(function(){
       
         getNews('other<?php echo $tag; ?>', 1024, <?php echo $artno; ?>, 'c='+cntNews+'&', 'tag', cntNews);
         setInterval(function() { getNews('other<?php echo $tag; ?>', 1024, <?php echo $artno; ?>, 'c='+cntNews+'&', 'tag', cntNews); }, <?php echo $artrf; ?> * 1000);

         setMenu('<?php echo $tag; ?>');

         $(window).on("scroll", function() {
           if (checkDBot('infscroll') && mar == 1) {
              // get more content
              mar = 0;
              cNo = cNo + 14;
              getInfTag(cNo, '<?php echo $tag ?>', cnt);
              cnt = cnt + 1;
           }
           if (checkDBot('other<?php echo $tag; ?>news'+cntNews)) {
              $('#newsgmc').show('slow');
           }
         });         
         
         $('body').on('click', '#newsgmc', function() {
            $('#newsgmc').hide('slow');
            cntNews += 1;
            getNews('other<?php echo $tag; ?>', 1024, <?php echo $artno; ?>, 'c='+cntNews+'&', 'tag', cntNews);
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
<?php include("includes/news_footer.php"); ?>
  </body>
</html>