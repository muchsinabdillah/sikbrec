$(document).ready(function () {
    asyncShowMain();
    $('#btnLoadInformation').attr('disabled', false);
    $("#GrupPerawatan").attr('disabled', true);
    $("#NamaDokter").attr('disabled', true);
    $(".preloader").fadeOut(); 
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
    var JenisRekap = $("#JenisRekap").val(); 
    var JenisTipe = document.getElementById("JenisTipe").value; 
    var GrupPerawatan = document.getElementById("GrupPerawatan").value; 
    var JenisInfo = document.getElementById("JenisInfo").value; 
    var NamaDokter = document.getElementById("NamaDokter").value; 


    if (PeriodeAwal == ''){
        PeriodeAwal = '-';
    }
    if (PeriodeAkhir == ''){
        PeriodeAkhir = '-';
    }
    if (JenisRekap == ''){
        JenisRekap = '-';
    }
    if (JenisTipe == ''){
        JenisTipe = '-';
    }
    if (GrupPerawatan == ''){
        GrupPerawatan == '-';
    }
    if (JenisInfo == ''){
        JenisInfo = '-';
    }
    if (NamaDokter == ''){
        NamaDokter = '-';
    }

//     if (JenisTipe == '1') {
       
//         window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + GrupPerawatan+ "/" + NamaDokter;
//     }
//     else if (JenisTipe == '2' ) {
     
//         window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik3/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + GrupPerawatan+ "/" + JenisInfo+ "/" + NamaDokter;  

// } else if (JenisInfo == '6') {
//     window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik5/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + GrupPerawatan+ "/" + JenisInfo+ "/" + NamaDokter;  
// }else{
//     window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik4/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + GrupPerawatan+ "/" + JenisInfo+ "/" + NamaDokter;  
// }
// }
  
if (JenisTipe == '1' && JenisInfo != '6'){
   
    window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + JenisInfo+ "/" + GrupPerawatan+ "/" + NamaDokter;

}else if (JenisTipe == '2' && JenisInfo != '6'){

    if ((JenisInfo == '4' && JenisRekap == '4') || (JenisInfo == '4' && JenisRekap == '5') || (JenisInfo == '4' && JenisRekap == '6') || (JenisInfo == '4' && JenisRekap == '7') || (JenisInfo == '4' && JenisRekap == '8') || (JenisInfo == '4' && JenisRekap == '9') || (JenisInfo == '4' && JenisRekap == '10') || (JenisInfo == '4' && JenisRekap == '11' ) || (JenisInfo == '1' && JenisRekap == '13' ) || (JenisInfo == '2' && JenisRekap == '13' ) || (JenisInfo == '3' && JenisRekap == '13' )){
              
        window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik3/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + JenisInfo+ "/" + GrupPerawatan+ "/" + NamaDokter;
}else{
        window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik4/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + JenisInfo+ "/" + GrupPerawatan+ "/" + NamaDokter;
}
    }else if (JenisInfo == '6'){
            window.location = base_url + "/SIKBREC/public/ExcelInfoRekamMedik/ExcelInfoRekamMedik5/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisRekap + "/" + JenisTipe + "/" + JenisInfo+ "/" + GrupPerawatan+ "/" + NamaDokter;
        }else{
     
            toast('Error! Data Not Found!',"error")
        }
    }

function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // // console.log(Difference_In_Days)
    // // if (Difference_In_Days > 30) {
    // //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    // //     $("#PeriodeAwal").val('');
    // //     $("#PeriodeAkhir").val('');
    // //     $('#btnLoadInformation').attr('disabled', true);
    // // } else {
    //      $('#btnLoadInformation').attr('disabled', false);
    // // }
}
function clearVal(val){
    //------07-03-2023
    if (val == '13' || val == '11' || val == '9' || val == '8' || val == '7' || val == '6' || val == '5' || val == '4'){
        $("#JenisTipe").val('2').trigger('change');
        $("#JenisTipe").attr('disabled', true);
        return false;
    }

    $("#JenisTipe").val('');
    $("#JenisTipe").attr('disabled', false);
}

function chageV(val){
    
    //let id = $(val).attr('id');
    let value = $(val).val();
    let JenisRekap = $("#JenisRekap").val();
    //console.log(id);return false;
        if (value == '1'){//jika milih pivot per dokter
            if (JenisRekap == '1'){
                $("#GrupPerawatan").attr('disabled', true);
                $("#NamaDokter").attr('disabled', false);
            }else if (JenisRekap == '2'){
                $("#GrupPerawatan").attr('disabled', false);
                $("#NamaDokter").attr('disabled', true);
            }
        }else{
            $("#GrupPerawatan").attr('disabled', true);
            $("#NamaDokter").attr('disabled', true);
        }
}

