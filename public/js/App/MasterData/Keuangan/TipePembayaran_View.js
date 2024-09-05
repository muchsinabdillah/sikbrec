$(document).ready(function () {
    asyncShowMain();
    // buton save ditekan
});

async function asyncShowMain(){
    try{
        const data1 = await getKodeRekeningCOA();
        updateUIgetKodeRekeningCOA(data1);

        const data2 = await getTipePembayaranByID();
        updateUIgetTipePembayaranByID(data2);
        $(".preloader").fadeOut();
    }catch(err){
        toast(err, "error")
    }
}

function getKodeRekeningCOA(){
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/TipePembayaran/getKodeRekeningCOA';
    return fetch(url, {
        method: 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        data: 'foo=bar&lorem=ipsum'
    })
    .then(response => { 
        if(!response.ok){
            throw new Error (response.statusText)
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
}

function updateUIgetKodeRekeningCOA(repoList) {
    var data = repoList;
    if (data.message == "success") {
        console.log("render repo list reggroup2", data);
        if (data.data !== null && data.data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#accountpayment").append(newRow);
            for (i = 0; i < data.data.length; i++) {
                var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_KD_REKENING + '</option';
                $("#accountpayment").append(newRow);
            }
        }
    } else {
        toast(data.data.errorInfo[2], "error");
    }
}

function getTipePembayaranByID() {
    var base_url = window.location.origin;
    var idtipe = $("#idpaymenttype").val();
    
    let url = base_url + '/SIKBREC/public/TipePembayaran/getTipePembayaranById';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idtipe=' + idtipe
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
async function updateUIgetTipePembayaranByID(data2) {
    let dataresponse = data2;
    // console.log('tai');
        $("#paymenttypejenis").val(convertEntities(dataresponse.data.PaymentType));
        $("#accountpayment").val(convertEntities(dataresponse.data.Account));
        $("#statuspayment").val(convertEntities(dataresponse.data.Status));
}

async function MySave() {
    try{
        var datasetSave =  await setSave();
        updateUIdatasetSave(datasetSave);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatasetSave(datasetSave) {
    let responseApi = datasetSave;
    // console.log(responseApi);
    swal({
        title: "Simpan Berhasil!",
        text: "Terimakasih",
        icon: "success",
    }).then((willDelete) => {
        if (willDelete) {
            MyBack();
        } 
    });
}

function setSave() {
    var base_url = window.location.origin;

    var idtipe = $("#idpaymenttype").val();
    var jenistipe = $("#paymenttypejenis").val();
    var accounttipe = $("#accountpayment").val();
    var statustipe = $("#statuspayment").val();
    if(jenistipe == ""){
        toast('Jenis Tipe Pembayaran Masih Kosong','warning');
        $("#paymenttypejenis").focus();
        return false;
    }
    if(accounttipe == ""){
        toast('Account Tipe Pembayaran Masih Kosong','warning');
        $("#accountpayment").focus();
        return false;
    }
    if(statustipe == ""){
        toast('Status Tipe Pembayaran Masih Kosong','warning');
        $("#statuspayment").focus();
        return false;
    }

    let url = base_url + '/SIKBREC/public/TipePembayaran/saveTipePembayaran';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 
        'idtipe=' + idtipe
        + '&jenistipe=' + jenistipe
        + '&accounttipe=' + accounttipe
        + '&statustipe=' + statustipe
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            // $("#namatindakan").select2();
        })
}

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/TipePembayaran";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

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