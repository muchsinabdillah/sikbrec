$(document).ready(function () { 
 
    onLoadFunctionAll();
    $("#Jenis_Requestx").attr("disabled", true);
    $("#Unit_Requestx").attr("disabled", true);
    //showDataDetil_PR('TPR230120240005');
    $("#Jenis_Requestx").select2();
    $('#datatable_pr').dataTable({})

    $('#btnSearching').click(function () {
        $('#btnSearching_modal').modal('show');
    });

    $('#btnprint').click(function () {
        $('#notif_Cetak').modal('show');
    });
    $('#btnUpdateKonersi').click(function () {
        updatedataKonversiBeliPO();
    });
    
    $(document).on('click', '#cetakan', function () {
        var No_Transaksi = $("#No_Transaksi").val();
        if (No_Transaksi == ''){
            toast('No Transaksi Tidak Ditemukan !', "warning")
            return false
      }
        CetakPO(No_Transaksi);
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
                    addHeaderPurchaseOrder();
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
                    goFinishEditPurchaseOrder();
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
                goVoidPurchaseOrder(value);
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

    $('#btnCloseTrs').click(function () {
        swal("Alasan Close:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Close Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                // swal(`You typed: ${value}`);
                goClosePurchaseOrder(value);
            });
    });

    //$(".preloader").fadeOut();

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
 
function calculatedata(){ 
    var qtybeli =  $("#Kon_EntriQty").val();
    var qtyKonversi =  $("#Kon_KonversiDatasatuan").val();
    var qtytotalBeli = parseFloat(qtybeli)*parseFloat(qtyKonversi);
    $("#Kon_EntriQtyTotal").val(qtytotalBeli);
}
async function showmodalkonversi(ProductCode,satuanbesar,ID,qty) {
    try {
        
        $('#notif_konversi').modal('show'); 
        $("#Kon_Detailid").val(ID);
        $("#Kon_SatuanBesar").val(satuanbesar);
        $("#Kon_QtyAwal").val(qty);
        
        // const datagetSuppliers = await getSuppliers();a
        // updateUIdatagetSuppliers(datagetSuppliers);
        const datagoVoidPurchaseOrderDetailsByID = await getBarangKonversibyId(ProductCode);
        updategetBarangKonversibyId(datagoVoidPurchaseOrderDetailsByID);
    
    } catch (err) {
        toast(err, "error")
    }
}
async function getIdDetailKonversiPo(e){
    try {
     //   $(".preloader").fadeIn(); 
        $("#PilihKonversikode").val(e.value);
        const datax = await getDetailDataIdKonversiPo(e.value);
        updategetDetailDataIdKonversiPo(datax);
       // $(".preloader").fadout();
    } catch (err) {
        toast(err, "error")
    }
    
}
function updategetDetailDataIdKonversiPo(datax){
    $("#Kon_KonversiDatasatuan").val(datax.data.NilaiKonversi);
    $("#Kon_DataSatBesar").val(datax.data.SatuanBeli);
    $("#Kon_DataSatKecil").val(datax.data.SatuanJual); 
}
function getDetailDataIdKonversiPo(id) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Purchase/getBarangKonversibyIdDetail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + id
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
function updategetBarangKonversibyId(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        $("#PilihKonversi").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#PilihKonversi").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].id + '">Satuan Beli : ' + responseApi.data[i].SatuanBeli + ', Satuan Jual : ' + responseApi.data[i].SatuanJual + ', Konversi : ' + responseApi.data[i].NilaiKonversi + '</option>';
            $("#PilihKonversi").append(newRow);
        }
    }

}
 

function getBarangKonversibyId(ProductCode) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Purchase/getBarangKonversibyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ProductCode=' + ProductCode
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
async function goVoidPurchaseOrderDetailsByID(product_code, QtyPurchase,param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidPurchaseOrderDetailsByID = await goVoidPurchaseOrderDetailsByID2(product_code,QtyPurchase, param);
        updateUIdatagoVoidPurchaseOrderDetailsByID2(datagoVoidPurchaseOrderDetailsByID);
    } catch (err) {
        toast(err, "error")
    }
}

