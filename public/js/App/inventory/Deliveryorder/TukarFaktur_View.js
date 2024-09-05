$(document).ready(function () {
    onLoadFunctionAll();
    $("#Jenis_Request").attr("disabled", true);
    $("#Unit_Request").attr("disabled", true);

    
    $("#PO_KodeSupplierx").prop("disabled", true);
    $("#Unitx").prop("disabled", true);

    //showDataDetil_DO('TDO130320240001');
    $("#Jenis_Request").select2();
    $('#datatable_pr').dataTable({})

    $('#btnSearching').click(function () {
        $('#btnSearching_modal').modal('show');
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
                    addHeader();
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
                    goFinishEdit();
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
                goVoidHeader(value);
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


async function goVoidPurchaseOrderDetailsByID(product_code, param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidPurchaseOrderDetailsByID = await goVoidPurchaseOrderDetailsByID2(product_code, param);
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoVoidPurchaseOrderDetailsByID2(datagoVoidPurchaseOrderDetailsByID);
    } catch (err) {
        toast(err, "error")
    }
}

async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidHeader2 = await goVoidHeader2(param);
        updateUIdatagoFinish(datagoVoidHeader2);
    } catch (err) {
        toast(err, "error")
    }
}

async function goFinishEdit() {
    try {
        $(".preloader").fadeIn();

        //$(".preloader").fadeIn();
        const datagoFinishDetil = await goFinishDetil();
        updateUIdatagoFinish(datagoFinishDetil);

        
        // const datagoEditFinish = await goEditFinish();
        // updateUIdatagoFinish(datagoEditFinish);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinish(data) {
    if (data.status == true) {
        toast(data.message, "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}

function updateUIdatagoVoidPurchaseOrderDetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_DO($("#No_Transaksi").val());
    } else {
        toast(data.message, "error")
    }
}

function goVoidPurchaseOrderDetailsByID2(product_code, param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var No_Request = document.getElementById("No_Request").value;
    var url2 = "/SIKBREC/public/TukarFaktur/voidFakturDetailbyItem";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&product_code=" + product_code + "&No_Request=" + No_Request
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

function goVoidHeader2(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var No_Request = document.getElementById("No_Request").value;
    var Unit = document.getElementById("Unit").value;
    var url2 = "/SIKBREC/public/TukarFaktur/goVoidHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi 
        + "&AlasanBatal=" + param 
        + "&No_Request=" + No_Request
        + "&Unit=" + Unit
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


function goFinishDetil() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_trs").value;
    var TglJatuhTempo = $("#TglJatuhTempo").val();
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/TukarFaktur/goFinishTukarFaktur";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
        +"&TglJatuhTempo="+TglJatuhTempo
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

function goEditFinish() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Trs").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var TglJatuhTempo = $("#TglJatuhTempo").val();
    var url2 = "/SIKBREC/public/TukarFaktur/goFinishEditTukarFaktur";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
                +"&TglJatuhTempo="+TglJatuhTempo
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
function updateUIdatagetTukarFakturHeader(data) {
        //CONVERT DATE
        var tgltrs = data[0].TransactionDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        $('#Tgl_trs').val(d.toISOString().substring(0,d.toISOString().length-1));

        //CONVERT DATE TO YYYY-MM-DD
        var d = new Date(data[0].DateFakturPBF),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;
        var dateconverted = [year, month, day].join('-');

        //$("#No_PurchasingOrder").val(data[0].PurchaseOrderCode);\
        $("#No_Request").val(data[0].DeliveryCode);
        $("#NoPurchaseOrder").val(data[0].PurchaseOrderCode);
        $("#Keterangan").val(data[0].Keterangan);
        $("#PO_KodeSupplier").val(data[0].SupplierCode);
        $("#Unit").val(data[0].UnitPembelian);
        $("#JenisDelivery").val(data[0].JenisDelivery);
        $("#NoFakturPBF").val(data[0].NoFakturPBF);
        $("#NoFakturPajak").val(data[0].NoFakturPajak);
        $("#TglFakturPBF").val(dateconverted);
        $("#TipeHutang").val(data[0].TipeHutang);
        showDataDetil_FK(data[0].TransactionCode);
        unlockBtnCreate();

        $("#Unitx").val(data[0].UnitPembelian).trigger('change');
        $("#PO_KodeSupplierx").val(data[0].SupplierCode).trigger('change');
        $("#Unitx").prop("disabled", true);
        $("#TglJatuhTempo").val(data[0].TglJatuhTempo);
        

        converted_diskonlain = data[0].DiskonLain.replace(".", ",");
        converted_biayalain = data[0].BiayaLain.replace(".", ",");
        converted_Pph23 = data[0].Pph23.replace(".", ",");
        converted_totallain = data[0].Grandtotal.replace(".", ",");

        $("#DiskonLain").val(number_to_price(converted_diskonlain));
        $("#BiayaLain").val(number_to_price(converted_biayalain));
        $("#Pph23").val(number_to_price(converted_Pph23));
        $("#GrandTotal").val(number_to_price(converted_totallain));
        
       // $("#grandtotalqty").val(data[0].TotalQtyDO);
        // $("#diskonxRp").val(data[0].TotalDiskon);
        // $("#subtotalttlrp").val(data[0].Subtotal);
        // $("#taxxRp").val(data[0].TotalTax);
        // $("#grandtotalxl").val(data[0].Grandtotal);

        $("#btnSearching").attr('disabled', true);

        //$("#PO_JenisPurchase").val(data.TIPE_PO).trigger('change');
        // if (data.status == "successDo") {
        //     disableForm();
        //     document.getElementById("btnNewTransaksi").disabled = true;
        //     toast(data.Pesan, "error")
        // }
        //enableForm();

    // await disableForm();
}
function getTukarFakturHeader() {
    var NoTrs = document.getElementById("No_Transaksi").value;
    var url2 = "/SIKBREC/public/TukarFaktur/getTukarFakturHeader";
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
async function addHeader() {
    try {
        $(".preloader").fadeIn();
        const datacreateHeader = await createHeader();
        updateUIdatacreateHeader(datacreateHeader);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeader(params) {

    if (params.status === true) {
        toast(params.message, "success");
        $("#No_Transaksi").val(params.data)
        unlockBtnCreate();
        showDataDetil_DO($("#No_Request").val());
        //MyBack();
    } else {
        toast(params.message, "error")
    }

}
function createHeader() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_trs").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/TukarFaktur/createHeaderTukarFaktur";
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
            const datagetTukarFakturHeader = await getTukarFakturHeader();
            updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
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


function ShowApprovedDObyDate() {
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();

    if (tglawal == '') {
        toast('Silahkan Isi Periode Awal !', 'warning')
        return false;
    }

    if (tglakhir == '') {
        toast('Silahkan Isi Periode Akhir !', 'warning')
        return false;
    }
    var base_url = window.location.origin;
    $('#datatable_req').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_req').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/DeliveryOrder/getDeliveryOrderbyPeriode/",
            //"url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyDateUser",
            "type": "POST",
            "data": {
                tglawal: tglawal,
                tglakhir: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> No. PO : ' + row.PurchaseOrderCode + ' <br> No. DO :  ' + row.TransactionCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.DeliveryOrderDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUser + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.JenisDelivery + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaSupplier + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""

                    // if (row.Approved == '0'){
                    //     var approve = 'disabled';
                    // }else{
                        var approve = '';
                    //}
                    var html = '<button type="button" class="btn btn-primary btn-xs border-primary"  onclick=ShowDetailDObyID("' + row.TransactionCode + '")'+approve+'>Pilih</button>'
                    return html
                },
            },
        ]
    });
}

//GET HDR PR
async function ShowDetailDObyID(param) {
    try {
        const dataGetPurchasebyId = await GetPurchasebyId(param);
        updateUIdataGetPurchasebyId(dataGetPurchasebyId);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGetPurchasebyId(data) {
    if (data.status === true) {

        // var tgltrs = data.data[0].DeliveryOrderDate;
        // var d = new Date(tgltrs);
        // d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        // $('#Tgl_trs').val(d.toISOString().substring(0,d.toISOString().length-1));

        $("#No_Request").val(data.data[0].TransactionCode);
        $("#NoPurchaseOrder").val(data.data[0].PurchaseOrderCode);
       // $("#User_Request").val(data.data[0].NamaUser);
        //$("#Keterangan_PO").val(data.data[0].Notes);
        $("#PO_KodeSupplier").val(data.data[0].SupplierCode);
        $("#Unit").val(data.data[0].UnitCode);
        //$("#JenisDelivery").val(data.data[0].JenisDelivery);
        //showDataDetil_DO(data.data[0].TransactionCode);
        unlockBtnCreate();

        

        $("#Unitx").val(data.data[0].UnitCode).trigger('change');
        $("#PO_KodeSupplierx").val(data.data[0].SupplierCode).trigger('change');
        $("#Unitx").prop("disabled", true);

        $("#grandtotalqty").val(data.data[0].TotalQtyDO);
        //$("#diskonxRp").val(data.data[0].TotalQtyDO);diskon tidak ada di api
        $("#subtotalttlrp").val(data.data[0].SubtotalDelivery);
        $("#taxxRp").val(data.data[0].TaxDelivery);
        $("#grandtotalxl").val(data.data[0].GrandtotalDelivery);

        $("#btnSearching").attr('disabled', true);

        $('#btnSearching_modal').modal('hide');
    } else {
        toast(params.message, "error")
    }
}
function GetPurchasebyId(TransasctionCode) {
    var base_url = window.location.origin;
    //var TransasctionCode = 'TPR160820220002'; 
    let url = base_url + '/SIKBREC/public/DeliveryOrder/getDeliveryOrderHeader/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoTrs=' + TransasctionCode
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

function CalculateItemsValue() {
    var subtotal = 0;
    var xxxx = 0;
    var subtotal2 = 0;
    var grandtotalx = 0;
    var diskon = 0;
    var qtytotal = 0;
    //console.log(total_items);
    for (i = 1; i <= total_items; i++) {
        itemID = document.getElementById("hidden_harga_barang_" + i);
        diskon = document.getElementById("hidden_discrp_barang_" + i);
        taxrp = document.getElementById("hidden_taxrp_" + i);
        qtyx = document.getElementById("hidden_qty_barang_" + i);

        //console.log(itemID);
        //console.log(diskon);
        var qty = $("#hidden_qty_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_harga_barang_" + i);
            // console.log(itemID);
        } else {
            //console.log(itemID);

            subtotal = parseFloat(itemID.value) * qty;
            subtotal2 = (parseFloat(itemID.value) - parseFloat(diskon.value)) * qty;
            grandtotalx = subtotal2 + parseFloat(taxrp.value);
            xxxx = xxxx + subtotal;
            qtytotal = qtytotal + parseFloat(qtyx.value);
            //console.log(qtytotal);
        }
        $("#hidden_subtotal_" + i).val(subtotal);
        $("#grandtotalqty" + i).val(qtytotal);

    }
    $("#grandtotalqty").val(qtytotal);

}

function CalculateALL() {
    var totalqty = 0;
    var totaldiscrp = 0;
    var totalsubtotal = 0;
    var totaltaxrp = 0;
    var totalgrand = 0;

    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_discrpttl_barang_" + i);

        var qty = $("#hidden_qty_barang_" + i).val();
        var Harga = $("#hidden_harga_barang_" + i).val();
        var DiscRPSt = $("#hidden_discrp_barang_" + i).val();
        var TaxRPSt = $("#hidden_taxrp2_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_discpros_barang_" + i);
        } else {
            //GET DISKON
            var getprosen_disc = (DiscRPSt/Harga)*100;
            var disc_rpall = ((Harga*qty))*getprosen_disc/100;

            //GET SUBTOTAL
            var subtotal = qty*Harga-disc_rpall;

            //GET TAX
            var hargasetelahdisc = Harga - ((Harga*getprosen_disc)/100);
            var getprosen_tax = (TaxRPSt/hargasetelahdisc)*100;
            var tax_rpall = (subtotal*getprosen_tax)/100;

            //GET GRANDTOTAL
            var grandtotal = subtotal + tax_rpall;
            
            //TOTAL  
            var totalqty = totalqty + qty;
            var totaldiscrp = totaldiscrp + disc_rpall;
            var totalsubtotal = totalsubtotal + subtotal;
            var totaltaxrp = totaltaxrp + tax_rpall;
            var totalgrand = totalgrand + grandtotal;
        }

        $("#hidden_discrpttl_barang_" + i).val(disc_rpall);
        $("#hidden_taxrp_" + i).val(tax_rpall);
        $("#hidden_grandtotal_" + i).val(grandtotal);

    //FOOTER
    //$("#grandtotalqty").val(totalqty);
    $("#diskonxRp").val(totaldiscrp);
    $("#subtotalttlrp").val(totalsubtotal);
    $("#taxxRp").val(totaltaxrp);
    $("#grandtotalxl").val(totalgrand);
    }
    

}

function CalculateItemsValueDiscon() {

    var subtotal = 0;
    var subtotal2 = 0;
    var subtotal3 = 0;
    var diskon = 0;
    var hrgstlhdiskonloop = 0;
    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_discpros_barang_" + i);

        // console.log(itemID);
        var qty = $("#hidden_qty_barang_" + i).val();
        var Harga = $("#hidden_harga_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_discpros_barang_" + i);
            //console.log(itemID);
        } else {
            subtotalx = (parseFloat(itemID.value) * Harga) / 100;
            subtotal2 = (Harga - subtotalx) * qty;
            //hrgstlhdiskonloop = hrgstlhdiskonloop + subtotalx;

            subtotalx_ttl = (parseFloat(itemID.value) * (Harga*qty)) / 100;

            hrgstlhdiskonloop = hrgstlhdiskonloop + subtotalx_ttl;
            subtotal3 = subtotal2+subtotal3;
        }
        $("#hidden_discrpttl_barang_" + i).val(subtotalx_ttl);

        $("#hidden_discrp_barang_" + i).val(subtotalx);
        $("#hidden_subtotal_" + i).val(subtotal2);
    }
    $("#diskonxRp").val(hrgstlhdiskonloop);
    $("#subtotalttlrp").val(subtotal3);

}

function CalculateItemsValueDisconTotal() {

    var hrgstlhdiskonloop = 0;
    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_discpros_barang_" + i);
        var qty = $("#hidden_qty_barang_" + i).val();
        var Harga = $("#hidden_harga_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_discpros_barang_" + i);
        } else {

            subtotalx_ttl = (parseFloat(itemID.value) * (Harga*qty)) / 100;

            hrgstlhdiskonloop = hrgstlhdiskonloop + subtotalx_ttl;
        }
    }
    $("#diskonxRp").val(hrgstlhdiskonloop);
}

