$(document).ready(function () {
    onLoadFunctionAll();
    $("#Jenis_Request").attr("disabled", true);
    $("#Unit_Request").attr("disabled", true);

    
    $("#PO_KodeSupplierx").prop("disabled", true);

    //showDataDetil_PO('TPO290520240001');
    $("#Jenis_Request").select2();
    $('#datatable_pr').dataTable({})

    $('#btnSearching').click(function () {
        $('#btnSearching_modal').modal('show');
    });

    $('#btnprint').click(function () {
        $('#notif_Cetak').modal('show');
    });

    $(document).on('click', '#cetakan', function () {
        var No_Transaksi = $("#No_Transaksi").val();
        if (No_Transaksi == ''){
              toast('No Transaksi Tidak Ditemukan !', "warning")
              return false
        }
        CetakDO(No_Transaksi);
    });


    // $(document).on('click', '#btnNewTransaksi', function () {
    //     window.onbeforeunload = null;
    //     addHeaderPurchaseOrder();
    // });

    $('#btnNewTransaksi').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Buat Transaksi Baru?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    addHeaderDeliveryOrder();
                } else {
                    swal("Transaction Rollback !");
                }
            });

    });
    $('#btnSimpan').click(function () {
        swal({
            title: "Simpan",
            text: "Pastikan Data yang dimasukan sudah sesuai, Lanjut Simpan?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //goFinishPurchaseOrder();
                    goFinishEditDeliveryOrder();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });

    $('#btn_batal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                // swal(`You typed: ${value}`);
                goVoidDeliveryOrder(value);
            });
    });

    // $('#remove_details').click(function () {
    //     swal("Alasan Hapus:", {
    //         content: "input",
    //         buttons:true,
    //       })
    //       .then((value) => {
    //           if (value == '' ){
    //             swal("Alasan Hapus Harus Diisi ! Simpan Gagal !");
    //             return false;
    //           }else if (value == null){
    //             return false;
    //           }
    //        // swal(`You typed: ${value}`);
    //        goVoidPurchaseOrderDetailsByID(value);
    //       });
    // });



    $('#btnbatal').click(function () {
        var PO_NoTrs = $("#PO_NoTrs").val();
        $("#noPoBatalHdr").val(PO_NoTrs);
    });

    $('#btnClose').click(function () {
        window.onbeforeunload = null;
        MyBack();
    });

    $(".preloader").fadeOut();

});
// async function goFinishPurchaseOrder() {
//     try {
//         $(".preloader").fadeIn();
//         const datagoFinishPurchaseOrder2 = await goFinishPurchaseOrder2();
//         //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
//         updateUIdatagoFinishPurchaseOrder2(datagoFinishPurchaseOrder2);
//     } catch (err) {
//         toast(err, "error")
//     }
// }


async function goVoidDODetailsByID(product_code, param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidDODetailsByID2 = await goVoidDODetailsByID2(product_code, param);
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoVoidDODetailsByID2(datagoVoidDODetailsByID2);
    } catch (err) {
        toast(err, "error")
    }
}

async function goVoidDeliveryOrder(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidDeliveryOrder = await goVoidDeliveryOrder2(param);
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoFinishDeliveryOrder2(datagoVoidDeliveryOrder);
    } catch (err) {
        toast(err, "error")
    }
}

async function goFinishEditDeliveryOrder() {
    try {
        if ($("#JenisPembayaran").val() == 'KREDIT' && $("#DateTempo").val() == ''){
            toast('Tgl jatuh tempo kosong !' ,'error');
            return false;
        }
        $(".preloader").fadeIn();

        //$(".preloader").fadeIn();
        const datagoEditFinishDeliveryOrder3 = await goEditFinishDeliveryOrder3();
        updateUIdatagoFinishDeliveryOrder2x(datagoEditFinishDeliveryOrder3);

        
        const datagoEditFinishDeliveryOrder2 = await goEditFinishDeliveryOrder2();
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoFinishDeliveryOrder2(datagoEditFinishDeliveryOrder2);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinishDeliveryOrder2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    } else {
        toast(data.message, "error")
    }
}

