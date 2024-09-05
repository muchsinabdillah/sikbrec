$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
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
    var REKENING = document.getElementById("REKENING").value;
    
        window.location = base_url + "/SIKBREC/public/ExcelInfoLedgerDetail/ExcelInfoLedgerDetail2/" + PeriodeAwal + "/" + PeriodeAkhir+ "/" + REKENING;
    
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
    //     $('#btnLoadInformation').prop('disabled', true);
    // }else{
    //     $('#btnLoadInformation').prop('disabled', false);
    }
 }


// async function onloadForm() {
//     await showdatatabel();
    
// }
async function asyncShowMain() {
    try { 
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
     
}

function showdatatabel() {
    // console.log ('ssssss')
    let PeriodeAwal ,PeriodeAkhir, REKENING;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val(); 
     var base_url = window.location.origin;
    // const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InfoLedger/getDataListInfoLedgerRekap",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                d.PeriodeAwal = PeriodeAwal;
                d.PeriodeAkhir = PeriodeAkhir; 
            },
            "deferRender": true,
        },
        
        "columns": [   
            { "data": "FS_KD_REKENING" },
            { "data": "FS_NM_REKENING" },  
            { "data": "SALDO_AWAL" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "DEBET" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "KREDIT" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "SALDO_AKHIR" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},
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

