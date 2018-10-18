<?php
class vendorsClass
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

	public function create($biz_name,$c_name,$gst_num,$phone,$email,$address,$city,$state,$status,$pin)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM customers WHERE (name=:biz_name OR gst_num=:gst_num) AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `customer_type` = 'Vendor' ");
			$st->bindparam(":biz_name",$biz_name,PDO::PARAM_STR);
			$st->bindparam(":gst_num",$gst_num,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO customers(name,c_name,gst_num,phone,email,address,city,state,status,pin,customer_type,company_id,user_id)  VALUES(:biz_name,:c_name,:gst_num,:phone,:email,:address,:city,:state,:status,:pin,'Vendor',$this->company_id,$this->user_id)");
				$stmt->bindparam(":biz_name",$biz_name,PDO::PARAM_STR);
				$stmt->bindparam(":c_name",$c_name,PDO::PARAM_STR);
				$stmt->bindparam(":gst_num",$gst_num,PDO::PARAM_STR);
				$stmt->bindparam(":phone",$phone,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM customers WHERE id=:id AND `company_id` = $this->company_id  AND `deleted` = 'N'  ");
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
	
	public function update($id,$biz_name,$c_name,$gst_num,$phone,$email,$address,$city,$state,$status,$pin)
	{
		try
		{
			if(empty(vendorsClass::getID($id))) { return false; }
			$st = $this->db->prepare("SELECT * FROM customers WHERE (name=:biz_name OR c_name=:c_name) AND  id !=:id AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `customer_type` = 'Vendor' ");			
			$st->bindparam(":biz_name",$biz_name,PDO::PARAM_STR);
			$st->bindparam(":c_name",$c_name,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
			$stmt = $this->db->prepare("UPDATE customers SET name=:biz_name, c_name=:c_name, gst_num=:gst_num, phone=:phone, email=:email, address=:address, city=:city, state=:state, status=:status, pin=:pin WHERE id=:id");
				$stmt->bindparam(":biz_name",$biz_name,PDO::PARAM_STR);
				$stmt->bindparam(":c_name",$c_name,PDO::PARAM_STR);
				$stmt->bindparam(":gst_num",$gst_num,PDO::PARAM_STR);
				$stmt->bindparam(":phone",$phone,PDO::PARAM_STR);
				$stmt->bindparam(":email",$email,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_STR);
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
			if(empty(vendorsClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `customers` SET  `deleted` = 'Y' WHERE id=:id AND `company_id` = $this->company_id AND `customer_type` = 'Vendor' ");
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
				$city_data = vendorsClass::getCity($row->city)	
			?>
				<tr>
					<td><?php print($row->name); ?></td>
					<td><?php print($row->c_name); ?></td>
                    <td><?php print($row->gst_num); ?></td>
                    <td><?php print($row->phone); ?></td>
					<td><?php print($row->email); ?></td>
					<td><?php print($row->address); ?></td>
					<td><?php print($row->city);  ?></td>
					<td><?php print(html_entity_decode($row->state)); ?></td>
					<td><?php print($row->status); ?></td>
					<td colspan="2" align="center">
						<a href="vendors_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="vendors_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
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
}
?>