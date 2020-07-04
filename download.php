<?php
    include "app/init.php";
    // exit($_GET['aid']);
    if(isset($_GET['aid'])){
        $audio_id=base64_decode($_GET['aid']);
        $audio_details=$audio_production->details($audio_id);
        $user_promo_benefit=$user->get_user_promo_benefit($loggedin_user_id, $audio_id);
        $promo_id=$user_promo_benefit['promo_id'];
        $promo_audio_free=0;
        if(!empty($user_promo_benefit)){
            $promo_audio_free=$user_promo_benefit['is_free'];
        }
        $filepath=$audio_details['audio_file_path'];
        $is_free=$audio_details['is_free'];

        if($user->has_bought_audio_but_yet_download($audio_id,$loggedin_user_id) || $is_free==1 || $promo_audio_free==1){

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);

        }

        if($promo_audio_free==1){
            $user->update_has_enjoyed_promo_audio($audio_id,$loggedin_user_id,$promo_id);
            exit;
        }

        if($user->has_bought_audio_but_yet_download($audio_id,$loggedin_user_id)){
            $user->update_has_downloaded_audio($audio_id,$loggedin_user_id);
        }
        
        
    }
    
?>