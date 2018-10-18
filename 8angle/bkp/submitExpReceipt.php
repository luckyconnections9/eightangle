<?php include 'includes/common.php';
isCompany($company_id);
include_once 'includes/expensescategoryClass.php';
$expensescategory = new expensescategoryClass();
include_once 'includes/payexpensesClass.php';
$payexpenses = new payexpensesClass();

$receipt_number = ($_POST['receipt_number']);
$receipt_date = ($_POST['receipt_date']); 
$expenses_category_id   = ($_POST['customer_id']);
$customer_name = ($_POST['customer_name']);
$invoice_id   = ($_POST['invoice_id']);
if(!empty($invoice_id) AND is_numeric($invoice_id)) {
	$receipt_type = "Single";
} else {
	$receipt_type = "Multiple";
}
$receipt_for  = ($_POST['receipt_for']);
$amount   = ($_POST['amount']);
$paid_amount  = ($_POST['amount']);
$paid_by   = ($_POST['paid_by']);
$paid_date  = ($_POST['paid_date']);
$account_name  = ($_POST['account_name']);
$account_number  = ($_POST['account_number']);
$bank_name = ($_POST['bank_name']);
$remarks = "";
$user_id = $session_uid;
$status = "Enable";
$invoice_type  = ($_POST['invoice_type']);
	$st = getDB()->prepare("INSERT INTO `payable` (`receipt_number`,`receipt_date`,`receipt_type`,`customer_id`,`customer_name`,`invoice_id`,`receipt_for`,`amount`,`paid_amount`,`paid_by`,`paid_date`,`account_name`,`account_number`,`bank_name`,`remarks`,`company_id`,`user_id`,`status`,`invoice_type`) VALUES (:receipt_number,:receipt_date,:receipt_type,:expenses_category_id,:customer_name,:invoice_id,:receipt_for,:amount,'0',:paid_by,:paid_date,:account_name,:account_number,:bank_name,:remarks,:company_id,:user_id,'Enable',:invoice_type)");
	$st->bindparam(":receipt_number",$receipt_number,PDO::PARAM_STR);
	$st->bindparam(":receipt_date",$receipt_date,PDO::PARAM_STR);
	$st->bindparam(":receipt_type",$receipt_type,PDO::PARAM_STR);
	$st->bindparam(":expenses_category_id",$expenses_category_id,PDO::PARAM_INT);
	$st->bindparam(":customer_name",$customer_name,PDO::PARAM_STR);
	$st->bindparam(":invoice_id",$invoice_id,PDO::PARAM_INT);
	$st->bindparam(":receipt_for",$receipt_for,PDO::PARAM_STR);
	$st->bindparam(":amount",$amount,PDO::PARAM_STR);
	$st->bindparam(":paid_by",$paid_by,PDO::PARAM_STR);
	$st->bindparam(":paid_date",$paid_date,PDO::PARAM_STR);
	$st->bindparam(":account_name",$account_name,PDO::PARAM_STR);
	$st->bindparam(":account_number",$account_number,PDO::PARAM_STR);
	$st->bindparam(":bank_name",$bank_name,PDO::PARAM_STR);
	$st->bindparam(":remarks",$remarks,PDO::PARAM_STR);
	$st->bindparam(":company_id",$company_id,PDO::PARAM_INT);
	$st->bindparam(":user_id",$user_id,PDO::PARAM_INT);
	$st->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
	$st->execute();
	
	$strlast =  getDB()->prepare("SELECT  `id` FROM `payable`  WHERE `company_id` = :company_id AND `invoice_type` = :invoice_type  ORDER BY `id` DESC LIMIT 1");
	$strlast->bindparam(":company_id",$company_id,PDO::PARAM_INT);
	$strlast->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
	$strlast->execute();
	$result = $strlast->fetch(PDO::FETCH_OBJ);
	$receipt_id =  $result->id; 
	$receipt_balance = 0;
	$paid_from_receipt = 0;
	
	if(!empty($invoice_id) AND is_numeric($invoice_id)) { 
		
		$sts =  getDB()->prepare("SELECT  `id`,`amt`,`exp_paid`,`paid_amount` FROM `expenses`  WHERE `id` = :invoice_id LIMIT 1");
		$sts->bindparam(":invoice_id",$invoice_id,PDO::PARAM_INT);
		$sts->execute();
		$editRow=$sts->fetch(PDO::FETCH_OBJ);
		if($editRow)
		{
			$bal = $editRow->amt;  //1000
			$inv_paid_amount = $editRow->paid_amount;  //500
			$exp_paid = $editRow->exp_paid;
			$balance_amount = $bal - $editRow->paid_amount;  //500
			
			$receipt_balance =  $paid_amount - $balance_amount;  //1000 - 500
			
			if($receipt_balance <= 0 ) {
				$paid_amounti =   $$inv_paid_amount + $paid_amount; 
				$paid_from_receipt =  $paid_amount;
				$receipt_balance = 0;
			}
			if($receipt_balance > 0 ) {
				$paid_amounti =   $inv_paid_amount + $balance_amount; 
				$receipt_balance = $receipt_balance;
				$paid_from_receipt =  $balance_amount;
			}
			
			$receipt_paid_amount = $paid_amount - $receipt_balance;
			
			if(($paid_amounti - $bal) == 0) 
			{ 
				$exp_paid = "Y";
			}
			
			saveReceipt($exp_paid,$paid_amounti,$invoice_id,$receipt_balance,$receipt_id,$invoice_type,$company_id,$receipt_number,$paid_from_receipt);
		}
	}
	if(empty($invoice_id)) 
	{
		$stoploop = 0;
		$receipt_balance_for_next_invoice = $paid_amount;
		$sts =  getDB()->prepare("SELECT  `id`,`amt`,`exp_paid`,`paid_amount` FROM `expenses`  WHERE `deleted` ='N' AND `company_id` = :company_id AND `exp_paid` = 'N' AND `expenses_category_id` = :expenses_category_id ORDER BY `id` ASC");
		$sts->bindparam(":company_id",$company_id,PDO::PARAM_INT);
		$sts->bindparam(":expenses_category_id",$expenses_category_id,PDO::PARAM_INT);
		$sts->execute();
		if($sts->rowCount() > 0)
		{
			while($editRow=$sts->fetch(PDO::FETCH_OBJ)) 
			{
					
				$invoice_id =  $editRow->id; 
				$bal = $editRow->amt;  //1000
				$inv_paid_amount = $editRow->paid_amount;  //500
				$exp_paid = $editRow->exp_paid;
				$balance_amount = $bal - $editRow->paid_amount;  //500
				
				$receipt_balance =  $paid_amount - $balance_amount;  //1000 - 500
				
				if($receipt_balance <= 0 ) {
					$paid_amounti =   $inv_paid_amount + $paid_amount; 
					$paid_from_receipt =  $paid_amount;
					$receipt_balance = 0;
					$stoploop = 1;
				}
				if($receipt_balance > 0 ) {
					$paid_amounti =   $inv_paid_amount + $balance_amount; 
					$receipt_balance = $receipt_balance;
					$paid_from_receipt =  $balance_amount;
					$paid_amount = $receipt_balance;
				}
			
				//$receipt_paid_amount = $paid_amount - $receipt_balance;
				
				if(($paid_amounti - $bal) == 0) 
				{ 
					$exp_paid = "Y";
				}
				
				saveReceipt($exp_paid,$paid_amounti,$invoice_id,$receipt_balance,$receipt_id,$invoice_type,$company_id,$receipt_number,$paid_from_receipt);
				if($stoploop == 1) {
					break;
				}
			}
		}
	}
	if($receipt_balance > 0) 
	{
		$stoploop = 0;
		$paid_amount = $receipt_balance;
		$sts =  getDB()->prepare("SELECT  `id`,`amt`,`exp_paid`,`paid_amount` FROM `expenses`  WHERE `deleted` ='N' AND `company_id` = :company_id AND `exp_paid` = 'N' AND `expenses_category_id` = :expenses_category_id ORDER BY `id` ASC");
		$sts->bindparam(":company_id",$company_id,PDO::PARAM_INT);
		$sts->bindparam(":expenses_category_id",$expenses_category_id,PDO::PARAM_INT);
		$sts->execute();
		if($sts->rowCount() > 0)
		{
			while($editRow=$sts->fetch(PDO::FETCH_OBJ)) 
			{
					
				$invoice_id =  $editRow->id; 
				$bal = $editRow->amt;  //1000
				$inv_paid_amount = $editRow->paid_amount;  //500
				$exp_paid = $editRow->exp_paid;
				$balance_amount = $bal - $editRow->paid_amount;  //500
				
				$receipt_balance =  $paid_amount - $balance_amount;  //1000 - 500
				
				if($receipt_balance <= 0 ) {
					$paid_amounti =   $inv_paid_amount + $paid_amount; 
					$paid_from_receipt =  $paid_amount;
					$receipt_balance = 0;
					$stoploop = 1;
				}
				if($receipt_balance > 0 ) {
					$paid_amounti =   $inv_paid_amount + $balance_amount; 
					$receipt_balance = $receipt_balance;
					$paid_from_receipt =  $balance_amount;
					$paid_amount = $receipt_balance;
				}
			
				//$receipt_paid_amount = $paid_amount - $receipt_balance;
				
				if(($paid_amounti - $bal) == 0) 
				{ 
					$exp_paid = "Y";
				}
				
				saveReceipt($exp_paid,$paid_amounti,$invoice_id,$receipt_balance,$receipt_id,$invoice_type,$company_id,$receipt_number,$paid_from_receipt);
				if($stoploop == 1) {
					break;
				}
			}
		}
	}	
	
	function saveReceipt($exp_paid,$paid_amounti,$invoice_id,$receipt_balance,$receipt_id,$invoice_type,$company_id,$receipt_number,$paid_from_receipt)
	{
		$stu =  getDB()->prepare("UPDATE `expenses` SET  `exp_paid` = :exp_paid, `paid_amount` = :paid_amounti WHERE `id` = :invoice_id LIMIT 1");
		$stu->bindparam(":exp_paid",$exp_paid,PDO::PARAM_STR);
		$stu->bindparam(":paid_amounti",$paid_amounti,PDO::PARAM_STR);
		$stu->bindparam(":invoice_id",$invoice_id,PDO::PARAM_INT);
		$stu->execute();
				
		$stur =  getDB()->prepare("UPDATE `payable` SET  `paid_amount` = :receipt_balance WHERE  `id` = :receipt_id AND `invoice_type` = :invoice_type  AND `company_id` = :company_id LIMIT 1");
		$stur->bindparam(":receipt_balance",$receipt_balance,PDO::PARAM_STR);
		$stur->bindparam(":receipt_id",$receipt_id,PDO::PARAM_INT);
		$stur->bindparam(":invoice_type",$invoice_type,PDO::PARAM_STR);
		$stur->bindparam(":company_id",$company_id,PDO::PARAM_INT);
		$stur->execute();
				
		$stm = getDB()->prepare("INSERT INTO `payable_details` (`receipt_id`, `receipt_number`, `invoice_id`, `amount`) VALUES (:receipt_id, :receipt_number, :invoice_id, :paid_from_receipt)");
		$stm->bindparam(":receipt_id",$receipt_id,PDO::PARAM_INT);
		$stm->bindparam(":receipt_number",$receipt_number,PDO::PARAM_STR);
		$stm->bindparam(":invoice_id",$invoice_id,PDO::PARAM_INT);
		$stm->bindparam(":paid_from_receipt",$paid_from_receipt,PDO::PARAM_STR);
		$stm->execute();
	}
	
?>
