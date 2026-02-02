var formID;
var btnSimpan = document.getElementById("btnSimpan");
var btnBatal = document.getElementById("btnBatal");
var btnSinkron = document.getElementById("btnSinkron");

if (btnSimpan && btnBatal && btnSinkron) {
    btnSimpan.style.display = 'none';
    btnBatal.style.display = 'none';
    btnSinkron.style.display = 'block';
}


function myFunction() {
    formID = document.getElementById("demo").value;
    if (formID == "") {
        alert("ID Finger Tidak Boleh Kosong");
    } else {
        $.ajax({
            type: "POST",
            url: "konfig/prosesdaftar/daftar.php",
            data: {
                id: formID,
                parameter: 'cek'
            },
            //dataType: "JSON",
            success: function(response) {
                if (response == "1") {
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
        success: function(response) {
            $('#message').text(response);
            tungguResponse();
        }
    });
}

function tungguResponse() {
    var demoInput = document.getElementById("demo");
    if (demoInput) {
        demoInput.readOnly = true;
    }
    $.ajax({
        type: "POST",
        url: "konfig/prosesdaftar/daftar.php",
        data: {
            id: 'response',
            parameter: 'response'
        },
        success: function(response) {
            $('#message').text(response);

            var text = (response || '').toString().trim().toLowerCase();
            if (text.indexOf('sukses') !== -1 || text.indexOf('berhasil') !== -1) {
                var namaInput = document.getElementById("nama");
                var nisnInput = document.getElementById("nisn");
                var chatInput = document.getElementById("chat-id");
                var kelasInput = document.getElementById("kelas");
                var jariInput = document.getElementById("Jari");
                if (namaInput) namaInput.readOnly = false;
                if (nisnInput) nisnInput.readOnly = false;
                if (chatInput) chatInput.readOnly = false;
                if (kelasInput) kelasInput.readOnly = false;
                if (jariInput) jariInput.readOnly = false;
                prosesSelesai();
                return false;
            }
            console.log(response);
            setTimeout(tungguResponse, 1500);
        }
    });
}

function prosesSelesai() {
    console.log("haloo");
    if (btnSimpan && btnBatal && btnSinkron &&
        btnSimpan.style.display === "none" &&
        btnBatal.style.display === "none" &&
        btnSinkron.style.display === "block") {
        btnSimpan.style.display = 'block';
        btnBatal.style.display = 'block';
        btnSinkron.style.display = 'none';
    }
}
