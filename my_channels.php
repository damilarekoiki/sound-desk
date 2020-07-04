<?php
    include("app/init.php");
    if(!$user->is_loggedin()){
        header("Location: index.php");
        exit(0);
    }
    $all_countries=$master->fetch_all_countries();

    $all_user_channels=$channel->fetch_all_user_channels($loggedin_user_id);
    
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>soundesk</title>

    <link href="assets/css/scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.custom-scrollbar.css">

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
    <link href="assets/css/channel.css" rel="stylesheet">

    <link href="assets/css/select2.min.css" rel="stylesheet">
    <link href="assets/css/date-picker.css" rel="stylesheet">
    <link href="assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <link href="assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    

    <style>
        .select2-container--default .select2-selection--single {
            border: 2px solid black !important;
            height:40px !important;
            padding: .375rem .60rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top:10px !important;
        }



        .select2-selection__placeholder{
            font-weight:bold;
            /* color:black !important; */
            /* font-size:22px !important; */
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
    </style>



  </head>

  <body id="page-top">

    <!-- Navigation -->
    <?php
        if(!isset($_SESSION['email'])){
            include("header_not_loggedin.php");
        }else{
          include("header_loggedin_bg.php");
        }
    ?>
    <!-- Original page -->
    <div class="page container" style="margin-top:100px;margin-bottom:70px;" >
        
        <div class="row col-md-12 container" style="padding:10px 0px 0px 0px;margin-top:60px">
            <div class="col-xl-10 container channels-div">
                <div class="row col-md-12">
                    <span class="note">Create your stunning channels and start uploading your audio records</span>
                </div>
                <div id="addNewChannelDiv" class="col col-md-12" style="margin-left:3px;margin-top:15px">
                    <i class="fa fa-plus fa-2x showChannelFormDiv" style="cursor:pointer"></i>
                </div>
                <div id="newChannelFormDiv" class="col" style="margin-top:5px;padding-bottom:0px">
                    <div id="formError"></div>
                    <form id="regChannelForm" class="row col-md-12" style="width:100%;margin-left:3px;padding:0px">
                        <div class="col-md-5" style="padding-left:0px">
                            <input type="text" class="form-control" style="width:100% !important;margin:0px;border:2px solid black" placeholder="Channel Name" id="ChannelName" name="channel_name"/>
                        </div>
                        <div class="form-group col-md-5" style=";">
                            <select name="brand_location" id="brandLocation" class="form-control" style="width:100%">
                                <option value=""></option>
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
                        <div class="form-group col-md-2" style="padding-right:0px;">
                            <button class="btn btn-submit" id="subBtn">Create</button>
                            <i class="fa fa-times float-right hideChannelFormDiv" style="cursor:pointer"></i>
                        </div>
                        <!-- <div class="form-group col-md-1" style="padding-right:0px;padding-top:8px;">
                            
                        </div> -->
                    </form>
                </div>
                <div class="col" style="margin-top:15px;paddding-bottom:8px">
                    <div class="row" style="margin-left:3px">
                        <span class="rec_note">Your Recent Channels</span>
                    </div>
                    <div class="col content " style="max-height:300px;overflow-y:hidden;padding-bottom:5px;padding-left:0px" data-mcs-theme="dark">
                        <?php
                            if(!empty($all_user_channels)){
                            foreach ($all_user_channels as $user_channel) {
                                # code...
                                $channel_id=$user_channel['channel_id'];
                                $channel_logo=$user_channel['logo'];
                                $channel_name=$user_channel['channel_name'];

                                $num_uploads=$channel->num_channel_uploads($channel_id);
                                $num_subscribers=$channel->num_channel_subscribers($channel_id);
                        ?>
                                    <div class="row channel-details" style="width:99.5%;">
                                        <div class="row col-md-5">
                                            <div class="col-md-2 channel-logo-div">
                                                <img src="<?php echo $channel_logo;?>" alt="Channel Logo" class="img img-fluid channel-logo" style="width:100%;">
                                            </div>
                                            <div class="channel-name-div col-md-10">
                                                <span class="channel-name"><?php echo $channel_name;?></span>
                                            </div>
                                        </div>
                                        <div class="num-uploads-div col-md-3">
                                            <span class="num-uploads"><?php echo $num_uploads;?> Upload(s)</span>
                                        </div>
                                        <div class="num-subscribers-div col-md-3">
                                            <span class="num-subscribers"><?php echo $num_subscribers;?> Subscriber(s)</span>
                                        </div>
                                        <div class="num-subscribers-div col-md-1">
                                            <a href="channel.php?cid=<?php echo base64_encode($channel_id);?>&oid=<?php echo base64_encode($loggedin_user_id);?>" class="visit-channel"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                        <?php
                            }
                        }else echo "You have not created any channel"
                        ?>
                        <div class="row last-channel-details"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- original page ends -->

    


    

    <?php
      include "footer.php";
    ?>
    
    

    <script>
        (function($){
            $(window).on("load",function(){
                // $(".content").mCustomScrollbar();
            });
        })(jQuery);
    </script>


  </body>

  <script>
      $("#brandLocation").select2({
          placeholder:"Brand Location",
      })
  </script>

    <script>
        $(".showChannelFormDiv").click(function(){
            $("#newChannelFormDiv").show();
            $(this).css("visibility","hidden");
        })
        $(".hideChannelFormDiv").click(function(){
            $("#newChannelFormDiv").hide();
            $("#ChannelName").val("");
            $("#brandLocation").val("").change();
            $(".showChannelFormDiv").css("visibility","visible");
        })
    </script>

    <script>
        $("#regChannelForm").submit(function(e){
            e.preventDefault();
            btn=$("#subBtn");
            btnValue=btn.text();
            btn.prop("disabled",true);
            btn.text("Please! Wait...")
            formData = new FormData(this);
            formData.append("create_channel",1)
            $.ajax({
                type:"POST",
                data:formData,
                url:"parsers/channel_parser.php",
                cache:false,
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data)
                    btn.prop("disabled",false);
                    btn.text(btnValue)

                    data=JSON.parse(data)
                    if(data.status==1){
                        $("#formError").html("<div class='alert alert-success'>"+data.message+"</div>")
                        $("#regChannelForm").trigger("reset")
                        setTimeout(() => {
                            window.location=data.url                            
                        }, 1000);
                    }else{
                        $("#formError").html("<div class='alert alert-danger'>"+data.message+"</div>")
                    }
                }
            })
        })
    </script>

    

</html>
