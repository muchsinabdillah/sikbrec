$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    // $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataInfoTindakanFisio();
    });
    // $(".preloader").fadeOut(); 
    // onloadForm();
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
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
function excelLanscape() {
    var base_url = window.location.origin;
    
    var TglAwal = document.getElementById("PeriodeAwal").value;
    var TglAkhir = document.getElementById("PeriodeAkhir").value; 
    
        window.location = base_url + "/SIKBREC/public/ExcelInfoTindakanFisio/ExcelInfoTindakanFisio2/" + TglAwal + "/" + TglAkhir;
    
    }

function getDataInfoTindakanFisio() { 
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
            { extend: 'excelHtml5', footer: true, messageTop: 'Laporan Tindakan Fisio', title: '   INFO TINDAKAN FISIO'},
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],

           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aInfoTindakanFisio/getDataListInfoTindakanFisio", // URL file untuk proses select datanya
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
                    var html = '<font size="1"> ' + row.NoMR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoEpisode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoRegistrasi + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PatientName + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaJaminan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaDokter + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Tanggal + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Jam + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kelas + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaProduct + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Quantity + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Tarif + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TotalTarif + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.UserInput + ' </font>  ';
                    return html
                }
            },
           
        ]


            

    });

    $(".preloader").fadeOut();

}


