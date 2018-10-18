<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/categoryClass.php';
$category = new categoryClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($category->delete($id)) {
		header("Location: category.php?deleted=Y"); 
	} 
	else {
		header("Location: category.php?deleted=N"); 
	}

}
?>
