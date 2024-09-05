$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $("#scanqr").focus();
    $(document).on('click', '#btnScan', function () {
        const param = $("#scanqr").val()
        goScan(param);
    });

    $("#scanqr").keyup(function (e) { 
        if (e.keyCode == 13) { 
            const param = $("#scanqr").val()
            goScan(param);
        }
    });
});

async function goScan(param) {
    try {
            const data = await goScanBarcode(param);
            updategoScanBarcode(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function goScanBarcode(param) {
    var NoTrs = param;
    var url2 = "/SIKBREC/public/aRegistrasiRajal/goScanQrCode";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTrs=" + NoTrs
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
function updategoScanBarcode(data) {
    if (data.status == 'success'){
        swal({
            title: data.message,
            text: data.message,
            icon: 'success',
        }).then(function() {
            MyBack()
        });

    }else{
        swal({
            title: data.message,
            text: data.message,
            icon: 'error',
        })
    }
}

function MyBack() {
    location.reload()
    // const base_url = window.location.origin;
    // window.location = base_url + "/SIKBREC/public/Hutang/PelunasanHutang";
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
