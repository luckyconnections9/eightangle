<?php include 'includes/common.php';
$meta_title = "Manage Products - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/productsClass.php';
$products = new productsClass();

$searchquery =""; $sortby ="id";  $sortorder ="ASC";
if(isset($_GET['search'])) { 
	$keyword= ($_GET['search']);
}	
else 
{
	$keyword = "";
}
$sortvalue = array('id','name','cname','code','hsn_code','product_type','sell_price','status');
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
			Manage Products
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Products</li>
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
							<option value="cname" <?php if($sortby == "cname") { echo "selected"; } ?> >Product Category</option>
							<option value="code" <?php if($sortby == "code") { echo "selected"; } ?> >Product Code</option>
							<option value="hsn_code" <?php if($sortby == "hsn_code") { echo "selected"; } ?> >HSN Code</option>
							<option value="product_type" <?php if($sortby == "product_type") { echo "selected"; } ?> >Product Type</option>
							<option value="sell_price" <?php if($sortby == "sell_price") { echo "selected"; } ?> >Sell Price</option>
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
					<a href="products_add.php" class="btn btn-large btn-info col-sm-2"><i class="glyphicon glyphicon-plus"></i> Add Product</a>

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
							 <th>Product Name</th>
							 <th>Category</th>
							 <th>HSN Code</th>
							 <th>Product type</th>
							 <th>Unit</th>
							 <th>Buy Price</th>
							 <th>Sell Price</th>
							 <th>Price</th>
							 <th>Tax</th>
							 <th>Status</th>
							 <th colspan="2" align="center">Actions</th>
						 </tr>
					 </thead>
					 <tbody>
						<?php
						$params = array();
						if($keyword) 
						{
							$searchquery = "(`name` LIKE :keyword OR `hsn_code`  LIKE :keyword OR `description`  LIKE :keyword OR `code`  LIKE :keyword ) AND  "; 
							$params[':keyword'] = '%'.$keyword.'%';	
						}
						$query = "SELECT *,(SELECT name 
							FROM category
							WHERE products.category_id = category.id)cname FROM `products` where $searchquery `company_id` = :company_id  AND `deleted` = 'N' ORDER BY $sortby $sortorder"; 
						$params[':company_id'] = $company_id;								
  
						$records_per_page=10;
						$newquery = $pagination->paging($query,$records_per_page);
						$products->dataview($newquery,$params);
						?>
						<tr>
							<td colspan="14" align="center">
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
