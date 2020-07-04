<?php
    include("app/init.php");

 
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if(!$user->is_loggedin()){
        $_SESSION['not_loggedin_url']=$url;
    }



    if(!isset($_GET['pid'])){
        header("Location: index.php");
        exit(0);
    }
    $promo_id=base64_decode($_GET['pid']);
    
    if($user->is_loggedin()){
        $user->update_user_checked_promo($loggedin_user_id,$promo_id);
    }

    $promo_details=$audio_production->get_promo_details($promo_id);
    $promoted_audios=json_decode($promo_details['promoted_audios'],true);
    $audios_to_get=json_decode($promo_details['audios_to_get'],true);

    $promo_code=$promo_details['promo_code'];
    $date_created=$promo_details['date_created'];
    $promo_type=$promo_details['promo_type'];
    $promo_discount=$promo_details['discount'];
    $num_audios_to_get=$promo_details['num_audios_to_get'];
    $promo_end_date=$promo_details['end_date'];

    if(strtotime($promo_end_date)<=strtotime(date("Y-m-d"))){
        header("Location: index.php");
        exit(0);
    }

    

    $date_created_ago=$audio_production->time_ago($date_created);

    $channel_id=$promo_details['channel_id'];
    $channel_details=$channel->details($channel_id);
    $channel_name=$channel_details['channel_name'];
    $channel_logo=$channel_details['logo'];

    $all_priced_audios=$audio_production->fetch_all_priced_audios();
    shuffle($all_priced_audios);

    $subscription=1;
    $subscription_style="background:#ca1010";
    $subscribe_text="<i class='fa fa-caret-square-o-right'></i> Subscribe";
    if($user->is_loggedin()){
        if($user->has_subscribed_to_channel($loggedin_user_id,$channel_id)){
            $subscription=0;
            $subscription_style="background:grey";
            $subscribe_text="<i class='fa fa-caret-square-o-right'></i> Unsubscribe";
        }
    }

    $promo_text="";
    if($promo_type==2){
        $promo_text="Select $num_audios_to_get and get them for free";
    }
    if($promo_type==3){
        $promo_text="Select $num_audios_to_get and get them on discount";
    }

    $audios_to_get_decider=$promo_details['audios_to_get_decider'];
    if($audios_to_get_decider==2){
        $audios_to_get=$channel->fetch_all_channel_priced_uploads($channel_id);
    }
    
    $prom_total_price=0;

    if($user->is_loggedin()){
        $user->update_user_visited_channel($loggedin_user_id,$channel_id);
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
        <!-- <link href="assets/css/audio_style.css" rel="stylesheet" type="text/css" /> -->

        <link href="assets/css/channel.css" rel="stylesheet">

        <link href="assets/css/select2.min.css" rel="stylesheet">
        <link href="assets/css/date-picker.css" rel="stylesheet">
        <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/rateYo/src/jquery.rateyo.css">

        <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <link href="assets/css/checkbox.css" rel="stylesheet">


        

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
                    <!-- Promoted Audios -->
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            Promo Code: <span style="font-size:22px;"><?php echo $promo_code;?></span>
                        </div>
                        <?php
                            if(!empty($promoted_audios)){
                                foreach($promoted_audios as $prom_aud){
                                    $audio_id=$prom_aud;
                                    $audio_details=$audio_production->details($audio_id);
                                    $is_deleted=$audio_details['deleted'];
                                    $audio_name=$audio_details['audio_name'];
                                    $audio_restricted_min_age=$audio_details['restricted_age_min'];
                                    $audio_restricted_max_age=$audio_details['restricted_age_max'];

                                    $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);
                                    $audio_category=$audio_details['category'];
                                    $audio_category_name=$audio_production->get_audio_category_details($audio_category)['category_name'];
                                    $audio_rating=$audio_production->get_audio_rating($audio_id);
                                    $audio_file=$audio_production->get_audio_preview_file($audio_id);

                                    $audio_artistes=$audio_details['artistes'];
                                    $audio_price=$audio_details['price'];
                                    $is_free=$audio_details['is_free'];
                                    $promo_price="";
                                    $promo_price_text="";
                                    $audio_price_text="$price_currency ".$audio_price;
                                    if($promo_type==1){
                                        $audio_price_text="<strike style='font-size:22px;color:grey'>$price_currency $audio_price</strike>";
                                        $promo_price=($audio_price)-($audio_price*($promo_discount/100));
                                        $prom_total_price+=$promo_price;
                                        $promo_price_text="$price_currency ".$promo_price;
                                    }else{
                                        $prom_total_price+=$audio_price;

                                    }
                                    if($user->is_loggedin()){
                                        $user->update_user_played_audio_category($loggedin_user_id,$audio_category);
                                    }
                                    if($user->is_loggedin()){
                                        $user->update_user_played_audio($loggedin_user_id,$audio_id);
                                    }
                        ?>
                                    <div class="col-md-6" style="margin-top:15px;">
                                        <div class="row col-md-12">
                                            <img src="<?php echo $audio_cover_pix;?>" alt="" class="img img-fluid" style="width:100%;height:100%" id="">
                                        </div>
                                        <div class="row col-md-12" id="">
                                            <audio src="<?php echo $audio_file;?>" preload="auto" >
                                        </div>

                                        <div class="row col-md-12" id="" style="font-weight:bold;">
                                            <?php echo $audio_price_text."&nbsp;&nbsp;&nbsp;".$promo_price_text;?>
                                        </div>
                                        
                                    </div>
                        <?php
                                }
                                
                            }
                        ?>
                            <div class="row col-md-12">
                                <div class="col-md-5" style="margin-top:25px;">
                                    Total price: <span><?php echo "$price_currency $prom_total_price";?></span>
                                </div>
                                <?php
                                    if($user->is_loggedin()){

                                ?>
                                <div class="col-md-7" style="margin-top:25px;">
                                    <i class="fa fa-shopping-cart fa-2x float-right add-promo-to-cart"></i>
                                </div>
                            </div>
                            <?php
                            }else{
                        ?>
                                <div class="col-md-10 col-10">
                                    <i class="fa fa-shopping-cart fa-2x float-right" onclick="popUpNotLoggedInModal()"></i>
                                </div>
                        <?php
                            }
                        ?>


                    </div>
                    <div class="row col-md-12" style="margin-top:35px;font-size:13px;">
                        Promo will expire on &nbsp; <span style="font-weight:bold;"><?php echo date("d M Y",strtotime($promo_end_date));?></span>
                    </div>

                    <!-- Audios to get -->
                    <div class="row col-md-12" style="margin-top:35px;">
                        
                        <?php
                            if(!empty($audios_to_get)){
                                echo '<div class="col-md-12">
                                <span style="font-size:18px;font-weight:bold">What to benefit after buying audios</span>
                            </div>';
                                echo "<div class='col-md-12'>
                                <span style='font-size:12px;'>$promo_text</span>
                            </div>";
                                foreach($audios_to_get as $aud_get){
                                    if($audios_to_get_decider==2){
                                        $audio_id=$aud_get['audio_id'];
                                        if(in_array($audio_id,$promoted_audios)){
                                            continue;
                                        }
                                    }else{
                                        $audio_id=$aud_get;
                                    }
                                    $audio_details=$audio_production->details($audio_id);
                                    $is_deleted=$audio_details['deleted'];
                                    $audio_name=$audio_details['audio_name'];
                                    $audio_restricted_min_age=$audio_details['restricted_age_min'];
                                    $audio_restricted_max_age=$audio_details['restricted_age_max'];

                                    $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);
                                    $audio_category=$audio_details['category'];
                                    $audio_category_name=$audio_production->get_audio_category_details($audio_category)['category_name'];
                                    $audio_rating=$audio_production->get_audio_rating($audio_id);
                                    $audio_file=$audio_production->get_audio_preview_file($audio_id);

                                    $audio_artistes=$audio_details['artistes'];
                                    $audio_price=$audio_details['price'];
                                    $is_free=$audio_details['is_free'];

                                    $promo_price="";
                                    $promo_price_text="";

                                    $audio_price_text=$audio_price;
                                    if($promo_type==2){
                                        $audio_price_text="<strike style='font-size:22px;color:grey'>$price_currency $audio_price</strike>";
                                        $promo_price_text="Free";
                                    }
                                    if($promo_type==3){
                                        $audio_price_text="<strike style='font-size:22px;color:grey'>$price_currency $audio_price</strike>";
                                        $promo_price=($audio_price)-($audio_price*($promo_discount/100));
                                        $promo_price_text="$price_currency ".$promo_price;
                                    }
                                    if($user->is_loggedin()){
                                        $user->update_user_played_audio_category($loggedin_user_id,$audio_category);
                                    }
                                    if($user->is_loggedin()){
                                        $user->update_user_played_audio($loggedin_user_id,$audio_id);
                                    }
                        ?>
                                    <div class="col-md-6" style="margin-top:15px;">
                                        <div class="row col-md-12">
                                            <img src="<?php echo $audio_cover_pix;?>" alt="" class="img img-fluid" style="width:100%;height:100%" id="">
                                        </div>
                                        <div class="row col-md-12" id="">
                                            <audio src="<?php echo $audio_file;?>" preload="auto" >
                                        </div>
                                        <div class="row col-md-12" id="" style="font-weight:bold">
                                            <?php echo $audio_price_text."&nbsp;&nbsp;&nbsp;".$promo_price_text;?>
                                        </div>
                                        <div class="row col-md-12" id="">
                                            <label class="checkbox-container">
                                                <input type="checkbox" class="audios-to-get" value="<?php echo $audio_id;?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    

                    
                    <div class="row col-md-12" style="padding-top:18px;padding-bottom:18px;border-top:1px solid grey;border-bottom:1px solid grey;margin-top:8px;">
                        
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
                    <div class="row col-md-12" style="padding-top:18px;padding-bottom:18px;">
                        
                        <div class="col-md-12">
                            <span style="font-weight:bold">Created <?php echo $date_created_ago;?></span>
                        </div>
                    </div>
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
        

        <?php
            include "footer.php";
        ?>

        <script>
            numAudiosToGet=<?php echo $num_audios_to_get;?>;
            countAudsToGet=0;
            $.each($(".audios-to-get"),function(){
                countAudsToGet++;
                $(this).prop("checked",true)
                if(countAudsToGet==numAudiosToGet) return false;
            })
        </script>
        
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

            $(".add-promo-to-cart").click(function(){
                swal({
                    title: "Confirm Selection",
                    text:"Please! Confirm the audios you selected",
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
                }).then((click)=>{
                    if(click){
                        formData=new FormData();
                        formData.append("add_promo_to_cart",1)
                        formData.append("promo_id",<?php echo $promo_id;?>)

                        $.each($(".audios-to-get"),function(){
                            if($(this).is(":checked")){
                                formData.append("audios_to_get[]",$(this).val())
                            }
                        })

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
                                        if(clicked){
                                            location.reload();
                                        }
                                    })
                                }
                                
                            }
                        })
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
