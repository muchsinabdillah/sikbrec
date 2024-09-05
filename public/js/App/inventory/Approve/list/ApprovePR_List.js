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
    window.location = base_url + '/SIKBREC/public/InventoryApprove/ViewApprovePR/' + str;
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
            "url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyPeriode",
            "type": "POST",
            "data": {
                tglawal_pr: tglawal,
                tglakhir_pr: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            { "data": "TransactionCode" },
            { "data": "TransasctionDate" },
            { "data": "NamaUserCreate" },
            { "data": "NamaUnit" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.Type == '1'){
                        var jenispr = 'FARMASI';
                    }else{
                        var jenispr = 'LOGISTIK';
                    }
                    var html = '<font size="1"> ' + jenispr + '</font>  ';
                    return html
                }
            },
            { "data": "Notes" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                        var html = 'Jumlah Barang: '+row.TotalRow+'<br>Jumlah Qty: '+row.TotalQty;
                   
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.Approved == '1'){
                        var html = '<span class="badge badge-success">'+row.StatusPR+'</span><br>Tgl Approve: '+row.DateApproved+'<br>'+'User Approve: '+row.NamaUserCreate;
                    }else{
                        var html = '<span class="badge badge-danger">'+row.StatusPR+'</span>';
                    }
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDataByID("' + row.TransactionCode + '") ><span class="visible-content" >View</span>'
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