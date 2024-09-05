$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut();
    // format number to price
    convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterRefferal();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function saveMasterRefferal() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataReferal/addReferal';

    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var ReferalFee = price_to_number(document.getElementById("ReferalFee").value);
    var DiskonPerItem = price_to_number(document.getElementById("DiskonPerItem").value);
    var ReferalFeeAsuransi = price_to_number(document.getElementById("ReferalFeeAsuransi").value);
    var GrupReferal = document.getElementById("GrupReferal").value;
    var NamaReferal = document.getElementById("NamaReferal").value;
    var PICName = document.getElementById("PICName").value;
    var TlpPIC = document.getElementById("TlpPIC").value;
    var NoRekening = document.getElementById("NoRekening").value;
    var NamaBank = document.getElementById("NamaBank").value;
    var PemegangRekening = document.getElementById("PemegangRekening").value; 
    var Status = document.getElementById("Status").value;
    var AlamatReferal =  document.getElementById("AlamatReferal").value;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto + "&ReferalFee=" + ReferalFee
            + "&DiskonPerItem=" + DiskonPerItem + "&ReferalFeeAsuransi=" + ReferalFeeAsuransi
            + "&GrupReferal=" + GrupReferal
            + "&NamaReferal=" + NamaReferal + "&PICName=" + PICName
            + "&TlpPIC=" + TlpPIC + "&NoRekening=" + NoRekening
            + "&NamaBank=" + NamaBank + "&PemegangRekening=" + PemegangRekening 
            + "&Status=" + Status + "&AlamatReferal=" + AlamatReferal
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        })
}
async function asyncShowMain() {
    try {
        await getHakAksesByForm(16);
        const datagetNamaCaraMasuk = await getNamaCaraMasuk();
        const dataGetDataRefferal = await getDataRefferal();
        updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk);
        updateUIgetDataRefferal(dataGetDataRefferal); 
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk) {
    let responseApi = datagetNamaCaraMasuk; 
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupReferal").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].id + '">' + responseApi.data[i].NamaCaraMasuk + '</option';
            $("#GrupReferal").append(newRow);
        }
    }
}
function getNamaCaraMasuk() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataReferal/getNamaCaraMasuk';
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
            $("#GrupReferal").select2();
            $("#NamaBank").select2();
            $("#Status").select2();
        })
}
function updateUIgetDataRefferal(dataGetDataRefferal) {
    let dataResponse = dataGetDataRefferal;
    if (dataResponse.data.ID === null) {
        $("#ReferalFee").val('0');
        $("#ReferalFeeAsuransi").val('0');
        $("#DiskonPerItem").val('0'); 
    } else {
        $("#IdAuto").val(convertEntities(dataResponse.data.id));
        $("#GrupReferal").val(convertEntities(dataResponse.data.idCaraMasuk)).trigger('change');
        $("#NamaReferal").val(convertEntities(dataResponse.data.NamaCaraMasukRef));
        $("#AlamatReferal").val(convertEntities(dataResponse.data.Alamat));
        $("#PICName").val(convertEntities(dataResponse.data.PICName));
        $("#TlpPIC").val(convertEntities(dataResponse.data.TlpPIC));
        $("#NoRekening").val(convertEntities(dataResponse.data.Norek));
        $("#NamaBank").val(convertEntities(dataResponse.data.NamaBank)).trigger('change');
        $("#PemegangRekening").val(convertEntities(dataResponse.data.PemegangRekening));
        $("#ReferalFeeAsuransi").val(convertEntities(number_to_price(dataResponse.data.RefferalFee_Asuransi)));
        $("#ReferalFee").val(convertEntities(number_to_price(dataResponse.data.RefferalFee)));
        $("#DiskonPerItem").val(convertEntities(number_to_price(dataResponse.data.Diskon_Per_Items)));
        $("#Status").val(convertEntities(dataResponse.data.status)).trigger('change'); 
    }
}
function getDataRefferal() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataReferal/getReferalId/';
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
            $(".preloader").fadeOut();
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataReferal/";
}
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var ReferalFeeAsuransi = document.getElementById("ReferalFeeAsuransi");
    ReferalFeeAsuransi.addEventListener("keyup", function (e) {
        ReferalFeeAsuransi.value = formatRupiah(this.value);
    });
    var ReferalFee = document.getElementById("ReferalFee");
    ReferalFee.addEventListener("keyup", function (e) {
        ReferalFee.value = formatRupiah(this.value);
    });
    var DiskonPerItem = document.getElementById("DiskonPerItem");
    DiskonPerItem.addEventListener("keyup", function (e) {
        DiskonPerItem.value = formatRupiah(this.value);
    }); 
}