<?php
  include "app/init.php";
  $all_adverts=$audio_production->fetch_all_adverts();
  shuffle($all_adverts);

  $all_promos=$audio_production->fetch_all_promotions();
  shuffle($all_promos);

  $all_free_audios=$audio_production->fetch_all_free_audios();
  shuffle($all_free_audios);

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
  


?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>soundesk</title>

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

    <link href="assets/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/rateYo/src/jquery.rateyo.css">

    <style>
      .audiojs{
        width:100%;
        /* height:auto; */
        /* padding-top:4px; */
      }
    </style>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <?php
        if(!isset($_SESSION['email'])){
            include("header_not_loggedin.php");
        }else{
          include("header_loggedin_no_bg.php");
        }
    ?>

    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-12 my-auto index-search-div" style="padding:100px">
          <div class="header-content mx-auto" id="buySellText">Buy and Sell Audio</div>
            <div class="header-content mx-auto" style="">
              <form action="search_result.php" method="get" class="">
                <div class="input-group">
                    <input type="text" name="s_q" id="" class="form-control" placeholder="Search for audio, promo code, user or channel" style="padding:10px"> 
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>                   
                    </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </header>

      <?php
        // echo $user_location_country_code;

      ?>

    <div class="row col-md-12" style="padding:10px 0px 10px 0px">
      <!-- <div class="col-md-2">
      </div> -->
      <div class="col-xl-8" style="margin-left:15%">

        <!-- div for adverts -->
        <?php
          if(isset($advert)){
        ?>
            <div class="row audio-disp-div">
              <div class="row col-md-12">
                <!-- <div class="col-md-2"></div> -->
                <div class="col-xl-10 audio-type" style="margin-left:15%">Advert</div>
              </div>

              <!-- audio media div for advert -->
              <div class="row col-md-12" style="padding-top:15px">
                <div class="col-md-3"></div>
                <div id="" class="col-md-7">
                  <div class="row col-md-12">
                    <img src="<?php echo $ad_cover_pix;?>" alt="" class="img img-fluid" style="width:100%;height:100%">
                  </div>
                  <div class="row col-md-12">
                    <audio src="<?php echo $ad_audio_file;?>" preload="auto">
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>

              

              <!-- advert info -->
              <div class="row col-md-12 advert-info">
                <div class="col-md-3"></div>
                <div class="col-md-7" style="">
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
                <div class="col-md-2"></div>

              </div>
              

            </div>
        <?php
          }
        ?>

        <!-- div for promos -->
        <div class="row audio-disp-div">
          <div class="row col-md-12">
            <div class="col-xl-10 audio-type" style="margin-left:15%">Promos</div>
          </div>

          <!-- audio medias div for promos -->
          <div class="row col-md-12" style="padding-top:15px">
            <!-- Promos -->
            <div class="col-md-3"></div>
            <!-- <div class=" row"> -->

              <div style="padding:2px;margin-left:0px" class="col-md-8 row">
                <?php
                  $promCount=0;
                  if(!empty($all_promos)){
                    foreach($all_promos as $promo){

                      $promo_id=$promo['promo_id'];
                      $promoted_audios=json_decode($promo['promoted_audios'],true);
                      $should_display=0;
                      foreach($promoted_audios as $promaud){
                        $audio_id=$promaud;
                        $audio_details=$audio_production->details($audio_id);
                        $is_deleted=$audio_details['deleted'];
                        if($is_deleted==0){
                          $should_display=1;
                        }
                      }
                      if($should_display==0){
                        continue;
                      }
                      $promCount++;
                      $audio_id=$promoted_audios[0];
                      $audio_details=$audio_production->details($audio_id);
                      $audio_name=$audio_details['audio_name'];
                      $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);

                      $channel_id=$promo['channel_id'];
                      $channel_details=$channel->details($channel_id);
                      $channel_name=$channel_details['channel_name'];
                      $channel_logo=$channel_details['logo'];

                ?>
                      <div class="col-md-5" style="padding-top:10px;">
                        <a href="promo.php?pid=<?php echo base64_encode($promo_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                        <div class="col-md-12">
                          <span class="audio-name"><?php echo $audio_name;?></span>
                        </div>
      
                        <div id="" class="col-md-12 row" style="margin-left:0px;margin-top:5px;">
                          <img src="<?php echo $audio_cover_pix;?>" alt="" class="img img-fluid" style="width:100%;height:100%;">
                        </div>
                        <div class="col-md-12 row" style="margin-top:5px;">
                          <div class="col-md-3">
                            <img src="<?php echo $channel_logo;?>" class="img img-fluid rounded-circle" alt="" style="">
                          </div>
                          <div class="col-md-9"><span class="channel-name"><?php echo $channel_name;?></span></div>
      
                        </div>
                        </a>
                      </div>
                <?php
                      if($promCount==10) break;
                    }
                  }else{
                    echo "No promo yet";
                  }
                ?>

              </div>  
            <!-- </div> -->
            <div class="col-md-1"></div>


          </div>
        </div>

        <!-- div for free audios -->
        <div class="row audio-disp-div">
          <div class="row col-md-12">
            <div class="col-xl-10 audio-type" style="margin-left:15%">Free Audios</div>
          </div>

          <!-- audio medias div for promos -->
          <div class="row col-md-12" style="padding-top:15px">
            <!-- Promos -->
            <div class="col-md-3"></div>
            <!-- <div class=" row"> -->

              <div style="padding:2px;margin-left:0px" class="col-md-8 row">

                <?php
                  $freeCount=0;
                  if(!empty($all_free_audios)){
                    foreach($all_free_audios as $free_audio){
                      $is_deleted=$free_audio['deleted'];
                      if($is_deleted==0){
                        $audio_id=$free_audio['audio_id'];
                        $audio_details=$audio_production->details($audio_id);
                        $audio_name=$audio_details['audio_name'];
                        $is_deleted=$audio_details['deleted'];
                        $audio_cover_pix=$audio_production->get_audio_cover_pix($audio_id);

                        $channel_id=$free_audio['channel_id'];
                        $channel_details=$channel->details($channel_id);
                        $channel_name=$channel_details['channel_name'];
                        $channel_logo=$channel_details['logo'];
                        if($is_deleted==0){
                          $freeCount++;
                ?>
                          <div class="col-md-5" style="padding-top:10px;">
                            <a href="audio_play.php?pid=<?php echo base64_encode($audio_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                            <div class="col-md-12">
                              <span class="audio-name"><?php echo $audio_name;?></span>
                            </div>
          
                            <div id="" class="col-md-12 row" style="margin-left:0px;margin-top:5px;">
                              <img src="<?php echo $audio_cover_pix;?>" alt="" class="img img-fluid" style="width:100%;height:100%;">
                            </div>
                            <div class="col-md-12 row" style="margin-top:5px;">
                              <div class="col-md-3">
                                <img src="<?php echo $channel_logo;?>" class="img img-fluid rounded-circle" alt="" style="">
                              </div>
                              <div class="col-md-9"><span class="channel-name"><?php echo $channel_name;?></span></div>
          
                            </div>
                            </a>
                          </div>
                <?php
                        }
                      }
                      if($freeCount==10) break;
                    }
                  }else{
                    echo "No free audio yet";
                  }
                ?>

              </div>  
            <!-- </div> -->
            <div class="col-md-1"></div>


          </div>
        </div>

        <!-- div for suggested audios -->
        <div class="row audio-disp-div">
          <div class="row col-md-12">
            <!-- <div class="col-md-2"></div> -->
            <div class="col-xl-10 audio-type" style="margin-left:15%">Suggestions</div>
          </div>

          <!-- audio media div for suggested audios -->
          <div class="row col-md-12" style="padding-top:15px">
            <div class="col-md-3"></div>
            <div class="col-md-8">
              <!-- Rate, subscribe, add to cart -->
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
                      $is_deleted=$audio_details['deleted'];
                      $audio_rating=$audio_production->get_audio_rating($audio_id);
                      $audio_artistes=$audio_details['artistes'];
                      $audio_price=$audio_details['price'];
                      $date_uploaded=$audio_details['date_uploaded'];
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
                              <div class="row col-md-12" style="font-size:18px">
                                <span class="audio-name"><?php echo $audio_name;?></span>
                              </div>
                              <div class="row col-md-12" style="padding-top:8px;color:black"><span><?php echo $audio_artistes;?></span></div>
                              <div class="row col-md-12" style="padding-top:8px">
                                <div class="audio_rating" dRate="<?php echo $audio_rating;?>"></div>
                              </div>
                              <div class="row col-md-12" style="padding-top:8px;color:black"><span><?php echo $num_downloads;?> downloads</span></div>
                              <div class="row col-md-12" style="padding-top:8px;color:black"><span><?php echo $date_uploaded_ago;?></span></div>
                              <div class="row col-md-12" style="padding-top:8px;color:black"><span><?php echo "$price_currency ".$audio_price;?></span></div>
                              <div class="row col-md-12" style="padding-top:8px;margin-left:0px;padding-left:0px">
                                <div class="row">
                                  <div class="col-md-12" style="">
                                    <span class="channel-name" style="color:grey">Uploaded by <?php echo $channel_name;?></span>
                                  </div>
                                </div>
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
                }else{
                  echo "No audio for suggestion";
                }
              ?>
                
              
              
            </div>
            
            <div class="col-md-1"></div>
          </div>
          

        </div>
      </div>
      <!-- <div class="col-md-2">
      </div> -->
    </div>




    

    <?php
      include "footer.php";
    ?>

  </body>

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
  </script>

  

</html>
