<?php
class post extends Master
{

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////setters///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
   public  function __construct($db_conn,$lang)
   {
        parent::__construct($db_conn,$lang);
          
   }

    // generate post id from previously generated id
    public function generate_post_id(){
        /*this method generate id for new post*/
        $id = $this->get_last_post_id();
        return intval($id) + 1;
    }

    public function get_last_post_id(){
        $data = array("post_id");
        $table = "post";
        $where = " ORDER BY id DESC";

        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
        }else{
            return $check['post_id'];
        }  
    }


    public function get_answer_details($answer_id){
        $data = "*";
        $table = "post_answers";
        $where = " where answer_id=$answer_id";

        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return [];
        }else{
            return $check;
        }  
    }


    // generate post id from previously generated id
    public function generate_post_answer_id(){
        /*this method generate id for new post*/
        $id = $this->get_last_post_answer_id();
        return intval($id) + 1;
    }

    public function get_last_post_answer_id(){
        $data = array("answer_id");
        $table = "post_answers";
        $where = " ORDER BY id DESC";

        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
        }else{
            return $check['answer_id'];
        }  
    }

    // generate post id from previously generated id
    public function generate_post_answer_reply_id(){
        /*this method generate id for new post*/
        $id = $this->get_last_post_answer_reply_id();
        return intval($id) + 1;
    }

    public function get_last_post_answer_reply_id(){
        $data = array("reply_id");
        $table = "post_answer_replies";
        $where = " ORDER BY id DESC";

        $check = $this->getData($data, $table, $where);
        if(empty($check)){
            return 0;
        }else{
            return $check['reply_id'];
        }  
    }

    public function send($user_id,$post_summary,$post_details,$to_public,$receivers,$url,$post_id,$file_counter)
    {
        # code...
        if($post_id==""){
            $post_id=$this->generate_post_id();
        }else{
            $post_id=$post_id;
        }
        $audio_path="";
        $image_path="";
        $video_path="";

        if($url!=""){
            $store_media=json_decode($this->store_media($user_id,$post_id,$url,$file_counter),true);
            $file_type=$store_media["file_type"];
            $file_path=$store_media["file_path"];
            if($file_type=="audio"){
                $audio_path=$file_path;
            }elseif($file_type=="image"){
                $image_path=$file_path;
            }elseif($file_type=="video"){
                $video_path=$file_path;
            }
        }
        
        $data = array("post_id"=>$post_id,"user_id"=>$user_id,"post_summary"=>$post_summary,"post_details"=>$post_details,"to_public"=>1,"receivers"=>$receivers,"audio_path"=>"$audio_path","video_path"=>"$video_path","image_path"=>"$image_path","date_posted"=>date("Y-m-d H:i:s"));
        $table = "post";
        $this->insertData($data,$table);
        // $this->upload_media($user_id,$post_id);
        return $post_id;
    }

    public function store_media($user_id,$post_id,$url,$file_counter)
    {
        # code...
        $username=$this->get_username_by_id($user_id);

        $file_data= str_replace(" ","+",$url);
        $file_data=substr($file_data,strpos($file_data,",")+1);
        $file_data=base64_decode($file_data);

        $fileTypes=["audio/mp3"=>"mp3","audio/ogg"=>"ogg","audio/mpeg"=>"mp3","image/jpg"=>"jpg","image/jpeg"=>"jpg","image/JPG"=>"jpg","image/gif"=>"gif","image/png"=>"png","image/PNG"=>"png","video/mp4"=>"mp4"];

        $file_repos=["mp3"=>"audio","ogg"=>"audio","jpg"=>"image","gif"=>"image","png"=>"image","mp4"=>"video"];

        $file_path="../assets/quesions_media/$username/$post_id/";
        $file_path_db="assets/quesions_media/$username/$post_id/";


        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type with mimetype extension   
        $file_type = finfo_file($finfo, $url);
        finfo_close($finfo);

        if(array_key_exists($file_type,$fileTypes)){
            $file_extension=$fileTypes[$file_type];
            if(array_key_exists($file_extension,$file_repos)){
                $file_repo=$file_repos[$file_extension];
                if(!file_exists($file_path.$file_repo)){
                    $create_question_media_path = mkdir($file_path.$file_repo, 0777, true);
                }
                $file_path.=$file_repo."/$file_counter-".date("Y-m-d_H-i-s").".".$file_extension;
                $file_path_db.=$file_repo."/$file_counter-".date("Y-m-d_H-i-s").".".$file_extension;

            }
        }

        $file=fopen($file_path, "w");
        fwrite($file,$file_data);
        fclose($file);
        return json_encode(["status"=>1,"file_path"=>"$file_path_db","file_type"=>$file_repo]);
    }

    public function send_to_private($user_id,$post_summary,$post_details,$receivers,$url)
    {
        # code...
        $post_id=$this->generate_post_id();
        $data = array("post_id"=>$post_id,"user_id"=>$user_id,"post_summary"=>$post_summary,"post_details"=>$post_details,"to_public"=>0,"receivers"=>$receivers,"audio_path"=>"","video_path"=>"","image_path"=>"","date_posted"=>date("Y-m-d H:i:s"));
        $table = "post";
        $this->insertData($data,$table);
        $this->upload_media($user_id,$post_id);
        return true;
    }

    public function send_to_category($user_id,$post_summary,$post_details,$receivers)
    {
        # code...
        $post_id=$this->generate_post_id();
        $data = array("post_id"=>$post_id,"user_id"=>$user_id,"post_summary"=>$post_summary,"post_details"=>$post_details,"to_public"=>0,"receivers"=>$receivers,"audio_path"=>"","video_path"=>"","image_path"=>"","date_posted"=>date("Y-m-d H:i:s"));
        $table = "post";
        $this->insertData($data,$table);
        $this->upload_media($user_id,$post_id);
        return true;
    }

    public function send_to_consultant($user_id,$post_summary,$post_details,$receivers)
    {
        # code...
        $post_id=$this->generate_post_id();
        $data = array("post_id"=>$post_id,"user_id"=>$user_id,"post_summary"=>$post_summary,"post_details"=>$post_details,"to_public"=>0,"receivers"=>$receivers,"audio_path"=>"","video_path"=>"","image_path"=>"","date_posted"=>date("Y-m-d H:i:s"));
        $table = "post";
        $this->insertData($data,$table);
        $this->upload_media($user_id,$post_id);
        return true;
    }

    public function upload_media($user_id,$question_id)
    {
        $post_id=$question_id;
        $username=$this->get_username_by_id($user_id);
        $question_media_path = "../assets/quesions_media/$username/$question_id";
        $question_audio_path="../assets/quesions_media/$username/$question_id/audio";
        $question_video_path="../assets/quesions_media/$username/$question_id/video";
        $question_image_path="../assets/quesions_media/$username/$question_id/image";

        // $path = $profile_pix_path."/avatar.png"; // default profile pix
        //make the directory
        $create_question_media_path=false;
        if(!file_exists($question_media_path)){
            $create_question_media_path = mkdir($question_media_path, 0777, true);
        }
        // if($create_profile_pix_path){
            //check if picture is uploaded
        if(is_uploaded_file($_FILES['question_audio']['tmp_name'])){
            $create_question_audio_path=false;
            if(!file_exists($question_audio_path)){
                $create_question_audio_path = mkdir($question_audio_path, 0777, true);
            }
            $file_temp = $_FILES['question_audio']['tmp_name'];
            $file_name = $_FILES['question_audio']['name'];
            $ext =  pathinfo($file_name,PATHINFO_EXTENSION);
            if($ext == "mp3" || $ext == "ogg"){

                $uploaded_file_name =  $question_audio_path."/".$file_name;

                $result =  move_uploaded_file($file_temp,$uploaded_file_name);
                if($result){
                    $path =  $uploaded_file_name;
                    $data = array("post_id"=>$post_id,"audio_path"=>$uploaded_file_name);
                    $table = "post";
                    $this->updateData($data,$table);
                    return true;
                }
            }
        }elseif(is_uploaded_file($_FILES['question_video']['tmp_name'])){
            $create_question_video_path=false;
            if(!file_exists($question_video_path)){
                $create_question_video_path = mkdir($question_video_path, 0777, true);
            }
            $file_temp = $_FILES['question_video']['tmp_name'];
            $file_name = $_FILES['question_video']['name'];
            $ext =  pathinfo($file_name,PATHINFO_EXTENSION);
            if($ext == "mp4"){

                $uploaded_file_name =  $question_video_path."/".$file_name;

                $result =  move_uploaded_file($file_temp,$uploaded_file_name);
                if($result){
                    $path =  $uploaded_file_name;
                    $data = array("post_id"=>$post_id,"video_path"=>$uploaded_file_name);
                    $table = "post";
                    $this->updateData($data,$table);
                    return true;
                }
            }
        }elseif(is_uploaded_file($_FILES['question_image']['tmp_name'])){
            $create_question_image_path=false;
            if(!file_exists($question_image_path)){
                $create_question_image_path = mkdir($question_image_path, 0777, true);
            }
            $file_temp = $_FILES['question_image']['tmp_name'];
            $file_name = $_FILES['question_image']['name'];
            $ext =  pathinfo($file_name,PATHINFO_EXTENSION);
            if($ext == "jpg" || $ext == "png" || $ext == "PNG"){

                $uploaded_file_name =  $question_image_path."/".$file_name;

                $result =  move_uploaded_file($file_temp,$uploaded_file_name);
                if($result){
                    $path =  $uploaded_file_name;
                    $data = array("post_id"=>$post_id,"image_path"=>$uploaded_file_name);
                    $table = "post";
                    $this->updateData($data,$table);
                    return true;
                }
            }
        }
        // }
    }

    public function add_answer($post_id,$poster_id,$answerer_id,$answer)
    {
        # code...
        $answer_id=$this->generate_post_answer_id();
        $data = array("post_id"=>$post_id,"answer_id"=>$answer_id,"poster_id"=>$poster_id,"answerer_id"=>$answerer_id,"answer"=>$answer,"date_answered"=>date("Y-m-d H:i:s"));
        $table = "post_answers";
        $this->insertData($data,$table);
        $this->update_num_answers($post_id);
        return $answer_id;

    }
    public function update_num_views($post_id)
    {
        # code...
        $num_views=$this->get_num_views($post_id);
        if($num_views==0){
            $data=array("post_id"=>$post_id,"num_views"=>$num_views);
            $table="num_post_views";
            $this->insertData($data,$table);
        }else{
            $data=array("num_views"=>$num_views);
            $table="num_post_views";
            $where=" where post_id=$post_id";
            $this->updateData($data,$table,$where);
        }
    }

    public function update_num_answers($post_id)
    {
        # code...
        $num_answers=$this->get_num_answers($post_id);
        if($num_answers==0){
            $data=array("post_id"=>$post_id,"num_answers"=>$num_answers);
            $table="num_post_answers";
            $this->insertData($data,$table);
        }else{
            $data=array("num_answers"=>$num_answers);
            $table="num_post_answers";
            $where=" where post_id=$post_id";
            $this->updateData($data,$table,$where);
        }
        
        return true;
    }
    public function update_num_replies($post_id)
    {
        # code...
        $num_replies=$this->get_num_post_replies($post_id);
        if($num_replies==0){
            $data=array("post_id"=>$post_id,"num_replies"=>$num_replies);
            $table="num_post_replies";
            $this->insertData($data,$table);
        }else{
            $data=array("num_replies"=>$num_replies);
            $table="num_post_replies";
            $where=" where post_id=$post_id";
            $this->updateData($data,$table,$where);
        }
        
        return true;
    }

    public function fetch_popular()
    {

        $data="*";
        $table="num_post_answers";
        $result=$this->getAllData($data,$table);
        $post_ordered_by_num_answers=[];
        if(!empty($result)){
            $post_ordered_by_num_answers=$result;
        }

        $data="*";
        $table="num_post_views";
        $result=$this->getAllData($data,$table);
        $post_ordered_by_num_views=[];
        if(!empty($result)){
            $post_ordered_by_num_views=$result;
        }

        $data="*";
        $table="num_post_replies";
        $result=$this->getAllData($data,$table);
        $post_ordered_by_num_replies=[];
        if(!empty($result)){
            $post_ordered_by_num_replies=$result;
        }

        $popular_posts=[];
        $i=0;
        if(!empty($post_ordered_by_num_views )){
            foreach ($post_ordered_by_num_views as $post_v) {
                # code...
                $post_a=$post_ordered_by_num_answers[$i];
                $post_r=$post_ordered_by_num_replies[$i];
                $popularity=$post_v["num_views"]+$post_a["num_answers"]+$post_r["num_replies"];
                $popular_posts[]=array("post_id"=>$post_v["post_id"],"popularity"=>$popularity);
                $i++;
            }
            usort($popular_posts, function ($post1, $post2) {
                return $post1['popularity'] <= $post2['popularity'];
            });
        }

        return $popular_posts;
    }

    public function fetch_all_answers($post_id)
    {
        # code...
        $data="*";
        $table="post_answers";
        $where=" where post_id=$post_id ORDER BY id DESC";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }

    public function fetch_all_answer_replies($answer_id)
    {
        # code...
        $data="*";
        $table="post_answer_replies";
        $where=" where answer_id=$answer_id";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }

    public function fetch_all_post_replies($post_id)
    {
        # code...
        $data="*";
        $table="post_answer_replies";
        $where=" where post_id=$post_id";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }
    public function get_num_post_replies($post_id)
    {
        # code...
        return count($this->fetch_all_post_replies($post_id));
    }

    public function get_num_answers($post_id)
    {
        # code...
        return count($this->fetch_all_answers($post_id));
    }

    public function reply_answer($post_id,$answer_id,$poster_id,$answerer_id,$replier_id,$reply)
    {
        # code...
        $reply_id=$this->generate_post_answer_reply_id();
        $data = array("post_id"=>$post_id,"answer_id"=>$answer_id,"reply_id"=>$reply_id,"poster_id"=>$poster_id,"answerer_id"=>$answerer_id,"replier_id"=>$replier_id,"reply"=>$reply,"date_replied"=>date("Y-m-d H:i:s"));
        $table = "post_answer_replies";
        $this->insertData($data,$table);
        $this->update_num_replies($post_id);
        return $reply_id;
    }

    public function ignore($post_id,$receiver_id)
    {
        $data = array("post_id"=>$post_id,"receiver_id"=>$receiver_id,"date_ignored"=>date("Y-m-d H:i:s"));
        $table = "ignored_posts";
        $this->insertData($data,$table);
        return true;
    }

    public function mark_post_answer_useful($post_id,$poster_id,$answer_id,$answerer_id,$liker_id,$is_useful)
    {
        # code...
        $has_rated=0;
        if($is_useful==0){
            $has_rated=0;
        }else{
            if($this->user_has_rated_answer($answer_id,$liker_id)){
                $has_rated=1;
            }else{
                $has_rated=0;
            }
        }
        
        if($this->user_has_liked_post_answer($answer_id,$liker_id)){
            $data=array("is_useful"=>$is_useful,"rate"=>0,"has_rated"=>$has_rated,"date_marked_useful"=>date("Y-m-d H:i:s"));
            $table="post_answer_useful";
            $where=" where liker_id=$liker_id AND answer_id=$answer_id";
            $this->updateData($data,$table,$where);
            return true;
        }else{
            $data=array("post_id"=>$post_id,"poster_id"=>$poster_id,"answer_id"=>$answer_id,"answerer_id"=>$answerer_id,"liker_id"=>$liker_id,"is_useful"=>$is_useful,"date_marked_useful"=>date("Y-m-d H:i:s"));
            $table="post_answer_useful";
            $this->insertData($data,$table);
            return true;
        }
        
    }

    // Function to check if user has marked post answer as useful or not useful
    public function user_has_liked_post_answer($answer_id,$liker_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND liker_id=$liker_id";
        $result=$this->getData($data,$table,$where);
        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }

    public function fetch_all()
    {
        # code...
        $data="*";
        $table="post";
        $where=" ORDER BY id DESC";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }

    public function get_num_posts()
    {
        # code...
        return count($this->fetch_all());
    }

    public function get_all_files($post_id)
    {
        # code...
        $data=array("video_path","image_path","audio_path");
        $table="post";
        $where=" where (video_path<>'' OR image_path<>'' OR audio_path<>'') AND post_id=$post_id ";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }

    public function get_num_all_files($post_id)
    {
        # code...
        return count($this->get_all_files($post_id));
    }

    public function get_details($post_id)
    {
        # code...
        $data="*";
        $table="post";
        $where=" where post_id=$post_id";
        $result=$this->getData($data,$table,$where);
        return $result;
    }

    public function get_answer_reply_details($answer_id,$reply_id)
    {
        # code...
        $data="*";
        $table="post_answer_replies";
        $where=" where answer_id=$answer_id AND reply_id=$reply_id";
        $result=$this->getData($data,$table,$where);
        return $result;
    }

    public function user_has_viewed($post_id,$viewer_id)
    {
        # code...
        $data="*";
        $table="post_views";
        $where=" where post_id=$post_id AND viewer_id=$viewer_id";
        $result=$this->getAllData($data,$table,$where);
        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }

    public function add_as_viewed($post_id,$viewer_id)
    {
        # code...
        if(!$this->user_has_viewed($post_id,$viewer_id)){
            $data = array("post_id"=>$post_id,"viewer_id"=>$viewer_id);
            $table = "post_views";
            $this->insertData($data,$table);
            $this->update_num_views($post_id);
        }
        
    }

    public function fetch_all_views($post_id)
    {
        # code...
        $data="*";
        $table="post_views";
        $where=" where post_id=$post_id";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }

    public function get_num_views($post_id)
    {
        # code...
        return count($this->fetch_all_views($post_id));
    }

    public function calc_post_answer_rate($percent)
    {
        # code...
        $num_star=($percent/100)*5;
        return $num_star;
    }

    public function num_star_to_percent($num_star)
    {
        # code...
        $rate_percent=($num_star*100)/5;
        return $rate_percent;
    }

    public function rate_post_answer($answer_id,$liker_id,$answer_rate)
    {
        # code...
        // $num_star=$this->calc_post_answer_rate($percent);
        $data=array("rate"=>$answer_rate,"has_rated"=>1);
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND liker_id=$liker_id";
        $this->updateData($data,$table,$where);
        return true;
    }

    public function rate_post($answer_id,$percent)
    {
        # code...
        $num_star=$this->calc_post_answer_rate($percent);
        $data=array("rate_stars"=>$num_star);
        $table="post_answers";
        $where=" where answer_id=$answer_id";
        $this->updateData($data,$table,$where);
        return true;
    }

    // User rate for a post answer
    public function get_user_rate_for_post_answer($answer_id,$liker_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(answer_id) From  post_answer_useful WHERE answer_id=:answer_id AND liker_id=:liker_id 
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('answer_id'=>$answer_id,'liker_id'=>$liker_id));
        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    // Rate of a consultant for a particular answer
    public function get_average_answer_rate($answer_id,$answerer_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(answer_id) From  post_answer_useful WHERE answerer_id=:answerer_id AND answer_id=:answer_id
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('answerer_id'=>$answerer_id,'answer_id'=>$answer_id));
        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    // Rate of a consultant for a particular post
    public function get_average_post_rate($post_id,$poster_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(post_id) From  post_useful WHERE poster_id=:poster_id AND post_id=:post_id
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('poster_id'=>$poster_id,'post_id'=>$post_id));
        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    // Total Rate of a consultant in the whole system
    public function get_consultant_rate($answerer_id)
    {
        # code...
        $sql = "SELECT SUM(rate)/COUNT(answerer_id) From  post_answer_useful WHERE answerer_id=:answerer_id
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('answerer_id'=>$answerer_id));

        if(empty($stmt)){
            return 0;
        }else{
            $rateValue=$stmt->fetchColumn();
            if(is_null($rateValue)) return 0;
            else return $rateValue;
        }
    }

    public function people_who_clicked_post_answer_useful($answer_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND is_useful=1";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }
    public function num_people_who_clicked_post_answer_useful($answer_id)
    {
        return count($this->people_who_clicked_post_answer_useful($answer_id));
    }

    public function people_who_clicked_post_answer_not_useful($answer_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND is_useful=0";
        $result=$this->getAllData($data,$table,$where);
        if(!empty($result)){
            return $result;
        }else{
            return [];
        }
    }
    public function num_people_who_clicked_post_answer_not_useful($answer_id)
    {
        return count($this->people_who_clicked_post_answer_not_useful($answer_id));
    }

    public function user_has_cliked_post_answer_useful($answer_id,$liker_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND liker_id=$liker_id AND is_useful=1";
        $result=$this->getData($data,$table,$where);
        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }
    public function user_has_cliked_post_answer_not_useful($answer_id,$liker_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND liker_id=$liker_id AND is_useful=0";
        $result=$this->getData($data,$table,$where);
        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }

    public function user_has_rated_answer($answer_id,$liker_id)
    {
        # code...
        $data="*";
        $table="post_answer_useful";
        $where=" where answer_id=$answer_id AND liker_id=$liker_id AND has_rated=1";
        $result=$this->getData($data,$table,$where);
        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }



    

}
?>