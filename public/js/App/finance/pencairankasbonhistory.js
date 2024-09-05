$(document).ready(function () {
    shwoOutstandingPencairan(); 
});
function shwoOutstandingPencairan() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PencairanKasbon/showHistoryPencairan",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [
            { "data": "ID" },
            { "data": "noorder" },
            { "data": "norealisasi" },
            { "data": "TglOrder" },
            { "data": "tglRealisai" },
            { "data": "Nama" },
            { "data": "Keterangan" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NIlaiOrder + '  </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NilaiRealisasi + '  </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TipeKasbon + '  </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowFormPencairan(' + row.ID + ')" ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
} 
// Primary function always
function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[status](data);
}

function ShowFormPencairan(params) {
    const base_url = window.location.origin;

    var str = btoa(params);
    console.log(params, str);
    window.location = base_url + '/SIKBREC/public/PencairanKasbon/EntriPencairan/' + str;
}
function ShowFormPenyelesaian(params) {
    const base_url = window.location.origin;

    var str = btoa(params);
    window.location = base_url + '/SIKBREC/public/PencairanKasbon/EntriPenyelesaian/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/EntriPencairan/";
}