async function goVoidPurchaseOrder(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidPurchaseOrder = await goVoidPurchaseOrder2(param);
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoFinishPurchaseOrder2(datagoVoidPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}

async function goFinishEditPurchaseOrder() {
    try {
        $(".preloader").fadeIn();
        const datagoFinishPurchaseOrder2 = await goEditFinishPurchaseOrder2();
        updateUIdatagoFinishPurchaseOrder2x(datagoFinishPurchaseOrder2);

        //$(".preloader").fadeIn();

        const datagoFinishPurchaseOrder3 = await goEditFinishPurchaseOrder3();
        updateUIdatagoFinishPurchaseOrder2(datagoFinishPurchaseOrder3);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinishPurchaseOrder2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        // setTimeout(() => {
        //     MyBack();
        // }, 2000);
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

function updateUIdatagoFinishPurchaseOrder2x(data) {
    if (data.status == true) {
        toast(data.message, "success");
    } else {
        toast(data.message, "error")
    }
}




function updateUIdatagoVoidPurchaseOrderDetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_PO($("#No_Transaksi").val());
        $("#grandtotalxl").val('');
        //onLoadFunctionAll();
    } else {
        toast(data.message, "error")
    }
}

function goVoidPurchaseOrderDetailsByID2(product_code, QtyPurchase,param) {
     
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var PurchaseRequisitonCode = document.getElementById("No_Request").value;

    //console.log(PurchaseRequisitonCode);
    var url2 = "/SIKBREC/public/purchase/goVoidPurchaseOrderDetails";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&product_code=" + product_code
        + "&PurchaseRequisitonCode=" + PurchaseRequisitonCode + "&QtyPurchase=" + QtyPurchase
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

function goVoidPurchaseOrder2(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var No_Request = document.getElementById("No_Request").value;
    var url2 = "/SIKBREC/public/purchase/goVoidPurchaseOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param
        + "&PurchaseRequisitonCode=" + No_Request
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

function goEditFinishPurchaseOrder3() {
    var data = $("#user_form, #form_hdr").serialize();
    var url2 = "/SIKBREC/public/purchase/goFinishPurchaseOrder";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data
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

function goEditFinishPurchaseOrder2() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/purchase/goFinishEditPurchaseOrder";
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
function updateUIdatagetPurchaseOrderHeader(data) {
    if (data.status == true) {
        ShowDetailPRbyID(data.data[0].PurchaseReqCode);
        //toast(data.message , 'success');
        // document.getElementById("PO_HDR_Qty").innerHTML = number_to_price(data.FN_TTL_QTY_PO);
        // document.getElementById("PO_HDR_Subtotal").innerHTML = number_to_price(data.FN_SUBTOTAL);
        // document.getElementById("PO_HDR_TaxRp").innerHTML = number_to_price(data.FN_TAX_RP);
        // document.getElementById("PO_HDR_Total").innerHTML = number_to_price(data.FN_TOTAL);
        // data.data[0].PurchaseDate = new Date()
        // var date = data.data[0].PurchaseDate.toISOString().split('T')[0]
        var tgltrs = data.data[0].PurchaseDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        console.log(d.toISOString());
        $('#Tgl_Transaksi').val(d.toISOString().substring(0,d.toISOString().length-1));

        $("#No_Request").val(data.data[0].PurchaseReqCode);
        //$("#Tgl_Transaksi").val(date);
        $("#User_Entri").val(data.data[0].NamaUserCreate);
        $("#PO_Keterangan").val(data.data[0].Notes);
        $("#Unit").val(data.data[0].Unit).trigger('change');
        $("#PO_KodeSupplierx").val(data.data[0].SupplierCode).trigger('change');
        showDataDetil_PO(data.data[0].PurchaseCode);
        unlockBtnCreate();

        $("#grandtotalqty").val(number_to_price(data.data[0].TotalQtyPO));
        //$("#diskonxRp").val(data.data[0].TotalQtyDO);
        $("#subtotalttlrp").val(number_to_price(data.data[0].SubtotalPurchase));
        //$("#taxxRp").val(data.data[0].TaxDelivery);
        $("#grandtotalxl").val(number_to_price(data.data[0].GrandtotalPurchase));

        $("#grandtotalqty_tmp").text(number_to_price(data.data[0].TotalQtyPO));
        $("#subtotalttlrp_tmp").text(number_to_price(data.data[0].SubtotalPurchase));
        $("#grandtotalxl_tmp").text(number_to_price(data.data[0].GrandtotalPurchase));

        if (data.data[0].DateApproved_1 == null){
            $("#Status").val('Waiting Approve 1');
        }else if(data.data[0].DateApproved_2 == null){
            $("#Status").val('Waiting Approve 2');
        }else if (data.data[0].DateApproved_3 == null){
            $("#Status").val('Waiting Approve 3');
        }else{
            $("#Status").val('Approved');
            $("#Tgl_Transaksi").attr('readonly',true);
            $("#PO_KodeSupplierx").attr('disabled',true);
            $("#PO_Keterangan").attr('readonly', true);
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
function getPurchaseOrderHeader() {
    var PO_NoTrs = document.getElementById("No_Transaksi").value;
    var url2 = "/SIKBREC/public/purchase/getPurchaseOrderHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "PO_NoTrs=" + PO_NoTrs
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
async function updatedataKonversiBeliPO(){
    try {
        $(".preloader").fadeIn();
        const datax = await createupdatedataKonversiBeliPO();
        updatecreateupdatedataKonversiBeliPO(datax); 
    } catch (err) {
        toast(err, "error")
    }
}
function updatecreateupdatedataKonversiBeliPO(params){
    if (params.status === true) {
        swal({
            title: "Success",
            text: 'Berhasil Membuat Transaksi Baru!',
            icon: "success",
        });
        $('#notif_konversi').modal('hide');
        showDataDetil_PR($("#No_Request").val());
    } else {
        toast(params.message, "error")
    }
   
}

function createupdatedataKonversiBeliPO() { 
    var Kon_Detailid = document.getElementById("Kon_Detailid").value; 
    var PilihKonversikode = document.getElementById("PilihKonversikode").value; 
    var Kon_DataSatBesar = document.getElementById("Kon_DataSatBesar").value; 
    var Kon_DataSatKecil = document.getElementById("Kon_DataSatKecil").value; 
    var Kon_KonversiDatasatuan = document.getElementById("Kon_KonversiDatasatuan").value; 
    var Kon_EntriQty = document.getElementById("Kon_EntriQty").value; 
    var Kon_EntriQtyTotal = document.getElementById("Kon_EntriQtyTotal").value; 
    var url2 = "/SIKBREC/public/purchase/createupdatekonversisatuanPo";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   "Kon_Detailid=" +Kon_Detailid 
                +"&PilihKonversikode=" +PilihKonversikode
                +"&Kon_DataSatBesar=" +Kon_DataSatBesar
                +"&Kon_DataSatKecil=" +Kon_DataSatKecil
                +"&Kon_KonversiDatasatuan=" +Kon_KonversiDatasatuan
                +"&Kon_EntriQty=" +Kon_EntriQty
                +"&Kon_EntriQtyTotal=" +Kon_EntriQtyTotal
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
async function addHeaderPurchaseOrder() {
    try {
        $(".preloader").fadeIn();
        const datacreateHeaderPurchaseOrder = await createHeaderPurchaseOrder();
        updateUIdatacreateHeaderPurchaseOrder(datacreateHeaderPurchaseOrder);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeaderPurchaseOrder(params) {

    //console.log(params);
    if (params.status === true) {
        swal({
            title: "Success",
            text: 'Berhasil Membuat Transaksi Baru!',
            icon: "success",
        });
        toast(params.message, "success");
        $("#No_Transaksi").val(params.data)
        unlockBtnCreate();
        showDataDetil_PR($("#No_Request").val());
        //MyBack();
    } else {
        toast(params.message, "error")
    }
}
function createHeaderPurchaseOrder() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_Transaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/purchase/createHeaderPurchaseOrder";
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
        $(".preloader").fadeIn();
        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        if ($("#No_Transaksi").val() != '') {
            const datagetPurchaseOrderHeader = await getPurchaseOrderHeader();
            updateUIdatagetPurchaseOrderHeader(datagetPurchaseOrderHeader);
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

function getIDSupplier(e){
    $("#PO_KodeSupplier").val(e.value);
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


function ShowApprovedPRbyDate() {
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
            "url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyPeriode",
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
                    var html = '<font size="1"> ' + row.TransactionCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransasctionDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"><b> ' + row.NamaUserCreate + '</b> <br>'+row.NamaUnit+'</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.Approved == '1'){
                        var html = '<span class="badge badge-success">'+row.StatusPR+'</span><br>Tgl Approve: '+row.DateApproved+'<br>'+'User Approve: '+row.namaUserApproved;
                    }else{
                        var html = '<span class="badge badge-danger">'+row.StatusPR+'</span>';
                    }
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.Type == '1') {
                        var Jenis = 'FARMASI';
                    } else if (row.Type == '2') {
                        var Jenis = 'LOGISTIK';
                    } else {
                        var Jenis = '';
                    }
                    var html = '<font size="1"> ' + Jenis + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""

                    if (row.Approved == '0'){
                        var approve = 'disabled';
                    }else{
                        var approve = '';
                    }
                    var html = '<button type="button" class="btn btn-maroon btn-xs btn-rounded"  onclick=ShowDetailPRbyID("' + row.TransactionCode + '") '+approve+'>Pilih</button>'
                    return html
                },
            },
        ]
    });
}

//GET HDR PR
async function ShowDetailPRbyID(param) {
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
        $('#No_Request').val(params.data[0].TransactionCode);
        $('#Tgl_Request').val(params.data[0].TransasctionDate);
        $('#User_Request').val(params.data[0].NamaUserCreate);
        //$('#Status').val(params.data[0].StatusPR); 
        $('#Unit_Requestx').val(params.data[0].Unit).trigger('change');
        $('#Jenis_Requestx').val(params.data[0].Type).trigger('change');
        $('#Jenis_Request').val(params.data[0].Type);
        $('#Unit_Request').val(params.data[0].Unit);
        $('#PR_Keterangan').val(params.data[0].Notes);
        unlockBtnCreate();


        $('#btnSearching_modal').modal('hide');
    } else {
        toast(params.message, "error")
    }
}
function GetPurchasebyId(TransasctionCode) {
    var base_url = window.location.origin;
    //var TransasctionCode = 'TPR160820220002'; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
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


//GET DTL PR
function showDataDetil_PR(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    // var TransasctionCode = "TPR160820220002"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionDetailbyID/";

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
                converted_qtyremain = val.QtyRemainPR.replace(".", ",");

                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
                newRow.html(`<td><font size='1'>${total_items}</td>
                            <td><font size='1'>${val.ProductCode}<input type='hidden' name='hidden_kode_barang[]' 
                                id='hidden_kode_barang${total_items}' class='hidden_kode_barang${total_items}' 
                                value='${val.ProductCode}' ><input type='text'  name='hidden_Satuan_Konversi_[]' 
                                id='hidden_Satuan_Konversi_${total_items}' 
                                value='${val.Satuan_Konversi}' ><input type='text'  name='hidden_KonversiQty_[]' 
                                id='hidden_KonversiQty_${total_items}' 
                                value='${val.KonversiQty}' ></font>
                            </td> 
                            <td><font size='1'>${val.ProductName}<input type='hidden'  name='hidden_nama_barang_[]' 
                                id='hidden_nama_barang_${total_items}' 
                                value='${val.ProductName}' ></font>
                            </td>
                            <td><span class='label label-success pointer' style='cursor: pointer;' onclick="showmodalkonversi('${val.ProductCode}','${val.Satuan}','${val.ID}','${converted_qtyremain}')">${val.Satuan}</span><input type='hidden' name='hidden_satuan_barang_[]' 
                                id='hidden_satuan_barang_${total_items}' 
                                value='${val.Satuan}' >
                            </td>
                            <td>${converted_qtyremain}<input type='hidden'  name='hidden_min_barang_[]' 
                                id='hidden_min_barang_${total_items}' 
                                value='${converted_qtyremain}' >
                            </td>
                            <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' 
                                id='hidden_qty_barang_${total_items}' 
                                value='${converted_qtyremain}' >
                            </td>
                            <td ><input size='5'   type='text' name='hidden_harga_barang_[]'   
                                id='hidden_harga_barang_${total_items}' class='harga' onkeydown='FormatCell(this)' 
                                value='0' >
                            </td>
                            <td><input size='1'  value='0' onkeydown='FormatCell(this)' type='text' 
                                name='hidden_discpros_barang_[]'   
                                id='hidden_discpros_barang_${total_items}' > 
                            </td> 
                            <td>
                                <input size='5' readonly='true' value='0' type='hidden' name='hidden_discrp_barang_[]'  
                                style'width: 1sx' id='hidden_discrp_barang_${total_items}' >
                                <input size='5' readonly='true' type='text' name='hidden_discrpttl_barang_[]' 
                                id='hidden_discrpttl_barang_${total_items}' >
                            </td>
                            <td><input size='7' readonly='true' value='0' type='text' name='hidden_subtotal_[]' 
                                style'width: 1sx' id='hidden_subtotal_${total_items}' >
                            </td>
                            <td><input size='1' value='11' type='text' onkeydown='FormatCell(this)'   
                                name='hidden_taxprosen_[]' style'width: 1sx' 
                                id='hidden_taxprosen_${total_items}' >
                            </td>
                            <td>
                                <input size='5' readonly='true' value='0'  type='text' name='hidden_taxrp_[]' 
                                style'width: 1sx' id='hidden_taxrp_${total_items}' >
                                <input size='5' readonly='true' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_${total_items}' >
                            </td>
                            <td>
                                <input size='8' readonly='true'  value='0'   type='text' name='hidden_grandtotal_[]' 
                                style'width: 1sx' id='hidden_grandtotal_${total_items}' >
                            </td>
                            </td></tr>`);


                dataHandler.append(newRow);
            });
        }
    });

    //$(".preloader").fadeOut();
}
function calculateAllDetail(){

    var subtotal = 0;
    var grandtotal = 0;  
    var qtytotal = 0;
    var hargamindiskon = 0;
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
       
        var qtyx = document.getElementById("hidden_min_barang_" + i);

        var qty = parseFloat(price_to_number($("#hidden_qty_barang_" + i).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_min_barang_" + i).val()));
        var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + i).val()));
        //disconprosen = document.getElementById("hidden_discpros_barang_" + i);
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + i).val()));
        //harga = document.getElementById("hidden_harga_barang_" + i);  
        var taxprosen = parseFloat(price_to_number($("#hidden_taxprosen_" + i).val()));


        if (typeof qtyx === 'undefined' || qtyx === null) {
            alert("No such item - " + "hidden_min_barang_" + i); 
        } else {
            if (qty > qtymr) {
                toast('Qty PO Lebih Besar daripada Qty Sisa MR !', 'warning'); 
                $("#hidden_qty_barang_"+i).val(0);
                return false;
            } else  { 

                subtotal = parseFloat(harga) * qty;
                hargamindiskon = (parseFloat(disconprosen) * parseFloat(harga)) / 100; 
                hargamindiskonQty = (parseFloat(harga) - hargamindiskon) * qty;
                hargamindiskonTok = (parseFloat(harga) - hargamindiskon);
                totaldiskonrp = hargamindiskon*qty;

                grandtotaldiskonrp = grandtotaldiskonrp + totaldiskonrp;

               
                qtytotal = qtytotal + parseFloat(qty);
                totalSubtotalAfterDiskon = hargamindiskonQty+totalSubtotalAfterDiskon;

                taxrp = (parseFloat(taxprosen)*hargamindiskonQty) / 100;
                // console.log("taxrp",taxrp);
                // console.log("taxprosen",taxprosen);
                // console.log("hargamindiskonQty",hargamindiskonQty);
                grandtotal = hargamindiskonQty + parseFloat(taxrp);
                grandtotaltax = grandtotaltax + taxrp;
                grandtotalPurchase = hargamindiskonQty + taxrp;
                grantotalxloop = grantotalxloop + grandtotalPurchase;
                taxrp_stn = (parseFloat(taxprosen)*hargamindiskonTok)/100;
                //console.log("taxrp_stn",taxrp_stn + ' ' + hargamindiskon + ' '  + parseFloat(taxprosen.value) + ' ' +parseFloat(disconprosen.value) + ' ' + parseFloat(harga.value));

                //noted
                // $("#hidden_discrpttl_barang_" + i).val(price_to_number(totaldiskonrp));
                // $("#hidden_discrp_barang_" + i).val(price_to_number(hargamindiskon));
                // $("#hidden_subtotal_" + i).val(price_to_number(hargamindiskonQty));
                // $("#grandtotalqty" + i).val(price_to_number(qtytotal));
                // $("#hidden_taxrp_" + i).val(price_to_number(taxrp));
                // $("#hidden_taxrp2_" + i).val(price_to_number(taxrp_stn));
                // $("#hidden_grandtotal_" + i).val(price_to_number(grandtotalPurchase));

                $("#hidden_discrpttl_barang_" + i).val(number_to_price(totaldiskonrp));
                $("#hidden_discrp_barang_" + i).val(number_to_price(hargamindiskon));
                $("#hidden_subtotal_" + i).val(number_to_price(hargamindiskonQty));
                $("#grandtotalqty" + i).val(number_to_price(qtytotal));
                $("#hidden_taxrp_" + i).val(number_to_price(taxrp));
                $("#hidden_taxrp2_" + i).val(number_to_price(taxrp_stn));
                $("#hidden_grandtotal_" + i).val(number_to_price(grandtotalPurchase));
                $("#hidden_harga_barang_" + i).val(number_to_price_input(harga));

            }
            // $("#hidden_discrpttl_barang_" + i).val(totaldiskonrp);
            // $("#hidden_discrp_barang_" + i).val(hargamindiskon);
            // $("#hidden_subtotal_" + i).val(hargamindiskonQty);
            // $("#grandtotalqty" + i).val(qtytotal);
            // $("#hidden_taxrp_" + i).val(taxrp);
            // $("#hidden_taxrp2_" + i).val(taxrp_stn);
            // $("#hidden_grandtotal_" + i).val(grandtotalPurchase);

        }
    }
    console.log(grandtotaldiskonrp,'aaaaaaaa');
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
                newRow.html("<td><font size='1'>" + total_items + "</td><td>" + val.ProductCode +
                    "<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'" + total_items + "' value='" + val.ProductCode +
                    "' ><input type='text' name='hidden_Satuan_Konversi_[]' id='hidden_Satuan_Konversi_'" + total_items + "' class='hidden_Satuan_Konversi_'" + total_items + "' value='" + val.Satuan_Konversi +
                    "' ><input type='text' name='hidden_KonversiQty_[]' id='hidden_KonversiQty_'" + total_items + "' class='hidden_KonversiQty_'" + total_items + "' value='" + val.KonversiQty +
                    "' ></font></td><td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +
                    "' ></font></td> <td><span class='label label-success pointer' style='cursor: pointer;' onclick=\'showmodalkonversi(" + val.ProductCode + ", " + val.ProductSatuan  + ", " + val.ID  + ", " + val.QtyPurchase  + ")\'>'" + val.ProductSatuan + "'</span><input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +
                    "' value='" + val.ProductSatuan + "' ></td> <td>" + parseFloat(val.QtyPR) + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items +
                    "' value='" + parseFloat(val.QtyPR) +
                    "' ></td>  <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +
                    "' value='" + parseFloat(val.QtyPurchase) +
                    "' ></td>  <td ><input size='5'   type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items +
                    "' class='harga' onkeydown='FormatCell(this)' value='" + parseFloat(val.Price) + "' ></td><td><input size='1'  value='" + converted_discprosen + "' onkeydown='FormatCell(this)' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +
                   /*dihhiden*/ "' ></td> <td><input size='5' readonly='true' value='" + converted_discrp + "' type='text' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +
                    "' ><input size='5' readonly='true' value='"+converted_discrpttl+"' type='hidden' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td>  <td><input size='7' readonly='true' value='" + converted_sbttl + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +
                    "' ></td><td><input size='1' value='" + converted_taxprosen + "' type='text' onkeydown='FormatCell(this)'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +
                    "' ></td> <td><input size='5' readonly='true' value='" + converted_taxrpttl + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items +
                    /*dihhiden*/"' ><input size='5' value='"+converted_taxrp+"' readonly='true' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td> <td><input size='8' readonly='true'  value='" + converted_total + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +
                    "' ></td>" +
                    "<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "','" + val.QtyPurchase + "') name='remove_details' class='btn btn-gold btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " +
                    "</td>  </tr>")
                    ;


                dataHandler.append(newRow);
            }); 
            calculateAllDetail();

        }
    });

    //$(".preloader").fadeOut();
}


