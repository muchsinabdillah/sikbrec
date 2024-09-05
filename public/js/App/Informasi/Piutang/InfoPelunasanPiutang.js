$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#caridatapasienarsip').attr('disabled', false);
    $(document).on('click', '#caridatapasienarsip', function () {
        //checking before get data
        CheckVar();
    });
   
});


function clearVal(val){
    //------07-03-2023
    if (val == '1' ){
        $("#tipepembayaran").val('').trigger('change');
        $("#tipepembayaran").attr('disabled', true);
        return false;
    }

    $("#tipepembayaran").val('');
    $("#tipepembayaran").attr('disabled', false);
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

    loadInfo();
}
function loadInfo() { 
    let PeriodeAwal ,PeriodeAkhir,optJenisInfo;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    optJenisInfo = $("#optJenisInfo").val(); 

    var base_url = window.location.origin;
    
        $('#table-load-data').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-load-data').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/piutang/loadInforekap",
              "type": "POST",
                  data: function ( d ) { 
                    d.TglAwal = PeriodeAwal;
                    d.TglAkhir = PeriodeAkhir;
                    d.optJenisInfo = optJenisInfo;
                    
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.FS_KD_TRS+' </font>';
                  return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.PetugasCreate+' </font>';
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.No_Tagihan+' </font>';
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.NamaPerusahaan+' </font>';
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.JenisRegName+' </font>';
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.FD_TGL_TRS+' </font>';
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.FS_KET+' </font>';
                  return html 
              }
            },   
            { "data": "FN_LUNAS" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "FN_MATERAI" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "FN_BIAYA_LAIN" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "FN_DISKON_LAIN" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "FN_TOTAL_LUNAS" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.FS_REKENING+' </font>';
                  return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.RekeningPelunasan+' </font>';
                  return html 
              }
            }, 
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

        // Total over all pages
  
        // Total over this page


            total3 = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            total4 = api
            .column( 8 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            total5 = api
            .column( 9 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            total6 = api
            .column( 10 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            total7 = api
            .column( 11 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );



        // Update footer
        $( api.column( 7 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','').display( total3 )
        );
         // Update footer
        $( api.column( 8 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','').display( total4 )
        );

        $( api.column( 9 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','').display( total5 )
        );  

        $( api.column( 10 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','').display( total6 )
        );  

        $( api.column( 11 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','').display( total7 )
        );  


    },
         dom: 'Bfrtip',
          buttons: [ 
              'colvis'
          ] 
    });
}

// function getDataLaporan() { 
//     let PeriodeAwal ,PeriodeAkhir,kasir,jenispasien,tipepembayaran,tipeinfo;
//     PeriodeAwal = $("#PeriodeAwal").val();
//     PeriodeAkhir = $("#PeriodeAkhir").val();
//     kasir = $("#kasir").val();
//     jenispasien = $("#jenispasien").val();
//     tipepembayaran = $("#tipepembayaran").val();
//     tipeinfo = $("#tipeinfo").val();
//     var base_url = window.location.origin;
    
//     $('#table-load-data').dataTable({
//            "bDestroy": true
//        }).fnDestroy();
//        $('#Piutangrekap').dataTable({
//         "bDestroy": true
//     }).fnDestroy();
//     if (tipeinfo == '2'  && jenispasien == '1' || (tipeinfo == '2' && jenispasien == '2') || (tipeinfo == '2' && jenispasien == '3') || (tipeinfo == '2' && jenispasien == '4')){
//         $("#table-load-data").show();
//         $("#Piutangrekap").hide();

//        $('#table-load-data').DataTable({
//            "ordering": true, // Set true agar bisa di sorting
//            "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
//            "ajax":
//            {
//                "url": base_url + "/SIKBREC/public/InfoLaporanKasir/getDataLaporan", // URL file untuk proses select datanya
//                "type": "POST",
//                data: function ( d ) {
//                 d.TglAwal = PeriodeAwal;
//                 d.TglAkhir = PeriodeAkhir;
//                 d.kasir = kasir;
//                 d.jenispasien = jenispasien;
//                 d.tipeinfo = tipeinfo;
//                 d.tipepembayaran = tipepembayaran;
//                // d.custom = $('#myInput').val();
//                // etc
//                },
//                 "dataSrc": "",
//            "deferRender": true,
//            }, 
//            "columns": [
//             { "data": "NoTransaksi" }, 
//             { "data": "NoKwitansi" }, 
//              { "data": "NoEpisode" }, 
//              { "data": "NoReg" }, 
//              { "data": "NoMR" },
//              { "data": "NamaPasien" }, 
//              { "data": "NamaJaminan" },    
//              { "data": "Nama_Unit" }, 
//               { "data": "Nama_Dokter"}, 
//              { "data": "TGL_Transaksi" },  
//              { "data": "User_Kasir" },  
//              { "data": "Total_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
//              { "data": "Tipe_Pembayaran" },  
//              { "data": "Nama_Perusahaan" },  
//              { "data": "Nomor_Kartu" },  
//              { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
                   
//            ],
//            dom: 'Bfrtip',
//             buttons: [
//                 'copyHtml5',
//                 'excelHtml5'
//             ]
//        });

//     }else if (tipeinfo == '1'  && jenispasien == '1' || (tipeinfo == '1' && jenispasien == '2') || (tipeinfo == '1' && jenispasien == '3') || (tipeinfo == '1' && jenispasien == '4')){
//         $("#table-load-data").hide();
//         $("#Piutangrekap").show();
//         // $('#Piutangrekap').dataTable({
//         //     "bDestroy": true
//         // }).fnDestroy();

//        $('#Piutangrekap').DataTable({
//            "ordering": true, // Set true agar bisa di sorting
//            "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
//            "ajax":
//            {
//                "url": base_url + "/SIKBREC/public/InfoLaporanKasir/getDataLaporan", // URL file untuk proses select datanya
//                "type": "POST",
//                data: function ( d ) {
//                 d.TglAwal = PeriodeAwal;
//                 d.TglAkhir = PeriodeAkhir;
//                 d.kasir = kasir;
//                 d.jenispasien = jenispasien;
//                 d.tipeinfo = tipeinfo;
//                 d.tipepembayaran = tipepembayaran;
//                // d.custom = $('#myInput').val();
//                // etc
//                },
//                 "dataSrc": "",
//            "deferRender": true,
//            }, 
//            "columns": [
//             { "data": "NoTransaksi" }, 
//             { "data": "NoKwitansi" }, 
//              { "data": "NoEpisode" }, 
//              { "data": "NoReg" }, 
//              { "data": "NoMR" },
//              { "data": "NamaPasien" }, 
//              { "data": "NamaJaminan" },    
//              { "data": "Nama_Unit" }, 
//               { "data": "Nama_Dokter"}, 
//              { "data": "TGL_Transaksi" },  
//              { "data": "User_Kasir" },  
//              { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
//              { "data": "Cash" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
//              { "data": "Debit" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
//              { "data": "Kredit" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
//             //  { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
                   
//            ],
//            dom: 'Bfrtip',
//             buttons: [
//                 'copyHtml5',
//                 'excelHtml5'
//             ]
//        });
//     }else{
//         $("#table-load-data").hide();
//         $("#Piutangrekap").hide();
//         toast('Error! Data Not Found!',"error")
//     }

    
// }  

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