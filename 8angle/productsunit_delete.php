<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/productsunitClass.php';
$productsunit = new productsunitClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($productsunit->delete($id)) {
		header("Location: productsunit.php?deleted=Y"); 
	} 
	else {
		header("Location: productsunit.php?deleted=N"); 
	}

}
?>
