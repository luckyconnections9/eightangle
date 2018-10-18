<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);

$user_input = (trim($_POST['search_term']));
// Define two array, one is to store output data and other is for display
$display_json = array();
$json_arr = array();
$user_input = preg_replace('/\s+/', ' ', $user_input);

if(!empty($user_input)) 
{
	$params = array();
	$params[':user_input'] = '%'.$user_input.'%';
	$params[':company_id'] = $company_id;
	
	$stmt_customer = getDB()->prepare('SELECT * FROM `customers` WHERE (`name` LIKE :user_input OR `email` LIKE :user_input OR `address` LIKE :user_input OR `phone` LIKE :user_input OR `gst_num` LIKE :user_input ) AND `company_id` = :company_id AND `status` ="Enable" AND `deleted` = "N" LIMIT 5');
	$stmt_customer->execute($params);	
	
	if($stmt_customer->rowCount()>0)
	{
		?>
		<br/>
		<?php
		while($recResult = $stmt_customer->fetch(PDO::FETCH_OBJ)) 
		{ 
		?>
			 - <a href="statement.php?customer=<?php echo $recResult->id;?>"><?php echo html_entity_decode($recResult->name); ?></a><br/>
		<?php
		}
	} 
	else  
	{ 
	}
}
else 
{ } ?>