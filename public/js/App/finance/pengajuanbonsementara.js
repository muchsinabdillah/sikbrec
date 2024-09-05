$(document).ready(function () {
    // shwoOutstandingPencairan();
    shwoOutstandingPenyelesaian();
});
function shwoOutstandingPencairan() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PencairanKasbon/showOutstandingPencairan",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [
            { "data": "ID" }, 
            { "data": "No_Transaksi" },
            { "data": "TglOrder" },
            { "data": "Nama" },
            { "data": "Keterangan" },  
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> '  + row.Nominal + '  </font>  ';
                    return html
                }
            },  
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowFormPencairan(' + row.ID + ')" ><span class="visible-content" > Pencairan</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
} 

function shwoOutstandingPenyelesaian() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_arsipa').DataTable().clear().destroy();
    $('#tbl_arsipa').DataTable({
         "searching" : true,
            "pagging": true,
            "processing": true, 
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'desc' ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PencairanKasbon/shwoOutstandingPenyelesaian", 
            "deferRender": true,
            "type": "POST" ,
            data: function ( d ) {
                d.tglawal = tglawal_Search;
                d.tglakhir = tglakhir_Search;  
                } 
        },
        "columns": [
            { "data": "id" },  
            { "data": "NoOrder" },  
            { "data": "tgltransaksi" },  
            { "data": "NamaPegawaiPencairan" },  
            { "data": "Keterangan" },  
            { "data": "NominalPencairan" }, 
            { "data": "statustransaski" },
            { "data": "statustransaski" },
             
        ]
    });
    $(".preloader").fadeOut();
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

function ShowFormPencairan(params) {
    const base_url = window.location.origin;
     
    var str = btoa(params);
    console.log(params,str);
     window.location = base_url + '/SIKBREC/public/PencairanKasbon/EntriPencairan/' + str;
}
function ShowFormPenyelesaian(params) {
    const base_url = window.location.origin;
    
    var str = btoa(params);
    window.location = base_url + '/SIKBREC/public/PencairanKasbon/entripengajuanbonsementara/' + str;
}
function gocreatebonsementara() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/entripengajuanbonsementara/";
}