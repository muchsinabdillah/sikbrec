$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(18);
    await showdatatabel();
}
function showdatatabel() { 
    var base_url = window.location.origin;
    $('#tbllistData').DataTable().clear().destroy();
    $('#tbllistData').DataTable({
        "ordering": true,
        "order": [[ 1, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyDateUser/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST" 
        },
        "columns": [ 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransactionCode + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransasctionDate + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUserCreate + '</font>  ';
                    return html
                }
            },
              {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUnit + '</font>  ';
                    return html
                }
            },
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
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Notes + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                        var html = 'Total Barang: '+row.TotalRow+'<br>Total Qty: '+row.TotalQty;
                   
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.Approved == '1'){
                        var html = '<span class="badge badge-success">'+row.StatusPR+'</span><br>Tgl Approve: '+row.DateApproved+'<br>'+'User Approve: '+row.namaUserApproved;
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
                    var html = '<button type="button" class="btn btn-maroon btn-animated btn-xs btn-rounded"  onclick=\'showPurchase("' + row.TransactionCode + '")\'    ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
function showPurchase(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/PurchaseForm/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PurchaseForm/";
}