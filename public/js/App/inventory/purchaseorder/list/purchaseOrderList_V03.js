$(".preloader").fadeOut();
$(document).ready(function () { 
    $(".preloader").fadeOut();
    onLoadFunctionAll(); 
    $('#btnSearching').click(function () {
        getListPurchaseOrderData();
    });
});
function getListPurchaseOrderData() {
    $(".preloader").fadeIn();
    var TglPeriodeAwal = $("[name='TglPeriodeAwal']").val();
    var TglPeriodeAkhir = $("[name='TglPeriodeAkhir']").val();
    var KodeSupplier = document.getElementById("KodeSupplier").value;
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPurchaseOrder/getListPurchaseOrderData",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.TglPeriodeAwal = TglPeriodeAwal;
                d.TglPeriodeAkhir = TglPeriodeAkhir;
                d.KodeSupplier = KodeSupplier;
            }
        },
        "columns": [ 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.no + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_KD_TRS + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_TGL_TRS + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Namapetugas + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Company + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.fs_ket + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FN_TOTAL + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPurchase("' + row.FS_KD_TRS + '")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
async function onLoadFunctionAll() {
    try { 
        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        console.log(datagetSuppliers)
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeSupplier").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#KodeSupplier").append(newRow);
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
            $("#KodeSupplier").select2();
        })
}
function ShowDataPurchase(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aPurchaseOrder/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPurchaseOrder/";
}