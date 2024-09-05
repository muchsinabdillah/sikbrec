$(document).ready(function () {
    $(".preloader").fadeOut();
});
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MJenisPelayananBPJS = document.getElementById("MJenisPelayananBPJS").value;
    var MJenisStatusPelayananBPJS = document.getElementById("MJenisStatusPelayananBPJS").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringDataKlaimBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MJenisPelayananBPJS = MJenisPelayananBPJS;
                d.MJenisStatusPelayananBPJS = MJenisStatusPelayananBPJS;
            }
        },
        "columns": [
            { "data": "noSEP" },
            { "data": "pesertanoKartu" },
            { "data": "pesertanoMR" },
            { "data": "noFPK" },
            { "data": "tglSep" },
            { "data": "tglPulang" },
            { "data": "pesertanama" },
            { "data": "jenisPelayanan" },
            { "data": "kodediagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" },
            { "data": "status" },
            { "data": "biayabyPengajuan" },
            { "data": "biayabySetujui" },
            { "data": "biayabyTarifGruper" },
            { "data": "biayabyTarifRS" },
            { "data": "biayabyTopup" }, 
        ]
    });

}
function showNoSEP(noSEP) {
    $("#modal_UpdateTglPulang").modal('show');
    $("#MNoSEPBPJS").val(noSEP);
}
function ShowDataPasienPoliklinik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/";
}