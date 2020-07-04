<?php
    include "app/init.php";
    if(isset($_GET['email'])&&isset($_GET['activation'])){
        $activate_email=base64_decode($_GET['email']);
        $activate_activation=base64_decode($_GET['activation']);

        $activate_user=json_decode($user->activate_user($activate_email,$activate_activation),true);
        if($activate_user['status']==0){
            echo "This link has expired, please try <a href='resend.php?activation=".base64_encode($activate_activation)."&email=".base64_encode($activate_email)."'".">click here</a> to resend";
        }else{
            echo "Acoount successfully activated, <a href='login.php'>click here to login</a>";
        }
    }
?>