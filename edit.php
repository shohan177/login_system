<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>
<?php 
 session_start();
 //with out login can not view
 if (!isset($_SESSION['id']) AND !isset($_SESSION['email']) AND !isset($_SESSION['phone'])) {
    header("location:index.php");
  }
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<link rel="stylesheet" href="asset/css/responsive.css">
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
</head>
<body>
	<?php 

	    $id = $_GET['id'];
	    
		//update new data
		if(isset($_POST['update'])){
	 	$name = $_POST['name'];
	 	$uname = $_POST['uname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		
		//recive old data
		$sql = "SELECT * FROM user_info WHERE id ='$id'";
		$userdata = $connection -> query($sql);	
		$edit_data = $userdata -> fetch_assoc();
		

		//check email
		if ($email == $edit_data['email']) {
			$e_email = $email;
		}else{
			$check_email = unique($connection,'user_info','email',$email);
			if ($check_email == true) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
					$mess[] = notification('email error','info');
				}else{

					$e_email = $email;
				}

			}else{
				$mess[] = notification('email already taken','info');
			}
		}
		 
		//user name check
		if ($uname == $edit_data['uname']) {

			$e_uname = $uname ;

		}else{
			 $check_uname = unique($connection,'user_info','uname',$uname);
			 if ($check_uname == true) {
			 	
			 	$e_uname = $uname ;

			 }else{
			 	$mess[] = notification('user name already taken','info');
			 }
		}

		//phone number check
		if ($phone == $edit_data['phone']) {

			$e_phone = $phone ;
			
		}else{
			 $check_phone = unique($connection,'user_info','phone',$phone);
			 if ($check_phone == true) {
			 	
			 	$e_phone = $phone ;

			 }else{
			 	$mess[] = notification('phone already taken','info');
			 }
		}
		 

				
				

		//password manage
		$oldPass = $_POST['oldpass'];
		$newdPass = $_POST['newpass'];
		if (empty($newdPass)) {
			$password = $oldPass;
		}else{
			$password = password_hash($newdPass, PASSWORD_DEFAULT);
		}
		//file manage
		$new = $_FILES['new_photo']['name'];
		$old = $_POST['old_photo'];
		if (empty($new)) {
			$Photo_name = $old;
		}else{
			$pArra = fileUp($_FILES['new_photo'],"photos/");
			$Photo_name = $pArra['file_name'];
		}

		if(empty($name)||empty($email)||empty($phone)){
			$mess[] = notification('fild empty','info');
		}else{
			if (isset($e_email)AND isset($e_uname)AND isset($e_phone)) {
				session_destroy();
				
				$sql = "UPDATE user_info
				SET name = '$name',uname = '$e_uname' ,email= '$e_email', phone = '$e_phone', pass = '$password',photo = '$Photo_name'
				WHERE id =  $id";
				$connection -> query($sql); 
				$mess[] = notification('information updated','success','done');

				
			
				$_SESSION['id'] = $edit_data['id'];
				$_SESSION['name'] = $edit_data['name'];
				$_SESSION['email'] = $edit_data['email'];
				$_SESSION['phone'] = $edit_data['phone'];
				$_SESSION['photo'] = $edit_data['photo'];
				$_SESSION['uname'] = $edit_data['uname'];

				
			}
	
		}

		
		}
		//recive old data
		$sql = "SELECT * FROM user_info WHERE id ='$id'";
		$userdata = $connection -> query($sql);	
		$edit_data = $userdata -> fetch_assoc();


	 ?>

	 

	<div class="card shadow w-50 mx-auto">

		<a href="all.php"><< Back all user list</a>
		<a href="profile.php"><< Back to profile</a>
		<?php
	 if (isset($mess)) {
	 	if (count($mess) > 0) {
		foreach ($mess as $m) {
			echo $m;
		}
	}
	 }
	 
	?>
	<div class="card-body">
		<div class="card-head ">
			<h2>Update <?php echo $edit_data['name']; ?>'s information</h2>
		</div>
		<form  action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo $id = $_GET['id'];?>" method="POST" enctype="multipart/form-data">
		<div class = "form-group">
			<label>Name:</label>
			<input type="text" class="form-control" name="name" value="<?php echo $edit_data['name']; ?>" placeholder="User Name">
		</div>

		<div class = "form-group">
			<label>user name:</label>
			<input type="text" class="form-control" name="uname" value="<?php echo $edit_data['uname']; ?>" placeholder="User Name">
		</div>


		<div class = "form-group">
			<label>Email:</label>
			<input type="text" class="form-control" name="email" value="<?php echo $edit_data['email']; ?>" placeholder="User Email">
		</div>

	

		<div class = "form-group">
			<label>New password:</label>
			<input type="text" class="form-control" name="newpass" value="" placeholder="new password">
			<input type="hidden" name="oldpass" value="<?php echo $edit_data['pass']; ?>" >
		</div>

		

	
		<div class = "form-group">
			<label>Phone:</label>
			<input type="text" class="form-control" name="phone" value="<?php echo $edit_data['phone']; ?>"  placeholder="User Phone Number">
		</div>

		
		<div class="form-group">
			<img style="width: 200px; height: 200px;" src="photos/<?php echo $edit_data['photo']; ?>" alt="" >
			<input type="hidden" name="old_photo" value="<?php echo $edit_data['photo']; ?>" id="">
		</div>

		<div class = "form-group">
			<input name="new_photo" type="file" >
		</div>
		<div class = "form-group">
			
			<input type="submit" class="form-control bg-success" name="update" value="update Data" >
		</div>


		</form>
		
	</div>
</div>
	<script src="asset/js/jquery-3.4.1.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/script.js"></script>
</body>
</html>