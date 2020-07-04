<?php
    include("app/init.php");

    if(!$user->is_loggedin()){
        header("Location: index.php");
        exit(0);
    }
    $subscribed_channels=$user->fetch_all_subscribed_channels($loggedin_user_id);

    $all_priced_audios=$audio_production->fetch_all_priced_audios();
    shuffle($all_priced_audios);


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
                    <div class="row col-md-12" style="font-weight:bold">All Subscriptions</div>
                    <div class="col-md-12">

                    <?php

                    if(!empty($subscribed_channels)){
                        foreach($subscribed_channels as $a_channel){
                            $channel_id=$a_channel['channel_id'];
                            $channel_details=$channel->details($channel_id);
                            $channel_name=$channel_details['channel_name'];
                            $channel_logo=$channel_details['logo'];
                            $owner_id=$channel_details['owner_id'];


                    ?>
                            <a href="channel_details.php?cid=<?php echo base64_encode($channel_id);?>&oid=<?php echo base64_encode($owner_id);?>">
                                <div class="row col-md-12" style="padding-top:8px;margin-top:10px;">
                                    <div id="" class="col-md-2">
                                        <img src="<?php echo $channel_logo;?>" alt="" class="img img-fluid" style="width:100%">
                                    </div>
                                    <div class="col-md-10" style="padding:1px 0px 0px 0px;">
                                        <div class="row col-md-12">
                                            <span class="audio-name"><?php echo $channel_name;?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <hr>

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
                                    $audio_price=$audio_details['price'];
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
        

        <?php
            include "footer.php";
        ?>

        <script>
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
        </script>

    </body>
</html>
