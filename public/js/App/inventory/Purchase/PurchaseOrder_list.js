$(document).ready(function () {
    onloadForm();
});
function showInputPurchaseOrder(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/Purchase/index/' + str;
}
function showInputPurchaseOrdernew() {
    const base_url = window.location.origin;
    // var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/Purchase/index/' ;
}

async function onloadForm() {
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/purchase/showPurchaseOrderAll",
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
            
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=showInputPurchaseOrder("' + row.PurchaseCode + '") ><span class="visible-content" >View</span>'
                    return html
                },
            },
            
        ]
    });
}