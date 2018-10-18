<?php include 'includes/common.php';
isCompany($company_id);
$id = ($_GET['id']);
if(!empty($id)) {
?>
HSN Code search Source: <a href="http://eightangle.com/?page=hsn_search" target="_blank" title="Eightenagle.Com">Eightangle.com</a>
<iframe src="http://eightangle.com/hsn.php?id=<?php echo $id;?>"  width="100%" height="450px"/>
<?php
}
else {
	 echo "No HSN Code found for this Product";
}
?>