function updateUIdatagoFinishDeliveryOrder2x(data) {
    if (data.status == true) {
        toast(data.message, "success");
    } else {
        toast(data.message, "error")
    }
}

function updateUIdatagoVoidDODetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_DO($("#No_Transaksi").val());
    } else {
        toast(data.message, "error")
    }
}

function goVoidDODetailsByID2(product_code, param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var No_PurchasingOrder = document.getElementById("No_PurchasingOrder").value;
    var Unit = document.getElementById("Unit").value;
    var url2 = "/SIKBREC/public/DeliveryOrder/voidDeliveryOrderDetailbyItem";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&product_code=" + product_code + "&Unit=" + Unit + "&No_PurchasingOrder=" + No_PurchasingOrder
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

function goVoidDeliveryOrder2(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var Unit = document.getElementById("Unit").value;
    var No_PurchasingOrder = document.getElementById("No_PurchasingOrder").value;
    var url2 = "/SIKBREC/public/DeliveryOrder/goVoidDeliveryOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&Unit=" + Unit + "&No_PurchasingOrder=" + No_PurchasingOrder
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

function goFinishPurchaseOrder2() {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var data = $("#user_form").serialize();
    var url2 = "/SIKBREC/public/purchase/goFinishPurchaseOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data + "&TransactionCode=" + No_Transaksi
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

function goEditFinishDeliveryOrder3() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/DeliveryOrder/goFinishDeliveryOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
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

function goEditFinishDeliveryOrder2() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/DeliveryOrder/goFinishEditDeliveryOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
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
function updateUIdatagetDeliveryOrderHeader(data) {
    if (data.status == true) {
        //ShowDetailPRbyID(data.data[0].PurchaseReqCode);
        //toast(data.message , 'success');
        // document.getElementById("PO_HDR_Qty").innerHTML = number_to_price(data.FN_TTL_QTY_PO);
        // document.getElementById("PO_HDR_Subtotal").innerHTML = number_to_price(data.FN_SUBTOTAL);
        // document.getElementById("PO_HDR_TaxRp").innerHTML = number_to_price(data.FN_TAX_RP);
        // document.getElementById("PO_HDR_Total").innerHTML = number_to_price(data.FN_TOTAL);
        // data.data[0].PurchaseDate = new Date()
        // var date = data.data[0].PurchaseDate.toISOString().split('T')[0]
        var tgltrs = data.data[0].DeliveryOrderDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        $('#Tgl_Transaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
        // $("#axPO_JenisPurchase").val(data.data[0].TipePO).trigger('change');
    
        $("#No_PurchasingOrder").val(data.data[0].PurchaseOrderCode);
        //$("#Tgl_Transaksi").val(date);
        $("#User_Request").val(data.data[0].NamaUser);
        $("#Keterangan_PO").val(data.data[0].Notes);
        $("#PO_KodeSupplier").val(data.data[0].SupplierCode);
        $("#Unit").val(data.data[0].UnitCode);
        $("#JenisDelivery").val(data.data[0].JenisDelivery);
        $("#axPO_JenisPurchase").val(data.data[0].TipePO);
        $("#axPO_JenisPurchasex").val(data.data[0].TipePO).trigger('change')
        showDataDetil_DO(data.data[0].TransactionCode);
        unlockBtnCreate();

        
        
        $("#Unitx").val(data.data[0].UnitCode).trigger('change');
        $("#PO_KodeSupplierx").val(data.data[0].SupplierCode).trigger('change');
        $("#Unitx").prop("disabled", true);
        $("#Tgl_Transaksi").attr('readonly', true)
        $("#JenisDelivery").attr('readonly', true)
        $('#JenisDelivery option:not(:selected)').prop('disabled', true)

        $("#grandtotalqty").val(data.data[0].TotalQtyDO);
        //$("#diskonxRp").val(data.data[0].TotalQtyDO);diskon tidak ada di api
        $("#subtotalttlrp").val(data.data[0].SubtotalDelivery);
        $("#taxxRp").val(data.data[0].TaxDelivery);
        $("#grandtotalxl").val(data.data[0].GrandtotalDelivery);

        $("#grandtotalqty_tmp").text(number_to_price(data.data[0].TotalQtyDO));
        $("#subtotalttlrp_tmp").text(number_to_price(data.data[0].SubtotalDelivery));
        $("#taxxRp_tmp").text(number_to_price(data.data[0].TaxDelivery));
        $("#grandtotalxl_tmp").text(number_to_price(data.data[0].GrandtotalDelivery));
        $("#JenisPembayaran").val(data.data[0].JenisPembayaran);
        $("#DateTempo").val(data.data[0].DateTempo);
        if (data.data[0].JenisPembayaran == 'KREDIT'){
            $("#DateTempo").prop('readonly',true)
        }else{
            $("#DateTempo").prop('readonly',false)
        }

        $("#btnSearching").attr('disabled', true);

        //$("#PO_JenisPurchase").val(data.TIPE_PO).trigger('change');
        // if (data.status == "successDo") {
        //     disableForm();
        //     document.getElementById("btnNewTransaksi").disabled = true;
        //     toast(data.Pesan, "error")
        // }
        //enableForm();

    } else {
        //disableForm();
        toast(data.message, 'warning');
    }

    // await disableForm();
}
function getDeliveryOrderHeader() {
    var NoTrs = document.getElementById("No_Transaksi").value;
    var url2 = "/SIKBREC/public/DeliveryOrder/getDeliveryOrderHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTrs=" + NoTrs
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
async function addHeaderDeliveryOrder() {
    try {
        $(".preloader").fadeIn();
        const datacreateHeaderDeliveryOrder = await createHeaderDeliveryOrder();
        updateUIdatacreateHeader(datacreateHeaderDeliveryOrder);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeader(params) {

    if (params.status === true) {
        swal({
            title: "Success",
            text: 'Berhasil Membuat Transaksi Baru!',
            icon: "success",
        });
        toast(params.message, "success");
        $("#No_Transaksi").val(params.data)
        unlockBtnCreate();
        showDataDetil_PO($("#No_PurchasingOrder").val());
        //MyBack();
    } else {
        toast(params.message, "error")
    }

}
function createHeaderDeliveryOrder() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/DeliveryOrder/createHeaderDeliveryOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate=" +TransasctionDate
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
// function disableForm() {
//     document.getElementById("btnSimpan").disabled = true;
//     document.getElementById("btnbatal").disabled = true;
//     document.getElementById("btnClose").disabled = true;
//     document.getElementById("Po_SrcBarang").disabled = true;
//     document.getElementById("PO_Harga").disabled = true;
//     document.getElementById("PO_DiscProsen").disabled = true;
//     document.getElementById("PO_TaxProsen").disabled = true;
//     document.getElementById("PO_Qty").disabled = true;
// }
// function enableForm() {
//     document.getElementById("btnSimpan").disabled = false;
//     document.getElementById("btnbatal").disabled = false;
//     document.getElementById("btnClose").disabled = false;
//     document.getElementById("Po_SrcBarang").disabled = false;
//     document.getElementById("PO_Harga").disabled = false;
//     document.getElementById("PO_DiscProsen").disabled = false;
//     document.getElementById("PO_TaxProsen").disabled = false;
//     document.getElementById("PO_Qty").disabled = false;
//     document.getElementById("PO_KodeSupplier").disabled = true;
//     document.getElementById("PO_JenisPurchase").disabled = true;
//     document.getElementById("btnNewTransaksi").disabled = true;

// }
async function onLoadFunctionAll() {
    try {

        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        if ($("#No_Transaksi").val() != '') {
            const datagetDeliveryOrderHeader = await getDeliveryOrderHeader();
            updateUIdatagetDeliveryOrderHeader(datagetDeliveryOrderHeader);
        }
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#PO_KodeSupplierx").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#PO_KodeSupplierx").append(newRow);
        }
    }
}
function getSuppliers() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPurchaseOrder/getSuppliers';
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
            $("#PO_KodeSupplierx").select2();
        })
}


function ShowApprovedPObyDate() {
    var tglawal_pr = $("#tglawal_pr").val();
    var tglakhir_pr = $("#tglakhir_pr").val();

    if (tglawal_pr == '') {
        toast('Silahkan Isi Periode Awal !', 'warning')
        return false;
    }

    if (tglakhir_pr == '') {
        toast('Silahkan Isi Periode Akhir !', 'warning')
        return false;
    }
    var base_url = window.location.origin;
    $('#datatable_pr').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_pr').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/purchase/getPurchaseOrderbyPeriode",
            //"url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyDateUser",
            "type": "POST",
            "data": {
                tglawal_pr: tglawal_pr,
                tglakhir_pr: tglakhir_pr
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PurchaseCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PurchaseDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUserCreate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Notes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.TipePO == '1') {
                        var Jenis = 'FARMASI';
                    } else if (row.TipePO == '2') {
                        var Jenis = 'LOGISTIK';
                    } else {
                        var Jenis = '';
                    }
                    var html = '<font size="1"> ' + Jenis + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                        var html = 'Total Barang: '+row.TotalRowPO+'<br>Total Qty: '+row.TotalQtyPO+'<br>Subtotal Purchase: '+new Intl.NumberFormat("id-ID", {style: "currency", currency: "IDR"}).format(row.SubtotalPurchase);
                   
                    //var html = '<span class="badge badge-'+element+'">'+row.StatusPR+'</span>'
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> Approve 1: ' + row.NamaUserApproved_1 + ' </font> <br> <font size="1"> Approve 2: ' + row.NamaUserApproved_2 + ' </font> <br> <font size="1"> Approve 3: ' + row.NamaUserApproved_3 + ' </font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""

                     if (row.UserApproved_1 != ' ' && row.UserApproved_2 != ' ' && row.UserApproved_3 != ' '){
                        var approve = '';
                     }else{
                        var approve = 'disabled';
                    }
                    var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDetailPObyID("' + row.PurchaseCode + '") '+approve+'>Pilih</button>'
                    return html
                },
            },
        ]
    });
}

