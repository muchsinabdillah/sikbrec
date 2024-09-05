$(document).ready(function () {
    $(".preloader").fadeOut(); 
    // // $('#btnLoadInformation').attr('disabled', false);
    $('#example').DataTable({});
    // $('#datatable_listuse').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        var as = $("#PeriodeAwal").val()
        var ed = $("#PeriodeAkhir").val()
        var jenisinfo = $("#jenisinfo").val()

        var cek = CheckVar(as,ed,jenisinfo);
        if (cek == true){ 
            getDataInformasiHutang(as,ed,jenisinfo);
        }

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
function CheckVar (as,ed,jenisinfo){
    //if not in creteria return false
    if (as == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if (ed == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }
    if (jenisinfo == ''){
        toast ('Isi Jenis Info', "warning");
        return false;
    }

    return true;
}


function getDataInformasiHutang(as,ed,jenisinfo) { 
    
    // let PeriodeAwal ,PeriodeAkhir;
    // PeriodeAwal = $("#PeriodeAwal").val();
    // PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/Hutang/getDataInformasiHutang", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = as;
                d.TglAkhir = ed;
                d.jenisinfo = jenisinfo;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "KD_HUTANG" },
            { "data": "Company" },
            { "data": "NAMA_BANK_SUPPLIER" },
            { "data": "NO_REKENING_SUPPLIER" },
            
            { "data": "KET" }, 
            { "data": "NO_FAKTUR" },  
            { "data": "NILAI_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '', 0,'' )},  // Tampilkan nama 
            { "data": "SISA_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '', 0,'' )},  // Tampilkan nama   
            
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =row.TGL_HUTANG;
                  return html 
              }
            }, 
             { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                  var html  =row.TGL_TEMPO;
                  return html 
              }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =row.Keterangan;
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
