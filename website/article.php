<?php
include("includes/constants.php");

if (isset($_GET['i']))
{
   $id  = $_GET['i'];
}  

$rSet = array();

$mysqli = new mysqli($dbserver, $username, $dbpwd, $database);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$query = "SELECT DISTINCT I.title, I.content, I.link, I.datetime as 'updatetime', I.author, S.title as 'source', S.tags, I.starred, S.id AS 'sid', I.unread FROM items I INNER JOIN sources S ON I.source = S.id WHERE I.id = " . $id;
$result = mysqli_query($mysqli, $query);
while($row = mysqli_fetch_assoc($result)){
   $rSet[] = $row;
}
$result -> free();
$mysqli -> close();
if ($rSet[0]["starred"] == 0) {
  // article is not starred
  $class = "btn-secondary";
  $jstar = 1;
} else {
  $class = "btn-success";
  $jstar = 0;
}
$tag = $tags[searchKey(strtolower($rSet[0]["tags"]),$tags)][0];

function searchKey($id, $array) {
 foreach ($array as $key => $val) {
   if (array_search($id,$val) != false) {
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
    <meta name="author" content="">
    <title><?php echo $npName ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/bootstrap-4.5.2-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="icon" href="assets/ico/favicon.ico">
    <script src="assets/js/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
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
      <!-- error row start -->
      <div class="row mb-4">
        <div class="col-md-12">
           <div id="errbox" class="mb-3 alert alert-danger" role="alert" style="display: none;">
             <div id="errmsg" class="w-100"></div>
             <div class="flex-shrink-1"><button type="button" class="justify-content-end btn btn-light btn-sm" id="errhide">close</button></div>
           </div>
        </div>
      </div>
      <!-- error row end -->
      <div class="row mb-4">
        <div class="col-md-3 d-none d-sm-block">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo strtolower($rSet[0]["tags"]); ?>" class="text-body"><?php echo $tag; ?></a></strong>
              <div id="<?php echo strtolower($rSet[0]["tags"]) ?>news"></div>
              <div id="errmsg3"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-3 d-flex flex-column position-static" id="article" aid="<?php echo $id; ?>">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo strtolower($rSet[0]["tags"]); ?>" class="text-body"><?php echo $tag; ?></a></strong>
              <div class="d-flex mb-1 text-muted"><div class="w-100"><small><?php echo $rSet[0]["source"] ?> - <?php echo $rSet[0]["updatetime"] ?> - <?php echo $rSet[0]["author"] ?></small></div><div class="flex-shrink-1"><button type="button" class="justify-content-end btn <?php echo $class; ?> btn-sm" id="artstar" aid="<?php echo $id; ?>">*</button></div></div>
              <h2 class="mb-0"><?php echo $rSet[0]["title"] ?></h2>
              <p>&nbsp;</p>
              <p class="card-text mb-auto"><?php echo $rSet[0]["content"]; ?></p>
              <p><a href="<?php echo $rSet[0]["link"]; ?>" target="_blank">Link to the full article</a></p>
              <!-- info row start -->
              <div id="infobox" class="mb-3 alert alert-primary invisible" role="alert">
                <div id="infomsg" class="w-100"></div>
                <div class="flex-shrink-1"><button type="button" class="justify-content-end btn btn-light btn-sm" id="infohide">close</button></div>
              </div>
              <!-- info row end -->
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3 d-block d-sm-none">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><?php echo $rSet[0]["tags"] ?></strong>
              <div id="<?php echo strtolower($rSet[0]["tags"]) ?>news2"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><?php echo $rSet[0]["source"] ?></strong>
              <div id="newssrc"></div>
            </div>
           </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="toast bg-primary text-white p-3" role="alert" aria-live="assertive" aria-atomic="true" data-delay="8000" style="position: fixed; bottom: 5px; right: 5px;">
      <div class="toast-body lead" id="toast-body"></div>
    </div>    
    
    <script language="JavaScript" type="text/javascript" src="assets/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js/news.js"></script>
    <script type="text/javascript">
       var jstar = <?php echo $jstar ?>;
       var imto  = <?php echo $imto ?>;
       
       $(document).ready(function(){
       
         var mar = <?php echo $rSet[0]["unread"] ?>;
       
         getNews('<?php echo strtolower($rSet[0]["tags"]); ?>', 1024, <?php echo $artno; ?>, '', 'article');
         getNews('<?php echo strtolower($rSet[0]["sid"]); ?>', 1024, <?php echo $artno; ?>, 'c=s&', 'article');
         setInterval(function() { getNews('<?php echo strtolower($rSet[0]["tags"]); ?>', 1024, <?php echo $artno; ?>, '', 'article'); }, <?php echo $artrf; ?> * 1000);
         setInterval(function() { getNews('<?php echo strtolower($rSet[0]["sid"]); ?>', 1024, <?php echo $artno; ?>, 'c=s&', 'article'); }, <?php echo $artrf; ?> * 1000);

         var scrollPosition = $(window).height() + $(window).scrollTop();
         var divBottom = $('#article').outerHeight() + $('#article').position().top;

         setMenu('<?php echo strtolower($rSet[0]["tags"]); ?>');

         if (scrollPosition >= divBottom && mar == 1) {
            setTimeout(function() { 
                let hid = $('#article').attr('aid');
                hideArticle(hid);
                mar = 0;
                showMsg('info','Article has been marked as read',<?php echo $imto; ?>)
            }, <?php echo $smar; ?> * 1000);
         }
         
         $(window).on("scroll", function() {
           var scrollPosition = $(window).height() + $(window).scrollTop();
           var divBottom = $('#article').outerHeight() + $('#article').position().top;
           if (scrollPosition >= divBottom && mar == 1) {
              // mark article as read when scrolled to bottom
              let hid = $('#article').attr('aid');
              hideArticle(hid);
              mar = 0; // don't trigger this again
              showMsg('info','Article has been marked as read',15)
           }
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
<?php include("includes/news_footer.php"); ?>
  </body>
</html>