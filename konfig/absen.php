<?php
if(isset($_POST['id'])){
	include 'C:\xampp\htdocs\fpm_absen\konfig\function.php';
	$uid = $_POST['id'];
	$hari_ini = date('Y-m-d');
	$day = getday($hari_ini); //cek hari ini untuk parameter pada kondisi hari libur
	
	if($day == $libur1 || $day == $libur2){ //kondisi hari libur
		echo "Hari Libur";
	}else{
		$cek_uid = uid($uid); //cek UID apakah ada di database
		if($cek_uid == "0"){ // jika ID ada
			$cek_nisn = mysqli_query($dbconnect, "SELECT nisn FROM tb_id WHERE id='$uid'");
			$data_nisn = mysqli_fetch_assoc($cek_nisn);
			if (!$data_nisn || $data_nisn['nisn'] == '') {
				echo "ID Tidak Ada";
				exit;
			}
			$nisn = $data_nisn['nisn'];
			$time = date('H:i:s');
			$cek_absen = cektime($time, $masuk_mulai, $masuk_akhir, $keluar_mulai, $keluar_akhir); //menjalankan algoritma absen membandingkan jam
			$cek_masuk_nisn = mysqli_query(
				$dbconnect,
				"SELECT tb_absen.id, tb_absen.masuk, tb_absen.keluar
				FROM tb_absen
				INNER JOIN tb_id ON tb_absen.id = tb_id.id
				WHERE tb_id.nisn='$nisn' AND tb_absen.date='$hari_ini' AND tb_absen.masuk!=''
				ORDER BY tb_absen.masuk ASC
				LIMIT 1"
			);
			if (mysqli_num_rows($cek_masuk_nisn) > 0) {
				$row_masuk = mysqli_fetch_assoc($cek_masuk_nisn);
				$masuk_awal = $row_masuk['masuk'];
				$keluar_akhir = $row_masuk['keluar'];
				$selisih = abs(strtotime($time) - strtotime($masuk_awal));
				if ($selisih <= 60) {
					echo "Terima kasih";
					exit;
				}
				if ($keluar_akhir != "") {
					echo "Presensi sudah tercatat";
					exit;
				}
				if ($cek_absen != "out" && $cek_absen != "bolos") {
					echo "Presensi sudah tercatat";
					exit;
				}
				$uid = $row_masuk['id'];
			}
			$simpan_absen = postdata($uid, $hari_ini, $time, $cek_absen); //menyimpan hasil jam dan status absen di database
			$message = telegram($uid, $time, $simpan_absen, $bot_token); // mengirimkan pesan ke telegram
			echo $simpan_absen;
			}else{ //jika ID tidak ada
			echo "ID Tidak Ada";
		}
	}

}else{
	echo "Coba Lagi";
}
?>
