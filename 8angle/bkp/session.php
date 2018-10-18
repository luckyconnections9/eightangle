<?php
if(!empty($_SESSION['uid']))
{
	$session_uid=$_SESSION['uid'];
	$session_role=$_SESSION['role'];
	include('includes/userClass.php');
	$userClass = new userClass();
}
if(empty($session_uid))
{
	$url=BASE_URL.'login.php';
	header("Location: $url");
}
if(isset($_GET['mi']) && is_numeric($_GET['mi']))
{
	$_SESSION['menuitem']= $_GET['mi'];
}
if(isset($_GET['company_id']) && !empty($crud->getID($_GET['company_id'])) )
{
	$_SESSION['company_id']=$_GET['company_id'];
}
if(isset($_SESSION['company_id']))
{
	$company_id = $_SESSION['company_id'];
}
if(isset($_SESSION['menuitem']))
{
	$menuitem = $_SESSION['menuitem'];
}
if(isset($_SESSION['check_u']))
{
	$check_u = $_SESSION['check_u'];
}
function isCompany($company_id) {
	if(empty($company_id)) {
		$url=BASE_URL.'index.php?isCompany=N';
		echo "<script>window.location='$url'</script>";
	}
}
?>