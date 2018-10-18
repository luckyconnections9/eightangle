<?php
class salstatementClass
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

	 
	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N' ");
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
	
	 /* paging */
	 
	public function saldata($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$i = 1; $balance = 0; $credit_total = 0; $debit_total =0;
		if($stmt->rowCount()>0)
		{
			$type=""; $view=""; $print="";
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				if($row->type == "Sale Invoice") 
				{ 
					$type = $row->type; 
					if($row->invtype == "Reverse") {
						$credit = "";
						$debit = $row->amt;
						$debit_total = $debit_total + $debit;
						$balance = $balance - $row->amt;
					} else {
						$credit = $row->amt;
						$debit = "";
						$credit_total = $credit_total + $credit;
						$balance = $balance + $row->amt;
					}
					$view =  "<a href='invoice_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printsaleinvoice.php?print_id=".$row->id."' target='_blank' ><i class='fa fa-print'></i></a>";
				}
				if($row->type == "Purchase Invoice") 
				{ 
					$type = $row->type; 
					$credit = "";
					$debit = $row->amt;
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->amt;
					$view =  "<a href='pus_invoice_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printpurchaseinvoice.php?print_id=".$row->id."' target='_blank' ><i class='fa fa-print'></i></a>";
				} 
				if($row->type == "Sale") 
				{  
					$type = "Receipt";  
					
					if($row->invtype == "Reverse") {
						$credit = $row->amt;
						$debit = "";
						$credit_total = $credit_total + $credit;
						$balance = $balance + $row->amt;
					} else {
						$credit = "";
						$debit = $row->amt;
						$debit_total = $debit_total + $debit;
						$balance = $balance - $row->amt;
					}
					$view =  "<a href='receipt_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printsalereceipt.php?print_id=".$row->id."' target='_blank' ><i class='fa fa-print'></i></a>";
				} 
				if($row->type == "Purchase") 
				{  
					$type = "Payment";  
					$credit = $row->amt;
					$debit = "";
					$credit_total = $credit_total + $credit;
					$balance = $balance + $row->amt;
					$view =  "";
				}
				?>
				<tr>
					 <td><?php echo $i;?></td>
					 <td><?php echo displaydateformat('d-m-Y',substr($row->t,0,10));?></td>
					 <td><?php  echo $type;?><?php if($row->invtype == "Reverse") { ?><span class="pull-right">[<?php echo $row->invtype; ?>]</span><?php } ?></td>
					 <td><?php echo html_entity_decode($row->reference); ?>
						<span class="pull-right"><?php echo $view; ?></span>
					 </td>
					 <td><?php echo $credit; ?></td>
					 <td><?php echo $debit;   ?></td>
					 <td><?php echo num($balance); ?></td>
				
				</tr>
				<!-- Modal HTML -->
						<div id="myModal<?php print($i); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php $i = $i+1;
			}
			?>
			<tr>
							 <th colspan="4"><span class="pull-right">Total:</span></th>
							 <th><?php echo num($credit_total); ?></th>
							 <th><?php echo num($debit_total); ?></th>
							 <th><?php echo num($balance); ?></th>
					    </tr>
			<?php
		}
		else
		{
		?>
			<tr>
				<td colspan="7">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
	public function saldataprint($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$i = 1; $balance = 0; $credit_total = 0; $debit_total =0;
		if($stmt->rowCount()>0)
		{
			$type=""; $view=""; $print="";
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				if($row->type == "Sale Invoice") 
				{ 
					$type = $row->type; 
					$credit = $row->amt;
					$debit = "";
					$credit_total = $credit_total + $credit;
					$balance = $balance + $row->amt;
					if($row->invtype == "Reverse") {
						$credit = "";
						$debit = $row->amt;
						$debit_total = $debit_total + $debit;
						$balance = $balance - $row->amt;
					}
				}
				if($row->type == "Purchase Invoice") 
				{ 
					$type = $row->type; 
					$credit = "";
					$debit = $row->amt;
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->amt;
				} 
				if($row->type == "Sale") 
				{  
					$type = "Receipt";  
					$credit = "";
					$debit = $row->amt;
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->amt;
					if($row->invtype == "Reverse") {
						$credit = $row->amt;
						$debit = "";
						$credit_total = $credit_total + $credit;
						$balance = $balance + $row->amt;
					}
				} 
				if($row->type == "Purchase") 
				{  
					$type = "Payment";  
					$credit = $row->amt;
					$debit = "";
					$credit_total = $credit_total + $credit;
					$balance = $balance + $row->amt;
					$view =  "";
				}
				?>
				<tr>
					 <td><?php echo $i;?></td>
					 <td><?php echo displaydateformat('d-m-Y',substr($row->t,0,10));?></td>
					 <td><?php  echo $type;?><?php if($row->invtype == "Reverse") { ?><span class="pull-right">[<?php echo $row->invtype; ?>]</span><?php } ?></td>
					 <td><?php echo html_entity_decode($row->reference); ?>
						<span class="pull-right"><?php echo $view; ?></span>
					 </td>
					 <td><?php echo $credit; ?></td>
					 <td><?php echo $debit;   ?></td>
					 <td><?php echo num($balance); ?></td>
				
				</tr>
				<!-- Modal HTML -->
						<div id="myModal<?php print($i); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php $i = $i+1;
			}
			?>
			<tr>
							 <th colspan="4"><span class="pull-right">Total:</span></th>
							 <th><?php echo num($credit_total); ?></th>
							 <th><?php echo num($debit_total); ?></th>
							 <th><?php echo num($balance); ?></th>
					    </tr>
			<?php
		}
		else
		{
		?>
			<tr>
				<td colspan="7">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
	 public function salestatement($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$i = 1; $balance = 0; $credit_total = 0; $debit_total =0;
		if($stmt->rowCount()>0)
		{
			$type=""; $view=""; $print="";
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				if($row->invoice_type == "Sale Invoice") 
				{
					$debit = $row->balance;
					$credit = "";
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->balance;
					$view =  "<a href='invoice_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printsaleinvoice.php?print_id=".$row->id."' target='_blank' ><i class='fa fa-print'></i></a>";
				}				
				if($row->invoice_type == "Debit Receipt") 
				{
					$debit = $row->balance;
					$credit = "";
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->balance;
					
					$view =  "<a href='receivable_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printcdssalereceipt.php?print_id=".$row->id."' title='Print small receipt' target='_blank' ><i class='fa fa-print'></i></a> &nbsp; 
					<a href='printcdsalereceipt.php?print_id=".$row->id."' title='Print full receipt' target='_blank' ><i class='fa fa-print text-green'></i></a>";
				}			
				if($row->invoice_type == "Credit Receipt") 
				{
					$debit ="";
					$credit = $row->balance;
					$credit_total = $credit_total + $credit;
					$balance = $balance + $row->balance;
					
					$view =  "<a href='receivable_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printcdssalereceipt.php?print_id=".$row->id."' title='Print small receipt' target='_blank' ><i class='fa fa-print'></i></a> &nbsp; 
					<a href='printcdsalereceipt.php?print_id=".$row->id."' title='Print full receipt' target='_blank' ><i class='fa fa-print text-green'></i></a>";
				}
				
				?>
				<tr>
					 <td><?php echo $i;?></td>
					 <td><?php echo displaydateformat('d-m-Y',substr($row->dt_created,0,10));?></td>
					 <td><?php echo html_entity_decode($row->invoice_type);?></td>
					 <td><?php echo html_entity_decode($row->invoice_number); ?>
						<span class="pull-right"><?php echo $view; ?></span>
					 </td>
					 <td><?php echo $credit; ?></td>
					 <td><?php echo $debit;   ?></td>
					 <td><?php if($balance< 0) { echo num(-($balance)) ."<b> dr</b>"; } else { echo num($balance)."<b> cr</b>"; } ?></td>
				
				</tr>
				<!-- Modal HTML -->
						<div id="myModal<?php print($i); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php $i = $i+1;
			}
			?>
			<tr>
							 <th colspan="4"><span class="pull-right">Total:</span></th>
							 <th><?php echo num($credit_total); ?></th>
							 <th><?php echo num($debit_total); ?></th>
							 <th><?php if($balance< 0) { echo num(-($balance)) ."<b> dr</b> "; } else { echo num($balance)."<b> cr</b>"; } ?></th>
					    </tr>
			<?php
		}
		else
		{
		?>
			<tr>
				<td colspan="7">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	  public function salestatementprint($query,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$i = 1; $balance = 0; $credit_total = 0; $debit_total =0;
		if($stmt->rowCount()>0)
		{
			$type=""; $view=""; $print="";
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				if($row->invoice_type == "Sale Invoice") 
				{
					$debit = $row->balance;
					$credit = "";
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->balance;
					$view =  "<a href='invoice_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printsaleinvoice.php?print_id=".$row->id."' target='_blank' ><i class='fa fa-print'></i></a>";
				}				
				if($row->invoice_type == "Debit Receipt") 
				{
					$debit = $row->balance;
					$credit = "";
					$debit_total = $debit_total + $debit;
					$balance = $balance - $row->balance;
					
					$view =  "<a href='receivable_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printcdssalereceipt.php?print_id=".$row->id."' title='Print small receipt' target='_blank' ><i class='fa fa-print'></i></a> &nbsp; 
					<a href='printcdsalereceipt.php?print_id=".$row->id."' title='Print full receipt' target='_blank' ><i class='fa fa-print text-green'></i></a>";
				}			
				if($row->invoice_type == "Credit Receipt") 
				{
					$debit ="";
					$credit = $row->balance;
					$credit_total = $credit_total + $credit;
					$balance = $balance + $row->balance;
					
					$view =  "<a href='receivable_view.php?print_id=".$row->id."' data-toggle='modal' data-target='#myModal".$i."' title='View'><i class='fa fa-eye'></i></a> &nbsp; 
					<a href='printcdssalereceipt.php?print_id=".$row->id."' title='Print small receipt' target='_blank' ><i class='fa fa-print'></i></a> &nbsp; 
					<a href='printcdsalereceipt.php?print_id=".$row->id."' title='Print full receipt' target='_blank' ><i class='fa fa-print text-green'></i></a>";
				}
				
				?>
				<tr>
					 <td><?php echo $i;?></td>
					 <td><?php echo displaydateformat('d-m-Y',substr($row->dt_created,0,10));?></td>
					 <td><?php echo html_entity_decode($row->invoice_type);?></td>
					 <td><?php echo html_entity_decode($row->invoice_number); ?>
					 </td>
					 <td><?php echo $credit; ?></td>
					 <td><?php echo $debit;   ?></td>
					 <td><?php if($balance < 0) { echo num(-($balance)) ." <b>dr</b>"; } else { echo num($balance)."<b> cr</b>"; } ?></td>
				
				</tr>
				<!-- Modal HTML -->
						<div id="myModal<?php print($i); ?>" class="modal fade">
							<div class="modal-content">
								 
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
				<?php $i = $i+1;
			}
			?>
			<tr>
							 <th colspan="4"><span class="pull-right">Total:</span></th>
							 <th><?php echo num($credit_total); ?></th>
							 <th><?php echo num($debit_total); ?></th>
							 <th><?php if($balance < 0) { echo num(-($balance)) ."<b> dr</b>"; } else { echo num($balance)."<b> cr</b>"; } ?></th>
					    </tr>
			<?php
		}
		else
		{
		?>
			<tr>
				<td colspan="7">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
	 
 /* paging */ 
}
?>