function CalculateItemsTax() {
    var taxrp = 0;
    var grandtotalrp = 0;
    var hrgstlhtaxloop = 0;
    var grantotalxloop = 0;
    var grandtotalqty = 0;
    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_taxprosen_" + i);
        subtotaltemp = document.getElementById("hidden_subtotal_" + i);
        //hargasatuan = document.getElementById("hidden_harga_barang_" + i);

        //console.log(itemID);
        var qty = $("#hidden_qty_barang_" + i).val();
        var Harga = $("#hidden_harga_barang_" + i).val();
        var DiscRP = $("#hidden_discrp_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_taxprosen_" + i);
            //console.log(itemID);
        } else {
            taxrp = (parseFloat(itemID.value) * parseFloat(subtotaltemp.value)) / 100;
            grandtotalrp = parseFloat(subtotaltemp.value) + taxrp;
            hrgstlhtaxloop = hrgstlhtaxloop + taxrp;
            grantotalxloop = grantotalxloop + grandtotalrp;
            
            taxrp_stn = (parseFloat(itemID.value)*(parseFloat(Harga) - parseFloat(DiscRP)))  / 100;

        }
        $("#hidden_taxrp2_" + i).val(taxrp_stn);
        $("#hidden_taxrp_" + i).val(taxrp);
        $("#hidden_grandtotal_" + i).val(grandtotalrp);

    }
    $("#taxxRp").val(hrgstlhtaxloop);
    $("#grandtotalxl").val(grantotalxloop);

    var DiskonLain = $("#DiskonLain").val();
    var BiayaLain = $("#BiayaLain").val();
    var GrandTotal = grantotalxloop - BiayaLain - DiskonLain;
    $("#GrandTotal").val(GrandTotal);
}

