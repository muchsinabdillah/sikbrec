$(document).ready(function () {
    $(".preloader").fadeOut();
    $(document).on('click', '#btnBatalSIPR', function () {
        batalSPRI();
    });
});
async function batalSPRI() {
    try {
        $(".preloader").fadeIn();
        const datagoBatalSPRI = await goBatalSPRI();
        console.log("datagoBatalSPRI", datagoBatalSPRI)
        UpdateUIdatagoBatalSPRI(datagoBatalSPRI);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UpdateUIdatagoBatalSPRI(data) {
    swal("Success ", "Data SIPR Sukses Dihapus !", "success")
        .then((value) => {
            GoMonitoringBPJS();
            $("#modal_UpdateTglPulang").modal('hide');
        });
}
function goBatalSPRI() {
    var base_url = window.location.origin;
    var NOspri = document.getElementById("NOspri").value;
    var alasanbatal = document.getElementById("alasanbatal").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/goBatalSPRI';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NOspri=' + NOspri + '&alasanbatal=' + alasanbatal
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
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjungan2BPJS = $("[name='MTglKunjungan2BPJS']").val();
    var MJenisPelayananBPJS = document.getElementById("MJenisPelayananBPJS").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoListSPRIBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MTglKunjungan2BPJS = MTglKunjungan2BPJS;
                d.MJenisPelayananBPJS = MJenisPelayananBPJS;
            }
        },
        "columns": [
            { "data": "noSuratKontrol" },
            { "data": "noKartu" },
            { "data": "nama" },
            { "data": "namaDokter" },
            { "data": "namaPoliAsal" },
            { "data": "namaPoliTujuan" },
            { "data": "jnsPelayanan" },
            { "data": "namaJnsKontrol" },
            { "data": "tglRencanaKontrol" },
            { "data": "tglTerbitKontrol" },
            { "data": "noSepAsalKontrol" },
            { "data": "tglSEP" },
            // {
            //     "render": function (data, type, row) {
            //         var html = ""
            //         var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataSIPR("' + row.noSuratKontrol + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
            //         return html
            //     }
            // },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataSIPR("' + row.noSuratKontrol + '","' + row.namaJnsKontrol + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ]
    });


}
//function ShowDataSIPR(noSuratKontrol) {
//    $("#modal_UpdateTglPulang").modal('show');
//    $("#NOspri").val(noSuratKontrol);
//}
function ShowDataSIPR(str, namaJnsKontrol) {
    console.log(namaJnsKontrol)
    const base_url = window.location.origin;
    if (namaJnsKontrol == "SPRI") {
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/SPRI/UpdateSPRI/' + str;
    } else {
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aKontrolUlang/UpdateFaskes/' + str;
    }


}