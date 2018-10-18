<?php include 'includes/common.php';
$meta_title = "Manage Taxes - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/taxesClass.php';
$taxes = new taxesClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Manage Taxes
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Taxes</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<a href="taxes_add.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> Add Tax</a>
			</div>
			<div class="box-body">
				<div class="col-sm-12">
					<?php
					if($created) { echo $created; }
					if($updated) { echo $updated; }
					if($deleted) { echo $deleted; }
					?>
				</div>
				<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>					
						<tr>
							 <th>#</th>
							 <th>IGST (%)</th>
							 <th>CGST (%)</th>
							 <th>SGST (%)</th>
	   						 <th>Status</th>
							 <th colspan="2" align="center">Actions</th>
						 </tr>
					 </thead>
					 <tbody>
						<?php
						$params =array();
						$query = "SELECT * FROM `invoice_tax` where `company_id` = :company_id AND `deleted` = 'N' ";       
						$params[':company_id'] = $company_id;
						$records_per_page=20;
						$newquery = $pagination->paging($query,$records_per_page);
						$taxes->dataview($newquery,$params);
						?>
						<tr>
							<td colspan="8" align="center">
								<div class="pagination-wrap">
									<?php $val = "";
										$pagination->paginglink($query,$records_per_page,$val,$params); ?>
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
