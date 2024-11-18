$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#btnLoad').attr('disabled', false);
    $(document).on('click', '#btnLoad', function () {
        //checking before get data
        CheckVar();
    });
   
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
    });
    function excelLanscape() {
    var base_url = window.location.origin;
    
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 
    
        window.location = base_url + "/SIKBREC/public/ExcelInfoJasaDokter/ExcelInfoJasaDokter2/" + PeriodeAwal + "/" + PeriodeAkhir;
    
    }
    async function printpdf() {
        var base_url = window.location.origin;
        // var base_urlx = window.location.origin;
        PeriodeAwal = $("#PeriodeAwal").val();
        PeriodeAkhir = $("#PeriodeAkhir").val();
        window.open(base_url + "/SIKBREC/public/bInfoJasaDokter/printPDF/"+PeriodeAwal+"/"+PeriodeAkhir, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        // printrincian(base_urlx);
    }
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

    getDataInfo();
}
function getDataInfo() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    
    $('#datatable1').dataTable({
           "bDestroy": true
       }).fnDestroy();
        $("#datatable1").show();
       $('#datatable1').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfoJasaDokter/getDataInfo", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no" }, 
            { "data": "TGL_BILLING" }, 
             { "data": "NO_TRS_BILLING" }, 
             { "data": "NO_REGISTRASI" }, 
             { "data": "PatientName" },
             { "data": "NamaJaminan" }, 
             { "data": "NM_DR" },    
             { "data": "NAMA_TARIF" }, 
             { "data": "TOTAL_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
             { "data": "nilaijasadokter" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
                   
           ],
           "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

                 totaltarif = api
                 .column( 8 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 nilaijasa = api
                 .column( 9 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                
 
             // Update footer
                $( api.column( 8 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totaltarif )
                );
                $( api.column( 9 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  nilaijasa )
                );
            
            },
            
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