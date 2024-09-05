var getUrl = window.location;
var baseUrl2 = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

$(document).ready(function () { 
    asyncShowMain();
    getListDataOrderDetails();
    $(".preloader").fadeOut();
    $('#formUploadManual').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData(); 
            form_data.append("file", $('input[type=file]')[0].files[0]); 
            form_data.append("idtrs", $("#idtrs").val());
            form_data.append("kd_instalasi", $("#kd_instalasi").val());
            form_data.append("TglBerlaku", $("#TglBerlaku").val());
            form_data.append("TglExpired", $("#TglExpired").val());
            $.ajax({
                url: baseUrl2 + '/public/MasterDataTarif/ImportFile/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    if (data.status == 'warning'){
                        toast(data.message, 'warning')
                        return false;
                    }
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.reload();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
                }, error: function (data) {
                    // Welcome notification
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
                    toastr["error"](data.responseText);
                    $(".preloader").fadeOut();
                }
            });
            e.preventDefault();

        }
    );

});


function getListDataOrderDetails() { 
    var base_url = window.location.origin;
    var IdAuto = $("#idtrs").val();
    $('#datadetail').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datadetail').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/MasterDataTarif/getListTransaksiTarif_Detaillab", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.IdAuto = IdAuto
     },
         "dataSrc": "",
    "deferRender": true,
    }, 

    
    "columns": [
                            { "data": "ID_TR_TARIF" },
                            { "data": "ID_TARIF" },
                            { "data": "GROUP_TARIF" },
                            { "data": "NILAI" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ) },
                            { "data": "KLSID" },
                            { "data": "GROUP_TARIF_2" },
                            { "data": "ID_TR_TARIF_PAKET" },
                            { "data": "KD_INSTALASI" },
                            // {
                            //     "render": function (data, type, row) {
                            //         var html = ""
                            //         var html = '<button type="button" class="btn btn-danger btn-xs"  onclick="DeleteLayanan(' + row.id + ')" >Delete</button>'
                            //         return html
                            //     },
                            // },
                           ],
     });
} 

async function asyncShowMain() {
    try {
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatabyID(datagetDatabyID){
    let dataResponse = datagetDatabyID;

        $("#Note").val(convertEntities(dataResponse.data.NOTE));
         $("#TglBerlaku").val(convertEntities(dataResponse.data.TglBerlaku));
         $("#TglExpired").val(convertEntities(dataResponse.data.TglExpired));
         $("#kd_instalasi").val(convertEntities(dataResponse.data.KD_INSTALASI));

}
function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getTransaksiTarifbyIDlab/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#idtrs").val()
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

function getTemplateCSV() {
    const base_url = window.location.origin;
    window.location = base_url + '/SIKBREC/public/upload/TEMPLATE_TRANSAKSI_TARIF.csv';
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}