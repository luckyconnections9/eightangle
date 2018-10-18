<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "Delete Companies - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = $_GET['delete_id'];
	if($crud->delete($id)) {
		header("Location: companies.php?deleted=Y"); 
	} 
	else {
		header("Location: companies.php?deleted=N"); 
	}

}
?>
