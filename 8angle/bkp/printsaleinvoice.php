<?php include 'includes/common.php';
$meta_title = "Sale Invoice";
isCompany($company_id);
include_once 'includes/invoiceClass.php';
$invoice = new invoiceClass();
include_once 'includes/customersClass.php';
$customers = new customersClass();
$company_data = $crud->getID($company_id);
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
$city_data = $crud->getCity($company_data->city);
$order_id = "";
$print = "";
if(isset($_GET['print_id']) and is_numeric($_GET['print_id'])) {
	$order_id = ($_GET['print_id']);
}
if(isset($_GET['print'])) {
	$print = ($_GET['print']);
}
if(!$invoice->getID($order_id)) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=invoice.php?updated=NP">'; 
	exit();
} 
else
{
	$invoice_data = $invoice->getID($order_id);
	$invoice_number_value = ($invoice_data->invoice_number);
	$invtype = ($invoice_data->invtype);
	$inv_user  = ($invoice_data->customer_id);
	$date   = ($invoice_data->dt_created);
	$inv_user_name = ($invoice_data->contactname);
	$nettotal   = ($invoice_data->nettotal);
	$tax     = ($invoice_data->tax); 
	$discount  =($invoice_data->discount);
	$total = ($invoice_data->total);
	$balance = ($invoice_data->balance);
	$paid_amount = ($invoice_data->paid_amount);
	$freight = ($invoice_data->freight);
	$inv_discount = ($invoice_data->invoice_discount);
	$code = ($invoice_data->code);
	$ship_to = ($invoice_data->ship_to);
	$pin = ($invoice_data->pin);
	$address = ($invoice_data->address);
	$city = ($invoice_data->city);
	$ship_to_city_data =$customers->getCity($city);
	$state = ($invoice_data->state);
	$gst = ($invoice_data->gst);
	$inv_comment = ($invoice_data->comment);
	$inv_paid = ($invoice_data->invoice_paid);
	$same_as_billing_address = ($invoice_data->same_as_billing_address);
	$customer_name= $inv_user_name;	
	$customer_phone= "";
	$customer_email= "";
	$customer_address = "";
	$customer_city = 0;
	$customer_pin = "";
	$customer_gst= "";
	$customer_state = ($invoice_data->customer_state);
	$invoice_reference = ($invoice_data->invoice_reference);
	$due_period = ($invoice_data->due_period);
	$due_date = date('d-m-Y', strtotime(substr($date,0,10). ' + '.$due_period));
	if($invoice_data->show_tax == "Disable") { $sale_tax_display = "none"; }
	if($invoice_data->show_tax == "Enable") { $sale_tax_display = "visible"; }
	if($invoice_data->show_hsn == "Disable") { $hsn_code_display = "none"; }
	if($invoice_data->show_hsn == "Enable") { $hsn_code_display = "visible"; }
	$show_tax = $invoice_data->show_tax;
	$show_hsn = $invoice_data->show_hsn;
							
	if($customersDetails = $customers->getID($inv_user)) 
	{
		$customersDetails = $customers->getID($inv_user); 
		$customer_phone= $customersDetails->phone;
		$customer_gst= $customersDetails->gst_num;
		$customer_email= $customersDetails->email;
		$customer_address = $customersDetails->address;
		$customer_city = $customersDetails->city;
		$customer_city_data =$customers->getCity($customersDetails->city);	
		$customer_state = $customersDetails->state;
		$customer_pin = $customersDetails->pin;
							
	}
	if($addresses->getID($invoice_data->billing_address_id))
	{
		$addressDetails = $addresses->getID($invoice_data->billing_address_id);									
		$customer_gst= $addressDetails->gst_number;
		$customer_address = $addressDetails->address;
		$customer_city = $addressDetails->city;
		$customer_city_data =$customers->getCity($addressDetails->city);	
		$customer_state = $addressDetails->state;
		$customer_pin = $addressDetails->pin;
									
	}
							
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $meta_title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL;?>bower_components/Ionicons/css/ionicons.min.css">
 
  <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/AdminLTE.min.css"> 
 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    #table-sm  { margin:2px;  }
	#table-sm td  { padding:2px;  }
    #table { page-break-inside:auto }
    #table tr    { page-break-inside:avoid; page-break-after:auto }
    #table thead { display:table-header-group }
    #table tfoot { display:table-footer-group }
	@page { size: auto;  margin: 0mm; }
</style>
</head>
<body onload="window.print();">
<div class="col-sm-12">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
			<i class="fa fa-globe"></i> <?php echo $company_data->name; ?>
			<small class="pull-right">Date: <?php echo displaydateformat("d/m/Y",substr($date,0,10));?>
				<table border="1" id="table-sm" >
					<tr><td>&nbsp;<?php if($print == "Original") { echo "<i class='fa fa-check'></i>";} ?>&nbsp;</td><td class="text-red">Original to Receipent</td></tr>
					<tr><td>&nbsp;<?php if($print == "Duplicate") { echo "<i class='fa fa-check'></i>";} ?>&nbsp;</td><td class="text-red">Duplicate for Supplier/Transporter</td></tr>
					<tr><td>&nbsp;<?php if($print == "Triplicate") { echo "<i class='fa fa-check'></i>";} ?>&nbsp;</td><td class="text-red">Triplicate for Supplier</td></tr>
				</table>
			</small>
			<small>
			<?php echo $company_data->address; ?><br />
			<?php if(!empty( $company_data->city)) { echo $city_data->Name; ?>,  <?php } echo $company_data->state; ?>, India, Pin-  <?php echo $company_data->pin; ?><br />
			GSTIN: <?php echo $company_data->gst_number; ?>
			</small>
        </h2>
      </div>					
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
       Billed to:
        <address>
          <strong><?php echo $customer_name;?></strong><br>
         <?php if($customer_address) { echo $customer_address."<br/>"; }?>
         <?php if($customer_city) { echo $customer_city_data->Name; ?>, <?php } if($customer_state) { echo $customer_state; } ?><?php if($customer_pin) { echo " - ".$customer_pin; } ?><br>
          Phone: <?php echo $customer_phone;?><br>
          GSTIN: <?php if($customer_gst) { echo $customer_gst; } ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Shipped to:
        <address>
          <strong><?php echo $ship_to;?></strong><br>
         <?php if($address) { echo $address."<br/>"; }?>
         <?php if($city) { echo $ship_to_city_data->Name; ?>, <?php } if($state) { echo $state; } ?><?php if($pin) { echo " - ".$pin; } ?><br>
          GSTIN: <?php if($gst) { echo $gst; } ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo $invoice_number_value;?></b><br>
        <br>
		<b>Amount: </b> <?php if(empty($balance - $paid_amount)) { echo "nil";} else { echo num($balance - $paid_amount); } ?><br>
        <b>Payment Due: </b> <?php if($inv_paid == 'Y') { echo "Paid";} else { echo $due_date;}?><br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12">
        <table class="table table-striped" id="table">
          <thead>
          <tr>
            <th>S.no</th>
            <th>Name of Product/Service</th>
            <th>HSN</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Discount</th>
            <th>Taxable value</th>
            <th colspan="2">CGST
			</th>
            <th colspan="2">SGST</th>
            <th colspan="2">IGST</th>
            <th>Total</th>
          </tr>
		   <tr>
            <td colspan="7"></th>
            <td>Rate</td>
            <td>Amount</td>
            <td>Rate</td>
            <td>Amount</td>
            <td>Rate</td>
            <td>Amount</td>
            <td></td>
          </tr>
          </thead>
		<tbody>
          <?php
	$stmt_order_items = getDB()->prepare("select inv.* from `order_item` as inv 
									 WHERE inv.order_id=:order_id ORDER BY inv.id ASC ");
	$stmt_order_items->bindparam(":order_id",$order_id,PDO::PARAM_INT);
	$stmt_order_items->execute();	
									
	$nettotal_count=0; $tax_count = 0;  $discount_count = 0; $cnt= 1;
	 $cgst_amtt = 0; $sgst_amtt = 0; $total_before_tax = 0;
	while($data_order_items=$stmt_order_items->fetch(PDO::FETCH_OBJ)) 
	{
		$prod_id = $data_order_items->product_id;
		$prod_name = $data_order_items->product_name;
		$prod_hsn_code = "";
		$stmt_order_items_d = getDB()->prepare("select id,hsn_code ,name, description from `products`
									 WHERE `id` = '$data_order_items->product_id' ");
		$stmt_order_items_d->execute();	
		if($stmt_order_items_d->rowCount()>0) {
			$data_order_items_d = $stmt_order_items_d->fetch(PDO::FETCH_OBJ);
			$prod_name = $data_order_items_d->name;
			$prod_hsn_code = $data_order_items_d->hsn_code;
		}
										
		$data_order_items_discount = $data_order_items->discount;
		$orginal_amount = $data_order_items->price * $data_order_items->qty;
		$new_amount = ($data_order_items->price * $data_order_items->qty) - $data_order_items->discount;
										
										
		if ($data_order_items->discount_type == "Percent") 
		{ 
		$Decrease = $orginal_amount - $new_amount;
		$Decrease = ($Decrease / $orginal_amount) * 100;
												
		$data_order_items_discount = $Decrease."%";
												
		$inv_product_discountt = ( ( $data_order_items->price * $data_order_items->qty ) * $Decrease ) / 100;
	} 
	else 
	{
		$data_order_items_discount =$data_order_items_discount;
	$inv_product_discountt = $data_order_items_discount;
	}
	if($show_tax == "Disable") {	 $ttax = 0; $cgst_amt = 0; $sgst_amt = 0; }
	if($show_tax == "Enable") {										
		$ttax = (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->tax_percent) / 100;
		$cgst_amt = (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->cgst_tax) / 100;
		$sgst_amt =  (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->sgst_tax) / 100;
	}
	$cgst_amtt  = $cgst_amtt +  $cgst_amt;
	$sgst_amtt  = $sgst_amtt +  $sgst_amt;
									
	$nettotal_count   = $nettotal_count + ($data_order_items->price * $data_order_items->qty);
	$tax_count     = $tax_count + $ttax;
	$discount_count  = $discount_count + $inv_product_discountt;
	$total_before_tax = $total_before_tax + (($data_order_items->qty * $data_order_items->price) - $inv_product_discountt);
	 ?>	 
	 <tr>
		<td><?php echo $cnt;?></td>
		<td><?php echo html_entity_decode($prod_name);?></td>
		<td>
			<?php if($show_hsn == "Disable") { echo ""; } else { echo html_entity_decode($prod_hsn_code); }?>
		</td>
		<td><?php echo html_entity_decode($data_order_items->qty);?></td>
		<td><?php echo html_entity_decode(num($data_order_items->price));?></td>
		<td><?php echo html_entity_decode(num($inv_product_discountt)); ?></td>
		<td><?php echo html_entity_decode(num(($data_order_items->qty * $data_order_items->price) - $inv_product_discountt));?></td>
		<td><?php  if($company_data->state == $state) {  if($show_tax == "Enable") { echo floatval($data_order_items->cgst_tax)."%"; } } ?></td>
		<td><?php  if($company_data->state == $state) {  echo num($cgst_amt); } ?></td>
		<td><?php  if($company_data->state == $state) {    if($show_tax == "Enable") { echo floatval($data_order_items->sgst_tax)."%"; } } ?></td>
		<td><?php  if($company_data->state == $state) {  echo num($sgst_amt); } ?></td>
		<td><?php  if($company_data->state != $state) {    if($show_tax == "Enable") { echo floatval($data_order_items->tax_percent)."%"; } }  ?></td>
		<td><?php if($company_data->state != $state) { echo num($ttax); } ?></td>
		<td><?php echo num(($orginal_amount -$inv_product_discountt ) + $ttax);?></td>
	</tr>
	<?php 
		$cnt = $cnt+1; 
	}  
	if($stmt_order_items->rowCount() > 0) 
	{
		$nettotal   = $nettotal_count ;
		$tax     = $tax_count ; 
		$discount  = $discount_count ;
		$total = round(($nettotal - $discount) + $tax) ;
		$balance = round(($total - $inv_discount) + $freight);
		$cgst_amtt = $cgst_amtt; 
		$sgst_amtt = $cgst_amtt;
	}
	?>
				 <tr>
					<th colspan="5"><span class="pull-right">Total: </span></th>
					<th><?php //echo $currency;?><?php echo html_entity_decode(num($discount)); ?></th>
					<th><?php // echo $currency;?><?php echo html_entity_decode(num($total_before_tax));?></th>
					<th></th>
					<th><?php if($company_data->state == $state) { //echo $currency;?><?php echo num($cgst_amtt); } ?></th>
					<th></th>
					<th><?php if($company_data->state == $state) { //echo $currency;?><?php echo num($sgst_amtt); } ?></th>
					<th></th>
					<th><?php if($company_data->state != $state) { //echo $currency;?><?php echo num($tax); } ?></th>
					<th><?php //echo $currency;?><?php echo num($total);?></th>
				</tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-8">
        <p class="lead"></p>
    
        <p class="text-muted well well-sm no-shadow col-sm-8">
        <?php echo $inv_comment;?>
        </p>
		
		<div class="well well-sm no-shadow col-sm-8 text-center">
			<span>Certified that particulars given above are true and correct</span>
			<p><b>For, <?php echo $company_data->name; ?></b></p>
			<br /><br />
			Authorised Signatory
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-4">

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Total Amount Before Tax:</th>
              <td><?php echo $currency;?> <?php echo num($total_before_tax);?></td>
            </tr>
            <tr>
              <th>Total Tax</th>
              <td><?php echo $currency;?> <?php echo num($tax);?></td>
            </tr>
            <tr>
              <th>Total Amount After Tax:</th>
              <td><?php echo $currency;?> <?php echo num($total);?></td>
            </tr> 
			<tr>
              <th>Invoice Discount</th>
              <td><?php echo $currency;?> <?php echo num($inv_discount);?></td>
            </tr>
            <tr>
              <th>Freight:</th>
              <td><?php echo $currency;?> <?php echo num($freight);?></td>
            </tr>
            <tr>
              <th>Grand Total:</th>
              <td><?php echo $currency;?> <?php echo num($balance);?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
	<div class="row">
		<div class="col-xs-3">
		</div>
		<div class="col-xs-3"> 
			<b>Reference (Invoice Number): </b>
			<?php echo $invoice_reference;?>
		</div>
		<div class="col-xs-3"> 
			<b>Due Days</b>: <?php echo $due_period; ?>
		</div>
	</div>
	<br /><br />
		<p class="well well-sm no-shadow" style="padding:8px; text-align:center"><b><?php echo html_entity_decode($company_data->disclaimer); ?></b></p>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
