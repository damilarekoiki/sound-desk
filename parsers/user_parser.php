<?php
    include("../app/init.php");

    if(isset($_POST['register_user'])){
        // exit(var_dump($_POST));
        $first_name=$_POST['firstname'];
        $last_name=$_POST['lastname'];
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $dob=$_POST['dob'];

        $t_fn=preg_replace('/\s+/','',$first_name);
        $t_ln=preg_replace('/\s+/','',$last_name);
        $t_un=preg_replace('/\s+/','',$username);
        $t_em=preg_replace('/\s+/','',$email);
        $t_pass=preg_replace('/\s+/','',$password);
        $t_pass=preg_replace('/\s+/','',$password);
        $t_dob=preg_replace('/\s+/','',$dob);


        if(empty($t_fn) || empty($t_ln) || empty($t_un) || empty($t_em) || !isset($_POST['gender'],$_POST['nationality']) || empty($t_dob)){
            exit(json_encode(["status"=>0,"error"=>1,"message"=>"Please fill all fields"]));            
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit(json_encode(array('status'=>0,"error"=>2,"message"=>"Please! Enter a valid email format")));
        }
        if(strtotime(is_nan(strtotime($dob)))){
            exit(json_encode(["status"=>0,"error"=>1,"message"=>"Please select a valid date in format YY-MM-DD"]));            
        }
        $gender=$_POST['gender'];
        $nationality=$_POST['nationality'];

        $message=$user->register($first_name,$last_name,$username,$email,$password,$gender,$nationality,$dob);
        exit($message);
    }

    if(isset($_POST['login'])){

        $username_email=$_POST['username_email'];
        $password=$_REQUEST["password"];

        if(empty($username_email) || empty($password)){
            exit(json_encode(["status"=>0,"message"=>"Please fill all fields"])); 
        }
        $log_user_in=$user->login($username_email,md5($_REQUEST["password"]));
        $message=json_decode($log_user_in,true);
        if($message['status']==1){
            exit(json_encode(["status"=>1,"message"=>"Successful login. Redirecting...","url"=>"redirect.php"])); 
        }else{
            exit(json_encode(["status"=>0,"message"=>$message['message']])); 
        }

    }

    

    if(isset($_POST['forgot_password'])){
        $email=$_POST['email'];

        $t_email=preg_replace('/\s+/','',$email);

        if(empty($t_email)){
            exit (json_encode(array("status"=>0,"message"=>"Email field is required")));
        }else{
            $do_forgot=$user->forgot_password($email);
            exit($do_forgot);
        }
    }

    if(isset($_POST['reset_password'])){
        $new_password=$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];
        $email=base64_decode($_POST['email']);
        $activation=base64_decode($_POST['activation']);


        $t_np=preg_replace('/\s+/','',$new_password);
        $t_cp=preg_replace('/\s+/','',$confirm_password);
        
        if(empty($t_np) || empty($t_cp)){
            exit(json_encode(array("status"=>0,"message"=>"Fill both fields")));
        }
        if($new_password != $confirm_password){
            exit(json_encode(array("status"=>0,"message"=>"Confirm password does not match new password")));
        }

        // exit($activation." ". $email);
        

        $reset_password=$user->reset_password($new_password,$email,$activation);
        exit($reset_password);
    }

    if(isset($_POST['add_account_number'])){
        $account_number=$_POST['account_number'];
        if(empty($account_number)){
            exit(json_encode(["status"=>0,"message"=>"You have to enter an account number"]));            
        }
        if(empty($user->get_account_number($loggedin_user_id))){
            $user->add_account_number($loggedin_user_id, $account_number);            
        }else{
            exit($user->update_account_number($loggedin_user_id, $account_number));
        }
        exit(json_encode(["status"=>1,"message"=>"Account number added successfully"]));
    }


?>