function CalculateGrandTotal (){

    var grantotalxloop = $("#grandtotalxl").val();
    var DiskonLain = $("#DiskonLain").val();
    var BiayaLain = $("#BiayaLain").val();
    var GrandTotal = grantotalxloop - BiayaLain - DiskonLain;
    $("#GrandTotal").val(GrandTotal);

}

function CalculateQty() {
    var total_items = $('#totalrow').val();
    // console.log(total_items);
    for (i = 1; i <= total_items; i++) {
        qtyx = document.getElementById("hidden_min_barang_" + i);

        var qty = parseFloat($("#hidden_qty_barang_" + i).val());
        var qtymr = parseFloat($("#hidden_min_barang_" + i).val());
        if (typeof qtyx === 'undefined' || qtyx === null) {
            alert("No such item - " + "hidden_min_barang_" + i);
            // console.log(itemID);
        } else {

            if (qty > qtymr) {
                // console.log(qty);
                // console.log(qtymr);
                //    new PNotify({
                //                               title: 'Notifikasi',
                //                               text: 'Qty PO Lebih Besar daripada Qty Sisa MR !',
                //                               type: 'success'
                //                   });
                toast('Qty PO Lebih Besar daripada Qty Sisa MR !', 'warning');
                document.getElementById("savetrs").disabled = true;
                document.getElementById("batal").disabled = true;
                document.getElementById("close").disabled = true;
                document.getElementById("supplier").disabled = true;
                document.getElementById("nomreq").disabled = true;
            } else if (qty < qtymr) {
                document.getElementById("savetrs").disabled = false;
                document.getElementById("batal").disabled = false;
                document.getElementById("close").disabled = false;
                document.getElementById("supplier").disabled = false;
                document.getElementById("nomreq").disabled = false;
            }
        }


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
                
                //convert titik jadi koma
                converted_discprosen = val.DiscountProsen.replace(".", ",");
                converted_discrp = val.DiscountRp.replace(".", ",");
                converted_discrpttl = val.DiscountRpTTL.replace(".", ",");
                converted_sbttl = val.SubtotalDeliveryOrder.replace(".", ",");
                converted_taxprosen = val.TaxProsen.replace(".", ",");
                converted_taxrp = val.TaxRp.replace(".", ",");
                converted_taxrpttl = val.TaxRpTTL.replace(".", ",");
                converted_total = val.TotalDeliveryOrder.replace(".", ",");
                converted_price = val.Price.replace(".", ",");
                converted_qty = val.QtyDelivery.replace(".", ",");
                converted_qtymin = val.QtyDeliveryRemain.replace(".", ",");
                //converted_qtypurchase = val.QtyPurchase.replace(".", ",");

                total_items = total_items + 1;
                $("#totalrow").val(total_items);
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
                /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ></td> '"+
            /*5*/"' <td>" + converted_qtymin + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + converted_qtymin + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + converted_qtymin +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga'  value='" + converted_price + "' ></td> '"+
            // /*7b*/"' <td><input size='5'  type='date' name='hidden_ed_[]'   id='hidden_ed_" + total_items + "' class='date' value='"+val.ExpiredDate+"'  ></td> '"+
            // /*7c*/"' <td><input size='1'  type='text' name='hidden_nobatch_[]'   id='hidden_nobatch_" + total_items + "' class='hidden_nobatch_' value='"+val.NoBatch+"' ></td> '"+
            ///*8*/"' <td><input size='1' readonly value='" + val.DiscountProsen + "' onkeyup='CalculateItemsValueDiscon()' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +"' ></td>'"+
            /*--9*/"' <td><input size='5' readonly='true' value='" + converted_discrp + "' type='hidden' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ><input size='5' readonly='true' value='" + converted_discrpttl + "' type='text' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td> '"+
            /*10*/"' <td><input size='7' readonly='true' value='" + converted_sbttl + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            ///*11*/"' <td><input size='1' readonly value='" + val.TaxProsen + "' type='text' onkeyup='CalculateItemsTax()'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            /*--12*/"' <td><input size='5' readonly='true' value='" + converted_taxrpttl + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ><input size='5' readonly='true' value='" + converted_taxrp + "' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td> '"+
            /*13*/"' <td><input size='8' readonly='true'  value='" + converted_total + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ID + "') name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " +
            // "</td>  
            "</tr>")
            ;


                dataHandler.append(newRow);
            });
            //CalculateItemsValueDisconTotal();
            calculateAllDetail()
        }
    });

    $(".preloader").fadeOut();
}

