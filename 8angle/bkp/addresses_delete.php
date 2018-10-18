<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($addresses->delete($id)) {
		header("Location: addresses.php?deleted=Y"); 
	} 
	else {
		header("Location: addresses.php?deleted=N"); 
	}

}
?>
