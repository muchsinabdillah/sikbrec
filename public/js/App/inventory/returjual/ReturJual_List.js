$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    //await getHakAksesByForm(18);
    showdatatabel();
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
            "url": base_url + "/SIKBREC/public/ReturJual/getReturJualbyDateUser",
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
                    var html = '<font size="1"> ' + row.SalesCode + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.NamaUnitOrder + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoResep + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TotalQtyReturJual + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.NamaUserCreate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-animated btn-rounded btn-xs"  onclick=viewReturBeli("' + row.TransactionCode + '") ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function viewReturBeli(str = null) {
    const base_url = window.location.origin;
    if (str == null){
        window.location = base_url + '/SIKBREC/public/ReturJual/';
        return false;
    }
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/ReturJual/' + str;
}