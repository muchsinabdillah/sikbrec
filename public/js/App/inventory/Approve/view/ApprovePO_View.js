$(document).ready(function () {
    onLoadFunctionAll();
    $("#Jenis_Requestx").attr("disabled", true);
    $("#Unit_Requestx").attr("disabled", true);

    $("#Jenis_Requestx").select2();
    $('#datatable_pr').dataTable({})

    $('#btnSave').click(function () {
        $("#Modal_Approve").modal('show');
    });

        $("#nopin").keyup(function(event) {
            if (event.keyCode === 13) {
                goGetApproveName();
            }
        });


    //$(".preloader").fadeOut();

});



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
        $("#PO_KodeSupplier").val(data.data[0].SupplierCode).trigger('change');
        showDataDetil_PO(data.data[0].PurchaseCode);
        unlockBtnCreate();

        $("#grandtotalqty").val(data.data[0].TotalQtyPO);
        //$("#diskonxRp").val(data.data[0].TotalQtyDO);
        $("#subtotalttlrp").val(data.data[0].SubtotalPurchase);
        //$("#taxxRp").val(data.data[0].TaxDelivery);
        $("#grandtotalxl").val(data.data[0].GrandtotalPurchase);

       // $("#btnSearching").attr('disabled', true);

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

async function onLoadFunctionAll() {
    try {

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
        $("#PO_KodeSupplier").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#PO_KodeSupplier").append(newRow);
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
            $("#PO_KodeSupplier").select2();
        })
}


//GET HDR PR
async function ShowDetailPRbyID(param) {
    try {
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
        //$('#pr_ketTransaksi').val(params.data[0].Notes);
        unlockBtnCreate();


       // $('#btnSearching_modal').modal('hide');
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
            //$(".preloader").fadeOut();
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


}

function CalculateItemsTaxTotal() {
    var taxrp = 0;
    var grandtotalrp = 0;
    var hrgstlhtaxloop = 0;
    var grantotalxloop = 0;
    var grandtotalqty = 0;
    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_taxprosen_" + i);
        subtotaltemp = document.getElementById("hidden_subtotal_" + i);

        //console.log(itemID);
        var qty = $("#hidden_qty_barang_" + i).val();
        var Harga = $("#hidden_harga_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_taxprosen_" + i);
            //console.log(itemID);
        } else {
            taxrp = (parseFloat(itemID.value) * parseFloat(subtotaltemp.value)) / 100;
            grandtotalrp = parseFloat(subtotaltemp.value) + taxrp;
            hrgstlhtaxloop = hrgstlhtaxloop + taxrp;
            grantotalxloop = grantotalxloop + grandtotalrp;

        }
        // $("#hidden_taxrp_" + i).val(taxrp);
        // $("#hidden_grandtotal_" + i).val(grandtotalrp);

    }
    $("#taxxRp").val(hrgstlhtaxloop);
    //$("#grandtotalxl").val(grantotalxloop);


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


//GET DTL PO
// function showDataDetil_PO(TransasctionCode) {
//     //var TransasctionCode = document.getElementById("IdAuto").value;
//     total_items = 0;
//     var dataHandler = $("#user_data");
//     dataHandler.html("");

//     // var TransasctionCode = "TPR160820220002"; 
//     var base_url = window.location.origin;
//     var url2 = "/SIKBREC/public/purchase/getPurchaseOrderDetailbyID/";

