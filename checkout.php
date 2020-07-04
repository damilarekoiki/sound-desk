<?php
    include("app/init.php");
    
    if(!$user->is_loggedin()){
      header("Location: index.php");
      exit(0);
    }

    if(!isset($_SESSION['cart'])){
      header("Location: index.php");
      exit(0);
    }

    $user_details=$user->get_details_by_id($loggedin_user_id);
    $fn=$user_details['first_name'];
    $ln=$user_details['last_name'];
    $user_email=$user_details['email'];
    $wallet_amount=$user_details['wallet_amount'];


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
    <link href="assets/css/index.css" rel="stylesheet">
    <link href="assets/css/channel.css" rel="stylesheet">
    <link href="assets/css/radio_button.css" rel="stylesheet">

    <link href="assets/css/select2.min.css" rel="stylesheet">
    <link href="assets/css/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/tooltipster/dist/css/tooltipster.bundle.min.css" />

    <link rel="stylesheet" type="text/css" href="assets/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fixedHeader.dataTables.min.css">

    <style>
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 5px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        /* width: 250px;
        height: 250px; */
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .cropit-preview-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input, .export {
        /* Use relative position to prevent from being covered by image background */
        position: relative;
        z-index: 10;
        display: block;
      }

      button {
        margin-top: 10px;
      }

      .audio-player-wrapper {
        margin-top:auto !important;
      }

      .audiojs{
        /* width:100%; */
        /* height:auto; */
        /* padding-top:4px; */
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

              

    <div class="page container" style="margin-top:100px;margin-bottom:70px;" >
      
      <div class="card-content collapse show" style="">
          <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
              <div class="row">
                  <div class="col-sm-12">
                      <table class="table table-striped table-bordered dataex-res-configuration dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                          <thead>
                              <tr role="row">
                                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">S/N</th>
                                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">Audio Name</th>
                                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">Audio Cover</th>
                                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">Price (<?php echo $price_currency;?>)</th>
                                  <th></th>

                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                  $cartCounter=0;
                                  $total_price=0;
                                  $cart_array=$_SESSION['cart'];
                                  if(!empty($cart_array)){
                                      foreach ($cart_array as $audio=>$value) {
                                          # code...
                                          $cartCounter++;
                                          $audio_details=$audio_production->details($audio);
                                          $audio_name=$audio_details['audio_name'];
                                          $audio_cover=$audio_production->get_audio_cover_pix($audio);
                                          $audio_price=$value['price'];
                                          $is_promo=$value['is_promo'];
                                          $promo_id=$value['promo_id'];
                                          $total_price+=$audio_price;
                                      
                              ?>
                                      <tr>
                                      <td><?php echo $cartCounter;?></td>
                                      <td><?php echo $audio_name;?></td>
                                      <td align="center"><img src="<?php echo $audio_cover;?>" alt="" style="width:50%;"></td>
                                      <td><?php echo $audio_price;?></td>
                                      <td>
                                        <?php
                                          if($is_promo==1){
                                        ?>
                                            <span style="color:blue;text-decoration:underline;cursor:pointer;" onclick="remove_promo_from_cart(<?php echo $promo_id;?>)">Remove</span>
                                        <?php
                                          }else{
                                        ?>
                                            <span style="color:blue;text-decoration:underline;cursor:pointer;" onclick="remove_from_cart(<?php echo $audio;?>)">Remove</span>
                                        <?php
                                          }
                                        ?>

                                      </td>
                                      

                                      </tr>
                              <?php
                                      }
                                  }
                              ?>
                              
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <?php
        if(!empty($cart_array)){
          
      ?>
          <form style="margin-left:25%;margin-top:25px;<?php if($wallet_amount>$total_price) echo 'display:none';?>">
            <button type="button" style="cursor:pointer;" value="Pay Now" id="pay" class="btn btn-submit">Pay Now:&nbsp; <?php echo "$price_currency ".$total_price;?></button>
          </form>
      <?php
          if($wallet_amount>$total_price){
      ?>
            <button type="button" style="cursor:pointer;margin-left:25%;margin-top:25px;"id="fakeBtn" class="btn btn-submit">Pay Now:&nbsp; <?php echo "$price_currency ".$total_price;?></button>
      <?php
          }
        }
      ?>
      

    </div>





    


<script type="text/javascript" src="http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function(event) {
  document.getElementById("pay").addEventListener("click", function(e) {
    var PBFKey = "FLWPUBK-4cd83e402625bcaf7942c99b993f18b9-X";
    
    getpaidSetup({
      PBFPubKey: PBFKey,
      customer_email: "<?php echo $user_email;?>",
      customer_firstname: "<?php echo $fn;?>",
      customer_lastname: "<?php echo $ln;?>",
      custom_description: "Pay Internet",
      custom_title: "SOUNDESK",
      amount: <?php echo $total_price;?>,
      customer_phone: "08156689295",
      country: "NG",
      currency: "<?php echo $price_currency;?>",
      txref: "rave-123456",
      onclose: function() {},
      callback: function(response) {
        var flw_ref = response.tx.flwRef; // collect flwRef returned and pass to a          server page to complete status check.
        console.log("This is the response returned after a charge", response);
        if (
          response.tx.chargeResponseCode == "00" ||
          response.tx.chargeResponseCode == "0"
        ) {
          // redirect to a success page
          window.location="after_payment.php"
        } else {
          // redirect to a failure page.
        }
      }
    });
  });
});



