<?php include 'includes/common.php';
$meta_title = "Manage Assets - 8angle |  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/assetsClass.php';
$assets = new assetsClass();

$searchquery =""; $sortby ="id";  $sortorder ="ASC";
if(isset($_GET['search'])) { 
	$keyword= ($_GET['search']);
}	
else 
{
	$keyword = "";
}
$sortvalue = array('id','name','cname','status','paidby','pay_date');
if(isset($_GET['sortby']) and in_array($_GET['sortby'], $sortvalue)) { 
	$sortby= ($_GET['sortby']);
}
if(isset($_GET['sortorder']) AND ($_GET['sortorder'] == "ASC" OR $_GET['sortorder'] = "DESC")) { 
	$sortorder= ($_GET['sortorder']);
}
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Manage Company Assets
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Assets</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<form action="" method="get" class="form-horizontal" >
						<div class="col-sm-4">
						<b>Search Keyword:</b>
							<input name="search" type="text" class="from_date form-control input-sm" value="<?php echo $keyword;?>" placeholder="" />
						</div>	
						<div class="col-sm-2">
						<b>Sort By:</b>
						<select class="form-control" name="sortby">
							<option value="id" <?php if($sortby == "id") { echo "selected"; } ?> ></option>
							<option value="name" <?php if($sortby == "name") { echo "selected"; } ?> >Asset</option>
							<option value="cname" <?php if($sortby == "cname") { echo "selected"; } ?> >Asset Type</option>
							<option value="paidby" <?php if($sortby == "paidby") { echo "selected"; } ?> >Paid By</option>
							<option value="pay_date" <?php if($sortby == "pay_date") { echo "selected"; } ?> >Pay Date</option>
							<option value="status" <?php if($sortby == "status") { echo "selected"; } ?> >Status</option>
						</select>
						</div>	
						<div class="col-sm-2">
						<b>Sort Order:</b>
						<select class="form-control" name="sortorder">
							<option value="ASC" <?php if($sortorder == "ASC") { echo "selected"; } ?> >Ascending</option>
							<option value="DESC" <?php if($sortorder == "DESC") { echo "selected"; } ?>>Desending</option>
						</select>
						</div>	
						<div class="col-sm-2">
						<br/>
							<input name="go" type="submit"  class="btn btn-info"  value="Go" placeholder="Go" />
						</div>	
					</form>
				
				<a href="assets_add.php" class="btn btn-large btn-info col-sm-2"><i class="glyphicon glyphicon-plus"></i> Add Assets</a>
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
							 <th>Asset Name</th>
							 <th>Asset Type</th>
							 <th>Amount</th>
							 <th>For</th>
							 <th>Paid By</th>
							 <th>Paid Date</th>
							 <th>Description</th>
	   						 <th>Status</th>
							 <th colspan="2" align="center">Actions</th>
						 </tr>
					 </thead>
					 <tbody>
						<?php
						$params = array();
						if($keyword) 
						{
							$searchquery = "(`name` LIKE :keyword OR `name_on_check`  LIKE :keyword OR `description`  LIKE :keyword ) AND  "; 
							$params[':keyword'] = '%'.$keyword.'%';	
						}
						$query = "SELECT *,(SELECT name 
							FROM assets_category
							WHERE assets.assets_category_id = assets_category.id)cname FROM `assets` where $searchquery `company_id` = :company_id  AND `deleted` = 'N' ORDER BY $sortby $sortorder"; 		
							$params[':company_id'] = $company_id;		
							
						$records_per_page=20;
						$newquery = $pagination->paging($query,$records_per_page);
						$assets->dataview($newquery,$params);
						?>
						<tr>
							<td colspan="12" align="center">
								<div class="pagination-wrap">
									<?php $val = "search=".$keyword."&sortby=".$sortby."&sortorder=".$sortorder."&";
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
