<?php require_once "app/db.php" ?>
<?php require_once "app/function.php" ?>
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

	<a href="index.php">Add new user</a>

	
  <h2 class="t1">All User</h2>
 <div class="card  shadow"></div>
 <input type="text"><button class="bg-warning">serach</button>
 	<table style="margin-top:20px;" class="table table-striped">
    <thead class="thead-dark">
      <tr>
      	 <th>#</th>
      	 <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Adress</th>
        <th>photo</th>
        <th>Action</th>
      </tr>
    </thead>
    <?php 
	$sql = 'SELECT * FROM user_info';
	$data = $connection -> query($sql);

	while($fdata = $data -> fetch_assoc()):		
	
 ?>
    <tbody>
      <tr >
     <td ><?php echo $fdata['ID']; ?></td>
     <td><?php echo $fdata['Name']; ?></td>
     <td><?php echo $fdata['Email']; ?></td>
   
     <td><?php echo $fdata['Phone'];?></td>
     <td><?php echo $fdata['Adress']; ?></td>
     <td><img style="width: 30px;height: 30px;border-radius:10%" src="photos/<?php echo $fdata['photo_str']; ?>" alt=""></td>
     <td>
     	<div class="mw-100">

     	<a class="btn btn-sm btn-info" href="view_stu.php?id=<?php echo $fdata['ID']; ?>">View</a>
		<a class="btn btn-sm btn-warning" href="edit.php?id=<?php echo $fdata['ID']; ?>">Edit</a>
		<a id="del_user" class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $fdata['ID']; ?>">Del</a>
     	</div>
     	
		
	 </td>
     

     
   
     
      </tr>

    </tbody>

	<?php endwhile ?>
  </table>
</body>
</html>
</div>


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