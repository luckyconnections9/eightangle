<?php
class receivableClass
{
	private $db; 
	private $user_id;
	private $company_id;
	 
	function __construct()
	{
		$this->db = getDB();
		$this->user_id = $_SESSION['uid'];
		$this->company_id = $_SESSION['company_id'];
	}


	 
	public function getID($id,$type)
	{
		$stmt = $this->db->prepare("SELECT * FROM receivable WHERE id=:id AND `invoice_type`=:type AND `company_id` = $this->company_id  AND `user_id` = $this->user_id ");
		$stmt->execute(array(":id"=>$id,":type"=>$type));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getCity($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM city WHERE ID=:id  ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	
	public function getCustomer($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id AND `user_id` = $this->user_id ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	 
	public function getReceiptnumber($invoice_type)
	{
		$stmt = $this->db->prepare("SELECT id,receipt_number FROM receivable WHERE `company_id` = $this->company_id AND `user_id` = $this->user_id AND `invoice_type` = :invoice_type GROUP BY `receipt_number` ");
		$stmt->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count >= 1) 
		{
			$editRow=$stmt->fetch(PDO::FETCH_OBJ);
				return sprintf("%03d", ($count+1));
		} 
		else 
		{
			return sprintf("%03d", 1);
		}
	}
		 
	public function getDCReceiptnumber()
	{
		$stmt = $this->db->prepare("SELECT id,invoice_number FROM orders WHERE  `company_id` = $this->company_id  AND `deleted` = 'N' AND (`invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Credit Receipt') ");
		$stmt->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count >= 1) 
		{
			$editRow=$stmt->fetch(PDO::FETCH_OBJ);
				return sprintf("%03d", ($count+1));
		} 
		else 
		{
			return sprintf("%03d", 1);
		}
	}	
	
	public function getDCpurchaseReceiptnumber()
	{
		$stmt = $this->db->prepare("SELECT id,invoice_number FROM vendor_orders WHERE  `company_id` = $this->company_id  AND `deleted` = 'N' AND (`invoice_type` = 'Debit Receipt' OR `invoice_type` = 'Credit Receipt') ");
		$stmt->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count >= 1) 
		{
			$editRow=$stmt->fetch(PDO::FETCH_OBJ);
				return sprintf("%03d", ($count+1));
		} 
		else 
		{
			return sprintf("%03d", 1);
		}
	}
	
