
<?php
	include "../app/init.php";
	include("header.php");

	
	$this_month=date("n");
	$this_year=date("Y");
	$transactions=$audio_production->fetch_this_month_transaction_history($this_month,$this_year);
	$uploaded_audios=$audio_production->fetch_all();
	$all_users=$user->fetch_all();



	$num_transactions=count($transactions);
	$num_audios=count($uploaded_audios);
	$num_users=count($all_users);

?>
    <br><br>
    <!--end of fixed top-->

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="row">
    	<div class="col-12 text-center">
    			<h2>ADMIN DASHBOARD</h2>
		</div>
	</div><br>


   	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-6 col-12">
				<div class="card pull-up">
					<a href="transactions.php">
						<div class="card-content">
							<div class="card-body">
								<div class="media d-flex">
									<div class="media-body text-left">
										<h5>Transactions Made</h5>
										<h4 class="warning"><?php echo $num_transactions;?></h4>
									</div>
									<div>
										<i class="ft-users warning font-large-2 float-right"></i>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-12">
				<div class="card pull-up">
					<a href="uploaded_audios.php">
					<div class="card-content">
						<div class="card-body">
							<div class="media d-flex">
								<div class="media-body text-left">
									<h5>Uploaded Audios</h5>
									<h4 class="warning"><?php echo $num_audios;?></h4>
								</div>
								<div>
									<i class="icon-pie-chart warning font-large-2 float-right"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-12">
				<div class="card pull-up">
					<a href="user.php">
						<div class="card-content">
							<div class="card-body">
								<div class="media d-flex">
									<div class="media-body text-left">
										<h5>Number of users</h5>
										<h4 class="warning"><?php echo $num_users;?></h4>
									</div>
									<div>
										<i class="ft-users warning font-large-2 float-right"></i>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-12">
				<div class="card pull-up">
					<a href="../register.php">
						<div class="card-content">
							<div class="card-body">
								<div class="media d-flex">
									<div class="media-body text-left">
										<h5>Add New User</h5>
									</div>
									<div>
										<i class="icon-user-follow success font-large-2 float-right"></i>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			
		</div>
	</div>

	<section id="configuration">
  <div class="container">
	<h3>Transactions made for the month of <?php echo date("F Y");?></h3>
	
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
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Seller</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Buyer</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Downloaded?</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Date Purchased</th>
                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Price</th>
									<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Amount Payable</th>

                </tr>
              </thead>
              <tbody>
                <?php
                  if(!empty($transactions)){
					$count_transaction=0;
					$total_price=0;
					$total_amount_payable=0;
                    foreach ($transactions as $transaction) {
					  # code...
					  $buyer_id=$transaction['buyer_id'];
					  $buyer_details=$user->get_details_by_id($buyer_id);
					  $buyer_name=$buyer_details['first_name']." ".$buyer_details['last_name'];


					  

					  $audio_id=$transaction['audio_id'];
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
                          <td><?php echo date("Y/m/d H:ia",strtotime($date_purchased));?></td>
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
	<button class="btn btn-submit" type="button" style="margin-left:25%;background:black;color:white">Total Price:&nbsp;<?php echo "$price_currency $total_price";?>&nbsp; <span style="color:red">Total Amount Payable:&nbsp;<?php echo "$price_currency $total_amount_payable";?></span></button>
			
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