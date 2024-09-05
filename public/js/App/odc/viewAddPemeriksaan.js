
$(document).ready(function () {
    $(".preloader").fadeOut(); 
    asyncShowMain();
    getDataDetailBilling();
    

    // $('#tbl_rincianbiaya').DataTable( {
    //     "order": [[ 0, "asc" ]]
    // } );

    $('#btn_tambah_tindakan').click(function () {
        $("#addtindakan_modal").modal('show');
        getDokter();
        getTindakan();
    });

    $('#btn_saveaddvisit').click(function () {
        goAddPemeriksaan();
    });


    //Auto Generate Total Tarif
    $('#qty_addvisit').on('input',function() {
        $("#diskon_addvisit").val('');
        var tarif_satuan = parseInt($('#tarif_satuan_addvisit').val());
        var qty = parseInt($('#qty_addvisit').val());
        var total_tarif_addvisit = qty*tarif_satuan;
        $('#total_tarif_addvisit_temp').val((total_tarif_addvisit ? total_tarif_addvisit : 0).toFixed(0));
      });

      //Auto Generate diskon Add Visit
      $('#diskon_addvisit').on('input',function() {
        var total_tarif_addvisit1 = parseInt($('#total_tarif_addvisit_temp').val());
        var diskon = parseFloat($('#diskon_addvisit').val());
        var hasil_diskon = total_tarif_addvisit1*(diskon/100);
        var subtotal = total_tarif_addvisit1-hasil_diskon;
        $('#total_tarif_addvisit').val((subtotal ? subtotal : 0).toFixed(0));
      });
});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        /*
        if ($("#IdAuto").val() != ''){ // if edit
            const datagetDatabyID = await getDatabyID();
            updateUIdatagetDatabyID(datagetDatabyID);
        }else{
            document.getElementById("labeledit").style.display = 'none';
            $("#TglMasuk").val(getDateNow);
            $("#JamMasuk").val(getTimeNow);
            $("#TglMasuk").attr('readonly', false);
            $("#JamMasuk").attr('readonly', false);
            $(".preloader").fadeOut(); 
        }
        */

    
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
         //await getRoomID(dataresponse.data.IDKelas);
         //await getBedID(dataresponse.data.RoomName);
        $("#NamaPasien").val(convertEntities(dataresponse.data.PatientName));
        $("#NoMR").val(convertEntities(dataresponse.data.NoMR));
        $("#NoEpisode").val(convertEntities(dataresponse.data.NoEpisode));
        $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
        $("#TanggalLahir").val(convertEntities(dataresponse.data.DOB+' ('+dataresponse.data.age+')'));
        $("#Penjamin").val(convertEntities(dataresponse.data.nama_penjamin));
        $("#GroupJaminan").val(convertEntities(dataresponse.data.GroupJaminan));
        $("#AlihStatusDari").val(convertEntities(dataresponse.data.NoRegisRWJ));
        $("#Dokter").val(convertEntities(dataresponse.data.NamaDokter));
        $("#IDUnit").val(convertEntities(dataresponse.data.Unit));
        $("#Unit").val(convertEntities(dataresponse.data.NamaUnit));
        $("#Kelas").val(convertEntities(dataresponse.data.NamaKelas));
        $("#IDKelas").val(convertEntities(dataresponse.data.IDKelas));
        $("#TglMasuk").val(convertEntities(dataresponse.data.TglMasuk));
        $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
        $("#HakKelas").val(convertEntities(dataresponse.data.HakKelas));
        $("#Diagnosa").val(convertEntities(dataresponse.data.Diagnosa));
        $("#penjamin_kode").val(convertEntities(dataresponse.data.penjamin_kode));
        $("#Keterangan_Ext").val(convertEntities(dataresponse.data.TelemedicineIs+' / '+dataresponse.data.JenisPasien));
        $("#judul").html(dataresponse.data.judul);
        $("#TypePatientID").val(convertEntities(dataresponse.data.TypePatientID));

        $("#tglpayment").val(convertEntities(dataresponse.data.TglMasuk));
        $("#tglpayment_closing").val(convertEntities(dataresponse.data.TglMasuk));

        //border
        if (dataresponse.data.judul == 'Rawat Inap'){
            $('#border').addClass('border-ranap');
        }else if (dataresponse.data.judul == 'Rawat Jalan'){
            $('#border').addClass('border-rajal');
        }else if (dataresponse.data.judul == 'Walkin'){
            $('#border').addClass('border-walkin');
        }else if (dataresponse.data.judul == 'Penjualan Bebas'){
            $('#border').addClass('border-bebas');
        }
        
        $('#statusreg').html(dataresponse.data.StatusReg);
        if (dataresponse.data.statusid == '0'){
            var badge = 'success';
        }else if(dataresponse.data.statusid == '1'){
            var badge = 'info';
        }else if(dataresponse.data.statusid == '2'){
            var badge = 'warning';
        }else if(dataresponse.data.statusid == '3'){
            var badge = 'danger';
        }else if(dataresponse.data.statusid == '4'){
            var badge = 'secondary';
        }else{
            var badge = 'default';
        }

        //Badge for Status if Penjualan Bebas
        if (dataresponse.data.NamaUnit == 'Penjualan Bebas'){
            if (dataresponse.data.statusid == '0'){
                var badge = 'success';
            }else if(dataresponse.data.statusid == '1'){
                var badge = 'warning';
            }else if(dataresponse.data.statusid == '2'){
                var badge = 'danger';
            }else if(dataresponse.data.statusid == '3'){
                var badge = 'secondary';
            }else if(dataresponse.data.statusid == '4'){
                var badge = 'secondary';
            }else{
                var badge = 'default';
            }
        }
        
        $('#statusreg').addClass('badge badge-'+badge);

        $("#tglawal").val(convertEntities(dataresponse.data.awal_periode));

                  var today = new Date();
                  var dd = String(today.getDate()).padStart(2, '0');
                  var mm = String(today.getMonth() + 1).padStart(2, '0');
                  var yyyy = today.getFullYear();

                  var datenow = yyyy +"-"+ mm +"-"+ dd;
                  $("#tglakhir").val(datenow);

        $(".preloader").fadeOut(); 
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#NoRegistrasi").val() 
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
            
        })
}

