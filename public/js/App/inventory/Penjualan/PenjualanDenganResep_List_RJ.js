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
            "url": base_url + "/SIKBREC/public/aPenjualanDenganResep/viewOrderResepbyDatePeriodeRajal",
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
            "url": base_url + "/SIKBREC/public/aPenjualanDenganResep/getSalesbyPeriodeResepRajal",
            "type":"POST",
            "data": {
                tglawal: tglawal,
                tglakhir: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            { "data": "NoResep" },
            { "data": "NoResep" },
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
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var proses = '';
                    if (row.StatusAntrean == 'PROCESSED'){
                        if (row.DatePacked != null){
                            var proses = '(DIKEMAS)';
                        }else if (row.DateChecked != null){
                            var proses = '(DIPERIKSA)';
                        }else if (row.DateTaken != null){
                            var proses = '(DIAMBIL)';
                        }
                    }
                    var html = '<font size="1"> ' + row.StatusAntrean + ' \n '+ proses+'</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    if (row.StatusAntrean == 'FINISHED'){
                        var btn_panggil = '<button type="button" class="btn-maroon  btn-xs" onclick=\'callPasien("' + row.UnitSales + '","' + row.NoRegistrasi + '","' + row.NamaPembeli + '")\' >Panggil</button>';
                    }else{
                        var btn_panggil = ''
                    }
                    var html = '<button type="button" class="btn-maroon btn-xs"  onclick=showPenjualanBarangDenganResepView("' + row.NoResep + '","' + row.TransactionCode + '") >View</button>&nbsp'+btn_panggil
                    return html
                },
            },
        ],
        'columnDefs': [
            {
               'targets': 0,
               'checkboxes': {
                  'selectRow': true
               }
            }
         ],
         'select': {
            'style': 'multi'
         },
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

function BtnActionAntrian(thisid){
    var table = $('#tbl_arsip').DataTable();
    var form = $("#form_arsipresep");
    var id = $(thisid).attr("id");
    var name_elm = $(thisid).attr("name");

    // Remove added elements
    $('input[name="iddetail\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'iddetail[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }
    //Swal
    swal({
        title: "Warning",
        text: "Apakah anda yakin yang dipilih ?",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    if (name_elm == 'update_verifikasi'){
                        ActionAntrianCheckbox(id);
                    }else{
                        ActionAntrianStatusCheckbox(id);
                    }
            } 
        });
}

async function ActionAntrianCheckbox(data) {
    try {
        $(".preloader").fadeIn();
        const dataUpdateDataVerifikasi = await UpdateDataVerifikasi(data);
        updateUIdataUpdateDataVerifikasi(dataUpdateDataVerifikasi);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataUpdateDataVerifikasi(params) {
    let response = params;
    var arrmsg = [];

    var status = 'success';
    var title = 'Berhasil!';
    for (let i = 0; i < response.length; ++i) {
        arrmsg.push(response[i]['message']);
        if (response[i]['status'] == false){
            var status = 'warning';
            var title = 'Mohon dicek kembali!';
        }
    }
    var msgs = arrmsg.join("\r\n");
    swal({
        title: title,
        text: msgs,
        icon: status,
    })
}

async function UpdateDataVerifikasi(data) {
    var form = $("#form_arsipresep").serialize();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aAntrianCaller/UpdateDataVerifikasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
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


async function ActionAntrianStatusCheckbox(data) {
    try {
        $(".preloader").fadeIn();
        const datas = await goActionAntrianStatusCheckbox(data);
        updateUIdataUpdateDataVerifikasi(datas);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function goActionAntrianStatusCheckbox(data) {
    var form = $("#form_arsipresep").serialize();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aAntrianCaller/UpdateAntrianFarmasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
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
