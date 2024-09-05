$(document).ready(function () { 
    asyncShowMain(); 

    $('#btnbatal').click(function () {
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
                goVoidCuti(value);
            });
    });
 
    setTimeout(function () {
        showdetil();
        $(".preloader").fadeOut();
    }, 2000);
 
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveTrsCutiDokter();
            console.log(result);
            if (result.status == "success") {
                toast(result.message, "success")
               // setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })

    $('#NamaPoliklinik').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#NamaFullPoli").val(data.text);
    });
    $('#NamaDokter').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#NamaDokterFull").val(data.text);
    });
});
async function getDataDokter() {
    const dataGetLayananPoliklinik = await getDataDokterbyPoliklinikID();
    console.log("dataGetLayananPoliklinik",dataGetLayananPoliklinik)
    updateUIgetDataDokterbyPoliklinikID(dataGetLayananPoliklinik);
    
}

async function saveTrsCutiDokter() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CutiDokter/addCutiDokter';
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
function updateUIgetDataDokterbyPoliklinikID(dataGetMasterCutiDokter) {
    let dataResponse = dataGetMasterCutiDokter;
    if (dataResponse.data !== null && dataResponse.data !== undefined) {
        console.log(dataResponse);
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaDokter").append(newRow);
        for (i = 0; i < dataResponse.data.length; i++) {
            var newRow = '<option value="' + dataResponse.data[i].ID + '">' + dataResponse.data[i].First_Name + '</option';
            $("#NamaDokter").append(newRow);
        }
    }
}
function getDataDokterbyPoliklinikID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CutiDokter/getDataDokterbyPoliklinikID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdPoliklinik=' + document.getElementById("NamaPoliklinik").value
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
            $("#NamaDokter").select2();
        })
}
async function asyncShowMain() {
    try {
        await getHakAksesByForm(17);
        const dataGetLayananPoliklinik= await GetLayananPoliklinik();
        console.log("dataGetLayananPoliklinik", dataGetLayananPoliklinik)
        const dataGetMasterCutiDokter = await GetMasterCutiDokter();
        console.log("dataGetMasterCutiDokter", dataGetMasterCutiDokter)
        updateUIGetLayananPoliklinik(dataGetLayananPoliklinik);
        updateUIGetMasterCutiDokter(dataGetMasterCutiDokter);
        const datagetDataDetilTransaksiCuti = await getDataDetilTransaksiCuti();
        updateUIgetDataDetilTransaksiCuti(datagetDataDetilTransaksiCuti);
        console.log("datagetDataDetilTransaksiCuti", datagetDataDetilTransaksiCuti)
    } catch (err) {
        toast(err, "error")
    }
}
async function showdetil() {
    try {
        const datagetDataDetilTransaksiCuti = await getDataDetilTransaksiCuti();
        updateUIgetDataDetilTransaksiCuti(datagetDataDetilTransaksiCuti);
        console.log("datagetDataDetilTransaksiCuti", datagetDataDetilTransaksiCuti)
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
    $('#NamaPoliklinik').val(responseData.data.id_poli).trigger('change');
    $('#NamaDokter').val(responseData.data.id_dokter).trigger('change');
    $('#JenisCuti').val(responseData.data.id_jenis_cuti).trigger('change');
    

}
function getDataDetilTransaksiCuti() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CutiDokter/getDataDetilTransaksiCuti/';
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
function updateUIGetMasterCutiDokter(dataGetMasterCutiDokter) {
    let dataResponse = dataGetMasterCutiDokter;
    if (dataResponse.data !== null && dataResponse.data !== undefined) {
        // console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#JenisCuti").append(newRow);
        for (i = 0; i < dataResponse.data.length; i++) {
            var newRow = '<option value="' + dataResponse.data[i].ID + '">' + dataResponse.data[i].nama_jenis_cuti + '</option';
            $("#JenisCuti").append(newRow);
        }
    }
}
function GetMasterCutiDokter() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CutiDokter/getAllMasterCutiDokter/';
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
function updateUIGetLayananPoliklinik(dataGetLayananPoliklinik) {
    let dataResponse = dataGetLayananPoliklinik;
    if (dataResponse.data !== null && dataResponse.data !== undefined) {
        // console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaPoliklinik").append(newRow);
        for (i = 0; i < dataResponse.data.length; i++) {
            var newRow = '<option value="' + dataResponse.data[i].ID + '">' + dataResponse.data[i].NamaUnit + '</option';
            $("#NamaPoliklinik").append(newRow);
        }
    }
}
function GetLayananPoliklinik() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataUnit/GetLayananPoliklinik/';
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
            $("#NamaPoliklinik").select2(); 
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
    window.location = base_url + "/SIKBREC/public/CutiDokter";
}

async function goVoidCuti(param) {
    try {
        $(".preloader").fadeIn();
        const data = await VoidCuti(param);
        updateUIdatagoVoidCuti(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function VoidCuti(param) {
    var form = $("#form_cuti_dokter").serialize();
    var url2 = "/SIKBREC/public/CutiDokter/goVoidCutiDokter";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&AlasanBatal=" + param 
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

function updateUIdatagoVoidCuti(data) {
    if (data.status == true) {
        toast(data.message, "success");
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    } else {
        toast(data.message, "error")
    }
}