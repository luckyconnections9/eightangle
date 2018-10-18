<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
$hsn_code_display = "none";
$company_data = $crud->getID($company_id);
$show_hsn = ($_POST['show_hsn']);
$show_tax = ($_POST['show_tax']);
	if($show_hsn == "Enable") 
	{ 
		$hsn_code_display = "visible"; 
	}
	$tax_display = "none";
	if($show_tax == "Enable") 
	{ 
		$tax_display = "visible"; 
	}
    $return_arr = array();
    $param = ($_POST['sa']);
	$divs = ($_POST['div']);
	$desc = ($_POST['desc']);  
	
	$params = array();
	
	$params[':param'] = $param;	
	$params[':company_id'] = $company_id;
	
	$stmt_product = getDB()->prepare("SELECT * FROM `products` WHERE  `id` = :param AND `company_id` = :company_id AND `status` = 'Enable' AND `deleted` = 'N' LIMIT 1");
	$stmt_product->execute($params);
	if($stmt_product->rowCount() >0) {
		/* Retrieve and store in array the results of the query.*/
		while ($row = $stmt_product->fetch(PDO::FETCH_OBJ)) 
		{
			$row_array['inv_product_id'] 		    = $row->id;
			$row_array['inv_product_code'] 		    = $row->code;
			$row_array['inv_product_name'] 		    = $row->name;
			$row_array['inv_product_desc'] 			= $row->description;
			$row_array['inv_product_cost']      	= $row->sell_price;
			$row_array['tax_type']      	= $row->tax_id;
			//array_push( $return_arr, $row_array );
			?>
			
			<td><a class="delete" title="remove Item"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
			<input  name="inv_product_id[]" readonly="readonly" type="hidden"   value="<?php echo $row->id; ?>" id="inv_product_id"  tabindex="1" />
			<td><input  class="form-control"  name="inv_product_name[]"  value="<?php echo $row->name; ?>" id="inv_product_name" autocomplete="off" onkeyup="load_search(this.value,<?php echo $divs;?>)" tabindex="1" /><br/><span id="showdata<?php echo $divs;?>" class="showdata"></span>
			</td>
			<td>
				<select  name="inv_product_type[]" id="inv_product_type"  class="inv_product_type  form-control" >
					<option <?php if($row->product_type == "Goods") { echo "selected"; }?> value="Goods">Goods</option>
					<option <?php if($row->product_type == "Services") { echo "selected"; }?> value="Services">Services</option>
				</select>
			</td>
			<td style="display:<?php echo $hsn_code_display;?>"><span class="HSN_code_show"><?php echo $row->hsn_code; ?></span></td>
			<td>
				<select  name="inv_product_unit[]" id="inv_product_unit"  class="inv_product_unit  form-control" >
					<option value=""></option>
				<?php 
					$stmt_unit = getDB()->prepare("SELECT * FROM products_unit WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
					$stmt_unit->execute();
					$stmt_unit_sel = "";
					 while($data_unit=$stmt_unit->fetch(PDO::FETCH_OBJ))
					 {
						 if($data_unit->id == $row->products_unit_id) { $stmt_unit_sel ="selected='selected'";}  else { $stmt_unit_sel ="";}
						 
						echo "<option ".$stmt_unit_sel."  value=".$data_unit->id.">".$data_unit->unit ."</option>";
					 }
					 ?>
				</select>
			</td>
			<td><input type="text" value="1"  class="qty  form-control" name="inv_product_qty[]"  id="inv_product_qty" /></td>
			<td><input type="text"  value="<?php echo $row->sell_price; ?>" class="cost  form-control" name="inv_product_cost[]"  id="inv_product_cost" /></td>
			<td style="display: <?php echo $tax_display;?>">
				<select name="tax_type[]"  onChange="load_taxes(this.value,<?php echo $divs;?>)" id="tax_type"  class="tax_type  form-control" >
				<option value=""></option>
				<?php 
				
				$taxv = 0; $cgst = 0; $sgst = 0;
				if($show_tax == "Enable") 
					{ 
					$stmt_tax = getDB()->prepare("SELECT * FROM invoice_tax WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
					$stmt_tax->execute(); 
					 while($data_tax = $stmt_tax->fetch(PDO::FETCH_OBJ))
					 {
						 if($data_tax->id == $row->tax_id) { $taxv = $data_tax->tax; $cgst =  $data_tax->cgst; $sgst =  $data_tax->sgst; $tax_sel ="selected='selected'"; } else {  $tax_sel = "";}
						echo "<option ".$tax_sel." value=".$data_tax->id.">".$data_tax->name."  ".$data_tax->tax."%</option>";
					 }
					} else {
						echo "<option value='0'></option>";
					}
					$amount_te = $row->sell_price + (($row->sell_price * $taxv) / 100);
					$total_amount_te = $row->sell_price;
					$total_tax = ($row->sell_price * $taxv) / 100;
					$grand_total = $total_amount_te + $total_tax;
					$cgst_amt = ($row->sell_price * $cgst) / 100;
					$sgst_amt = $total_tax-$cgst_amt;
					?>
				</select>
				<input  name="tax_amount[]"  class="tax_amount" readonly="readonly" type="hidden"  value="<?php echo $taxv;?>" id="tax_amount"  tabindex="1" />
				<span class="row_number"><?php echo $divs;?></span>
			</td>
			<td><input type="text" value="0.00"   class="discount form-control" name="inv_product_discount[]"  id="inv_product_discount" /> <span class="discount_amount"></span></td>
			<td><span class="total_amount_te"><?php echo number_format($total_amount_te,2); ?></span></td>
			<td  style="display: <?php echo $tax_display;?>"><span class="total_tax"><?php echo number_format($total_tax,2)?></span>
			<span class="tax_hidden"><input type="hidden" name="cgst_tax_percent[]" id="cgst_tax_percent" class="cgst_tax_percent" value="<?php echo number_format($cgst,2)?>"><span id="cgst_amt" class="cgst_amt"><?php echo number_format($cgst_amt,2)?></span> [ <input type="hidden" name="sgst_tax_percent[]" id="sgst_tax_percent" class="sgst_tax_percent" value="<?php echo number_format($sgst,2)?>"><span   class="sgst_amt" id="sgst_amt"><?php echo number_format($sgst_amt,2)?></span>]</span>
			</td>
			<td><span class="total_discount">0.00</span></td>
			<td>
				<input   type="text" value="<?php echo num($grand_total); ?>"  class="grand_total  form-control" name="grand_total[]"  id="grand_total" />
			</td>

			<?php
		}
	} else {
		?>
														<td><a class="delete" title="remove Item"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
														<input  name="inv_product_id[]" readonly="readonly" type="hidden"  value="0" id="inv_product_id"  tabindex="1" />
														<td><input name="inv_product_name[]" class="form-control" value="<?php echo $desc;?>" id="inv_product_name" autocomplete="off" onkeyup="load_search(this.value,<?php echo $divs;?>)" tabindex="1" /><br/><span id="showdata<?php echo $divs;?>"  class="showdata"></span>
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
															$stmt_unit = getDB()->prepare("SELECT * FROM products_unit WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
															$stmt_unit->execute();
															 while($data_unit=$stmt_unit->fetch(PDO::FETCH_OBJ))
															 {
																echo "<option  value=".$data_unit->id.">".$data_unit->unit ."</option>";
															 }
															 ?>
														</select>
														</td>
														<td><input type="text" value="1"  class="qty form-control" name="inv_product_qty[]"  id="inv_product_qty" /></td>
														<td><input type="text" value="0.00" class="cost form-control" name="inv_product_cost[]"  id="inv_product_cost" /></td>
														<td  style="display: <?php echo $tax_display;?>">
															<select name="tax_type[]" onChange="load_taxes(this.value,<?php echo $divs;?>)" id="tax_type"  class="tax_type form-control" >
																<option value=""></option>
																<?php 
																if($show_tax == "Enable") 
																{ 
																	$stmt_tax1 = getDB()->prepare("SELECT * FROM invoice_tax WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
																	$stmt_tax1->execute();
																	 while($data_tax1=$stmt_tax1->fetch(PDO::FETCH_OBJ))
																	 {
																		echo "<option value=".$data_tax1->id.">".$data_tax1->name."  ".$data_tax1->tax."%</option>";
																	 }
																}
																else {
																		echo "<option value='0'></option>";
																	}
																 ?>
															</select>
															<input  name="tax_amount[]"  class="tax_amount" readonly="readonly" type="hidden"  value="" id="tax_amount"  tabindex="1" />
															<span class="row_number"><?php echo $divs;?></span>
														</td>
														<td><input type="text" value="0.00"  class="discount form-control" name="inv_product_discount[]"  id="inv_product_discount" /> <span class="discount_amount"></span></td>
														<td><span class="total_amount_te">0.00</span></td>
														<td  style="display: <?php echo $tax_display;?>"><span class="total_tax">0.00</span>
														<span class="tax_hidden">
															<input type="hidden" name="cgst_tax_percent[]" id="cgst_tax_percent" class="cgst_tax_percent" value="0"><span id="cgst_amt" class="cgst_amt"></span> [ <input type="hidden" name="sgst_tax_percent[]" id="sgst_tax_percent" class="sgst_tax_percent" value="0"><span id="sgst_amt" class="sgst_amt"></span>]</span></td>
														<td><span class="total_discount">0.00</span></td>
														<td>
														<input   type="text" value="0"  class="grand_total  form-control" name="grand_total[]"  id="grand_total" />
													</td>
		<?php
	}