//GET DTL PO
function showDataDetil_FK(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    // var TransasctionCode = "TPR160820220002"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/TukarFaktur/getFakturDetailbyID/";

    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {

                //convert titik jadi koma
                //converted_discprosen = val.DiscountProsen.replace(".", ",");
                converted_discrp = val.Diskon2.replace(".", ",");
                converted_discrpttl = val.Diskon.replace(".", ",");
                converted_sbttl = val.Subtotal.replace(".", ",");
                //converted_taxprosen = val.TaxProsen.replace(".", ",");
                converted_taxrp = val.Tax2.replace(".", ",");
                converted_taxrpttl = val.Tax.replace(".", ",");
                converted_total = val.Total.replace(".", ",");
                converted_price = val.Harga.replace(".", ",");
                converted_qty = val.QtyFaktur.replace(".", ",");
                converted_qtymin = val.QtyFakturSisa.replace(".", ",");

                total_items = total_items + 1;
                $("#totalrow").val(total_items);
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ></td> '"+
            /*5*/"' <td>" + converted_qtymin + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + val.QtyFakturSisa + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + converted_qty +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga' value='" + converted_price + "' ></td> '"+
            // /*7b*/"' <td><input size='5'  type='date' name='hidden_ed_[]'   id='hidden_ed_" + total_items + "' class='date'  ></td> '"+
            // /*7c*/"' <td><input size='1'  type='text' name='hidden_nobatch_[]'   id='hidden_nobatch_" + total_items + "' class='hidden_nobatch_'  ></td> '"+
            ///*8*/"' <td><input size='1' readonly value='" + val.DiscountProsen + "' onkeyup='CalculateItemsValueDiscon()' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +"' ></td>'"+
            /*--9*/"' <td><input size='5' readonly='true' value='" + converted_discrp + "' type='text' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ><input size='5' readonly='true' value='" + converted_discrpttl + "' type='hidden' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td> '"+
            /*10*/"' <td><input size='7' readonly='true' value='" + converted_sbttl + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            ///*11*/"' <td><input size='1' readonly value='" + val.TaxProsen + "' type='text' onkeyup='CalculateItemsTax()'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            /*--12*/"' <td><input size='5' readonly='true' value='" + converted_taxrpttl + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ></td> <input size='5' readonly='true' value='" + converted_taxrp + "' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td>'"+
            /*13*/"' <td><input size='8' readonly='true'  value='" + converted_total + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " +
            //     "</td>  
                "</tr>")
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
            goVoidPurchaseOrderDetailsByID(product_code, value);
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/TukarFaktur/list";
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

function calculateAllDetail(){
    var subtotal = 0;
    var grandtotal = 0;  
    var qtytotal = 0;
    var pph23 = 0;
    var hargamindiskon = 0;
    var grandtotaldiskonrp = 0;
    var totalSubtotalAfterDiskon = 0;
    var grandtotaltax = 0;
    var grandtotalPurchase = 0;
    var grandtotalPurchase = 0;
    var taxrp = 0;
    var grantotalxloop = 0;
    var taxrp_stn = 0;
    var diskon_lain = 0;
    var biaya_lain = 0;
    var grandtotaltemp = 0;
    var grandtotal_final = 0;
    var total_items = $('#totalrow').val(); 
    for (i = 1; i <= total_items; i++) {
       
        qtyx = document.getElementById("hidden_min_barang_" + i);
        var qty = parseFloat(price_to_number($("#hidden_qty_barang_" + i).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_min_barang_" + i).val()));
        // disconprosen = document.getElementById("hidden_discpros_barang_" + i);
        //var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + i).val()));
        //harga = document.getElementById("hidden_harga_barang_" + i);  
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + i).val()));
        var disconprosen = (parseFloat(price_to_number($("#hidden_discrp_barang_" + i).val())) / harga)*100;
        var harga_after_disc = harga * (1 - (disconprosen/100))
        // taxprosen = document.getElementById("hidden_taxprosen_" + i); 
        //var taxprosen = parseFloat(price_to_number($("#hidden_taxprosen_" + i).val()));
        //var taxprosen = (parseFloat(price_to_number($("#hidden_taxrp2_" + i).val())) / harga_after_disc)*100;
        var taxprosen = 11;

        if (typeof qtyx === 'undefined' || qtyx === null) {
            alert("No such item - " + "hidden_min_barang_" + i); 
            return false
        } 
            if (qty > qtymr) {
                toast('Qty Melebihi quantity minimal (Qty DO) !', 'warning'); 
                $("#hidden_qty_barang_"+i).val(0);
                return false;
            } 

                subtotal = parseFloat(harga) * qty;
                hargamindiskon = (parseFloat(disconprosen) * parseFloat(harga)) / 100; 
                hargamindiskonQty = (parseFloat(harga) - hargamindiskon) * qty;
                hargamindiskonTok = (parseFloat(harga) - hargamindiskon);
                totaldiskonrp = hargamindiskon*qty;

                grandtotaldiskonrp = grandtotaldiskonrp + totaldiskonrp;

                qtytotal = qtytotal + parseFloat(qty);
                totalSubtotalAfterDiskon = hargamindiskonQty+totalSubtotalAfterDiskon;

                taxrp = (parseFloat(taxprosen)*hargamindiskonQty) / 100;
                grandtotal = hargamindiskonQty + parseFloat(taxrp);
                grandtotaltax = grandtotaltax + taxrp;
                grandtotalPurchase = hargamindiskonQty + taxrp;
                grantotalxloop = grantotalxloop + grandtotalPurchase;
                taxrp_stn = (parseFloat(taxprosen)*hargamindiskonTok)/100;
                
            $("#hidden_discrpttl_barang_" + i).val(number_to_price(totaldiskonrp));
            $("#hidden_discrp_barang_" + i).val(number_to_price(hargamindiskon));
            $("#hidden_subtotal_" + i).val(number_to_price(hargamindiskonQty));
            //$("#grandtotalqty" + i).val(number_to_price(qtytotal));
            $("#hidden_taxrp_" + i).val(number_to_price(taxrp));
            $("#hidden_taxrp2_" + i).val(number_to_price(taxrp_stn));
            $("#hidden_grandtotal_" + i).val(number_to_price(grandtotalPurchase));
            $("#hidden_harga_barang_" + i).val(number_to_price(harga));
        }
        diskon_lain = parseFloat(price_to_number($("#DiskonLain").val()));
        pph23 = parseFloat(price_to_number($("#Pph23").val()));
        biaya_lain = parseFloat(price_to_number($("#BiayaLain").val()));
        grandtotaltemp = grantotalxloop - (diskon_lain);
        grandtotal_final = grandtotaltemp+biaya_lain+pph23;
         

        $("#diskonxRp").val(number_to_price(grandtotaldiskonrp));
        $("#grandtotalqty").val(number_to_price(qtytotal));
        $("#subtotalttlrp").val(number_to_price(totalSubtotalAfterDiskon));
        $("#taxxRp").val(number_to_price(grandtotaltax));
        $("#grandtotalxl").val(number_to_price(grantotalxloop));
        $("#GrandTotal").val(number_to_price(grandtotal_final));

        $("#diskonxRp_tmp").text(number_to_price(grandtotaldiskonrp));
        $("#grandtotalqty_tmp").text(number_to_price(qtytotal));
        $("#subtotalttlrp_tmp").text(number_to_price(totalSubtotalAfterDiskon));
        $("#taxxRp_tmp").text(number_to_price(grandtotaltax));
        $("#grandtotalxl_tmp").text(number_to_price(grantotalxloop));
}