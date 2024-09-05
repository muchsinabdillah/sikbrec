$(document).ready(function () {
    asyncShowMain();
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterSubMenu();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function saveMasterSubMenu() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSubmenu/addSubMenu';

    // data form
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
            } else if (response.Found) {
                MyBack();
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
        await getHakAksesByForm(2);
        const dataGetMenu = await GetMenu(); 
        updateUIdataGetMenu(dataGetMenu);
        const datagetDataSubMenu = await getDataSubMenu();
        updateUIgetDataSubMenu(datagetDataSubMenu);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetMenu(dataGetMenu) {
    let data = dataGetMenu;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#CodeMenu").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].nama_menu + '</option';
            $("#CodeMenu").append(newRow);
        }
    }
}
function GetMenu() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterMenu/getAllDataMenu';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idpoli=' + $("#GrupPerawatan").val()
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
            $("#CodeMenu").select2();
        })
}
function updateUIgetDataSubMenu(datagetDataSubMenu) {
    let dataResponse = datagetDataSubMenu;
    $("#IdAuto").val(convertEntities(dataResponse.data.ID));
    $("#NamaSubMenu").val(convertEntities(dataResponse.data.nama_submenu));
    $("#UrlSubMenu").val(convertEntities(dataResponse.data.url));
    $("#IconSubMenu").val(convertEntities(dataResponse.data.icon));
    $("#CodeMenu").val(convertEntities(dataResponse.data.id_menu)).trigger('change');
}
function getDataSubMenu() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSubmenu/getSubMenuId/';
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
            console.log(response)
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
            //$("#EMRMenu").select2();
            //$("#CodeRegis").select2();
            //$("#GrupInstalasi").select2();
        }).catch((err) => {
            console.log(err, "error")
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterSubMenu/";
}
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var ReferalFeeAsuransi = document.getElementById("ReferalFeeAsuransi");
    ReferalFeeAsuransi.addEventListener("keyup", function (e) {
        ReferalFeeAsuransi.value = formatRupiah(this.value);
    });
    var ReferalFee = document.getElementById("ReferalFee");
    ReferalFee.addEventListener("keyup", function (e) {
        ReferalFee.value = formatRupiah(this.value);
    });
    var DiskonPerItem = document.getElementById("DiskonPerItem");
    DiskonPerItem.addEventListener("keyup", function (e) {
        DiskonPerItem.value = formatRupiah(this.value);
    });
}