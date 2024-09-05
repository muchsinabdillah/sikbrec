$(document).ready(function () {
    console.log("aaaaaaa")
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
    $(document).on('click', '#btnclosemodalcetak', function () {
        MyBack();
    })
    onLoadFunctionAll();
    //add bpjs
    $('#BPJS_cariPoliBPJSx').on('select2:select', function (e) {
        var data = e.params.data;

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
});
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
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan
            + "&noreg=" + noreg
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
async function setDataPoli() {
    try {
        $(".preloader").fadeIn();
        const datasetDataSEPRujukanByID = await setDataSEPRujukanByID();
        updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID);
        const datagetNoSEPDetilxSIMRS = await getNoSEPDetilSIMRS();
        updateUIgetNoSEPDetilSIMRS(datagetNoSEPDetilxSIMRS);
        const datagetNoregistrasiByNoregistrasi = await getNoregistrasiByNoregistrasi();
        updateUIdatagetNoregistrasiByNoregistrasi(datagetNoregistrasiByNoregistrasi);
      //  console.log("datagetNoregistrasiByNoregistrasi", datagetNoregistrasiByNoregistrasi);
        const datasetDataPoli = await setDataPoliklinik();
        UpdateUIsetDataPoli(datasetDataPoli);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function getNoregistrasiByNoregistrasi() {
    var SIMRS_Registrasi = $("#SIMRS_Registrasi").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + SIMRS_Registrasi
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
function updateUIdatagetNoregistrasiByNoregistrasi(data) {
   // $("#SIMRS_ID").val(data.ID);
    $("#SIMRS_NoMR").val(data.NoMR);
    $("#SIMRS_NoEpisode").val(data.NoEpisode);
    $("#SIMRS_TglBerobat").val(data.VisitDate);
    $("#SIMRS_TglPulang").val(data.VisitDate);
}
function updateUIgetNoSEPDetilSIMRS(data) {
    $("#SIMRS_NamaPasien").val(data.NAMA_PESERTA);
    $("#SIMRS_Registrasi").val(data.NO_REGISTRASI);
    $("#SIMRS_RoomPoliAkhir").val(data.NAMA_POLI);
    $("#SIMRS_Poli").val(data.NAMA_POLI);
    $("#SIMRS_Dokter").val(data.NAMA_DOKTER);
    // $('#isJenisPelayananBPJS').val(data.KODE_JENIS_RAWAT).trigger('change');



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
function updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID) {
    let data = datasetDataSEPRujukanByID.hasil;
    console.log(data)
    $("#BPJS_NoSEP").val(data.noSep);
    $("#BPJS_NoKartu").val(data.peserta.noKartu);
    $("#BPJS_Diagnosa").val(data.diagnosa);
    $("#SIMRS_JENIS_SEP").val(data.jnsPelayanan);
    if (data.jnsPelayanan == "Rawat Inap"){
 
        swal("Oops", "Sorry... SEP Rawat Inap Silahkan Gunakan Form Rencana Kontrol Pasca Rawat. ", "error")
            .then((value) => {
                MyBack();
            });
    }

}
function setDataSEPRujukanByID() {
    var base_url = window.location.origin;
    var BPJS_NoSEP = $("#BPJS_NoSEP").val();
    let url = base_url + '/SIKBREC/public/aKontrolUlang/setDataSEPRujukanByID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoSEP=' + BPJS_NoSEP
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
    $('#BPJS_NoRencKontrol').val(params.hasil);
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
    var SIMRS_JENIS_SEP = document.getElementById("SIMRS_JENIS_SEP").value;
    var SIMRS_Registrasi = document.getElementById("SIMRS_Registrasi").value;
    
    var jenisTrs = "Insert";
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
async function onLoadFunctionAll() {
    try {
        // const datagetDataSPRDetail = await getDataSPRDetail();
        // updateUIgetDataSPRDetail(datagetDataSPRDetail); 
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateUIgetDataSPRDetail(datagetDataSPRDetail) {
    let data = datagetDataSPRDetail.data;
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
    $('#SIMRS_IDJNS').val("RANAP").trigger('change');
    //$("#BPJS_NoSEP").val(data.NoSEP);
}
function getDataSPRDetail() {
    var base_url = window.location.origin;
    var id = $("#SIMRS_ID").val();
    let url = base_url + '/SIKBREC/public/aKontrolUlang/getDataRencanaKontrolDetail/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + id
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
            $("#TipePenjamin").select2();
            $("#JenisRawat").select2();
            $("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            console.log(err, "error")
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aKontrolUlang";
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
function GoMonitoringBPJS() {

    var SIMRS_TglKontrol = document.getElementById("SIMRS_TglKontrol").value;

    if (SIMRS_TglKontrol == "") {
        swal("Oops", "Sorry... Masukan Tanggal Rencana Kontrol !", "error");
        $(".preloader").fadeOut();
    } else {
        var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
        var MTglKunjunganBPJS_akhir = $("[name='MTglKunjunganBPJS_akhir']").val();
        var MNoKartuPeserta = document.getElementById("MNoKartuPeserta").value;
        // var MJenisPelayananBPJS = document.getElementById("isJenisPelayananBPJS").value;
        var base_url = window.location.origin;
        $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
        $('#tbl_kunjungan_monitoring').DataTable({
            "ordering": false,
            //"order": [[ 2, "desc" ]],
            "ajax": {
                "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringHistoriPelayananBPJS",
                "dataSrc": "",
                "deferRender": true,
                "type": "POST",
                data: function (d) {
                    d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                    d.MTglKunjunganBPJS_akhir = MTglKunjunganBPJS_akhir;
                    // d.MJenisPelayananBPJS = MJenisPelayananBPJS;
                    d.MNoKartuPeserta = MNoKartuPeserta;
                }
            },
            "columns": [
                { "data": "noSep" },
                { "data": "noRujukan" },
                { "data": "tglSep" },
                { "data": "namaPeserta" },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        if (row.jnsPelayanan == "1") {
                            var html = ""
                            var html = 'Rawat Inap';
                            return html
                        } else {
                            var html = ""
                            var html = 'Rawat Jalan';
                            return html
                        }

                    }
                },
                { "data": "diagnosa" },
                { "data": "kelasRawat" },
                { "data": "poli" },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        if (row.tglPlgSep == null) {
                            var html = ""
                            var html = '<span class="label label-danger" onclick=\'showNoSEP("' + row.noSep + '")\'> UPDATE TANGGAL PULANG</span> ';
                            return html
                        } else {
                            var html = ""
                            var html = '<font size="1"> ' + row.nama + ' </font> <br><br><span class="label label-info">' + row.nama + '</span> ';
                            return html
                        }

                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                        var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPasienPoliklinik("' + row.noSep + '","' + row.noKartu + '")\' ><span class="visible-content" > Pilih </span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                        return html
                    }
                },
            ]
        });
    }


}
function ShowDataPasienPoliklinik(nosep, nokartu) {
    $("#BPJS_NoSEP").val(nosep);

    $("#modal_Pengajuan").modal('hide');
    setDataPoli();
}
function GetKetersediaanPoliklinik() {
    var SPRI_NoKartu2 = document.getElementById("BPJS_NoSEP").value;
    var SPRI_KodeJenisKontrol = document.getElementById("BPJS_KodeJenisKontrol").value;
    var SPRI_TglRencanaKontrol = document.getElementById("SIMRS_TglKontrol").value;
    var base_url = window.location.origin;

    if (SPRI_NoKartu2 == "") {
        swal("Oops", "Sorry... No. Sep Harus Diisi !", "error");
    } else {
        $('#tbl_Ketersediaan_Poli').DataTable().clear().destroy();
        $('#tbl_Ketersediaan_Poli').DataTable({
            "ordering": false,
            //"order": [[ 2, "desc" ]],
            "ajax": {
                "url": base_url + "/SIKBREC/public/xBPJSBridging/GetKetersediaanPoliklinikInternal",
                "dataSrc": "",
                "deferRender": true,
                "type": "POST",
                data: function (d) {
                    d.SPRI_NoKartu2 = SPRI_NoKartu2;
                    d.SPRI_KodeJenisKontrol = SPRI_KodeJenisKontrol;
                    d.SPRI_TglRencanaKontrol = SPRI_TglRencanaKontrol;
                }
            },
            "columns": [
                { "data": "kodePoli" },
                { "data": "namaPoli" },
                { "data": "kapasitas" },
                { "data": "jmlRencanaKontroldanRujukan" },
                { "data": "persentase" },
            ]
        });
    }
}