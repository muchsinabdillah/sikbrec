$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#btnLoadInformation').prop('disabled', true);
    $('#permintaanrawat_all').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListLmaPasien();
    });
});

function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if(Difference_In_Days > 30 ){
    //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
    //     $('#btnLoadInformation').prop('disabled', true);
    // }else{
    //     $('#btnLoadInformation').prop('disabled', false);
    // }
 }

function getDataListLmaPasien() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationBPJS/getDataMonitoringBPJS", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "NO_SEP"},
            { "data": "NO_REGISTRASI"},
            { "data": "NAMA_PESERTA"},
            { "data": "NAMA_POLI"},
            { "data": "NAMA_DOKTER"},
            { "data": "TGL_SEP"},
            { "data": "Task1"},
            { "data": "Task2"},
            { "data": "Task3"},
            { "data": "Task4"},
            { "data": "Task5"},
            { "data": "Task6"},
            { "data": "Task7"},
           ],
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}