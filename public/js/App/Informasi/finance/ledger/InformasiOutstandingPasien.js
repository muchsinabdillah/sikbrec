$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        showdatatabel(); 
    });
});

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


// async function asyncShowMain() {
//     await showdatatabel();
    
// }
async function asyncShowMain() {
    try {
    //     const datagetRekening = await getRekening();
    // updateUIgetRekening (datagetRekening);
    $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
    // function updateUIgetRekening(datagetRekening) {
    //     let data = datagetRekening.data;
    //     // console.log (data)
    //     if (data !== null && data !== undefined) {
    //         console.log(data.length);
    //         var newRow = '<option value="">-- PILIH --</option';
    //         $("#REKENING").append(newRow);
    //         for (i = 0; i < data.length; i++) {
    //             // console.log(data[i].FS_KD_REKENING );
    //             var newRow = '<option value="' + data[i].FS_KD_REKENING + '">' + data[i].FS_NM_REKENING + '</option';
    //             $("#REKENING").append(newRow);
    //         }
    //     }
    // }
// function getRekening() {
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/InfoLedger/getRekening';
//     return fetch(url, {
//         method: 'GET',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         }
//     })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(response.statusText)
//             }
//             return response.json();
//         })
//         .then(response => {
//             if (response.status === "error") {
//                 throw new Error(response.message.errorInfo[2]);
//                 // console.log("ok " + response.message.errorInfo[2])
//             } else if (response.status === "warning") {
//                 throw new Error(response.errorname);
//                 // console.log("ok " + response.message.errorInfo[2])
//             }
//             return response
//         })
//         .finally(() => {
//             $("#REKENING").select2();
//         })
//     }
}

function showdatatabel() {
    // console.log ('ssssss')
    let PeriodeAwal ,PeriodeAkhir, REKENING;
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
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InformasiOutstandingPasien/getDataListInfoOutstanding",
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
            { "data": "NO" },   
            { "data": "Tgl" },    
            { "data": "NoMR" },
            { "data": "NoRegistrasi" }, 
            { "data": "PatientName" },
            { "data": "LokasiPasien" },
            { "data": "First_Name" },
            { "data": "TypePatient" },
            { "data": "PetugasDaftar"},
            { "data": "Status"},
            { "data": "totalnominal"}
            // {
            //     "render": function (data, type, row) {
            //         var html = ""
            //         var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showInputDataPabrik(' + row.ID + ')" ><span class="visible-content" >Edit</span>'
            //         return html
            //     },
            // },
            
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

