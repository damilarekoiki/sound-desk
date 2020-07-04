<?php
    include("app/init.php");
    $all_countries=$master->fetch_all_countries();
    if(!$user->is_loggedin()){
        header("Location: index.php");
        exit(0);
    }




?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>soundesk</title>

    <link href="assets/css/scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.custom-scrollbar.css">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="assets/simple-line-icons/css/simple-line-icons.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet"> -->

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/new-age.min.css" rel="stylesheet">
    <link href="assets/css/channel.css" rel="stylesheet">

    <link href="assets/css/select2.min.css" rel="stylesheet">
    <link href="assets/css/date-picker.css" rel="stylesheet">
    <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    

    <style>
        .select2-container--default .select2-selection--single {
            border: 2px solid black !important;
            height:40px !important;
            padding: .375rem .60rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top:10px !important;
        }



        .select2-selection__placeholder{
            font-weight:bold;
            /* color:black !important; */
            /* font-size:22px !important; */
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        a{
            color:black;
        }
    </style>



  </head>

  <body id="page-top">

    <!-- Navigation -->
    <?php
        if(!isset($_SESSION['email'])){
            include("header_not_loggedin.php");
        }else{
          include("header_loggedin_bg.php");
        }
    ?>
    <!-- Original page -->
    <div class="page container" style="margin-top:100px;margin-bottom:70px;" >
        <div class="row col-md-12" style="padding-bottom:20px;font-weight:bold">Notifications</div>
        <?php 
            $my_notifications=$user->print_my_notifications($loggedin_user_id,-1);
        ?>

    </div>
    <!-- original page ends -->

    


    

    <?php
        include "footer.php";
    ?>
    
    

    <script>
        (function($){
            $(window).on("load",function(){
                // $(".content").mCustomScrollbar();
            });
        })(jQuery);
    </script>

    <script>
        audiojs.events.ready(function() {
            var as = audiojs.createAll();
        });
    </script>


  </body>

    

</html>
