$(document).ready(function () { 
    $("#hide_dokter").hide();
    $("#ShowTarif").hide();

    onLoadFunctionAll();
    $('#dokterid').click(function () {
        var noreservasi = $("#pxNoReservasi").val();
        $("#hide_dokter").show();
        $('#dokter').select2();
       // getDokter();

    });
    $('#Rad_Kode_Tarif').click(function () {
        $("#ShowTarif").show();
        $('#Rad_Select').select2();
    });
    // $(document).on('click', '#btnSelesai', function () {
    //     swal({
    //         title: "Simpan",
    //         text: "Apakah Anda ingin Simpan Registrasi ?",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 if ($("#Rad_WOID").val() != '') {
    //                     toast("Edit Tidak Diizinkan, Silahkan Batalkan Lalu Order Ulang!", "error")
    //                     exit();
    //                 }
    //                 goCreateOrderRadiologi();
    //             } else {
    //                 // swal("Transaction Rollback !");
    //             }
    //         });
       
    // });

        $(document).on('click', '#btnSelesai', function () {
                    if ($("#Rad_WOID").val() != '') {
                        toast("Edit Tidak Diizinkan, Silahkan Batalkan Lalu Order Ulang!", "error")
                        exit();
                    }
                    if ($("#Rad_Daignosa").val() == '') {
                        toast("Diagnosa Kosong !", "error")
                        exit();
                    }
                    if ($("#Rad_Keterangan_Klinik").val() == '') {
                        toast("Keterangan Klinis Kosong !", "error")
                        exit();
                    }
                    //goCreateOrderRadiologi();
                    $("#modal_alert_konfirmasi_payment").modal('show');
                
    });

    $('#btnSudahBayar').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ini Sudah Dibayarkan?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //goFinishOrderLab();
                    goGeneratePayment();
                } else {
                    // swal("Transaction Rollback !");
                }
            });
    });

    $('#btnBelumBayar').click(function () {
        goCreateOrderRadiologi('0');
    });

    $('#btnKirimRincian').click(function () {
        swal({
            title: "Kirim E-mail",
            text: "Apakah Anda Yakin Ingin Kirim Rincian Biaya ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    
                    var email = $("#EmailSend").val();
                    if (!validateEmail(email)) {
                        swal({
                            title: "Email Tidak Sesuai Format",
                            text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
                            icon: "warning",
                        })
                        $("#EmailSend").focus();
                        $(".preloader").fadeOut();
                        return false;
                       }
    
                            var notrs = $("#Rad_NORegistrasi").val();
                            var kodereg = $("#Rad_NORegistrasi").val().slice(0,2);
                            // if (kodereg != 'RJ' || kodereg != 'RI'){
                            //     kodereg = 'PB';
                            // }
                            var lang = 'ID';
                            //var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
                            var jeniscetakan = 'RINCIANBIAYA_RJ';
                            if (jeniscetakan == 'KUITANSIREKAP'){
                                var url = 'SaveKuitansiRekap';
                            }else if(jeniscetakan == 'KUITANSI'){
                                var url = 'SaveKuitansi';
                            }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
                                var url = 'SaveRincianPB';
                            }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
                                var url = 'SaveRincianRJOld';
                            }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
                                var url = 'SaveRincianRI';
                            }
                            gouploadtoAws(notrs,kodereg,lang,jeniscetakan,url,email);
                } 
            });
    });

    $('#btnPreviewRincian').click(function () {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aBillingPasien/PrintRincianRJOld/ID/'+$("#Rad_NORegistrasi").val();
        var win = window.open(url,  "_blank", 
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
              win.focus();
    });


    $(document).on('click', '#btnVoidTrsRegHdr', function () {
        window.onbeforeunload = null;
        deleteOrder();
    });
});
async function goCreateOrderRadiologi(param) {
    try {
        const dataCreateOrderRadiologi = await CreateOrderRadiologi(param);
        //console.log("dataCreateOrderRadiologi", dataCreateOrderRadiologi);
        updateUIdataCreateOrderRadiologi(dataCreateOrderRadiologi,param);
    } catch (err) {
        toast(err, "error")
    }
}
function loadDataOrderRadiologi() {
    var base_url = window.location.origin;
    var searchbox = $("[name='Rad_NORegistrasi']").val();
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aOrderRadiologi/getListOrderRadiologi",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.searchbox = searchbox;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            { "data": "NoMR" },
            { "data": "PatientName" },
            { "data": "NoEpisode" },
            { "data": "NamaUnit" },
            { "data": "ACCESSION_NO" },
            { "data": "First_Name" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showdatahdr("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-log-in"></span></button> '
                    return html
                }
            },

        ]
    });
}
function updateUIdataCreateOrderRadiologi(data,param) {
    toast(data.message,"success")
    if (param == '0'){
        counter(2, MyBack() );
    }
}
function counter(time, url) {
    var interval = setInterval(function () {
        $('#waktu').text(time);
        time = time - 1;

        if (time == 0) {
            clearInterval(interval);
            window.location = url;
        }
    }, 1000);
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/list";
}
function CreateOrderRadiologi(param) {
    var Rad_NoMR = $("#Rad_NoMR").val();
    var Rad_NoEpisode = $("#Rad_NoEpisode").val();
    var Rad_NORegistrasi = $("#Rad_NORegistrasi").val();
    var Rad_NamaPasien = $("#Rad_NamaPasien").val();
    var Rad_IdDokter = $("#Rad_IdDokter").val();
    var Rad_NamaDokter = $("#Rad_NamaDokter").val();
    var Rad_IdPoli = $("#Rad_IdPoli").val();
    var Rad_Nama_Poli = $("#Rad_Nama_Poli").val();
    var Rad_Patient_Loc = $("#Rad_Patient_Loc").val();
    var Rad_Acc_Number = $("#Rad_Acc_Number").val();
    var Rad_Department_req = $("#Rad_Department_req").val();
    var Rad_Kode_Tarif = $("#Rad_Kode_Tarif").val();
    var Rad_Nama_Tarif = $("#Rad_Nama_Tarif").val();
    var Rad_ModalityCodes = $("#Rad_ModalityCodes").val();
    var Rad_ActionCodes = $("#Rad_ActionCodes").val();
    var Rad_Position = $("#Rad_Position").val();
    var Rad_Side = $("#Rad_Side").val();
    var Rad_Nilai = $("#Rad_Nilai").val();
    var Rad_Daignosa = $("#Rad_Daignosa").val();
    var Rad_Keterangan_Klinik = $("#Rad_Keterangan_Klinik").val();
    var Rad_DokterRadiologi = $("#dokterid").val();
    var Ket_Hasil = $("#Ket_hasildiambil").val();
    var Rad_TglKunjungan = $("#Rad_TglKunjungan").val();
    var Rad_iscito = $("#Rad_iscito").val();

    var base_url = window.location.origin;
    let url = base_url + "/SIKBREC/public/aOrderRadiologi/CreateOrderRadiologi";
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Rad_NoMR=" + Rad_NoMR + "&Rad_NoEpisode=" + Rad_NoEpisode + "&Rad_NORegistrasi=" + Rad_NORegistrasi +
            "&Rad_NamaPasien=" + Rad_NamaPasien + "&Rad_IdDokter=" + Rad_IdDokter +
            "&Rad_NamaDokter=" + Rad_NamaDokter + "&Rad_IdPoli=" + Rad_IdPoli
            + "&Rad_Nama_Poli=" + Rad_Nama_Poli + "&Rad_Patient_Loc=" + Rad_Patient_Loc
            + "&Rad_Acc_Number=" + Rad_Acc_Number + "&Rad_Department_req=" + Rad_Department_req
            + "&Rad_Kode_Tarif=" + Rad_Kode_Tarif + "&Rad_Nama_Tarif=" + Rad_Nama_Tarif
            + "&Rad_ModalityCodes=" + Rad_ModalityCodes + "&Rad_ActionCodes=" + Rad_ActionCodes
            + "&Rad_Position=" + Rad_Position + "&Rad_Side=" + Rad_Side
            + "&Rad_Nilai=" + Rad_Nilai + "&Rad_Daignosa=" + Rad_Daignosa
            + "&Rad_Keterangan_Klinik=" + Rad_Keterangan_Klinik
            + "&Rad_DokterRadiologi=" + Rad_DokterRadiologi
            + "&Ket_hasildiambil=" + Ket_Hasil + "&Rad_TglKunjungan=" + Rad_TglKunjungan
            + "&Rad_iscito=" + Rad_iscito + "&is_approved=" + param
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
            // $("#caramasuk").select2();
        })
}
async function onLoadFunctionAll() {
    try {
        const datagetTarifRadiologiCombo = await getTarifRadiologiCombo();
        
        const dataGetregistrasiRajalbyNoRegistrasi = await GetregistrasiRajalbyNoRegistrasi();
        updateUIgetTarifRadiologiCombo(datagetTarifRadiologiCombo);
        updateUIdataGetregistrasiRajalbyNoRegistrasi(dataGetregistrasiRajalbyNoRegistrasi);

        console.log("dataGetregistrasiRajalbyNoRegistrasi", dataGetregistrasiRajalbyNoRegistrasi);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetregistrasiRajalbyNoRegistrasi(data) {
    var Lab_NORegistrasi = $("#Rad_NORegistrasi").val();
    var res = Lab_NORegistrasi.substr(0, 2);
    if (res == 'RI') {
        var url = "/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasiRI";
        var pat_loc = 'RWI';
    } else {
        var url = "/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasi";
        var pat_loc = 'RWJ';
    }
    $("#Rad_NORegistrasi").val(data.NoRegistrasi);
    $("#Rad_NoEpisode").val(data.NoEpisode);
    $("#Rad_NamaPasien").val(data.PatientName);
    $("#Rad_NoMR").val(data.NoMR);
    $("#Rad_IdDokter").val(data.Doctor1);
    $("#Rad_IdPoli").val(data.Unit);
    $("#Rad_Nama_Poli").val(data.LokasiPasien);
    $("#Rad_NamaDokter").val(data.namadokter);
    $("#Rad_Patient_Loc").val(pat_loc);
    $("#Rad_TglKunjungan").val(data.VisitDate+' '+data.JamDate);
}
function GetregistrasiRajalbyNoRegistrasi() {
    var NoRegistrasi = $("#Rad_NORegistrasi").val(); 
    var res = NoRegistrasi.substr(0, 2);
    if (res == 'RI') {
        var url2 = "controller/EMR/exec_Order_Radiologi.php?action=ShowDataPasienRanapbyNoReg";
        var pat_loc = 'RWI';
    } else {
        var url2 = "/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasi";
        var pat_loc = 'RWJ';
    }
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + NoRegistrasi
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
            // $("#caramasuk").select2();
        })
}
async function getTarifRad() {
    try {
        const datagetTarifRadbyId = await getTarifRadbyId();
        console.log("datagetTarifRadbyId", datagetTarifRadbyId);
        updateUITarifRadbyId(datagetTarifRadbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUITarifRadbyId(data) {
    $("#Rad_Kode_Tarif").val(data.Proc_Code);
    $("#Rad_Nama_Tarif").val(data.Proc_Description);
    $("#Rad_ModalityCodes").val(data.Modality_Code);
    $("#Rad_ActionCodes").val(data.Proc_ActionCode);
    $("#Rad_Nilai").val(data.ServiceCharge_O);
    $("#Rad_Position").val(data.position);
    $("#ShowTarif").hide();
}
function getTarifRadbyId() {
    var base_url = window.location.origin;
    var Rad_Select = document.getElementById("Rad_Select").value;
    let url = base_url + '/SIKBREC/public/MasterDataTarifRadiologi/getTarifRadbyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Rad_Select=' + Rad_Select
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
            $("#Rad_Select").select2();
        })
}
function updateUIgetTarifRadiologiCombo(datagetTarifRadiologiCombo) {
    let responseApi = datagetTarifRadiologiCombo;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Rad_Select").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Proc_Description + '</option';
            $("#Rad_Select").append(newRow);
        }
    }
}
function getTarifRadiologiCombo() {
    var base_url = window.location.origin;
    var noregistrasi = $("#Rad_NORegistrasi").val();
    let url = base_url + '/SIKBREC/public/MasterDataTarifRadiologi/getTarifRadiologiCombo';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val() +"&noregistrasi="+noregistrasi
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
            $("#Rad_Select").select2();
        })
}

