$(document).ready(function () {
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveJasaMedisDetil();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
    // format number to price
    var NilaiProsenJasa = document.getElementById("NilaiProsenJasa");
    NilaiProsenJasa.addEventListener("keyup", function (e) {
        NilaiProsenJasa.value = formatRupiah(this.value);
    });
    var NilaiFixJasa = document.getElementById("NilaiFixJasa");
    NilaiFixJasa.addEventListener("keyup", function (e) {
        NilaiFixJasa.value = formatRupiah(this.value);
    });

    asyncShowMain();
});
async function saveJasaMedisDetil(){
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/JasaDetil/addJasaDetil';
    var IdAuto = $("#IdAuto").val(); var KodeTipeJasa = $("#KodeTipeJasa").val();
    var KodeJasa = $("#KodeJasa").val(); var NilaiProsenJasa = price_to_number($("#NilaiProsenJasa").val());
    var NilaiFixJasa = price_to_number($("#NilaiFixJasa").val()); 
    var KodeRekeningHpp = document.getElementById("KodeRekeningHpp").value;
    var KodeRekeningDiskon = document.getElementById("KodeRekeningDiskon").value; 
    var KodeRekeningHutang = document.getElementById("KodeRekeningHutang").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto + "&KodeTipeJasa=" + KodeTipeJasa
            + "&KodeJasa=" + KodeJasa + "&NilaiProsenJasa=" + NilaiProsenJasa + "&NilaiFixJasa=" + NilaiFixJasa
            + "&KodeRekeningHpp=" + KodeRekeningHpp + "&KodeRekeningDiskon=" + KodeRekeningDiskon 
            + "&KodeRekeningHutang=" + KodeRekeningHutang
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
async function asyncShowMain(){
    try{
        const dataGetJasaHeader = await GetJasaHeader();
        const dataGetRekeningDiskon = await getRekeningDiskon(); 
        const dataGetRekeningHpp = await getRekeningHpp();
        const dataGetRekeningHutang = await GetRekeningHutang();
        const dataGetDetilJasaDetil = await GetDetilJasaDetil();
        updateUIJasaHeader(dataGetJasaHeader);
        updateUIRekeningDiskon(dataGetRekeningDiskon); 
        updateUIRekeningHpp(dataGetRekeningHpp);
        updateUIRekeningHutang(dataGetRekeningHutang);
        updateUIDetilJasaDetil(dataGetDetilJasaDetil);
        console.log(dataGetDetilJasaDetil);
    }catch(err){
        toast(err, "error")
    }
} 
function updateUIDetilJasaDetil(dataDetilPdp) {
    let data = dataDetilPdp;
    $("#IdAuto").val(convertEntities(data.data.ID));
    $('#KodePdp').val(data.data.KD_PDP).trigger('change');
    $("#KodeTipeJasa").val(convertEntities(data.data.KD_TIPE_JASA));
    $('#KodeJasa').val(data.data.KD_JASA).trigger('change');
    $("#NilaiFixJasa").val(convertEntities(number_to_price(data.data.NILAI_FIX)));
    $("#NilaiProsenJasa").val(convertEntities(number_to_price(data.data.NILAI_PROSEN)));
    $('#KodeRekeningHpp').val(data.data.KD_POSTING).trigger('change');
    $('#KodeRekeningDiskon').val(data.data.KD_POSTING_DISC).trigger('change');
    $('#KodeRekeningHutang').val(data.data.KD_HUTANG).trigger('change');
    //document.getElementById("KodeJasa").readOnly = true;
}
function GetDetilJasaDetil() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/JasaDetil/getJasaDetilById/';
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
function updateUIRekeningHutang(dataGetRekeningHutang) {
    let data = dataGetRekeningHutang;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekeningHutang").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekeningHutang").append(newRow);
        }

    }
}
function GetRekeningHutang() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningHutang';
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
            $("#KodeRekeningHutang").select2();
        })
}
function updateUIRekeningHpp(dataGetRekeningHpp) {
    let data = dataGetRekeningHpp;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekeningHpp").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekeningHpp").append(newRow);
        }

    } 
}
function getRekeningHpp() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningHpp';
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
            $("#KodeRekeningHpp").select2();
        })
}
function updateUIRekeningDiskon(dataGetRekeningPendapatan) {
    let data = dataGetRekeningPendapatan;
    
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekeningDiskon").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekeningDiskon").append(newRow);
        }

    }
}
function getRekeningDiskon() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningAllAktif';
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
            $("#KodeRekeningDiskon").select2();
        })
}
function updateUIJasaHeader(dataGetJasaHeader) {
    let data = dataGetJasaHeader;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeJasa").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KD_JASA + '">' + data[i].NM_JASA + '</option';
            $("#KodeJasa").append(newRow);
        }
    }
}
function GetJasaHeader() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Jasa/getAllJasa';
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
            $("#KodeJasa").select2(); 
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/JasaDetil";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}