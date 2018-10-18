<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/expensescategoryClass.php';
$expensescategory = new expensescategoryClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($expensescategory->delete($id)) {
		header("Location: expensescategory.php?deleted=Y"); 
	} 
	else {
		header("Location: expensescategory.php?deleted=N"); 
	}

}
?>
