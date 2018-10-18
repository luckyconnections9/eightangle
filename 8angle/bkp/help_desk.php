<?php include 'includes/common.php';
$meta_title = "Help Desk - 8angle | POS  ";
require('header.php');
require('left.php'); ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Help Desk</h3>
			</div>
			<div class="col-sm-12">
			<?php
				if($isCompany) { echo $isCompany; }
			?>
			</div>
			<div class="box-body">
					<div class="col-sm-12">
						<iframe width="100%" height="600px" src="http://eightangle.com/help_desk/"></iframe>
					</div>
			</div>
		
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
