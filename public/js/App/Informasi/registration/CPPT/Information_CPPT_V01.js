$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', true);
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        getDataListPasien();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var Noregistrasi = document.getElementById("Noregistrasi").value;
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value; 

        window.location = base_url + "/SIKBREC/public/ExcelInfoCPPT/ExcelInfoCPPT2/" + Noregistrasi + "/" + PeriodeAwal + "/" + PeriodeAkhir;
   
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
    let PeriodeAwal ,PeriodeAkhir,Noregistrasi;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    Noregistrasi = $("#Noregistrasi").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationCPPT/getDataListCPPTPasien", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               d.Noregistrasi = Noregistrasi;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
               { "data": "No" }, 
               { "data": "Tgl" }, 
               { "data": "NoMR" },
               { "data": "NamaPasien" }, 
               { "data": "NoRegistrasi" }, 
               { "data": "Date_of_birth" }, 
               { "data": "StartDate" },
               { "data": "S_Anamnesa" }, 
               { "data": "S_RPD" }, 
               { "data": "O_TTV" }, 
               { "data": "O_PemeriksaanFisik" }, 
               { "data": "A_Diagnosa" }, 
               { "data": "P_RencanaTatalaksana" }, 
               { "data": "P_InstruksiNonMedis" }, 
           ],
       });
} 

async function asyncShowMain() {
    try {
        const datagetNamaPasien = await getNamaPasien();
        updateUIgetNamaPasien(datagetNamaPasien);
    } catch (err) {
        toast(err, "error")
    }
}

function getNamaPasien() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationCPPT/getNamaPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val()
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
            $("#Noregistrasi").select2();
        })
}

function updateUIgetNamaPasien(datagetNamaPasien) {
    let responseApi = datagetNamaPasien; 
    if (responseApi.data !== null && responseApi.data !== undefined) {
       // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Noregistrasi").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].NoRegRI + '">' + responseApi.data[i].PatientName + ' - ' + responseApi.data[i].NoRegRI +'</option';
            $("#Noregistrasi").append(newRow);
        }
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