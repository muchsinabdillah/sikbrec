$(document).ready(function () {
   // $(".preloader").fadeOut();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveJadwalDokter();
            if (result.status == "success") {
                toast(result.message, "success")
                // setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {

            toast(err, "error")
        }
    })

    //VALIDASI SESSION PRAKTEK
    $('#SeninWaktuAwal').change(function () {
        //Some code
        var val = $("#SeninWaktuAwal").val();
        var attr = 'SessionSenin';
        validasiSession(val,attr);
    });
    $('#SelasaWaktuAwal').change(function () {
        //Some code
        var val = $("#SelasaWaktuAwal").val();
        var attr = 'SessionSelasa';
        validasiSession(val,attr);
    });
    $('#RabuWaktuAwal').change(function () {
        //Some code
        var val = $("#RabuWaktuAwal").val();
        var attr = 'SessionRabu';
        validasiSession(val,attr);
    });
    $('#KamisWaktuAwal').change(function () {
        //Some code
        var val = $("#KamisWaktuAwal").val();
        var attr = 'SessionKamis';
        validasiSession(val,attr);
    });
    $('#JumatWaktuAwal').change(function () {
        //Some code
        var val = $("#JumatWaktuAwal").val();
        var attr = 'SessionJumat';
        validasiSession(val,attr);
    });
    $('#SabtuWaktuAwal').change(function () {
        //Some code
        var val = $("#SabtuWaktuAwal").val();
        var attr = 'SessionSabtu';
        validasiSession(val,attr);
    });
    $('#MingguWaktuAwal').change(function () {
        //Some code
        var val = $("#MingguWaktuAwal").val();
        var attr = 'SessionMinggu';
        validasiSession(val,attr);
    });
});
async function validasiSession(param,attr) {
    try { 
        const dtGovalidateSession = await GovalidateSession(param); 
        updateUIdtGovalidateSession(dtGovalidateSession,attr); 
    } catch (err) {
        toast(err, "error")
    }
}
function GovalidateSession(param) {
    //var dummyjampraktek = $("[name='jamawalseninawal']").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getSession/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'jam=' + param
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

function updateUIdtGovalidateSession(dtGovalidateSession,attr){
    let responseApi = dtGovalidateSession;
    $('#'+attr).val(convertEntities(responseApi.NamaSesion));
}

async function saveJadwalDokter() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/addJadwalDokter';

    // data form
    var form_data = $("#form_cuti").serialize();
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

}
async function asyncShowMain() {
    try { 
        await getHakAksesByForm(13);
        const datagetGrupPerawatan = await getGrupPerawatan(); 
        const datagetJadwalDokter = await getJadwalDokter();
        console.log(datagetJadwalDokter);
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        updateUIdatagetDokterAllAktif(datagetJadwalDokter);
     
    } catch (err) {
        toast(err, "error")
    }
}
async function getIDDokter(){
    let idPoli = $("#GrupPerawatan").val();
    if(idPoli != null){
        const datagetDokterAllAktif =  await getDokterAllAktif();
        console.log(datagetDokterAllAktif);
        updateUIgetDokterAllAktif(datagetDokterAllAktif);
       
    }
    
}
function updateUIdatagetDokterAllAktif(datagetDokterAllAktif){
    let responseApi = datagetDokterAllAktif;
    $('#IdAuto').val(convertEntities(responseApi.data.ID));
    $('#StatusJadwal').val(convertEntities(responseApi.data.Status_Aktif_fix));
    $('#SeninStatus').val(convertEntities(responseApi.data.Senin));
    $('#SeninWaktuAwal').val(convertEntities(responseApi.data.Senin_Awal));
    $('#SeninWaktuAkhir').val(convertEntities(responseApi.data.Senin_Akhir));
    $('#SessionSenin').val(convertEntities(responseApi.data.Senin_Sesion));

    $('#SelasaStatus').val(convertEntities(responseApi.data.Selasa));
    $('#SelasaWaktuAwal').val(convertEntities(responseApi.data.Selasa_Awal));
    $('#SelasaWaktuAkhir').val(convertEntities(responseApi.data.Selasa_Akhir));
    $('#SessionSelasa').val(convertEntities(responseApi.data.Selasa_Sesion));

    $('#RabuStatus').val(convertEntities(responseApi.data.Rabu));
    $('#RabuWaktuAwal').val(convertEntities(responseApi.data.Rabu_Awal));
    $('#RabuWaktuAkhir').val(convertEntities(responseApi.data.Rabu_Akhir));
    $('#SessionRabu').val(convertEntities(responseApi.data.Rabu_Sesion));

    $('#KamisStatus').val(convertEntities(responseApi.data.Kamis));
    $('#KamisWaktuAwal').val(convertEntities(responseApi.data.Kamis_Awal));
    $('#KamisWaktuAkhir').val(convertEntities(responseApi.data.Kamis_Akhir));
    $('#SessionKamis').val(convertEntities(responseApi.data.Kamis_Sesion));

    $('#JumatStatus').val(convertEntities(responseApi.data.Jumat));
    $('#JumatWaktuAwal').val(convertEntities(responseApi.data.Jumat_Awal));
    $('#JumatWaktuAkhir').val(convertEntities(responseApi.data.Jumat_Akhir));
    $('#SessionJumat').val(convertEntities(responseApi.data.Jumat_Sesion));

    $('#SabtuStatus').val(convertEntities(responseApi.data.Sabtu));
    $('#SabtuWaktuAwal').val(convertEntities(responseApi.data.Sabtu_Awal));
    $('#SabtuWaktuAkhir').val(convertEntities(responseApi.data.Sabtu_Akhir));
    $('#SessionSabtu').val(convertEntities(responseApi.data.Sabtu_Sesion));

    $('#MingguStatus').val(convertEntities(responseApi.data.Minggu));
    $('#MingguWaktuAwal').val(convertEntities(responseApi.data.Minggu_Awal));
    $('#MingguWaktuAkhir').val(convertEntities(responseApi.data.Minggu_Akhir));
    $('#SessionMinggu').val(convertEntities(responseApi.data.Minggu_Sesion));

    $('#MaxSenin').val(convertEntities(responseApi.data.Senin_Max));
    $('#MaxSelasa').val(convertEntities(responseApi.data.Selasa_Max));
    $('#MaxRabu').val(convertEntities(responseApi.data.Rabu_Max));
    $('#MaxKamis').val(convertEntities(responseApi.data.Kamis_Max));
    $('#MaxJumat').val(convertEntities(responseApi.data.Jumat_Max));
    $('#MaxSabtu').val(convertEntities(responseApi.data.Sabtu_Max));
    $('#MaxMinggu').val(convertEntities(responseApi.data.Minggu_Max));

    $('#KuotaBpjsSenin').val(convertEntities(responseApi.data.Senin_Max_JKN));
    $('#KuotaNonBpjsSenin').val(convertEntities(responseApi.data.Senin_Max_NonJKN));
    $('#KuotaBpjsSelasa').val(convertEntities(responseApi.data.Selasa_Max_JKN));
    $('#KuotaNonBpjsSelasa').val(convertEntities(responseApi.data.Selasa_Max_NonJKN));
    $('#KuotaBpjsRabu').val(convertEntities(responseApi.data.Rabu_Max_JKN));
    $('#KuotaNonBpjsRabu').val(convertEntities(responseApi.data.Rabu_Max_NonJKN));
    $('#KuotaBpjsKamis').val(convertEntities(responseApi.data.Kamis_Max_JKN));
    $('#KuotaNonBpjsKamis').val(convertEntities(responseApi.data.Kamis_Max_NonJKN));
    $('#KuotaBpjsJumat').val(convertEntities(responseApi.data.Jumat_Max_JKN));
    $('#KuotaNonBpjsJumat').val(convertEntities(responseApi.data.Jumat_Max_NonJKN));
    $('#KuotaBpjsSabtu').val(convertEntities(responseApi.data.Sabtu_Max_JKN));
    $('#KuotaNonBpjsSabtu').val(convertEntities(responseApi.data.Sabtu_Max_NonJKN));
    $('#KuotaBpjsMinggu').val(convertEntities(responseApi.data.Minggu_Max_JKN));
    $('#KuotaNonBpjsMinggu').val(convertEntities(responseApi.data.Minggu_Max_NonJKN));

    $('#Note').val(convertEntities(responseApi.data.Note));

    $('#GrupPerawatan').val(convertEntities(responseApi.data.IDUnit)).trigger('change');
    
    setTimeout(function () {
        $('#NamaDokter').val(convertEntities(responseApi.data.IDDokter)).trigger('change');
    }, 500);

    $('#GroupJadwal').val(convertEntities(responseApi.data.Group_Jadwal_fix)).trigger('change');
    $(".preloader").fadeOut();
}
function getJadwalDokter() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getJadwalDokterId/';
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
            $("#NamaDokter").select2();
        })
}
function updateUIgetDokterAllAktif(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        $("#NamaDokter").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaDokter").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].First_Name + '</option';
            $("#NamaDokter").append(newRow);
        }
    }
}
function getDokterAllAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getIDDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idpoli=' + $("#GrupPerawatan").val()
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
            $("#NamaDokter").select2();
        })
}
function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
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
            $("#GrupPerawatan").select2();
        })
}

///harus ada
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
    location.reload();
}
function sendHFIS(params) {
    var hari = params;
    var kodetrsJadwal = $("#IdAuto").val(); 
    goSendHFIS(hari, kodetrsJadwal);
}
async function goSendHFIS(hari, kodetrsJadwal) { 
    try {
        const dataGoSendHFIS = await GoSendHFIS(hari, kodetrsJadwal);
        updateUIdatadataGoSendHFIS(dataGoSendHFIS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}  
function GoSendHFIS(hari, kodetrsJadwal) {
    var dataid = kodetrsJadwal;
    var haris = hari;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/xGoSendHFIS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "dataid=" + dataid + "&hari=" + haris 
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIdatadataGoSendHFIS(params) {
    if (params.status == "success") {
        toast(params.pesan, "success")
    }

}