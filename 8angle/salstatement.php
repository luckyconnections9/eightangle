<?php include 'includes/common.php';
$meta_title = "Manage Customers - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/salstatementClass.php';
$salstatement = new salstatementClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Sale/Purchase Statement
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Sale/Purchase Statement</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<a href="printstatement.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i>Print Statement</a>
			</div>
			<div class="box-body">
				<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>					
						<tr>
							 <th>#</th>
							 <th width="20%">Date</th>
							 <th width="10%">Type</th>
							 <th width="20%">Reference Number</th>
							 <th>Credit (<?php echo $currency;?>)</th>
							 <th>Debit (<?php echo $currency;?>)</th>
							 <th>Balance (<?php echo $currency;?>)</th>
					    </tr>
					 </thead>
					 <tbody>
						<?php
						$cust_id = 2;
						$params = array();
						$params[':cust_id'] = $cust_id;
						$params[':company_id'] = $company_id;
						
						$query = "SELECT invoice_number as reference, dt_created as t, balance as amt, invoice_type as type FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND `customer_id`=:cust_id UNION SELECT receipt_number as reference, receipt_date as t, amount as amt , invoice_type as type
FROM `receivable` WHERE `company_id` = :company_id AND `invoice_type` = 'Sale' AND `customer_id`=:cust_id ORDER BY t ASC";       
						$records_per_page=1000;
						$newquery = $pagination->paging($query,$records_per_page);
						$salstatement->saldata($newquery,$params);
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
