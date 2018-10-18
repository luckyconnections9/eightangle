<?php include 'includes/common.php';
$meta_title = "Manage Assets Category - 8angle | POS  ";
require('header.php');
require('left.php');
isCompany($company_id);
include_once 'includes/assetscategoryClass.php';
$assetscategory = new assetscategoryClass();
 ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Manage Users
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Users</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
                <?php $userid = ""; $companyid = "";
					if(isset($_GET['userid'])  and !empty($_GET['userid']) and is_numeric($_GET['userid'])) 
					{ 
						$userid = ($_GET['userid']); 
					} else { echo "Select User"; exit();}
					if(isset($_GET['companyid'])  and !empty($_GET['companyid']) and is_numeric($_GET['companyid'])) 
					{ 
						$companyid = ($_GET['companyid']); 
					}
					
					$sqlUser=getDB()->prepare("SELECT username FROM users WHERE `id`=:userid ");
					$sqlUser->bindparam(":userid",$userid,PDO::PARAM_INT);
					$sqlUser->execute();
					$rowUser=$sqlUser->fetch(PDO::FETCH_ASSOC);
					
					
					$sqlPrivilege=getDB()->prepare("SELECT * FROM users_privileges WHERE  company_id = :companyid AND user_id=:userid ");
					$sqlPrivilege->bindparam(":userid",$userid,PDO::PARAM_INT);
					$sqlPrivilege->bindparam(":companyid",$companyid,PDO::PARAM_INT);
					$sqlPrivilege->execute();
				@	$rowPrivilege=$sqlPrivilege->fetch(PDO::FETCH_ASSOC);
		
