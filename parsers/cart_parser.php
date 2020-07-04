<?php
    include "../app/init.php";

    if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
    if(!isset($_SESSION['promo_benefits'])) $_SESSION['promo_benefits']=[];


    if(isset($_POST['add_to_cart'])){
        $audio_id=$_POST['audio_id'];
        $audio_details=$audio_production->details($audio_id);
        $audio_price=$audio_details['price'];
        $is_deleted=$audio_details['deleted'];
        $user_promo_benefit=$user->get_user_promo_benefit($loggedin_user_id, $audio_id);
        $is_free=$audio_details['is_free'];

        if(array_key_exists($audio_id, $_SESSION['cart'])){
            exit(json_encode(["status"=>0,"title"=>"Could not add to cart","message"=>"Item already in cart"]));                      
        }

        if($is_deleted==0){
            if($is_free==0){
                if(empty($user_promo_benefit)){
                    $price=$audio_price;
                }else{
                    $price=$user_promo_benefit['price'];
                }
                add_to_cart($audio_id,$price,0,null);
            }
        }
        exit(json_encode(["status"=>1,"title"=>"Sucessful","message"=>"Item added to cart"]));
    }

    if(isset($_POST['remove_from_cart'])){
        $audio_id=$_POST['audio_id'];
        unset($_SESSION['cart'][$audio_id]);

        exit(json_encode(["status"=>1,"title"=>"Successful","message"=>"Audio removed from cart"]));

    }

    if(isset($_POST['remove_promo_from_cart'])){
        $promo_id=$_POST['promo_id'];
        $cart_array=$_SESSION['cart'];
        foreach ($cart_array as $cart_audio_id => $cart) {
            # code...
            $cart_promo_id=$cart['promo_id'];
            if($cart_promo_id==$promo_id){
                unset($_SESSION['cart'][$cart_audio_id]);
            }
        }

        exit(json_encode(["status"=>1,"title"=>"Successful","message"=>"Every audio in this promo has been removed"]));

    }

    if(isset($_POST['add_promo_to_cart'])){
        $promo_id=$_POST['promo_id'];
        $promo_details=$audio_production->get_promo_details($promo_id);
        
        $promoted_audios=json_decode($promo_details['promoted_audios'],true);
        $audios_to_get=json_decode($promo_details['audios_to_get'],true);
        $audios_benefit=[];
        if(isset($_POST['audios_to_get'])){
            $audios_benefit=$_POST['audios_to_get'];
        }
        
        
        $discount=$promo_details['discount'];
        $promo_type=$promo_details['promo_type'];

        

        $should_add_to_cart=0;
        foreach($promoted_audios as $promaud){
            $audio_id=$promaud;
            if(!array_key_exists($audio_id, $_SESSION['cart'])){
                $should_add_to_cart=1;            
            }
        }
        if($should_add_to_cart==0){
            exit(json_encode(["status"=>0,"title"=>"Could not add to cart","message"=>"One or more of these items are already in cart"]));
        }
        foreach($promoted_audios as $promaud){
            $audio_id=$promaud;
            $audio_details=$audio_production->details($audio_id);

            $audio_price=$audio_details['price'];
            $is_deleted=$audio_details['deleted'];
            $is_free=$audio_details['is_free'];

            if($is_deleted==0){
                if($is_free==0){
                    if($promo_type==2 || $promo_type==3){
                        $price=$audio_price;
                    }else{
                        $price=$audio_price-($audio_price*($discount/100));
                    }
                    add_to_cart($audio_id,$price,1,$promo_id);
                }
            }
        }

        // Adding promo benefits
        
        if(!empty($audios_benefit)){
            if(empty(array_intersect($audios_to_get,$audios_benefit))){
                exit(json_encode(["status"=>0,"message"=>"An error occurred"]));
            }
        }
        

        $should_continue=1;
        $audios_to_get_decider=$promo_details['audios_to_get_decider'];
        $channel_id=$promo_details['channel_id'];
        if($audios_to_get_decider==2){
            $audios_to_get=$channel->fetch_all_channel_priced_uploads($channel_id);
            foreach ($audios_to_get as $auds_get) {
                # code...
                if(!in_array($auds_get['audio_id'],$audios_benefit,1,NULL)){
                    $should_continue=0;
                }
            }
        }

        if($should_continue==0){
            exit(json_encode(["status"=>0,"message"=>"An error occurred"]));
        }
        
        if(!empty($audios_benefit)){
            foreach ($audios_benefit as $aud_benf) {
                # code...
                $audio_details=$audio_production->details($aud_benf);

                $audio_price=$audio_details['price'];
                $is_deleted=$audio_details['deleted'];
                $is_free=$audio_details['is_free'];

                if($is_deleted==0){
                    if($is_free==0){
                        if($promo_type==2){
                            add_to_promo_benefit($promo_id,$aud_benf);
                        }elseif($promo_type==3){
                            $prom_benf_price=$audio_price-($audio_price*($discount/100));
                            add_to_promo_benefit($promo_id,$aud_benf,0,$prom_benf_price);
                        }
                    }

                }
                
            }
        }

        exit(json_encode(["status"=>1,"title"=>"Sucessful","message"=>"Item(s) added to cart"]));
        
    }

    function add_to_cart($audio_id,$price,$is_promo,$promo_id){
        $cart_item=["price"=>$price,"is_promo"=>$is_promo,"promo_id"=>$promo_id];
        // check if the item is not in the array, if it is, do not add
        if(!array_key_exists($audio_id, $_SESSION['cart'])){
            $_SESSION['cart'][$audio_id]=$cart_item;            
        }
    }

    function add_to_promo_benefit($promo_id,$audio_id,$is_free=1,$price=NULL){
        $cart_item=["price"=>$price,"is_free"=>$is_free,"promo_id"=>$promo_id];
        $_SESSION['promo_benefits'][$audio_id]=$cart_item;            
    }
?>