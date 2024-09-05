$(document).ready(function () {
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveSatuan();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }else{
                toast(result.message, "error")
            }

        } catch (err) {
            toast(err, "error")
        }
    })

    $("#nama_Barang").keyup(function(event) {
        if (event.keyCode === 13) {
            getBarangbyId();
        }
    });

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
  });

    $('#pr_btnAdd').click(function () {
        AddRow();
    });
});
async function asyncShowMain() {
    try {
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#IdAuto").val();
        if(id != ""){
            const dataGetSatuanbyId = await GetSatuanbyId();  
            updateUIdataGetSatuanbyID(dataGetSatuanbyId); 
        }
        await $(".preloader").fadeOut();
        await getHakAksesByForm(12); 
        
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetSatuanbyID(dataResponse) {
    $("#nama_paket").val(dataResponse.data.nama_paket);
    $("#status").val(dataResponse.data.status);
    $("#user_create").val(dataResponse.data.user_create);
    $("#date_create").val(dataResponse.data.date_create);
    $("#user_update").val(dataResponse.data.user_update);
    $("#date_update").val(dataResponse.data.date_update);
    showDataDetil();
}
function GetSatuanbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterPaketInventory/getPaketInventorybyId/';
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
            //$(".preloader").fadeOut();
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterPaketInventory/list";
}
async function saveSatuan() {

    var formdata = $("#form_data").serialize();
    var IdAuto = $("#IdAuto").val();
    $(".preloader").fadeIn(); 
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    
    
    var url = '';
    if(IdAuto == "" ){
        url = base_url + '/SIKBREC/public/MasterPaketInventory/addData';
    }else{
        url = base_url + '/SIKBREC/public/MasterPaketInventory/editPaketInventory';
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: formdata
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
            document.getElementById("btnSave").disabled = false;
        })
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

function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#UnitCode").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#UnitCode").append(newRow);
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
            $("#UnitCode").select2();
        })
}

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
    var IDHeader = document.getElementById("IdAuto").value;
    // var IDHeader = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterPaketInventory/getDetailPaketInventory/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.IDHeader = IDHeader; 
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
                    var html = '<font size="1"> ' + row.product_id + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.nama_product + '</font>  ';
                    return html
                }
            },
            { "data": "quantity" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
             
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-gold btn-animated btn-xs"  onclick="goVoidDetails(' + row.product_id + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 
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
    var IDHeader = document.getElementById("IdAuto").value;
    var ProductName = document.getElementById("xNamaBarang").value;
    var ProductCode = document.getElementById("xIdBarang").value;
    var QtyPR = document.getElementById("qty_Barang").value;
    var SatuanBarang = document.getElementById("SatuanBarang").value;
    var SatuanBarang_Konversi = document.getElementById("SatuanBarang_Konversi").value;
    var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/MasterPaketInventory/addDetailPaketInventory/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDHeader=' + IDHeader
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

async function deletedetilPerItem2(product_code) {
    var IDHeader = document.getElementById("IdAuto").value;
    var url2 = "/SIKBREC/public/MasterPaketInventory/deleteDetailPaketInventory/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IDHeader=" + IDHeader + "&product_code=" + product_code 
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