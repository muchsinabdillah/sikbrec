var base_url = window.location.origin;
var signature
var param1
var path1 
var param2
var path2
var tandatangan = document.getElementById('tandatangan')
var noregistrasi = document.getElementById('Noregis')
var namapihak1 = document.getElementById('namapihak1')
var nama = document.getElementById('xNamaPasien')
var namajelas = document.getElementById('namajelas')
var NoEpisode = document.getElementById('NoEpisode') 

// data pasien
var norm = document.getElementById('xnoMedrec')
var namapasien = document.getElementById('xNamaPasien')
// var jeniskelasmin = document.getElementById('jeniskelasmin')
// var tgllahir = document.getElementById('tgllahir')
// var kamar = document.getElementById('kamar')


//data wali 
var pnj_noKTP = document.getElementById('pnj_noKTP')
var pnj_pekerjaan = document.getElementById('pnj_pekerjaan')
var pnj_noHP = document.getElementById('pnj_noHP')
var pnj_alamat = document.getElementById('pnj_alamat')
var pnj_JenisOrang = document.getElementById('pnj_JenisOrang')


 

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
        $("#tandatanganjson").val(signature)
        console.log(signature)
        html2canvas([document.getElementById('sign-pad')], {
            onrendered: function(canvas) {
                var canvas_data = canvas.toDataURL('image/png');
                var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
                $.ajax({
                    url: base_url + '/SIKBREC/public/signatureDigital/getPath',
                    data: {
                        img_data: img_data,
                        // nama: document.getElementById('nama').value
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.path)
                        path2 = response.path
                        param2 = response.uuid 
                        $('#saksipasien').modal('hide');
                       
                        
                    }
                });
            }
        
    });
});
// saksi rumah sakit
$(".ttdsaksirumahsakit").click(function(e) {
    e.preventDefault()
    console.log('di klik')
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
                url: base_url + '/SIKBREC/public/signatureDigital/getPath',
                data: {
                    img_data: img_data,
                    // nama: document.getElementById('nama').value
                },
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    console.log(response.path)
                    path1 = response.path
                    param1 = response.uuid
                    $('#saksirumahsakit').modal('hide');
                }
            });
        }
    });
});
 
tandatangan.addEventListener('click',function (e) {
    swal({
        title: "Simpan & Kirim",
        text: "Apakah Anda Yakin Ingin Simpan & Kirim ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                
    var email_send = $("#email_send").val();
    var nohp_send = $("#nohp_send").val();
    if (nohp_send == '' || nohp_send == null){
        swal({
            title: "Warning",
            text: "No. HP Belum Diisi !",
            icon: "warning",
        })
        $("#nohp_send").focus()
        return false;
    }
    if (email_send == '' || email_send == null){
        swal({
            title: "Warning",
            text: "Email Belum Diisi !",
            icon: "warning",
        })
        $("#email_send").focus()
        return false;
    }
    if (!validateEmail(email_send)) {
        swal({
            title: "Email Tidak Sesuai Format",
            text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
            icon: "warning",
        })
        $("#email_send").focus()
        return false;
       }
       $(".preloader").fadeIn();
       e.preventDefault()
       var FormData = {
           namaparam1:nama.value,
           namaparam2:nama.value,
           uuid1:param1,
           uuid2:param2,
           path1:path1,
           path2:path2,
           nomortransaksi:noregistrasi.value,
           noregistrasi:noregistrasi.value,
           NoEpisode:NoEpisode.value,
           norm:norm.value,
           namapasien:namapasien.value,
           usercreate:namauser,
            namawali:$("#namawali").val(),
            nik:$("#nik").val(),
            namapetugas_ext:$("#namapetugas_ext").val(),
            idpetugas_ext:$("#idpetugas_ext").val(),

            hubungan_dgnpasien:$("#hubungan_dgnpasien").val(),
            rencana_tindakan:$("#rencana_tindakan").val(),
            estimasi_biaya:$("#estimasi_biaya").val(),
            pasien_kelas:$("#pasien_kelas").val(),
            ruangan:$("#ruangan").val(),
            pasien_kelas_nama : $('#pasien_kelas option:selected').text(),
            nohp_send:$("#nohp_send").val(),
            email_send:$("#email_send").val(),
            namapenjamin_pasien:$("#namapenjamin_pasien").val(),
            gender_pasien:$("#gender_pasien").val(),
            tgllahir_pasien:$("#tgllahir_pasien").val(),
            alamat_pasien:$("#alamat_pasien").val(),
            nohp_pasien:$("#nohp_pasien").val(),
            nohp_pjpasien:$("#nohp_pjpasien").val(),
       }
       $.ajax({
           url: base_url + '/SIKBREC/public/signatureDigital/savePersetujuanSelisih',
           data: FormData,
           type: 'post',
           dataType: 'json',
           success: function(response) {
               if (response.status != 200) {
                   // alert(data.errorname,data.metadata.message)
                   swal({
                       title: "error",
                       text: "Data Gagal di Simpan ke Sistem ! "+response.message,
                       icon: "error",
                   })
                   $(".preloader").fadeOut();
               } else {
                   swal({
                       title: "success",
                       text: "Tanda Tangan Digital Berhasil Di input",
                       icon: "success",
                   })
                   //$('#modalSend').modal('show');
                   $("#param_id").val(response.data);
                   gouploadtoAws(response.data,email_send);
                // uploadtoAws_filepdf(response.data);
                // goSendMail(email_send);
                   //$(".preloader").fadeOut();
               }
           }
       });
            } else {
               // swal("Transaction Rollback !");
               return false;
            }
        });
    
})

