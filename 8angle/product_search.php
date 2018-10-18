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
	$stmt_product = getDB()->prepare('SELECT * FROM `products` WHERE (`name` LIKE :user_input OR `hsn_code` LIKE :user_input OR `description` LIKE :user_input OR `code` LIKE :user_input ) AND `company_id` = :company_id AND `status` ="Enable" AND `deleted` = "N" LIMIT 8');
	$stmt_product->execute($params);	
	
	if($stmt_product->rowCount()>0)
	{
		?>
		<br/>
		<?php
		while($recResult = $stmt_product->fetch(PDO::FETCH_OBJ)) 
		{ 
		?>
			 - <a href="stockman.php?product=<?php echo $recResult->id;?>&from_date=<?php echo (trim($_POST['from_date']))?>&to_date=<?php echo (trim($_POST['to_date']))?>"><?php echo html_entity_decode($recResult->name); ?></a><br/>
		<?php
		}
	} 
	else  
	{ 
	}
}
else 
{ } ?>