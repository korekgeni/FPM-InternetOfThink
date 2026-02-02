<?php
if (isset($_SESSION['page'])) {
	if (isset($_GET['id'])) {
		//lajut
	} else {
		echo '<h3><center> Permintaan ditolak :( </center></h3>';
		exit;
	}
} else {
	header("location: ../index.php?page=dashboard&error=true");
}
$uid = $_GET['id'];
$nisn = $_GET['nisn'];
$nama = $_GET['nama'];
$telegram = $_GET['telegram'];
$jari = $_GET['jari'];
$kelas = $_GET['kelas'];
$gender = $_GET['gender'];
$tampung_uid = $uid;
?>

<div class="content-header ml-3 mr-3">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">EDIT SISWA</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="index.php?page=siswa">Siswa</a></li>
					<li class="breadcrumb-item active">Edit</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>

<section class="content ml-3 mr-3">
	<div class="content">
		<div class="container-fluid">


			<form action="./konfig/update_siswa.php" method="POST">
				<div class="form-group">
					<input type="hidden" name="parameter" value="<?php echo $tampung_uid; ?>">
					<label for="exampleInputEmail1">ID</label>
					<input required class="form-control" type="text" name="id" placeholder="Masukan UID" value="<?php echo $uid ?>">
					<small id="emailHelp" class="form-text text-muted">UID yang terdaftar</small>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">NISN</label>
					<input required class="form-control" type="text" name="nisn" placeholder="Masukan NSIN" value="<?php echo $nisn ?>">
					<small id="emailHelp" class="form-text text-muted">NISN siswa</small>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Nama</label>
					<input required class="form-control" type="text" name="nama" placeholder="Masukan nama" value="<?php echo $nama ?>">
					<small id="emailHelp" class="form-text text-muted">Nama Siswa harus sesuai dengan pemilik UID</small>
				</div>
				<!---<div class="form-group">
					<label for="exampleInputEmail1">Telegram ID</label>
					<input required type="text" class="form-control" name="telegram" placeholder="Masukan Telegram ID" value="<?php echo $telegram ?>">
					<small id="emailHelp" class="form-text text-muted">ID Telegram siswa</small>
				</div>-->
				<div class="form-group">
					<label for="exampleInputEmail1">ID Jari</label>
					<input required type="text" class="form-control" name="jari" placeholder="Masukan ID Jari" value="<?php echo $jari ?>">
					<small id="emailHelp" class="form-text text-muted">ID Jari siswa</small>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Kelas</label>
					<input required type="text" class="form-control" name="kelas" placeholder="Masukan Kelas" value="<?php echo $kelas ?>">
					<small id="emailHelp" class="form-text text-muted">Kelas siswa</small>
				</div>
				<div class="form-group">
					<label for="genderSelect">Pilih gender</label>
					<select required class="form-control" name="gender" id="genderSelect">
						<option value="laki-laki" <?php echo ($gender == 'laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
						<option value="perempuan" <?php echo ($gender == 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
					</select><small id="genderHelp" class="form-text text-muted">Pilih ender dari daftar.</small>
				</div>
				<div class="text-right mt-4">
					<button type="submit" class="btn btn-outline-primary" value="simpan">
						Submit
					</button>
				</div>

			</form>

		</div>
	</div>
</section>