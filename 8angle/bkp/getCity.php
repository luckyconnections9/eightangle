<?php include 'includes/define.php';
$id = ($_GET['id']);
if(!empty($id)) {
$stmt_city = getDB()->prepare("SELECT * FROM `city` WHERE `District`=:id ORDER BY `Name` ASC");
$stmt_city->bindparam(":id",$id,PDO::PARAM_STR);
$stmt_city->execute();										 
if($stmt_city->rowCount()>0) {
			echo "<option value='0'>Select City</option>";
			  while($data_city=$stmt_city->fetch(PDO::FETCH_OBJ))
				{
					echo "<option value=".$data_city->ID.">".$data_city->Name."</option>";
				}
		 }
		 else
		 {
			  echo "<option value='0'>Select City</option>";
		 }
}
else {
	 echo "<option value='0'>Select City</option>";
}
?>