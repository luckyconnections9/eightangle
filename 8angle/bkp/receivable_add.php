<?php include 'includes/common.php';
	$meta_title = "Create Sale Credit/Debit Receipt - 8angle | POS  ";
	$invoice_js = "sale";
	require('header.php');
	require('left.php');
	isCompany($company_id);
	?>
<link rel="stylesheet" href="css/invoice.css">
<?php
	include_once 'includes/invoiceClass.php';
	$invoice = new invoiceClass();
	include_once 'includes/stockmanClass.php';
	$stockman = new stockmanClass();
	include_once 'includes/customersClass.php';
	$customers = new customersClass();
	include_once 'includes/addressesClass.php';
	$addresses = new addressesClass();
	include_once 'includes/receivableClass.php';
	$receivable = new receivableClass();
	$company_data = $crud->getID($company_id);
	$city_data = $crud->getCity($company_data->city);
	$inv = ""; $cur = $currency; //&#8377;
	$invoice_number = $company_data->invoice_number;
	$hsn_code_display = "none";
	$invoice_number_value_display = "readonly";
		if($company_data->hsn_code == "Enable") 
		{ 
			$hsn_code_display = "visible"; 
		}
		$sale_tax_display = "none";
		if($company_data->sale_tax == "Enable") 
		{ 
			$sale_tax_display = "visible"; 
		}
		$invoice_number_value = $receivable->getDCReceiptnumber();
	
		$inv_id = "";
		if(isset($_GET['inv_id']) and is_numeric($_GET['inv_id'])) {
			$inv_id = ($_GET['inv_id']);
		}
	?>
