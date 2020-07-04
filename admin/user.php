<?php
	include "../app/init.php";
  include("header.php");
  $all_users=$user->fetch_all();
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
        <h1>USERS</h1>
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
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">Username</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Email</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Gender</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Wallet Amount</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Account Number</th>                  
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php
                  $i=0;
                  if(!empty($all_users)){
                    foreach($all_users as $a_user){
                      $i++;
                      $user_id=$a_user['user_id'];
                      $user_email=$a_user['email'];
                      $username=$a_user['username'];
                      $gender=$a_user['gender'];
                      $wallet_amount=$a_user['wallet_amount'];
                      $user_account_number=$user->get_account_number($user_id);
                      

                ?>
                      <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1"><?php echo $i;?></td>
                        <td><?php echo $username;?></td>
                        <td><?php echo $user_email;?></td>
                        <td><?php echo "<i>$gender</i>";?></td>
                        <td><?php echo "$price_currency $wallet_amount";?></td>
                        <td><?php echo $user_account_number;?></td>                        
                        <td><a href="user_sales.php?uid=<?php echo base64_encode($user_id);?>">View user sales</a></td>
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

<!-- The Modal pined -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Edit User</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
                      <div class="col-md-12">
                             <p> <span><b>Username:</b></span> <span class="usn">Thatcher8</span></p>
                             <p> <span><b>Email:</b></span> <span class="userEmail">thatcher@gmail.com</span></p>
                             <p> <span><b>Phone Number:</b></span> <span class="userPhn">09076543210</span></p>
                             <p> <span><b>Level:</b></span> <span class="userLevel">User</span></p>
                      </div>
                            <br>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Pin to Homepage</button>
           <button type="button" class="btn btn-danger" data-dismiss="modal">Unpin from Homepage</button>
        </div>
        
      </div>
    </div>
  </div>


  <!-- The Modal pined -->
  <div class="modal" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Change User Level</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="col-md-12">
              <p><div class="" id="levlAlert"></div></p>
              <p> <span><b>Username:</b></span> <span class="usn"></span></p>
              <p> <span><b>Email:</b></span> <span class="userEmail"></span></p>
              <p> <span><b>Level:</b></span> <span class="userLevel"></span></p>
           </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success levlBtn" onclick="changeUserLevel(this,1)" onmouseover="checkLevel(this,1)">Grant Privilege</button>
          <button type="button" class="btn btn-danger levlBtn" onclick="changeUserLevel(this,0)" onmouseover="checkLevel(this,0)">Revoke Privilege</button>
        </div>
        
      </div>
    </div>
  </div>

 <!-- The Modal -->
  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Users</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="col-md-12">
            <p><div id="statusAlert"></div></p>
            <p> <span><b>Username:</b></span> <span class="usn"></span></p>
              <p> <span><b>Email:</b></span> <span class="userEmail"></span></p>
              <p> <span><b>Status:</b></span> <span class="userStatus"></span></p>

          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
         <button type="button" class="btn btn-success banBtn" data-dismiss="modal" onclick="changeUserStatus(this,1)" onmouseover="checkStatus(this,1)">Ban User</button>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="changeUserStatus(this,0)" onmouseover="checkStatus(this,0)">Unban User</button>
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
          <h2 class="modal-title">Delete User</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="deleteAlert"></div>
        <div class="alert alert-warning" role="alert">
               Are you sure you want to delete User?
        </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="removeUser(this)">Yes</button>
           <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        </div>
        
      </div>
    </div>
  </div>

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

    function changeUserLevel(elem,level) {
      $("#levlAlert").html("");
      if(level!=userLevel){
        btn=$(elem)
        btnValue=btn.html();
        btn.prop("disabled",true);
        btn.html("Please wait...")

        formData=new FormData()
        formData.append("new_level",level)
        formData.append("user_id",userId)
        formData.append("change_user_level",1)

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
              $("#levlAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
              setTimeout(() => {
                location.reload()
              }, 100);
              
            }
          }
        })
      }
    }

    function checkLevel(elem,level){
      $(".levlBtn").css({
          "cursor":"pointer"
        })
      if(level==userLevel){
        $(elem).css({
          "cursor":"no-drop"
        })
      }
    }
    function changeUserStatus(elem,status) {
      $("#statusAlert").html("");
      if(status!=userStatus){
        btn=$(elem)
        btnValue=btn.html();
        btn.prop("disabled",true);
        btn.html("Please wait...")

        formData=new FormData()
        formData.append("banned",status)
        formData.append("user_id",userId)
        formData.append("change_user_ban",1)

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
              $("#statusAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
              setTimeout(() => {
                location.reload()
              }, 100);
              
            }
          }
        })
      }
    }
    function checkStatus(elem,status){
      $(".banBtn").css({
          "cursor":"pointer"
        })
      if(status==userStatus){
        $(elem).css({
          "cursor":"no-drop"
        })
      }
    }

    function removeUser(elem){
        btn=$(elem)
        btnValue=btn.html();
        btn.prop("disabled",true);
        btn.html("Please wait...")

        formData=new FormData()
        formData.append("user_id",userId)
        formData.append("delete_user",1)

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
              $("#deleteAlert").html("<div class='alert alert-success'>"+data.message+"</div>");
              setTimeout(() => {
                location.reload()
              }, 100);
              
            }
          }
        })
    }
  </script>