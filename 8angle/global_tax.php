<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
$param = ($_POST['sa']);
if(!empty($param) and is_numeric($param))
{
	$divs = ($_POST['div']);
	$div=$divs+1;
	$d = "inv".$div;
	$inv_discount = 0;
	$inv_amount = 0;
	$cnt= 1;
	
	$params = array();
	
	$params[':param'] = $param;	
	$params[':company_id'] = $company_id;
	
	$stmt_tax = getDB()->prepare("SELECT * FROM `invoice_tax` WHERE  `id` =:param AND `company_id` = :company_id AND `status` = 'Enable' LIMIT 1");
	$stmt_tax->execute($params);
	
	if($stmt_tax->rowCount()>0)
	{
		while ($row = $stmt_tax->fetch(PDO::FETCH_OBJ))
		{
			echo $row->tax.",".$row->cgst.",".$row->sgst;
		}
	}
	else  
	{
		echo "0,0,0";
	}
} 
else {
	echo "0,0,0";	
}
?>