//-----07-03-2023
function JenisInfoTrigger(val){
    if (val == '6'){
        $("#JenisRekap").val('').trigger('change');
        $("#JenisTipe").val('').trigger('change');
        $("#JenisRekap").attr('disabled', true);
        $("#JenisTipe").attr('disabled', true);
        return false
    }
    if (val == '5'){
        $("#JenisRekap").val('12').trigger('change');
        $("#JenisTipe").val('2').trigger('change');
        $("#JenisRekap").attr('disabled', true);
        $("#JenisTipe").attr('disabled', true);
        return false
    }
    $("#JenisRekap").val('').trigger('change');
    $("#JenisRekap").attr('disabled', false);
    $("#JenisTipe").attr('disabled', false);
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

    //------07-03-2023
    if ($("#JenisRekap").val() == '13'){
        if ($("#JenisInfo").val() != '1' && $("#JenisInfo").val() != '2' && $("#JenisInfo").val() != '3'){
            toast ('Rekap Jaminan Hanya Bisa Pilih Antara Jenis Pasien: [Rawat Jalan], [IGD], atau [Rawat Inap]', "warning");
            return false;
        }
    }
    var JenisRekap = $("#JenisRekap").val()
    // if (JenisRekap == '11' || JenisRekap == '9' || JenisRekap == '8' || JenisRekap == '7' || JenisRekap == '6' || JenisRekap == '5' || JenisRekap == '4'){
    //     if ($("#JenisInfo").val() != '4' ){
    //         toast ('Rekap Jaminan Hanya Bisa Pilih Jenis Pasien [All]', "warning");
    //         return false;
    //     }
    // }
    if ($("#JenisRekap").val() == '13'){
        if ($("#JenisInfo").val() != '1' && $("#JenisInfo").val() != '2' && $("#JenisInfo").val() != '3'){
            toast ('Rekap Jaminan Hanya Bisa Pilih Antara Jenis Pasien: [Rawat Jalan], [IGD], atau [Rawat Inap]', "warning");
            return false;
        }
    }

    //if True, get data
    getDataListPasien();
}


