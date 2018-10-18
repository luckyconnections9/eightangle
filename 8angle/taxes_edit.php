<?php include 'includes/common.php';
$meta_title = "Edit Tax - 8angle | POS  ";
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
			Edit Taxes
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>taxes.php">Taxes</a></li>
			<li class="active">Edit Tax</li>
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
						$tax= "";
						$cgst= "";
						$sgst= "";
						$status= "";
						
				if(isset($_POST['EditTax']))
					{
							$id = ($_GET['edit_id']);
					 		$name = ($_POST['name']);
					 		$tax = ($_POST['tax']);
					 		$cgst = ($_POST['cgst']);
					 		$sgst = ($_POST['sgst']);
					 		$status = ($_POST['status']);
						
						if($taxes->update($id,$name,$tax,$cgst,$sgst,$status))
						{
							$inserted ="Tax was Edited/Updated successfully";
						}
						else
						{
							$failure = "Error while Editing/Updating Tax!";
						}
					}
					if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
					{
						$id = ($_GET['edit_id']);
						$taxesDetails = $taxes->getID($id); 				
					@	$name= $taxesDetails->name;
					@	$tax= $taxesDetails->tax;
					@	$cgst= $taxesDetails->cgst;
					@	$sgst= $taxesDetails->sgst;
					@	$status= $taxesDetails->status;
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
			<form class="form-horizontal"   id="formTaxes"  method='post' action="">
				
						
						<input type="hidden" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Tax Name">

							<div class="form-group">
							<label for="tax" class="col-sm-2 control-label">IGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="tax" name="tax" onBlur="return setTaxes(this.value)" value="<?php echo html_entity_decode($tax); ?>" autocomplete="off" placeholder="10" required>
								</div>
							</div>

							<div class="form-group">
							<label for="cgst" class="col-sm-2 control-label">CGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="cgst" id="cgst" value="<?php echo html_entity_decode($cgst); ?>" autocomplete="off" placeholder="5" readonly>
								</div>
							</div>
							
							<div class="form-group">
							<label for="sgst" class="col-sm-2 control-label">SGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="sgst" id="sgst" value="<?php echo html_entity_decode($sgst); ?>" autocomplete="off" placeholder="5" readonly>
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
					<a href="<?php echo BASE_URL;?>taxes.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="EditTax" class="btn btn-info pull-right" value="Edit">Edit Tax</button>
				</div>
								<!-- /.box-footer -->
			</form>				
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<script language="javascript" type="text/javascript">
	function setTaxes(val)
	{	
		v = Number(val); 
		half = Number(v/2); 
		if (!isNaN(parseFloat(val)) && isFinite(val)) {
			document.getElementById('cgst').value = half;
			document.getElementById('sgst').value = half;
		} else {
			document.getElementById('tax').value = '';
			document.getElementById('cgst').value = 0;
			document.getElementById('sgst').value = 0;
			//alert("Enter tax in numbers");
		}
	}
</script>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
