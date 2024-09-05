$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#LoadDataFaktur').attr('disabled', false);
    $(document).on('click', '#LoadDataFaktur', function () {
        //checking before get data
        CheckVar();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
   
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;

        window.location = base_url + "/SIKBREC/public/ExcelInfoFaktur/ExcelInfoFaktur2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
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
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    
        $('#table-load-data').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-load-data').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/bInfoFaktur/getDataListInfoFaktur",
              "type": "POST",
                  data: function ( d ) { 
                    d.TglAwal = PeriodeAwal;
                    d.TglAkhir = PeriodeAkhir;
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [
            { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.TransactionCode+' </font>';
                return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.TransactionDate+' </font>';
                return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.TglJatuhTempo+' </font>';
              return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.PurchaseOrderCode+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.DeliveryCode+' </font>';
                return html 
                }
              },  
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.Company+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NamaUnit+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoFakturPajak+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoFakturPBF+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoRekeningSupplier+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NamaNBank+' </font>';
                return html 
                }
              },
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.DateFakturPBF+' </font>';
                return html 
                }
              },
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.Keterangan+' </font>';
                return html 
                }
              },
            { "data": "TotalNilaiFaktur" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "TotalDiskon" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "TotalTax" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "Subtotal" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "DiskonLain" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "BiayaLain" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "Pph23" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            { "data": "Grandtotal" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 

        ],
  
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