$(document).ready(function () {
    asyncShowMain();
    $("#GrupPerawatan").attr('disabled', true);
    $("#NamaDokter").attr('disabled', true);
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        //checking before get data
        CheckVar();
    });

    $('#JenisInfo').change(function () {
        $("#JenisRekap").val('');
    });

    $('#JenisRekap').change(function () {
      if ($("#JenisInfo").val() == '3'){
        if ($("#JenisRekap").val() == '2'){
            toast ('Tidak Bisa Pilih Rekap Pivot Per Poliklinik Jika Pasien Rawat Inap', "warning");
            $("#JenisRekap").val('')
            return false;
        }
      }
    });

});

function clearVal(){
    $("#JenisTipe").val('');
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

    if ($("#JenisInfo").val() == '3'){
        if ($("#JenisRekap").val() == '2'){
            toast ('Tidak Bisa Pilih Rekap Pivot Per Poliklinik Jika Pasien Rawat Inap', "warning");
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
    // $('#datatable3').dataTable({
    //     "bDestroy": true
    // }).fnDestroy();
    // $('#datatable4').dataTable({
    //     "bDestroy": true
    // }).fnDestroy();


    if (JenisTipe == '1'){
        $("#datatable1").show();
        $("#datatable2").hide();
        $("#datatable3").hide();
        $("#datatable4").hide();

        
        $('#datatable1').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationBPJS/getDataListRekamMedikPasien", // URL file untuk proses select datanya
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
              { "data": "First_Name" },  
              { "data": "NamaPerusahaan" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    }else if (JenisTipe == '2'){
        $("#datatable1").hide();
        $("#datatable2").show();
        $("#datatable3").hide();
        $("#datatable4").hide();
        $('#datatable2').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "paging": false, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationBPJS/getDataListRekamMedikPasien", // URL file untuk proses select datanya
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
                'excelHtml5'
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