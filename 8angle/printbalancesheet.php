<?php include 'includes/common.php';
$meta_title = "Print Balancesheet - 8angle | POS  ";
isCompany($company_id);
include_once 'includes/balancesheetClass.php';
$balancesheet = new balancesheetClass();
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
$fromdate=date('Y-04-01'); 
$year_end_date = date('Y-m-d' , strtotime('+1 years', strtotime(date('Y-04-01'))) );
$next_year_start_date = date('Y-m-d' , strtotime('-3 months',strtotime($year_end_date)) );
if(date('Y-m-d') >= $next_year_start_date AND date('Y-m-d') < $year_end_date) { $fromdate = date('Y-m-d' , strtotime('-1 years',strtotime($year_end_date)) ); }
$todate = date('Y-m-d');

if(isset($_GET['from_date'])) 
	{
		$fromdate =  ($_GET['from_date']);
	}
	if(isset($_GET['to_date'])) 
	{
		$todate =  ($_GET['to_date']);
	}
	if($fromdate == $todate) 
	{
		$fromdate = "";
	}
	$saleInvoice = $balancesheet->saleInvoice($fromdate,$todate);
	$saleDebit = $balancesheet->saleDebit($fromdate,$todate);
	$saleCredit = $balancesheet->saleCredit($fromdate,$todate);
		
	$purchaseInvoice = $balancesheet->purchaseInvoice($fromdate,$todate);
	$purchaseDebit = $balancesheet->purchaseDebit($fromdate,$todate);
	$purchaseCredit = $balancesheet->purchaseCredit($fromdate,$todate);

	$gotGstCredit = $balancesheet->gotGstCredit($fromdate,$todate);
	$gotGstDebit = $balancesheet->gotGstDebit($fromdate,$todate);
	$gstStandingInv = $balancesheet->gstStandingInv($fromdate,$todate);	


	$gstOutPurInv = $balancesheet->gstOutPurInv($fromdate,$todate);
	$gstPurCre = $balancesheet->gstPurCre($fromdate,$todate);
	$gstPurDeb = $balancesheet->gstPurDeb($fromdate,$todate);
 ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Balancesheet</title>
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
					<i class="fa fa-globe"></i> <?php echo $company_data->name; ?>
					<small class="pull-right">Date: 
					<?php 
						if(!empty($fromdate)) { 
							echo ": ".displaydateformat("d/m/Y",substr($fromdate,0,10))." <b>to</b> ".displaydateformat("d/m/Y",substr($todate,0,10));;
						} else {
							echo ": ".displaydateformat("d/m/Y",substr(date('Y-m-d'),0,10));
						}
					?>
					</small>
					<small>
					<?php echo $company_data->address; ?><br />
					<?php if(!empty( $company_data->city)) { echo $city_data->Name; ?>,  <?php } echo $company_data->state; ?>, India, Pin-  <?php echo $company_data->pin; ?><br />
					GSTIN: <?php echo $company_data->gst_number; ?>
					</small>
				</h2>
			  </div>					
		  <!-- /.col -->
		</div>
				<div class="row">
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>	
							
							</thead>
							 <tbody>
								<tr><th colspan="2">
								<font size="3">Assets</font>
								</th></tr>							
								<tr>
									<td>Cash</td>
									<td><?php echo $currency;?> <?php echo num($balancesheet->saleCredit($fromdate,$todate) - $balancesheet->saleDebit($fromdate,$todate)); ?> </td>
								</tr>	
								<tr>
									<td>Accounts Receivable (Net)</td>
									<td><?php echo $currency;?> <?php  $InvoiceOutstandingTotal = num($saleInvoice - ($saleCredit - $saleDebit)); echo $InvoiceOutstandingTotal; ?></td>
								</tr>
								<tr>
									<td>Pre-Paid Expenses</td>
									<td><?php echo $currency;?> <?php echo num($balancesheet->exptotal($fromdate,$todate) + $balancesheet->exp2total($fromdate,$todate));?></td>
								</tr>
								<tr>
									<td>Equity Paid - Purchased Inventory </td>
									<td><?php echo $currency;?> <?php echo $balancesheet->availableStock($fromdate,$todate) ;?></td>
								</tr>
								<th><span class="pull-right">Total Current Assets</span></th>
								<td><?php echo $currency;?> <?php echo num($balancesheet->saleCredit($fromdate,$todate) - $balancesheet->saleDebit($fromdate,$todate)) + $InvoiceOutstandingTotal + $balancesheet-> inventorytotal($fromdate,$todate) + $balancesheet->exptotal($fromdate,$todate) + $balancesheet->exp2total($fromdate,$todate) + $balancesheet->paidVendor($fromdate,$todate) ; ?> </td>
							 
							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>
							</thead>
							 <tbody>
							<tr><th colspan="2">
								<font size="3">Liabilities</font>
							</th></tr>							 
								<tr>
									<td>Inventory Purchase (Outstanding)</td>
									<td><?php echo $currency;?> <?php echo $balancesheet->pay2Vendor($fromdate,$todate); ?></td>
								</tr>	
								<tr>
									<td>-- </td>
									<td><?php echo $currency;?> </td>
								</tr>
								<tr>
									<td>--</td>
									<td><?php echo $currency;?> </td>
								</tr>
								<th><span class="pull-right">Total Liabilities</span></th>
								<td><?php echo $currency;?> <?php echo $balancesheet->pay2Vendor($fromdate,$todate); ?></td>
							</tbody>
						</table>
					</div>
			

				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>	
							
							</thead>
							 <tbody>
								<tr><th colspan="2">
								<font size="3">Fixed Assets</font>
								</th></tr>							
								<?php echo $balancesheet->assetsPlus($fromdate,$todate,$currency) ;?>		
													 
							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>
							</thead>
							 <tbody>
							<tr><th colspan="2">
								<font size="3">Shareholders - Other Liabilities</font>
							</th></tr>							 
									<?php echo $balancesheet->postExp($fromdate,$todate,$currency) ;?>		
									
							</tbody>
						</table>
					</div>
			

				</div>
				
			</div>

	</section>
	<!-- /.content -->
	
</div>
<!-- /.content-wrapper -->

</body>
</html>