//     $.ajax({
//         type: "POST",
//         data: "TransasctionCode=" + TransasctionCode,
//         url: base_url + url2,
//         success: function (result) {
//             //console.log(result);
//             var resultObj = JSON.parse(result);
//             $.each(resultObj, function (key, val) {
//                 total_items = total_items + 1;
//                 $("#totalrow").val(total_items);
//                 // document.getElementById('totalrow').innerHTML = total_items;
//                 var newRow = $("<tr id='row_'" + total_items + "'>");
//                 newRow.html("<td><font size='1'>" + total_items + "</td><td>" + val.ProductCode +
//                     "<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'" + total_items + "' value='" + val.ProductCode +
//                     "' ></font></td><td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +
//                     "' ></font></td> <td>" + val.ProductSatuan + "<input readonly type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +
//                     "' value='" + val.ProductSatuan +
//                     "' ></td> <td>" + val.QtyPR + "<input type='hidden'  readonly name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items +
//                     "' value='" + val.QtyPR +
//                     "' ></td>  <td><input  size='2' readonly  type='text' onkeyup='CalculateQty()'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +
//                     "' value='" + val.QtyPurchase +
//                     "' ></td>  <td ><input size='5' readonly   type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items +
//                     "' class='harga' onkeyup='CalculateItemsValue()' value='" + val.Price + "' ></td><td><input size='1' readonly value='" + val.DiscountProsen + "' onkeyup='CalculateItemsValueDiscon()' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +
//                    /*dihhiden*/ "' ></td> <td><input size='5' readonly='true' value='" + val.DiscountRp + "' type='hidden' readonly name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +
//                     "' ><input size='5' readonly='true' value='"+val.DiscountRpTTL+"' type='text' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td>  <td><input size='7' readonly='true' value='" + val.SubtotalPurchase + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +
//                     "' ></td><td><input size='1' value='" + val.TaxProsen + "' type='text' readonly onkeyup='CalculateItemsTax()'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +
//                     "' ></td> <td><input size='5' readonly='true' value='" + val.TaxRpTTL + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items +
//                     /*dihhiden*/"' ><input size='5' value='"+val.TaxRp+"' readonly='true' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td> <td><input size='8' readonly='true'  value='" + val.TotalPurchase + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +
//                     "' ></td>" +
//                     "  </tr>")
//                     ;


//                 dataHandler.append(newRow);
//             });
//             // CalculateQty();
//              CalculateItemsValueDisconTotal();
//             // CalculateItemsValue();
//              CalculateItemsTaxTotal();


//         }
//     });

//     //$(".preloader").fadeOut();
// }

function showDataDetil_PO(notrs) {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/purchase/getPurchaseOrderDetailbyID",
            "type": "POST",
            "data": {
                TransasctionCode: notrs,
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductName + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductSatuan + ' </font>  ';
                    return html
                }
            },
            { "data": "QtyPR" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "QtyPurchase" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "Price" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "DiscountProsen" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "DiscountRp" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "SubtotalPurchase" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "TaxProsen" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "TaxRp" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "TotalPurchase" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            var i = 5;
            var n = i+8;
              for (;i < n; i++) {
                total = api
                .column( i )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
            pageTotal = api
                .column( i, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( i ).footer() ).html(
                $.fn.dataTable.render.number( '.',',',2,'').display( total )
            );
              }
        },
    });
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


async function goGetApproveName() {
    try {
        const dataGetApproveName = await GetApproveName();
        updateUIdataGetApproveName(dataGetApproveName);
    } catch (err) {
        toast(err, "error")
        $("#nama_ext").val('');
        $("#nopin_ext").val('');
        var parent = $('embed#file').parent();
        var newElement = "<embed src='' id='file'>";
        $('embed#file').remove();
        parent.append(newElement);
    }
}
function updateUIdataGetApproveName(params) {
        //toast(params.message, params.status);

        if (params.data.FileDocument == null){
            toast('Tanda Tangan Tidak Ditemukan !', 'warning');
        }else{
            $("#nama_ext").val(params.data.username);
            $("#nopin_ext").val(params.data.NoPIN);
            var parent = $('embed#file').parent();
            var newElement = "<embed src='"+params.data.FileDocument+"' id='file'>";
            $('embed#file').remove();
            parent.append(newElement);
            toast('No PIN Berhasil dan Tanda Tangan Ditemukan !', 'success');
            $("#btnSearching").focus();
        }
       
}
function GetApproveName() {
    var base_url = window.location.origin;
    var nopin = $("#nopin").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/GetApproveName/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'nopin=' + nopin 
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

async function goSaveApprove() {
    try {
        const dataSaveApprove = await SaveApprove();
        updateUIdataSaveApprove(dataSaveApprove);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataSaveApprove(params) {
    if(params.status === true){
        toast(params.message, "success")
        swal({
            title: 'Success',
            text: params.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    }else{
        toast(params.message, "error")
    }
}
function SaveApprove() {
    var base_url = window.location.origin;
    //var nopin = $("#nopin").val();
    var nopin_ext = $("#nopin_ext").val();
    var no_trs = $("#No_Transaksi").val();
    var approve_ke = $("#approve_ke").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/SaveApprovePO/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'no_trs=' + no_trs +
              '&nopin_ext=' + nopin_ext +
              '&approve_ke=' + approve_ke
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/InventoryApprove/ListApprovePO";
}