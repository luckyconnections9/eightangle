<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Assets Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/assetscategoryClass.php';
$assetscategory = new assetscategoryClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($assetscategory->delete($id)) {
		header("Location: assetscategory.php?deleted=Y"); 
	} 
	else {
		header("Location: assetscategory.php?deleted=N"); 
	}

}
?>
