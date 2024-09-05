$(document).ready(function () {
    asyncShowMain();
   
    const saveButtonx = document.querySelector('#btnSave');
    saveButtonx.addEventListener('click', async function () {
        try {
            const result = await saveDataBeban();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
                asyncShowMain();
            }

        } catch (err) {

            toast(err, "error")
        }
    }) 
});
async function asyncShowMain() {
    try {
        const datagetRekeningDiskon = await getRekeningDiskon();

        updateUIRekeningDiskon(datagetRekeningDiskon);
        const datagetDatabyID = await getDatabyID();
        
        updateUIdatagetDatabyID(datagetDatabyID);
       
        $(".preloader").fadeOut();
    } catch (err) {
        // toast(err, "error")
    }
    function updateUIRekeningDiskon(datagetRekeningDiskon) {
        let data = datagetRekeningDiskon;
        if (data !== null && data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#KODE_COA").append(newRow);
            for (i = 0; i < data.data.length; i++) {
                var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
                $("#KODE_COA").append(newRow);
            }
        }
    }
    function getRekeningDiskon() {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/Rekening/getRekeningAllAktif';
        return fetch(url, {
            method: 'GET',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            }
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
                $("#KODE_COA").select2();
            })
    }
    function updateUIdatagetDatabyID(datagetDatabyID){
        let dataResponse = datagetDatabyID.data;
        console.log(dataResponse)
    
    
        $("#ID").val(convertEntities(dataResponse.ID));
        $("#NAMA_GROUP_BEBAN").val(convertEntities(dataResponse.NAMA_GROUP_BEBAN)); 
        $("#AKTIF").val(convertEntities(dataResponse.AKTIF)).trigger('change');
        $("#KODE_COA").val(convertEntities(dataResponse.KODE_COA)).trigger('change');
 
    }
    
    function getDatabyID() {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/MasterDataBeban/getDataBebanbyID/';
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
//     
}
async function saveDataBeban() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBeban/saveDataBeban';

    // data form
    var form_data = $("#form_cuti").serialize();
    //var id_tarif = $("#IdAuto").val();
    // var id_layanan = $("#GrupPerawatan").val();
    // var kd_instalasi = $("#kd_instalasi").val();
    //console.log('sss');return false;
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

}


function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataBeban/listMasterBeban";
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
