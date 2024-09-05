$(document).ready(function () {
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    // $('#excelLanscape').prop('disabled', true);
    $('#table').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListLmaPasien();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});

function excelLanscape() {
    var base_url = window.location.origin;
 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 

        window.location = base_url + "/SIKBREC/public/ExcelInfoLMA/ExcelInfoLMA2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
}

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
    $('#table').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#table').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationRadiologiGigi/getListData", // URL file untuk proses select datanya
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
           
               { "data": "mrn" }, // Tampilkan telepon
               { "data": "EPISODE_NUMBER" }, // Tampilkan alamat
               { "data": "NOREGISTRASI" },  // Tampilkan nama
               { "data": "ORDER_DATE" },  // Tampilkan nama
               { "data": "PATIENT_NAME" },  // Tampilkan nama
               { "data": "SCHEDULED_PROC_DESC" },  // 
               { "data": "NamaJaminan" },  // Tampilkan nama 
               { "data": "Tarif" },  // Tampilkan nama 
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
            ]
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}