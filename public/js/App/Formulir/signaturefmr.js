var base_url = window.location.origin;
var signature
// var param1
var path 
// var param2
var path2
var tandatangan = document.getElementById('tandatangan')
// var noregistrasi = document.getElementById('Noregis')
var namapihak1 = document.getElementById('namapihak1')
var nama = document.getElementById('nama')
var namajelas = document.getElementById('namajelas')
// saksi Pasien
$("#btn_sakspasiensig").click(function(e) {
    e.preventDefault()
    console.log('di klik')
    var pesan = $('#ttdsaksipasien').signaturePad().getSignatureString();
    signature = pesan
    // gambar 
    $("#pasienttd").signaturePad({
        displayOnly: true,
        penColour: '#000000',
        drawBezierCurves: true,
    }).regenerate(signature)
    $("#tandatanganjson").val(signature)
    console.log(signature)
    html2canvas([document.getElementById('sign-pad')], {
        onrendered: function(canvas) {
            var canvas_data = canvas.toDataURL('image/png');
            var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
            $.ajax({
                url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/getPath',
                data: {
                    img_data: img_data,
                    // nama: document.getElementById('nama').value
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                   console.log(response.path)
                   path2 = response.Path
                //    param2 = response.uuid
                    $("#saksi_pasiens").val(path2);

                }
            });
        }
    });
});
// saksi rumah sakit
$("#btn_saksirumahsakitsig").click(function(e) {
    e.preventDefault()
    var pesan = $('.signature-area').signaturePad().getSignatureString();
    signature = pesan
    $(".rumahsakit").signaturePad({
        displayOnly: true,
        penColour: '#000000',
        drawBezierCurves: true,
    }).regenerate(signature)
    $("#tandatanganjson").val(signature)
    console.log(signature)
    html2canvas([document.getElementById('ttdrumahsakit')], {
        onrendered: function(canvas) {
            var canvas_data = canvas.toDataURL('image/png');
            var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
            $.ajax({
                url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/getPath',
                data: {
                    img_data: img_data,
                    // nama: document.getElementById('nama').value
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    console.log(response.path)
                    path = response.Path
                    param1 = response.uuid
                    $("#saksi_rumah_sakit").val(path);
                }
            });
        }
    });
});

tandatangan.addEventListener('click',function (e) {
    e.preventDefault()
    var FormData = {
        // namaparam1:nama.value,
        // namaparam2:nama.value,
        // uuid1:param1,
        // uuid2:param2,
        path:path,
        path2:path2,
        // nomortransaksi:noregistrasi.value,
        // usercreate:namauser
    }
    $.ajax({
        url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/getPath',
        data: FormData,
        type: 'post',
        dataType: 'json',
        success: function(response) {
            if (response.status != 200) {
                // alert(data.errorname,data.metadata.message)
                swal({
                    title: "error",
                    text: response.message,
                    icon: "error",
                })
            } else {
                swal({
                    title: "success",
                    text: "Tanda Tangan Digital Berhasil Di input",
                    icon: "success",
                })
            }
        }
    });
})

nama.addEventListener('keyup',function (e) {
    namajelas.textContent == this.value
})