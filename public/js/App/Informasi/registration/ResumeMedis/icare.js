$(document).ready(function () {
    $(".preloader").fadeOut();
    Icare();  
});

async function Icare(){
    try {
        $(".preloader").fadeIn(); 
        const xaddIcare = await addIcare();
        updateIcare(xaddIcare);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}


function updateIcare(data){ 
    if(data.status == "success"){
        window.location = data.hasil;
        // swal({
        //     title: "success",
        //     text: "Data Berhasil dikirim Ke i-Care, Url : " + data.hasil,
        //     icon: "success", 
        //     dangerMode: true,
        // });
    }else{
        swal({
            title: "success",
            text: "Data Gagal dikirim Ke i-Care !",
            icon: "success", 
            dangerMode: true,
        });
    }
}
function addIcare(noreg) {
    var base_url = window.location.origin;
    var kodeResumeMEdis = $("#kodeResumeMEdis").val();
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GoAddIcare';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }, 
        body: "Noreg=" + kodeResumeMEdis
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
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