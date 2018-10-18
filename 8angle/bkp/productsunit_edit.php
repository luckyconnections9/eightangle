<?php include 'includes/common.php';
$meta_title = "Edit Products unit - 8angle | POS  ";
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
			Edit Products unit
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>productsunit.php">Products unit</a></li>
			<li class="active">Edit Products unit</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
				<?php	
				$failure = "";
				$inserted = "";
						$name= "";
						$unit= "";
						$status= "";
						
				if(isset($_POST['EditProductsunit']))
					{
						$id = ($_GET['edit_id']);
						$name = ($_POST['name']);
						$unit = ($_POST['unit']);
						$status = ($_POST['status']);
					 
						if($productsunit->update($id,$name,$unit,$status))
						{
							$inserted ="Products unit was updated successfully";
						}
						else
						{
							$failure = "Error while updating Products unit!";
						}
					}
					if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
					{
						$id = ($_GET['edit_id']);
						$productsunitDetails = $productsunit->getID($id); 
					@	$name= $productsunitDetails->name;
					@	$unit= $productsunitDetails->unit;
					@	$status= html_entity_decode($productsunitDetails->status);
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
				<form class="form-horizontal"  id="formProductsunit"  method='post' action="">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Products unit Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Kilogram" required>
							</div>
						</div>
						<div class="form-group">
							<label for="unit" class="col-sm-2 control-label">Unit</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="unit" autocomplete="off" placeholder="kg" value="<?php echo html_entity_decode($unit); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control" name="status">
									<option value="Enable" <?php if($status == "Enable") { echo "selected"; } ?> >Enable</option>
									<option value="Disable" <?php if($status == "Disable") { echo "selected"; } ?>>Disable</option>
								 </select>
							</div>
						</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo BASE_URL;?>productsunit.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="EditProductsunit" class="btn btn-info pull-right" value="Edit">Edit Products unit</button>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
