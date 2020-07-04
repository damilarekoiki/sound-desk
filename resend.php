<?php
    if(isset($_GET['email'])&&isset($_GET['activation'])){
        $activate_email=base64_decode($_GET['email']);
        $activate_activation=base64_decode($_GET['activation']);
        include "app/init.php";
        // echo $email;
        // echo $activation;
        // echo $user->activate_user($activate_email,$activate_activation);
        echo json_decode($user->resend_activation($activate_email,$activate_activation),true)['message'];
    }
?>