$(document).ready(function () { 
    
    $("#modalNotificationOrdeLab").modal('show');
    FormReadonly();
    document.getElementById("btnAddDetail").disabled = true;
    console.log("okesssss")
    onLoadFunctionAll();
    $(document).on('click', '#btnnewtransaksi', function () {
        addnewHeader();
    });
    $(document).on('click', '#btnAddDetail', function () {
        addDetilPemeriksaanLaboratoriuma();
    });
    $(document).on('click', '#btnVoidTrsDetil', function () {
         
        deleteDetilOrderLab();
    });
    $(document).on('click', '#btnVoidTrs', function () {
        window.onbeforeunload = null;
        deleteOrderLab();
    });
    $(document).on('click', '#btnClose', function () {
        window.onbeforeunload = null;
        LogTime();
        MyBack();
    });
    
    $('#btnSelesai').click(function () {
        $("#modal_alert_konfirmasi_payment").modal('show');
        // swal({
        //     title: "Simpan",
        //     text: "Apakah Anda ingin Simpan ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
        //             goFinishOrderLab();
        //         } else {
        //             // swal("Transaction Rollback !");
        //         }
        //     });

    });
    $("#is_batal").val("1");
    window.onbeforeunload = function () {
        return "Do you want to leave?"
    }
    // A jQuery event (I think), which is triggered after "onbeforeunload"
    $(window).unload(function () {
        LogTime();
        //I will call my method
    });

    $('#btnSudahBayar').click(function () {
        if ($("#Lab_NoLab").val() == ''){
            toast('NoLab Invalid !', 'error');
            return false;
        }
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
        goFinishOrderLab('0');
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
    
                            var notrs = $("#Lab_NORegistrasi").val();
                            var kodereg = $("#Lab_NORegistrasi").val().slice(0,2);
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
        let url = base_url + '/SIKBREC/public/aBillingPasien/PrintRincianRJOld/ID/'+$("#Lab_NORegistrasi").val();
        var win = window.open(url,  "_blank", 
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
              win.focus();
    });
    
});
async function LogTime() { 
    var is_batal = $("#is_batal").val();  
    if (is_batal == "1") {
        try {
            $(".preloader").fadeIn();
            const datadeleteOrderLab = await godeleteOrderLabRef();
            console.log("datadeleteOrderLab", datadeleteOrderLab);
           // updateUIdatadeleteOrderLab(datadeleteOrderLab);
        } catch (err) {
            toast(err, "error")
        } 
    } else {
        // try {
        //     $(".preloader").fadeIn();
        //     const datadeleteOrderLab = await godeleteOrderLabRef_2();
        //     console.log("datadeleteOrderLab", datadeleteOrderLab);
        //     // updateUIdatadeleteOrderLab(datadeleteOrderLab);
        // } catch (err) {
        //     toast(err, "error")
        // }
    }
} 
function godeleteOrderLabRef_2() {
    var NoLabOrderBatal = $("[name='Lab_NoLab']").val();
    var alasanbatalOrder = "auto Sistem";
    var url2 = "/SIKBREC/public/aorderLaboratorium/deleteOrderLab2";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Lab_NoLab=' + NoLabOrderBatal + '&alasanbatalOrder=' + alasanbatalOrder
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
function godeleteOrderLabRef() {
    var NoLabOrderBatal = $("[name='Lab_NoLab']").val();
    var alasanbatalOrder = "auto Sistem";
    var url2 = "/SIKBREC/public/aorderLaboratorium/deleteOrderLab";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Lab_NoLab=' + NoLabOrderBatal + '&alasanbatalOrder=' + alasanbatalOrder
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
async function deleteOrderLab() {
    try {
        $(".preloader").fadeIn();
        const datadeleteOrderLab = await godeleteOrderLab();
        console.log("datadeleteOrderLab", datadeleteOrderLab);
        updateUIdatadeleteOrderLab(datadeleteOrderLab);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatadeleteOrderLab(data) {
    if (data.status == "warning") {
        toast(data.errorname, "error")
    } else if (data.status == "warningreceive") {
        $("#modal_alert_verifdetail").modal('show');
    } else if (data.status == "success") {
        toast("Pemeriksaan Berhasil Dibatalkan !", "success")
        window.location.reload();
    }
}
function godeleteOrderLab() {
    var NoLabOrderBatal = $("[name='NoLabOrderBatal']").val();
    var alasanbatalOrder = $("[name='alasanbatalOrder']").val();
    var url2 = "/SIKBREC/public/aorderLaboratorium/deleteOrderLab";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Lab_NoLab=' + NoLabOrderBatal + '&alasanbatalOrder=' + alasanbatalOrder
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
function loadDataOrderLaboratorium() {
    var base_url = window.location.origin;
    var searchbox = $("[name='Lab_NORegistrasi']").val();
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aorderLaboratorium/getListOrderLaboratoriumbyNoReg",
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
            { "data": "NoRegistrasi" },
            { "data": "NamaUnit" },
            { "data": "NoLab" },
            { "data": "First_Name" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.StatusID >= 3){
                        var html = '<button class="btn btn-info" title="Pemeriksaan Sudah Diapprove Oleh Billing"  id="buttonedit" name="buttonedit" disabled><span class="glyphicon glyphicon-log-in"></span></button> '
                    }else{
                        var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showdataLIShdr("' + row.LabID + '")\' value=' + row.LabID + '><span class="glyphicon glyphicon-log-in"></span></button> '
                    }
                   
                    return html
                }
            },

        ]
    });
}
async function showdataLIShdr(idLab) {
    try {
        $(".preloader").fadeIn();
        const datagetDataTblLabHeader = await getDataTblLabHeader(idLab); 
        updateUIdatagetDataTblLabHeader(datagetDataTblLabHeader);
        const datacekStatus = await cekStatus();
        updateUIdatacekStatus(datacekStatus);
        console.log("datacekStatus", datacekStatus);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacekStatus(data) {
    var x = $("#Lab_NoLab").val();
    console.log("x",x)
    if (x != '') {
        var variable = 'New';
        var color = 'grey';
        document.getElementById("btnSelesai").disabled = false;
        document.getElementById("btnAddDetail").disabled = false;
    }
    if (data.st_received == '1') {
        var variable = 'RECEIVE';
        var color = '#00fff2';
        document.getElementById("btnSelesai").disabled = true;
        document.getElementById("btnAddDetail").disabled = true;
    }
    if (data.st_proces == '1') {
        var variable = 'PROCESSING';
        var color = 'yellow';
        document.getElementById("btnSelesai").disabled = true;
        document.getElementById("btnAddDetail").disabled = true;
    }
    if (data.Result == '1') {
        var variable = 'SUDAH ADA HASIL';
        var color = 'green';
        document.getElementById("btnSelesai").disabled = true;
        document.getElementById("btnAddDetail").disabled = true;
    }
    // console.log(data.st_received,data.st_proces,data.Result,'xxxx');
    $("#status_span").text(variable).css('background-color', color);
}
function updateUIdatagetDataTblLabHeader(data) {
    $("#Lab_RecID").val(data.RecID);
    $("#Lab_NoLab").val(data.NoLAB);
    $("#Lab_Daignosa").val(data.Diagnosa);
    $("#Lab_Keterangan_Klinik").val(data.KeteranganKlinis);
    $("#Lab_TglPeriksa").val(data.LabDate);
    $("#is_batal").val("0");
    FormReadonlyFalse();
    document.getElementById("btnnewtransaksi").disabled = true;
    document.getElementById("btnAddDetail").disabled = false;
    ShowDataTblLabDetil();
    $("#modalCariDataListOrderLab").modal('hide');
    //cekstatus(data.NoLAB);
}
function getDataTblLabHeader(idLab) {
    var idLab = idLab;
    var url2 = "/SIKBREC/public/aorderLaboratorium/getDataTblLabHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'q=' + idLab
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
async function goFinishOrderLab(param) {
    try {
        $(".preloader").fadeIn();
        window.onbeforeunload = null;
        const dataFinishOrderLaboratorium = await FinishOrderLaboratorium(param);
        console.log("dataFinishOrderLaboratorium", dataFinishOrderLaboratorium);
        updateUIFinishOrderLaboratorium2(dataFinishOrderLaboratorium);
        $(".preloader").fadeOut();
        toast("Pemeriksaan Berhasil Disimpan !", "success")
        if (param == '0'){
            MyBack();
        }
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIFinishOrderLaboratorium2(data) {
    if (data.status == "warning") {
        toast(data.errorname, "error")
    } else if (data.status == "warningreceive") {
        $("#modal_alert_verifdetail").modal('show');
    } else if (data.status == "success") {
        toast("Pemeriksaan Berhasil Disimpan !", "success")
        //$("#modal_alert_konfirmasi_payment").modal('show');
        // MyBack();

    }
}
function MyBack() {
    const base_url = window.location.origin;
    let nomr = $("#Lab_NoMR").val();
    var iswalkin = nomr.includes("W");
    if (iswalkin){
        var page = "aRegistrasiWalkin";
    }else{
        var page = "aRegistrasiRajal";
    }
    window.location = base_url + "/SIKBREC/public/"+page+"/list";
}
function FinishOrderLaboratorium(param) {
    var Lab_NoLab = $("#Lab_NoLab").val();
    var Lab_kodeTes_2 = $("#Lab_kodeTes_2").val();
    var Lab_Nilai = $("#Lab_Nilai").val();
    var Lab_kodeTes_kelompok = $("#Lab_kodeTes_kelompok").val();
    var Lab_NORegistrasi = $("#Lab_NORegistrasi").val();
    var Lab_Daignosa = $("#Lab_Daignosa").val();
    var Lab_Keterangan_Klinik = $("#Lab_Keterangan_Klinik").val();
    var Lab_Namajaminan = $("#Lab_Namajaminan").val();
    var Lab_Dokter_Operator = $("#Lab_Dokter_Operator").val();
    var Lab_TglKunjungan = $("#Lab_TglKunjungan").val();
    var url2 = "/SIKBREC/public/aorderLaboratorium/FinishOrderLaboratorium";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   "Lab_NoLab=" + Lab_NoLab + "&Lab_kodeTes_2=" + Lab_kodeTes_2 + "&Lab_Nilai=" + Lab_Nilai +
                "&Lab_kodeTes_kelompok=" + Lab_kodeTes_kelompok + "&Lab_NORegistrasi=" + Lab_NORegistrasi +
                "&Lab_Daignosa=" + Lab_Daignosa + "&Lab_Keterangan_Klinik=" + Lab_Keterangan_Klinik +
                "&Lab_Namajaminan=" + Lab_Namajaminan + "&Lab_Dokter_Operator=" + Lab_Dokter_Operator + "&Lab_TglKunjungan=" + Lab_TglKunjungan + "&is_approved=" + param
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
async function deleteDetilOrderLab() {
    try {
        $(".preloader").fadeIn();
        const datadeleteDetilPemeriksaanOrderLab = await deleteDetilPemeriksaanOrderLab();
        console.log("datadeleteDetilPemeriksaanOrderLab", datadeleteDetilPemeriksaanOrderLab);
        updateUIdeleteDetilPemeriksaanOrderLab(datadeleteDetilPemeriksaanOrderLab);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdeleteDetilPemeriksaanOrderLab(data) {
    console.log("dataaaa", data)
    if (data.status == "warning") {
        toast(data.errorname, "error")
    } else if (data.status == "warningreceive") {
        $("#modal_alert_verifdetail").modal('show');
    } else if (data.status == "success") {
        toast("Pemeriksaan Berhasil DiHapus !", "success")
        ShowDataTblLabDetil();
        $("#modal_alert_bataldetil").modal('hide');

    }
}
function deleteDetilPemeriksaanOrderLab() {
    var NoDetilOrder = $("#NoDetilOrder").val();
    var alasanbatalDetil = $("#alasanbatalDetil").val(); 
    var Lab_NoLab = $("#Lab_NoLab").val();
    var url2 = "/SIKBREC/public/aorderLaboratorium/deleteDetilPemeriksaanOrderLab";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoDetilOrder=" + NoDetilOrder + "&alasanbatalDetil=" + alasanbatalDetil 
            + "&Lab_NoLab=" + Lab_NoLab
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
async function addDetilPemeriksaanLaboratoriuma() {
    try {
        $(".preloader").fadeIn();
        const dataaddDetilPemeriksaanLaboratoriums = await addDetilPemeriksaanLaboratorium();
        updateUIdataaddDetilPemeriksaanLaboratoriums(dataaddDetilPemeriksaanLaboratoriums);
        console.log("dataaddDetilPemeriksaanLaboratoriums", dataaddDetilPemeriksaanLaboratoriums);
       
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataaddDetilPemeriksaanLaboratoriums(data) {
    console.log("dataaaa", data)
    if (data.status == "warning") {
        toast(data.errorname,"error")
    } else if (data.status == "warningreceive") {
        $("#modal_alert_verifdetail").modal('show');
    } else if (data.status == "success") {
        toast("Pemeriksaan Berhasil ditambahkan !" ,"success")
        ShowDataTblLabDetil();
    }
}
function ShowDataTblLabDetil() {
    var Lab_NoLab = $("#Lab_NoLab").val();
    var base_url = window.location.origin;
    $('#table-id').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#table-id').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aorderLaboratorium/getListPemeriksaanLaboratoriumByNoLab/",
            "type": "POST",
            "data": { Lab_NoLab: Lab_NoLab },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.No + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.IDTes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaTes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Tarif + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" id="btndelete" name="btndelete" class="btn btn-danger border-danger btn-animated btn-wide"  onclick="DelKonfirmasiDetail(' + row.IDTes + ')" ><span class="visible-content" >Delete</span><span class="hidden-content"><i class="fa fa-trash"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function cekStatus() {
    var Lab_NoLab = $("#Lab_NoLab").val();
    var url2 = "/SIKBREC/public/aorderLaboratorium/cekStatusOrderLab";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Lab_NoLab=" + Lab_NoLab
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
function DelKonfirmasiDetail(row_id) {
    $("#NoDetilOrder").val(row_id);
    $("#modal_alert_bataldetil").modal('show');
}
function showModalDel() {
    var NoJurnal = $("#Lab_NoLab").val();
    $("#NoLabOrderBatal").val(NoJurnal);
    $("#modal_alert_batalOrder").modal('show');
}
function addDetilPemeriksaanLaboratorium() {
    var Lab_NoLab = $("#Lab_NoLab").val();
    var Lab_kodeTes_2 = $("#Lab_kodeTes_2").val();
    var Lab_Nilai = $("#Lab_Nilai").val();
    var Lab_kodeTes_kelompok = $("#Lab_kodeTes_kelompok").val();
    var Lab_Dokter_Operator = document.getElementById("Lab_Dokter_Operator").value;

    var url2 = "/SIKBREC/public/aorderLaboratorium/addDetilPemeriksaanLaboratorium";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   "Lab_NoLab=" + Lab_NoLab + "&Lab_kodeTes_2=" + Lab_kodeTes_2 + "&Lab_Nilai=" + Lab_Nilai +
                "&Lab_kodeTes_kelompok=" + Lab_kodeTes_kelompok + "&Lab_Dokter_Operator=" + Lab_Dokter_Operator
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
async function addnewHeader() {
    try {
        $(".preloader").fadeIn();
        const datacreateHeaderOrderLaboratorium = await createHeaderOrderLaboratorium();
        updateUIdatacreateHeaderOrderLaboratorium(datacreateHeaderOrderLaboratorium);
        console.log("datacreateNewHeader", datacreateHeaderOrderLaboratorium);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeaderOrderLaboratorium(data) {
    
    if (data.status == "success"){
        $("#is_batal").val("0");
        $("#Lab_RecID").val(data.RecID);
        $("#Lab_NoLab").val(data.NoLab);
        FormReadonlyFalse();
        document.getElementById("btnAddDetail").disabled = false;
        document.getElementById("btnnewtransaksi").disabled = true;
        toast("silahkan Input Pemeriksaan !", "success")
    }  
}
function createHeaderOrderLaboratorium() {
    var Lab_NoEpisode = $("#Lab_NoEpisode").val();
    var Lab_NORegistrasi = $("#Lab_NORegistrasi").val();
    var Lab_NoMR = $("#Lab_NoMR").val();
    var Lab_Doctor = document.getElementById("Lab_Dokter_Operator").value;
    var Lab_Daignosa = $("#Lab_Daignosa").val();
    var Lab_Keterangan_Klinik = $("#Lab_Keterangan_Klinik").val();
    var Lab_TglKunjungan = $("#Lab_TglKunjungan").val();
    var url2 = "/SIKBREC/public/aorderLaboratorium/createHeaderOrderLaboratorium";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Lab_NoEpisode=" + Lab_NoEpisode + "&Lab_NORegistrasi=" + Lab_NORegistrasi + "&Lab_NoMR=" + Lab_NoMR +
            "&Lab_Doctor=" + Lab_Doctor + "&Lab_Keterangan_Klinik=" + Lab_Keterangan_Klinik + "&Lab_Daignosa=" + Lab_Daignosa + "&Lab_TglKunjungan=" + Lab_TglKunjungan
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
async function getTarifLaboratorium() {
    try {
        const datagetDataPemeriksaanLabByID = await getDataPemeriksaanLabByID();
        updatedatagetDataPemeriksaanLabByID(datagetDataPemeriksaanLabByID);
        console.log("datagetDataPemeriksaanLabByID", datagetDataPemeriksaanLabByID);
    } catch (err) {
        toast(err, "error")
    }
}
function updatedatagetDataPemeriksaanLabByID(data) {
    $("#Lab_Nilai").val(data.Tarif);
    $("#Lab_kodeTes_2").val(data.IDTes);
    $("#Lab_kodeTes_kelompok").val(data.KodeKelompok);
}
function getDataPemeriksaanLabByID() {
    var Lab_kodeTes = document.getElementById("Lab_kodeTes").value;
    var url2 = "/SIKBREC/public/MasterDataTarif/getDataPemeriksaanLabByID";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Lab_kodeTes=' + Lab_kodeTes
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
            $("#Lab_kodeTes").select2();
        })
}
async function onLoadFunctionAll() {
    try {
        const datagetDokterLaboratorium = await getDokterLaboratorium();
        const dataGetregistrasiRajalbyNoRegistrasi = await GetregistrasiRajalbyNoRegistrasi();
        updatedatagetDokterLaboratorium(datagetDokterLaboratorium);
        updateUIdataGetregistrasiRajalbyNoRegistrasi(dataGetregistrasiRajalbyNoRegistrasi);
        const dataGetGroupJaminan = await GetGroupJaminan(dataGetregistrasiRajalbyNoRegistrasi.PatientType, dataGetregistrasiRajalbyNoRegistrasi.Perusahaanid);
        const datagetDataPemeriksaanLab =  await getDataPemeriksaanLab(dataGetGroupJaminan.Group_Jaminan);
        updateUIdatagetDataPemeriksaanLab(datagetDataPemeriksaanLab);
        //console.log("datagetDataPemeriksaanLab", datagetDataPemeriksaanLab);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDataPemeriksaanLab(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Lab_kodeTes").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaTes + ' - ' + number_to_price(responseApi.data[i].Tarif)  + '</option>';
            $("#Lab_kodeTes").append(newRow);
        }
    }
}
function getDataPemeriksaanLab(Group_Jaminan) {
    var url2 = "/SIKBREC/public/MasterDataTarif/GetTarifLaboratorium";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Group_Jaminan=' + Group_Jaminan 
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
             $("#Lab_kodeTes").select2();
        })
}
function GetGroupJaminan(PatientType, Perusahaanid) {
    var url2 = "/SIKBREC/public/MasterDataGroupJaminan/GetJaminanByIdJaminan";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'grupJaminanId=' + PatientType + '&namajaminanId=' + Perusahaanid
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
function updateUIdataGetregistrasiRajalbyNoRegistrasi(data) {
    $("#Lab_NORegistrasi").val(data.NoRegistrasi);
    $("#Lab_NoEpisode").val(data.NoEpisode);
    $("#Lab_NamaPasien").val(data.PatientName);
    $("#Lab_NoMR").val(data.NoMR); 
    $("#Lab_Doctor").val(data.Doctor1);
    $("#Lab_Namajaminan").val(data.Perusahaan);
    $("#Lab_TglKunjungan").val(data.VisitDate+' '+data.JamDate);
    
}
function GetregistrasiRajalbyNoRegistrasi() {
    var NoRegistrasi = $("#Lab_NORegistrasi").val();
    var res = NoRegistrasi.substr(0, 2);
    if (res == 'RI') {
        //var url2 = "controller/EMR/exec_Order_Radiologi.php?action=ShowDataPasienRanapbyNoReg";
        var url2 = "/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyNoRegistrasiRI";
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
function updatedatagetDokterLaboratorium(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Lab_Dokter_Operator").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].First_Name + '</option';
            $("#Lab_Dokter_Operator").append(newRow);
        }
    }
}
function getDokterLaboratorium() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDokterLaboratorium';
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
            $("#Lab_Dokter_Operator").select2();
        })
}
function FormReadonly() {
    document.getElementById("Lab_kodeTes").disabled = true;
}
function FormReadonlyFalse() {
    document.getElementById("Lab_kodeTes").disabled = false;
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
        goFinishOrderLab('1');
        toast(data.message, "success")
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
    var JenisTrs = 'LAB';
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&JenisTrs=' + JenisTrs
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
//     var JenisTrs = 'LAB';
//     var base_url = window.location.origin;
//     let url = base_url + url2;
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: form + '&JenisTrs=' + JenisTrs
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
    var pkuitansi_notrs = $("#Lab_NORegistrasi").val();
    var jeniscetakan = 'RINCIANBIAYA_RJ';
    var noregistrasi = $("#Lab_NORegistrasi").val();
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
    var NoRegistrasi = $("#Lab_NORegistrasi").val();
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