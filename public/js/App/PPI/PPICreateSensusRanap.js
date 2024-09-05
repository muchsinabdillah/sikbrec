$(document).ready(function () { 
    asyncShowMain();
    $(".preloader").fadeOut();
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
            // else{
            //     toast(result.message, "")
            // }
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

        $("#SensusDarahKM01").val(convertEntities(dataResponse.data.KM01_D));
        $("#SensusDarahKM02").val(convertEntities(dataResponse.data.KM02_D));
        $("#SensusDarahKM03").val(convertEntities(dataResponse.data.KM03_D));
        $("#SensusDarahKM04").val(convertEntities(dataResponse.data.KM04_D));
        $("#SensusDarahKM05").val(convertEntities(dataResponse.data.KM05_D));
        $("#SensusDarahKM06").val(convertEntities(dataResponse.data.KM06_D));
        $("#SensusDarahKM07").val(convertEntities(dataResponse.data.KM07_D));
        $("#SensusDarahKM08").val(convertEntities(dataResponse.data.KM08_D));
        $("#SensusDarahKM09").val(convertEntities(dataResponse.data.KM09_D));
        $("#SensusDarahKM10").val(convertEntities(dataResponse.data.KM10_D));
        $("#SensusDarahKM11").val(convertEntities(dataResponse.data.KM11_D));
        $("#SensusDarahKM12").val(convertEntities(dataResponse.data.KM12_D));
        $("#SensusDarahKM13").val(convertEntities(dataResponse.data.KM13_D));
        $("#SensusDarahKM14").val(convertEntities(dataResponse.data.KM14_D));
        $("#SensusDarahKM15").val(convertEntities(dataResponse.data.KM15_D));
        
        $("#SensusSwabKM01").val(convertEntities(dataResponse.data.KM01_S));
        $("#SensusSwabKM02").val(convertEntities(dataResponse.data.KM02_S));
        $("#SensusSwabKM03").val(convertEntities(dataResponse.data.KM03_S));
        $("#SensusSwabKM04").val(convertEntities(dataResponse.data.KM04_S));
        $("#SensusSwabKM05").val(convertEntities(dataResponse.data.KM05_S));
        $("#SensusSwabKM06").val(convertEntities(dataResponse.data.KM06_S));
        $("#SensusSwabKM07").val(convertEntities(dataResponse.data.KM07_S));
        $("#SensusSwabKM08").val(convertEntities(dataResponse.data.KM08_S));
        $("#SensusSwabKM09").val(convertEntities(dataResponse.data.KM09_S));
        $("#SensusSwabKM10").val(convertEntities(dataResponse.data.KM10_S));
        $("#SensusSwabKM11").val(convertEntities(dataResponse.data.KM11_S));
        $("#SensusSwabKM12").val(convertEntities(dataResponse.data.KM12_S));
        $("#SensusSwabKM13").val(convertEntities(dataResponse.data.KM13_S));
        $("#SensusSwabKM14").val(convertEntities(dataResponse.data.KM14_S));
        $("#SensusSwabKM15").val(convertEntities(dataResponse.data.KM15_S));

        $("#SensusSputumKM01").val(convertEntities(dataResponse.data.KM01_Spt));
        $("#SensusSputumKM02").val(convertEntities(dataResponse.data.KM02_Spt));
        $("#SensusSputumKM03").val(convertEntities(dataResponse.data.KM03_Spt));
        $("#SensusSputumKM04").val(convertEntities(dataResponse.data.KM04_Spt));
        $("#SensusSputumKM05").val(convertEntities(dataResponse.data.KM05_Spt));
        $("#SensusSputumKM06").val(convertEntities(dataResponse.data.KM06_Spt));
        $("#SensusSputumKM07").val(convertEntities(dataResponse.data.KM07_Spt));
        $("#SensusSputumKM08").val(convertEntities(dataResponse.data.KM08_Spt));
        $("#SensusSputumKM09").val(convertEntities(dataResponse.data.KM09_Spt));
        $("#SensusSputumKM10").val(convertEntities(dataResponse.data.KM10_Spt));
        $("#SensusSputumKM11").val(convertEntities(dataResponse.data.KM11_Spt));
        $("#SensusSputumKM12").val(convertEntities(dataResponse.data.KM12_Spt));
        $("#SensusSputumKM13").val(convertEntities(dataResponse.data.KM13_Spt));
        $("#SensusSputumKM14").val(convertEntities(dataResponse.data.KM14_Spt));
        $("#SensusSputumKM15").val(convertEntities(dataResponse.data.KM15_Spt));

        $("#SensusUrineKM01").val(convertEntities(dataResponse.data.KM01_Ur));
        $("#SensusUrineKM02").val(convertEntities(dataResponse.data.KM02_Ur));
        $("#SensusUrineKM03").val(convertEntities(dataResponse.data.KM03_Ur));
        $("#SensusUrineKM04").val(convertEntities(dataResponse.data.KM04_Ur));
        $("#SensusUrineKM05").val(convertEntities(dataResponse.data.KM05_Ur));
        $("#SensusUrineKM06").val(convertEntities(dataResponse.data.KM06_Ur));
        $("#SensusUrineKM07").val(convertEntities(dataResponse.data.KM07_Ur));
        $("#SensusUrineKM08").val(convertEntities(dataResponse.data.KM08_Ur));
        $("#SensusUrineKM09").val(convertEntities(dataResponse.data.KM09_Ur));
        $("#SensusUrineKM10").val(convertEntities(dataResponse.data.KM10_Ur));
        $("#SensusUrineKM11").val(convertEntities(dataResponse.data.KM11_Ur));
        $("#SensusUrineKM12").val(convertEntities(dataResponse.data.KM12_Ur));
        $("#SensusUrineKM13").val(convertEntities(dataResponse.data.KM13_Ur));
        $("#SensusUrineKM14").val(convertEntities(dataResponse.data.KM14_Ur));
        $("#SensusUrineKM15").val(convertEntities(dataResponse.data.KM15_Ur));
        
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
            // $("#SensusTipeRawat").select2(); 
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

function CalculateALL() {
    var totalgrand = 0;

    var SensusB =  $("#SensusB").val() || 0;
    var SensusBC =  $("#SensusBC").val() || 0;
    var SensusC =  $("#SensusC").val() || 0;
    var SensusK =  $("#SensusK").val() || 0;

    totalgrand +=  parseFloat(SensusB)+ parseFloat(SensusBC) + parseFloat(SensusC) + parseFloat(SensusK)

    $("#SensusOpr").val(totalgrand);

    var totalCek = null;

    var SensusTanggal = $("#SensusTanggal").val()||null;
    var SensusRuangRawat = $("#SensusRuangRawat").val()||null;
    
    totalCek += SensusTanggal + SensusTanggal

    $("#SensusCek").val(totalCek);

    
    var totalKumanDarah = 0;
    
    var SensusDarahKM01 = $("#SensusDarahKM01").val() || 0;
    var SensusDarahKM02 = $("#SensusDarahKM02").val() || 0;
    var SensusDarahKM03 = $("#SensusDarahKM03").val() || 0;
    var SensusDarahKM04 = $("#SensusDarahKM04").val() || 0;
    var SensusDarahKM05 = $("#SensusDarahKM05").val() || 0;
    var SensusDarahKM06 = $("#SensusDarahKM06").val() || 0;
    var SensusDarahKM07 = $("#SensusDarahKM07").val() || 0;
    var SensusDarahKM08 = $("#SensusDarahKM08").val() || 0;
    var SensusDarahKM09 = $("#SensusDarahKM09").val() || 0;
    var SensusDarahKM10 = $("#SensusDarahKM10").val() || 0;
    var SensusDarahKM11 = $("#SensusDarahKM11").val() || 0;
    var SensusDarahKM12 = $("#SensusDarahKM12").val() || 0;
    var SensusDarahKM13 = $("#SensusDarahKM13").val() || 0;
    var SensusDarahKM14 = $("#SensusDarahKM14").val() || 0;
    var SensusDarahKM15 = $("#SensusDarahKM15").val() || 0;

    totalKumanDarah +=  parseFloat(SensusDarahKM01)+ parseFloat(SensusDarahKM02) + parseFloat(SensusDarahKM03) + parseFloat(SensusDarahKM04) + parseFloat(SensusDarahKM05)+ parseFloat(SensusDarahKM06) + parseFloat(SensusDarahKM07) + parseFloat(SensusDarahKM08) + parseFloat(SensusDarahKM09) + parseFloat(SensusDarahKM10) + parseFloat(SensusDarahKM11) + parseFloat(SensusDarahKM12) + parseFloat(SensusDarahKM13) + parseFloat(SensusDarahKM14) + parseFloat(SensusDarahKM15)

    $("#SensusJKD").val(totalKumanDarah);

    var totalKumanSputum = 0;
    
    var SensusSputumKM01 = $("#SensusSputumKM01").val() || 0;
    var SensusSputumKM02 = $("#SensusSputumKM02").val() || 0;
    var SensusSputumKM03 = $("#SensusSputumKM03").val() || 0;
    var SensusSputumKM04 = $("#SensusSputumKM04").val() || 0;
    var SensusSputumKM05 = $("#SensusSputumKM05").val() || 0;
    var SensusSputumKM06 = $("#SensusSputumKM06").val() || 0;
    var SensusSputumKM07 = $("#SensusSputumKM07").val() || 0;
    var SensusSputumKM08 = $("#SensusSputumKM08").val() || 0;
    var SensusSputumKM09 = $("#SensusSputumKM09").val() || 0;
    var SensusSputumKM10 = $("#SensusSputumKM10").val() || 0;
    var SensusSputumKM11 = $("#SensusSputumKM11").val() || 0;
    var SensusSputumKM12 = $("#SensusSputumKM12").val() || 0;
    var SensusSputumKM13 = $("#SensusSputumKM13").val() || 0;
    var SensusSputumKM14 = $("#SensusSputumKM14").val() || 0;
    var SensusSputumKM15 = $("#SensusSputumKM15").val() || 0;

    totalKumanSputum +=  parseFloat(SensusSputumKM01)+ parseFloat(SensusSputumKM02) + parseFloat(SensusSputumKM03) + parseFloat(SensusSputumKM04) + parseFloat(SensusSputumKM05)+ parseFloat(SensusSputumKM06) + parseFloat(SensusSputumKM07) + parseFloat(SensusSputumKM08) + parseFloat(SensusSputumKM09) + parseFloat(SensusSputumKM10) + parseFloat(SensusSputumKM11) + parseFloat(SensusSputumKM12) + parseFloat(SensusSputumKM13) + parseFloat(SensusSputumKM14) + parseFloat(SensusSputumKM15)

    $("#SensusJKSPT").val(totalKumanSputum);

    var totalKumanUrine = 0;
    
    var SensusUrineKM01 = $("#SensusUrineKM01").val() || 0;
    var SensusUrineKM02 = $("#SensusUrineKM02").val() || 0;
    var SensusUrineKM03 = $("#SensusUrineKM03").val() || 0;
    var SensusUrineKM04 = $("#SensusUrineKM04").val() || 0;
    var SensusUrineKM05 = $("#SensusUrineKM05").val() || 0;
    var SensusUrineKM06 = $("#SensusUrineKM06").val() || 0;
    var SensusUrineKM07 = $("#SensusUrineKM07").val() || 0;
    var SensusUrineKM08 = $("#SensusUrineKM08").val() || 0;
    var SensusUrineKM09 = $("#SensusUrineKM09").val() || 0;
    var SensusUrineKM10 = $("#SensusUrineKM10").val() || 0;
    var SensusUrineKM11 = $("#SensusUrineKM11").val() || 0;
    var SensusUrineKM12 = $("#SensusUrineKM12").val() || 0;
    var SensusUrineKM13 = $("#SensusUrineKM13").val() || 0;
    var SensusUrineKM14 = $("#SensusUrineKM14").val() || 0;
    var SensusUrineKM15 = $("#SensusUrineKM15").val() || 0;

    totalKumanUrine +=  parseFloat(SensusUrineKM01)+ parseFloat(SensusUrineKM02) + parseFloat(SensusUrineKM03) + parseFloat(SensusUrineKM04) + parseFloat(SensusUrineKM05)+ parseFloat(SensusUrineKM06) + parseFloat(SensusUrineKM07) + parseFloat(SensusUrineKM08) + parseFloat(SensusUrineKM09) + parseFloat(SensusUrineKM10) + parseFloat(SensusUrineKM11) + parseFloat(SensusUrineKM12) + parseFloat(SensusUrineKM13) + parseFloat(SensusUrineKM14) + parseFloat(SensusUrineKM15)

    $("#SensusJKUR").val(totalKumanUrine);

    var totalKumanSwab = 0;
    
    var SensusSwabKM01 = $("#SensusSwabKM01").val() || 0;
    var SensusSwabKM02 = $("#SensusSwabKM02").val() || 0;
    var SensusSwabKM03 = $("#SensusSwabKM03").val() || 0;
    var SensusSwabKM04 = $("#SensusSwabKM04").val() || 0;
    var SensusSwabKM05 = $("#SensusSwabKM05").val() || 0;
    var SensusSwabKM06 = $("#SensusSwabKM06").val() || 0;
    var SensusSwabKM07 = $("#SensusSwabKM07").val() || 0;
    var SensusSwabKM08 = $("#SensusSwabKM08").val() || 0;
    var SensusSwabKM09 = $("#SensusSwabKM09").val() || 0;
    var SensusSwabKM10 = $("#SensusSwabKM10").val() || 0;
    var SensusSwabKM11 = $("#SensusSwabKM11").val() || 0;
    var SensusSwabKM12 = $("#SensusSwabKM12").val() || 0;
    var SensusSwabKM13 = $("#SensusSwabKM13").val() || 0;
    var SensusSwabKM14 = $("#SensusSwabKM14").val() || 0;
    var SensusSwabKM15 = $("#SensusSwabKM15").val() || 0;

    totalKumanSwab +=  parseFloat(SensusSwabKM01)+ parseFloat(SensusSwabKM02) + parseFloat(SensusSwabKM03) + parseFloat(SensusSwabKM04) + parseFloat(SensusSwabKM05)+ parseFloat(SensusSwabKM06) + parseFloat(SensusSwabKM07) + parseFloat(SensusSwabKM08) + parseFloat(SensusSwabKM09) + parseFloat(SensusSwabKM10) + parseFloat(SensusSwabKM11) + parseFloat(SensusSwabKM12) + parseFloat(SensusSwabKM13) + parseFloat(SensusSwabKM14) + parseFloat(SensusSwabKM15)

    $("#SensusJKS").val(totalKumanSwab);
}