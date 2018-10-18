<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Category - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/banksClass.php';
$banks = new banksClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($banks->delete($id)) {
		header("Location: banks.php?deleted=Y"); 
	} 
	else {
		header("Location: banks.php?deleted=N"); 
	}

}
?>