//GET HDR PR
async function ShowDetailPObyID(param) {
    try {
        $(".preloader").fadeIn();
        const dataGetPurchasebyId = await GetPurchasebyId(param);
        updateUIdataGetPurchasebyId(dataGetPurchasebyId);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGetPurchasebyId(params) {
    if (params.status === true) {
        // if (params.data[0].StatusPR == 'BELUM APPROVED'){
        //     toast('Request Belum Diapprove, Silahkan Approve Terlebih Dahulu !', 'warning');
        //     return false;
        // }
        $('#No_PurchasingOrder').val(params.data[0].PurchaseCode);
        $('#Tgl_Request').val(params.data[0].TransasctionDate);
        $('#User_Request').val(params.data[0].NamaUserCreate);
        $('#PO_KodeSupplier').val(params.data[0].SupplierCode);
        $('#Unit').val(params.data[0].Unit);
        $('#Keterangan_PO').val(params.data[0].Notes);
        
        $("#Unitx").val(params.data[0].Unit).trigger('change');
        $("#PO_KodeSupplierx").val(params.data[0].SupplierCode).trigger('change');
        $("#axPO_JenisPurchase").val(params.data[0].TipePO);
        $("#axPO_JenisPurchasex").val(params.data[0].TipePO).trigger('change')
        //$("#PO_KodeSupplier").select2("readonly", true);
        //$("#Unit").prop("readonly", true);
        //$('#Status').val(params.data[0].StatusPR); 
        //$('#Unit_Request').val(params.data[0].Unit).trigger('change');
        //$('#Jenis_Request').val(params.data[0].Type).trigger('change');
        unlockBtnCreate();

        $('#btnSearching_modal').modal('hide');
    } else {
        toast(params.message, "error")
    }
}
function GetPurchasebyId(TransasctionCode) {
    var base_url = window.location.origin;
    //var TransasctionCode = 'TPR160820220002'; 
    let url = base_url + '/SIKBREC/public/purchase/getPurchaseOrderHeader/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'PO_NoTrs=' + TransasctionCode
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
function calculateAllDetail(){
    var subtotal = 0;
    var grandtotal = 0;  
    var qtytotal = 0;
    var discrp = 0;
    var grandtotaldiskonrp = 0;
    var totalSubtotalAfterDiskon = 0;
    var grandtotaltax = 0;
    var grandtotalPurchase = 0;
    var grandtotalPurchase = 0;
    var taxrp = 0;
    var grantotalxloop = 0;
    var taxrp_stn = 0;
    var total_items = $('#totalrow').val(); 
    for (i = 1; i <= total_items; i++) {
       
        
        qtyx = document.getElementById("hidden_min_barang_" + i);

        var qty = parseFloat(price_to_number($("#hidden_qty_barang_" + i).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_min_barang_" + i).val()));
        // disconprosen = document.getElementById("hidden_discpros_barang_" + i);
        var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + i).val()));
        //harga = document.getElementById("hidden_harga_barang_" + i);  
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + i).val()));
        // taxprosen = document.getElementById("hidden_taxprosen_" + i); 
        var taxprosen = parseFloat(price_to_number($("#hidden_taxprosen_" + i).val()));

        var konversiqty = $("#konversi_qty_" + i).val()

        if (typeof qtyx === 'undefined' || qtyx === null) {
            alert("No such item - " + "hidden_min_barang_" + i); 
        } else {
            if (qty > qtymr) {
                toast('Qty PO Lebih Besar daripada Qty Sisa MR !', 'warning'); 
                $("#hidden_qty_barang_"+i).val(0);
                return false;
            } else  { 
            
        if (konversiqty > 1){
            var konversiqty_total = konversiqty * qty;
            // discrp = ((parseFloat(disconprosen) * parseFloat(harga)) / 100) / konversiqty_total; 
            discrp = ((parseFloat(disconprosen) * parseFloat(harga)) / 100); 
            // subtotal = (parseFloat(harga)/konversiqty_total - discrp) * konversiqty_total;
            subtotal = ((parseFloat(harga) - discrp) * qty);
            console.log(subtotal,i);
            hargamindiskonTok = (parseFloat(harga) - discrp);
            // totaldiskonrp = discrp*konversiqty_total;
            totaldiskonrp = discrp*qty;
            // taxrp_stn = (parseFloat(harga)/konversiqty_total-discrp)*parseFloat(taxprosen)/100;
            taxrp_stn = (parseFloat(harga)-discrp) * parseFloat(taxprosen) /100;
            console.log("xx" , "harga : " + harga + " discrp : " + discrp + " taxprosen : " + taxprosen  
                + " taxprosens : " + (parseFloat(harga)-discrp)  
                + " taxprosens : " + ((parseFloat(harga)-discrp)  * parseFloat(taxprosen) )
                + " taxprosen : " + taxrp_stn );
            taxrp = taxrp_stn * qty;
        }else{
            var konversiqty_total = 1;
            discrp = (parseFloat(disconprosen) * parseFloat(harga)) / 100; 
            subtotal = (parseFloat(harga) - discrp) * qty;
            hargamindiskonTok = (parseFloat(harga) - discrp);
            totaldiskonrp = discrp*qty;
            taxrp_stn = (parseFloat(taxprosen)*hargamindiskonTok)/100;
            taxrp = (parseFloat(taxprosen)*subtotal) / 100;
        }

                //subtotal = parseFloat(harga) * qty;
                // hargamindiskon = (parseFloat(disconprosen) * parseFloat(harga)) / 100; 
                // subtotal = (parseFloat(harga) - hargamindiskon) * qty;
                // hargamindiskonTok = (parseFloat(harga) - hargamindiskon);
                // totaldiskonrp = hargamindiskon*qty;

                //hargamindiskon = ((parseFloat(disconprosen) * parseFloat(harga)) / 100) / konversiqty_total; 
                //subtotal = (parseFloat(harga) - hargamindiskon) * qty;

                //subtotal = (parseFloat(harga)/konversiqty_total - hargamindiskon) * konversiqty_total;
                //hargamindiskonTok = (parseFloat(harga) - hargamindiskon);
                //totaldiskonrp = hargamindiskon*(qty*konversiqty_total);

                grandtotaldiskonrp = grandtotaldiskonrp + totaldiskonrp;

               
                qtytotal = qtytotal + parseFloat(qty);
                totalSubtotalAfterDiskon = subtotal+totalSubtotalAfterDiskon;
                
                //taxrp_stn = (parseFloat(harga)/konversiqty_total-hargamindiskon)*parseFloat(taxprosen)/100;
                //taxrp = taxrp_stn * qty;
                
                grandtotal = subtotal + parseFloat(taxrp);
                grandtotaltax = grandtotaltax + taxrp;
                grandtotalPurchase = subtotal + taxrp;
                grantotalxloop = grantotalxloop + grandtotalPurchase;
                //taxrp_stn = (parseFloat(taxprosen)*hargamindiskonTok)/100;
                //console.log("taxrp_stn",taxrp_stn + ' ' + hargamindiskon + ' '  + parseFloat(taxprosen) + ' ' +parseFloat(disconprosen) + ' ' + parseFloat(harga));
            }
            $("#hidden_discrpttl_barang_" + i).val(number_to_price(totaldiskonrp));
            $("#hidden_discrp_barang_" + i).val(number_to_price(discrp));
            $("#hidden_subtotal_" + i).val(number_to_price(subtotal));
            //$("#grandtotalqty" + i).val(number_to_price(qtytotal));
            $("#hidden_taxrp_" + i).val(number_to_price(taxrp));
            $("#hidden_taxrp2_" + i).val(number_to_price(taxrp_stn));
            $("#hidden_grandtotal_" + i).val(number_to_price(grandtotalPurchase));
            $("#hidden_harga_barang_" + i).val(number_to_price(harga));
 

        }
        $("#diskonxRp").val(number_to_price(grandtotaldiskonrp));
        $("#grandtotalqty").val(number_to_price(qtytotal));
        $("#subtotalttlrp").val(number_to_price(totalSubtotalAfterDiskon));
        $("#taxxRp").val(number_to_price(grandtotaltax));
        $("#grandtotalxl").val(number_to_price(grantotalxloop));

        $("#diskonxRp_tmp").text(number_to_price(grandtotaldiskonrp));
        $("#grandtotalqty_tmp").text(number_to_price(qtytotal));
        $("#subtotalttlrp_tmp").text(number_to_price(totalSubtotalAfterDiskon));
        $("#taxxRp_tmp").text(number_to_price(grandtotaltax));
        $("#grandtotalxl_tmp").text(number_to_price(grantotalxloop));
    }
}
 
