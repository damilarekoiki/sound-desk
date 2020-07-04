<?php
    include("app/init.php");
    
    if(!$user->is_loggedin()){
      header("Location: index.php");
      exit(0);
    }
  
  

    if(isset($_GET['fetch_transac_subm'])){
      $this_month=$_GET['trans_month'];
      $this_year=$_GET['trans_year'];
      $transactions=$user->fetch_my_sales_for_this_month($loggedin_user_id,$this_month,$this_year);
    }else{
      $transactions=$user->fetch_my_sales($loggedin_user_id);
    }


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

    <section id="configuration">
  <div class="container">
  <h4>Fetch transaction history</h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get" style="width:100%">
      <div class="row" style="margin-bottom:15px;">
      
        <div class="col-md-4">
             
          <select name="trans_month" id="transMonth" style="width:100%;" required>
            <option></option>
            <?php
              $current_year=date("Y");

              for($i=1;$i<=12;$i++){
                $month_selected="";                
                $current_month=date("F", strtotime("$i/01/$current_year"));
                if(isset($_GET['fetch_transac_subm'])){
                  if($i==$_GET['trans_month']){
                    $month_selected="selected";
                  }
                }else{
                  // if($i==date("n")) $month_selected="selected";
                }
            ?>
              <option value="<?php echo $i;?>" <?php echo $month_selected?>><?php echo $current_month;?></option>
            <?php
              }
            ?>        
          </select>
        </div>

        <div class="col-md-4">
          <select name="trans_year" id="transYear" style="width:100%" required>
          <option value=""></option>
            <?php
                for($i=1970;$i<=$current_year+30;$i++){
                  $year_selected="";                  
                  if(isset($_GET['fetch_transac_subm'])){
                    if($i==$_GET['trans_year']){
                      $year_selected="selected";
                    }
                  }else{
                    // if($i==$current_year) $year_selected="selected";
                  }
              ?>
                <option value="<?php echo $i;?>" <?php echo $year_selected?>> <?php echo $i;?> </option>
              <?php
                }
              ?>
          </select>
        </div>

        <div class="col-md-4">
          <button class="btn btn-primary" type="submit" name="fetch_transac_subm">Fetch history</button>
        </div>
      </div>
      
    </form>
    <div class="col-md-12 row">
      <div class="card center">
        <div class="card-header">
          <div style="font-weight:bold;">This list does not contain any audio that recharges your wallet</div>
         
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
    
          </div>
        </div>
        <div class="card-content collapse show">

          <div class="card-body card-dashboard">
            
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
            <div class="col-sm-12">
            <table class="table table-striped table-bordered dataex-res-configuration dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
              <thead>
                <tr role="row">
                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">ID</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">Audio Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Channel Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Buyer Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Downloaded?</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Date Purchased</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Price (<?php echo $price_currency;?>)</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Amount Payable (<?php echo $price_currency;?>)</th>

                </tr>
              </thead>
              <tbody>
                <?php
                  $count_transaction=0;
                  $total_price=0;
                  $total_amount_payable=0;

                  if(!empty($transactions)){
                    foreach ($transactions as $transaction) {
					  # code...
					  $buyer_id=$transaction['buyer_id'];
					  $buyer_details=$user->get_details_by_id($buyer_id);
					  $buyer_name=$buyer_details['first_name']." ".$buyer_details['last_name'];


					  

					  $audio_id=$transaction['audio_id'];
					  $payment_mode=$audio_production->get_audio_payment_mode($audio_id);
					  if($payment_mode==0) continue;
					  $count_transaction++;
					  $audio_details=$audio_production->details($audio_id);
					  $audio_name=$audio_details['audio_name'];
					  $date_purchased=$transaction['date_purchased'];
					  $downloaded=$transaction['downloaded'];
					  $audio_price=$transaction['price'];

					  
					  $channel_id=$audio_details['channel_id'];
					  $channel_details=$channel->details($channel_id);
					  $channel_name=$channel_details['channel_name'];

					  $total_price+=$audio_price;
            
            $amount_payable=($audio_price*90)/100;

						$total_amount_payable+=$amount_payable;
					  

              ?>
                        <tr role="row" class="odd">
                          <td tabindex="0" class="sorting_1"><?php echo $count_transaction;?></td>
                          <td><?php echo $audio_name;?></td>
                          <td><?php echo $channel_name;?></td>
                          <td><?php echo $buyer_name;?></td>
                          <td><?php if($downloaded==1) echo "<i>Yes</i>";else echo "<i>No</i>";?></td>
                          <td><?php echo date("d/m/Y H:ia",strtotime($date_purchased));?></td>
                          <td><?php echo $audio_price;?></td>
                          <td><?php echo $amount_payable;?></td>
                          

                        </tr>
              <?php
                  }
                }
              ?>
              </tbody>
            </table></div></div>
			<div class="row">
      <?php
                  if($total_price>0){
              ?>
                    <button class="btn btn-submit" type="button" style="margin-left:25%;background:black;color:white">Total Price:&nbsp;<?php echo "$price_currency $total_price";?>&nbsp; <span style="color:red">Total Amount Payable:&nbsp;<?php echo "$price_currency $total_amount_payable";?></span></button>
                  <?php } ?>
			
			</div></div>        
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
      

    </div>
    

    <?php
      include "footer.php";
    ?>

    <script>
        $("#DataTables_Table_0").dataTable()
    </script>

    <script>
      $("#transMonth").select2({
        placeholder:"Select month",
      })
      $("#transYear").select2({
        placeholder:"Select year"
      })
    </script>

  </body>

</html>
