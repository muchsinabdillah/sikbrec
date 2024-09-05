$(document).ready(function () {
    //$(".preloader").fadeOut(); 

    $('#btnSearchBooking').click(function () {
        $("#myModal").modal('show')
    }); 


    asyncShowMain();
    IsTitipan(0);

    $('#Titipan').change(function () {
        var xdi = document.getElementById("Titipan").value;
        IsTitipan(xdi);
      });

    $('#classid_temp').change(function () {
        var xdi = document.getElementById("classid_temp").value;
        //getRoomID(xdi);
        
        getPropsClassID(xdi);
        getRoomID(xdi);
       // $("#NamaKamar").select2()
        //$("#BedKamar").select2()
    });

    $('#roomid_temp').change(function () {
        var xdi = document.getElementById("roomid_temp").value;
        getPropsRoomID(xdi);
        getBedID(xdi);
    });
    
    $('#bedid_temp').change(function () {
        var xdi = document.getElementById("bedid_temp").value;
        //getTarif();
        getPropsBedID(xdi)
    });

    //TITIPAN-------------------------

    $('#ClassID_Titipan').change(function () {
        var xdi = document.getElementById("ClassID_Titipan").value;
        getRoomID_Titipan(xdi);
        //$("#NamaKamar_Titipan").select2()
        //$("#BedKamar_Titipan").select2()
    });

    $('#NamaKamar_Titipan').change(function () {
        var xdi = document.getElementById("NamaKamar_Titipan").value;
        getBedID_Titipan(xdi);
    });

    $('#BedKamar_Titipan').change(function () {
        //var xdi = document.getElementById("BedKamar").value;
        getTarif_Titipan();
    });

    //----------------------------

    $('#savetrs').click(function () {
        if ($("#IdAuto").val() == ''){
            swal({
                title: "Simpan",
                text: "Apakah Anda ingin Simpan dan Check In ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            goCreateTrs();
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });
        }else{
            swal("Alasan Edit:", {
                content: "input",
                buttons:true,
              })
              .then((value) => {
                  if (value == '' ){
                    swal("Alasan Edit Harus Diisi ! Simpan Gagal !");
                    return false;
                  }else if (value == null){
                    return false;
                  }
               // swal(`You typed: ${value}`);
               goUpdateTrs(value);
              });
        }
    });

    $('#btnSaveValidate').click(function () {
            swal({
                title: "Simpan",
                text: "Apakah Anda yakin ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            $("#validateModal").modal('hide')
                            $("#myModal").modal('hide')
                            $("#nomr_pass").val($("#nomr_validasi").val())
                            goViewDataBooked($("#kodebooking_validasi").val());
                    } 
                });
    });
    

});

