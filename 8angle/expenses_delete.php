<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Expense - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
include_once 'includes/expensesClass.php';
$expenses = new expensesClass();
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($expenses->delete($id)) {
		header("Location: expenses.php?deleted=Y"); 
	} 
	else {
		header("Location: expenses.php?deleted=N"); 
	}

}
?>
