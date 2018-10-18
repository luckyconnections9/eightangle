<?php
class userClass
{
	/* User Login */
	public function userLogin($usernameEmail,$password)
	{
		try{
		$db = getDB();
		$hash_password= hash('sha256', $password); //Password encryption 
		$stmt = $db->prepare("SELECT id,role FROM `users` WHERE (username=:usernameEmail or email=:usernameEmail) AND password_hash=:hash_password");
		$stmt->bindParam("usernameEmail", $usernameEmail,PDO::PARAM_STR) ;
		$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
		$stmt->execute();
		$count=$stmt->rowCount();
		$data=$stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
		if($count)
		{
		$_SESSION['uid']=$data->id; // Storing user session value
		$_SESSION['role']=$data->role;
		return true;
		}
		else
		{
		return false;
		}
		}
		catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	
	}
	
	public function getCount()
	{
		$db = getDB();
		$stmt = $db->prepare("SELECT id FROM users");
		$stmt->execute();
		$count=$stmt->rowCount();
		if($count >= 1) {
			return true;
		} else { return false; }
		
	}
	
	/* User Registration */
	public function userRegistration($username,$password,$email,$name)
	{
		try{
		if(userClass::getCount() == true) { return false; }
		$db = getDB();
		$st = $db->prepare("SELECT id FROM users WHERE username=:username OR email=:email");
		$st->bindParam("username", $username,PDO::PARAM_STR);
		$st->bindParam("email", $email,PDO::PARAM_STR);
		$st->execute();
		$count=$st->rowCount();
		if($count<1)
		{
		$stmt = $db->prepare("INSERT INTO users(username,password_hash,email,name,role) VALUES (:username,:hash_password,:email,:name,30)");
		$stmt->bindParam("username", $username,PDO::PARAM_STR) ;
		$hash_password= hash('sha256', $password); //Password encryption
		$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
		$stmt->bindParam("email", $email,PDO::PARAM_STR) ;
		$stmt->bindParam("name", $name,PDO::PARAM_STR) ;
		$stmt->execute();
		$uid=$db->lastInsertId(); // Last inserted row id
		$db = null;
		$_SESSION['uid']=$uid;
		$_SESSION['role']=30; //30 for Admin
		return true;
		}
		else
		{
		$db = null;
		return false;
		}
		
		}
		catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	public function userAdd($username,$password,$email,$name)
	{
		try{
		
		$db = getDB();
		$st = $db->prepare("SELECT id FROM users WHERE username=:username OR email=:email");
		$st->bindParam("username", $username,PDO::PARAM_STR);
		$st->bindParam("email", $email,PDO::PARAM_STR);
		$st->execute();
		$count=$st->rowCount();
		if($count<1)
		{
		$stmt = $db->prepare("INSERT INTO users(username,password_hash,email,name,role) VALUES (:username,:hash_password,:email,:name,10)");
		$stmt->bindParam("username", $username,PDO::PARAM_STR) ;
		$hash_password= hash('sha256', $password); //Password encryption
		$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
		$stmt->bindParam("email", $email,PDO::PARAM_STR) ;
		$stmt->bindParam("name", $name,PDO::PARAM_STR) ;
		$stmt->execute();
		return true;
		}
		else
		{
		return false;
		}
		
		}
		catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	/* User Details */
	public function userDetails($uid)
	{
		try{
		$db = getDB();
		$stmt = $db->prepare("SELECT email,username,name,role,created_at,status FROM users WHERE id=:uid");
		$stmt->bindParam("uid", $uid,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ); //User data
		return $data;
		}
		catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	
	public function dataview($query,$params)
	{
		$stmt = getDB()->prepare($query);
		$stmt->execute($params);
	 
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_OBJ))
			{

			?>
				<tr>
					<td><?php print(html_entity_decode($row->name)); ?></td>
					<td><?php print(html_entity_decode($row->email)); ?></td>
					<td><?php print(html_entity_decode($row->status)); ?></td>
					<td align="center">
						<a href="user_edit.php?edit_id=<?php print($row->id); ?>"><i class="glyphicon glyphicon-edit"></i></a>
					</td>
					<td align="center">
						<a href="users_delete.php?delete_id=<?php print($row->id); ?>" onClick="return(confirm('Action can not be undone. All company data will be deleted permanently. Are you sure?'))"><i class="glyphicon glyphicon-remove-circle"></i></a>
					</td>
				</tr>
				<?php
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="5">Nothing here...</td>
			</tr>
			<?php
		}
	  
	}
	
	}
?>

