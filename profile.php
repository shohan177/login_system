<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>
<?php 
/**
 * data recive frome session memory
 */
 session_start();
 //with out login can not view
 if (!isset($_SESSION['id']) AND !isset($_SESSION['email']) AND !isset($_SESSION['phone'])) {
    header("location:index.php");
  }

 //logout sysytem (session distoroy)
 if (isset($_GET['logout'])AND $_GET['logout'] == 'userlogout') {
  //session distroy
  $remember = "rememLogin"."[".$_SESSION['id']."]";
 
   session_destroy();
   //cookie disable
   setcookie('relog','',time() - (60*60*24*365));
   //remember log in 
   setcookie($remember,$_SESSION['id'],time() + (60*60*24*365));

   header("location:index.php");
  } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_SESSION['name']; ?></title>

	<link rel="stylesheet" href="asset/css/responsive.css">
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
</head>

<body>



<div class="card shadow w-50 mx-auto t-10">
  <div class="card-header"><a href="all.php">show profile</a></div>
  <div class="card-body">
   <div class="col-4"> 
   </div>
   <div class="row">
      <div class="col-4"><img style="height:200px; border-radius:1% 9%;"
      class="shadow" src="photos/<?php echo $_SESSION['photo']; ?>" alt=""></div>

      <div class="col-6">
        <p class="font-weight-bold">Name: <?php echo $_SESSION['name']; ?></p>
        <p class="font-weight-bold">user name: <?php echo $_SESSION['uname']; ?></p>
        <p class="font-weight-normal">Email: <?php echo $_SESSION['email']; ?></p>
        <p class="font-weight-normal">Phone: <?php echo $_SESSION['phone']; ?></p>
        </p>
        <p class="font-weight-normal"><a href="edit.php?id=<?php echo $_SESSION['id']; ?>">edit</a></p>
       
       
      </div>
       <a href="?logout=userlogout">Logout</a>
  </div>

  </div>


</div>

	<script src="asset/js/jquery-3.4.1.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/script.js"></script>
</body>
</html>