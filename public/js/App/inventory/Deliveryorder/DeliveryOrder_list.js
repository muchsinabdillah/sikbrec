$(document).ready(function () {
    onloadForm();
});
function showInputDeliveryOrder(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/DeliveryOrder/index/' + str;
}
function showInputDeliveryOrdernew() {
    const base_url = window.location.origin;
    // var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/DeliveryOrder/index/' ;
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
        "ajax": {
            "url": base_url + "/SIKBREC/public/DeliveryOrder/showDeliveryOrderbyUser",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "TransactionCode" },
            { "data": "PurchaseOrderCode" },
            { "data": "DeliveryOrderDate" },
            { "data": "NamaUser" },
            { "data": "NamaSupplier" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                        var html = 'Total Barang: '+row.TotalRowDO+'<br>Total Qty: '+row.TotalQtyDO+'<br>Subtotal Purchase: '+new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR"}).format(row.GrandtotalDelivery);
                   
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            { "data": "Notes" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-rounded btn-xs"  onclick=showInputDeliveryOrder("' + row.TransactionCode + '") ><span class="visible-content" >View</span>'
                    return html
                },
            },
            
        ]
    });
}