//GET DTL PR
function showDataDetil_DO(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    // var TransasctionCode = "TPR160820220002"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/DeliveryOrder/getDeliveryOrderDetailbyID/";
    
    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                //convert titik jadi koma
                converted_discprosen = val.DiscountProsen.replace(".", ",");
                converted_discrp = val.DiscountRp.replace(".", ",");
                converted_discrpttl = val.DiscountRpTTL.replace(".", ",");
                converted_sbttl = val.SubtotalDeliveryOrder.replace(".", ",");
                converted_taxprosen = val.TaxProsen.replace(".", ",");
                converted_taxrp = val.TaxRp.replace(".", ",");
                converted_taxrpttl = val.TaxRpTTL.replace(".", ",");
                converted_total = val.TotalDeliveryOrder.replace(".", ",");

                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
                /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ><input type='hidden' name='satuan_konversi_[]' id='satuan_konversi_'" + total_items +"' value='" + val.Satuan_Konversi +"' ><input type='hidden' name='konversi_qty_[]' id='konversi_qty_" + total_items +"' value='" + val.KonversiQty +"' ></td> '"+
            /*5*/"' <td>" + parseFloat(val.QtyDeliveryRemain) + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + parseFloat(val.QtyDeliveryRemain) + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + parseFloat(val.QtyDeliveryRemain) +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga' onkeydown='FormatCell(this)' value='" + parseFloat(val.Price) + "' ></td> '"+
            /*7b*/"' <td><input size='5'  type='date' name='hidden_ed_[]'   id='hidden_ed_" + total_items + "' class='date' value='"+val.ExpiredDate+"'  ></td> '"+
            /*7c*/"' <td><input size='1'  type='text' name='hidden_nobatch_[]'   id='hidden_nobatch_" + total_items + "' class='hidden_nobatch_' value='"+val.NoBatch+"' ></td> '"+
            /*8*/"' <td><input size='1' readonly value='" + converted_discprosen + "' onkeydown='FormatCell(this)' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +"' ></td>'"+
            /*--9*/"' <td><input size='5' readonly='true' value='" + converted_discrp + "' type='hidden' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ><input size='5' readonly='true' value='" + converted_discrpttl + "' type='text' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td> '"+
            /*10*/"' <td><input size='7' readonly='true' value='" + converted_sbttl + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            /*11*/"' <td><input size='1' readonly value='" + converted_taxprosen + "' type='text' onkeydown='FormatCell(this)'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            /*--12*/"' <td><input size='5' readonly='true' value='" + converted_taxrpttl + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ><input size='5' readonly='true' value='" + converted_taxrp + "' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td> '"+
            /*13*/"' <td><input size='8' readonly='true'  value='" + converted_total + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus> " +
            "</td>  </tr>")
            ;


                dataHandler.append(newRow);
            });
            calculateAllDetail();
        }
    });

    $(".preloader").fadeOut();
}

