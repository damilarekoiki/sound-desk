<?php
	include "../app/init.php";
  include("header.php");
  $all_audios=$audio_production->fetch_all();
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
          <div class="col-12">
        <span class="float-right"><a href="deleted_audios.php">View all deleted audios</a></span>
          
        <h1>AUDIOS</h1>
      </div>
    </div>
<section id="configuration">
  <div class="">
  
    <div class="col-md-12">
      <div class="card center">
        <div class="card-header">
         
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
              <div class="row"><div class="col-sm-12"><table class="table table-striped table-bordered dataex-res-configuration dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="">
              <thead>
                <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">ID</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">Title</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Cover Pix</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Seller</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Number of Downloads</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Rate</th> 
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Free?</th>                 
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Price</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Revenue Generated</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Deleted?</th>                  
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Date Uploaded</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Action</th>                  
                  

                </tr>
              </thead>
              <tbody>
                <?php
                  $i=0;
                  if(!empty($all_audios)){
                    foreach($all_audios as $an_audio){
                        $deleted=$an_audio['deleted']; 
                        if($deleted==1) continue;  
                        $i++;

                        $audio_id=$an_audio['audio_id'];
                        $owner_id=$an_audio['owner_id'];

                        $seller=$user->get_details_by_id($owner_id)['username'];
                        
                        $audio_name=$an_audio['audio_name'];
                        $cover_pix=$audio_production->get_audio_cover_pix($audio_id);
                        $num_downloads=$audio_production->get_num_downloads($audio_id);
                        $rate=$audio_production->get_audio_rating($audio_id);
                        $is_free=$an_audio['is_free'];                        
                        $price=$an_audio['price'];
                        $revenue_generated=$audio_production->get_revenue_generated($audio_id);
                        $date_uploaded=$an_audio['date_uploaded'];              
                        
                      
                      

                ?>
                      <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1"><?php echo $i;?></td>
                        <td><?php echo $audio_name;?></td>
                        <td><img src="../<?php echo $cover_pix;?>" alt="cover" class="img img-fluid"></td>
                        <td><?php echo $seller;?></td>
                        <td><?php echo $num_downloads;?></td>
                        <td><?php echo $rate;?></td>
                        <td><?php if($is_free==1) echo "<i>Yes</i>";else echo "<i>No</i>";?></td>                       
                        <td><?php echo $price;?></td>
                        <td><?php echo $revenue_generated;?></td>
                        <td><?php if($deleted==1) echo "<i>Yes</i>";else echo "<i>No</i>";?></td>
                        <td><?php echo date("Y/m/d H:ia",strtotime($date_uploaded));?></td>
                        <td>
                            <span style="cursor:pointer;color:blue" onclick="deleteAudio('<?php echo base64_encode($audio_id);?>')">Remove</span>
                        </td>
                        
                        
                      </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
            </table></div></div><div class="row"></div></div>        
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
    var userId=0;
    var userLevel=0;
    var userStatus=0;

    function getUserDetails(user_id,username,user_email,user_phone,levelText,status,user_level,user_status){
      userId=user_id;
      userLevel=user_level;
      userStatus=user_status;
      $(".usn,.userEmail,.userPhn,.userLevel,.userStatus").text("")
      $(".usn").text(username)
      $(".userEmail").text(user_email)
      $(".userPhn").text(user_phone)
      $(".userLevel").text(levelText)
      $(".userStatus").text(status)
    }

    function deleteAudio(audioId){
        formData = new FormData();
        formData.append("audio_id",audioId)
        formData.append("delete_audio",1)

        $.ajax({
          type:"POST",
          data:formData,
          url:"../parsers/channel_parser.php",
          cache:false,
          processData: false,
          contentType: false,
          success:function(data){
            console.log(data)
            data=JSON.parse(data)
            if(data.status==1){
              swal({
                  title: "Successful",
                  text:data.message,
                  icon:"success",
                  button:"OK"
              })
              setTimeout(() => {
                location.reload();
              }, 3000);
            }
          }
        })

      }
  </script>