async function gouploadtoAws(data,email) {
    try {
        //await uploadtoAwsx(data);
        const awsurl = await uploadtoAws_filepdfx(data);
        await goSendMailx(email,awsurl);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
async function uploadtoAwsx(param){
    var FormData = {
        namaparam1:nama.value,
        namaparam2:nama.value,
        uuid1:param1,
        uuid2:param2,
        path1:path1,
        path2:path2,
        nomortransaksi:noregistrasi.value,
        noregistrasi:noregistrasi.value,
        usercreate:namauser,
        // pnj_JenisOrang:pnj_JenisOrang.value,
        // pnj_alamat:pnj_alamat.value,
        // pnj_noHP:pnj_noHP.value,
        // pnj_pekerjaan:pnj_pekerjaan.value,
        // pnj_noKTP:pnj_noKTP.value,
        reffid:param

    }
    $.ajax({
        url: base_url + '/SIKBREC/public/signatureDigital/uploadToAwsSignPersetujuanBiaya',
        data: FormData,
        type: 'post',
        dataType: 'json',
        success: function(response) {
            if (response.status != 200) { 
                swal({
                    title: "error",
                    text: "Data Gagal di Simpan ke Sistem !",
                    icon: "error",
                })
                $(".preloader").fadeOut();
            } else {
                swal({
                    title: "success",
                    text: "Generate Berhasil",
                    icon: "success",
                }) 
            }
        }
    });
}

async function uploadtoAws_filepdfx(param){
    var FormData = {
        id:param,
    }
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/SavePersetujuanSelisih';
    return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: "id=" + param
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.statusText)
        }
        return response.json();
    })
    .then(response => {
        if (response.status === "error") {
            throw new Error(response.message.errorInfo[2]);
            // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
            throw new Error(response.errorname);
            // console.log("ok " + response.message.errorInfo[2])
        }
        return response
    })
    .finally(() => {
        //$("#NamaPenjamin").select2();
    })
}
// nama.addEventListener('keyup',function (e) {
//     namajelas.textContent == this.value
// })

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

 async function goSendMailx (email_send,aws_url){
    var aws_url = aws_url['aws_url'];
    var param = $("#xnoMedrec").val();
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aRegistrasiRajal/SendPersetujuanSelisih/";
              $.ajax({
                  url: url,
                  type: "POST",
                  data: "notrs="+param+"&email_send="+email_send+"&aws_url="+aws_url,
                  dataType: "JSON",
                  success: function (data) {
                    $(".preloader").fadeOut();
                      if (data.status=='success'){
                        var title = 'Kirim Email Berhasil!';
                        var statuskirim = 'TERKIRIM';
                      }else{
                        var title = 'Kirim Email Gagal!';
                        var statuskirim = 'GAGAL';
                      }

                      //toast(data.message, data.status);

                      swal({
                        title: title,
                        text: data.message,
                        icon: data.status,
                    }).then(function() {
                        location.reload();

                    });

                    //INSERT TZ LOG EMAIL
                    //goInsertLog(nolab,statuskirim,email);

                  },
                  error: function (xhr, status) {
                    $(".preloader").fadeOut();
                    toast(xhr, status);
                      // handle errors
                      console.log(xhr,status);
                  }
              });

}

function checkTrue(){
    var checkBox = document.getElementById("checkboxSyarat");
   
    if (checkBox.checked == true){
        document.getElementById("tandatangan").disabled = false;
        document.getElementById("btnttd1").disabled = false;
        document.getElementById("btnttd2").disabled = false;
    } else {
       document.getElementById("tandatangan").disabled = true;
       document.getElementById("btnttd1").disabled = true;
       document.getElementById("btnttd2").disabled = true;
    }
}

$(document).ready(function () {
    $(document).on('click', '#sendmail', function () {
        goSendMail();
    });
    $(document).on('click', '#btnHistory', function () {
        $('#modalHistory').modal('show');
        getDataHistoryDoc();
    });

    asyncShowMain();
});

