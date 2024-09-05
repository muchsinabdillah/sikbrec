$(document).ready(function () {
    $(".preloader").fadeOut();
    GenerateWhatsAppVerification();  
});

async function GenerateWhatsAppVerification() {
    try{
        const data = await aGenerateWhatsAppVerification();
        console.log(data);
        // updateUIgoGenerateHasil(data);
    } catch (err) {
        toast(err, "error")
    }
}
function aGenerateWhatsAppVerification() {
    var base_url = window.location.origin;
    var kodeResumeMEdis = $("#kodeResumeMEdis").val();
    let url = base_url + '/SIKBREC/public/bInformationResumeMedis/SendWhatsappVerification';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "kodeResumeMEdis=" + kodeResumeMEdis
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