$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#loaddata').DataTable({});
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

        window.location = base_url + "/SIKBREC/public/ExcelInfoRekapPasien/ExcelInfoRekapPasien2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
}

function getDataListPasien() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#loaddata').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#loaddata').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationRekapPasien/getDataListPasien", // URL file untuk proses select datanya
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
               { "data": "NoRegistrasi" },  // Tampilkan nama 
               { "data": "PatientName" }, // Tampilkan alamat
               { "data": "TypePatient" },  // Tampilkan nama
               { "data": "Address" },  // Tampilkan nama
               { "data": "NamaPerusahaan" },  // Tampilkan nama 
               { "data": "JenisReg" }, // Tampilkan telepon
               { "data": "NAMA_RUANG_AWAL" },  // Tampilkan nama 

               { "data": "NAMA_RUANG_AKHIR" },
               { "data": "KELAS_PERAWATAN_AWAL" },
               { "data": "KELAS_PERAWATAN_AKHIR" },  
               { "data": "TGL_MASUK" },  

               { "data": "TGL_KELUAR" },
               { "data": "LOS" },
               { "data": "Date_of_birth" },  
               { "data": "UMUR_THN" },  
               
               { "data": "UMUR_HARI" },
               { "data": "BERAT_LAHIR" },
               { "data": "JENIS_KELAMIN" },  
               { "data": "STATUS_KELUAR" }, 

               { "data": "DIAGNOSA_EMR_DOKTER" },
               { "data": "DIAGNOSA_UTAMA" },
               { "data": "DIAGNOSA_PROCEDURE" },  
               { "data": "DOKTER_DPJP" },  
               { "data": "BILLING" },  
           ],
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}