$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', true);
    // $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListSensus();
    });
    // $(".preloader").fadeOut(); 
    // onloadForm();
});

function TrigerTgl() {
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    var nowDateawal = new Date(PeriodeAwal);
    var nowDateakhir = new Date(PeriodeAkhir);
    var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    console.log(Difference_In_Days)
    if (Difference_In_Days > 31) {
        alert("Periode Penarikan Data Adalah 31 Hari maksimal dari Tanggal Awal. !");
        $("#PeriodeAwal").val('');
        $("#PeriodeAkhir").val('');
        $('#btnLoadInformation').attr('disabled', true);
    } else {
        $('#btnLoadInformation').attr('disabled', false);
    }
}


function getDataListSensus() { 
    let PeriodeAwal ,PeriodeAkhir, TipeRawat, RuangRawat;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeRawat = $("#TipeRawat").val();
    RuangRawat = $("#RuangRawat").val();
    // TipeResume = $("#TipeResume").val();
    var base_url = window.location.origin;
    $('#example').dataTable({
           "bDestroy": true
       }).fnDestroy();
       
       $('#example').DataTable({

        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Data Sensus PPI', title: 'SENSUS PPI'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],

           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aPPI/getDataListSensusFilter", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               d.TipeRawat = TipeRawat;
               d.RuangRawat = RuangRawat;
            //    d.TipeResume = TipeResume;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Tanggal + ' </font>  ';
                    return html
                }
            },
            
            { "data": "Jumlah", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "Opr", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "OP_B", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "OP_IDOB", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "OP_BC", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "OP_IDOBC", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "OP_C", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "OP_IDOC", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "OP_K", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "OP_IDOK", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "OP_WSD", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "OP_IDOWSD", render: $.fn.dataTable.render.number(',', '', 0, '') },

        

            { "data": "Infus_CVL", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "Infus_IAD", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "Infus_IVL", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "Infus_UC", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "Infus_ISK", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "ETT_Vent", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "VAP", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "TB", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "HAP", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "DEK_G1", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "DEK_G2", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "DEK_G3", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "DEK_G4", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "PLEB_G1", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "PLEB_G2", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "PLEB_G3", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "PLEB_G4", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "PLEB_G5", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahAntibiotik_1", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahAntibiotik_2", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahAntibiotik_3", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahKuman_D", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahKuman_S", render: $.fn.dataTable.render.number(',', '', 0, '') },

            { "data": "JumlahKuman_SPT", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
            { "data": "JumlahKuman_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide" onclick=\'showDataGroupShift("' + row.ID + '", "'+row.Tipe_Rawat+'")\'  ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ],
        

        
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            totalC1 = api
                .column(1)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            $(api.column(1).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalC1)
            );

            totalc2 = api
            .column(2)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(2).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc2)
            );
                
            totalc3 = api
            .column(3)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(3).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc3)
            );

            totalc4 = api
            .column(4)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(4).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc4)
            );
            
            totalc5 = api
            .column(5)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(5).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc5)
            );

            totalc6 = api
            .column(6)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(6).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc6)
            );

            totalc7 = api
            .column(7)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(7).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc7)
            );

            totalc8 = api
            .column(8)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(8).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc8)
            );

            totalc9 = api
            .column(9)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(9).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc9)
            );

            totalc10 = api
            .column(10)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(10).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc10)
            );

            totalc11 = api
            .column(11)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(11).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc11)
            );

            totalc12 = api
            .column(12)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(12).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc12)
            );

            totalc13 = api
            .column(13)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(13).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc13)
            );

            totalc14 = api
            .column(14)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(14).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc14)
            );

            totalc15 = api
            .column(15)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(15).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc15)
            );

            totalc16 = api
            .column(16)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(16).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc16)
            );

            totalc17 = api
            .column(17)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(17).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc17)
            );

            totalc18 = api
            .column(18)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(18).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc18)
            );

            totalc19 = api
            .column(19)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(19).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc19)
            );

            totalc20 = api
            .column(20)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(20).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc20)
            );

            totalc21 = api
            .column(21)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(21).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc21)
            );

            totalc22 = api
            .column(22)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(22).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc22)
            );

            totalc23 = api
            .column(23)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(23).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc23)
            );

            totalc24 = api
            .column(24)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(24).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc24)
            );

            totalc25 = api
            .column(25)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(25).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc25)
            );

            totalc26 = api
            .column(26)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(26).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc26)
            );

            totalc27 = api
            .column(27)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(27).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc27)
            );

            totalc28 = api
            .column(28)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(28).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc28)
            );

            totalc29 = api
            .column(29)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(29).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc29)
            );

            totalc30 = api
            .column(30)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(30).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc30)
            );

            totalc31 = api
            .column(31)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(31).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc31)
            );

            totalc32 = api
            .column(32)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(32).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc32)
            );

            totalc33 = api
            .column(33)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(33).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc33)
            );

            totalc34 = api
            .column(34)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(34).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc34)
            );

            totalc35 = api
            .column(35)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(35).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc35)
            );

            totalc36 = api
            .column(36)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(36).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc36)
            );

            totalc37 = api
            .column(37)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(37).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(totalc37)
            );

            },
            


    });

    table.buttons().container()
    .appendTo( '#example_wrapper .col-sm-6:eq(0)' );

    $(".preloader").fadeOut();

} 





