<?php
class balancesheetClass
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
	
	
	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM orders WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getCustomer($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
	public function saleInvoice($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Sale Invoice' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function saleCredit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Credit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}	
	public function saleDebit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Debit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	}

	////
	public function gotGstCredit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax) AS gotgst FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Credit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->gotgst);
		}
		else
		{
		return (0);
		} 
	}
	
	public function gotGstDebit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax) AS gotgst FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Debit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->gotgst);
		}
		else
		{
		return (0);
		} 
	}
	
	public function gstStandingInv($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax) AS gotgst FROM `orders` WHERE `deleted` ='N' AND `invoice_type` = 'Sale Invoice' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->gotgst);
		}
		else
		{
		return (0);
		} 
	}
	////
	
	
	public function purchaseInvoice($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Purchase Invoice' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{	
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function purchaseCredit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Credit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function purchaseDebit($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(balance - tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Debit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}

	public function gstOutPurInv($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Purchase Invoice' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function gstPurCre($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Credit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function gstPurDeb($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(tax)  AS outstanding FROM `vendor_orders` WHERE `deleted` ='N' AND `invoice_type` = 'Debit Receipt' AND `deleted` ='N' AND `company_id` = $this->company_id AND (dt_created >= :fromdate AND dt_created <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return ($row->outstanding);
		}
		else
		{
		return (0);
		}
	  
	}

	public function exptotal($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(amt) AS recieved FROM `expenses` WHERE `exp_type` ='Pre-Paid' AND `deleted` ='N' AND `company_id` = $this->company_id AND (pay_date >= :fromdate AND pay_date <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return $row->recieved;
		}
		else
		{
		return (0);
		}
	  
	}

	
	public function exp2total($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(amount) AS recieved FROM `payable` WHERE `invoice_type` ='Expenses' AND `company_id` = $this->company_id AND (receipt_date >= :fromdate AND receipt_date <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return $row->recieved;
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function posexptotal($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(amt) AS recieved FROM `expenses` WHERE `exp_type` ='Post-Paid' AND `deleted` ='N' AND `company_id` = $this->company_id AND (pay_date >= :fromdate AND pay_date <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return $row->recieved;
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function inventorytotal($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(price) AS outstanding FROM `products` WHERE `company_id` = $this->company_id");
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return (0);
		}
		else
		{
		return (0);
		}
	  
	}
	
	public function getAssets($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM assets_category WHERE id=:id  AND `company_id` = $this->company_id AND `user_id` = $this->user_id ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
	public function assetsPlus($fromdate,$todate,$currency)
	{
		$stmt = $this->db->prepare("SELECT *, SUM(amt) AS remold FROM `assets` WHERE `deleted` ='N' AND `company_id` = $this->company_id AND (pay_date >= :fromdate AND pay_date <= :todate) GROUP BY `assets_category_id` ORDER BY `id` DESC");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			$total = 0;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$cust_data = balancesheetClass::getAssets($row->assets_category_id);	
			?>
				<tr>
					<td><?php if($row->assets_category_id) { print($cust_data->name); } else { print($row->name); } ?></td>
					<td><?php echo $currency;?> <?php print($row->remold);  ?></td>
				</tr>
				<?php
				$total =$total + $row->remold;
			}
			?>
			<tr>
				<th><span class="pull-right">Total Current Assets</span></th>
				<th><?php echo $currency;?>  <?php echo num($total);?></th>
			</tr>
			<?php 
		}
		else
		{
		?>
			<tr>
				<td colspan="2"></td>
			</tr>
			<?php
		}
	}

	public function getExpenses($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id AND `user_id` = $this->user_id ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
	public function postExp($fromdate,$todate,$currency)
	{
		$stmt = $this->db->prepare("SELECT *, SUM(amt - paid_amount) AS remake FROM `expenses` WHERE `deleted` ='N' AND `company_id` = $this->company_id AND (pay_date >= :fromdate AND pay_date <= :todate) GROUP BY `expenses_category_id` ORDER BY `id` DESC");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$total = 0;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$cust_data = balancesheetClass::getExpenses($row->expenses_category_id);	
				
			?>
				<tr>
					<td><?php if($row->expenses_category_id) { print($cust_data->name); } else { print($row->name); } ?></td>
					<td><?php echo $currency;?> <?php print($row->remake);  ?></td>
				</tr>
				<?php
				$total =$total + $row->remake;
			}
			?>	
				<tr>
				<th><span class="pull-right">Total Other Liabilities</span></th>
				<th><?php echo $currency;?>  <?php echo num($total);?></th>
				</tr>
			<?php 
				
		}
		else
		{
		?>
			<tr>
				<td colspan="2"></td>
			</tr>
			<?php
		}
	}
	
	public function availableStock($fromdate,$todate)
	{
		$stmt = $this->db->prepare("SELECT SUM(price * (stock_in - stock_out)) AS outstanding FROM `stock` WHERE `company_id` = $this->company_id AND (entry_date >= :fromdate AND entry_date <= :todate)");
		$stmt->bindparam(":fromdate",$fromdate,PDO::PARAM_STR);
		$stmt->bindparam(":todate",$todate,PDO::PARAM_STR);
		$stmt->execute();
	 
		if($stmt->rowCount()>0)
		{
			$row=$stmt->fetch(PDO::FETCH_OBJ);
			return $row->outstanding;
		}
		else
		{
		return (0);
		}
	  
	}
	
	
}
?>