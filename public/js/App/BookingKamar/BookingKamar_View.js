$(document).ready(function () {  
    
    $("#btnSearchMR").prop('disabled', true)

    $('#savetrs').click(function () {
            swal({
                title: "Simpan",
                text: "Apakah anda yakin ingin simpan ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        if ($("#transactioncode").val() == ''){
                            goCreateTrs();
                        }else{
                            goUpdateTrs();
                        }
                    } 
                });
    });

    $('#batal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                goVoidTrs(value);
            });
    });

     $("#roomid_temp").select2();
     $("#bedid_temp").select2();

    $('#classid_temp').change(function () {
        var xdi = document.getElementById("classid_temp").value;
        getPropsClassID(xdi);
        getRoomID(xdi);
    });

    $('#roomid_temp').change(function () {
        var xdi = document.getElementById("roomid_temp").value;
        getPropsRoomID(xdi);
        getBedID(xdi);
    });
    
    $('#bedid_temp').change(function () {
        var xdi = document.getElementById("bedid_temp").value;
        getPropsBedID(xdi)
        //getTarif();
    });

    $('#btnSearchMR').click(function () {
        $("#myModal").modal('show')
    }); 


    onLoadFunctionAll(); 
 

});

 
$("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
    if (e.keyCode == 13) { // Jika user menekan tombol ENTER
        loaddatamr();
    }
});
function loaddatamr() {
    var base_url = window.location.origin;
    var txSearchData = $("#txSearchData").val();
    var cmbxcrimr = $("#cmbxcrimr").val();
    if (txSearchData == '' || txSearchData == null) {
        toast('Silahkan Isi Kata Kunci!', "warning")
        return false
    }
    var iswalkin = $("#iswalkin").val();
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aMedicalRecord/getListMedicalRecord",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.txSearchData = txSearchData;
                d.iswalkin = iswalkin;
                d.cmbxcrimr = cmbxcrimr;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            { "data": "NoMR" },
            { "data": "NamaPasien" },
            { "data": "TglLahir" },
            { "data": "Alamat" },
            { "data": "TlpRumah" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showIDMR("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-log-in"></span></button> '
                    return html
                }
            },

        ]
    });
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aBookingKamar/";
}
async function onLoadFunctionAll() {
    try{
        
        const datagetClass = await getClass();
        updateUIdatagetClass(datagetClass);
        const trscode = $("#transactioncode").val();
        if ($("#transactioncode").val() != ''){
            GetLoadData(trscode)
        }
        //showIDMR($("#SIMRS_Registrasi").val());
    } catch (err) {
        toast(err, "error")
    }
}


async function showIDMR(params) {
    try {
        const dataShowIdMr = await GetMedicalRecordbyIDTrs(params);
        updateUIGetMedicalRecordbyIDTrs(dataShowIdMr);
        
    } catch (err) {
        toast(err, "error")
    }
}

async function GetMedicalRecordbyIDTrs(params) {
    var x = params;
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetMedicalRecordbyIDTrs';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + x + "&iswalkin=" + iswalkin
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
         //   $("#Medical_Provinsi").select2();
        })
}

