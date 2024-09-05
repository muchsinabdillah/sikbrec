$(document).ready(function () {

   
    const btnOTPVerify = document.querySelector('#btnOTPVerify');
    btnOTPVerify.addEventListener('click', async function () {
        try {
            const result = await verifyOTP();
            console.log(result)
            if (result.status == "success") {
                toast(result.message, "success")
                //gotoOTP();
                setTimeout(function () { gotoHomepage(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
function gotoOTP() {
    var UserId = $("#UserId").val();
    var UserIdx = btoa(UserId);
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Verification/sendOTP/" + UserIdx;
}
function verifyOTP() {
   // document.getElementById("btnOTPVerify").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Login/verifyOTP';

    // data form
    var NoOTP = document.getElementById("NoOTP").value;
    var UserId = document.getElementById("UserId").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoOTP=" + NoOTP + "&UserId=" + UserId
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
function gotoHomepage() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public";
}