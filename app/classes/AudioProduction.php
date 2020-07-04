<?php
class AudioProduction extends Master
{

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////setters///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected $mp3;
   public  function __construct($db_conn,$lang,$mp3)
   {
        parent::__construct($db_conn,$lang);
        $this->mp3=$mp3;

          
   }

    public function generate_audio_id(){
        $id = $this->get_last_audio_id();
        return intval($id) + 1;
    }

    public function get_last_audio_id(){
        $data = array("audio_id");
        $table = "audio_production";
        $where = " ORDER BY id DESC";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
         }else{
            return $check['audio_id'];
        }  
    }

    public function upload($audio_name,$channel_id,$owner_id,$category,$price,$description,$age_min,$age_max,$is_free,$payment_mode,$artistes,$duration,$cover_pix)
    {
        # code...
        $audio_id=$this->generate_audio_id();
        $audio_production_path="../assets/audio_productions/$channel_id";
        $audio_production_path_db="assets/audio_productions/$channel_id";

        if(is_uploaded_file($_FILES['audio_file']['tmp_name'])){
            $create_audio_production_path=false;
            if(!file_exists($audio_production_path)){
                $create_audio_production_path = mkdir($audio_production_path, 0777, true);
            }
            $file_temp = $_FILES['audio_file']['tmp_name'];
            $file_name = $_FILES['audio_file']['name'];
            $ext =  pathinfo($file_name,PATHINFO_EXTENSION);
            if($ext == "mp3"){
                $own_name=date("YmdHis").".mp3";
                $uploaded_file_name =  $audio_production_path."/".$audio_id.$own_name;
                $uploaded_file_name_db= $audio_production_path_db."/".$audio_id.$own_name;

                $result =  move_uploaded_file($file_temp,$uploaded_file_name);
                if($result){
                    $path =  $uploaded_file_name_db;
                    if($price=="" && $age_max!="" && $age_min!=""){
                        $data = array("audio_id"=>$audio_id,"audio_name"=>$audio_name,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"category"=>$category,"description"=>$description,"restricted_age_min"=>$age_min,"restricted_age_max"=>$age_max,"is_free"=>$is_free,"audio_file_path"=>$path,"artistes"=>$artistes,"duration"=>$duration,"date_uploaded"=>date("Y-m-d H:i:s"));
                    }elseif($age_min=="" && $age_max!="" && $price!=""){
                        $data = array("audio_id"=>$audio_id,"audio_name"=>$audio_name,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"category"=>$category,"price"=>$price,"audio_file_path"=>$path,"description"=>$description,"restricted_age_max"=>$age_max,"is_free"=>$is_free,"artistes"=>$artistes,"duration"=>$duration,"date_uploaded"=>date("Y-m-d H:i:s"));
                    }elseif($age_max=="" && $age_min!="" && $price!=""){
                        $data = array("audio_id"=>$audio_id,"audio_name"=>$audio_name,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"category"=>$category,"price"=>$price,"description"=>$description,"restricted_age_min"=>$age_min,"is_free"=>$is_free,"audio_file_path"=>$path,"artistes"=>$artistes,"duration"=>$duration,"date_uploaded"=>date("Y-m-d H:i:s"));
                    }elseif($age_max=="" && $age_min=="" && $price==""){
                        $data = array("audio_id"=>$audio_id,"audio_name"=>$audio_name,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"category"=>$category,"description"=>$description,"is_free"=>$is_free,"audio_file_path"=>$path,"artistes"=>$artistes,"duration"=>$duration,"date_uploaded"=>date("Y-m-d H:i:s"));
                    }else{
                        $data = array("audio_id"=>$audio_id,"audio_name"=>$audio_name,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"category"=>$category,"price"=>$price,"description"=>$description,"restricted_age_min"=>$age_min,"restricted_age_max"=>$age_max,"is_free"=>$is_free,"audio_file_path"=>$path,"artistes"=>$artistes,"duration"=>$duration,"date_uploaded"=>date("Y-m-d H:i:s"));
                    }
                    
                    $table = "audio_production";
                    $this->insertData($data,$table);
                    if($price!=""){
                        $this->set_payment_mode($audio_id,$payment_mode);
                    }
                    $this->set_audio_preview($audio_id,$uploaded_file_name,$channel_id,$own_name);
                    $this->set_cover_pix($audio_id,$channel_id,$cover_pix);
                    return (json_encode(["status"=>1,"message"=>"Audio uploaded successfully"]));
                }
            }
            return (json_encode(["status"=>0,"message"=>"You did not select an mp3 file"]));
        }
    }

    public function set_payment_mode($audio_id,$payment_mode)
    {
        # code...
        $data = array("audio_id"=>$audio_id,"payment_mode"=>$payment_mode);
        $table = "audio_payment_mode";
        $this->insertData($data,$table);
        return true;
    }

    public function set_cover_pix($audio_id,$channel_id,$cover_pix)
    {
        # code...
        $audio_cover_photo_path="../assets/audio_cover_photos/$channel_id";
        $audio_cover_photo_path_db="assets/audio_cover_photos/$channel_id";

        $file_data= str_replace(" ","+",$cover_pix);
        $file_data=substr($file_data,strpos($file_data,",")+1);
        $file_data=base64_decode($file_data);

        $fileTypes=["image/jpg"=>"jpg","image/jpeg"=>"jpg","image/JPG"=>"jpg","image/png"=>"png","image/PNG"=>"png","image/jfif"=>"jfif"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type with mimetype extension   
        $file_type = finfo_file($finfo, $cover_pix);
        finfo_close($finfo);

        if(array_key_exists($file_type,$fileTypes)){
            $file_extension=$fileTypes[$file_type];
            if(!file_exists($audio_cover_photo_path)){
                $create_audio_cover_photo_path = mkdir($audio_cover_photo_path, 0777, true);
            }
            $file_path =  $audio_cover_photo_path."/".$audio_id.date("YmdHis").".$file_extension";
            $file_path_db= $audio_cover_photo_path_db."/".$audio_id.date("YmdHis").".$file_extension";
        }

        $file=fopen($file_path, "w");
        fwrite($file,$file_data);
        fclose($file);
        $data = array("audio_id"=>$audio_id,"picture_path"=>$file_path_db);
        $table = "audio_cover_picture";
        $this->insertData($data,$table);
        return json_encode(["status"=>1,"file_path"=>"$file_path_db"]);
        
    }
   
    public function set_audio_preview($audio_id,$audio_path,$channel_id,$audio_name)
    {
        # code...
        // $mp3=new MP3();
        // $audio_production_path="../assets/audio_productions/$channel_id";
        // $audio_production_path."/".$audio_id.date("YmdHis").".mp3";
        

        $preview_audio_path="../assets/audio_productions_preview/$channel_id/$audio_id"."$audio_name";
        
        $preview_audio_path_db="assets/audio_productions_preview/$channel_id/$audio_id"."$audio_name";

        if(!file_exists("../assets/audio_productions_preview/$channel_id")){
            $create_audio_production_path = mkdir("../assets/audio_productions_preview/$channel_id", 0777, true);
        }
        $phpmp3 = new PHPMP3($audio_path);
        $mp3_1 = $phpmp3->extract(0,60);
        $mp3_1->save($preview_audio_path);
        // $this->mp3->set_mp3($audio_path, $preview_audio_path, array(), array());

        // $this->mp3->cut_mp3($audio_path, $preview_audio_path, 0, 60, 'second', false);

        $data = array("audio_id"=>$audio_id,"audio_preview_path"=>$preview_audio_path_db);
        $table = "audio_preview_file";
        $this->insertData($data,$table);
        return true;
    }

    public function fetch_all_category()
    {
        # code...
        $data = "*";
        $table = "audio_category_available";
        $check=$this->getAllData($data,$table);
        return $check;
    }

    public function get_audio_preview_file($audio_id)
    {
        # code...
        $data = array("audio_preview_path");
        $table = "audio_preview_file";
        $where=" WHERE audio_id=$audio_id";
        $result=$this->getData($data,$table,$where);
        return $result['audio_preview_path'];
    }

    public function get_audio_cover_pix($audio_id)
    {
        # code...
        $data = array("picture_path");
        $table = "audio_cover_picture";
        $where=" WHERE audio_id=$audio_id";
        $result=$this->getData($data,$table,$where);
        return $result['picture_path'];
    }

    public function get_audio_payment_mode($audio_id)
    {
        # code...
        $data = array("payment_mode");
        $table = "audio_payment_mode";
        $where=" WHERE audio_id=$audio_id";
        $result=$this->getData($data,$table,$where);
        return $result['payment_mode'];
    }

    public function generate_promo_id(){
        $id = $this->get_last_promo_id();
        return intval($id) + 1;
    }

    public function get_last_promo_id(){
        $data = array("promo_id");
        $table = "audios_promotion";
        $where = " ORDER BY id DESC";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
         }else{
            return $check['promo_id'];
        }  
    }

    public function promote($promoted_audios,$audios_to_get,$num_audios_to_get,$promo_type,$discount,$audios_to_get_is_free,$audios_to_get_decider,$channel_id,$owner_id,$end_date)
    {
        # code...
        $promo_id=$this->generate_promo_id();
        $promo_code=$this->generate_promo_code();

        if($discount==""){
            $data = array("promo_id"=>$promo_id,"promoted_audios"=>$promoted_audios,"audios_to_get"=>$audios_to_get,"num_audios_to_get"=>$num_audios_to_get,"promo_type"=>$promo_type,"audios_to_get_is_free"=>$audios_to_get_is_free,"audios_to_get_decider"=>$audios_to_get_decider,"promo_code"=>$promo_code,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"date_created"=>date("Y-m-d H:i:s"),"end_date"=>$end_date);
        }else{
            $data = array("promo_id"=>$promo_id,"promoted_audios"=>$promoted_audios,"audios_to_get"=>$audios_to_get,"num_audios_to_get"=>$num_audios_to_get,"promo_type"=>$promo_type,"discount"=>$discount,"audios_to_get_is_free"=>$audios_to_get_is_free,"audios_to_get_decider"=>$audios_to_get_decider,"promo_code"=>$promo_code,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"date_created"=>date("Y-m-d H:i:s"),"end_date"=>$end_date);
        }
        $table = "audios_promotion";
        $result=$this->insertData($data,$table);
        return true;
    }

    public function generate_advert_id(){
        $id = $this->get_last_advert_id();
        return intval($id) + 1;
    }

    public function get_last_advert_id(){
        $data = array("advert_id");
        $table = "advert";
        $where = " ORDER BY id DESC";
    
        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
         }else{
            return $check['advert_id'];
        }  
    }

    public function advertise($company_name,$company_website,$which_prod_ad,$audios_on_channel_to_advertise,$channel_id,$owner_id,$cover_pix)
    {
        # code...
        $advert_id=$this->generate_advert_id();
        $advert_audio_path="../assets/adverts/$channel_id";
        $advert_audio_path_db="assets/adverts/$channel_id";

        $advert_audio_cover_pix_path="../assets/advert_cover_pix/$channel_id";
        $advert_audio_cover_pix_path_db="assets/advert_cover_pix/$channel_id";

        if(is_uploaded_file($_FILES['advert_audio']['tmp_name'])){
            $create_advert_audio_path=false;
            if(!file_exists($advert_audio_path)){
                $create_advert_audio_path = mkdir($advert_audio_path, 0777, true);
            }
            $file_temp = $_FILES['advert_audio']['tmp_name'];
            $file_name = $_FILES['advert_audio']['name'];
            $ext =  pathinfo($file_name,PATHINFO_EXTENSION);
            $accepted_file_types=["mp3","ogg"];
            if(in_array($ext,$accepted_file_types)){

                $uploaded_file_name =  $advert_audio_path."/".$advert_id.date("YmdHis").".$ext";
                $uploaded_file_name_db= $advert_audio_path_db."/".$advert_id.date("YmdHis").".$ext";

                $result =  move_uploaded_file($file_temp,$uploaded_file_name);
                if($result){
                    $path =  $uploaded_file_name_db;
                }
            }

            $file_data= str_replace(" ","+",$cover_pix);
            $file_data=substr($file_data,strpos($file_data,",")+1);
            $file_data=base64_decode($file_data);

            $fileTypes=["image/jpg"=>"jpg","image/jpeg"=>"jpg","image/JPG"=>"jpg","image/png"=>"png","image/PNG"=>"png","image/jfif"=>"jfif"];

            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type with mimetype extension   
            $file_type = finfo_file($finfo, $cover_pix);
            finfo_close($finfo);

            if(array_key_exists($file_type,$fileTypes)){
                $file_extension=$fileTypes[$file_type];
                if(!file_exists($advert_audio_cover_pix_path)){
                    $create_advert_audio_cover_pix_path = mkdir($advert_audio_cover_pix_path, 0777, true);
                }
                $file_path =  $advert_audio_cover_pix_path."/".$advert_id.date("YmdHis").".$file_extension";
                $file_path_db= $advert_audio_cover_pix_path_db."/".$advert_id.date("YmdHis").".$file_extension";
                $cover_path=$file_path_db;
            }else{
                return false;
            }

            $file=fopen($file_path, "w");
            fwrite($file,$file_data);
            fclose($file);
            
            $data = array("advert_id"=>$advert_id,"company_name"=>$company_name,"company_website"=>$company_website,"advert_type"=>$which_prod_ad,"audios_on_channel"=>$audios_on_channel_to_advertise,"channel_id"=>$channel_id,"owner_id"=>$owner_id,"audio_file_path"=>$path,"advert_cover_pix"=>$cover_path,"date_created"=>date("Y-m-d H:i:s"));
            $table = "advert";
            $this->insertData($data,$table);
            return true;
        }

        
    }

    public function fetch_all_free_audios()
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where is_free=1";
    
        $result = $this->getAllData($data, $table, $where);
        return $result;
    }

    public function fetch_all_priced_audios()
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where is_free=0";
    
        $result = $this->getAllData($data, $table, $where);
        return $result;
    }

    public function fetch_all()
    {
        # code...
        $data = "*";
        $table = "audio_production";
    
        $result = $this->getAllData($data, $table);
        return $result;
    }

    public function fetch_all_promotions()
    {
        # code...
        $data = "*";
        $table = "audios_promotion";
        $where= " where end_date > CURDATE()";
    
        $result = $this->getAllData($data,$table,$where);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_all_adverts()
    {
        # code...
        $data = "*";
        $table = "advert";
    
        $result = $this->getAllData($data, $table);
        return $result;
    }

    public function details($audio_id)
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where audio_id=$audio_id";
    
        $result = $this->getData($data, $table, $where);
        return $result;
    }

    public function get_promo_details($promo_id)
    {
        # code...
        $data = "*";
        $table = "audios_promotion";
        $where = " where promo_id=$promo_id";
    
        $result = $this->getData($data, $table, $where);
        return $result;
    }

    public function rate_audio($audio_id,$rater_id,$rate,$comment)
    {
        # code...
        // $num_star=$this->calc_post_answer_rate($percent);
        $data=array("audio_id"=>$audio_id,"rater_id"=>$rater_id,"rate"=>$rate,"comment"=>$comment,"date_rated"=>date("Y-m-d H:i:s"));
        $table="audio_rating";
        $this->insertData($data,$table);
        return true;
    }

    

    public function get_audio_rating($audio_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(audio_id) From  audio_rating WHERE audio_id=:audio_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('audio_id'=>$audio_id));
        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    public function get_user_audio_rating($audio_id,$user_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(audio_id) From  audio_rating WHERE audio_id=:audio_id AND rater_id=:rater_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('audio_id'=>$audio_id,"rater_id"=>$user_id));
        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    public function get_audio_category_details($category_id)
        {
            # code...
            $data = "*";
            $table = "audio_category_available";
            $where = " where category_id=$category_id";
        
            $check = $this->getData($data, $table, $where);
            return $check;
        }

    public function fetch_all_comments($audio_id)
    {
        # code...
        $data = "*";
        $table = "audio_rating";
        $where = " where audio_id=$audio_id";
    
        $result = $this->getAllData($data, $table, $where);
        return $result;
    }

    public function fetch_transaction_history()
    {
        # code...
        $data = "*";
        $table = "transactions";
    
        $result = $this->getAllData($data, $table);
        if(empty($result)) return [];
        return $result;
    }

    public function fetch_this_month_transaction_history($month,$year)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where= " where MONTH(date_purchased) = $month AND YEAR(date_purchased)=$year";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function create_transaction($audio_id,$user_id,$price){
        $data=array("audio_id"=>$audio_id,"buyer_id"=>$user_id,"price"=>$price,"date_purchased"=>date("Y-m-d H:i:s"));
        $table="transactions";
        $this->insertData($data,$table);
        return true;
    }

    public function get_num_downloads($audio_id)
    {
        # code...
        $data = "*";
        $table = "transactions";
        $where = " where audio_id=$audio_id AND downloaded=1";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)){
            return 0;
        }else{
            return count($result);

        }
    }

    public function get_revenue_generated($audio_id)
    {
        # code...

        $sql = "SELECT SUM(price)From transactions WHERE audio_id=:audio_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('audio_id'=>$audio_id));
        if(empty($stmt)){
            return 0;
        }else{
            $revenue=$stmt->fetchColumn();
            if(is_null($revenue)) return 0;
            else return $revenue;
        }
    }

    public function search($audio_name)
    {
        # code...
        $data = "*";
        $table = "audio_production";
        $where = " where audio_name LIKE '%$audio_name%'";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function search_promo($promo_code)
    {
        # code...
        $data = "*";
        $table = "audios_promotion";
        $where = " where promo_code LIKE '%$promo_code%' AND end_date > CURDATE()";
    
        $result = $this->getAllData($data, $table, $where);
        if(empty($result)) return [];
        return $result;
    }

    public function delete($audio_id)
    {
        # code...
        $data = ["deleted"=>1];
        $table = "audio_production";
        $where = " where audio_id=$audio_id";
    
        $this->updateData($data, $table, $where);
        
    }

    public function restore($audio_id)
    {
        # code...
        $data = ["deleted"=>0];
        $table = "audio_production";
        $where = " where audio_id=$audio_id";
    
        $this->updateData($data, $table, $where);
        
    }
}
?>