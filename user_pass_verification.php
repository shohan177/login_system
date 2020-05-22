<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>

<?php
		session_start();
		//redirect user without session id
		if (empty($_SESSION['id'])) {
			header("location:index.php");
		}
		//recive data base on session id
			$user_id = $_SESSION['id'];
			$sql = "SELECT * FROM user_info WHERE id = '$user_id'";
			$data = $connection -> query($sql);
			$login_user = $data -> fetch_assoc();
		
		if(isset($_POST['save'])){
			$user_pass = $_POST['pass'];

		if(empty($user_pass)){
			$mess = notification('Input fild empty','warning');
		}else{
			

			if (password_verify($user_pass, $login_user['pass'])) {
						

						//session data
						
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
						$mess = notification('Wrong password try aagin','warning');
					}
	
	}
	};

	 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $login_user['name']; ?></title>

	<link rel="stylesheet" href="asset/css/responsive.css">
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
</head>
<body>


	
	 
	<div class="row">
	    <div class="col"></div>
	    <div class="col">
	     
			<div class="card shadow w-50 mx-auto" style="margin-top: 5%;">
				<?php
				if (isset($mess)) {
					echo $mess; 
					
				}

				?>	

	<div class="card-body">
		<div class="card-head">
			<h4><?php echo $login_user['name']?></h4>
		</div>
		<form  action="" method="POST" enctype="multipart/form-data">
		<div class = "form-group">
			<img style="height:100px;width:100px ; border: 3px solid blue; border-radius: 50px;" src="photos/<?php echo $login_user['photo'];?>" alt="">
		</div>

		<div class = "form-group">
			<label>Password:</label>
			<input type="password" class="form-control" name="pass" value="" placeholder="Password">
		</div>

		<div class = "form-group">
			
			<input type="submit" class="form-control bg-success" name="save" value="Login" >
		</div>


		</form>
		
		
	</div>
	<div class="card-footer">
		<a href="index.php">Not my accound</a>
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