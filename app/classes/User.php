<?php
class User extends Master
{

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////setters///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
   public  function __construct($db_conn,$lang)
   {
        parent::__construct($db_conn,$lang);
          
   }
   
  
   
    public function register($first_name,$last_name,$username,$email,$password,$gender,$nationality,$date_of_birth){

       $password = md5($password);

        if(!$this->user_exists($username,$email)){

            $user_id=$this->generate_user_id();
            
            $activation_code = $this->generate_user_activation();
            $date_reg = strtotime("now");
            $activation_code_validity = strtotime("+1 day");

            $sql = "INSERT INTO user SET
                    user_id = :user_id,
                    first_name = :first_name,
                    last_name = :last_name,
                    username = :username,
                    email = :email,
                    password = :password,
                    activation_code = :activation_code,
                    account_status = :account_status,
                    date_registered = :date_registered,
                    profile_pix=:profile_pix,
                    activation_code_validity = :activation_code_validity,
                    nationality = :nationality,
                    gender=:gender,
                    date_of_birth = :date_of_birth";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array('user_id'=>$user_id,'first_name'=>$first_name,'last_name'=>$last_name,'username'=>$username,'email'=>$email,'password'=>$password,'activation_code'=>$activation_code,'account_status'=>1,'date_registered'=>date("Y-m-d H:i:s"),'activation_code_validity'=>$activation_code_validity,"profile_pix"=>"assets/img/user_avatar.png",'nationality'=>$nationality,'gender'=>$gender,'date_of_birth'=>date("Y-m-d",strtotime($date_of_birth)) ));

           /*send user confirmation email*/
        //    $to = $email;
        //    $subject =  $lang['registeration_mail_subject'];
        //    $content =   $lang['registeration_mail_content'];


        //    $response =   $this->send_mail($to,$subject,$content);
            
        $message = json_encode(array('status'=>1,"message"=>"Registration was successful. A link has been sent to your mail, please click on the link to activate your account"));
        
        return $message;

        }elseif($this->email_exists($email)){
            $message = json_encode(array('status'=>0,"error"=>2,"message"=>$this->lang['user_email_error'],"email"=>$email));
            return $message;
        }elseif($this->username_exists($username)){
            $message = json_encode(array('status'=>0,"error"=>3,"message"=>$this->lang['username_error']));
            return $message;
        }   
        
    }

    // generate user id from previously generated id
    public function generate_user_id(){
        /*this method generate id for new user*/
        $id = $this->get_last_user_id();
        return intval($id) + 1;
    }

