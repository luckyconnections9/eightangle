<?php include 'includes/common.php';
$meta_title = "Edit Category - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/categoryClass.php';
$category = new categoryClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Edit Category
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>category.php">Categories</a></li>
			<li class="active">Edit Category</li>
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
						
				if(isset($_POST['EditCategory']))
					{
						$id = ($_GET['edit_id']);
						$name = ($_POST['name']);
						$parent = ($_POST['parent']);
						$description = ($_POST['description']);
						$status = ($_POST['status']);
					 
						if($category->update($id,$name,$description,$status,$parent))
						{
							$inserted ="Category was updated successfully";
						}
						else
						{
							$failure = "Error while updating Category!";
						}
					}
					if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
					{
						$id = ($_GET['edit_id']);
						$categoryDetails = $category->getID($id); 
					@	$name= $categoryDetails->name;
					@	$parent= html_entity_decode($categoryDetails->parent);
					@	$description= $categoryDetails->description;
					@	$status= html_entity_decode($categoryDetails->status);
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
				<form class="form-horizontal"  id="formCategory"  method='post' action="">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Category Name</label>
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
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control" name="status">
									<option value="Enable" <?php if($status == "Enable") { echo "selected"; } ?> >Enable</option>
									<option value="Disable" <?php if($status == "Disable") { echo "selected"; } ?>>Disable</option>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label for="parent" class="col-sm-2 control-label">Parent</label>
							<div class="col-sm-4">
								<select class="form-control" name="parent">
									<option value="0">Select Parent Category</option>
									<?php 
										$stmt_cats = getDB()->prepare("SELECT * FROM category WHERE status='Enable' and id != $id AND  `company_id` = $company_id  AND `deleted`='N'");
										$stmt_cats->execute();
										$cat_sel = "";
										 while($dataa=$stmt_cats->fetch(PDO::FETCH_OBJ))
										 {
											 if($dataa->id == $parent) { $cat_sel ="selected='selected'";}  else { $cat_sel ="";}
											echo "<option ".$cat_sel." value=".$dataa->id.">".$dataa->name."</option>";
										 }
									 ?>
								 </select>
							</div>
						</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo BASE_URL;?>category.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="EditCategory" class="btn btn-info pull-right" value="Edit">Edit Category</button>
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
