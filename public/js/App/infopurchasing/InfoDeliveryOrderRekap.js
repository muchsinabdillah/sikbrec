$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        showdatatabel(); 
    });
$(document).on('click', '#excelLanscape', function () {
    excelLanscape();
});
});
function excelLanscape() {
var base_url = window.location.origin;

var PeriodeAwal = document.getElementById("PeriodeAwal").value;
var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 

    window.location = base_url + "/SIKBREC/public/ExcelInfoDeliveryOrderRekap/ExcelInfoDeliveryOrderRekap2/" + PeriodeAwal + "/" + PeriodeAkhir;

}

function TrigerTgl() {
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    var nowDateawal = new Date(PeriodeAwal);
    var nowDateakhir = new Date(PeriodeAkhir);
    var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    if(Difference_In_Days > 30 ){
        alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
        $("#PeriodeAwal").val('');
        $("#PeriodeAkhir").val('');
   
    }
 }
 async function asyncShowMain() {
    try {
  
    $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
    
        }
    

 function showdatatabel() {
        // console.log ('ssssss')
    // let PeriodeAwal ,PeriodeAkhir, REKENING;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    // REKENING = $("#REKENING").val();
     var base_url = window.location.origin;
    // const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InfoDeliveryOrderRekap/getDataListInfoDeliveryOrderRekap",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                d.PeriodeAwal = PeriodeAwal;
                d.PeriodeAkhir = PeriodeAkhir;
                // d.REKENING = REKENING;
            },
            "deferRender": true,
        },
        
        "columns": [

            { "data": "Transaction_Code" },
            { "data": "DeliveryOrder_Date" },
            { "data": "User_Create" },
            { "data": "Supplier_Code" },
            { "data": "Notes" },
            { "data": "TotalQty_Delivery" },
            { "data": "Subtotal_Delivery" },
            { "data": "Tax_Delivery" },
            { "data": "GrandTotal_Delivery" },
            { "data": "PurchaseOrder_Code" },
            { "data": "TotalRowDO" },
            { "data": "TotalQty_DO" },
            { "data": "Jenis_Delivery" },          
            { "data": "Nama_Supplier" },          
            { "data": "Nama_User" },          
            { "data": "Tanggal_Periode" },          
            { "data": "Unit_Code" },  
            
        ],
        dom: 'Bfrtip',
            buttons: [
               'excelHtml5'
            ]
    });
}


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
