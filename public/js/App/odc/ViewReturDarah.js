$(document).ready(function () {
    // $(".preloader").fadeOut(); 
    asyncShowMain();

    $('#btn_simpan').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Simpan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goupdateHeaderTrs();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
     });

     $('#btn_batal').click(function () {
        if ($("#NoOrderTransaksi").val() == ''){
            toast('No Transaksi Tidak Ditemukan ! Silahkan Klik New Transaction Terlebih Dahulu !', 'warning');
            return false
        }
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Batal ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goBatalHeaderUseBlood();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
     });

     $('#btnBack').click(function () {
        MyBack();
     });

    // $('#list_useblooddetail').DataTable({});

});

async function asyncShowMain() {
    try {
        // await getHakAksesByForm(46);
        if($('#id_Order').val()!=''){
        const datagetDataOrderDarah = await getDataOrderDarah();
        updateUIgetDataOrderDarah(datagetDataOrderDarah);
        showDataDetil();
        }
    } catch (err) {
        toast(err, "error")
    }
}

function getDataOrderDarah() {
    // console.log($("#id_Order").val());
    // exit;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/getOrderData/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#id_Order").val()
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function updateUIgetDataOrderDarah(datagetDataOrderDarah) {

    let dataResponse = datagetDataOrderDarah;
    // console.log(dataResponse);
    // exit;

        $("#tgl_Order").val(dataResponse.data.DateOrder);
        $("#ket_order").val(dataResponse.data.Keterangan);
        $("#no_MR").val(dataResponse.data.NoMR);
        $("#no_Eps").val(dataResponse.data.NoEpisode);
        $("#no_Reg").val(dataResponse.data.NoRegistrasi);
        $("#user_Order").val(dataResponse.data.UserOrderName);
        $("#dokter_DPJP").val(dataResponse.data.DPJPName);
        $("#nama_Pasien").val(dataResponse.data.PatientName);
        $("#GolonganDarah").val(dataResponse.data.GolonganDarah);
        $("#nama_Jaminan").val(dataResponse.data.NamaJaminan);

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

//fiqri 09-04-2023 19:08

async function goupdateHeaderTrs() {
    try {
        $(".preloader").fadeIn();
        const data = await updateHeaderTrs();
        updateUIdataupdateHeaderTrs(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataupdateHeaderTrs(dataResponse) {
    if(dataResponse.status == 'success'){
        toast(dataResponse.message, "success");
        swal({
            title: "Save Success!",
            text: dataResponse.message,
            icon: "success",
        }).then(function() {
            MyBack();
        });
    }else{
        toast(dataResponse.message, "error")
    }
}
function updateHeaderTrs() {
    var base_url = window.location.origin;
    var data = $("#frmSimpanTrsRegistrasi").serialize();
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/ReturOrderBlood/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data
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

async function goBatalHeaderUseBlood() {
    try {
        $(".preloader").fadeIn();
        const data = await BatalHeaderUseBlood();
        updateUIdataBatalHeaderUseBlood(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataBatalHeaderUseBlood(dataResponse) {
    if(dataResponse.status == 'success'){
        toast(dataResponse.message, "success");
        swal({
            title: "Save Success!",
            text: dataResponse.message,
            icon: "success",
        }).then(function() {
            MyBack();
        });
    }else{
        toast(dataResponse.message, "error")
    }
}
function BatalHeaderUseBlood() {
    var base_url = window.location.origin;
    var data = $("#frmSimpanTrsRegistrasi").serialize();
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/BatalHeaderUseBlood/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data
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

    
    function showDataDetil() {
        var IDHdr = $("#id_Order").val();
        var base_url = window.location.origin;
        $('#list_orderdarahdetail').DataTable().clear().destroy();
        $('#list_orderdarahdetail').DataTable({
            "ordering": false,
            "paging": false,
            //"order": [[ 2, "desc" ]],
            "ajax": {
                "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataListOrderBloodDetail/",
                "dataSrc": "",
                "deferRender": true,
                "type": "POST",
                data: function (d) {
                    d.IDHdr = IDHdr; 
                }
            },
            "columns": [
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.ID + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.IdTarifDarah + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.NamaTarifDarah + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.QtyOrder + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.QtyPakai + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<span class="badge badge-info">'+row.QtySisa+'</span> ';
                        
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.CC + '</font>  ';
                        return html
                    }
                },
    
            ], 
    
        });
        $(".preloader").fadeOut();
    } 

    function MyBack() {
        const base_url = window.location.origin;
        window.location = base_url + "/SIKBREC/public/bInfoOrderDarah/list";
    }