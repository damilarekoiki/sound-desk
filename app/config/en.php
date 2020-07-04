<?php
$lang_array = array(
    "user_email_error" => "A user already exists with that email",
    "username_error" => "A user already exists with that username",
    "email_exist_error" => "Email doesnt exist in our record",
    "email_sent_successfully" => "An email has been sent to your mail address, please access it to reset your password",
    "password_reset_successfully" =>  "Your password has been reset successfully you can <a href='login.php'>Login here</a>",
    "password_reset_failure" =>  "There was a problem resetting password. <a href='forgot_password.php'>Go back</a> to forgot password",
    "access_link" =>  "Please access this page from the link sent to your email address or contact your admin",
    "password_change" =>  "Your password has been changed successfully",
    "password_change_error" =>  "Error while changing your password",

    "update_success" =>  "The update was successful",
    "update_failure" =>  "Could not make update",

    "business_update_success" =>  "The update was successful. Redirecting to feed...",
    "business_update_failure" =>  "Could not make update",
    



    "email_sent_error" => "Error while ending your email , please try again",
    "registeration_mail_subject" => "Distress Registeration Confirmation",
    "registeration_mail_content" => "Your Distress account has been created, please follow the link below to activate your account 
        <br>       
        " . SITE_URL . "/activation.php?activation=" . base64_encode('d') . "&email=" . base64_encode('d') . "",
    "user_registeration_successful" => "Registration was successful. An email has been sent to your email address for confirmation, <a href='index.php' >click here</a> to proceed to homepage",
    "account_activation" => "Activation successful,<a href='login.php' >you can now login here</a>",
    "account_activation_failure" => "Please access this page through the link sent to your email address or <a href='index.php' >click here to proceed to homepage</a>",
    "activation_exp_date" => "This link has expired, please try <a href='resend.php?activation=".base64_encode("d")."&email=".base64_encode("d")."'".">click here</a> to resend",
    "resend_activation_success" => "A new email has been sent your email address for confirmation, <a href='index.php' >click here</a> to proceed to homepage",
    
)


?>