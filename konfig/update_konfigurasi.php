<?php
session_start();
if(isset($_SESSION['page'])){

if(isset($_POST['id']) && isset($_POST['param'])){ 
include 'connection.php';
$id = mysqli_real_escape_string($dbconnect, $_POST['id']);
$parameter = mysqli_real_escape_string($dbconnect, $_POST['param']);
$kolom = "";
	if($id == '1'){
		$kolom = "masuk_mulai";
	}
	else if($id == '2'){
		$kolom = "masuk_akhir";
	}
	else if($id == '3'){
		$kolom = "keluar_mulai";
	}
	else if($id == '4'){
		$kolom = "keluar_akhir";
	}
	else if($id == '5'){
		$kolom = "libur1";
	}
	else if($id == '6'){
		$kolom = "libur2";
	}
	else if($id == '7'){
		$kolom = "timezone";
	}
	else if($id == '8'){
		$kolom = "bot_token";
	}
	else if($id == '9'){
		$kolom = "ip";
	}
	
	
$sql = mysqli_query($dbconnect, "UPDATE tb_settings SET $kolom='$parameter'");

if($sql){
	header("location:../index.php?page=konfigurasi");
}
else{
	header("location:../index.php?page=konfigurasi&error=true");
}

}else{
	header("location:../index.php?page=konfigurasi&error=true");
}

}else{
	header("location:../index.php?page=konfigurasi&error=true");
}
?>