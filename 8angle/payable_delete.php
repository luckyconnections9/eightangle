<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Invoice - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/pus_invoiceClass.php';
$invoice = new pus_invoiceClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = mysql_real_escape_string($_GET['delete_id']);
	if($invoice->delete($id)) {
		header("Location: receipts.php?deleted=Y&receipt=Purchase"); 
	} 
	else {
		header("Location: receipts.php?deleted=N&receipt=Purchase"); 
	}

}
?>
