$(document).ready(function () {
    $(".preloader").fadeIn();
    //$(".preloader").fadeOut();
    asyncShowMain(); 
    // buton save ditekan
    // const saveButton = document.querySelector('#btnSave');
    // saveButton.addEventListener('click', async function () {
    //     try {
    //         const result = await saveGolongan();
    //         console.log(result);
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             setTimeout(function () { MyBack(); }, 1000);
    //         }

    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // })
    $('#pr_btnSave').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goeditPurchaseRequisition();
                } else {
                    swal("Transaction Rollback !");
                }
            });

    });
    $('#btnprint').click(function () {
        $('#notif_Cetak').modal('show');
    });
    $(document).on('click', '#cetakan', function () {
        var No_Transaksi = $("#IdAuto").val();
        if (No_Transaksi == ''){
                toast('No Transaksi Tidak Ditemukan !', "warning")
                return false
            }
        PrintBuktiPR(No_Transaksi);
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

    $('#pr_btn_batal').click(function () {

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
                goVoidPurchaseRequisition(value);
            });

    });
    $('#pr_btnAdd').click(function () {
        AddRow();
    });

    $("#qty_Barang").keyup(function(event) {
        if (event.keyCode === 13) {
            AddRow();
        }
    });

    $("#nama_Barang").keyup(function(event) {
        if (event.keyCode === 13) {
            getBarangbyId();
        }
    });
    

    $('#btnNewPurchase').click(function () {
       createHeaderTrs();
    });
    // $("#nama_Barang").select2({
    //     ajax: {
    //         url: function (params) {
    //             return window.location.origin + '/SIKBREC/public/PurchaseForm/getDataBarangbyName';
    //         },
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 searchTerm: params.term,
    //                 grupBarang: $('#pr_jenistransaksi').val()
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 3
    // });
    
    // $("#nama_Barang").autocomplete({

    //     serviceUrl: window.location.origin + "/SIKBREC/public/PurchaseForm/getDataBarangbyName", 
    //     cache: false,
    //     dataType: "JSON", // Tipe data JSON.
    //     onSelect: function (data) {
    //      // $("#kodeFormularium").val("" + data.kodetype);
    //      console.log(data);
          
    //       }

    //   });


        $( "#nama_Barang" ).autocomplete({
          source: function( request, response ) {
            $.ajax({
              url: window.location.origin + "/SIKBREC/public/PurchaseForm/getDataBarangbyName",
              dataType: "json",
              type: 'post',
              data: {
                searchTerm: request.term,
                grupBarang: $('#pr_jenistransaksi').val()
              },
              success: function( data ) {
                response( data );
              }
            });
          },
          
          minLength: 3,
          select: function(event, ui)
            {
                $(this).val(ui.item.label);
                $("#xIdBarang").val(ui.item.id);
                $("#qty_barang").focus();
                getBarangbyId(ui.item.id);
                //event.keyCode === 9;
                //document.valueSelectedForAutocomplete = ui.item.id 
                //$(this).closest('tr').find("input[id^='drawing_number']").val(ui.item.dwg); 
                return false; 
            }
    })

    //add bpjs
    // $('#nama_Barang').on('change', function (e) {
    //     var data = e.params.data; 
    //     $("#xIdBarang").val(data.id);
    //     $("#xNamaBarang").val(data.text);

    //     getBarangbyId(data.id)
    // });

    // $("#nama_Barang").click(function(){   // 1st way
    //     var data = e.params.data; 
    //     $("#xIdBarang").val(data.id);
    //     $("#xNamaBarang").val(data.text);

    //     getBarangbyId(data.id)
    // });
    
});

