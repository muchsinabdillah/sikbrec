$(document).ready(function () {
    onloadForm();
});
function showInputData(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataJenisBarang/viewMasterJenisBarang/' + str;
}
function showInputDatanew() {
    const base_url = window.location.origin;
    window.location = base_url + '/SIKBREC/public/MasterDataJenisBarang/viewMasterJenisBarang/';
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
            "url": base_url + "/SIKBREC/public/MasterDataJenisBarang/showJenisAll/",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "ID" },
            { "data": "NamaJenis" },
                      
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showInputData(' + row.ID + ')" ><span class="visible-content" >Edit</span>'
                    return html
                },
            },
            
        ]
    });
}