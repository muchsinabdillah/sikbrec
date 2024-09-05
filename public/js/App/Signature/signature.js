var base_url = window.location.origin;
var signature

// saksi Pasien
$("#btn-save").click(function(e) {
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
    // $("#tandatanganjson").val(signature)
    console.log(signature)
    html2canvas([document.getElementById('sign-pad')], {
        onrendered: function(canvas) {
            var canvas_data = canvas.toDataURL('image/png');
            var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
            $.ajax({
                url: base_url + '/SIKBREC/public/SignatureDigital/saveimgSignature',
                data: {
                    img_data: img_data,
                    namaparam: namapasien.value,
                    nomortransaksi:NO_MR.value,
                    usercreate:namauser,
                    noregistrasi: noregistrasi.value
                    // nama: document.getElementById('nama').value
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $("#btnModalSrcPasienClose").click()
                    console.log(response)
                    if(response.status !=200){
                        alert(response.message)
                    }
                }
            });
        }
    });
});

$('#tbl_kunjungan_monitoring tbody').on( 'click', 'button', function () {
    console.log('diklik')
    // $(window).load(function() {
        // });
        
            $('#formtandatangan').modal('show');
        console.log('di click')
    var data = datatable.row( $(this).parents('tr') ).data();
    console.log(data)
    namapasien.value = data.nama
    NO_MR.value = data.noSep
    TglRujukan.value = data.tglSep
    //noregistrasi.value = data.tglSep
    noregistrasi.value = data.noreg
    // noepisode.value = this.cells[3].innerHTML
    // medicalrecord.value = this.cells[3].innerHTML
} );