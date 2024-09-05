$(document).ready(function () {
    $(".preloader").fadeOut();
})



function inputreservasi() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/udd/";
}

function loaddataListUDD() {
    var base_url = window.location.origin;
    var tglawal =   $("#tglAwalReservasi").val();
    var tglakhir =   $("#tglAkhirReservasi").val();
    $('#tbl_aktif_listudd2').DataTable().clear().destroy();
    $('#tbl_aktif_listudd2').DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/Udd/getlistDataUddAll",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal = tglawal;
                d.tglakhir = tglakhir;
            }
        },
        "columns": [
            { "data": "ID" },
            { "data": "ID_RESEP" },
            { "data": "PatientName" },
            { "data": "TGL_ENTRY" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = 'Tanggal : ' + row.TGL_DIBERIKAN + 'Jam : ' + row.JAM_DIBERIKAN + 'Waktu : ' + row.WAKTU_DIBERIKAN  
                    return html
                }
            },
            { "data": "USER_ENTRI" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showdetil("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-eye-open"></span></button> | <button class="btn btn-danger"  id="buttonedit" name="buttonedit" onclick=\'PrintLabelPasien("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-print"></span></button> '
                    return html
                }
            },

        ]
    });
}
function PrintLabelPasien(idParams) {
    var notrs = btoa(idParams);
    var base_url = window.location.origin;
    window.open(base_url + "/SIKBREC/public/Udd/PrintLabelUDD/" + notrs, "_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}
function showdetil(params) {
    var str = btoa(params);
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Udd/" + str;
}