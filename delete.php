<?php 

require_once "app/db.php";
require_once "app/function.php";
 session_start();
echo $id = $_GET['id'];
$remember = "rememLogin"."[".$id."]";
 
   session_destroy();
   //cookie disable
   setcookie('relog','',time() - (60*60*24*365));
   //remember log in 
   setcookie($remember,'',time() - (60*60*24*365));



$sql = "DELETE FROM user_info WHERE id ='$id'";
$connection -> query($sql);

 header("location:index.php");

