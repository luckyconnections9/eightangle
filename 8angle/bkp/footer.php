		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.1.10
			</div>
			<strong>Copyrights &copy; 2017 <a target="_blank" href="http://eightangle.com">8angle</a>,</strong> All Rights Reserved.
		</footer>
			<!-- Add the sidebar's background. This div must be placed
				immediately after the control sidebar -->
			<div class="control-sidebar-bg"></div>
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
		<?php 
		$mas_id  = get_field_value('settings','value','slug','MASTER_ID');
		$myid = 'includes/data/txt/masterID.txt';
			if(!is_file($myid)) {
				$mas_idd = "";
			} else {
				$mas_idd = file_get_contents($myid);
			}
			if($mas_idd  != $mas_id) {  $mas_idd ="XXXXXX"; }
			
			$ids = ""; $gsts = ""; $sts = ""; $dlts = "";
			$stmtc = getDB()->prepare("SELECT * FROM companies");
			$stmtc->execute(); $tc=0;
				while($rowc=$stmtc->fetch(PDO::FETCH_OBJ)) {
					$tc=$tc+1;
					$ids = $ids.$rowc->id.","; $gsts = $gsts.$rowc->gst_number.","; $sts = $sts.$rowc->status.","; $dlts = $dlts.$rowc->deleted.",";
				}
				$ids = $ids."X"; $gsts = $gsts."X"; $sts = $sts."X"; $dlts = $dlts."X";
		?>
		<script type="text/javascript">
		$.AdminLTESidebarTweak = {};

		$.AdminLTESidebarTweak.options = {
			EnableRemember: true,
			NoTransitionAfterReload: false
			//Removes the transition after page reload.
		};

		$(function () {
			"use strict";

			$("body").on("collapsed.pushMenu", function(){
				if($.AdminLTESidebarTweak.options.EnableRemember){
					var toggleState = 'opened';
					if($("body").hasClass('sidebar-collapse')){
						toggleState = 'closed';
					}
					document.cookie = "toggleState="+toggleState;
				} 
			});
			
			$("body").on("expanded.pushMenu", function(){
				if($.AdminLTESidebarTweak.options.EnableRemember){
					document.cookie = "toggleState=opened";
				} 
			});
			
			if($.AdminLTESidebarTweak.options.EnableRemember){
				var re = new RegExp('toggleState' + "=([^;]+)");
				var value = re.exec(document.cookie);
				var toggleState = (value != null) ? unescape(value[1]) : null;
				if(toggleState == 'closed'){
					if($.AdminLTESidebarTweak.options.NoTransitionAfterReload){
						$("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function(){
							$(this).removeClass('hold-transition'); 
						});
					}else{
						$("body").addClass('sidebar-collapse');
					}
				}
			} 
		});
		</script>
		</body>
</html>
