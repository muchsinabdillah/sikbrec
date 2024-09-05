$(document).ready(function () { 
    showdatatabel();
    convertNumberToRp();
    asyncShowMain();

    //badrul
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#form_cuti').submit(
        function (e) {
        
            var form_data = new FormData(); 
            form_data.append("file", $('input[type=file]')[0].files[0]); 
            form_data.append("IdAuto", $("#IdAuto").val()); 
            console.log("aaa",$('input[type=file]')[0]);
            $.ajax({
                url: base_url + '/SIKBREC/public/MasterDataDokter/uploadDataImage/',
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
    //badrul

});





//badrul
async function UpdateDataLanjutan() {
    try{
        const dtGoUpdateDataLanjutan = await GoUpdateDataLanjutan(); 
        updateUIdtGoUpdateDataLanjutan(dtGoUpdateDataLanjutan); 
    } 
    catch (err) {
        console.log(err);
    }
}

function GoUpdateDataLanjutan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/updateDataLanjutanDokter';

    var id = document.getElementById("IdAuto").value;
    const pendidikanxx = Pendidikan_Dokter.getData();

    // var pendidikan = document.getElementById("Pendidikan_Dokter").value;
    var deskripsi = document.getElementById("Description_Dokter").value;
    var pelatihan = document.getElementById("Pelatihan_Dokter").value;
    console.log(id);
    console.log(pendidikan);
    console.log(deskripsi);
    console.log(pelatihan);

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + id
            + "&pendidikan=" + pendidikanxx 
            + "&deskripsi=" + deskripsi
            + "&pelatihan=" + pelatihan
            
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
        // $("#poliklinik").val();
        $("").val();
    })
}

function updateUIdtGoUpdateDataLanjutan(params) {
    console.log('oke:',params);
    // return false;
    if(params.status === "success"){ 
        swal("Terima Kasih", params.message, "success");
    }else{ 
        swal("Oops",   params.message, "error");
    }
}



function showdatatabel() {
    const base_url = window.location.origin;
    var ID = $("#IdAuto").val();
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "scrollX": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataDokter/getDataTableImage",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID
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
                    var html = '<font size="1"> ' + row.First_Name + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URLFOTODOKTER + '" data-title="' + row.foto + '" width="100" height="100">';
                        return html
                }
            },
        ]
    });
}
//badrul
async function saveMasterDokter() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/addDokter';

    var IdAuto = document.getElementById("IdAuto").value;
    var NamaDokter = document.getElementById("NamaDokter").value;
    var Spesialis = document.getElementById("Spesialis").value;
    var JobTitle = document.getElementById("JobTitle").value;
    var Category = document.getElementById("Category").value;
    var GrupPerawatan = document.getElementById("GrupPerawatan").value;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaDokter=" + NamaDokter + "&Spesialis=" + Spesialis
            + "&JobTitle=" + JobTitle + "&Category=" + Category
            + "&GrupPerawatan=" + GrupPerawatan
            
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
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })
}

async function asyncShowMain() {
    try {
        await getHakAksesByForm(12);
        const datagetJobTitle = await getJobTitle();
        const datagetGrupPerawatan = await getGrupPerawatan();
        const datagetDataGroupSpesialis = await getDataGroupSpesialis();
        const datagetDataDokterbyId = await getDataDokterbyId();
        updateUIgetJobTitle(datagetJobTitle);
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis);
        updateUIdatagetDataDokterbyId(datagetDataDokterbyId);
        console.log(datagetDataDokterbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDataDokterbyId(datagetDataDokterbyId) {
    let dataResponse = datagetDataDokterbyId; 
    console.log(dataResponse);
 

    
    $("#Category").select2();
    $(".preloader").fadeOut();
    $("#IdAuto").val(convertEntities(dataResponse.data.ID));
    $("#NamaDokter").val(convertEntities(dataResponse.data.First_Name));
    $("#Spesialis").val(convertEntities(dataResponse.data.Spesialis));
    $("#JobTitle").val(convertEntities(dataResponse.data.Job_Title));

    $("#Category").val(convertEntities(dataResponse.data.designationId)).trigger('change');
    $("#GrupPerawatan").val(convertEntities(dataResponse.data.GroupPerawatan));
 

}
function getDataDokterbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDokterId/';
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
            $(".preloader").fadeOut();
        })
}
function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
    return fetch(url, {
        method: 'GET',
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
            $("#GrupPerawatan").select2();
        })
}
///harus ada
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
function updateUIgetJobTitle(datagetJobTitle) {
    let data = datagetJobTitle;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#JobTitle").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].JobTitle + '">' + data.data[i].JobTitle + '</option';
            $("#JobTitle").append(newRow);
        }
    }
}
function getJobTitle() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getJobTitle';
    return fetch(url, {
        method: 'GET',
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
            $("#JobTitle").select2(); 
        })
}

function getDataGroupSpesialis() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDataGroupSpesialis/';
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
            $(".preloader").fadeOut();
        })
}
function updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis) {
    let data = datagetDataGroupSpesialis;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH GROUP SPESIALIS--</option';
        $("#GroupSpesialis").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].NamaBagian + '">' + data.data[i].NamaBagian + '</option';
            $("#GroupSpesialis").append(newRow);
        }
    }
}


///harus ada
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
    window.location = base_url + "/SIKBREC/public/MasterDataDokter";
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
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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

}