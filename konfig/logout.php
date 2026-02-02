<?php 
session_start();
$_SESSION['page'] = '';
session_destroy();

header("location:../login.php");
?>