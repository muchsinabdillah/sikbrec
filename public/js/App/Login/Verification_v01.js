$(document).ready(function () {
 
    const btnVerify = document.querySelector('#btnVerify');
    btnVerify.addEventListener('click', async function () {
        try {
            const result = await sendVerification();
            console.log(result)
            if (result.status == "success") {
                toast(result.message, "success")
                gotoOTP();
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
function sendVerification() {
    document.getElementById("btnVerify").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Login/sendVerification';

    // data form
    var NoHandphone = document.getElementById("NoHandphone").value;
    var UserId = document.getElementById("UserId").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoHandphone=" + NoHandphone + "&UserId=" + UserId
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