async function showdatahdr(woid) {
    try {
        $(".preloader").fadeIn();
        const datagetDataTblHeader = await getDataTblHeader(woid); 
        updateUIdatagetDataTblHeader(datagetDataTblHeader);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetDataTblHeader(data) {
    $("#Rad_WOID").val(data.WOID);
    $("#Rad_Acc_Number").val(data.Accession_No); 
    $("#Rad_Kode_Tarif").val(data.SCHEDULED_PROC_ID);
    $("#Rad_Nama_Tarif").val(data.SCHEDULED_PROC_DESC);
    $("#Rad_ModalityCodes").val(data.SCHEDULED_MODALITY);  
    $("#Rad_ActionCodes").val(data.SCHEDULED_ACTION_CODES); 
    $("#Rad_Position").val(data.Posisition); 
    $("#Rad_Nilai").val(data.Tarif); 
    $("#Rad_Daignosa").val(data.Diagnosis); 
    $("#Rad_Keterangan_Klinik").val(data.Note); 
    $("#Rad_TglPeriksa").val(data.ORDER_DATE); 
    $("#dokterid").val(data.DokterRadiologi);
    $("#shownamdokterfix").val(data.NamaDokterRadiologi);
    $("#Ket_hasildiambil").val(data.Ket_hasildiambil); 
    $("#Rad_iscito").val(data.cito); 
    $("#modalCariDataListOrderRad").modal('hide');
}
function getDataTblHeader(woid) {
    var url2 = "/SIKBREC/public/aOrderRadiologi/getDataTblHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'woid=' + woid
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

function showModalDel() {
    var NoJurnal = $("#Rad_WOID").val();
     $("#noregbatalHdr").val(NoJurnal);
    $("#modal_alert_batalhdr").modal('show');
}

async function deleteOrder() {
    try {
        $(".preloader").fadeIn();
        const datadeleteOrder = await godeleteOrder();
        updateUIdatadeleteOrder(datadeleteOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatadeleteOrder(data) {
    if (data.status == "warning") {
        toast(data.errorname, "error")
    } else if (data.status == "success") {
        toast("Pemeriksaan Berhasil Dibatalkan !", "success")
        window.location.reload();
    }
}
function godeleteOrder() {
    var noregbatalHdr = $("[name='noregbatalHdr']").val();
    var Rad_Acc_Number = $("[name='Rad_Acc_Number']").val();
    var alasanbatalOrder = $("[name='alasanbatalHdr']").val();
    var Rad_NORegistrasi = $("[name='Rad_NORegistrasi']").val();
    var url2 = "/SIKBREC/public/aOrderRadiologi/deleteOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noregbatalHdr=' + noregbatalHdr + '&Rad_Acc_Number=' + Rad_Acc_Number + '&alasanbatalOrder=' + alasanbatalOrder + '&Rad_NORegistrasi=' + Rad_NORegistrasi
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

async function goGeneratePayment() {
    try {
        $(".preloader").fadeIn();
        window.onbeforeunload = null;
        const datareg = await GetregistrasiRajalbyNoRegistrasiDigital();
        updateUIGetregistrasiRajalbyNoRegistrasiDigital(datareg);
        const data = await GeneratePayment();
        updateUIGeneratePayment(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGeneratePayment(data) {
    if (data.status == 'warning'){
        toast(data.errorname, "error")
    }else{
        toast(data.message, "success")
        goCreateOrderRadiologi('1');
        $("#modal_alert_konfirmasi_payment").modal('hide');
        $("#modal_alert_konfirmasi_send").modal('show');
    }
    // if (data.status == "warning") {
    //     toast(data.errorname, "error")
    // } else if (data.status == "warningreceive") {
    //     $("#modal_alert_verifdetail").modal('show');
    // } else if (data.status == "success") {
    //     toast("Pemeriksaan Berhasil Disimpan !", "success")
    //     //$("#modal_alert_konfirmasi_payment").modal('show');
    //     // MyBack();
    // }
}
async function GeneratePayment() {
    var form = $("#frmSimpanTrsRegistrasi").serialize();
    var url2 = "/SIKBREC/public/aBillingPasien/goPaymentFromAPI";
    var JenisTrs = 'RADIOLOGI';
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&JenisTrs=' + JenisTrs + "&Lab_NORegistrasi=" + $("#Rad_NORegistrasi").val()
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

// async function goSendRincian() {
//     try {
//         $(".preloader").fadeIn();
//         window.onbeforeunload = null;
//         const data = await SendRincian();
//         updateUISendRincian(data);
//     } catch (err) {
//         toast(err, "error")
//     }
// }
// function updateUISendRincian(data) {
//     if (data.status == 'warning'){
//         toast(data.errorname, "error")
//     }else{
//         toast(data.message, "success")
//         // $("#modal_alert_konfirmasi_payment").modal('hide');
//         // $("#modal_alert_konfirmasi_send").modal('show');
//     }
// }
// async function SendRincian() {
//     var form = $("#frmSimpanTrsRegistrasi").serialize();
//     var url2 = "/SIKBREC/public/aBillingPasien/goPaymentFromAPI";
//     var JenisTrs = 'RADIOLOGI';
//     var base_url = window.location.origin;
//     let url = base_url + url2;
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: form + '&JenisTrs=' + JenisTrs + "&Lab_NORegistrasi=" + $("#Rad_NORegistrasi").val()
//     })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(response.statusText)
//             }
//             return response.json();
//         })
//         .then(response => {
//             if (response.status === "error") {
//                 throw new Error(response.message.errorInfo[2]);
//                 // console.log("ok " + response.message.errorInfo[2])
//             } else if (response.status === "warning") {
//                 throw new Error(response.errorname);
//                 // console.log("ok " + response.message.errorInfo[2])
//             }
//             return response
//         })
//         .finally(() => {
//             $(".preloader").fadeOut();
//         })
// }

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  async function gouploadtoAws(notrs,kodereg,lang,jeniscetakan,url,email) {
    try {
        $(".preloader").fadeIn();
        const awsurl = await uploadtoAws_filepdfx(notrs,kodereg,lang,jeniscetakan,url);
            var url = 'SendMailRincian';
            var judul = 'Rincian Biaya';
        await SendEmail(judul,email,awsurl);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

async function uploadtoAws_filepdfx(notrs,kodereg,lang,jeniscetakan,urlx){
    var base_url = window.location.origin;
    var d = new Date();
    var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
    let url = base_url + '/SIKBREC/public/aBillingPasien/'+urlx;
    return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body:   'notrs='+notrs+
            '&jeniscetakan='+jeniscetakan+
            '&kodereg='+kodereg+
            '&lang='+lang+
            '&periode_awal='+strDate+
            '&periode_akhir='+strDate+
            '&lang='+lang
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
        //$("#NamaPenjamin").select2();
    })
}

async function SendEmail(judul,email,awsurl) {
    $(".preloader").fadeIn();
    var pkuitansi_notrs = $("#Rad_NORegistrasi").val();
    var jeniscetakan = 'RINCIANBIAYA_RJ';
    var noregistrasi = $("#Rad_NORegistrasi").val();
    var aws_url = awsurl['aws_url'];
    // var email = $("#pemail_pasien").val();
    // if (!validateEmail(email)) {
    //     swal({
    //         title: "Email Tidak Sesuai Format",
    //         text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
    //         icon: "warning",
    //     })
    //     $("#pemail_pasien").focus();
    //     $(".preloader").fadeOut();
    //     return false;
    //    }
    var FormData = {
        notrs:pkuitansi_notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
        aws_url:aws_url,
    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aBillingPasien/SendMail/";
    $.ajax({
        url: url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
        success: function (data) {
          $(".preloader").fadeOut();
            if (data.status=='success'){
              var title = 'Kirim Email Berhasil!';
              var statuskirim = 'TERKIRIM';
            }else{
              var title = 'Kirim Email Gagal!';
              var statuskirim = 'GAGAL';
            }
            
            //$("#notif_ShowTTD_Digital").modal('hide');
            swal({
              title: title,
              text: data.message,
              icon: data.status,
          }).then(function() {
            MyBack();
          });
          //INSERT TZ LOG EMAIL
          //goInsertLog(nolab,statuskirim,email);

        },
        error: function (xhr, status) {
          $(".preloader").fadeOut();
          toast(xhr, status);
            // handle errors
            console.log(xhr,status);
        }
    });
}

function updateUIGetregistrasiRajalbyNoRegistrasiDigital(data) {
    // if (data.status == 'warning'){
    //     toast(data.errorname, "error")
    // }else{
        $("#NoHPSend").val(data.NoHP)
        $("#EmailSend").val(data.Email)
    //}
}
async function GetregistrasiRajalbyNoRegistrasiDigital() {
    var url2 = "/SIKBREC/public/aBillingPasien/GetregistrasiRajalbyNoRegistrasiDigital";
    var NoRegistrasi = $("#Rad_NORegistrasi").val();
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + NoRegistrasi
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
            //$(".preloader").fadeOut();
        })
}