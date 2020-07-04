<?php
    include("app/init.php");
    $all_countries=$master->fetch_all_countries();
    if(!$user->is_loggedin() &&  isset($_GET['uid'])){
        header("Location: index.php");
        exit(0);
    }


    if(isset($_GET['uid'])){
        $user_id=base64_decode($_GET['uid']);
    }else{
        $user_id=$loggedin_user_id;
    }

    $user_details=$user->get_details_by_id($user_id);
    $p_pix=$user_details['profile_pix'];
    $name=$user_details['first_name']." ".$user_details['last_name'];
    $username=$user_details['username'];
    $gender=$user_details['gender'];
    $dob=$user_details['date_of_birth'];
    $nationality=$user_details['nationality'];
    $nationality=$master->get_country_details($nationality)['country_name'];

    $all_user_channels=$channel->fetch_all_user_channels($user_id);

    $my_bought_audios=$user->fetch_my_bought_audios($user_id);
    $my_recent_promos=$user->fetch_my_recent_promos($user_id);

    
    $user_account_number=$user->get_account_number($user_id);


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

        .audiojs{
            width:100%;
        }

        .audiojs .scrubber{
            width:40%
        }

        .audiojs .time{
            width:30%
        } 

        .audio-name{
            font-size:13px;
            color:black;
        }
        .audio-artiste{
            font-size:9px;
            color:grey;
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
        
        <div class="row col-md-12 container" style="padding:10px 0px 0px 0px;margin-top:60px">
            <div class="col-xl-10 container">
                <img src="<?php echo $p_pix;?>" alt="" style="width:50px;height:50px;margin-left:35%;">
                <span class="float-right"><a href="user_sales.php" style="color:blue">View Your sales</a></span>
            </div>
            <div class="col-xl-10 container channels-div" style="margin-top:15px;">
                <div class="row col-md-12" style="margin-top:15px">
                    <span class="note">Name: &nbsp; </span> <?php echo $name;?>
                </div>
                <div class="row col-md-12" style="margin-top:15px">
                    <span class="note">Username: &nbsp; </span> <?php echo $username;?>
                </div>
                <div class="row col-md-12" style="margin-top:15px">
                    <span class="note">Gende: &nbsp; </span> <?php echo $gender;?>
                </div>
                <div class="row col-md-12" style="margin-top:15px">
                    <span class="note">Date of birth: &nbsp; </span> <?php echo $dob;?>
                </div>
                <div class="row col-md-12" style="margin-top:15px">
                    <span class="note">Nationality: &nbsp; </span> <?php echo $nationality;?>
                </div>
                <div class="col-md-12" style="margin-top:15px">
                    <span class="float-right" style="color:blue;cursor:pointer" data-toggle="modal" data-target="#accountModal">Add an account number</span>
                </div>
            </div>
        </div>

        <div class="col-xl-10 container " style="margin-top:50px;">
            <div style="font-weight:bold;"><?php echo $username;?>'s channels</div>
            <?php
                if(!empty($all_user_channels)){
                    foreach ($all_user_channels as $user_channel) {
                        # code...
                        $channel_id=$user_channel['channel_id'];
                        $channel_logo=$user_channel['logo'];
                        $channel_name=$user_channel['channel_name'];

                        $num_uploads=$channel->num_channel_uploads($channel_id);
                        $num_subscribers=$channel->num_channel_subscribers($channel_id);
            ?>

                        <div class="row" style="margin-top:20px">
                            <div class="row col-md-5">
                                <div class="col-md-2 channel-logo-div">
                                    <img src="<?php echo $channel_logo;?>" alt="Channel Logo" class="img img-fluid channel-logo" style="width:100%;">
                                </div>
                                <div class="channel-name-div col-md-10">
                                    <span class="channel-name"><?php echo $channel_name;?></span>
                                </div>
                            </div>
                            <div class="num-uploads-div col-md-3">
                                <span class="num-uploads"><?php echo $num_uploads;?> Upload(s)</span>
                            </div>
                            <div class="num-subscribers-div col-md-3">
                                <span class="num-subscribers"><?php echo $num_subscribers;?> Subscriber(s)</span>
                            </div>
                            <?php
                                if(isset($_GET['uid'])){
                            ?>
                                <div class="num-subscribers-div col-md-1">
                                    <a href="channel_details.php?cid=<?php echo base64_encode($channel_id);?>&oid=<?php echo base64_encode($loggedin_user_id);?>" class="visit-channel"><i class="fa fa-eye"></i></a>
                                </div>
                            <?php        
                                }else{
                            ?>
                                <div class="num-subscribers-div col-md-1">
                                    <a href="channel.php?cid=<?php echo base64_encode($channel_id);?>&oid=<?php echo base64_encode($loggedin_user_id);?>" class="visit-channel"><i class="fa fa-eye"></i></a>
                                </div>
                            <?php
                                }
                            ?>
                            
                        </div>
            <?php
                    }
                }else{
                    echo "$username has no channel";
                }
            ?>
        </div>

        <div class="row col-md-12 container " style="margin-top:50px;">
            <?php
                if(!isset($_GET['uid'])){
                    echo '<div class="container col-xl-10" style="font-weight:bold;">All Purchased Audios</div>';
                    if(!empty($my_bought_audios)){
                        foreach($my_bought_audios as $bought_audio){
                            $audio_id=$bought_audio['audio_id'];
                            $date_purchased=$bought_audio['date_purchased'];
                            $audio_details=$audio_production->details($audio_id);
                            $audio_name=$audio_details['audio_name'];

                            $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);
                            $audio_category=$audio_details['category'];
                            $audio_category_name=$audio_production->get_audio_category_details($audio_category)['category_name'];
                            $audio_rating=$audio_production->get_audio_rating($audio_id);
                            $audio_file=$audio_details['audio_file_path'];
                            $channel_id=$audio_details['channel_id'];


                            $audio_artistes=$audio_details['artistes'];
                            $audio_price=$audio_details['price'];
                            $is_free=$audio_details['is_free'];
            ?>
                            <div class="col-md-4" style="margin-top:10px;">

                                <div class="row col-md-12">
                                    <img src="<?php echo $audio_cover_pix;?>" class="img img-fluid" style="width:100%;height:100%">
                                </div>
                                <div class="row col-md-12" id="">
                                    <audio src="<?php echo $audio_file;?>" preload="auto" >
                                </div>
                                <a href="audio_play.php?pid=<?php echo base64_encode($audio_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                                    <div class="row col-md-12">
                                        <span class="audio-name"><?php echo $audio_name;?></span>
                                    </div>
                                    <div class="row col-md-12">
                                        <span class="audio-name"><?php echo $audio_artistes;?></span>
                                    </div>
                                    <div class="row col-md-12">
                                        <span class="audio-name"><?php echo "$price_currency ".$audio_price;?></span>&nbsp;
                                        <span class="audio-name">Purchased on &nbsp;<?php echo date("d F Y",strtotime($date_purchased));?></span>

                                    </div>
                                </a>
                            </div>
            <?php
                        }
                    }else{
                        echo "<div class='container col-xl-10' style='font-size:11px;'>You have not bought any audio</diV>";
                    }
                }
            ?>

        </div>

        <div class="row col-md-12 container " style="margin-top:50px;">
            <?php
                if(!isset($_GET['uid'])){
                    echo '<div class="container col-xl-10" style="font-weight:bold;">Recent Promos</div>';
                    if(!empty($my_recent_promos)){
                        foreach($my_recent_promos as $prom){
                            $promo_id=$prom['promo_id'];
                            $promo_details=$audio_production->get_promo_details($promo_id);
                            $promo_code=$promo_details['promo_code'];
                            $channel_id=$promo_details['channel_id'];


            ?>
                            <div class="col-md-4" style="margin-top:10px;">
                                <a href="promo.php?pid=<?php echo base64_encode($promo_id);?>&cid=<?php echo base64_encode($channel_id);?>" class="audio-name"><?php echo $promo_code;?></a>
                            </div>
            <?php
                        }
                    }else{
                        echo "<div class='container col-xl-10' style='font-size:11px;'>You have no recent promo</div>";
                    }
                }
            ?>

        </div>

    </div>
    <!-- original page ends -->

    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Add account number</b></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="padding:2px !important;">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <form action="" id="accountForm">
                                    <div class="form-group">
                                        <input type="number" name="account_number" placeholder="Enter a bank account number" class="form-control" value="<?php echo $user_account_number;?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-submit" value="Submit"/>
                                    </div>                      
                                </form>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        <?php
            if(isset($_GET['payment_success'])){
                if($_GET['payment_success']==1){
                    if(isset($_SESSION['payment_success'])){
                        $payment_success=$_SESSION['payment_success'];
                        echo "<script>alert('".$payment_success."')</script>";
                        unset($_SESSION['payment_success']);
                    }
                }
            }
        ?>

    

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

    <script>
        $("#accountForm").submit(function(e) {
            e.preventDefault();
            formData=new FormData(this);
            formData.append("add_account_number",1)
            $.ajax({
                type:"POST",
                data:formData,
                url:"parsers/user_parser.php",
                cache:false,
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data)
                    data=JSON.parse(data)
                    if(data.status==1){
                        swal({
                            title: "Success",
                            text:data.message,
                            icon:"success",
                            button:"OK"
                        })
                    }else{
                        swal({
                            title: "Oops!!!",
                            text:data.message,
                            icon:"warning",
                            button:"OK"
                        })
                    }

                    // setTimeout(() => {
                    //     location.reload()
                    // }, 3000);
                    
                }
            })
            

        })
    </script>


  </body>

    

</html>
