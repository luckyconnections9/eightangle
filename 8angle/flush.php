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

	if(isset($_POST['date']) and !empty($_POST['date'])) {
		$date = mysql_real_escape_string($_POST['date']);
		
		$myFile3 = 'includes/data/txt/date.txt';
		if(!is_file($myFile3)) {
			file_put_contents($myFile3,$date);
		} else {
			file_put_contents($myFile3,$date);
		}
		
	} else {
		$errorCode = 101;
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
			file_put_contents($myFile,"");
		} else {
			file_put_contents($myFile,"");
		}
		
		$myFile2 = 'includes/data/txt/register.txt';
		if(!is_file($myFile2)) {
			file_put_contents($myFile2,"");
		} else {
			file_put_contents($myFile2,"");
		}
		
		$stmt11 = getDB()->prepare("UPDATE `settings` SET `value` = '' WHERE `slug` = 'MASTER_ID' "); 
		$stmt11->execute();
		$stmt12 = getDB()->prepare("UPDATE `settings` SET `value` = '' WHERE `slug` = 'REGISTER' "); 
		$stmt12->execute();
		
		
		$array = array("type" => 'success', "errorcode" => $errorCode);  //type success , masterID, scode, errorcode empty
		
		die(json_encode($array));
		
	}
}
?>