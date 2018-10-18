<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Invoice - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/invoiceClass.php';
$invoice = new invoiceClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($invoice->delete($id)) {
		header("Location: invoice.php?deleted=Y"); 
	} 
	else {
		header("Location: invoice.php?deleted=N"); 
	}

}
?>
