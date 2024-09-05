var base_url = window.location.origin;
var signature
var param1
var path1 
var param2
var path2
var tandatangan = document.getElementById('tandatangan')
var noregistrasi = document.getElementById('Noregis')
var namapihak1 = document.getElementById('namapihak1')
var nama = document.getElementById('nama')
var namajelas = document.getElementById('namajelas')
var NoEpisode = document.getElementById('NoEpisode') 

// data pasien
var norm = document.getElementById('pasien_nomr')
var namapasien = document.getElementById('pasien_nama')
var jeniskelasmin = document.getElementById('pasien_jeniskelamin')
var tgllahir = document.getElementById('pasien_tgllahir')
var pasien_agama = document.getElementById('pasien_agama')
var pasien_alamat  = document.getElementById('pasien_alamat')
var pasien_jenistandapengenal = document.getElementById('pasien_jenistandapengenal')
var pasien_notandapengenal = document.getElementById('pasien_notandapengenal')

//data wali 
var pnj_noKTP = document.getElementById('pnj_noKTP')
var pnj_pekerjaan = document.getElementById('pnj_pekerjaan')
var pnj_noHP = document.getElementById('pnj_noHP')
var pnj_alamat = document.getElementById('pnj_alamat')
var pnj_JenisOrang = document.getElementById('pnj_JenisOrang')
var pnj_kelamin = document.getElementById('pnj_kelamin')
var pnj_umur = document.getElementById('pnj_umur')
 
// jaminan

 var jaminan = $('input[name="jaminan"]:checked').val()
