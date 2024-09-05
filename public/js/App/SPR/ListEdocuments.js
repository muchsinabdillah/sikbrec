$(document).ready(function () {
    //showDataPasienRajalAktif();
    getDataHistoryDoc_GC();
    getDataHistoryDoc_AkadIjaroh();
    getDataHistoryDoc_HakKewajiban();
    getDataHistoryDoc_TataTertib();
    getDataHistoryDoc_BiayaNonOP();
    getDataHistoryDoc_BiayaOP();
    getDataHistoryDoc_PersetujuanBiaya();
    getDataHistoryDoc_PersetujuanSelisih();

    $(".preloader").fadeOut();
});

function getDataHistoryDoc_GC() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_gc').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_gc').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryGeneralConsent", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoRMPasien' },
            { "data": 'NamaPasien' },
            { "data": 'NamaPenanggungJawab' },
            { "data": 'NoKtp' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","GC") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_AkadIjaroh() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_akadijaroh').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_akadijaroh').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryAkadIjaroh", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoRM' },
            { "data": 'NamaPasien' },
            { "data": 'NamaPenanggungJawab' },
            { "data": 'NoKtp' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","AI") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_HakKewajiban() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_hakdankewajiban').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_hakdankewajiban').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryHakdanKewajiban", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","HK") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_TataTertib() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_tatatertib').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_tatatertib').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryTataTertib", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","TT") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_BiayaNonOP() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_biayanonop').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_biayanonop').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryBiayaNonOP", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","BNOP") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_BiayaOP() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_biayaop').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_biayaop').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryBiayaOP", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","BOP") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_PersetujuanBiaya() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_persetujuanbiaya').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_persetujuanbiaya').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryPersetujuanBiaya", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","IPBT") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function getDataHistoryDoc_PersetujuanSelisih() { 
    var nomr = $("#xnoMedrec").val();
    var base_url = window.location.origin;
    $('#edoc_persetujuanselisih').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#edoc_persetujuanselisih').DataTable({
        "processing":true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/signatureDigital/getDataHistoryPersetujuanSelisih", // URL file untuk proses select datanya
            "type": "POST",
           data: function ( d ) {
           d.nomr = nomr;
           },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": 'ID' },
            { "data": 'TglCreate_sign' },
            { "data": 'NoRegistrasi' },
            { "data": 'NoEpisode' },
            { "data": 'NoMR' },
            { "data": 'NamaPasien' },
            { "data": 'NamaWaliPasien' },
            { "data": 'NIK' },
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=ShowHistoryDocuments("${row.AwsUrlDocuments}","PSB") ><span class="visible-content" > View</span></button>`;
                    return html
                }
            },
        ],
    });
} 

function ShowHistoryDocuments(aws,jenisdoc) {
    if (jenisdoc == 'GC'){
        $("#subjudul").text('GENERAL CONSENT');
    }else if(jenisdoc == 'AI'){
        $("#subjudul").text('AKAD IJAROH');
    }else if(jenisdoc == 'HK'){
        $("#subjudul").text('HAK DAN KEWAJIBAN');
    }else if(jenisdoc == 'TT'){
        $("#subjudul").text('TATA TERTIB');
    }else if(jenisdoc == 'BNOP'){
        $("#subjudul").text('PERKIRAAN BIAYA NON OPERASI');
    }else if(jenisdoc == 'BOP'){
        $("#subjudul").text('PERKIRAAN BIAYA OPERASI');
    }else if(jenisdoc == 'IPBT'){
        $("#subjudul").text('INFORMASI PERSETUJAUN BIAYA TINDAKAN');
    }else if(jenisdoc == 'PSB'){
        $("#subjudul").text('PERSETUJUAN SELISIH BIAYA');
    }
    $("#awsurl").attr('src', aws+'#toolbar=0')
    $('#modalHistory').modal('show'); 
}

function gocreate(jenisdoc) {
    var noreg = $("#Noregis").val();
    if (jenisdoc == 'GC'){
        GeneralConsen(noreg);
    }else if(jenisdoc == 'AI'){
        AkadIjaroh(noreg);
    }else if(jenisdoc == 'HK'){
        HakdanKewajiban(noreg);
    }else if(jenisdoc == 'TT'){
        TataTertib(noreg);
    }else if(jenisdoc == 'BNOP'){
        PerkiraanBiayaNonOP(noreg);
    }else if(jenisdoc == 'BOP'){
        PerkiraanbiayaOP(noreg);
    }else if(jenisdoc == 'IPBT'){
        PersetujuanBiaya(noreg);
    }else if(jenisdoc == 'PSB'){
        PersutujuanSelisih(noreg);
    }
}


function AkadIjaroh(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/Akadijaroh/" + str;

    var win = window.open(url);
    win.focus()
}

function GeneralConsen(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/GeneralConsern/" + str;

    var win = window.open(url);
    win.focus()
}

function HakdanKewajiban(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/HakdanKewajiban/" + str;

    var win = window.open(url);
    win.focus()
}

function TataTertib(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/TataTertib/" + str;

    var win = window.open(url);
    win.focus()
}

function PerkiraanBiayaNonOP(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PerkiraanBiayaNonOP/" + str;

    var win = window.open(url);
    win.focus()
}

function PerkiraanbiayaOP(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PerkiraanbiayaOP/" + str;

    var win = window.open(url);
    win.focus()
}

function PersetujuanBiaya(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PersetujuanBiaya/" + str;

    var win = window.open(url);
    win.focus()
}

function PersutujuanSelisih(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PersetujuanSelisih/" + str;

    var win = window.open(url);
    win.focus()
}

// function ShowHistoryDocuments(str) {
//     const base_url = window.location.origin;
//     var str = btoa(str);
//     window.location = base_url + '/SIKBREC/public/SignatureDigital/ListEdocuments/' + str;
// }

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