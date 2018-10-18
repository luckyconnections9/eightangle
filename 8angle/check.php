<?php include 'includes/define.php';
include 'function.php';

$errorCode = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' )	{
		
		$errorCode = 100; //invalid request
		
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
		
	}
	
	$businessnameReg = ($_POST['businessnameReg']);
	if(empty($businessnameReg)) 
	{
		$errorCode[] =101; //Enter Business Name 
	}
	
	$contactnameReg = ($_POST['contactnameReg']);
	if(empty($contactnameReg)) 
	{
		$errorCode[] =102; //Enter Contact Person 
	}
	
	$contactnumberReg = ($_POST['contactnumberReg']);
	if(empty($contactnumberReg)) 
	{
		$errorCode[] =103; //Enter Contact Number
	}
	
	$emailReg = ($_POST['emailReg']);
	if(empty($emailReg) OR !filter_var($emailReg, FILTER_VALIDATE_EMAIL)) 
	{
		$errorCode[] =104; // Invalid Email
	}
	
	$referenceReg = ($_POST['referenceReg']); 
	
	$addressReg = ($_POST['addressReg']);
	if(empty($addressReg)) 
	{
		$errorCode[] =108; //Enter Address 
	}
	
	$address2Reg = ($_POST['address2Reg']);
	$countryReg = ($_POST['countryReg']);
	
	$cityReg = ($_POST['cityReg']);
	if(empty($cityReg)) 
	{
		$errorCode[] =109; //Enter CIty 
	}
	
	$stateReg = ($_POST['stateReg']);
	if(empty($stateReg)) 
	{
		$errorCode[] =110; //Enter State 
	}
	
	$pinReg = ($_POST['pinReg']);
	if(empty($pinReg)) 
	{
		$errorCode[] =111; //Enter Pin 
	}
	
	$gstinReg = ($_POST['gstinReg']);
	
	if(!empty($errorCode)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		$array = array('type' => 'error', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
	}
	else  
	{	
		$myFile2 = 'includes/data/txt/register.txt';
		if(!is_file($myFile2)) {
			file_put_contents($myFile2,3);
		} else {
			file_put_contents($myFile2,3);
		}
		
		$purchaseDate = date('Y-m-d h:i:s');
		$stmt = getDB()->prepare("UPDATE `settings` SET `value` = :contactnameReg WHERE `slug` = 'CONTACT_NAME' "); 
		$stmt->bindParam("contactnameReg", $contactnameReg,PDO::PARAM_STR) ;
		$stmt->execute();
		$stmt2 = getDB()->prepare("UPDATE `settings` SET `value` = :businessnameReg WHERE `slug` = 'BUSINESS_NAME' ");
		$stmt2->bindParam("businessnameReg", $businessnameReg,PDO::PARAM_STR) ;		
		$stmt2->execute();
		$stmt3 = getDB()->prepare("UPDATE `settings` SET `value` = :emailReg WHERE `slug` = 'EMAIL' "); 
		$stmt3->bindParam("emailReg", $emailReg,PDO::PARAM_STR) ;
		$stmt3->execute();
		$stmt4 = getDB()->prepare("UPDATE `settings` SET `value` = :contactnumberReg WHERE `slug` = 'CONTACT_NUMBER' "); 
		$stmt4->bindParam("contactnumberReg", $contactnumberReg,PDO::PARAM_STR) ;
		$stmt4->execute();
		$stmt5 = getDB()->prepare("UPDATE `settings` SET `value` = :addressReg WHERE `slug` = 'ADDRESS1' "); 
		$stmt5->bindParam("addressReg", $addressReg,PDO::PARAM_STR) ;
		$stmt5->execute();
		$stmt6 = getDB()->prepare("UPDATE `settings` SET `value` = :address2Reg WHERE `slug` = 'ADDRESS2' "); 
		$stmt6->bindParam("address2Reg", $address2Reg,PDO::PARAM_STR) ;
		$stmt6->execute();
		$stmt7 = getDB()->prepare("UPDATE `settings` SET `value` = :stateReg WHERE `slug` = 'STATE' ");
		$stmt7->bindParam("stateReg", $stateReg,PDO::PARAM_STR) ;
		$stmt7->execute();
		$stmt8 = getDB()->prepare("UPDATE `settings` SET `value` = :cityReg WHERE `slug` = 'CITY' "); 
		$stmt8->bindParam("cityReg", $cityReg,PDO::PARAM_STR) ;
		$stmt8->execute();
		$stmt9 = getDB()->prepare("UPDATE `settings` SET `value` = :referenceReg WHERE `slug` = 'REFERENCE' "); 
		$stmt9->bindParam("referenceReg", $referenceReg,PDO::PARAM_STR) ;
		$stmt9->execute();
		$stmt10 = getDB()->prepare("UPDATE `settings` SET `value` = :purchaseDate WHERE `slug` = 'PURCHASE_DATE' "); 
		$stmt10->bindParam("purchaseDate", $purchaseDate,PDO::PARAM_STR) ;
		$stmt10->execute();
		$stmt12 = getDB()->prepare("UPDATE `settings` SET `value` = :pinReg WHERE `slug` = 'PIN' "); 
		$stmt12->bindParam("pinReg", $pinReg,PDO::PARAM_STR) ;
		$stmt12->execute();
		$stmt13 = getDB()->prepare("UPDATE `settings` SET `value` = '3' WHERE `slug` = 'REGISTER' "); 
		$stmt13->execute();
		$stmt15 = getDB()->prepare("UPDATE `settings` SET `value` = :gstinReg WHERE `slug` = 'GSTIN' "); 
		$stmt15->bindParam("gstinReg", $gstinReg,PDO::PARAM_STR) ;
		$stmt15->execute();
		
		$array = array("type" => 'success', "errorcode" => $errorCode);  //type success , masterID, scode, errorcode empty
		
		die(json_encode($array));
		
	}
}
?>