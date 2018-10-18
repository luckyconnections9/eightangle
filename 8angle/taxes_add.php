<?php include 'includes/common.php';
$meta_title = "Add Taxes - 8angle | POS  ";
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
			Add Taxes
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>taxes.php">Taxes</a></li>
			<li class="active">Add Tax</li>
		</ol>
    </section>
	<section class="content">
				<!-- Default box -->
		<div class="box">
			<div class="box-body">
					<?php	
						$failure = "";
						$inserted = "";
						$name = "";
						$tax = "";
						$cgst = 0;
						$sgst = 0;
						$status = "Enable";
						
						if(isset($_POST['AddTax']))
							{
								 $name = ($_POST['name']);
								 $tax = ($_POST['tax']);
								 $cgst = ($_POST['cgst']);
								 $sgst = ($_POST['sgst']);
								 $status = ($_POST['status']);
										 
								if($taxes->create($name,$tax,$cgst,$sgst,$status))
								{
									$inserted ="Tax was added successfully";
								}
								else
								{
									$failure = "Error while adding Tax!";
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
							
				<form class="form-horizontal" id="formTaxes"  method='post' action="">
							<input type="hidden" class="form-control" name="name" autocomplete="off" placeholder="Tax Name">
							
							<div class="form-group">
							<label for="tax" class="col-sm-2 control-label">IGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" onBlur="return setTaxes(this.value)" name="tax"  id="tax" autocomplete="off" value="<?php echo $tax; ?>" placeholder="TAX" required>
								</div>
							</div>

							<div class="form-group">
							<label for="cgst" class="col-sm-2 control-label">CGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" value="<?php echo $cgst; ?>" name="cgst"  id="cgst" autocomplete="off" placeholder="CGST" readonly>
								</div>
							</div>
							
							<div class="form-group">
							<label for="sgst" class="col-sm-2 control-label">SGST (%)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" value="<?php echo $sgst; ?>" name="sgst" id="sgst"  autocomplete="off" placeholder="SGST" readonly>
								</div>
							</div>
						<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
						
											<!-- /.box-body -->
							<div class="box-footer">
								<a href="<?php echo BASE_URL;?>taxes.php" class="btn btn-default">Cancel</a>
									<button type="submit" name="AddTax" class="btn btn-info pull-right" value="Add">Add Tax</button>
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
