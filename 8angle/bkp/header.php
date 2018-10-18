<?php $userDetails=$userClass->userDetails($session_uid); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $meta_title;?></title>
		<link rel="shortcut icon" href="<?php echo BASE_URL;?>images/favicon.png" type="image/x-icon">
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
        <?php 
			if ($invoice_js == "sale")
			{	?>
				<script type="text/javascript" src="<?php echo BASE_URL;?>js/example.js"></script>
			<?php 
			} 

			if ($invoice_js == "purchase")
			{
			?>
                 <script type="text/javascript" src="<?php echo BASE_URL;?>js/vendor.js"></script>
			<?php 
			}
			?>
		
		<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/bootstrapValidator.js"></script>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL;?>css/style.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/skins/_all-skins.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Google Font -->
		</head>
	<body class="hold-transition skin-blue  sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="index.php" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini" ><i class="fa fa-dashboard text-aqua"></i>
					</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><img src="images/logo.png" width="50%" style="max-width:100px" height="auto"/></span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
					
					<span class="icon-bar"></span>
					
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a>
			<span id="btn-po">		
				<a href="<?php echo BASE_URL;?>invoice_add.php" class="btn btn-app">
					<i class="fa fa-pencil-square-o text-green"></i> Sale Invoice
                </a>
				<a href="<?php echo BASE_URL;?>pus_invoice_add.php" class="btn btn-app">
					<i class="fa fa-pencil-square-o text-yellow"></i> Purchase
                </a>
                <a href="<?php echo BASE_URL;?>receipts.php" class="btn btn-app">
					<i class="fa  fa-money text-green"></i> Recievable
				</a>
                <a href="<?php echo BASE_URL;?>receipts.php?receipt=Purchase" class="btn btn-app">
					<i class="fa  fa-money text-yellow"></i> Payable
				</a>
				<a href="<?php echo BASE_URL;?>payexpenses.php" class="btn btn-app">
					<i class="fa  fa-binoculars text-yellow"></i> Expenses
				</a>
                <a href="<?php echo BASE_URL;?>statement.php" class="btn btn-app">
					<i class="fa  fa-calculator text-red"></i> Statement
				</a>
				<a href="<?php echo BASE_URL;?>balancesheet.php" class="btn btn-app">
					<i class="fa  fa-folder-open text-red"></i> Balancesheet
				</a>
			</span>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
						<?php  if($crud->getCount() ==  false) { ?>
							<li><a href="companies_add.php?mi=10" ><i class="fa fa-plus"></i> Add Company</a></li>
						<?php } ?>
							<li>
							<form action="" method="get" >
								<select id="mainCompany" class="form-control input-lg" name="company_id" onChange="return checkCompany(this.value)" >
									<option value="" <?php if($company_id == "") { echo "selected";}?>> Select Company </option>
									<?php 
										$stmt_comp = getDB()->prepare("SELECT * FROM companies WHERE status='Enable' AND `deleted`='N'");
										$stmt_comp->execute();
										$comp_sel = "";
										 while($data_comp=$stmt_comp->fetch(PDO::FETCH_OBJ))
										 {
											if($data_comp->id == $company_id) { $comp_sel ="selected='selected'";} else { $comp_sel = "";  }
											echo "<option  ".$comp_sel."  value=".$data_comp->id.">".$data_comp->name."</option>";
										 }
									 ?>          
								</select>
							</form>
							</li>
						
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="dist/img/avatar.png" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $userDetails->username; ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<p>
											<?php echo $userDetails->name; ?>
											<small>Member since <?php echo displaydate(substr($userDetails->created_at, 0, 10));?></small>
										</p>
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
									
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- =============================================== -->

