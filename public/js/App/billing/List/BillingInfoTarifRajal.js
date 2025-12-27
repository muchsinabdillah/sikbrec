$(document).ready(function () {
    asyncShowMain();
    $(document).on('click', '#btn_infokasir', function () {
        //checking before get data
        CheckVar();
    });
});

async function asyncShowMain() {
    try { 
        $(".preloader").fadeOut(); 
        $('#tbl_aktif').DataTable({});
        const dataGetLayananPoliPenunjangIgd = await GetLayananPoliPenunjangIgd();
        updateUIGetLayananPoliPenunjangIgd(dataGetLayananPoliPenunjangIgd);
    } catch (err) {
        toast(err, "error")
    }
}

function CheckVar (){
    getDataLaporan();
}

// 25/08/2024
function getDataLaporan() { 
    var gruptarif = $("#gruptarif").val();
    var unitlayanan = $("#unitlayanan").val();
    var jenispasien = $("#jenispasien").val();
    var base_url = window.location.origin;
    
    $('#tbl_aktif').DataTable().clear().destroy();
       $('#tbl_aktif').dataTable({
           "ordering": true, // Set true agar bisa di sorting
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aInfoTarifTindakanBilling/getDataInfoRajal", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.gruptarif = gruptarif;
                d.unitlayanan = unitlayanan;
                d.jenispasien = jenispasien;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "No" },  
            { "data": "namatarif" }, 
            { "data": "NILAI" , render: $.fn.dataTable.render.number( ',', '.', 0,'' )}, 
           ],
         'order' : [1,'asc'],
       });
    
}  


function GetLayananPoliPenunjangIgd() {
    var base_url = window.location.origin;
    var iswalkin = $("#iswalkin").val();
    var idodc = $("#idodc").val();
    let url = base_url + '/SIKBREC/public/MasterDataUnit/GetLayananAll';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val() + "&iswalkin="+iswalkin
        + "&idodc="+idodc
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
            $("#unitlayanan").select2();
        })
}
function updateUIGetLayananPoliPenunjangIgd(dataGetLayananPoliPenunjangIgd) {
    let responseApi = dataGetLayananPoliPenunjangIgd;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#unitlayanan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaUnit + '</option';
            $("#unitlayanan").append(newRow);
        }
    }
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