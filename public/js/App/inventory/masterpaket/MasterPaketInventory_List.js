$(document).ready(function () {
    onloadForm();

    // $('#btnSearchMutasi').click(function () {
    //     $('#createnew_modal').modal('show');
    // });

});
async function onloadForm() {
    await getHakAksesByForm(18);
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
            "url": base_url + "/SIKBREC/public/MasterPaketInventory/showAll",
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
                    var html = '<font size="1"> ' + row.nama_paket + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.user_create + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.date_create + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.user_update + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.date_update + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.status == '1'){
                        var statusket = 'Aktif';
                    }else{
                        var statusket = 'Tidak Aktif';
                    }
                    var html = '<font size="1"> ' + statusket + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showSatuan(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function showSatuan(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterPaketInventory/' + str;
}

function goGroupShiftPages() {
    $('#createnew_modal').modal('show');
    // const base_url = window.location.origin;
    // window.location = base_url + "/SIKBREC/public/MasterPaketInventory/";
}

async function addNewPaket() {
    try {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goSave();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function goSave(){
    try{
    $(".preloader").fadeIn();
    const data = await goaddNewPaket();
    updateUIdatagoaddNewPaket(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function goaddNewPaket() {
    var nama_paket = $("#nama_paket").val();
    var url2 = "/SIKBREC/public/MasterPaketInventory/addPaketInventory";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nama_paket=" + nama_paket 
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

function updateUIdatagoaddNewPaket(data) {
    console.log(data);
    if (data.status == 'success'){
        toast(data.message, "success")
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            const base_url = window.location.origin;
            var str = btoa(data.data);
            window.location = base_url + '/SIKBREC/public/MasterPaketInventory/' + str;
        });
    }else{
        swal({
            title: 'Warning',
            text: data.errorname,
            icon: 'success',
        })
    }

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