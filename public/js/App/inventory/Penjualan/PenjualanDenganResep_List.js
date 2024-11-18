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
                    var html = '<button type="button" class="btn-maroon btn-xs"  onclick=showPenjualanBarangDenganResepView("' + row.NoResep + '","' + row.TransactionCode + '") >View</button>&nbsp<button type="button" class="btn-maroon  btn-xs" onclick=\'callPasien("' + row.UnitSales + '","' + row.NoRegistrasi + '","' + row.NamaPembeli + '")\' >Panggil</button>&nbsp<button type="button" class="btn-maroon  btn-xs" onclick=\'finishAntrian("' + row.NoResep + '","' + row.NoRegistrasi + '")\' >Panggil</button>'
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

function showPenjualanBarangDenganResepView(str,trscode) {
    const base_url = window.location.origin;
    var str = btoa(str);
    var trscode = btoa(trscode);
    window.open(base_url + '/SIKBREC/public/aPenjualanDenganResep/ViewOrder/' + str +'/'+trscode , "_blank");
}

function showPenjualanBarangDenganResepView(str,trscode) {
    const base_url = window.location.origin;
    var str = btoa(str);
    var trscode = btoa(trscode);
    window.open(base_url + '/SIKBREC/public/aPenjualanDenganResep/ViewOrder/' + str +'/'+trscode , "_blank");
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanDenganResep/";
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

async function callPasien(idunit,noreg,nama){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtl = await GocallPasien(idunit,noreg,nama);
        updateUIdataGocallPasien(dataGocreateDtl);
        //showDataDetilTable();
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocallPasien(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        swal({
            title: dataResponse.message,
            text: 'Nama Pasien = '+dataResponse.data.name+'\n No. Antrian = '+dataResponse.data.NoAntrianPoli ,
            icon: "success",
        });
        toast(dataResponse.message, "success")
    }
     
}
async function GocallPasien(idunit,noreg,nama) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aAntrianCaller/gocallantrianFarmasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:     "idunit=" + idunit
                +"&noreg=" + noreg
                +"&nama=" + nama
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

async function finishAntrian(NoResep,noreg){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtl = await GofinishAntrian(NoResep,noreg);
        updateUIdataGofinishAntrian(dataGocreateDtl);
        //showDataDetilTable();
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGofinishAntrian(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        swal({
            title: dataResponse.message,
            text: 'Nama Pasien = '+dataResponse.data.name+'\n No. Antrian = '+dataResponse.data.NoAntrianPoli ,
            icon: "success",
        });
        toast(dataResponse.message, "success")
    }
     
}
async function GofinishAntrian(NoResep,noreg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aAntrianCaller/goUpdateAntrianFarmasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:     "NoResep=" + NoResep
                +"&NoRegistrasi=" + noreg
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}
