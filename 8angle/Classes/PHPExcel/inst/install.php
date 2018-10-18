<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Install 8angle POS | Authorised access only!</title>
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
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

	</head>
	<body class="hold-transition register-page" onload="check_install();">
		<div id="data">
			
		<!-- /.form-box -->
		</div>
		<!-- /.register-box -->

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>
		<!-- iCheck -->
		<script type="text/javascript">
		function check_install() {
			$("#data").html('<center><i class="fa fa-spinner fa-spin" style="font-size:200px; margin-top:5%"></i><br/><i class="fa fa-spinner fa-spin" style="font-size:200px;"></i><p>Please wait while the product is being installed..</p></center>');
						$.ajax({
							type: "POST",
							url: "8angle.php",
							dataType: 'json',
							data: 'inst=1',
							success: function(data) {
								window.location.href = "register.php?inst=2";
							}
						});
				}
						
		</script>
	</body>
</html>
