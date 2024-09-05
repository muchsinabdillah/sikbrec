$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    //showDataDetil_DO('TDO070120240001');

    $('#btnSearchMutasi').click(function () {
        $('#btnSearching_modal').modal('show');
    });

    $('#btnNewPurchase').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin buat transaksi baru ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    createHeaderTrs();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
     });

     $('#btnSave').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goSaveReturBeli();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });

    $("#nama_Barang").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/PurchaseForm/getDataBarangbyName';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    //add bpjs
    $('#nama_Barang').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#xIdBarang").val(data.id);
        $("#xNamaBarang").val(data.text);

        getBarangbyId(data.id)
    });


    $("#btnAdd").click(function () { 

        if($("#xNamaBarang").val() == ''){
            $("#xNamaBarang").focus();
            toast("Nama Barang Kosong !", 'warning');
            return false;
        }

        if($("#Qty").val() == '' || $("#Qty").val() == 0 ){
            $("#Qty").focus();
            toast("Qty Kosong !", 'warning');
            return false;
        }

          if($('#totalrow_closing').val()==0){
            var count =0;
          }else{
            var count = parseFloat($('#totalrow_closing').val());
          }
          count = count + 1;
          document.getElementById('grantotalOrder_closing').innerHTML = count;
          $('#totalrow_closing').val(count);

        hidden_kode_barang = $('#xIdBarang').val();
          hidden_nama_barang_ = $('#xNamaBarang').val();
          hidden_satuan_barang_ = $('#Satuan').val();
          hidden_min_barang_ = $('#Qty').val();
          hidden_qty_barang_ = 5;
          hidden_hpp_barang_ = 5;
          hidden_total_barang_ = 5;

            output = '<tr id="row_closing_' + count + '">';
            output += '<td>' + hidden_kode_barang+ ' <input type="hidden" name="hidden_kode_barang[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_kode_barang+ '" /></td>';
            output += '<td>' + hidden_nama_barang_+ ' <input type="hidden" name="hidden_nama_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_nama_barang_+ '" /></td>';
            output += '<td>' + hidden_satuan_barang_+ ' <input type="hidden" name="hidden_satuan_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_satuan_barang_+ '" /></td>';
            output += '<td>' + hidden_min_barang_ + ' <input type="hidden" name="hidden_min_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_min_barang_ + '" /></td>';
            output += '<td>' + hidden_qty_barang_+ ' <input type="hidden" name="hidden_qty_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_qty_barang_+ '" /></td>';
            output += '<td>' + hidden_hpp_barang_+ ' <input type="hidden" name="hidden_hpp_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_hpp_barang_+ '" /></td>';
             output += '<td>' + hidden_total_barang_+ ' <input type="hidden" name="hidden_total_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_total_barang_+ '" /></td>';
            output += '<td><button type="button" title="Hapus" name="remove_details_closing" class="btn btn-danger btn-sm remove_details_closing" id="' +
              count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';
            $('#user_data_closing').append(output);
            
            //$("#nama_Barang").select2('destroy');
            $("#xNamaBarang").val("");
            $("#Satuan").val("");
            $("#Qty").val('');
            
    });

    $(document).on('click', '.remove_details_closing', function () {
    var row_id = $(this).attr("id");
    console.log(row_id);
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $('#row_closing_' + row_id + '').remove();
            $('#row_closing_')
            var count = $('#totalrow_closing').val();
            //console.log(count);
            count = count - 1 ;
            document.getElementById('grantotalOrder_closing').innerHTML = count;
            $('#totalrow_closing').val(count);
            toast('Berhasil Hapus !', "success")
        } else {
          //swal("Your imaginary file is safe!");
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

//   $(document).on('click', '.remove_details_n', function () {
//     var row_id = $(this).attr("id");
//     console.log(row_id);
//     //$('#row_' + row_id ).remove();return false;
//    // $('#row_' + row_id ).remove();
//     //return false;
//     swal({
//         title: "Are you sure?",
//         text: "Apakah anda yakin Ingin hapus data ini ?",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//       })
//       .then((willDelete) => {
//         if (willDelete) {
//             $('#row_' + row_id + '').remove();
//             var count = $('#totalrow').val();
//             //console.log(count);
//             count = count - 1 ;
//             //document.getElementById('grantotalOrder').innerHTML = count;
//             $("#grantotalOrder").html(count);
//             $('#totalrow').val(count);
//             toast('Berhasil Hapus !', "success")
//         } else {
//           //swal("Your imaginary file is safe!");
//         }
//       });

//     });

});

