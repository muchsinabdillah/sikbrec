$(document).ready(function () {
    // asyncShowMain();
        $('#table-load-data').dataTable();
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
    $(document).on('click', '#btnPrint', function () {
      btnPrint();
  });
   
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;

        window.location = base_url + "/SIKBREC/public/ExcelInfoFaktur/ExcelInfoFaktur2/" + PeriodeAwal + "/" + PeriodeAkhir;
}

function btnPrint() {
  var base_url = window.location.origin;

  var PeriodeAwal = document.getElementById("PeriodeAwal").value;
  var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;

    const obj = JSON.parse(`
    {
    "PeriodeAwal":"${PeriodeAwal}", 
    "PeriodeAkhir":"${PeriodeAkhir}"
    }
    `);
    var mybj = JSON.stringify(obj);
    var mybj = btoa(mybj);

      //window.location = base_url + "/SIKBREC/public/bInformasiPenjualan/print/" + PeriodeAwal + "/" + PeriodeAkhir;
      window.open(base_url + "/SIKBREC/public/bInformasiPenjualan/print/" + mybj , "_blank");
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
              "url": "/SIKBREC/public/bInformasiPenjualan/getDataInformasiPenjualan",
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
              var html  = '<font size="2">'+row.NamaUserCreate+' </font>';
              return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoRegistrasi+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoResep+' </font>';
                return html 
                }
              },  
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NoMR+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NamaPembeli+' </font>';
                return html 
                }
              }, 
              // { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              //   var html = ""
              //   var html  = '<font size="2">'+row.NamaUnit+' </font>';
              //   return html 
              //   }
              // }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NamaJaminan+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.ProductCode+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.ProductName+' </font>';
                return html 
                }
              }, 
                { "data": "Qty" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},  // Tampilkan nama 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                    var html = ""
                    var html  = '<font size="2">'+row.Satuan+' </font>';
                    return html 
                    }
                  },
                { "data": "Harga" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )},  // Tampilkan nama 
                { "data": "Discount" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
                // { "data": "Subtotal" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
                { "data": "Grandtotal" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
                // { "data": "UangR" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
                // { "data": "Embalase" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama  

        ],
  
        dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
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
                        total11 = api
                        .column( 11 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        total13 = api
                        .column( 13 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        total14 = api
                        .column( 14 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        total15 = api
                        .column( 15 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                    // Update footer
                    $( api.column( 11 ).footer() ).html(
                        $.fn.dataTable.render.number( ',','.','2','').display( total11 )
                    );
                    $( api.column( 13 ).footer() ).html(
                        $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total13 )
                    );
                    $( api.column( 14 ).footer() ).html(
                        $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total14 )
                    );
                    $( api.column( 15 ).footer() ).html(
                        $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total15 )
                    );
                
                    
                },
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