<?php
    include("app/init.php");

    
 
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if(!$user->is_loggedin()){
        $_SESSION['not_loggedin_url']=$url;
    }

    if(!isset($_GET['pid'],$_GET['cid'])){
        header("Location: index.php");
        exit(0);
    }
    $audio_id=base64_decode($_GET['pid']);
    $channel_id=base64_decode($_GET['cid']);

    if(!$channel->owns_audio($audio_id,$channel_id)){
        header("Location: index.php");
        exit(0);
    }

    $all_adverts=$audio_production->fetch_all_adverts();
    shuffle($all_adverts);

    $all_priced_audios=$audio_production->fetch_all_priced_audios();
    shuffle($all_priced_audios);

    if(!empty($all_adverts)){
        $advert=$all_adverts[0];
        $ad_company_name=$advert['company_name'];
        $ad_company_website=$advert['company_website'];
        $ad_channel_id=$advert['channel_id'];
        $ad_channel_details=$channel->details($ad_channel_id);
        $ad_channel_name=$ad_channel_details['channel_name'];
        $ad_audio_file=$advert['audio_file_path'];
        $ad_cover_pix=$advert['advert_cover_pix'];

        $ad_subscription=1;
        $ad_subscription_style="background:#ca1010";
        $ad_subscribe_text="<i class='fa fa-caret-square-o-right'></i> Subscribe";

        if($user->is_loggedin()){
            if($user->has_subscribed_to_channel($loggedin_user_id,$ad_channel_id)){
                $ad_subscription=0;
                $ad_subscription_style="background:grey";
                $ad_subscribe_text="<i class='fa fa-caret-square-o-right'></i> Unsubscribe";
            }
        }
    }

    $audio_details=$audio_production->details($audio_id);
    $is_deleted=$audio_details['deleted'];
    if($is_deleted==1){
        header("Location: index.php");
        exit(0);
    }
    $audio_comments=$audio_production->fetch_all_comments($audio_id);
    $audio_name=$audio_details['audio_name'];
    $audio_restricted_min_age=$audio_details['restricted_age_min'];
    $audio_restricted_max_age=$audio_details['restricted_age_max'];
    $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);
    $audio_category=$audio_details['category'];
    $audio_category_name=$audio_production->get_audio_category_details($audio_category)['category_name'];
    $audio_rating=$audio_production->get_audio_rating($audio_id);
    $audio_artistes=$audio_details['artistes'];
    $audio_price=$audio_details['price'];
    $audio_category=$audio_details['category'];
    $audio_description=$audio_details['description'];

    

    
    $is_free=$audio_details['is_free'];
    $audio_file=$audio_production->get_audio_preview_file($audio_id);
    $channel_id=$audio_details['channel_id'];
    $channel_details=$channel->details($channel_id);
    $channel_name=$channel_details['channel_name'];
    $channel_logo=$channel_details['logo'];


    $real_audio_file=$audio_file;
    $real_cover_pix=$audio_cover_pix;


    $date_uploaded=$audio_details['date_uploaded'];
    $date_uploaded_ago=$audio_production->time_ago($date_uploaded);
    $num_downloads=$audio_production->get_num_downloads($audio_id);

    $subscription=1;
    $subscription_style="background:#ca1010";
    $subscribe_text="<i class='fa fa-caret-square-o-right'></i> Subscribe";
    if($user->is_loggedin()){
        if($user->has_subscribed_to_channel($loggedin_user_id,$channel_id)){
            $subscription=0;
            $subscription_style="background:grey";
            $subscribe_text="<i class='fa fa-caret-square-o-right'></i> Unsubscribe";
        }

        $user->update_user_played_audio_category($loggedin_user_id,$audio_category);
        $user->update_user_played_audio($loggedin_user_id,$audio_id);
        $user->update_user_visited_channel($loggedin_user_id,$channel_id);
    }
    $play_audio_cover=$audio_cover_pix;
    if($is_free==1 && isset($advert)){
        $play_audio_cover=$ad_cover_pix;
    }

    $audio_price_text="$price_currency ".$audio_price;
    if($is_free==1){
        $audio_price_text="Free";
    }
    if($user->is_loggedin()){
        $user_promo_benefit=$user->get_user_promo_benefit($loggedin_user_id, $audio_id);
        if(!empty($user_promo_benefit)){
            $promo_audio_free=$user_promo_benefit['is_free'];
            if($promo_audio_free==1){
                $audio_price_text="Free <span style='font-size:10;color:grey'> You are still enjoying your promo</span>";
            }else{
                $audio_price_text="$price_currency ".$user_promo_benefit['price']." <span style='font-size:10;color:grey'> You are still enjoying your promo</span>";
                $audio_price=$user_promo_benefit['price'];

            }
        }
    }

    $real_audio_price=$audio_price;
    $real_audio_id=$audio_id;

    
    

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
        <!-- <link href="assets/css/audio_style.css" rel="stylesheet" type="text/css" /> -->

        <link href="assets/css/channel.css" rel="stylesheet">

        <link href="assets/css/select2.min.css" rel="stylesheet">
        <link href="assets/css/date-picker.css" rel="stylesheet">
        <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/rateYo/src/jquery.rateyo.css">

        <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">

        

        <style>
            .audiojs{
                width:100%;
            }

            .audiojs .scrubber{
                width:60%
            }
            /* .audiojs .play-pause{
                width:20%
            }*/

            .audiojs .time{
                width:20%
            } 

            .audio-name{
                font-size:13px;
                color:black;
            }
            .audio-artiste{
                font-size:9px;
                color:grey;
            }

            .col-md-12.play-page{
                padding-right:0px !important;
                padding-left:0px !important;

            }

            .fa-shopping-cart, .fa-download{
                cursor:pointer;
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
            <div class="row col-md-12 play-page" style="">
                <div class="col-md-7">
                    <div class="row col-md-12">
                        <img src="<?php echo $play_audio_cover;?>" alt="" class="img img-fluid" style="width:100%;height:100%" id="audioCover">
                    </div>
                    <?php
                        if($is_free==1){
                            if(isset($advert)){
                    ?>
                    <div class="row col-md-12" id="adAudioDiv">
                        <audio src="<?php echo $ad_audio_file;?>" preload="auto" >
                    </div>
                    <?php
                            }
                        }

                    ?>
                    <div class="row col-md-12" id="realAudioDiv" style="<?php if($is_free==1 && isset($advert)) echo 'display:none';?>">
                        <audio src="<?php echo $real_audio_file;?>" preload="auto" >
                    </div>
                    <!-- advert info -->
                    <?php
                        if($is_free==1){
                            if(isset($advert)){
                    ?>
                                <div class="row col-md-12 advert-info" id="advertInfo">
                                    <div class="col-md-12" style="">
                                        <div class="row col-md-12" style="font-size:11px;margin-top:0px">
                                            <a href="http://<?php echo $ad_company_website;?>" style="color:blue;">Visit advertiser's site</a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2" style="padding-top:8px;"><span class="ad-btn">Ad</span></div>
                                            <div class="col-md-7" style="padding-top:5px;">
                                            <div class="row col-md-12" style="padding-top:8px;"><span class="advert_company"><?php echo $ad_company_name;?></span></div> 
                                            <div class="row col-md-12" style="padding-top:3px;"><span class="advert_channel">Uploaded by <?php echo $ad_channel_name;?></span></div> 
                                            </div>
                                            <?php
                                                if($user->is_loggedin()){
                                            ?>
                                                    <div class="col-md-3" style="padding-top:8px;"><button class="subscribe-btn btn chanSub<?php echo $ad_channel_id;?>" onclick="subscribe(this,<?php echo $ad_subscription;?>,<?php echo $ad_channel_id;?>)" style="<?php echo $ad_subscription_style;?>"><?php echo $ad_subscribe_text;?></button></div>
                                            <?php
                                                }else{

                                            ?>
                                                    <div class="col-md-3" style="padding-top:8px;"><button class="subscribe-btn btn" onclick="popUpNotLoggedInModal()" style="background:#ca1010"><i class='fa fa-caret-square-o-right'></i> Subscribe</button></div>
                                                    
                                            <?php
                                                }
                                            ?>
                                            
                                        </div>
                                    </div>
            
                                </div>
        
                                <div class="row col-md-12" id="countDownDiv">
                                    <span id="countdownAdvert"></span>
                                </div>
                    <?php
                            }
                        }
                    ?>

                    <div class="row col-md-12" style="padding-top:18px;font-weight:bold">
                        <?php echo $audio_name;?>
                    </div>
                    <div class="row" style="padding-top:18px;">
                        <div class="col-md-4"><?php echo $num_downloads;?> downloads</div>
                        <div class="col-md-4">
                            <div class="audio_rating" dRate="<?php echo $audio_rating;?>"></div>
                        </div>
                        <div class="col-md-4"><?php echo $audio_price_text;?></div>
                    </div>
                    <div class="row col-md-12" style="padding-top:18px;padding-bottom:18px;">
                        <div class="col-md-2 col-2" id="userAudioRateDiv">
                            <?php
                                if($user->is_loggedin()){
                                    if(!$user->has_rated_audio($audio_id,$loggedin_user_id)){
                            ?>
                                        <span class="mx-1" onclick="showRateModal(this,<?php echo $audio_id;?>)" style="color:blue;text-decoration:underline;cursor:pointer">Rate</span>
                            <?php
                                    }else{
                                        $user_audio_rate=$audio_production->get_user_audio_rating($audio_id,$loggedin_user_id);
                            ?>
                                        <div class="user_audio_rating" dRate="<?php echo $user_audio_rate;?>"></div>
                            <?php
                                    }
                                }else{
                            ?>
                                    <span class="mx-1" onclick="popUpNotLoggedInModal()" style="color:blue;text-decoration:underline;cursor:pointer">Rate</span>
                            <?php
                                }
                            ?>
                            
                        </div>
                        <?php
                            
                            if($user->is_loggedin()){
                                if(!empty($user_promo_benefit)){
                                    $promo_audio_free=$user_promo_benefit['is_free'];
                                    if($promo_audio_free==1){
                        ?>
                                        <div class="col-md-10 col-10">
                                            <i class="fa fa-download fa-2x float-right download"></i>
                                        </div>
                        <?php
                                    }
                                }else{
                                    if($user->has_bought_audio_but_yet_download($audio_id,$loggedin_user_id) || $is_free==1){
                        ?>
                                        <div class="col-md-10 col-10">
                                            <i class="fa fa-download fa-2x float-right download"></i>
                                        </div>
                        <?php
                                    }else{
                        ?>
                                        <div class="col-md-10 col-10">
                                            <i class="fa fa-shopping-cart fa-2x float-right add-to-cart"></i>
                                        </div>
                        <?php
                                    }
                                }
                        ?>
                            
                        <?php
                            }else{
                        ?>
                                <div class="col-md-10 col-10">
                                    <i class="fa fa-shopping-cart fa-2x float-right" onclick="popUpNotLoggedInModal()"></i>
                                </div>
                        <?php
                            }
                        ?>
                        <div style="clear:both"></div>
                    </div>
                    <div class="row col-md-12" style="padding-top:18px;padding-bottom:18px;border-top:1px solid grey;border-bottom:1px solid grey;">
                        
                        <div class="col-md-2 col-2">
                            <img src="<?php echo $channel_logo;?>" alt="" class="img img-fluid rounded-circle float-right" style="width:50px;height:50px;">
                        </div>
                        <div class="col-md-7 col-7">
                            <span  class=""><?php echo $channel_name;?></span>
                        </div>
                        <div class="col-md-3 col-3">
                        <?php
                            if($user->is_loggedin()){
                        ?>
                            <button class="subscribe-btn btn chanSub<?php echo $channel_id;?>" onclick="subscribe(this,<?php echo $subscription;?>,<?php echo $channel_id;?>)" style="<?php echo $subscription_style;?>"><?php echo $subscribe_text;?></button>
                        <?php
                            }else{
                        ?>
                                <button class="subscribe-btn btn" onclick="popUpNotLoggedInModal()" style="background:#ca1010"><i class='fa fa-caret-square-o-right'></i> Subscribe</button>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                    <div class="row col-md-12" style="padding-top:18px;padding-bottom:18px;border-bottom:1px solid grey;">
                        
                        <div class="col-md-12">
                            <span style="font-weight:bold">Uploaded <?php echo $date_uploaded_ago;?></span>
                        </div>
                        <div class="col-md-12">
                            <span  class="" style="">Category</span>
                            <span  class="float-right" style="color:blue"><?php echo $audio_category_name;?></span>
                        </div>
                        <div class="col-md-12" style="margin-top:15px;">
                            <span style="font-size:12px"><?php echo $audio_description;?></span>
                        </div>
                    </div>
                    <div class='row col-md-12' style='margin-top:8px;'>Comments</div>
                    <div id="CommentsDiv">
                        <?php
                            if(!empty($audio_comments)){
                                $num_audio_comments=count($audio_comments);
                                foreach($audio_comments as $a_comment){
                                    $rater_id=$a_comment['rater_id'];
                                    $rater_details=$user->get_details_by_id($rater_id);
                                    $rater_username=$rater_details['username'];
                                    $rater_pix=$rater_details['profile_pix'];
                                    $rater_audio_rate=$a_comment['rate'];
                                    $rater_audio_comment=$a_comment['comment'];
                                    $when_rated=date("d/m/Y",strtotime($a_comment['date_rated']));
                        ?>
                                    <div class="row col-md-12" style="margin-top:8px;">
                                        <div class="row col-md-12">
                                            <div class="col-md-2 col-2">
                                                <img src="<?php echo $rater_pix;?>" alt="" class="img img-fluid rounded-circle float-right" style="width:50px;height:50px;">
                                            </div>
                                            <div class="col-md-10 col-10">
                                                <span  class="" style="font-weight:bold;"><?php echo $rater_username;?></span>
                                            </div>

                                        </div>
                                        <div class="row col-md-10 mx-2" style="margin-top:8px">
                                            <div class="user_audio_rating" dRate="<?php echo $rater_audio_rate;?>"></div>
                                            <div><span  class="" style="font-size:13px;font-weight:bold;"><?php echo $when_rated;?></span></div>
                                        </div>
                                        <div class="row col-md-10 mx-2">
                                            <span  class=""><?php echo $rater_audio_comment;?></span>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-4">
                    <div class="col-md-12 text-center" style="font-weight:bold"> Suggestions </div>
                    <?php
                        $pricedCount=0;
                        if(!empty($all_priced_audios)){
                            foreach($all_priced_audios as $priced_audio){
                                $is_deleted=$priced_audio['deleted'];
                                if($is_deleted==0){
                                    $audio_id=$priced_audio['audio_id'];
                                    $audio_details=$audio_production->details($audio_id);
                                    $audio_name=$audio_details['audio_name'];
                                    $audio_restricted_min_age=$audio_details['restricted_age_min'];
                                    $audio_restricted_max_age=$audio_details['restricted_age_max'];
                                    $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);
                                    $audio_category=$audio_details['category'];
                                    $audio_rating=$audio_production->get_audio_rating($audio_id);
                                    $audio_artistes=$audio_details['artistes'];
                                    $date_uploaded=$audio_details['date_uploaded'];
                                    $is_deleted=$audio_details['deleted'];
                                    $date_uploaded_ago=$audio_production->time_ago($date_uploaded);
                                    $num_downloads=$audio_production->get_num_downloads($audio_id);


                                    $channel_id=$priced_audio['channel_id'];
                                    $channel_details=$channel->details($channel_id);
                                    $channel_name=$channel_details['channel_name'];
                                    $channel_country=$channel_details['brand_location'];
                                    $channel_country_details=$channel->get_country_details($channel_country);
                                    $channel_country_code=$channel_country_details['cc_iso'];
                                    $channel_country_name=$channel_country_details['country_name'];

                                    $channel_logo=$channel_details['logo'];

                                    $owner_id=$channel_details['owner_id'];


                                    $should_display=0;

                                    if(!$user->is_loggedin()){
                                        if(strtolower($channel_country_code)==strtolower($user_location_country_code) || strtolower($channel_country_name)==strtolower($user_location_country_name)){
                                        $should_display=1;
                                        }
                                    }else{
                                        $user_age=$user->calculate_user_age($loggedin_user_id);
                                        if(strtolower($channel_country_code)==strtolower($user_location_country_code) 
                                        || 
                                        strtolower($channel_country_name)==strtolower($user_location_country_name) 
                                        || 
                                        $user->has_played_audio($loggedin_user_id,$audio_id) 
                                        || 
                                        $user->has_played_audio_category($loggedin_user_id,$audio_category) 
                                        || 
                                        $user->age_not_restricted($user_age,$audio_restricted_min_age,$audio_restricted_max_age) 
                                        || 
                                        $user->has_visited_channel($loggedin_user_id,$channel_id)
                                        ||
                                        $owner_id==$loggedin_user_id 
                                        ||
                                        $user->has_subscribed_to_channel($loggedin_user_id,$channel_id)
                                        ){
                                        $should_display=1;
                                        }
                                    }
                                    if($should_display==1 && $is_deleted==0){
                                        $pricedCount++;
                        ?>
                                    <a href="audio_play.php?pid=<?php echo base64_encode($audio_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                                        <div class="row col-md-12" style="padding-top:8px;margin-top:10px;">
                                            <div id="" class="col-md-6">
                                                <img src="<?php echo $audio_cover_pix;?>" alt="" class="img img-fluid" style="width:100%">
                                            </div>
                                            <div class="col-md-6" style="padding:1px 0px 0px 8%;">
                                                <div class="row col-md-12">
                                                    <span class="audio-name"><?php echo $audio_name." ";?></span> <span class="audio-artiste"><?php echo " ".$audio_artistes;?></span>
                                                </div>
                                                <div class="row col-md-12" style="padding-top:8px">
                                                    <div class="audio_rating" dRate="<?php echo $audio_rating;?>"></div>
                                                </div>
                                                <div class="row col-md-12" style="padding-top:8px;color:black">
                                                    <span><?php echo $num_downloads;?> downloads</span>
                                                </div>
                                            



                                            </div>
                                        </div>
                                    </a>

                                    <hr>
                        <?php
                                    }
                                }
                                if($pricedCount==10) break;
                            }
                        }
                    ?>
                </div>
            </div>

        </div>
        <!-- original page ends -->

        

        <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Rate Audio</b></h5>
                    </div>
                    <div class="modal-body">
                        <?php
                            if($user->is_loggedin()){
                                if($user->has_bought_audio_at_least_once($real_audio_id,$loggedin_user_id) || $is_free==1){
                        ?>
                                    <div class="row" style="padding:0px !important;">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <div id="audioRate"></div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:2px !important;">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <form action="" id="audioRateForm" style="display:none;">
                                                <div class="form-group">
                                                    <textarea name="audio_rate_comment" cols="30" rows="2" style="resize:none" placeholder="Enter a comment (optional)" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-submit" type="submit" id="audioRateSubmit">Submit</button>
                                                </div>                         
                                            </form>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                        <?php
                                }else{
                        ?>
                                    <div class="row" style="padding:0px !important;">You need to buy this audio before you can rate it</div>
                        <?php
                                }
                            }else{
                        ?>
                                <div class="row" style="padding:0px !important;">You need to log in</div>

                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        

        <?php
            include "footer.php";
        ?>
        
        <script>
            function popUpNotLoggedInModal(){
                swal({
                    title: "You are not logged in",
                    text:"You need to login to continue",
                    icon:"warning",
                    buttons:{
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                        confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            className: "",
                            closeModal: true
                        }
                    }
                }).then((clicked)=>{
                    if(clicked){
                        window.location="login.php"
                    }
                })
            }
        </script>

        <script>
            $(".download").click(function(){
                swal({
                    title: "Download will start shortly",
                    text:"Please! Do not leave or reload this page until download completes",
                    icon:"warning",
                    button:"OK"
                })
                window.location="download.php?aid=<?php echo base64_encode($real_audio_id);?>";
            })

            $(".add-to-cart").click(function(){
                formData=new FormData();
                formData.append("add_to_cart",1)
                formData.append("audio_id",<?php echo $real_audio_id;?>)

                $.ajax({
                    type:"POST",
                    data:formData,
                    url:"parsers/cart_parser.php",
                    cache:false,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        console.log(data)
                        data=JSON.parse(data)
                        if(data.status==0){
                            swal({
                                title: data.title,
                                text:data.message,
                                icon:"warning",
                                button:"OK"
                            })
                        }else{
                            swal({
                                title: data.title,
                                text:data.message,
                                icon:"success",
                                button:"OK"
                            }).then((clicked)=>{
                                if(clicked) location.reload();
                            })
                        }
                        
                    }
                })
            })
        </script>
        

        <script>
            audiojs.events.ready(function() {
                var as = audiojs.createAll();
            });

            $(".audio_rating").each(function(){
                rate=$(this).attr("dRate");
                $(this).rateYo({
                    numStars: 5,
                    starWidth: "15px",
                    precision: 0,
                    rating: rate,
                    spacing: "1px",
                    fullStar: true,
                    readOnly: true
                
                });
            })

            $(".user_audio_rating").each(function(){
                rate=$(this).attr("dRate");
                $(this).rateYo({
                    numStars: 5,
                    starWidth: "13px",
                    precision: 0,
                    rating: rate,
                    spacing: "1px",
                    fullStar: true,
                    readOnly: true
                
                });
            })
        </script>

        <script>
            var realAudioCoverPix="<?php echo $real_cover_pix;?>"
            countDown=5;
            $(document).ready(function(){
                aud=$("#adAudioDiv").find("audio");
                if(typeof aud!="undefined"){
                    aud.on('ended',function(){
                        skipAd()
                    })
                }

                obj=$("#countdownAdvert")
                if(typeof obj!="undefined"){
                    $("#countdownAdvert").html(countDown);
                    setInterval(() => {
                        if(countDown==4){
                            $("#adAudioDiv").find(".play").trigger("click");
                        }
                        if(countDown==0){
                            $("#countdownAdvert").html("<button class='btn btn-submit' style='font-size:11px;padding:2px;' onclick='skipAd()'>Skip Ad</button>");
                            
                            return false;
                        }
                        $("#countdownAdvert").html(countDown--);                    
                    }, 1000);
                }

                
            })

            function skipAd(){
                // $("#adAudioDiv").find("audio").attr("src","");
                // audiojs.events.ready(function() {
                //     var as = audiojs.createAll();
                // });
                $("#adAudioDiv").remove()
                $("#realAudioDiv").show()
                $("#realAudioDiv").find(".play").trigger("click");
                $("#audioCover").attr("src",realAudioCoverPix)
                $("#countDownDiv, #advertInfo").remove();
            }

            

        </script>

        <script>
            function subscribe(elem,subscription,channel_id){
                btn=$(elem);
                btnValue=btn.html();
                btn.prop("disabled",true);
                btn.text("Please! Wait...")
                formData = new FormData();
                formData.append("subscription",subscription)
                formData.append("channel_id",channel_id)
                formData.append("subscribe",1)

                $.ajax({
                    type:"POST",
                    data:formData,
                    url:"parsers/channel_parser.php",
                    cache:false,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        console.log(data)
                        btn.prop("disabled",false);
                        btn.html(btnValue)

                        data=JSON.parse(data)
                        if(data.status==1){
                            if(subscription==1){
                                btn.attr("onclick","subscribe(this,0,"+channel_id+")").html("<i class='fa fa-caret-square-o-right'></i> Unsubscribe").css({
                                    "background":"grey"
                                })
                                $(".chanSub"+channel_id).attr("onclick","subscribe(this,0,"+channel_id+")").html("<i class='fa fa-caret-square-o-right'></i> Unsubscribe").css({
                                    "background":"grey"
                                })
                            }else{
                                btn.attr("onclick","subscribe(this,1,"+channel_id+")").html("<i class='fa fa-caret-square-o-right'></i> Subscribe").css({
                                    "background":"#ca1010"
                                })
                                $(".chanSub"+channel_id).attr("onclick","subscribe(this,1,"+channel_id+")").html("<i class='fa fa-caret-square-o-right'></i> Subscribe").css({
                                    "background":"#ca1010"
                                })
                            }
                        }else{
                            alert("something went wrong");
                        }
                    }
                })
            }

            var audioId=0;
            var audioRate=0;

            function showRateModal(e,audio_id){
                audioId=audio_id;

                $('#rateModal').modal({
                    show: true
                })
            }

            $("#audioRate").rateYo({
                numStars: 5,
                starWidth: "25px",
                precision: 0,
                spacing: "1px",
                fullStar: true,
                
                onSet: function (rating, rateYoInstance) {
                    audioRate=rating;
                    $("#audioRateForm").show()
                }
            });

            $("#audioRateForm").submit(function(e){
                e.preventDefault();
                btn=$("#audioRateSubmit");
                btnValue=btn.html();
                btn.prop("disabled",true);
                btn.text("Please! Wait...")
                formData = new FormData(this);
                formData.append("audio_id",audioId)
                formData.append("rate",audioRate)
                formData.append("rate_audio",1)

                

                $.ajax({
                    type:"POST",
                    data:formData,
                    url:"parsers/channel_parser.php",
                    cache:false,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        console.log(data)
                        btn.prop("disabled",false);
                        btn.html(btnValue)

                        newDiv=document.createElement("div");
                        $("#userAudioRateDiv").html(newDiv)
                        $(newDiv).rateYo({
                            numStars: 5,
                            starWidth: "15px",
                            precision: 0,
                            rating: audioRate,
                            spacing: "1px",
                            fullStar: true,
                            readOnly: true
                        
                        });

                        $("#CommentsDiv").html(data);

                        $("#rateModal").modal('hide')
                    }
                })
            })
        </script>



    </body>
</html>
