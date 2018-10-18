<?php include 'includes/define.php';
include 'function.php';
$errorMsgReg='';
$city= 0;
$state= "";
$myFile = 'includes/data/txt/register.txt';
$redirect = "";
$redirect2 = get_field_value('settings','value','slug','REGISTER');
if(!is_file($myFile)) {
	$redirect = "";
} else {
	$redirect = file_get_contents($myFile);
}
if($redirect == $redirect2)	{
	
	if($redirect == 3) { $urll = 'users_add.php';  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); } 
	if($redirect == 4) { $urll = 'login.php';  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); } 
	if($redirect == 2) {
		
	}
		
} else {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=register.php">';  exit();
	$redirect = "";
}
if(!$redirect) { $urll = 'register.php';  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); } 

$version ="Full"; $show ="";
if(isset($_GET['ver'])) {
	$version = mysql_real_escape_string($_GET['ver']);
	$show = "1";
}
if($version == "Trial" OR $version=="Full") {
	$version = $version;
}

$myFile2 = 'includes/data/txt/version.txt';
if(!is_file($myFile)) {
	$cont = "";
} else {
	$cont = file_get_contents($myFile2);
}
if($cont) {
	$version ="Full"; $show ="1";
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>8angle POS Activation| Authorised access only!</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

		  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		  <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		  <![endif]-->

		  <!-- Google Font -->
	</head>
	<body class="hold-transition register-page">
		<div class="register-box" style="max-width:360px !important">
			<div class="register-logo">
				<a href="login.php"><b>8angle</b> Activation</a>
			</div>
			<div class="register-box-body">
			<?php if(!$show) { ?>
				<div class="row">
				<div class="col-sm-6">
					<center><input type="radio"  name="ver" class="btn btn-primary" onClick="window.location.href='activation.php?ver=Trial'"><br/><b>Trial Version</b><br/>
					30 day(s)
					</center>
				</div>
				
				<div class="col-sm-6">
					<center><input type="radio"  name="ver" class="btn btn-primary"  onclick="window.location.href='activation.php?ver=Full'"><br/><b>Full version</b><br/>
					365 day(s)</center>
				</div>
			</div>
			<?php } ?>
			<?php if($show) { ?>
				<div class="col-sm-12"><center><b style="padding:1%;">
				<?php if($version == "Trial") { echo "You are registering for Trail Version"; } ?>
				<?php if($version == "Full") { echo "Continue to Full Version"; } ?></b></center>
				</div>
				<p class="login-box-msg">Enter Details to Activate </p>
				<?php if($errorMsgReg) { ?><div class="alert alert-danger alert-dismissible"><?php echo $errorMsgReg; ?></div><?php } ?>
				<form action="" method="post" id="formActivate">
							<!-- Company Details -->
							<div class="form-group has-feedback">
								<input type="text" class="form-control input-lg" name="masterIDReg" autocomplete="off" placeholder="Master ID" required> 
								
							</div>
							<?php if($version == "Trial") { ?>
							<input type="hidden" name="serialkeyReg" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" class="form-control input-lg" value="XXXX-XXXX-XXXX-XXXX"; required>
								<input type="hidden" name="scode" autocomplete="off" value="<?php echo  get_field_value('settings','value','slug','SCODE');?>" class="form-control input-lg" required>
								<input type="hidden"  value="<?php echo $product_type;?>" class="form-control input-lg" name="producttypeReg" autocomplete="off" placeholder="" required>
								<input type="hidden"  value="Trial" class="form-control input-lg" name="versionReg" autocomplete="off" placeholder="" required>
							<?php } ?>
							<?php if($version == "Full") { ?>
							<div class="form-group has-feedback">
								<input type="text" name="serialkeyReg" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" class="form-control input-lg" required>
								<input type="hidden" name="scode" autocomplete="off" value="<?php echo  get_field_value('settings','value','slug','SCODE');?>" class="form-control input-lg" required>
								<input type="hidden"  value="<?php echo $product_type;?>" class="form-control input-lg" name="producttypeReg" autocomplete="off" placeholder="" required>
								<input type="hidden"  value="Full" class="form-control input-lg" name="versionReg" autocomplete="off" placeholder="" required>
							</div>
							<?php } ?>
							<button type="submit" class="btn btn-primary btn-block"   name="activateSubmit" value="Activate">Activate</button>
							<span id="errordata"></span>
				</form>
				<?php } ?>
						<!-- /.col -->
			</div>
		<!-- /.form-box -->
		</div>
		<!-- /.register-box -->

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>
		<!-- iCheck -->
		<script src="<?php echo BASE_URL;?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

		<script src="dist/js/adminlte.min.js"></script>
		
		<script src="js/validator.js"></script>
		<script type="text/javascript">
		$("#formActivate").submit(function(event){
			event.preventDefault();
			event.stopImmediatePropagation();
				$("#errordata").html('<center><i class="fa fa-spinner fa-spin" style="font-size:30px"></i></center>');
						var formData = $('#formActivate').serialize(); 
						$.ajax({
							type: "POST",
							url: "http://eightangle.com/apis/activationapi.php",
							dataType: 'json',
							data: formData,
							success: function(data) {
								if(data.type == 'success' && data.errorcode == '') {
									
									$.ajax({
											type: "POST",
											url: "activate.php",
											dataType: 'json',
											data: formData+'&sc='+data.scode,
											success: function(data) {
												if(data.type == 'success') {
													window.location.href = "<?php echo BASE_URL;?>users_add.php";
												} 
												else 
												{
												$("#errordata").html(data.errorcode);	
												}
											}
										});
								$("#errordata").html('Activation completed.');
								} 
								else 
								{
									var err ="Required Fields! ";
									for(var i=0; i < data.errorcode.length; ++i) {
										if(data.errorcode[i] == 101) { err = err + '<br/> - Invalid Master ID'; }
										if(data.errorcode[i] == 102) { err = err + '<br/> - Invalid Serial Key'; }
									}
									$("#errordata").html(err);
								}
							}
						});
						return false;
		});
						
		</script>
	</body>
</html>