//table 1
// async function onloadForm() {
//     await getHakAksesByForm(18);
//     await showdatatabel();
// }
// function showdatatabel() {

//     let PeriodeAwal ,PeriodeAkhir;
//     PeriodeAwal = $("#PeriodeAwal").val();
//     PeriodeAkhir = $("#PeriodeAkhir").val();


//     const base_url = window.location.origin;
//     $(".preloader").fadeOut();
//     $('#example').dataTable({
//         "bDestroy": true
//     }).fnDestroy();
//     $('#example').DataTable({
//         "ordering": true,
//         "ajax": {
//             "url": base_url + "/SIKBREC/public/aPPI/getDataSensusPPI",
//             // "type": "POST",
//                data: function ( d ) {
//                d.TglAwal = PeriodeAwal;
//                d.TglAkhir = PeriodeAkhir;
//                },
//             "dataSrc": "",
//             "deferRender": true,
//         },
//         "columns": [
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.Tanggal + ' </font>  ';
//                     return html
//                 }
//             },
            
//             { "data": "Jumlah", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "Opr", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "OP_B", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "OP_IDOB", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "OP_BC", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "OP_IDOBC", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "OP_C", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "OP_IDOC", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "OP_K", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "OP_IDOK", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "OP_WSD", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "OP_IDOWSD", render: $.fn.dataTable.render.number(',', '', 0, '') },

        

//             { "data": "Infus_CVL", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "Infus_IAD", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "Infus_IVL", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "Infus_UC", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "Infus_ISK", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "ETT_Vent", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "VAP", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "TB", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "HAP", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "DEK_G1", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "DEK_G2", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "DEK_G3", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "DEK_G4", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "PLEB_G1", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "PLEB_G2", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "PLEB_G3", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "PLEB_G4", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "PLEB_G5", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahAntibiotik_1", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahAntibiotik_2", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahAntibiotik_3", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahKuman_D", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahKuman_S", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             { "data": "JumlahKuman_SPT", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
//             { "data": "JumlahKuman_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },

//             {
//                 "render": function (data, type, row) {
//                     var html = ""
//                     var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide" onclick=\'showDataGroupShift("' + row.ID + '", "'+row.Tipe_Rawat+'")\'  ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
//                     return html
//                 },
//             },
//         ],
        
        
//         "footerCallback": function (row, data, start, end, display) {
//             var api = this.api(), data;

//             // Remove the formatting to get integer data for summation
//             var intVal = function (i) {
//                 return typeof i === 'string' ?
//                     i.replace(/[\$,]/g, '') * 1 :
//                     typeof i === 'number' ?
//                         i : 0;
//             };

