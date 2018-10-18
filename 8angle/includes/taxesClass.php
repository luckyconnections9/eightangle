<?php
class taxesClass
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

	public function create($name,$tax,$cgst,$sgst,$status)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM invoice_tax WHERE tax=:tax AND `company_id` = $this->company_id AND `deleted` = 'N' ");
			$st->bindparam(":tax",$tax,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO invoice_tax(name,tax,cgst,sgst,status,company_id,user_id)  VALUES(:name,:tax,:cgst,:sgst,:status,$this->company_id,$this->user_id)");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);				
				$stmt->bindparam(":tax",$tax,PDO::PARAM_STR);
				$stmt->bindparam(":cgst",$cgst,PDO::PARAM_STR);	
				$stmt->bindparam(":sgst",$sgst,PDO::PARAM_STR);					
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM invoice_tax WHERE id=:id  AND `company_id` = $this->company_id AND `deleted` = 'N'");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function update($id,$name,$tax,$cgst,$sgst,$status)
	{
		try
		{
			if(empty(taxesClass::getID($id))) { return false; }
			$st = $this->db->prepare("SELECT * FROM invoice_tax WHERE tax=:tax AND id !=:id AND `company_id` = $this->company_id AND `deleted` = 'N'");			
			$st->bindparam(":tax",$tax,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
			$stmt = $this->db->prepare("UPDATE invoice_tax SET name=:name, tax=:tax, cgst=:cgst, sgst=:sgst,  status=:status WHERE id=:id");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);				
				$stmt->bindparam(":tax",$tax,PDO::PARAM_STR);
				$stmt->bindparam(":cgst",$cgst,PDO::PARAM_STR);	
				$stmt->bindparam(":sgst",$sgst,PDO::PARAM_STR);					
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
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
			if(empty(taxesClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `invoice_tax` SET `deleted`='Y' WHERE id=:id AND `company_id` = $this->company_id");
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
					<td><?php print(html_entity_decode($row->id)); ?></td>
					<td><?php print(html_entity_decode($row->tax)); ?></td>
                    <td><?php print(html_entity_decode($row->cgst)); ?></td>
					<td><?php print(html_entity_decode($row->sgst)); ?></td>
					<td><?php print(html_entity_decode($row->status)); ?></td>
					<td align="center">
						<a href="taxes_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="taxes_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="8">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
}
?>