$(document).ready(function () {
    $(".preloader").fadeOut();
    ShowHeaderUDD();
    document.getElementById("Udd_Qty").disabled = true;
    document.getElementById("slcDataObat").disabled = true;
    $("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
        if (e.keyCode == 13) { // Jika user menekan tombol ENTER
            loaddataResep();
        }
    });
    $(document).on('click', '#btnprint', function () {
        
            $('#notif_Cetak').modal('show');
        
    });
    $(document).on('click', '#savetrs', function () {

        $('#notif_Cetak').modal('show');

    });
    $(document).on('click', '#btnclosemodalcetak', function () {
        MyBack();
    });
    $(document).on('click', '#logocetakbuktireg', function () {
        var noreg = $("#IdTransaksi").val();
        PrintLabelPasien(noreg);
    });
});
async function ShowHeaderUDD() {
    try {
        const dataGogetDataUddHeaderbyTrsid = await GogetDataUddHeaderbyTrsid();
        console.log(dataGogetDataUddHeaderbyTrsid);
        updateUIdataGogetDataUddHeaderbyTrsid(dataGogetDataUddHeaderbyTrsid);
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateUIdataGogetDataUddHeaderbyTrsid(params) {
    if (params.JAM_DIUDD_TRSBERIKAN !=  null ){
        $("#Udd_No_Resep").val(params.JAM_DIBERIKAN);
        $("#Udd_PasienIdJKel").val(params.JAM_DIBERIKAN);
        $("#Udd_PasienNamaJKel").val(params.JAM_DIBERIKAN);
        $("#Udd_NoEpisode").val(params.NO_EPISODE);
        $("#Udd_No_Registrasi").val(params.NO_REGISTRASI);
        $("#Udd_NOMR").val(params.NoMR);
        $("#Udd_JenisResep").val(params.JENIS_RESEP);
        $("#Udd_PasienTglLahir").val(params.Date_of_birth);
        // $("#Udd_PasienUsia").val(params.JAM_DIBERIKAN);
        $("#Udd_PasienNama").val(params.PatientName);
        $("#Udd_RoomName").val(params.JAM_DIBERIKAN);
        $("#Udd_Class").val(params.JAM_DIBERIKAN);
        $("#Udd_Bed").val(params.JAM_DIBERIKAN);
        $("#Udd_Dokter").val(params.NAMA_DOKTER);
        $("#slcWaktu").val(params.WAKTU_DIBERIKAN);
        $("#slcWaktuTgl").val(params.TGL_DIBERIKAN);
        $("#slcWaktuJam").val(params.JAM_DIBERIKAN);
        loaddataUddDetailById();
        document.getElementById("Udd_Qty").disabled = true;
        document.getElementById("slcDataObat").disabled = true;
        document.getElementById("BtnCreateHdrUdd").disabled = true;
        $("#btnSadas").hide();
    }
    
}
function GogetDataUddHeaderbyTrsid() {
    var IdTransaksi = $("#IdTransaksi").val();  
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/getDataUddHeaderbyTrsid';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdTransaksi=" + IdTransaksi
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
function PrintLabelPasien(idParams) {
    var notrs = btoa(idParams);
    var base_url = window.location.origin;
    window.open(base_url + "/SIKBREC/public/Udd/PrintLabelUDD/" + notrs, "_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}
// $("#Udd_Qty").keyup(function (e) { // Ketika user menekan tombol di keyboard
//     if (e.keyCode == 13) { // Jika user menekan tombol ENTER
//         goCreateDetilUdd();
//     }
// });

$('#btnVoidTrsReg').click(function () {
    voidTransaksiUDD();
});
async function voidTransaksiUDD() {
    try {
        const dataGovoidTransaksiUDD = await GovoidTransaksiUDD();
        updateUIdataGovoidTransaksiUDD(dataGovoidTransaksiUDD);

    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}

function updateUIdataGovoidTransaksiUDD(dataGovoidTransaksiUDD) {
    let params = dataGovoidTransaksiUDD;
    swal('Good job!', params.message + " !", "success")
        .then((value) => {
         
                MyBack();
            
        });
}
function MyBack() {
    const base_url = window.location.origin;
  
    window.location = base_url + "/SIKBREC/public/udd";
}
function GovoidTransaksiUDD() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/voidTransaksiUDD';
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
$('#BtnCreateHdrUdd').click(function () {
    goCreateHeaderUdd();
});
function Passingbatal() {
    var IdTransaksi = $("#IdTransaksi").val();  
    $("#noregbatal").val(IdTransaksi);
}
async function goCreateDetilUdd() {
    try {
        const dataCreateDetilUdd = await CreateDetilUdd();
        updateUIdatadataCreateDetilUdd(dataCreateDetilUdd);
        await loaddataUddDetailById();
    } catch (err) {
        toast(err, "error")
    }
}
function loaddataUddDetailById() {
    var base_url = window.location.origin;
    var IdTransaksi = $("#IdTransaksi").val();
    $('#tbl_aktif_detil').DataTable().clear().destroy();
    $('#tbl_aktif_detil').DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/Udd/loaddataUddDetailById",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.IdTransaksi = IdTransaksi; 
            }
        },
        "columns": [ 
            { "data": "ID_OBAT" },
            { "data": "NAMAOBA" },
            { "data": "QTy" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'deleteUddDetil("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-remove-circle"></span></button> '
                    return html
                }
            },

        ]
    });
}
async function deleteUddDetil(params){
    try {
        let dataid = params;
        const dataGodeleteUddDetil = await GodeleteUddDetil(dataid);
        updateUIdataGodeleteUddDetil(dataGodeleteUddDetil);
        await loaddataUddDetailById();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGodeleteUddDetil(params) {
    let response = params;
    toast(response.message, "success");
}
function GodeleteUddDetil(dataid) {
    var dataidx = dataid; 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/deleteUddDetil';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoIdUddDetail=" + dataidx
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
function updateUIdatadataCreateDetilUdd(params) {
    let response = params;
    toast(response.message,"success"); 
}
function CreateDetilUdd() {
    var IdTransaksi = $("#IdTransaksi").val();
    var slcDataObat = $("#slcDataObat").val();
    var Udd_Qty = $("#Udd_Qty").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/CreateDetilUdd';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdTransaksi=" + IdTransaksi + "&slcDataObat=" + slcDataObat + "&Udd_Qty=" + Udd_Qty 
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
async function goCreateHeaderUdd() {
    try {
        const dataCreateHeaderUdd = await CreateHeaderUdd();
        updateUIdataCreateHeaderUdd(dataCreateHeaderUdd);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataCreateHeaderUdd(params) {
    let response = params;
    $("#IdTransaksi").val(response.id);
    document.getElementById("BtnCreateHdrUdd").disabled = true;
    document.getElementById("btnSadas").disabled = true;
    document.getElementById("Udd_Qty").disabled = false;
    document.getElementById("slcDataObat").disabled = false;
    $("#btnSadas").hide();
}
function CreateHeaderUdd() {
    var str = $("#frmSimpanTrsUddHeader").serialize(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/CreateHeaderUdd';
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
function loaddataResep() {
    var base_url = window.location.origin;
    var txSearchData = $("#txSearchData").val();
    if (txSearchData == '' || txSearchData == null) {
        toast('Silahkan Isi Kata Kunci!', "warning")
        return false
    } 
    var jenisPencarian = $("#slcResep").val();
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/Udd/getListResepRanap",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.txSearchData = txSearchData; 
                d.jenisPencarian = jenisPencarian; 
            }
        },
        "columns": [
            { "data": "NoOrder" },
            { "data": "PatientName" },
            { "data": "TglOrder" },
            { "data": "NamaDokter" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showIDMR("' + row.NoOrder + '")\' value=' + row.NoOrder + '><span class="glyphicon glyphicon-log-in"></span></button> '
                    return html
                }
            },

        ]
    });
}
async function showIDMR(params) {
    try {
        const datax = await GogetListResepRanapSingle(params);
        updateUIGogetListResepRanapSingle(datax);
        const dataGogetListResepDetilByNoresep = await GogetListResepDetilByNoresep();
        updateUIGogetListResepDetilByNoresep(dataGogetListResepDetilByNoresep);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGogetListResepDetilByNoresep(datagetStatusHubunganKeluarga) {
    let responseApi = datagetStatusHubunganKeluarga;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#slcDataObat").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].KodeBarang + '">' + responseApi[i].NAMAOBAT + '</option';
            $("#slcDataObat").append(newRow);
        }
    }
}
function GogetListResepDetilByNoresep() {
    var base_url = window.location.origin;
    var Udd_No_Resep = $("#Udd_No_Resep").val();
    let url = base_url + '/SIKBREC/public/Udd/getListResepDetilByNoresep';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Udd_No_Resep=" + Udd_No_Resep
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
            $("#slcDataObat").select2();
        })
}
function updateUIGogetListResepRanapSingle(datax) {
    let data = datax;
    $("#Udd_NoEpisode").val(data.NoEpisode);
    $("#Udd_No_Registrasi").val(data.NoRegistrasi);
    $("#Udd_NOMR").val(data.NoMR);
    $("#Udd_No_Resep").val(data.orderid);
    $("#Udd_PasienIdJKel").val(data.Gander);
    $("#Udd_PasienNamaJKel").val(data.JKEL);
    $("#Udd_JenisResep").val(data.JenisResep);
    $("#Udd_PasienTglLahir").val(data.Date_of_birth);
    $("#Udd_PasienUsia").val(data.Usia);
    $("#Udd_PasienNama").val(data.PatientName); 
    $("#Udd_RoomName").val(data.RoomName);
    $("#Udd_Class").val(data.Class);
    $("#Udd_Bed").val(data.Bed);
    $("#Udd_Dokter").val(data.NamaDokter);
    document.getElementById("btnModalSrcPasienClose").click();
}
function GogetListResepRanapSingle(params) {
    var Udd_No_Resep = params; 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Udd/getListResepRanapSingle';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Udd_No_Resep=" + Udd_No_Resep
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
            // $("#Medical_Provinsi").select2();
        })
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