//             totalC1 = api
//                 .column(1)
//                 .data()
//                 .reduce(function (a, b) {
//                     return intVal(a) + intVal(b);
//                 }, 0);
 
//             $(api.column(1).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalC1)
//             );

//             totalc2 = api
//             .column(2)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(2).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc2)
//             );
                
//             totalc3 = api
//             .column(3)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(3).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc3)
//             );

//             totalc4 = api
//             .column(4)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(4).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc4)
//             );
            
//             totalc5 = api
//             .column(5)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(5).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc5)
//             );

//             totalc6 = api
//             .column(6)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(6).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc6)
//             );

//             totalc7 = api
//             .column(7)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(7).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc7)
//             );

//             totalc8 = api
//             .column(8)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(8).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc8)
//             );

//             totalc9 = api
//             .column(9)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(9).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc9)
//             );

//             totalc10 = api
//             .column(10)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(10).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc10)
//             );

//             totalc11 = api
//             .column(11)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(11).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc11)
//             );

//             totalc12 = api
//             .column(12)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(12).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc12)
//             );

//             totalc13 = api
//             .column(13)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(13).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc13)
//             );

//             totalc14 = api
//             .column(14)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(14).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc14)
//             );

//             totalc15 = api
//             .column(15)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(15).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc15)
//             );

//             totalc16 = api
//             .column(16)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(16).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc16)
//             );

//             totalc17 = api
//             .column(17)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(17).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc17)
//             );

//             totalc18 = api
//             .column(18)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(18).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc18)
//             );

//             totalc19 = api
//             .column(19)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(19).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc19)
//             );

//             totalc20 = api
//             .column(20)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(20).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc20)
//             );

//             totalc21 = api
//             .column(21)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(21).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc21)
//             );

//             totalc22 = api
//             .column(22)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(22).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc22)
//             );

//             totalc23 = api
//             .column(23)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(23).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc23)
//             );

//             totalc24 = api
//             .column(24)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(24).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc24)
//             );

//             totalc25 = api
//             .column(25)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(25).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc25)
//             );

//             totalc26 = api
//             .column(26)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(26).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc26)
//             );

//             totalc27 = api
//             .column(27)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(27).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc27)
//             );

//             totalc28 = api
//             .column(28)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(28).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc28)
//             );

//             totalc29 = api
//             .column(29)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(29).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc29)
//             );

//             totalc30 = api
//             .column(30)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(30).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc30)
//             );

//             totalc31 = api
//             .column(31)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(31).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc31)
//             );

//             totalc32 = api
//             .column(32)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(32).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc32)
//             );

//             totalc33 = api
//             .column(33)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(33).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc33)
//             );

//             totalc34 = api
//             .column(34)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(34).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc34)
//             );

//             totalc35 = api
//             .column(35)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(35).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc35)
//             );

//             totalc36 = api
//             .column(36)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(36).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc36)
//             );

//             totalc37 = api
//             .column(37)
//             .data()
//             .reduce(function (a, b) {
//                 return intVal(a) + intVal(b);
//             }, 0);

//             $(api.column(37).footer()).html(
//                 $.fn.dataTable.render.number(',', '', '', '').display(totalc37)
//             );

//             }, 

//     });
//     $(".preloader").fadeOut();
// } 

function gocreatesensusranap() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPPI/createSensusRanap";
}
function gocreatesensusrajal() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPPI/createSensusRajal";
}
function showDataGroupShift(str,typeR) {
    const base_url = window.location.origin;
    var str = btoa(str);
    //typeR = ' + row.Tipe_Rawat + '
    if(typeR=='Rawat Inap'){
        window.location = base_url + '/SIKBREC/public/aPPI/createSensusRanap/' + str;
    }
    if(typeR=='Rawat Jalan'){
        window.location = base_url + '/SIKBREC/public/aPPI/createSensusRajal/' + str;
    }
    //window.location = base_url + '/SIKBREC/public/aPPI/createSensusRanap/' + str;
}


