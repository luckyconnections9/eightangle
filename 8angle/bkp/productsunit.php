<?php include 'includes/common.php';
$meta_title = "Manage Products unit - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/productsunitClass.php';
$productsunit = new productsunitClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Manage Products unit
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Products unit</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<a href="productsunit_add.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i>Add Products unit</a>
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
							 <th>Name</th>
							 <th>Unit</th>
							 <th>Status</th>
							 <th colspan="2" align="center">Actions</th>
						 </tr>
					 </thead>
					 <tbody>
						<?php
						$params = array();
						$query = "SELECT * FROM `products_unit` where `company_id` = '$company_id' AND `deleted` = 'N' ";       
						$records_per_page=30;
						$newquery = $pagination->paging($query,$records_per_page);
						$productsunit->dataview($newquery,$params);
						?>
						<tr>
							<td colspan="7" align="center">
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
