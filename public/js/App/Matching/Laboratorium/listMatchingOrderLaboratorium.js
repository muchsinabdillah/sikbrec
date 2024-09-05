$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    $('#datatable').DataTable({});
    // $('#datatablex').DataTable2({});
    $(document).on('click', '#btnLoadInformation', function () {
        CheckVar();
    });
    $(document).on('click', '#btnAddNewOrder', function () {
        goNewOrder();
    });
    // $(".preloader").fadeOut(); 
    // onloadForm();
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
function CheckVar(){
    //if not in creteria return false
    if ($("#PeriodeAwal").val() == ''){
        toast ('Isi Periode', "warning");
        return false;
    }
    // if ($("#PeriodeAkhir").val() == ''){
    //     toast ('Isi Periode Akhir', "warning");
    //     return false;
    // }
    /*
    if ($("#TipePenjamin").val() != '4'){
        if ($("#NamaPenjamin").val() == ''){
            toast ('Isi Nama Penjamin', "warning");
            return false;
        }
    }*/
    //if True
    getDataMatchOrderLab();
}


function getDataMatchOrderLab() { 
    let PeriodeAwal;
    PeriodeAwal = $("#PeriodeAwal").val();
    // PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/aMatchingLaboratorium/getDataListMatchOrderLab", // URL file untuk proses select datanya
              "type": "POST",
              data: function ( d ) {
              d.TglAwal = PeriodeAwal;
            //    d.TglAkhir = PeriodeAkhir;
              },
                "dataSrc": "",
          "deferRender": true,
          }, 
          "columns": [
             { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.LabID+'</font> ';
                return html 
            }
          },
           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoLAB+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.LabDate+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.PatientName+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoMR+'</font> ';
            return html 
        }
      },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoRegRI+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoEpisode+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.JamOrder+'</font> ';
                return html 
            }
          },
        //   { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        //         var html = ""
        //         var html  =  '<font size="2"> '+row.First_Name+'</font> ';
        //         return html 
        //     }
        //   },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  = '<td><div style="display: block; border: 1px; height: 65px; overflow-y: scroll">'+row.NamaTest+'</div></td>';
              return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.First_Name+'</font> ';
            return html 
            }
            },
          {
            "render": function (data, type, row) {
                var html = ""
                var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" style="width:100%"  onclick=\'modalForm("' + row.LabID + '", "'+ row.NoMR + '", "'+ row.LabDate + '")\'">MATCHING'
                return html
            },
          },
      ]
//        ,
// dom: 'Bfrtip',
//       buttons: [
//       'copyHtml5',
//       {
//           extend: 'excelHtml5',
//       },
//       'print',
//       'csv'
//   ]
  });
}

function modalForm(labid,nomr,labdate){
    $("#IDLab").val(labid);
    $("#IDNoMR").val(nomr);
    $("#DateLab").val(labdate);
    $('#myModal').modal('show');
    getDataMatching();
}

function getDataMatching() { 
  let IDLAB ,IDNoMR, DateLab;
  IDLab = $("#IDLab").val();
  IDNoMR = $("#IDNoMR").val();
  DateLab = $("#PeriodeAwal").val();
  // PeriodeAwal = $("#PeriodeAwal").val();
  // console.log('xxx');
  // return false;
  // PeriodeAkhir = $("#PeriodeAkhir").val();
  var base_url = window.location.origin;
  $('#datatablex').dataTable({
      "bDestroy": true
  }).fnDestroy();
  $('#datatablex').DataTable({
      "ordering": true, // Set true agar bisa di sorting
      "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      "ajax":
      {
            "url": base_url + "/SIKBREC/public/aMatchingLaboratorium/getDataListMatchingLab", // URL file untuk proses select datanya
            "type": "POST",
            data: function ( d ) {
            d.Idlab = IDLab;
            d.Nomr = IDNoMR;
            d.Datelab = DateLab;
            },
              "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.PatientName+'</font> ';
              return html 
          }
        },
         { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.NoMR+'</font> ';
              return html 
          }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.NoRegistrasi+'</font> ';
              return html 
          }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.NoEpisode+'</font> ';
              return html 
          }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
          var html = ""
          var html  =  '<font size="2"> '+row.First_Name+'</font> ';
          return html 
      }
    },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.NamaPerusahaan+'</font> ';
              return html 
          }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              var html = ""
              var html  =  '<font size="2"> '+row.TglKunjungan+'</font> ';
              return html 
          }
        },
        { "render": function (data, type, row) {
          var html = ""
          var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" style="width:100%"  onclick=\'updateLab("' + row.NoMR + '", "'+ row.NoRegistrasi + '", "'+ row.NoEpisode + '")\'">PILIH'
          return html
      },
    },
    ]
//        ,
// dom: 'Bfrtip',
//       buttons: [
//       'copyHtml5',
//       {
//           extend: 'excelHtml5',
//       },
//       'print',
//       'csv'
//   ]
});
}

// function updateLab(nomr,noreg,noeps){
//   let NoMR ,NoRegistrasi, NoEpisode;
//   NoMR = nomr;
//   NoRegistrasi = noreg;
//   NoEpisode = noeps;
// }

async function updateLab(nomr,noreg,noeps) {
  let NoMR ,NoRegistrasi, NoEpisode;
  NoMR = nomr;
  NoRegistrasi = noreg;
  NoEpisode = noeps;
  try {
      const datagoOrderLab = await goOrderLab(NoMR,NoRegistrasi,NoEpisode);
      updateUIdatagoOrderLab(datagoOrderLab);
  } catch (err) {
      //console.log(err);
      toast(err, "error")
  }
}
function goOrderLab(NoMR, NoRegistrasi, NoEpisode) {
  $(".preloader").fadeIn();
  // $('#btnOrder').addClass('btn-danger');
  // $('#btnOrder').html('Sending, Please Wait...');
  
  var nomr = NoMR;
  var noreg = NoRegistrasi;
  var noeps = NoEpisode;
  var idlab = document.getElementById("IDLab").value;

  // var str = $("#frmSimpanTrs").serialize();
  // console.log(nomr);
  // console.log(noreg);
  // console.log(noeps);

  // return false;
  var base_url = window.location.origin;
  let url = base_url + '/SIKBREC/public/aMatchingLaboratorium/goUpdatetblLab';
  return fetch(url, {
      method: 'POST',
      headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
      },
      body: 'nomr=' + nomr + '&noreg=' + noreg + '&noeps=' + noeps + '&idlab=' + idlab
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
          $(".preloader").fadeOut();
          // $('#btnOrder').removeClass('btn-danger');
          // $('#btnOrder').html('Pilih dan Order Paket');
          // document.getElementById("btnOrder").disabled = false;
      })
}
function updateUIdatagoOrderLab(params) {
  let response = params;

  if(response['status']== 'success'){
      // toast("Berhasil Update !", "success");
      //swal("Berhasil Simpan Order MCU !", "success");
      toast(response.message, "success")
          swal({
              title: "Save Success!",
              text: response.message,
              icon: "success",

          }).then(function() {
              setTimeout(() => {
              IsLocked(1);
                  
              }, 500);
              $('#myModal').modal('hide');
              getDataMatchOrderLab();
          });
      //var noregistrasi = response.NoRegistrasi; ;
  }
  else{
      toast(response['message'], "warning");
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

// function goNewOrder() {
//     const base_url = window.location.origin;
//     window.location = base_url + "/SIKBREC/public/bInfoRadiologi/ListRegOrderRadiologi/";
// }