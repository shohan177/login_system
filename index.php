<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>
<?php 
	//session start
	session_start();
	if (isset($_SESSION['id']) AND isset($_SESSION['email']) AND isset($_SESSION['phone'])) {
		header("location:profile.php");
	}

	//relogin with cooki
	if (isset($_COOKIE['relog'])) {
		$user_id = $_COOKIE['relog'];

		// data recive by cookii id
		$sql = "SELECT * FROM user_info WHERE id = '$user_id'";
				$data = $connection -> query($sql);
				$login_user = $data -> fetch_assoc();

				// session create by cooki id
				$_SESSION['id'] = $login_user['id'];
				$_SESSION['name'] = $login_user['name'];
				$_SESSION['email'] = $login_user['email'];
				$_SESSION['phone'] = $login_user['phone'];
				$_SESSION['photo'] = $login_user['photo'];
				$_SESSION['uname'] = $login_user['uname'];

				// redirect user to profile page
				header("location:profile.php");
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>

	<link rel="stylesheet" href="asset/css/responsive.css">
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
</head>
<body>


	<?php
		
		
		if(isset($_POST['save'])){
		$user_name = $_POST['name'];
		$user_pass = $_POST['pass'];

		if(empty($user_pass)||empty($user_name)){
			$mess = notification('Input fild empty','warning');
		}else{

				$sql = "SELECT * FROM user_info WHERE uname = '$user_name'|| email = '$user_name'";
				$data = $connection -> query($sql);
				$login_user = $data -> fetch_assoc();
				//pasword verify
				if($data -> num_rows == 1){
					if (password_verify($user_pass, $login_user['pass'])) {
						

						//session data
						$_SESSION['id'] = $login_user['id'];
						$_SESSION['name'] = $login_user['name'];
						$_SESSION['email'] = $login_user['email'];
						$_SESSION['phone'] = $login_user['phone'];
						$_SESSION['photo'] = $login_user['photo'];
						$_SESSION['uname'] = $login_user['uname'];

						//cookie setup
						setcookie('relog',$login_user['id'],time() + (60*60*24*365));
						
						// redirect user to profile page
						header("location:profile.php");

					}else{
						$_SESSION['id'] = $login_user['id'];
						header("location:user_pass_verification.php");
					}
				}else{
					$mess = notification('Email | user not found','danger');
				}
		}
	

	
	};

	 ?>
	 
	<div class="row">
	    <div class="col ">
	    	<div class="mx-auto">
	     <!-- recent log in div start -->
		

		<?php if (isset($_COOKIE['rememLogin'])): ?>

		<?php 
		$remember_data = $_COOKIE['rememLogin'];
		foreach ($remember_data as $value): ?>
		
		<?php 
		$sql = "SELECT * FROM user_info WHERE id = '$value' ";
				$data = $connection -> query($sql);
				$login_user = $data -> fetch_assoc();
		?>
			
		
					<div class="car shadow w-25 mx-auto" style="margin-top:3%; margin-left: 2%">
						<a href="?triger=<?php echo $login_user['id'];?>">
							<div class="card-body w-25">
							<img style="max-height: 100px; max-width:100px; " src="photos/<?php echo $login_user['photo'];?>" alt="">
							</div>
						</a>
						
						<div class="card-footer">
							<a href="?task=<?php echo $login_user['id'];?>">Clear</a> <?php echo $login_user['uname'];?>
						</div>
					</div>
		
	
		<?php endforeach ?>
		<?php endif ?>
		<?php 
		if (isset($_GET['triger'])) {
			// redirect user to profile page
			$each_id = $_GET['triger'];

			$sql = "SELECT * FROM user_info WHERE id = '$each_id'";
				$data = $connection -> query($sql);
				$each_user = $data -> fetch_assoc();
				// session create by cooki id
				$_SESSION['id'] = $each_user['id'];
				// $_SESSION['name'] = $each_user['name'];
				// $_SESSION['email'] = $each_user['email'];
				// $_SESSION['phone'] = $each_user['phone'];
				// $_SESSION['photo'] = $each_user['photo'];
				// $_SESSION['uname'] = $each_user['uname'];
 
				// redirect user to profile page
				header("location:user_pass_verification.php");
			}
		

		 ?>
		

		<!-- recent log in disable start -->
		<?php
		if (isset($_GET['task'])) {
			$each_id = $_GET['task'];

			$remember = "rememLogin"."[".$each_id."]";

			setcookie($remember,'',time() - (60*60*24*365));
			header("location:index.php");
		}
		
		 ?>
		 <!-- recent log in disable End -->
		<!-- recent log in div End -->
			</div>
	    </div>
	    <div class="col">
	     
			<div class="card shadow w-50 mx-auto" style="margin-top: 5%;">
				<?php
				if (isset($mess)) {
					echo $mess; 
					
				}

				?>	

	<div class="card-body">
		<div class="card-head">
			<h2>Login</h2></br>
		</div>
		<form  action="" method="POST" enctype="multipart/form-data">
		<div class = "form-group">
			<label>User name:</label>
			<input type="text" class="form-control" name="name" value="<?php old('name');?>" placeholder="User Name">
		</div>

		<div class = "form-group">
			<label>Password:</label>
			<input type="password" class="form-control" name="pass" value="" placeholder="Password">
		</div>

		<div class = "form-group">
			
			<input type="submit" class="form-control bg-success" name="save" value="Save" >
		</div>


		</form>
		<div class="card-footer">
			<a href="reg.php">Create Account</a>
		</div>
		
	</div>
</div>

	    </div>
  </div>
	

	<script src="asset/js/jquery-3.4.1.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/script.js"></script>
</body>
</html>