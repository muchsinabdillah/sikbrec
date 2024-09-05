
async function getHakAkses(params) {
    const datashowHakAseks = await showHakAseks(params);
    updateUIshowHakAseks(datashowHakAseks);
}
async function getHakAksesByForm(params) {
    const datashowHakAseks = await showHakAseks(params);
    updateUIshowHakAseksByForm(datashowHakAseks);
}
function updateUIshowHakAseksByForm(datashowHakAseks) {
    let data = datashowHakAseks;
    const base_url = window.location.origin;
    if (data.message == "warning") {
        window.alert("Sorry... " + data.data.pesan);
        window.location = base_url + '/SIKBREC/public';
    }
}
function updateUIshowHakAseks(datashowHakAseks) {
    let data = datashowHakAseks;
    const base_url = window.location.origin;
    if (data.message == "success") { 
        // //------------------------ cek jam 13
        // //cek jika url mengandung kata "Information"
        // if (data.data.url.includes("Information")){
        //     //pengecualian
        //     if (data.data.url == '/bInformationBPJS'){
        //         window.location = base_url + '/SIKBREC/public' + data.data.url;
        //     }
        //     if (data.data.url == '/bInformationLma'){
        //         window.location = base_url + '/SIKBREC/public' + data.data.url;
        //     }
        //     // if (data.data.url == '/bInformationRegistrasi'){
        //     //     window.location = base_url + '/SIKBREC/public' + data.data.url;
        //     // }

        //     //Cek jika sekarang di bawa jam 13:00
        //     var today = new Date().getHours();
        //     if (today <= 12) {
        //         alert('Maaf, sementara menu ini hanya bisa diakses setelah jam 13:00');
        //         return false;
        //     }
        // }
        // //------------------------ #END cek jam 13
        
        window.location = base_url + '/SIKBREC/public' + data.data.url;
    } else if (data.message == "warning") {
        window.alert("Sorry... "+data.data.pesan);
        window.location = base_url + '/SIKBREC/public';
    }
}
function showHakAseks(params) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/GetHakAksesUser/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + params
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
