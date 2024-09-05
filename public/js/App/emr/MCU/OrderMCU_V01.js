$(document).ready(function () { 
    
    asyncShowMain();

    $(document).on('click', '#btnOrder', function () {

        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Order Paket MCU Yang Dipilih ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateOrderMCU();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
    });
    
   
    
});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        const datagetNamaPaketMCU = await getNamaPaketMCU();
        const datagetPaketMCUbyNoreg = await getPaketMCUbyNoreg();
        updateUIdatagetDatabyID(datagetDatabyID);
        updateUIdatagetNamaPaketMCU(datagetNamaPaketMCU);
        updateUIdatagetPaketMCUbyNoreg(datagetPaketMCUbyNoreg);

    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
         //await getRoomID(dataresponse.data.IDKelas);
         //await getBedID(dataresponse.data.RoomName);
        $("#NamaPasien").val(convertEntities(dataresponse.PatientName));
        $("#nomr").val(convertEntities(dataresponse.NoMR));
        $("#NoEpisode").val(convertEntities(dataresponse.NoEpisode));
        $("#TglRegistrasi").val(convertEntities(dataresponse.VisitDate+" "+dataresponse.JamDate));
        $("#NamaPenjamin").val(convertEntities(dataresponse.Perusahaan));
        $("#IDDokter").val(convertEntities(dataresponse.Doctor1));
         $("#PatientType").val(convertEntities(dataresponse.PatientType));
         $("#dokternamxe").val(convertEntities(dataresponse.namadokter));
         $("#IDUnit").val(convertEntities(dataresponse.Unit));
         $("#poliklinikname").val(convertEntities(dataresponse.LokasiPasien));
         $("#DOB").val(convertEntities(dataresponse.Date_of_birth));
         $("#JenisKelamin").val(convertEntities(dataresponse.Gander));
         $("#Alamat").val(convertEntities(dataresponse.Address));


        $(".preloader").fadeOut(); 
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasi';
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


function getNamaPaketMCU() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aOrderMCU/getPaketMCU';
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

function updateUIdatagetNamaPaketMCU(datagetNamaPaketMCU) {
    let data = datagetNamaPaketMCU;
    if (data !== null && data !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#IDPemeriksaan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaPaket + '</option';
            $("#IDPemeriksaan").append(newRow);
        }
    }
}

async function updateUIdatagetPaketMCUbyNoreg(datagetPaketMCUbyNoreg) {
    let dataresponse = datagetPaketMCUbyNoreg;
        $("#IDPemeriksaan").val(convertEntities(dataresponse.IDPaket)).trigger('change');
        await IsLocked(dataresponse.Lock);

}

function getPaketMCUbyNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aOrderMCU/getPaketMCUbyNoreg';
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

async function getTarifPaketMCU(param) {
    try {
        const datagetTarifPaketMCUbyID = await getTarifPaketMCUbyID(param);
        updatedatagetTarifPaketMCUbyID(datagetTarifPaketMCUbyID);
        getPaketDetail(datagetTarifPaketMCUbyID.data.NamaPaket);
    } catch (err) {
        toast(err, "error")
    }
}
function updatedatagetTarifPaketMCUbyID(data) {
    $("#HargaPaket").val(data.data.Tarif);
    $("#namapaket").val(data.data.NamaPaket);
   // $("#Lab_kodeTes_kelompok").val(data.Lock);
}
function getTarifPaketMCUbyID(param) {
    //var Lab_kodeTes = document.getElementById("Lab_kodeTes").value;
    var url2 = "/SIKBREC/public/aOrderMCU/getPaketMCUbyID";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDMCU=' + param
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

function getPaketDetail(param){
    var base_url = window.location.origin;

     $('#table-load-data-mcu').dataTable({
              "bDestroy": true
          }).fnDestroy();
    $('#table-load-data-mcu').DataTable( {
          "ordering": true, // Set true agar bisa di sorting
              "order": [ 2, 'asc' ],
              /*
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            $(nRow).children("td").css("overflow", "hidden");
            $(nRow).children("td").css("white-space", "nowrap");
            $(nRow).children("td").css("text-overflow", "ellipsis");
            },*/
          "ajax": {
            "url": base_url + "/SIKBREC/public/aOrderMCU/getDataMCUDetail", // URL file 
              "type": "POST",
                  data: function ( d ) {
                  d.namapaket = param;
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [
                 { "data": "Pemeriksaan" }, // Tampilkan telepon
                  { "data": "LokasiPemeriksaan" }, // Tampilkan telepon
                  { "data": "Keterangan" }, // Tampilkan alamat
                  { "data": "IdTes" },  // Tampilkan nama
                  { "data": "Tarif" },  
          ]
      } );
   }

   async function goCreateOrderMCU() {
    try {
        const datagoOrderMCU = await goOrderMCU();
        updateUIdatagoOrderMCU(datagoOrderMCU);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdatagoOrderMCU(params) {
    let response = params;
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
function goOrderMCU() {
    $(".preloader").fadeIn();
    $('#btnOrder').addClass('btn-danger');
    $('#btnOrder').html('Sending, Please Wait...');
    
    document.getElementById("btnOrder").disabled = true;
    var str = $("#frmSimpanTrs").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aOrderMCU/goCreateOrderMCU';
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
            $("#btnPrintLabel").prop('disabled',false)
            
        })
}

async function IsLocked(param) {
    console.log(param);
    if(param == '1'){
        $('#StatusOrder').removeClass('badge-success');
        $('#StatusOrder').addClass('badge-danger');
        document.getElementById("btnOrder").disabled = true;
        document.getElementById("IDPemeriksaan").disabled = true;
        //$("#btnPrintLabel").prop('disabled',true)
        $('#StatusOrder').html('Lock');
        console.log($("#StatusOrder"));
       //document.getElementById("StatusOrder").element.classList.add("badge-danger");
    }else{
        $('#StatusOrder').removeClass('badge-danger');
        $('#StatusOrder').addClass('badge-success');
        document.getElementById("btnOrder").disabled = false;
        document.getElementById("IDPemeriksaan").disabled = false;
        $("#btnPrintLabel").prop('disabled',false)
        $('#StatusOrder').html('Unlock');
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

async function PrintLabelLab() {
    try {
        const data = await goPrintLabelLab();
        updateUIgoPrintLabelLab(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgoPrintLabelLab(params) {
    let response = params;
    if (response.status == 'success'){
        toast(response.message, 'success');
    }else{
        toast(response.message, 'warning');
    }
}
async function goPrintLabelLab() {
    //$(".preloader").fadeIn();
    var str = $("#frmSimpanTrs").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aOrderMCU/getPrinterLabelLab';
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
            
        })
}