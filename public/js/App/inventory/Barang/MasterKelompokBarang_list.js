$(document).ready(function () {
    onloadForm();
});
function showInputData(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterKelompokBarang/viewMasterKelompokBarang/' + str;
}
function AddNewKelompok() {
    const base_url = window.location.origin;
    window.location = base_url + '/SIKBREC/public/MasterKelompokBarang/viewMasterKelompokBarang/';
}
async function onloadForm() {
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example2').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterKelompokBarang/showkelompokBarangAll/",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "KelompokCode" },
            { "data": "KelompokName" }, 
           
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs" onclick=\'showInputData("' + row.KelompokCode +'")\'   ><span class="visible-content" >Edit</span>'
                    return html
                },
            },
            
        ]
    });
}