async function createHeaderTrs() {
    try {
        var  date  = document.getElementById("TglTransaksi").value;  
        var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
        const FormData =  $("#form_hdr").serialize()+'&TransasctionDate='+TransasctionDate;
        const ctlrname = 'ReturBeli';
        const funcname = 'addReturBeliHeader';
        const dataGocreateHdr = await getpostData(FormData,ctlrname,funcname);
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocreateHdr(dataResponse) {
    if(dataResponse.status == true){
        toast(dataResponse.message, "success");
        $('#NoOrderTransaksi').val(dataResponse['data']['notrs']);
        $("#btnNewPurchase").attr('disabled', true);
        showDataDetil_DO($("#NoDeliveryOrder").val());
        enableAll();
        $(".preloader").fadeOut();
    }else{
        toast(dataResponse.message, "error")
    }
}

//----------------------------------------

async function goSaveReturBeli() {
    try {
        var  date  = document.getElementById("TglTransaksi").value;  
        var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
        const FormData =  $("#user_form, #form_hdr").serialize()+'&TransasctionDate='+TransasctionDate;
        const ctlrname = 'ReturBeli';
        const funcname = 'addReturBeliFinish';
        const data = await getpostData(FormData,ctlrname,funcname);
        updateUIdatafinish(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatafinish(params) {
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

function disableAll() { 
    //document.getElementById("pr_status").disabled = true;  
    //  document.getElementById("xNamaBarang").disabled = true;
    //  document.getElementById("xIdBarang").disabled = true;
    //  document.getElementById("qty_Barang").disabled = true; 
    //  document.getElementById("SatuanBarang").disabled = true;
     // $("#btnAdd").attr('disabled', true);
    // $("#pr_btn_kembali").attr('disabled', true);
     $("#btn_batal").attr('disabled', true);
     $("#btnSave").attr('disabled', true); 
      $("#NamaBarang").attr('disabled', true);
     // $("#qty_Barang").attr('disabled', true);
     $("#nama_Barang").attr('disabled', true);
    // $("#btnAdd").attr('disabled', false);
     //$("#btnNewPurchase").attr('disabled', true);
 }
 function enableAll() {
     $("#nama_Barang").attr('disabled', false);
     // document.getElementById("pr_TglTransaksi").disabled = false;
     // document.getElementById("pr_status").disabled = false;
     // document.getElementById("pr_jenistransaksi").disabled = false;
     // document.getElementById("pr_unitTrnasaksi").disabled = false;
     // document.getElementById("pr_ketTransaksi").disabled = false;
    //  document.getElementById("xNamaBarang").disabled = false;
    //  document.getElementById("xIdBarang").disabled = false;
    //  document.getElementById("qty_Barang").disabled = false;
    //  document.getElementById("SatuanBarang").disabled = false;
    //  $("#btnAdd").attr('disabled', false);
     // $("#pr_btn_kembali").attr('disabled', false);
     $("#btn_batal").attr('disabled', false);
     $("#btnSave").attr('disabled', false);
      $("#NamaBarang").attr('disabled', false);
     // $("#qty_Barang").attr('disabled', false);
     // $("#btnAdd").attr('disabled', true);
     //$("#btnNewPurchase").attr('disabled', false);
     
 }

async function asyncShowMain() {
    try {
        $(".preloader").fadeIn();
        await getHakAksesByForm(12); 
        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#NoOrderTransaksi").val();
        disableAll();
        if (id != ""){
            getReturBelibyID(id);
        }
       
    } catch (err) {
        toast(err, "error")
    }
}

function ShowApprovedDatabyDate() {
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
    $('#datatable_pr').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_pr').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/DeliveryOrder/getDeliveryOrderbyPeriode",
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
                    var html = '<font size="1"> ' + row.TransactionCode + ' </font>  ';
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

                    if (row.Approved == '0'){
                        var approve = 'disabled';
                    }else{
                        var approve = '';
                    }
                    // var html = '<button type="button" class="btn btn-primary btn-xs border-primary"  onclick=ShowHeaderbyID("' + row.TransactionCode + '")'+approve+'>Pilih</button>'
                    var html = '<button type="button" class="btn btn-maroon btn-xs border-primary"  onclick=ShowHeaderbyID("' + row.TransactionCode + '") '+approve+'>Pilih</button>'
                    return html
                },
            },
        ]
    });
}

async function getReturBelibyID(param) {
    try {
        const FormData = 'TransactionCode='+param;
        const ctlrname = 'ReturBeli';
        const funcname = 'getReturBelibyID';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIdatagetReturBelibyID(response);
    } catch (err) {
        toast(err, "error")
    }
}

//GET HDR PR
async function ShowHeaderbyID(param) {
    try {
        const FormData = 'NoTrs='+param;
        const ctlrname = 'DeliveryOrder';
        const funcname = 'getDeliveryOrderHeader';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIdatagetDObyID(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function getpostData(data,ctlrname,funcname) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/'+ctlrname+'/'+funcname+'/';
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function updateUIdatagetDObyID(dataResponse) {
    if (dataResponse.status === true) {
        $(".preloader").fadeOut();
        $("#NoDeliveryOrder").val(dataResponse.data[0].TransactionCode);
        $("#LokasiStokx").val(dataResponse.data[0].UnitCode).trigger('change');
        $("#LokasiStok").val(dataResponse.data[0].UnitCode);
        $("#KodeSupplierx").val(dataResponse.data[0].SupplierCode).trigger('change');
        $("#KodeSupplier").val(dataResponse.data[0].SupplierCode);
        $("#LokasiStokx").attr('disabled', true);
        $("#KodeSupplierx").attr('disabled', true);
        toast('Data berhasil dipilih !', 'success');

        enableAll();
        $('#btnSearching_modal').modal('hide');


    } else {
        toast(params.message, "error")
    }
}


function updateUIdatagetReturBelibyID(dataResponse) {
    var tgltrs = dataResponse.data[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
        
    $("#NoOrderMutasi").val(dataResponse.data[0].TransactionOrderCode);
    $("#NoDeliveryOrder").val(dataResponse.data[0].DeliveryCode);
    $("#LokasiStokx").val(dataResponse.data[0].UnitCode).trigger('change');
    $("#KodeSupplierx").val(dataResponse.data[0].SupplierCode).trigger('change');
    $("#Notes").val(dataResponse.data[0].Notes);
    $("#LokasiStok").val(dataResponse.data[0].UnitCode);
    $("#KodeSupplier").val(dataResponse.data[0].SupplierCode);


    $("#btnNewPurchase").attr('disabled', true);
    $("#btnSearchMutasi").attr('disabled', true);
    enableAll()

    showDataDetil_View(dataResponse.data[0].TransactionCode);
}


function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#LokasiStokx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#LokasiStokx").append(newRow);
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
            $("#LokasiStokx").select2();
        })
}

function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeSupplierx").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#KodeSupplierx").append(newRow);
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
            $("#KodeSupplierx").select2();
        })
}

