<?php
class addressesClass
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
	 
	public function create($customer_id,$name,$gst_number,$address,$city,$state,$pin,$status)
	{
		try
		{
				$stmt = $this->db->prepare("INSERT INTO addresses(customer_id,name,gst_number,address,city,state,pin,status,company_id) VALUES(:customer_id,:name,:gst_number,:address,:city,:state,:pin,:status,$this->company_id)");
				$stmt->bindparam(":customer_id",$customer_id,PDO::PARAM_INT);
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":gst_number",$gst_number,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_INT);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM addresses WHERE id=:id  AND `deleted` = 'N' AND `company_id` = $this->company_id");
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
	 
	public function getCity($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM city WHERE ID=:id  ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	public function getCustomer($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id  ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function update($id,$customer_id,$name,$gst_number,$address,$city,$state,$pin,$status)
	{
		try
		{
			if(empty(addressesClass::getID($id))) { return false; }
			
				$stmt=$this->db->prepare("UPDATE banks SET customer_id=:customer_id,name=:name,gst_number=:gst_number,address=:address,city=:city,state=:state,pin=:pin,status=:status WHERE id=:id ");
				$stmt->bindparam(":customer_id",$customer_id,PDO::PARAM_INT);
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":gst_number",$gst_number,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_INT);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
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
			if(empty(addressesClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `addresses` SET `deleted` = 'Y' WHERE id=:id AND `company_id` = $this->company_id");
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
				$cust_data = addressesClass::getCustomer($row->customer_id);
				$city_data = addressesClass::getCity($row->city);
			?>
				<tr>
					<td><?php print($i); $i = $i +1; ?></td>
					<td><?php if(!empty($row->customer_id)) print(html_entity_decode($cust_data->name));  ?></td>
					<td><?php print(html_entity_decode($row->name)); ?></td>
					<td><?php print(html_entity_decode($row->gst_number)); ?></td>
					<td><?php print(html_entity_decode($row->address)); ?></td>
					<td><?php if(!empty($row->city)) print(html_entity_decode($city_data->Name));  ?></td>
					<td><?php print(html_entity_decode($row->state)); ?></td>
					<td><?php print(html_entity_decode($row->pin)); ?></td>
					<td align="center">
						<a href="addresses_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="addresses_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm( Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
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
 /* paging */ 
}
?>