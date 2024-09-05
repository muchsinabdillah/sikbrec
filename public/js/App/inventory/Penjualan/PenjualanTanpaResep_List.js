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
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPenjualanTanpaResep/getSalesbyDateUser",
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
                    var html = '<font size="1"> ' + row.NoResep + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.NoRegistrasi + ' </font>  ';
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
                    // if (row.Group_Transaksi == 'RESEP'){
                    //     var html = '<button type="button" class="btn-rounded btn-maroon btn-sm"  onclick=showPenjualanBarangDenganResep("' + row.TransactionCode + '") > View </button>'
                    // }else{
                        var html = '<button type="button" class="btn-rounded btn-maroon btn-sm"  onclick=showPenjualanBarangTanpaResep("' + row.TransactionCode + '") > View </button>'
                    //}
                    return html
                },
            },
        ]
    });
}
function showPenjualanBarangDenganResep(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aPenjualanDenganResep/' + str;
}

function showPenjualanBarangTanpaResep(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aPenjualanTanpaResep/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanTanpaResep/";
        // $("#IDMedrec").val(nomr);
        //$('#myModal').modal('show');
}