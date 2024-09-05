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
  var JenisInfo = document.getElementById("JenisInfo").value;
  var TipePenjamin = document.getElementById("TipePenjamin").value;
  var NamaPenjamin = document.getElementById("NamaPenjamin").value;


      if (JenisInfo == '0') {
     
          window.location = base_url + "/SIKBREC/public/ExcelInfoRekapPiutangInvoice/ExcelInfoRekapPiutangInvoice2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisInfo + "/" + TipePenjamin+ "/" + NamaPenjamin;

      }
      else if (JenisInfo == '1') {
          window.location = base_url + "/SIKBREC/public/ExcelInfoRekapPiutangInvoice/ExcelInfoRekapPiutangInvoice3/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisInfo + "/" + TipePenjamin+ "/" + NamaPenjamin;

  }
  else if (JenisInfo == '2') {
      window.location = base_url + "/SIKBREC/public/ExcelInfoRekapPiutangInvoice/ExcelInfoRekapPiutangInvoice4/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisInfo + "/" + TipePenjamin+ "/" + NamaPenjamin;

}
}
async function getIDPenjamin() {
  try {
      const datagetNamaPenjamin = await getNamaPenjamin();
      updateUIgetNamaPasien(datagetNamaPenjamin);
  } catch (err) {
      toast(err, "error")
  }
}

function getNamaPenjamin() {
  var base_url = window.location.origin;
  let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
  return fetch(url, {
      method: 'POST',
      headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
      },
      body: 'tp_penjamin=' + $("#TipePenjamin").val()
  })
      .then(response => {
          if (!response.ok) {
              throw new Error(response.statusText)
          }
          return response.json();
      })
      .then(response => {
          if (response.status === "error") {
              throw new Error(response.message.errorInfo[2]);
              // console.log("ok " + response.message.errorInfo[2])
          } else if (response.status === "warning") {
              throw new Error(response.errorname);
              // console.log("ok " + response.message.errorInfo[2])
          }
          return response
      })
      .finally(() => {
          $("#NamaPenjamin").select2();
      })
}

function updateUIgetNamaPasien(datagetNamaPasien) {
  let responseApi = datagetNamaPasien; 
  if (responseApi.data !== null && responseApi.data !== undefined) {
      //console.log(responseApi.data);
      $("#NamaPenjamin").empty();
      var newRow = '<option value="">-- PILIH --</option ';
      $("#NamaPenjamin").append(newRow);
      for (i = 0; i < responseApi.data.length; i++) {
          var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
          $("#NamaPenjamin").append(newRow);
      }
  }
}
function chage(valJenisInfo){
  let value = $(valJenisInfo).val();
  if (value == '1'){
      $("#NamaPenjamin").attr('disabled', true);
      $("#TipePenjamin").attr('disabled', true);

  }else{
      $("#NamaPenjamin").attr('disabled', false);
      $("#TipePenjamin").attr('disabled', false);

  }
}
function chageV(valTipePenjamin){
  let value = $(valTipePenjamin).val();
  if (value == '4'){
      $("#NamaPenjamin").attr('disabled', true);
  }else{
      $("#NamaPenjamin").attr('disabled', false);
  }
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
  // if ($("#JenisJaminan").val() == ''){
  //     toast ('Isi Jenis Jaminan', "warning");
  //     return false;
  // }


  loadInfo();
}
function loadInfo() { 
  let PeriodeAwal ,PeriodeAkhir,JenisInfo;

  PeriodeAwal = $("#PeriodeAwal").val();
  PeriodeAkhir = $("#PeriodeAkhir").val();
  JenisInfo = $("#JenisInfo").val();
  TipePenjamin = $("#TipePenjamin").val();
  NamaPenjamin = $("#NamaPenjamin").val();

  

  // console.log(PeriodeAwal,PeriodeAkhir,JenisJaminan);return false;

  var base_url = window.location.origin;
  $('#datatable_invoice').dataTable({
      "bDestroy": true
  }).fnDestroy();
  $('#datatable_Jaminan').dataTable({
      "bDestroy": true
  }).fnDestroy();
  $('#datatable_Pasien').dataTable({
      "bDestroy": true
  }).fnDestroy();
  
      // $('#datatable_invoice').dataTable({
      //       "bDestroy": true
      //   }).fnDestroy();   

      if (JenisInfo == '0') {

          $('#datatable_invoice').show()
          $('#datatable_Jaminan').hide()
          $('#datatable_Pasien').hide()
          $('#datatable_invoice').DataTable().clear().destroy();
        $('#datatable_invoice').DataTable({
          "ordering": true, // Set true agar bisa di sorting
          "paging": true,
          "searching": true,
            "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
          
           "ajax": {
            "url": "/SIKBREC/public/Piutang/getInfoRekapPiutangInvoice",
            "type": "POST",
                data: function ( d ) { 
                  d.TglAwal = PeriodeAwal;
                  d.TglAkhir = PeriodeAkhir;
                  d.JenisInfo = JenisInfo;
                  d.TipePenjamin = TipePenjamin;
                  d.NamaPenjamin = NamaPenjamin;

              },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
          { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 

          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.FS_KET+' </font>';
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
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.umur+' </font>';
              return html 
            }
          }, 
            { "data": "piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
            { "data": "nilai_pay" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
            { "data": "sisa_piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 

            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.Keterangan+' </font>';
              return html 
            }
          },    
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.totalpasien+' </font>';
              return html 
            }
          },   
           
      ],
  });
} 
// else if (JenisInfo == '0' && TipePenjamin=='2') {

