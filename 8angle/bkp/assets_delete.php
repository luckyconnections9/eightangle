<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Asset - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/assetsClass.php';
$assets = new assetsClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($assets->delete($id)) {
		header("Location: assets.php?deleted=Y"); 
	} 
	else {
		header("Location: assets.php?deleted=N"); 
	}

}
?>
