$(document).ready(function () { 
    asyncShowMain(); 
 
    // setTimeout(function () {
    //     showdetil();
    //     $(".preloader").fadeOut();
    // }, 1000);
 
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveTrsCutiDokter();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
    
    $('#btn_batal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                // swal(`You typed: ${value}`);
                goVoidHeader(value);
            });
    });

});

async function saveTrsCutiDokter() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLiburNasional/AddNew';
    var form_data = $("#form_cuti_dokter").serialize();
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
        await getHakAksesByForm(17);
        const datagetDataDetilTransaksiCuti = await getDataDetilTransaksiCuti();
        updateUIgetDataDetilTransaksiCuti(datagetDataDetilTransaksiCuti);
    } catch (err) {
        toast(err, "error")
    }
}
async function showdetil() {
    try {
        const datagetDataDetilTransaksiCuti = await getDataDetilTransaksiCuti();
        updateUIgetDataDetilTransaksiCuti(datagetDataDetilTransaksiCuti);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgetDataDetilTransaksiCuti(datagetDataDetilTransaksiCuti) {
    let responseData = datagetDataDetilTransaksiCuti;
    $("#IdAuto").val(convertEntities(responseData.data.ID)); 
    $("#TglAwal").val(convertEntities(responseData.data.periode_awalx));
    $("#TglAkhir").val(convertEntities(responseData.data.periode_akhirx));
    $("#note").val(convertEntities(responseData.data.keterangan));
    

}
function getDataDetilTransaksiCuti() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLiburNasional/getDataDetil/';
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
            $("#JenisCuti").select2();
            
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterLiburNasional";
}

async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const data = await goVoidHeader2(param);
        updateUIdatagoVoidHeader2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function goVoidHeader2(param) {
    var ID = document.getElementById("IdAuto").value;
    var url2 = "/SIKBREC/public/MasterLiburNasional/void";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID=" + ID + "&AlasanBatal=" + param 
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

function updateUIdatagoVoidHeader2(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}