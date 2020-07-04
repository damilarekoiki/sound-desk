<?php
ob_start();
session_start();

include ('config/config.php');
include ('config/db_config.php');

global $db_conn;
if(isset($_GET['lang'])){
    $lang = htmlspecialchars($_GET['lang']);
    include "config/".$lang.".php";
    $_SESSION['lang'] = $lang;
}else{
    if(isset($_SESSION['lang'])){
        $lang = htmlspecialchars($_SESSION['lang']);
        include "config/".$lang.".php";
    }else{
        include "config/en.php";

    }

}
$lang = $lang_array;
global $lang;
include "classes/Master.php";
include "classes/User.php";
include "classes/Channel.php";
include "classes/AudioProduction.php";
include "classes/MP3.php";
include "classes/phpmp3.php";
include "classes/Geoplugin.php";



// include "classes/Message.php";




$master = new Master($db_conn,$lang);
$user = new User($db_conn,$lang);
$channel = new Channel($db_conn,$lang);
$mp3 = new MP3();
$geoplugin = new GeoPlugin();



$audio_production = new AudioProduction($db_conn,$lang,$mp3);


// $message = new Message($db_conn,$lang);


if($user->is_loggedin()){
    $loggedin_email=$_SESSION['email'];
    $loggedin_user_id=$_SESSION['user_id'];
}

// $user_location_info=var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
// $user_location_country=$user_location_info[];


// $geoplugin->locate();
// $user_location_country_code=$geoplugin->countryCode;
// $user_location_country_name=$geoplugin->countryName;
$user_location_country_code="NG";
$user_location_country_name="Nigeria";

$price_currency="NGN";


// $user = new User($db_conn,$lang_array);

    $num_items_in_cart=0;
    $cart_total_price=0;
    if(isset($_SESSION['cart'])){
        $num_items_in_cart=count($_SESSION['cart']);
        $cart_total_price=0;
        $cart_array=$_SESSION['cart'];
        foreach ($cart_array as $array) {
            # code...
            $cart_total_price+=$array['price'];
        }
    }
?>