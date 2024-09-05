$(document).ready(function () {
    showdatatabel();
});
function showInputTukarFaktur(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/TukarFaktur/index/' + str;
}
function showInputTukarFakturnew() {
    const base_url = window.location.origin;
    // var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/TukarFaktur/index/' ;
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
            "url": base_url + "/SIKBREC/public/TukarFaktur/getFakturbyDateUser",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "TransactionCode" },
            { "data": "TransactionDate" },
            { "data": "NamaUser" },
            { "data": "NamaSupplier" },
            { "data": "Keterangan" },
            
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick=showInputTukarFaktur("' + row.TransactionCode + '") ><span class="visible-content" >View</span>'
                    return html
                },
            },
            
        ]
    });
}