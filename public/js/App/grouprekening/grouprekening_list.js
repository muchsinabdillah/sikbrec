$(document).ready(function () {
    onloadForm();
});
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
            "url": base_url + "/SIKBREC/public/MasterGroupRekening/getAll/",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "ID" },
            { "data": "Nama" } 
            
        ]
    });
}