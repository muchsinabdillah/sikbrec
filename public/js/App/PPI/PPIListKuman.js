$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', true);
    // $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        showdatatabelDarah();
        showdatatabelSputum();
        showdatatabelUrine();
        showdatatabelSwab();
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

async function onloadForm() {
    await getHakAksesByForm(18);
    await showdatatabelDarah();
    await showdatatabelSputum();
    await showdatatabelUrine();
    await showdatatabelSwab();
}

function showdatatabelDarah() {
    let PeriodeAwal ,PeriodeAkhir, TipeRawat, RuangRawat;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeRawat = $("#TipeRawat").val();
    RuangRawat = $("#RuangRawat").val();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#exampleDarah').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#exampleDarah').DataTable({
        
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Data Sensus PPI', title: 'SENSUS PPI'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],

        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPPI/getDataListKumanDarahFilter", // URL file untuk proses select datanya
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

            { "data": "KM01_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM02_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM03_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM04_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM05_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM06_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM07_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM08_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM09_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM10_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM11_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM12_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM13_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM14_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM15_D", render: $.fn.dataTable.render.number(',', '', 0, '') },
            
        ],"footerCallback": function (row, data, start, end, display) {
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

            },

    });
    $(".preloader").fadeOut();
}
function showdatatabelSputum() {
    let PeriodeAwal ,PeriodeAkhir, TipeRawat, RuangRawat;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeRawat = $("#TipeRawat").val();
    RuangRawat = $("#RuangRawat").val();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#exampleSputum').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#exampleSputum').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Data Sensus PPI', title: 'SENSUS PPI'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPPI/getDataListKumanSputumFilter", // URL file untuk proses select datanya
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
            { "data": "KM01_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM02_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM03_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM04_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM05_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM06_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM07_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM08_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM09_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM10_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM11_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM12_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM13_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM14_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM15_Spt", render: $.fn.dataTable.render.number(',', '', 0, '') },
        ],"footerCallback": function (row, data, start, end, display) {
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

            },

    });
    $(".preloader").fadeOut();
}

function showdatatabelUrine() {
    let PeriodeAwal ,PeriodeAkhir, TipeRawat, RuangRawat;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeRawat = $("#TipeRawat").val();
    RuangRawat = $("#RuangRawat").val();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#exampleUrine').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#exampleUrine').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Data Sensus PPI', title: 'SENSUS PPI'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPPI/getDataListKumanUrineFilter", // URL file untuk proses select datanya
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
            { "data": "KM01_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM02_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM03_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM04_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM05_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM06_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM07_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM08_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM09_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM10_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM11_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM12_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM13_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM14_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM15_Ur", render: $.fn.dataTable.render.number(',', '', 0, '') },
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

            },

    });
    $(".preloader").fadeOut();
}

function showdatatabelSwab(){
    let PeriodeAwal ,PeriodeAkhir, TipeRawat, RuangRawat;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeRawat = $("#TipeRawat").val();
    RuangRawat = $("#RuangRawat").val();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#exampleSwab').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#exampleSwab').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Data Sensus PPI', title: 'SENSUS PPI'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPPI/getDataListKumanSwabFilter", // URL file untuk proses select datanya
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
            { "data": "KM01_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM02_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM03_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM04_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM05_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM06_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM07_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM08_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM09_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM10_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM11_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM12_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM13_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM14_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
            { "data": "KM15_S", render: $.fn.dataTable.render.number(',', '', 0, '') },
        ],"footerCallback": function (row, data, start, end, display) {
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

            },

    });
    $(".preloader").fadeOut();
}



function gocreatesensusranap() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPPI/createSensusRanap";
}
