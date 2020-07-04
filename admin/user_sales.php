
<?php
	include "../app/init.php";
  include("header.php");
  if(!isset($_GET['uid'])){
    header("Locations: index.php");
    exit(0);
  }
  $user_id=urldecode(base64_decode($_GET['uid']));


  if(isset($_GET['fetch_transac_subm'])){
    $this_month=$_GET['trans_month'];
    $this_year=$_GET['trans_year'];
    $transactions=$user->fetch_my_sales_for_this_month($user_id,$this_month,$this_year);
  }else{
    $transactions=$user->fetch_my_sales($user_id);
  }
?>
    <br><br>
    <!--end of fixed top-->

    <!-- ////////////////////////////////////////////////////////////////////////////-->

	<section id="configuration">
  <div class="container">
    <h4>Fetch transaction history</h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
      <input type="hidden" name="uid" value="<?php echo urlencode(base64_encode($user_id));?>">
      <div class="row" style="margin-bottom:15px;">
      
        <div class="col-md-4">
             
          <select name="trans_month" id="transMonth" style="" required>
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
         
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
     
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12"><table class="table table-striped table-bordered dataex-res-configuration dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="">
              <thead>
                <tr role="row">
                  <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="First name: activate to sort column descending">ID</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last name: activate to sort column ascending">Audio Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Seller Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Buyer Name</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Downloaded?</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Date Purchased</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Price</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Amount Payable</th>

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

					  
					  $seller_id=$audio_details['owner_id'];
					  $seller_details=$user->get_details_by_id($seller_id);
					  $seller_name=$seller_details['first_name']." ".$seller_details['last_name'];

            $total_price+=$audio_price;
            
            $amount_payable=($audio_price*90)/100;

						$total_amount_payable+=$amount_payable;
					  
					  

              ?>
                        <tr role="row" class="odd">
                          <td tabindex="0" class="sorting_1"><?php echo $count_transaction;?></td>
                          <td><?php echo $audio_name;?></td>
                          <td><?php echo $seller_name;?></td>
                          <td><?php echo $buyer_name;?></td>
                          <td><?php if($downloaded==1) echo "<i>Yes</i>";else echo "<i>No</i>";?></td>
                          <td><?php echo date("d/m/Y H:ia",strtotime($date_purchased));?></td>
                          <td><?php echo "$price_currency $audio_price";?></td>
                          <td><?php echo "$price_currency $amount_payable";?></td>

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
    <?php
    include("footer.php")
    ?>

    <script>
      $("#transMonth").select2({
        placeholder:"Select month",
      })
      $("#transYear").select2({
        placeholder:"Select year"
      })
    </script>