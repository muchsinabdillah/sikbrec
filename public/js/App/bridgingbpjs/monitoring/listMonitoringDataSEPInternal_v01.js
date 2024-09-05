$(document).ready(function () {
    $(".preloader").fadeOut();
    $('#btnHapusInternal').click(function () {
        swal({
            title: "BPJS",
            text: "Apakah Anda ingin Hapus SEP Internal ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goUpdateTgl();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });
});

async function goUpdateTgl() {
    try {
        $(".preloader").fadeIn();
        const datagoUpdateTglSEPPulang = await goUpdateTglSEPPulang();
        console.log("datagoUpdateTglSEPPulang", datagoUpdateTglSEPPulang)
        updateUIdatagoUpdateTglSEPPulang(datagoUpdateTglSEPPulang);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdatagoUpdateTglSEPPulang(datagoUpdateTglSEPPulang) {
    let data = datagoUpdateTglSEPPulang;
    swal("Success", data.message, "success")
        .then((value) => {
            location.reload();
        });

}
function goUpdateTglSEPPulang() {
    var base_url = window.location.origin;
    var MNoSEPBPJS = document.getElementById("MNoSEPBPJS").value;
    var MNoRujukanSEPBPJS = document.getElementById("MNoRujukanSEPBPJS").value;
    var KodePoliRujukanBPJS = document.getElementById("KodePoliRujukanBPJS").value;
    var TglRujukanBPJS = document.getElementById("TglRujukanBPJS").value; 
    let url = base_url + '/SIKBREC/public/xBPJSBridging/goHapussepInternal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'MNoSEPBPJS=' + MNoSEPBPJS + '&MNoRujukanSEPBPJS=' + MNoRujukanSEPBPJS + '&KodePoliRujukanBPJS=' + KodePoliRujukanBPJS
            + '&TglRujukanBPJS=' + TglRujukanBPJS 
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
            //$("#cariDokterBPJS").select2();
        })
}

function GoMonitoringBPJS() { 
    var MSepInternalNoSep = document.getElementById("MSepInternalNoSep").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/KunjunganSEPInternal/GoMonitoringDataSEPInernalBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) { 
                d.MSepInternalNoSep = MSepInternalNoSep;
            }
        },
        "columns": [
            { "data": "nosep" },
            { "data": "nosepref" },
            { "data": "nmtujuanrujuk" },
            { "data": "nmpoliasal" },
            { "data": "tglrujukinternal" }, 
            { "data": "nokapst" },
            { "data": "nmdiag" },
            { "data": "nmdokter" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    
                        var html = ""
                    var html = '<span class="label label-danger" onclick=\'showNoSEP("' + row.nosep + '","' + row.nosurat + '","' + row.tglrujukinternal + '","' + row.tujuanrujuk + '")\'> HAPUS </span> ';
                        return html
                  

                }
            },
        ]
    });

}
function showNoSEP(noSEP, nosurat, tglrujukinternal, tujuanrujuk) {
    $("#modal_UpdateTglPulang").modal('show');
    $("#MNoSEPBPJS").val(noSEP);
    $("#MNoRujukanSEPBPJS").val(nosurat);
    $("#TglRujukanBPJS").val(tglrujukinternal);
    $("#KodePoliRujukanBPJS").val(tujuanrujuk);
}
function ShowDataPasienPoliklinik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/";
}