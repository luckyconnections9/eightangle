<?php
class customersClass
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

	public function create($name,$c_name,$phone,$gst_num,$email,$address,$city,$state,$status,$pin)
	{
		try
		{ 
			$st = $this->db->prepare("SELECT * FROM customers WHERE (name=:name ) AND `company_id` = $this->company_id AND `deleted` = 'N' AND `customer_type` = 'Customer'");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO customers(name,c_name,phone,gst_num,email,address,city,state,status,pin,customer_type,company_id,user_id)  VALUES(:name,:c_name,:phone,:gst_num,:email,:address,:city,:state,:status,:pin,'Customer',$this->company_id,$this->user_id)");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":c_name",$c_name,PDO::PARAM_STR);
				$stmt->bindparam(":phone",$phone,PDO::PARAM_STR);
				$stmt->bindparam(":gst_num",$gst_num,PDO::PARAM_STR);
				$stmt->bindparam(":email",$email,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_INT);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);	
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N' ");
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
	 
	public function update($id,$name,$c_name,$phone,$gst_num,$email,$address,$city,$state,$status,$pin)
	{
		try
		{
			if(empty(customersClass::getID($id))) { return false; }
			$st = $this->db->prepare("SELECT * FROM customers WHERE (name=:name ) AND  id !=:id AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `customer_type` = 'Customer' ");			
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
			$stmt = $this->db->prepare("UPDATE customers SET name=:name, c_name=:c_name, phone=:phone, gst_num=:gst_num, email=:email, address=:address, city=:city, state=:state, status=:status, pin=:pin WHERE id=:id");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":c_name",$c_name,PDO::PARAM_STR);
				$stmt->bindparam(":phone",$phone,PDO::PARAM_STR);
				$stmt->bindparam(":gst_num",$gst_num,PDO::PARAM_STR);
				$stmt->bindparam(":email",$email,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_INT);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);	
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
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
			if(empty(customersClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `customers` SET `deleted` = 'Y'  WHERE id=:id AND `company_id` = $this->company_id ");
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
				$cust_id = $row->id; 
				$city_data = customersClass::getCity($row->city);
				$outstanding = "";
				$stmts = $this->db->prepare(" SELECT SUM(balance - paid_amount) AS outstanding FROM `orders` WHERE `deleted` ='N' AND `company_id` = $this->company_id  AND  `customer_id` = '$cust_id' GROUP BY `customer_id` ");
				$stmts->execute();
				if($stmts->rowCount()>0) { $data=$stmts->fetch(PDO::FETCH_OBJ); $outstanding =  $data->outstanding;  }
			?>
				<tr>
					<td><?php print(html_entity_decode($row->name)); ?></td>
					<td><?php print(html_entity_decode($row->c_name)); ?></td>
					<td><?php print(html_entity_decode($row->phone)); ?></td>	
					<td><?php print(html_entity_decode($row->address)); ?></td>					
					<td><?php print(html_entity_decode($row->city)); ?></td>
					<td><?php  print(html_entity_decode($row->state)); ?></td>
					<td><?php print(html_entity_decode($row->outstanding)); ?></td>
					<td><?php print(html_entity_decode($row->status)); ?></td>
					<td align="center">
						<a href="customers_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="customers_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="11">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
 /* paging */ 
}
?>