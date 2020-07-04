
<!DOCTYPE html>
<html lang="en">

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
    <!-- <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet"> -->

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/new-age.min.css" rel="stylesheet">
    <link href="assets/css/audio_style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/register.css" rel="stylesheet">
    <link href="assets/css/select2.min.css" rel="stylesheet">
    <link href="assets/css/date-picker.css" rel="stylesheet">
    <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">



  </head>

  <body id="page-top">

    <!-- Navigation -->
    <?php
        if(!isset($_SESSION['email'])){
            include("header_not_loggedin.php");
        }else{
          include("header_not_loggedin.php");
        }
    ?>
    
    <div class="page col-md-12" style="margin-top:100px;">
        <div class="row col-md-12" style="margin-top:auto;margin-left:10px">
            <div class="col-xl-10 container">
                <div class="reg-div col-md-10 container">
                    <div class="col-md-8" id="regError" style="margin-left:15%"></div>
                    <form action="" class="container" style="padding-top:15px;padding-bottom:15px;" id="loginForm">
                        <div class="form-group">
                            <label for="email">Email or Username</label>
                            <input type="text" name="username_email" id="email" class="form-control" placeholder="Email or username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>

                        <div class="row col-md-12" style="margin-top:15px;padding-left:20%;">
                            <div class="col-md-4"></div>
                            <div class="col-md-8 row">
                                <div class="col-md-12 row" style="margin-left:12px;">
                                    <button class="btn btn-submit" type="button" id="loginBtn">Login</button>
                                </div>
                                <div class="col-md-12 row" style="padding-top:20px">
                                    <span class="already-have">Don't have an account yet? <a href="register.php">Register here</a></span>
                                </div>
                                <div class="col-md-12 row" style="margin-left:5px">
                                    <span class="already-have"><a href="forgot_password.php">Forgot password? </a></span>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            
                        </div>
                            
                    </form>

                    
                    
                </div>
            </div>
        </div>
    </div>


    

    <!-- <footer>
      <div class="container">
      <p>&copy; Group 2B Term Project - RWMS 2018. All Rights Reserved.</p>
      <ul class="list-inline">
          <li class="list-inline-item">
          <a href="#">Privacy</a>
          </li>
          <li class="list-inline-item">
          <a href="#">Terms</a>
          </li>
          <li class="list-inline-item">
          <a href="#">FAQ</a>
          </li>
      </ul>
      </div>
    </footer> -->

    <!-- Bootstrap core JavaScript -->
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
        $("#loginBtn").click(function(){
            btn=$(this)
            btnValue=btn.html();
            btn.prop("disabled",true);
            btn.html("Please wait...")

            formData=new FormData($("#loginForm")[0])
            formData.append("login",1)
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
                        $("#loginForm").trigger("reset")
                        window.location=data.url;
                    }else{
                        $("#regError").html("<div class='alert alert-danger'>"+data.message+"</div>")
                    }
                }
            })
        })
    </script>


  </body>

</html>
