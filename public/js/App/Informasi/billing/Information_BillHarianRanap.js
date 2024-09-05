$(document).ready(function () {
    //asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
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

        window.location = base_url + "/SIKBREC/public/ExcelInfoPasienRanap/ExcelInfoPasienRanap2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisInfo + "/" + TipePenjamin + "/" + NamaPenjamin;
   
}
function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // // if (Difference_In_Days > 30) {
    // //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    // //     $("#PeriodeAwal").val('');
    // //     $("#PeriodeAkhir").val('');
    // //     $('#btnLoadInformation').attr('disabled', true);
    // // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // // }
}
function CheckVar (){
    //if not in creteria return false
    if ($("#PeriodeAwal").val() == ''){
        toast ('Isi Periode Awal', "warning");
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
    getDataListPasien();
}


function getDataListPasien() { 
    let PeriodeAwal ,PeriodeAkhir,TipePenjamin,NamaPenjamin;
    PeriodeAwal = $("#PeriodeAwal").val();
    TipePenjamin = $("#TipePenjamin").val();
    NamaPenjamin = $("#NamaPenjamin").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListInfoBillHarianRanap", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.dates = PeriodeAwal;
               d.TipePenjamin = TipePenjamin;
               d.NamaPenjamin = NamaPenjamin;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no"  ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
            { "data": "PatientName" }, 
           { "data": "noreg" }, 
            { "data": "NoMR" }, 
            { "data": "penjamin" },  
            { "data": "HakKelas" }, 
            { "data": "Class" }, 
            { "data": "totalkamar"  ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )}, 
            { "data": "totalvst" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )},  
            { "data": "totalrad" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ) }, 
            { "data": "totallab" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )},    
            { "data": "totalaptk" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )},   
            { "data": "totalperhari" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )}, 
            { "data": "TotalBiayaRawat" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )}, 
            { "data": "TarifCoding"},   
            { "data": "diagnosa"},   
            { "data": "NamaTindakanOP"},   
            { "data": "lamarawat" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )},  
           ],
       });
} 

async function asyncShowMain() {
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
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaPenjamin").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
            $("#NamaPenjamin").append(newRow);
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