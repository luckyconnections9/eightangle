<?php include 'includes/common.php';
$meta_title = "Edit Expenses - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/expensesClass.php';
$expenses = new expensesClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Edit Expenses
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>expenses.php">Expenses</a></li>
			<li class="active">Edit Expense</li>
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
						$expenses_category_id = 0;
						$name_on_check = "";
						$bank_name = "";
						$check_or_account_number = "";
						$exp_type = "Pre-Paid";
						
				if(isset($_POST['EditExpense']))
					{
						$id = ($_GET['edit_id']);
					 	$name = ($_POST['name']);
						$amt = ($_POST['amt']);
						$reason = ($_POST['reason']);
						$paidby = ($_POST['paidby']);
						$pay_date = ($_POST['pay_date']);
						$description = ($_POST['description']);
						$status = ($_POST['status']);
						$expenses_category_id = ($_POST['expenses_category_id']);
						$name_on_check = ($_POST['name_on_check']);
						$bank_name = ($_POST['bank_name']);
						$check_or_account_number = ($_POST['check_or_account_number']);
						$exp_type = ($_POST['exp_type']);
												
						if($expenses->update($id,$name,$amt,$reason,$paidby,$pay_date,$description,$status,$expenses_category_id,$name_on_check,$bank_name,$check_or_account_number,$exp_type))
						{
							$inserted ="Expense was Edited/Updated successfully";
						}
						else
						{
							$failure = "Error while Editing/Updating Expense!";
						}
					}
					if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
					{
						$id = ($_GET['edit_id']);
						$expensesDetails = $expenses->getID($id); 				
					@	$name= $expensesDetails->name;
					@	$amt= $expensesDetails->amt;
					@	$reason= $expensesDetails->reason;
					@	$paidby= $expensesDetails->paidby;
					@	$pay_date= $expensesDetails->pay_date;
					@	$description= $expensesDetails->description;
					@	$status= $expensesDetails->status;
					@	$expenses_category_id = ($expensesDetails->expenses_category_id);
					@	$name_on_check = ($expensesDetails->name_on_check);
					@	$bank_name = ($expensesDetails->bank_name);
					@	$check_or_account_number = ($expensesDetails->check_or_account_number);
						if($paidby == "Cash") {
							$name_on_check = "";
							$bank_name = "";
							$check_or_account_number = "";
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
			<form class="form-horizontal"   id="formExpenses"  method='post' action="">
						<div class="form-group">
                        <label class="col-sm-3 control-label">Select Expense Type</label>
                            <div class="col-sm-4">
                                <div class="radio  col-sm-6">
                                   <label>
                                        <input type="radio" name="exp_type" <?php if($exp_type == "Pre-Paid") { echo "checked"; } ?> id="exp_type" value="Pre-Paid" /> Pre-Paid</label>
                                     
                                </div>
                                <div class="radio col-sm-6">
                                      <label>
                                        <input type="radio"  <?php if($exp_type == "Post-Paid") { echo "checked"; } ?>  name="exp_type"  id="exp_type" value="Post-Paid" /> Post-Paid </label>
                                 
                                </div>
                            </div>
							</div>
						
						<div class="form-group">
						<label for="Expenses category" class="col-sm-3 control-label">Expense Type</label>
							<div class="col-sm-4">
								<select class="form-control" name="expenses_category_id">
									<option value="0">Select Expense Type</option>
									<?php 
										$stmt_cats = getDB()->prepare("SELECT * FROM expenses_category WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
											$stmt_cats->execute();
											$cat_sel="";
										 while($dataa=$stmt_cats->fetch(PDO::FETCH_OBJ))
										 {
											if($dataa->id == $expenses_category_id) { $cat_sel ="selected='selected'";}  else { $cat_sel ="";}
											echo "<option  ".$cat_sel."  value=".$dataa->id.">".$dataa->name."</option>";
										 }
									 ?>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Expense Name</label>
								<div class="col-sm-4">
						<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Expense Name" required>
								</div>
						</div>

							<div class="form-group">
							<label for="amt" class="col-sm-3 control-label">Amount</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="amt" value="<?php echo html_entity_decode($amt); ?>" autocomplete="off" placeholder="Amount" required>
								</div>
							</div>

							<div class="form-group">
							<label for="reason" class="col-sm-3 control-label">Reason</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="reason" value="<?php echo html_entity_decode($reason); ?>" autocomplete="off" placeholder="Reason">
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
			  	         	<div class="form-group">
							<label for="status" class="col-sm-3 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control" name="status">
									<option value="Enable" <?php if($status == "Enable") { echo "selected"; } ?> >Enable</option>
									<option value="Disable" <?php if($status == "Disable") { echo "selected"; } ?>>Disable</option>
								</select>
							</div>
				</div>
								<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo BASE_URL;?>expenses.php" class="btn btn-default">Cancel</a>
						<button type="submit" name="EditExpense" class="btn btn-info pull-right" value="Edit">Edit Expense</button>
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
