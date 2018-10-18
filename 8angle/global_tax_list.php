<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
$stmt_tax1 = getDB()->prepare("SELECT * FROM invoice_tax WHERE status='Enable' AND  `company_id` = $company_id AND `deleted` = 'N' ");
$stmt_tax1->execute();
	echo "<option value=''></option>";
while($data_tax1=$stmt_tax1->fetch(PDO::FETCH_OBJ))
	{
		echo "<option value=".$data_tax1->id.">".$data_tax1->name." ".$data_tax1->tax."%</option>";
	}
?>


