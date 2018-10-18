<?php include 'includes/common.php';
$meta_title = "Sale Statement";
isCompany($company_id);
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
include_once 'includes/salstatementClass.php';
$salstatement = new salstatementClass();
$customer_id = "";
$from_date =  date('Y-m-d' , strtotime('-1 days') );
$to_date=date('Y-m-d');
if(isset($_GET['print_id']) and is_numeric($_GET['print_id'])) 
{
	$customer_id = ($_GET['print_id']);
}
if(isset($_GET['from_date'])) 
{
	$from_date =  ($_GET['from_date']);
}
if(isset($_GET['to_date'])) 
{
	$to_date =  ($_GET['to_date']);
}
if($from_date == $to_date) {
		$from_date = "";
	}
	$params = array();
	$query = "SELECT id,invoice_number, dt_created, balance, invoice_type , invtype FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Sale invoice') AND  `customer_id`=:customer_id  ORDER BY `dt_created` ASC"; 
							
							
							if(!empty($from_date)) {
								$query = "SELECT id,invoice_number, dt_created, balance, invoice_type , invtype FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Sale invoice') AND  `customer_id`=:customer_id AND (dt_created >= :from_date AND dt_created <= :to_date)  ORDER BY `dt_created` ASC"; 
								$params[':from_date'] = $from_date;
								$params[':to_date'] = $to_date;
							}
							$params[':customer_id'] = $customer_id;
							$params[':company_id'] = $company_id;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $meta_title;?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/Ionicons/css/ionicons.min.css">
 
	<link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/AdminLTE.min.css"> 
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

  <!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style type="text/css">
		#table table { page-break-inside:auto }
		#table tr    { page-break-inside:avoid; page-break-after:auto }
		#table thead { display:table-header-group }
		#table tfoot { display:table-footer-group }
		@page { size: auto;  margin: 0mm; }
	</style>
</head>
<body onload="window.print();">
	<div class="col-sm-12">
	  <!-- Main content -->
		<section class="invoice">
			<div class="row">
			  <div class="col-xs-12">
				<h2 class="page-header">
					Statement
					<small class="pull-right"><b>Date</b>
					<?php 
						if(!empty($from_date)) { 
							echo ": ".displaydateformat("d/m/Y",substr($from_date,0,10))." <b>to</b> ".displaydateformat("d/m/Y",substr($to_date,0,10));;
						} else {
							echo ": ".displaydateformat("d/m/Y",substr(date('Y-m-d'),0,10));
						}
					?>
					</small>
				<?php if($cust_data= $salstatement->getID($customer_id)) { ?>
					<small>
					<?php echo $cust_data->name; ?><br />
					GSTIN: <?php echo $cust_data->gst_num; ?>
					</small>
				<?php } ?>
				</h2>
			  </div>					
			  <!-- /.col -->
			</div>
			<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>					
						<tr>
							 <th>#</th>
							 <th width="20%">Date</th>
							 <th width="20%">Type</th>
							 <th width="20%">Reference Number</th>
							 <th>Credit (<?php echo $currency;?>)</th>
							 <th>Debit (<?php echo $currency;?>)</th>
							 <th>Balance (<?php echo $currency;?>)</th>
					    </tr>
					 </thead>
					 <tbody>
						<?php

						$records_per_page=1000;
						$newquery = $pagination->paging($query,$records_per_page);
						$salstatement->salestatementprint($newquery,$params);
						?>
						</tr>
					</tbody>
				</table>
		</section>
  <!-- /.content -->
	</div>
</body>
</html>
