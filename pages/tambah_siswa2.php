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

            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            Form Registrasi

                            <a href="#" class="ml-auto" onclick="alertError()"><i class="fas fa-question-circle"></i></a>


                        </div>
                <div class="card-body">
                    <div class="form-group">

                        <form action="./konfig/prosesdaftar/daftar-siswa.php" method="POST">

                            <div class="form-group">
                                <label>ID Finger</label>
                                <input required id="demo" class="form-control" type="number" name="id" placeholder="Masukan ID Finger">
                            </div>

                            <div class="form-group">
                                <label>Nama</label>
                                <input id="nama" readonly required class="form-control" name="nama" type="text" placeholder="Nama Lengkap">
                            </div>

                            <div class="form-group">
                                <label>NISN</label>
                                <input id="nisn" readonly required class="form-control" name="nisn" type="text" placeholder="Masukan NISN">
                            </div>
                            
                            <div class="form-group">
                                <label>ID Jari</label>
                                <input id="jari" readonly required class="form-control" name="jari" type="text" placeholder="Masukan ID Jari">  
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <input id="kelas" readonly required class="form-control" name="kelas" type="text" placeholder="Masukan Kelas">
                            </div>

                            <div class="form-group">
                                <label>Gender</label>
                                <select id="gender" disabled required class="form-control" name="gender">
                                    <option value="" disabled selected>Pilih Gender</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- AREA TOMBOL -->
                            <div class="form-group text-right mt-4">

                                <button id="btnSinkron" type="button" class="btn btn-primary mr-2" onclick="myFunction()">
                                    Sinkron
                                </button>

                                <a href="./konfig/prosesdaftar/hapusentry.php" id="btnBatal" class="btn btn-danger mr-2">
                                    Batal
                                </a>

                                <button id="btnSimpan" type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>
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
            </div>
        </div>
    </div>
</section>

<script>
    alert("Jangan gunakan tombol enter pada keyboard untuk melakukan sinkron, gunakan tombol sinkron untuk terkoneksi dengan kontroler. ");

    var formID;
    var btnSimpan = document.getElementById("btnSimpan");
    var btnBatal = document.getElementById("btnBatal");
    var btnSinkron = document.getElementById("btnSinkron");


    btnSimpan.style.display = 'none';
    btnBatal.style.display = 'none';
    btnSinkron.style.display = 'block';

    function alertError() {
        var delete_data = confirm("Jika kontroler terus menerus masuk pada mode tambah pegawai/user, silahkan klik Ya/Oke untuk menghapus history permintaan kontroler masuk ke mode tambah data. Kemudian reset kontroler.");
        if (delete_data == true) {
            $.ajax({
                type: "GET",
                url: "konfig/prosesdaftar/hapusentry.php",
                cache: false,
                //dataType: "JSON",
                success: function(response) {
                    alert("Reset/Restart Kontroler Sekarang.");
                }
            });
        }
    }

    function myFunction() {
        formID = document.getElementById("demo").value;
        if (formID == "") {
            alert("ID Finger Tidak Boleh Kosong");
        } else {
            $('#message').text("Mengirim permintaan...");
            $.ajax({
                type: "POST",
                url: "konfig/prosesdaftar/daftar.php",
                data: {
                    id: formID,
                    parameter: 'cek'
                },
                timeout: 8000,
                cache: false,
                //dataType: "JSON",
                success: function(response) {
                    var text = (response || '').toString().trim();
                    if (text === "1") {
                        var konfirm = confirm("ID Telah terdaftar, Pilih Ya/Oke untuk melakukan update Data");
                        if (konfirm == true) {
                            daftarPengguna(); //jika update bersedia
                        } else {
                            //nothing
                        }
                    } else {
                        $('#message').text(response);
                        tungguResponse();
                    }
                },
                error: function(xhr) {
                    $('#message').text("Gagal terhubung: " + xhr.status);
                }
            });
        }

    }


    function daftarPengguna() {
        $.ajax({
            type: "POST",
            url: "konfig/prosesdaftar/daftar.php",
            data: {
                id: formID,
                parameter: 'daftar'
            },
            timeout: 8000,
            cache: false,
            success: function(response) {
                $('#message').text(response);
                tungguResponse();
            },
            error: function(xhr) {
                $('#message').text("Gagal terhubung: " + xhr.status);
            }
        });
    }

    function tungguResponse() {
        document.getElementById("demo").readOnly = true;
        $.ajax({
            type: "POST",
            url: "konfig/prosesdaftar/daftar.php",
            data: {
                id: 'response',
                parameter: 'response'
            },
            timeout: 8000,
            cache: false,
            success: function(response) {
                $('#message').text(response);

                var text = (response || '').toString().trim().toLowerCase();
                if (text.indexOf('sukses') !== -1 || text.indexOf('berhasil') !== -1) {
                    document.getElementById("nama").readOnly = false;
                    document.getElementById("nisn").readOnly = false;
                    document.getElementById("jari").readOnly = false;
                    document.getElementById("kelas").readOnly = false;
                    document.getElementById("gender").disabled = false;
                    prosesSelesai();
                    document.getElementById("nama").focus();
                    return false;
                }
                console.log(response);
                setTimeout(tungguResponse, 1500);
            },
            error: function(xhr) {
                $('#message').text("Gagal terhubung: " + xhr.status);
                setTimeout(tungguResponse, 3000);
            }
        });
    }

    function prosesSelesai() {
        console.log("haloo");
        if (btnSimpan.style.display === "none" && btnBatal.style.display === "none" && btnSinkron.style.display === "block") {
            btnSimpan.style.display = 'block';
            btnBatal.style.display = 'block';
            btnSinkron.style.display = 'none';
        }
    }
</script>
