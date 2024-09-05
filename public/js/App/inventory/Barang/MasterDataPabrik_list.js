$(document).ready(function () {
    onloadForm();
});
function showInputDataPabrik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataPabrik/viewMasterPabrik/' + str;
}
function showInputDataPabriknew() {
    const base_url = window.location.origin;
    // var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataPabrik/viewMasterPabrik/' ;
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
            "url": base_url + "/SIKBREC/public/MasterDataPabrik/showPabrikAll",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "ID" },
            { "data": "Nama" },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showInputDataPabrik(' + row.ID + ')" ><span class="visible-content" >Edit</span>'
                    return html
                },
            },
            
        ]
    });
}