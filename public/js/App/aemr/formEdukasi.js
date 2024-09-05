$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    asyncShowFormEdukasi();
    asyncShowTableEdukasiLanjutan();

    $('#btn_modaledukasilanjutan').click(function () {
        $("#emr_id_edukasilanjutan").val('');
        $("#emr_tgl_edukasilanjutan").val('');
        $("#emr_materi_edukasilanjutan").val('');
        $("#emr_penerima_edukasilanjutan").val('');
        $("#emr_edukator_edukasilanjutan").val('');
        $("#emr_evaluasi_edukasilanjutan").val('');
        $("#modaledukasilanjutan").modal('show');
    });
});

async function asyncShowMain(){
    try{
        const datagetPasienByNoReg = await getPasienByNoReg();
        updateUIdatagetPasienByNoReg(datagetPasienByNoReg);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getPasienByNoReg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
            
        })
}
function updateUIdatagetPasienByNoReg(datagetPasienByNoReg) {
    let datapasien = datagetPasienByNoReg;
    $("#emr_nama").val(datapasien.data.PatientName);
    $("#emr_norm").val(datapasien.data.NoMR);
    $("#emr_tgllahir").val(datapasien.data.Date_of_birth);
    $("#emr_jeniskelamin").val(datapasien.data.Gander);

    $("#emr_mr_edukasilanjutan").val(datapasien.data.NoMR);
    $("#emr_noreg_edukasilanjutan").val(datapasien.data.NoRegistrasi);
}

async function asyncShowFormEdukasi(){
    try{
        const datagetFormEdukasiByNoreg = await getFormEdukasiByNoreg();
        updateUIdatagetFormEdukasiByNoreg(datagetFormEdukasiByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getFormEdukasiByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getFormEdukasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
            
        })
}
function updateUIdatagetFormEdukasiByNoreg(datagetFormEdukasiByNoreg) {
    let datadedukasi = datagetFormEdukasiByNoreg;
    $("#emr_tambahanmateridokter").val(datadedukasi.data.Tambahan_Materi_Dokter);
    $("#emr_tglmateridokter").val(datadedukasi.data.Tgl_Materi_Dokter);
    $("#emr_metodemateridokter").val(datadedukasi.data.Metode_Materi_Dokter);
    $("#emr_evaluasimateridokter").val(datadedukasi.data.Evaluasi_Materi_Dokter);
    $("#emr_edukatormateridokter").val(datadedukasi.data.Edukator_Materi_Dokter);
    $("#emr_penerimamateridokter").val(datadedukasi.data.Penerima_Materi_Dokter);
    $("#emr_tambahanmaterinutrisi").val(datadedukasi.data.Tambahan_Materi_Nutrisi);
    $("#emr_tglmaterinutrisi").val(datadedukasi.data.Tgl_Materi_Nutrisi);
    $("#emr_metodematerinutrisi").val(datadedukasi.data.Metode_Materi_Nutrisi);
    $("#emr_evaluasimaterinutrisi").val(datadedukasi.data.Evaluasi_Materi_Nutrisi);
    $("#emr_edukatormaterinutrisi").val(datadedukasi.data.Edukator_Materi_Nutrisi);
    $("#emr_penerimamaterinutrisi").val(datadedukasi.data.Penerima_Materi_Nutrisi);
    $("#emr_tglmaterinyeri").val(datadedukasi.data.Tgl_Materi_Nyeri);
    $("#emr_metodematerinyeri").val(datadedukasi.data.Metode_Materi_Nyeri);
    $("#emr_evaluasimaterinyeri").val(datadedukasi.data.Evaluasi_Materi_Nyeri);
    $("#emr_edukatormaterinyeri").val(datadedukasi.data.Edukator_Materi_Nyeri);
    $("#emr_penerimamaterinyeri").val(datadedukasi.data.Penerima_Materi_Nyeri);
    $("#emr_tambahanmaterifarmasi").val(datadedukasi.data.Tambahan_Materi_Farmasi);
    $("#emr_tglmaterifarmasi").val(datadedukasi.data.Tgl_Materi_Farmasi);
    $("#emr_metodematerifarmasi").val(datadedukasi.data.Metode_Materi_Farmasi);
    $("#emr_evaluasimaterifarmasi").val(datadedukasi.data.Evaluasi_Materi_Farmasi);
    $("#emr_edukatormaterifarmasi").val(datadedukasi.data.Edukator_Materi_Farmasi);
    $("#emr_penerimamaterifarmasi").val(datadedukasi.data.Penerima_Materi_Farmasi);
    $("#emr_tentangmateriperawat").val(datadedukasi.data.Tentang_Materi_Perawat);
    $("#emr_tambahanmateriperawat").val(datadedukasi.data.Tambahan_Materi_Perawat);
    $("#emr_tglmateriperawat").val(datadedukasi.data.Tgl_Materi_Perawat);
    $("#emr_metodemateriperawat").val(datadedukasi.data.Metode_Materi_Perawat);
    $("#emr_evaluasimateriperawat").val(datadedukasi.data.Evaluasi_Materi_Perawat);
    $("#emr_edukatormateriperawat").val(datadedukasi.data.Edukator_Materi_Perawat);
    $("#emr_penerimamateriperawat").val(datadedukasi.data.Penerima_Materi_Perawat);
    $("#emr_tglmateriisolasi").val(datadedukasi.data.Tgl_Materi_Isolasi);
    $("#emr_metodemateriisolasi").val(datadedukasi.data.Metode_Materi_Isolasi);
    $("#emr_evaluasimateriisolasi").val(datadedukasi.data.Evaluasi_Materi_Isolasi);
    $("#emr_edukatormateriisolasi").val(datadedukasi.data.Edukator_Materi_Isolasi);
    $("#emr_penerimamateriisolasi").val(datadedukasi.data.Penerima_Materi_Isolasi);
}

