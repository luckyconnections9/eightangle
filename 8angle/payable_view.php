<?php include 'includes/common.php';
$meta_title = "View Credit/Debit Receipt";
isCompany($company_id);
include_once 'includes/pus_invoiceClass.php';
$invoice = new pus_invoiceClass();
include_once 'includes/customersClass.php';
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
$customers = new customersClass();
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
$order_id = "";
$print = "";
if(isset($_GET['print_id']) and is_numeric($_GET['print_id'])) {
	$order_id = mysql_real_escape_string($_GET['print_id']);
}
if(isset($_GET['print'])) {
	$print = mysql_real_escape_string($_GET['print']);
}
if(!$invoice->getID($order_id)) {
	//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=receipt.php?updated=NP">'; 
	exit();
} 
else
{
	$invoice_data = $invoice->getID($order_id);
	$invoice_number_value = mysql_real_escape_string($invoice_data->invoice_number);
	$invtype = mysql_real_escape_string($invoice_data->invtype);
	$inv_user  = mysql_real_escape_string($invoice_data->customer_id);
	$date   = mysql_real_escape_string($invoice_data->dt_created);
	$inv_user_name = mysql_real_escape_string($invoice_data->contactname);
	$nettotal   = mysql_real_escape_string($invoice_data->nettotal);
	$tax     = mysql_real_escape_string($invoice_data->tax); 
	$discount  =mysql_real_escape_string($invoice_data->discount);
	$total = mysql_real_escape_string($invoice_data->total);
	$balance = mysql_real_escape_string($invoice_data->balance);
	$paid_amount = mysql_real_escape_string($invoice_data->paid_amount);
	$freight = mysql_real_escape_string($invoice_data->freight);
	$inv_discount = mysql_real_escape_string($invoice_data->invoice_discount);
	$code = mysql_real_escape_string($invoice_data->code);
	$ship_to = mysql_real_escape_string($invoice_data->ship_to);
	$pin = mysql_real_escape_string($invoice_data->pin);
	$address = mysql_real_escape_string($invoice_data->address);
	$city = mysql_real_escape_string($invoice_data->city);
	$ship_to_city_data =$customers->getCity($city);
	$state = mysql_real_escape_string($invoice_data->state);
	$gst = mysql_real_escape_string($invoice_data->gst);
	$inv_comment = mysql_real_escape_string($invoice_data->comment);
	$inv_paid = mysql_real_escape_string($invoice_data->invoice_paid);
	$same_as_billing_address = mysql_real_escape_string($invoice_data->same_as_billing_address);
	$invoice_type = $invoice_data->invoice_type;
	$invoice_id = mysql_real_escape_string($invoice_data->invoice_id);
	$invoice_data_parent = $invoice->getID($invoice_id);
	$invoice_no = mysql_real_escape_string($invoice_data_parent->invoice_number);
	$customer_name= $inv_user_name;	
	$customer_phone= "";
	$customer_email= "";
	$customer_address = "";
	$customer_city = 0;
	$customer_pin = "";
	$customer_gst= "";
	$customer_state = mysql_real_escape_string($invoice_data->customer_state);
	$invoice_reference = mysql_real_escape_string($invoice_data->invoice_reference);
	$due_period = mysql_real_escape_string($invoice_data->due_period);
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
</style>
</head>
<body>
<div class="col-sm-12" style="width:100%;">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
			<i class="fa fa-globe"></i> <?php echo $company_data->name; ?>
			<small class="pull-right">Date: <?php echo displaydateformat("d/m/Y",substr($date,0,10));?><br/>  <?php echo $invoice_type;?>
			<br /><b>Invoice# <?php echo $invoice_no;?></b>
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
       Customer:
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
       </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Receipt# <?php echo $invoice_number_value;?></b><br>
        <br>
		<b>Amount: </b> <?php echo num($balance); ?><br>
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
	$stmt_order_items = getDB()->prepare("select inv.* from `vendor_order_item` as inv 
									 WHERE inv.order_id='$order_id' ORDER BY inv.id ASC ");
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
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
