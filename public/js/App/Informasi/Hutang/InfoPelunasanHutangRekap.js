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

        window.location = base_url + "/SIKBREC/public/ExcelInfoPelunasanHutangRekap/ExcelInfoPelunasanHutangRekap2/" + PeriodeAwal + "/" + PeriodeAkhir;
   
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
              "url": "/SIKBREC/public/Hutang/getInfoPelunasanHutangRekap",
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
                var html  = '<font size="2">'+row.KD_TRS_PAY+' </font>';
                return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.KD_TRS_ORDER+' </font>';
                return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.TGL_PAY+' </font>';
              return html 
              }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.First_Name+' </font>';
                return html 
                }
              }, 
              { "data": "TOTAL" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},  // Tampilkan nama 

              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.PeriodeHutangAwal+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.PeriodeHutangAkhir+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.REK_PELUNASAN+' </font>';
                return html 
                }
              }, 
              { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.FS_NM_REKENING+' </font>';
                return html 
                }
              }, 
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