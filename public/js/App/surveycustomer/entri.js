$(document).ready(function () {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();

});


function handleSangatPuas(value) {
    var noreg = $("#noreg").val();
    var statuspuas = value; 
    goCreateRegistrasi(noreg,statuspuas);
}

function handlePuas(value) {
    var noreg = $("#noreg").val();
    var statuspuas = value; 
    goCreateRegistrasi(noreg,statuspuas);
}

function handleTidakPuas(value) {
    var noreg = $("#noreg").val();
    var statuspuas = value; 
    goCreateRegistrasi(noreg,statuspuas);
}

async function goCreateRegistrasi(noreg,statuspuas) {
    try {
        const dataCreateRegistrasi = await CreateRegistrasi(noreg,statuspuas);
        updateUIdataCreateRegistrasi(dataCreateRegistrasi);
       
    } catch (err) {
        alert(err)
    }
}
function updateUIdataCreateRegistrasi(dataCreateRegistrasi){
    let data = dataCreateRegistrasi;
    console.log(data)
    if (data.status == "warning") {
        alert(data.message);
    } else if (data.status == "success") {
        alert("Terima kasih atas penilaian anda !. haaman akan direct dalam 3 detik."); 

        // Your application has indicated there's an error
        window.setTimeout(function(){

            // Move to a new location or you can do something else
            const base_url = window.location.origin;
            window.location = base_url + "/SIKBREC/public/surveycustomer/";

        }, 3000);

    }
}
function CreateRegistrasi(noreg,statuspuas) { 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SurveyCustomer/insertPenilaian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "noreg=" + noreg + "&statuspuas=" + statuspuas
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
            // $(".preloader").fadeOut();
            // document.getElementById("frmKartuRSYarsi").reset();
            // $('#Modal_Karyawn_Polis').modal('hide');
            
})
}