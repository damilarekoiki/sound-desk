<?php
class Channel extends Master
{

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////setters///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
   public  function __construct($db_conn,$lang)
   {
        parent::__construct($db_conn,$lang);
          
   }

    // generate message id from previously generated id
    public function generate_channel_id(){
        /*this method generate id for new user*/
        $id = $this->get_last_channel_id();
        return intval($id) + 1;
    }

    public function get_last_channel_id(){
        $data = array("channel_id");
        $table = "channel";
        $where = " ORDER BY id DESC";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
         }else{
            return $check['channel_id'];
        }  
    }

    public function fetch_all_user_channels($owner_id){
        $data = "*";
        $table = "channel";
        $where = " where owner_id=$owner_id";
    
        $check = $this->getAllData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        }  
    }

    public function fetch_all_channel_uploads($channel_id)
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where channel_id=$channel_id";
    
        $check = $this->getAllData($data, $table, $where);
        return $check;

        // if(empty($check)){
        //     return [];
        //  }else{
        // }
    }

    public function fetch_all_channel_priced_uploads($channel_id)
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where channel_id=$channel_id AND is_free=0 AND deleted=0";
    
        $check = $this->getAllData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        }
    }

    public function fetch_all_channel_promos($channel_id)
    {
        # code...
        $data = "*";
        $table = "audios_promotion";
        $where = " where channel_id=$channel_id";
    
        $check = $this->getAllData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        }
    }

    public function fetch_all_channel_adverts($channel_id)
    {
        # code...
        $data = "*";
        $table = "advert";
        $where = " where channel_id=$channel_id";
    
        $check = $this->getAllData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        }
    }

    public function num_channel_uploads($channel_id)
    {
        # code...
        if(empty($this->fetch_all_channel_uploads($channel_id))) return 0;
        return count($this->fetch_all_channel_uploads($channel_id));
    }

    public function fetch_all_channel_subscribers($channel_id)
    {
        # code...
        $data = "*";
        $table = "channel_subscriptions";
        $where = " where channel_id=$channel_id";
    
        $check = $this->getAllData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        }
    }

    public function num_channel_subscribers($channel_id)
    {
        # code...
        return count($this->fetch_all_channel_subscribers($channel_id));
    }



    public function create($channel_name,$brand_location,$owner_id)
    {
        # code...
        $channel_id=$this->generate_channel_id();
        $data = array("channel_id"=>$channel_id,"channel_name"=>$channel_name,"owner_id"=>$owner_id,"brand_location"=>$brand_location,"cover_pix"=>"assets/img/background9.jpg","logo"=>"assets/img/logo_avatar.png","date_created"=>date("Y-m-d H:i:s"));
        $table = "channel";
    
        $check = $this->insertData($data, $table);
        return $channel_id; 
    }

    public function update($channel_id,$channel_description,$brand_location)
    {
        # code...
        $data = array("description"=>$channel_description,"brand_location"=>$brand_location);
        $table = "channel";
        $where=" WHERE channel_id=$channel_id";
        $check = $this->updateData($data, $table, $where);
        return true; 
    }

    public function name_exists($channel_name,$owner_id){
        $data = "*";
        $table = "channel";
        $where = " WHERE channel_name='$channel_name' AND owner_id=$owner_id";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return false;
         }else{
            return true;
        } 
    }

    public function exists($channel_id,$owner_id){
        $data = "*";
        $table = "channel";
        $where = " WHERE channel_id=$channel_id AND owner_id=$owner_id";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return false;
         }else{
            return true;
        } 
    }
    public function details($channel_id)
    {
        # code...
        $data = "*";
        $table = "channel";
        $where = " WHERE channel_id=$channel_id";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return [];
         }else{
            return $check;
        } 
    }

    public function owns_audio($audio_id,$channel_id)
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " WHERE audio_id=$audio_id AND channel_id=$channel_id";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return false;
         }else{
            return true;
        } 
    }

    public function subscribe($channel_id, $user_id)
    {
        # code...
        $data = array("channel_id"=>$channel_id,"subscriber_id"=>$user_id,"date_subscribed"=>date("Y-m-d H:i:s"));
        $table = "channel_subscriptions";
        $this->insertData($data, $table);
        return true;
    }

    public function unsubscribe($channel_id, $user_id)
    {
        # code...
        $sql = "DELETE FROM channel_subscriptions WHERE subscriber_id=:user_id AND channel_id=:channel_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('channel_id'=>$channel_id,'user_id'=>$user_id));
        return true;
    }

    public function search($channel_name)
    {
        # code...
        $data = "*";
        $table = "channel";
        $where = " where channel_name LIKE '%$channel_name%'";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

}
?>