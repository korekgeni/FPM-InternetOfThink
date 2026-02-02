<?php
    include "../connection.php";
    $sql = mysqli_query($dbconnect, "DELETE FROM tb_state");
    header("location:../../index.php?page=tambah-siswa");
?>