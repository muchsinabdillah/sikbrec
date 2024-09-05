$(document).ready(function () {
    $(".preloader").fadeOut();
});
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjunganBPJS_akhir = document.getElementById("MTglKunjunganBPJS_akhir").value;
    var MNoKartuPeserta = document.getElementById("MNoKartuPeserta").value;
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
                d.MNoKartuPeserta = MNoKartuPeserta;
            }
        },
        "columns": [
            { "data": "noSep" },
            { "data": "noKartu" },
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
            { "data": "tglPlgSep" },
            { "data": "ppkPelayanan" }, 
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