<?php
class expensescategoryClass
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
	 
	public function create($name,$description,$status,$parent)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM expenses_category WHERE name=:name  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO expenses_category (name,description,status,parent,company_id,user_id) VALUES(:name,:description,:status,:parent,$this->company_id,$this->user_id)");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":parent",$parent,PDO::PARAM_INT);
				$stmt->execute();
				return true;
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
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getParent($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM expenses_category WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow->name; } else { return "";}
	}
	
	//edited by vinci//
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
	//--//
	
	public function update($id,$name,$description,$status,$parent)
	{
		try
		{
			if(empty(expensescategoryClass::getID($id))) { return false; } 
			$st = $this->db->prepare("SELECT * FROM expenses_category WHERE (name=:name AND parent=:parent) AND  id !=:id AND `company_id` = $this->company_id AND `deleted` = 'N'");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->bindparam(":parent",$parent,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt=$this->db->prepare("UPDATE expenses_category SET name=:name,description=:description, status=:status, parent=:parent WHERE id=:id ");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":parent",$parent,PDO::PARAM_INT);
				$stmt->bindparam(":id",$id,PDO::PARAM_INT);
				$stmt->execute();
			   
				return true; 
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
	 
	public function delete($id)
	{
		try
		{
			if(empty(expensescategoryClass::getID($id))) { return false; }
			
			$st = $this->db->prepare("SELECT * FROM `expenses` WHERE `expenses_category_id`=$id  AND `company_id` = $this->company_id AND `deleted` = 'N'  ");
			$st->execute();
			$count=$st->rowCount();
			if($count < 1)
			{
				$stmt = $this->db->prepare("UPDATE `expenses_category` SET `deleted` = 'Y' WHERE id=:id  AND `company_id` = $this->company_id ");
				$stmt->bindparam(":id",$id,PDO::PARAM_INT);
				$stmt->execute();
				return true;
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
					<td><?php print(html_entity_decode($row->description)); ?></td>
					<td><?php print($row->status); ?></td>
					<td  align="center">
						<a href="expensescategory_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="expensescategory_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
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