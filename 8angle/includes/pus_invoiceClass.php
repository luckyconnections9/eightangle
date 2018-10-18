<?php
class pus_invoiceClass
{
	private $db;
	private $user_id;
	private $company_id;
	 
	function __construct()
	{
		$this->db = getDB();
	@	$this->user_id = $_SESSION['uid'];
	@	$this->company_id = $_SESSION['company_id'];
	}
	 
	public function create($invoice_number_value,$invtype,$inv_user,$date,$inv_user_name,$customer_state,$inv_discount,$code,$same_as_billing_address,$address,$city,$state,$inv_comment,$invoice_reference,$due_period,$show_hsn,$show_tax,$billing_address_id,$ship_to,$gst,$pin,$invoice_type,$invoice_id)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM `vendor_orders` WHERE invoice_number=:invoice_number_value  AND `company_id` = $this->company_id  AND `deleted` = 'N' ");
			$st->bindparam(":invoice_number_value",$invoice_number_value,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO vendor_orders(invoice_number,invtype,customer_id,dt_created,contactname,customer_state
,invoice_discount,code,same_as_billing_address,address,city,state,comment,invoice_reference,due_period,show_hsn,show_tax,company_id,user_id,billing_address_id,ship_to,gst,pin,invoice_type,invoice_id) VALUES(:invoice_number_value,:invtype,:inv_user,:date,:inv_user_name,:customer_state
,:inv_discount,:code,:same_as_billing_address,:address,:city,:state,:inv_comment,:invoice_reference,:due_period,:show_hsn,:show_tax,$this->company_id,$this->user_id,:billing_address_id,:ship_to,:gst,:pin,:invoice_type,:invoice_id)");
				$stmt->bindparam(":invoice_number_value",$invoice_number_value,PDO::PARAM_STR);
				$stmt->bindparam(":invtype",$invtype,PDO::PARAM_STR);
				$stmt->bindparam(":inv_user",$inv_user,PDO::PARAM_INT);
				$stmt->bindparam(":date",$date,PDO::PARAM_STR);
				$stmt->bindparam(":inv_user_name",$inv_user_name,PDO::PARAM_STR);
				$stmt->bindparam(":customer_state",$customer_state,PDO::PARAM_STR);
				$stmt->bindparam(":inv_discount",$inv_discount,PDO::PARAM_STR);
				$stmt->bindparam(":code",$code,PDO::PARAM_STR);
				$stmt->bindparam(":same_as_billing_address",$same_as_billing_address,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_INT);
				$stmt->bindparam(":inv_comment",$inv_comment,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_reference",$invoice_reference,PDO::PARAM_STR);
				$stmt->bindparam(":due_period",$due_period,PDO::PARAM_STR);
				$stmt->bindparam(":show_hsn",$show_hsn,PDO::PARAM_STR);
				$stmt->bindparam(":show_tax",$show_tax,PDO::PARAM_STR);
				$stmt->bindparam(":billing_address_id",$billing_address_id,PDO::PARAM_INT);
				$stmt->bindparam(":ship_to",$ship_to,PDO::PARAM_STR);
				$stmt->bindparam(":gst",$gst,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_id",$invoice_id,PDO::PARAM_INT);
				$stmt->execute();
				
				return $this->db->lastInsertId();
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	 
	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM vendor_orders WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getCustomer($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' and `status` = 'Enable'");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
	public function getCompany($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM companies WHERE id=:id  AND `deleted` = 'N' and `status` = 'Enable'");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
	public function chkBalance($inv_id)
	{
		$stmt = $this->db->prepare("SELECT SUM(paid_amount) FROM `vendor_orders` WHERE `invoice_number` = :inv_id ");
		$stmt->bindparam(":inv_id",$inv_id,PDO::PARAM_INT);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->paid_amount);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function getInvoicenumber()
	{
		$stmt = $this->db->prepare("SELECT purchase_invoice_number,purchase_invoice_prefix,purchase_invoice_number_start FROM companies WHERE `id` = $this->company_id AND `deleted` = 'N' LIMIT 1");
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if(!empty($editRow->purchase_invoice_prefix)) {
			
			$st = $this->db->prepare("SELECT id,invoice_number FROM vendor_orders WHERE invoice_number LIKE '".$editRow->purchase_invoice_prefix."%'  AND `company_id` = $this->company_id  AND `invoice_type` = 'Purchase Invoice'  AND `deleted` = 'N' ORDER BY `id` DESC ");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count >= 1) {
				$Row=$st->fetch(PDO::FETCH_OBJ);
				$inv_num = $editRow->purchase_invoice_prefix. sprintf("%03d", $count+$editRow->purchase_invoice_number_start);
				$inv_num1 = $editRow->purchase_invoice_prefix. sprintf("%03d", $editRow->purchase_invoice_number_start);
				$last_num = str_replace($editRow->purchase_invoice_prefix,"",$Row->invoice_number);
				
				if( $inv_num1 == $Row->invoice_number ) 
					{
						return $editRow->purchase_invoice_prefix. sprintf("%03d", ($editRow->purchase_invoice_number_start+1));
					}
					else 
					{
						if($last_num < $editRow->purchase_invoice_number_start) {
							return $editRow->purchase_invoice_prefix. sprintf("%03d",  $editRow->purchase_invoice_number_start);
						}
						if($last_num >= $editRow->purchase_invoice_number_start) {
							return $editRow->purchase_invoice_prefix. sprintf("%03d",  $last_num+1);
						}
					}
			} else {
				return $editRow->purchase_invoice_prefix. sprintf("%03d",  $editRow->purchase_invoice_number_start);
			}
		} else {
			return "";
		}
	}
	
	public function update_balance($order_id,$nettotal,$tax,$discount,$total,$balance,$freight,$invoice_paid,$paid_amount)
	{
		try
		{
			if(empty(pus_invoiceClass::getID($order_id))) { return false; } 

				$stmt=$this->db->prepare("UPDATE vendor_orders SET nettotal=:nettotal,tax=:tax, discount=:discount, total=:total ,balance=:balance ,freight=:freight,invoice_paid=:invoice_paid, paid_amount=:paid_amount WHERE id=:order_id ");
				$stmt->bindparam(":nettotal",$nettotal,PDO::PARAM_STR);
				$stmt->bindparam(":tax",$tax,PDO::PARAM_STR);
				$stmt->bindparam(":discount",$discount,PDO::PARAM_STR);
				$stmt->bindparam(":total",$total,PDO::PARAM_STR);
				$stmt->bindparam(":balance",$balance,PDO::PARAM_STR);
				$stmt->bindparam(":freight",$freight,PDO::PARAM_STR);
				$stmt->bindparam(":paid_amount",$paid_amount,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_paid",$invoice_paid,PDO::PARAM_STR);
				$stmt->bindparam(":order_id",$order_id,PDO::PARAM_INT);
				$stmt->execute();
			   
				return true; 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	
	public function update_payment_details($order_id,$paid_by,$paid_date,$name_on_check,$check_or_account_number,$bank_name,$remarks)
	{
		try
		{
			if(empty(pus_invoiceClass::getID($order_id))) { return false; } 

				$stmt=$this->db->prepare("UPDATE vendor_orders SET paid_by=:paid_by,paid_date=:paid_date, account_name=:name_on_check, account_number=:check_or_account_number ,bank_name=:bank_name, remarks=:remarks WHERE id=:order_id ");
				$stmt->bindparam(":paid_by",$paid_by,PDO::PARAM_STR);
				$stmt->bindparam(":paid_date",$paid_date,PDO::PARAM_STR);
				$stmt->bindparam(":name_on_check",$name_on_check,PDO::PARAM_STR);
				$stmt->bindparam(":check_or_account_number",$check_or_account_number,PDO::PARAM_STR);
				$stmt->bindparam(":bank_name",$bank_name,PDO::PARAM_STR);
				$stmt->bindparam(":remarks",$remarks,PDO::PARAM_STR);
				$stmt->bindparam(":order_id",$order_id,PDO::PARAM_INT);
				$stmt->execute();
			   
				return true; 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	
	public function update($order_id,$invoice_number_value,$invtype,$inv_user,$date,$inv_user_name,$customer_state,$inv_discount,$code,$same_as_billing_address,$address,$city,$state,$inv_comment,$invoice_reference,$due_period,$billing_address_id,$ship_to,$gst,$pin)
	{
		try
		{
			if(empty(pus_invoiceClass::getID($order_id))) { return false; } 
			
				$stmt=$this->db->prepare("UPDATE vendor_orders SET invoice_number=:invoice_number_value, invtype=:invtype, customer_id=:inv_user, dt_created=:date, contactname=:inv_user_name,customer_state=:customer_state , invoice_discount=:inv_discount, code=:code, same_as_billing_address=:same_as_billing_address, address=:address, city=:city, state=:state, comment=:inv_comment, invoice_reference=:invoice_reference, due_period=:due_period, billing_address_id=:billing_address_id, ship_to=:ship_to, gst=:gst, pin=:pin WHERE id=:order_id "); 
					$stmt->bindparam(":invoice_number_value",$invoice_number_value,PDO::PARAM_STR);
					$stmt->bindparam(":invtype",$invtype,PDO::PARAM_STR);
					$stmt->bindparam(":inv_user",$inv_user,PDO::PARAM_INT);
					$stmt->bindparam(":date",$date,PDO::PARAM_STR);
					$stmt->bindparam(":inv_user_name",$inv_user_name,PDO::PARAM_STR);
					$stmt->bindparam(":customer_state",$customer_state,PDO::PARAM_STR);	
					$stmt->bindparam(":inv_discount",$inv_discount,PDO::PARAM_STR);
					$stmt->bindparam(":code",$code,PDO::PARAM_STR);
					$stmt->bindparam(":same_as_billing_address",$same_as_billing_address,PDO::PARAM_STR);
					$stmt->bindparam(":address",$address,PDO::PARAM_STR);
					$stmt->bindparam(":state",$state,PDO::PARAM_STR);
					$stmt->bindparam(":city",$city,PDO::PARAM_INT);
					$stmt->bindparam(":inv_comment",$inv_comment,PDO::PARAM_STR);
					$stmt->bindparam(":invoice_reference",$invoice_reference,PDO::PARAM_STR);
					$stmt->bindparam(":due_period",$due_period,PDO::PARAM_STR);
					$stmt->bindparam(":order_id",$order_id,PDO::PARAM_INT); 
					$stmt->bindparam(":billing_address_id",$billing_address_id,PDO::PARAM_INT);
					$stmt->bindparam(":ship_to",$ship_to,PDO::PARAM_STR);
					$stmt->bindparam(":gst",$gst,PDO::PARAM_STR);
					$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
					$stmt->execute();
			   
				return true; 

		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	 
	public function delete($id)
	{
		try
		{
			if(empty(pus_invoiceClass::getID($id))) { return false; }
			
				$stmt = $this->db->prepare("UPDATE vendor_orders SET deleted='Y' WHERE id=:id  AND `company_id` = $this->company_id ");
				$stmt->bindparam(":id",$id,PDO::PARAM_INT);
				$stmt->execute();
				$stmtstock = $this->db->prepare("UPDATE stock SET deleted='Y' WHERE order_id=:id AND `type` = 'IN'  AND `company_id` = $this->company_id ");
				$stmtstock->bindparam(":id",$id,PDO::PARAM_INT);
				$stmtstock->execute();
				return true;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	 
	 /* paging */
	 
	public function dataview($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
	 
		if($stmt->rowCount()>0)
		{
			$i = 1;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$cust_data = pus_invoiceClass::getCustomer($row->customer_id);	
			?>
				<tr>
					<td><?php print($row->invoice_number); ?></td>
					<td><?php print(html_entity_decode(displaydate(substr($row->dt_created,0,10)))); ?></td>
					<td><?php if($row->customer_id) { print($row->cname); } else { print($row->contactname); } ?></td>
					<td><?php print(html_entity_decode($row->nettotal)); ?></td>
					<td><?php if($row->state == $row->customer_state)  print(html_entity_decode($row->cgst)); ?></td>
					<td><?php if($row->state == $row->customer_state)  print(html_entity_decode($row->sgst)); ?></td>
					<td><?php if($row->state != $row->customer_state) print(html_entity_decode($row->igst)); ?></td>
					
					<td><?php print(html_entity_decode($row->discount)); ?></td>
					<td><?php $ttl= number_format(($row->nettotal - $row->discount ) + $row->tax, 2, '.', ''); print(html_entity_decode(round($ttl))); ?></td>
					<td><?php print(html_entity_decode($row->invoice_discount)); ?></td>
					<td><?php print(html_entity_decode($row->freight)); ?></td>
					<td><?php print(html_entity_decode( round($ttl - $row->invoice_discount + $row->freight))); ?></td>
					<td  align="center">
						<a href="pus_invoice_edit.php?edit_id=<?php print($row->id); ?>&code=<?php print($row->code); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="pus_invoice_view.php?print_id=<?php print($row->id); ?>" data-toggle="modal" data-target="#myModal<?php print($row->id); ?>" title="View Purchase Invoice"><i class="fa fa-eye"></i></a>
					</td>
					<td align="center">
						<a href="printpurchaseinvoice.php?print_id=<?php print($row->id); ?>" target="_blank" ><i class="fa fa-print"></i></a>
					</td>
					<td align="center">
						<a title="Create Receipt" href="payable_add.php?inv_id=<?php print($row->id); ?>" ><i class="fa fa-file-text-o"></i></a>
					</td>
					<td align="center">
					<?php if($i == 1) { ?>
						<a href="pus_invoice_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					<?php } ?>
					</td>
				</tr>
				 <!-- Modal HTML -->
						<div id="myModal<?php print($row->id); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php
				$i = $i+1;;
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="17">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
	public function dataviewnon($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
	 
		if($stmt->rowCount()>0)
		{
			$i = 1;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$cust_data = pus_invoiceClass::getCustomer($row->customer_id);	
			?>
				<tr>
					<td><?php print($row->invoice_number); ?></td>
					<td><?php print(html_entity_decode(displaydate(substr($row->dt_created,0,10)))); ?></td>
					<td><?php if($row->customer_id) { print($cust_data->name); } else { print($row->contactname); } ?></td>
					<td><?php print(html_entity_decode($row->nettotal)); ?></td>
					<td><?php print(html_entity_decode($row->tax)); ?></td>
					<td><?php print(html_entity_decode($row->discount)); ?></td>
					<td><?php $ttl= number_format(($row->nettotal - $row->discount ) + $row->tax, 2, '.', ''); print(html_entity_decode(round($ttl))); ?></td>
					<td><?php print(html_entity_decode($row->invoice_discount)); ?></td>
					<td><?php print(html_entity_decode($row->freight)); ?></td>
					<td><?php print(html_entity_decode( round($ttl - $row->invoice_discount + $row->freight))); ?></td>
					<td  align="center">
						<a href="pus_invoice_edit.php?edit_id=<?php print($row->id); ?>&code=<?php print($row->code); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="pus_invoice_view.php?print_id=<?php print($row->id); ?>" data-toggle="modal" data-target="#myModal<?php print($row->id); ?>" title="View Purchase Invoice"><i class="fa fa-eye"></i></a>
					</td>
					<td align="center">
						<a href="printpurchaseinvoice.php?print_id=<?php print($row->id); ?>" target="_blank" ><i class="fa fa-print"></i></a>
					</td>
					<td align="center">
					<?php if($i == 1) { ?>
						<a href="pus_invoice_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					<?php } ?>
					</td>
				</tr>
				 <!-- Modal HTML -->
						<div id="myModal<?php print($row->id); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php
				$i = $i+1;;
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="14">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
}
?>