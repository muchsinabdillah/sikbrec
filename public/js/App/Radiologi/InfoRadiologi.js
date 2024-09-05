$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        CheckVar();
    });
    $(document).on('click', '#btnAddNewOrder', function () {
        goNewOrder();
    });
    // $(".preloader").fadeOut(); 
    // onloadForm();
    $(document).on('click', '#sendmail', function () {
        SendEmail();
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
    /*
    if ($("#TipePenjamin").val() != '4'){
        if ($("#NamaPenjamin").val() == ''){
            toast ('Isi Nama Penjamin', "warning");
            return false;
        }
    }*/
    //if True
    getDataInfoRadiologi();
}


function getDataInfoRadiologi() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/bInfoRadiologi/getDataListInfoRadiologi", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
             { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.ACCESSION_NO+'</font> ';
                return html 
            }
          },
           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.ORDER_DATE+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.JamOrder+'</font> ';
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
                var html  =  '<font size="2"> '+row.PATIENT_NAME+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.REQUESTED_PROC_DESC+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.DokterRadiologi+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.SCHEDULED_MODALITY+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.TypePatient+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.PATIENT_LOCATION+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  `<button id="btnGenerateFile" name="btnGenerateFile" class="btn btn-primary btn-xs" onclick="ConfirmGenerateHasil('${row.ACCESSION_NO}','${row.NoRegistrasi}')">Generate Hasil</button>`;
            return html 
        }
      },
      ],
       dom: 'Bfrtip',
      buttons: [
      'copyHtml5',
      {
          extend: 'excelHtml5',
          
      },
      'print',
      'csv'
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

function goNewOrder() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/bInfoRadiologi/ListRegOrderRadiologi/";
}

function ConfirmGenerateHasil(acn,noreg) {
    try{
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Generate ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(".preloader").fadeIn();
                    GenerateHasil(acn,noreg)
                } else {
                   // swal("Transaction Rollback !");
                   return false;
                }
            });
       
    } catch (err) {
        toast(err, "error")
    }
}

async function GenerateHasil(acn,noreg) {
    try{
        const data = await goGenerateHasil(acn,noreg);
        updateUIgoGenerateHasil(data,noreg);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgoGenerateHasil(data,noreg) {
    let responseApi = data;
    if (responseApi['status'] == 200){
        swal({
            title: "success",
            text: responseApi['message'],
            icon: "success",
        });
        $("#param_id").val(responseApi.data); 
        $("#param_noreg").val(noreg); 
        $('#modalSend').modal('show');
    }else{
        swal({
            title: "warning",
            text: responseApi['message'],
            icon: "warning",
        }) 
    }
}
function goGenerateHasil(acn,noreg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfoRadiologi/SaveHasilRadiologi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + acn + "&NoRegistrasi=" + noreg
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function SendEmail() {
    $(".preloader").fadeIn();
    var notrs = $("#param_id").val();
    var jeniscetakan = 'HASIL_RADIOLOGI';
    var noregistrasi = $("#param_noreg").val();
    var email = $("#param_noreg").val();
    var judul = 'Hasil Radiologi';
    var FormData = {
        notrs:notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/bInfoRadiologi/SendMail/";
    $.ajax({
        url: url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
        success: function (data) {
          $(".preloader").fadeOut();
            if (data.status=='success'){
              var title = 'Kirim Email Berhasil!';
              var statuskirim = 'TERKIRIM';
            }else{
              var title = 'Kirim Email Gagal!';
              var statuskirim = 'GAGAL';
            }
            swal({
              title: title,
              text: data.message,
              icon: data.status,
          }).then(function() {

          });
          //INSERT TZ LOG EMAIL
          //goInsertLog(nolab,statuskirim,email);

        },
        error: function (xhr, status) {
          $(".preloader").fadeOut();
          toast(xhr, status);
            // handle errors
            console.log(xhr,status);
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
