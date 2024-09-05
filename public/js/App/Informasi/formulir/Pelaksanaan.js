$(document).ready(function () {
   // asyncShowMain();
    $(".preloader").fadeOut(); 
    
    $(document).on('click', '#tandatangan', function () {
        //checking before get data
        CheckVar1();
    });
});
// // var base_url = window.location.origin;
// var signature
// var tandatangan = document.getElementById('tandatangan')

// // saksi Pasien
// $("#btn-save").click(function(e) {
//     e.preventDefault()
//     console.log('di klik')
//     var pesan = $('#ttdsaksipasien').signaturePad().getSignatureString();
//     signature = pesan
//     // gambar zzz
//     $("#pasienttd").signaturePad({
//         displayOnly: true,
//         penColour: '#000000',
//         drawBezierCurves: true,
//     }).regenerate(signature)
//     // $("#tandatanganjson").val(signature)
//     console.log(signature)
//     html2canvas([document.getElementById('sign-pad')], {
//         onrendered: function(canvas) {
//             var canvas_data = canvas.toDataURL('image/png');
//             var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
//             $.ajax({
//                 url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/saveimgSignature',
//                 data: {
//                     img_data: img_data,
//                     // namaparam: namapasien.value,
//                     // nomortransaksi:NO_MR.value,
//                     // usercreate:namauser,
//                     // noregistrasi: noregistrasi.value
//                     // nama: document.getElementById('nama').value
//                 },
//                 type: 'post',
//                 dataType: 'json',
//                 success: function(response) {
//                    console.log(response.path)
//                    path2 = response.path
//                 //    param2 = response.uuid
//                 // type: 'post',
//                 // dataType: 'json',
//                 // success: function(response) {
//                 //     $("#btnModalSrcPasienClose").click()
//                 //     console.log(response)
//                 //     if(response.status !=200){
//                 //         alert(response.message)
//                 //     }
//                 }
//             });
//         }
//     });
// });

// $(".ttdsaksirumahsakit").click(function(e) {
//     e.preventDefault()
//     console.log('di klik')
//     var pesan = $('.signature-area').signaturePad().getSignatureString();
//     signature = pesan
//     $(".rumahsakit").signaturePad({
//         displayOnly: true,
//         penColour: '#000000',
//         drawBezierCurves: true,
//     }).regenerate(signature)
//     $("#tandatanganjson").val(signature)
//     console.log(signature)
//     html2canvas([document.getElementById('ttdrumahsakit')], {
//         onrendered: function(canvas) {
//             var canvas_data = canvas.toDataURL('image/png');
//             var img_data = canvas_data.replace(/^data:image\/(png|jpg);base64,/, "");
//             $.ajax({
//                 url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/getPath',
//                 data: {
//                     img_data: img_data,
//                     // nama: document.getElementById('nama').value
//                 },
//                 type: 'post',
//                 dataType: 'json',
//                 success: function(response) {
//                     console.log(response.path)
//                     path1 = response.path
//                     param1 = response.uuid
//                 }
//             });
//         }
//     });
// });

// tandatangan.addEventListener('click',function (e) {
//     e.preventDefault()
//     var FormData = {
//         // namaparam1:nama.value,
//         // namaparam2:nama.value,
//         // uuid1:param1,
//         // uuid2:param2,
//         path1:path1,
//         path2:path2,
//         // nomortransaksi:noregistrasi.value,
//         // usercreate:namauser
//     }
//     $.ajax({
//         url: base_url + '/SIKBREC/public/fPelaksanaanEdukasi/dobleSignautre',
//         data: FormData,
//         type: 'post',
//         dataType: 'json',
//         success: function(response) {
//             if (response.status != 200) {
//                 // alert(data.errorname,data.metadata.message)
//                 swal({
//                     title: "error",
//                     text: response.message,
//                     icon: "error",
//                 })
//             } else {
//                 swal({
//                     title: "success",
//                     text: "Tanda Tangan Digital Berhasil Di input",
//                     icon: "success",
//                 })
//             }
//         }
//     });
// })

// // selectedtable()
// // $(document).ready(function() {
// //     $(".signature-area").signaturePad({
// //         penColour: '#000000',
// //         drawOnly: true,
// //         drawBezierCurves: true,
// //         lineTop: 90,
// //         lineWidth: 0,
// //         validateFields: true,

// //     })
// //     if (signature != '') {

// //     }

//     $(".btn-clear").click(function(e) {
//         $(".signature-area").signaturePad().clearCanvas();
//     });
// // });