async function asyncShowMain() {
    try {   
        const datagetClass = await getClass();
        updateUIdatagetClass(datagetClass);

        if ($("#IdAuto").val() != ''){ // if edit
            const datagetDatabyID = await getDatabyID();
            updateUIdatagetDatabyID(datagetDatabyID);
        }else{
            document.getElementById("labeledit").style.display = 'none';
            $("#TglMasuk").val(getDateNow);
            $("#JamMasuk").val(getTimeNow);
            $("#TglMasuk").attr('readonly', false);
            $("#JamMasuk").attr('readonly', false);
            $("#roomid_temp").select2();
            $("#bedid_temp").select2();
            $("#NamaKamar_Titipan").select2();
            $("#BedKamar_Titipan").select2();
            $("#Titipan").select2();
            const datagetPenjamin = await getPenjamin();
            updateUIgetDataPenjamin(datagetPenjamin);
            IsTitipan(0);
            $("#myModal").modal('show')
            
            // const dataListBooking = await getBookingList();
            // updateUIdataListBooking(dataListBooking);

            $(".preloader").fadeOut(); 
        }
        
    
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;

    $("#NoRegistrasi").val(convertEntities(dataresponse.data.NoRegRI));
    const datagetPenjamin = await getPenjamin();
    updateUIgetDataPenjamin(datagetPenjamin);

        //$("#classid_temp").val(convertEntities(dataresponse.data.IDKelas)).trigger('change');
        //  await getRoomID(dataresponse.data.IDKelas);
        //  await getBedID(dataresponse.data.RoomName);
        $("#classname").val(convertEntities(dataresponse.data.Class));
        $("#classid").val(convertEntities(dataresponse.data.IDKelas));
        $("#roomname").val(convertEntities(dataresponse.data.RoomName));
        $("#roomid").val(convertEntities(dataresponse.data.KodeLokasi));
        $("#bedname").val(convertEntities(dataresponse.data.Bed));
        $("#bedid").val(convertEntities(dataresponse.data.RoomID));
       //$("#BedKamar").val(convertEntities(dataresponse.data.Bed)).trigger('change');
        $("#TarifKamar").val(convertEntities(dataresponse.data.Tarif));
        $("#LamaRawat").val(convertEntities(dataresponse.data.LamaRawat));
        $("#TglMasuk").val(convertEntities(dataresponse.data.TglMasuk));
        $("#JamMasuk").val(convertEntities(dataresponse.data.JamMasuk));
        $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
        $("#JamKeluar").val(convertEntities(dataresponse.data.JamKeluar));
        $("#roomid_temp").select2();
        $("#bedid_temp").select2();

        //TITIPAN
        $("#Titipan").val(convertEntities(dataresponse.data.Titipan));
        IsTitipan(convertEntities(dataresponse.data.Titipan));
        if (convertEntities(dataresponse.data.Titipan) == '1'){
            $("#ClassID_Titipan").val(convertEntities(dataresponse.data.IDKelas_Titipan)).trigger('change');
            await getRoomID_Titipan(dataresponse.data.IDKelas_Titipan);
            await getBedID_Titipan(dataresponse.data.RoomName_Titipan);
            $("#NamaKamar_Titipan").val(convertEntities(dataresponse.data.RoomName_Titipan));
            $("#BedKamar_Titipan").val(convertEntities(dataresponse.data.Bed_Titipan)).trigger('change');
            $("#TarifKamar_Titipan").val(convertEntities(dataresponse.data.Tarif_Titipan));
        }
        $("#NamaKamar_Titipan").select2();
        $("#BedKamar_Titipan").select2();
        $("#Titipan").select2();
        
        $("#btnSearchBooking").prop('disabled', true)


        document.getElementById("labelnew").style.display = 'none';
        $(".preloader").fadeOut(); 
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getDatabyID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val() 
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

//--------------------
async function updateUIgetDataPenjamin(datagetPenjamin) {
    let dataresponse = datagetPenjamin;
        $("#Jaminan").val(convertEntities(dataresponse.data.nama_penjamin));
        $("#TipePasien").val(convertEntities(dataresponse.data.TipePasien));
        $("#GroupJaminan").val(convertEntities(dataresponse.data.GroupJaminan));
}

function getPenjamin() {
    console.log($("#NoRegistrasi").val(),'sss');
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



function getClass() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
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
            $("#classid_temp").select2();
            $("#ClassID_Titipan").select2();
        })
}

function updateUIdatagetClass(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#classid_temp").append(newRow);
        $("#ClassID_Titipan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
            $("#classid_temp").append(newRow);
            $("#ClassID_Titipan").append(newRow);
        }
    }
}

async function getRoomID(classid) {
        try{
            const datagetRoom = await getRoom(classid);
            updateUIgetRoom(datagetRoom);
        } catch (err) {
            toast(err.message, "error")
        }
    }

    async function getRoomID_Titipan(classid) {
        try{
            const datagetRoom = await getRoom(classid);
            updateUIgetRoom_Titipan(datagetRoom);
        } catch (err) {
            toast(err.message, "error")
        }
    }


function getRoom(classid) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getRoom';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'classid=' + classid,
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
            //$("#NamaKamar").select2();
        })
}

function updateUIgetRoom(datagetRoom) {
    let data = datagetRoom;
    if (data !== null && data !== undefined) {
    $("#roomid_temp").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#roomid_temp").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].Room + '">' + data.data[i].Room + '</option';
            $("#roomid_temp").append(newRow);
        }
    }
}

function updateUIgetRoom_Titipan(datagetRoom) {
    let data = datagetRoom;
    if (data !== null && data !== undefined) {
    $("#NamaKamar_Titipan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaKamar_Titipan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].Room + '">' + data.data[i].Room + '</option';
            $("#NamaKamar_Titipan").append(newRow);
        }
    }
}


async function getBedID(room) {
        try{
            const datagetBed = await getBed(room);
            updateUIgetBed(datagetBed);
        } catch (err) {
            toast(err.message, "error")
        }
    }

    async function getBedID_Titipan(room) {
        try{
            const datagetBed = await getBed(room);
            updateUIgetBed_Titipan(datagetBed);
        } catch (err) {
            toast(err.message, "error")
        }
    }


