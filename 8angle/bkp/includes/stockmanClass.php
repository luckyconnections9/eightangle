<?php
class stockmanClass
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
	
	public function create($order_id,$customer_id,$product_id,$stock_in,$stock_out,$price,$unit,$type,$entry_date)
	{
		try
		{
			
				$stmt = $this->db->prepare("INSERT INTO stock(order_id,customer_id,product_id,stock_in,stock_out,price,unit,type,entry_date,company_id,user_id) VALUES(:order_id,:customer_id,:product_id,:stock_in,:stock_out,:price,:unit,:type,:entry_date,$this->company_id,$this->user_id)");
				$stmt->bindparam(":order_id",$order_id,PDO::PARAM_INT);
				$stmt->bindparam(":customer_id",$customer_id,PDO::PARAM_INT);
				$stmt->bindparam(":product_id",$product_id,PDO::PARAM_INT);
				$stmt->bindparam(":stock_in",$stock_in,PDO::PARAM_INT);
				$stmt->bindparam(":stock_out",$stock_out,PDO::PARAM_INT);
				$stmt->bindparam(":price",$price,PDO::PARAM_STR);
				$stmt->bindparam(":unit",$unit,PDO::PARAM_INT);
				$stmt->bindparam(":type",$type,PDO::PARAM_STR);
				$stmt->bindparam(":entry_date",$entry_date,PDO::PARAM_STR);
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
	
	public function getPro($id)
	{
		$stmt = $this->db->prepare("SELECT name FROM products WHERE id=:id  AND `deleted` = 'N' AND `company_id` = $this->company_id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	

	public function getUnit($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM products_unit WHERE id=:id  AND `deleted` = 'N' AND `status` = 'Enable' AND `company_id` = $this->company_id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_OBJ);
		if($editRow) {
		return $editRow; } else { return "";}
	}
	
			
	public function stockMan($query,$currency,$params)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
		$i = 1;
 
		if($stmt->rowCount()>0)
		{
			$total = 0; $total_stock_in = 0; $total_stock_out = 0; $balance = 0;
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{
				$pro_data = stockmanClass::getPro($row->product_id);					
				$unit_data = stockmanClass::getUnit($row->unit);
				 $total_stock_in =  $total_stock_in + $row->stock_in; 
				 $total_stock_out =  $total_stock_out + $row->stock_out;	
				
			?>
				<tr>
					<td><?php echo $i; $i= $i+1 ?></td>
					<td><?php if($row->product_id) { print($pro_data->name); } ?></td>
					<td><?php if($row->unit) { print($unit_data->name); } ?></td>
					<td><?php print(num($row->price)); ?></td>
					<td><?php if($row->stock_in) {  print($row->stock_in); } ?></td>
					<td><?php if($row->stock_out) { print($row->stock_out); } ?></td>
					<td><?php echo $balance = $balance + ($row->stock_in - $row->stock_out);?></td>
					<td><?php if($row->product_id) { print(num($row->price * ($row->stock_in - $row->stock_out))); } ?></td>
				</tr>
				
				<?php
				$total =$total + ($row->price * ($row->stock_in - $row->stock_out));
			}
			?>
				<th colspan="4" align="right"><span class="pull-right">Total:</span></th>
				<th><?php echo $total_stock_in;?></th>
				<th><?php echo $total_stock_out;?></th>
				<th><?php echo  $balance;?></th>
				<th><?php echo $currency;?>  <?php echo num($total);?></th>
			<?php 
				
		}
		else
		{
		?>
			<tr>
				<td colspan="8"></td>
			</tr>
			<?php
		}
	}
	

	
	
}
?>