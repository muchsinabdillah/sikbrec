 
$(document).ready(function () {  
    loadDataPegById();
    LoadData();
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#formUploadManual').submit(
        function (e) {
        
            var form_data = new FormData(); 
            form_data.append("file", $('input[type=file]')[0].files[0]); 
            form_data.append("iddata", $("#iddata").val());
            form_data.append("iddatax", $("#iddatax").val());
            form_data.append("nikPegawai", $("#nikPegawai").val());
            form_data.append("NamaPegawai", $("#NamaPegawai").val()); 
            form_data.append("JenisPegawai", $("#JenisPegawai").val()); 
            // form_data.append("tglAwalSIP", $("#tglAwalSIP").val()); 
            // form_data.append("tglAkhirSIP", $("#tglAkhirSIP").val()); 
            // form_data.append("noSuratSIP", $("#noSuratSIP").val());
            form_data.append("jenisdoc", $("#jenisdoc").val()); 
            $.ajax({
                url: base_url + '/SIKBREC/public/FormDataPegawai/uploadDataSPK/',
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
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.reload();
                                history.go(-1);
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


async function loadDataPegById() {
    // try {
    //     const dtGetDataPegawaiById = await GetDataPegawaiById();
    //     console.log("dtGetDataPegawaiById",dtGetDataPegawaiById);
    //     updateUGetDataPegawaiById(dtGetDataPegawaiById.data);
    // } catch (err) {
    //     toast(err, "error")
    // }

    
    try {
        if($("#iddatax").val() == '' || $("#iddata").val() == null){
            const dtGetDataPegawaiById = await GetDataPegawaiById();
            console.log("dtGetDataPegawaiById",dtGetDataPegawaiById);
            updateUGetDataPegawaiById(dtGetDataPegawaiById.data);
        }
        else{
            const dtGetDataPegawaiById2 = await GetDataPegawaiById2();
            console.log("dtGetDataPegawaiById2",dtGetDataPegawaiById2);
            updateUGetDataPegawaiById2(dtGetDataPegawaiById2.data);
        }
        
    } catch (err) {
        toast(err, "error")
    }
}
function updateUGetDataPegawaiById(data){
    $("#JenisPegawai").val(data.Jenis_Pegawai);
    $("#NamaPegawai").val(data.Nama);
    $("#nikPegawai").val(data.Nip); 
}
function GetDataPegawaiById() {
    var base_url = window.location.origin;
    var iddata =  $("#iddata").val();
    let url = base_url + '/SIKBREC/public/FormDataPegawai/getDatapegawai';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + iddata
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

function updateUGetDataPegawaiById2(data){
    $("#iddata").val(data.Id_data);
    $("#JenisPegawai").val(data.Jenis_Pegawai);
    $("#NamaPegawai").val(data.Nama);
    $("#nikPegawai").val(data.Nip); 


    // ([Id_data]
            // ,[Tgl_Awal]
            // ,[Tgl_Akhir]
            // ,[No_SIP]
            // ,[JenisDocument]
            // ,[FileDocument]
            // ,[Extension]
            // ,[date_update]
            // ,[user_update]
            // ,[Provider])
    
    // $("#tglAwalSIP").val(data.Tgl_Awal); 
    // $("#tglAkhirSIP").val(data.Tgl_Akhir);
    // $("#noSuratSIP").val(data.No_SIP);
    $("#jenisdoc").val(data.JenisDocument);
}

function GetDataPegawaiById2() {
    var base_url = window.location.origin;
    var iddata =  $("#iddatax").val();
    let url = base_url + '/SIKBREC/public/FormDataPegawai/getDataSPKDetail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + iddata
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

function LoadData() {
    var doc_nomr = document.getElementById("iddata").value;
    var base_url = window.location.origin;
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],s
        "ajax": {
            "url": base_url + '/SIKBREC/public/FormDataPegawai/getDataListSPK',
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.doc_nomr = doc_nomr;
            }
        },
        "columns": [

            { "data": "Id_trs" },
            { "data": "Id_data" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.EXTENSION == "pdf") {
                        var html = ""
                        var html = '<span class="badge bg-danger">PDF File</span>';
                        return html
                    }else{
                        var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URL + '" data-title="' + row.JenisDocument + '" width="100" height="100">';
                        return html
                    }
                    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.EXTENSION == "pdf"){
                        var html = ""
                        var html = '<span class="badge bg-danger">' + row.EXTENSION +  '</span>';
                        return html
                    }else{
                        var html = ""
                        var html = '<span class="badge bg-primary">' + row.EXTENSION + '</span>';
                        return html
                    }
                    
                }
            },
            
            { "data": "date_update" },
            { "data": "user_update" }, 

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowrujukanDataMulti("' + row.URL + '")\'   ><span class="visible-content" > View File</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> <button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'showDataGroupShift("'+row.Id_trs+'")\'  ><span class="visible-content" >Edit File</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ]
    });

}
function ShowrujukanDataMulti(params) {
    window.open(params, "_blank");
}

function showDataGroupShift(str) {
    const base_url = window.location.origin;
    window.location = base_url + '/SIKBREC/public/FormDataPegawai/UpdateDataSPK/' + str;
    //typeR = ' + row.Tipe_Rawat + '
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