function getBed(room) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getBed';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'room=' + room,
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
            //$("#BedKamar").select2();
        })
}

function updateUIgetBed(datagetBed) {
    let data = datagetBed;
    if (data !== null && data !== undefined) {
    $("#bedid_temp").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#bedid_temp").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].Bad + '">' + data.data[i].Bad + ' - '+ data.data[i].cekkamar + ' - '+ data.data[i].IsBPJS +'</option';
            $("#bedid_temp").append(newRow);
        }
    }
}

function updateUIgetBed_Titipan(datagetBed) {
    let data = datagetBed;
    if (data !== null && data !== undefined) {
    $("#BedKamar_Titipan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#BedKamar_Titipan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].Bad + '">' + data.data[i].Bad + ' - '+ data.data[i].cekkamar + ' - '+ data.data[i].IsBPJS +'</option';
            $("#BedKamar_Titipan").append(newRow);
        }
    }
}

async function getTarif() {
        try{
            const datagetdatatarif = await getdatatarif();
            updateUIgetdatatarif(datagetdatatarif);
        } catch (err) {
            $("#TarifKamar").val('');
            $("#RoomID").val('');
            toast(err.message, "error")
        }
    }

async function getTarif_Titipan() {
    try{
        const datagetdatatarif = await getdatatarif_Titipan();
        updateUIgetdatatarif_Titipan(datagetdatatarif);
    } catch (err) {
        $("#TarifKamar_Titipan").val('');
        $("#RoomID_Titipan").val('');
        toast(err.message, "error")
    }
}


