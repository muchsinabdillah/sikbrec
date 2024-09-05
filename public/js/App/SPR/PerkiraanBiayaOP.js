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
        title: "Simpan",
        text: "Apakah Anda Yakin Ingin Simpan ?",
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
    // var FormData = $("#frmSimpanTrsRegistrasi").serialize();
    // var kelasname = $('#pasien_kelas option:selected').text();
    var FormData = 
                $("#frmSimpanTrsRegistrasi").serialize()+
                    '&namaparam1='+nama.value+
                    '&namaparam2='+nama.value+
                    '&uuid1='+param1+
                    '&uuid2='+param2+
                    '&path1='+path1+
                    '&path2='+path2+
                    '&namaparam2='+nama.value+
                    '&usercreate='+namauser+
                    '&kelasname='+$('#pasien_kelas option:selected').text()+
                    '&nohp_send='+$("#nohp_send").val()+
                    '&email_send='+$("#email_send").val();
    $.ajax({
        url: base_url + '/SIKBREC/public/signatureDigital/savePerkiraanBiayaOP',
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
        url: base_url + '/SIKBREC/public/signatureDigital/uploadToAwsSignPerkiraanbiayaOP',
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

// async function uploadtoAws_filepdfx(param){
//     var FormData = {
//         id:param,
//     }
//     $.ajax({
//         url: base_url + '/SIKBREC/public/aRegistrasiRajal/SavePerkiraanBiayaNonOP',
//         data: FormData,
//         type: 'post',
//         dataType: 'json',
//         success: function(response) {
//             if (response.status != 200) { 
//                 swal({
//                     title: "error",
//                     text: "Data Gagal di Simpan ke Sistem !",
//                     icon: "error",
//                 })
//                 $(".preloader").fadeOut();
//             } else {
//                 swal({
//                     title: "success",
//                     text: "Generate Berhasil",
//                     icon: "success",
//                 }) 
//             }
//         }
//     });
// }

async function uploadtoAws_filepdfx(param){
    var FormData = {
        id:param,
    }
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/SavePerkiraanBiayaOP';
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
    const url = base_url + "/SIKBREC/public/aRegistrasiRajal/SendMailPerkiraanBiayaOP/";
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

function passData(){
    $("#namajelas").text($("#namawali").val());
    $("#NamaPasien_tmp").text($("#pasien_nama").val());
    $("#NoRMPasien_tmp").text($("#pasien_nomr").val());
    $("#PerawatanPasien_tmp").text($("#pasien_rencanakeperawatan").val());
    $("#DiagnosaPasien_tmp").text($("#pasien_diagnosa").val());
    //$("#DPJPPasien_tmp").text($("#pasien_dpjp").val());
    $("#KamarPasien_tmp").text($("#pasien_kamarperawatan").val());
    $("#KelasPasien_tmp").text($('#pasien_kelas option:selected').text());
    $("#LamaRawatPasien_tmp").text($("#pasien_perkiraanlamarawat").val());

    $("#drop_tmp").text($("#jd_drop").val());
    $("#drassop_tmp").text($("#jd_drassop").val());
    $("#dranestesi_tmp").text($("#jd_dranestesi").val());
    $("#sewakamar_tmp").text($("#sewakamar").val());
    $("#alkes_tmp").text($("#alkesbhp").val());
    $("#lain_tmp").text($("#lainlain").val());

    $("#drop_ket_tmp").text($("#jd_drop_ket").val());
    $("#drassop_ket_tmp").text($("#jd_drassop_ket").val());
    $("#dranestesi_ket_tmp").text($("#jd_dranestesi_ket").val());
    $("#sewakamar_ket_tmp").text($("#sewakamar_ket").val());
    $("#alkes_ket_tmp").text($("#alkesbhp_ket").val());
    $("#lain_ket_tmp").text($("#lainlain_ket").val());

    $("#KeteranganLainnya_tmp").text($("#keterangan_lainnya").val());

    $("#Tindakan_tmp").text($("#pasien_tindakan").val());
    $("#DrOperator_tmp").text($("#pasien_droperator").val());
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

    $(document).on('click', '#btncopydiagnosa', function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Copy Diagnosa Dari EMR?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCopyDiagnosa();
                } else {
                   // swal("Transaction Rollback !");
                   return false;
                }
            });
    });

    $('#pasien_kelas').change(function () {
        var xdi = document.getElementById("pasien_kelas").value;
        getRoomID(xdi);
    });

    asyncShowMain();
});

