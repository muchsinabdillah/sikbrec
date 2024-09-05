$(document).ready(function () {
    onloadForm();
});
function showInputDataBeban(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataBeban/viewMasterBeban/' + str;
}
function goInputDataBeban() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataBeban/viewMasterBeban/";
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
            "url": base_url + "/SIKBREC/public/MasterDataBeban/getListDataMasterbeban",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "ID" },
            { "data": "Nama_group_Beban" },
            { "data": "KODE_COA" },
             { "data": "AKTIF" },
                       {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showInputDataBeban(' + row.ID + ')" ><span class="visible-content" >Edit</span>'
                    return html
                },
            },
            
        ]
    });
}