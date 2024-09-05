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
    window.location = base_url + '/SIKBREC/public/InventoryApprove/ViewApprovePO/' + str;
}

function ShowDataByID2(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/InventoryApprove/ViewApprovePO2/' + str;
}

function ShowDataByID3(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/InventoryApprove/ViewApprovePO3/' + str;
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
        "order": [2,'desc'],
        "ajax": {
            "url": base_url + "/SIKBREC/public/purchase/getPurchaseOrderbyPeriode",
            "type": "POST",
            "data": {
                tglawal_pr: tglawal,
                tglakhir_pr: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            { "data": "PurchaseCode" },
            { "data": "PurchaseReqCode" },
            { "data": "PurchaseDate" },
            { "data": "NamaUserCreate" },
            { "data": "namasupplier" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                        var html = 'Total Barang: '+row.TotalRowPO+'<br>Total Qty: '+row.TotalQtyPO+'<br>Subtotal Purchase: '+new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR"}).format(row.SubtotalPurchase);
                   
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            { "data": "Notes" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html2 = ""
                    var html3 = ""
                    if (row.DateApproved_1 != null){
                        var html = 'APPROVE 1: <span class="badge badge-success">APPROVED</span> '+row.DateApproved_1+' '+row.NamaUserApproved_1;
                    }else{
                        var html = 'APPROVE 1: <span class="badge badge-danger">WAITING</span>'
                    }
                    if (row.DateApproved_2 != null){
                        var html2 = 'APPROVE 2: <span class="badge badge-success">APPROVED</span> '+row.DateApproved_2+' '+row.NamaUserApproved_2;
                    }else{
                        var html2 = 'APPROVE 2: <span class="badge badge-danger">WAITING</span>'
                    }
                    if(row.DateApproved_3 != null){
                        var html3 = 'APPROVE 3: <span class="badge badge-success">APPROVED</span> '+row.DateApproved_3+' '+row.NamaUserApproved_3;
                    }else{
                        var html3 = 'APPROVE 3: <span class="badge badge-danger">WAITING</span>'
                    }
                    return html+'<br>'+html2+'<br>'+html3
                }
            },
            // {
            //     "render": function (data, type, row) {
            //         var html = ""
            //         if (row.Approved == '1'){
            //             var element = 'success';
            //         }else{
            //             var element = 'danger';
            //         }
            //         var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
            //         return html
            //     },
            // },
            // { "data": "UserApproved" },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    console.log(row.UserApproved_1);
                    if (row.UserApproved_1 == ' '){
                        var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDataByID("' + row.PurchaseCode + '") ><span class="visible-content" >Approve 1</span>'

                    }
                    else if (row.UserApproved_1 != ' ' && row.UserApproved_2 == ' '){
                        var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDataByID2("' + row.PurchaseCode + '") ><span class="visible-content" >Approve 2</span>'

                    }else if(row.UserApproved_1 != ' ' && row.UserApproved_2 != ' ' && row.UserApproved_3 == ' '){
                        var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDataByID3("' + row.PurchaseCode + '") ><span class="visible-content" >Approve 3</span>'
                    }
                    
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