<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Purchase Invoice - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/pus_invoiceClass.php';
$invoice = new pus_invoiceClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($invoice->delete($id)) {
		header("Location: pus_invoice.php?deleted=Y"); 
	} 
	else {
		header("Location: pus_invoice.php?deleted=N"); 
	}

}
?>