//GET DTL PO
function showDataDetil_PO(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    // var TransasctionCode = "TPR160820220002"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/purchase/getPurchaseOrderDetailbyID/";

    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                //convert titik jadi koma
                converted_discprosen = val.DiscountProsen.replace(".", ",");
                converted_discrp = val.DiscountRp.replace(".", ",");
                converted_discrpttl = val.DiscountRpTTL.replace(".", ",");
                converted_sbttl = val.SubtotalPurchase.replace(".", ",");
                converted_taxprosen = val.TaxProsen.replace(".", ",");
                converted_taxrp = val.TaxRp.replace(".", ",");
                converted_taxrpttl = val.TaxRpTTL.replace(".", ",");
                converted_total = val.TotalPurchase.replace(".", ",");

                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ><input type='hidden' name='satuan_konversi_[]' id='satuan_konversi_'" + total_items +"' value='" + val.Satuan_Konversi +"' ><input type='hidden' name='konversi_qty_[]' id='konversi_qty_" + total_items +"' value='" + val.KonversiQty +"' ></td> '"+
            /*5*/"' <td>" + parseFloat(val.QtyPurchaseRemain) + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + parseFloat(val.QtyPurchaseRemain) + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + parseFloat(val.QtyPurchaseRemain) +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga' onkeydown='FormatCell(this)' value='" + parseFloat(val.Price) + "' ></td> '"+
            /*7b*/"' <td><input size='5'  type='date' name='hidden_ed_[]'   id='hidden_ed_" + total_items + "' class='date'  ></td> '"+
            /*7c*/"' <td><input size='1'  type='text' name='hidden_nobatch_[]'   id='hidden_nobatch_" + total_items + "' class='hidden_nobatch_'  ></td> '"+
            /*8*/"' <td><input size='1' readonly value='" + converted_discprosen + "' onkeydown='FormatCell(this)' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +"' ></td>'"+
            /*--9*/"' <td><input size='5' readonly='true' value='" + converted_discrp + "' type='hidden' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ><input size='5' readonly='true' value='" + converted_discrpttl + "' type='text' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td> '"+
            /*10*/"' <td><input size='7' readonly='true' value='" + converted_sbttl + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            /*11*/"' <td><input size='1' readonly value='" + converted_taxprosen + "' type='text' onkeydown='FormatCell(this)'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            /*--12*/"' <td><input size='5' readonly='true' value='" + converted_taxrpttl + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ></td> <input size='5' readonly='true' value='" + converted_taxrp + "' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td>'"+
            /*13*/"' <td><input size='8' readonly='true'  value='" + converted_total + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus> " +
                "</td>  </tr>")
                ;


                dataHandler.append(newRow);
            });
            calculateAllDetail();
            // CalculateQty();
            // CalculateItemsValueDiscon();
            // CalculateItemsValue();
            // CalculateItemsTax();

        }
    });

    $(".preloader").fadeOut();
}


