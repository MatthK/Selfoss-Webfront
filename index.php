<?php
include("includes/constants.php");
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
      <!-- top start -->
      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-10 px-0">
          <div><small><a id="<?php echo $tags[11][1] ?>link" href="<?php echo $tags[11][1] ?>" class="text-white" target="_blank"><span id="<?php echo $tags[11][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[11][1] ?>updatetime"></span></small></div>
          <h1 class="display-4 font-italic"><a href="#" id="<?php echo $tags[11][1] ?>title" class="text-white"></a></h1>
          <p class="lead my-3" id="<?php echo $tags[11][1] ?>content"></p>
          <p class="lead mb-0"><a id="<?php echo $tags[11][1] ?>id" href="#" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
      </div>
      <!-- top end -->
      <!-- Cat 1-4 start -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo $tags[0][1] ?>" class="text-body"><?php echo $tags[0][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[0][1] ?>link" href="<?php echo $tags[0][1] ?>" target="_blank"><span id="<?php echo $tags[0][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[0][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[0][1] ?>title" class="text-dark"></a></h4>
              <p class="card-text mb-auto" id="<?php echo $tags[0][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-danger"><a href="tag.php?t=<?php echo $tags[1][1] ?>" class="text-danger"><?php echo $tags[1][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[1][1] ?>link" href="<?php echo $tags[1][1] ?>" target="_blank"><span id="<?php echo $tags[1][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[1][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[1][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[1][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-success"><a href="tag.php?t=<?php echo $tags[2][1] ?>" class="text-success"><?php echo $tags[2][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[2][1] ?>link" href="<?php echo $tags[2][1] ?>" target="_blank"><span id="<?php echo $tags[2][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[2][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[2][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[2][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary"><a href="tag.php?t=<?php echo $tags[3][1] ?>" class="text-primary"><?php echo $tags[3][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[3][1] ?>link" href="<?php echo $tags[3][1] ?>" target="_blank"><span id="<?php echo $tags[3][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[3][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[3][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[3][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
      </div>
      <!-- Cat 1-4 end -->
      <!-- Cat 5-8 start -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo $tags[4][1] ?>" class="text-body"><?php echo $tags[4][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[4][1] ?>link" href="<?php echo $tags[4][1] ?>" target="_blank"><span id="<?php echo $tags[4][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[4][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[4][1] ?>title" class="text-dark"></a></h4>
              <p class="card-text mb-auto" id="<?php echo $tags[4][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-danger"><a href="tag.php?t=<?php echo $tags[5][1] ?>" class="text-danger"><?php echo $tags[5][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[5][1] ?>link" href="<?php echo $tags[5][1] ?>" target="_blank"><span id="<?php echo $tags[5][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[5][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[5][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[5][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-success"><a href="tag.php?t=<?php echo $tags[6][1] ?>" class="text-success"><?php echo $tags[6][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[6][1] ?>link" href="<?php echo $tags[6][1] ?>" target="_blank"><span id="<?php echo $tags[6][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[6][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[6][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[6][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-400 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary"><a href="tag.php?t=<?php echo $tags[7][1] ?>" class="text-primary"><?php echo $tags[7][0] ?></a></strong>
              <div><small><a id="<?php echo $tags[7][1] ?>link" href="<?php echo $tags[7][1] ?>" target="_blank"><span id="<?php echo $tags[7][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[7][1] ?>updatetime"></span></small></div>
              <h4 class="mb-0"><a href="#" id="<?php echo $tags[7][1] ?>title" class="text-dark"></a></h4>
              <p class="mb-auto" id="<?php echo $tags[7][1] ?>content"></p>
            </div>
           </div>
          </div>
        </div>
      </div>
      <!-- Cat 5-8 end -->
      <!-- Cat 1-4 list start -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo $tags[0][1] ?>" class="text-body"><?php echo $tags[0][0] ?></a></strong>
              <div id="<?php echo $tags[0][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-danger"><a href="tag.php?t=<?php echo $tags[1][1] ?>" class="text-danger"><?php echo $tags[1][0] ?></a></strong>
              <div id="<?php echo $tags[1][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-success"><a href="tag.php?t=<?php echo $tags[2][1] ?>" class="text-success"><?php echo $tags[2][0] ?></a></strong>
              <div id="<?php echo $tags[2][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary"><a href="tag.php?t=<?php echo $tags[3][1] ?>" class="text-primary"><?php echo $tags[3][0] ?></a></strong>
              <div id="<?php echo $tags[3][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
      </div>
      <!-- Cat 1-4 list end -->
      <!-- Cat 5-6 list start -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-body"><a href="tag.php?t=<?php echo $tags[4][1] ?>" class="text-body"><?php echo $tags[4][0] ?></a></strong>
              <div id="<?php echo $tags[4][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-danger"><a href="tag.php?t=<?php echo $tags[5][1] ?>" class="text-danger"><?php echo $tags[5][0] ?></a></strong>
              <div id="<?php echo $tags[5][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-success"><a href="tag.php?t=<?php echo $tags[6][1] ?>" class="text-success"><?php echo $tags[6][0] ?></a></strong>
              <div id="<?php echo $tags[6][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
           <div class="row no-gutters overflow-hidden flex-md-row mb-4 position-relative">
            <div class="col p-2 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary"><a href="tag.php?t=<?php echo $tags[7][1] ?>" class="text-primary"><?php echo $tags[7][0] ?></a></strong>
              <div id="<?php echo $tags[7][1] ?>news0"></div>
            </div>
           </div>
          </div>
        </div>
      </div>
      <!-- Cat 5-6 list end -->
    </div><!-- end container -->
    <!-- Three categories with one full article -->
    <main role="main" class="container">
      <!-- Category 8 -->
      <div class="row">
        <div class="col-md-12 blog-main">
          <h3 class="pb-4 mb-4 font-italic border-bottom alert-primary">
            <a href="tag.php?t=<?php echo $tags[8][1] ?>" class="text-primary"><?php echo $tags[8][0] ?></a>
          </h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 blog-main">
          <div class="blog-post">
            <div><small><a id="<?php echo $tags[8][1] ?>link" href="#"><span id="<?php echo $tags[8][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[8][1] ?>updatetime"></span></small></div>
            <h2 class="blog-post-title"><a href="#" id="<?php echo $tags[8][1] ?>title" class="text-dark"></a></h2>
            <p id="<?php echo $tags[8][1] ?>content"></p>
          </div><!-- /.blog-post -->
        </div>
        <div class="col-md-4 blog-main">
          <div id="<?php echo $tags[8][1] ?>news0"></div>
        </div>
      </div>
      <!-- Category 10 -->
      <div class="row">
        <div class="col-md-12 blog-main">
          <h3 class="pb-4 mb-4 font-italic border-bottom alert-secondary">
            <a href="tag.php?t=<?php echo $tags[10][1] ?>" class="text-secondary"><?php echo $tags[10][0] ?></a>
          </h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 blog-main">
          <div class="blog-post">
            <div><small><a id="<?php echo $tags[10][1] ?>link" href="#"><span id="<?php echo $tags[10][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[10][1] ?>updatetime"></span></small></div>
            <h2 class="blog-post-title"><a href="#" id="<?php echo $tags[10][1] ?>title" class="text-dark"></a></h2>
            <p id="<?php echo $tags[10][1] ?>content"></p>
          </div><!-- /.blog-post -->
        </div>
        <div class="col-md-4 blog-main">
          <div id="<?php echo $tags[10][1] ?>news0"></div>
        </div>
      </div>
      <!-- Category 9 -->
      <div class="row">
        <div class="col-md-12 blog-main">
          <h3 class="pb-4 mb-4 font-italic border-bottom alert-success">
            <a href="tag.php?t=<?php echo $tags[9][1] ?>" class="text-success"><?php echo $tags[9][0] ?></a>
          </h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 blog-main">
          <div class="blog-post">
            <div><small><a id="<?php echo $tags[9][1] ?>link" href="#"><span id="<?php echo $tags[9][1] ?>source"></span></a> - <span class="mb-1 text-muted" id="<?php echo $tags[9][1] ?>updatetime"></span></small></div>
            <h2 class="blog-post-title"><a href="#" id="<?php echo $tags[9][1] ?>title" class="text-dark"></a></h2>
            <p id="<?php echo $tags[9][1] ?>content"></p>
          </div><!-- /.blog-post -->
        </div>
        <div class="col-md-4 blog-main">
          <div id="<?php echo $tags[9][1] ?>news0"></div>
        </div>
      </div><!-- /.blog-main -->
    </main><!-- /.container -->
    <!-- Toast start -->    
    <div id="toast-wrapper" class="toast text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="8000" style="position: fixed; bottom: 5px; right: 5px;">
      <div class="toast-body lead p-2" id="toast-body"></div>
    </div>    
    <!-- Toast end -->    
    <!-- Placed at the end of the document so the pages load faster -->
    <script language="JavaScript" type="text/javascript" src="assets/js/news.js"></script>
    <script type="text/javascript">
       var imto  = <?php echo $imto ?>;
       var jTags = <?php echo $jTags; ?>
       var cntNews = 0;
         
       $(document).ready(function(){

         jTags.forEach(function(aRec) {
            getNews(aRec.tag, aRec.mlen, aRec.nrec, 'c='+cntNews+'&', 'news', cntNews);
            setInterval(function() { getNews(aRec.tag, aRec.mlen, aRec.nrec, 'c='+cntNews+'&', 'news', cntNews); }, aRec.itv * 1000);
         });
       });

       $('body').on('click', 'button', function(){
          $(this).off('click');
          let vid = $(this).attr('id');
          let hid = vid.substr(4,vid.length);
          hideArticle(hid);
       });

    </script>
<?php include("includes/news_footer.php"); ?>
  </body>
</html>