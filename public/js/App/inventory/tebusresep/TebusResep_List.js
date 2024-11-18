$(document).ready(function () {
    //onloadForm();
    $('#example').dataTable({
    })
    $('#tbl_arsip').dataTable({
    })
    $(".preloader").fadeOut();

    $('#btnSearching').click(function () {
        showdatatabel();
    });

    $('#btnSearchArsip').click(function () {
        showdatatabelArsip();
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
            "url": base_url + "/SIKBREC/public/aTebusResep/viewOrderResepbyDatePeriodeTebus",
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
                    var html = '<font size="1"> ' + row.OrderID + ' </font>  ';
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
                    var html = '<button type="button" class="btn btn-maroon btn-rounded btn-sm"  onclick=showPenjualanBarangDenganResep("' + row.OrderID + '") >View</button>'
                    return html
                },
            },
        ]
    });
}

function showdatatabelArsip() {
    var tglawal = $("#tglAwal_arsip").val();
    var tglakhir = $("#tglAkhir_arsip").val();

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
    $('#tbl_arsip').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_arsip').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPenjualanDenganResep/getSalesbyPeriodeResep",
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
                    var html = '<font size="1"> ' + row.TransactionCode + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.NamaPembeli + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.TransactionDate + ' </font>  ';
                    return html
                }
            },
            // {
            //     "render": function (data, type, row) { // Tampilkan kolom aksi
            //         var html = ""
            //         var html = '<font size="1"> ' + row.NamaDokter + ' </font>  ';
            //         return html
            //     }
            // },
            // {
            //     "render": function (data, type, row) { // Tampilkan kolom aksi
            //         var html = ""
            //         var html = '<font size="1"> ' + row.JenisPasien + ' </font>  ';
            //         return html
            //     }
            // },
            // {
            //     "render": function (data, type, row) { // Tampilkan kolom aksi
            //         var html = ""
            //         var html = '<font size="1"> ' + row.JenisResep + ' </font>  ';
            //         return html
            //     }
            // },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-maroon btn-rounded btn-sm"  onclick=showPenjualanBarangDenganResepView("' + row.NoResep + '","' + row.TransactionCode + '") >View</button>'
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
    window.open(base_url + '/SIKBREC/public/aTebusResep/' + str , "_blank");
}

function showPenjualanBarangDenganResepView(str,trscode) {
    const base_url = window.location.origin;
    var str = btoa(str);
    var trscode = btoa(trscode);
    window.open(base_url + '/SIKBREC/public/aTebusResep/ViewOrder/' + str +'/'+trscode , "_blank");
}

function showPenjualanBarangDenganResepView(str,trscode) {
    const base_url = window.location.origin;
    var str = btoa(str);
    var trscode = btoa(trscode);
    window.open(base_url + '/SIKBREC/public/aTebusResep/ViewOrder/' + str +'/'+trscode , "_blank");
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aTebusResep/";
}

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