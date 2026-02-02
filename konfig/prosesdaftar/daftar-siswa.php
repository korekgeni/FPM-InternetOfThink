<?php
include '../connection.php';
$error = 'true';
if(isset($_POST['id']) && isset($_POST['nama'])){
    $id = mysqli_real_escape_string($dbconnect, $_POST['id']);
    $nama = mysqli_real_escape_string($dbconnect, $_POST['nama']);
    $nisn = mysqli_real_escape_string($dbconnect, $_POST['nisn']);
    $jari = mysqli_real_escape_string($dbconnect, $_POST['jari']);
    $kelas = mysqli_real_escape_string($dbconnect, $_POST['kelas']); 
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($dbconnect, $_POST['gender']) : '';


    $sql = mysqli_query($dbconnect, "SELECT * FROM tb_id WHERE id='$id'");
    $cek = mysqli_num_rows($sql);
    if($cek > 0){
        mysqli_query($dbconnect, "UPDATE tb_id SET  nama='$nama', nisn='$nisn', jari='$jari', kelas='$kelas', gender='$gender' WHERE id='$id'");
        $error = 'false';
    }else{
        mysqli_query($dbconnect, "INSERT INTO tb_id (id,nama,nisn,jari,kelas,gender) VALUES ('$id','$nama','$nisn', '$jari', '$kelas', '$gender')");
        $error = 'false';
    }
    mysqli_query($dbconnect, "DELETE FROM tb_state");
    header("location:../../index.php?page=tambah-siswa&error=".$error);
    exit();
}
?>
