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
    var JenisJaminan = document.getElementById("JenisJaminan").value;

        window.location = base_url + "/SIKBREC/public/ExcelInfoMonitorBerkasPenagihanPiutang/ExcelInfoMonitorBerkasPenagihanPiutang2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisJaminan;
   
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
    if ($("#JenisJaminan").val() == ''){
        toast ('Isi Jenis Jaminan', "warning");
        return false;
    }


    loadInfo();
}
function loadInfo() { 
    let PeriodeAwal ,PeriodeAkhir,JenisJaminan;

    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    JenisJaminan = $("#JenisJaminan").val();

    // console.log(PeriodeAwal,PeriodeAkhir,JenisJaminan);return false;

    var base_url = window.location.origin;
    
        $('#table-load-data').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-load-data').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/Piutang/getInfoMonitoring",
              "type": "POST",
                  data: function ( d ) { 
                    d.TglAwal = PeriodeAwal;
                    d.TglAkhir = PeriodeAkhir;
                    d.JenisJaminan = JenisJaminan;
                },
              "dataSrc": "",
              "deferRender": true,
          },
          "columns": [
            { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 

            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.FS_KD_TRS+' </font>';
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
                var html  = '<font size="2">'+row.FS_JENIS_CUSTOMER+' </font>';
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
                var html  = '<font size="2">'+row.FS_KET+' </font>';
                return html 
              }
            }, 
              { "data": "FN_TOTAL_TAGIH" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.fd_periode1+' </font>';
                return html 
              }
            },    
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.fd_periode2+' </font>';
                return html 
              }
            },   
             { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.Fs_Code_Jenis_Reg+' </font>';
                return html 
              }
            },    
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.FD_TGL_INPUT+' </font>';
                return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.Fd_Tgl_Dikirim+' </font>';
                return html 
              }
            },    
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.Fd_Tgl_Diterima+' </font>';
                return html 
              }
            },    

            //   { "data": "empatlimahari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            //   { "data": "enampuluhhari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            //   { "data": "sembilanplhhari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            //   { "data": "seratuduapuluhhari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 
            //   { "data": "lebihseratuduapuluhhari" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 

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
    
                total6 = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
    
    
            $( api.column( 6 ).footer() ).html(
                $.fn.dataTable.render.number( '.','','').display( total6 )
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