	public function dataview($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$i = 1;
		$total=0;
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$total= $total+$row->outstanding;	
				$cust_data = receivableClass::getCustomer($row->customer_id);	
				?>
				<tr>
					<td><?php print(html_entity_decode($i)); ?></td>
					<td><?php if($row->customer_id) { print($cust_data->name); } else { print($row->contactname); } ?></td>
					<td><?php print($row->outstanding);  ?></td>	
					<td align="center">
						<a href="javascript:;" onClick="return outstanding_invoice(<?php echo $row->customer_id; ?>);" class="btn btn-primary">View/Recieve</a>
					</td>
				</tr>							
				<?php $i = $i+1;
			}
			?>
			<?php	
		}
		else
		{
		?>
			<tr>
				<td colspan="4">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
	public function vdataview($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$total=0;
		$i = 1;
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$total= $total+$row->outstanding;	
				$ven_data = receivableClass::getCustomer($row->customer_id);	
				?>
				<tr>
					<td><?php print(html_entity_decode($i)); ?></td>
					<td><?php if($row->customer_id) { print($ven_data->name); } else { print($row->contactname); } ?></td>
					<td><?php print($row->outstanding);  ?></td>	
					<td align="center">
						<a href="javascript:;" onClick="return outstanding_payable(<?php echo $row->customer_id; ?>);" class="btn btn-primary">View/Pay</a>
					</td>
				</tr>
				<?php $i = $i+1;
			}
			?>
			<tr>
				<td colspan="2">Total</td>
				
				<td><?php echo num($total) ?></td>
				<td></td>
				
			</tr>
			<?php	
		}
		else
		{
		?>
			<tr>
				<td colspan="10">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
	public function getInvoice($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM orders WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getInvoicep($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM vendor_orders WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function dataviewr($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
	 
		if($stmt->rowCount()>0)
		{
			$i = 1;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$inv_data = receivableClass::getInvoice($row->invoice_id);	
			?>
				<tr>
					<td><?php print($row->invoice_number); ?></td>
					<td><?php print($inv_data->invoice_number); ?></td>
					<td><?php print(html_entity_decode(displaydate(substr($row->dt_created,0,10)))); ?></td>
			<td><?php if($row->customer_id) { print($row->cname); } else { print($row->contactname); } ?></td>
					<td><?php print(html_entity_decode($row->nettotal)); ?></td>
					<td><?php print(html_entity_decode($row->tax)); ?></td>
					<td><?php print(html_entity_decode($row->discount)); ?></td>
					<td><?php $ttl= number_format(($row->nettotal - $row->discount ) + $row->tax, 2, '.', '');print(html_entity_decode( round($ttl - $row->invoice_discount + $row->freight))); ?></td>
					<td  align="center">
						<a href="receivable_edit.php?edit_id=<?php print($row->id); ?>&code=<?php print($row->code); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="receivable_view.php?print_id=<?php print($row->id); ?>" data-toggle="modal" data-target="#myModal<?php print($row->id); ?>" title="View Receipt"><i class="fa fa-eye"></i></a>
					</td>
					<td align="center">
						<a href="printcdssalereceipt.php?print_id=<?php print($row->id); ?>" title="Print Small Receipt" target="_blank" ><i class="fa fa-print"></i></a>
					</td>
					<td align="center">
						<a href="printcdsalereceipt.php?print_id=<?php print($row->id); ?>" target="_blank" title="Print Full receipt"><i class="fa fa-print text-green"></i></a>
					</td>
					<td align="center">
					<?php if($i == 1) { ?>
						<a href="receivable_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					<?php } ?>
					 <!-- Button HTML (to Trigger Modal) -->
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
				<td colspan="10">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
	public function dataviewp($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
	 
		if($stmt->rowCount()>0)
		{
			$i = 1;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$inv_data = receivableClass::getInvoicep($row->invoice_id);	
			?>
				<tr>
					<td><?php print($row->invoice_number); ?></td>
					<td><?php print($inv_data->invoice_number); ?></td>
					<td><?php print(html_entity_decode(displaydate(substr($row->dt_created,0,10)))); ?></td>
			<td><?php if($row->customer_id) { print($row->cname); } else { print($row->contactname); } ?></td>
					<td><?php print(html_entity_decode($row->nettotal)); ?></td>
					<td><?php print(html_entity_decode($row->tax)); ?></td>
					<td><?php print(html_entity_decode($row->discount)); ?></td>
					<td><?php $ttl= number_format(($row->nettotal - $row->discount ) + $row->tax, 2, '.', '');print(html_entity_decode( round($ttl - $row->invoice_discount + $row->freight))); ?></td>
					<td  align="center">
						<a href="payable_edit.php?edit_id=<?php print($row->id); ?>&code=<?php print($row->code); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="payable_view.php?print_id=<?php print($row->id); ?>" data-toggle="modal" data-target="#myModal<?php print($row->id); ?>" title="View Receipt"><i class="fa fa-eye"></i></a>
					</td>
					<td align="center">
						<a href="printcdspurchasereceipt.php?print_id=<?php print($row->id); ?>" title="Print Small Receipt" target="_blank" ><i class="fa fa-print"></i></a>
					</td>
					<td align="center">
						<a href="printcdpurchasereceipt.php?print_id=<?php print($row->id); ?>" target="_blank" title="Print Full receipt"><i class="fa fa-print text-green"></i></a>
					</td>
					<td align="center">
					<?php if($i == 1) { ?>
						<a href="purchase_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					<?php } ?>
					 <!-- Button HTML (to Trigger Modal) -->
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
				<td colspan="10">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
}
?>