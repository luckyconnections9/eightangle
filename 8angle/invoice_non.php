<?php include 'includes/common.php';
$meta_title = "Manage Invoices - 8angle | POS  ";
$invoice_js = "sale";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/invoiceClass.php';
$invoice = new invoiceClass();
$searchquery =""; $sortby ="id";  $sortorder ="DESC";
$from_date = "";
$to_date=date('Y-m-d');

if(isset($_GET['search'])) { 
	$keyword= ($_GET['search']);
}	
else 
{
	$keyword = "";
}
$sortvalue = array('id','invoice_number','contactname','dt_created');
if(isset($_GET['sortby']) and in_array($_GET['sortby'], $sortvalue)) { 
	$sortby= ($_GET['sortby']);
}
if(isset($_GET['sortorder']) AND ($_GET['sortorder'] == "ASC" OR $_GET['sortorder'] = "DESC")) { 
	$sortorder= ($_GET['sortorder']);
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
			Un-Registered Customers
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Invoices</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<form action="" method="get" class="form-horizontal" >
						<div class="col-sm-2">
						<b>Search Keyword:</b>
							<input name="search" type="text" class="from_date form-control input-sm" value="<?php echo $keyword;?>" placeholder="" />
						</div>	
						<div class="col-sm-2">
						<b>From:</b>
								<input name="from_date"  type="text" class="form-control input-sm" id="datepicker" value="<?php echo $from_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>	
						<div class="col-sm-2">
						<b>To:</b>
								<input name="to_date" type="text"  class="form-control input-sm"  id="datepicker1" value="<?php echo $to_date;?>" placeholder="<?php echo date('Y-m-d')?>" />
						</div>	
						<div class="col-sm-2">
						<b>Sort By:</b>
						<select class="form-control" name="sortby">
							<option value="id" <?php if($sortby == "id") { echo "selected"; } ?> ></option>
							<option value="invoice_number" <?php if($sortby == "invoice_number") { echo "selected"; } ?> >Invoice Number</option>
							<option value="contactname" <?php if($sortby == "contactname") { echo "selected"; } ?> >Customer Name</option>
							<option value="dt_created" <?php if($sortby == "dt_created") { echo "selected"; } ?> >Date</option>
						</select>
						</div>	
						<div class="col-sm-2">
						<b>Sort Order:</b>
						<select class="form-control" name="sortorder">
							<option value="ASC" <?php if($sortorder == "ASC") { echo "selected"; } ?> >Ascending</option>
							<option value="DESC" <?php if($sortorder == "DESC") { echo "selected"; } ?>>Desending</option>
						</select>
						</div>	
						<div class="col-sm-2">
						<br/>
							<input name="go" type="submit"  class="btn btn-info"  value="Go" placeholder="Go" />
						</div>	
					</form>
				</div>
			<div class="box-body">
				<div class="col-sm-12">
					<?php
					if($created) { echo $created; }
					if($updated) { echo $updated; }
					if($deleted) { echo $deleted; }
					?>
				</div>
				<div class="col-xs-12 table-responsive">
					<table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>					
							<tr>
								 <th>Invoice Number</th>
								 <th>Date</th>
								 <th>Customer</th>
								 <th>Sub Total</th>
								 <th>Total Tax</th>
								 <th>Total Discount</th>
								 <th>Total</th>
								 <th>Invoice Discount</th>
								 <th>Balance</th>
								 <th colspan="5" align="center">Actions</th>
							 </tr>
						 </thead>
						 <tbody>
							<?php
							$params = array();
							if(!empty($from_date)) 
							{
								$searchquery = "(dt_created >= :from_date AND dt_created <= :to_date ) AND ";
								$params[':from_date'] = $from_date;	
								$params[':to_date'] = $to_date;	
							}
							if($keyword) 
							{
								$searchquery = $searchquery ."(`invoice_number` LIKE :keyword OR `contactname` LIKE :keyword ) AND  "; 
								$params[':keyword'] = '%'.$keyword.'%'; 
							}
							$query = "SELECT * FROM `orders` WHERE  $searchquery `deleted` ='N' AND (`customer_id` = '0' OR `customer_id` = '') AND `company_id` = :company_id AND `invoice_type` = 'Sale Invoice' ORDER BY $sortby $sortorder";  
							$params[':company_id'] = $company_id;
							
							$records_per_page=20;
							$newquery = $pagination->paging($query,$records_per_page);
							$invoice->dataviewnon($newquery,$params);
							?>
							<tr>
								<td colspan="15" align="center">
									<div class="pagination-wrap">
										<?php $val = "search=".$keyword."&sortby=".$sortby."&sortorder=".$sortorder."&from_date=".$from_date."&to_date=".$to_date."&";
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
