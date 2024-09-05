$(document).ready(function () {
    // onloadForm();
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    $('#example').DataTable({});
    $(document).on('click', '#btnLoad', function () {
        showdatatabel(); 
        asyncShowMain();

    });
});

async function asyncShowMain() {
    // await showdatatabel();
    toast('SudahdiKlaim', "success")
}
function showdatatabel() {
    let jenis_rawat, date_type ,start_dt, stop_dt;
    jenis_rawat = $("#jenis_rawat").val();
    date_type = $("#date_type").val();
    start_dt = $("#start_dt").val();
    stop_dt = $("#stop_dt").val();
        const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/KirimData",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                d.jenis_rawat = jenis_rawat;
                d.date_type = date_type;
                d.start_dt = start_dt;
                d.stop_dt = stop_dt;
               
            },
            "deferRender": true,
        },
        "columns": [

            // { "data": "No" },
             { "data": "tgl_pulang" },
            { "data": "nomor_sep" },
            { "data": "kemkes_dc_status" },
            //{ "data": "Tgl_pulang" },
            // { "data": "SEP" },
                       
            
        ]
    });
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
