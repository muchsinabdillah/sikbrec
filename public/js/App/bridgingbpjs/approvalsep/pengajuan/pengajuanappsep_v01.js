$(document).ready(function () {
    $(".preloader").fadeOut();
    $("#isJenisPelayananBPJS").select2();
    $("#isJenisPelayananPengajuanBPJS").select2();
    $(document).on('click', '#savetrs', function () {
        savePengajuanSEP();
    });
});
async function savePengajuanSEP() {
    try {
        $(".preloader").fadeIn();
        const datagosavePengajuanSEP = await gosavePengajuanSEP();
        console.log("datagosavePengajuanSEP", datagosavePengajuanSEP)
        UpdateUIgosavePengajuanSEP(datagosavePengajuanSEP);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UpdateUIgosavePengajuanSEP(params) {
    
    swal("Success", params[1], "success")
        .then((value) => {
          //  $('#notif_Cetak').modal('show');
         location.reload();
        });
}
function gosavePengajuanSEP() {
    var base_url = window.location.origin;
    var iscatatanBPJS = document.getElementById("iscatatanBPJS").value;
    var PengSEP_NoKartu = document.getElementById("PengSEP_NoKartu").value;
    var PengSEP_Tgl = document.getElementById("PengSEP_Tgl").value;
    var isJenisPelayananBPJS = document.getElementById("isJenisPelayananBPJS").value;
    var isJenisPelayananPengajuanBPJS = document.getElementById("isJenisPelayananPengajuanBPJS").value;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/gosavePengajuanSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'iscatatanBPJS=' + iscatatanBPJS + '&PengSEP_NoKartu=' + PengSEP_NoKartu
            + '&PengSEP_Tgl=' + PengSEP_Tgl + '&isJenisPelayananBPJS=' + isJenisPelayananBPJS
            + '&isJenisPelayananPengajuanBPJS=' + isJenisPelayananPengajuanBPJS
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