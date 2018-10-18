<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Products - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/productsClass.php';
$products = new productsClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($products->delete($id)) {
		header("Location: products.php?deleted=Y"); 
	} 
	else {
		header("Location: products.php?deleted=N"); 
	}

}
?>
