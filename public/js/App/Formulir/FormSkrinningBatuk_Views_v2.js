$(document).ready(function () {
    loadDataPasienId();
    // LoadData();
    // const base_url = window.location.origin;
    // $(".preloader").fadeOut();
    // $('#formUploadManual').submit(
    //     function (e) {
        
    //         var form_data = new FormData(); 
    //        // form_data.append("file", $('input[type=file]')[0].files[0]); 
    //         form_data.append("file", $("#saksi_rumah_sakit").val());
    //         form_data.append("IdTranasksiAuto", $("#IdTranasksiAuto").val());
    //         form_data.append("Mst_NamaPegawai", $("#Mst_NamaPegawai").val());
    //         form_data.append("Mst_Username", $("#Mst_Username").val());
            
    //         $.ajax({
    //             url: base_url + '/SIKBREC/public/MasterLoginUser/uploadDataTTD/',
    //             type: 'POST',
    //             data: form_data,
    //             processData: false,
    //             contentType: false,
    //             dataType: "JSON",
    //             beforeSend: function () {
    //                 $(".preloader").fadeIn();
    //             },
    //             success: function (data) {
    //                 $(".preloader").fadeOut();
    //                 swal({
    //                     title: "Success",
    //                     text: data.message,
    //                     icon: "success",
    //                 })
    //                     .then((willDelete) => {
    //                         if (willDelete) {
    //                             location.reload();
    //                         } else {
    //                             swal("Transaction Rollback !");
    //                         }
    //                     });
    //             }, error: function (data) {
    //                 // Welcome notification
    //                 toastr.options = {
    //                     "closeButton": true,
    //                     "debug": false,
    //                     "newestOnTop": false,
    //                     "progressBar": false,
    //                     "positionClass": "toast-top-right",
    //                     "preventDuplicates": false,
    //                     "onclick": null,
    //                     "showDuration": "300",
    //                     "hideDuration": "1000",
    //                     "timeOut": "3500",
    //                     "extendedTimeOut": "1000",
    //                     "showEasing": "swing",
    //                     "hideEasing": "linear",
    //                     "showMethod": "fadeIn",
    //                     "hideMethod": "fadeOut"
    //                 }
    //                 toastr["error"](data.responseText);
    //                 $(".preloader").fadeOut();
    //             }
    //         });
    //         e.preventDefault();

    //     }
    // );
});

async function loadDataPasienId() {
    try {
        const dtGetDataPasienById = await GetDataPasienById();
        console.log("dtGetDataPasienById",dtGetDataPasienById);
        updateUGetDataPasienById(dtGetDataPasienById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUGetDataPasienById(data){
    console.log(data)
    // $("#JenisPegawai").val(data.Jenis_Pegawai);
    // $("#NamaPegawai").val(data.Nama);
    // $("#nikPegawai").val(data.Nip); 
    $("#NamaPasien").val(convertEntities(data.PatientName));
    $("#tglregistrasi").val(convertEntities(data.NoPIN));
    $("#NoMR").val(convertEntities(data.usesrname));
    $("#NoRegistrasi").val(convertEntities(data.NoPIN));
    $("#poliklinik").val(convertEntities(data.username));
    $("#Mst_Username").val(convertEntities(data.NoPIN));
}
function GetDataPasienById() {
    var base_url = window.location.origin;
    var id =  $("#IdTranasksiAuto").val();
    let url = base_url + '/SIKBREC/public/aFormSkrinning/getDataPasienTTD';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + id
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterLoginUser/";
}

function LoadData() {
    var doc_nomr = document.getElementById("IdTranasksiAuto").value;
    var base_url = window.location.origin;
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + '/SIKBREC/public/MasterLoginUser/getDataListTTD',
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.doc_nomr = doc_nomr;
            }
        },
        "columns": [

            { "data": "IdTranasksiAuto" }, 
            { "data": "Mst_NamaPegawai" }, 
            { "data": "Mst_Username" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    // if (row.EXTENSION == "pdf") {
                    //     var html = ""
                    //     var html = '<span class="badge bg-danger">PDF File</span>';
                    //     return html
                    // }else{
                    //     var html = ""
                    //     var html = '<img class="img-thumbnail" src="' + row.URL + '" data-title="' + row.JenisDocument + '" width="100" height="100">';
                    //     return html
                    // }
                    var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URL + '" data-title="' + row.FileDocument + '" width="100" height="100">';
                        return html
                }
            },

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowrujukanDataMulti("' + row.URL + '")\'   ><span class="visible-content" > View File</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },


        ]
    });

}

function ShowrujukanDataMulti(params) {
    window.open(params, "_blank");
}