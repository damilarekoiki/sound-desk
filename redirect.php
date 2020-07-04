<?php
    include "app/init.php";
    if($user->is_loggedin()){
        $email=$_SESSION['email'];
        if(isset($_SESSION['not_loggedin_url'])){
            $not_loggedin_url=$_SESSION['not_loggedin_url'];
            header("Location: $not_loggedin_url");
        }else{
            header("Location: index.php");
        }
    }else{
        echo "Not logged in";
    }

?>