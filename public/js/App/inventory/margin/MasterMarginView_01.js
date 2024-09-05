$(document).ready(function () {
    asyncShowMain();
    convertNumberToRp();
    // buton save ditekan
    const saveButton2 = document.querySelector('#btnSave');
    saveButton2.addEventListener('click', async function () {
        try {
            const result = await saveMasterKarcis();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
    // Get the input field
    var HargaJualRJProsen = document.getElementById("HargaJualRJProsen");
    // Execute a function when the user presses a key on the keyboard
    HargaJualRJProsen.addEventListener("keypress", function (event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            var HargaJualRJProsen = $("#HargaJualRJProsen").val();
            var HargaJualRJProsen2 = price_to_number(HargaJualRJProsen)+1;
            var HNA_PPN = $("#HNA_PPN").val();
            var HargaAfterPPNx = HargaJualRJProsen2 * price_to_number(HNA_PPN);
            $("#HargaJualRJ").val(number_to_price(HargaAfterPPNx));
        }
    });

    // Get the input field
    var HargaJualRIProsen = document.getElementById("HargaJualRIProsen");
    // Execute a function when the user presses a key on the keyboard
    HargaJualRIProsen.addEventListener("keypress", function (event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            var HargaJualRIProsen = $("#HargaJualRIProsen").val();
            var HargaJualRIProsen2 = price_to_number(HargaJualRIProsen) + 1;
            var HNA_PPN = $("#HNA_PPN").val();
            var HargaAfterPPNx = HargaJualRIProsen2 * price_to_number(HNA_PPN);
            $("#HargaJualRI").val(number_to_price(HargaAfterPPNx));
        }
    });
    // Get the input field
    var HargaJualBebasProsen = document.getElementById("HargaJualBebasProsen");
    // Execute a function when the user presses a key on the keyboard
    HargaJualBebasProsen.addEventListener("keypress", function (event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            var HargaJualBebasProsen = $("#HargaJualBebasProsen").val();
            var HargaJualBebasProsen2 = price_to_number(HargaJualBebasProsen) + 1;
            var HNA_PPN = $("#HNA_PPN").val();
            var HargaAfterPPNx = HargaJualBebasProsen2 * price_to_number(HNA_PPN);
            $("#HargaJualBebas").val(number_to_price(HargaAfterPPNx));
        }
    });
});
async function saveMasterKarcis() {
    $(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterMarginObat/updatemargin';

    // data form 
    var IdAuto = document.getElementById("IdAuto").value; 
    var HargaJualRJProsen = price_to_number(document.getElementById("HargaJualRJProsen").value);
    var HargaJualRJ = price_to_number(document.getElementById("HargaJualRJ").value);
    var HargaJualRIProsen = price_to_number(document.getElementById("HargaJualRIProsen").value);
    var HargaJualRI = price_to_number(document.getElementById("HargaJualRI").value);
    var HargaJualBebasProsen = price_to_number(document.getElementById("HargaJualBebasProsen").value);
    var HargaJualBebas = price_to_number(document.getElementById("HargaJualBebas").value);

    var HNA = price_to_number(document.getElementById("HNA").value);
    var PPN = price_to_number(document.getElementById("PPN").value);
    var HNA_PPN = price_to_number(document.getElementById("HNA_PPN").value);
    var Discount = price_to_number(document.getElementById("Discount").value);
    var HargaNonPPN = price_to_number(document.getElementById("HargaNonPPN").value); 


    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto + "&HargaJualRJProsen=" + HargaJualRJProsen
            + "&HargaJualRJ=" + HargaJualRJ 
            + "&HargaJualRIProsen=" + HargaJualRIProsen
            + "&HargaJualRI=" + HargaJualRI
            + "&HargaJualBebasProsen=" + HargaJualBebasProsen
            + "&HargaJualBebas=" + HargaJualBebas
            + "&HNA=" + HNA
            + "&PPN=" + PPN
            + "&HNA_PPN=" + HNA_PPN
            + "&Discount=" + Discount
            + "&HargaNonPPN=" + HargaNonPPN
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
async function asyncShowMain() {
    try {
        await getHakAksesByForm(18);
        const datagetDataMarginObatbyID = await getDataMarginObatbyID();
       
        updateUIdatagetDataMarginObatbyID(datagetDataMarginObatbyID);
    } catch (err) {
        console.log(err)
        toast(err, "error")
    }
}
function updateUIdatagetDataMarginObatbyID(datagetDataMarginObatbyID) {
    let dataResponse = datagetDataMarginObatbyID;
    $("#Nama").val(convertEntities(dataResponse.data.NamaBarang));
    $("#Satuan").val(convertEntities(dataResponse.data.Satuan));
    $("#HNA").val(convertEntities(number_to_price(dataResponse.data.HNA)));
    if (dataResponse.data.PPNIn == null || dataResponse.data.PPNIn == ".00"){
        var ppns = "0,11";
    }else{
        var ppns =  dataResponse.data.PPNIn;
    }
    $("#PPN").val(convertEntities(ppns));
    $("#HNA_PPN").val(convertEntities(number_to_price(dataResponse.data.HargaAfterPPN)));
    $("#Discount").val(convertEntities(number_to_price(dataResponse.data.Disc)));
    $("#HargaNonPPN").val(convertEntities(number_to_price(dataResponse.data.HargaNonPPN)));

    $("#HargaJualRJProsen").val(convertEntities(number_to_price(dataResponse.data.MarginRajal)));
    $("#HargaJualRJ").val(convertEntities(number_to_price(dataResponse.data.HargaRajal)));
    $("#HargaJualRIProsen").val(convertEntities(number_to_price(dataResponse.data.MarginRI)));
    $("#HargaJualRI").val(convertEntities(number_to_price(dataResponse.data.hargaRanap)));
    $("#HargaJualBebasProsen").val(convertEntities(number_to_price(dataResponse.data.MarginBebas)));
    $("#HargaJualBebas").val(convertEntities(number_to_price(dataResponse.data.HargaBebas)));

     
}
function getDataMarginObatbyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterMarginObat/getMarginObatbyId/';
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
    window.location = base_url + "/SIKBREC/public/MasterMarginObat";
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
    var HargaJualRJProsen = document.getElementById("HargaJualRJProsen"); 
    HargaJualRJProsen.addEventListener("keyup", function (e) { 
        HargaJualRJProsen.value = formatRupiah(this.value); 
    });

    var HargaJualRIProsen = document.getElementById("HargaJualRIProsen");
    HargaJualRIProsen.addEventListener("keyup", function (e) {

        HargaJualRIProsen.value = formatRupiah(this.value);
    });

    var HargaJualBebasProsen = document.getElementById("HargaJualBebasProsen");
    HargaJualBebasProsen.addEventListener("keyup", function (e) {
        HargaJualBebasProsen.value = formatRupiah(this.value);
    });

    var HNA = document.getElementById("HNA");
    HNA.addEventListener("keyup", function (e) {
        HNA.value = formatRupiah(this.value);
    });

    var Discount = document.getElementById("Discount");
    Discount.addEventListener("keyup", function (e) {
        Discount.value = formatRupiah(this.value);
    });
}
function calcHnaPPh() {
    var HNA = price_to_number($("#HNA").val());
    var hnappn = HNA*1.11;
    $("#HNA_PPN").val(number_to_price(hnappn));
    console.log(hnappn);
}
function calcHnaNonPPN() {
    var Discount = price_to_number($("#Discount").val());
    var HNA = price_to_number($("#HNA").val());
    var hnappn = (parseFloat(HNA) * parseFloat(Discount)) / 100;
    var hnappn2 = parseFloat(HNA) - parseFloat(hnappn);
    $("#HargaNonPPN").val(number_to_price(hnappn2)); 
}