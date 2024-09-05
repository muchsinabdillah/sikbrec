$(document).ready(function () {
    $(".preloader").fadeOut();
    $('#btngenerateJurnal').click(function () {
       generatejurnal();
    });
});
async function generatejurnal() {
    try {
       
        $(".preloader").fadeIn();
        const dataGenJurnal = await Gogeneratejurnal(); 
        console.log(dataGenJurnal);
        updateUIdataGogeneratejurnal(dataGenJurnal);
            $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGogeneratejurnal(params) {
    toast(params.message,"success");
}
function Gogeneratejurnal() {
    var PeriodeSaldo = document.getElementById("PeriodeSaldo").value;
    var PeriodeAwal = document.getElementById("PeriodeAwal").value; 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InfoLedger/Gogeneratejurnal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "PeriodeSaldo=" + PeriodeSaldo + "&PeriodeAwal=" + PeriodeAwal 
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
