<?php include 'includes/common.php';
$meta_title = "Sale statement- 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/salstatementClass.php';
$salstatement = new salstatementClass();
$customer_id = "";
	$from_date =  date('Y-m-d' , strtotime('-1 days') );
	$to_date=date('Y-m-d'); $customer_name = "";
	if(isset($_GET['customer']) and is_numeric($_GET['customer']) and $salstatement->getID($_GET['customer'])) 
	{
		$customer_id = ($_GET['customer']);
		$cust_data = $salstatement->getID($customer_id);
		$customer_name = $cust_data->name;
	}
	if(isset($_GET['from_date'])) 
	{
		$from_date =  ($_GET['from_date']);
	}
	if(isset($_GET['to_date'])) 
	{
		$to_date =  ($_GET['to_date']);
	}
	if($from_date == $to_date) 
	{
		$from_date = "";
	}
							
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Sale Statement
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Sale Statement</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<div class="form-group col-sm-12">
					<div class="col-sm-3">
					<b>Select Customer/Vendor:</b>
							<input autocomplete="off" type="text"   class="form-control input-sm"  onkeyup="load_customer(this.value);" name="customer" value="<?php echo $customer_name;?>" placeholder="Enter Party/Customer name" required />
					</div>	
					<form action="statement.php?customer=<?php echo $customer_id;?>" method="get">
						<div class="col-sm-2">
						<input name="customer" type="hidden" value="<?php echo $customer_id;?>" />
						<b>From:</b>
								<input name="from_date"  type="text" class="form-control input-sm" id="datepicker" value="<?php echo $from_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>	
						<div class="col-sm-2">
						<b>To:</b>
								<input name="to_date" type="text"  class="form-control input-sm"  id="datepicker1" value="<?php echo $to_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>		
						<div class="col-sm-2">
						<br/>
								<input name="go" type="submit"  class="btn btn-info"  value="Go" placeholder="Go" />
						</div>	
					</form>
					<div class="col-sm-3">
					<br/>
					<a href="printstatement.php?print_id=<?php echo $customer_id;?>&from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>" class="btn btn-large btn-info pull-right" target="_blank"><i class="glyphicon glyphicon-plus"></i> Print Statement</a>
					</div>
					<span class="col-sm-12" id="auto"></span>
				</div>
				
			</div>
			<div class="box-body">
				<div class="col-sm-12">
					<?php
					if($created) { echo $created; }
					if($updated) { echo $updated; }
					if($deleted) { echo $deleted; }
					?>
				</div>
				<?php if($customer_id ) {?>
				<div class="col-xs-12">
							<small class="pull-right"><b>Date</b>
							<?php 
								if(!empty($from_date)) { 
									echo ": ".displaydateformat("d/m/Y",substr($from_date,0,10))." <b>to</b> ".displaydateformat("d/m/Y",substr($to_date,0,10));;
								} else {
									echo ": ".displaydateformat("d/m/Y",substr(date('Y-m-d'),0,10));
								}
							?>
							</small>
							<b><?php echo $cust_data->name; ?></b><br />
							<small>
							GSTIN: <?php echo $cust_data->gst_num; ?>
							</small>
				</div>
				<?php } ?>
				<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>					
						<tr>
							 <th>#</th>
							 <th width="20%">Date</th>
							 <th width="15%">Type</th>
							 <th width="20%">Reference Number</th>
							 <th>Credit (<?php echo $currency;?>)</th>
							 <th>Debit (<?php echo $currency;?>)</th>
							 <th>Balance (<?php echo $currency;?>)</th>
					    </tr>
					 </thead>
					 <tbody>
						<?php
						$params = array();
							$query = "SELECT id,invoice_number, dt_created, balance, invoice_type , invtype FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Sale invoice') AND  `customer_id`=:customer_id  ORDER BY `dt_created` ASC"; 
							
							
							if(!empty($from_date)) {
								$query = "SELECT id,invoice_number, dt_created, balance, invoice_type , invtype FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Sale invoice') AND  `customer_id`=:customer_id AND (dt_created >= :from_date AND dt_created <= :to_date)  ORDER BY `dt_created` ASC"; 
								$params[':from_date'] = $from_date;
								$params[':to_date'] = $to_date;
							} 
							$params[':customer_id'] = $customer_id;
							$params[':company_id'] = $company_id;
								
						$records_per_page=1000;
						$newquery = $pagination->paging($query,$records_per_page);
						$salstatement->salestatement($newquery,$params);
						?>
						<tr>
							<td colspan="11" align="center">
								<div class="pagination-wrap">
									<?php $val = "";
										 ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
