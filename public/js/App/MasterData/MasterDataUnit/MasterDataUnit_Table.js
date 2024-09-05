$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(19);
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataUnit/getAllDataUnit",
            "dataSrc": "",
            "deferRender": true,
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
                    var html = '<font size="1"> ' + row.NamaUnit + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.EmrMenu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kelasrawat + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.idUnitKemkes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    if(row.idUnitKemkes == null){
                        var html = ""
                        var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="PostLocation('${row.CODEUNIT}','${row.NamaUnit}','${row.idUnitKemkes}')" ><span class="visible-content" >POST</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>`
                        return html
                    }else{
                        var html = ""
                        var html = `<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="PutLocation('${row.CODEUNIT}','${row.NamaUnit}','${row.idUnitKemkes}')" ><span class="visible-content" >UPDATE</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>`
                        return html
                    }
                    
                },
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showDataGroupShift(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataUnit/viewUnit/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataUnit/viewUnit/";
}

function PostLocation(id, nama, idunitKemenkes){
    console.log(id,nama,idunitKemenkes);
    swal({
        title: "Insert Location",
        text: "Apakah Anda ingin Kirim Data : "+ nama + ", Ke Kemenkes SATU SEHAT ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) { 
                validatePostLocation(id, nama, idunitKemenkes);
            } else {
               swal("Transaction Rollback !");
            }
        }); 
}
function PutLocation(id, nama, idunitKemenkes){
    console.log(id,nama,idunitKemenkes);
    swal({
        title: "Update Location",
        text: "Apakah Anda ingin Kirim Data : "+ nama + ", Ke Kemenkes SATU SEHAT ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) { 
                validatePutLocation(id, nama, idunitKemenkes);
            } else {
               swal("Transaction Rollback !");
            }
        });
}
async function validatePutLocation(id, nama, idunitKemenkes) {
    try {
        $(".preloader").fadeIn();
        const data = await GoPutLocationData(id, nama, idunitKemenkes); 
        updateGoPutLocationData(data);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
        $(".preloader").fadeOut(); 
    }
}
function updateGoPutLocationData(data) {
    if(data.message == "success"){
        toast("Data Berhasil di Rubah di Kemenkes Satu Sehat !", "success")
    }
}
function GoPutLocationData(id, nama, idunitKemenkes) {
 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataUnit/PutLocation';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id="+id+"&nama="+nama+"&idunitKemenkes="+idunitKemenkes
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

async function validatePostLocation(id, nama, idunitKemenkes) {
    try {
        $(".preloader").fadeIn();
        const data = await GoPostLocationData(id, nama, idunitKemenkes); 
        updateGoPostLocationData(data);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
        $(".preloader").fadeOut(); 
    }
}
function updateGoPostLocationData(data) {
    if(data.message == "success"){
        toast("Data Berhasil di Tambahkan di Kemenkes Satu Sehat !", "success")
    }
    
}
function GoPostLocationData(id, nama, idunitKemenkes) {
 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataUnit/PostLocation';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id="+id+"&nama="+nama+"&idunitKemenkes="+idunitKemenkes
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