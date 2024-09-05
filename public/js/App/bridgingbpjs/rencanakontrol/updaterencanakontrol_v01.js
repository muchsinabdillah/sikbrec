$(document).ready(function () {
    $('#logocetakbuktiSEP').click(function () {
        $('#notif_ShowTTD_Digital').modal('show');
        $('#notif_Cetak').modal('hide');
        // var pxNoRegistrasi = $("#pxNoRegistrasi").val();
        var pxNoSep = $("#BPJS_NoRencKontrol").val();
        console.log("pxNoSep", pxNoSep);
        //$("#signNoRegistrasi").val(pxNoRegistrasi);
        $("#signNoSep").val(pxNoSep);
        // document.getElementById("btncetakSep").disabled = true;

        

    });
    $('#btncetakDigital').click(function () {
        goCountCetak();
    });
    $('#btnsimpan').click(function () {
        swal({
            title: "BPJS",
            text: "Apakah Anda ingin Simpan Rencana Kontrol BPJS ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateRencanaKontrol();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });
    $(document).on('click', '#btnBatalSIPR', function () {
        batalSPRI();
    });
    $(document).on('click', '#btnclosemodalcetak', function () {
        MyBack();
    })
    onLoadFunctionAll();
    $(document).on('click', '#btnCloseVerifikasi', function () {
        MyBack();
    });
    //  $(document).on('click', '#btnCekKepesertaan', function () {
    // BPJSCekKepesertaan();
    // });

    //add bpjs
    $('#BPJS_cariPoliBPJSx').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodePoliklinikBPJS").val(data.id);
        $("#NamaPoliklinikBPJS").val(data.text);
    });
    //add bpjs
    $('#cariDokterBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodeDokterBPJS").val(data.id);
        $("#NamaDokterBPJS").val(data.text);
    });
    $('#savetrs').click(function () {
        swal({
            title: "SPRI",
            text: "Apakah Anda ingin Simpan SPRI BPJS ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateSPRI();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });
});
async function goCreateRencanaKontrol() {
    try {
        $(".preloader").fadeIn();
        const dataCreateRencanaKontrol = await CreateRencanaKontrol();
        console.log("dataCreateRencanaKontrol", dataCreateRencanaKontrol)
        updateUICreateRencanaKontrol(dataCreateRencanaKontrol);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUICreateRencanaKontrol(params) {
    $('#SPRI_NoSPR2BPJS').val(params.hasil);
    swal("Success", "Rencana Kontrol Berhasil Dibuat !", "success")
        .then((value) => {
            $('#notif_Cetak').modal('show');
            //MyBack();
        });
}
function CreateRencanaKontrol() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("BPJS_KodeJenisKontrol").value;
    var nomor = document.getElementById("BPJS_NoKartu").value;
    var TglRegIGD = document.getElementById("SIMRS_TglBerobat").value;
    var TglRencanaKontrol = document.getElementById("SIMRS_TglKontrol").value;
    var KodePoliklinikBPJS = document.getElementById("KodePoliklinikBPJS").value;
    var KodeDokterBPJS = document.getElementById("KodeDokterBPJS").value;
    var SPRI_NoSPR2 = document.getElementById("SIMRS_ID").value;
    var SPRI_NoSPR2BPJS = document.getElementById("BPJS_NoRencKontrol").value;
    var SPRI_NoSEP = document.getElementById("BPJS_NoSEP").value;
    var NamaPoliklinikBPJS = document.getElementById("NamaPoliklinikBPJS").value;
    var NamaDokterBPJS = document.getElementById("NamaDokterBPJS").value;
    var SIMRS_JENIS_SEP = document.getElementById("SIMRS_JENIS_SEP").value;
    var SIMRS_Registrasi = document.getElementById("SIMRS_Registrasi").value;
    var jenisTrs = "Update";
    let url = base_url + '/SIKBREC/public/aKontrolUlang/CreateKontrolUlang';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
            + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS + '&KodeDokterBPJS=' + KodeDokterBPJS
            + '&SPRI_NoSPR2=' + SPRI_NoSPR2
            + '&jenisTrs=' + jenisTrs
            + '&TglRegIGD=' + TglRegIGD
            + '&NamaPoliklinikBPJS=' + NamaPoliklinikBPJS
            + '&NamaDokterBPJS=' + NamaDokterBPJS
            + '&SPRI_NoSPR2BPJS=' + SPRI_NoSPR2BPJS
            + '&SPRI_NoSEP=' + SPRI_NoSEP
            + '&SIMRS_JENIS_SEP=' + SIMRS_JENIS_SEP
            + '&SIMRS_Registrasi=' + SIMRS_Registrasi
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
            //$("#cariDokterBPJS").select2();
        })
}
async function batalSPRI() {
    try {
        $(".preloader").fadeIn();
        const datagoBatalSPRI = await goBatalSPRI();
        console.log("datagoBatalSPRI", datagoBatalSPRI)
        UpdateUIdatagoBatalSPRI(datagoBatalSPRI);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UpdateUIdatagoBatalSPRI(data) {
    swal("Success ", "Data SIPR Sukses Dihapus !", "success")
        .then((value) => {
            MyBack();
            $("#modal_UpdateTglPulang").modal('hide');
        });
}
function goBatalSPRI() {
    var base_url = window.location.origin;
    var NOspri = document.getElementById("NOspri").value;
    var alasanbatal = document.getElementById("alasanbatal").value;
    var NoRegistrasi = document.getElementById("SIMRS_Registrasi").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/goBatalSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NOspri=' + NOspri + '&alasanbatal=' + alasanbatal + '&NoRegistrasi=' + NoRegistrasi
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
            //$("#cariDokterBPJS").select2();
        })
}
function getPoliklinikSPRI() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("SPRI_KodeJenisKontrol").value;
    var nomor = document.getElementById("SPRI_NoKartu2").value;
    var TglRencanaKontrol = document.getElementById("SPRI_Tglberobat2").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoGetPoliklinikBPJSSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
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
            $("#cariPoliklinikBPJS").select2();
        })
}
async function BPJSCekKepesertaan() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        const datagetPoliklinikSPRI = await getPoliklinikSPRI();
        UpdateUIdatagetPoliklinikSPRI(datagetPoliklinikSPRI);
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
async function goCreateSPRI() {
    try {
        $(".preloader").fadeIn();
        const dataCreateSPRI = await CreateSPRI();
        console.log("dataCreateSPRI", dataCreateSPRI)
        updateUIdataCreateSPRI(dataCreateSPRI);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataCreateSPRI(params) {
    // $('#SPRI_NoSPR2BPJS').val(params.hasil);
    swal("Success", "SPRI Berhasil Dirubah !", "success")
        .then((value) => {
            $('#notif_Cetak').modal('show');
            //MyBack();
        });
}
function CreateSPRI() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("SPRI_KodeJenisKontrol").value;
    var nomor = document.getElementById("SPRI_NoKartu2").value;
    var TglRegIGD = document.getElementById("SPRI_Tglberobat2").value;
    var TglRencanaKontrol = document.getElementById("SPRI_TglRencanaKontrol").value;
    var KodePoliklinikBPJS = document.getElementById("KodePoliklinikBPJS").value;
    var KodeDokterBPJS = document.getElementById("KodeDokterBPJS").value;
    var SPRI_NoSPR2 = document.getElementById("SPRI_NoSPR2").value;
    var SPRI_NoSPR2BPJS = document.getElementById("SPRI_NoSPR2BPJS").value;
    var SPRI_NoSEP = document.getElementById("SPRI_NoSEP").value;
    var NamaPoliklinikBPJS = document.getElementById("NamaPoliklinikBPJS").value;
    var NamaDokterBPJS = document.getElementById("NamaDokterBPJS").value;
    var jenisTrs = "Update";
    let url = base_url + '/SIKBREC/public/xBPJSBridging/CreateSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
            + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS + '&KodeDokterBPJS=' + KodeDokterBPJS
            + '&SPRI_NoSPR2=' + SPRI_NoSPR2
            + '&jenisTrs=' + jenisTrs
            + '&TglRegIGD=' + TglRegIGD
            + '&NamaPoliklinikBPJS=' + NamaPoliklinikBPJS
            + '&NamaDokterBPJS=' + NamaDokterBPJS
            + '&SPRI_NoSPR2BPJS=' + SPRI_NoSPR2BPJS
            + '&SPRI_NoSEP=' + SPRI_NoSEP
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
            //$("#cariDokterBPJS").select2();
        })
}
async function GoCariDokterSPRI() {
    try {
        $(".preloader").fadeIn();
        const datagetDokterbyKodePoliSPRI = await getDokterbyKodePoliSPRI();
        UpdateUIdatagetDokterbyKodePoliSPRI(datagetDokterbyKodePoliSPRI);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UpdateUIdatagetDokterbyKodePoliSPRI(datagetDokterbyKodePoliSPRI) {
    let responseApi = datagetDokterbyKodePoliSPRI;
    $("#cariDokterBPJS").empty();
    console.log("responseApi", responseApi)
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariDokterBPJS").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariDokterBPJS").append(newRow);
        }
    }
}

