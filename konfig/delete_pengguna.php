<?php

session_start();
if(isset($_SESSION['page'])){

	if(isset($_GET['no'])){
		include'connection.php';
		$no_user = $_GET['no'];
		
		$sql = mysqli_query($dbconnect,"DELETE FROM tb_pengguna WHERE no='$no_user'");
		header("location:../index.php?page=pengguna");
	}else{
		header("location:../index.php?page=pengguna&error=true");
	}
  
}else{
  header("location: ../index.php?page=dashboard&error=true");
}

?>