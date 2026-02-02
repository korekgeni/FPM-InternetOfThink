<?php

include 'connection.php'; 
//=====================================Load Settings From Datbase=======================================
$sql= mysqli_query($dbconnect, "SELECT * FROM tb_settings");
while($data = mysqli_fetch_array($sql)){
	$masuk_mulai = $data['masuk_mulai'];
	$masuk_akhir = $data['masuk_akhir'];
	$keluar_mulai = $data['keluar_mulai'];
	$keluar_akhir = $data['keluar_akhir'];
	$libur1 = $data['libur1'];
	$libur2 = $data['libur2'];
	$timezone = $data['timezone'];
	$bot_token = $data['bot_token'];
	$ip = $data['ip'];
}
//====================================load timezone====================================================
date_default_timezone_set($timezone);
//====================================Cek jumlah hari dalam bulan======================================
function jumlah_hari($month, $year){
	$jumlah = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	return $jumlah;
}
//=====================================Cek Hari Libur================================================
function getday($tanggal){
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);
    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
}
//=====================================Cek ID di DB==============================================
function uid($id){
	global $dbconnect; 
	$sql = mysqli_query($dbconnect,"select * from tb_id where id='$id'");
	$auth = mysqli_num_rows($sql);
		if($auth > 0){
			return("0");
		}else{ 
			return("1");
		}
}
//=====================================Cek jam absen==============================================
function cektime($time, $m_mulai, $m_akhir, $k_mulai, $k_akhir){
	if($time > $m_mulai && $time < $m_akhir){
		return "in"; //parameter absen masuk
	}
	else if ($time >  $m_akhir && $time < $k_mulai){
		return "terlambat"; //parameter absen masuk terlambat
	}
	else if($time > $k_mulai && $time < $k_akhir){
		return "out"; //parameter absen pulang
	}
	else if($time > $k_akhir){
		return "bolos"; //parameter absen bolos
	}
	else{
		return "bolos"; //parameter tidak diset
	}	
}
//=====================================Cek Masuk/Pulang 1x per Hari==============================================
function cek_sudah_masuk($uid, $hari_ini)
{
	global $dbconnect;
	$sql = mysqli_query($dbconnect, "SELECT masuk FROM tb_absen WHERE id='$uid' AND date='$hari_ini' AND masuk!=''");
	return mysqli_num_rows($sql) > 0;
}

function cek_sudah_pulang($uid, $hari_ini)
{
	global $dbconnect;
	$sql = mysqli_query($dbconnect, "SELECT keluar FROM tb_absen WHERE id='$uid' AND date='$hari_ini' AND keluar!=''");
	return mysqli_num_rows($sql) > 0;
}


//===============================Insert or Update Database Absen==================================
function postdata($uid, $hari_ini, $time, $cek_absen){
	global $dbconnect;
	$sql = mysqli_query($dbconnect,"select * from tb_absen where id='$uid' and date='$hari_ini'");
	$auth = mysqli_num_rows($sql);
		if ($auth > 0){
			if($cek_absen == "in"){
				mysqli_query($dbconnect, "UPDATE tb_absen SET masuk='$time', status = 'H' WHERE id='$uid' AND date='$hari_ini'");
				return("Presensi Masuk");
			}
			else if($cek_absen == "terlambat"){
				mysqli_query($dbconnect, "UPDATE tb_absen SET masuk='$time', status = 'T' WHERE id='$uid' AND date='$hari_ini'");
				return("Presensi Terlambat");
			}
			else if($cek_absen == "out"){
				$cek_masuk = mysqli_query($dbconnect, "select * from tb_absen WHERE id='$uid' AND date='$hari_ini'");
					while($data = mysqli_fetch_array($cek_masuk)){
						$masuk = $data['masuk'];
						$status = $data['status'];
							if($masuk != "" && $status != "T"){
								mysqli_query($dbconnect, "UPDATE tb_absen SET keluar='$time', status = 'H' WHERE id='$uid' AND date='$hari_ini'");
								return ("Presensi Hadir");
							}
							else if ($masuk != "" && $status == "T"){
								mysqli_query($dbconnect, "UPDATE tb_absen SET keluar='$time', status = 'T' WHERE id='$uid' AND date='$hari_ini'");
								return ("Presensi Terlambat");
							}
							else if ($masuk == "" && $status == "B"){
								mysqli_query($dbconnect, "UPDATE tb_absen SET keluar='$time', status = 'B' WHERE id='$uid' AND date='$hari_ini'");
								return ("Presensi Bolos");
							}			
					}	
			}
			else if($cek_absen == "bolos"){
				mysqli_query($dbconnect, "UPDATE tb_absen SET keluar='$time', status = 'B' WHERE id='$uid' AND date='$hari_ini'");
				return ("Presensi Selesai");
			}
			
		}
		else{	
			if($cek_absen == "in"){
				mysqli_query($dbconnect,"INSERT INTO tb_absen VALUES ('$uid','$time','','$hari_ini','H','')");
				return ("Presensi Masuk");
			}
			else if($cek_absen == "terlambat"){
				mysqli_query($dbconnect,"INSERT INTO tb_absen VALUES ('$uid','$time','','$hari_ini','T','')");
				return ("Presensi Terlambat");
			}
			else if($cek_absen == "out"){
				mysqli_query($dbconnect,"INSERT INTO tb_absen VALUES ('$uid','','$time','$hari_ini','B','')");
				return ("Presensi Keluar");
			}
			else if($cek_absen == "bolos"){
				mysqli_query($dbconnect,"INSERT INTO tb_absen VALUES ('$uid','','$time','$hari_ini','B','')");
				return ("Presensi Bolos");
			}
		}
		mysqli_close($dbconnect);
}

