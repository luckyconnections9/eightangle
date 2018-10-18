<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);

$user_input = trim($_POST['search_term']);
// Define two array, one is to store output data and other is for display
$display_json = array();
$json_arr = array();
$user_input = preg_replace('/\s+/', ' ', $user_input);

if(!empty($user_input)) 
{
	$params = array();
	$params[':user_input'] = '%'.$user_input.'%';
	$params[':company_id'] = $company_id;
	
	$stmt_customer = getDB()->prepare('SELECT * FROM `customers` WHERE (`name` LIKE :user_input OR `email` LIKE :user_input OR `address` LIKE :user_input OR `phone` LIKE :user_input OR `gst_num` LIKE :user_input) AND `company_id` = :company_id AND `status` ="Enable" AND `deleted` = "N" LIMIT 5');
	$stmt_customer->execute($params);	
	
	if($stmt_customer->rowCount()>0)
	{
		?>
		<br/>
		<?php
		include_once 'includes/customersClass.php';
		$customers = new customersClass();
		while($recResult = $stmt_customer->fetch(PDO::FETCH_OBJ)) 
		{ 
			$city_data =$customers->getCity($recResult->city);	
		?>
			 <a href="javascript:;" onclick='addinvcust(0,<?php echo $recResult->id;?>,"<?php echo $recResult->name;?>", "<?php echo $recResult->phone;?>","<?php echo $recResult->gst_num;?>","<?php echo $recResult->address;?>","<?php echo $recResult->email;?>",<?php echo $recResult->city;?>,"<?php if(!empty($recResult->city)) echo $city_data->Name;?>","<?php if(!empty($recResult->state)) echo $city_data->District;?>","<?php echo $recResult->pin;?>")'><font color='black'><?php echo $recResult->name;?></font> <font color='black'>[<?php echo $recResult->email;?></font>] <?php echo $recResult->gst_num;?></a><br/>
		<?php
		}
	} 
	else  
	{ 
		echo "<b style='color:red'>No Customer Found."; ?><a style="cursor: pointer;"
		  onclick="window.open('addcustomerquick.php','',' scrollbars=yes,width=600, resizable=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0').focus()"> Add new</a></b> <?php 
	}
}
else 
{
	echo "<b  style='color:red'>No Customer Found."; ?><a style="cursor: pointer;"
  onclick="window.open('addcustomerquick.php','',' scrollbars=yes,width=600, resizable=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0').focus()"> Add new</a></b>
<?php } ?>