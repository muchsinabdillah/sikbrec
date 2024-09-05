$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await savePabrik();
            console.log(result);
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }else{
                toast(result.message, "warning")
            }

        } catch (err) {
            toast(err, "error")
        }
    })
});
async function asyncShowMain() {
    try {
        await getHakAksesByForm(12); 
        const dataGetPabrikbyID = await GetPabrikbyID();  
        updateUIdataGetPabrikbyID(dataGetPabrikbyID); 
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetPabrikbyID(dataResponse) {
    $("#Nama_Formularium").val(dataResponse.data[0].Nama_Formularium);
}
function GetPabrikbyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataFormularium/getFormulariumbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#ID").val()
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
    window.location = base_url + "/SIKBREC/public/MasterDataFormularium/list";
}
async function savePabrik() {

    $(".preloader").fadeIn(); 
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    
    // data form
    var form = $("#formtrs").serialize();
    var url = '';
    if($("#ID").val() == "" ){
        url = base_url + '/SIKBREC/public/MasterDataFormularium/addFormularium';

    }else{
        url = base_url + '/SIKBREC/public/MasterDataFormularium/editFormularium';
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form
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
            document.getElementById("btnSave").disabled = false;
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