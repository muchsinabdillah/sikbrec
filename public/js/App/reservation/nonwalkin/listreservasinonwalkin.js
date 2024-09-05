$(document).ready(function(){
$(".preloader").fadeOut();
$('#btnupdatebooking').click(function(){
    swal({
            title: "Simpan",
            text: "Pastikan Data sudah terinput sudah benar. Lanjutkan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                        //goUpdateSEP();
                        $(".preloader").fadeIn();
                        goUpdateBooking();
                } else {
                   // swal("Transaction Rollback !");
                }
            });

});
})

//CEK NO SEP---------------
async function goUpdateBooking() {
    try {
        const data = await ggoUpdateBooking();
        updtggoUpdateBooking(data);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

function updtggoUpdateBooking(params) {
    let response = params;
    if (response.status == 'success'){
        swal({
            title: response.status,
            text: response.message,
            icon: response.status,
        }).then(function() {
            $("#modal_edit_sep").modal('hide');
        });
        caridatareservasi();
        
    }else{
    swal({
        title: response.status,
        text: response.errorname,
        icon: response.status,
    });
    }
    $(".preloader").fadeOut();
        // if (response.status == 'success'){
        //         goUpdateSEP();
        // }else if (response.status = 'warning'){
        //         swal({
        //             title: "Simpan",
        //             text: response.message,
        //             icon: "warning",
        //             buttons: true,
        //             dangerMode: true,
        //         })
        //             .then((willDelete) => {
        //                 if (willDelete) {
        //                         goUpdateSEP();

        //                 } else {
        //                 // swal("Transaction Rollback !");
        //                 }
        //             });
        // }
    //var noregistrasi = response.NoRegistrasi; ;
}

function ggoUpdateBooking() {
    //$(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var JenisPasien = 'RAJAL';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/goUpdateRujukanBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&JenisPasien=" + JenisPasien
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
            } 
            return response
        })
        .finally(() => {
            //$(".preloader").fadeOut();
        })
}
var base_url = window.location.origin;
var tglawal = document.getElementById('tglAwalReservasi')
var tglakhir = document.getElementById('tglAkhirReservasi')

function caridatareservasi_new() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi").val();
    var tanggal_akhir = $("#tglAkhirReservasi").val();
    var jenisdata = $("#jenisdata").val();
    var iswalkin = 'RAJAL';
    $('#tbl_aktif').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_aktif').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.tanggal_akhir = tanggal_akhir
         d.tanggal_awal = tanggal_awal
         d.iswalkin = iswalkin
         d.jenisdata = jenisdata
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "ID" },
                            { "data": "No" },
                            { "data": "NoMR" },
                            { "data": "NamaPasien" },
                            { "data": "ApmDate" },
                            { "data": "NamaUnit" },
                            { "data": "First_Name" },
                            { "data": "HP" },
                            { "data": "JenisPembayaran" },
                            
                            { 
                                "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                if(row.NamaPerusahaan == "BPJS Kesehatan"  ){
                                    if (row.NoRujukanBPJS == null){
                                        var norujukan = '';
                                    }else{
                                        var norujukan = row.NoRujukanBPJS;
                                    }
                                    if (row.NoSuratKontrolBPJS == null){
                                        var nosurkon = '';
                                    }else{
                                        var nosurkon = row.NoSuratKontrolBPJS;
                                    }
                                    if (row.NoKartuBPJS == null){
                                        var nokartubpjs = '';
                                    }else{
                                        var nokartubpjs = row.NoKartuBPJS;
                                    }
                                    var html = '<span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.ID+'","'+row.NamaPerusahaan+'","'+norujukan+'","'+nosurkon+'","'+nokartubpjs+'","'+row.IdPoli+'","'+row.NoMR+'")\'>' + row.NamaPerusahaan + "</span> <br>No. Rujukan : " + norujukan + "<br> No. Surkon : "+ nosurkon + "<br> No. Kartu BPJS : "+ nokartubpjs
                                    return html 
                                }else{
                                    var html = row.NamaPerusahaan
                                    return html  
                                }
                                   
                              }
                            },
                            { "data": "Description" },
                            { "data": "NoBooking" }, 
                            {
                                "render": function (data, type, row) {
                                    var html = ""
                                   
                                        var html = `<font size= "2">No. Antrian : ${row.NoAntrianAll}<br>Petugas Entri : ${row.PetugasInput}<br></font>`
                                   
                                    
                                    return html
                                }
                            },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                if(row.NamaPerusahaan == "BPJS Kesehatan" && row.Description == "BPJS KESEHATAN - MOBILE JKN"){
                                    var html = "" 
                                    return html 
                                }else{
                                    var html = ""
                                    var html  = '<a class="btn btn-primary btn-xs" onclick=ShowbyID("'+row.ID+'")>input</a>'
                                    return html  
                                }
                                
                            }
                      },
                           ],
        'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order' : [1,'asc']
     });
}  
function caridatareservasi() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi").val();
    var tanggal_akhir = $("#tglAkhirReservasi").val();
    var jenisdata = $("#jenisdata").val();
    var iswalkin = 'RAJAL';

    $('#tbl_aktif').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_aktif').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.tanggal_akhir = tanggal_akhir
         d.tanggal_awal = tanggal_awal
         d.iswalkin = iswalkin
         d.jenisdata = jenisdata
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "ID" },
                            { "data": "No" },
                            { "data": "NoMR" },
                            { "data": "NamaPasien" },
                            { "data": "ApmDate" },
                            { "data": "NamaUnit" },
                            { "data": "First_Name" },
                            { "data": "HP" },
                            { "data": "JenisPembayaran" },
                            
                            { 
                                "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                if(row.NamaPerusahaan == "BPJS Kesehatan"  ){
                                    if (row.NoRujukanBPJS == null){
                                        var norujukan = '';
                                    }else{
                                        var norujukan = row.NoRujukanBPJS;
                                    }
                                    if (row.NoSuratKontrolBPJS == null){
                                        var nosurkon = '';
                                    }else{
                                        var nosurkon = row.NoSuratKontrolBPJS;
                                    }
                                    if (row.NoKartuBPJS == null){
                                        var nokartubpjs = '';
                                    }else{
                                        var nokartubpjs = row.NoKartuBPJS;
                                    }
                                    var html = '<span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.ID+'","'+row.NamaPerusahaan+'","'+norujukan+'","'+nosurkon+'","'+nokartubpjs+'","'+row.IdPoli+'","'+row.NoMR+'")\'>' + row.NamaPerusahaan + "</span> <br>No. Rujukan : " + norujukan + "<br> No. Surkon : "+ nosurkon + "<br> No. Kartu BPJS : "+ nokartubpjs
                                    return html 
                                }else{
                                    var html = row.NamaPerusahaan
                                    return html  
                                }
                                   
                              }
                            },
                            { "data": "Description" },
                            { "data": "NoBooking" }, 
                            {
                                "render": function (data, type, row) {
                                    var html = ""
                                   
                                        var html = `<font size= "2">No. Antrian : ${row.NoAntrianAll}<br>Petugas Entri : ${row.PetugasInput}<br></font>`
                                   
                                    
                                    return html
                                }
                            },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                if(row.NamaPerusahaan == "BPJS Kesehatan" && row.Description == "BPJS KESEHATAN - MOBILE JKN"){
                                    var html = "" 
                                    return html 
                                }else{
                                    var html = ""
                                    var html  = '<a class="btn btn-primary btn-xs" onclick=ShowbyID("'+row.ID+'")>input</a>'
                                    return html  
                                }
                                
                            }
                      },
                           ],
        'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order' : [1,'asc']
     });
}  

