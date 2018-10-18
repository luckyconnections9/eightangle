<?php include 'includes/common.php';
$meta_title = "Manage Assets Category - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/assetscategoryClass.php';
$assetscategory = new assetscategoryClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Manage Assets Categories
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Assets Categories</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<a href="assetscategory_add.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i>Add Assets Category</a>
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
							 <th>Category Name</th>
							 <th>Description</th>
							 <th>Status</th>
							 <th colspan="2" align="center">Actions</th>
						 </tr>
					 </thead>
					 <tbody>
						<?php
						$params = array();
						$query = "SELECT * FROM `assets_category` where `company_id` = '$company_id' AND `deleted` = 'N' ";       
						$records_per_page=10;
						$newquery = $pagination->paging($query,$records_per_page);
						$assetscategory->dataview($newquery,$params);
						?>
						<tr>
							<td colspan="6" align="center">
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
