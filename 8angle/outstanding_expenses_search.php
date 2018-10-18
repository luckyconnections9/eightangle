<?php include 'includes/common.php';
isCompany($company_id);
include_once 'includes/expensescategoryClass.php';
$expensescategory = new expensescategoryClass();
include_once 'includes/payexpensesClass.php';
$payexpenses = new payexpensesClass();
$receipt_number = $payexpenses->getReceiptnumber('Expenses');
$company_data = $crud->getID($company_id);
$city_data = $crud->getCity($company_data->city);
$id = ($_GET['id']);
?>
<form class="form-horizontal" id="formReceipt" method='post' action="" >
<?php
if(!empty($id) AND $expensescategory->getID($id)) {
	
$cust_data = $expensescategory->getID($id);
$stmt_inv = getDB()->prepare("SELECT * FROM  `expenses` WHERE `deleted` ='N' AND `company_id` = :company_id AND `exp_paid` = 'N' AND `exp_type` = 'Post-Paid' AND `expenses_category_id` = :id ORDER BY `id` DESC");  
$stmt_inv->bindparam(":company_id",$company_id,PDO::PARAM_INT);
$stmt_inv->bindparam(":id",$id,PDO::PARAM_INT);
$stmt_inv->execute();										 
if($stmt_inv->rowCount()>0) { 
			echo '<div style="max-height:300px; overflow-y:scroll;"><table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" >';
			echo '<tr><th>';
						echo  '</th>
								 <th>Name</th>
								 <th>Date</th>
								 <th>Total</th>
								 <th>Total Paid</th>
								 <th>Balance</th>
							 </tr>';
				$total =0; $total_discount =0; $total_paid =0; $balance =0;
				while($row = $stmt_inv->fetch(PDO::FETCH_OBJ))
				{
					$ttl= $row->amt;
					$total =$total +$ttl;
					$total_paid =$total_paid + $row->paid_amount; 
					$balance =$balance + number_format($ttl - $row->paid_amount, 2, '.', '');
					
					echo "<tr>
								 <td><div class='checkbox'><label>"; ?>
								<input type='radio' id="<?php echo $row->expenses_category_id; ?>" name='expenses_category_id' onClick="update_receipt(<?php echo $row->id; ?>,'<?php echo $row->expenses_category_id; ?>',<?php echo $ttl - $row->paid_amount; ?>,'<?php echo $row->name;?>')" value='<?php echo $row->id; ?>' class='check'>
								 <?php echo "</label></div></td>
								 <td>".$row->name."</td>
								 <td>".displaydate(substr($row->pay_date,0,10))."</td>
								 <td>".$ttl."</td>
								 <td>".$row->paid_amount."</td>
								 <td>".number_format($ttl - $row->paid_amount, 2, '.', '')."</td>
							 </tr>";
				}
				echo "<tr><th>"; 
				?>
				<div class='checkbox'><label>
				<input type='radio' name='expenses_category_id' checked onClick="update_receipt(0,'',<?php echo $balance;?>,'<?php echo $cust_data->name;?>')" value='' class='check'> None</label></div>
				<?php
				echo "</th><th></th><th>Total</th><th>".number_format($total, 2, '.', '')."</th><th>".number_format($total_paid, 2, '.', '')."</th><th>".number_format($balance, 2, '.', '')."</th></tr></table></div>"; $paid_by ="";
				?>
					<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" >
						<tr>
							<th>PAYMENT RECEIPT</th>
						</tr>
						<tr>
							 <td>
								<div class="receipt">
									<div class="row col-sm-12">
										<div  class="col-sm-6">
										
											<div class="form-group">
												<label for="receipt_number" class="col-sm-6 control-label">Reference Number: </label>
												<div class="col-sm-6">
													<input type="text" class="form-control input-sm"  name="receipt_number" id="receipt_number" value="" required />
												</div>
											</div>
										</div>
										<div  class="col-sm-6">
											<div class="form-group">
												<label for="date" class="col-sm-6 control-label">Date: </label>
												<div class="col-sm-6">
												<input type="text" id="datepicker1" class="form-control input-sm receipt_date"  name="receipt_date"  value="<?php echo date('Y-m-d');?>" />
												</div>
											</div>
										</div>
									 </div>
									 <div class="row col-sm-12">
										<div  class="col-sm-5">
											<div class="form-group">
												<label for="from" class="col-sm-6 control-label">
												Total Amount Due: <br />
												This payment: <br />
												Balance: 
												</label>
												<span for="from" class="col-sm-6 control-label" style="text-align:left">
													<input type="hidden" id="rtotal_amount"  name="rtotal_amount"  value="<?php echo number_format($balance, 2, '.', '');?>" />
													<span id="rtotal_amount_txt"><?php echo number_format($balance, 2, '.', '');?></span><br />
													<span id="this_paid"></span><br />
													<span id="total_balance"><?php echo number_format($balance, 2, '.', '');?></span>
												</span>
											</div>
										</div>
										<div  class="col-sm-7">
												<div class="form-group">
													<div class="col-sm-3">
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
									 </div>
											<div class="col-sm-12" id="hide_data">
												<div class="col-sm-2 ">
												<label for="check_date" class="col-sm-12 control-label">Date</label>
															<input autocomplete="off"  class="form-control input-sm check_date"  id="datepicker"  value="<?php echo date("Y-m-d");?>" name="check_date" type="text"  />
												</div>
												<div class="col-sm-4 ">
												<label for="name_on_check" class="col-sm-12 control-label">AC/Card holder Name</label>
														<input type="text" class="form-control"  value=""   name="name_on_check"   id="name_on_check" autocomplete="off" placeholder="Lucky Company">
												</div>
												<div class="col-sm-3 ">
												<label for="check_or_account_number" class="col-sm-12 control-label">AC/CC/Cheque #</label>
														<input type="text" class="form-control"  value=""   name="check_or_account_number" id="check_or_account_number" autocomplete="off" placeholder="657986">
												</div>
												<div class="col-sm-3 ">
												<label for="bank_name" class="col-sm-12 control-label">Bank Name</label>
														<input type="text" class="form-control"  value=""   name="bank_name"  id="bank_name" autocomplete="off" placeholder="ICICI Bank">
												</div>
											</div>
									 <div class="row col-sm-12">
										<div  class="col-sm-7">
											<div class="form-group">
												<label for="from" class="col-sm-4 control-label">Paid for: </label>
												<div class="col-sm-8">
													<input type="hidden" class="form-control input-sm"  name="cust_id" id="cust_id" value="<?php echo $cust_data->id;?>" />
													<input type="text" class="form-control input-sm"  name="cust_name" id="cust_name" value="<?php echo $cust_data->name;?>" />
												</div>
											</div>
										</div>
										<div  class="col-sm-5">
											<div class="form-group">
											<label for="amount" class="col-sm-6 control-label">Amount of INR: </label>
												<div class="col-sm-6">
													<input type="text" class="form-control " onBlur="update_receipt_amount(this.value)" name="paid_amount" id="paid_amount"  value="<?php echo $balance; ?>" />
												</div>
											</div>
										</div>
									 </div>
									 <div class="row col-sm-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">Rupees: </label>
											<span class="col-sm-10">
												<span class="in_words form-control" id="in_words" style="border:0px; border-bottom: 1px solid gray" ></span>
											</span>
										</div>
									 </div>
									 
									  <div class="row col-sm-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">For: </label>
											<span class="col-sm-10">
												<input type="text" class="form-control input-sm"  name="payment_for" id="payment_for" value="" />
												<input type="hidden" id="for_invoice"  name="for_invoice"  value="" />
												<input type="hidden" name="payment_for_id" id="payment_for_id" value="" />
											</span>
										</div>
									 </div>
									 <button type="button" onClick = "submitReceipt();" name="Save" class="btn btn-info pull-right" value="Save">Save</button>
								</div>
							 </td>
						</tr>
					</table>
				<?php
		 }
		 else
		 {
			  echo "No Outstanding invoice found for this customer";
		 }
}
else {
	   echo "No Outstanding invoice found for this customer";
}
?>
</form>
<script src="js/validator.js"></script>
<script type="text/javascript">
	function update_receipt_amount(val) {
		document.getElementById('this_paid').innerHTML  = val;
		document.getElementById('in_words').innerHTML = number2text(val);
		var rtotal_amount = 	document.getElementById('rtotal_amount').value; 
		document.getElementById('total_balance').innerHTML  = (rtotal_amount - val).toFixed(2);
		}
	function update_receipt(invioce,inv_number,amount,pay_for) 
	{
		document.getElementById('paid_amount').value = amount.toFixed(2);
		document.getElementById('payment_for_id').value  = invioce;
		document.getElementById('for_invoice').value = inv_number;
		//vinci//
		document.getElementById('payment_for').value = pay_for;
		document.getElementById('rtotal_amount').value = amount.toFixed(2);
		document.getElementById('rtotal_amount_txt').innerHTML = amount.toFixed(2);
		document.getElementById('total_balance').innerHTML = amount.toFixed(2);
		update_receipt_amount(document.getElementById('paid_amount').value);		
	}
	
	function submitReceipt() {
		var receipt_number = $("#receipt_number").val();
		var receipt_date = $(".receipt_date").val();
		var cust_id = $("#cust_id").val();
		var cust_name = $("#cust_name").val();
		var payment_for_id = $("#payment_for_id").val();
		var payment_for = $("#payment_for").val();
		var paid_amount = $("#paid_amount").val();
		var paid_by = $("#paid_by:checked").val();
		var check_date = $(".check_date").val();
		var name_on_check = $("#name_on_check").val();
		var check_or_account_number = $("#check_or_account_number").val();
		var bank_name = $("#bank_name").val();
		
		var dataString = 'receipt_number='+ receipt_number + '&receipt_date='+ receipt_date + '&customer_id='+ cust_id + '&customer_name='+ cust_name+ '&invoice_id='+ payment_for_id + '&receipt_for='+ payment_for + '&amount='+ paid_amount+ '&paid_by='+ paid_by + '&paid_date='+ check_date + '&account_name='+ name_on_check+ '&account_number='+ check_or_account_number+ '&bank_name='+ bank_name+ '&invoice_type=Expenses';
		
		
		if(cust_name==''||receipt_number==''||paid_amount==''||paid_by=='')
		{
		alert("Please Fill All Fields");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "submitExpReceipt.php",
				data: dataString,
				cache: false,
				success: function(result)
				{
					alert("Receipt created");
					outstanding_expenses(<?php echo $id; ?>);
					document.getElementById('paid_amount').value  = 0;
					update_receipt(0,'',0,'');
				}
			});
		}
		return false;
				
	}
</script>