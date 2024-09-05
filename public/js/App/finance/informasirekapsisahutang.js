$(document).ready(function () {
    $(".preloader").fadeOut();
    $('#btnLoadInformation').click(function () {
        getInformasiHutangDetail();
    });
});


function getInformasiHutangDetail() {
    var base_url = window.location.origin; 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    let url = base_url + '/SIKBREC/public/hutang/informasiHutangRekapSisa';
    $('#tabelhutang').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tabelhutang').DataTable({
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      
       "ajax": {
        "url": url,
        "type": "POST",
            data: function ( d ) { 
            d.PeriodeAwal = PeriodeAwal; 
            d.PeriodeAkhir = PeriodeAkhir; 
          },
        "dataSrc": "",
        "deferRender": true,
    },
        "columns": [  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.Company+' </font>';
                  return html 
              }
            },  
            { "data": "fn_piutang" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "nilai_pay" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "SISA_SEKARANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
        // Update footer
        $( api.column( 3 ).footer() ).html(
            $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total3 )
            
           
        );
    
        
    },
         dom: 'Bfrtip',
          buttons: [ 
              'colvis'
          ] 
    });
}