function getDataListPasien() { 
    let PeriodeAwal ,PeriodeAkhir,JenisRekap,JenisTipe,GrupPerawatan,JenisInfo,NamaDokter;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    JenisRekap = $("#JenisRekap").val();
    JenisTipe = $("#JenisTipe").val();
    GrupPerawatan = $("#GrupPerawatan").val();
    JenisInfo = $("#JenisInfo").val();
    NamaDokter = $("#NamaDokter").val();
    var base_url = window.location.origin;

    $('#datatable1').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable3').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable4').dataTable({
        "bDestroy": true
    }).fnDestroy();


    if (JenisTipe == '1' && JenisInfo != '6'){
        $("#datatable1").show();
        $("#datatable2").hide();
        $("#datatable3").hide();
        $("#datatable4").hide();

        
        $('#datatable1').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationRekamMedik/getDataListRekamMedikPasien", // URL file untuk proses select datanya
                "type": "POST",
                data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.JenisRekap = JenisRekap;
                d.JenisTipe = JenisTipe;
                d.JenisInfo = JenisInfo;
                d.GrupPerawatan = GrupPerawatan;
                d.NamaDokter = NamaDokter;
                },
                error: function (xhr, error, code)
            {
                toast('Error! Data Not Found!',"error")
                $("#datatable1").hide();
            },
                 "dataSrc": "",
            "deferRender": true,
            
            }, 
            "columns": [
             { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
             { "data": "TglKunjungan" }, 
              { "data": "NoMR" }, 
              { "data": "JenisPasien" }, 
              { "data": "statusregis" },
              { "data": "NoRegistrasi" }, 
              { "data": "PatientName" },    
              { "data": "Gander" }, 
               { "data": "NamaUnit"}, 
              { "data": "A_Diagnosa" },  
              { "data": "First_Name" },  
              { "data": "NamaPerusahaan" },
              { "data": "Address" }, 
              { "data": "Kelurahan" },    
              { "data": "Kecamatan" }, 
               { "data": "kabupatenNama"}, 
              { "data": "ProvinsiNama" },  
              { "data": "NamaCaraMasuk" },  
              { "data": "NamaCaraMasukRef" },
              { "data": "tarif" }, 
              { "data": "TarifRS" },    
              { "data": "totalbill" }, 
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
            ]
        });

    }else if (JenisTipe == '2' && JenisInfo != '6'){

        if ((JenisInfo == '4' && JenisRekap == '4') || (JenisInfo == '4' && JenisRekap == '5') || (JenisInfo == '4' && JenisRekap == '6') || (JenisInfo == '4' && JenisRekap == '7') || (JenisInfo == '4' && JenisRekap == '8') || (JenisInfo == '4' && JenisRekap == '9') || (JenisInfo == '4' && JenisRekap == '10') || (JenisInfo == '4' && JenisRekap == '11' ) || (JenisInfo == '1' && JenisRekap == '13' ) || (JenisInfo == '2' && JenisRekap == '13' ) || (JenisInfo == '3' && JenisRekap == '13' )){
            $("#datatable1").hide();
            $("#datatable2").hide();
            $("#datatable3").show();
            $("#datatable4").hide();
    
            
            $('#datatable3').DataTable({
                "ordering": true, // Set true agar bisa di sorting
                "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                "ajax":
                {
                    "url": base_url + "/SIKBREC/public/bInformationRekamMedik/getDataListRekamMedikPasien", // URL file untuk proses select datanya
                    "type": "POST",
                    data: function ( d ) {
                    d.TglAwal = PeriodeAwal;
                    d.TglAkhir = PeriodeAkhir;
                    d.JenisRekap = JenisRekap;
                    d.JenisTipe = JenisTipe;
                    d.JenisInfo = JenisInfo;
                    d.GrupPerawatan = GrupPerawatan;
                    d.NamaDokter = NamaDokter;
                    },
                    error: function (xhr, error, code)
                    {
                        toast('Error! Data Not Found!',"error")
                        $("#datatable3").hide();
                    },
                     "dataSrc": "",
                "deferRender": true,
                }, 
                "columns": [
                 { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
                 { "data": "Keterangan" }, 
                 { "data": "total"},
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'print'
                ]
            });
         }else{

        $("#datatable1").hide();
        $("#datatable2").show();
        $("#datatable3").hide();
        $("#datatable4").hide();

       
        $('#datatable2').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationRekamMedik/getDataListRekamMedikPasien", // URL file untuk proses select datanya
                "type": "POST",
                data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.JenisRekap = JenisRekap;
                d.JenisTipe = JenisTipe;
                d.JenisInfo = JenisInfo;
                d.GrupPerawatan = GrupPerawatan;
                d.NamaDokter = NamaDokter;
                },
                error: function (xhr, error, code)
                {
                    toast('Error! Data Not Found!',"error")
                    $("#datatable2").hide();
                },
                 "dataSrc": "",
            "deferRender": true,
            }, 
            "columns": [
             { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
             { "data": "NamaUnit" }, 
             { "data": "First_Name" }, 
             { "data": "01"},
             { "data": "02"},
             { "data": "03"},
             { "data": "04"},
             { "data": "05"},
             { "data": "06"},
             { "data": "07"},
             { "data": "08"},
             { "data": "09"},
             { "data": "10"},
             { "data": "11"},
             { "data": "12"},
             { "data": "13"},
             { "data": "14"},
             { "data": "15"},
             { "data": "16"},
             { "data": "17"},
             { "data": "18"},
             { "data": "19"},
             { "data": "20"},
             { "data": "21"},
             { "data": "22"},
             { "data": "23"},
             { "data": "24"},
             { "data": "25"},
             { "data": "26"},
             { "data": "27"},
             { "data": "28"},
             { "data": "29"},
             { "data": "30"},
             { "data": "31"},
             { "data": "total"},
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
            ]
        });
      }
    }else if (JenisInfo == '6'){
        $("#datatable1").hide();
        $("#datatable2").hide();
        $("#datatable3").hide();
        $("#datatable4").show();

        
        $('#datatable4').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationRekamMedik/getDataListRekamMedikPasien", // URL file untuk proses select datanya
                "type": "POST",
                data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.JenisRekap = JenisRekap;
                d.JenisTipe = JenisTipe;
                d.JenisInfo = JenisInfo;
                d.GrupPerawatan = GrupPerawatan;
                d.NamaDokter = NamaDokter;
                },
                error: function (xhr, error, code)
                {
                    toast('Error! Data Not Found!',"error")
                    $("#datatable4").hide();
                },
                 "dataSrc": "",
            "deferRender": true,
            }, 

            "columns": [
             { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
             { "data": "TglOrder" }, 
             { "data": "TglOperasi"},
             { "data": "NoMR" }, 
             { "data": "NoRegistrasi"},
             { "data": "NamaPasien" }, 
             { "data": "DiagnosaPreOP"},
             { "data": "DiagnosaPostOP" }, 
             { "data": "JenisOperasi"},
             { "data": "DrOperator" }, 
             { "data": "DrAnastesi"},
             { "data": "PerkiraanLamaOP" }, 
             { "data": "NamaPerusahaan"},
             { "data": "GroupSpesialis" }, 
             { "data": "KlasifikasiOP"},
             { "data": "LaporanOP"},
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
            ]
        });
    }else{
        $("#datatable1").hide();
        $("#datatable2").hide();
        $("#datatable3").hide();
        $("#datatable4").hide();
        toast('Error! Data Not Found!',"error")
    }

    
} 


async function asyncShowMain() {
    try { 
        
        const datagetGrupPerawatan = await getGrupPerawatan(); 
        const datagetDokterAllAktif =  await getDokterAllAktif();
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        updateUIgetDokterAllAktif(datagetDokterAllAktif);
     
    } catch (err) {
        toast(err, "error")
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
/*
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
*/
function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
    return fetch(url, {
        method: 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
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
            $("#GrupPerawatan").select2();
        })
}

function updateUIgetDokterAllAktif(datagetDokterAllAktif) {
    let data = datagetDokterAllAktif;
    if (data !== null && data !== undefined) {
        $("#NamaDokter").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaDokter").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].First_Name + '</option';
            $("#NamaDokter").append(newRow);
        }
    }
}

function getDokterAllAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationRekamMedik/getIDDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#GrupPerawatan").val()
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
            $("#NamaDokter").select2();
        })
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