function updateDataSEP2(ID,NamaPerusahaan,NoRujukanBPJS,NoSuratKontrolBPJS,NoKartuBPJS,IdPoli,NoMR){
   
        $('#modal_edit_sep').modal('show');
        $('#frmUpdateSEP')[0].reset();
        $('#updtbook_ID').val(ID); 
        $('#updtbook_NoRujukan').val(NoRujukanBPJS);
        $('#updtbook_NoSurkon').val(NoSuratKontrolBPJS);
        $('#updtbook_nokartubpjs').val(NoKartuBPJS); 
        $('#updtbook_IdPoli').val(IdPoli); 
        $('#updtbook_NoMR').val(NoMR); 
        
}

function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjungan2BPJS = $("[name='MTglKunjungan2BPJS']").val();
    var MJenisPelayananBPJS = '2';
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoListSPRIBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MTglKunjungan2BPJS = MTglKunjungan2BPJS;
                d.MJenisPelayananBPJS = MJenisPelayananBPJS;
            }
        },
        "columns": [
            { "data": "noSuratKontrol" },
            { "data": "noKartu" },
            { "data": "nama" },
            { "data": "namaDokter" },
            { "data": "namaPoliAsal" },
            { "data": "namaPoliTujuan" },
            { "data": "jnsPelayanan" },
            { "data": "namaJnsKontrol" },
            { "data": "tglRencanaKontrol" },
            { "data": "tglTerbitKontrol" },
            { "data": "noSepAsalKontrol" },
            { "data": "tglSEP" },
            // {
            //     "render": function (data, type, row) {
            //         var html = ""
            //         var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataSIPR("' + row.noSuratKontrol + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
            //         return html
            //     }
            // },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataSIPR("' + row.noSuratKontrol + '","' + row.namaJnsKontrol + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ]
    });


}

