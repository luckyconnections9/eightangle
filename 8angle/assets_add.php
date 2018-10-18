<?php include 'includes/common.php';
$meta_title = "Add Assets - 8angle |  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/assetsClass.php';
$assets = new assetsClass();
?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Add Asset
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>assets.php">Assets</a></li>
			<li class="active">Add Asset</li>
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
						$amt= "";
						$reason= "";
						$paidby= "";
						$pay_date= "";
						$description= "";
						$status= "";
						$assets_category_id = 0;
						$name_on_check = "";
						$bank_name = "";
						$check_or_account_number = "";
						
						if(isset($_POST['AddAsset']))
							{
								 $name = ($_POST['name']);
								 $amt = ($_POST['amt']);
								 $reason = ($_POST['reason']);
								 $paidby = ($_POST['paidby']);
								 $pay_date = ($_POST['pay_date']);
								 $description = ($_POST['description']);
								 $status = ($_POST['status']);
								 $assets_category_id = ($_POST['assets_category_id']);
								 $name_on_check = ($_POST['name_on_check']);
								 $bank_name = ($_POST['bank_name']);
								 $check_or_account_number = ($_POST['check_or_account_number']);
										 
								if($assets->create($name,$amt,$reason,$paidby,$pay_date,$description,$status,$assets_category_id,$name_on_check,$bank_name,$check_or_account_number))
								{
									$inserted ="Asset was added successfully";
								}
								else
								{
									$failure = "Error while adding Asset!";
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
							
						<form class="form-horizontal" id="formAssets" method='post' action="">
							<div class="form-group">
						<label for="Asset category" class="col-sm-3 control-label">Asset Type</label>
							<div class="col-sm-4">
								<select class="form-control" name="assets_category_id">
									<option value="0">Select Asset Type</option>
									<?php 
										$stmt_cats = getDB()->prepare("SELECT * FROM assets_category WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
											$stmt_cats->execute();
											$cat_sel="";
										 while($dataa=$stmt_cats->fetch(PDO::FETCH_OBJ))
										 {
											if($dataa->id == $assets_category_id) { $cat_sel ="selected='selected'";}  else { $cat_sel ="";}
											echo "<option  ".$cat_sel."  value=".$dataa->id.">".$dataa->name."</option>";
										 }
									 ?>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Asset Name</label>
								<div class="col-sm-4">
						<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Asset Name" required>
								</div>
						</div>

							<div class="form-group">
							<label for="amt" class="col-sm-3 control-label">Amount</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="amt" value="<?php echo html_entity_decode($amt); ?>" autocomplete="off" placeholder="Amount" required>
								</div>
							</div>

							<div class="form-group">
							<label for="reason" class="col-sm-3 control-label">For</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="reason" value="<?php echo html_entity_decode($reason); ?>" autocomplete="off" placeholder="For">
								</div>
							</div>
							
						<div class="form-group">
							<label for="paidby" class="col-sm-3 control-label">Paid by</label>
							<div class="col-sm-4">
								<select class="form-control"  onChange="checkPaidby(this.value)" name="paidby">
									<option value="Check"  <?php if($paidby == "Check") { echo "selected"; } ?>>Check/Draft</option>
									<option value="Cash"  <?php if($paidby == "Cash") { echo "selected"; } ?>>Cash</option>
                                    <option value="Credit Card"  <?php if($paidby == "Credit Card") { echo "selected"; } ?>>Credit Card</option>
                                    <option value="Bank Transfer"  <?php if($paidby == "Bank Transfer") { echo "selected"; } ?>>Bank Transfer</option>
								 </select>
							</div>
						</div>
    
                        	<div class="form-group">
							<label for="pay_date" class="col-sm-3 control-label">Paid Date</label>
								<div class="col-sm-4">
									<input type="text" class="form-control"  id="datepicker"  name="pay_date" value="<?php echo html_entity_decode(substr($pay_date,0 ,10)); ?>" autocomplete="off" placeholder="Paid Date">
								</div>
							</div>
							
							<div class="form-group">
							<label for="description" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="description" value="<?php echo html_entity_decode($description); ?>" autocomplete="off" placeholder="Description">
								</div>
							</div>
							<span id="hide_data">							
								<div class="form-group">
								<label for="" class="col-sm-3 control-label"></label>
									<div class="col-sm-4">
										If payment by Check/credit card/Bank Transfer enter below details
									</div>
								</div>
								<div class="form-group">
								<label for="name_on_check" class="col-sm-3 control-label">Account/Card holder Name</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="name_on_check" value="<?php echo $name_on_check; ?>"  autocomplete="off" placeholder="Lucky Companies">
									</div>
								</div>
								<div class="form-group">
								<label for="check_or_account_number" class="col-sm-3 control-label">Account/Credit card/Check Number</label>
									<div class="col-sm-4">
										<input type="text" class="form-control"  value="<?php echo $check_or_account_number; ?>"   name="check_or_account_number" autocomplete="off" placeholder="657986">
									</div>
								</div>
								
								<div class="form-group">
								<label for="Bank Name" class="col-sm-3 control-label">Bank Name</label>
									<div class="col-sm-4">
										<input type="text" class="form-control"  value="<?php echo $bank_name; ?>"  name="bank_name" autocomplete="off" placeholder="ICICI bank">
									</div>
								</div>
							</span>
			  	         	<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
											<!-- /.box-body -->
							<div class="box-footer">
								<a href="<?php echo BASE_URL;?>assets.php" class="btn btn-default">Cancel</a>
									<button type="submit" name="AddAsset" class="btn btn-info pull-right" value="Add">Add Asset</button>
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
