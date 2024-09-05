$(document).ready(function () {
    onloadForm();
   
});

function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataDokter/viewDokter/' + str;
}

function showLayanan(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataDokter/viewDokterLayanan/' + str;
}

function showFoto(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataDokter/uploadFotoDokter/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataDokter/viewDokter/";
}
async function onloadForm() {
    await getHakAksesByForm(12);
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
            "url": base_url + "/SIKBREC/public/MasterDataDokter/getAllDataDokter",
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
                    var html = '<font size="1"> ' + row.First_Name + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JobTitle + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.active + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.idDoktertKemkes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoIdentitasKTP + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    
                    if(row.idDoktertKemkes == null){
                        var html = ""
                        var html = `<button type="button" class="btn btn-warning border-primary btn-animated btn-xs"  onclick="PostPractitioners('${row.idDoktertKemkes}','${row.First_Name}','${row.NoIdentitasKTP}')" ><span class="visible-content" >INSERT</span></button>`
                        return html
                    }else{
                        var html = ""
                        return html
                    }
                },
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="showDataGroupShift(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp<button type="button" class="btn btn-info border-info btn-animated btn-xs"  onclick="showLayanan(' + row.ID + ')" ><span class="visible-content" >Layanan</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp<button type="button" class="btn btn-danger border-info btn-animated btn-xs"  onclick="showFoto(' + row.ID + ')" ><span class="visible-content" >Dokumen</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}

function PostPractitioners(idDoktertKemkes,First_Name,NoIdentitasKTP){
    swal({
        title: "Post Practitioner",
        text: "Apakah Anda ingin Kirim Data : "+ First_Name + ", Ke Kemenkes SATU SEHAT ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) { 
               validatePostPractitioners(idDoktertKemkes,First_Name,NoIdentitasKTP);
            } else {
               swal("Transaction Rollback !");
            }
        });
} 
async function validatePostPractitioners(idDoktertKemkes,First_Name,NoIdentitasKTP) {
    try {
        $(".preloader").fadeIn();
        const data = await GoPostPractitioners(idDoktertKemkes,First_Name,NoIdentitasKTP); 
        updateGoPostPractitioners(data);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
        $(".preloader").fadeOut(); 
    }
}
function updateGoPostPractitioners(data) {
    if(data.message == "success"){
        toast("Data Berhasil di Tambahkan di Kemenkes Satu Sehat !", "success")
    }
}
function GoPostPractitioners(idDoktertKemkes,First_Name,NoIdentitasKTP) {
 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/PostPractitioners';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idDoktertKemkes="+idDoktertKemkes+"&First_Name="+First_Name+"&NoIdentitasKTP="+NoIdentitasKTP
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