function CheckVar1 (){
    //if not in creteria return false
    if ($("#TglJamEdukasi").val() == ''){
        toast ('Isi Tgl', "warning");
        return false;
    }
    if ($("#Materi_Edukasi_Berdasarkan_Kebutuhan").val() == ''){
        toast ('Isi Materi Edukasi', "warning");
        return false;
    } 
    if ($("#Kode_Leaflet").val() == ''){
        toast ('Isi Kode Leaflet', "warning");
        return false;
    }
    if ($("#Lama_Edukasi").val() == ''){
        toast ('Isi Lama Edukasi', "warning");
        return false;
    }if ($("#Hasil_Verifikasi").val() == ''){
        toast ('Isi Hasil Verifikasi', "warning");
        return false;
    }
    if ($("#Tgl_Reedukasi_Redemonstrasi").val() == ''){
        toast ('Isi Tgl Reedukasi', "warning");
        return false;
    }
    if ($("#Pemberi_Edukasi").val() == ''){
        toast ('Isi Pemberi Edukasi', "warning");
        return false;
    }
    if ($("#Pasien_keluarga_Hubungan").val() == ''){
        toast ('Isi Nama Pasien Atau Keluarga', "warning");
        return false;
    }
    if ($("#saksi_rumah_sakit").val() == ''){
        toast ('Isi TTD Pemberi Edukasi', "warning");
        return false;
    }
    if ($("#saksi_pasiens").val() == ''){
        toast ('Isi TTD ', "warning");
        return false;
    }
    goInsert1();
}

async function goInsert1() {
    try {
        const dataCreateData = await CreateData();
        updateUIdataCreateData1(dataCreateData);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCreateData(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        //$("#idhdr_bpjs").val(response);
        // asyncShowMain();

    }else{
        toast(response.message, "error")
    }  
}

function CreateData() {
    var str = $("#form2").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/form/getInsert2';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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

        })
}


function getInsert1() { 
    //if ($("#TglJamEdukasi").val() == ''){
        let TglJamEdukasi ,Materi_Edukasi_Berdasarkan_Kebutuhan,Kode_Leaflet,Lama_Edukasi,Hasil_Verifikasi,Tgl_Reedukasi_Redemonstrasi,Pemberi_Edukasi,Pasien_keluarga_Hubungan,saksi_rumah_sakit,saksi_pasiens ;
        TglJamEdukasi = $("#TglJamEdukasi").val();
    Materi_Edukasi_Berdasarkan_Kebutuhan = $("#Materi_Edukasi_Berdasarkan_Kebutuhan").val();
    Kode_Leaflet = $("#Kode_Leaflet").val();
    Lama_Edukasi = $("#Lama_Edukasi").val();
    Hasil_Verifikasi = $("#Hasil_Verifikasi").val();
    Tgl_Reedukasi_Redemonstrasi = $("#Tgl_Reedukasi_Redemonstrasi").val();
    Pemberi_Edukasi = $("#Pemberi_Edukasi").val();
    Pasien_keluarga_Hubungan = $("#Pasien_keluarga_Hubungan").val();
    saksi_rumah_sakit = $("#saksi_rumah_sakit").val();
    saksi_pasiens = $("#saksi_pasiens").val();


        var base_url = window.location.origin;
        $('#datatable').dataTable({
            "bDestroy": true
        }).fnDestroy();
        $('#datatable').dataTable({
            "bDestroy": true
        }).fnDestroy();
        if (JenisPasien == '1' && JenisRekap == '3') {
            $('#datatable').show()
            $('#datatable').hide()
    
            $('#datatable').DataTable({
                "ordering": true, // Set true agar bisa di sorting
                "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                "ajax":
                {
                    "url": base_url + "/SIKBREC/public/form/getInsert2", // URL file untuk proses select datanya
                    "type": "POST",
                    data: function ( d ) {
                    d.TglJamEdukasi = TglJamEdukasi;
                    d.Materi_Edukasi_Berdasarkan_Kebutuhan = Materi_Edukasi_Berdasarkan_Kebutuhan;
                    d.Kode_Leaflet = Kode_Leaflet;
                    d.Lama_Edukasi = Lama_Edukasi;
                    d.Hasil_Verifikasi = Hasil_Verifikasi;
                    d.Tgl_Reedukasi_Redemonstrasi = Tgl_Reedukasi_Redemonstrasi;
                    d.Pemberi_Edukasi = Pemberi_Edukasi;
                    d.Pasien_keluarga_Hubungan = Pasien_keluarga_Hubungan;
                    d.saksi_rumah_sakit= saksi_rumah_sakit;
                    d.saksi_pasiens = saksi_pasiens;
                    },
                    error: function (xhr, error, code)
                    {
                        toast('Error! Data Not Found!',"error")
                        $("#datatable_Rujukan").hide();
                    },
                     "dataSrc": "",
                "deferRender": true,
                }, 
                "columns": [
                //  { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
                 { "data": "TglJamEdukasi" },
                 { "data": "Materi_Edukasi_Berdasarkan_Kebutuhan" },
                 { "data": "Kode_Leaflet" }, 
                 { "data": "Lama_Edukasi"},
                 { "data": "Hasil_Verifikasi"},
                 { "data": "Tgl_Reedukasi_Redemonstrasi"},
                 { "data": "Pemberi_Edukasi"},
                 { "data": "Pasien_keluarga_Hubungan"},
                 { "data": "saksi_rumah_sakit"},
                 { "data": "saksi_pasiens"},
                                 ],
            });
    
        }
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
    toastr[status](data);
}

