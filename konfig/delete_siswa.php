<?php
session_start();
if(isset($_SESSION['page'])){

	if(isset($_GET['id'])){
		include'connection.php';
		$uid = $_GET['id'];
		$sql = mysqli_query($dbconnect,"DELETE FROM tb_id WHERE id='$uid'");
		$del_absen = mysqli_query($dbconnect,"DELETE FROM tb_absen WHERE id='$uid'");
		header("location:../index.php?page=siswa&error=false");
	}else{
		header("location:../index.php?page=siswa&error=true");
	}
		  
}else{
  header("location: ../index.php?page=dashboard&error=true");
}
?>