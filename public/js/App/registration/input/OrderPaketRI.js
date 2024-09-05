$(document).ready(function () { 
    
    asyncShowMain();

    $(document).on('click', '#btnOrder', function () {

        swal({
            title: "Simpan",
            text: "Lanjut Order Paket Ranap",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateOrderPaketRI();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
    });
    
    
});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDataSPRDetail();
        const datagetNamaPaketRanap = await getNamaPaketRanap();
        const datagetDataIDPaketOperasiByReg = await getDataIDPaketOperasiByReg();
        updateUIgetDataSPRDetail(datagetDatabyID);
        updateUIdatagetNamaPaketRanap(datagetNamaPaketRanap);
        updateUIgetDataIDPaketOperasiByReg(datagetDataIDPaketOperasiByReg);

    } catch (err) {
        toast(err.message, "error")
    }
}
function getDataSPRDetail() {
    var base_url = window.location.origin;
    var noregri = $("#NoRegistrasi").val();
    // console.log(noregri);
    // return false;

    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/GetregistrasiRanapbyNoRegistrasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noregri=' + noregri
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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
            // $("#TipePenjamin").select2();
            // $("#JenisRawat").select2();
            // $("#Paket").select2();
           $(".preloader").fadeOut(); 
        }).catch((err) =>{
            console.log(err, "error")
        })
}

async function updateUIgetDataSPRDetail(datagetDataSPRDetail) {
    let dataResponse = datagetDataSPRDetail;
    $("#IdAuto").val(convertEntities(dataResponse.data.ID));
    $("#NoMR").val(convertEntities(dataResponse.data.NoMR));
    $("#NoEpisode").val(convertEntities(dataResponse.data.NoEpisode));
    $("#NoRegistrasi").val(convertEntities(dataResponse.data.NoRegRI));
    $("#NamaPasien").val(convertEntities(dataResponse.data.PatientName));
    $("#DateStart").val(convertEntities(dataResponse.data.SDATE));
    $("#IdPaket").val(convertEntities(dataResponse.data.ID_Paket));
    $("#HakKelas").val(convertEntities(dataResponse.data.KlsID));
    $("#NamaKelas").val(convertEntities(dataResponse.data.NamaKelas));
    $("#TglLahir").val(convertEntities(dataResponse.data.DOB));
    $("#IdDokter").val(convertEntities(dataResponse.data.drPenerima));
    $("#NamaDokter").val(convertEntities(dataResponse.data.First_Name));
    $("#JenisKelamin").val(convertEntities(dataResponse.data.Gander));

    $("#Alamat").val(convertEntities(dataResponse.data.Address));
    $("#TipePasien").val(convertEntities(dataResponse.data.TypePatient));
    $("#KodeLokasi").val(convertEntities(dataResponse.data.KodeLokasi));
    $("#NamaRuangan").val(convertEntities(dataResponse.data.Room));
    $("#NamaPerusahaan").val(convertEntities(dataResponse.data.NamaPerusahaan));

    $(".preloader").fadeOut(); 
}
function getDataIDPaketOperasiByReg() {
    var base_url = window.location.origin;
    var noregri = $("#NoRegistrasi").val();
    // console.log(noregri);
    // return false;

    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/GetpaketOperasibyNoRegistrasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noregri=' + noregri
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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
            // $("#TipePenjamin").select2();
            // $("#JenisRawat").select2();
            // $("#Paket").select2();
            // $("#IDPemeriksaan").select2();
           $(".preloader").fadeOut(); 
        }).catch((err) =>{
            console.log(err, "error")
        })
}

async function updateUIgetDataIDPaketOperasiByReg(datagetDataIDPaketOperasiByReg) {
    let dataResponse = datagetDataIDPaketOperasiByReg;
    // console.log(dataResponse);
    $("#IdPaket1").val(convertEntities(dataResponse.data.id));
    $("#IDPemeriksaan").val(convertEntities(dataResponse.data.id_paket)).trigger('change');
    await IsLocked(dataresponse.Lock);
    // $("#IDPemeriksaan").val(convertEntities(dataResponse.data.id_paket)).trigger('change');
}

