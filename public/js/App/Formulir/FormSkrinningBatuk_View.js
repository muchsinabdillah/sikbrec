$(document).ready(function () {
    asyncShowMain();
    // buton save ditekan

    // const saveButton = document.querySelector('#btnSave');
    // saveButton.addEventListener('click', async function () {
    //     try {
    //         const result = await saveTransaksiForm();
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             // setTimeout(function () { MyBack(); }, 1000);
    //             setTimeout(() => {
    //                 location.reload();
    //             }, 1000);
    //         }
    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // })

    //edit badrul

    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#formdata').submit(
        function (e) {
        
            var form_data = new FormData(); 
            //form_data.append("file", $('input[type=file]')[0].files[0]); 
            // form_data.append("file", $("#saksi_rumah_sakit").val());
            // form_data.append("file", $("#saksi_pasiens").val());
            form_data.append("saksi_rumah_sakit", $("#saksi_rumah_sakit").val());
            form_data.append("saksi_pasiens", $("#saksi_pasiens").val());
            // form_data.append("IdRegistrasi", $("#IdRegistrasi").val());
            form_data.append("NoMR", $("#NoMR").val());
            form_data.append("NoRegistrasi", $("#NoRegistrasi").val());
            
            // form_data.append("NamaPasien", $("#NamaPasien").val());
            // form_data.append("TglLahir", $("#TglLahir").val());
            // form_data.append("tglregistrasi", $("#tglregistrasi").val());
            // form_data.append("poliklinik", $("#poliklinik").val());

            //console.log($("#case1a").val());return false;
            // form_data.append("case1a", $("#case1a").val());
            // form_data.append("case1b", $("#case1b").val());
            // form_data.append("case1c", $("#case1c").val());
            // form_data.append("case1d", $("#case1d").val());
            // form_data.append("case1e", $("#case1e").val());
            // form_data.append("case2", $("#case2").val());
            // form_data.append("case3a", $("#case3a").val());
            // form_data.append("case3b", $("#case3b").val());
            // form_data.append("case3c", $("#case3c").val());
            // form_data.append("case4a", $("#case4a").val());
            // form_data.append("case4b", $("#case4b").val());
            // form_data.append("case4c", $("#case4c").val());
            // form_data.append("case4d", $("#case4d").val());
            // form_data.append("case4e", $("#case4e").val());

            
                var form_data = $('#formdata').serialize();
                //console.log(form_data);return false;
            
            $.ajax({
                url: base_url + '/SIKBREC/public/aFormSkrinning/uploadDataTTD/',
                type: 'POST',
                data: form_data,
               // processData: true,
                //contentType: false,
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

    //edit badrul
});
async function saveTransaksiForm() {
    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aFormSkrinning/insert';

    // data form 
    var formdata = $('#formdata').serialize();
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('SIMPAN');
            document.getElementById("btnSave").disabled = false;
        })
}

async function asyncShowMain() {
    try {
        await getHakAksesByForm(18);
        const datagetDataPasien = await getDataPasien();
        //console.log(datagetDataPasien)
        updateUIdataGetregistrasiRajalbyId(datagetDataPasien);
        showdatatabel();
    } catch (err) {
        toast(err, "error")
    }
}
async function updateUIdataGetregistrasiRajalbyId(params) {
    let data = params;
    $("#NamaPasien").val(data.PatientName);
    $("#NoMR").val(data.NoMR);
    $("#TglLahir").val(data.Date_of_birth);
    $("#poliklinik").val(data.LokasiPasien);
    $("#tglregistrasi").val(data.VisitDate);
    $("#NoRegistrasi").val(data.NoRegistrasi);

}
function getDataPasien() {
    var IdRegistrasi = document.getElementById("IdRegistrasi").value;
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdRegistrasi=' + IdRegistrasi + "&iswalkin=" + iswalkin
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
            $("#GruptarifKarcis").select2();
            $("#StatusKarcis").select2();
        })
}

function showdatatabel() {
    const base_url = window.location.origin;
    var NoRegistrasi = $("#NoRegistrasi").val();
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "scrollX": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aFormSkrinning/getAllSkrinningBatuk",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.NoRegistrasi = NoRegistrasi
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.datecreate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kondisi_Kesehatan_Batuk + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kondisi_Kesehatan_Pilek + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kondisi_Kesehatan_NyeriTenggorokan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kondisi_Kesehatan_Demam + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kondisi_Kesehatan_Sesak + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Batuk_2Minggu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Riwayat_Berkunjung_Covid19 + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Riwayat_Perjalanan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kontak_Terkonfirmasi_Positif + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Diabetes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Ginjal + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kanker + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.HIV_AIDS + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Minum_ObatSteroid + ' </font>  ';
                    return html
                }
            },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URLPASIEN + '" data-title="' + row.TTDPasien + '" width="100" height="100">';
                        return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URLPETUGAS + '" data-title="' + row.TTDPetugas + '" width="100" height="100">';
                        return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-danger border-primary btn-animated btn-wide"  onclick=delleteDatabyID(' + row.ID + ') ><span class="visible-content" >Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}

async function delleteDatabyID(id) {
    try {
        const dataUpdateFormSkrinning = await UpdateFormSkrinning(id);
        updateUIdataUpdateFormSkrinning(dataUpdateFormSkrinning);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdataUpdateFormSkrinning(params) {
    let response = params;
    // toast(response.message, "success")
    if (response.status == 'success') {
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        })
        showdatatabel()
    } else if (response.status = 'warning') {
        swal({
            title: 'Warning',
            text: response.message,
            icon: "warning",
        })
    }
    //var noregistrasi = response.NoRegistrasi; ;q
}
function UpdateFormSkrinning(id) {
    //$(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aFormSkrinning/delete';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID=" + id
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
            setTimeout(() => {
                location.reload();
            }, 500);
            $(".preloader").fadeOut();
        })
}

function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "close": true,
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/list";
}