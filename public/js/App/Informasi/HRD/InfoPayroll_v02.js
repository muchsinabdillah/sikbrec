$(document).ready(function () {
    $(".preloader").fadeOut();
    getLokasi2();
    $('#btn_printrekapgaji').click(function () {
        $(".preloader").fadeOut();
        var Hr_Periode = $("#Hr_Periode").val();
        var base_url = window.location.origin;
        var Hr_LokasiProject_Updt = $("#Hr_LokasiProject_Updt").val();
        window.open(base_url + "/pms_gut/public/InfoPayroll/PrintRekap/" + Hr_Periode + "/" + Hr_LokasiProject_Updt, "_blank",
             "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    $('#btn_printproduktivitas').click(function () {
        var Hr_Periode = $("#Hr_Periode").val();
        var Hr_LokasiProject_Updt = $("#Hr_LokasiProject_Updt").val();
        var base_url = window.location.origin;
        window.open(base_url + "/pms_gut/public/InfoPayroll/PrintRekapProduktifitas/" + Hr_Periode + "/" + Hr_LokasiProject_Updt, "_blank",
             "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
});
function getInfoPayroll() {
    var Hr_LokasiProject_Updt = $("#Hr_LokasiProject_Updt").val();
    var Hr_Periode = $("#Hr_Periode").val();
    var base_url = window.location.origin;
    var title = 'Info Payroll';
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "scrollX": false,
        "paging": true,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/ProsesPayroll/getInfoPayroll", 
            "type": "POST",
            data: function (d) {
                d.Hr_LokasiProject_Updt = Hr_LokasiProject_Updt;
                d.Hr_Periode = Hr_Periode;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_TRANSAKSI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_LOKASI + '</font> ';
                    return html
                }
            },
            { "data": "TUNJANGAN_POKOK", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "UPAH_POKOK", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "LEMBUR", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "POTONGAN_ABSENSI", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "PPH21", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "TL_PSW", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "KASBON", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 
            { "data": "TotalGaji", render: $.fn.dataTable.render.number(',', '.', 0, '') },  // Tampilkan nama 

        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            {
                extend: 'excelHtml5',
                title: title
            },
            'csv'
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

            // Total over all pages

            // Total over this page


            total3 = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            total4 = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total5 = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            total6 = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total7 = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total8 = api
                .column(8)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total9 = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total10 = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);



            // Update footer
            $(api.column(3).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total3)
            );
            // Update footer
            $(api.column(4).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total4)
            );

            $(api.column(5).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total5)
            );
            $(api.column(6).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total6)
            );
            $(api.column(7).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total7)
            );
            $(api.column(8).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total8)
            );
            $(api.column(9).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total9)
            );
            $(api.column(10).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total10)
            );
        },
    });
}
function getLokasi2() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/JobOrder/getLokasiJoByHakUser',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Hr_LokasiProject_Updt").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_LokasiProject_Updt").append(newRow);
            }
            $('.js-example-basic-single').select2();
            //$('.js-example-basic-single').select2(); 

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}