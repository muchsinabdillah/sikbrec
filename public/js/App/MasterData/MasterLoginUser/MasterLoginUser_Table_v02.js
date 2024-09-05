$(document).ready(function () {
    onloadForm();
    

});  
function showMasterHakAksesLoginByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterLoginUser/UserLoginHakAkses/' + str;
}
function showMasterLoginByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterLoginUser/UserLoginForm/' + str;
} 
function showSignatureByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterLoginUser/UserSignature/' + str;
} 
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterLoginUser";
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterLoginUser/UserLoginForm";
}

async function onloadForm() {
    await getHakAksesByForm(3);
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "order": [[0, "desc"]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterLoginUser/getAllUserLogin",
            "dataSrc": "",
            "type": "POST",
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
                    var html = '<font size="1"> ' + row.Username + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaLengkap + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaLengkap + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="showMasterLoginByID(' + row.ID + ')"  >View</button> | <button title="Show Data" type="button" class="btn btn-sm btn-warning" id="btn_showkasbon" onclick="showMasterHakAksesLoginByID(' + row.ID + ')"  >Hak Akses</button> | <button title="Show Data" type="button" class="btn btn-sm btn-info" id="btn_showkasbon" onclick="showSignatureByID(' + row.ID + ')"  >Signature</button>'
                    return html
                },
            },
        ]
    });
}