async function BtnSimpanData(){
    try{
        const dataSaveFormEdukasi = await SaveFormEdukasi();
        updateUIdataSaveFormEdukasi(dataSaveFormEdukasi);
    }catch{
        toast(err.message, "error")
    }
}
function SaveFormEdukasi() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var mr_pasien = $("#emr_norm").val();
    var form_edukasi= $("#form_edukasi").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/setFormEdukasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'noreg_pasien=' +  noreg_pasien +
                '&mr_pasien=' + mr_pasien +
                '&form_edukasi=' + form_edukasi 
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
            
        })
}
function updateUIdataSaveFormEdukasi(dataSaveFormEdukasi) {
    let dataformedukasi = dataSaveFormEdukasi;
    if (dataformedukasi.status == "success") {
        swal("DATA FORM EDUKASI",  "BERHASIL DISIMPAN", "success");
        asyncShowWakilPasien();
    }else{
        toast(response.message, "error")
    }
}

async function btnSaveModalEdukasiLanjutan(){
    try{
        const dataSaveModalEdukasiLanjutan = await SaveModalEdukasiLanjutan();
        updateUIdataSaveModalEdukasiLanjutan(dataSaveModalEdukasiLanjutan);
    }catch{
        toast(err.message, "error")
    }
}
function SaveModalEdukasiLanjutan() {
    var base_url = window.location.origin;
    var form_edukasilanjutan = $("#form_edukasilanjutan").serialize();

    let url = base_url + '/SIKBREC/public/aEMR/setSaveEdukasiLanjutan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_edukasilanjutan
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
            
        })
}
function updateUIdataSaveModalEdukasiLanjutan(dataSaveModalEdukasiLanjutan) {
    let datamodaledukasilanjutan = dataSaveModalEdukasiLanjutan;
    if (datamodaledukasilanjutan.status == "success") {
        swal("Transaksi Form Edukasi Lanjutan",  "BERHASIL DISIMPAN", "success");
        asyncShowTableEdukasiLanjutan();
        $('#modaledukasilanjutan').modal('hide');

    }else{
        toast(response.message, "error")
    }
}

function asyncShowTableEdukasiLanjutan() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_formedukasi_lanjutan').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_formedukasi_lanjutan').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataTableEdukasiLanjutan", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg_pasien = noreg_pasien
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "ID" },
                            { "data": "Tgl_Edukasi" },
                            { "data": "Materi_Edukasi" },
                            { "data": "Penerima_Edukasi" },
                            { "data": "Edukator_Edukasi" },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.Evaluasi_Edukasi == "Sudah Mengerti"){ 
                                      var cek1  = '✓'
                                  }else{
                                    var cek1  = ''
                                  }
                                  var html = '<span>'+cek1+'</span>'
                                     return html 
                              }
                            },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.Evaluasi_Edukasi == "Edukasi Ulang"){ 
                                      var cek1  = '✓'
                                  }else{
                                    var cek1  = ''
                                  }
                                  var html = '<span>'+cek1+'</span>'
                                     return html 
                              }
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
        'order' : [1,'asc']
     });
}

function BtnBtlEdukasiLanjutan(thisid){
    var table = $('#tbl_formedukasi_lanjutan').DataTable();
    var form = $("#form_edukasi_lanjutan");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idedukasilanjutan\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idedukasilanjutan[]')
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
        text: "Pastikan menceklis data sesuai yang akan di hapus !",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    BtlEdukasiLanjutan(id);
            } 
        });
}
async function BtlEdukasiLanjutan(data) {
    try {
        const dataBtlEdukasiLanjut = await BtlEdukasiLanjut(data);
        updateUIdataBtlEdukasiLanjut(dataBtlEdukasiLanjut);
    } catch (err) {
        toast(err.message, "error")
    }
}

function BtlEdukasiLanjut(data) {
    var form = $("#form_edukasi_lanjutan").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/setBatalEdukasiLanjutan';
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
function updateUIdataBtlEdukasiLanjut(params) {
    let dataparams = params;
    if (dataparams.status == "success") {
        swal("Transaksi Edukasi Lanjutan",  "BERHASIL DIHAPUS", "success");
        asyncShowTableEdukasiLanjutan();
    }else{
        toast(response.message, "error")
    }
}

async function btnCloseModalEdukasiLanjutan(){
    $('#modaledukasilanjutan').modal('hide');
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

function convertBoleanToBit($data) {
    var convertboleanbit = $data ? 1 : 0;
    return convertboleanbit;
}

function convertBitToBolean($data) {
    // var convertbitbolean = $data ? true : false;
    // return convertbitbolean;
    var convertbitbolean = $data;
    if(convertbitbolean == "1"){
        convertbitbolean = true;
    }
    else{
        convertbitbolean = false;
    }
    return convertbitbolean;
}
