<?php
function update_field($table_name,$field,$value,$primary_key,$pvalue)
{
    $stmt = getDB()->prepare("UPDATE $table_name SET $field = '$value' WHERE $primary_key = '$pvalue' "); 
	$stmt->execute();
	return true;
}

function get_field_value($table_name,$field,$primary_key,$pvalue)
{
    $stmt = getDB()->prepare("SELECT $field FROM $table_name WHERE $primary_key = '$pvalue' "); 
	$stmt->execute();
	@	$editRow=$stmt->fetch(PDO::FETCH_OBJ);
	return @$editRow->$field;
}

function count_query($query)
{
    $count = mysql_num_rows($query);
    return ($count);
}

function days_left()
{
	$myFile = 'includes/data/txt/date.txt';
	$redirect = "";
	$redirect2 = get_field_value('settings','value','slug','EXPIRE_DATE');
	if(!is_file($myFile)) {
		$redirect = "0000-00-00 00:00:00";
	} else {
		$redirect = file_get_contents($myFile);
	}
	if($redirect2  ==  $redirect) {
		$redirect = $redirect;
	} else {
		$redirect = date('Y-m-d h:i:s');
	}
	$current_date = new DateTime(date('Y-m-d h:i:s'));
	$exp_date = new DateTime($redirect);
	$diff = $exp_date->diff($current_date)->format('%r%a');
	if($diff >=0) {
		$myFile2 = 'includes/data/txt/register.txt';
		if(!is_file($myFile2)) {
			file_put_contents($myFile2,2);
		} else {
			file_put_contents($myFile2,2);
		}
		
		$stmt4 = getDB()->prepare("UPDATE `settings` SET `value` = '2' WHERE `slug` = 'REGISTER' "); 
		$stmt4->execute();
		
		$urll = 'activation.php'; echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$urll.'">'; exit();
	}
	if($diff <= 0) {
		$d = -($diff);
		if($diff <= 0  AND $diff >= -30) {
		echo "<p style='background-color:red; padding:15px; border-radius:4px;' class='alert-danger  col-sm-12'><b>".$d." day(s) to Expire. <a href='renew.php' style='color:#ffffff !important; text-decoration:underline !important;'>Click Here</a> to Activate your product</b></p>";
		} else {
		}
	}
}

function create_slug($string){
	$slug= trim($string);
	$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

function displaydate($dt)
{
	$pieces=explode("-",$dt);
	$dispdate=date("M d, Y",mktime(0,0,0,$pieces[1],$pieces[2],$pieces[0]));
	return($dispdate);
}

function displaydateformat($format,$dt)
{
	$pieces=explode("-",$dt);
	$dispdate=date($format,mktime(0,0,0,$pieces[1],$pieces[2],$pieces[0]));
	return($dispdate);
}

function num($num)
{
	$nums = number_format($num, 2, '.', '');
	return($nums);
}

function genpassword()
{
	$password='10';
	for ($i=1;$i<=11;$i++)
	{
		$tmp = substr('k5qwer61ghj58n@vc952piuy548@h', rand(1,29), 1);
		$password.= $tmp;
	}
	return($password);
}

function numberTowords($num)
{ 
	$ones = array( 
		1 => "one", 
		2 => "two", 
		3 => "three", 
		4 => "four", 
		5 => "five", 
		6 => "six", 
		7 => "seven", 
		8 => "eight", 
		9 => "nine", 
		10 => "ten", 
		11 => "eleven", 
		12 => "twelve", 
		13 => "thirteen", 
		14 => "fourteen", 
		15 => "fifteen", 
		16 => "sixteen", 
		17 => "seventeen", 
		18 => "eighteen", 
		19 => "nineteen" 
	); 
	$tens = array( 
		1 => "ten",
		2 => "twenty", 
		3 => "thirty", 
		4 => "forty", 
		5 => "fifty", 
		6 => "sixty", 
		7 => "seventy", 
		8 => "eighty", 
		9 => "ninety" 
	); 
	$hundreds = array( 
		"hundred", 
		"thousand", 
		"million", 
		"billion", 
		"trillion", 
		"quadrillion" 
	); //limit t quadrillion 
	$num = number_format($num,2,".",","); 
	$num_arr = explode(".",$num); 
	$wholenum = $num_arr[0]; 
	$decnum = $num_arr[1]; 
	$whole_arr = array_reverse(explode(",",$wholenum)); 
	krsort($whole_arr); 
	$rettxt = ""; 
	foreach($whole_arr as $key => $i){ 
		if($i < 20)
		{ 
			$rettxt .= $ones[$i]; 
		}
		elseif($i < 100)
		{ 
			$rettxt .= $tens[substr($i,0,1)]; 
			$rettxt .= " ".$ones[substr($i,1,1)]; 
		}
		else
		{ 
		@	$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
		@	$rettxt .= " ".$tens[substr($i,1,1)]; 
		@	$rettxt .= " ".$ones[substr($i,2,1)]; 
		} 
		if($key > 0)
		{ 
			$rettxt .= " ".$hundreds[$key]." "; 
		} 
	} 
	if($decnum > 0){ 
		$rettxt .= " and "; 
		if($decnum < 20){
			$rettxt .= $ones[$decnum]; 
		}
		elseif($decnum < 100)
		{ 
			$rettxt .= $tens[substr($decnum,0,1)]; 
			$rettxt .= " ".$ones[substr($decnum,1,1)]; 
		} 
	} 
	return $rettxt; 
}

function isConnected()
{
    $connected = @fsockopen("www.google.com", 80,$errorNum,$errorMessage);
    if ($connected){
        fclose($connected);
		 return true; 
    } else {
    return false;
		//echo $errorMessage;
	}
}


function genscode()
{
	$code='';
	for ($i=1;$i<=16;$i++)
	{
		$tmp = substr('k5qwer61ghj58n@vc952piuy548@h9sc6sdom01xw', rand(1,41), 1);
		$code.= $tmp;
	}
	return($code);
}

?>