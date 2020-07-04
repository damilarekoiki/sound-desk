<?php
    include("app/init.php");
    
    if(!isset($_GET['cid'],$_GET['oid'])){
      header("Location: index.php");
      exit(0);
    }
    $channel_id=base64_decode($_GET['cid']);
    $owner_id=base64_decode($_GET['oid']);
    if(!$channel->exists($channel_id,$owner_id)){
      header("Location: index.php");
      exit(0);
    }
    $channel_details=$channel->details($channel_id);
    $channel_name=$channel_details['channel_name'];
    $channel_brand_location=$channel_details['brand_location'];
    $channel_description=$channel_details['description'];
    $channel_logo=$channel_details['logo'];
    $channel_cover_pix=$channel_details['cover_pix'];


    $all_countries=$master->fetch_all_countries();
    $all_audio_categories=$audio_production->fetch_all_category();

    $all_uploads=$channel->fetch_all_channel_uploads($channel_id);
    $all_promos=$channel->fetch_all_channel_promos($channel_id);
    $all_adverts=$channel->fetch_all_channel_adverts($channel_id);

    $all_priced_audios=$audio_production->fetch_all_priced_audios();
    shuffle($all_priced_audios);

    $user->update_user_visited_channel($loggedin_user_id,$channel_id);

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
    <link href="assets/css/index.css" rel="stylesheet">
    <link href="assets/css/channel.css" rel="stylesheet">
    <link href="assets/css/radio_button.css" rel="stylesheet">

    <link href="assets/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/tooltipster/dist/css/tooltipster.bundle.min.css" />
    <link rel="stylesheet" href="assets/rateYo/src/jquery.rateyo.css">


    <style>
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 5px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        /* width: 250px;
        height: 250px; */
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .cropit-preview-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input, .export {
        /* Use relative position to prevent from being covered by image background */
        position: relative;
        z-index: 10;
        display: block;
      }

      button {
        margin-top: 10px;
      }

      .audio-player-wrapper {
        margin-top:auto !important;
      }

      .audiojs{
        /* width:100%; */
        /* height:auto; */
        /* padding-top:4px; */
      }

      /* .audiojs .scrubber{
        width:60%
      }
      .audiojs .play-pause{
        width:20%
      }
*/
      .audiojs .time{
        /* width:20% */
        /* display: none; */
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
        // if(!isset($_SESSION['email'])){
        //     include("header_not_loggedin.php");
        // }else{
          include("header_loggedin_bg.php");
        // }
    ?>

    <header class="masthead" style="padding:0px;background:none;height:auto;min-height:auto;">
        <img src="<?php echo $channel_cover_pix;?>" alt="" class="img img-fluid coverpage-tooltip " style="cursor:pointer" title="Double click to change cover photo" id="channelCoverPhoto">
    </header>
    



    <div class="row col-md-12" style="padding:10px 0px 10px 0px;">
      <div class="col-md-5" style="margin-left:15%">
        <div class="row col-md-12">
          <div class="col-md-12 channel-logo-div" style="padding:auto;">
              <img src="<?php echo $channel_logo;?>" alt="Channel Logo" class="img img-fluid channel-logo" style="margin-top:30px;width:50px;height:50px;cursor:pointer" id="channelLogo" title="Double click to change channel logo">
              <span class="channel-name" style="margin:auto;padding:auto;font-size:20px"><?php echo $channel_name;?></span>
          </div>
          <!-- <div class="channel-name-div col-md-8" style="margin:auto;padding:auto;">
              <span class="channel-name" style="margin:auto;padding:auto;font-size:20px">Invisible Ray</span>
          </div> -->
        </div>
      </div>
    </div>

              

    <div class="row col-md-12" style="padding:20px 0px 10px 0px">
      <div class="col-md-1">
          

      </div>
      <div class="col-md-8" style="">

        <div class="col" style="padding-top:35px">
          <div class="row col-md-12">All Uploads</div>
          <div class="row col-md-12" style="margin-top:10px;">
            <?php
            if(!empty($all_uploads)){
              foreach($all_uploads as $upload){
                $audio_id=$upload['audio_id'];
                $audio_name=$upload['audio_name'];
                $is_free=$upload['is_free'];
                $audio_price=$upload['price'];
                $is_deleted=$upload['deleted'];
                $price_text="";

                if($is_free==0 && $is_deleted==0){
                  $price_text=$audio_price;
                }else{
                  $price_text="Free";
                }
                $cover_pix=$audio_production->get_audio_cover_pix($audio_id);
            ?>
              <div class="col-md-4">
                <a href="audio_play.php?pid=<?php echo base64_encode($audio_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                  <div class="row col-md-12">
                    <img src="<?php echo $cover_pix;?>" class="img img-fluid" style="width:100%;height:100%">
                  </div>
                  <div class="row col-md-12">
                    <span class="audio-name"><?php echo $audio_name;?></span>
                  </div>
                  <div class="row col-md-12">
                    <span class="audio-name"><?php echo $price_text;?></span>
                  </div>
                </a>
              </div>
            <?php
              }
            }else{
              echo "No uploads yet";
            }
            ?>
          </div>
        </div>

        <div class="col" style="padding-top:35px">
          <div class="row col-md-12">All Promos</div>
          <div class="row col-md-12" style="">
            <?php
              $promCount=0;
              if(!empty($all_promos)){
                foreach($all_promos as $promo){

                  $promo_id=$promo['promo_id'];
                  $promo_code=$promo['promo_code'];
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
                  <div class="col-md-4" style="margin-top:10px;">
                    <a href="promo.php?pid=<?php echo base64_encode($promo_id);?>&cid=<?php echo base64_encode($channel_id);?>">
                      <div class="row col-md-12">
                        <img src="<?php echo $audio_cover_pix;?>" class="img img-fluid" style="width:100%;height:100%">
                      </div>
                      <div class="row col-md-12">
                        <span class="audio-name">Promo Code:&nbsp;<?php echo $promo_code;?></span>
                      </div>
                    </a>
                  </div>
            <?php
                }
              }else{
                echo "No promo yet";
              }
            ?>
          </div>
        </div>

        <div class="col" style="padding-top:35px">
          <div class="row col-md-12">All Adverts</div>
          <div class="row col-md-12" style="">
            <?php
              if(!empty($all_adverts)){
                foreach($all_adverts as $advert){

                  $advert_id=$advert['advert_id'];
                  $advert_cover_pix=$advert['advert_cover_pix'];
                  $advert_audio_file=$advert['audio_file_path'];
                  $company_name=$advert['company_name'];
                  $company_website=$advert['company_website'];


            ?>
                  <div class="col-md-4" style="margin-top:10px;">
                    <div class="row col-md-12">
                      <img src="<?php echo $advert_cover_pix;?>" class="img img-fluid" style="width:100%;height:100%">
                    </div>
                    <div class="row col-md-12" id="">
                      <audio src="<?php echo $advert_audio_file;?>" preload="auto" >
                    </div>
                    <div class="row col-md-12">
                      Advertiser:&nbsp;<?php echo $company_name;?>&nbsp;&nbsp;
                      <?php
                        if($company_website!=""){
                      ?>
                          <a href="<?php echo $company_website;?>">
                            <span class="audio-name">Visit site</span>
                          </a>
                      <?php
                        }
                      ?>

                    </div>
                  </div>
            <?php
                }
              }else{
                echo "No promo yet";
              }
            ?>
          </div>
        </div>
      
      </div>

      <div class="col-md-3">
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



    <div class="hiddenfile" style="width:0px;height:0px">
      <input type="file" name="channel_logo" id="channelLogoFile">
    </div>



  
    <div class="container" id="cropitDiv" style="display:none;margin-top:50px;margin-bottom:50px">
      Drag Image
      <!-- Cropit div -->
      <div class="image-editor" style="padding:0px">
          <div class="hiddenfile">
              <input name="cover_photo" type="file" id="coverPhotoFile" class="cropit-image-input"/>
          </div>
          <div class="cropit-preview"></div>
          <div class="image-size-label" style="margin-top:20px">
              Zoom in or out
          </div>
          <input type="range" class="cropit-image-zoom-input">
          <div style="margin-top:20px">
              <img src="assets/img/circular-counterclockwise-arrow-rotation.png" alt="" width="20px" class="rotate-ccw"style="cursor:pointer"/>
              <img src="assets/img/clockwise-circular-arrow.png" alt="" width="20px" class="rotate-cw" style="margin-left:10px;cursor:pointer"/>
          </div>
          
          <form id="cropitUploadForm">
              <input type="hidden" name="upload_channel_cover_photo" value="1">
              <input type="hidden" name="image-data" id="imageData">
              <button class="export btn btn-submit" type="submit">Upload</button>
          </form>
      </div>
    </div>


    




    

    <?php
      include "footer.php";
    ?>

    


  </body>

    <script>
      audiojs.events.ready(function() {
        var as = audiojs.createAll();
      });
    </script>

  <script>
    $("#tiggerAudioCoverPhoto").click(function(){
      $("#audioCoverPhoto").trigger("click")
    })
    $("#triggerAdvertCoverPhoto").click(function(){
      $("#advertCoverPhoto").trigger("click")
    })
      var originalHeight = 150;
      var originalWidth = 300;
    $(function() {
      dividend=($("#cropitDiv").width()*40)/100

      var previewScale = (originalWidth /dividend);

      var previewHeight = Math.round(originalHeight / previewScale);
      var previewWidth = Math.round(originalWidth / previewScale);
      $('#uploadAudioCoverImageEditor, #AdvertCoverImageEditor').cropit({
        allowDragNDrop: false,
        exportZoom: previewScale,
        imageBackground: true,
        imageBackgroundBorderWidth: 20,
        width:previewWidth,
        height:previewHeight,
        // smallImage:'allow',
        imageState: {
          src: "assets/img/audio_cover_default.jpg",
        },
      });

      $('.rotate-cw').click(function() {
        $('.image-editor').cropit('rotateCW');
      });
      $('.rotate-ccw').click(function() {
        $('.image-editor').cropit('rotateCCW');
      });
      $('.export').click(function() {
        var imageData = $('.image-editor').cropit('export');
        window.open(imageData);
      });

    });
  </script>



  <script>
      $("#brandLocation").select2({
          placeholder:"Brand Location",
      })
      $("#audioCategory").select2({
          placeholder:"Audio Category",
      })

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
    $("#audioFile").change(function(e){
      filesPreview(this,"audio")
    })
    $("#audioCoverPhoto").change(function(e){
    })

    var audioObj=new Audio();
    var filesPreview = function(input,fileSel) {
      if (input.files) {
          
        fileType=input.files[0].type
        reader = new FileReader();

        reader.onload = function(event) {
            if(fileSel=="audio"){
                if(fileType=="audio/mp3" || fileType=="audio/mpeg"){
                  $("#previewAudioDiv").html("");
                  audio=document.createElement("audio")
                  $(audio).attr("src",event.target.result)
                  audioObj.src=event.target.result;
                  $(audio).attr("preload","auto")

                  $("#previewAudioDiv").append($(audio))
                  audiojs.events.ready(function() {
                      var as = audiojs.createAll();
                  });
                }
            }
        }
        reader.readAsDataURL(input.files[0]);   
      }
    };


    $("#advertAudio").change(function(e){
      filesPreviewAdvert(this,"audio")
    })
    $("#advertAudioCoverPix").change(function(e){
    })
    var filesPreviewAdvert = function(input,fileSel) {
      if (input.files) {
          
        fileType=input.files[0].type
        reader = new FileReader();

        reader.onload = function(event) {
            if(fileSel=="audio"){
                if(fileType=="audio/mp3" || fileType=="audio/mpeg"){
                  $("#advertPreviewAudioDiv").html("");
                  audio=document.createElement("audio")
                  $(audio).attr("src",event.target.result)
                  $(audio).attr("preload","auto")

                  $("#advertPreviewAudioDiv").append($(audio))
                  audiojs.events.ready(function() {
                      var as = audiojs.createAll();
                  });
                  $("#advertPreviewImage").show()
                }
            }
        }
        reader.readAsDataURL(input.files[0]);   
      }
    };
  </script>
  
  <script>
    $("#updateChannelForm").submit(function(e){
      e.preventDefault();
      btn=$("#updChannellBtn");
      btnValue=btn.text();
      btn.prop("disabled",true);
      btn.text("Please! Wait...");
      formData = new FormData(this);
      formData.append("channel_id",<?php echo $channel_id;?>)
      formData.append("update_channel",1)

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
              btn.text(btnValue)

              data=JSON.parse(data)
              if(data.status==1){
                  $("#updateChannelFormError").html("<div class='alert alert-success'>"+data.message+"</div>")
                  $("#updateChannelForm").trigger("reset")
                  
              }else{
                  $("#updateChannelFormError").html("<div class='alert alert-danger'>"+data.message+"</div>")
              }
          }
      })
    })

    $("#uploadAudioForm").submit(function(e){
      e.preventDefault()
      console.log(audioObj.duration);
      audioDuration=audioObj.duration;
      imageData = $('#uploadAudioCoverImageEditor').cropit('export');
      btn=$("#uploadAudioBtn");
      btnValue=btn.text();
      btn.prop("disabled",true);
      btn.text("Please! Wait...");
      formData = new FormData(this);
      formData.append("channel_id",<?php echo $channel_id;?>)
      formData.append("audio_duration",audioDuration)
      formData.append("audio_cover_photo",imageData)
      formData.append("upload_audio",1)

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
              btn.text(btnValue)

              data=JSON.parse(data)
              $('html, body').animate({
                scrollTop: $("#uploadAudioFormError").offset().top-90
              }, 200);
              if(data.status==1){
                  $("#uploadAudioFormError").html("<div class='alert alert-success'>"+data.message+"</div>")
                  setTimeout(() => {
                    location.reload();
                  }, 1000);              
              }else{
                  $("#uploadAudioFormError").html("<div class='alert alert-danger'>"+data.message+"</div>")
              }
          }
      })
      
    })

    $("#promoteAudioForm").submit(function(e){
      e.preventDefault()

      btn=$("#promSubmit");
      btnValue=btn.text();
      btn.prop("disabled",true);
      btn.text("Please! Wait...");
      formData = new FormData(this);
      formData.append("channel_id",<?php echo $channel_id;?>)
      formData.append("promote_audios",1)

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
              btn.text(btnValue)

              data=JSON.parse(data)
              $('html, body').animate({
                scrollTop: $("#promoteAudioFormError").offset().top-90
              }, 200);
              if(data.status==1){
                  $("#promoteAudioFormError").html("<div class='alert alert-success'>"+data.message+"</div>")
                  setTimeout(() => {
                    location.reload();
                  }, 1000);              
              }else{
                  $("#promoteAudioFormError").html("<div class='alert alert-danger'>"+data.message+"</div>")
              }
          }
      })
      
    })

    $("#advertForm").submit(function(e){
      e.preventDefault()

      btn=$("#adSubmit");
      btnValue=btn.text();
      imageData = $('#AdvertCoverImageEditor').cropit('export');
      btn.prop("disabled",true);
      btn.text("Please! Wait...");
      formData = new FormData(this);
      formData.append("channel_id",<?php echo $channel_id;?>)
      formData.append("advert_audio_cover_pix",imageData)
      formData.append("make_advert",1)

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
              btn.text(btnValue)

              data=JSON.parse(data)
              $('html, body').animate({
                scrollTop: $("#advertFormError").offset().top-90
              }, 200);
              if(data.status==1){
                  $("#advertFormError").html("<div class='alert alert-success'>"+data.message+"</div>")
                  setTimeout(() => {
                    location.reload();
                  }, 1000);              
              }else{
                  $("#advertFormError").html("<div class='alert alert-danger'>"+data.message+"</div>")
              }
          }
      })
      
    })
  </script>

  <script>
    $("#audioOnChannSel").select2({
      placeholder:"Select audios from your channel",
      width:"100%"

    })
    $("#showAdvertDiv").click(function(){
      $("#advertDiv").show()
    })
    $("#audOnChannelRadio").click(function(){
      if($(this).is(":checked")){
        $("#audioOnChannSelDiv").show();
      }
    })
    $("#otherProdRadio").click(function(){
      if($(this).is(":checked")){
        $("#audioOnChannSelDiv").hide();
      }
    })
  </script>

  <script>
    $("#promotedAudio").select2({
        placeholder:"Select audios from your channel"
    })
    $("#audiosForDiscPromo").select2({
        placeholder:"Select audios from your channel"
    })
    $("#audiosForFreePromo").select2({
        placeholder:"Select audios from your channel"
    })
    $("#promotionType").select2({
        placeholder:"Select promotion type"
    })



    $("#discount_helper_audio").on("input",function(){
      if($(this).val()!="" && $("#"+audioSelId).val()!="" && $("#promotedAudio").val()!="" && $("#"+howManyAudioPromoField).val()>=1){
        $("#promSubmit").prop("disabled",false);
      }else{
        $("#promSubmit").prop("disabled",true);
      }

      if($(this).val()!=""){
        if($(this).val()<1){
          $(this).val(1)
        }
        if($(this).val()>100){
          $(this).val(100)
        }
      }
    })


    var promotedAudio=[]
    $("#promotedAudio").change(function(){
      $("#promTypDiv").show();
      promotedAudio=[];
      obj=$(this).find("option");
      $.each(obj,function(){
        if($(this).is(":selected")){
          promotedAudio.push($(this).val())
        }
      })


      if($("#"+audioSelId).val()!="" && $(this).val()!="" && $("#"+howManyAudioPromoField).val()>=1){
        if($(this).attr("id")=="audiosForDiscPromo"){
          if($("#discount_helper_audio").val()==""){
            $("#promSubmit").prop("disabled",true);
          }else{
            $("#promSubmit").prop("disabled",false);
          }
        }else{
          $("#promSubmit").prop("disabled",false);
        }
      }else{
        $("#promSubmit").prop("disabled",true);
      }

      
      console.log()
      $.each($(".audios-for-promo"),function(){
        selElem=$(this);
        selectAudio=$(this).find("option");
        $.each(selectAudio,function(){
          selAudio=$(this);
          if($.inArray($(this).val(),promotedAudio)!=-1){
            selAudio.prop("disabled",true);
            selElem.select2();
            selAudio.prop("selected",false);
            selAudio.trigger("change.select2");
          }else{
            selAudio.prop("disabled",false);
            selElem.select2();
          }
        })
      })

      numUploads="<?php echo count($all_uploads);?>"

      $.each($(".prom-audio-how-many"),function(){
        if($(this).val()!=""){
          $(this).val(numUploads-promotedAudio.length);
        }
      })
      
    })

    var PromAudios=[];
    var audioSelId="audiosForDiscPromo";
    var howManyAudioPromoField="";
    $(".audios-for-promo").change(function(){
      console.log("changed")
      selProm=$(this);
      audioSelId=$(this).attr("id");
      targNumField=$(this).attr("targNumField");
      howManyAudioPromoField=targNumField;
      if($(this).attr("id")!=""){
        if($(this).val()!="" && $("#promotedAudio").val()!="" && $("#"+targNumField).val()>=1){
          if($(this).attr("id")=="audiosForDiscPromo"){
            if($("#discount_helper_audio").val()==""){
              $("#promSubmit").prop("disabled",true);
            }else{
              $("#promSubmit").prop("disabled",false);
            }
          }else{
            $("#promSubmit").prop("disabled",false);
          }
        }else{
          $("#promSubmit").prop("disabled",true);
        }
      }
    })
    $(".audios-for-promo").on("select2:select", function(e) {
      selProm=$(this);
      audioSelId=$(this).attr("id");
      targNumField=$(this).attr("targNumField");
      howManyAudioPromoField=targNumField;
      
      PromAudios=[];
      
      obj=$(this).find("option");
      $.each(obj,function(){
        if($(this).is(":selected")){
          PromAudios.push($(this).val())
        }
      })
      if(PromAudios.length==$("#"+targNumField).val()){
        $.each(obj,function(){
          if(!$(this).is(":selected")){
            $(this).prop("disabled",true);
            selProm.select2();
          }else{
            $(this).prop("disabled",false);
            selProm.select2();
          }
        })
      }else{
        
      }
    })
    
    var howManyForPromo=0;
    $(".prom-audio-how-many").on("input",function (e) {
      promAudioHowMany=$(this);
      targSel=promAudioHowMany.attr("targSel");
      targRadio=promAudioHowMany.attr("targRadio");
      targNote=promAudioHowMany.attr("targNote");
      targDiv=promAudioHowMany.attr("targDiv");

      if(promAudioHowMany.val()>numUploads-promotedAudio.length){
        promAudioHowMany.val(numUploads-promotedAudio.length);
      }

      if(promAudioHowMany.val()!=""){
        if(promAudioHowMany.val()<1){
          promAudioHowMany.val(1);
        }
        if(promAudioHowMany.val()%1!==0){
          promAudioHowMany.val(Math.trunc(promAudioHowMany.val()));
        }
      }
      
      
      // When a new value is entered enable disabled audio options that have not been selected to be promoted
      obj=$("#"+targSel).find("option")
      $.each(obj,function(){
        if($(this).prop("disabled")==true){
          if($.inArray($(this).val(),promotedAudio)==-1){
            $(this).prop("disabled",false);
            $("#"+targSel).select2();
          }
          
        }
      })

      // All selected option
      selOptions=$("#"+targSel).find("option:selected");
      length_selOptions=selOptions.length;
      lastOption=selOptions.eq(length_selOptions-1);

      // check if user has entered a lower number than the previous number
      if($(this).val()!=""){
        if($(this).val()<howManyForPromo){
          howManyForPromo=$(this).val();
          for(i=howManyForPromo;i<length_selOptions;i++){
            selOptions.eq(i).prop("selected",false); // deselect other options
            $("#"+targSel).trigger("change.select2");
            selOptions.eq(i).prop("disabled",true);
            $("#"+targSel).select2();
          }
        }if($(this).val()<howManyForPromo){
          obj=$("#"+targSel).find("option")
          $.each(obj,function(){
            if($(this).prop("disabled")==true){
              if($.inArray($(this).val(),promotedAudio)==-1){
                $(this).prop("disabled",false);
                $("#"+targSel).select2();
              }
              
            }
          })
        }
      }
      
      // in case, condition is not true; this assignment has to be below the condition statement
      if($(this).val()!=""){
        howManyForPromo=$(this).val();
      }
      
      // if it is a number
      if(isNaN($(this).val())==false){
        if($(this).val()>=1){
          $("#"+targDiv).show();
          // $("#"+targRadio).prop("checked","checked")
          $("#"+targNote).hide();
          if($("#"+targSel).val()!="" && $("#promotedAudio").val()!=""){
            if(audioSelId=="audiosForDiscPromo"){
              if($("#discount_helper_audio").val()==""){
                $("#promSubmit").prop("disabled",true);
              }else{
                $("#promSubmit").prop("disabled",false);
              }
            }else{
              $("#promSubmit").prop("disabled",false);
            }
          }
        }else{
          // $("#freeDecideDiv, #audioFreePromDiv").hide();
          if($("#"+targSel).val()=="" || $("#promotedAudio").val()==""){
            $("#promSubmit").prop("disabled",true);
          }
          $("#"+targNote).show()
        }
      }else{
        // $("#freeDecideDiv, #audioFreePromDiv").hide();
        $("#promSubmit").prop("disabled",true);
        $("#"+targNote).show()
      }

      if($(this).val()==""){
        $("#promSubmit").prop("disabled",true);
        $("#"+targNote).show()
      }
    })


    $("#promoDiscount").on("input",function(){
      if($(this).val()!="" && $("#promotedAudio").val()!=""){
        $("#promSubmit").prop("disabled",false);
      }else{
        $("#promSubmit").prop("disabled",true);
      }
    })


    $("#promotionType").change(function(){
      dTarget=$(this).find(":selected").attr("dTarget");
      $(".promFormDiv").not("#"+dTarget).hide();
      $("#"+dTarget).show();

      optionValue=$(this).val();
      if(optionValue==1){
        if($("#promoDiscount").val()!="" && $("#promotedAudio").val()!=""){
          $("#promSubmit").prop("disabled",false);
        }else{
          $("#promSubmit").prop("disabled",true);
        }
      }else if(optionValue==2){
        if($("#audiosForFreePromo").val()!="" && $("#promotedAudio").val()!="" && $("#numFreePromotion").val()>=1){
          $("#promSubmit").prop("disabled",false);
        }else{
          $("#promSubmit").prop("disabled",true);
        }
      }else if(optionValue==3){
        if($("#discount_helper_audio").val()!="" && $("#audiosForDiscPromo").val()!="" && $("#promotedAudio").val()!="" && $("#numDiscountPromotion").val()>=1){
          $("#promSubmit").prop("disabled",false);
        }else{
          $("#promSubmit").prop("disabled",true);
        }
      }
      
    })

    $("#meFreeRadioBtn, #meDiscPromoRadioBtn").click(function(){
      if($("#meFreeRadioBtn").is(":checked")){
        $("#audioFreePromDiv").show()
      }else if($("#meDiscPromoRadioBtn").is(":checked")){
        $("#audioDiscPromDiv, #discPromDiv").show()
      }
    })
    $("#cusFreeRadioBtn, #cusDiscPromoRadioBtn").click(function(){
      if($("#cusFreeRadioBtn").is(":checked")){
        $("#audioFreePromDiv").hide()
      }if($("#cusDiscPromoRadioBtn").is(":checked")){
        $("#audioDiscPromDiv, #discPromDiv").hide()
      }
    })

    

    
  </script>

  <script>
    $(".hide-form").click(function(){
      $(this).parents(".form-div").hide();
    })
  </script>

  <script>
    $("#navSearchBtn").click(function() {
      $(".nav-text").hide(function(){
        $(".nav-search").show()
      })
    })

    $("#searchCancel").click(function(){
      $(".nav-search").hide(function(){
        $(".nav-text").show()
      })
    })
  </script>

    <script>
      $("#paidRadioBtn").click(function(){
        if($(this).is(":checked")){
          $(".notFreeDiv").show();
        }
      })

      $("#freeRadioBtn").click(function(){
        if($(this).is(":checked")){
          $(".notFreeDiv").hide();
          $("#audioPrice").val("");
        }
      })
    </script>

  <script>
    $(document).ready(function() {
        $('.coverpage-tooltip').tooltipster();
        $('#channelLogo').tooltipster();
        $('#hideForm').tooltipster();
        
    });

    $("#channelLogo").dblclick(function(){
        $('#channelLogo').val("");
        $('#channelLogoFile').trigger('click'); 
    })

    $("#channelLogoFile").change(function(){
      alert($('#channelLogoFile').val())

        $("#channelLogo").attr("src",$('#channelLogoFile').val());
    })

    $("#channelCoverPhoto").dblclick(function(){
        $('#coverPhotoFile').val("");
        $('#coverPhotoFile').trigger('click'); 
    })

    $("#coverPhotoFile").change(function(){
        $("#cropitDiv").show();
        $("html, body").animate({ scrollTop: $('#cropitDiv').offset().top }, 1000);
    })

    $("#uploadAudio").click(function(){
      $("#uploadAudioDiv").show();
    })
  </script>
  
  <script>
    $("#editChannel").click(function(){
      $("#channelEditDiv").show();
    })

    $("#promoteAudio").click(function(){
      $("#promoteAudioDiv").show();
    })
  </script>

  <script>
    //   var originalHeight = 510;
    //   var originalWidth = 1521;

    //   var previewScale = (originalWidth /500);

    //   var previewHeight = Math.round(originalHeight / previewScale);
    //   var previewWidth = Math.round(originalWidth / previewScale);
    // $(function() {
    //   $('#xkkd').cropit({
    //       allowDragNDrop: false,
    //     exportZoom: previewScale,
    //     imageBackground: true,
    //     imageBackgroundBorderWidth: 20,
    //     width:previewWidth,
    //     height:previewHeight,
    //     smallImage:'allow',
    //     imageState: {
    //       // src: 'http://lorempixel.com/500/400/',
    //     },
    //   });

    //   $('.rotate-cw').click(function() {
    //     $('.image-editor').cropit('rotateCW');
    //   });
    //   $('.rotate-ccw').click(function() {
    //     $('.image-editor').cropit('rotateCCW');
    //   });
    //   $('.export').click(function() {
    //     var imageData = $('.image-editor').cropit('export');
    //     window.open(imageData);
    //   });

    // });
  </script>

  <script>
      $('#cropitUploadForm').submit(function(e) {
          e.preventDefault();
          // Move cropped image data to hidden input
          var imageData = $('.image-editor').cropit('export');
          $('.imageData').val(imageData);

          // Print HTTP request params
          var formValue = $(this).serialize();
          //$('#result-data').text(formValue);

          $.ajax({
              type: "POST",
              url : "parsers/channel_parser.php",
              data: formValue,
              success: function(msg){
                  //$("#AjaxResult").html(msg);
                  alert(msg);
              }
          })
      });
  </script>

</html>
