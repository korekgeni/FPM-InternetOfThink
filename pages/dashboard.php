<?php
if(isset($_SESSION['page'])){
  
}else{
  header("location: ../index.php?page=dashboard&error=true");
}
    $today = date('Y-m-d'); 
    // Hitung presensi hanya untuk hari ini (unik per NISN)
    $sql_presensi = mysqli_query($dbconnect, "
        SELECT 
            tb_id.nisn,
            tb_id.nama,
            SUBSTRING_INDEX(
                GROUP_CONCAT(tb_absen.status ORDER BY COALESCE(NULLIF(tb_absen.masuk,''),'99:99:99') ASC),
                ',', 1
            ) AS status_utama
        FROM tb_absen
        INNER JOIN tb_id ON tb_absen.id = tb_id.id
        WHERE tb_absen.date = '$today'
        GROUP BY tb_id.nisn, tb_id.nama
    ");
    $count_presensi = mysqli_num_rows($sql_presensi);
    $count_terlambat = 0;
    $count_hadir = 0;
    $count_izin = 0;
    $count_sakit = 0;
    $count_bolos = 0;
    while ($row = mysqli_fetch_assoc($sql_presensi)) {
      switch ($row['status_utama']) {
        case 'H':
          $count_hadir++;
          break;
        case 'T':
          $count_terlambat++;
          break;
        case 'I':
          $count_izin++;
          break;
        case 'S':
          $count_sakit++;
          break;
        case 'B':
          $count_bolos++;
          break;
      }
    }

    $sql6 = mysqli_query($dbconnect,"
      SELECT COUNT(*) AS total
      FROM (
        SELECT nisn, nama FROM tb_id GROUP BY nisn, nama
      ) t
      WHERE t.nisn NOT IN (
        SELECT DISTINCT tb_id.nisn
        FROM tb_absen
        INNER JOIN tb_id ON tb_absen.id = tb_id.id
        WHERE tb_absen.date = '$today'
      )
    ");
    $row_alpa = mysqli_fetch_assoc($sql6);
    $count_alpa = $row_alpa ? (int)$row_alpa['total'] : 0;

    $sql_siswa = mysqli_query($dbconnect, "SELECT nisn, nama FROM tb_id GROUP BY nisn, nama");
    $count_siswa = mysqli_num_rows($sql_siswa);
?>


<!-- Content Header (Page header) -->
    <div class="content-header ml-3 mr-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">DASHBOARD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content ml-3 mr-3">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        

          <!-- card-->
          <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php
                  echo $count_presensi;
                ?>
                </h3>

                <p>Data Presensi</p>
              </div>
              <div class="icon">
              <i class="ion ion-pie-graph"></i>
              </div>
              <a href="index.php?page=absensi" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                <?php
                  echo $count_siswa;?>
                </h3>

                <p>Jumlah Siswa</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="index.php?page=siswa" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                <?php
                  echo jumlah_row('tb_pengguna','!','!');
                ?>
                </h3>

                <p>Pengguna</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
              <a href="index.php?page=pengguna" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->



      <!-- chart -->
            
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header bg-secondary">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Presentase Kehadiran
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div id="container" height="300px" width="300px"></div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            </section>
            
            <!-- right colum-->
            <section class="col-lg-5 connectedSortable">

            <!-- calendar-->
            <div class="card">
              <div class="card-header border-1 bg-secondary">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt mr-1"></i>
                  Tanggal & Jam
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div style="text-align:center;padding:1em 0;"> <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=en&size=large&timezone= <?php echo $timezone;?>" width="100%" height="140" frameborder="0" seamless></iframe> </div>
              </div>
              <!-- /.card-body -->
            </div>        
          </section><!--end right colum-->
        </div><!-- end row-->
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
    </section>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Nilai Presentase'
    },
    xAxis: {
        categories: ['Hadir', 'Alpa', 'Bolos', 'Terlambat', 'Sakit', 'Izin']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Kehadiran'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: '',
        data: 
        [
          <?php echo $count_hadir;?>,
          <?php echo $count_alpa;?>,
          <?php echo $count_bolos;?>,
          <?php echo $count_terlambat;?>,
          <?php echo $count_sakit;?>,
          <?php echo $count_izin;?>
        ]
    }]
});
</script>