// var jaminan_pribadi = $("#jaminan_pribadi").is(":checked")
// var jaminan_bpjs = $("#jaminan_bpjs").is(":checked")
// var jaminan_perusahaan = $("#jaminan_perusahaan").is(":checked")
// var jaminan_asuransi = $("#jaminan_asuransi").is(":checked")
var jaminan_namaPerusahaan = document.getElementById('jaminan_namaPerusahaan')
// consen
var consen_kuasa = $('input[name="consen_kuasa"]:checked').val();
var consen_kondisiPasien = $('input[name="consen_kondisiPasien"]:checked').val();
var consen_aksesKeluarga = $('input[name="consen_aksesKeluarga"]:checked').val();
var consen_privasiKhusus = $('input[name="consen_privasiKhusus"]:checked').val();
var consen_privasiKhusus_add = document.getElementById('consen_privasiKhusus_add')
var consen_nilaikepercayaan = $('input[name="consen_nilaikepercayaan"]:checked').val();
var consen_nilaikepercayaan_add = document.getElementById('consen_nilaikepercayaan_add')    

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
    var FormData = 
    $("#user_formdtl").serialize()+
        '&namaparam1='+nama.value+
        '&namaparam2='+nama.value+
        '&uuid1='+param1+
        '&uuid2='+param2+
        '&path1='+path1+
        '&path2='+path2+
        '&nomortransaksi='+noregistrasi.value+
        '&noregistrasi='+noregistrasi.value+
        '&usercreate='+namauser+
        '&pnj_JenisOrang='+pnj_JenisOrang.value+
        '&pnj_alamat='+pnj_alamat.value+
        '&pnj_noHP='+pnj_noHP.value+
        '&pnj_pekerjaan='+pnj_pekerjaan.value+
        '&pnj_noKTP='+pnj_noKTP.value+
        '&pnj_kelamin='+pnj_kelamin.value+
        '&pnj_umur='+pnj_umur.value+
        '&NoEpisode='+NoEpisode.value+
        '&norm='+norm.value+
        '&namapasien='+namapasien.value+
        '&jeniskelasmin='+jeniskelasmin.value+
        '&tgllahir='+tgllahir.value+
        '&pasien_agama='+pasien_agama.value+
        '&pasien_alamat='+pasien_alamat.value+
        '&pasien_jenistandapengenal='+pasien_jenistandapengenal.value+
        '&pasien_notandapengenal='+pasien_notandapengenal.value+
        '&jaminan='+$('input[name="jaminan"]:checked').val()+
        '&jaminan_namaPerusahaan='+jaminan_namaPerusahaan.value+
        '&pasien_nohp='+$("#pasien_nohp").val()+
        '&consen_kuasa='+$('input[name="consen_kuasa"]:checked').val()+
        '&consen_kondisiPasien='+$('input[name="consen_kondisiPasien"]:checked').val()+
        '&consen_aksesKeluarga='+$('input[name="consen_aksesKeluarga"]:checked').val()+
        '&consen_privasiKhusus='+$('input[name="consen_privasiKhusus"]:checked').val()+
        '&consen_privasiKhusus_add='+consen_privasiKhusus_add.value+
        '&consen_nilaikepercayaan='+$('input[name="consen_nilaikepercayaan"]:checked').val()+
        '&consen_nilaikepercayaan_add='+consen_nilaikepercayaan_add.value+
        '&namapetugas_ext='+$("#namapetugas_ext").val()+
        '&idpetugas_ext='+$("#idpetugas_ext").val()+
        '&jaminan_bpjs_cob='+$("#jaminan_bpjs_cob").val()+
        '&jaminan_bpjs_kelas='+$("#jaminan_bpjs_kelas").val()+
        '&nohp_send='+$("#nohp_send").val()+
        '&email_send='+$("#email_send").val();
        
    $.ajax({
        url: base_url + '/SIKBREC/public/signatureDigital/saveGeneralConsen',
        data: FormData,
        type: 'post',
        dataType: 'json',
        success: function(response) {
            if (response.status != 200) {
                // alert(data.errorname,data.metadata.message)
                swal({
                    title: "error",
                    text: "Data Gagal di Simpan ke Sistem ! "+response.message ,
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
        pnj_JenisOrang:pnj_JenisOrang.value,
        pnj_alamat:pnj_alamat.value,
        pnj_noHP:pnj_noHP.value,
        pnj_pekerjaan:pnj_pekerjaan.value,
        pnj_noKTP:pnj_noKTP.value,
        reffid:param

    }
    $.ajax({
        url: base_url + '/SIKBREC/public/signatureDigital/uploadToAwsSignGeneralConsen',
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
nama.addEventListener('keyup',function (e) {
    namajelas.textContent == this.value
})

// async function uploadtoAws_filepdfx(param){
//     var FormData = {
//         id:param,
//     }
//     $.ajax({
//         url: base_url + '/SIKBREC/public/aRegistrasiRajal/SaveGeneralConsent',
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
//             return response['aws_url'];
//         }
//     });
// }

 async function uploadtoAws_filepdfx(param){
        var FormData = {
            id:param,
        }
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aRegistrasiRajal/SaveGeneralConsent';
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

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  async function goSendMailx (email_send,aws_url){
    var aws_url = aws_url['aws_url'];
    var param = $("#xnoMedrec").val();
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aRegistrasiRajal/SendMailGeneralConsent";
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
                $(".preloader").fadeOut();

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
    $("#ttd_namapasien").text($("#nama").val());
    $("#NamaPenanggungJawab_tmp").text($("#nama").val());
    $("#JenisKelamin_Inisial_tmp").text($("#pnj_kelamin").val());
    $("#Tahun_tmp").text($("#pnj_umur").val());
    $("#AlamatPenanggungJawab_tmp").text($("#pnj_alamat").val());
    $("#NoHandphone_tmp").text($("#pnj_noHP").val());
    $("#NamaJenisPenanngungJawab_tmp").text($("#pnj_JenisOrang").val());

    if ($("#pasien_jeniskelamin").val() == 'L'){
        var gender = 'Laki-laki';
    }else{
        var gender = 'Laki-laki';
    }

    const today = new Date($("#pasien_tgllahir").val());
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();
    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    var formattedToday = dd + '/' + mm + '/' + yyyy;

    $("#NamaPasien_tmp").text($("#pasien_nama").val());
    $("#JenisKelaminPasien_tmp").text(gender);
    $("#TangalLahirPasien_tmp").text(formattedToday);
    $("#NoRMPasien_tmp").text($("#pasien_nomr").val());
    $("#AgamaPasien_tmp").text($("#pasien_agama").val());
    $("#AlamatPasien_tmp").text($("#pasien_alamat").val());
    $("#NoHPPasien_tmp").text($("#pasien_nohp").val());
    $("#JenisPengenalPasien_tmp").text($("#pasien_jenistandapengenal").val());
    $("#NIKPasien_tmp").text($("#pasien_notandapengenal").val());

    // var jm_pribadi = '';
    // var jm_bpjs = '';
    // var jm_perusahaan = '';
    // var jm_asuransi = '';
    // if ($("#jaminan_pribadi").is(":checked") == true){
    //     var jm_pribadi = "Pribadi;";
    // }

    // if ($("#jaminan_bpjs").is(":checked") == true){
    //     var jm_bpjs = "Dijamin oleh BPJS;";
    // }

    // if ($("#jaminan_perusahaan").is(":checked") == true){
    //     var jm_perusahaan = "Dijamin oleh Perusahaan;";
    // }
    // if ($("#jaminan_asuransi").is(":checked") == true){
    //     var jm_asuransi = "Dijamin oleh Asuransi;";
    // }

    var jm = '';
    if ($('input[name="jaminan"]:checked').val() == '1'){
        var jm = 'Pribadi';
    }else if ($('input[name="jaminan"]:checked').val() == '3'){
        var jm = 'Dijamin oleh BPJS';
    }else if ($('input[name="jaminan"]:checked').val() == '5'){
        var jm = 'Dijamin oleh Perusahaan';
    }else if ($('input[name="jaminan"]:checked').val() == '2'){
        var jm = 'Dijamin oleh Asuransi';
    }
    if ($("#jaminan_namaPerusahaan").val() == 'null'){
        var jm_nama = '';
    }else{
        var jm_nama = $("#jaminan_namaPerusahaan").val();
    }

    if ($('input[name="jaminan"]:checked').val() == '3'){
        var cob = $("#jaminan_bpjs_cob").val();
        var cob_kelas = $("#jaminan_bpjs_kelas").val();
        if (cob == 'YA'){
            cob_text = ' (COB '+cob_kelas+')';
        }else{
            cob_text = '';
        }
        var jm = jm+cob_text;
    }else{
        var cob = '';
        var cob_kelas = '';
        var jm = jm;
    }


    // $("#jaminan_namaPerusahaan_tmp").text(jm_pribadi+' '+jm_bpjs+' '+jm_perusahaan+' '+jm_asuransi+' '+ $("#jaminan_namaPerusahaan").val());
    $("#jaminan_namaPerusahaan_tmp").text(jm+' '+ jm_nama);
    if ($('input[name="consen_kuasa"]:checked').val() == 'MENYETUJUI'){
        var kuasa_eng = 'Approve';
    }else if ($('input[name="consen_kuasa"]:checked').val() == 'MENOLAK'){
        var kuasa_eng = 'Deny';
    }else{
        var kuasa_eng = '';
    }

    if ($('input[name="consen_kondisiPasien"]:checked').val() == 'MENGIZINKAN'){
        var kondisi_eng = 'Allow';
    }else if ($('input[name="consen_kondisiPasien"]:checked').val() == 'TIDAK MENGIZINKAN'){
        var kondisi_eng = 'Disallow';
    }else{
        var kondisi_eng = '';
    }

    if ($('input[name="consen_aksesKeluarga"]:checked').val() == 'MENGIZINKAN'){
        var akseskel_eng = 'Allowing';
    }else if ($('input[name="consen_kondisiPasien"]:checked').val() == 'TIDAK MENGIZINKAN'){
        var akseskel_eng = 'Not allowing';
    }else{
        var akseskel_eng = '';
    }

    if ($('input[name="consen_privasiKhusus"]:checked').val() == 'MENGINGINKAN'){
        var privasi_eng = 'I want';
    }else if ($('input[name="consen_privasiKhusus"]:checked').val() == 'TIDAK MENGINGINKAN'){
        var privasi_eng = 'Do not want';
    }else{
        var privasi_eng = '';
    }

    $("#MemberiKuasa_tmp").text($('input[name="consen_kuasa"]:checked').val())//approve/deny
    $("#MemberiKuasa_tmpeng").text(kuasa_eng)
    $("#KondisiPasien_tmp").text($('input[name="consen_kondisiPasien"]:checked').val())//allow/disallow
    $("#KondisiPasien_tmpeng").text(kondisi_eng)
    $("#MemberiIzin_tmp").text($('input[name="consen_aksesKeluarga"]:checked').val())//allowing/not allowing
    $("#MemberiIzin_tmpeng").text(akseskel_eng)
    $("#PrivasiKhusus_tmp").text($('input[name="consen_privasiKhusus"]:checked').val())//i want/do not want
    $("#PrivasiKhusus_tmpeng").text(privasi_eng)
    $("#PrivasiKhususText_tmp").text($("#consen_privasiKhusus_add").val())
    $("#PrivasiKhususText_tmp2").text($("#consen_privasiKhusus_add").val())
    $("#Kepercayaan_tmp").text($('input[name="consen_nilaikepercayaan"]:checked').val())
    $("#KepercayaanText_tmp").text($("#consen_nilaikepercayaan_add").val())

    // $(`#${user_data} tr`).each((index, row) => {
    //     $(`#${user_data2}`).append(row);
    //   });

    var source = document.getElementById('user_data');
    var destination = document.getElementById('user_data2');
    var copy = source.cloneNode(true);
    copy.setAttribute('id', 'user_data2');
    destination.parentNode.replaceChild(copy, destination);
    
    //$("#user_data2").append($("#user_data tr"));
    // var $tr = $('#user_data').parents('tr:first').clone();

    //     $tr.appendTo($('#stopsTable > tbody'));
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
    console.log(responseApi.data);
        if (responseApi.data['ID'] !== null) {

            $("#nama").val(responseApi.data['NamaPenanggungJawab']);
            $("#pnj_noKTP").val(responseApi.data['NoKtp']);
            $("#pnj_umur").val(responseApi.data['Tahun']);
            $("#pnj_kelamin").val(responseApi.data['JenisKelamin']);
            $("#pnj_pekerjaan").val(responseApi.data['Pekerjaan']);
            $("#pnj_noHP").val(responseApi.data['NoHandphone']);
            $("#pnj_alamat").val(responseApi.data['AlamatPenanggungJawab']);
            $("#pnj_JenisOrang").val(responseApi.data['NamaJenisPenanngungJawab']);
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
                "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryGeneralConsent", // URL file untuk proses select datanya
                "type": "POST",
               data: function ( d ) {
               d.nomr = nomr;
               },
                 "dataSrc": "",
            "deferRender": true,
            }, 
            "columns": [
                { "data": 'ID' },
                { "data": 'TglCreate' },
                { "data": 'NoRegistrasi' },
                { "data": 'NoEpisode' },
                { "data": 'NoRMPasien' },
                { "data": 'NamaPasien' },
                { "data": 'AwsUrlDocuments' },
                { "data": 'uuid4' },
                { "data": 'NamaPenanggungJawab' },
                { "data": 'NoKtp' },
            ],
        });
    } 

    async function getIDPenjamin() {
        try {
            var tp_penjamin = $('input[name="jaminan"]:checked').val();
            if (tp_penjamin == '3'){
                $("#jaminan_bpjs_cob").attr('disabled', false);
                $("#jaminan_bpjs_kelas").attr('disabled', false);
            }else {
                $("#jaminan_bpjs_cob").attr('disabled', true);
                $("#jaminan_bpjs_kelas").attr('disabled', true);

            }
            
            const data = await getNamaPenjamin(tp_penjamin);
            updateUIgetNamaPenjamin(data);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function getNamaPenjamin(tp_penjamin) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'tp_penjamin=' + tp_penjamin
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
                $("#jaminan_namaPerusahaan").select2();
            })
    }
    
    function updateUIgetNamaPenjamin(datas) {
        let responseApi = datas; 
        if (responseApi.data !== null && responseApi.data !== undefined) {
            //console.log(responseApi.data);
            $("#jaminan_namaPerusahaan").empty();
            var newRow = '<option value="">-- PILIH --</option';
            $("#jaminan_namaPerusahaan").append(newRow);
            for (i = 0; i < responseApi.data.length; i++) {
                var newRow = '<option value="' + responseApi.data[i].NamaPerusahaan + '">' + responseApi.data[i].NamaPerusahaan + '</option';
                $("#jaminan_namaPerusahaan").append(newRow);
            }
        }
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

    function passData_ttdpasien (){
        $("#ttd_namapasien").text($("#nama").val());
    }

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

    $("#add_row").click(function () { 

        if($('#totalrow').val()==0){
            var count =0;
          }else{
            var count = parseFloat($('#totalrow').val());
          }
          count = count + 1;
          document.getElementById('grantotalOrder').innerHTML = count;
          $('#totalrow').val(count);

            output = '<tr id="row_' + count + '">';
            output += "<td><input type='text' name='consen_kondisiPasien_suami[]' id='consen_kondisiPasien_suami'"+count+" style='width:100%'  ></td>";
            output += "<td><input type='text' name='consen_kondisiPasien_istri[]' id='consen_kondisiPasien_istri'"+count+" style='width:100%'  ></td>";
            output += "<td><input type='text' name='consen_kondisiPasien_anak[]' id='consen_kondisiPasien_anak'"+count+" style='width:100%'  ></td>";
            output += "<td><input type='text' name='consen_kondisiPasien_saudarakandung[]' id='consen_kondisiPasien_saudarakandung'"+count+" style='width:100%'  ></td>";
            output += "<td><input type='text' name='consen_kondisiPasien_orangtua[]' id='consen_kondisiPasien_orangtua'"+count+" style='width:100%'  ></td>";
            output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' +
              count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';
            $('#user_data').append(output); 
            
        //}
    });

    $(document).on('click', '.remove_details', function () {
        var row_id = $(this).attr("id");
        swal({
            title: "Are you sure?",
            text: "Apakah anda yakin Ingin hapus data ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $('#row_' + row_id + '').remove();
                var count = $('#totalrow').val();
                //console.log(count);
                count = count - 1 ;
                document.getElementById('grantotalOrder').innerHTML = count;
                $('#totalrow').val(count);
                toast('Berhasil Hapus !', "success")
            } else {
              //swal("Your imaginary file is safe!");
            }
          });
    
        });
