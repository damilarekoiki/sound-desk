<?php
	include "../app/init.php";

  include("header.php");
  $all_posts=$post->fetch_all();

?>

<div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"></h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                 
                </ol>
              </div>
            </div>
          </div>
</div>

        <div class="container centered">
        	<div class="col-sm-12">
        <h1>POSTS</h1>
    </div>
    </div>

<!-- The Modal pined -->
  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Pin Post</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="pinAlert"></div>
          <div id="postDetails">
            <p> <span><b>Post Title:</b></span> <span>How to rear cows personally</span></p>
            <p> <span><b>Author:</b></span> <span>Moyosore</span></p>
          </div>
          <span style="display:none;color:blue;cursor:pointer" id="viewExtraDetails" onclick="getPostExtraDetails()">View datails</span>
        

        <!--  -->
        <div class="collapse" id="postExtraDetails">
          <p>Number of views: <span id="numViews"></span></p>
          <p>Number of comments: <span id="numComments"></span></p>
          <p>Date posted: <span id="datePosted"></span></p>

        </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success pinner" onmouseover="checkPin(this,1)" onclick="pin(this,1)">Pin to Homepage</button>
           <button type="button" class="btn btn-danger pinner" onmouseover="checkPin(this,0)" onclick="pin(this,0)">Unpin from Homepage</button>
        </div>
        
      </div>
    </div>
  </div>




 <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Edit Post</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <!-- User Post 3 -->
            <div class="card shadow-none">
                <div class="catd-body">
                    <div class="row p-2">
                      <div id="commentAlert"></div>
                    	<!--topic title -->
                    	<div class="col-12">
                    		<h4>Add your Comment <i class="ft-edit-3"></i>.</h4>
                    	</div>
                    </div>
                    <form id="postCommentForm">
                      <div class=" col-10 write-post">
                        <fieldset class="form-group">
                              <textarea class="form-control" name="answer" id="descTextarea" rows="3" placeholder="Enter your comment.."></textarea>
                          </fieldset>
                      </div>
                      <div class="col-10">
                        <div class="pull-right" id="bottom">
                            <span class="pr-1"><button type="button" id="postCommentBtn" class="btn btn-success btn-sm">Submit </button></span>
                            
                          </div>
                      </div>
                    </form>
                </div><br><br>
            </div>
            <!-- -->
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


  <!-- The Modal -->
  <div class="modal" id="mModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">

          <h2 class="modal-title">Delete Post</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
       <!-- Modal body -->
        <div class="modal-body">
          <div id="deleteAlert"></div>
          <div class="alert alert-warning" role="alert">
                Are you sure you want to delete this Post?
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="deletePost(1)">Yes</button>
           <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        </div>
        
      </div>
    </div>
  </div>
  <section id="configuration">
  <div class="">
    <div class="col-md-12">
      <div class="card center">
        <div class="card-header">
         
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
           
        <a href="deleted_post.php"><button type="button" class="btn btn-success btn-md">View Deleted Post</button></a>
     
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><!-- <div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div></div></div> --><div class="row"><div class="col-sm-12"><table class="table table-striped table-bordered dataex-res-configuration dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1303px;">
              <thead>
                <tr role="row">
                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">ID</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">Post Title</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Category</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Author</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Date</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $displayed_posts=[];
                    $count_post=0;
                  if(!empty($all_posts)){
                    $has_displayed=0;
                    foreach ($all_posts as $p_post) {
                      # code...
                      $post_id=$p_post["post_id"];
                      if(!in_array($post_id,$displayed_posts)){
                        // var_dump(!in_array($post_id,$displayed_posts));
                        // var_dump($post->fetch_all_answers($post_id));


                        array_push($displayed_posts,$post_id);
                        $question_post=$post->get_details($post_id);
                        $poster_id=$question_post['user_id'];

                        $is_deleted=$question_post['deleted'];
                        if($is_deleted==1){
                          continue;
                        }
                      $count_post++;


                        $post_summary=$question_post['post_summary'];
                        $poster_details=$user->get_details_by_id($poster_id);
                        $poster_last_name=$poster_details["last_name"];
                        $poster_first_name=$poster_details["first_name"];
                        $pinned=$question_post['pinned'];
                        $poster_name=$poster_first_name." ".$poster_last_name;
                        $num_all_post_files=$post->get_num_all_files($post_id);
                        $time_question_posted=date("d-m-Y",strtotime($question_post['date_posted']));
                        $post_img="";
                        $post_vid="";
                        $post_aud="";
                        if(!empty($num_all_post_files)){
                            $post_first_file=$post->get_all_files($post_id)[0];
                            $post_img=$post_first_file['image_path'];
                            $post_vid=$post_first_file['video_path'];
                            $post_aud=$post_first_file['audio_path'];
                        }
                        $receivers=json_decode($question_post['receivers'],true);

                        $who_receives=$receivers['receivers'];
                        $post_category=[];
                        $bs_cat="";
                        if($who_receives==2){ // If post is for category
                            $post_category=$receivers[0];
                        }
                        $i=0;
                        if(!empty($post_category)){
                          foreach ($post_category as $cate) {
                              # code...
                              $catename=$master->get_business_category_name($cate);
                              $bs_cat.=$catename;
                              if($i!=count($post_category)-1){
                                  $bs_cat.=", ";
                              }
              
                              $i++;
                          }
                        }
              ?>
                        <tr role="row" class="odd">
                          <td tabindex="0" class="sorting_1"><?php echo $count_post;?></td>
                          <td><?php echo $post_summary;?></td>
                          <td><?php echo $bs_cat;?></td>
                          <td><?php echo $poster_name;?></td>
                          <td><?php echo $time_question_posted;?></td>
                          <td>
                            <button type="button" class="btn btn-success btn-sm"><i class="ft-bookmark" onclick="getPostDetails(<?php echo $post_id;?>,<?php echo $poster_id;?>,<?php echo $pinned;?>);showModal()"></i></button>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal" onclick="getPostDetails(<?php echo $post_id;?>,<?php echo $poster_id;?>,<?php echo $pinned;?>)"><i class="ft-edit-2"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#mModal" onclick="getPostDetails(<?php echo $post_id;?>,<?php echo $poster_id;?>,<?php echo $pinned;?>)"><i class="ft-x"></i></button>
                          </td>
                          
                        </tr>
              <?php
                      }
                  }
                }
              ?>
              </tbody>
            </table></div></div><div class="row"><!-- <div class="col-sm-12 col-md-5"><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div> --><!-- <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div> --></div></div>        
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


  <?php
  include("footer.php")
  ?>

  <script>
    var postId=0;
    var posterId=0;
    var pinned=0;
    function getPostDetails(post_id,poster_id,is_pinned){
      $(".pinner").css({
        "cursor":"pointer",
      })
      postId=post_id;
      posterId=poster_id;
      pinned=is_pinned;
      $("#postExtraDetails").hide()
      $("#postDetails").html("Loading...");

      formData=new FormData()
      formData.append("post_id",postId)
      formData.append("poster_id",posterId)
      formData.append("get_post_details",1)

      $.ajax({
        type:"POST",
        data:formData,
        url:"../parsers/admin_parser.php",
        cache:false,
        processData: false,
        contentType: false,
        success:function(data){
          $("#postDetails").html(data);
          $("#viewExtraDetails").show();
          
        }
      })
    }
    
    function showModal(){
      $("#Modal").modal("show")
    }

    countExtra=0
    function getPostExtraDetails(){
      $("#postExtraDetails").html("Loading...");
      countExtra++
      formData=new FormData()
      formData.append("post_id",postId)
      formData.append("countExtra",countExtra)
      formData.append("get_post_extra_details",1)

      $.ajax({
        type:"POST",
        data:formData,
        url:"../parsers/admin_parser.php",
        cache:false,
        processData: false,
        contentType: false,
        success:function(data){
          console.log(data);
          
          $("#postExtraDetails").html(data);
      $   ("#postExtraDetails").show()

        }
      })

    }


    var slideIndex = 1;
        // showSlides(slideIndex);

        

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }


        function checkPin(elem,shouldPin){
          if(pinned==shouldPin){
            $(elem).css({
              "cursor":"not-allowed"
            })
          }
        }

        function pin(elem,shouldPin){
          btn=$(elem)
          btnValue=btn.html()
          btn.html("Please! wait")
          if(pinned!=shouldPin){
            formData=new FormData()
            formData.append("post_id",postId)
            formData.append("pin",shouldPin)
            formData.append("pin_post",1)

            $.ajax({
              type:"POST",
              data:formData,
              url:"../parsers/admin_parser.php",
              cache:false,
              processData: false,
              contentType: false,
              success:function(data){
                btn.prop("disabled",false);
                btn.html(btnValue)

                console.log(data)
                data=JSON.parse(data)
                if(data.status==1){
                  $("#pinAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
                  setTimeout(() => {
                    location.reload()
                  }, 100);
                  
                }
              }
            })
          }
        }

        $("#postCommentBtn").click(function(e){
          btn=$(this);
          btnValue=btn.html()
          btn.html("Please! wait")
          formData=new FormData($("#postCommentForm")[0])
          formData.append("post_id",postId)
          formData.append("poster_id",posterId)
          formData.append("comment_post",1)

          $.ajax({
            type:"POST",
            data:formData,
            url:"../parsers/admin_parser.php",
            cache:false,
            processData: false,
            contentType: false,
            success:function(data){
              btn.prop("disabled",false);
              btn.html(btnValue)

              console.log(data)
              data=JSON.parse(data)
              if(data.status==1){
                $("#commentAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
                setTimeout(() => {
                  location.reload()
                }, 100);
                
              }
            }
          })
        })


        function deletePost(deleteP) {
          formData=new FormData()
          formData.append("post_id",postId)
          formData.append("delete",deleteP)
          formData.append("delete_post",1)

          $.ajax({
            type:"POST",
            data:formData,
            url:"../parsers/admin_parser.php",
            cache:false,
            processData: false,
            contentType: false,
            success:function(data){
              console.log(data)
              data=JSON.parse(data)
              if(data.status==1){
                $("#deleteAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
                setTimeout(() => {
                  location.reload()
                }, 100);
                
              }
            }
          })
        }

        
  </script>