<?php include 'includes/common.php';
$meta_title = "Add Assets Category - 8angle | POS  ";
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
			Add Assets Category
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>assetscategory.php">Assets Categories</a></li>
			<li class="active">Add Assets Category</li>
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
						$parent= 0;
						$description= "";
						$status= "";
						
			if(isset($_POST['AddCategory']))
				{
					 $name = ($_POST['name']);
					 $description = ($_POST['description']);
					 $status = ($_POST['status']);
					 $parent = ($_POST['parent']);
				 
					if($assetscategory->create($name,$description,$status,$parent))
					{
						$inserted ="Asset Category was added successfully";
						$name= "";
						$parent= 0;
						$description= "";
						$status= "";
					}
					else
					{
						$failure = "Error while adding Asset Category!";
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
				<form class="form-horizontal" id="formCategory"  method='post' action="">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Asset Category Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Category Name" required>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-2 control-label">Description</label>

							<div class="col-sm-4">
								<textarea class="form-control" name="description" rows="3" placeholder="Enter ..."><?php echo html_entity_decode($description); ?></textarea>
							</div>
						</div>
						<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
						<input type="hidden" class="form-control" name="parent" autocomplete="off" value="<?php echo html_entity_decode($parent); ?>">
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo BASE_URL;?>assetscategory.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="AddCategory" class="btn btn-info pull-right" value="Add">Add Asset Category</button>
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