async function asyncShowMain() {
    try {   
        const data = await getLoadDataFromGC();
        updateUIgetLoadDataFromGC(data);
        const datagetJenisRawat = await getJenisRawat();
        updateUIgetJenisRawat(datagetJenisRawat);
        const dataKelas = await getKelas();
        updateUIgetKelas(dataKelas);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetLoadDataFromGC(datagetGroupJaminan) {
    let responseApi = datagetGroupJaminan;
    console.log(responseApi.data);
        if (responseApi.data['ID'] !== null) {

            $("#namawali").val(responseApi.data['NamaPenanggungJawab']);
            $("#nik").val(responseApi.data['NoKtp']);
            $("#email_send").val(responseApi.data['EmailSend']);
            $("#nohp_send").val(responseApi.data['NoHPSend']);
            
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
                "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryBiayaOP", // URL file untuk proses select datanya
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

    var jd_drop = document.getElementById("jd_drop");
    jd_drop.addEventListener("keyup", function (e) {
        jd_drop.value = formatRupiah(this.value);
        CalculateALL();
    })
    var jd_drassop = document.getElementById("jd_drassop");
    jd_drassop.addEventListener("keyup", function (e) {
        jd_drassop.value = formatRupiah(this.value);
        CalculateALL();
    })
    var jd_dranestesi = document.getElementById("jd_dranestesi");
    jd_dranestesi.addEventListener("keyup", function (e) {
        jd_dranestesi.value = formatRupiah(this.value);
        CalculateALL();
    })
    var sewakamar = document.getElementById("sewakamar");
    sewakamar.addEventListener("keyup", function (e) {
        sewakamar.value = formatRupiah(this.value);
        CalculateALL();
    })
    var alkesbhp = document.getElementById("alkesbhp");
    alkesbhp.addEventListener("keyup", function (e) {
        alkesbhp.value = formatRupiah(this.value);
        CalculateALL();
    })
    var lainlain = document.getElementById("lainlain");
    lainlain.addEventListener("keyup", function (e) {
        lainlain.value = formatRupiah(this.value);
        CalculateALL();
    })

    function number_to_price(v){
        if(v==0){return '0';}
        v=parseFloat(v);
        v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        v=v.split('.').join('*').split(',').join('.').split('*').join(',');
        return v;
    }
    function price_to_number(v){
        if(!v){return 0;}
        v=v.split('.').join('');
        v=v.split(',').join('.');
        return Number(v.replace(/[^0-9.]/g, ""));
    }
    
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
          split = number_string.split(","),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
          separator = sisa ? "." : "";
          rupiah += separator + ribuan.join(".");
        }
      
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
      }

      function CalculateALL() {

        var grandtotal = 0;
    
        var jd_drop = parseFloat(price_to_number($("#jd_drop").val()));
        var jd_drassop = parseFloat(price_to_number($("#jd_drassop").val()));
        var jd_dranestesi = parseFloat(price_to_number($("#jd_dranestesi").val()));
        var sewakamar = parseFloat(price_to_number($("#sewakamar").val()));
        var alkesbhp = parseFloat(price_to_number($("#alkesbhp").val()));
        var lainlain = parseFloat(price_to_number($("#lainlain").val()));
    
        // grandtotal = 
        // rs_kamarperawatan + prosedur_bedah + konsultasi + tenaga_ahli + keperawatan + penunjang + radiologi + laboratorium + pelayanan_darah + rehabilitasi + kamar + rawat_intensif + obat + obat_kronis + obat_kemoterapi + alkes + bmhp + sewa_alat
    
        $("#jd_drop").val(number_to_price(jd_drop))
        $("#jd_drassop").val(number_to_price(jd_drassop))
        $("#jd_dranestesi").val(number_to_price(jd_dranestesi))
        $("#sewakamar").val(number_to_price(sewakamar))
        $("#alkesbhp").val(number_to_price(alkesbhp))
        $("#lainlain").val(number_to_price(lainlain))
    }

    async function goCopyDiagnosa() {
        try {   
            const data = await getgoCopyDiagnosa();
            updateUIgetgoCopyDiagnosa(data);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetgoCopyDiagnosa(data) {
        let responseApi = data;
        $("#pasien_diagnosa").val(responseApi['data']['A_Diagnosa']);
        $("#pasien_rencanakeperawatan").val(responseApi['data']['JenisRawat']).trigger('change');
        $("#pasien_dpjp").val(responseApi['data']['DokterDPJP']);
        if (responseApi['data']['LamaRawat'] == null){
            $("#pasien_perkiraanlamarawat").val('');
        }else{
            $("#pasien_perkiraanlamarawat").val(responseApi['data']['LamaRawat']+' Hari');
        }
        swal({
            title: "Success",
            text: 'Berhasil Copy Dari SPR',
            icon: "success",
        })
        }
        
        async function getgoCopyDiagnosa() {
        var notrs = $("#Noregis").val()
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/signatureDigital/getCopyDiagnosa';
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

        async function getJenisRawat() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getJenisRawat';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
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
                    $("#pasien_rencanakeperawatan").select2();
                })
        }
        
        function updateUIgetJenisRawat(datas) {
            let responseApi = datas; 
            if (responseApi.data !== null && responseApi.data !== undefined) {
                //console.log(responseApi.data);
                $("#pasien_rencanakeperawatan").empty();
                var newRow = '<option value="">-- PILIH --</option';
                $("#pasien_rencanakeperawatan").append(newRow);
                for (i = 0; i < responseApi.data.length; i++) {
                    var newRow = '<option value="' + responseApi.data[i].JenisRuangRawat + '">' + responseApi.data[i].JenisRuangRawat + '</option';
                    $("#pasien_rencanakeperawatan").append(newRow);
                }
            }
        }
            
            async function getKelas() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                //body: 'id=' + $("#IdAuto").val()
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
                    $("#pasien_kelas").select2(); 
                })
            }

            
        function updateUIgetKelas(datagetKelas) {
            let responseApi = datagetKelas;
            if (responseApi.data !== null && responseApi.data !== undefined) {
                //console.log(responseApi.data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#pasien_kelas").append(newRow);
                for (i = 0; i < responseApi.data.length; i++) {
                    var newRow = '<option value="' + responseApi.data[i].IDKelas + '">' + responseApi.data[i].NamaKelas + '</option';
                    $("#pasien_kelas").append(newRow);
                }
            }
            }

            async function getRoomID(classid) {
                try{
                    const datagetRoom = await getRoom(classid);
                    updateUIgetRoom(datagetRoom);
                } catch (err) {
                    toast(err.message, "error")
                }
            }
        
        async function getRoom(classid) {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getRoom';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: 'classid=' + classid,
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
                    $("#pasien_kamarperawatan").select2();
                })
        }
        
        function updateUIgetRoom(datagetRoom) {
            let data = datagetRoom;
            if (data !== null && data !== undefined) {
            $("#pasien_kamarperawatan").empty();
                var newRow = '<option value="">-- PILIH --</option';
                $("#pasien_kamarperawatan").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].Room + '">' + data.data[i].Room + '</option';
                    $("#pasien_kamarperawatan").append(newRow);
                }
            }
        }