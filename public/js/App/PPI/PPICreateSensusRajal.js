$(document).ready(function () { 
    asyncShowMain();
    // convertNumberToRp();
    // buton save ditekan

    const saveButton = document.querySelector('#btnsubmit');
    // console.log(saveButton);

    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveDataSensusPPI();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function saveDataSensusPPI() {
    $(".preloader").fadeIn();
    $('#btnsubmit').html('Please Wait...');
    $('#btnsubmit').addClass('btn-danger');
    document.getElementById("btnsubmit").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPPI/addSensusPPI';

    var form_data = $("#form_PPI").serialize();
    // data form 
    // var IdAuto = document.getElementById("IdAuto").value;
    // var SensusTipeRawat = document.getElementById("SensusTipeRawat").value;
    // var SensusRuangRawat = document.getElementById("SensusRuangRawat").value;
    // var SensusTanggal = document.getElementById("SensusTanggal").value;
    // var Sensusjumlah = document.getElementById("Sensusjumlah").value;
    // var SensusOpr = document.getElementById("SensusOpr").value;

    // var SensusB = document.getElementById("SensusB").value;
    // var SensusIDOB = document.getElementById("SensusIDOB").value;
    // var SensusBC = document.getElementById("SensusBC").value;
    // var SensusIDOBC = document.getElementById("SensusIDOBC").value;
    // var SensusC = document.getElementById("SensusC").value;
    // var SensusIDOC = document.getElementById("SensusIDOC").value;
    // var SensusK = document.getElementById("SensusK").value;
    // var SensusIDOK = document.getElementById("SensusIDOK").value;
    // var SensusWSD = document.getElementById("SensusWSD").value;
    // var SensusIDOWSD = document.getElementById("SensusIDOWSD").value;

    // var SensusCVL = document.getElementById("SensusCVL").value;
    // var SensusIAD = document.getElementById("SensusIAD").value;
    // var SensusIVL = document.getElementById("SensusIVL").value;
    // var SensusUC = document.getElementById("SensusUC").value;
    // var SensusISK = document.getElementById("SensusISK").value;

    // var SensusETTVENT = document.getElementById("SensusETTVENT").value;
    // var SensusVAP = document.getElementById("SensusVAP").value;
    // var SensusTB = document.getElementById("SensusTB").value;
    // var SensusHAP = document.getElementById("SensusHAP").value;

    // var SensusDEKG1 = document.getElementById("SensusDEKG1").value;
    // var SensusDEKG2 = document.getElementById("SensusDEKG2").value;
    // var SensusDEKG3 = document.getElementById("SensusDEKG3").value;
    // var SensusDEKG4 = document.getElementById("SensusDEKG4").value;

    // var SensusPLEBG1 = document.getElementById("SensusPLEBG1").value;
    // var SensusPLEBG2 = document.getElementById("SensusPLEBG2").value;
    // var SensusPLEBG3 = document.getElementById("SensusPLEBG3").value;
    // var SensusPLEBG4 = document.getElementById("SensusPLEBG4").value;
    // var SensusPLEBG5 = document.getElementById("SensusPLEBG5").value;

    // var SensusJA1 = document.getElementById("SensusJA1").value;
    // var SensusJA2 = document.getElementById("SensusJA2").value;
    // var SensusJA3 = document.getElementById("SensusJA3").value;

    // var SensusJKO = document.getElementById("SensusJKO").value;
    // var SensusJKS = document.getElementById("SensusJKS").value;
    // var SensusJKSPT = document.getElementById("SensusJKSPT").value;
    // var SensusJKUR = document.getElementById("SensusJKUR").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_data
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
        // await getHakAksesByForm(18);
        if($('#IdAuto').val()!=''){
        const datagetDataSensusPPI = await getDataSensusPPI();
        updateUIgetDataSensusPPI(datagetDataSensusPPI);
        }
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgetDataSensusPPI(datagetDataSensusPPI) {
    let dataResponse = datagetDataSensusPPI;
    // if (dataResponse.data.ID === null) {
    //     $("#NilaiKarcis").val('0');
    // } else {
        $("#IdAuto").val(convertEntities(dataResponse.data.ID));
        $("#SensusTipeRawat").val(convertEntities(dataResponse.data.Tipe_Rawat));
        $("#SensusRuangRawat").val(convertEntities(dataResponse.data.RuangRawat));
        $("#SensusTanggal").val(convertEntities(dataResponse.data.Tanggal));
        $("#Sensusjumlah").val(convertEntities(dataResponse.data.Jumlah));
        $("#SensusOpr").val(convertEntities(dataResponse.data.Opr));

        $("#SensusB").val(convertEntities(dataResponse.data.OP_B));
        $("#SensusIDOB").val(convertEntities(dataResponse.data.OP_IDOB));
        $("#SensusBC").val(convertEntities(dataResponse.data.OP_BC));
        $("#SensusIDOBC").val(convertEntities(dataResponse.data.OP_IDOBC));
        $("#SensusC").val(convertEntities(dataResponse.data.OP_C));
        $("#SensusIDOC").val(convertEntities(dataResponse.data.OP_IDOC));
        $("#SensusK").val(convertEntities(dataResponse.data.OP_K));
        $("#SensusIDOK").val(convertEntities(dataResponse.data.OP_IDOK));
        $("#SensusWSD").val(convertEntities(dataResponse.data.OP_WSD));
        $("#SensusIDOWSD").val(convertEntities(dataResponse.data.OP_IDOWSD));

        $("#SensusCVL").val(convertEntities(dataResponse.data.Infus_CVL));
        $("#SensusIAD").val(convertEntities(dataResponse.data.Infus_IAD));
        $("#SensusIVL").val(convertEntities(dataResponse.data.Infus_IVL));
        $("#SensusUC").val(convertEntities(dataResponse.data.Infus_UC));
        $("#SensusISK").val(convertEntities(dataResponse.data.Infus_ISK));

        $("#SensusETTVENT").val(convertEntities(dataResponse.data.ETT_Vent));
        $("#SensusVAP").val(convertEntities(dataResponse.data.VAP));
        $("#SensusTB").val(convertEntities(dataResponse.data.TB));
        $("#SensusHAP").val(convertEntities(dataResponse.data.HAP));

        $("#SensusDEKG1").val(convertEntities(dataResponse.data.DEK_G1));
        $("#SensusDEKG2").val(convertEntities(dataResponse.data.DEK_G2));
        $("#SensusDEKG3").val(convertEntities(dataResponse.data.DEK_G3));
        $("#SensusDEKG4").val(convertEntities(dataResponse.data.DEK_G4));

        $("#SensusPLEBG1").val(convertEntities(dataResponse.data.PLEB_G1));
        $("#SensusPLEBG2").val(convertEntities(dataResponse.data.PLEB_G2));
        $("#SensusPLEBG3").val(convertEntities(dataResponse.data.PLEB_G3));
        $("#SensusPLEBG4").val(convertEntities(dataResponse.data.PLEB_G4));
        $("#SensusPLEBG5").val(convertEntities(dataResponse.data.PLEB_G5));

        $("#SensusJA1").val(convertEntities(dataResponse.data.JumlahAntibiotik_1));
        $("#SensusJA2").val(convertEntities(dataResponse.data.JumlahAntibiotik_2));
        $("#SensusJA3").val(convertEntities(dataResponse.data.JumlahAntibiotik_3));

        $("#SensusJKD").val(convertEntities(dataResponse.data.JumlahKuman_D));
        $("#SensusJKS").val(convertEntities(dataResponse.data.JumlahKuman_S));
        $("#SensusJKSPT").val(convertEntities(dataResponse.data.JumlahKuman_SPT));
        $("#SensusJKUR").val(convertEntities(dataResponse.data.JumlahKuman_Ur));
    // }
}
function getDataSensusPPI() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPPI/getSensusPPIId/';
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
    window.location = base_url + "/SIKBREC/public/aPPI";
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