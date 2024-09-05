$(document).ready(function () {
    onloadForm();
});
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataTarif/viewtransaksitarif/' + str;
}

function viewtransaksitarifdetail(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataTarif/viewtransaksitarifdetail/' + str;
}



function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataTarif/viewtransaksitarif/";
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
            "url": base_url + "/SIKBREC/public/MasterDataTarif/getListDataTransaksiTarif",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID_TR_TARIF + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TGL_ENTRY + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.username + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NOTE + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglBerlaku + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglExpired + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    if(row.BATAL == "0"){ 
                        var html  = '<span class="badge badge-success">Aktif</span> '
                    }else if(row.BATAL == "1"){ // Jika bukan 1
                        var html  = '<span class="badge badge-danger">Batal</span> '
                    }
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick=\'showDataGroupShift("'+row.ID_TR_TARIF+'")\') >Edit</button>&nbsp<button type="button" class="btn btn-info btn-xs"  onclick=\'viewtransaksitarifdetail("'+row.ID_TR_TARIF+'")\') >Detail</button>'
                    return html
                },
            },
        ]
    });
}