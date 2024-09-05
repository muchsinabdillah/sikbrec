$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListPasien();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});

function excelLanscape() {
    var base_url = window.location.origin;
 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 
  
        window.location = base_url + "/SIKBREC/public/ExcelInfoSuketCovid/ExcelInfoSuketCovid2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
}

function getDataListPasien() { 
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
               "url": base_url + "/SIKBREC/public/bInformationRiwayatImunisasi/getDataListPasien", // URL file untuk proses select datanya
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
            { "data": "NamaPasien" }, 
            { "data": "NoMR" },
            { "data": "JenisImunisasi" },  
            { "data": "O" }, 
            { "data": "I" }, 
            { "data": "II" }, 
            { "data": "III" }, 
            { "data": "Booster_I" }, 
            { "data": "Booster_II" }, 
            { "data": "Bosster_III" }, 
            //  { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            //       var html = ""
                   
            //         var html  = row.TglInput+' '+row.JamInput;
            //            return html 
            //     }
            // },   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });
} 