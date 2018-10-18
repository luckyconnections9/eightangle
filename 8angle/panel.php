<?php include 'includes/common.php'; 
$meta_title = "Dashboard - 8angle | POS  ";
require('header.php');
require('left.php');
$company_data = $crud->getID($company_id);
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Dashboard</h3>
			</div>
			<div class="col-sm-12">
			<?php
				if($isCompany) { echo $isCompany; }
				
			$iractivities = 'includes/data/txt/activities.txt';
			if(!is_file($iractivities)) {
				$iractivity = "";
			} else {
				$iractivity = file_get_contents($iractivities);
			}
			if($iractivity) {
				echo "<div  style='background-color:red; padding:15px; margin:15px; border-radius:4px;' class='alert-danger'><strong></strong> Irregular Activities ! <br /> Looks like someone else is using same MasterID. if you do not take any action your subscription will be suspended.</div>";
			}
			
			?>
			</div>
			<div class="box-body">
				<div class="col-sm-12">
				<a href="<?php echo BASE_URL;?>receivable.php" class="btn btn-app">
					<i class="fa fa-money text-yellow"></i> A/C Receivable
                </a>
                <a href="<?php echo BASE_URL;?>customers.php?mi=2" class="btn btn-app">
					<i class="fa  fa-users text-green"></i> Customers
				</a>
				<a href="<?php echo BASE_URL;?>products.php" href="products.php" class="btn btn-app">
					<i class="fa fa-cube text-aqua"></i> Products
				</a>
				<a href="<?php echo BASE_URL;?>invoice.php" class="btn btn-app">
					<i class="fa fa-pencil-square-o text-green"></i> Sale Invoice
				</a>
				<a href="<?php echo BASE_URL;?>vendors.php" class="btn btn-app">
					<i class="fa  fa-university text-aqua"></i> Vendors
				</a>	
				<a href="<?php echo BASE_URL;?>payable.php" class="btn btn-app">
                    <i class="fa  fa-users text-yellow"></i> A/C Payable
                </a>
				<a href="<?php echo BASE_URL;?>balancesheet.php" class="btn btn-app">
                     <i class="fa fa-calculator text-red"></i> Balancesheet
				</a>				
				</div>

				<div class="col-sm-12 well well-sm" style="margin-top:5%">
						<center><?php if(!empty($company_data->logo) and file_exists('uploads/logo/'.$company_data->logo) ) { ?>
									<img src="uploads/logo/<?php echo $company_data->logo; ?>" width="200px"/>
						</center>
            		
				<?php } ?> 
			</div>
				
					
			</div>  
			<!-- /.box-body -->
		
		</div>
   
		<!-- /.bar chart -->      
		<div class="box-footer">
			<div class="row">

				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
                    <div class="small-box bg-black">
						<h3> + 8angle</h3>   
						<div class="inner">
							<p> India's #1 Leading Software</p>
						</div>
						<div class="icon">
                            <i class="fa  fa-check-circle text-white"></i>
                        </div>
                    </div>
               </div> 
				<div class="col-lg-3 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3>Help</h3>
							 <p>Knowledgebase</p>
						</div>
						<div class="icon">
						<a style="cursor: pointer;"
  onclick="window.open('http://eightangle.com/help_desk/','',' scrollbars=yes,width=1000, resizable=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0').focus()"><i class="fa fa-life-buoy"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3>System</h3>
							 <p>Beta version released!</p>
						</div>
						<div class="icon">
							<a href="#"><i class="fa fa-database"></i></a>
						</div>
					</div>
				</div>
				
					<div class="col-lg-3 col-xs-6">
					<!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>GST</h3>
                                <p>Push to File GST</p>
                            </div>
							<div class="icon">
								<a href="#"><i class="fa fa-commenting"></i></a>
                            </div>
						</div>
					</div>
				</a> 
			</div>
				
		</div>
		<!-- /.box-footer-->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- /.Chart content-wrapper -->

<?php	require('footer.php');
?>
