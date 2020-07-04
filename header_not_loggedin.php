<?php
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-dark bg-dark" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="" style="color:white;"><img src="assets/img/logo.png" width="22px"/></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item nav-text">
              <a class="nav-link js-scroll-trigger" href="index.php" style="color:white;font-size:13px;">Home</a>
            </li>

            <li class="nav-item nav-text">
              <a class="nav-link js-scroll-trigger" href="login.php" style="color:white;font-size:13px;">Login</a>
            </li>

            <li class="nav-item nav-text">
              <a class="btn nav-text js-scroll-trigger" role="button" style="color:white;font-size:13px;" id="navSearchBtn"><i class="fa fa-search"></i></a>
            </li>

            <li class="nav-item ml-4 nav-search" style="display:none;line-height:100%">
              <form action="search_result.php" method="get" class="form-inline" style="float:left">
                <div class="input-group col-md-12">
                  <input type="text" name="s_q" id="" class="form-control" placeholder="Search" style=""> 
                  <div class="input-group-append">
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>                   
                  </div>
                </div>
                
              </form>
              <a class="btn nav-link js-scroll-trigger" role="button"  style="float:right;color:white" id="searchCancel">
                  <i class="fa fa-times"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>




    