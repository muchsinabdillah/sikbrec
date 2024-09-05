$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#btnLoadInformation').attr('disabled', true);
    $('#permintaanrawat_all').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListPasien();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
    $(document).on('click', '#sendmail', function () {
        SendEmail();
    });
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var TipeResume = document.getElementById("TipeResume").value;
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 

        window.location = base_url + "/SIKBREC/public/ExcelInfoResume/ExcelInfoResume2/" + TipeResume + "/" + PeriodeAwal + "/" + PeriodeAkhir;
   
}
function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if (Difference_In_Days > 30) {
    //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
    //     $('#btnLoadInformation').attr('disabled', true);
    // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // }
}
function getDataListPasien() { 
    let PeriodeAwal ,PeriodeAkhir,TipeResume;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipeResume = $("#TipeResume").val();
    var base_url = window.location.origin;
    $('#permintaanrawat_all').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#permintaanrawat_all').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5',footer: true, title: 'Informasi Resume Medis Pasien',orientation: 'landscape', pageSize: 'LEGAL', Image:('../public/images/yarsi.png'),
            customize: function ( xlsx ){
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // jQuery selector to add a border
                $('row c[r^="C"]', sheet).attr( 's', '25' );
                $('row c[r^="A"]', sheet).attr( 's', '25' );
                $('row c[r^="B"]', sheet).attr( 's', '25' );
                $('row c[r^="D"]', sheet).attr( 's', '25' );
                $('row c[r^="E"]', sheet).attr( 's', '25' );
                $('row c[r^="F"]', sheet).attr( 's', '25' );
                $('row c[r^="G"]', sheet).attr( 's', '25' );
                $('row c[r^="H"]', sheet).attr( 's', '25' );
                $('row c[r^="I"]', sheet).attr( 's', '25' );
                $('row c[r^="J"]', sheet).attr( 's', '25' );
                $('row c[r^="K"]', sheet).attr( 's', '25' );
                $('row c[r^="L"]', sheet).attr( 's', '25' );
                $('row c[r^="M"]', sheet).attr( 's', '25' );
                $('row c[r^="N"]', sheet).attr( 's', '25' );
                $('row c[r^="O"]', sheet).attr( 's', '25' );
                $('row c[r^="P"]', sheet).attr( 's', '25' );
            } //c[r^="C"]'
        },
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,title: 'Informasi Resume Medis Pasien',orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationResumeMedis/getDataListResumeMedisPasien", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               d.TipeResume = TipeResume;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [

               { "data": "Jenis_Resume_Medis" }, 
               { "data": "No_MR" }, 
               { "data": "No_Episode" },
               { "data": "No_Registrasi" }, 
               { "data": "Nama_Pasien" }, 
               { "data": "Tgl_lahir" }, 
               { "data": "Tgl_Berobat" }, 
               { "data": "Tgl_Pulang" },
               { "data": "Diagnosa_Awal" }, 
               { "data": "komordibitas" }, 
               { "data": "Diagnosa_Akhir" }, 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  `<button id="btnGenerateFile" name="btnGenerateFile" class="btn btn-primary btn-xs" onclick="ConfirmGenerateHasil('${row.ID}','${row.No_Registrasi}')">Generate Hasil</button>`;
                return html 
            }
          },
           ],
       });
} 

function ConfirmGenerateHasil(id,noreg) {
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
                    GenerateHasil(id,noreg)
                } else {
                   // swal("Transaction Rollback !");
                   return false;
                }
            });
       
    } catch (err) {
        toast(err, "error")
    }
}

async function GenerateHasil(id,noreg) {
    try{
        const data = await goGenerateHasil(id,noreg);
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
function goGenerateHasil(id,noreg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationResumeMedis/SaveMedical';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + id + "&NoRegistrasi=" + noreg
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
    var jeniscetakan = 'RESUME_MEDIS';
    var noregistrasi = $("#param_noreg").val();
    var email = $("#param_noreg").val();
    var judul = 'Resume Medis';
    var FormData = {
        notrs:notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/bInformationResumeMedis/SendMail/";
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