function CalculateALL() {
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
       
        qtyx = document.getElementById("hidden_min_barang_" + i);

        var qty = parseFloat(price_to_number($("#hidden_qty_barang_" + i).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_min_barang_" + i).val()));
        // disconprosen = document.getElementById("hidden_discpros_barang_" + i);
        var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + i).val()));
        //harga = document.getElementById("hidden_harga_barang_" + i);  
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + i).val()));
        // taxprosen = document.getElementById("hidden_taxprosen_" + i); 
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
                //console.log("taxrp_stn",taxrp_stn + ' ' + hargamindiskon + ' '  + parseFloat(taxprosen) + ' ' +parseFloat(disconprosen) + ' ' + parseFloat(harga));
            }
            $("#hidden_discrpttl_barang_" + i).val(number_to_price(totaldiskonrp));
            $("#hidden_discrp_barang_" + i).val(number_to_price(hargamindiskon));
            $("#hidden_subtotal_" + i).val(number_to_price(hargamindiskonQty));
            $("#grandtotalqty" + i).val(number_to_price(qtytotal));
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
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
                /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ></td> '"+
            /*5*/"' <td>" + parseFloat(val.QtyDeliveryRemain) + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + parseFloat(val.QtyDeliveryRemain) + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + parseFloat(val.QtyDeliveryRemain) +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga' onkeydown='FormatCell(this)' value='" + parseFloat(val.Price) + "' ></td><input size='1'  value='" + val.KonversiQty + "' type='hidden' name='KonversiQty[]'   id='KonversiQty" + total_items +"' ></td><input size='1'  value='" + val.Satuan_Konversi + "' type='hidden' name='Satuan_Konversi[]'   id='Satuan_Konversi" + total_items +"' >"+ 
            // /*8*/"' <td><input size='1' readonly value='" + parseFloat(val.DiscountProsen) + "' onkeydown='FormatCell(this)' type='text' name='hidden_discpros_barang_[]'   id='hidden_discpros_barang_" + total_items +"' ></td>'"+
            // /*--9*/"' <td><input size='5' readonly='true' value='" + parseFloat(val.DiscountRp) + "' type='hidden' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ><input size='5' readonly='true' value='" + parseFloat(val.DiscountRpTTL) + "' type='text' name='hidden_discrpttl_barang_[]' id='hidden_discrpttl_barang_" + total_items +"' ></td> '"+
            /*10*/"' <td><input size='7' readonly='true' value='" + parseFloat(val.SubtotalDeliveryOrder) + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            // /*11*/"' <td><input size='1' readonly value='" + parseFloat(val.TaxProsen) + "' type='text' onkeydown='FormatCell(this)'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            // /*--12*/"' <td><input size='5' readonly='true' value='" + parseFloat(val.TaxRpTTL) + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ><input size='5' readonly='true' value='" + parseFloat(val.TaxRp) + "' type='hidden' name='hidden_taxrp2_[]' id='hidden_taxrp2_" + total_items +"' ></td> '"+
            // /*13*/"' <td><input size='8' readonly='true'  value='" + parseFloat(val.TotalDeliveryOrder) + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus> " +
            "</td>  </tr>")
            ;


                dataHandler.append(newRow);
            });
            CalculateALL();
        }
    });

    $(".preloader").fadeOut();
}

