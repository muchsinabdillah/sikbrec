$(document).ready(function () {
    asyncShowMain();
});
  
// function GoMonitoringBPJS() {
//     var MNoTrs = document.getElementById("MNoTrs").value;
//     //var base_url = window.location.origin;
//     var base_url = 'http://localhost:8080';

// }  

async function asyncShowMain() {
    try {
        const dataUpdateWaktuAntrian = await UpdateWaktuAntrian();
        updateUIdataUpdateWaktuAntrian(dataUpdateWaktuAntrian);
    } catch (err) {
        // alert(err.message)
        // window.close();

        if(!alert(err.message)) document.location = 'http://rsyarsi.co.id/';
    }
}

function updateUIdataUpdateWaktuAntrian(dataUpdateWaktuAntrian) {
            if(!alert('Data Berhasil Dikirim Ke BPJS !')) document.location = 'http://rsyarsi.co.id/';
    }
    function UpdateWaktuAntrian() {
    var NoTrs = document.getElementById("MNoTrs").value;
    var TaskID = document.getElementById("TaskID").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/UpdateWaktuAntrian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoTrs=' + NoTrs +'&TaskID=' + TaskID
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
           // $("#ProgramPRB").select2(); 
        })
    }

    // function toast(data, status) {
    //     toastr.options = {
    //         "closeButton": true,
    //         "debug": false,
    //         "newestOnTop": false,
    //         "progressBar": false,
    //         "positionClass": "toast-top-right",
    //         "preventDuplicates": false,
    //         "onclick": null,
    //         "showDuration": "300",
    //         "hideDuration": "1000",
    //         "timeOut": "3500",
    //         "extendedTimeOut": "1000",
    //         "showEasing": "swing",
    //         "hideEasing": "linear",
    //         "showMethod": "fadeIn",
    //         "hideMethod": "fadeOut"
    //     }
    //     toastr[status](data);
    // }