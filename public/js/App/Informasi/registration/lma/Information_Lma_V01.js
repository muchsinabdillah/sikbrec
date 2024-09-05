$(document).ready(function () {
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    // $('#excelLanscape').prop('disabled', true);
    $('#permintaanrawat_all').DataTable({});
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
    $('#permintaanrawat_all').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#permintaanrawat_all').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationLma/getDataListLmaPasien", // URL file untuk proses select datanya
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
           
               { "data": "NoMR" }, // Tampilkan telepon
               { "data": "PatientName" }, // Tampilkan alamat
               { "data": "VisitDate" },  // Tampilkan nama
               { "data": "NoRegistrasi" },  // Tampilkan nama 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                       if(row.Status == "Close"){ 
                           var html  = '<span class="badge badge-secondary">'+row.Status+'</span> '
                       }else if(row.Status == "New"){ // Jika bukan 1
                           var html  = '<span class="badge badge-success">'+row.Status+'</span> '
                       }else if(row.Status == "Payment"){ // Jika bukan 1
                           var html  = '<span class="badge badge-warning">'+row.Status+'</span> '
                       }else if(row.Status == "Lunas"){ // Jika bukan 1
                           var html  = '<span class="badge badge-danger">'+row.Status+'</span> '
                       }else{ // Jika bukan 1
                           var html  = '<span class="badge badge-info">'+row.Status+'</span> '
                       }
                          return html 
                   }
               },
               { "data": "NamaDokter" },  // Tampilkan nama
               { "data": "DokterDPJP" },  // Tampilkan nama 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""

                     if(row.NoSEP == null || row.NoSEP == ''){
                       var nosep = ''
                     }else{
                       var nosep = '<b>(No SEP:'+row.NoSEP+'</b>)'
                     }

                      var html  = row.NamaPerusahaan+'<br>'+nosep
                          return html 
                   }
               },
               { "data": "startdate" },  // Tampilkan nama 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<a class="btn btn-primary btn-sm" onclick="PrintSPR('+row.IDSpr+')"   value='+row.IDSpr+'><span class="glyphicon glyphicon-print"></span> Print</a>'
                          return html 
                   }
               },
           ],
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}