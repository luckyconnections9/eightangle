<?php
class payexpensesClass
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
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id  AND `user_id` = $this->user_id  AND `deleted` = 'N'");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
		
	public function getExpenses($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id AND `user_id` = $this->user_id ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	 
	public function getReceiptnumber($invoice_type)
	{
		$stmt = $this->db->prepare("SELECT id,receipt_number FROM payable WHERE `company_id` = $this->company_id AND `user_id` = $this->user_id AND `invoice_type` = :invoice_type GROUP BY `receipt_number` ");
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
				$cust_data = payexpensesClass::getExpenses($row->expenses_category_id);	
				?>
				<tr>
					<td><?php print(html_entity_decode($i)); ?></td>
					<td><?php if($row->expenses_category_id) { print($cust_data->name); } else { print($row->name); } ?></td>
					<td><?php print($row->outstanding);  ?></td>	
					<td align="center">
						<a href="javascript:;" onClick="return outstanding_expenses(<?php echo $row->expenses_category_id; ?>);" class="btn btn-primary">View/Pay</a>
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
	
}
?>