<?php include 'includes/common.php';
$meta_title = "Inventory/Stock - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/stockmanClass.php';
$stockman = new stockmanClass();
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
$product_id = ""; $product_name ="";
	$from_date = date('Y-m-d' , strtotime('-1 days') );
	$to_date=date('Y-m-d'); $customer_name = "";
	if(isset($_GET['product']) and is_numeric($_GET['product']) and $stockman->getPro($_GET['product'])) 
	{
		$product_id = ($_GET['product']);
		$pro_data = $stockman->getPro($product_id);
		$product_name = $pro_data->name;
	}
	if(isset($_GET['from_date'])) 
	{
		$from_date =  ($_GET['from_date']);
	}
	if(isset($_GET['to_date'])) 
	{
		$to_date =  ($_GET['to_date']);
	}
	if($from_date == $to_date) 
	{
		$from_date = "";
	}
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Inventory - Stock
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Inventory </li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<div class="form-group col-sm-12">
					<div class="col-sm-3">
					<b>Select Product:</b>
							<input autocomplete="off" type="text"   class="form-control input-sm"  onkeyup="load_product(this.value);" name="product" value="<?php echo $product_name;?>" placeholder="Enter Product name" required />
					</div>	
					<form action="stockman.php?product=<?php echo $product_id;?>" method="get">
						<div class="col-sm-2">
						<input name="product" type="hidden" value="<?php echo $product_id;?>" />
						<b>From:</b>
								<input name="from_date" type="text" class="from_date form-control input-sm" id="datepicker" value="<?php echo $from_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>	
						<div class="col-sm-2">
						<b>To:</b>
								<input name="to_date" type="text"  class="to_date form-control input-sm"  id="datepicker1" value="<?php echo $to_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>		
						<div class="col-sm-2">
						<br/>
								<input name="go" type="submit"  class="btn btn-info"  value="Go" placeholder="Go" />
						</div>	
					</form>
					<span class="col-sm-12" id="auto"></span>
				</div>
				
			</div>
			<div class="box-body">
				<div class="col-sm-12">
						<?php
						if($created) { echo $created; }
						if($updated) { echo $updated; }
						if($deleted) { echo $deleted; }
						?>
				</div>
				<div class="col-xs-12">
							<small class="pull-right"><b>Date</b>
							<?php 
								if(!empty($from_date)) { 
									echo ": ".displaydateformat("d/m/Y",substr($from_date,0,10))." <b>to</b> ".displaydateformat("d/m/Y",substr($to_date,0,10));;
								} else {
									echo ": ".displaydateformat("d/m/Y",substr(date('Y-m-d'),0,10));
								}
							?>
							</small><br/><br/>
				</div>
				<div class="col-sm-12">
						<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
							 <tbody>							
								<tr>
									<th>ID</th>
									<th>Product Name</th>
									<th>Product Unit</th>
									<th>Buy Price(/unit)</th>
									<th>Stock In</th>
									<th>Stock Out</th>
									<th>Avl. Stock</th>
									<th><?php echo $currency;?> Worth Amount (x. Bought Price)</th>
								</tr>
							
								<?php
								$params = array();
								$query = "SELECT * FROM `stock` WHERE `company_id` = :company_id AND (entry_date >= :from_date AND entry_date <= :to_date) ORDER BY `date` DESC  "; 
								
								if($product_id) 
								{
									$query = "SELECT * FROM `stock` WHERE `product_id`=:product_id AND `company_id` = :company_id AND (entry_date >= :from_date AND entry_date <= :to_date ) ORDER BY `date` DESC  ";  
									$params[':product_id'] = $product_id;	
								}	
								
								$params[':company_id'] = $company_id;
								$params[':from_date'] = $from_date;
								$params[':to_date'] = $to_date;
								
								$records_per_page=1000;
								$newquery = $pagination->paging($query,$records_per_page);
								$stockman->stockMan($newquery,$currency,$params);
								?>
								<tr>
									<td colspan="11" align="center">
										<div class="pagination-wrap">
											<?php $val = "";
											$pagination->paginglink($query,$records_per_page,$val,$params); ?>
										 </div>
									</td>
								</tr>
															 
							</tbody>
						</table>
				

				</div>												
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
	
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
