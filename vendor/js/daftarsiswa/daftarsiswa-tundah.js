
function requestTundah() {

    $.ajax({
        type: "POST",
        url: './konfig/prosesdaftar/daftar.php',
        data: {
            id: 'response',
            parameter: 'response'
        },
        success: function (response) {
            //console.log(response)
            var text = (response || '').toString().trim().toLowerCase();
            if (text.indexOf('sukses') !== -1) {
                $('#message').text("Data Berhasil Ditambahkan");
                completeData();
                return false;

            } else {
                $('#message').text("Menunggu respon kontroler");
            }
            setTimeout(requestTundah, 1500);
        }
    });
}

function completeData() {
    var x = document.getElementById("save-data");
    if (x) {
        x.style.display = "block";
    }
    var firstId = document.getElementById('first-id');
    var secondId = document.getElementById('second-id');
    if (firstId && secondId) {
        secondId.value = firstId.value;
    }
}



function hapusEntry(){
    $.ajax({
        url: "konfig/prosesdaftar/hapusentry.php",
        //dataType: "JSON",
        success: function (response) {
            location.reload();
            console.log(response);
        }
    });
}
