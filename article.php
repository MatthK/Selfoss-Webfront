<?php
include(__DIR__ . "/includes/constants.php");
// A user-supplied constants.php is bind-mounted over includes/constants.php
// in the Docker setup and may be an older file that does not include
// helpers.php - load the helper functions (esc, jsv, safe_url) regardless.
include_once(__DIR__ . "/includes/helpers.php");

if (isset($_GET['i']))
{
   $id  = (int) $_GET['i'];
} else {
   $id = 0;
}

$rSet = array();

$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$stmt = $mysqli->prepare("SELECT DISTINCT I.title, I.content, I.link, I.datetime as 'updatetime', I.author, S.title as 'source', S.tags, I.starred, S.id AS 'sid', I.unread FROM items I INNER JOIN sources S ON I.source = S.id WHERE I.id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
   $rSet[] = $row;
}
$stmt->close();
$result -> free();
$mysqli -> close();

if (count($rSet) == 0) {
   // No article with this id - treat as not found
   http_response_code(404);
   printf('<!doctype html><html lang="en"><head><meta charset="utf-8"><title>%s</title></head><body><h1>Article not found</h1><p>This article does not exist (anymore). It might have been marked as read and cleaned up.</p><p><a href="index.php">Back to the newspaper</a></p></body></html>', esc($npName));
   exit();
}

$article = $rSet[0];
$tagKey = searchKey(strtolower($article["tags"]), $tags);
$tag = ($tagKey !== false) ? $tags[$tagKey][0] : $article["tags"];
$artTag = strtolower($article["tags"]);
$artSid = (int) $article["sid"];

if ($article["starred"] == 0) {
  // article is not starred
  $class = "btn-secondary";
  $jstar = 1;
} else {
  $class = "btn-success";
  $jstar = 0;
}

function searchKey($id, $array) {
 foreach ($array as $key => $val) {
   if ($val[1] === $id) {
      return $key;
   }
 }
 return false;
}
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
      <div class="row mb-2">
        <div class="col-md-3 d-none d-sm-block">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo esc($artTag); ?>" class="text-body"><?php echo esc($tag); ?></a></strong>
              <div id="<?php echo esc($artTag) ?>news0"></div>
              <div id="newsgmc" style="display: none;">Show more</div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-3 d-flex flex-column position-static" id="article" aid="<?php echo (int) $id; ?>">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo esc($artTag); ?>" class="text-body"><?php echo esc($tag); ?></a></strong>
              <div class="d-flex mb-1 text-muted"><div class="w-100"><small><?php echo esc($article["source"]) ?> - <?php echo esc($article["updatetime"]) ?> - <?php echo esc($article["author"]) ?></small></div><div class="flex-shrink-1"><button type="button" class="justify-content-end btn <?php echo $class; ?> btn-sm" id="artstar" aid="<?php echo (int) $id; ?>">*</button></div></div>
              <h2 class="mb-0"><a href="<?php echo safe_url($article["link"]); ?>" class="text-dark" target="_blank" rel="noopener"><?php echo esc($article["title"]) ?></a></h2>
              <p>&nbsp;</p>
              <div class="card-text mb-auto"><?php echo $article["content"]; ?></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3 d-block d-sm-none">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><?php echo esc($article["tags"]) ?></strong>
              <div id="<?php echo esc($artTag) ?>newsm0"></div>
              <div id="newsmgmc" style="display: none;">Show more</div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-2 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><?php echo esc($article["source"]) ?></strong>
              <div id="newssrc0"></div>
              <div id="newssrcgmc" style="display: none;">Show more</div>
            </div>
           </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Toast start -->
    <div id="toast-wrapper" class="toast text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="8000" style="position: fixed; bottom: 5px; right: 5px;">
      <div class="toast-body lead p-2" id="toast-body"></div>
    </div>
    <!-- Toast end -->
    <script language="JavaScript" type="text/javascript" src="assets/js/news.js"></script>
    <script type="text/javascript">
       var jstar = <?php echo (int) $jstar ?>;
       var imto  = <?php echo (int) $imto ?>;
       var artTag = <?php echo jsv($artTag) ?>;
       var artSid = <?php echo (int) $artSid ?>;
       var cntNews = 0;
       var cntSrc = 0;

       $(document).ready(function(){

         var mar = <?php echo (int) $article["unread"] ?>;

         getNews(artTag, 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'article', cntNews);
         getNews(artSid, 1024, <?php echo (int) $artno; ?>, 'c=s'+cntSrc+'&', 'article', cntSrc);
         setInterval(function() { getNews(artTag, 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'article', cntNews); }, <?php echo (int) $artrf; ?> * 1000);
         setInterval(function() { getNews(artSid, 1024, <?php echo (int) $artno; ?>, 'c=s'+cntSrc+'&', 'article', cntSrc); }, <?php echo (int) $artrf; ?> * 1000);

         setMenu(artTag);

         if (checkDBot('article') && mar == 1) {
            setTimeout(function() { 
                let hid = $('#article').attr('aid');
                hideArticle(hid);
                mar = 0;
            }, <?php echo (int) $smar; ?> * 1000);
         }

         $(window).on("scroll", function() {
           if (checkDBot('article') && mar == 1) {
              // mark article as read when scrolled to bottom
              let hid = $('#article').attr('aid');
              hideArticle(hid);
              mar = 0; // don't trigger this again
           }
           if (checkDBot(artTag + 'news'+cntNews)) {
              $('#newsgmc').show('slow');
           }
           if (checkDBot(artTag + 'newsm'+cntNews)) {
              $('#newsmgmc').show('slow');
           }
           if (checkDBot('newssrc'+cntSrc)) {
              $('#newssrcgmc').show('slow');
           }

         });

         $('body').on('click', '#newsgmc', function() {
            $('#newsgmc').hide('slow');
            cntNews += 1;
            getNews(artTag, 1024, <?php echo (int) $artno; ?>, 'c='+cntNews+'&', 'article', cntNews);
         });
         $('body').on('click', '#newssrcgmc', function() {
            $('#newssrcgmc').hide('slow');
            cntSrc += 1;
            getNews(artSid, 1024, <?php echo (int) $artno; ?>, 'c=s'+cntSrc+'&', 'article', cntSrc);
         });

         $('body').on('click', '#errhide', function() {
            hideMsg('err');
         });

         $('body').on('click', '#artstar', function() {
            let hid = $(this).attr('aid');
            hideArticle(hid, jstar);
         });

         $('body').on('click', 'button', function() {
            $(this).off('click');
            if ($(this).attr('id') !== 'artstar') {
               let vid = $(this).attr('id');
               let hid = vid.substr(4,vid.length);
               hideArticle(hid);
            }
         });
         
       });

    </script>
<?php include(__DIR__ . "/includes/news_footer.php"); ?>
  </body>
</html>