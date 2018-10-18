<?php
class expensesClass
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

	public function create($name,$amt,$reason,$paidby,$pay_date,$description,$status,$expenses_category_id,$name_on_check,$bank_name,$check_or_account_number,$exp_type)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO expenses(name,amt,reason,paidby,pay_date,description,status,expenses_category_id,name_on_check,bank_name,check_or_account_number,exp_type,company_id,user_id)  VALUES(:name,:amt,:reason,:paidby,:pay_date,:description,:status,:expenses_category_id,:name_on_check,:bank_name,:check_or_account_number,:exp_type,$this->company_id,$this->user_id)");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);				
				$stmt->bindparam(":amt",$amt,PDO::PARAM_STR);
				$stmt->bindparam(":reason",$reason,PDO::PARAM_STR);					
				$stmt->bindparam(":paidby",$paidby,PDO::PARAM_STR);
				$stmt->bindparam(":pay_date",$pay_date,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);		
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);				
				$stmt->bindparam(":expenses_category_id",$expenses_category_id,PDO::PARAM_INT);
				$stmt->bindparam(":name_on_check",$name_on_check,PDO::PARAM_STR);
				$stmt->bindparam(":bank_name",$bank_name,PDO::PARAM_STR);		
				$stmt->bindparam(":check_or_account_number",$check_or_account_number,PDO::PARAM_STR);				
				$stmt->bindparam(":exp_type",$exp_type,PDO::PARAM_STR);
				$stmt->execute();
				return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
	}
	 
	public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM expenses WHERE id=:id  AND `company_id` = $this->company_id  AND `status` = 'Enable'");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	 
	public function getCategory($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N'  AND `status` = 'Enable' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow->name; } else { return "";}
	}
	 
	public function update($id,$name,$amt,$reason,$paidby,$pay_date,$description,$status,$expenses_category_id,$name_on_check,$bank_name,$check_or_account_number,$exp_type)
	{
		try
		{
			if(empty(expensesClass::getID($id))) { return false; }
			
				$stmt = $this->db->prepare("UPDATE expenses SET name=:name, amt=:amt, reason=:reason, paidby=:paidby, pay_date=:pay_date, description=:description,  status=:status, expenses_category_id=:expenses_category_id, name_on_check=:name_on_check, bank_name=:bank_name, check_or_account_number=:check_or_account_number, exp_type=:exp_type WHERE id=:id");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);				
				$stmt->bindparam(":amt",$amt,PDO::PARAM_STR);
				$stmt->bindparam(":reason",$reason,PDO::PARAM_STR);					
				$stmt->bindparam(":paidby",$paidby,PDO::PARAM_STR);
				$stmt->bindparam(":pay_date",$pay_date,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);		
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":expenses_category_id",$expenses_category_id,PDO::PARAM_INT);
				$stmt->bindparam(":name_on_check",$name_on_check,PDO::PARAM_STR);
				$stmt->bindparam(":bank_name",$bank_name,PDO::PARAM_STR);		
				$stmt->bindparam(":check_or_account_number",$check_or_account_number,PDO::PARAM_STR);
				$stmt->bindparam(":exp_type",$exp_type,PDO::PARAM_STR);
				$stmt->bindparam(":id",$id,PDO::PARAM_INT);
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
			if(empty(expensesClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("DELETE FROM `expenses` WHERE id=:id AND `company_id` = $this->company_id");
			$stmt->bindparam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
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
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
			?>
				<tr>
					<td><?php print(html_entity_decode($row->name)); ?></td>
					<td><?php print(html_entity_decode($row->cname));  ?></td>
					<td><?php print(html_entity_decode($row->amt)); ?></td>
                    <td><?php print(html_entity_decode($row->reason)); ?></td>
					<td><?php print(html_entity_decode($row->paidby)); ?></td>
					<td><?php print(html_entity_decode($row->pay_date)); ?></td>
					<td><?php print(html_entity_decode($row->description)); ?></td>                   
					<td><?php print(html_entity_decode($row->status)); ?></td>
					<td colspan="2" align="center">
						<a href="expenses_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="expenses_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
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