//======================== cek jumlah absen ========================

function num_row($tabel, $parameter, $value1, $value2, $date_awal, $date_akhir){
global $dbconnect;
//$sql = mysqli_query($dbconnect, "SELECT $parameter FROM $tabel WHERE id='$value2' AND status='$value1'");
$sql = mysqli_query($dbconnect, "SELECT * FROM $tabel WHERE date BETWEEN '$date_awal' AND '$date_akhir' AND id= '$value2' AND status='$value1'");
$hasil = mysqli_num_rows($sql);
return $hasil;
}


//======================== Telegram Info absen ========================
function telegram($uid, $jam_absen, $status, $secret_token) {
	global $dbconnect;
	$sql = mysqli_query($dbconnect, "SELECT * FROM tb_id WHERE id='$uid'");
	while($results = mysqli_fetch_array($sql)){
			$nama = $results['nama'];
			$chat_id= $results['telegram_id'];
	}
	$message_text = "Haloo,".$nama."\nAbsen anda telah berhasil disimpan. dengan status saat ini : \n". $status ."\njam absen : ". $jam_absen;
    $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=markdown&chat_id=" . $chat_id;
    $url = $url . "&text=" . urlencode($message_text);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
	curl_close($ch);
}

 
function getToken($val){
 $token = password_hash($val, PASSWORD_DEFAULT);
 return $token;
}

/*======================================================================================
								Function Query Tambahan
======================================================================================*/

//-------------------------------cek jumlah row DB-------------------------------------
function jumlah_row($nama_tabel, $field, $parameter){
	global $dbconnect;
	if($field == "!" || $parameter == "!"){
		$sql = mysqli_query($dbconnect, "SELECT * FROM $nama_tabel");
	}else{
		$sql = mysqli_query($dbconnect, "SELECT * FROM $nama_tabel WHERE $field = '$parameter'");
	}	
	$hasil = mysqli_num_rows($sql);
	return $hasil;
}

//-------------------------------cek jumlah row DB 2 parameter-------------------------------------
function jumlah_row2($nama_tabel, $field1, $parameter1, $field2, $parameter2){
	global $dbconnect;
	$sql = mysqli_query($dbconnect, "SELECT * FROM $nama_tabel WHERE $field1 = '$parameter1' AND $field2 = '$parameter2'");
	$hasil = mysqli_num_rows($sql);
	return $hasil;
}

//-------------------------------cek data array DB -------------------------------------
function cekDB_array($nama_tabel, $field, $parameter){
	global $dbconnect;
	$sql = mysqli_query($dbconnect, "SELECT * FROM $nama_tabel WHERE $field = '$parameter'");
	$row = mysqli_fetch_assoc($sql);	
	return $row[$field];
}
?>
