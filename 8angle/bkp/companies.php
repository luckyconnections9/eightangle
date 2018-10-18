<?php include 'includes/common.php';
$meta_title = "Manage Companies - 8angle | POS  ";
require('header.php');
require('left.php');

$searchquery =""; $sortby ="id";  $sortorder ="ASC";
if(isset($_GET['search'])) { 
	$keyword= $_GET['search'];
}	
else 
{
	$keyword = "";
}
$sortvalue = array('id','name','gst_number','status','city','state');
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
			Manage Company
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Companies</li>
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
							<option value="name" <?php if($sortby == "name") { echo "selected"; } ?> >Product Name</option>
							<option value="gst_number" <?php if($sortby == "gst_number") { echo "selected"; } ?> >GSTIN</option>
							<option value="city" <?php if($sortby == "city") { echo "selected"; } ?> >City</option>
							<option value="state" <?php if($sortby == "state") { echo "selected"; } ?> >State</option>
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
				<a href="companies_add.php" class="btn btn-large btn-info col-sm-2"><i class="glyphicon glyphicon-plus"></i> Add Company</a>
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
							 <th>Company Name</th>
							 <th>GSTIN</th>
							 <th>Address</th>
							 <th>City</th>
							 <th>State</th>
							 <th>Pin</th>
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
							$searchquery = "(`name` LIKE :keyword OR `gst_number`  LIKE :keyword OR `city`  LIKE :keyword OR `state`  LIKE :keyword OR `pin`  LIKE :keyword ) AND  ";
							$params[':keyword'] = '%'.$keyword.'%';					
						}
						$query = "SELECT *,(SELECT Name 
							FROM city
							WHERE companies.city = city.ID)city FROM `companies` where $searchquery  `deleted` = 'N' ORDER BY $sortby $sortorder"; 		
						
						$records_per_page=10;
						$newquery = $pagination->paging($query,$records_per_page);
						$crud->dataview($newquery,$params);
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
