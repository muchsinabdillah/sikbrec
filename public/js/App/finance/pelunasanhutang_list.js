$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(18);
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({ 
            "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]],
        "ajax": {
            "url": base_url + "/ESIRYARSI/public/Hutang/getListPelunasanHutang",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.KD_TRS_PAY + ' </font>  ';
                    return html
                }
            }, 

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.KD_TRS_ORDER + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TGL_PAY + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PETUGAS + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PERIODE + ' </font>  ';
                    return html
                }
            }, 
            { "data": "TOTAL" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-sm btn-rounded btn-maroon btn-animated btn-wide btn-xs"  onclick=showOrderMutasiBarang("' + row.KD_TRS_PAY + '") ><span class="visible-content" >View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function showOrderMutasiBarang(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/ESIRYARSI/public/Hutang/PelunasanHutang/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/ESIRYARSI/public/Hutang/PelunasanHutang";
}