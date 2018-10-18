<?php
class companiesClass
{
	private $db;
	private $user_id; 
	
	function __construct()
	{
		$this->db = getDB();
	@	$this->user_id = $_SESSION['uid'];
	}
	 
	public function create($name,$gst,$description,$status,$address,$city,$state,$pin,$disclaimer,$logo,$invoice_number,$invoice_prefix,$hsn_code,$sale_tax,$purchase_tax,$bank,$branch,$account_name,$account_number,$ifsc,$remarks,$bank1,$branch1,$account_name1,$account_number1,$ifsc1,$remarks1,$invoice_number_start,$purchase_invoice_number,$purchase_invoice_prefix,$purchase_invoice_number_start)
	{
		try
		{
			$st = $this->db->prepare("SELECT * FROM companies WHERE (name=:name) AND `deleted` = 'N' ");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt = $this->db->prepare("INSERT INTO companies(name,gst_number,description,status,address,city,state,pin,disclaimer,logo,invoice_number,invoice_prefix,hsn_code,sale_tax,purchase_tax,bank,branch,account_name,account_number,ifsc,remarks,bank1,branch1,account_name1,account_number1,ifsc1,remarks1,invoice_number_start,purchase_invoice_number,purchase_invoice_prefix,purchase_invoice_number_start) VALUES(:name,:gst,:description,:status,:address,:city,:state,:pin,:disclaimer,:logo,:invoice_number,:invoice_prefix,:hsn_code,:sale_tax,:purchase_tax,:bank,:branch,:account_name,:account_number,:ifsc,:remarks,:bank1,:branch1,:account_name1,:account_number1,:ifsc1,:remarks1,:invoice_number_start,:purchase_invoice_number,:purchase_invoice_prefix,:purchase_invoice_number_start)");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":gst",$gst,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_STR);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
				$stmt->bindparam(":disclaimer",$disclaimer,PDO::PARAM_STR);
				$stmt->bindparam(":logo",$logo,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_number",$invoice_number,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_prefix",$invoice_prefix,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_code",$hsn_code,PDO::PARAM_STR);
				$stmt->bindparam(":sale_tax",$sale_tax,PDO::PARAM_STR);
				$stmt->bindparam(":purchase_tax",$purchase_tax,PDO::PARAM_STR);
				$stmt->bindparam(":bank",$bank,PDO::PARAM_STR);
				$stmt->bindparam(":branch",$branch,PDO::PARAM_STR);
				$stmt->bindparam(":account_name",$account_name,PDO::PARAM_STR);
				$stmt->bindparam(":account_number",$account_number,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc",$ifsc,PDO::PARAM_STR);
				$stmt->bindparam(":remarks",$remarks,PDO::PARAM_STR);
				$stmt->bindparam(":bank1",$bank1,PDO::PARAM_STR);
				$stmt->bindparam(":branch1",$branch1,PDO::PARAM_STR);
				$stmt->bindparam(":account_name1",$account_name1,PDO::PARAM_STR);
				$stmt->bindparam(":account_number1",$account_number1,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc1",$ifsc1,PDO::PARAM_STR);
				$stmt->bindparam(":remarks1",$remarks1,PDO::PARAM_STR);
				$stmt->bindparam(":purchase_invoice_number",$purchase_invoice_number,PDO::PARAM_STR);
				$stmt->bindparam(":purchase_invoice_number_start",$purchase_invoice_number_start,PDO::PARAM_INT);
				$stmt->bindparam(":purchase_invoice_prefix",$purchase_invoice_prefix,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_number_start",$invoice_number_start,PDO::PARAM_INT);
				$stmt->execute();
				
				$cid = $this->db->lastInsertId();
				
				
				$stmt_tax = $this->db->prepare("INSERT INTO invoice_tax(name,tax,cgst,sgst,status,company_id,user_id)  VALUES ('','0','0','0','Enable',$cid,$this->user_id),
				('','0.25','0.125','0.125','Enable',$cid,$this->user_id),
				('','3','1.5','1.5','Enable',$cid,$this->user_id),
				('','5','2.5','2.5','Enable',$cid,$this->user_id),
				('','12','6','6','Enable',$cid,$this->user_id),
				('','18','9','9','Enable',$cid,$this->user_id),
				('','28','14','14','Enable',$cid,$this->user_id);");
				$stmt_tax->execute();
				
				$stmt_units = $this->db->prepare("INSERT INTO products_unit(unit,name,status,company_id,user_id) VALUES
				('BOU','BOU','Enable',$cid,$this->user_id),
				('BGS','Bags','Enable',$cid,$this->user_id),
				('BAL','Bale','Enable',$cid,$this->user_id),
				('BTL','Bottles','Enable',$cid,$this->user_id),
				('BOX','Boxes','Enable',$cid,$this->user_id),
				('BKL','Buckles','Enable',$cid,$this->user_id),
				('BUN','Bunches','Enable',$cid,$this->user_id),
				('BDL','Bundles','Enable',$cid,$this->user_id),
				('CAN','Cans','Enable',$cid,$this->user_id),
				('CTN','Cartons','Enable',$cid,$this->user_id),
				('CMS','Centimeter','Enable',$cid,$this->user_id),
				('CCM','Cubic Centimeter','Enable',$cid,$this->user_id),
				('CBM','Cubic Meter','Enable',$cid,$this->user_id),
				('DOZ','Dozen','Enable',$cid,$this->user_id),
				('DRM','Drums','Enable',$cid,$this->user_id),
				('GMS','Grams','Enable',$cid,$this->user_id),
				('GGK','Great Gross','Enable',$cid,$this->user_id),
				('GRS','Gross','Enable',$cid,$this->user_id),
				('GYD','Gross Yards','Enable',$cid,$this->user_id),
				('KGS','Kilograms','Enable',$cid,$this->user_id),
				('KLR','Kiloliter','Enable',$cid,$this->user_id),
				('KME','Kilometers','Enable',$cid,$this->user_id),
				('MTR','Meter','Enable',$cid,$this->user_id),
				('MTS','Metric Ton','Enable',$cid,$this->user_id),
				('MLT','Milliliters','Enable',$cid,$this->user_id),
				('NOS','Numbers','Enable',$cid,$this->user_id),
				('OTH','Others','Enable',$cid,$this->user_id),
				('PAC','Packs','Enable',$cid,$this->user_id),
				('PRS','Pairs','Enable',$cid,$this->user_id),
				('PCS','Pieces','Enable',$cid,$this->user_id),
				('QTL','Quintal','Enable',$cid,$this->user_id),
				('ROL','Rolls','Enable',$cid,$this->user_id),
				('SET','Sets','Enable',$cid,$this->user_id),
				('SQF','Square Feet','Enable',$cid,$this->user_id),
				('SQM','Square Meter','Enable',$cid,$this->user_id),
				('SQY','Square Yards','Enable',$cid,$this->user_id),
				('TBS','Tablets','Enable',$cid,$this->user_id),
				('TGM','Ten Grams','Enable',$cid,$this->user_id),
				('THD','Thousands','Enable',$cid,$this->user_id),
				('TON','Tonnes','Enable',$cid,$this->user_id),
				('TUB','Tubes','Enable',$cid,$this->user_id),
				('UGS','US Gallons','Enable',$cid,$this->user_id),
				('UNT','Units','Enable',$cid,$this->user_id),
				('YDS','Yards','Enable',$cid,$this->user_id);");
				$stmt_units->execute();
				
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
		$stmt = $this->db->prepare("SELECT * FROM companies WHERE id=:id  AND `deleted` = 'N'");
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
	
	public function getCount()
	{
		$db = getDB();
		$stmt = $db->prepare("SELECT id FROM companies WHERE `deleted` = 'N'");
		$stmt->execute();
		$count=$stmt->rowCount();
		if($count >= 1) {
			return true;
		} else { return false; }
		
	}
	
	public function update($id,$name,$gst,$description,$status,$address,$city,$state,$pin,$disclaimer,$logo,$invoice_number,$invoice_prefix,$hsn_code,$sale_tax,$purchase_tax,$bank,$branch,$account_name,$account_number,$ifsc,$remarks,$bank1,$branch1,$account_name1,$account_number1,$ifsc1,$remarks1,$invoice_number_start,$purchase_invoice_number,$purchase_invoice_prefix,$purchase_invoice_number_start)
	{
		try
		{
			if(empty(companiesClass::getID($id))) { return false; }
			$st = $this->db->prepare("SELECT * FROM companies WHERE (name=:name) AND  id !=:id  AND `deleted` = 'N'");
			$st->bindparam(":name",$name,PDO::PARAM_STR);
			$st->bindparam(":id",$id,PDO::PARAM_INT);
			$st->execute();
			$count=$st->rowCount();
			if($count<1)
			{
				$stmt=$this->db->prepare("UPDATE companies SET name=:name, gst_number=:gst, description=:description, status=:status, address=:address, city=:city, state=:state, pin=:pin, disclaimer=:disclaimer, logo=:logo, invoice_number=:invoice_number, invoice_prefix=:invoice_prefix, hsn_code=:hsn_code, sale_tax=:sale_tax, purchase_tax=:purchase_tax, bank=:bank, branch=:branch, account_name=:account_name, account_number=:account_number, ifsc=:ifsc, remarks=:remarks, bank1=:bank1, branch1=:branch1, account_name1=:account_name1, account_number1=:account_number1, ifsc1=:ifsc1, remarks1=:remarks1, invoice_number_start=:invoice_number_start, purchase_invoice_number=:purchase_invoice_number, purchase_invoice_prefix=:purchase_invoice_prefix, purchase_invoice_number_start=:purchase_invoice_number_start WHERE id=:id ");
				$stmt->bindparam(":name",$name,PDO::PARAM_STR);
				$stmt->bindparam(":gst",$gst,PDO::PARAM_STR);
				$stmt->bindparam(":description",$description,PDO::PARAM_STR);
				$stmt->bindparam(":status",$status,PDO::PARAM_STR);
				$stmt->bindparam(":address",$address,PDO::PARAM_STR);
				$stmt->bindparam(":city",$city,PDO::PARAM_STR);
				$stmt->bindparam(":state",$state,PDO::PARAM_STR);
				$stmt->bindparam(":pin",$pin,PDO::PARAM_STR);
				$stmt->bindparam(":disclaimer",$disclaimer,PDO::PARAM_STR);
				$stmt->bindparam(":logo",$logo,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_number",$invoice_number,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_prefix",$invoice_prefix,PDO::PARAM_STR);
				$stmt->bindparam(":hsn_code",$hsn_code,PDO::PARAM_STR);
				$stmt->bindparam(":sale_tax",$sale_tax,PDO::PARAM_STR);
				$stmt->bindparam(":purchase_tax",$purchase_tax,PDO::PARAM_STR);
				$stmt->bindparam(":bank",$bank,PDO::PARAM_STR);
				$stmt->bindparam(":branch",$branch,PDO::PARAM_STR);
				$stmt->bindparam(":account_name",$account_name,PDO::PARAM_STR);
				$stmt->bindparam(":account_number",$account_number,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc",$ifsc,PDO::PARAM_STR);
				$stmt->bindparam(":remarks",$remarks,PDO::PARAM_STR);
				$stmt->bindparam(":bank1",$bank1,PDO::PARAM_STR);
				$stmt->bindparam(":branch1",$branch1,PDO::PARAM_STR);
				$stmt->bindparam(":account_name1",$account_name1,PDO::PARAM_STR);
				$stmt->bindparam(":account_number1",$account_number1,PDO::PARAM_STR);
				$stmt->bindparam(":ifsc1",$ifsc1,PDO::PARAM_STR);
				$stmt->bindparam(":remarks1",$remarks1,PDO::PARAM_STR);
				$stmt->bindparam(":invoice_number_start",$invoice_number_start,PDO::PARAM_INT);
				$stmt->bindparam(":purchase_invoice_number",$purchase_invoice_number,PDO::PARAM_STR);
				$stmt->bindparam(":purchase_invoice_number_start",$purchase_invoice_number_start,PDO::PARAM_INT);
				$stmt->bindparam(":purchase_invoice_prefix",$purchase_invoice_prefix,PDO::PARAM_STR);
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
			if(empty(companiesClass::getID($id))) { return false; }
			
			$stmt = $this->db->prepare("UPDATE `companies` SET `deleted` = 'Y' WHERE id=:id");
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
				$city_data = companiesClass::getCity($row->city)
			?>
				<tr>
					<td><?php print($row->id); ?></td>
					<td><?php print(html_entity_decode($row->name)); ?></td>
					<td><?php print(html_entity_decode($row->gst_number)); ?></td>
					<td><?php print(html_entity_decode($row->address)); ?></td>
					<td><?php print(html_entity_decode($row->city)); ?></td>
					<td><?php print(html_entity_decode($row->state)); ?></td>
					<td><?php print(html_entity_decode($row->pin)); ?></td>
					<td><?php print(html_entity_decode($row->description)); ?></td>
					<td><?php print(html_entity_decode($row->status)); ?></td>
					<td align="center">
						<a href="companies_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="companies_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Action can not be undone. All company data will be deleted permanently. Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="12">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
 /* paging */ 
}
?>