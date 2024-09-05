$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#permintaanrawat_all').DataTable({});
    getDataListPemakaianKamar();
    asyncShowMain();

    $('#submit_checkout').click(function () {
        goCheckout();
    });
});

 
async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
    console.log('aaaaa');
    $("#NamaPasien").val(convertEntities(dataresponse.data.PatientName));
    $("#NoMR").val(convertEntities(dataresponse.data.NoMR));
    $("#NoEpisode").val(convertEntities(dataresponse.data.NoEpisode));
    $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
    $("#TanggalLahir").val(convertEntities(dataresponse.data.DOB+' ('+dataresponse.data.age+')'));
    $("#Penjamin").val(convertEntities(dataresponse.data.nama_penjamin));
    $("#AlihStatusDari").val(convertEntities(dataresponse.data.NoRegisRWJ));
    $("#Dokter").val(convertEntities(dataresponse.data.NamaDokter));
    $("#Unit").val(convertEntities(dataresponse.data.NamaUnit));
    $("#Kelas").val(convertEntities(dataresponse.data.NamaKelas));
    $("#TglMasuk").val(convertEntities(dataresponse.data.TglMasuk));
    $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
    $("#HakKelas").val(convertEntities(dataresponse.data.HakKelas));
    $("#Diagnosa").val(convertEntities(dataresponse.data.Diagnosa));
    $("#Keterangan_Ext").val(convertEntities(dataresponse.data.TelemedicineIs+' / '+dataresponse.data.JenisPasien));
    $("#judul").html(dataresponse.data.judul);
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#NoRegistrasi").val() 
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

function getDataListPemakaianKamar() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    $('#pemakaiankamar').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#pemakaiankamar').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aRegistrasiKamar/getDataKamar", // URL file untuk proses select datanya
               "type": "POST",data: function (d) {
                d.noreg = noreg
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "ID" },
            { "data": "Class" },
            { "data": "RoomName" },
            { "data": "Bed" },
            { "data": "JenisRawat" },
            { "data": "StartDate" },
            { "data": "jam_masuk" },
            { "data": "Tarif" },
            { "data": "LamaRawat" },
            { "data": "EndDate" },
            { "data": "jam_keluar" },
            { "data": "Disc" },
            { "data": "Jumlah" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                  if(row.Status == "1"){ 
                      var html  = '<span class="badge badge-success">Active</span> '
                  }else{ 
                      var html  = '<span class="badge badge-secondary">Checked out</span> '
                  }
                     return html 
              }
          },
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="showID(' + row.ID + ')" ><span class="visible-content" > Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick="ConfrmCheckin(' + row.ID + ')" ><span class="visible-content" > Checkin</span><span class="hidden-content"><i class="fa fa-sign-in"></i></span></button>&nbsp<button type="button" class="btn btn-warning border-warning btn-animated btn-xs"  onclick="Checkout(' + row.ID + ')" ><span class="visible-content" > Checkout</span><span class="hidden-content"><i class="fa fa-sign-out"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="ConfrmDelete(' + row.ID + ')" ><span class="visible-content" > Hapus</span><span class="hidden-content"><i class="fa fa-trash-o"></i></span></button>'
                          return html 
                   }
               },
           ],
       });
} 

async function showID(str) {
    try {
        await CekRowData(str);
        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aRegistrasiKamar/edit/' + str;
    } catch (err) {
        toast(err.message, "error")
        return false;
    }
}

function CekRowData(str) {
    //var str = $("#frmDataPasien").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CekRowData';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idtrs="+ str
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

async function CheckStatus() {
    try {
        //$(".preloader").fadeIn();
        //const dataCekStatusAktif = 
        await CekStatusAktif();
        //updateUIdataCheckStatusAktif(dataCekStatusAktif);
        return true;
    } catch (err) {
        toast(err.message, "error")
        return false;
    }
}
/*
function updateUIdataCheckStatusAktif(params) {
    let response = params;
    if (response.message == "success") {
        //CreateNew();
        //return 'aaaaa';
    }else{
        toast(response.message, "error")
        //return 'bbbbbbbb';
    }

}
*/
function CekStatusAktif() {
    var str = $("#frmDataPasien").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CekStatusAktif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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

function CreateNew() {
    (async () => {
        var cek = await CheckStatus()
        if (cek){
        const base_url = window.location.origin;
        var str  = btoa($("#NoRegistrasi").val())
        window.location = base_url + '/SIKBREC/public/aRegistrasiKamar/' + str;
        }
    })()
}

function Checkout(idtrs){
    $("#idtrs").val(idtrs);
    $("#modal_checkout").modal('show');
}

//Transaction Checkout
async function goCheckout() {
    try {
        //$(".preloader").fadeIn();
        const datagoCheckout = await goCheckoutKamar();
        updateUIdatagoCheckout(datagoCheckout);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagoCheckout(params) {
    let response = params;
    console.log(response.message);
    if (response.status == "success") {
        toast(response.message, "success")
        $("#modal_checkout").modal('hide');
        getDataListPemakaianKamar();
    }else{
        toast(response.message, "error")
    }  

}
function goCheckoutKamar() {
    var str = $("#form_checkout").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CheckoutKamar';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
//----#END Transaction Checkout-----------

//Transaction Checkin
function ConfrmCheckin (idtrs){
    swal({
        title: "Checkin",
        text: "Apakah Anda ingin Check In ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                (async () => {
                    var cek = await CheckStatus()
                    if (cek){
                        goCheckin(idtrs);
                    }
                })()
            } else {
               // swal("Transaction Rollback !");
            }
        });
}

async function goCheckin(idtrs) {
    try {
        //$(".preloader").fadeIn();
        const datagoCheckin = await goCheckinKamar(idtrs);
        updateUIdatagoCheckin(datagoCheckin);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagoCheckin(params) {
    let response = params;
    console.log(response.message);
    if (response.status == "success") {
        toast(response.message, "success")
        //$("#modal_checkout").modal('hide');
        getDataListPemakaianKamar();
    }else{
        toast(response.message, "error")
    }  
}

function goCheckinKamar(idtrs) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CheckinKamar';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idtrs="+idtrs
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
//----#END Transaction Checkin-----------

function ConfrmDelete (idtrs){
swal("Alasan Hapus:", {
    content: "input",
    buttons:true,
  })
  .then((value) => {
      if (value == '' ){
        swal("Alasan Hapus Harus Diisi ! Simpan Gagal !");
        return false;
      }else if (value == null){
        return false;
      }
   // swal(`You typed: ${value}`);
   goDelete(idtrs,value);
  });
}

//Transaction Delete
async function goDelete(idtrs,value) {
    try {
        //$(".preloader").fadeIn();
        const datagoDeleteKamar = await goDeleteKamar(idtrs,value);
        updateUIdatagoDeleteKamar(datagoDeleteKamar);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagoDeleteKamar(params) {
    let response = params;
    console.log(response.message);
    if (response.status == "success") {
        toast(response.message, "success")
        //$("#modal_checkout").modal('hide');
        getDataListPemakaianKamar();
    }else{
        toast(response.message, "error")
    }  

}
function goDeleteKamar(idtrs,value) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/DeleteKamar';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idtrs="+ idtrs + "&alasan=" + value
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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