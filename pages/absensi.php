<?php
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
	if (!isset($dbconnect)) {
		include '../konfig/function.php';
	}
} else {
	if (isset($_SESSION['page'])) {
	} else {
		header("Location:../index.php?page=dashboard&error=true");
	}
}

// =======================
//  INISIALISASI FILTER
// =======================

$date = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
$kelas_filter = isset($_POST['kelas']) ? $_POST['kelas'] : "";

// =======================
//  AMBIL LIST KELAS
// =======================

$list_kelas = mysqli_query($dbconnect, "
    SELECT DISTINCT kelas FROM tb_id ORDER BY kelas ASC
");

// =======================
//  QUERY ABSENSI HARIAN (TANGGAL TERPILIH SAJA)
// =======================

$kelas_sql = $kelas_filter == "" ? "" : "AND tb_id.kelas = '$kelas_filter'";

$sql = mysqli_query($dbconnect, "
	SELECT 
        tb_id.nisn,
        tb_id.nama,
        tb_id.kelas,
        MIN(CASE 
            WHEN tb_absen.masuk IS NOT NULL 
            THEN tb_absen.masuk 
        END) AS masuk_awal,
        MAX(CASE 
            WHEN tb_absen.keluar IS NOT NULL 
            THEN tb_absen.keluar 
        END) AS keluar_akhir,
        GROUP_CONCAT(tb_absen.status) AS all_status,
        GROUP_CONCAT(tb_absen.keterangan SEPARATOR ' | ') AS all_ket
    FROM tb_absen
    INNER JOIN tb_id 
        ON tb_absen.id = tb_id.id
    WHERE tb_absen.date = '$date'
        $kelas_sql
    GROUP BY tb_id.nisn, tb_id.nama, tb_id.kelas
    ORDER BY tb_id.nama ASC
");

function render_absensi_rows($sql)
{
	while ($d = mysqli_fetch_array($sql)) {

		$status_full = $d['all_status'] == "" ? "A" : $d['all_status'];
		$status_utama = substr($status_full, 0, 1);

		// Warna status
		switch ($status_utama) {
			case 'H':
				$color = "table-success";
				break;
			case 'T':
				$color = "table-secondary";
				break;
			case 'A':
				$color = "table-danger";
				break;
			case 'I':
				$color = "table-primary";
				break;
			case 'S':
				$color = "table-info";
				break;
			case 'B':
				$color = "table-warning";
				break;
			default:
				$color = "";
		}
		?>

		<tr class="<?php echo $color; ?>">
			<td><?php echo $d['nisn']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['kelas']; ?></td>
			<td><?php echo ($d['masuk_awal'] ? $d['masuk_awal'] : "-"); ?></td>
			<td><?php echo ($d['keluar_akhir'] ? $d['keluar_akhir'] : "-"); ?></td>
			<td><?php echo $status_utama; ?></td>
			<td><?php echo ($d['all_ket'] ? $d['all_ket'] : "-"); ?></td>
		</tr>

	<?php
	}
}

if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
	render_absensi_rows($sql);
	exit;
}

?>
<!-- HEADER -->
<div class="content-header ml-3 mr-3">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">DATA PRESENSI</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
					<li class="breadcrumb-item active">Data Presensi</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- CONTENT -->
<section class="content ml-3 mr-3">
	<div class="content">
		<div class="container-fluid">

			<div class="card">
				<div class="card-header bg-secondary" style="height: 120px;">
					<form method="POST">
						<div class="row">
							<div class="col-md-4">
								<label>Tanggal</label>
								<input type="date" name="tanggal" class="form-control" value="<?php echo $date; ?>">
							</div>

							<div class="col-md-4">
								<label>Kelas</label>
								<select name="kelas" class="form-control">
									<option value="">Semua Kelas</option>
									<?php while ($k = mysqli_fetch_array($list_kelas)) { ?>
										<option value="<?php echo $k['kelas']; ?>"
											<?php if ($kelas_filter == $k['kelas']) echo "selected"; ?>>
											<?php echo $k['kelas']; ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="col-md-4">
								<label>&nbsp;</label><br>
								<button type="submit" class="btn btn-light btn-sm">
									<i class="fas fa-search"></i> Filter
								</button>
							</div>
						</div>
					</form>

					<div class="text-right mt-2" style="font-size:18px;">
						<?php echo "Menampilkan tanggal: " . $date; ?>
					</div>
				</div>

				<div class="card-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>NISN</th>
								<th>Nama Siswa</th>
								<th>Kelas</th>
								<th>Jam Masuk (Pertama)</th>
								<th>Jam Keluar (Terakhir)</th>
								<th>Status</th>
								<th>Keterangan</th>
							</tr>
						</thead>

						<tbody id="absensi-body">
							<?php render_absensi_rows($sql); ?>
						</tbody>

					</table>
				</div>
			</div>

		</div>
	</div>
</section>

<script>
	function refreshAbsensi() {
		var tanggal = $('input[name="tanggal"]').val();
		var kelas = $('select[name="kelas"]').val();
		$.ajax({
			type: "POST",
			url: "pages/absensi.php?ajax=1",
			data: {
				tanggal: tanggal,
				kelas: kelas
			},
			success: function(response) {
				$('#absensi-body').html(response);
			}
		});
	}

	setInterval(refreshAbsensi, 5000);
</script>
