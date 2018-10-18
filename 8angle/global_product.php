<?php include 'includes/common.php';
isCompany($company_id);
$userDetails=$userClass->userDetails($session_uid);
	echo '<table class="table table-striped  dt-responsive nowrap" cellspacing="0" >';
    $param = ($_POST['sa']);
	if(strlen($param) >=2) 
	{
		if(!empty($param)) 
		{
			$divs = ($_POST['div']); 
			$div=$divs+1;
			$d = "inv".$div;
			$desc = ($_POST['desc']); 
			$inv_discount = 0;  $inv_amount = 0; $cnt= 1;
			?>
			<?php
			$params = array();
			
			$params[':param'] = '%'.$param.'%';	
			$params[':company_id'] = $company_id;
			
			$stmt_product = getDB()->prepare("SELECT * FROM `products` WHERE (`name` like :param OR  `code` like :param OR  `description` like :param ) AND `company_id` = :company_id AND `status` = 'Enable' AND `deleted` = 'N' LIMIT 20");
			$stmt_product->execute($params);
			
			if($stmt_product->rowCount()>0) 
			{
				while ($row = $stmt_product->fetch(PDO::FETCH_OBJ)) 
				{ ?>
					<tr><td><a href="javascript:;" onClick="load_ajax_data('<?php echo $d; ?>',<?php echo $row->id;?>,<?php echo $divs;?>,'<?php echo html_entity_decode($desc);?>')"><?php echo $row->name;?></b></a> </td></tr>
					<?php
				} 
			} 
			else  
			{	 ?> 
		
			<tr><td><a href="javascript:;" onClick="load_ajax_data('<?php echo $d; ?>',0,<?php echo $divs;?>,'<?php echo $param;?>')"><?php echo $param;?></b></a> </td></tr>
		<tr><td>No product Found.<a style="cursor: pointer; color:red; font-weight:bold;"
		  onclick="window.open('addproductquick.php','',' scrollbars=yes,menubar=no,width=600, resizable=yes,toolbar=no,location=no,status=no').focus()"> Add new</a></td></tr> 
		  <?php }
		}  else {
			?> <tr><td>No product Found.<a style="cursor: pointer; color:red; font-weight:bold;"
		  onclick="window.open('addproductquick.php','',' scrollbars=yes,menubar=no,width=600, resizable=yes,toolbar=no,location=no,status=no').focus()"> Add new</a></td></tr> 
		  <?php
		}
	}
	echo "</table>"; ?>