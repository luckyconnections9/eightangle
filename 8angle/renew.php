<?php include 'includes/common.php';
$meta_title = "Activate Product - 8angle |  ";
require('header.php');
require('left.php');
$myFile = 'includes/data/txt/date.txt';
	$redirect = "";
	$redirect2 = get_field_value('settings','value','slug','EXPIRE_DATE');
	if(!is_file($myFile)) {
		$redirect = "0000-00-00 00:00:00";
	} else {
		$redirect = file_get_contents($myFile);
	}
	if($redirect2  ==  $redirect) {
		$redirect = $redirect;
	} else {
		$redirect = date('Y-m-d h:i:s');
	}
	$current_date = new DateTime(date('Y-m-d h:i:s'));
	$exp_date = new DateTime($redirect);
	$diff = $exp_date->diff($current_date)->format('%r%a');
	if($diff <=0 AND $diff >= -30) {
			}			
	else {
			$urll = 'index.php'; echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit();
		}
$version ="Full";
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Product Activation
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Product Activation</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
			</div>
			<div class="box-body">
				
				<div class="register-box-body">
			
					<p class="login-box-msg">Enter Details to Activate </p>
					<form action="" method="post" id="formActivate">
								<!-- Company Details -->
								<div class="form-group has-feedback">
									<input type="text" class="form-control input-lg" name="masterIDReg" autocomplete="off" placeholder="Master ID" required> 
									
								</div>
								<div class="form-group has-feedback">
									<input type="text" name="serialkeyReg" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" class="form-control input-lg" required>
									<input type="hidden" name="scode" autocomplete="off" value="<?php echo  get_field_value('settings','value','slug','SCODE');?>" class="form-control input-lg" required>
									<input type="hidden"  value="<?php echo $product_type;?>" class="form-control input-lg" name="producttypeReg" autocomplete="off" placeholder="" required>
									<input type="hidden"  value="Full" class="form-control input-lg" name="versionReg" autocomplete="off" placeholder="" required>
								</div>
								<button type="submit" class="btn btn-primary btn-block"   name="activateSubmit" value="Activate">Activate</button>
								<span id="errordata"></span>
					</form>
						<!-- /.col -->
			</div>
				
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<footer class="main-footer">
			<?php days_left();?>
	</footer>
</div>
		<!-- ./wrapper -->
		<!-- jQuery 3 -->
		<script src="<?php echo BASE_URL;?>bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="<?php echo BASE_URL;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		 <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/bootstrapValidator.js"></script>
		<!-- bootstrap datepicker -->
		<script src="<?php echo BASE_URL;?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        
        <!-- ChartJS -->
		<script src="<?php echo BASE_URL;?>bower_components/chart.js/Chart.js"></script>
		<!-- SlimScroll -->
		<script src="<?php echo BASE_URL;?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo BASE_URL;?>bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo BASE_URL;?>dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo BASE_URL;?>dist/js/demo.js"></script>
		<script src="<?php echo BASE_URL;?>js/validator.js"></script>
		<script type="text/javascript">
		$("#billingAddress").val(null).trigger("change");
		</script>
		<script type="text/javascript">
function check_u() {			
					$.ajax({
							type: "POST",
							url: "http://eightangle.com/apis/checkmasteridapi.php",
							dataType: 'json',
							data: 'masterIDReg=<?php echo get_field_value('settings','value','slug','MASTER_ID');?>',
							success: function(data) {
								if(data.type == 'success' && data.errorcode == '') {
									
									$.ajax({
											type: "POST",
											url: "flush.php",
											dataType: 'json',
											data: 'masterIDReg=<?php echo get_field_value('settings','value','slug','MASTER_ID');?>&date='+data.date,
											success: function(data) {
												if(data.type == 'success') {
													window.location.href = "<?php echo BASE_URL;?>logout.php";
												} 
												else 
												{
												$("#errordata").html(data.errorcode);	
												}
											}
										});
								} 
								else 
								{}
							}
						});
}
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

