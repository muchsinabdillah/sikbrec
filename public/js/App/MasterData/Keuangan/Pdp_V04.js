$(document).ready(function () {
     asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await savePdp();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
function savePdp() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Pdp/addPdp';
    var form_data = $("#form_cuti").serialize();
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        })
}
async function asyncShowMain() {
    try {
        const data = await getDataPdpById();
        updateUI(data); 
    } catch (err) {
        toast(err, "error") 
    }
}
function updateUI(repoList) {
    var data = repoList;
    //console.log(data);
    if (data.message == "success") {
        $("#IdAuto").val(convertEntities(data.data.ID));
        $("#KodePdp").val(convertEntities(data.data.KD_PDP));
        $("#NamaPdp").val(convertEntities(data.data.NM_PDP));
        $("#KodeJenisPdp").val(convertEntities(data.data.KD_JENIS_PDP));
        if (data.data.ID === null) {
            document.getElementById("KodePdp").readOnly = false;
        } else {
            document.getElementById("KodePdp").readOnly = true;
        }
    }
}
function getDataPdpById() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Pdp/getPdpId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val()
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Pdp";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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