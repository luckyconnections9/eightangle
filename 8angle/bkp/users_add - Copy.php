<?php include 'includes/common.php';
$meta_title = "8angle - Add Application User ";
require('header.php');
require('left.php');
?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Add Application User
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>companies.php">Users</a></li>
			<li class="active">Add User</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
		<?php	
			$failure = "";
			$inserted = "";
			$errorMsgReg='';

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
	$uid=$userClass->userAdd($username,$password,$email,$name);
	if($uid)
	{	
	$url=BASE_URL.'users_management.php';
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=users_management.php?created=Y">'; 
	exit();
	header("Location: $url"); // Page redirecting to home.php 
	}
	else
	{
	$errorMsgReg="Username or Email already exists.";
	}
	}
}
?>

				<?php if($errorMsgReg) { ?><div class="alert alert-danger alert-dismissible"><?php echo $errorMsgReg; ?></div><?php } ?>
				<form class="form-horizontal" id="formUsers"  method='post' action="" enctype="multipart/form-data">
				<div class="box-body">
					<div class="col-sm-6" solid lightgray">
						<div class="form-group has-feedback">
							<input type="text" class="form-control input-lg" value=""  name="nameReg" autocomplete="off" placeholder="Full name" required>
							<span class="glyphicon glyphicon-user form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="text" name="usernameReg" autocomplete="off" class="form-control input-lg" placeholder="Username" required>
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="text" name="emailReg" value="" autocomplete="off" class="form-control input-lg" placeholder="Email" >
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
					</div>	
				</div>	
				</form>

			</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>