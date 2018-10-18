<?php  include 'includes/common.php';
$meta_title = "Address - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
isCompany($company_id);
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
include_once 'includes/customersClass.php';
$customers = new customersClass();
$customer_id = ($_GET['customer']);
if(isset($_GET['customer']) and $customers->getID($customer_id)) {
	$customer_id = ($_GET['customer']);
} else {
	$customer_id = 0;
}
$type=($_GET['type']);
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
		<script src="<?php echo BASE_URL;?>bower_components/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				 
				<!-- /.content -->
<script type="text/javascript">$("#load_data").load("load_invoice_addresses.php?customer=<?php echo $customer_id;?>&type=<?php echo $type;?>")</script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
				<!-- Main content -->
				<section class="content-header">
					<h1>
						Addresses
					   <small></small>
					</h1>
				</section>
				<section class="content">
							<!-- Default box -->
					<div class="box">
						<div id="load_data" class="box-body">
						
						</div>
					</div>
						<!-- /.box-body -->
				</section>
		</body></html>