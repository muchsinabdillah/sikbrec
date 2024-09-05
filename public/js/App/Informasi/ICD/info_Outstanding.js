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
    // tipeinfo = $("#tipeinfo").val();
    var base_url = window.location.origin;
    
    $('#datatable1').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable2').dataTable({
        "bDestroy": true
    }).fnDestroy();

    if (jenisinfo == '1' ){
        $("#datatable1").show();
        $("#datatable2").hide();


       $('#datatable1').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfo_Outstanding_icd/getDataOutStanding", // URL file untuk proses select datanya
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
            { "data": "NoEpisode" }, 
            { "data": "NoRegistrasi" }, 
             { "data": "NoMR" }, 
             { "data": "PatientName" }, 
             { "data": "VisitDate" }, 
             { "data": "NamaDokter" }, 
             { "data": "NamaUnit" }, 

                   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });

    }else if (jenisinfo == '2' ){
        $("#datatable1").hide();
        $("#datatable2").show();
       $('#datatable2').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfo_Outstanding_icd/getDataOutStanding", // URL file untuk proses select datanya
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
            { "data": "NoEpisode" }, 
            { "data": "NoRegistrasi" }, 
             { "data": "NoMR" }, 
             { "data": "PatientName" }, 
             { "data": "datatimestamp" }, 
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });
   
    }else{
        $("#datatable1").hide();
        $("#datatable2").hide();
        toast('Error! Data Not Found!',"error")
    }

    
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