async function getClassID(classid) {
    try{
        const datagetClass = await getClass(classid);
        updateUIdatagetClass(datagetClass);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getClass() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
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
            $("#cb_editkelas").select2();
            $("#kelasedit").select2();
        })
}

function updateUIdatagetClass(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#cb_editkelas").append(newRow);
        $("#kelasedit").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
            $("#cb_editkelas").append(newRow);
            $("#kelasedit").append(newRow);
        }
    }
}

async function getTindakan(){
    try{
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetTindakanRajal =  await getTindakanRajal();
            updateUIgetDataTindakan(datagetTindakanRajal); 
        }else if (getreg == 'RI'){
            var datagetTindakanRanap =  await getTindakanRanap();
            updateUIgetDataTindakan(datagetTindakanRanap); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataTindakan(datagetTindakan) {
    let responseApi = datagetTindakan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        $("#namatindakan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#namatindakan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].ProductName + '</option';
            $("#namatindakan").append(newRow);
        }
    }
}

function getTindakanRajal() {
    var base_url = window.location.origin;
    var xdi = $('#IDUnit').val();
    var groupjaminan = $('#GroupJaminan').val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTindakanRajal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idunit=' + xdi + '&groupjaminan=' + groupjaminan
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
            $("#namatindakan").select2();
        })
}

