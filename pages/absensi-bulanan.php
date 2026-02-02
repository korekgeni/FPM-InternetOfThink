<?php
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] === '1';
if ($is_ajax) {
    if (!isset($dbconnect)) {
        include '../konfig/function.php';
    }
} else {
    // =====================================================
    // CEK SESSION
    // =====================================================
    if (!isset($_SESSION['page'])) {
        header("location: ../index.php?page=dashboard&error=true");
        exit;
    }
}

// =====================================================
// INPUT / DEFAULT FILTER BULAN
// =====================================================
if (isset($_POST['bulan'])) {
    $pencarian = $_POST['bulan'];
    $bulan = date('m', strtotime($pencarian));
    $tahun = date('Y', strtotime($pencarian));
    $tampil_date = date('F', strtotime($pencarian));
    $hasil = jumlah_hari($bulan, $tahun);
} else {
    $bulan = date('m');
    $tahun = date('Y');
    $tampil_date = date('F');
    $hasil = jumlah_hari($bulan, $tahun);
}

// =====================================================
// INPUT FILTER KELAS
// =====================================================
$kelas_filter = isset($_POST['kelas']) ? $_POST['kelas'] : "";

// =====================================================
// PRELOAD DATA TB_ABSEN untuk 1 bulan
// =====================================================
$absen_bulan = [];
$q_absen = mysqli_query(
    $dbconnect,
    "SELECT id, status, date 
     FROM tb_absen 
     WHERE date BETWEEN '$tahun-$bulan-01' AND '$tahun-$bulan-$hasil'"
);

while ($r = mysqli_fetch_assoc($q_absen)) {
    $absen_bulan[$r['id']][$r['date']] = $r['status'];
}

function render_bulanan_table($dbconnect, $kelas_filter, $absen_bulan, $hasil, $tampil_date, $tahun, $bulan)
{
    ?>
    <table class="table table-bordered dt-responsive nowrap" style="width: 100%;">
        <thead class="text-center">
            <tr>
                <th rowspan="2" bgcolor="f3f3f3">NISN</th>
                <th rowspan="2" bgcolor="#F3F3F3">Nama</th>
                <th colspan="<?= $hasil ?>" bgcolor="#F3F3F3">
                    Daftar Presensi Bulan <?= $tampil_date . " " . $tahun ?>
                </th>
                <th colspan="6" bgcolor="#F3F3F3">Jumlah Kehadiran</th>
            </tr>

            <tr>
                <?php for ($i = 1; $i <= $hasil; $i++) : ?>
                    <th bgcolor="#F3F3F3"><?= $i ?></th>
                <?php endfor; ?>

                <th bgcolor="#F3F3F3">A</th>
                <th bgcolor="#F3F3F3">B</th>
                <th bgcolor="#F3F3F3">T</th>
                <th bgcolor="#F3F3F3">S</th>
                <th bgcolor="#F3F3F3">I</th>
                <th bgcolor="#F3F3F3">H</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // ===================================================== QUERY DAFTAR SISWA BERDASARKAN KELAS =====================================================
            if ($kelas_filter != "") {
                $sql = mysqli_query(
                    $dbconnect,
                    "SELECT nisn, nama 
                    FROM tb_id 
                    WHERE kelas = '$kelas_filter'
                    GROUP BY nisn, nama
                    ORDER BY nama ASC"
                );
            } else {
                $sql = mysqli_query(
                    $dbconnect,
                    "SELECT nisn, nama 
                    FROM tb_id 
                    GROUP BY nisn, nama
                    ORDER BY nama ASC"
                );
            }

            // =====================================================
            // LOOP DATA SISWA
            // =====================================================
            while ($row = mysqli_fetch_array($sql)) {

                $nisn = $row['nisn'];
                $nama = $row['nama'];

                echo "<tr>";
                echo "<td><b>$nisn</b></td>";
                echo "<td bgcolor='#FAFAFA'><b>$nama</b></td>";

                // -------------------------------------------------
                // AMBIL SEMUA ID YANG DIMILIKI SISWA INI
                // -------------------------------------------------
                $id_list = [];
                $get_ids = mysqli_query($dbconnect, "SELECT id FROM tb_id WHERE nisn='$nisn'");
                while ($iid = mysqli_fetch_assoc($get_ids)) {
                    $id_list[] = $iid['id'];
                }

                // -------------------------------------------------
                // TAMPILKAN STATUS PRESENSI PER TANGGAL (UNIK NISN)
                // -------------------------------------------------
                $total_H = $total_I = $total_S = $total_B = $total_T = $total_A = 0;
                $priority = ["H", "T", "I", "S", "B"];

                for ($tgl = 1; $tgl <= $hasil; $tgl++) {

                    $convert_date = sprintf("%04d-%02d-%02d", $tahun, $bulan, $tgl);
                    $status_harian = "";

                    // cek semua id milik siswa dengan prioritas status
                    foreach ($priority as $p) {
                        foreach ($id_list as $idc) {
                            if (isset($absen_bulan[$idc][$convert_date]) && $absen_bulan[$idc][$convert_date] == $p) {
                                $status_harian = $p;
                                break 2;
                            }
                        }
                    }

                    // Warna default (A)
                    $warna = "#F0386A";

                    if ($status_harian) {
                        switch ($status_harian) {
                            case "H":
                                $warna = "#66EDC0";
                                $total_H++;
                                break;
                            case "I":
                                $warna = "#72ADF5";
                                $total_I++;
                                break;
                            case "S":
                                $warna = "#62E3EB";
                                $total_S++;
                                break;
                            case "B":
                                $warna = "#F9D612";
                                $total_B++;
                                break;
                            case "T":
                                $warna = "#A7ACB1";
                                $total_T++;
                                break;
                        }
                        echo "<td class='text-center' bgcolor='$warna'>$status_harian</td>";
                    } else {
                        // Jika hari libur
                        $day = getday($convert_date);
                        global $libur1, $libur2;

                        if ($day == $libur1 || $day == $libur2) {
                            echo "<td class='text-center' bgcolor='#DCFCFF'>L</td>";
                        } else {
                            $total_A++;
                            echo "<td class='text-center' bgcolor='#F0386A'>A</td>";
                        }
                    }
                }

                echo "<td class='text-center'>$total_A</td>";
                echo "<td class='text-center'>$total_B</td>";
                echo "<td class='text-center'>$total_T</td>";
                echo "<td class='text-center'>$total_S</td>";
                echo "<td class='text-center'>$total_I</td>";
                echo "<td class='text-center'>$total_H</td>";
                echo "</tr>";
            }
            ?>

        </tbody>
    </table>
    <?php
}

