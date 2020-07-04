<?php
    class Master
    {
        protected $db;
        protected $lang;


        
        function __construct($db_conn,$lang)
        {
            $this->db = $db_conn;
            $this->lang = $lang;
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////ACTIONS//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        
        public function fetch_all_countries()
        {
            # code...
            $data = "*";
            $table = "country";
        
            $check = $this->getAllData($data, $table);
            if(empty($check)){
                return 0;
             }else{
                return $check;
            }  

        }
        
        

        //generating user activation code
        public function generate_user_activation(){
            /*this method generate activation code for new user*/
            $activation_code = uniqid(rand());
            return $activation_code;

        }


        public function construct_new($array1,$array2){
            $new_array = array();
            for($i= 0;$i<count($array1);++$i){
                if(isset($array1[$i]) && isset($array2[$i])) {
                    $new_array[str_replace(' ','_',$array1[$i])] =  $array2[$i];
                }

            }
            return $new_array;
        }

        public function activate_user($email,$activation_code){
            $exp_date = $this->get_user_activation_expiry($email);
            $now = strtotime('now');
            // $exp_date = strtotime($exp_date);
            if( $now > $exp_date ){
                $message = json_encode(array('status'=>0,"message"=>$this->lang['activation_exp_date']));
                //remove user from database
                return $message;
            }
            $user_activation_code = $this->get_user_activation_code($email);
            if($user_activation_code == $activation_code){
                $this->update_user_activation_code($email);
                $message = json_encode(array('status'=>1,"message"=>$this->lang['account_activation']));
                return $message;
                
            }else{
                $message = json_encode(array('status'=>0,"message"=>$this->lang['account_activation_failure']));
                return $message;
            }

        }

        public function resend_activation($email,$activation_code)
        {
            # code...
            $user_activation_code = $this->get_user_activation_code($email);
            if($user_activation_code == $activation_code){
                $new_activation = $this->generate_user_activation();
                $data = array("activation_code"=>$new_activation,"activation_code_validity"=>strtotime(" +1 day"));
                $table = "user";
                $where = "WHERE email = '$email'";
            
                $check = $this->updateData($data, $table, $where);
                $message = json_encode(array('status'=>1,"message"=>$this->lang['resend_activation_success']));
                /*send user confirmation email*/
                //    $to = $email;
                //    $subject =  $lang['registeration_mail_subject'];
                //    $content =   $lang['registeration_mail_content'];


                //    $response =   $this->send_mail($to,$subject,$content);
                return $message;
            }else{
                $message = json_encode(array('status'=>0,"message"=>""));
                
                return $message;
            }
        }

        public function get_user_activation_expiry($email){
            /*This method get the user activation code*/
            $data = array("activation_code_validity");
            $table = "user";
            $where = " WHERE email = '$email'";
        
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return 0;
             }else{
                return $check['activation_code_validity'];
            }  
        
        }

        public function get_user_activation_code($email){
            /*This method get the user activation code*/
            $data = array("activation_code");
            $table = "user";
            $where = " WHERE email = '$email'";
        
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return 0;
             }else{
                return $check['activation_code'];
            }  
        
        }

        public function update_user_activation_code($email){
            $new_activation = $this->generate_user_activation();
            $data = array("activation_code"=>$new_activation,"account_status"=>1);
            $table = "user";
            $where = "WHERE email = '$email'";
        
            $check = $this->updateData($data, $table, $where);
        }

        public function send_mail($to,$subject,$content){
            $body = '<p>
                        Hi,
                        <br>'.$content.'
                        <br>
                        Thanks
                        
                        </p>';
            $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
            $headers .='From:<noreply@mediapay.com.ng>' . "\r\n";

            $res = mail($to,$subject,$body,$headers);
            return $res;
        }

        public function isJSON($string){
            return is_string($string) && is_array(json_decode($string, true)) ? true : false;
        }

        public function make_date($day="today"){
            if($day == "today"){
                return date();
            
            }
        }


        public function getData($data, $table, $where = '')
        {
            try {
                if ($data != '*') {
                    $selections = implode(', ', $data);
                } else {
                    $selections = '*';
                }

                $stmt = $this->db->prepare("SELECT {$selections} FROM `$table` " . $where . " LIMIT 1");
                $stmt->execute();
                $settings_data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {
                    return $settings_data;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function updateData($array, $table, $where = '')
        {

            try {

                $fields = array_keys($array);
                $values = array_values($array);
                $fieldlist = implode(',', $fields);
                $qs = str_repeat("?, ", count($fields) - 1);
                $firstfield = true;

                $sql = "UPDATE `$table` SET";

                for ($i = 0; $i < count($fields); $i++) {
                    if (!$firstfield) {
                        $sql .= ", ";
                    }
                    $sql .= " " . $fields[$i] . "= ? ";
                    $firstfield = false;
                }
                if (!empty($where)) {
                    $sql .= $where;
                }
                $sth = $this->db->prepare($sql);
                return $sth->execute($values);

                return $sth;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function insertData($array, $table)
        {

            try {

                $fields = array_keys($array);
                $values = array_values($array);
                $fieldlist = implode(',', $fields);
                $qs = str_repeat("?,", count($fields) - 1);
                $firstfield = true;

                $sql = "INSERT INTO `$table` SET";

                for ($i = 0; $i < count($fields); $i++) {
                    if (!$firstfield) {
                        $sql .= ", ";
                    }
                    $sql .= " " . $fields[$i] . "=?";
                    $firstfield = false;
                }

                $sth = $this->db->prepare($sql);
                return $sth->execute($values);

                return $sth;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function getAllData($data, $table, $where = '')
        {
            try {
                if ($data != '*') {
                    $selections = implode(', ', $data);
                } else {
                    $selections = '*';
                }


                $stmt = $this->db->prepare("SELECT {$selections} FROM `$table` " . $where . "");
                $stmt->execute();
                $settings_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {
                    return $settings_data;
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }


        public function forgot_password($email){
            $email_exists = $this->email_exists($email);
            if(!$email_exists){
                $message = json_encode(array('status' => 0, "message" =>$this->lang['email_exist_error']));
            }else{
                $to = $email;
                $subject = "Password Reset";
                $activation = $this->get_user_activation($email); 
                $content =  ' <br>
                        Follow the below link to reset your password
                    <br>
                    <a href="shall be set later.atlas.com/password_reset.php?activate="'. $activation.'&email='.$email.' >Password reset</a> 
                <br>
                <br>';
                //   $email_status = $this->send_mail($to,$subject,$content);  
                // if($email_status){
                //     $message = json_encode(array('status' => 1, "message"=>$this->lang['email_sent_successfully']));
                // }else{
                //     $message = json_encode(array('status' => 0, "message"=>$this->lang['email_sent_error']));
                // }
                $message = json_encode(array('status' => 1, "message"=>$this->lang['email_sent_successfully']));
            }
            return $message;
        }

        public function reset_password($new_password,$email,$activation){

            if($activation == $this->get_user_activation($email)){
                $where = "WHERE email = '$email'";
                $new_password = md5($new_password);
                $new_activation = uniqid(rand());

                $array = array("password"=>$new_password,"activation_code"=>$new_activation);
                $this->updateData($array,'user',$where);
                $message = json_encode(array('status' => 1, "message"=>$this->lang['password_reset_successfully']));
            }else{
                $message = json_encode(array('status' => 0,"message"=>$this->lang['password_reset_failure']));
            }
            
            return $message;
        }

        public function get_user_activation($email)
        {
            # code...
            $data = array("activation_code");
            $table = "user";
            $where = " WHERE email='$email'";
        
            $check = $this->getData($data, $table, $where);
            return $check['activation_code'];

        }

        public function email_exists($email)
        {
            $data = "*";
            $table = "user";
            $where = " where email='$email'";
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return false;
            }else{
                return true;
            }  
        }

        public function user_exists($username,$email)
        {
            $data = "*";
            $table = "user";
            $where = " where email='$email' OR username='$username'";
            $check = $this->getAllData($data, $table, $where);
            if(empty($check)){
                return false;
            }else{
                return true;
            }  
        }

        public function username_exists($username)
        {
            $data = "*";
            $table = "user";
            $where = " where username='$username'";
            $check = $this->getAllData($data, $table, $where);
            if(empty($check)){
                return false;
            }else{
                return true;
            }  
        }

        public function change_password($old_password,$password){

            $email = $this->logged_in_user();
            // validate confirm password
            if(md5($old_password) == $this->get_user_password($email)){
                $table='user';
                $where = "WHERE email = '".$email."'";
                $password = md5($password);
                $data = array("password"=>$password);
                $this->updateData($data,$table,$where);
                $message = json_encode(array('status' => 1, "message"=>$this->lang['password_change']));
            }else{
                    
                $message = json_encode(array('status' => 0, "message"=>$this->lang['password_change_error']));
            }
            
            return $message;
            
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Getters/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function get_user_password($email)
        {
            $data = array("password");
            $table = "user";
            $where = " where email='$email'";
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return "";
            }else{
                return $check['password'];
            } 
        }

        public function get_username($email)
        {
            $data = array("username");
            $table = "user";
            $where = " where email='$email'";
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return "";
            }else{
                return $check['username'];
            } 
        }

        public function get_username_by_id($user_id)
        {
            $data = array("username");
            $table = "user";
            $where = " where user_id=$user_id";
            $check = $this->getData($data, $table, $where);
            if(empty($check)){
                return "";
            }else{
                return $check['username'];
            } 
        }
        
        public function is_loggedin()
        {
            if (isset($_SESSION['email'])) {
                return true;
            }
        }

        public function logged_in_user()
        {
            if (isset($_SESSION['email'])) {
                return $_SESSION['email'];
            }
        }


                                                        

        public function redirect($url)
        {
            header("Location: " . $url . "");
        }

        public function logout()
        {
            session_destroy();
            if ($_SESSION['user_session']) {
                unset($_SESSION['user_session']);

            }
            
            return true;
        }

        public function time_ago($past_time){
            $time_diff=time()-strtotime($past_time);
            $secs_ago=round($time_diff);
            $mins_ago=round($time_diff/60);
            $hours_ago=round($time_diff/3600);
            $days_ago=round($time_diff/(3600*24));
            $weeks_ago=round($time_diff/(3600*24*7));
            $months_ago=round($time_diff/(3600*24*7*4));
            $years_ago=round($time_diff/(3600*24*7*4*12));
            if($secs_ago<60){
                if($secs_ago>1){
                    return $secs_ago." seconds ago";
                }
                if($secs_ago==0){
                    return "Just now";
                }
                return "A second ago";
            }
            if($mins_ago<60){
                if($mins_ago>1){
                    return $mins_ago." minutes ago";
                }
                return "A minute ago";
            }
            if($hours_ago<24){
                if($hours_ago>1){
                    return $hours_ago." hours ago";
                }
                return "An hour ago";
            }
            if($days_ago<7){
                if($days_ago>1){
                    return $days_ago." days ago";
                }
                return "A day ago";
            }
            if($weeks_ago<4){
                if($weeks_ago>1){
                    return $weeks_ago." weeks ago";
                }
                return "A week ago";
            }
            if($months_ago<12){
                if($months_ago>1){
                    return $months_ago." months ago";
                }
                return "A month ago";
            }
            if($years_ago>0){
                if($years_ago>1){
                    return $years_ago." years ago";
                }
                return "A year ago";
            }
        
        }

        public function generate_promo_code($l=8){
            $uniq_id = uniqid(rand());
            $promo_code="SD";
            $promo_code.= substr(str_shuffle($uniq_id), 0, $l);
            if($this->promo_code_exists($promo_code)){
                $this->generate_promo_code();
            }else{
                return $promo_code;
            }
        }

        public function promo_code_exists($promo_code)
        {
            # code...
            $data = "*";
            $table = "audios_promotion";
            $where = " where promo_code='$promo_code'";
        
            $check = $this->getAllData($data, $table, $where);
            if(empty($check)){
                return false;
            }else{
                return true;
            }  
        }

        public function get_country_details($country_id)
        {
            # code...
            $data = "*";
            $table = "country";
            $where = " where id=$country_id";
        
            $check = $this->getData($data, $table, $where);
            return $check;
        }

        

        

    }



?>