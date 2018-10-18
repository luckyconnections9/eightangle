<?php include 'includes/common.php';
$meta_title = "Balancesheet - 8angle | POS  ";
require('header.php');
require('left.php');
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
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Balancesheet (Financial Datasheet)
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Balancesheet </li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
			<div class="form-group col-sm-12">
					<form action="balancesheet.php" method="get">
						<div class="col-sm-4">
								<div class="col-sm-10">
									<b>From:</b>
										<input name="from_date"  type="text" class="form-control input-sm" id="datepicker" value="<?php echo $fromdate;?>" placeholder="<?php echo date('Y-m-d')?>" />
								</div>
								<div class="col-sm-2">
								</div>
								
								<div class="col-sm-10">
								<b>To:</b>
									<input name="to_date" type="text"  class="form-control input-sm"  id="datepicker1" value="<?php echo $todate;?>" placeholder="<?php echo date('Y-m-d')?>" />
								</div>
								<div class="col-sm-2"><br/>
									<input name="go" type="submit"  class="btn btn-info"  value="Go" placeholder="Go" />
								</div>
						</div>	
					</form>
					<div class="col-sm-6">
						<center>
						<h3><?php echo $company_data->name; ?> <small>(Balancesheet)</small></h3>
							<p>
							
							<?php echo $company_data->state; ?>, India, 
							<br />
							GSTIN: <?php echo $company_data->gst_number; ?>
							</p>
							<p></p>
						</center>
					</div>
					<div class="col-sm-2">
					<br/>
					</div>
			</div>
				<div class="col-sm-12">
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>	
							
							</thead>
							 <tbody>
								<tr>
								<th colspan="2">
								<font size="5">Assets</font>
								</th>
								</tr>							
								<tr>
									<th>Recieved Amount</th>
									<th><?php echo $currency;?> <?php $cashTotal = num($saleCredit - $saleDebit); echo $cashTotal; ?> </th>
								</tr>						
								<tr>
									<th>GST Recieved</th>
									<th><?php echo $currency;?> <?php $gotGstTotal = num($gotGstCredit - $gotGstDebit); echo $gotGstTotal; ?> </th>
								</tr>	
								<tr>
									<th>Accounts Receivable (Tax Excluded)</th>
									<th><?php echo $currency;?> <?php $InvoiceOutstandingTotal = num($saleInvoice - ($saleCredit - $saleDebit)); echo $InvoiceOutstandingTotal; ?></th>
								</tr>
								<tr>
									<th>GST Receivable </th>
									<th><?php echo $currency;?> <?php $gstOutstandingTotal = num($gstStandingInv - ($gotGstCredit - $gotGstDebit)); echo $gstOutstandingTotal; ?></th>
								</tr>
								<tr>
									<th>Equity Paid - Inventory (w/o Tax)</th>
									<th><?php echo $currency;?> <?php $inventoryPur = num($gstPurCre - $gstPurDeb); echo $inventoryPur;?></th>
								</tr>
								<tr>
									<th>GST Paid in Stock </th>
									<th><?php echo $currency;?> <?php $PaidGstTotal = num($saleInvoice - ($saleCredit - $saleDebit)); echo $PaidGstTotal; ?></th>
								</tr>
								<tr>
								<th><span class="pull-right">Total Current Assets</span></th>
								
								<th><?php echo $currency;?> <?php $total =  num($cashTotal + $InvoiceOutstandingTotal + $balancesheet->availableStock($fromdate,$todate) ); echo $total; ?> </th>
								</tr>
								
								<tr>
								<th colspan="2">
								<font size="5">Expenses</font>
								</th>
								</tr>
								<tr>
									<th>Pre-Paid Expenses</th>
									<th><?php echo $currency;?> <?php $prepaidexpenseTotal =  num($balancesheet->exptotal($fromdate,$todate) + $balancesheet->exp2total($fromdate,$todate)); echo $prepaidexpenseTotal ;?></th>
								</tr>

							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>
							</thead>
							 <tbody>
							<tr><th colspan="2">
								<font size="5">Liabilities</font>
							</th></tr>							 
								<tr>
									<th>Inventory Purchase (Outstanding)</th>
									<th><?php echo $currency;?> <?php $pusInvoiceOutstandingTotal = num($purchaseInvoice - ($purchaseDebit - $purchaseCredit)); echo $pusInvoiceOutstandingTotal; ?></th>
								</tr>	
								<tr>
									<th>Outstanding GST </th>
									<th><?php echo $currency;?> <?php $pusInvoiceOutstandingTotal = num($purchaseInvoice - ($purchaseDebit - $purchaseCredit)); echo $pusInvoiceOutstandingTotal; ?></th>
								</tr>
								<tr>
									<th>--</th>
									<th><?php echo $currency;?> </th>
								</tr>
								<tr>
								<th><span class="pull-right">Total Liabilities</span></th>
								<th><?php echo $currency;?> <?php echo num($pusInvoiceOutstandingTotal); ?></th>
								</tr>
							</tbody>
						</table>
					</div>
			

				</div>
				
				<div class="col-sm-12">
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
						
							 <tbody>
								<tr><th colspan="2">
								<font size="5">Fixed Assets</font>
								</th></tr>							
								<?php echo $balancesheet->assetsPlus($fromdate,$todate,$currency);?>		
													 
							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							<thead>
							</thead>
							 <tbody>
							<tr><th colspan="2">
								<font size="5">Other Liabilities - Post Paid Expenses</font>
							</th></tr>							 
									<?php echo $balancesheet->postExp($fromdate,$todate,$currency);?>										
							</tbody>
						</table>
					</div>
			

				</div>
				
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
	
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
