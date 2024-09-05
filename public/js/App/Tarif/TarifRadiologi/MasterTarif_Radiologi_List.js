$(document).ready(function () {
    onloadForm();
});
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataTarif/viewradiologi/' + str;
}
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataTarif/viewradiologi/";
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
            "url": base_url + "/SIKBREC/public/MasterDataTarif/getListDataTarifRadiologi",
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
                    var html = '<font size="1"> ' + row.NamaProduk + ' </font>  ';
                    return html
                }
            },
            // { "data": "TarifRS" ,  render: $.fn.dataTable.render.number( '.', ',', 0 )},
            // {
            //     "render": function (data, type, row) { // Tampilkan kolom aksi
            //         var html = ""
            //         var html = '<font size="1"> ' + row.Group_Jaminan + ' </font>  ';
            //         return html
            //     }
            // },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    if(row.discontinue == "0"){ 
                        var html  = '<span class="badge badge-success">Aktif</span> '
                    }else if(row.discontinue == "1"){ // Jika bukan 1
                        var html  = '<span class="badge badge-danger">Tidak Aktif</span> '
                    }
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showDataGroupShift(' + row.ID + ')" >Edit</button>'
                    return html
                },
            },
        ]
    });
}