<?php session_start();
ini_set("max_execution_time", "9999999999");
ini_set("post_max_size", "100M");
ini_set("upload_max_filesize", "100M");
ini_set("file_uploads", "100");
	
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', '8hosting');
	define("BASE_URL", "http://localhost/FHP/8hosting/"); 
$inst = 1;
if(file_exists('install.php')) {
	if(isset($_GET['inst']) and $_GET['inst'] == 2) {  unlink('install.php'); unlink('8angle.php'); }	else {
	$url=BASE_URL.'install.php?inst='.$inst;
	echo "<script>window.location='$url'</script>";
	}
} 	
function getDB()
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	try {
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbConnection->exec("set names utf8");
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
	return $dbConnection;
	}
	catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	}

}
$company_id = ""; $menuitem = 1; $deleted = ""; $created =""; $updated =""; $isCompany=""; $invoice_js = ""; $check_u = 1; $product_type ="8angle";
if(isset($_GET['deleted']) and $_GET['deleted'] == "Y") { $deleted="<div class='alert alert-success alert-dismissible'><strong></strong>Record deleted successfully!</div>"; } 
if(isset($_GET['deleted']) and $_GET['deleted'] == "N") {  $deleted="<div class='alert alert-danger alert-dismissible'><strong></strong>Error while deleting record !</div>"; }
if(isset($_GET['created']) and $_GET['created'] == "Y") { $created="<div class='alert alert-success alert-dismissible'>WOW<strong></strong>Record added successfully!</div>"; 
	if(isset($_GET['invoice'])) { $created="<div class='alert alert-success alert-dismissible'>WOW<strong></strong>Invoice created/updated successfully!</div>";  }
	if(isset($_GET['receipt'])) { $created="<div class='alert alert-success alert-dismissible'>WOW<strong></strong>Receipt created/updated successfully!</div>";  }
}  
if(isset($_GET['created']) and $_GET['created'] == "N") {  $created="<div class='alert alert-danger alert-dismissible'><strong></strong>Error while adding record !</div>"; }
if(isset($_GET['updated']) and $_GET['updated'] == "Y") { $updated="<div class='alert alert-success alert-dismissible'>WOW<strong></strong>Record updated successfully!</div>"; }  
if(isset($_GET['updated']) and $_GET['updated'] == "N") {  $updated="<div class='alert alert-danger alert-dismissible'><strong></strong>Error while updating record !</div>"; }
if(isset($_GET['isCompany']) and $_GET['isCompany'] == "N") {  $isCompany="<div class='alert alert-danger  alert-dismissible'><strong></strong> Select Company !</div>"; }
include_once 'includes/companiesClass.php';
$crud = new companiesClass();
include_once 'includes/paginationClass.php';
$pagination = new paginationClass();
$currency = '<i class="fa fa-inr text-green"></i>';

?>