<?php
include '../connection.php';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$parameter = isset($_POST['parameter']) ? $_POST['parameter'] : '';

// Batasi ID hanya numerik (ID fingerprint) kecuali sinyal dari kontroler
if ($id !== 'kontroler' && $id !== 'response' && !ctype_digit($id)) {
    echo 'ID tidak valid';
    exit;
}

if ($parameter == "cek" && $id != "kontroler") {
    mysqli_query($dbconnect, "DELETE FROM tb_state");
    $safeId = mysqli_real_escape_string($dbconnect, $id);
    $sql = mysqli_query($dbconnect, "SELECT * FROM tb_id WHERE id = '$safeId'");
    $cek = mysqli_num_rows($sql);
    if ($cek > 0) {
        echo '1';
    } else {
        $sql = mysqli_query($dbconnect, "INSERT INTO tb_state VALUES ('1','','$safeId')");
        if ($sql) {
            echo 'Melakukan Proses';
        } else {
            echo 'Proses Gagal!';
        }
    }
} else if ($parameter == "daftar" && $id != "kontroler") {
    $safeId = mysqli_real_escape_string($dbconnect, $id);
    mysqli_query($dbconnect, "DELETE FROM tb_state"); // pastikan antrian bersih
    $sql = mysqli_query($dbconnect, "INSERT INTO tb_state VALUES ('1','','$safeId')");
    if ($sql) {
        echo 'Melakukan Proses';
    } else {
        echo 'Proses Gagal!';
    }
} else if($parameter == "response" && $id == "response"){
    $sql = mysqli_query($dbconnect, "SELECT * FROM tb_state ORDER BY status DESC LIMIT 1");
    if ($sql && mysqli_num_rows($sql) > 0) {
        $response = mysqli_fetch_assoc($sql);
        if($response['pesan_kontroler'] != ""){
            echo $response['pesan_kontroler'];
        } else{
            echo "Melakukan Proses Pendaftaran";
        } 
    } else {
        echo "Menunggu perintah kontroler";
    }

} else if($id == "kontroler" && $parameter!=""){
    $safeParam = mysqli_real_escape_string($dbconnect, $parameter);
    $sql = mysqli_query($dbconnect, "UPDATE tb_state SET status='0', pesan_kontroler='$safeParam' ORDER BY status DESC LIMIT 1");
    echo $parameter;
}

?>
