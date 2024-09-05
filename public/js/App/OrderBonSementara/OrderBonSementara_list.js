$(document).ready(function () {
    onloadForm();
});
function showInputDataBon(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/OrderBonSementara/viewBonSementara/' + str;
}
function goInputDataBon() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/OrderBonSementara/viewBonSementara/";
}
function PrintbyID(parameter){
    // var no_jurnal = $("#NoJurnal").val();
    const base_url = window.location.origin;
    url = "/SIKBREC/public/OrderBonSementara/PrintBuktiRegis/"+parameter;
    var win = window.open(url, '_blank');
    win.focus();
}
async function onloadForm() {
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/OrderBonSementara/getListDataBonSementara",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            { "data": "No_Transaksi" },
            { "data": "Tanggal" },
            { "data": "Pegawai" },
            { "data": "Nominal" },
            { "data": "Keterangan" },
            { "data": "No_Pencairan" },
            { "data": "Tgl_Pencairan" },
            { "data": "STATUS_Selesai" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="showInputDataBon(' + row.ID + ')" ><span class="visible-content" >Edit</span><button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'PrintbyID("' + row.ID + '")\' ><span class="visible-content" > Cetak</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>'
                    return html
                },
            },
            
        ]
    });
}

// function toast(data, status) {
//     toastr.options = {
//         "closeButton": true,
//         "debug": false,
//         "newestOnTop": false,
//         "progressBar": false,
//         "positionClass": "toast-top-right",
//         "preventDuplicates": false,
//         "onclick": null,
//         "showDuration": "300",
//         "hideDuration": "1000",
//         "timeOut": "3500",
//         "extendedTimeOut": "1000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut"
//     }
//     toastr[status](data);
// }







// $(document).ready(function () {
//     $(".preloader").fadeOut();
//     $('#example').dataTable({
//              "bDestroy": true
//          }).fnDestroy();
//    $('#example').DataTable( {
//          "ordering": false,
//          "ajax": {
//              "url": "controller/keuangan/exec_kasbon.php?action=ShowDataAllOrder",
//              "dataSrc": "",
//              "deferRender": true,
//          },
//          "columns": [
//                  { "data": "No_Transaksi" }, 
//                  { "data": "TglOrder" }, 
//                  { "data": "Pegawai" },  
//                  { "data": "Nominal" }, 
//                  { "data": "Keterangan" },  
//                  { "data": "No_Pencairan"}, 
//                  { "data": "TglPencairan"},  
//                  { "render": function ( data, type, row ) {
//                        var html = ""
 
//                        if(row.Status=='Order'){
//                          var html  = '<span class="badge badge-secondary">Order</span>'
//                        }else{
//                          var html  = '<span class="badge badge-primary">Realisasi</span>'
//                        }
                        
//                             return html
//                      },
//                  },   
//                  { "render": function ( data, type, row ) {
//                        var html = ""
 
//                        if(row.Status=='Order'){
//                          var attribute  = ''
//                        }else{
//                          var attribute  = 'Disabled'
//                        }
                        
//                          var html  = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="ShowKasbonPegawai('+row.ID+')" '+attribute+'><i class="fa fa-pencil-alt"></i></button>'
//                             return html
//                      },
//                  },    
//          ],
//          dom: 'Bfrtipl',
//          buttons: [
//              'copyHtml5',
//              'excelHtml5', 
//              'print',
//              'csv'
//          ]
//      } );
  
 
//      $('.js-example-basic-single').select2();
 
//  });
 
