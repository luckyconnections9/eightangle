<?php
class banksClass
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
	 
	public function create($bank,$branch,$account_name,$account_number,$ifsc,$remarks,$status)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM banks WHERE (account_number=:account_number) AND `deleted` = 'N' AND `company_id` = $this->company_id ");
			$st->bindparam(":account_number",$account_number,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO banks(company_id,bank,branch,account_name,account_number,ifsc,remarks,status) VALUES($this->company_id,:bank,:branch,:account_name,:account_number,:ifsc,:remarks,:status)");
				$stmt->bindparam(":bank",$bank,PDO::PARAM_STR);
				$stmt->bindparam(":branch",$branch,PDO::PARAM_STR);
				$stmt->bindparam(":account_name",$account_name,PDO::PARAM_STR);
				$stmt->bindparam(":account_number",$account_number,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc",$ifsc,PDO::PARAM_STR);
				$stmt->bindparam(":remarks",$remarks,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM banks WHERE id=:id  AND `deleted` = 'N' AND `company_id` = $this->company_id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	 
	public function getCompany($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM company WHERE id=:id  ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function update($id,$bank,$branch,$account_name,$account_number,$ifsc,$remarks,$status)
	{
		try
		{
			if(empty(banksClass::getID($id))) { return false; }
			$st = $this->db->prepare("SELECT * FROM banks WHERE (account_number=:account_number) AND `deleted` = 'N' AND `company_id` = $this->company_id AND  id !=:id ");
			$st->bindparam(":account_number",$account_number,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt=$this->db->prepare("UPDATE banks SET bank=:bank, branch=:branch, account_name=:account_name, account_number=:account_number, ifsc=:ifsc, remarks=:remarks, status=:status WHERE id=:id ");
				$stmt->bindparam(":bank",$bank,PDO::PARAM_STR);
				$stmt->bindparam(":branch",$branch,PDO::PARAM_STR);
				$stmt->bindparam(":account_name",$account_name,PDO::PARAM_STR);
				$stmt->bindparam(":account_number",$account_number,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc",$ifsc,PDO::PARAM_STR);
				$stmt->bindparam(":remarks",$remarks,PDO::PARAM_STR);
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
			if(empty(banksClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `banks` SET `deleted` = 'Y' WHERE id=:id AND `company_id` = $this->company_id");
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
	 
	public function dataview($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	 $i = 1;
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$company_data = banksClass::getCompany($row->company_id)
			?>
				<tr>
					<td><?php print($i); $i = $i +1; ?></td>
					<td><?php print(html_entity_decode($row->bank)); ?></td>
					<td><?php print(html_entity_decode($row->branch)); ?></td>
					<td><?php print(html_entity_decode($row->account_name)); ?></td>
					<td><?php print(html_entity_decode($row->account_number)); ?></td>
					<td><?php print(html_entity_decode($row->ifsc)); ?></td>
					<td><?php print(html_entity_decode($row->remarks)); ?></td>
					<td align="center">
						<a href="banks_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="banks_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm( Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="9">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
 /* paging */ 
}
?>