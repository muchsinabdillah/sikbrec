$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    $('#examplex').DataTable({});
    $(document).on('click', '#btnTampilkan', function () {
        showdatatabel(); 
    });
});

async function asyncShowMain() {
    await showdatatabel();
}
function showdatatabel() {
    let jenis_rawat, date_type ,laporan_start_dttm, laporan_stop_dttm,payor_id,kelas_rawat,discharge_status,Severity,kode_tarif,cob_cd,laporan_grouping_start_dttm,laporan_grouping_stop_dttm,Petugas,Urutkan;
    jenis_rawat = $("#jenis_rawat").val();
    date_type = $("#date_type").val();
    laporan_start_dttm = $("#laporan_start_dttm").val();
    laporan_stop_dttm = $("#laporan_stop_dttm").val();
    payor_id = $("#payor_id").val();
    kelas_rawat = $("#kelas_rawat").val();
    discharge_status = $("#discharge_status").val();
    Severity = $("#Severity").val();
    kode_tarif = $("#kode_tarif").val();
    cob_cd = $("#cob_cd").val();
    laporan_grouping_start_dttm = $("#laporan_grouping_start_dttm").val();
    laporan_grouping_stop_dttm = $("#laporan_grouping_stop_dttm").val();
    Petugas = $("#Petugas").val();
    Urutkan = $("#Urutkan").val();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#examplex').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#examplex').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/laporanklaim",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                d.jenis_rawat = jenis_rawat;
                d.date_type = date_type;
                d.laporan_start_dttm = laporan_start_dttm;
                d.laporan_stop_dttm = laporan_stop_dttm;
                d.payor_id = payor_id;
                d.kelas_rawat = kelas_rawat;
                d.discharge_status = discharge_status;
                d.Severity = Severity;
                d.kode_tarif = kode_tarif;
                d.cob_cd = cob_cd;
                d.laporan_grouping_start_dttm = laporan_grouping_start_dttm;
                d.laporan_grouping_stop_dttm = laporan_grouping_stop_dttm;
                d.Petugas = Petugas;
                d.Urutkan = Urutkan;
            },
            "deferRender": true,
        },
        "columns": [

            { "data": "No" },
            { "data": "Tgl_masuk" },
            { "data": "Tgl_pulang" },
            { "data": "SEP" },
            { "data": "Pasien" },
            { "data": "Kode" },
            { "data": "Tarif_total" },
            { "data": "Billing_rs" },
            { "data": "Rawat" },
            { "data": "Petugas" },            
            
        ]
    });
}