function unlockBtnCreate() {
    if ($("#No_Transaksi").val() == '' && $("#No_PurchasingOrder").val() != '') {
        $("#btnNewTransaksi").attr('disabled', false);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);

    } else if ($("#No_Transaksi").val() == '' && $("#No_PurchasingOrder").val() == '') {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);
    } else {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', false);
        $("#btn_batal").attr('disabled', false);
        $("#btnSearching").attr('disabled', true);
    }
}


function goVoidDetails(product_code) {
    swal("Alasan Hapus:", {
        content: "input",
        buttons: true,
    })
        .then((value) => {
            if (value == '') {
                swal("Alasan Hapus Harus Diisi ! Simpan Gagal !");
                return false;
            } else if (value == null) {
                return false;
            }
            // swal(`You typed: ${value}`);
            goVoidDODetailsByID(product_code, value);
        });
}

function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        //console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unitx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#Unitx").append(newRow);
        }
    }
}
function GetLayanan() {
    var base_url = window.location.origin; 
 
    let url = base_url + '/SIKBREC/public/MasterDataUnit/getAllDataUnit';
    return fetch(url, {
        method: 'POST',
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
            $("#Unitx").select2();
        })
}

function CetakDO(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/DeliveryOrder/CetakDO/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
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
// function number_to_price(v) {
//     if (v == 0) { return '0,00'; }
//     v = parseFloat(v);
//     v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
//     v = v.split('.').join('*').split(',').join('.').split('*').join(',');
//     return v;
// }
// function price_to_number(v) {
//     if (!v) { return 0; }
//     v = v.split('.').join('');
//     v = v.split(',').join('.');
//     return Number(v.replace(/[^0-9.]/g, ""));
// }
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/DeliveryOrder/list";
}