function getdatatarif() {
    var base_url = window.location.origin;
    // var classid = $("#ClassID").val();
    // var room = $("#roomid_temp").val();
    // var bed = $("#BedKamar").val();

    var classid = $("#classid").val();
    var room = $("#roomname").val();
    var bed = $("#bedname").val();
    var groupjaminan = $("#GroupJaminan").val();
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getTarif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'classid=' + classid + '&room=' + room + '&bed=' + bed + '&groupjaminan=' + groupjaminan 
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

function getdatatarif_Titipan() {
    var base_url = window.location.origin;
    var classid = $("#ClassID_Titipan").val();
    var room = $("#NamaKamar_Titipan").val();
    var bed = $("#BedKamar_Titipan").val();
    var groupjaminan = $("#GroupJaminan").val();
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/getTarif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'classid=' + classid + '&room=' + room + '&bed=' + bed + '&groupjaminan=' + groupjaminan 
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

function updateUIgetdatatarif(datagetBed) {
    let dataresponse = datagetBed;
        $("#TarifKamar").val(convertEntities(dataresponse.data.TarifKamar));
        $("#RoomID").val(convertEntities(dataresponse.data.RoomID));
}

function updateUIgetdatatarif_Titipan(datagetBed) {
    let dataresponse = datagetBed;
        $("#TarifKamar_Titipan").val(convertEntities(dataresponse.data.TarifKamar));
        $("#RoomID_Titipan").val(convertEntities(dataresponse.data.RoomID));
    
}

function myBack() {
    window.history.back();
}

function getDateNow(){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var datenow = yyyy +"-"+ mm +"-"+ dd;
    return datenow;
}

function getTimeNow(){
    var today = new Date();
    var hh = String(today.getHours()).padStart(2, '0');
    var menit = String(today.getMinutes()).padStart(2, '0');
    var ss = String(today.getSeconds()).padStart(2, '0');
    var timenow = hh + ":" + menit + ":" + ss;
    return timenow;

}

//Transaction
async function goCreateTrs() {
    try {
        //$(".preloader").fadeIn();
        const dataCreateTrs = await CreateTrs();
        updateUIdataCreateTrs(dataCreateTrs);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCreateTrs(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        }).then(function() {
            const base_url = window.location.origin;
            var str = btoa($("#NoRegistrasi").val());
            window.location = base_url + '/SIKBREC/public/aRegistrasiKamar/list/' + str;
        });
    }else{
        toast(response.message, "error")
    }  

}
function CreateTrs() {
    var str = $("#frmTrsKamar").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CreateTrs';
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

async function goUpdateTrs(alasan) {
    try {
        const dataUpdateTrs = await UpdateTrs(alasan);
        updateUIdataCreateTrs(dataUpdateTrs);
    } catch (err) {
        toast(err.message, "error")
    }
}


function UpdateTrs(alasan) {
    
    var str = $("#frmTrsKamar").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiKamar/CreateTrs';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str + '&alasan=' + alasan
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

function IsTitipan(val){
    if (val == '0'){
      $("#istitipan").hide();
      // $("#KelasTitipan").attr('disabled', true);
      // $("#KamarTitipan").attr('disabled', true);
      // $("#BedTitipan").attr('disabled', true);
      // $("#TarifTitipan").attr('disabled', true);
    }else{
      $("#istitipan").show();
      // $("#KelasTitipan").attr('disabled', false);
      // $("#KamarTitipan").attr('disabled', false);
      // $("#BedTitipan").attr('disabled', false);
      // $("#TarifTitipan").attr('disabled', false);
    }
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

// async function updateUIdataListBooking(dataresponse) {

// }

// async function getBookingList() {
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/aBookingKamar/getBookingList';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: 'NoRegistrasi=' + $("#NoRegistrasi").val() 
//     })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(response.statusText)
//             }
//             return response.json();
//         })
//         .then(response => {
//             if (response.status === "error") {
//                 throw new Error(response.message.errorInfo[2]);
//                 // console.log("ok " + response.message.errorInfo[2])
//             } else if (response.status === "warning") {
//                 throw new Error(response.errorname);
//                 // console.log("ok " + response.message.errorInfo[2])
//             }
//             return response
//         })
//         .finally(() => {
            
//         })
// }

function caridatareservasi() { 
    var base_url = window.location.origin;
    var tanggal_awal = $("#tglAwalReservasi").val();
    var tanggal_akhir = $("#tglAkhirReservasi").val();
    if (tanggal_awal == '' || tanggal_akhir == ''){
        toast('Mohon isi periode !','warning');
        return false
    }
    $('#datalistbooking').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datalistbooking').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBookingKamar/listAllActivebyNoMR",
        "type": "POST",
        data: function (d) {
            d.StartPeriode = tanggal_awal
            d.EndPeriode = tanggal_akhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "transactioncode" },
                            { "data": "medicalrecordnumber" },
                            { "data": "patientname" },
                            { "data": "bookingbeddate" },
                            { "data": "classname" },
                            { "data": "roomname" },
                            { "data": "bedname" },
                            { "data": "notes" },
                            {
                                "render": function (data, type, row) {
                                    var html = ""
                                    if (row.medicalrecordnumber == null){
                                        var html = '<button type="button" class="btn btn-maroon border-primary btn-animated btn-xs"  onclick=\'validateMR("' + row.transactioncode + '",true)\'   ><span class="visible-content" > Checkin</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                                    }else{
                                        var html = '<button type="button" class="btn btn-maroon border-primary btn-animated btn-xs"  onclick=\'validateMR("' + row.transactioncode + '",false)\'   ><span class="visible-content" > Checkin</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                                    }
                                    return html
                                }
                            },
                            
                           ],
     });
}  


async function validateMR(transactioncode,isnewpatient) {
    try {
        const FormData =  "transactioncode="+transactioncode +"&noregri="+$("#NoRegistrasi").val();
        const ctlrname = 'aBookingKamar';
        const funcname = 'viewByMatch';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        if (isnewpatient){
            updateUILoadDataValidate(response);
        }else{
            $("#nomr_pass").val('')
            updateUILoadData(response);
        }
    } catch (err) {
        console.log(err);
        toast(err, "error")
    }
}

async function goViewDataBooked(transactioncode) {
    try {
        const FormData =  "transactioncode="+transactioncode 
        const ctlrname = 'aBookingKamar';
        const funcname = 'viewByNoTrs';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUILoadData(response);
    } catch (err) {
        console.log(err);
        toast(err, "error")
    }
}

async function getpostData(data,ctlrname,funcname) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/'+ctlrname+'/'+funcname+'/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

async function updateUILoadData(responseData) {
    let dataresponse = responseData;
    //---------------------------------
       // $("#ClassID").val(convertEntities(dataresponse.data.classid)).trigger('change');
        //  await getRoomID(dataresponse.data.classid);
        //  await getBedID(dataresponse.data.roomname);
        $("#classid").val(convertEntities(dataresponse.data.classid));
        $("#classname").val(convertEntities(dataresponse.data.classname));
        $("#roomid").val(convertEntities(dataresponse.data.roomid));
        $("#roomname").val(convertEntities(dataresponse.data.roomname));
        $("#bedname").val(convertEntities(dataresponse.data.bedname));
        $("#bedid").val(convertEntities(dataresponse.data.bedid));
        getTarif();

        //$("#NamaKamar").val(convertEntities(dataresponse.data.roomname));
        //$("#BedKamar").val(convertEntities(dataresponse.data.bedname)).trigger('change');
        $("#NamaKamar").select2();
        $("#bedid_temp").select2();
        $("#myModal").modal('hide')
        $("#kodebooking").val(dataresponse.data.transactioncode)
        $(".preloader").fadeOut(); 
}

async function updateUILoadDataValidate(responseData) {
    let dataresponse = responseData.data;

        $("#validateModal").modal('show')
        //$("#myModal").modal('hide')
        $("#patientname").val(dataresponse.patientname);
        $("#patientaddress").val(dataresponse.patientaddress);
        $("#patientsex").val(dataresponse.patientsex);
        $("#patientbirthplace").val(dataresponse.patientbirthplace);
        $("#patientbirthdate").val(dataresponse.patientbirthdate);
        
        $("#patientname_validasi").val(dataresponse.patientname_validasi);
        $("#patientaddress_validasi").val(dataresponse.patientaddress_validasi);
        $("#patientsex_validasi").val(dataresponse.patientsex_validasi);
        $("#patientbirthplace_validasi").val(dataresponse.patientbirthplace_validasi);
        $("#patientbirthdate_validasi").val(dataresponse.patientbirthdate_validasi);
        $("#nomr_validasi").val(dataresponse.nomr_validasi);
        $("#kodebooking_validasi").val(dataresponse.transactioncode);

}

async function getPropsClassID(param) {
    try {
        const FormData = 'classid=' + param;
        const ctlrname = 'aBookingKamar';
        const funcname = 'getPropsClass';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIgetClass(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function getPropsRoomID(param) {
    try {
        const FormData = 'roomid=' + param;
        const ctlrname = 'aBookingKamar';
        const funcname = 'getPropsRoom';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIgetRooms(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function getPropsBedID(param) {
    try {
        const FormData = 'bedid=' + param ;
        const ctlrname = 'aBookingKamar';
        const funcname = 'getPropsBed';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIgetBeds(response);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetClass(responseData) {
    let data = responseData.data;
    $("#classname").val(data.classname);
    $("#classid").val(data.classid);
    $("#roomname").val('');
    $("#roomid").val('');
    $("#bedname").val('');
    $("#bedid").val('');
}

function updateUIgetRooms(responseData) {
    let data = responseData.data;
    $("#roomname").val(data.roomname);
    $("#roomid").val(data.roomid);
    $("#bedname").val('');
    $("#bedid").val('');
}

async function updateUIgetBeds(responseData) {
    let data = responseData.data;
    $("#bedname").val(data.bedname);
    $("#bedid").val(data.bedid);
    await getTarif();
    //$("#TarifKamar").val(convertEntities(data.TarifKamar));
}

async function getRoom(classid) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBookingKamar/getRoombyClassID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'classid=' + classid,
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
            //$("#NamaKamar").select2();
        })
}

function updateUIgetRoom(datagetRoom) {
    let data = datagetRoom;
    if (data !== null && data !== undefined) {
    $("#roomid_temp").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#roomid_temp").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ROOM_ID + '">' + data.data[i].ROOM + '</option';
            $("#roomid_temp").append(newRow);
        }
    }
}

async function getBedID(room) {
    try{
        const datagetBed = await getBed(room);
        updateUIgetBed(datagetBed);
    } catch (err) {
        toast(err.message, "error")
    }
}


async function getBed(room) {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aBookingKamar/getBedbyRoomID';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'roomid=' + room,
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
        //$("#BedKamar").select2();
    })
}

function updateUIgetBed(datagetBed) {
let data = datagetBed;
if (data !== null && data !== undefined) {
$("#bedid_temp").empty();
    var newRow = '<option value="">-- PILIH --</option';
    $("#bedid_temp").append(newRow);
    for (i = 0; i < data.data.length; i++) {
        var newRow = '<option value="' + data.data[i].RoomID + '">' + data.data[i].Bad + ' - '+ data.data[i].StatusName + ' - '+ data.data[i].IsBPJS +'</option';
        $("#bedid_temp").append(newRow);
    }
}
}