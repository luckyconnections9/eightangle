<?php include 'includes/define.php';
include 'function.php';
date_default_timezone_set('Asia/Kolkata');
$errorCode = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') 

{
	
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' )	{
		
		$errorCode = 100; //invalid request
		
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
		
	}

	$versionReg = mysql_real_escape_string($_POST['versionReg']);
	if(empty($versionReg)) 
	{
		$errorCode[] =105; //Enter Contact Person 
	}
	if($versionReg == "Trial" OR $versionReg =="Full")
	{ } else {
		$errorCode[] =106; //Invalid Product
	}
	$days = 30;
	if($versionReg == "Full") { $days = 365;}
	
	
	$scode = mysql_real_escape_string($_POST['sc']);
	
	
	if(!empty($errorCode)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
	}
	else  
	{	
		$activation_date = date('Y-m-d h:i:s');
		$expire_date = date('Y-m-d h:i:s' , strtotime('+'.$days.' days',strtotime(date('Y-m-d'))) );
		
		$myFile = 'includes/data/txt/date.txt';
		if(!is_file($myFile)) {
			file_put_contents($myFile,$expire_date);
		} else {
			file_put_contents($myFile,$expire_date);
		};
		
		$myFile2 = 'includes/data/txt/register.txt';
		if(!is_file($myFile2)) {
			file_put_contents($myFile2,3);
		} else {
			file_put_contents($myFile2,3);
		}
		$myFile3 = 'includes/data/txt/version.txt';
		if(!is_file($myFile3)) {
			file_put_contents($myFile3,$versionReg);
		} else {
			file_put_contents($myFile3,$versionReg);
		}
		
		$stmt = getDB()->prepare("UPDATE `settings` SET `value` = '$expire_date' WHERE `slug` = 'EXPIRE_DATE' "); 
		$stmt->execute();
		$stmt2 = getDB()->prepare("UPDATE `settings` SET `value` = 'Y' WHERE `slug` = 'PRODUCT_ACTIVATION' "); 
		$stmt2->execute();
		$stmt3 = getDB()->prepare("UPDATE `settings` SET `value` = '$activation_date' WHERE `slug` = 'ACTIVATION_DATE' "); 
		$stmt3->execute();
		$stmt4 = getDB()->prepare("UPDATE `settings` SET `value` = '3' WHERE `slug` = 'REGISTER' "); 
		$stmt4->execute();
		$stmt5 = getDB()->prepare("UPDATE `settings` SET `value` = '$scode' WHERE `slug` = 'SCODE' "); 
		$stmt5->execute();
		
		$array = array("type" => 'success', "errorcode" => $errorCode);  //type success , masterID, scode, errorcode empty
		
		die(json_encode($array));
		
	}
}
?>