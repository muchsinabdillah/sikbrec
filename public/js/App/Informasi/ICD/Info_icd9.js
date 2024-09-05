$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#btn_infoICD').attr('disabled', false);
    $(document).on('click', '#btn_infoICD', function () {
        //checking before get data
        CheckVar();
    });
   
});


async function asyncShowMain() {
    try { 
        
        const datagetPoli =  await getPoli();
        const datagetDokter =  await getDokter();

        updateUIgetPoli(datagetPoli);
        updateUIgetDokter(datagetDokter);
    } catch (err) {
        toast(err, "error")
    }
}



function updateUIgetPoli(datagetPoli) {
    let data = datagetPoli;
    if (data !== null && data !== undefined) {
        // $("#Poli").empty();
        // var newRow = '<option value="">-- PILIH --</option';
        $("#Poli").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].NamaUnit + '">' + data.data[i].NamaUnit + '</option';
            $("#Poli").append(newRow);
        }
    }
}

function getPoli() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfo_ICD9/getListPoli';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#tipepembayaran").val()
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
            $("#Poli").select2();
        })
}
function updateUIgetDokter(datagetDokter) {
    let data = datagetDokter;
    if (data !== null && data !== undefined) {
        // $("#kasir").empty();
        // var newRow = '<option value="">-- PILIH --</option';
        $("#Dokter").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].First_Name + '">' + data.data[i].First_Name + '</option';
            $("#Dokter").append(newRow);
        }
    }
}

function getDokter() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfo_ICD9/getDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#tipepembayaran").val()
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
            $("#Dokter").select2();
        })
}
function clearVal(val){
    //------07-03-2023
    if (val == '1' ){
        $("#Poli").val('').trigger('change');
        $("#Poli").attr('disabled', true);
        $("#Dokter").val('').trigger('change');
        $("#Dokter").attr('disabled', true);
        return false;
    } 
    else if (val == '2' ){
        $("#Poli").val('').trigger('change');
        $("#Poli").attr('disabled', false);
        $("#Dokter").val('').trigger('change');
        $("#Dokter").attr('disabled', true);
        return false;
    } 
    else if(val == '3' ){
        $("#Poli").val('').trigger('change');
        $("#Poli").attr('disabled', true);
        $("#Dokter").val('').trigger('change');
        $("#Dokter").attr('disabled', false);
        return false;
    }

    $("#Poli").val('');
    $("#Poli").attr('disabled', false);
    $("#Dokter").val('');
    $("#Dokter").attr('disabled', false);
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

    getDataRekap();
}
function getDataRekap() { 
    let PeriodeAwal ,PeriodeAkhir,Poli,jenisinfo,Dokter;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    Poli = $("#Poli").val();
    jenisinfo = $("#jenisinfo").val();
    Dokter = $("#Dokter").val();
    // tipeinfo = $("#tipeinfo").val();
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
    if (jenisinfo == '1' ){
        $("#datatable1").show();
        $("#datatable2").hide();
        $("#datatable3").hide();

       $('#datatable1').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfo_ICD9/getDataRekap9", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.Poli = Poli;
                d.jenisinfo = jenisinfo;
                d.Dokter = Dokter;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no" }, 
            { "data": "ICD_CODE" }, 
            { "data": "DESCRIPTION" }, 
             { "data": "TOTAL" }, 
                   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });

    }else if (jenisinfo == '2' ){
        $("#datatable1").hide();
        $("#datatable2").show();
        $("#datatable3").hide();

        // $('#datatable2').dataTable({
        //     "bDestroy": true
        // }).fnDestroy();

       $('#datatable2').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfo_ICD9/getDataRekap9", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.Poli = Poli;
                d.jenisinfo = jenisinfo;
                d.Dokter = Dokter;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no" }, 
            { "data": "NamaUnit" },
            { "data": "ICD_CODE" }, 
            { "data": "DESCRIPTION" }, 
             { "data": "TOTAL" }, 
           
                   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });
    }else if (jenisinfo == '3' ){
        $("#datatable1").hide();
        $("#datatable2").hide();
        $("#datatable3").show();

        // $('#datatable2').dataTable({
        //     "bDestroy": true
        // }).fnDestroy();

       $('#datatable3').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfo_ICD9/getDataRekap9", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.Poli = Poli;
                d.jenisinfo = jenisinfo;
                d.Dokter = Dokter;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "no" }, 
            { "data": "NamaDokter" },
            { "data": "ICD_CODE" }, 
            { "data": "DESCRIPTION" }, 
             { "data": "TOTAL" }, 
           
                   
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
        toast('Error! Data Not Found!',"error")
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