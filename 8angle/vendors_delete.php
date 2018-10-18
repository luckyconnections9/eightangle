<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Vendor - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/vendorsClass.php';
$vendors = new vendorsClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($vendors->delete($id)) {
		header("Location: vendors.php?deleted=Y"); 
	} 
	else {
		header("Location: vendors.php?deleted=N"); 
	}

}
?>
