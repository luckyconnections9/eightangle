<?php include 'includes/common.php';
$meta_title = "Add Vendor - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/vendorsClass.php';
$vendors = new vendorsClass();
?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Add Vendor
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>vendors.php">Vendors</a></li>
			<li class="active">Add Vendor</li>
		</ol>
    </section>
<section class="content">
		<!-- Default box -->
<div class="box">
<div class="box-body">
		<?php	
			$failure = "";
			$inserted = "";
						$biz_name="";
						$c_name= "";
						$gst_num= "";
						$phone= "";
						$email= "";
						$address= "";
						$city= 0;
						$state= "";
						$status= "";
						$pin ="";
			if(isset($_POST['AddVendor']))
				{
					 $biz_name = ($_POST['biz_name']);
					 $c_name = ($_POST['c_name']);
					 $gst_num = strtoupper($_POST['gst_num']);
					 $phone = ($_POST['phone']);				 					 
					 $email = ($_POST['email']);
					 $address = ($_POST['address']);
					 $city = ($_POST['city']);
					 $state = ($_POST['state']);
					 $status = ($_POST['status']);
					 $pin = ($_POST['pin']);
					 		 
					if($vendors->create($biz_name,$c_name,$gst_num,$phone,$email,$address,$city,$state,$status,$pin))
					{
						$inserted ="Vendor was added successfully";
					}
					else
					{
						$failure = "Error while adding Vendor!";
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
                
				<form class="form-horizontal" id="formVendors"  method='post' action="">
					<div class="form-group">
					<label for="biz_name" class="col-sm-2 control-label">Company Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="biz_name" value="<?php echo html_entity_decode($biz_name); ?>" autocomplete="off" placeholder="ABCD Comapny" required>
						</div>
					</div>

					<div class="form-group">
					<label for="c_name" class="col-sm-2 control-label">Contact Person</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="c_name" value="<?php echo html_entity_decode($c_name); ?>" autocomplete="off" placeholder="Contact Person">
						</div>
					</div>

					<div class="form-group">
					<label for="gst_num" class="col-sm-2 control-label">GSTIN</label>
						<div class="col-sm-4">
							<input type="text" class="form-control text-uppercase" name="gst_num" value="<?php echo html_entity_decode($gst_num); ?>" autocomplete="off" placeholder="GSTIN">  ex:- 22AAAAA0000A1Z2
						</div>
					</div>
					
					<div class="form-group">
					<label for="phone" class="col-sm-2 control-label">Phone</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" autocomplete="off" placeholder="9876543210">
						</div>
					</div>

					<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="email" value="<?php echo html_entity_decode($email); ?>" autocomplete="off" placeholder="Email ID">
						</div>
					</div>

					<div class="form-group">
					<label for="address" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="address" value="<?php echo html_entity_decode($address); ?>" autocomplete="off" placeholder="Address">
						</div>
					</div>

					<div class="form-group">
						<label for="state" class="col-sm-2 control-label">State</label>
						<div class="col-sm-4">
							<select class="form-control" name="state" onChange="getCity(this.value)">
								<option value="">Select State</option>
								<?php 
									$stmt_state = getDB()->prepare("SELECT * FROM `city` WHERE `CountryCode`='IND' GROUP BY `District` ORDER BY `District` ASC");
									$stmt_state->execute();
									$state_sel = "";
									 while($data_state=$stmt_state->fetch(PDO::FETCH_OBJ))
									 {
										if($data_state->District == $state) { $state_sel ="selected='selected'";} else { $state_sel ="";}
										echo "<option ".$state_sel." value=".$data_state->District.">".$data_state->District."</option>";
									 }
								 ?>
							 </select>
						</div>
					</div>
					<div class="form-group">
					<label for="city" class="col-sm-2 control-label">City</label>
						<div class="col-sm-4">
							<select name="city" id="city" class="form-control city"  title="Select City">
								<option value="0">Select City</option>
								<?php
								$stmt_city = getDB()->prepare("SELECT * FROM `city` WHERE `District`='$state' ORDER BY `Name` ASC");
								$stmt_city->execute();	
								$city_sel = "";
								 while($data_city=$stmt_city->fetch(PDO::FETCH_OBJ))
									{
									if($data_city->ID == $city) { $city_sel ="selected='selected'";}  else { $city_sel ="";}
									echo "<option ".$city_sel." value=".$data_city->ID.">".$data_city->Name."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="pin" class="col-sm-2 control-label">Pin Code</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pin" value="<?php echo html_entity_decode($pin); ?>" autocomplete="off" placeholder="141009">
							</div>
					</div>
					<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
									<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo BASE_URL;?>vendors.php" class="btn btn-default">Cancel</a>
							<button type="submit" name="AddVendor" class="btn btn-info pull-right" value="Add">Add Vendor</button>
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
