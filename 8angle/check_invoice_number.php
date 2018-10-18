<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
$valid = true;
$param = strtoupper($_POST['invoice_number_value']);
$invoice_action = ($_POST['invoice_action']);

if($invoice_action  == "Add") 
{
	$stmt_invoice_number = getDB()->prepare("SELECT `invoice_number` FROM `orders` WHERE  `invoice_number` =:param AND `company_id` = :company_id AND `deleted` = 'N' "); 
	$stmt_invoice_number->bindparam(":param",$param,PDO::PARAM_STR);
	$stmt_invoice_number->bindparam(":company_id",$company_id,PDO::PARAM_INT);
	$stmt_invoice_number->execute();
	$result_array = array();
	while($row = $stmt_invoice_number->fetch(PDO::FETCH_ASSOC))
	{
		$result_array[] = $row['invoice_number'];
		if($row['invoice_number'] == $param  ) {
			 $valid = false;
		}
	}
	$invoice_number_value = $result_array;

	if (isset($_POST['invoice_number_value']) && array_key_exists($_POST['invoice_number_value'], $invoice_number_value)) {
		$valid = false;
	} 
}
if($invoice_action  == "Edit") 
{
	$valid  = true;
}

echo json_encode(array(
    'valid' => $valid,
));



