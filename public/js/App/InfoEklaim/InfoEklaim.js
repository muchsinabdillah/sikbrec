$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    // $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataInfo();
    });
    // $(".preloader").fadeOut(); 
    // onloadForm();
});

function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if (Difference_In_Days > 31) {
    //     alert("Periode Penarikan Data Adalah 31 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
    //     $('#btnLoadInformation').attr('disabled', true);
    // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // }
}


function getDataInfo() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#example').dataTable({
           "bDestroy": true
       }).fnDestroy();
       
       $('#example').DataTable({

        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            {
                extend: 'excelHtml5',
                customize: function ( xlsx ){
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    // $('row c[r^="2"]', sheet).attr( 's', '2' );
                    // jQuery selector to add a border
                    $('row c[r*="A"]', sheet).attr( 's', '25' );
                    $('row c[r*="B"]', sheet).attr( 's', '25' );
                    $('row c[r*="C"]', sheet).attr( 's', '25' );
                    
                    $('row c[r*="D"]', sheet).attr( 's', '25' );
                    $('row c[r*="E"]', sheet).attr( 's', '25' );
                    $('row c[r*="F"]', sheet).attr( 's', '25' );
                    
                    

                }
            },
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],

           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aInfoEklaim/getDataListInfo", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.KODE_DIAGNOSA + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_DIAGNOSA + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.total + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.total_tarif_rs + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.total_tarif_inacbg + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.selisih_claim + ' </font>  ';
                    return html
                }
            },
        ]


            

    });

    $(".preloader").fadeOut();

}