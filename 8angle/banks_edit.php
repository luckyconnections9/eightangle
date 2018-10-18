<?php include 'includes/common.php';
$meta_title = "Add Acoount Details - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
isCompany($company_id);
include_once 'includes/banksClass.php';
$banks = new banksClass();
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
						Add Bank
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
									$bank="";
									$branch="";
									$account_name="";
									$account_number="";
									$ifsc="";
									$remarks="";
									$status="Enable";
									
									if(isset($_POST['EditBank']))
										{
											$id= ($_POST['edit_id']);
											$bank= ($_POST['bank']);
											$branch= ($_POST['branch']);
											$account_name= ($_POST['account_name']);
											$account_number= ($_POST['account_number']);
											$ifsc=($_POST['ifsc']);
											$remarks=($_POST['remarks']);
											$status=($_POST['status']);
													 
											if($banks->update($id,$bank,$branch,$account_name,$account_number,$ifsc,$remarks,$status))
											{
												$inserted ="Bank Details was updated successfully";
											}
											else
											{
												$failure = "Error while updating Bank details!";
											}
										}
										if(isset($_GET['edit_id']) and is_numeric($_GET['edit_id']))
										{
											$id = ($_GET['edit_id']);
											$bankDetails = $crud->getID($id);
										@	$bank= html_entity_decode($bankDetails->bank);
										@	$branch= html_entity_decode($bankDetails->branch);
										@	$account_name= html_entity_decode($bankDetails->account_name);
										@	$account_number= html_entity_decode($bankDetails->account_number);
										@	$ifsc= html_entity_decode($bankDetails->ifsc);
										@	$remarks= html_entity_decode($bankDetails->remarks);
										@	$status= html_entity_decode($bankDetails->status);
										}
										?>
										<?php
										if($inserted)
										{
										 ?>
											<div class="alert alert-success alert-dismissible"><strong>WOW! </strong><?php echo $inserted ?></div>
											<script language="JavaScript" type="text/javascript">
												alert("Bank details updated");
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
										
									<form class="form-horizontal" id="formBanks" method='post' action="">
										<div class="form-group">
											<label for="bank" class="col-sm-4 control-label">Bank Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="bank" value="<?php echo html_entity_decode($bank); ?>" autocomplete="off" placeholder="Bank Name" required>
											</div>
										</div>
										<div class="form-group">
											<label for="branch" class="col-sm-4 control-label">Branch</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="branch" value="<?php echo html_entity_decode($branch); ?>" autocomplete="off" placeholder="Branch/Address" required>
											</div>
										</div>
										<div class="form-group">
											<label for="account_name" class="col-sm-4 control-label">Account Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="account_name" value="<?php echo html_entity_decode($account_name); ?>" autocomplete="off" placeholder="Account Name" required>
											</div>
										</div>
										<div class="form-group">
											<label for="account_number" class="col-sm-4 control-label">Account Number</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="account_number" value="<?php echo html_entity_decode($account_number); ?>" autocomplete="off" placeholder="a/c number" required>
											</div>
										</div>
										<div class="form-group">
											<label for="ifsc" class="col-sm-4 control-label">IFSC Code</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="ifsc" value="<?php echo html_entity_decode($ifsc); ?>" autocomplete="off" placeholder="IFSC CODE">
											</div>
										</div>
										<div class="form-group">
											<label for="remarks" class="col-sm-4 control-label">Remarks</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="remarks" value="<?php echo html_entity_decode($remarks); ?>" autocomplete="off" placeholder="">
											</div>
										</div>
										
										<div class="form-group">
											<label for="status" class="col-sm-4 control-label">Status</label>
											<div class="col-sm-8">
												<select class="form-control" name="status">
													<option value="Enable" <?php if($status == "Enable") { echo "selected"; } ?> >Enable</option>
													<option value="Disable" <?php if($status == "Disable") { echo "selected"; } ?>>Disable</option>
												 </select>
											</div>
										</div>				<!-- /.box-body -->
										<div class="box-footer">
												<button type="submit" name="EditBank" class="btn btn-info pull-right" value="Edit">Edit Bank</button>
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
