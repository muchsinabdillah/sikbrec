$(document).ready(function () {
    $(".preloader").fadeOut();

    $('#datatable').dataTable({});

    $(document).on('click', '#btnLoadInformation', function () {
        //checking before get data
        CheckVar();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var Periode = document.getElementById("Periode").value;
       
        window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist4/" + Periode ;
}

function CheckVar() {
    //if not in creteria return false
    if ($("#Periode").val() == '') {
        toast('Periode Kosong!', "warning");
        return false;
    }

    swal({
        title: "Memuat Data",
        text: "Proses ini memerlukan generate data terlebih dahulu untuk memuat data beberapa saat. Apakah anda yakin ingin melanjutkannya ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $(".preloader").fadeIn();
                getDataListPasien();
                $(".preloader").fadeOut();
                } else {
                return false;
                }
        });

}


function getDataListPasien() {
    var Periode = $("#Periode").val();
    var base_url = window.location.origin;

    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    //$('#datatable').DataTable().clear().destroy();
        $('#datatable').DataTable({
            "ordering": false, // Set true agar bisa di sorting
           //"order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": false,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInfoHariPerawatan/getDataListBOR", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    //$("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "periode" },
                { "data": "TotalPasienPulang"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "ResumeTotalSEMBUH"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "ResumeTotalMeninggal2"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "ResumeTotalLainlain"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "ResumeTotalPulangPaksa"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "BOR"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "LOS"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "BTO"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "TOI"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "GDR"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "NDR"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "HariPerawatan"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "JumlahBed"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
                { "data": "LamaPerawatan"  ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},
            ],
            // "footerCallback": function ( row, data, start, end, display ) {
            //     var api = this.api(), data;
     
            //     // Remove the formatting to get integer data for summation
            //     var intVal = function ( i ) {
            //         return typeof i === 'string' ?
            //             i.replace(/[\$,]/g, '')*1 :
            //             typeof i === 'number' ?
            //                 i : 0;
            //     };
            //     // Total over all pages
            //     var i = 8;
            //     var n = i+31;
            //     var t = 0;
            //       for (;i < n; i++) {
            //         total = api
            //         .column( i )
            //         .data()
            //         .reduce( function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0 );
            //     // Total over this page
            //     pageTotal = api
            //         .column( i, { page: 'current'} )
            //         .data()
            //         .reduce( function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0 );
            //     // Update footer
            //     $( api.column( i ).footer() ).html(
            //         $.fn.dataTable.render.number( '.',',').display( total )
            //     );
            //         t += total;
            //       }
            //       $( api.column( 1 ).footer() ).html(
            //         $.fn.dataTable.render.number( '.',',').display( t )
            //     );
            //     $("#totalx").css("fontSize", 16);
            // },
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