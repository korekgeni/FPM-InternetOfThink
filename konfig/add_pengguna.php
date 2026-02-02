<?php
if(isset($_POST['username']) && isset($_POST['password'])){
include 'connection.php';

$username = mysqli_real_escape_string($dbconnect, $_POST['username']);
$password = mysqli_real_escape_string($dbconnect, $_POST['password']);
$role = $_POST['role'];

if($role == 'Admin'){
	$role='0';
}
	$sql = mysqli_query($dbconnect,"INSERT INTO tb_pengguna(username, password, level) VALUES ('$username', '$password', '$role')");
	if($sql){
		$error = 'false';
	}else{
		$error = 'true';
	}
} else {
	$error= 'true';
}
header("location:../index.php?page=pengguna&error=".$error);
?>