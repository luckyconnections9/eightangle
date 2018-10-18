<?php include 'includes/common.php';
$meta_title = "Add Address - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
isCompany($company_id);
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
include_once 'includes/customersClass.php';
$customers = new customersClass();
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $meta_title;?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/example.js"></script>
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
		<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="dist/css/skins/_all-skins.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Google Font -->
		<link rel="stylesheet" href="dist/css/css.css">
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<div class="content-wrapper">
				<!-- Main content -->
				<section class="content-header">
					<h1>
						Add Address
					   <small></small>
					</h1>
				</section>
				<section class="content">
							<!-- Default box -->
					<div class="box">
						<div class="box-body">
								<?php	
									$failure = "";
									$inserted = "";
									$customer_id="0";
									$name="";
									$gst_number="";
									$address="";
									$city="";
									$state="";
									$pin="";
									$status ="Enable";
									
									if(isset($_POST['EditAddress']))
										{
											$id=($_POST['edit_id']);
											$customer_id=($_POST['customer_id']);
											$name=($_POST['name']);
											$gst_number=($_POST['gst']);
											$address=($_POST['address']);
											$city=($_POST['city']);
											$state=($_POST['state']);
											$pin=($_POST['pin']);
											$status =($_POST['status']);
													 
											if($addresses->update($id,$customer_id,$name,$gst_number,$address,$city,$state,$pin,$status))
											{
												$inserted ="Address was updated successfully";
											}
											else
											{
												$failure = "Error while updating Address!";
											}
										}
										if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
										{
											$id = ($_GET['edit_id']);
											$addressDetails = $addresses->getID($id);									
										@	$customer_id=html_entity_decode($addressDetails->customer_id);
										@	$name=html_entity_decode($addressDetails->name);
										@	$gst_number=html_entity_decode($addressDetails->gst_number);
										@	$address=html_entity_decode($addressDetails->address);
										@	$city=html_entity_decode($addressDetails->city);
										@	$state=html_entity_decode($addressDetails->state);
										@	$pin=html_entity_decode($addressDetails->pin);
										@	$status =html_entity_decode($addressDetails->status);
									
										}
										?>
										<?php
										if($inserted)
										{
										 ?>
											<div class="alert alert-success alert-dismissible"><strong>WOW! </strong><?php echo $inserted ?></div>
											<script language="JavaScript" type="text/javascript">
												alert("Address updated");
												self.close();
											 </script>
											<h1> <a href="javascript:window.open('','_self').close();">close</a></h1>
										<?php
										}
										if($failure)
										{
										 ?>
											<div class="alert alert-danger alert-dismissible"><?php echo $failure ?></div>
										<?php
										}
										?>
										
									<form class="form-horizontal" id="formAddress" method='post' action="">
										<input type="hidden" class="form-control" name="customer_id" value="<?php echo html_entity_decode($customer_id); ?>">
										<?php if($customer_id) { ?>	
										<div class="form-group">
											<label for="name" class="col-sm-4 control-label">Company Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Company Name">
											</div>
										</div>
										<?php } else { ?>
											<input type="hidden" class="form-control" name="name" value="-" autocomplete="off" placeholder="">
										<?php } ?>
										<div class="form-group">
											<label for="gst" class="col-sm-4 control-label">GSTIN</label>

											<div class="col-sm-8">
												<input type="text" class="form-control text-uppercase" value="<?php echo html_entity_decode($gst_number); ?>" name="gst" id="gstin" autocomplete="off" placeholder="GSTIN"> ex:- 22AAAAA0000A1Z2
											</div>
										</div>
										<div class="form-group">
										<label for="address" class="col-sm-4 control-label">Address</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="address" value="<?php echo html_entity_decode($address); ?>" autocomplete="off" placeholder="Address">
											</div>
										</div>

										<div class="form-group">
											<label for="state" class="col-sm-4 control-label">State</label>
											<div class="col-sm-8">
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
										<label for="city" class="col-sm-4 control-label">City</label>
											<div class="col-sm-8">
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
										<label for="pin" class="col-sm-4 control-label">Pin Code</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="pin" value="<?php echo html_entity_decode($pin); ?>" autocomplete="off" placeholder="141009">
											</div>
										</div>
										<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
														<!-- /.box-body -->
										<div class="box-footer">
												<button type="submit" name="EditAddress" class="btn btn-info pull-right" value="Add">Edit Address</button>
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
