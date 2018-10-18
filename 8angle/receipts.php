<?php include 'includes/common.php';
$meta_title = "Credit/Debit Receipts 8angle | POS  ";
$invoice_js = "sale";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/invoiceClass.php';
$invoice = new invoiceClass();
include_once 'includes/receivableClass.php';
$receivable = new receivableClass();
$searchquery =""; $sortby ="id";  $sortorder ="DESC";
$from_date = "";
$to_date=date('Y-m-d');
$receipt = "Sale";

if(isset($_GET['receipt']) AND ($_GET['receipt']=="Sale" OR $_GET['receipt'] == "Purchase")) { 
	$receipt= ($_GET['receipt']);
}
if(isset($_GET['search'])) { 
	$keyword= ($_GET['search']);
}	
else 
{
	$keyword = "";
}
$sortvalue = array('invoice_id','invoice_number','contactname','dt_created');
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
			Manage <?php echo $receipt;?> Credit/Debit Receipts 
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Credit/Debit Receipts </li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">
				<?php 
				if($receipt == "Purchase") 
				{
				?>
				<a href="payable_add.php" class="btn btn-large btn-info pull-right"><i class="glyphicon glyphicon-plus"></i> Create <?php echo $receipt;?> Credit/Debit Receipts </a>
				<?php 
				} 
				else 
				{ 
				?>
				<a href="receivable_add.php" class="btn btn-large btn-info pull-right"><i class="glyphicon glyphicon-plus"></i> Create <?php echo $receipt;?> Credit/Debit Receipts </a>
				<?php 
				} 
				?>
				</div>
				<form action="" method="get" class="form-horizontal row" >
						<div class="col-sm-2">
						<b>Search Keyword:</b>
							<input name="receipt" type="hidden" class="receipt form-control input-sm" value="<?php echo $receipt;?>" placeholder="receipt" />
							<input name="search" type="text" class="from_date form-control input-sm" value="<?php echo $keyword;?>" placeholder="Invoice Number" />
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
							<option value="invoice_number" <?php if($sortby == "invoice_number") { echo "selected"; } ?> >Receipt Number</option>
							<option value="invoice_id" <?php if($sortby == "invoice_id") { echo "selected"; } ?> >Invoice Number</option>
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
								 <th>Receipt#</th>
								 <th>Invoice#</th>
								 <th>Date</th>
								 <th>Customer</th>
								 <th>Sub Total</th>
								 <th>Total Tax</th>
								 <th>Total Discount</th>
								 <th>Total</th>
								 <th colspan="5" align="center">Actions</th>
							 </tr>
						 </thead>
						 <tbody>
							<?php
							$params = array();
							if(!empty($from_date)) {
								$searchquery = "(dt_created >= :from_date AND dt_created <= :to_date) AND ";
								$params[':from_date'] = $from_date;	
								$params[':to_date'] = $to_date;
							}
							if($keyword) 
							{
								if($receipt == "Purchase") 
								{
									$qr = getDB()->prepare("SELECT  GROUP_CONCAT(id SEPARATOR ', ') AS ids  FROM `vendor_orders` WHERE (`deleted` ='N' AND `company_id` = :company_id AND `invoice_type` = 'Purchase Invoice') AND (`invoice_number` LIKE :keyword) ");
								} 
								else 
								{
									$qr = getDB()->prepare("SELECT  GROUP_CONCAT(id SEPARATOR ', ') AS ids  FROM `orders` WHERE (`deleted` ='N' AND `company_id` = :company_id AND `invoice_type` = 'Sale Invoice') AND (`invoice_number` LIKE :keyword) ");
								}
								
								$qr->execute();
								
								if($qr->rowCount() >= 1) {
								@	$row=$qr->fetch(PDO::FETCH_OBJ);
									$searchquery = $searchquery ." (`invoice_id` IN ($row->ids)) OR  `contactname` LIKE :keyword"; 
								
								} else {
								$searchquery = $searchquery ."(`contactname` LIKE :keyword OR `invoice_id` LIKE :keyword ) AND  "; 
								}
								
								$params[':keyword'] = '%'.$keyword.'%';	
							}
							
							$params[':company_id'] = $company_id;  
							$records_per_page=100;
							
							if($receipt == "Purchase") 
							{
								$query = "SELECT *,(SELECT Name 
								FROM customers
								WHERE vendor_orders.customer_id = customers.id)cname FROM `vendor_orders` WHERE  $searchquery `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt') ORDER BY $sortby $sortorder"; 
								
								$newquery = $pagination->paging($query,$records_per_page);
								$receivable->dataviewp($newquery,$params);
							}
							else 
							{
								$query = "SELECT *,(SELECT Name 
								FROM customers
								WHERE orders.customer_id = customers.id)cname FROM `orders` WHERE  $searchquery `deleted` ='N' AND `company_id` = :company_id AND (`invoice_type` = 'Credit Receipt' OR `invoice_type` = 'Debit Receipt') ORDER BY $sortby $sortorder"; 
								
								$newquery = $pagination->paging($query,$records_per_page);
								$receivable->dataviewr($newquery,$params);
							}
							?>
							<tr>
								<td colspan="13" align="center">
									<div class="pagination-wrap">
									<?php $val = "search=".$keyword."&sortby=".$sortby."&sortorder=".$sortorder."&from_date=".$from_date."&to_date=".$to_date."&receipt=".$receipt."&";
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