function getNamaPaketRanap() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getPaketRanap';
    return fetch(url, {
        method: 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
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
            $("#IDPemeriksaan").select2();
        })
}

function updateUIdatagetNamaPaketRanap(datagetNamaPaketRanap) {
    let data = datagetNamaPaketRanap;
    // console.log(data);
    // return false;

    if (data !== null && data !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#IDPemeriksaan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].id_paket + '">' + data.data[i].nama_paket + '</option';
            $("#IDPemeriksaan").append(newRow);
        }
    }
}

async function getTarifPaketRI(param) {
    try {
        // console.log(param);
        const datagetTarifPaketRIbyID = await getTarifPaketRIbyID(param);
        updatedatagetTarifPaketRIbyID(datagetTarifPaketRIbyID);
        getPaketDetail(datagetTarifPaketRIbyID.data.id_paket);
    } catch (err) {
        toast(err, "error")
    }
}
function getTarifPaketRIbyID(param) {
    //var Lab_kodeTes = document.getElementById("Lab_kodeTes").value;
    var url2 = "/SIKBREC/public/aRegistrasiRanap/getPaketRI";
    var base_url = window.location.origin;
    var hakkelas = $("#HakKelas").val();
    // console.log(hakkelas);
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdPaket=' + param + '&hakkelas=' + hakkelas
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
            $//("#Lab_kodeTes").select2();
        })
}
function updatedatagetTarifPaketRIbyID(data) {
    $("#HargaPaket").val(data.data.tarif_paket);
    $("#namapaket").val(data.data.nama_paket);
   // $("#Lab_kodeTes_kelompok").val(data.Lock);
}
function getPaketDetail(param){
    var base_url = window.location.origin;
    var hakkelas = $("#HakKelas").val();
     $('#table-load-data-paket-ri').dataTable({
              "bDestroy": true
          }).fnDestroy();
    $('#table-load-data-paket-ri').DataTable( {
          "ordering": true, // Set true agar bisa di sorting
              "order": [ 2, 'asc' ],
              /*
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            $(nRow).children("td").css("overflow", "hidden");
            $(nRow).children("td").css("white-space", "nowrap");
            $(nRow).children("td").css("text-overflow", "ellipsis");
            },*/
          "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiRanap/getDataPaketRIDetail", // URL file 
              "type": "POST",
                  data: function ( d ) {
                  d.idpaket = param;
                  d.hakkelas = hakkelas;
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [
                    // { "data": "No" }, 
                    { "data": "nama_item_detil" }, 
                    { "data": "group_paket_detil" },
                    { "data": "qty" },
                    { "data": "Tarif" },  
          ]
      } );
   }

async function goCreateOrderPaketRI() {
    try {
        const datagoOrderPaket = await goOrderPaket();
        updateUIdatagoOrderPaket(datagoOrderPaket);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function goOrderPaket() {
    $(".preloader").fadeIn();
    $('#btnOrder').addClass('btn-danger');
    $('#btnOrder').html('Sending, Please Wait...');
    
    document.getElementById("btnOrder").disabled = true;
    var str = $("#frmSimpanTrs").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/goCreateOrderPaket';
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
            $('#btnOrder').removeClass('btn-danger');
            $('#btnOrder').html('Pilih dan Order Paket');
            document.getElementById("btnOrder").disabled = false;
        })
}
function updateUIdatagoOrderPaket(params) {
    let response = params;

    if(response['status']== 'success'){
        toast("Berhasil Simpan Order MCU !", "success");
        //swal("Berhasil Simpan Order MCU !", "success");
        toast(response.message, "success")
            swal({
                title: "Save Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
                setTimeout(() => {
                IsLocked(1);
                    
                }, 500);
            });
        //var noregistrasi = response.NoRegistrasi; ;
    }
    else{
        toast(response['message'], "warning");
    }
    
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}