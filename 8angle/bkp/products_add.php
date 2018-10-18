<?php include 'includes/common.php';
$meta_title = "Add Product - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/productsClass.php';
$products = new productsClass();
?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Add Product
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>products.php">Products</a></li>
			<li class="active">Add Product</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
		<?php	
			$failure = "";
			$inserted = "";
						$name= "";
						$category_id= 0;
						$code= "";
						$price= "";
						$hsn_id="";
						$hsn_code="";
						$description= "";
						$status= "";
						$buy_price=0;
						$sell_price=0;
						$tax_id="";
						$products_unit_id ="";
						$product_type="Goods";
			
			if(isset($_POST['AddProducts']))
				{
					 $name = ($_POST['name']);
					 $category_id = ($_POST['category_id']);
					 $hsn_id = ($_POST['hsn_id']);
					 $hsn_code = ($_POST['hsn_code']);
					 $code = ($_POST['code']);
					 $buy_price = ($_POST['buy_price']);
					 $sell_price = ($_POST['sell_price']);
					 $price = ($_POST['price']);
					 $tax_id = ($_POST['tax_id']);
					 $status = ($_POST['status']);
					 $description = ($_POST['description']);
					 $product_type = ($_POST['product_type']);
					 $products_unit_id = ($_POST['products_unit_id']);
				 
					if($products->create($category_id,$name,$hsn_id,$hsn_code,$code,$buy_price,$sell_price,$price,$tax_id,$status,$description,$product_type,$products_unit_id))
					{
						$inserted ="Product was added successfully";
					}
					else
					{
						$failure = "Error while adding Product!";
					}
				}
				?>
				<?php
				if($inserted)
				{
				 ?>
					<div class="alert alert-success alert-dismissible"><strong>WOW! </strong><?php echo $inserted ?></div>
				<?php
				}
				if($failure)
				{
				 ?>
					<div class="alert alert-danger alert-dismissible"><?php echo $failure ?></div>
				<?php
				}
				?>
				<form class="form-horizontal" name="addproduct" id="formProducts"  method='post' action="">
					<div class="box-body">
					<div class="col-sm-8">
						<div class="form-group">
								<label for="Product category" class="col-sm-2 control-label">Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="category_id">
										<option value="0">Select Category</option>
										<?php 
											$stmt_cats = getDB()->prepare("SELECT * FROM category WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
											$stmt_cats->execute();
											$cat_sel = "";
											 while($dataa=$stmt_cats->fetch(PDO::FETCH_OBJ))
											 {
												if($dataa->id == $category_id) { $cat_sel ="selected='selected'";}  else { $cat_sel ="";}
												echo "<option  ".$cat_sel."  value=".$dataa->id.">".$dataa->name."</option>";
											 }
										 ?>
									 </select>
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-sm-2 control-label">Product Name</label>
								<div class="col-sm-8">
									<input type="text" value="<?php echo html_entity_decode($name);?>" id="hsn_item_name"  class="form-control" name="name" autocomplete="off" placeholder="Product Name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="Product Type" class="col-sm-2 control-label">Product Type</label>
								<div class="col-sm-8">
									<select class="form-control" name="product_type">
										<option value="Goods" <?php if($product_type == "Goods") { echo "selected"; } ?> >Goods</option>
										<option value="Services" <?php if($product_type == "Services") { echo "selected"; } ?>>Services</option>
									 </select>
								</div>
							</div>
							<div class="form-group">
								<label for="code" class="col-sm-2 control-label">Product Code</label>

								<div class="col-sm-8">
									<input type="text" value="<?php echo html_entity_decode($code);?>" class="form-control" name="code" autocomplete="off" placeholder="Product Code" >
								</div>
							</div>
							<input type="hidden" class="form-control" name="hsn_id" autocomplete="off" value="<?php echo html_entity_decode($hsn_id);?>">
							<div class="form-group">
								<label for="hsn_code" class="col-sm-2 control-label">HSN Code</label>

								<div class="col-sm-8">
									<input type="text" class="form-control" id="hsn_code"  value="<?php echo html_entity_decode($hsn_code);?>" name="hsn_code" autocomplete="off" placeholder="HSN Code" >
								</div>
								<i class="fa fa-search"><a href="javascript:;" onClick="return hsn_code_search();"> Search HSN Code</a></i>
							</div>
							<div class="form-group">
								<label for="Product Unit" class="col-sm-2 control-label">Unit</label>
								<div class="col-sm-8">
									<select class="form-control" name="products_unit_id">
										<option value="0">Select Unit</option>
										<?php 
											$stmt_units = getDB()->prepare("SELECT * FROM products_unit WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
											$stmt_units->execute();
											$units_sel ="";
											 while($dataa_units=$stmt_units->fetch(PDO::FETCH_OBJ))
											 {
												 if($dataa_units->id == $products_unit_id) { $units_sel ="selected='selected'";}  else { $units_sel ="";}
												echo "<option ".$units_sel." value=".$dataa_units->id.">".$dataa_units->name."</option>";
											 }
										 ?>
									 </select>
								</div>
							</div>
							<div class="form-group">
								<label for="buy_price" class="col-sm-2 control-label">Buy Price</label>

								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo html_entity_decode($buy_price);?>" name="buy_price" value="0" autocomplete="off" placeholder="60" >
								</div>
							</div>
							<div class="form-group">
								<label for="sell_price" class="col-sm-2 control-label">Sell Price</label>

								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo html_entity_decode($sell_price);?>" name="sell_price" value="0" autocomplete="off" placeholder="100" >
								</div>
							</div>
							<div class="form-group">
								<label for="price" class="col-sm-2 control-label">MRP</label>

								<div class="col-sm-8">
									<input type="text" class="form-control" id="price" onKeypress="return checkNumber(this.value)" name="price" value="<?php echo html_entity_decode($price);?>" autocomplete="off" placeholder="100" >
								</div>
							</div>
							<div class="form-group">
								<label for="Product Tax" class="col-sm-2 control-label">Tax </label>
								<div class="col-sm-8">
									<select class="form-control" name="tax_id" >
										<option value="0">Select Tax</option>
										<?php 
											$stmt_tax = getDB()->prepare("SELECT * FROM invoice_tax WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N' ");
											$stmt_tax->execute();
											$tax_sel="";
											 while($data_tax=$stmt_tax->fetch(PDO::FETCH_OBJ))
											 {
												 if($data_tax->id == $tax_id) { $tax_sel ="selected='selected'";}  else { $tax_sel ="";}
												echo "<option ".$tax_sel." value=".$data_tax->id.">".$data_tax->name." @ ".$data_tax->tax."%</option>";
											 }
										 ?>
									 </select>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="col-sm-2 control-label">Description</label>

								<div class="col-sm-8">
									<textarea class="form-control" name="description" rows="3" placeholder="Enter ..."><?php echo html_entity_decode($description);?></textarea>
								</div>
							</div>
							<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
						<!-- /.box-body -->
					</div>
					<div class="col-sm-4"> 
						<span id="hsn_code_data"></span>
					</div>
				
				</div>
				<div class="box-footer">
						<a href="<?php echo BASE_URL;?>products.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="AddProducts" class="btn btn-info pull-right" value="Add">Add Product</button>
				</div>
						<!-- /.box-footer -->
				
			</form>
				
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<script language="javascript" type="text/javascript">
	function checkNumber(id,val)
	{
		if (!isNaN(parseFloat(val)) && isFinite(val)) {
			
		} else {
			document.getElementById(id).value = '';
		}
	}
	function getHsnvalue(val)
	{
		document.getElementById('hsn_code').value = val;
		document.getElementById('hsn_code_data').innerHTML = '';
	}
</script>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
