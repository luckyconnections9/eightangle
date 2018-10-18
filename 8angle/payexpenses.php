<?php include 'includes/common.php';
$meta_title = "Pay Outstanding Expenses - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/payexpensesClass.php';
$payexpenses = new payexpensesClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Pay Outstanding Expenses
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Payable Expenses</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
				<div class="col-sm-12">
					<?php
					if($created) { echo $created; }
					if($updated) { echo $updated; }
					if($deleted) { echo $deleted; }
					?>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-5">
						<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							<thead>					
								<tr>
									 <th>#</th>
									 <th>Expense Category</th>
									 <th>Current Outstanding</th>
									 <th align="center">Actions</th>
								 </tr>
							 </thead>
							 <tbody>
								<?php
								$params = array();
								$query = " SELECT *, SUM(amt - paid_amount) AS outstanding FROM `expenses` WHERE `deleted` ='N' AND `company_id` = $company_id AND `exp_paid` = 'N' AND `exp_type` = 'Post-Paid' AND `expenses_category_id` != '' GROUP BY `expenses_category_id` ORDER BY `id` DESC ";         
								$records_per_page=20;
								$newquery = $pagination->paging($query,$records_per_page);
								$payexpenses->dataview($newquery,$params);
								?>
								<tr>
									<td colspan="11" align="center">
										<div class="pagination-wrap">
											<?php $val = "";
											$pagination->paginglink($query,$records_per_page,$val,$params); ?>
										 </div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-7" >
						<span id="outstanding_expenses_data">
							
						</span>
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
