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
	if($redirect == 2) { $urll = 'activation.php'; echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); }
	if($redirect == 3) { $urll = 'users_add.php';  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); } 
	if($redirect == 4) { $urll = 'login.php';  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit(); } 
	
} else {
	$redirect = "";
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>8angle POS | Authorised access only!</title>
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
		<div class="register-box">
			<div class="register-logo">
				<a href="login.php"><b>8angle</b> Registration</a>
			</div>
			<div class="register-box-body">
				<p class="login-box-msg"></p>
				<?php if($errorMsgReg) { ?><div class="alert alert-danger alert-dismissible"><?php echo $errorMsgReg; ?></div><?php } ?>
				<form action="" method="post" id="formRegister">
					<input type="hidden"  value="<?php echo $product_type;?>" class="form-control input-lg" name="producttypeReg" autocomplete="off" placeholder="" required>
					<div class="row" >
						<div class="col-xs-6">
							<!-- Company Details -->
							<div class="form-group has-feedback">
								<input type="text" class="form-control input-lg" name="businessnameReg" autocomplete="off" placeholder="Business name" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="gstinReg" autocomplete="off" class="form-control input-lg" placeholder="GSTIN" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="contactnameReg" autocomplete="off" class="form-control input-lg" placeholder="Contact Person" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="contactnumberReg" autocomplete="off" class="form-control input-lg" placeholder="Contact Number" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="emailReg" autocomplete="off" class="form-control input-lg" placeholder="Email" >
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="referenceReg" autocomplete="off" class="form-control input-lg" placeholder="Reference" required>
							</div>
						</div>
						<div class="col-xs-6" >
							<div class="form-group has-feedback">
								<input type="text" name="addressReg" autocomplete="off" class="form-control input-lg" placeholder="Address" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="address2Reg" autocomplete="off" class="form-control input-lg" placeholder="Address (optional)">
							</div>
							<div class="form-group has-feedback">
									<select class="form-control input-lg" name="stateReg" onChange="getCity(this.value)">
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
							<div class="form-group has-feedback">
								<input type="hidden" name="countryReg" autocomplete="off" value="IND" class="form-control input-lg" placeholder="Country" required>
								<select name="cityReg" id="city" class="form-control  input-lg city"  title="Select City">
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
							<div class="form-group has-feedback">
								<input type="text" name="pinReg" autocomplete="off" class="form-control input-lg" placeholder="Pin" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" class="" name="agreeReg" value="agree" />
								 I agree Terms & conditions listed below</label>
							</div>
						</div>
					</div>
					<div class="row">
						<b>Terms & Conditions:</b>
						<div class="col-xs-12" style="max-height:150px; border:1px solid lightgray; border-radius:5px; overflow-y:scroll; color:#000000 !important;">
							<?php include('terms.php');?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
						</div>
						<div class="col-xs-4">
							<br />
							<button type="submit" class="btn btn-primary btn-block"   name="registerSubmit" value="Signup">Register</button>
						</div>
						<div class="col-xs-4">
						<br />
							<span class="col-xs-12 form-group" id="errordata"></span>
						</div>
						<!-- /.col -->
					</div>
				</form>
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
		$("#formRegister").submit(function(event){
			event.preventDefault();
			event.stopImmediatePropagation();
			$("#errordata").html('<center><i class="fa fa-spinner fa-spin" style="font-size:30px"></i></center>');
				var formData = $('#formRegister').serialize(); 
						$.ajax({
							type: "POST",
							url: "http://eightangle.com/apis/registerapi.php",
							dataType: 'json',
							data: formData,
							success: function(data) {
								if(data.type == 'success' && data.errorcode == '') {
									
									$.ajax({
											type: "POST",
											url: "check.php",
											dataType: 'json',
											data: formData+'&masterID='+data.masterID+'&scode='+data.scode+'&sent='+data.sent,
											success: function(data) {
												if(data.type == 'success') {
													window.location.href = "<?php echo BASE_URL;?>activation.php";
												} 
												else 
												{
												$("#errordata").html(data.errorcode);
												}
											}
										});
									$("#errordata").html('Registered successfully. redirecting to product activation....');
								} 
								else 
								{
									var err ="Required Fields! ";
									for(var i=0; i < data.errorcode.length; ++i) {
										if(data.errorcode[i] == 104) { err = err + '<br/> - Enter valid Email ID'; }
										if(data.errorcode[i] == 105) { err = err + '<br/> - Email ID already exists'; }
										if(data.errorcode[i] == 106) { err = err + '<br/> - Enter Referrer ID'; }
										if(data.errorcode[i] == 107) { err = err + '<br/> - Invalid Referrer ID'; }
										if(data.errorcode[i] == 112) { err = err + '<br/> - Enter GSTIN'; }
										if(data.errorcode[i] == 115) { err = err + '<br/> - GSTIN already exists'; }
										if(data.errorcode[i] == 116) { err = err + '<br/> - Please accept 8angle Terms and Conditions'; }
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
