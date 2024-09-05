$(document).ready(function () {
    $('#logocetakbuktiSEP').click(function () { 
        $('#notif_ShowTTD_Digital').modal('show');
        $('#notif_Cetak').modal('hide');
        var pxNoRegistrasi = $("#pxNoRegistrasi").val();
        var pxNoSep = $("#SPRI_NoSPR2BPJS").val();
        $("#signNoRegistrasi").val(pxNoRegistrasi);
        $("#signNoSep").val(pxNoSep);
        //document.getElementById("btncetakDigital").disabled = true;
    });
    $('#btncetakDigital').click(function () {
        goCountCetak();
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
    $('#cariPoliklinikBPJS').on('select2:select', function (e) {
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
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#SPRI_NoSPR2BPJS").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var SPRI_NoRegistrasi2 = $("#SPRI_NoRegistrasi2").val();
        var jeniscetakan = "SPRI";
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, jeniscetakan, SPRI_NoRegistrasi2);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs, SPRI_NoRegistrasi2);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUiSukseshistory(params, notrs, SPRI_NoRegistrasi2) {
    if (params.status === 200) {
        var notrs = $("#SPRI_NoSPR2BPJS").val();
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSPRI/" + notrs + "/" + SPRI_NoRegistrasi2, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        MyBack();
    }

}
function CountCetak(notrs, signAlasanCetak, jeniscetakan, SPRI_NoRegistrasi2) {
    var nomortransaksi = $("#SPRI_NoSPR2BPJS").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan
            + "&noreg=" + SPRI_NoRegistrasi2
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
    var SPRI_NoRegistrasi = document.getElementById("SPRI_NoRegistrasi2").value;
    var alasanbatal = document.getElementById("alasanbatal").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/goBatalSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NOspri=' + NOspri + '&alasanbatal=' + alasanbatal + '&NoRegistrasi=' + SPRI_NoRegistrasi
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
    var SPRI_NoRegistrasi2 = document.getElementById("SPRI_NoRegistrasi2").value;
    var jenisTrs ="Update";
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
            + '&SPRI_NoRegistrasi2=' + SPRI_NoRegistrasi2
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
    var JenisRujukanFaskesBPJSx = $("#JenisRujukanFaskesBPJSx").val();
    //$("#SPRI_NoKartu2").val(kodePeserta);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekKepesertaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta + "&JenisRujukanFaskesBPJSx=" + JenisRujukanFaskesBPJSx
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
async function onLoadFunctionAll() {
    try {
        const datagetDataSPRI = await getDataSPRI();
        updateUIdatagetDataSPRI(datagetDataSPRI);
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        const datagetPoliklinikSPRI = await getPoliklinikSPRI();
        UpdateUIdatagetPoliklinikSPRI(datagetPoliklinikSPRI);
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateUIdatagetDataSPRI(datagetDataSPRI) {
    let data = datagetDataSPRI.data; 
    $("#SPRI_NoSPR2").val(data.NO_SPR_SIMRS);
    $("#SPRI_NoRM2").val(data.NoMR);
    $("#SPRI_Noepisode2").val(data.NoEpisode);
    $("#SPRI_NoRegistrasi2").val(data.NOREGISTRASI);
    $("#SPRI_DPJPRanap2").val(data.DokterPemeriksa);
    $("#SPRI_Tujuan2").val(data.JenisRawat);
    $("#SPRI_NamaPasien2").val(data.NAMA_PASIEN);
    $("#SPRI_Tglberobat2").val(data.TGL_REG_IGD);
    $("#SPRI_NoKartu2").val(data.NO_KARTU);
    $("#SPRI_TglRencanaKontrol").val(data.TGL_RENCANA_KONTROL);
    $("#KodePoliklinikBPJS").val(data.KODE_POLI);
    $("#NamaPoliklinikBPJS").val(data.NAMA_POLI);
    $("#KodeDokterBPJS").val(data.KODE_DOKTER);
    $("#NamaDokterBPJS").val(data.NAMA_DOKTER);
    $("#SPRI_NoSEP").val(data.NO_SEP);
    if (data.STATUS =="1"){
        swal("Oops", "Sorry.. No. SIPR Sudah Tidak Aktif !", "error");
    }
  //  $('#modal_BPJSCekPesertaa').modal('show');


}
function getDataSPRI() {
    var base_url = window.location.origin; 
    var noSPRBPJS = $("#SPRI_NoSPR2BPJS").val();
    let url = base_url + '/SIKBREC/public/SPRI/getDataSPRI/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noSPRBPJS=' + noSPRBPJS
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
function GetKetersediaanPoliklinik() {
    var SPRI_NoKartu2 = document.getElementById("SPRI_NoKartu2").value;
    var SPRI_KodeJenisKontrol = document.getElementById("SPRI_KodeJenisKontrol").value;
    var SPRI_TglRencanaKontrol = document.getElementById("SPRI_TglRencanaKontrol").value;
    var base_url = window.location.origin;

    if (SPRI_TglRencanaKontrol == "") {
        swal("Oops", "Sorry... tgl Rencana Kontrol Harus Diisi !", "error");
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