//     $('#datatable_invoice').show()
//     $('#datatable_Jaminan').hide()
//     $('#datatable_Pasien').hide()
//     $('#datatable_invoice').DataTable().clear().destroy();
//   $('#datatable_invoice').DataTable({
//     "ordering": true, // Set true agar bisa di sorting
//     "paging": true,
//     "searching": true,
//       "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
  
//      "ajax": {
//       "url": "/SIKBREC/public/Piutang/getInfoRekapPiutangInvoice",
//       "type": "POST",
//           data: function ( d ) { 
//             d.TglAwal = PeriodeAwal;
//             d.TglAkhir = PeriodeAkhir;
//             d.JenisInfo = JenisInfo;
//             d.TipePenjamin = TipePenjamin;
//             d.NamaPenjamin = NamaPenjamin;

          

//         },
//       "dataSrc": "",
//       "deferRender": true,
//   },
//   "columns": [
//     { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 

//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.FS_KET+' </font>';
//         return html 
//       }
//     }, 
//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.NamaPerusahaan+' </font>';
//         return html 
//       }
//     }, 
//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.Fd_Tgl_Dikirim+' </font>';
//         return html 
//       }
//     }, 
//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.Fd_Tgl_Diterima+' </font>';
//         return html 
//       }
//     }, 
//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.umur+' </font>';
//         return html 
//       }
//     }, 
//       { "data": "piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
//       { "data": "nilai_pay" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
//       { "data": "sisa_piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 

//       { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.Keterangan+' </font>';
//         return html 
//       }
//     },    
//     { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
//         var html = ""
//         var html  = '<font size="2">'+row.totalpasien+' </font>';
//         return html 
//       }
//     },   
   
// ],
// });
// }
else if (JenisInfo == '1') {

  $('#datatable_Jaminan').show()
  $('#datatable_invoice').hide()
  $('#datatable_Pasien').hide()
  $('#datatable_Jaminan').DataTable().clear().destroy();
$('#datatable_Jaminan').DataTable({
  "ordering": true, // Set true agar bisa di sorting
  "paging": true,
  "searching": true,
      "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      "ajax":
      {
            "url": "/SIKBREC/public/Piutang/getInfoRekapPiutangInvoice",
          "type": "POST",
          data: function (d) {
              d.TglAwal = PeriodeAwal;
              d.TglAkhir = PeriodeAkhir;
              d.JenisInfo = JenisInfo;
              d.TipePenjamin = TipePenjamin;
              d.NamaPenjamin = NamaPenjamin;
          },
          error: function (xhr, error, code) {
              toast('Error! Data Not Found!', "error")
              $("#datatable").hide();
          },
          "dataSrc": "",
          "deferRender": true,
      },
      "columns": [
          { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.NamaPerusahaan+' </font>';
              return html 
            }
          }, 
          { "data": "sisa_piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
                 ],
  });
}
else if (JenisInfo == '2') {

  $('#datatable_Pasien').show()
  $('#datatable_invoice').hide()
  $('#datatable_Jaminan').hide()
  $('#datatable_Pasien').DataTable().clear().destroy();
$('#datatable_Pasien').DataTable({
      "ordering": true, // Set true agar bisa di sorting
      "paging": true,
      "searching": true,
      "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      "ajax":
      {
            "url": "/SIKBREC/public/Piutang/getInfoRekapPiutangInvoice",
          "type": "POST",
          data: function (d) {
              d.TglAwal = PeriodeAwal;
              d.TglAkhir = PeriodeAkhir;
              d.JenisInfo = JenisInfo;
              d.TipePenjamin = TipePenjamin;
              d.NamaPenjamin = NamaPenjamin;
          },
          "dataSrc": "",
          "deferRender": true,
      },
      "columns": [
          { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.FS_KET+' </font>';
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
              var html  = '<font size="2">'+row.ket+' </font>';
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
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
              var html = ""
              var html  = '<font size="2">'+row.umur+' </font>';
              return html 
            }
          }, 
                      { "data": "piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
                      { "data": "nilai_pay" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
                      { "data": "sisa_piutang" ,  render: $.fn.dataTable.render.number(  '.','' ,'Rp ' )},  // Tampilkan nama 
                      { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                          var html = ""
                          var html  = '<font size="2">'+row.Keterangan+' </font>';
                          return html 
                        }
                      }, 
                      { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                          var html = ""
                          var html  = '<font size="2">'+row.totalpasien+' </font>';
                          return html 
                        }
                      }, 
                 ],
  });
}
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