<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registaion</title>

	<link rel="stylesheet" href="asset/css/responsive.css">
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">


</head>
<body>



	<?php
		
		$mess[] = "";
		if(isset($_POST['save'])){
	
			  $name = $_POST['name'];
			  $uname = $_POST['uname'];
			  $email = $_POST['email'];
			  $pass = $_POST['pass'];
			  $cpass = $_POST['cpass'];
			  $phone = $_POST['phone'];
			//already taken fild check 
			 $check_uname = unique($connection,'user_info','uname',$uname);
			 $check_email = unique($connection,'user_info','email',$email);
			 $check_phone = unique($connection,'user_info','phone',$phone);
			
			//password hash
			  $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
			// pasword match  
			$pass_match = pasMatch($pass,$cpass);
			// function base notification

				if ($check_uname == false) {
					$mess[] = notification('user name already taken','info');
				}else{
					$mess[] ="";
				}

				if ($check_email == false) {
					$mess[] = notification('Email already taken','warning');
				}else{
					$mess[] ="";
				}

				if ($check_phone == false) {
					$mess[] = notification('Phone number already taken','dark');
				}else{
					$mess[] ="";
				}

				if ($pass_match == false) {
					$mess[] = notification('password not match','info');
				}else{
					$mess[] ="";
				}

		if(empty($name)||empty($email)||empty($pass)||empty($phone)){
			$mess[] = notification('Fild empty','danger');
			


		}elseif (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
			$mess[] = notification('Email error','warning');	
		
		}
		
		else{

			if( $check_uname == true AND $check_email == true AND $check_phone == true And $pass_match ==true){
				$data = fileUp($_FILES['photo'], "photos/");
				$photo_name = $data['file_name'];

				if($data['status'] == 'without'){
					/**
					 * register user without image
					 */
					$sql = "INSERT INTO user_info (name,uname,email,phone,pass)
					 VALUES ('$name','$uname','$email','$phone','$pass_hash')" ;
					$connection -> query($sql); 

					setMsg("register user without image");
					header("location:reg.php");
					
				}elseif($data['status'] == 'with'){
					/**
					 * register user with image
					 */
					$sql = "INSERT INTO user_info (name,uname,email,phone,pass,photo)
					 VALUES ('$name','$uname','$email','$phone','$pass_hash','$photo_name')" ;
					$connection -> query($sql);

					
					setMsg("register Done");
					header("location:reg.php");

				}else{

					$mess[] = notification('Insert valide image format','info');
				}
			}
			
			
			
		}
		
	};

	 ?>
	<div class="row">
	<div class="col-12 col-md-8"><div class="card shadow w-75" style=" margin-left: 20%;">
	
	

	<div class="card-body" style="max-height:90%;">
		<div class="card-head">
			<h2>Registaion</h2>
		</div>
		<form  action="" method="POST" enctype="multipart/form-data">
		<div class = "form-group">
			<label>Name:</label>
			<input type="text" class="form-control" name="name" value="<?php old('name');?>" placeholder="Full Name">
		</div>
		<div class = "form-group">
			<label>User Name:</label>
			<input type="text" class="form-control" name="uname" value="<?php old('uname');?>" placeholder="User Name">
		</div>

		<div class = "form-group">
			<label>Email:</label>
			<input type="text" class="form-control" name="email" value="<?php old('email');?>" placeholder="User Email">
		</div>

	
		<div class = "form-group">
			<label>Phone:</label>
			<input type="text" class="form-control" name="phone" value="<?php old('phone');?>"  placeholder="Phone Number">
		</div>

		<div class = "form-group">
			<label>Password:</label>
			<input type="password" class="form-control" name="pass" value="<?php old('pass');?>" placeholder="Password">
		</div>

		<div class = "form-group">
			<label>Conform Password:</label>
			<input type="password" class="form-control" name="cpass" value="<?php old('cpass');?>" placeholder="Conform Password">
		</div>

		<div class = "form-group">
			
			<input type="file" name="photo">
		</div>
		<div class = "form-group">
			
			<input type="submit" class="form-control bg-success" name="save" value="Save" >
		</div>


		</form>
		<div class="card-footer">
			<a href="index.php">Login</a>
		</div>
		
		</div>
	</div>
	</div>
	<div class="col-6 col-md-4" style="margin-top: 2%;">
	<?php 
	if (count($mess) > 0) {
		foreach ($mess as $m) {
			echo $m;
		}
	}
	echo getMsg();
	?>
		
	</div>
	</div>
	

	<script src="asset/js/jquery-3.4.1.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/script.js"></script>
	<!-- for notification -->
	

	
</body>
</html>