async function getBarangbyId(param) {
    try {
        //var param = $("#xIdBarang").val();
        const datagetBarangbyId = await getBarangbyId2(param);
        updateUIdatagetBarangbyId(datagetBarangbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetBarangbyId(params) {
    if (params.status === 'success') { 
        $("#xNamaBarang").val(params.data[0]['Product Name']);
        $("#xIdBarang").val(params.data[0]['ID']);
        $("#SatuanBarang").val(params.data[0]['Satuan_Beli']);
        $("#SatuanBarang_Konversi").val(params.data[0]['Unit Satuan']);
        $("#Konversi_Satuan").val(params.data[0]['Konversi_satuan']);
        $("#qty_Barang").focus();

    } else {
        toast(params.message, "error")
    }
}

function getBarangbyId2(param) {
    var base_url = window.location.origin; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/getBarangbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDbarang=' + param 
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

async function goVoidPurchaseRequisition(param) {
    try {
        $(".preloader").fadeIn();
        const dtax = await goVoidPurchaseRequisition2(param);
        updateUIdatagoVoidPurchase(dtax);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoVoidPurchase(params) {
    if (params.status === true) { 
        toast(params.message, "success")
        //MyBack();
        swal({
            title: 'Success',
            text: params.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    } else {
        toast(params.message, "error")
    }
}
function goVoidPurchaseRequisition2(param) {
    var base_url = window.location.origin; 
    var TransasctionCode = document.getElementById("IdAuto").value;
    var Void = "1"; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/voidPurchaseRequisition/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode 
            + '&Void=' + Void 
            + '&AlasanBatal=' + param
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
async function goeditPurchaseRequisition() {
    try {
        $(".preloader").fadeIn();
        const dataeditPurchaseRequisition = await editPurchaseRequisition();
        updateUIdataeditPurchaseRequisition(dataeditPurchaseRequisition);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataeditPurchaseRequisition(params) {
    if(params.status === true){
        toast(params.message, "success")
        //MyBack();
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
function editPurchaseRequisition() {
    var base_url = window.location.origin;
    var date = document.getElementById("pr_TglTransaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var TransasctionCode = document.getElementById("IdAuto").value;
    var TotalQty = document.getElementById("pr_totalQty").value;
    var TotalRow = document.getElementById("pr_totalRow").value;
    var Notes = document.getElementById("pr_ketTransaksi").value;
    let url = base_url + '/SIKBREC/public/PurchaseForm/editPurchaseRequisition/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionDate=' + TransasctionDate
            + '&TransasctionCode=' + TransasctionCode
            + '&TotalQty=' + TotalQty
            + '&TotalRow=' + TotalRow
            + '&Notes=' + Notes
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
async function createHeaderTrs() {
    try {
        $(".preloader").fadeIn();
        const dataGocreateHdr = await GocreateHdr();
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}
async function asyncShowMain() {
    try {
        //await getHakAksesByForm(12); 
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#IdAuto").val();
        disableAll();
        if (id != ""){
            const dataGetPurchasebyId = await GetPurchasebyId();  
            updateUIdataGetPurchasebyId(dataGetPurchasebyId); 
            showDataDetil();
            enableAll();
            $("#btnNewPurchase").attr('disabled', true);
        }
        $(".preloader").fadeOut();
       
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetPurchasebyId(params) {
    if(params.status === true ){
        console.log("params.status", params.data[0].Approved);
        var tgltrs = params.data[0].TransasctionDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        console.log(d.toISOString());
        $('#pr_TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));

        // $('#pr_TglTransaksi').val(params.data[0].TransasctionDate);
        $('#pr_userEntriCode').val(params.data[0].UserCreate);
        $('#pr_userEntri').val(params.data[0].NamaUserCreate);
        $('#pr_status').val(params.data[0].StatusPR); 
        $('#pr_unitTrnasaksi').val(params.data[0].Unit).trigger('change');
        $('#pr_jenistransaksi').val(params.data[0].Type).trigger('change');
        $('#pr_ketTransaksi').val(params.data[0].Notes);
        $("#pr_jenistransaksi").attr('disabled', true);

        if (params.data[0].StatusPR == 'APPROVED'){
            $("#btnprint").attr('disabled', false);
            $("#pr_ketTransaksi").attr('readonly', true);
            $("#pr_unitTrnasaksi").attr('disabled', true);
            $('#pr_TglTransaksi').prop('readonly', true);
            
        }else{
            $("#btnprint").attr('disabled', true);
            $('#btnprint').prop('title', 'PR belum diapprove ! Silahkan approve terlebih dahulu !');
        }
    }else{
        toast(params.message,"error")
    }
}
function GetPurchasebyId() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value; 
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
function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#pr_unitTrnasaksi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#pr_unitTrnasaksi").append(newRow);
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
            $("#pr_unitTrnasaksi").select2();
        })
}
function disableAll() { 
    document.getElementById("pr_status").disabled = true;  
    document.getElementById("xNamaBarang").disabled = true;
    document.getElementById("xIdBarang").disabled = true;
   // document.getElementById("qty_Barang").disabled = true; 
    document.getElementById("SatuanBarang").disabled = true;
    $("#pr_btnAdd").attr('disabled', true);
    $("#pr_btn_kembali").attr('disabled', true);
    $("#pr_btn_batal").attr('disabled', true);
    $("#pr_btnSave").attr('disabled', true); 
    $("#nama_Barang").attr('disabled', true);
    $("#qty_Barang").attr('disabled', true);
}
function enableAll() {
    document.getElementById("pr_TglTransaksi").disabled = false;
    document.getElementById("pr_status").disabled = false;
    //document.getElementById("pr_jenistransaksi").disabled = false;
    //document.getElementById("pr_unitTrnasaksi").disabled = false;
    document.getElementById("pr_ketTransaksi").disabled = false;
    document.getElementById("xNamaBarang").disabled = false;
    document.getElementById("xIdBarang").disabled = false;
    document.getElementById("qty_Barang").disabled = false;
    document.getElementById("SatuanBarang").disabled = false;
    $("#pr_btnAdd").attr('disabled', false);
    $("#pr_btn_kembali").attr('disabled', false);
    $("#pr_btn_batal").attr('disabled', false);
    $("#pr_btnSave").attr('disabled', false);
    $("#nama_Barang").attr('disabled', false);
    $("#qty_Barang").attr('disabled', false);
    
}



function updateUIdataGocreateHdr(dataResponse) {
    if (dataResponse != null || dataResponse != ''){
        // swal({
        //     title: "Success",
        //     text: 'Berhasil Membuat Transaksi Baru!',
        //     icon: "success",
        // });
        $('#IdAuto').val(dataResponse);
        $("#btnNewPurchase").attr('disabled', true);
        $("#pr_jenistransaksi").attr('disabled', true);
        enableAll();
    }else{
        swal({
            title: "Gagal",
            text: 'Gagal Membuat Transaksi Baru!',
            icon: "error",
        });
    }
    
}
function GocreateHdr() {
    var base_url = window.location.origin;
    var  date  = document.getElementById("pr_TglTransaksi").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var Type = document.getElementById("pr_jenistransaksi").value; 
    var Unit = document.getElementById("pr_unitTrnasaksi").value;
    var pr_ketTransaksi = document.getElementById("pr_ketTransaksi").value; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/createHeaderTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionDate=' + TransasctionDate  
            + '&Type=' + Type
            + '&Unit=' + Unit
            + '&Notes=' + pr_ketTransaksi
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PurchaseForm/list";
} 
async function AddRow(){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtl = await GocreateDtl();
        updateUIdataGocreateDtl(dataGocreateDtl);
        showDataDetil();
    } catch (err) {
        toast(err, "error")
    }
}

function showDataDetil() {
    var TransasctionCode = document.getElementById("IdAuto").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionDetailbyID/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.TransasctionCode = TransasctionCode; 
            }
        },
        "columns": [
        
            
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductCode + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductName + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Satuan + '</font>  ';
                    return html
                }
            },
            { "data": "QtySafe" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
             
            { "data": "QtyPR", render: $.fn.dataTable.render.number('.', ',', 2, '') },  // 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-gold btn-animated btn-xs"  onclick="goVoidDetails(' + row.ProductCode + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
         

            total15 = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 

            $(api.column(5).footer()).html(
                $.fn.dataTable.render.number('.', ',', 2,'').display(total15)
            );
            $("#pr_totalQty").val(total15);
            var table = $('#tbl_aktif').DataTable();
            var table_length = table.data().count();
            $("#pr_totalRow").val(table_length)
            
             
        },
    });
    //$(".preloader").fadeOut();
} 
function updateUIdataGocreateDtl(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        toast(dataResponse.message, "success")
        $('#nama_Barang').val('');
        $('#xNamaBarang').val('');
        $('#xIdBarang').val('');
        $('#qty_Barang').val('');
        $('#SatuanBarang').val('');
        $('#SatuanBarang_Konversi').val('');
        $('#Konversi_Satuan').val('');
        $("#nama_Barang").focus();
    }
     
}
function GocreateDtl() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value;
    var ProductName = document.getElementById("xNamaBarang").value;
    var ProductCode = document.getElementById("xIdBarang").value;
    var QtyPR = document.getElementById("qty_Barang").value;
    var SatuanBarang = document.getElementById("SatuanBarang").value;
    var SatuanBarang_Konversi = document.getElementById("SatuanBarang_Konversi").value;
    var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/PurchaseForm/createDtlTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
            + '&ProductCode=' + ProductCode
            + '&ProductName=' + ProductName
            + '&QtyPR=' + QtyPR 
            + '&SatuanBarang=' + SatuanBarang 
            + '&SatuanBarang_Konversi=' + SatuanBarang_Konversi 
            + '&Konversi_Satuan=' + Konversi_Satuan 
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
$(document).on('click', '.remove_details', function () {
    var row_id = $(this).attr("id");
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $('#row_' + row_id + '').remove();
            var count = $('#totalrow').val();
            //console.log(count);
            count = count - 1 ;
            document.getElementById('grantotalOrder').innerHTML = count;
            $('#totalrow').val(count);
            toast('Berhasil Hapus !', "success")
        } else {
          //swal("Your imaginary file is safe!");
        }
      });

    });
    function PrintBuktiPR(idParams){
        var notrs = btoa(idParams); 
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/PurchaseForm/PrintBuktiPR/" + notrs , "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
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

function goVoidDetails(product_code) {
    swal({
        title: "Simpan",
        text: "Apakah Anda ingin Hapus Item Ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                deletedetilPerItem(product_code);
            } else {
               // swal("Transaction Rollback !");
            }
        });
}

async function deletedetilPerItem(product_code) {
    try {
        $(".preloader").fadeIn();
        const data = await deletedetilPerItem2(product_code);
        updateUIdeletedetilPerItem2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdeletedetilPerItem2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil();
    } else {
        toast(data.message, "error")
    }
}

function deletedetilPerItem2(product_code) {
    var No_Transaksi = document.getElementById("IdAuto").value;
    var url2 = "/SIKBREC/public/PurchaseForm/voidPurchaseRequisitionDetailbyItem/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&product_code=" + product_code 
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