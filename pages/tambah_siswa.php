    <?php
    $sql = mysqli_query($dbconnect, "SELECT * FROM tb_state");
    $query = mysqli_fetch_assoc($sql);
    $disable =  false;
    if ($query['status'] == "") {
    }

    if ($query['status'] == "0") {
        echo '
        <script src="./vendor/js/daftarsiswa/daftarsiswa-tundah.js"></script>
        <script src="./vendor/js/jquery/jquery.min.js"></script>
        <script>
        requestTundah();
        </script>
        ';
    }

    if ($query['status'] == "1") {

        $disable = true;
        echo '
                <script src="./vendor/js/daftarsiswa/daftarsiswa-tundah.js"></script>
                <script src="./vendor/js/jquery/jquery.min.js"></script>
                <script>
                var accept = confirm("Anda ingin melanjutkan menambahkan ID ' . $query['id'] . ' ?");
                if (accept) {
                    requestTundah();
                } else {
                    hapusEntry();
                }             
                </script>
                ';
    }

    ?>


    <div class="content-header ml-3 mr-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">TAMBAH SISWA</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tambah Siswa</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content ml-3 mr-3">
        <div class="content">
            <div class="container-fluid">

                <div clas="row">

                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                Input ID
                            </div>
                            <div class="card-body">
                                <div class="form-group">

                                    <form id="myForm" method="post" action="">
                                        <label for="exampleInputEmail1">ID Fingger</label>
                                        <?php
                                        if ($disable) {
                                            echo '<input required readonly class="form-control" type="number" id="first-id" name="id" placeholder="Masukan ID Fingger" value=' . $query['id'] . '> ';
                                        } else {
                                            echo '<input required class="form-control" type="number" id="first-id" name="id" placeholder="Masukan ID Fingger" autocomplete="off" value=' . $query['id'] . '>';
                                        }
                                        ?>

                                        <button class="btn btn-outline-primary mt-3 float-right" name="btn-sinkron" type="submit">Sinkron</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                Respon Kontroler
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" id="message"> None </h5>
                                <p class="card-text mt-1"><?php echo "IP : " . $ip ?></p>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div id="save-data" style="display:none;">
                            <div class="card">
                                <div class="card-header">
                                    Form Data
                                </div>
                                <div class="card-body">
                                    <form action="./konfig/prosesdaftar/daftar-siswa.php" method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ID Fingger Terdaftar</label>
                                            <input required class="form-control" name="id" id="second-id" type="text" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama</label>
                                            <input required class="form-control" name="nama" type="text" autocomplete="off" place="Masukan Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">NISN</label>
                                            <input required class="form-control" name="nisn" type="text" autocomplete="off" placeholder="Masukan NISN">
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ID jari</label>
                                            <input required class="form-control" name="jari" type="text" autocomplete="off" placeholder="Masukan ID Jari">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kelas</label>
                                            <input required class="form-control" name="kelas" type="text" autocomplete="off" placeholder="Masukan Kelas">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Gender</label>
                                            <select required class="form-control" name="gender" id="genderSelect">
                                                <option value="" disabled selected>Pilih Gender</option>
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                            <small id="genderHelp" class="form-text text-muted">Pilih gender dari daftar.</small>
                                        </div>
                                </div>

                                <a href="" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary">Daftar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
