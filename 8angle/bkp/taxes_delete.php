<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Tax - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/taxesClass.php';
$taxes = new taxesClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($taxes->delete($id)) {
		header("Location: taxes.php?deleted=Y"); 
	} 
	else {
		header("Location: taxes.php?deleted=N"); 
	}

}
?>
