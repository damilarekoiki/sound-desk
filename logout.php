<?php
    include "app/init.php";
    if(isset($_GET['action'])){
        if($_GET['action']==1){
            $user->logout();
            $user->redirect("index.php");
        }
    }

?>