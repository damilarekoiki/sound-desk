<?php
    include "app/init.php";

    if(isset($_GET['email'],$_GET['activation'])){
        $email=$_GET['email'];
        $activation=$_GET['activation'];

    }else{
        exit(0);
    }
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  
<!-- Mirrored from pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/html/ltr/horizontal-menu-template-nav/login-simple.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 14:55:28 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>soundesk</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="assets/simple-line-icons/css/simple-line-icons.css">

        <!-- Plugin CSS -->
        <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

        <!-- Custom styles for this template -->
        <link href="assets/css/new-age.min.css" rel="stylesheet">
        <link href="assets/css/audio_style.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/register.css" rel="stylesheet">
        <link href="assets/css/select2.min.css" rel="stylesheet">
        <link href="assets/css/date-picker.css" rel="stylesheet">
        <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <!-- END Custom CSS-->
    </head>
    <body id="page-top">
        <?php
            // if(!isset($_SESSION['email'])){
            //     include("header_not_loggedin.php");
            // }else{
            include("header_not_loggedin.php");
            // }
        ?>

        <div class="page col-md-12" style="margin-top:100px;">
            <div class="row col-md-12" style="margin-top:auto;margin-left:10px">
                <div class="col-xl-10 container">
                    <div class="reg-div col-md-10 container">
                        <form class="form-horizontal form-simple container" action="" id="prForm" style="padding-top:15px;padding-bottom:15px;">
                            <div class="form-group">
                                <label for="new_password">Password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="Enter New Password" required="" name="new_password">

                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" required="" name="confirm_password">

                            </div>
                            

                            <div class="row col-md-12" style="margin-top:15px;padding-left:20%;">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 row">
                                    <div class="col-md-12 row" style="margin-left:12px;">
                                        <button type="button" class="btn  btn-submit" id="prBtn">Submit</button>
                                    </div>
                                    <div class="col-md-12 row" style="padding-top:20px">
                                        <span class="already-have">Don't have an account yet? <a href="register.php">Register here</a></span>
                                    </div>
                                    <input type="hidden" name="email" value="<?php echo $email;?>">
                                    <input type="hidden" name="activation" value="<?php echo $activation;?>">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>







                        <!-- <form action="" class="container" style="padding-top:15px;padding-bottom:15px;">
                            <div class="form-group">
                                <label for="email">Email or Username</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email or username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>

                            <div class="row col-md-12" style="margin-top:15px;padding-left:28%;">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 row">
                                    <div class="col-md-12 row">
                                        <button class="btn btn-submit" type="button">Login</button>
                                    </div>
                                    <div class="col-md-12 row" style="padding-top:20px">
                                        <span class="already-have">Don't have an account yet? <a href="register.php">Register here</a></span>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                
                            </div>
                                
                        </form> -->

                        
                        
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/jquery/jquery.min.js"></script>
        <script src="assets/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="assets/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for this template -->
        <script src="assets/js/new-age.min.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/select2.full.min.js"></script>
        <script src="assets/js/date-picker.js"></script>

        <script>
            $("#prBtn").click(function(){
                validate=validatepasswordResetForm();
                btn=$(this)
                btnValue=btn.html();
                btn.prop("disabled",true);
                btn.html("Please wait...")

                formData=new FormData($("#prForm")[0])
                formData.append("reset_password",1)
                if(validate==true){
                    // Submit Form
                    $.ajax({
                        type:"POST",
                        data:formData,
                        url:"parsers/user_parser.php",
                        cache:false,
                        processData: false,
                        contentType: false,
                        success:function(data){
                        btn.prop("disabled",false);
                        btn.html(btnValue)
                        console.log(data)
                        data=JSON.parse(data)
                        if(data.status==1){
                            $("#regError").html("<div class='alert alert-success'>"+data.message+"</div>")
                            $("#prForm").trigger("reset")
                        }else{
                            $("#regError").html("<div class='alert alert-danger'>"+data.message+"</div>")

                        }
                        }
                    })
                }
            })
        </script>
    </body>

<!-- Mirrored from pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/html/ltr/horizontal-menu-template-nav/login-simple.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 14:55:29 GMT -->

    
</html>