<?php
if (isset($_SESSION['page'])) {
	if (isset($_GET['id']) || isset($_GET['param'])) {
		//lajut
	} else {
		echo '<h3><center> Permintaan ditolak :( </center></h3>';
		exit;
	}
} else {
	header("location: ../index.php?page=dashboard&error=true");
}

$id = $_GET['id'];
$parameter = $_GET['param'];


$label = "";
$keterangan = "";
if ($id == '1') {
	$label = "EDIT MULAI JAM MASUK";
	$keterangan = "Format jam yang harus disimpan HH:MM:SS dan nilai yang dimasukan harus sebelum parameter AKHIR JAM MASUK serta harus lebih dari AKHIR JAM KELUAR";
} else if ($id == '2') {
	$label = "EDIT AKHIR JAM MASUK";
	$keterangan = "Format jam yang harus disimpan HH:MM:SS dan nilai yang dimasukan harus sebelum parameter MULAI JAM KELUAR serta harus lebih dari MULAI JAM MASUK";
} else if ($id == '3') {
	$label = "EDIT MULAI JAM KELUAR";
	$keterangan = "Format jam yang harus disimpan HH:MM:SS dan nilai yang dimasukan harus sebelum parameter AKHIR JAM KELUAR serta harus lebih dari AKHIR JAM MASUK";
} else if ($id == '4') {
	$label = "EDIT AKHIR JAM KELUAR";
	$keterangan = "Format jam yang harus disimpan HH:MM:SS dan nilai yang dimasukan harus sebelum parameter MULAI JAM MASUK serta harus lebih dari MULAI JAM KELUAR";
} else if ($id == '5') {
	$label = "EDIT HARI LIBUR 1";
	$keterangan = "Input - jika tidak ingin mengatur parameter ini. Masukan hari libur contoh format penulisan : Sabtu";
} else if ($id == '6') {
	$label = "EDIT HARI LIBUR 2";
	$keterangan = "Input - jika tidak ingin mengatur parameter ini. Masukan hari libur contoh format penulisan : Minggu";
} else if ($id == '7') {
	$label = "EDIT ZONA WAKTU";
	$keterangan = "Parameter penulisan : 'WIB = Asia/Jakarta' - 'WITA = Asia/Makassar' - 'WIT = Asia/Jayapura'";
} else if ($id == '8') {
	$label = "EDIT BOT TOKEN TELEGRAM";
	$keterangan = "BOT Token Telegram, Untuk mengirimkan pesan presensi pada user.";
} else if ($id == '9') {
	$label = "EDIT IP Address Kontroler";
	$keterangan = "IP Address Dari Kontroller untuk terkoneksi dengan kontroler via (LAN).";
}

?>

<div class="content-header ml-3 mr-3">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">EDIT PARAMETER</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="index.php?page=konfigurasi">Konfigurasi</a></li>
					<li class="breadcrumb-item active">Edit</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>

<section class="content ml-3 mr-3" id="box">
	<div class="content">
		<div class="container-fluid">
			<form action="./konfig/update_konfigurasi.php" method="POST">
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $label; ?></label>
					<input type="hidden" name="id" value=<?php echo $id; ?>>
					<input required class="form-control" type="text" name="param" placeholder="Masukan Parameter" value="<?php echo $parameter ?>">
					<small id="emailHelp" class="form-text text-muted"><?php echo $keterangan; ?></small>
				</div>
				<button type="submit" class="btn btn-outline-primary mt-3" value="simpan">Simpan Konfigurasi</button>
			</form>

		</div>
	</div>
</section>