function getID(e){
    $("#Unit").val(e.value);
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
    if (v == 0) { return '0'; }
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
function convertNumberToRp() {
    var Nominal = document.getElementById("Nominal");
    Nominal.addEventListener("keyup", function (e) {
        Nominal.value = formatRupiah(this.value);
    });
}

function converttoCurrency(number){
    var n = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 12 }).format(number);
    return n
}

function FormatCell(element){
    var elementid = document.getElementById(element.id);
    elementid.addEventListener("keyup", function (e) {
    elementid.value = formatRupiah(this.value);
    calculateAllDetail();
});
}

function goDateTempo(param){
    if (param == 'KREDIT'){
        goCalculateDateTempo($("#PO_KodeSupplier").val());
        $("#DateTempo").prop('readonly',true)
    }else{
        $("#DateTempo").val('')
        $("#DateTempo").prop('readonly',false)
    }
}

async function goCalculateDateTempo(param) {
    try {
        $(".preloader").fadeIn();
        const data = await getCalculateDateTempobyIDSupplier(param);
        updategetCalculateDateTempobyIDSupplier(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updategetCalculateDateTempobyIDSupplier(response) {
    if (response['status'] == 'success'){
        toast(response['message'],'success')
        $("#DateTempo").val(response['data']);
    }else{
        toast(response['message'],'warning')
    }
}
async function getCalculateDateTempobyIDSupplier(param) {
    var base_url = window.location.origin;
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    let url = base_url + '/SIKBREC/public/DeliveryOrder/getCalculateDateTempobyIDSupplier/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDSupplier=' + param + '&TransasctionDate=' + TransasctionDate
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