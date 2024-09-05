$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveSatuan();
            console.log(result);
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {
            toast(err, "error")
        }
    })
});
async function asyncShowMain() {
    try {
        await getHakAksesByForm(12); 
        var id = $("#IdAuto").val();
        if(id != ""){
            const dataGetSatuanbyId = await GetSatuanbyId();  
            updateUIdataGetSatuanbyID(dataGetSatuanbyId); 
        }else{
            $("#Isi").val("1");
        }
        
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetSatuanbyID(dataResponse) {
    $("#NamaSatuan").val(dataResponse.data[0].nama_satuan);
    $("#Isi").val(dataResponse.data[0].isi);
}
function GetSatuanbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSatuan/getSatuanbyId/';
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
    window.location = base_url + "/SIKBREC/public/MasterSatuan/list";
}
async function saveSatuan() {

    $(".preloader").fadeIn(); 
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    
    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var Isi = document.getElementById("Isi").value;
    var NamaSatuan = document.getElementById("NamaSatuan").value; 
    var url = '';
    if(IdAuto == "" ){
        url = base_url + '/SIKBREC/public/MasterSatuan/addSatuan';

    }else{
        url = base_url + '/SIKBREC/public/MasterSatuan/editSatuan';
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaSatuan=" + NamaSatuan 
            + "&Isi=" + Isi
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