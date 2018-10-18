<?php include 'includes/define.php'; 
include 'function.php';
include('includes/userClass.php');
$userClass = new userClass();
$errorMsgReg='';

if($userClass->getCount() == true) { $urll = 'login.php';
		
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">';
		exit(); }
if (!empty($_POST['signupSubmit']))
{
	$username=$_POST['usernameReg'];
	$email=$_POST['emailReg'];
	$password=$_POST['passwordReg'];
	$name=$_POST['nameReg'];
	/* Regular expression check */
	$username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

	if($username_check && $email_check && $password_check && strlen(trim($name))>0)
	{
	$uid=$userClass->userRegistration($username,$password,$email,$name);
	if($uid)
	{
	
	$url=BASE_URL.'index.php';
	header("Location: $url"); // Page redirecting to home.php 
	}
	else
	{
	$errorMsgReg="Username or Email already exists.";
	}
	}
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
				<a href="login.php"><b>POS</b> Admin</a>
			</div>
			<div class="register-box-body">
				<p class="login-box-msg">Create User to Login</p>
				<?php if($errorMsgReg) { ?><div class="alert alert-danger alert-dismissible"><?php echo $errorMsgReg; ?></div><?php } ?>
				<form action="" method="post">
					<div class="form-group has-feedback">
						<input type="text" class="form-control input-lg" value="<?php echo  get_field_value('settings','value','slug','CONTACT_NAME');?>"  name="nameReg" autocomplete="off" placeholder="Full name" required>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="text" name="usernameReg" autocomplete="off" class="form-control input-lg" placeholder="Username" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="text" name="emailReg" value="<?php echo  get_field_value('settings','value','slug','EMAIL');?>" autocomplete="off" class="form-control input-lg" placeholder="Email" >
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password"  name="passwordReg" autocomplete="off" class="form-control  input-lg" placeholder="password" required>
						<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat"  name="signupSubmit" value="Signup">Signup</button>
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
	</body>
</html>
