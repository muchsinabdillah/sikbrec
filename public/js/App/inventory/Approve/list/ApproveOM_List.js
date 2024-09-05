$(document).ready(function () {
    $('#example').DataTable()
    $(".preloader").fadeOut();

    $('#btnSearching').click(function () {
        showdatatabel();
    });
});
function ShowDataByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/InventoryApprove/ViewApproveOM/' + str;
}

function showdatatabel() {
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();

    if (tglawal == '') {
        toast('Silahkan Isi Periode Awal !', 'warning')
        return false;
    }

    if (tglakhir == '') {
        toast('Silahkan Isi Periode Akhir !', 'warning')
        return false;
    }
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/OrderMutasiBarang/getOrderMutasibyPeriode",
            "type": "POST",
            "data": {
                tglawal: tglawal,
                tglakhir: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransactionCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransactionDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUserCreate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Notes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JenisMutasi + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    if (row.Approved == '1'){
                        var element = 'success';
                    }else{
                        var element = 'danger';
                    }
                    var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                },
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.namaUserApproved + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""

                    // if (row.Approved == '0'){
                    //     var approve = 'disabled';
                    // }else{
                        var approve = '';
                    //}
                    var html = '<button type="button" class="btn btn-maroon btn-xs"  onclick=ShowDataByID("' + row.TransactionCode + '")'+approve+'>View</button>'
                    return html
                },
            },
            
        ]
    });
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