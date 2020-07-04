<?php
    include "../app/init.php";

    if(isset($_POST['create_channel'])){
        $channel_name=$_POST['channel_name'];
        $t_channel_name=preg_replace('/\s+/','',$channel_name);
        if(empty($t_channel_name) || !isset($_POST['brand_location'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Fill all fields"]));
        }
        if($channel->name_exists($channel_name,$loggedin_user_id)){
            exit(json_encode(["status"=>0,"message"=>"You already own this channel $channel_name"]));

        }
        $brand_location=$_POST['brand_location'];
        $channel_id=$channel->create($channel_name,$brand_location,$loggedin_user_id);
        $enc_channel_id=base64_encode($channel_id);
        $enc_loggedin_user_id=base64_encode($loggedin_user_id);

        exit(json_encode(["status"=>1,"message"=>"Channel created successfully", "url"=>"channel.php?cid=$enc_channel_id&oid=$enc_loggedin_user_id"]));

    }

    if(isset($_POST['update_channel'])){
        $channel_description=$_POST['channel_description'];
        $t_channel_description=preg_replace('/\s+/','',$channel_description);
        if(empty($t_channel_description) || !isset($_POST['brand_location'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Fill all fields"]));
        }
        $brand_location=$_POST['brand_location'];
        $channel_id=$_POST['channel_id'];

        $channel->update($channel_id,$channel_description,$brand_location);

        exit(json_encode(["status"=>1,"message"=>"Channel updated successfully"]));

    }

    if(isset($_POST['upload_audio'])){
        
        $audio_name=$_POST['audio_title'];
        $audio_description=$_POST['audio_description'];
        $audio_price=$_POST['audio_price'];
        $is_free=$_POST['is_free'];
        $payment_mode=$_POST['payment_mode'];
        $artistes=$_POST['artistes'];
        $duration=$_POST['audio_duration'];        
        $minimum_age=preg_replace('/\s+/','',$_POST['minimum_age']);
        $maximum_age=preg_replace('/\s+/','',$_POST['maximum_age']);
        $cover_pix=$_POST['audio_cover_photo'];
        $channel_id=$_POST['channel_id'];
        $owner_id=$loggedin_user_id;

        $t_audio_name=preg_replace('/\s+/','',$audio_name);
        $t_audio_description=preg_replace('/\s+/','',$audio_description);
        $audio_price=preg_replace('/\s+/','',$audio_price);

        $allowedFiles=["image/jpg","image/jpeg","image/JPG","image/png","image/PNG","image/jfif"];
        $allowFile=1;
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type with mimetype extension   
        $file_type = finfo_file($finfo, $cover_pix);
        finfo_close($finfo);
        if(!in_array($file_type,$allowedFiles)){
            $allowFile=0;
        }

        if($allowFile==0){
            exit(json_encode(array("status"=>0,"message"=>"Select profile image not more than 1mb: Gif not allowed")));
        }


        if(!is_uploaded_file($_FILES['audio_file']['tmp_name'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Select an audio file"]));
        }

        if($t_audio_name==""){
            exit(json_encode(["status"=>0,"message"=>"Please! Enter an audio title"]));
        }
        if($t_audio_description==""){
            exit(json_encode(["status"=>0,"message"=>"Please! Enter an audio description"]));
        }

        if(!isset($_POST['audio_category'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Select an audio category"]));
        }

        if($is_free==1 && preg_replace('/\s+/','',$audio_price)!=""){
            exit(json_encode(["status"=>0,"message"=>"Please! Enter price for audio"]));
        }

        if($is_free==0 && preg_replace('/\s+/','',$audio_price)==""){
            exit(json_encode(["status"=>0,"message"=>"Price cannot be entered for free audio"]));
        }

        $audio_category=$_POST['audio_category'];

        $upload_audio=$audio_production->upload($audio_name,$channel_id,$owner_id,$audio_category,
        $audio_price,$audio_description,$minimum_age,$maximum_age,$is_free,$payment_mode,$artistes,$duration,$cover_pix);

        exit($upload_audio);
    }

    if(isset($_POST['promote_audios'])){
        if(!isset($_POST['promoted_audio'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Select an audio for promotion"]));
        }
        if(!isset($_POST['promotion_type'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Select a promotion type"]));
        }

        if($_POST['promotion_type']==1){
            if($_POST['promo_discount']==""){
                exit(json_encode(["status"=>0,"message"=>"Please! Enter a discount for the selected audios"]));
            }
        }elseif($_POST['promotion_type']==2){
            if($_POST['num_free_promotion']==""){
                exit(json_encode(["status"=>0,"message"=>"Please! Specify the number of audios customer will get for free"]));
            }else{
                if(!isset($_POST['decide_free_promo'])){
                    exit(json_encode(["status"=>0,"message"=>"Please! Specify who decides the audios that customers will get for free"]));
                }
                if($_POST['decide_free_promo']==1){
                    if(!isset($_POST['audios_for_freePromo'])){
                        exit(json_encode(["status"=>0,"message"=>"Please! Specify audios that customer will get for free"]));

                    }
                }
            }
        }elseif($_POST['promotion_type']==3){
            if($_POST['num_discount_promotion']==""){
                exit(json_encode(["status"=>0,"message"=>"Please! Specify the number of audios customer will get on discount"]));
            }else{
                if(!isset($_POST['decide_discount_promo'])){
                    exit(json_encode(["status"=>0,"message"=>"Please! Specify who decides the audios that customers will get on discount"]));
                }
                if($_POST['decide_discount_promo']==1){
                    if(!isset($_POST['audios_for_discPromo'])){
                        exit(json_encode(["status"=>0,"message"=>"Please! Specify audios that customer will get for free"]));

                    }
                    if($_POST['discount_helper_audio']){
                        exit(json_encode(["status"=>0,"message"=>"Please! Enter a discount for the selected audios"]));
                    }
                }
            }
        }

        $channel_id=$_POST['channel_id'];
        $owner_id=$loggedin_user_id;

        $promoted_audios=json_encode($_POST['promoted_audio']);
        $promo_type=$_POST['promotion_type'];

        $audios_to_get="";
        $num_audios_to_get=0;
        $discount="";
        $audios_to_get_decider=0;
        $audios_to_get_is_free=0;

        if($promo_type==1){
            $audios_to_get="";
            $num_audios_to_get=0;
            $discount=$_POST['promo_discount'];
            $audios_to_get_decider=0;
            $audios_to_get_is_free=0;
        }elseif($promo_type==2){
            $audios_to_get=json_encode($_POST['audios_for_freePromo']);
            $num_audios_to_get=$_POST['num_free_promotion'];
            $discount="";
            $audios_to_get_decider=$_POST['decide_free_promo'];
            $audios_to_get_is_free=1;
        }elseif($promo_type==3){
            $audios_to_get=json_encode($_POST['audios_for_discPromo']);
            $num_audios_to_get=$_POST['num_discount_promotion'];
            $discount=$_POST['discount_helper_audio'];
            $audios_to_get_decider=$_POST['decide_discount_promo'];
            $audios_to_get_is_free=0;
        }

        if(preg_replace('/\s+/','',$_POST['end_date'])==""){
            exit(json_encode(["status"=>0,"error"=>1,"message"=>"Please enter end date"]));            
        }

        if(strtotime(is_nan(strtotime($_POST['end_date'])))){
            exit(json_encode(["status"=>0,"error"=>1,"message"=>"Please select a valid date"]));            
        }

        $end_date=$_POST['end_date'];

        $audio_production->promote($promoted_audios,$audios_to_get,$num_audios_to_get,$promo_type,$discount,$audios_to_get_is_free,$audios_to_get_decider,$channel_id,$owner_id,$end_date);

        exit(json_encode(["status"=>1,"message"=>"The promotion was successful"]));      
    }

    if(isset($_POST['make_advert'])){
        $company_name=$_POST['company_name'];
        $company_website=$_POST['company_website'];
        $channel_id=$_POST['channel_id'];
        $cover_pix=$_POST['advert_audio_cover_pix'];
        $owner_id=$loggedin_user_id;

        if(!is_uploaded_file($_FILES['advert_audio']['tmp_name'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Select an audio file"]));
        }
        if(!isset($_POST['which_prod_ad'])){
            exit(json_encode(["status"=>0,"message"=>"Please! Specify the product you are advertising"]));

        }
        $which_prod_ad=$_POST['which_prod_ad'];
        $audios_on_channel_to_advertise="";
        if($which_prod_ad==1){
            if(!isset($_POST['audio_on_channel_ad'])){
                exit(json_encode(["status"=>0,"message"=>"Please! Select audios you are advertising"]));                
            }
            $audios_on_channel_to_advertise=json_encode($_POST['audio_on_channel_ad']);
        }
        if(preg_replace('/\s+/','',$company_name)==""){
            exit(json_encode(["status"=>0,"message"=>"Please! Enter company name"]));                
        }

        $audio_production->advertise($company_name,$company_website,$which_prod_ad,$audios_on_channel_to_advertise,$channel_id,$owner_id,$cover_pix);

        exit(json_encode(["status"=>1,"message"=>"The advert was successfully uploaded"])); 

    }

    if(isset($_POST['subscribe'])){
        $channel_id=$_POST['channel_id'];
        if($_POST['subscription']==1){
            $channel->subscribe($channel_id, $loggedin_user_id);
        }else{
            $channel->unsubscribe($channel_id, $loggedin_user_id);
        }
        exit(json_encode(["status"=>1,"message"=>"Successful"])); 

    }

    if(isset($_POST['rate_audio'])){
        $audio_id=$_POST['audio_id'];
        $rater_id=$loggedin_user_id;
        $rate=$_POST['rate'];
        $comment=$_POST['audio_rate_comment'];
        $audio_production->rate_audio($audio_id,$rater_id,$rate,$comment);

        $audio_comments=$audio_production->fetch_all_comments($audio_id);

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

                echo "<div class='row col-md-12' style='margin-top:8px;'>
                    <div class='row col-md-12'>
                        <div class='col-md-2 col-2'>
                            <img src='$rater_pix' alt='' class='img img-fluid rounded-circle float-right' style='width:50px;height:50px;'>
                        </div>
                        <div class='col-md-10 col-10'>
                            <span  class='' style='font-weight:bold;'>$rater_username</span>
                        </div>

                    </div>
                    <div class='row col-md-10 mx-2' style='margin-top:8px'>
                        <div class='user_audio_rating' dRate='$rater_audio_rate'></div>
                        <div><span  class='' style='font-size:13px;font-weight:bold;'>$when_rated</span></div>
                    </div>
                    <div class='row col-md-10 mx-2'>
                        <span  class=''>$rater_audio_comment</span>
                    </div>
                </div>";
            
            }
        }

        echo "
            <script>
            $('.user_audio_rating').each(function(){
                rate=$(this).attr('dRate');
                $(this).rateYo({
                    numStars: 5,
                    starWidth: '13px',
                    precision: 0,
                    rating: rate,
                    spacing: '1px',
                    fullStar: true,
                    readOnly: true
                
                });
            })
            </script>
        ";

    }

    if(isset($_POST['delete_audio'])){
        $audio_id=base64_decode($_POST['audio_id']);
        $audio_production->delete($audio_id);  
        exit(json_encode(["status"=>1,"message"=>"Audio deleted successfully"]));              
    }

    if(isset($_POST['restore_audio'])){
        $audio_id=base64_decode($_POST['audio_id']);
        $audio_production->restore($audio_id);  
        exit(json_encode(["status"=>1,"message"=>"Audio successfully restored"]));              
    }

    
?>