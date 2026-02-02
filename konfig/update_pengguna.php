<?php 
session_start();
if(isset($_SESSION['page'])){

if(isset($_POST['no'])){

include 'connection.php';
$no = mysqli_real_escape_string($dbconnect, $_POST['no']);
$username = mysqli_real_escape_string($dbconnect, $_POST['username']);
$password = mysqli_real_escape_string($dbconnect, $_POST['password']);
$role = mysqli_real_escape_string($dbconnect, $_POST['role']);

$sql = mysqli_query($dbconnect, "UPDATE tb_pengguna SET username='$username', password='$password', level='$role' WHERE no='$no'");
    if($sql){
        $error = "false";
    }else{
        $error = "true";
    }
}else{
    $error="true";
}

}else{
    $error="true";
}
header("location:../index.php?page=pengguna&error=".$error);

?>