function getTindakanRanap() {
    var base_url = window.location.origin;
    var groupjaminan = $('#GroupJaminan').val();
    var IDKelas = $('#IDKelas').val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTindakanRanap';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'groupjaminan=' + groupjaminan + '&IDKelas=' + IDKelas
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
            $("#namatindakan").select2();
        })
}
//---
async function getTarifTindakan(param){
    try{
        var val = $(param).val();
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetTarifTindakanRajal =  await getTarifTindakanRajal(val);
            updateUIgetDataTarifTindakan(datagetTarifTindakanRajal); 
        }else if (getreg == 'RI'){
            var datagetTarifTindakanRanap =  await getTarifTindakanRanap(val);
            updateUIgetDataTarifTindakan(datagetTarifTindakanRanap); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataTarifTindakan(datagetTindakan) {
    let responseApi = datagetTindakan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
       // console.log(responseApi.data);
        $("#tarif_satuan_addvisit").val(convertEntities(responseApi.data.GetTarif));
        $("#qty_addvisit").val('1');
        $("#diskon_addvisit").val(0);

        var total_tarif_addvisit1 = convertEntities(responseApi.data.GetTarif);
        var diskon = parseFloat(0);
        var hasil_diskon = total_tarif_addvisit1*(diskon/100);
        var subtotal = total_tarif_addvisit1-hasil_diskon;
        $('#total_tarif_addvisit').val((subtotal ? subtotal : 0).toFixed(0));
    }
}

function getTarifTindakanRajal(val) {
    var base_url = window.location.origin;
    var IDUnit = $('#IDUnit').val();;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTarifTindakanRajal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + val
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
            $("#namatindakan").select2();
        })
}

function getTarifTindakanRanap(val) {
    var base_url = window.location.origin;
    var IDKelas = $('#IDKelas').val();;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTarifTindakanRanap';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDKelas=' + IDKelas + '&id=' + val
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
            $("#namatindakan").select2();
        })
}
//--------
async function getDokter(){
    try{
        // var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        // if (getreg == 'RJ'){
        //     var datagetDataDokter =  await getDataDokterByJadwal();
        //     updateUIgetDataDokter(datagetDataDokter); 
        // }else if (getreg == 'RI'){
            var datagetDataDokter =  await getDokterAllAktif();
            updateUIgetDataDokter(datagetDataDokter); 
        //}
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataDokter(datagetDataDokter) {
    let responseApi = datagetDataDokter;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#dokterpemeriksa").append(newRow);
        $("#dokterpemeriksa_edit").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].First_Name + '</option';
            $("#dokterpemeriksa").append(newRow);
            $("#dokterpemeriksa_edit").append(newRow);
        }
    }
}


function getDataDokterByJadwal() {
    var base_url = window.location.origin;
    var tglnow = $('#TglMasuk').val();
    const days = getWeekdays(tglnow);
    var xdi = $('#IDUnit').val();
    let url = base_url + '/SIKBREC/public/JadwalAbsensi/getHariJadwalDokterCurrent';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kode_prop=' + xdi + '&days=' + days
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
            $("#dokterpemeriksa").select2();
            $("#dokterpemeriksa_edit").select2();
        })
}

function getWeekdays(params){
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";
    var dx = new Date(params);
    var days = weekday[dx.getDay()];
    return days;
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
            $("#dokterpemeriksa").select2();
        })
    }

function getDataDetailBilling() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_rincianbiaya').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#tbl_rincianbiaya').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataPemeriksaan", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "data": "ID" },
            { "data": "No" },
            { "data": "Tgl" },
            { "data": "NamaProduct" },
            { "data": "TotalTarif" },
            //    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            //          var html = ""
                      
            //            var html  = '</button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
            //               return html 
            //        }
            //    },
           ],
           'columnDefs': [
            {
               'targets': 0,
               'checkboxes': {
                  'selectRow': true
               }
            }
         ],
         'select': {
            'style': 'multi'
         },
       });
       
} 


function ShowDataTarif(ID){
    $("#edittarif_modal").modal('show');
    getDokter();
    getClassID();
    getDataDetailBill(ID);
}

function getDokterName(val){
        $("#namadokter_addvisit").val(val);
}

async function goAddPemeriksaan() {
    try{
        const data = await getgoAddPemeriksaan();
        updateUIgoAddPemeriksaan(data);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getgoAddPemeriksaan() {
    var base_url = window.location.origin;
    var form = $("#form_addvisitdetails, #frmDataPasien").serialize();
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/goAddPemeriksaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form
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
        })
}

function updateUIgoAddPemeriksaan(goBatalDetailBillbyID) {
    let dataresponse = goBatalDetailBillbyID;
    if (dataresponse !== null && dataresponse !== undefined) {
        toast(dataresponse.message,'success');
        $("#addtindakan_modal").modal('hide');
        getDataDetailBilling();
    }
}

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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