<?php 
	/**
		 * make sql connection
		 */
		$server = 'localhost';
		$user = 'root';
		$pass = '';
		$db_name = 'users';
		$connection = new mysqli($server,$user,$pass,$db_name);

 ?>