async function updateUIGetMedicalRecordbyIDTrs(dataShowIdMr) {
    let data = dataShowIdMr;
    $("#medicalrecordnumber").val(data.NoMR)
    $("#patientname").val(data.PatientName)
    $("#patientaddress").val(data.Address)
    $("#patientsex").val(data.Gander)
    $("#patientbirthplace").val(data.BirthPlace)
    $("#patientbirthdate").val(data.Date_of_birth)
    $("#myModal").modal('hide');

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
               // $("#classid_temp_Titipan").select2();
            })
    }
    
    function updateUIdatagetClass(datagetClass) {
        let data = datagetClass;
        if (data !== null && data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#classid_temp").append(newRow);
           // $("#classid_temp_Titipan").append(newRow);
            for (i = 0; i < data.data.length; i++) {
                var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
                $("#classid_temp").append(newRow);
                //$("#classid_temp_Titipan").append(newRow);
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

async function getTarif() {
    try{
        const datagetdatatarif = await getdatatarif();
        updateUIgetdatatarif(datagetdatatarif);
    } catch (err) {
        // $("#TarifKamar").val('');
        // $("#RoomID").val('');
        toast(err.message, "error")
    }
}

function getdatatarif() {
var base_url = window.location.origin;
var classid = $("#classid_temp").val();
var room = $("#roomid_temp").val();
var bed = $("#bedid_temp").val();
var groupjaminan = 'UM';
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
        // $("#TarifKamar").val(convertEntities(dataresponse.data.TarifKamar));
        // $("#RoomID").val(convertEntities(dataresponse.data.RoomID));
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

async function goCreateTrs() {
    try {
        var date = document.getElementById("transactiondate").value;
        var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
        const FormData = $("#frmSimpanTrsRegistrasi").serialize() + "&TransasctionDate="+TransasctionDate;
        const ctlrname = 'aBookingKamar';
        const funcname = 'create';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUICreate(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function goUpdateTrs() {
    try {
        var date = document.getElementById("transactiondate").value;
        var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
        const FormData = $("#frmSimpanTrsRegistrasi").serialize() + "&TransasctionDate="+TransasctionDate;
        const ctlrname = 'aBookingKamar';
        const funcname = 'update';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIUpdate(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function goVoidTrs(param) {
    try {
        const FormData = $("#frmSimpanTrsRegistrasi").serialize() + "&alasanbatal="+param;
        const ctlrname = 'aBookingKamar';
        const funcname = 'void';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIUpdate(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function GetLoadData(transactioncode) {
    try {
        const FormData =  "transactioncode="+transactioncode;
        const ctlrname = 'aBookingKamar';
        const funcname = 'viewByNoTrs';
        $(".preloader").fadeIn();
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUILoadData(response);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUICreate(responseData) {
    let data = responseData;
        if (data.status == 'success'){
        swal({
            title: "Berhasil Simpan",
            text: data.message,
            icon: "success",
        }).then((willDelete) => {
            if (willDelete) {
                MyBack();
            } 
        });
        toast(data.message,'success');
        $("#transactioncode").val(data.data);
        
    }else{
        let msg = []
        let obj = data.errordetails
        for (const [key, value] of Object.entries(obj)) {
            msg.push(value)
            toast(value,'warning')
        }
        swal({
            title: "Gagal Simpan",
            text: msg[0][0],
            icon: "warning",
        });
        //toast(data.message,'warning')
    }
}

function updateUIUpdate(responseData) {
    let data = responseData;
        if (data.status == 'success'){
        swal({
            title: "Berhasil Simpan",
            text: data.message,
            icon: "success",
        })
        .then((willDelete) => {
            if (willDelete) {
                MyBack();
            } 
        });
        toast(data.message,'success');
    }else{
        swal({
            title: "Gagal Simpan",
            text: data.message,
            icon: "warning",
        });
        toast(data.message,'danger')
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

function updateUIgetBeds(responseData) {
    let data = responseData.data;
    $("#bedname").val(data.bedname);
    $("#bedid").val(data.bedid);
}

function updateUILoadData(responseData) {
    let data = responseData.data;
    $("#transactiondate").val(data.transactiondate);
    $("#bookingbeddate").val(data.tglbooking);
    $("#medicalrecordnumber").val(data.medicalrecordnumber);
    $("#patientname").val(data.patientname);
    $("#patientaddress").val(data.patientaddress);
    $("#patientsex").val(data.patientsex);
    $("#patientbirthplace").val(data.patientbirthplace);
    $("#patientbirthdate").val(data.patientbirthdate);
    $("#jenisbooking").val(data.jenisbooking);

    // $("#classid_temp").val(data.classid).trigger('change');
    // $("#roomid_temp").val(data.roomid);
    // $("#bedid_temp").val(data.bedid);

    $("#classid").val(data.classid);
    $("#classname").val(data.classname);
    $("#roomid").val(data.roomid);
    $("#roomname").val(data.roomname);
    $("#bedid").val(data.bedid);
    $("#bedname").val(data.bedname);
    $("#notes").val(data.notes);
    $("#bookingstatus").val(data.StatusName);
    $("#jenispasien").val(data.jenispasien);

    $("#jenispasien").prop('disabled', true)
    $("#btnSearchMR").prop('disabled', true)
    $("#transactiondate").prop('readonly', true)

    getjenispasien();
}

function getjenispasien() {
    var jenispasien = $("#jenispasien").val();
    if (jenispasien == ''){
        toast('Silahkan pilih jenis pasien !', 'warning')
        return false
    }
    if (jenispasien == 'Lama'){
        $("#btnSearchMR").prop('disabled', false)
        $("#medicalrecordnumber").prop('readonly', true)
        $("#patientname").prop('readonly', true)
        $("#patientaddress").prop('readonly', true)
        $("#patientsex").prop('readonly', true)
        $("#patientbirthplace").prop('readonly', true)
        $("#patientbirthdate").prop('readonly', true)
    }else if(jenispasien == 'Baru'){
        $("#btnSearchMR").prop('disabled', true)
        $("#medicalrecordnumber").val('')
        $("#medicalrecordnumber").prop('readonly', true)
        $("#patientname").prop('readonly', false)
        $("#patientaddress").prop('readonly', false)
        $("#patientsex").prop('readonly', false)
        $("#patientbirthplace").prop('readonly', false)
        $("#patientbirthdate").prop('readonly', false)

    }
}