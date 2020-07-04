<?php
    include "app/init.php";
    if(!isset($_SESSION['cart'])){
        $user->redirect("index.php");
        exit(0);
    }
    if(empty($_SESSION['cart'])){
        $user->redirect("index.php");
        exit(0);
    }
    $cart_array=$_SESSION['cart'];
    if(!empty($cart_array)){
        foreach ($cart_array as $audio=>$value) {
            $audio_details=$audio_production->details($audio);
            $owner_id=$audio_details['owner_id'];
            $audio_price=$value['price'];
            $is_promo=$value['is_promo'];
            $promo_id=$value['promo_id'];

            $audio_production->create_transaction($audio,$loggedin_user_id,$audio_price);
            $audio_payment_mode=$audio_production->get_audio_payment_mode($audio);
            if($audio_payment_mode==0){
                $user->recharge_my_wallet($owner_id, $audio_price);
            }

            if(isset($_GET['umw'])){
                if($_GET['umw']==1){
                    $user->debit_my_wallet($loggedin_user_id, $audio_price);
                }
            }

            if($is_promo==0){
                $user_promo_benefit=$user->get_user_promo_benefit($loggedin_user_id, $audio);
                $promo_audio_free=1;
                if(!empty($user_promo_benefit)){
                    $promo_audio_free=$user_promo_benefit['is_free'];
                }
                if($promo_audio_free==0){
                    $user->update_has_enjoyed_promo_audio($audio,$loggedin_user_id,$promo_id);
                }
            }
        }
    }

    if(isset($_SESSION['promo_benefits'])){
        $promo_benefits=$_SESSION['promo_benefits'];
        if(!empty($promo_benefits)){
            foreach ($promo_benefits as $audio_id=>$benefit) {
                $audio_price=$benefit['price'];
                $is_free=$benefit['is_free'];
                $promo_id=$benefit['promo_id'];
    
                $user->set_user_promo_benefit($promo_id,$audio_id,$loggedin_user_id,$is_free,$audio_price);
            }
        }
    }

    unset($_SESSION['cart']);
    unset($_SESSION['promo_benefits']);

    $_SESSION['payment_success']="Your payment was successful";

    $user->redirect("user_details.php?payment_success=1");
?>