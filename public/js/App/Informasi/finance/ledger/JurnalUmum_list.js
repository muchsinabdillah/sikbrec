$(document).ready(function () {
    onloadForm();
});
function goJurnalBaru() {
    // console.log ("sssss")
    // return false
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/JurnalUmum/ViewJurnalUmum/";
}
function showEdit(id) {
       const base_url = window.location.origin;
       var id = btoa(id);
    window.location = base_url + "/SIKBREC/public/JurnalUmum/ViewJurnalUmum/" + id;
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
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/JurnalUmum/getDataListDataJurnalUmum",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "No_Jurnal" },
            { "data": "Tanggal" },
            { "data": "Jumlah" },
            { "data": "Keperluan" },
            { "data": "Petugas" },
            // { "data": "Action" },
       
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick=showEdit("' + row.No_Jurnal + '") > <span class="glyphicon glyphicon-log-in"></span>'
                    return html
                },
            },
            
        ]
    });
}