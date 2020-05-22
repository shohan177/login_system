<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>
<?php 
 session_start();
 //with out login can not view
 if (!isset($_SESSION['id']) AND !isset($_SESSION['email']) AND !isset($_SESSION['phone'])) {
    header("location:index.php");
  } ?>
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
/**
 * data recive frome databasee by user id 
 */
 $id = $_GET['id'];
 $sql = "SELECT * FROM user_info WHERE ID ='$id' ";
 $data = $connection -> query($sql);
 $fdata = $data -> fetch_assoc();

?>

<div class="card shadow w-50 mx-auto">
  <div class="card-header"><a href="all.php"><<-Back</a></div>
  <div class="card-body">
   <div class="col-4"> 
   </div>
   <div class="row">
      <div class="col-4"><img style="width:200px; height:200px; border-radius:1% 9%;"
      class="shadow" src="photos/<?php echo $fdata['photo']; ?>" alt=""></div>

      <div class="col-6">
        <p class="font-weight-bold">Name: <?php echo $fdata['name']; ?></p>
        <p class="font-weight-normal">Email: <?php echo $fdata['email']; ?></p>
        <p class="font-weight-normal">Phone: <?php echo $fdata['phone']; ?></p>
       
       
       
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