if(isset($_POST['submit']))
{
	$companyid = ($_GET['companyid']);
	$userid = ($_GET['userid']);
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	$sqlExist=getDB()->prepare("SELECT id,company_id FROM users_privileges WHERE company_id = :companyid AND user_id=:userid ");
	$sqlExist->bindparam(":userid",$userid,PDO::PARAM_INT);
	$sqlExist->bindparam(":companyid",$companyid,PDO::PARAM_INT);
	$sqlExist->execute();
	$rowExist=$sqlExist->fetch(PDO::FETCH_ASSOC);
	if($sqlExist->rowCount() >0)
	{
			$sqlInsert="UPDATE users_privileges SET ";

		if(isset($_POST['companies_add'])) { $sqlInsert.="companies_add=1, "; } else { $sqlInsert.="companies_add=2, "; }
		if(isset($_POST['companies_edit'])) { $sqlInsert.="companies_edit=1, "; } else { $sqlInsert.="companies_edit=2, "; }
		if(isset($_POST['companies_view'])) { $sqlInsert.="companies_view=1, "; } else { $sqlInsert.="companies_view=2, "; }
		if(isset($_POST['companies_delete'])) {	$sqlInsert.="companies_delete=1, "; } else { $sqlInsert.="companies_delete=2, "; }
		
		if(isset($_POST['assets_add'])) { $sqlInsert.="assets_add=1, "; } else { $sqlInsert.="assets_add=2, "; }
		if(isset($_POST['assets_edit'])) { $sqlInsert.="assets_edit=1, "; } else { $sqlInsert.="assets_edit=2, "; }
		if(isset($_POST['assets_view'])) { $sqlInsert.="assets_view=1, "; } else { $sqlInsert.="assets_view=2, "; }
		if(isset($_POST['assets_delete'])) {	$sqlInsert.="assets_delete=1, "; } else { $sqlInsert.="assets_delete=2, "; }
		
		if(isset($_POST['customers_add'])) { $sqlInsert.="customers_add=1, "; } else { $sqlInsert.="customers_add=2, "; }
		if(isset($_POST['customers_edit'])) { $sqlInsert.="customers_edit=1, "; } else { $sqlInsert.="customers_edit=2, "; }
		if(isset($_POST['customers_view'])) { $sqlInsert.="customers_view=1, "; } else { $sqlInsert.="customers_view=2, "; }
		if(isset($_POST['customers_delete'])) {	$sqlInsert.="customers_delete=1, "; } else { $sqlInsert.="customers_delete=2, "; }
		
		if(isset($_POST['expenses_add'])) { $sqlInsert.="expenses_add=1, "; } else { $sqlInsert.="expenses_add=2, "; }
		if(isset($_POST['expenses_edit'])) { $sqlInsert.="expenses_edit=1, "; } else { $sqlInsert.="expenses_edit=2, "; }
		if(isset($_POST['expenses_view'])) { $sqlInsert.="expenses_view=1, "; } else { $sqlInsert.="expenses_view=2, "; }
		if(isset($_POST['expenses_delete'])) {	$sqlInsert.="expenses_delete=1, "; } else { $sqlInsert.="expenses_delete=2, "; }
		
		if(isset($_POST['invoice_tax_add'])) { $sqlInsert.="invoice_tax_add=1, "; } else { $sqlInsert.="invoice_tax_add=2, "; }
		if(isset($_POST['invoice_tax_edit'])) { $sqlInsert.="invoice_tax_edit=1, "; } else { $sqlInsert.="invoice_tax_edit=2, "; }
		if(isset($_POST['invoice_tax_view'])) { $sqlInsert.="invoice_tax_view=1, "; } else { $sqlInsert.="invoice_tax_view=2, "; }
		if(isset($_POST['invoice_tax_delete'])) {	$sqlInsert.="invoice_tax_delete=1, "; } else { $sqlInsert.="invoice_tax_delete=2, "; }
				
		if(isset($_POST['orders_add'])) { $sqlInsert.="orders_add=1, "; } else { $sqlInsert.="orders_add=2, "; }
		if(isset($_POST['orders_edit'])) { $sqlInsert.="orders_edit=1, "; } else { $sqlInsert.="orders_edit=2, "; }
		if(isset($_POST['orders_view'])) { $sqlInsert.="orders_view=1, "; } else { $sqlInsert.="orders_view=2, "; }
		if(isset($_POST['orders_delete'])) {	$sqlInsert.="orders_delete=1, "; } else { $sqlInsert.="orders_delete=2, "; }
					
		if(isset($_POST['products_add'])) { $sqlInsert.="products_add=1, "; } else { $sqlInsert.="products_add=2, "; }
		if(isset($_POST['products_edit'])) { $sqlInsert.="products_edit=1, "; } else { $sqlInsert.="products_edit=2, "; }
		if(isset($_POST['products_view'])) { $sqlInsert.="products_view=1, "; } else { $sqlInsert.="products_view=2, "; }
		if(isset($_POST['products_delete'])) {	$sqlInsert.="products_delete=1, "; } else { $sqlInsert.="products_delete=2, "; }

		if(isset($_POST['stock_view'])) {	$sqlInsert.="stock_view=1, "; } else { $sqlInsert.="stock_view=2, "; }
				
		if(isset($_POST['users_add'])) { $sqlInsert.="users_add=1, "; } else { $sqlInsert.="users_add=2, "; }
		if(isset($_POST['users_edit'])) { $sqlInsert.="users_edit=1, "; } else { $sqlInsert.="users_edit=2, "; }
		if(isset($_POST['users_view'])) { $sqlInsert.="users_view=1, "; } else { $sqlInsert.="users_view=2, "; }
		if(isset($_POST['users_delete'])) {	$sqlInsert.="users_delete=1, "; } else { $sqlInsert.="users_delete=2, "; }
			
		if(isset($_POST['vendor_orders_add'])) { $sqlInsert.="vendor_orders_add=1, "; } else { $sqlInsert.="vendor_orders_add=2, "; }
		if(isset($_POST['vendor_orders_edit'])) { $sqlInsert.="vendor_orders_edit=1, "; } else { $sqlInsert.="vendor_orders_edit=2, "; }
		if(isset($_POST['vendor_orders_view'])) { $sqlInsert.="vendor_orders_view=1, "; } else { $sqlInsert.="vendor_orders_view=2, "; }
		if(isset($_POST['vendor_orders_delete'])) {	$sqlInsert.="vendor_orders_delete=1, "; } else { $sqlInsert.="vendor_orders_delete=2, "; }
			
		if(isset($_POST['vendors_add'])) { $sqlInsert.="vendors_add=1, "; } else { $sqlInsert.="vendors_add=2, "; }
		if(isset($_POST['vendors_edit'])) { $sqlInsert.="vendors_edit=1, "; } else { $sqlInsert.="vendors_edit=2, "; }
		if(isset($_POST['vendors_view'])) { $sqlInsert.="vendors_view=1, "; } else { $sqlInsert.="vendors_view=2, "; }
		if(isset($_POST['vendors_delete'])) {	$sqlInsert.="vendors_delete=1, "; } else { $sqlInsert.="vendors_delete=2, "; }
		
		//
		
		$sqlInsert.=" `company_id` = '".$rowExist['company_id']."' WHERE `id`=".$rowExist['id'];
		echo $sqlInsert;
		$rsInsert=getDB()->prepare($sqlInsert);
		$rsInsert->execute();	
	}
	else
	{
		$sqlInsert="INSERT INTO users_privileges SET ";

		if(isset($_POST['companies_add'])) { $sqlInsert.="companies_add=1, "; } else { $sqlInsert.="companies_add=2, "; }
		if(isset($_POST['companies_edit'])) { $sqlInsert.="companies_edit=1, "; } else { $sqlInsert.="companies_edit=2, "; }
		if(isset($_POST['companies_view'])) { $sqlInsert.="companies_view=1, "; } else { $sqlInsert.="companies_view=2, "; }
		if(isset($_POST['companies_delete'])) {	$sqlInsert.="companies_delete=1, "; } else { $sqlInsert.="companies_delete=2, "; }
		
		if(isset($_POST['assets_add'])) { $sqlInsert.="assets_add=1, "; } else { $sqlInsert.="assets_add=2, "; }
		if(isset($_POST['assets_edit'])) { $sqlInsert.="assets_edit=1, "; } else { $sqlInsert.="assets_edit=2, "; }
		if(isset($_POST['assets_view'])) { $sqlInsert.="assets_view=1, "; } else { $sqlInsert.="assets_view=2, "; }
		if(isset($_POST['assets_delete'])) {	$sqlInsert.="assets_delete=1, "; } else { $sqlInsert.="assets_delete=2, "; }
		
		if(isset($_POST['customers_add'])) { $sqlInsert.="customers_add=1, "; } else { $sqlInsert.="customers_add=2, "; }
		if(isset($_POST['customers_edit'])) { $sqlInsert.="customers_edit=1, "; } else { $sqlInsert.="customers_edit=2, "; }
		if(isset($_POST['customers_view'])) { $sqlInsert.="customers_view=1, "; } else { $sqlInsert.="customers_view=2, "; }
		if(isset($_POST['customers_delete'])) {	$sqlInsert.="customers_delete=1, "; } else { $sqlInsert.="customers_delete=2, "; }
		
		if(isset($_POST['expenses_add'])) { $sqlInsert.="expenses_add=1, "; } else { $sqlInsert.="expenses_add=2, "; }
		if(isset($_POST['expenses_edit'])) { $sqlInsert.="expenses_edit=1, "; } else { $sqlInsert.="expenses_edit=2, "; }
		if(isset($_POST['expenses_view'])) { $sqlInsert.="expenses_view=1, "; } else { $sqlInsert.="expenses_view=2, "; }
		if(isset($_POST['expenses_delete'])) {	$sqlInsert.="expenses_delete=1, "; } else { $sqlInsert.="expenses_delete=2, "; }
		
		if(isset($_POST['invoice_tax_add'])) { $sqlInsert.="invoice_tax_add=1, "; } else { $sqlInsert.="invoice_tax_add=2, "; }
		if(isset($_POST['invoice_tax_edit'])) { $sqlInsert.="invoice_tax_edit=1, "; } else { $sqlInsert.="invoice_tax_edit=2, "; }
		if(isset($_POST['invoice_tax_view'])) { $sqlInsert.="invoice_tax_view=1, "; } else { $sqlInsert.="invoice_tax_view=2, "; }
		if(isset($_POST['invoice_tax_delete'])) {	$sqlInsert.="invoice_tax_delete=1, "; } else { $sqlInsert.="invoice_tax_delete=2, "; }
				
		if(isset($_POST['orders_add'])) { $sqlInsert.="orders_add=1, "; } else { $sqlInsert.="orders_add=2, "; }
		if(isset($_POST['orders_edit'])) { $sqlInsert.="orders_edit=1, "; } else { $sqlInsert.="orders_edit=2, "; }
		if(isset($_POST['orders_view'])) { $sqlInsert.="orders_view=1, "; } else { $sqlInsert.="orders_view=2, "; }
		if(isset($_POST['orders_delete'])) {	$sqlInsert.="orders_delete=1, "; } else { $sqlInsert.="orders_delete=2, "; }
					
		if(isset($_POST['products_add'])) { $sqlInsert.="products_add=1, "; } else { $sqlInsert.="products_add=2, "; }
		if(isset($_POST['products_edit'])) { $sqlInsert.="products_edit=1, "; } else { $sqlInsert.="products_edit=2, "; }
		if(isset($_POST['products_view'])) { $sqlInsert.="products_view=1, "; } else { $sqlInsert.="products_view=2, "; }
		if(isset($_POST['products_delete'])) {	$sqlInsert.="products_delete=1, "; } else { $sqlInsert.="products_delete=2, "; }

		if(isset($_POST['stock_view'])) {	$sqlInsert.="stock_view=1, "; } else { $sqlInsert.="stock_view=2, "; }
				
		if(isset($_POST['users_add'])) { $sqlInsert.="users_add=1, "; } else { $sqlInsert.="users_add=2, "; }
		if(isset($_POST['users_edit'])) { $sqlInsert.="users_edit=1, "; } else { $sqlInsert.="users_edit=2, "; }
		if(isset($_POST['users_view'])) { $sqlInsert.="users_view=1, "; } else { $sqlInsert.="users_view=2, "; }
		if(isset($_POST['users_delete'])) {	$sqlInsert.="users_delete=1, "; } else { $sqlInsert.="users_delete=2, "; }
			
		if(isset($_POST['vendor_orders_add'])) { $sqlInsert.="vendor_orders_add=1, "; } else { $sqlInsert.="vendor_orders_add=2, "; }
		if(isset($_POST['vendor_orders_edit'])) { $sqlInsert.="vendor_orders_edit=1, "; } else { $sqlInsert.="vendor_orders_edit=2, "; }
		if(isset($_POST['vendor_orders_view'])) { $sqlInsert.="vendor_orders_view=1, "; } else { $sqlInsert.="vendor_orders_view=2, "; }
		if(isset($_POST['vendor_orders_delete'])) {	$sqlInsert.="vendor_orders_delete=1, "; } else { $sqlInsert.="vendor_orders_delete=2, "; }
			
		if(isset($_POST['vendors_add'])) { $sqlInsert.="vendors_add=1, "; } else { $sqlInsert.="vendors_add=2, "; }
		if(isset($_POST['vendors_edit'])) { $sqlInsert.="vendors_edit=1, "; } else { $sqlInsert.="vendors_edit=2, "; }
		if(isset($_POST['vendors_view'])) { $sqlInsert.="vendors_view=1, "; } else { $sqlInsert.="vendors_view=2, "; }
		if(isset($_POST['vendors_delete'])) {	$sqlInsert.="vendors_delete=1, "; } else { $sqlInsert.="vendors_delete=2, "; }
			//		
		$sqlInsert.=" user_id= :userid, company_id=:companyid ";
		$rsInsert=getDB()->prepare($sqlInsert);
		$rsInsert->bindparam(":userid",$userid,PDO::PARAM_INT);
		$rsInsert->bindparam(":companyid",$companyid,PDO::PARAM_INT);
		$rsInsert->execute();
	}
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=users_management.php?updated=Y">'; 
	
		header('Location:users_management.php?updated=Y');	
		exit;
}
if($companyid == "") {
	?>
	<div class="col-sm-12">
			<form action="" method="get" >
				<select class="form-control input-lg" name="company_id" onChange=" window.location.href= 'user_privileges.php?companyid='+this.value+'&userid=<?php echo $userid;?>'" >
					<option value="" <?php if($companyid == "") { echo "selected";}?>> Select Company </option>
					<?php 
						$stmt_comp1 = getDB()->prepare("SELECT * FROM companies WHERE status='Enable' AND `deleted`='N'");
						$stmt_comp1->execute();
						$comp_sel1 = "";
						 while($data_comp1=$stmt_comp1->fetch(PDO::FETCH_OBJ))
						 {
							if($data_comp1->id == $companyid) { $comp_sel ="selected='selected'";} else { $comp_sel1 = "";  }
							echo "<option  ".$comp_sel1."  value=".$data_comp1->id.">".$data_comp1->name."</option>";
						 }
						?>          
				</select>
			</form>
	</div>
	<?php
	exit();
}
?>
	<table class="col-sm-12" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="22" align="center"><h1>ASSIGN PRIVILEGE(S) FOR <span style="color:#F00"><?php echo $rowUser['username'];?></span></h1></td>
      </tr>
      <tr>
        <td align="center" valign="top">
		<form name="addprivilege" id="addprivilege" action="user_privileges.php?userid=<?php echo $userid;?>&companyid=<?php echo $companyid;?>" method="post">
          <table width="70%" cellpadding="3" cellspacing="3" class="bdr" border="0" style="border-collapse:collapse;">
            <tr>
              <td colspan="2"><h4>Assign permissions</h4></td>
            </tr>
            <?php include_once('privileges_cat.php'); ?>
            <tr align="left">
              <td class="textbdr">&nbsp;</td>
              <td align="left" class="textbdr">&nbsp;</td>
            </tr>
            <tr align="left">
              <td width="27%" class="textbdr">&nbsp;</td>
              <td width="73%" align="left" class="textbdr"><input type="submit" name="submit" value="Update Privileges" class="text" /></td>
            </tr>
          </table>
        </form>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr></tr>
    </table>
              
             </p>            
	</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
