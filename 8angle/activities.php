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

	if(isset($_POST['act'])) 
	{
		$act = mysql_real_escape_string($_POST['act']);
		
		$myFile3 = 'includes/data/txt/activities.txt';
		if(!is_file($myFile3)) {
			file_put_contents($myFile3,$act);
		} else {
			file_put_contents($myFile3,$act);
		}
		$array = array('type' => 'success', 'errorcode' => $errorCode);  //type error ,masterID empty, scode empty, errorcodes
		
		die(json_encode($array));
		
	} 
}
?>