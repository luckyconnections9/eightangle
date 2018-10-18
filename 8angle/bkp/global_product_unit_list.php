<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
	$stmt_unit1 = getDB()->prepare("SELECT * FROM products_unit WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N'");
	$stmt_unit1->execute();
	echo '<option value=""></option>';
	while($data_unit1=$stmt_unit1->fetch(PDO::FETCH_OBJ))
	{
		echo "<option  value=".$data_unit1->id.">".$data_unit1->unit ."</option>";
	 }
?>


