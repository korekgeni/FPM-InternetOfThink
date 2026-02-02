<?php 
session_start();
if(isset($_SESSION['page'])){

	if(isset($_POST['parameter'])){
		include 'connection.php';
		$parameter 	= mysqli_real_escape_string($dbconnect, $_POST['parameter']);
		$id 		= mysqli_real_escape_string($dbconnect, $_POST['id']);
		$nisn		= mysqli_real_escape_string($dbconnect, $_POST['nisn']);
		$nama		= mysqli_real_escape_string($dbconnect, $_POST['nama']);
		$telegram 	= mysqli_real_escape_string($dbconnect, $_POST['telegram']);
		$jari 		= mysqli_real_escape_string($dbconnect, $_POST['jari']);
		$kelas 		= mysqli_real_escape_string($dbconnect, $_POST['kelas']);
		$gender		= mysqli_real_escape_string($dbconnect, $_POST['gender']);
		
		
	$sql = mysqli_query($dbconnect,  
	"UPDATE tb_id SET id='$id', 
					nisn='$nisn',
					nama='$nama', 
					telegram_id='$telegram', 		
					jari='$jari', 
					kelas='$kelas', 
					gender='$gender'
			WHERE id='$parameter'");

			if($sql){
				$error = "false";
			}
			else{
				$error = "true";
			}
	}else{
		$error = "true";
	}

} else{
	$error = "true";
}
header("location:../index.php?page=siswa&error=".$error);
?>
