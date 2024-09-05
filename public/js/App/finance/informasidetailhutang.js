$(document).ready(function () {
    $(".preloader").fadeOut();
    $('#btnLoadInformation').click(function () {
        getInformasiHutangDetail();
    });
});


function getInformasiHutangDetail() {
    var base_url = window.location.origin;
    var JenisInfo = document.getElementById("JenisInfo").value;
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    let url = base_url + '/SIKBREC/public/hutang/informasiHutangDetail';
    $('#tabelhutang').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tabelhutang').DataTable({
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      
       "ajax": {
        "url": url,
        "type": "POST",
            data: function ( d ) {
            d.JenisInfo = JenisInfo;
            d.PeriodeAwal = PeriodeAwal; 
            d.PeriodeAkhir = PeriodeAkhir; 
          },
        "dataSrc": "",
        "deferRender": true,
    },
        "columns": [  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.KD_HUTANG+' </font>';
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
                  var html  = '<font size="2">'+row.KET +' </font>';
                  return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NO_FAKTUR+' </font>';
                return html 
            }
          }, 
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.TGL_HUTANG+' </font>';
                return html 
            }
          }, 
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.TGL_TEMPO+' </font>';
                return html 
            }
          }, 
            { "data": "NILAI_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "SISA_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
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
            total3 = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            total4 = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 
        // Update footer
        $( api.column( 7 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total3 )
            
           
        );
        $( api.column( 6 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total4 )
            
           
        );
        
    },
         dom: 'Bfrtip',
          buttons: [ 
              'pdf'
          ] 
    });
}
