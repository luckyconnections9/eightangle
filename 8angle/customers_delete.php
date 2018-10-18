<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Customer - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/customersClass.php';
$customers = new customersClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($customers->delete($id)) {
		header("Location: customers.php?deleted=Y"); 
	} 
	else {
		header("Location: customers.php?deleted=N"); 
	}

}
?>
