<?php
    include("app/init.php");
    $all_countries=$master->fetch_all_countries();
?>
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
        <link href="assets/css/radio_button.css" rel="stylesheet">
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

        <div class="page" style="margin-top:70px;">
            <div class="row col-md-12" style="padding:10px 0px 0px 0px;margin:auto">
                <div class="col-xl-10 container">
                    <div class="reg-div col-md-10 container">
                        <form action="" class="container" id="regForm" style="padding-top:15px;padding-bottom:15px;">
                            <div class="col-md-8" id="regError" style="margin-left:15%"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">First name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <div id="datepicker-container" class="datepicker-container">
                                            <span class="outline-element-container form-inline">
                                                <input id="datepicker-input" type="text" class="openemr-datepicker input-textbox outline-element incorrect form-control" placeholder="Date of Birth" objtype="7" name="dob" objindex=""  aria-label="Select Date" style="width:95%"> <span class="correct-incorrect-icon"> </span>
                                            </span>
                                        </div>
                                        <div class="datepicker-container openemr-calendar" id="datepicker-div" ></div>
                                    </div>
                                    <div class="form-group">
                                        <div class=""><label for="">Gender</label></div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <input type="radio" id="male" name="gender" value="M">
                                                <label for="male">Male</label>
                                            </div>

                                            <div class="form-group ml-5">
                                                <input type="radio" id="female" name="gender" value="F" checked>
                                                <label for="female">Female</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname">Nationality</label>
                                        <select name="nationality" id="nationality" class="form-control" style="width:100%">
                                            <option value=""></option>
                                            <?php
                                                if(!empty($all_countries)){
                                                    foreach ($all_countries as $country) {
                                                        # code...
                                                        $country_id=$country['id'];
                                                        $country_name=$country['country_name'];
                                            ?>
                                                        <option value="<?php echo $country_id;?>"><?php echo $country_name;?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="religion">Religion</label>
                                        <select name="religion" id="religion" class="form-control" style="width:100%">
                                            <option value=""></option>
                                            <option value="1">Christianity</option>
                                            <option value="2">Islam</option>
                                            <option value="2">None</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>

                            <div class="row col-md-12" style="margin-top:15px;padding-left:28%;">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 row">
                                    <div class="col-md-12 row">
                                        <button class="btn btn-submit" type="submit" id="regBtn">Register</button>
                                    </div>
                                    <div class="col-md-12 row" style="padding-top:20px">
                                        <span class="already-have">Already have an account? <a href="login.php" class="log-reg-link">Login here</a></span>
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
            $("#regForm").submit(function(e){
                btn=$("#regBtn");
                btnValue=btn.text();
                btn.prop("disabled",true);
                btn.text("Please! Wait...")
                e.preventDefault()
                formData = new FormData(this);
                formData.append("register_user",1)
                $.ajax({
                    type:"POST",
                    data:formData,
                    url:"parsers/user_parser.php",
                    cache:false,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        console.log(data)
                        btn.prop("disabled",false);
                        btn.text(btnValue)

                        data=JSON.parse(data)
                        if(data.status==1){
                            $("#regError").html("<div class='alert alert-success'>"+data.message+"</div>")
                            $("#regForm").trigger("reset")
                        }else{
                            $("#regError").html("<div class='alert alert-danger'>"+data.message+"</div>")
                        }
                    }
                })
            })
        </script>

        <script>
            $("#nationality").select2({
                placeholder:"Select Country"
            })

            // $("#religion").select2({
            //     placeholder:"Select Religion"
            // })
        </script>

        <script>
            $( "#datepicker-input" ).blur(function(){
                val = $(this).val();
                val1 = Date.parse(val);
                if (isNaN(val1)==true && val!==''){
                alert("Invalid date: Enter date in format YY-MM-DD")
                }
                else{
                console.log(val1);
                }
            })

            $('#datepicker-input').click(function(){
                $('#datepicker-input').datepicker('show');
            }).focus(function(){
                $('#datepicker-input').datepicker('show');
            });
        </script>


    </body>



    

</html>
