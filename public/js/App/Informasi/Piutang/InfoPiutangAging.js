$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#LoadData').attr('disabled', false);
    $(document).on('click', '#LoadData', function () {
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

        window.location = base_url + "/SIKBREC/public/ExcelInfoPiutangAging/ExcelInfoPiutangAging2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
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
              "url": "/SIKBREC/public/Piutang/getInfoAging",
              "type": "POST",
                  data: function ( d ) { 
                    d.TglAwal = PeriodeAwal;
                    d.TglAkhir = PeriodeAkhir;
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [
            // { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 

            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.NamaPerusahaan+' </font>';
                return html 
              }
            }, 
              { "data": "noltoempatlima" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
              { "data": "empatlimatoenampuluh" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
              { "data": "enampuluhtosembilanpuluh" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
              { "data": "sembilanpuluhtoseratusduapuluh" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama  
              { "data": "lebihseratuduapuluhhari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 

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
    
    
                total1 = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
                total2 = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                total3 = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
                total4 = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                total5 = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
    
            // Update footer
            $( api.column( 1 ).footer() ).html(
                $.fn.dataTable.render.number( ',','.','2','').display( total1 )
            );  
            $( api.column( 2 ).footer() ).html(
                $.fn.dataTable.render.number( ',','.','2','').display( total2 )
            );
             // Update footer
            $( api.column( 3 ).footer() ).html(
                $.fn.dataTable.render.number( ',','.','2','').display( total3 )
            );
    
            $( api.column( 4 ).footer() ).html(
                $.fn.dataTable.render.number( ',','.','2','').display( total4 )
            );  
    
            $( api.column( 5 ).footer() ).html(
                $.fn.dataTable.render.number( ',','.','2','').display( total5 )
            );  
     
        
        },
  
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