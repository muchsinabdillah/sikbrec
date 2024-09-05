function go_save() {
    var base_url = window.location.origin;
    var UserId = $("#UserId").val();
    var Password = $("#Password").val();
    $.ajax({
        url: base_url + '/SIKBREC/public/Login/cekLogin',
        data: {
            UserId: UserId,
            Password: Password
        },
        method: 'post',
        dataType: 'json',
        beforeSend: function () { 
            document.getElementById("btnLogin").disabled = true;
        },
        success: function (data) {
          
            if (data.status == "warning") {
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
                toastr["error"](data.errorname);
                document.getElementById("btnLogin").disabled = false;

            } else if (data.status == "success") {
                toast(data.message,"success");
                gotoHomepage(); 
            }  

        },
        error: function () {
            document.getElementById("btnLogin").disabled = false;
        }
    });
}
function gotoHomepage() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public";
}
function gotoVerify() {
    var UserId = $("#UserId").val();
    var UserIdx = btoa(UserId);
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Verification/" + UserIdx;
}
function gotoOTP() {
    var UserId = $("#UserId").val();
    var UserIdx = btoa(UserId);
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Verification/sendOTP/" + UserIdx;
}

// test token
async function getTokenWapin() {
    try {
        const result = await GogetTokenWapin();
        console.log(result)
        
    } catch (err) {
        toast(err, "error")
    }
}
function GogetTokenWapin() { 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Login/getTokenWapin';
 

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }, 
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