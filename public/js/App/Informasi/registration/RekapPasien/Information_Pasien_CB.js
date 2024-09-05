$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#btn_infoICD').attr('disabled', false);
    $(document).on('click', '#btn_infoICD', function () {
        //checking before get data
        CheckVar();
    });
   
});

function CheckVar (){
    //if not in creteria return false
    if ($("#PeriodeAwal").val() == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if ($("#PeriodeAkhir").val() == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }

    getDataOutStanding();
}
function getDataOutStanding() { 
    let PeriodeAwal ,PeriodeAkhir,jenisinfo;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    jenisinfo = $("#jenisinfo").val();
    var base_url = window.location.origin;
    
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationRekapPasien/getDataPasien", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.jenisinfo = jenisinfo;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no" }, 
            { "data": "mrn" }, 
            { "data": "EPISODE_NUMBER" }, 
             { "data": "NOREGISTRASI" }, 
             { "data": "ORDER_DATE" }, 
             { "data": "PATIENT_NAME" }, 
             { "data": "NamaJaminan" }, 
             { "data": "SCHEDULED_PROC_DESC" }, 
             { "data": "Tarif" }, 
             { "data": "IsVerifikasi" }, 
             

           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
    });
} 

// Primary function always
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