<?php
include('includes/define.php');
session_unset();
session_destroy();
$session_uid='';
$_SESSION['uid']='';
if(empty($session_uid) && empty($_SESSION['uid']))
{
	$url=BASE_URL.'login.php';
	header("Location: $url");
	//echo "<script>window.location='$url'</script>";
}
?>