function passData(){

    $("#namajelas").text($("#namawali").val());
    $("#NamaPJawab_tmp").text($("#namawali").val());
    $("#NIK_tmp").text($("#nik").val());
    $("#HubunganDenganPasien_tmp").text($("#hubungan_dgnpasien").val());
    $("#NoTelpHP_tmp").text($("#nohp_pjpasien").val());
    $("#NamaPasien_tmp").text($("#namapasien").val());
    $("#NoRM_tmp").text($("#norm").val());
    $("#NamaPenjamin_tmp").text($("#namapenjamin_pasien").val());
    $("#Gender_tmp").text($("#gender_pasien").val());
    $("#Alamat_tmp").text($("#alamat_pasien").val());
    $("#NoTelpHPPasien_tmp").text($("#nohp_pasien").val());
}

async function asyncShowMain() {
    try {   
        const data = await getLoadDataFromGC();
        updateUIgetLoadDataFromGC(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetLoadDataFromGC(datagetGroupJaminan) {
    let responseApi = datagetGroupJaminan;
        if (responseApi.data['ID'] !== null) {

            $("#namawali").val(responseApi.data['NamaPenanggungJawab']);
            $("#nik").val(responseApi.data['NoKtp']);
            $("#hubungan_dgnpasien").val(responseApi.data['NamaJenisPenanngungJawab']);
            $("#email_send").val(responseApi.data['EmailSend']);
            $("#nohp_send").val(responseApi.data['NoHPSend']);
            $("#nohp_pjpasien").val(responseApi.data['NoHandphone']);
            
        }else{

            swal({
                title: "warning",
                text: "Data penanggung jawab kosong karena General Consent belum dilakukan / belum dikirim !",
                icon: "warning",
            })
            
        }
    }
    
    async function getLoadDataFromGC() {
    var notrs = $("#Noregis").val()
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/signatureDigital/getDataFromGC';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'notrs=' + notrs
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            //$("#TipePenjamin").select2();
        })
    }

    // Primary function always
function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function getDataHistoryDoc() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#tbl_arsip').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_arsip').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryTataTertib", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'AwsUrlDocuments' },
            { "data": 'uuid4' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
        ],
    });
} 

function ceklis_noemail(){
    if ($("#ceklis_noemailx").is(":checked") == true){
        $("#email_send").val("edocrsy@gmail.com");
    }else{
        $("#email_send").val($("#email_send_backup").val());
    }
}

function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[status](data);
}

$("#nopin").keyup(function(event) {
    if (event.keyCode === 13) {
        goGetApproveName();
    }
});

async function goGetApproveName() {
    try {
        const dataGetApproveName = await GetApproveName();
        updateUIdataGetApproveName(dataGetApproveName);
    } catch (err) {
        toast(err, "error")
        $("#nama_ext").val('');
        $("#nopin_ext").val('');
        var parent = $('embed#file').parent();
        var newElement = "<embed src='' id='file'>";
        $('embed#file').remove();
        parent.append(newElement);

        var parent = $('embed#filettd').parent();
        var newElement = "<embed src='' id='filettd'>";
        $('embed#filettd').remove();
        path1 = '';

            swal({
                title: "Gagal Input Tanda Tangan",
                text: err,
                icon: "error",
            })
    }
}
function updateUIdataGetApproveName(params) {
        //toast(params.message, params.status);

        if (params.status == 'success'){
            $("#nama_ext").val(params.data.username);
            $("#nopin_ext").val(params.data.NoPIN);
            var parent = $('embed#file').parent();
            var newElement = "<embed src='"+params.data.FileDocument+"' id='file'>";
            $('embed#file').remove();
            parent.append(newElement);
            toast('No PIN Berhasil dan Tanda Tangan Ditemukan !', 'success');
            $("#idpetugas_ext").val(params.data.ID);
            $("#namapetugas_ext").val(params.data.username);

            var parent = $('embed#filettd').parent();
            var newElement = "<embed src='"+params.data.FileDocument+"' id='filettd'>";
            $('embed#filettd').remove();
            parent.append(newElement);
            path1 = params.data.FileDocument;
            //$("#btnSearching").focus();

            swal({
                title: "Berhasil Input Tanda Tangan",
                text: "No PIN Berhasil dan Tanda Tangan Ditemukan !",
                icon: "success",
            })
            
        }else{
            toast(params.message, 'warning');
            swal({
                title: "Gagal Input Tanda Tangan",
                text: params.message,
                icon: "error",
            })
           
        }
       
}
async function GetApproveName() {
    var base_url = window.location.origin;
    var nopin = $("#nopin").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/GetApproveName/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'nopin=' + nopin 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}
