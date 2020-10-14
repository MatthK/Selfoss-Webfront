      <!-- Only show on mobile -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
        <a class="navbar-brand" href="index.php"><?php echo $npName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#srxfrm" aria-controls="srxfrm" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="srxfrm">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <small><span>Last refreshed on </span><span id="lastrfm"><?php echo date("d.m.Y H:i:s") ?></span></small>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" id="srx" method="post" action="search.php">
            <input class="form-control-sm mr-sm-2" id="search" name="s" type="search" placeholder="search" tabindex="10" value="" />&nbsp;
            <button type="submit" class="btn btn-dark btn-sm my-2 my-sm-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg></button>
          </form>
        </div>
      </nav>
      <!-- Do not show on mobile -->
      <header class="blog-header py-3 d-none d-md-block">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-3 pt-1">
            <small><span class="d-none d-sm-block">Last refreshed on </span><span id="lastrf"><?php echo date("d.m.Y H:i:s") ?></span></small>
          </div>
          <div class="col-6 text-center">
            <a class="<?php echo $font; ?> text-dark" href="index.php"><?php echo $npName ?></a>
          </div>
          <div class="col-3 d-flex justify-content-end align-items-center">
            <form class="form-inline" id="srx" method="post" action="search.php">
              <input class="form-control-sm" id="search" name="s" type="text"  tabindex="10" value="" />&nbsp;
              <button type="submit" class="btn btn-dark btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg></button>
            </form>
          </div>
        </div>
      </header>
      <!-- Show all -->
      <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
          <a id="menu<?php echo $tags[0][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[0][1] ?>"><?php echo $tags[0][0] ?></a>
          <a id="menu<?php echo $tags[1][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[1][1] ?>"><?php echo $tags[1][0] ?></a>
          <a id="menu<?php echo $tags[2][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[2][1] ?>"><?php echo $tags[2][0] ?></a>
          <a id="menu<?php echo $tags[3][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[3][1] ?>"><?php echo $tags[3][0] ?></a>
          <a id="menu<?php echo $tags[4][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[4][1] ?>"><?php echo $tags[4][0] ?></a>
          <a id="menu<?php echo $tags[5][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[5][1] ?>"><?php echo $tags[5][0] ?></a>
          <a id="menu<?php echo $tags[6][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[6][1] ?>"><?php echo $tags[6][0] ?></a>
          <a id="menu<?php echo $tags[7][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[7][1] ?>"><?php echo $tags[7][0] ?></a>
          <a id="menu<?php echo $tags[8][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[8][1] ?>"><?php echo $tags[8][0] ?></a>
          <a id="menu<?php echo $tags[9][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[9][1] ?>"><?php echo $tags[9][0] ?></a>
          <a id="menu<?php echo $tags[10][1] ?>" class="p-2 text-muted" href="tag.php?t=<?php echo $tags[10][1] ?>"><?php echo $tags[10][0] ?></a>
        </nav>
      </div>