$(document).ready(function () {
    loadDataPegById();
    LoadData();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#formUploadManual').submit(
        function (e) {
        
            var form_data = new FormData(); 
           // form_data.append("file", $('input[type=file]')[0].files[0]); 
            form_data.append("file", $("#saksi_rumah_sakit").val());
            form_data.append("IdTranasksiAuto", $("#IdTranasksiAuto").val());
            form_data.append("Mst_NamaPegawai", $("#Mst_NamaPegawai").val());
            form_data.append("Mst_Username", $("#Mst_Username").val());
            form_data.append("Mst_PinTTD", $("#Mst_PinTTD").val());
            
            $.ajax({
                url: base_url + '/SIKBREC/public/MasterLoginUser/uploadDataTTD/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    // console.log(data);
                    $(".preloader").fadeOut();
                    if (data.status == 'warning'){
                    toast(data.message,'error');
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
async function verifiedOtpSign(){
    try {
        const dgetsendOtpVerified = await getverifiedOtpSign();
        console.log("dgetsendOtpVerified",dgetsendOtpVerified);
        updategetverifiedOtpSign(dgetsendOtpVerified);
    } catch (err) {
        toast(err, "error")
    }
}
function updategetverifiedOtpSign(response){
    if(response.status == "success"){
        toast(response.message, "success")
        $('#verifyOtp').modal('hide');
    }else{
        toast(response.errorname, "error")
    }
}
function getverifiedOtpSign() {
    var base_url = window.location.origin;
    var Mst_PinTTD =  $("#Mst_PinTTD").val();
    var Mst_Username =  $("#Mst_Username").val();
    var otp_verify =  $("#otp_verify").val();
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getverifiedOtpSign';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Mst_PinTTD=" + Mst_PinTTD + "&Mst_Username=" + Mst_Username+ "&otp_verify=" + otp_verify
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
async function sendOtpVerified(){
    try {
        const dgetsendOtpVerified = await getsendOtpVerified();
        console.log("dgetsendOtpVerified",dgetsendOtpVerified);
        updatedgetsendOtpVerified(dgetsendOtpVerified);
    } catch (err) {
        toast(err, "error")
    }
}
function updatedgetsendOtpVerified(response){
    if(response.status == "success"){
        toast(response.errorname, "success")
        $('#verifyOtp').modal('show');
    }else{
        toast(response.errorname, "error")
    }
}
function getsendOtpVerified() {
    var base_url = window.location.origin;
    var Mst_PinTTD =  $("#Mst_PinTTD").val();
    var Mst_Username =  $("#Mst_Username").val();
    
    let url = base_url + '/SIKBREC/public/MasterLoginUser/sendotpVerifikasiSign';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "Mst_PinTTD=" + Mst_PinTTD + "&Mst_Username=" + Mst_Username
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
async function loadDataPegById() {
    try {
        const dtGetDataPegawaiById = await GetDataPegawaiById();
        console.log("dtGetDataPegawaiById",dtGetDataPegawaiById);
        updateUGetDataPegawaiById(dtGetDataPegawaiById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUGetDataPegawaiById(data){
    console.log(data)
    // $("#JenisPegawai").val(data.Jenis_Pegawai);
    // $("#NamaPegawai").val(data.Nama);
    // $("#nikPegawai").val(data.Nip); 
    $("#Mst_NamaPegawai").val(convertEntities(data.username));
    $("#Mst_Username").val(convertEntities(data.NoPIN));
    $("#Mst_PinTTD").val(convertEntities(data.TTD_Pegawai));
}
function GetDataPegawaiById() {
    var base_url = window.location.origin;
    var id =  $("#IdTranasksiAuto").val();
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getDatapegawaiTTD';
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
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URL + '" data-title="' + row.FileDocument + '" width="100" height="100">';
                        return html
                }
            },
            { "data": "Mst_PinTTD" },
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