function getDokterbyKodePoliSPRI() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("SPRI_KodeJenisKontrol").value;
    var nomor = document.getElementById("SPRI_NoKartu2").value;
    var TglRencanaKontrol = document.getElementById("SPRI_Tglberobat2").value;
    var KodePoliklinikBPJS = document.getElementById("KodePoliklinikBPJS").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/getDokterbyKodePoliSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
            + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS
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
            $("#cariDokterBPJS").select2();
        })
}
function UpdateUIdatagetPoliklinikSPRI(datagetPoliklinikSPRI) {
    let responseApi = datagetPoliklinikSPRI;
    console.log("responseApi", responseApi)
    $("#cariPoliklinikBPJS").empty();
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariPoliklinikBPJS").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariPoliklinikBPJS").append(newRow);
        }
    }
}
function updateUIdataGoBPJSCekKepesertaan(data) {
    if (data.hasil[1].peserta.statusPeserta.keterangan == "AKTIF") {
        swal("Success ", "Data Kesertaan " + data.hasil[1].peserta.statusPeserta.keterangan, "success")
            .then((value) => {
                $('#modal_BPJSCekPesertaa').modal('hide');
            });
    } else {
        swal("Ooops ", "Data Kesertaan " + data.hasil[1].peserta.statusPeserta.keterangan, "error")
            .then((value) => {
                swal('Pendaftaran Tidak Bisa DiLanjutkan !');
            });




    }
    $('#modal_BPJSCekPesertaa').modal('hide');
}

