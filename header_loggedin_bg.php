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
              <a href="index.php" class="nav-link js-scroll-trigger" href="" style="color:white;font-size:13px;">Home</a>
            </li>
            <li class="nav-item nav-text">
              <a href="my_subscriptions.php" class="nav-link js-scroll-trigger" href="" style="color:white;font-size:13px;">Subscriptions</a>
            </li>
            <li class="nav-item nav-text">
              <span class="dropdown show">
                  <a class="btn" href="#" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:"><i class="fa fa-bell" style="color:white"></i></a>
                <div class="dropdown-menu" araia-labelledby="dropdownMenuButton" style="background:black;width:320px">
                  <?php 
                      $my_notifications=$user->print_my_notifications($loggedin_user_id,3);
                  ?>
                </div>
              </span>
            </li>

            <li class="nav-item nav-text">
              <a class="btn nav-text js-scroll-trigger" role="button" style="color:white;font-size:13px;" id="navSearchBtn"><i class="fa fa-search"></i></a>
            </li>

            <li class="nav-item nav-text">
              <span class="dropdown show">
                  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;"><i class="fa fa-user-circle-o"></i> <br>
              <span style="font-size:9px;"></span></a>
                  <div class="dropdown-menu" araia-labelledby="dropdownMenuButton" style="background:black;">
                      <a class="nav-link js-scroll-trigger" href="user_details.php">View Profile</a>
                      <a href="my_channels.php" class="nav-link js-scroll-trigger" href="my_channels.php">My Channels</a>
                      <a href="logout.php?action=1" class="nav-link js-scroll-trigger">Logout</a>
                  </div>
              </span>
            </li>
            <?php
              if($num_items_in_cart>0){
            ?>
            <li class="nav-item nav-text">
              <span class="dropdown show">
                <a class="btn " href="#" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;"><i class="fa fa-shopping-cart"></i>
                  <sup style="font-size:9px;"><?php echo $num_items_in_cart;?></sup>
                </a>
                  <div class="dropdown-menu" araia-labelledby="dropdownMenuButton" style="background:black;">
                      <a class="nav-link js-scroll-trigger" href="#" style="margin-left:5px">Total: &nbsp;<?php echo "$price_currency ".$cart_total_price;?></a>
                      <a href="checkout.php" class="nav-link js-scroll-trigger btn btn-submit" style="background:green">Checkout</a>
                  </div>
              </span>
            </li>
            <?php
              }else{
            ?>
              <li class="nav-item nav-text">
                <a href="#" class="nav-link js-scroll-trigger" href="" style="color:white;font-size:13px;"><i class="fa fa-shopping-cart"></i></a>
              </li>
            <?php
            
              }

            ?>
            

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




    