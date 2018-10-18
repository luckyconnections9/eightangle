<?php
class productsClass
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
	 
	public function create($category_id,$name,$hsn_id,$hsn_code,$code,$buy_price,$sell_price,$price,$tax_id,$status,$description,$product_type,$products_unit_id)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM products WHERE name=:name AND category_id=:category_id AND `product_type` = :product_type AND `company_id` = $this->company_id AND `deleted` = 'N'  ");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->bindparam(":product_type",$product_type,PDO::PARAM_STR);
			$st->bindparam(":category_id",$name,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO products(category_id,name,hsn_id,hsn_code,code,buy_price,sell_price,price,tax_id,status,description,product_type,products_unit_id,company_id,user_id) VALUES(:category_id,:name,:hsn_id,:hsn_code,:code,:buy_price,:sell_price,:price,:tax_id,:status,:description,:product_type,:products_unit_id,$this->company_id,$this->user_id)");
				$stmt->bindparam(":category_id",$category_id,PDO::PARAM_INT);
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":code",$code,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_id",$hsn_id,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_code",$hsn_code,PDO::PARAM_STR);
				$stmt->bindparam(":buy_price",$buy_price,PDO::PARAM_STR);
				$stmt->bindparam(":sell_price",$sell_price,PDO::PARAM_STR);
				$stmt->bindparam(":price",$price,PDO::PARAM_STR);
				$stmt->bindparam(":tax_id",$tax_id,PDO::PARAM_INT);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":product_type",$product_type,PDO::PARAM_STR);
				$stmt->bindparam(":products_unit_id",$products_unit_id,PDO::PARAM_STR);
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
		$stmt = $this->db->prepare("SELECT * FROM `products` WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `status` = 'Enable' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		return $editRow;
	}
	
	public function getParent($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM category WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `status` = 'Enable' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow->name; } else { return "";}
	}
	
	public function getProductsunit($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM products_unit WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N' AND `status` = 'Enable' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow->name; } else { return "";}
	}
	
	public function getTax($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM invoice_tax WHERE id=:id  AND `company_id` = $this->company_id  AND `deleted` = 'N'  AND `status` = 'Enable' ");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow->tax."%"; } else { return "";}
	}
	
	public function update($id,$category_id,$name,$hsn_id,$hsn_code,$code,$buy_price,$sell_price,$price,$tax_id,$status,$description,$product_type,$products_unit_id)
	{
		try
		{
			if(empty(productsClass::getID($id))) { return false; } 
			$st = $this->db->prepare("SELECT * FROM `products` WHERE (name=:name AND category_id=:category_id AND `product_type` =:product_type ) AND  id !=:id AND `company_id` = $this->company_id  AND `deleted` = 'N' ");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->bindparam(":product_type",$product_type,PDO::PARAM_STR);
			$st->bindparam(":category_id",$category_id,PDO::PARAM_INT);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt=$this->db->prepare("UPDATE `products` SET category_id=:category_id,name=:name,hsn_id=:hsn_id,hsn_code=:hsn_code,code=:code,buy_price=:buy_price,sell_price=:sell_price,price=:price,tax_id=:tax_id,status=:status,description=:description,product_type=:product_type,products_unit_id=:products_unit_id WHERE id=:id ");
				$stmt->bindparam(":category_id",$category_id,PDO::PARAM_INT);
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":code",$code,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_id",$hsn_id,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_code",$hsn_code,PDO::PARAM_STR);
				$stmt->bindparam(":buy_price",$buy_price,PDO::PARAM_STR);
				$stmt->bindparam(":sell_price",$sell_price,PDO::PARAM_STR);
				$stmt->bindparam(":price",$price,PDO::PARAM_STR);
				$stmt->bindparam(":tax_id",$tax_id,PDO::PARAM_INT);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":product_type",$product_type,PDO::PARAM_STR);
				$stmt->bindparam(":products_unit_id",$products_unit_id,PDO::PARAM_STR);
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
			if(empty(productsClass::getID($id))) { return false; }
			
			//$st = $this->db->prepare("SELECT * FROM `products` WHERE `category_id`=$id ");
			//$st->execute();
			//$count=$st->rowCount();
			//if($count<1)
			//{
				$stmt = $this->db->prepare("UPDATE `products` SET  `deleted` = 'Y'  WHERE id=:id  AND `company_id` = $this->company_id ");
				$stmt->bindparam(":id",$id,PDO::PARAM_INT);
				$stmt->execute();
				return true;
			//}
			//else
			//{
			//	return false;
			//}
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
					<td><?php print(html_entity_decode($row->cname)); ?></td>
					<td><?php print(html_entity_decode($row->hsn_code)); ?></td>
					<td><?php print(html_entity_decode($row->product_type)); ?></td>
					<td><?php if($row->products_unit_id) print(productsClass::getProductsunit($row->products_unit_id));  ?></td>
					<td><?php print(html_entity_decode($row->buy_price)); ?></td>
					<td><?php print(html_entity_decode($row->sell_price)); ?></td>
					<td><?php print(html_entity_decode($row->price)); ?></td>
					<td><?php if($row->tax_id) print(productsClass::getTax($row->tax_id)); ?></td>
					<td><?php print($row->status); ?></td>
					<td  align="center">
						<a href="products_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="products_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="14">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	 
 /* paging */ 
}
?>