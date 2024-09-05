$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#btn_loaddata').attr('disabled', false);
    $(document).on('click', '#btn_loaddata', function () {
        //checking before get data
        CheckVar();
    });
    $(document).on('click', '#passkodepox', function () {
        var row_id = $(this).attr("value");
        $("#KirimNoTagihan").val(row_id);
        var JenisBerkas =  document.getElementById("JenisBerkas").value;   

        LoadPenagihanByStatus(JenisBerkas);    
        // $('#modal_alert_Updatekirim').modal('hide');
        // $('.modal-backdrop').hide();

    });
    $(document).on('click', '#btnupdtBatalKirim', function () {
        var row_id = $(this).attr("value");
        $("#KirimNoTagihanBatalKirim").val(row_id);
        var JenisBerkas =  document.getElementById("JenisBerkas").value;   
        LoadPenagihanByStatus(JenisBerkas);    
        //  $('#modal_alert_batal_kirim').modal('show');
    });

    $(document).on('click', '#btnupdatediterima', function () {
        var row_id = $(this).attr("value");
        $("#KirimNoTagihanditerima").val(row_id);
        var JenisBerkas =  document.getElementById("JenisBerkas").value;   
        LoadPenagihanByStatus(JenisBerkas);    
        //  $('#modal_alert_UpdateDiterima').modal('hide');
    });

    $(document).on('click', '#btnBatalDikrimUpdate', function () {
         var row_id = $(this).attr("value");
         $("#KirimNoTagihanBatalDiterima").val(row_id);
         var JenisBerkas =  document.getElementById("JenisBerkas").value;   
         LoadPenagihanByStatus(JenisBerkas);    
         //  $('#modal_alert_batal_diterima').modal('show');
            
    });
        

    $(document).on('click', '#btnKirimTagihan', function () {
        var KirimNoTagihan = $("#KirimNoTagihan").val();
        var KirimPetugas = $("#KirimPetugas").val();
        var Kirimtgl = $("#Kirimtgl").val();
        var JenisBerkas =  document.getElementById("JenisBerkas").value;
        var x = "2";
        console.log(x,KirimNoTagihan,KirimPetugas,Kirimtgl,JenisBerkas);
        kirimtagihannya(); 

    });
    $(document).on('click', '#btnTrsKirim', function () {
        var KirimNoTagihan = $("#KirimNoTagihan").val();
        var KirimPetugas = $("#KirimPetugas").val();
        var Kirimtgl = $("#Kirimtgl").val();
        var JenisBerkas =  document.getElementById("JenisBerkas").value;
        var x = "2";
        console.log(x,KirimNoTagihan,KirimPetugas,Kirimtgl,JenisBerkas);
        batalkirimtagihannya(); 
    
    });
    $(document).on('click', '#btnKirimTagihanDiterima', function () {
        var KirimNoTagihanditerima = $("#KirimNoTagihanditerima").val();
        var KirimPetugasDiterima = $("#KirimPetugasDiterima").val();
        var KirimtglDiterima = $("#KirimtglDiterima").val();
        var JenisBerkas =  document.getElementById("JenisBerkas").value;
        var x = "2";
        console.log(x,KirimNoTagihanditerima,KirimPetugasDiterima,KirimtglDiterima,JenisBerkas);
        kirimtagihanditerimanya(); 
    
    });
    $(document).on('click', '#btnTrsDiterimabatal', function () {
        var KirimNoTagihanditerima = $("#KirimNoTagihanditerima").val();
        var KirimPetugasDiterima = $("#KirimPetugasDiterima").val();
        var KirimtglDiterima = $("#KirimtglDiterima").val();
        var JenisBerkas =  document.getElementById("JenisBerkas").value;
        var x = "2";
        console.log(x,KirimNoTagihanditerima,KirimPetugasDiterima,KirimtglDiterima,JenisBerkas);
        batalkirimtagihanditerimanya(); 
        
    });
   
});
async function kirimtagihannya() {
    try {
        const datakirimtagihan = await kirimtagihan(); 
        updateUIdatakirimtagihan(datakirimtagihan); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
function kirimtagihan() {
    var KirimNoTagihan = $("#KirimNoTagihan").val();
    var KirimPetugas = $("#KirimPetugas").val();
    var Kirimtgl = $("#Kirimtgl").val();
    var JenisBerkas =  document.getElementById("JenisBerkas").value;


    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Piutang/kirimtagihan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:'KirimNoTagihan=' + KirimNoTagihan 
        + '&KirimPetugas=' + KirimPetugas
        + '&Kirimtgl=' + Kirimtgl
        + '&JenisBerkas=' + JenisBerkas

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
            // document.getElementById("frmKartuRSYarsi").reset();
            // $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIdatakirimtagihan(datakirimtagihan) {
    let params = datakirimtagihan;
        swal('Good job!', params.message + " !", "success")
            .then((value) => {
                // var KirimPetugas = $("#KirimPetugas").val();
                // console.log(KirimPetugas);
                $("#KirimPetugas").val(params.KirimPetugas);
                        $('#modal_alert_Updatekirim').modal('hide');
        $('.modal-backdrop').hide();
        LoadPenagihanByStatus();

                // var alasanbatal = $("#alasanbatalHdr").val();
                // MyBack();

            });
}
async function batalkirimtagihannya() {
    try {
        const databatalkirimtagihan = await batalkirimtagihan(); 
        updateUIdatabatalkirimtagihan(databatalkirimtagihan); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
function batalkirimtagihan() {
    var KirimNoTagihanBatalKirim = $("#KirimNoTagihanBatalKirim").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Piutang/batalkirimtagihan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:'KirimNoTagihanBatalKirim=' + KirimNoTagihanBatalKirim 


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
            // document.getElementById("frmKartuRSYarsi").reset();
            // $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIdatabatalkirimtagihan(databatalkirimtagihan) {
    let params = databatalkirimtagihan;
    swal('Good job!', params.message + " !", "success")
    .then((value) => {
        // var KirimPetugas = $("#KirimPetugas").val();
        // console.log(KirimPetugas);
        $("#KirimNoTagihanBatalKirim").val(params.KirimNoTagihanBatalKirim);
                $('#modal_alert_batal_kirim').modal('hide');
$('.modal-backdrop').hide();
LoadPenagihanByStatus();
            });
}
async function kirimtagihanditerimanya() {
    try {
        const datakirimtagihanditerima = await kirimtagihanditerima(); 
        updateUIdatakirimtagihanditerima(datakirimtagihanditerima); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
function kirimtagihanditerima() {
    var KirimNoTagihanditerima = $("#KirimNoTagihanditerima").val();
    var KirimPetugasDiterima = $("#KirimPetugasDiterima").val();
    var KirimtglDiterima = $("#KirimtglDiterima").val();
    var JenisBerkas =  document.getElementById("JenisBerkas").value;


    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Piutang/kirimtagihanditerima';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:'KirimNoTagihanditerima=' + KirimNoTagihanditerima 
        + '&KirimPetugasDiterima=' + KirimPetugasDiterima
        + '&KirimtglDiterima=' + KirimtglDiterima
        + '&JenisBerkas=' + JenisBerkas

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
            // document.getElementById("frmKartuRSYarsi").reset();
            // $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIdatakirimtagihanditerima(datakirimtagihanditerima) {
    let params = datakirimtagihanditerima
    // console.log(params);return false;
    swal('Good job!', params.message + " !", "success")
    .then((value) => {
        // var KirimPetugas = $("#KirimPetugas").val();
        // console.log(KirimPetugas);
        $("#KirimPetugasDiterima").val(params.KirimPetugasDiterima);
                $('#modal_alert_UpdateDiterima  ').modal('hide');
$('.modal-backdrop').hide();
LoadPenagihanByStatus();
            });
}
async function batalkirimtagihanditerimanya() {
    try {
        const databatalkirimtagihanditerima = await batalkirimtagihanditerima(); 
        updateUIdatabatalkirimtagihanditerima(databatalkirimtagihanditerima); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
function batalkirimtagihanditerima() {
    var KirimNoTagihanBatalDiterima = $("#KirimNoTagihanBatalDiterima").val();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Piutang/batalkirimtagihanditerima';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:'KirimNoTagihanBatalDiterima=' + KirimNoTagihanBatalDiterima 


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
            // document.getElementById("frmKartuRSYarsi").reset();
            // $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIdatabatalkirimtagihanditerima(databatalkirimtagihanditerima) {
    let params = databatalkirimtagihanditerima;
    swal('Good job!', params.message + " !", "success")
    .then((value) => {
        // var KirimPetugas = $("#KirimPetugas").val();
        // console.log(KirimPetugas);
        $("#KirimNoTagihanBatalDiterima").val(params.KirimNoTagihanBatalDiterima);
                $('#modal_alert_batal_diterima').modal('hide');
$('.modal-backdrop').hide();
LoadPenagihanByStatus();
            });
}


function CheckVar (){
    //if not in creteria return false
    if ($("#PeriodeAwal").val() == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if ($("#PeriodeAkhir").val() == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }
    if ($("#JenisBerkas").val() == ''){
        toast ('Silahkan Pilih Jenis Berkas', "warning");
        return false;
    }

    LoadPenagihanByStatus();
}
function LoadPenagihanByStatus() { 
    let PeriodeAwal ,PeriodeAkhir,JenisBerkas;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    JenisBerkas = $("#JenisBerkas").val();
   
    var base_url = window.location.origin;
    
    $('#BerkasPiutangdetail').dataTable({
           "bDestroy": true
       }).fnDestroy();
        $("#BerkasPiutangdetail").show();
       $('#BerkasPiutangdetail').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/piutang/getDataBerkasPiutang", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.PeriodeAwal = PeriodeAwal;
                d.PeriodeAkhir = PeriodeAkhir;
                d.JenisBerkas = JenisBerkas;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [  
               
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> '+row.FS_KD_TRS+'</font> ';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> '+row.NamaPerusahaan+'</font> ';
                  return html 
              }
            },
             { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> '+row.FD_TGL_TRS+'</font> ';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> '+row.FS_KET+'</font> ';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> '+row.FN_TOTAL_TAGIH+'</font> ';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                    if(row.Fb_Status_Kirim == "1"){ // Jika jenis kelaminnya 1
                        var html  = '<span class="btn btn-info" id="btnupdtBatalKirim" name="btnupdtBatalKirim" href="#modal_alert_batal_kirim" data-toggle="modal"   value='+row.ID+'>BATAL KIRIM</span> '
                    
                     
                    }else{ // Jika bukan 1
                        var html  = '<a class="btn btn-danger" id="passkodepox" name="passkodepox"  href="#modal_alert_Updatekirim" data-toggle="modal"  id="ediit" value='+row.ID+'>BELUM KIRIM</a> '
                    }
                       return html 
                }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                    if(row.Fb_Status_Diiterima == "1"){ // Jika jenis kelaminnya 1
                        var html  = '<span class="btn btn-info" id="btnBatalDikrimUpdate" name="btnBatalDikrimUpdate" href="#modal_alert_batal_diterima" data-toggle="modal"   value='+row.ID+'>BATAL DITERIMA</span> '
                    }else{ // Jika bukan 1
                        var html  = '<span class="btn btn-danger" id="btnupdatediterima" name="btnupdatediterima" id="ediit"  href="#modal_alert_UpdateDiterima" data-toggle="modal"    value='+row.ID+'>BELUM DITERIMA</span> '
                    }
                       return html 
                }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> Tgl Kirim : '+row.Fd_Tgl_Dikirim+' <br> Petugas Kirim : '+row.Fs_Petugas_Kirim+'</font> ';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =  '<font size="2"> Tgl Kirim : '+row.Fd_Tgl_Diterima+' <br> Petugas Kirim : '+row.Fs_Petugas_Penerima+'</font> ';
                  return html 
              }
            },
        ],
        dom: 'Bfrtip',
         buttons: [
             'copyHtml5',
             'excelHtml5'
         ]
    });
}

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Piutang/PengirimanBerkasPiutang";
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