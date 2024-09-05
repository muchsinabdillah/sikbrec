$(document).ready(function(){
$(".preloader").fadeOut();
})

var base_url = window.location.origin;
var tglawal = document.getElementById('tglAwalReservasi')
var tglakhir = document.getElementById('tglAkhirReservasi')
var nama = document.getElementById('carireservasi')

function caridatareservasi() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi").val();
    var tanggal_akhir = $("#tglAkhirReservasi").val();
    var jenisdata = $("#jenisdata").val();
    var iswalkin = 'WALKIN';
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
         "searching" : true,
     "pagging": true,
     "processing": true, 
     "serverSide": true,
     "ordering": true, // Set true agar bisa di sorting
     "order": [[ 0, 'desc' ]],
    // $('#tbl_aktif').dataTable({
    //     "bDestroy": true
    // }).fnDestroy();
    //    $('#tbl_aktif').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi", // URL file untuk proses select datanya
        "type": "POST",
        "deferRender": true,

        data: function (d) {
         d.tanggal_akhir = tanggal_akhir
         d.tanggal_awal = tanggal_awal
         d.jenisdata = jenisdata
         d.iswalkin = iswalkin
     }

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
                            { "data": "Description" },
                            { "data": "NoBooking" },
                            { "data": "NoAntrianAll" },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                             
                              var html  = '<a class="btn btn-primary btn-xs" onclick=ShowbyID("'+row.ID+'")>input</a>'
                                 return html 
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

/*
function caridatareservasi(){
    // var awal = tglawal.value
    
    // console.log(awal)
$.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getWalkinbyDate',
        data: {
                tglakhir:tglakhir.value,
                tglawal:tglawal.value,
                nama:nama.value
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            $("#tabledatareservasi").empty();
            data.forEach(datareservasi);
            
            function datareservasi(reservasi,index){
                var encode = btoa(reservasi.ID)
                $('#tabledatareservasi').append(`
                <tr>
                    <td>${reservasi.NoMR}</td>
                    <td>${reservasi.NamaPasien}</td>
                    <td>${reservasi.ApmDate}</td>
                    <td>${reservasi.NamaUnit}</td>
                    <td>${reservasi.First_Name}</td>
                    <td>${reservasi.HP}</td>
                    <td>${reservasi.JenisPembayaran}</td>
                    <td>${reservasi.Description}</td>
                    <td>${reservasi.Alamat}</td>
                    <td><a class="btn btn-primary" target="_blank" href="${base_url}/SIKBREC/public/aReservasiPasienWalkin/input/${encode}">input</a></td>
                    <td>${reservasi.HP}</td>
                </tr>
                `);
            }
 
        });
}
*/

function caridatareservasi_arsip() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi_arsip").val();
    var tanggal_akhir = $("#tglAkhirReservasi_arsip").val();
    var iswalkin = 'WALKIN';
    $('#tbl_arsip').DataTable().clear().destroy();
    $('#tbl_arsip').DataTable({
         "searching" : true,
     "pagging": true,
     "processing": true, 
     "serverSide": true,
     "ordering": true, // Set true agar bisa di sorting
     "order": [[ 0, 'desc' ]],
    // $('#tbl_arsip').dataTable({
    //     "bDestroy": true
    // }).fnDestroy();
    //    $('#tbl_arsip').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aReservasipasiennonWalkin/caridatareservasi_arsip", // URL file untuk proses select datanya
        "type": "POST",
    "deferRender": true,

        data: function (d) {
         d.tanggal_akhir = tanggal_akhir
         d.tanggal_awal = tanggal_awal
         d.iswalkin = iswalkin
     }
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
                            { "data": "Description" },
                            { "data": "NoBooking" },
                            { "data": "NoAntrianAll" },
                            { "data": "NoRegistrasi" },
                           ],
        'order' : [0,'asc']
     });
} 

function inputreservasi() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aReservasiPasienWalkin/input_new";
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
    swal({
        title: "Kirim Reminder",
        text: "Apakah Anda ingin Kirim Yang Dipilih ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    ApproveCheckbox();
            } 
        });
}

async function ApproveCheckbox() {
    try {
        const dataApproveAll = await ApproveAll();
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

function ApproveAll() {
    $(".preloader").fadeIn();
    var form = $("#form_approve").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/sendreminderAll';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form 
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
        window.location = base_url + '/SIKBREC/public/aReservasiPasienWalkin/input_new/' + str;
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