function GoBPJSCekKepesertaan() {
    var jenisPencarian = "2";
    var kodePeserta = $("#SPRI_NoKartu2").val();
    //$("#SPRI_NoKartu2").val(kodePeserta);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekKepesertaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta
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
function updateUIgetNoSEPDetilSIMRS(data) {
    $("#BPJS_NoKartu").val(data.NO_KARTU); 
    // $('#isJenisPelayananBPJS').val(data.KODE_JENIS_RAWAT).trigger('change');



}
async function onLoadFunctionAll() {
    try {
        const datagetDataRencanaKontrolbyID = await getDataRencanaKontrolbyID(); 
        updateUIdatagetDataRencanaKontrolbyID(datagetDataRencanaKontrolbyID);

            const datagetDataRencanaKontrolbyIDBPJS= await getDataRencanaKontrolbyIDBPJS();
            updateUIdatagetDataRencanaKontrolbyIDBPJS(datagetDataRencanaKontrolbyIDBPJS);

        const datagetNoSEPDetilxSIMRS = await getNoSEPDetilSIMRS();
        updateUIgetNoSEPDetilSIMRS(datagetNoSEPDetilxSIMRS);


            const datasetDataPoli = await setDataPoliklinik();
            UpdateUIsetDataPoli(datasetDataPoli);
        //console.log(datagetDataRencanaKontrolbyIDBPJS);
        //const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        //const datagetPoliklinikSPRI = await getPoliklinikSPRI();
        //UpdateUIdatagetPoliklinikSPRI(datagetPoliklinikSPRI);
        //updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}

function UpdateUIsetDataPoli(datasetDataPoli) {
    let responseApi = datasetDataPoli;
    console.log("responseApi", responseApi)
    $("#BPJS_cariPoliBPJSx").empty();
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#BPJS_cariPoliBPJSx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#BPJS_cariPoliBPJSx").append(newRow);
        }
    }
}
function setDataPoliklinik() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("BPJS_KodeJenisKontrol").value;
    var nomor = document.getElementById("BPJS_NoSEP").value;
    var TglRencanaKontrol = document.getElementById("SIMRS_TglKontrol").value;
    console.log("TglRencanaKontrol", TglRencanaKontrol)
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoGetPoliklinikBPJSSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
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
            $("#BPJS_cariPoliBPJSx").select2();
        })
}
async function GoCariDokterKontrol() {
    try {
        $(".preloader").fadeIn();
        const datagetDokterbyKodePoliSPRI = await getDoktersbyKodePoliSPRI();
        UpdateUIdatagetDokterbyKodePoliSPRI(datagetDokterbyKodePoliSPRI);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UpdateUIdatagetDokterbyKodePoliSPRI(datagetDokterbyKodePoliSPRI) {
    let responseApi = datagetDokterbyKodePoliSPRI;
    $("#cariDokterBPJS").empty();
    console.log("responseApi", responseApi)
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariDokterBPJS").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariDokterBPJS").append(newRow);
        }
    }
}
function getDoktersbyKodePoliSPRI() {
    var base_url = window.location.origin;
    var JnsKontrol = document.getElementById("BPJS_KodeJenisKontrol").value;
    var nomor = document.getElementById("BPJS_NoKartu").value;
    var TglRencanaKontrol = document.getElementById("SIMRS_TglKontrol").value;
    var KodePoliklinikBPJS = document.getElementById("BPJS_cariPoliBPJSx").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/getDokterbyKodePoliSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
            + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS
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
            $("#cariDokterBPJS").select2();
        })
}
function updateUIdatagetDataRencanaKontrolbyIDBPJS(datagetDataRencanaKontrolbyIDBPJS) {
    let data = datagetDataRencanaKontrolbyIDBPJS.data;
    $("#SIMRS_ID").val(data.ID);
    $("#SIMRS_TglKontrol").val(data.TglKontrol);
    $("#SIMRS_Jam").val(data.Jam);
    $("#SIMRS_NamaPasien").val(data.PatientName);
    $("#SIMRS_NoMR").val(data.NoMR);
    $("#SIMRS_NoEpisode").val(data.NoEpisode);
    $("#SIMRS_Registrasi").val(data.NoRegistrasi);
    $("#SIMRS_Poli").val(data.PoliKlinik);
    $("#SIMRS_Dokter").val(data.Dokter);
    $("#SIMRS_Ket").val(data.Keterangan);
    $("#SIMRS_NoReservasi").val(data.NoReservasi);
    $("#SIMRS_TglPulang").val(data.TglPulang);
    $("#SIMRS_TglBerobat").val(data.TglBerobat);
    $("#SIMRS_RoomPoliAkhir").val(data.RoomName);
    $("#BPJS_NoSEP").val(data.NoSEP);
    
    //$("#BPJS_NoSEP").val(data.NoSEP);
} 
function getDataRencanaKontrolbyIDBPJS() {
    var base_url = window.location.origin;
    var BPJS_NoRencKontrol = $("#BPJS_NoRencKontrol").val();
    let url = base_url + '/SIKBREC/public/aKontrolUlang/getDataRencanaKontrolbyIDBPJS/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoRencKontrol=' + BPJS_NoRencKontrol
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
function updateUIdatagetDataRencanaKontrolbyID(datagetDataRencanaKontrolbyID) {
    let data = datagetDataRencanaKontrolbyID.hasil;
    console.log(data)
    //$("#BPJS_NoSEP").val(data.sep.noSep);
    $("#KodePoliklinikBPJS").val(data.poliTujuan);
  //  $("#NamaPoliklinikBPJS").val(data.namaPoliTujuan);
    $("#KodeDokterBPJS").val(data.kodeDokter);
    $("#NamaDokterBPJS").val(data.namaDokter);
    $("#SIMRS_TglKontrol").val(data.tglRencanaKontrol);
    $("#SIMRS_JENIS_SEP").val(data.sep.jnsPelayanan);
    $("#BPJS_NoSEP").val(data.sep.noSep);


}
function getDataRencanaKontrolbyID() {
    var base_url = window.location.origin;
    var BPJS_NoRencKontrol = $("#BPJS_NoRencKontrol").val();
    let url = base_url + '/SIKBREC/public/aKontrolUlang/GetRencanaKontrolbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoRencKontrol=' + BPJS_NoRencKontrol
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/SPRI/list";
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
 
function getNoSEPDetilSIMRS() {
    var nomortransaksi = $("#BPJS_NoSEP").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/setDataSEPSIMRS/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoSEP=' + nomortransaksi
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#BPJS_NoRencKontrol").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var jeniscetakan = "RENCANAKONTROL";
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, jeniscetakan);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUiSukseshistory(params, notrs) {
    if (params.status === 200) {
        var notrs = $("#BPJS_NoRencKontrol").val();
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aKontrolUlang/PrintRencanaKontrol/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        MyBack();
    }

}
function CountCetak(notrs, signAlasanCetak, jeniscetakan) {
    var nomortransaksi = $("#SPRI_NoSPR2BPJS").val();
    var noreg = "";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan + "&noreg=" + noreg
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
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}