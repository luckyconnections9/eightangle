<?php include 'includes/define.php';
include 'function.php';

$errorCode = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' )	{
		
		$errorCode = 100; //invalid request
		
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
		
	}
	
	$businessnameReg = mysql_real_escape_string($_POST['businessnameReg']);
	if(empty($businessnameReg)) 
	{
		$errorCode[] =101; //Enter Business Name 
	}
	
	$contactnameReg = mysql_real_escape_string($_POST['contactnameReg']);
	if(empty($contactnameReg)) 
	{
		$errorCode[] =102; //Enter Contact Person 
	}
	
	$contactnumberReg = mysql_real_escape_string($_POST['contactnumberReg']);
	if(empty($contactnumberReg)) 
	{
		$errorCode[] =103; //Enter Contact Number
	}
	
	$emailReg = mysql_real_escape_string($_POST['emailReg']);
	if(empty($emailReg) OR !filter_var($emailReg, FILTER_VALIDATE_EMAIL)) 
	{
		$errorCode[] =104; // Invalid Email
	}
	
	$referenceReg = mysql_real_escape_string($_POST['referenceReg']); 
	if(empty($referenceReg)) 
	{
		$errorCode[] =106; //Enter Reference 
	}
	
	$addressReg = mysql_real_escape_string($_POST['addressReg']);
	if(empty($addressReg)) 
	{
		$errorCode[] =108; //Enter Address 
	}
	
	$address2Reg = mysql_real_escape_string($_POST['address2Reg']);
	$countryReg = mysql_real_escape_string($_POST['countryReg']);
	
	$cityReg = mysql_real_escape_string($_POST['cityReg']);
	if(empty($cityReg)) 
	{
		$errorCode[] =109; //Enter CIty 
	}
	
	$stateReg = mysql_real_escape_string($_POST['stateReg']);
	if(empty($stateReg)) 
	{
		$errorCode[] =110; //Enter State 
	}
	
	$pinReg = mysql_real_escape_string($_POST['pinReg']);
	if(empty($pinReg)) 
	{
		$errorCode[] =111; //Enter Pin 
	}
	
	$masterIDReg = mysql_real_escape_string($_POST['masterID']);
	if(empty($masterIDReg)) 
	{
		$errorCode[] =112; //Enter Pin 
	}
	
	$scodeReg = mysql_real_escape_string($_POST['scode']);
	if(empty($scodeReg)) 
	{
		$errorCode[] =113; //Enter Pin 
	}
	
	$gstinReg = mysql_real_escape_string($_POST['gstinReg']);
	if(empty($gstinReg)) 
	{
		$errorCode[] =114; //Enter Contact Person 
	}
	if(!empty($errorCode)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
	}
	else  
	{	
		$myFile = 'includes/data/txt/masterID.txt';
		if(!is_file($myFile)) {
			file_put_contents($myFile,$masterIDReg);
		} else {
			file_put_contents($myFile,$masterIDReg);
		}
		
		$myFile2 = 'includes/data/txt/register.txt';
		if(!is_file($myFile2)) {
			file_put_contents($myFile2,2);
		} else {
			file_put_contents($myFile2,2);
		}
		
		$purchaseDate = date('Y-m-d h:i:s');
		$stmt = getDB()->prepare("UPDATE `settings` SET `value` = '$contactnameReg' WHERE `slug` = 'CONTACT_NAME' "); 
		$stmt->execute();
		$stmt2 = getDB()->prepare("UPDATE `settings` SET `value` = '$businessnameReg' WHERE `slug` = 'BUSINESS_NAME' "); 
		$stmt2->execute();
		$stmt3 = getDB()->prepare("UPDATE `settings` SET `value` = '$emailReg' WHERE `slug` = 'EMAIL' "); 
		$stmt3->execute();
		$stmt4 = getDB()->prepare("UPDATE `settings` SET `value` = '$contactnumberReg' WHERE `slug` = 'CONTACT_NUMBER' "); 
		$stmt4->execute();
		$stmt5 = getDB()->prepare("UPDATE `settings` SET `value` = '$addressReg' WHERE `slug` = 'ADDRESS1' "); 
		$stmt5->execute();
		$stmt6 = getDB()->prepare("UPDATE `settings` SET `value` = '$address2Reg' WHERE `slug` = 'ADDRESS2' "); 
		$stmt6->execute();
		$stmt7 = getDB()->prepare("UPDATE `settings` SET `value` = '$stateReg' WHERE `slug` = 'STATE' "); 
		$stmt7->execute();
		$stmt8 = getDB()->prepare("UPDATE `settings` SET `value` = '$cityReg' WHERE `slug` = 'CITY' "); 
		$stmt8->execute();
		$stmt9 = getDB()->prepare("UPDATE `settings` SET `value` = '$referenceReg' WHERE `slug` = 'REFERENCE' "); 
		$stmt9->execute();
		$stmt10 = getDB()->prepare("UPDATE `settings` SET `value` = '$purchaseDate' WHERE `slug` = 'PURCHASE_DATE' "); 
		$stmt10->execute();
		$stmt11 = getDB()->prepare("UPDATE `settings` SET `value` = '$masterIDReg' WHERE `slug` = 'MASTER_ID' "); 
		$stmt11->execute();
		$stmt12 = getDB()->prepare("UPDATE `settings` SET `value` = '$pinReg' WHERE `slug` = 'PIN' "); 
		$stmt12->execute();
		$stmt13 = getDB()->prepare("UPDATE `settings` SET `value` = '2' WHERE `slug` = 'REGISTER' "); 
		$stmt13->execute();
		$stmt14 = getDB()->prepare("UPDATE `settings` SET `value` = '$scodeReg' WHERE `slug` = 'SCODE' "); 
		$stmt14->execute();
		$stmt15 = getDB()->prepare("UPDATE `settings` SET `value` = '$gstinReg' WHERE `slug` = 'GSTIN' "); 
		$stmt15->execute();
		
		$array = array("type" => 'success', "errorcode" => $errorCode);  //type success , masterID, scode, errorcode empty
		
		die(json_encode($array));
		
	}
}
?>