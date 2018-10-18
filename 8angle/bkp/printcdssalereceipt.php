<?php include 'includes/common.php';
isCompany($company_id);
include_once 'includes/invoiceClass.php';
$invoice = new invoiceClass();
include_once 'includes/customersClass.php';
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
$customers = new customersClass();
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
$receipt_id = "";
$print = "";
if(isset($_GET['print_id']) and is_numeric($_GET['print_id'])) {
	$receipt_id = ($_GET['print_id']);
}
if(isset($_GET['print'])) {
	$print = ($_GET['print']);
}
if(!$invoice->getID($receipt_id)) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=receipt.php?updated=NP">'; 
	exit();
} 
else
{
	$receipt_data = $invoice->getID($receipt_id);
	$receipt_number = ($receipt_data->invoice_number);
	$receipt_date = ($receipt_data->dt_created);
	$customer_name  = ($receipt_data->contactname);
	$amount   = ($receipt_data->balance);
	$invoice_type = $receipt_data->invoice_type;
	$invoice_id = ($receipt_data->invoice_id);
	$invoice_data_parent = $invoice->getID($invoice_id);
	$invoice_no = ($invoice_data_parent->invoice_number);
	$receipt_for   = $invoice_no;
	$paid_by     = ($receipt_data->paid_by); 
	$paid_date     = ($receipt_data->paid_date); 
	$account_name  =($receipt_data->account_name);
	$account_number = ($receipt_data->account_number);
	$bank_name = ($receipt_data->bank_name);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $invoice_type;?></title>
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
<center>
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
	  <!-- Main content -->
		<section class="invoice">
			<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" >
						<tr >
							<th class="text-white"><?php echo strtoupper($invoice_type); ?></th>
						</tr>
						<tr>
							 <td>
								<div class="receipt">
									 <div class="row">
										<div  class="col-xs-8">
											<b><?php echo html_entity_decode($company_data->name); ?></b><br />	
											<?php if($company_data->address) echo html_entity_decode($company_data->address)."<br />"; ?>
											<?php if(!empty( $company_data->city)) { echo $city_data->Name; ?>,  <?php } echo $company_data->state; if($company_data->pin) { ?>, Pin-  <?php echo $company_data->pin; } ?>
											<?php if($company_data->gst_number) echo "<p>GSTIN: ".html_entity_decode($company_data->gst_number)."</p>"; ?>
										</div>
										<div  class="col-xs-4">
											<table border="0" class="table table-striped dt-responsive nowrap">
												<tr><td><b>Receipt Number: </b></td><td> <?php echo $receipt_number; ?></td></tr>
												<tr><td><b>Date: </b></td><td> <?php echo displaydateformat("d/m/Y",substr($receipt_date,0,10));?></td></tr>
											</table>
										</div>
									 </div>
									 <div class="row">
										<div  class="col-xs-7">
											<div class="form-group">
												<label for="from" class="col-xs-4 control-label">Received from: </label>
												<div class="col-xs-8">
													<?php echo $customer_name;?>
												</div>
											</div>
										</div>
										<div  class="col-xs-5">
											<div class="form-group">
												<label for="amount" class="col-xs-6 control-label">Amount of INR: </label>
												<div class="col-xs-6">
													<?php echo number_format($amount, 2, '.', '');?>
												</div>
											</div>
										</div>
									 </div>
									 <div class="row">
										<div class="form-group">
											<label class="col-xs-2 control-label"><span class="pull-right">Rupees: </span></label>
											<span class="col-xs-10" >
												<span  class="form-control" style="border:0px; border-bottom: 1px solid gray" id="in_words"></span>
											</span>
										</div>
									 </div>
									  <div class="row">
										<div class="form-group">
											<label class="col-xs-2 control-label"><span class="pull-right">For: </span></label>
											<span class="col-xs-10">
												<span class="form-control" style="border:0px; border-bottom: 1px solid gray" > <?php echo $receipt_for;?></span>
											</span>
										</div>
									 </div>
									 <div class="row">
										<div class="col-xs-12">
										<p>&nbsp;</p>
											<table border="0" class="table table-striped dt-responsive nowrap">
												<tr><td width="10%"><b>Paid By: </b></td><td> <?php echo $paid_by;?></td></tr>
												<?php if($paid_by != "Cash") { ?>
												<tr>
												<td colspan="2">
													<div class="col-xs-12" >
														<div class="col-xs-4 ">
															<b>AC/Card holder Name: <br/></b> <?php echo $account_name;?>
														</div>
														<div class="col-xs-4 ">
															<b>AC/CC/Cheque #</b> <br/><?php echo $account_number;?>
														</div>
														<div class="col-xs-4 ">
															<b>Bank Name: </b> <br/><?php echo $bank_name;?>
														</div>
													</div>
												</td></tr>
											 <?php } ?>
											</table>
										</div>
												
									 </div>
									 <div class="row">
										<div class="form-group">
											<label class="col-xs-2 control-label">Received By: </label>
											<span class="col-xs-10">
												<span class="form-control" style="border:0px; border-bottom: 1px solid gray" ></span>
											</span>
										</div>
									 </div>
								</div>
							 </td>
						</tr>
					</table>
		</section>
  <!-- /.content -->
	</div>
</center>
	<script src="js/validator.js"></script>
	<script type="text/javascript">
		document.getElementById('in_words').innerHTML = number2text(<?php echo $amount;?>);
	</script>
</body>
</html>
