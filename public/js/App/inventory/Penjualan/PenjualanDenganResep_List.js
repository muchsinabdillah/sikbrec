$(document).ready(function () {
    //onloadForm();
    $('#example').dataTable({
    })
    $(".preloader").fadeOut();

    $('#btnSearching').click(function () {
        showdatatabel();
    });
});
// async function onloadForm() {
//     await getHakAksesByForm(18);
//     await showdatatabel();
// }
function showdatatabel() {
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();

    if (tglawal == '') {
        toast('Silahkan Isi Periode Awal !', 'warning')
        return false;
    }

    if (tglakhir == '') {
        toast('Silahkan Isi Periode Akhir !', 'warning')
        return false;
    }
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPenjualanDenganResep/viewOrderResepbyDatePeriode",
            "type":"POST",
            "data": {
                tglawal: tglawal,
                tglakhir: tglakhir
            },
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
                    var html = '<font size="1"> ' + row.NoMR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PatientName + ' </font>  ';
                    return html
                }
            }, 

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoRegistrasi + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglResep + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaDokter + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JenisPasien + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JenisResep + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-rounded btn-sm"  onclick=showPenjualanBarangDenganResep("' + row.ID + '") >View</button>'
                    return html
                },
            },
        ]
    });
}
function showPenjualanBarangDenganResep(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    //window.location = base_url + '/SIKBREC/public/aPenjualanDenganResep/' + str;
    window.open(base_url + '/SIKBREC/public/aPenjualanDenganResep/' + str , "_blank");
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanDenganResep/";
}