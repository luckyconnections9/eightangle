<?php include 'includes/common.php';
isCompany($company_id);
$meta_title = "8angle | Delete User   ";
$userDetails=$userClass->userDetails($session_uid);
if(isset($_GET['delete_id']) and $userDetails->role == 30)
{
	$id = ($_GET['delete_id']);
	if($crud->delete($id)) {
		header("Location: users_management.php?deleted=Y"); 
	} 
	else {
		header("Location: users_management.php?deleted=N"); 
	}

}
?>
