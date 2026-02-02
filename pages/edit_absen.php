<?php
if(isset($_SESSION['page'])) {
	if(isset($_GET['id']) && isset($_GET['nama']) && isset($_GET['tanggal']) && isset($_GET['status']) && isset($_GET['flag'])){
		//lajut
	}else{
		echo '<h3><center> Permintaan ditolak :( </center></h3>';
		exit;
	}
}else{
  header("location: ../index.php?page=dashboard&error=true");
}
	$id = $_GET['id'];
	$nama = $_GET['nama'];
	$tanggal = $_GET['tanggal'];
	$status = $_GET['status'];
	$flag=$_GET['flag'];
?>

<div class="content-header ml-3 mr-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">EDIT PRESENSI</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?page=absensi">Data Presensi</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

<section class="content ml-3 mr-3">
	<div class="content pb-4">
		<div class="container-fluid">
			
				<form action="./konfig/update_absen.php" method="POST">
				
				<input type="hidden" id="custId" name="flag" value="<?php echo $flag;?>">
				
				<div class="form-group">
					<label for="exampleInputEmail1">ID</label>
					<input required class="form-control" type="text" name="id" placeholder="Masukan nama" value="<?php echo $id ?>" readonly>
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">Nama</label>
					<input required class="form-control" type="text" placeholder="Masukan nama" value="<?php echo $nama ?>" readonly>
				</div>
				
				<div class="form-group pt-2">
					<label for="exampleInputEmail1">Tanggal</label>
					<input required class="form-control" type="text" name="tanggal" placeholder="Masukan nama" value="<?php echo $tanggal ?>" readonly>
				</div>
				
				<div class="form-group pt-2">
					<label for="exampleFormControlSelect1">Status Kehadiran</label>
					<select class="form-control" name="status">
						<option value="" selected disabled>Presensi saat ini : <?php echo $status;?></option>
						<option>H</option>
						<option>I</option>
						<option>S</option>
						<option>B</option>
						<option>T</option>
						<option>A</option>
					</select>
					<small id="emailHelp" class="form-text text-muted">H=Hadir - I=Izin - S=Sakit - B=Bolos - T=Terlambat - A=Alpa </small>
				</div>
				
				<div class="form-group pt-2">
					<label for="exampleFormControlTextarea1">Keterangan</label>
					<textarea required class="form-control" id="exampleFormControlTextarea1" name="keterangan" rows="3" maxlength="100" placeholder="Max 100 karakter."></textarea>
				</div>
					<button type="submit" class="btn btn-outline-primary mt-3" value="simpan">Simpan</button>
			</form>
			
		</div>
	</div>
</section>