//GET DETAIL MUTASI BY ID
function showDataDetil_View(TransasctionCode) {
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/ReturBeli/getReturBeliDetailbyID/";

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
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
             /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.ProductSatuan + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.ProductSatuan +"' ></td> '"+
            /*5*/"' <td>" + parseFloat(val.QtyPurchase) + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + parseFloat(val.QtyPurchase) + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + parseFloat(val.QtyRetur) +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_harga_barang_[]'   id='hidden_harga_barang_" + total_items + "' class='harga' onkeydown='FormatCell(this)' value='" + parseFloat(val.ReturPrice) + "' ><input size='1'  value='" + val.KonversiQty + "' type='hidden' name='KonversiQty[]'   id='KonversiQty" + total_items +"' ><input size='1'  value='" + val.Satuan_Konversi + "' type='hidden' name='Satuan_Konversi[]'   id='Satuan_Konversi" + total_items +"' ></td>"+ 
            /*10*/"' <td><input size='7' readonly='true' value='" + parseFloat(val.TotalReturBeli) + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            /*14*/'<td> <button type="button" onclick=\'goVoidDetails("' + val.ProductCode + '","' + val.ProductName + '","' + val.KonversiQty + '","' + val.QtyRetur + '")\'  name="remove_details" class="btn btn-gold btn-xs remove_details btn-rounded" id="' + total_items + '" >Delete</Hapus> ' +
            "</td>  </tr>")
            ;


                dataHandler.append(newRow);
            });
            CalculateALL();

        }
    });

    $(".preloader").fadeOut();
}



function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/ReturBeli/list";
}

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

function getIDAwal(e){
    $("#LokasiStok").val(e.value);
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
    v = v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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
    CalculateALL();
});
}

async function goVoidHeader(param) {
    try {
        const FormData =  $("#form_hdr").serialize()+'&AlasanBatal='+param;
        const ctlrname = 'ReturBeli';
        const funcname = 'voidReturBeli';
        const data = await getpostData(FormData,ctlrname,funcname);
        updateUIdatafinish(data);
    } catch (err) {
        toast(err, "error")
    }
}


function goVoidDetails(product_code,product_name,konversi_qty,qty_barang) {
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
            goVoidDetailsByID(product_code, value,product_name,konversi_qty,qty_barang);
        });
}

async function goVoidDetailsByID(product_code, param,product_name,konversi_qty,qty_barang) {
    try {
        const FormData =  $("#form_hdr").serialize()+'&AlasanBatal='+param+'&product_code='+product_code+'&product_name='+product_name+'&konversi_qty='+konversi_qty+'&qty_barang='+qty_barang;
        const ctlrname = 'ReturBeli';
        const funcname = 'voidReturBeliDetailbyItem';
        const data = await getpostData(FormData,ctlrname,funcname);
        updateUIdatagoVoidMTDetailsByID2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidMTDetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_View($("#NoOrderTransaksi").val());
    } else {
        toast(data.message, "error")
    }
}