<input type="hidden" id="Company_State" value="<?php echo $company_data->state; ?>" >
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Create Sale Credit/Debit Receipt
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>receipts.php">Sale Credit/Debit Receipt </a></li>
			<li class="active">Create Sale Credit/Debit Receipt</li>
		</ol>
	</section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<?php	
				$failure = "";
				$inserted = "";
				$paid_amount = 0; $invoice_type ="";
					?>
			<?php	
				if(!$invoice->getID($inv_id)) {
					?>
					<div class="row">
						<div class="col-sm-12"  style="padding:4%">
							<div class="col-sm-3">
							<b>Invoice Number:</b>
									<input autocomplete="off" type="text"   class="form-control input-sm"  onkeyup="load_invoice(this.value);" name="inv" value="<?php echo $inv_id;?>" placeholder="INV001" />
							</div>	
							<span class="col-sm-12" id="auto"></span>
						</div>
						<br />
						<br />
					</div>
					
					<?php
				} 
				else
				{
					$invoice_data = $invoice->getID($inv_id);
					$invtype = ($invoice_data->invtype);
					$invoice_no = ($invoice_data->invoice_number);
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
					$address = ($invoice_data->address);
					$city = ($invoice_data->city);
					$state = ($invoice_data->state);
					$inv_comment = ($invoice_data->comment);
					$same_as_billing_address = ($invoice_data->same_as_billing_address);
					$name= $inv_user_name;	
					$customer_phone= "";
					$customer_email= "";
					$customer_gst = "";
					$customer_address = "";
					$customer_city = 0;
					$billing_address_id = ($invoice_data->billing_address_id);
					$ship_to = ($invoice_data->ship_to);
					$pin = ($invoice_data->pin);
					$gst = ($invoice_data->pin);
					$customer_state = ($invoice_data->customer_state);
					$invoice_reference = ($invoice_data->invoice_reference);
					$show_tax = $invoice_data->show_tax;
					$show_hsn = $invoice_data->show_hsn;
					$due_period = ($invoice_data->due_period);
					if($invoice_data->show_tax == "Disable") { $sale_tax_display = "none"; }
					if($invoice_data->show_tax == "Enable") { $sale_tax_display = "visible"; }
					if($invoice_data->show_hsn == "Disable") { $hsn_code_display = "none"; }
					if($invoice_data->show_hsn == "Enable") { $hsn_code_display = "visible"; }
					$paid_by = $invoice_data->paid_by;
					$name_on_check = $invoice_data->account_name;
					$check_or_account_number = $invoice_data->account_number;
					$bank_name = $invoice_data->bank_name;
					$remarks = $invoice_data->remarks;
					$paid_date = $invoice_data->paid_date;
					
					if($customersDetails = $customers->getID($inv_user)) {
						
						$customersDetails = $customers->getID($inv_user); 
						$name= $customersDetails->name;	
						$customer_gst= $customersDetails->gst_num;
						$customer_phone= $customersDetails->phone;
						$customer_email= $customersDetails->email;
						$customer_address = $customersDetails->address;
						$customer_city = $customersDetails->city;
						$customer_state = $customersDetails->state;
					
					}
					if($addresses->getID($billing_address_id))
					{
						$addressDetails = $addresses->getID($billing_address_id);									
						$customer_gst= $addressDetails->gst_number;
						$customer_address = $addressDetails->address;
						$customer_city = $addressDetails->city;	
						$customer_state = $addressDetails->state;
						$customer_pin = $addressDetails->pin;
													
					}
				
				if(isset($_POST['EditInvoice']) or isset($_POST['EditInvoicenew']))
				{
					$invoice_number_value = ($_POST['invoice_number_value']);
					$invtype = ($_POST['invtype']);
					$inv_user  = ($_POST['inv_user']);
					$date   = ($_POST['date']);
					$inv_user_name = ($_POST['inv_user_name']);
					$customer_state = ($_POST['customer_state']);
					$nettotal   = 0;
					$tax     = 0; 
					$discount  = 0;
					$total = 0;
					$balance = 0;
					$inv_discount = ($_POST['inv_discount']);
					$freight = ($_POST['freight']);
					$code = genpassword();
					$address = ($_POST['address']);
					$city = ($_POST['city']);
					$state = ($_POST['state']);
					$inv_comment = ($_POST['inv_comment']);
					$invoice_reference = ($_POST['invoice_reference']);
					$due_period = ($_POST['due_period']);
					$same_as_billing_address = 'N';
					$invoice_type = ($_POST['invoice_type']);
					
					$billing_address_id = ($_POST['billing_address_id']);
					$gst = ($_POST['gst']);
					$ship_to = ($_POST['ship_to']);
					$pin = ($_POST['pin']);
					$paid_by = ($_POST['paid_by']);
					$name_on_check = ($_POST['name_on_check']);
					$check_or_account_number = ($_POST['check_or_account_number']);
					$bank_name = ($_POST['bank_name']);
					$remarks = "";
					$paid_date = $date;
					
					if(isset($_POST['sameAddress']) and $_POST['sameAddress'] == 1) { $same_as_billing_address = 'Y';}
					
					if($order_id = $invoice->create($invoice_number_value,$invtype,$inv_user,$date,$inv_user_name,$customer_state,$inv_discount,$code,$same_as_billing_address,$address,$city,$state,$inv_comment,$invoice_reference,$due_period,$show_hsn,$show_tax,$billing_address_id,$ship_to,$gst,$pin,$invoice_type,$inv_id))
					{
						$delete_old_items = getDB()->prepare("DELETE FROM `order_item` WHERE `order_id`=:order_id ");
						$delete_old_items->bindparam(":order_id",$order_id,PDO::PARAM_INT);
						$delete_old_items->execute();
						
						$delete_old_stock = getDB()->prepare("DELETE FROM `stock` WHERE `order_id`=:order_id AND `type` = 'OUT' ");
						$delete_old_stock->bindparam(":order_id",$order_id,PDO::PARAM_INT);
						$delete_old_stock->execute();
						
						for($i=0; $i< count($_POST['inv_product_name']); $i++)
						{
							$inv_product_id= ($_POST['inv_product_id'][$i]);
							$inv_product_name= ($_POST['inv_product_name'][$i]);
						@	$inv_product_type= ($_POST['inv_product_type'][$i]);
						@	$inv_product_unit= ($_POST['inv_product_unit'][$i]) ? $_POST['inv_product_unit'][$i] : 0;
							$inv_product_cost= ($_POST['inv_product_cost'][$i]);
							$inv_product_qty= ($_POST['inv_product_qty'][$i]);
							$inv_product_discount= ($_POST['inv_product_discount'][$i]);
						@	$tax_type= ($_POST['tax_type'][$i]) ? $_POST['tax_type'][$i] : 0;
							$tax_amount = ($_POST['tax_amount'][$i]);
							$cgst_tax_percent = ($_POST['cgst_tax_percent'][$i]);
							$sgst_tax_percent = ($_POST['sgst_tax_percent'][$i]);
							
							
							if (strstr($inv_product_discount, '%')) 
							{ 
								$s =	str_replace("%","",$inv_product_discount);
								$inv_product_discount = ( ($inv_product_cost * $inv_product_qty ) * $s ) / 100;
								$inv_product_discount_type = "Percent";
							} 
							else 
							{
								$inv_product_discount = $inv_product_discount;
								$inv_product_discount_type = "Num";
							}
							
							
							$t_tax = ( (($inv_product_cost * $inv_product_qty ) - $inv_product_discount) * $tax_amount) / 100;
							$cgst_amount = ( (($inv_product_cost * $inv_product_qty ) - $inv_product_discount) * $cgst_tax_percent) / 100;
							$sgst_amount =  ( (($inv_product_cost * $inv_product_qty ) - $inv_product_discount) * $sgst_tax_percent) / 100;
							
							if(!empty($inv_product_name) AND !empty($inv_product_cost) AND is_numeric($inv_product_cost) AND !empty($inv_product_qty) AND is_numeric($inv_product_qty))
							{
								
								$order_item = getDB()->prepare("INSERT INTO `order_item` (`order_id`,`product_id`,`product_name`,`product_type`,`products_unit_id`,`price`,`qty`,`tax_id`,`tax_percent`,`tax`,`discount`,`discount_type`,`description`,`cgst_tax`,`sgst_tax`,`cgst_amount`,`sgst_amount`) VALUES(:order_id,:inv_product_id,:inv_product_name,:inv_product_type,:inv_product_unit,:inv_product_cost,:inv_product_qty,:tax_type,:tax_amount,:t_tax,:inv_product_discount,:inv_product_discount_type,'',:cgst_tax_percent,:sgst_tax_percent,:cgst_amount,:sgst_amount) ");
										$order_item->bindparam(":order_id",$order_id,PDO::PARAM_INT);
										$order_item->bindparam(":inv_product_id",$inv_product_id,PDO::PARAM_INT);
										$order_item->bindparam(":inv_product_name",$inv_product_name,PDO::PARAM_STR);
										$order_item->bindparam(":inv_product_type",$inv_product_type,PDO::PARAM_STR);
										$order_item->bindparam(":inv_product_unit",$inv_product_unit,PDO::PARAM_INT);
										$order_item->bindparam(":inv_product_qty",$inv_product_qty,PDO::PARAM_INT);
										$order_item->bindparam(":tax_type",$tax_type,PDO::PARAM_INT);
										$order_item->bindparam(":tax_amount",$tax_amount,PDO::PARAM_STR);
										$order_item->bindparam(":t_tax",$t_tax,PDO::PARAM_STR);
										$order_item->bindparam(":inv_product_cost",$inv_product_cost,PDO::PARAM_STR);
										$order_item->bindparam(":inv_product_discount",$inv_product_discount,PDO::PARAM_STR);
										$order_item->bindparam(":inv_product_discount_type",$inv_product_discount_type,PDO::PARAM_STR);
										$order_item->bindparam(":cgst_tax_percent",$cgst_tax_percent,PDO::PARAM_STR);
										$order_item->bindparam(":sgst_tax_percent",$sgst_tax_percent,PDO::PARAM_STR);
										$order_item->bindparam(":cgst_amount",$cgst_amount,PDO::PARAM_STR);
										$order_item->bindparam(":sgst_amount",$sgst_amount,PDO::PARAM_STR);
										$order_item->execute();
								
								$nettotal   = $nettotal + ($inv_product_cost * $inv_product_qty);
								$tax     = $tax + $t_tax;
								$discount  = $discount + $inv_product_discount;
							}
							if(!empty($inv_product_id) AND is_numeric($inv_product_id) AND !empty($inv_product_cost) AND is_numeric($inv_product_cost) AND !empty($inv_product_qty) AND is_numeric($inv_product_qty)) 
							{	
								$inv_product_cost1 =  $inv_product_cost + (($inv_product_cost * $tax_amount) / 100);
								$chkstk = getDB()->prepare("SELECT price FROM `stock` WHERE `company_id` = :company_id AND `product_id` = :inv_product_id ORDER BY `date` DESC LIMIT 1 ");
								$chkstk->bindparam(":company_id",$company_id,PDO::PARAM_INT);
								$chkstk->bindparam(":inv_product_id",$inv_product_id,PDO::PARAM_INT);
								$chkstk->execute();
								if($chkstk->rowCount()>0)
								{	
									$rss=$chkstk->fetch(PDO::FETCH_OBJ);
									$inv_product_cost1 = $rss->price;
								}
						
								if( $invoice_type == "Debit Receipt" ) {
									$stockman->create($order_id,$inv_user,$inv_product_id,$inv_product_qty,0,$inv_product_cost1,$inv_product_unit,"OUT",$date); 
								} 
								if( $invoice_type == "Credit Receipt") {
									$stockman->create($order_id,$inv_user,$inv_product_id,0,$inv_product_qty,$inv_product_cost1,$inv_product_unit,"OUT",$date); 
								}
								
							}
						}
						$total = round(($nettotal - $discount) + $tax);
						$balance = ($total - $inv_discount) + $freight;
						
						$invoice_paid= "Y";
						
						$invoice->update_payment_details($order_id,$paid_by,$paid_date,$name_on_check,$check_or_account_number,$bank_name,$remarks);
						
						if($invoice->update_balance($order_id,$nettotal,$tax,$discount,$total,$balance,$freight,$invoice_paid,$paid_amount))
						{
							$inserted = $invoice_type." was created successfully";
							$urll = 'receivable_edit.php?created=Y&receipt=saved&edit_id='.$order_id;
							
							if(isset($_POST['EditInvoicenew']))
							{
								$urll = 'receivable_add.php?created=Y&receipt=saved';
								echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; 
								exit();
							} 
							
							
							echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; 
							exit();
						}
						else
						{
							$failure = "Error while adding Receipt!";
						}
					}
					else
					{
						$failure = "Error while adding Receipt!";
					}
				} 
				
				if($inserted)
				{
				 ?>
			<div class="alert alert-success alert-dismissible"><strong>WOW! </strong><?php echo $inserted ?></div>
			<?php
				}
				if($failure)
				{
				 ?>
			<div class="alert alert-danger alert-dismissible"><?php echo $failure ?></div>
			<?php
				}
				if($created) { echo $created; }
				?>
			<input type="hidden" id="Show_HSN_Code" value="<?php echo $company_data->hsn_code; ?>" >
			<input type="hidden" id="Show_Saletax" value="<?php echo $company_data->sale_tax; ?>" >
			<form class="form-horizontal" id="formInvoice" method='post' action="receivable_add.php?inv_id=<?php echo $inv_id;?>&code=<?php echo $code;?>">
				<input type="hidden" id="invoice_action"  name="invoice_action" value="Edit" >
				<center>
					<div class="box-body" id="lc-invoice">
						<div class="col-sm-12">
							<span class="col-sm-6" style="text-align:left">
								<h4>	Create:&nbsp;
									<input checked type="radio" name="invoice_type" <?php if($invoice_type  == "Credit Receipt") { echo "checked";}?> value="Credit Receipt" required /> Credit Receipt &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="invoice_type" <?php if($invoice_type  == "Debit Receipt") { echo "checked";}?> value="Debit Receipt" required /> Debit Receipt
								</h4>
							</span>
							<span class="col-sm-6" style="text-align:right">
								<h4>	Invoice#: <?php echo $invoice_no;?>
								</h4>
							</span>
						</div>
						<div class="col-sm-12">
							<div class="invoice_cust_address col-sm-4">
								<b>Customer: </b><br />
								<div class="form-group">
									<div class="col-sm-12">
										<input type="hidden" name="inv_user" id="inv_user" value="<?php echo $inv_user;?>" />
										<input readonly autocomplete="off"  class="form-control input-sm"  onkeyup="load_ajax_cust(this.value);" id="inv_user_name"  name="inv_user_name" type="text" value="<?php echo $inv_user_name;?>" placeholder="Enter Party/Customer name" required />
									</div>
									<span id="auto"></span>
								</div>
								<input type="hidden" class="form-control input-sm"   id="customer_state" name="customer_state"  value="<?php echo $customer_state; ?>"/>
								<input type="hidden" name="billing_address_id" id="billing_address_id" value="<?php echo $billing_address_id;?>" />
								<p>
									<b>Address:&nbsp;&nbsp;</b><b><span id="inv_address"><?php echo $customer_address;?></span></b>, <span id="inv_city_id" style="display:none;"><?php echo $customer_city;?></span><span id="inv_city"><?php if(!empty($customer_city) ) { echo $crud->getCity($customer_city)->Name;?>,<?php } ?></span> <span id="inv_state"><?php echo $customer_state;?></span> &nbsp;<span id="inv_pin"></span><br/>
									GSTIN: <span id="inv_gst"><?php echo $customer_gst;?></span>
								</p>
								<span id="showBillingAddress" >
									<?php if(!empty($inv_user)) { ?>
									<a href="invoice_addresses.php?customer=<?php echo $inv_user;?>&type=billing" data-toggle="modal" data-target="#billingAddress<?php echo $inv_user;?>" title="" data-refresh="true"><i class="fa fa-plus">Add Billing Address</i></a>
									<div id="billingAddress<?php echo $inv_user;?>" class="modal fade">
										<div class="modal-content"></div>
										<div class="modal-footer"><button type="button" class="btn btn-outline" data-dismiss="modal">Close</button></div>
									</div>
									<?php } ?>
								</span>
							</div>
							<div class="invoice_cust_shipping_address col-sm-4" style="opacity:0;">
								<table  class="table table-striped table-bordered dt-responsive nowrap" style="border:none !important;" cellspacing="0" >
									<tr>
										<td colspan="2"><b>Shipping address: </b> <input type="checkbox" value="1" id="sameAddress" name="sameAddress" onClick="return matchAddress();" <?php if($same_as_billing_address == 'Y') { echo "checked";} ?> > same as Billing address</td>
									</tr>
									<input type="hidden" name="pin" id="pin" value="<?php echo $pin;?>" />
									<input type="hidden" name="ship_to" id="ship_to" value="<?php echo $ship_to;?>" />
									<input type="hidden" name="gst" id="gst" value="<?php echo $gst;?>" />
									<input name="city" type="hidden" class="city form-control input-sm" id="city" value="<?php echo $city;?>" />
									<input name="state" type="hidden" class="state form-control input-sm" id="inv_shipping_state" value="<?php echo $state;?>" />
									<input name="address" type="hidden" class="address form-control input-sm" id="inv_shipping_address" value="<?php echo $address;?>" />
									<tr>
										<td><b>Address:</b></td>
										<td>
											<span id="ship_to_name"><?php echo $ship_to; ?></span>
											<span id="ship_address"><?php echo $address; ?></span><br/>
											GSTIN:  <span id="gst_num"><?php echo $gst;?></span>
										</td>
									</tr>
									<tr>
										<td width="60px"><b>City:</b></td>
										<td>
											<span id="city_name"><?php if(!empty($city) ) { echo $crud->getCity($city)->Name;} ?></span>
										</td>
									</tr>
									<tr>
										<td><b>State:</b></td>
										<td>
											<span id="state_name"><?php echo $state;?></span> &nbsp; <span id="ship_pin"><?php echo $pin;?></span>
										</td>
									</tr>
								</table>
								<span id="showShippingAddress" >
									<?php if(!empty($inv_user)) { ?>
									<a href="invoice_addresses.php?customer=<?php echo $inv_user;?>&type=shipping" data-toggle="modal" data-target="#shippingAddress<?php echo $inv_user;?>" title="" data-refresh="true"><i class="fa fa-plus">Add Shipping Address</i></a>
									<div id="shippingAddress<?php echo $inv_user;?>" class="modal fade">
										<div class="modal-content"></div>
										<div class="modal-footer"><button type="button" class="btn btn-outline" data-dismiss="modal">Close</button></div>
									</div>
									<?php } ?>
								</span>
							</div>
							<div class="invoice_cust col-sm-4">
								<table>
									<tr>
										<th align="left">Receipt No.</th>
										<td  align="right">
											<div class="form-group">
												<div class="col-sm-12">
													<input autocomplete="off" style="text-transform: uppercase"  class="form-control input-sm" id="invoice_number_value" readonly  name="invoice_number_value" type="text" value="<?php echo $invoice_number_value;?>" <?php echo $invoice_number_value_display;?>  required />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<th style="width:40%" align="left">Date</th>
										<td  align="right">
											<div class="form-group">
												<div class="col-sm-12">
													<input autocomplete="off"  class="form-control input-sm"  id="datepicker"  value="<?php echo substr($date,0,10);?>" name="date" type="text"  required />
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
								<div class="col-sm-9 well">
									<div  class="col-sm-12">
												<div class="form-group">
													<div class="col-sm-2">
													   <label class="control-label">
															<input onClick="checkPaidby(this.value)" type="radio" <?php if($paid_by == "Cash") { echo "checked"; } ?> name="paid_by" id="paid_by" value="Cash" />  Cash</label>
														 
													</div>
													<div class="col-sm-3">
													   <label class="control-label">
															<input onClick="checkPaidby(this.value)" type="radio" <?php if($paid_by == "Check") { echo "checked"; } ?> name="paid_by" id="paid_by" value="Check" checked />  Cheque</label>
													  
													</div>
													<div class="col-sm-2">
													   <label class="control-label">
															<input onClick="checkPaidby(this.value)" type="radio" <?php if($paid_by == "Credit Card") { echo "checked"; } ?> name="paid_by" id="paid_by" value="Credit Card" />  CC</label>
														 
													</div>
													<div class="col-sm-4">
													   <label class="control-label">
															<input onClick="checkPaidby(this.value)" type="radio" <?php if($paid_by == "Bank Transfer") { echo "checked"; } ?> name="paid_by" id="paid_by" value="Bank Transfer" />  Bank Transfer</label>
														 
													</div>
												</div>
												
										</div>
											<div class="col-sm-12" id="hide_data">
												<div class="col-sm-4 ">
												<label for="name_on_check" class="col-sm-12 control-label">AC/Card holder Name</label>
														<input type="text" class="form-control"  value="<?php echo $name_on_check;?>"   name="name_on_check"   id="name_on_check" autocomplete="off" placeholder="Lucky Company">
												</div>
												<div class="col-sm-3 ">
												<label for="check_or_account_number" class="col-sm-12 control-label">AC/CC/Cheque #</label>
														<input type="text" class="form-control"  value="<?php echo $check_or_account_number;?>"   name="check_or_account_number" id="check_or_account_number" autocomplete="off" placeholder="657986">
												</div>
												<div class="col-sm-3 ">
												<label for="bank_name" class="col-sm-12 control-label">Bank Name</label>
														<input type="text" class="form-control"  value="<?php echo $bank_name;?>"   name="bank_name"  id="bank_name" autocomplete="off" placeholder="ICICI Bank">
												</div>
											</div>
								</div>
								<div class="col-sm-3 well">
								<table>
									<tr>
										<td align="left">Invoice Amount</td>
										<td  align="right">
											<?php echo $balance;?>
										</td>
									</tr>
									<tr>
										<td align="left">Credit</td>
										<td  align="right">
										<?php
											$cr = getDB()->prepare("SELECT SUM(balance)  AS credit ,SUM(invoice_discount) AS cr_invoice_discount ,SUM(freight) AS cr_freight , GROUP_CONCAT(id SEPARATOR ', ') AS idss FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND `invoice_type` = 'Credit Receipt' AND `invoice_id` = :inv_id ");
											$cr->bindparam(":company_id",$company_id,PDO::PARAM_INT);
											$cr->bindparam(":inv_id",$inv_id,PDO::PARAM_INT);
											$cr->execute();
											$cids = NULL;
											$credit =   0;
											$cr_invoice_discount =  0;
											$cr_freight =   0;
											if($cr->rowCount()>0)
											{
											@	$r=$cr->fetch(PDO::FETCH_OBJ);
												if($credit =  $r->credit) {
													$cids = $r->idss;
													$cr_invoice_discount =   $r->cr_invoice_discount;
													$cr_freight =   $r->cr_freight;
												}
											}
											echo $credit;
										?>
										</td>
									</tr>
									<tr>
										<td align="left">Debit</td>
										<td  align="right">
										<?php
											$dr = getDB()->prepare("SELECT SUM(balance)  AS debit,SUM(invoice_discount) AS dr_invoice_discount ,SUM(freight) AS dr_freight FROM `orders` WHERE `deleted` ='N' AND `company_id` = :company_id AND `invoice_type` = 'Debit Receipt' AND `invoice_id` = :inv_id ");
											$dr->bindparam(":company_id",$company_id,PDO::PARAM_INT);
											$dr->bindparam(":inv_id",$inv_id,PDO::PARAM_INT);
											$dr->execute();
											$debit = 0;
											$dr_invoice_discount =  0;
											$dr_freight =   0;
											if($dr->rowCount()>0)
											{
											@	$d=$dr->fetch(PDO::FETCH_OBJ);
												if($debit =  $d->debit) {
													$debit =  $d->debit;
													$dr_invoice_discount =   $d->dr_invoice_discount;
													$dr_freight =   $d->dr_freight;
												}
											}
											else
											{
											 $debit =   "0";
											}
											echo $debit;
										?>
										</td>
									</tr>
									<tr>
										<td align="left">Amount Due</td>
										<td  align="right"><b><?php echo $cur;?></b>  <span class="due"><?php echo ($balance - ($credit - $debit));?></span></td>
									</tr>
								</table>
								</div>
							<div class="col-sm-12 table-responsive">
								<table id="items" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="4%"></th>
											<th width="18%">Product Name / Service</th>
											<th width="8%">Type</th>
											<th style="display: <?php echo $hsn_code_display;?>" >HSN</th>
											<th  width="6%">Unit</th>
											<th >Qty</th>
											<th>Sell Price</th>
											<th width="7%" style="display: <?php echo $sale_tax_display;?>">Tax</th>
											<th >Discount (Amt/%)</th>
											<th >Total Amt</th>
											<th style="display: <?php echo $sale_tax_display;?>">Total Tax</th>
											<th >Total Discount</th>
											<th width="8%">Grand Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$stmt_unit1 = getDB()->prepare("SELECT * FROM products_unit WHERE status='Enable' AND  `company_id` = :company_id AND `deleted` = 'N'");
											$stmt_unit1->bindparam(":company_id",$company_id,PDO::PARAM_INT);
											$stmt_unit1->execute();
											$data_unit1 = $stmt_unit1->fetchAll();
												
												
											$stmt_tax = getDB()->prepare("SELECT * FROM invoice_tax WHERE status='Enable' AND  `company_id` = :company_id AND `deleted` = 'N'");
											$stmt_tax->bindparam(":company_id",$company_id,PDO::PARAM_INT);
											$stmt_tax->execute();
											$data_tax = $stmt_tax->fetchAll();
											
											$stmt_order_items = getDB()->prepare("select inv.* from `order_item` as inv 
											 WHERE inv.order_id=:inv_id ORDER BY inv.id ASC ");
											$stmt_order_items->bindparam(":inv_id",$inv_id,PDO::PARAM_INT);
											$stmt_order_items->execute();	
											
											$nettotal_count=0; $tax_count = 0;  $discount_count = 0; $cnt= 0;
											 $cgst_amtt = 0; $sgst_amtt = 0;
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
													
													$ttax = (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->tax_percent) / 100;
													$cgst_amt = (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->cgst_tax) / 100;
													$sgst_amt =  (( ( $data_order_items->price  * $data_order_items->qty) - $inv_product_discountt ) * $data_order_items->sgst_tax) / 100;
													$cgst_amtt  = $cgst_amtt +  $cgst_amt;
													$sgst_amtt  = $sgst_amtt +  $sgst_amt;
											
												$nettotal_count   = $nettotal_count + ($data_order_items->price * $data_order_items->qty);
												$tax_count     = $tax_count + $ttax;
												$discount_count  = $discount_count + $inv_product_discountt;
												
												$check_order_items = getDB()->prepare("SELECT `id` FROM `orders` WHERE `deleted` ='N' AND `company_id` = $company_id AND `invoice_type` = 'Credit Receipt' AND `invoice_id` = '$inv_id'");
											 ?> 
										<tr class="item-row">
											<td>
												<a class="delete" title="remove Item"><i class="glyphicon glyphicon-remove-circle"></i></a>
											</td>
											<input  name="inv_product_id[]" readonly="readonly" type="hidden"  value="<?php echo html_entity_decode($data_order_items->product_id);?>" id="inv_product_id"  tabindex="1" />
											<td>
												<input class="form-control" name="inv_product_name[]"  value="<?php echo html_entity_decode($prod_name);?>" id="inv_product_name" autocomplete="off" onkeyup="load_search(this.value,<?php echo $cnt;?>)" tabindex="1" readonly />
												<br/>
												<span class="showdata"></span>
											</td>
											<td>
												<select name="inv_product_type[]" id="inv_product_type"  class="inv_product_type  form-control" >
													<option <?php if($data_order_items->product_type == "Goods") { echo "selected"; }?> value="Goods">Goods</option>
													<option  <?php if($data_order_items->product_type == "Services") { echo "selected"; }?> value="Services">Services</option>
												</select>
											</td>
											<td style="display:<?php echo $hsn_code_display;?>">
												<span class="HSN_code_show"><?php echo html_entity_decode($prod_hsn_code);?></span>
											</td>
											<td>
												<select   name="inv_product_unit[]" id="inv_product_unit"  class="inv_product_unit  form-control" >
													<option value=""></option>
													<?php 
														$stmt_unit_sel = "";
															foreach( $data_unit1 as $dataunit )
															{
																if($dataunit['id'] == $data_order_items->products_unit_id) { $stmt_unit_sel ="selected='selected'";}  else { $stmt_unit_sel ="";}
																echo "<option ".$stmt_unit_sel." value=".$dataunit['id'].">".$dataunit['unit']."</option>";
															}
														?>
												</select>
											</td>
											<td>
												<input  type="text" value="<?php echo html_entity_decode($data_order_items->qty);?>"  class="qty  form-control" name="inv_product_qty[]"  id="inv_product_qty" readonly />
											</td>
											<td>
												<input  class="cost form-control"  type="text" value="<?php echo html_entity_decode($data_order_items->price);?>" name="inv_product_cost[]"  id="inv_product_cost" readonly />
											</td>
											<td style="display: <?php echo $sale_tax_display;?>">
												<select  name="tax_type[]"  id="tax_type"  class="tax_type  form-control" >
													<option value=""></option>
													<?php 
															$stmt_tax_sel = "";
															foreach( $data_tax as $datatax )
															{
																if($datatax['id'] == $data_order_items->tax_id) { $stmt_tax_sel ="selected='selected'";}  else { $stmt_tax_sel ="";}
																echo "<option ".$stmt_tax_sel." value=".$datatax['id'].">".$datatax['name']."  ".$datatax['tax']."%</option>";
															}
														 ?>
												</select>
												<input  name="tax_amount[]" class="tax_amount" readonly="readonly" type="hidden"  value="<?php echo html_entity_decode($data_order_items->tax_percent);?>" id="tax_amount"  tabindex="1" readonly />
												<span class="row_number"><?php echo $cnt;?></span>
											</td>
											<td>
												<input   type="text" value="<?php echo html_entity_decode($data_order_items_discount);?>"  class="discount  form-control" name="inv_product_discount[]"  id="inv_product_discount"  readonly /> 
												<span class="discount_amount" ></span>
											</td>
											<td>
												<span class="total_amount_te"><?php echo number_format($orginal_amount, 2, '.', '');?></span>
											</td>
											<td  style="display: <?php echo $sale_tax_display;?>">
												<span class="total_tax"><?php echo number_format($ttax, 2, '.', '');?></span>
												<span class="tax_hidden">
												<input type="hidden" name="cgst_tax_percent[]" id="cgst_tax_percent" class="cgst_tax_percent" value="<?php echo html_entity_decode($data_order_items->cgst_tax);?>">
												<span id="cgst_amt" class="cgst_amt"><?php echo html_entity_decode(num($cgst_amt)); ?></span> 
												[ 
												<input type="hidden" name="sgst_tax_percent[]" id="sgst_tax_percent" class="sgst_tax_percent" value="<?php echo html_entity_decode($data_order_items->sgst_tax);?>">
												<span id="sgst_amt" class="sgst_amt"><?php echo html_entity_decode(num($sgst_amt)); ?></span>
												]
												</span>
											</td>
											<td>
												<span class="total_discount"><?php echo html_entity_decode(num($inv_product_discountt)); ?></span>
											</td>
											<td>
												<input   type="text" value="<?php echo num(($orginal_amount -$inv_product_discountt ) + $ttax);?>"  class="grand_total  form-control" name="grand_total[]"  id="grand_total" readonly /> 
											</td>
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
											$balance = ($total - $inv_discount) + $freight;
											$cgst_amtt = $cgst_amtt; 
											$sgst_amtt = $cgst_amtt;
											}
											else {
												$nettotal   = 0;
												$tax     = 0 ; 
												$discount  = 0 ;
												$total = round(($nettotal - $discount) + $tax) ;
												$balance = ($total - 0) + 0;
												$cgst_amtt = 0; 
												$sgst_amtt = 0;
											}
											if($stmt_order_items->rowCount() < 20)
											{ 
											if(!empty($inv_id)) 
											{ 
												$ss= $cnt; $ss2= $cnt+1;  $ss3= $cnt+2; $ss4= $cnt+3;  $ss5=$cnt+4; $ss6=$cnt+5; $ss7=$cnt+6; $ss8=$cnt+7;
											} 
											else 
											{ 
												$ss= 0; $ss2=1; $ss3= 2; $ss4=3; $ss5=4; $ss6=5; $ss7=6; $ss8=7;
											} ?>
										 <tr class="item-row">
														<td><a class="delete" title="remove Item"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
														<input  name="inv_product_id[]" readonly="readonly" type="hidden"  value="" id="inv_product_id"  tabindex="1" />
														<td><input class="form-control" name="inv_product_name[]"  value="" id="inv_product_name" autocomplete="off" onkeyup="load_search(this.value,<?php echo $ss;?>)" tabindex="1" /><br/><span class="showdata"></span>
														</td>
														<td>
															 <select  name="inv_product_type[]" id="inv_product_type"  class="inv_product_type  form-control" >
																<option value="Goods">Goods</option>
																<option value="Services">Services</option>
															</select>
														</td>
														<td style="display:<?php echo $hsn_code_display;?>"><span class="HSN_code_show"></span></td>
														<td>
															 <select  name="inv_product_unit[]" id="inv_product_unit"  class="inv_product_unit  form-control" >
																<option value=""></option>
															<?php 
																	foreach( $data_unit1 as $dataunit )
																	{
																		echo "<option value=".$dataunit['id'].">".$dataunit['unit']."</option>";
																	}
																 ?>
															</select>
														</td>
														<td><input type="text" value="1"  class="qty  form-control" name="inv_product_qty[]"  id="inv_product_qty" /></td>
														<td><input  class="cost form-control"  type="text" value="0.00" name="inv_product_cost[]"  id="inv_product_cost" /></td>
														<td style="display: <?php echo $sale_tax_display;?>">
															 <select  name="tax_type[]" onChange="load_taxes(this.value,<?php echo $ss;?>)" id="tax_type"  class="tax_type  form-control" >
																<option value=""></option>
																<?php 
																	foreach( $data_tax as $datatax )
																	{
																		echo "<option value=".$datatax['id'].">".$datatax['name']."  ".$datatax['tax']."%</option>";
																	}
																 ?>
															</select>
															<input  name="tax_amount[]" class="tax_amount" readonly="readonly" type="hidden"  value="" id="tax_amount"  tabindex="1" />
															<span class="row_number"><?php echo $ss;?></span>
														</td>
														<td><input   type="text" value="0.00"  class="discount  form-control" name="inv_product_discount[]"  id="inv_product_discount" /> <span class="discount_amount"></span></td>
														<td><span class="total_amount_te">0.00</span></td>
														<td style="display: <?php echo $sale_tax_display;?>"><span class="total_tax">0.00</span>
														<span class="tax_hidden">
															<input type="hidden" name="cgst_tax_percent[]" id="cgst_tax_percent" class="cgst_tax_percent" value="0"><span id="cgst_amt" class="cgst_amt"></span> [ <input type="hidden" name="sgst_tax_percent[]" id="sgst_tax_percent" class="sgst_tax_percent" value="0"><span id="sgst_amt" class="sgst_amt"></span>]</span></td>
														<td><span class="total_discount">0.00</span></td>
														<td>
															<input   type="text" value="0"  class="grand_total  form-control" name="grand_total[]"  id="grand_total" />
														</td>
													</tr>
										<?php } ?>
										<tr>
											<?php $cols = 13; $cols2 = 9; $cols4 = 9; 
												if($show_hsn == "Disable") { $cols = $cols - 1; $cols2 = $cols2 - 1; $cols4 = $cols4 - 1;  }
												if($show_tax == "Disable") { $cols = $cols - 1; $cols2 = $cols2 - 1;  $cols4 = $cols4 - 1; }
												?>
											<td colspan="<?php echo $cols4; ?>"><b class="pull-right">Total:</b></td>
											<td>
												<div id="subtotal"><?php echo num($nettotal);?></div>
											</td>
											<td style="display: <?php echo $sale_tax_display;?>">
												<span id="tax"><?php echo num($tax);?></span>
											</td>
											<td>
												<span id="discount_total"><?php echo num($discount);?></span>
											</td>
											<td>
												<span id="total"><?php echo num($total);?></span>
											</td>
										</tr>
										<tr id="hiderow">
											<td colspan="<?php echo $cols; ?>"> <a href="javascript:;" id="addRow" class="button-clean large"><span> <i class="fa fa-plus-circle"></i> Add new row</span></a></td>
										</tr>
										<tr>
											<td colspan="<?php echo $cols2; ?>" rowspan="3" class="blank" vertical-align="middle">
												<div class="col-sm-12">
													<b>Comment(s):</b><br/>
													<textarea style="width:90%" name="inv_comment"><?php echo $inv_comment;?></textarea>
													</p>
												</div>
												<div class="col-sm-12"  style="display: <?php echo $sale_tax_display;?>">
													<?php if($company_data->state == $state) { ?>
													<div class="col-sm-4 cgst_div"><b>CGST : </b> <?php echo $cur; ?></span>&nbsp;<span class="total_cgst"><?php echo num($cgst_amtt);?></span></div>
													<div class="col-sm-4 sgst_div"><b>SGST : </b> <?php echo $cur; ?></span>&nbsp;<span class="total_sgst"><?php echo num($sgst_amtt);?></span></div>
													<?php } else { ?>
													<div class="col-sm-4 igst_div"><b>IGST : </b> <?php echo $cur; ?></span>&nbsp;<span class="total_igst"><?php echo num($tax);?></span></div>
													<?php } ?>
												</div>
											</td>
											<td colspan="2" class="total-line">Invoice Discount</td>
											<td class="total-value" colspan="2">
												<input type="text" class="form-control" size="32" name="inv_discount" id="discount" value="<?php echo num(($inv_discount - $cr_invoice_discount) +  $dr_invoice_discount);?>" />
											</td>
										</tr>
										<tr>
											<td colspan="2" class="total-line">Freight</td>
											<td class="total-value" colspan="2"><input type="text" class="form-control" size="32" name="freight" id="freight" value="<?php echo num(($freight - $cr_freight) + $dr_freight);?>" /></td>
										</tr>
										<tr>
											<td colspan="2" class="total-line">Balance</td>
											<td class="total-value" colspan="2">
												<span style="float:left"><?php echo $cur; ?> &nbsp;  </span>
												<div id="paid_due" class="paid_due"><?php echo num($balance);?></div>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="row">
									<div class="col-sm-3">
										<input type="hidden" name="invtype"  id="invtype" value="Simple"  class="invtype form-control" />
									</div>
									<div class="col-sm-3"> 
										<input type="hidden" class="invoice_reference form-control" name="invoice_reference" id="invoice_reference" value="">
									</div>
									<div class="col-sm-3"> 
									</div>
									<div class="col-sm-3"> 
										<input type="hidden" value="1 days" name="due_period"  id="due_period"  class="due_period form-control" />
									</div>
								</div>
								<br />
							</div>
						</div>
					</div>
				</center>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo BASE_URL;?>invoice.php" onclick="return confirm('Are you sure you want to close this page')" class="btn btn-default">Cancel</a>
					<button type="submit" name="EditInvoicenew" style="margin-right:30px"  onclick="return confirm('You are about to create new receipt. Are you sure?')"  class="btn btn-info pull-right" value="Add">New</button>
					
					<button type="submit" name="EditInvoice"  onclick="return confirm('You are about to create Receipt. Are you sure?')"  class="btn btn-info pull-right" style="margin-right:30px" value="Edit">Save</button>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
		<?php 	
			}
			?>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
	?>