    public function get_last_user_id(){
        $data = array("user_id");
        $table = "user";
        $where = " ORDER BY id DESC";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
         }else{
            return $check['user_id'];
        }  
    }

    public function login($username_email,$user_password)
    {
        $data="*";
        $table="user";
        $where=" WHERE (email='$username_email' OR username='$username_email' ) AND password = '$user_password'";
        $check=$this->getData($data,$table,$where);
        if(!empty($check)){
            if($check['account_status']==0){
                return json_encode(["status"=>0,"message"=>"Account unactivated. Please check your mail and click the link sent to you"]);
            }

            $_SESSION['email']=$check['email'];
            $_SESSION['username']=$check['username'];
            $_SESSION['user_id']=$check['user_id'];

            return json_encode(["status"=>1,"message"=>"Successful login. Redirecting..."]);
        }else{
            return json_encode(["status"=>0,"message"=>"Incorrect username or password"]);
        }
    }

    public function fetch_all()
    {
        # code...
        $data="*";
        $table="user";
        $where="";

        $result=$this->getAllData($data,$table,$where);

        return $result;
    }

    public function get_details($email)
    {
        # code...
        $data="*";
        $table="user";
        $where=" WHERE email='$email'";

        $result=$this->getData($data,$table,$where);

        return $result;
    }

    public function get_details_by_id($user_id)
    {
        # code...
        $data="*";
        $table="user";
        $where=" WHERE user_id=$user_id";

        $result=$this->getData($data,$table,$where);

        return $result;
    }

    public function update_user_played_audio_category($user_id,$category_id)
    {
        # code...
        $data=array("user_id"=>$user_id,"category_id"=>$category_id,"date_played"=>date("Y-m-d H:i:s"));
        $table="audio_category_views";
        if(!$this->has_played_audio_category($user_id,$category_id)){
            $this->insertData($data,$table);
        }
        
    }

    public function update_user_played_audio($user_id,$audio_id)
    {
        # code...
        $data=array("user_id"=>$user_id,"audio_id"=>$audio_id,"date_played"=>date("Y-m-d H:i:s"));
        $table="audio_views";
        if(!$this->has_played_audio($user_id,$audio_id)){
            $this->insertData($data,$table);
        }
    }

    public function update_user_checked_promo($user_id,$promo_id)
    {
        # code...
        $data=array("user_id"=>$user_id,"promo_id"=>$promo_id,"date_checked"=>date("Y-m-d H:i:s"));
        $table="promo_checks";
        if(!$this->has_checked_promo($user_id,$promo_id)){
            $this->insertData($data,$table);
        }
    }

    public function update_user_visited_channel($user_id,$channel_id)
    {
        # code...
        $data=array("user_id"=>$user_id,"channel_id"=>$channel_id,"date_visited"=>date("Y-m-d H:i:s"));
        $table="channel_visits";
        if(!$this->has_visited_channel($user_id,$channel_id)){
            $this->insertData($data,$table);
        }
    }

    public function has_played_audio_category($user_id,$category_id)
    {
        # code...
        $data="*";
        $table="audio_category_views";
        $where=" WHERE user_id=$user_id AND category_id=$category_id";

        $result=$this->getData($data,$table,$where);

        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }

    public function has_played_audio($user_id,$audio_id)
    {
        # code...
        $data="*";
        $table="audio_views";
        $where=" WHERE user_id=$user_id AND audio_id=$audio_id";

        $result=$this->getData($data,$table,$where);

        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }
    public function has_checked_promo($user_id,$promo_id)
    {
        # code...
        $data="*";
        $table="promo_checks";
        $where=" WHERE user_id=$user_id AND promo_id=$promo_id";

        $result=$this->getData($data,$table,$where);

        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }

    public function has_visited_channel($user_id,$channel_id)
    {
        # code...
        $data="*";
        $table="channel_visits";
        $where=" WHERE user_id=$user_id AND channel_id=$channel_id";

        $result=$this->getData($data,$table,$where);

        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }

    public function age_not_restricted($user_age,$min_age,$max_age)
    {
        # code...
        $not_restricted=false;
        if(is_null($min_age) && is_null($max_age)){
            $not_restricted=true;
        }

        if(!is_null($min_age)){
            if($user_age>=$min_age){
                $not_restricted=true;
            }else{
                $not_restricted=false;
            }
        }

        if(!is_null($max_age)){
            if($user_age<=$max_age){
                $not_restricted=true;
            }else{
                $not_restricted=false;
            }
        }

        return $not_restricted;
    }

    public function has_subscribed_to_channel($user_id,$channel_id)
    {
        # code...
        $data="*";
        $table="channel_subscriptions";
        $where=" WHERE subscriber_id=$user_id AND channel_id=$channel_id";

        $result=$this->getData($data,$table,$where);

        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }

    public function fetch_all_subscribed_channels($user_id)
    {
        # code...
        $data="*";
        $table="channel_subscriptions";
        $where=" WHERE subscriber_id=$user_id";

        $result=$this->getAllData($data,$table,$where);

        if(empty($result)){
            return [];
        }else{
            return $result;
        }
    }

    public function print_my_notifications($user_id,$counter)
    {
        # code...
        $channel = new Channel($this->db,$this->lang);
        $mp3 = new MP3();
        $audio_production = new AudioProduction($this->db,$this->lang,$mp3);
        $all_subscribed_channels=$this->fetch_all_subscribed_channels($user_id);
        $notiCounter=0;
        if(!empty($all_subscribed_channels)){
            foreach ($all_subscribed_channels as $a_channel) {
                # code...
                $channel_id=$a_channel['channel_id'];
                $channel_details=$channel->details($channel_id);
                $channel_name=$channel_details['channel_name'];
                $channel_logo=$channel_details['logo'];

                $all_channel_uploads=$channel->fetch_all_channel_uploads($channel_id);
                $all_channel_promos=$channel->fetch_all_channel_promos($channel_id);

                if(!empty($all_channel_uploads)){
                    foreach ($all_channel_uploads as $an_upload) {
                        # code...
                        $audio_id=$an_upload['audio_id'];
                        $deleted=$an_upload['deleted'];
                        if(!$this->has_played_audio($user_id,$audio_id) && $deleted==0){
                            $notiCounter++;
                            $audio_name=$an_upload['audio_name'];
                            $audio_price=$an_upload['price'];
                            $is_free=$an_upload['is_free'];
                            $date_uploaded_ago=$this->time_ago($an_upload['date_uploaded']);
                            $price_text=$audio_price;
                            if($is_free==1){
                                $price_text="Free";
                            }

                            $enc_aud_id=base64_encode($audio_id);
                            $enc_c_id=base64_encode($channel_id);
                            echo "
                                <a class='nav-link js-scroll-trigger' href='audio_play.php?pid=$enc_aud_id&cid=$enc_c_id' style='font-size:13px;'>
                                    <div class='row col-md-12'>
                                        <div class='col-md-2'>
                                            <img src='$channel_logo' alt='' class='img img-fluid' style='width:20px;height:20px;'>
                                        </div>

                                        <div class='col-md-10'>
                                            <div class='row col-md-12'>
                                                $channel_name
                                            </div>
                                            <div class='row col-md-12'>
                                                Uploaded $audio_name
                                            </div>
                                            <div class='row col-md-12'>
                                            <span class='float-left'>Price:&nbsp;$price_text</span> &nbsp;&nbsp; <span class='float-right' style='font-size:10px;'>$date_uploaded_ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style='border:white 1px solid'>
                                </a>
                            ";
                        }

                        if($notiCounter==$counter && $counter>0) break;
                    }
                }

                if(!empty($all_channel_promos)){
                    foreach ($all_channel_promos as $a_promo) {
                        # code...
                        $promo_id=$a_promo['promo_id'];
                        if(!$this->has_checked_promo($user_id,$promo_id)){
                            $notiCounter++;
                            $promo_code=$a_promo['promo_code'];
                            $promoted_audios=json_decode($a_promo['promoted_audios'],true);
                            $should_display=0;
                            foreach($promoted_audios as $promaud){
                                $audio_id=$promaud;
                                $audio_details=$audio_production->details($audio_id);
                                $is_deleted=$audio_details['deleted'];
                                if($is_deleted==0){
                                $should_display=1;
                                }
                            }
                            if($should_display==0){
                                continue;
                            }

                            $enc_prom_id=base64_encode($promo_id);
                            $enc_c_id=base64_encode($channel_id);
                            echo "
                                <a class='nav-link js-scroll-trigger' href='promo.php?pid=$enc_prom_id&cid=$enc_c_id' style='font-size:13px;'>
                                    <div class='row col-md-12'>
                                        <div class='col-md-2'>
                                            <img src='$channel_logo' alt='' class='img img-fluid' style='width:20px;height:20px;'>
                                        </div>

                                        <div class='col-md-10'>
                                            <div class='row col-md-12'>
                                                $channel_name
                                            </div>
                                            <div class='row col-md-12'>
                                                Create a promo
                                            </div>
                                            <div class='row col-md-12'>
                                                $promo_code
                                            </div>
                                        </div>
                                    </div>
                                    <hr style='border:white 1px solid'>
                                </a>
                            ";
                        }
                        if($notiCounter==$counter && $counter>0) break;
                    }
                }
            }
        }

        if($notiCounter==0){
            echo"
                <a href='#' class='nav-link js-scroll-trigger' href='' style='color:white;font-size:13px;'>No no tification</a>
            ";
        }
        echo"
            <a href='notifications.php' class='nav-link js-scroll-trigger' href='' style='color:white;font-size:13px;margin-left:10%'>View all notification</a>
        ";
        return ["noti_counter"];
    }

    public function has_rated_audio($audio_id,$rater_id)
    {
        # code...
        // $num_star=$this->calc_post_answer_rate($percent);
        $data="*";
        $table="audio_rating";
        $where=" WHERE audio_id=$audio_id AND rater_id=$rater_id";
        $check=$this->getData($data,$table,$where);
        if(empty($check)){
            return false;
        }else{
            return true;
        }
    }

    public function has_bought_audio_at_least_once($audio_id,$user_id)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where = " where audio_id=$audio_id AND buyer_id=$user_id";
    
        $result = $this->getData($data, $table, $where);
        if(empty($result)){
            return false;
        }else{
            return true;

        }
    }

    public function has_bought_audio_but_yet_download($audio_id,$user_id)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where = " where audio_id=$audio_id AND buyer_id=$user_id AND downloaded=0";
    
        $result = $this->getData($data, $table, $where);
        if(empty($result)){
            return false;
        }else{
            return true;

        }
    }

    public function update_has_enjoyed_promo_audio($audio_id,$user_id,$promo_id)
    {
        # code...
        $data = ["enjoyed"=>1];
        $table = "user_promos";
        $where = " where audio_id=$audio_id AND user_id=$user_id AND enjoyed=0 AND promo_id=$promo_id LIMIT 1";
    
        $this->updateData($data, $table, $where);
        
    }

    public function update_has_downloaded_audio($audio_id,$user_id)
    {
        # code...
        $data = ["downloaded"=>1];
        $table = "transactions";
        $where = " where audio_id=$audio_id AND buyer_id=$user_id LIMIT 1";
    
        $this->updateData($data, $table, $where);
        
    }

    public function calculate_user_age($user_id)
    {
        # code...
        $user_details=$this->get_details_by_id($user_id);
        $user_dob=$user_details['date_of_birth'];
        $date = new DateTime($user_dob);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;

    }

    public function search($username_name)
    {
        # code...
        $data = "*";
        $table = "user";
        $where = " where first_name LIKE '%$username_name%' OR last_name LIKE '%$username_name%' OR username LIKE '%$username_name%'";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function set_user_promo_benefit($promo_id,$audio_id,$user_id,$is_free,$price)
    {
        # code...
        $data = array("promo_id"=>$promo_id,"audio_id"=>$audio_id,"user_id"=>$user_id,"is_free"=>$is_free,"price"=>$price);
        $table = "user_promos";
        $where = " where promo_id=$promo_id";
    
        $result = $this->insertData($data, $table);
        return true;
    }

    public function get_user_promo_benefit($user_id, $audio_id)
    {
        # code...
        $data = "*";
        $table = "user_promos";
        $where = " where user_id=$user_id AND audio_id=$audio_id AND enjoyed=0";
    
        $result = $this->getData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_my_bought_audios($user_id)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where = " where buyer_id=$user_id";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_my_tansactions($user_id)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where = " where buyer_id=$user_id";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_my_sales($user_id)
    {
        # code...
        $sql = "SELECT transactions.* from transactions join audio_production where transactions.audio_id=audio_production.audio_id AND audio_production.owner_id=:user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('user_id'=>$user_id));
        return $stmt->fetchAll();

        $data = "*";
        $table = "transactions";
        $where = " where buyer_id=$user_id";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_my_sales_for_this_month($user_id,$month,$year)
    {
        # code...
        $sql = "SELECT transactions.* from transactions join audio_production where transactions.audio_id=audio_production.audio_id AND audio_production.owner_id=:user_id AND MONTH(transactions.date_purchased) = $month AND YEAR(transactions.date_purchased)=$year";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('user_id'=>$user_id));
        return $stmt->fetchAll();

        $data = "*";
        $table = "transactions";
        $where = " where buyer_id=$user_id";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_my_recent_promos($user_id)
    {
        # code...
        $data = "*";
        $table = "user_promos";
        $where = " where user_id=$user_id AND enjoyed=0";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function recharge_my_wallet($user_id, $amount)
    {
        # code...
        $sql = "UPDATE user SET wallet_amount=wallet_amount+:amount WHERE user_id=:user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('user_id'=>$user_id,'amount'=>$amount));
        return true;
    }

    public function debit_my_wallet($user_id, $amount)
    {
        # code...
        $sql = "UPDATE user SET wallet_amount=wallet_amount-:amount WHERE user_id=:user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('user_id'=>$user_id,'amount'=>$amount));
        return true;
    }

    public function update_account_number($user_id, $account_number)
    {
        # code...
        $sql = "UPDATE user_payment_info SET account_number=:account_number WHERE user_id=:user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('user_id'=>$user_id,'account_number'=>$account_number));
        return $account_number;
    }

    public function add_account_number($user_id,$account_number)
    {
        # code...
        $data = array("user_id"=>$user_id,"account_number"=>$account_number);
        $table = "user_payment_info";
    
        $result = $this->insertData($data, $table);
        return true;
    }

    public function get_account_number($user_id)
    {
        # code...
        $data = "*";
        $table = "user_payment_info";
        $where = " where user_id=$user_id";
    
        $result = $this->getData($data, $table, $where);
        if(empty($result)) return "";
        return $result['account_number'];
    }



}
?>