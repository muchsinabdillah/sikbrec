$(document).ready(function () { 
    asyncShowMain();
    // convertNumberToRp();
    // buton save ditekan
    
    const saveButton = document.querySelector('#btnsubmit');
    // console.log(saveButton);
    saveButton.addEventListener('click', async function () {
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
});
async function saveMasterKarcis() {
    $(".preloader").fadeIn();
    $('#btnsubmit').html('Please Wait...');
    $('#btnsubmit').addClass('btn-danger');
    document.getElementById("btnsubmit").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterCOB/addCOB';

    // data form 
    var IdAuto = document.getElementById("IdAuto").value;
    var namaCOB = document.getElementById("namaCOB").value;
    var statusCOB = document.getElementById("statusCOB").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   "IdAuto=" + IdAuto + "&namaCOB=" + namaCOB + "&statusCOB=" + statusCOB
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
            $('#btnsubmit').removeClass('btn-danger');
            $('#btnsubmit').html('Submit');
            document.getElementById("btnsubmit").disabled = false;
        })
}
async function asyncShowMain() {
    try {
        await getHakAksesByForm(18);
        const datagetDataCOB = await getDataCOB();
        console.log(datagetDataCOB)
        updateUIgetDataCOB(datagetDataCOB);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgetDataCOB(datagetDataCOB) {
    let dataResponse = datagetDataCOB;
    // if (dataResponse.data.ID === null) {
    //     $("#NilaiKarcis").val('0');
    // } else {
        $("#IdAuto").val(convertEntities(dataResponse.data.ID));
        $("#namaCOB").val(convertEntities(dataResponse.data.NamaCOB));
        // $("#NilaiKarcis").val(convertEntities(number_to_price(dataResponse.data.Nilai_Karcis)));
        $("#statusCOB").val(convertEntities(dataResponse.data.StatusCOB));
        // $("#GruptarifKarcis").val(convertEntities(dataResponse.data.grup_tarif)).trigger('change'); 
    // }
}
function getDataCOB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterCOB/getCOBId/';
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
            // $("#GruptarifKarcis").select2();
            $("#StatusCOB").select2(); 
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
    window.location = base_url + "/SIKBREC/public/MasterCOB";
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
// function convertNumberToRp() {
//     var NilaiKarcis = document.getElementById("NilaiKarcis");
//     NilaiKarcis.addEventListener("keyup", function (e) {
//         NilaiKarcis.value = formatRupiah(this.value);
//     }); 
// }