function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        //console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unit_Requestx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#Unit_Requestx").append(newRow);
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
            $("#Unit_Requestx").select2();
        })
}

function unlockBtnCreate() {
    if ($("#No_Transaksi").val() == '' && $("#No_Request").val() != '') {
        $("#btnNewTransaksi").attr('disabled', false);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);

    } else if ($("#No_Transaksi").val() == '' && $("#No_Request").val() == '') {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);
    } else {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', false);
        $("#btn_batal").attr('disabled', false);
    }
}


function goVoidDetails(product_code,QtyPurchase) {
   
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
            goVoidPurchaseOrderDetailsByID(product_code, QtyPurchase,value);
        });
}
function CetakPO(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/purchase/CetakPO/" + notrs , "_blank",
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
function number_to_price_input(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
// function price_to_number(v) {
//     if (!v) { return 0; }
//     v = v.split('.').join('');
//     v = v.split(',').join('.');
//     return Number(v.replace(/[^0-9.]/g, ""));
// }
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/purchase/list";
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

    async function goClosePurchaseOrder(param) {
        try {
            $(".preloader").fadeIn();
            const datagoClosePurchaseOrder = await goClosePurchaseOrder2(param);
            updateUIdatagoFinishPurchaseOrder2(datagoClosePurchaseOrder);
        } catch (err) {
            toast(err, "error")
        }
    }

    function goClosePurchaseOrder2(param) {
        var No_Transaksi = document.getElementById("No_Transaksi").value;
        var url2 = "/SIKBREC/public/purchase/goClosePurchaseOrder";
        var base_url = window.location.origin;
        let url = base_url + url2;
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param
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