<?php
    if(isset($_POST['paginate_post'])){
        $limit=5;
        $current_page=$_POST['current_page'];
        $paginated_posts=$post->fetch_all_infinite_scroll_pagination($limit,$current_page);
        $num_post=$post->get_num_posts();
        // find out total pages
        $total_pages = ceil($num_post / $limit);
        if ($current_page >= $total_pages) {
           // set current page to last page
           $end_of_posts = 1;
        }
        
        $message="";
        if(!empty($paginated_posts)){
            foreach ($paginated_posts as $question_post) {
                # code...
                $post_id=$question_post['post_id'];
                $poster_id=$question_post['user_id'];
                $poster_is_admin=$question_post['poster_is_admin'];
                if($poster_is_admin==1){
                    $poster_details=$admin->get_details_by_id($poster_id);
                    
                }else{
                    $poster_details=$user->get_details_by_id($poster_id);
                }
                
                $num_all_post_files=$post->get_num_all_files($post_id);
                $post_img="";
                $post_vid="";
                $post_aud="";
                if(!empty($num_all_post_files)){
                    $post_first_file=$post->get_all_files($post_id)[0];
                    $post_img=$post_first_file['image_path'];
                    $post_vid=$post_first_file['video_path'];
                    $post_aud=$post_first_file['audio_path'];
                }

                $num_file_remaiing=$num_all_post_files-1;
                $post_details=$question_post['post_details'];
                $is_deleted=$question_post['deleted'];
                $post_summary=$question_post['post_summary'];
                $to_public=$question_post['to_public'];
                $receivers=json_decode($question_post['receivers'],true);
                $who_receives=$receivers['receivers'];
                $should_display=0;
                $logged_in_user_category=json_decode($user->get_details($loggedin_email)["business_category"],true);
                $poster_image=$user->get_details($poster_details['email'])["profile_pix"];
                $poster_last_name=$user->get_details($poster_details['email'])["last_name"];
                $poster_first_name=$user->get_details($poster_details['email'])["first_name"];
                $poster_name=$poster_first_name." ".$poster_last_name;

                $time_question_posted=$master->time_ago($question_post['date_posted']);

                $num_views=$post->get_num_views($post_id);
                $num_answers=$post->get_num_answers($post_id)+$post->get_num_post_replies($post_id);

                $viewed_icon_btn_style="";
                if($post->user_has_viewed($post_id,$loggedin_user_id)){
                    $viewed_icon_btn_style="color:green";
                }

                $post_category=[];
                if($who_receives==2){ // If post is for category
                    $post_category=$receivers[0];
                    if(empty($logged_in_user_category))$should_display=1;
                    else{
                        if(!empty(array_intersect($logged_in_user_category,$receivers[0]))){
                            $should_display=1;
                        }
                    }
                }elseif($who_receives==1){ 
                    if(in_array($loggedin_user_id,$receivers[0])){
                        $should_display=1;
                    }
                }

                $pinned=$question_post['pinned'];
                $pin_text="";
                if($pinned==1){
                    $pin_text="<i class='fa fa-thumb-tack'></i>";
                }

                

                if(($should_display==1 || $loggedin_user_id==$poster_id || $to_public==1) && $is_deleted==0){

                    $message.="
                    <div class='card shadow-none'>
                        <div class='catd-body'>
                            <div class='row p-2'>
                                <div class='col-sm-6'>
                                    <div class='row'>
                                        <div class='col-lg-4 col-3'>
                                            <img src='$poster_image' alt='' class='img-fluid rounded-circle width-50'>
                                        </div>
                                        <div class='col-lg-8 col-7 p-0'>
                                        <h2> $post_summary</h2>
                                            <p> $time_question_posted</p>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <h5 class='m-0' style='text-align: right'>
                            ";
                                        if($poster_is_admin==1)
                            $message.='Admin';
                                        else  
                            $message.=ucwords($poster_name);
                            $message.="
                                    </h5>
                                    <h6> $pin_text</h6>
                                </div>
                            </div>
                            <div class='write-post'>
                                <div class='col-sm-12 px-2'>
                                    <p><a class='post-link' href='post_details.php?pid=".base64_encode($post_id)."'> $post_details</a></p>
                                </div>
                            ";
                                
                                    if($num_all_post_files>0){
                            $message.="            
                                    <div class='col-sm-12 px-2 pb-2'>
                            ";                   
                                            if($post_img!=""){
                            $message.="                     
                                                <img src='$post_img' alt='' class='img img-fluid' style='max-width:50%;max-height:50%;margin-left:25%;'>
                            ";                            
                                            }
                                            if($post_vid!=""){
                            $message.="                     
                                                <video class='video-js vjs-default-skin' data-setup='{\"fluid\":true}' controls style='width:100%'>
                                                    <source src='$post_vid' type=''>
                                                </video>
                            ";                    
                                            }
                                            if($post_aud!=""){
                            $message.="                    
                                                <audio src='$post_aud' preload='auto'></audio>
                            ";                    
                                            }
                            $message.="                     
                                    </div>
                            ";                
                                        if($num_all_post_files>1){
                            $message.="                 
                                            <div class='col-md-12' style='position:absolute;margin-top:-65px'>
                                                <li class='avatar avatar-sm' style='margin-left:55%'>
                                                    <span class='badge badge-info'>+ $num_file_remaiing  more</span>
                                                </li>
                                            </div>
                            ";            
                                        }
                                    }
                            $message.="             
                                <hr class='m-0'>
                                <div class='row p-1'>
                                    <div class='col-6'>
                                        <div class='row'>
                                            <div class='col-8 pl-0'>
                                                <ul class='list-unstyled users-list m-0'>
                            ";                                
                                                        $catCount=0;
                                                        if (!empty($post_category)){
                                                            foreach ($post_category as $categ) {
                                                                # code...
                                                                $catCount++;
                                                                $category_details=$master->get_category_details($categ);
                                                                $category_name=$category_details['category_name'];
                                                                $category_icon=$category_details['icon'];

                            $message.="                                
                                                    <li data-toggle='tooltip' data-popup='tooltip-custom' data-original-title=' $category_name '
                                                        class='avatar avatar-sm pull-up'>
                                                        &nbsp;&nbsp;<img class='media-object rounded-circle' src=' $category_icon '
                                                            alt='Avatar'>
                                                    </li>
                            ";                                
                                                                if($catCount==3) break;
                                                            }
                                                        }
                                                        if(count($post_category)>3){
                            $message.="                                 
                                                    <li class='avatar avatar-sm'>
                                                        <span class='badge badge-info'>+ (count($post_category)-3)  more</span>
                                                    </li>
                                                    
                                                        }
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-6'>
                                        <div class='pull-right'>
                                            <span class='pr-1'><i class='ft-eye h4 align-middle' style='$viewed_icon_btn_style'></i>  $num_views</span>
                                            <span class='pr-1'><i class='ft-message-circle h4 align-middle'></i>  $num_answers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    "; 

                }

            }
        }
    }
    exit(json_encode(["status"=>1,"posts"=>$message,"end_of_posts"=>1]));
    }