if ($is_ajax) {
    render_bulanan_table($dbconnect, $kelas_filter, $absen_bulan, $hasil, $tampil_date, $tahun, $bulan);
    exit;
}

?>

<!-- =====================================================
     HEADER HALAMAN
====================================================== -->
<div class="content-header ml-3 mr-3">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">DATA PRESENSI BULANAN</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Presensi / Bulanan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- =====================================================
     FORM FILTER
====================================================== -->
<section class="content ml-3 mr-3">
    <div class="content">
        <div class="container-fluid">

            <div class="row bg-secondary mt-2 pt-2 pb-3 mb-4">
                <div class="col-md-12 pt-3">
                    <form method="POST" class="form-inline">

                        <!-- Filter Bulan -->
                        <input required placeholder="yyyy-mm" type="text" class="form-control bulan mr-2"
                            name="bulan" autocomplete="off">

                        <!-- Filter Kelas -->
                        <select name="kelas" class="form-control mr-2" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            $getkelas = mysqli_query($dbconnect, "SELECT DISTINCT kelas FROM tb_id ORDER BY kelas ASC");
                            while ($kk = mysqli_fetch_assoc($getkelas)) {
                                $sel = ($kelas_filter == $kk['kelas']) ? "selected" : "";
                                echo "<option $sel value='" . $kk['kelas'] . "'>" . $kk['kelas'] . "</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-info mr-2">
                            <i class="fas fa-search mr-1"></i>Cari
                        </button>

                        <button id="button-a" type="button" class="btn btn-success mr-2">
                            <i class="far fa-file-excel mr-1"></i>Export
                        </button>

                        <button type="button" class="btn btn-primary"
                            onclick="printContent('table-bulanan')">
                            <i class="fas fa-print mr-1"></i>Cetak
                        </button>

                    </form>
                </div>

                <div class="col-md-12 pt-3 text-right pr-3" style="font-size:18px;">
                    <?= $tampil_date . " " . $tahun ?>
                </div>
            </div>

            <!-- =====================================================TABEL PRESENSI
            ====================================================== -->
            <div class="table-responsive mt-2" id="table-bulanan">
                <?php render_bulanan_table($dbconnect, $kelas_filter, $absen_bulan, $hasil, $tampil_date, $tahun, $bulan); ?>
            </div>

        </div>
    </div>
</section>

<!-- =====================================================
     SCRIPT PRINT
====================================================== -->
<script>
    function printContent(el) {
        document.getElementById("button-a").addEventListener("click", function() {

            // Ambil elemen tabel yang mau diexport
            let table = document.getElementById("table-bulanan").innerHTML;

            // Format Excel
            let excelFile =
            `<html xmlns:o="urn:schemas-microsoft-com:office:office" 
                xmlns:x="urn:schemas-microsoft-com:office:excel" 
                xmlns="http://www.w3.org/TR/REC-html40">
        <head><!--[if gte mso 9]><xml><x:ExcelWorkbook>
            <x:ExcelWorksheets><x:ExcelWorksheet>
            <x:Name>Data</x:Name>
            <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
            </x:ExcelWorksheet></x:ExcelWorksheets>
        </x:ExcelWorkbook></xml><![endif]--></head>
        <body>${table}</body></html>`;

            // Buat file Blob
            let blob = new Blob([excelFile], {
                type: "application/vnd.ms-excel"
            });

            // Buat URL download
            let url = URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = "absensi_bulanan.xls";
            a.click();
        });
        let restorepage = document.body.innerHTML;
        let printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>

<script>
    function refreshBulanan() {
        var bulan = $('input[name="bulan"]').val();
        var kelas = $('select[name="kelas"]').val();
        if (!bulan) {
            bulan = "<?php echo $tahun . "-" . $bulan; ?>";
        }
        $.ajax({
            type: "POST",
            url: "pages/absensi-bulanan.php?ajax=1",
            data: {
                bulan: bulan,
                kelas: kelas
            },
            success: function(response) {
                $('#table-bulanan').html(response);
            }
        });
    }

    setInterval(refreshBulanan, 5000);
</script>
