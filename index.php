<?php
session_start();
if ($_SESSION['status'] != '0' && $_SESSION['username'] == '') {
  header("location: konfig/logout.php");
}
include 'konfig/function.php';
$_SESSION['page'] = 'index';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>SDN TANJUNG SARI 2</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="vendor/css/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vendor/css/admin-lte/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- custom databales -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <!-- loading -->
  <link rel="stylesheet" href="vendor/css/css-manual/print.css" type="text/css" media="print" />
  <!-- date picker-->
  <link rel="stylesheet" href="vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" />
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php?page=dashboard" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://www.linkedin.com/in/nanggala-jalasena-pramana-putra-725879290/" class="nav-link">Contact Dev</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link" href="konfig/logout.php" onclick="return confirm('Ingin keluar ??')">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="vendor\img\image-removebg-preview.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light" href="indeks.php?pages=dashboard.php" class="nav-link">SDN TANJUNG SARI 2</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="vendor/img/admin.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo "Hello, " . $_SESSION['username']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php?page=dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  Data Presensi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?page=absensi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Pertanggal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?page=absen-bulanan" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bulanan</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Siswa/i
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?page=siswa" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Daftar Siswa/i</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?page=tambah-siswa" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Siswa/i</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="index.php?page=pengguna" class="nav-link">
                <i class="nav-icon fas fa-user-lock"></i>
                <p>
                  Daftar Pengguna
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?page=konfigurasi" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Konfigurasi
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-4 pb-4">
      <?php
      if (isset($_GET['page'])) {
        $page = $_GET['page'];

        switch ($page) {

          case 'dashboard':
            include "pages/dashboard.php";
            break;

          case 'absensi':
            include "pages/absensi.php";
            break;

          case 'siswa':
            include "pages/siswa.php";
            break;

          case 'tambah-siswa':
            include "pages/tambah_siswa2.php";
            break;

          case 'pengguna':
            include "pages/pengguna.php";
            break;

          case 'konfigurasi':
            include "pages/konfigurasi.php";
            break;

          case 'edit_siswa':
            include "pages/edit_siswa.php";
            break;

          case 'edit_konfigurasi':
            include "pages/edit_konfigurasi.php";
            break;

          case 'edit_absen':
            include "pages/edit_absen.php";
            break;

          case 'absen-bulanan':
            include "pages/absensi-bulanan.php";
            break;

          case 'edit_pengguna':
            include "pages/edit_pengguna.php";
            break;

          case 'tambah_pengguna':
            include "pages/tambah_pengguna.php";
            break;

          case 'login':
            include "pages/login.php";
            break;

          default:
            echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
            break;
        }
      } else {
        echo '<h3><center> Permintaan ditolak :( </center></h3>';
      }
      ?>

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- Default to the left -->
      <strong>2025 &copy;by <a href="https://www.linkedin.com/in/nanggala-jalasena-pramana-putra-725879290/">Usrnme.nang</a>.</strong>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="vendor/js/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="vendor/js/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="vendor/js/admin-lte/adminlte.min.js"></script>

  <!-- Date Picker -->
  <script src="vendor/js/bootstrap/js/bootstrap.js"></script>
  <script src="vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

  <!-- Js datatables -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

  <!--- export excel -->
  <script lang="javascript" src="vendor/js/sheetJS/xlsx.full.min.js"></script>
  <script lang="javascript" src="vendor/js/sheetJS/FileSaver.min.js"></script>

  <!-- JS Daftar siswa
<script src="vendor/js/daftarsiswa/daftarsiswa.js"></script>
 -->

  <script>
    var wb = XLSX.utils.table_to_book(document.getElementById('table-bulanan'), {
      sheet: "Sheet JS"
    });
    var wbout = XLSX.write(wb, {
      bookType: 'xlsx',
      bookSST: true,
      type: 'binary'
    });

    function s2ab(s) {
      var buf = new ArrayBuffer(s.length);
      var view = new Uint8Array(buf);
      for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
      return buf;
    }
    $("#button-a").click(function() {
      saveAs(new Blob([s2ab(wbout)], {
        type: "application/octet-stream"
      }), 'Presensi.xlsx');
    });
  </script>

  <!--data tables function-->
  <script>
    $(document).ready(function() {
      var table = $('#example').DataTable({
        blengthChange: false,
        bPaginate: false,
        bInfo: false,
        buttons: [{
            extend: 'pdf',
            className: 'btn-danger'
          },
          {
            extend: 'excel',
            className: 'btn-success'
          },
          {
            extend: 'print',
            className: 'btn-info'
          }
        ]
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');

    });
  </script>

  <script>
    $(document).ready(function() {
      $('.bulan').datepicker({
        format: "yyyy-mm",
        autoclose: true,
        viewMode: "months",
        minViewMode: "months"
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      var table = $('#siswa').DataTable({
        blengthChange: false,
        bPaginate: true,
        bInfo: false,
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>


</body>

</html>