<?php
session_start();
if(isset($_SESSION['page'])){

if(isset($_POST['id']) && isset($_POST['status']) && isset($_POST['flag'])){

	include 'connection.php';
	$id = mysqli_real_escape_string($dbconnect, $_POST['id']);
	$tanggal = mysqli_real_escape_string($dbconnect, $_POST['tanggal']);
	$status = mysqli_real_escape_string($dbconnect, $_POST['status']);
	$keterangan = mysqli_real_escape_string($dbconnect, $_POST['keterangan']);
	$flag = mysqli_real_escape_string($dbconnect, $_POST['flag']);
	$error = "false";

	if($flag == '0'){
		$sql = mysqli_query($dbconnect, "UPDATE tb_absen SET status='$status', keterangan='$keterangan' WHERE date='$tanggal' AND id='$id'");
	}else{
		$sql = mysqli_query($dbconnect,"INSERT INTO tb_absen VALUES ('$id','-','-','$tanggal','$status','$keterangan')");
	}

	if($sql){
		$error = "false";
	}else{
		$error= "true";
	}

}else{
	$error = "true";
}

}else{
	$error = "true";
}
header("location:../index.php?page=absensi&error=".$error);
?>