function ShowDataSIPR(noSuratKontrol,namaJnsKontrol){
    $('#updtbook_NoSurkon').val(noSuratKontrol);
}
function caridatareservasi_arsip_new() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi_arsip").val();
    var tanggal_akhir = $("#tglAkhirReservasi_arsip").val();
    var iswalkin = 'RAJAL';
    $('#tbl_arsip').DataTable().clear().destroy();
    $('#tbl_arsip').DataTable({
     "searching" : true,
     "pagging": true,
     "processing": true, 
     "serverSide": true,
     "ordering": true, // Set true agar bisa di sorting
     "order": [[ 0, 'desc' ]],
     "ajax": {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi_arsip", // URL file untuk proses select datanya
         "deferRender": true,
         "type": "POST" ,
         data: function (d) {
            d.tanggal_akhir = tanggal_akhir
            d.tanggal_awal = tanggal_awal
            d.iswalkin = iswalkin
             }

     },

    "columns": [
        // { "data": "No" },
        { "data": "NoMR" },
        { "data": "NamaPasien" },
        { "data": "ApmDate" },
        { "data": "NamaUnit" },
        { "data": "First_Name" },
        { "data": "HP" },
        { "data": "JenisPembayaran" },
        { "data": "NamaPerusahaan" },
        { "data": "Description" },
        { "data": "NoBooking" },
        { "data": "NoAntrianAll" },
        { "data": "NoRegistrasi" },
                           ],
                        //    'order' : [0,'asc']

     });
}  
function caridatareservasi_arsip() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi_arsip").val();
    var tanggal_akhir = $("#tglAkhirReservasi_arsip").val();
    var iswalkin = 'RAJAL';
    $('#tbl_arsip').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_arsip').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi_arsip", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.tanggal_akhir = tanggal_akhir
         d.tanggal_awal = tanggal_awal
         d.iswalkin = iswalkin
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "No" },
                            { "data": "NoMR" },
                            { "data": "NamaPasien" },
                            { "data": "ApmDate" },
                            { "data": "NamaUnit" },
                            { "data": "First_Name" },
                            { "data": "HP" },
                            { "data": "JenisPembayaran" },
                            { "data": "NamaPerusahaan" },
                            { "data": "Description" },
                            { "data": "NoBooking" },
                            { "data": "NoAntrianAll" },
                            { "data": "NoRegistrasi" },
                           ],
        'order' : [0,'asc']
     });
} 

function BtnApprove(thisid){
    var table = $('#tbl_aktif').DataTable();
    var form = $("#form_approve");
    //var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapprove\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapprove[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    //Swal
    swal("Note ( Jika ada perubahan Jadwal atau Lainnya / Isikan - jika tidak ada. ) : ", {
        content: "input",
        buttons: true,
    })
        .then((value) => {
            if (value) {
                ApproveCheckbox(value);
            } 
        });
}

async function ApproveCheckbox(value) {
    try {
        const dataApproveAll = await ApproveAll(value);
        updateUIdataApproveAll(dataApproveAll);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAll(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Kirim Berhasil!",
            text: response.message,
            icon: "success",
        })
        caridatareservasi();
    }else{
        toast(response.message, "error")
    }  

}

function ApproveAll(noted) {
    $(".preloader").fadeIn();
    var form = $("#form_approve").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/sendreminderAll';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&noted=' + noted
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


// function caridatareservasi(){
//     // var awal = tglawal.value
    
//     // console.log(awal)
// $.ajax({
//         type: "POST",
//         url: base_url + '/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi',
//         data: {
//                 tanggal_akhir:tglakhir.value,
//                 tanggal_awal:tglawal.value,
//                 namapasien:document.getElementById('carireservasi').value
//                 },
//         dataType: "json",
//                         // encode: true,
//         }).done(function(data) {
//             $("#tabledatareservasi").empty();
//             data.response.forEach(datareservasi);
//             function datareservasi(reservasi,index){
//                 var encode = btoa(reservasi.ID)
//                 $('#tabledatareservasi').append(`
//                 <tr>
//                     <td>${index+1}</td>
//                     <td>${reservasi.NoMR}</td>
//                     <td>${reservasi.NamaPasien}</td>
//                     <td>${reservasi.ApmDate}</td>
//                     <td>${reservasi.NamaUnit}</td>
//                     <td>${reservasi.First_Name}</td>
//                     <td>${reservasi.HP}</td>
//                     <td>${reservasi.JenisPembayaran}</td>
//                     <td>${reservasi.Description}</td>
//                     <td>${reservasi.Alamat}</td>
//                     <td>${reservasi.Datang}</td>
//                     <td><a class="btn btn-primary btn-xs" target="_blank" href="${base_url}/SIKBREC/public/aReservasiPasiennonWalkin/input/${encode}">input</a>&nbsp<button title="Kirim Reminder" type="button" class="btn-xs btn-success" id="btn_sendreminder" onclick=\'btn_sendreminder("${reservasi.ID}")\')"><i class="fa fa-whatsapp" aria-hidden="true"></i> Kirim Reminder</button></td>
//                 </tr>
//                 `);
//             }
 
//         });
// }

function inputreservasi() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aReservasiPasiennonWalkin/input";
}

async function btn_sendreminder(param) {
    try {
        //$(".preloader").fadeIn();
        const dataSendReminder = await SendReminder(param);
        updateUIdataSendReminder(dataSendReminder);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSendReminder(params) {
    let response = params;
    console.log(response,'sss');
    if (response.status == 200) {
        toast(response.message, "success")
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        }).then(function() {

        });
    }else{
        toast(response.message, "error")
    }  

}
function SendReminder(param) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/sendreminder';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idresv=" + param
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

function ShowbyID(str){
         const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/input/' + str;
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