</script>
    

    <?php
      include "footer.php";
    ?>

    <script>
      $("#fakeBtn").click(function(){
        swal({
          title: "You have enough money in your wallet",
          text:"Do you wish to buy from your wallet",
          icon:"warning",
          buttons:{
              cancel: {
                  text: "Cancel",
                  value: null,
                  visible: true,
                  className: "",
                  closeModal: true,
              },
              confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
              }
          }
        }).then((clicked)=>{
            if(clicked){
                window.location="after_payment.php?umw=1"
            }else{
              console.log("Okkkk")
              $("#pay").trigger("click")
            }
        })
      })
    </script>

    <script>
        $("#DataTables_Table_0").dataTable()
    </script>

    <script>
      function remove_promo_from_cart(promoId){
        swal({
          text:"All audios in this promo will be removed from cart",
          icon:"warning",
          buttons:{
              cancel: {
                  text: "Cancel",
                  value: null,
                  visible: true,
                  className: "",
                  closeModal: true,
              },
              confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
              }
          }
        }).then((clicked)=>{
            if(clicked){
              formData=new FormData();
                formData.append("remove_promo_from_cart",1)
                formData.append("promo_id",promoId)

                $.ajax({
                  type:"POST",
                  data:formData,
                  url:"parsers/cart_parser.php",
                  cache:false,
                  processData: false,
                  contentType: false,
                  success:function(data){
                      console.log(data)
                      data=JSON.parse(data)
                      if(data.status==0){
                          swal({
                              title: data.title,
                              text:data.message,
                              icon:"warning",
                              button:"OK"
                          })
                      }else{
                          swal({
                              title: data.title,
                              text:data.message,
                              icon:"success",
                              button:"OK"
                          }).then((clicked)=>{
                              if(clicked) location.reload();
                          })
                      }
                      
                  }
                })
            }
        })
      }

      function remove_from_cart(audioId){
        swal({
          text:"This audio will be removed from cart",
          icon:"warning",
          buttons:{
              cancel: {
                  text: "Cancel",
                  value: null,
                  visible: true,
                  className: "",
                  closeModal: true,
              },
              confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
              }
          }
        }).then((clicked)=>{
            if(clicked){
              formData=new FormData();
                formData.append("remove_from_cart",1)
                formData.append("audio_id",audioId)

                $.ajax({
                  type:"POST",
                  data:formData,
                  url:"parsers/cart_parser.php",
                  cache:false,
                  processData: false,
                  contentType: false,
                  success:function(data){
                      console.log(data)
                      data=JSON.parse(data)
                      if(data.status==0){
                          swal({
                              title: data.title,
                              text:data.message,
                              icon:"warning",
                              button:"OK"
                          })
                      }else{
                          swal({
                              title: data.title,
                              text:data.message,
                              icon:"success",
                              button:"OK"
                          }).then((clicked)=>{
                              if(clicked) location.reload();
                          })
                      }
                      
                  }
                })
            }
        })
      }
    </script>
    


  </body>

</html>
