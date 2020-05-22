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

	
 
 	<table class="table table-striped shadow w-75 mx-auto">

  <h2 class="mx-auto">All User</h2>
    <thead class="thead-dark">
      <a href="profile.php"><< Back</a>

      <tr>
      	 <th>#</th>
      	 <th>Name</th>
         <th>User name</th>
        <th>Email</th>
        <th>Phone</th>
      
        <th>photo</th>
        <th>Action</th>
      </tr>
    </thead>
    <?php 
	$sql = 'SELECT * FROM user_info';
	$data = $connection -> query($sql);
  $i = 0;
	while($fdata = $data -> fetch_assoc()):		
	
 ?>
    <tbody>
      <tr >
     <td ><?php echo $i++ ?></td>
     <td><?php echo $fdata['name']; ?></td>
     <td><?php echo $fdata['uname']; ?></td>
     <td><?php echo $fdata['email']; ?></td>
   
     <td><?php echo $fdata['phone'];?></td>
   
     <td><img style="width: 30px;height: 30px;border-radius:10%" src="photos/<?php echo $fdata['photo']; ?>" alt=""></td>
     <td>
     	<div class="mw-100">
    <?php if ( $fdata['id'] == $_SESSION['id']):?>
     	<a class="btn btn-sm btn-info" href="view_users.php?id=<?php echo $fdata['id']; ?>">View</a>
		<a class="btn btn-sm btn-warning" href="edit.php?id=<?php echo $fdata['id']; ?>">Edit</a>
		<a id="del_user" class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $fdata['id']; ?>">Del</a>
    <?php else: ?>
    <a class="btn btn-sm btn-info" href="view_users.php?id=<?php echo $fdata['id']; ?>">View</a>
    <?php endif; ?>
     	</div>
     	
		
	 </td>
     

     
   
     
      </tr>

    </tbody>

	<?php endwhile ?>
  </table>



	<script src="asset/js/jquery-3.4.1.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/script.js"></script>
  <script>
    $('a#del_user').click(function(){

     let val = confirm('are you sure you want to delete');
     if (val==true) {
      return true;
     }else{
      return false;
     }

    });

  </script>
</body>
</html>