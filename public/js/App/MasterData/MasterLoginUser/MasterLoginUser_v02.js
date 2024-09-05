$(document).ready(function () {
    asyncShowMain(); 
    $('#Mst_ID_Pegawai').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#Mst_NamaPegawai").val(data.text);
    });
    const saveButton = document.querySelector('#searchpins');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await getLastPINID();
            $("#Mst_Username").val(result.urut);
            document.getElementById("searchpins").disabled = true;
        } catch (err) {
            toast(err, "error")
        }
    })
    const btnreservasi = document.querySelector('#btnreservasi');
    btnreservasi.addEventListener('click', async function () {
        try {
            const result = await createUserLogin();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function createUserLogin() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/createUserLogin';

    // data form
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_ID_Pegawai = $('#Mst_ID_Pegawai').val();
    var Mst_NamaPegawai = $('#Mst_NamaPegawai').val();
    var Mst_Username = $('#Mst_Username').val();
    var Mst_Password = $('#Mst_Password').val();
    var Mst_Status = $('#Mst_Status').val();
    var Mst_Admin = $('#Mst_Admin').val();
    var Mst_JobTitle = $('#Mst_JobTitle').val();
    var Mst_GroupUser = $('#Mst_GroupUser').val();
    var Mst_DesignationID = $('#Mst_DesignationID').val();
    var Mst_Menu1 = $('#Mst_Menu1').val();
    var Mst_Menu2 = $('#Mst_Menu2').val(); 
    var Mst_NIKKTP = $('#Mst_NIKKTP').val(); 
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdTranasksiAuto=" + IdTranasksiAuto + "&Mst_ID_Pegawai=" + Mst_ID_Pegawai
            + "&Mst_NamaPegawai=" + Mst_NamaPegawai + "&Mst_Username=" + Mst_Username
            + "&Mst_Password=" + Mst_Password + "&Mst_Status=" + Mst_Status
            + "&Mst_Admin=" + Mst_Admin + "&Mst_JobTitle=" + Mst_JobTitle
            + "&Mst_GroupUser=" + Mst_GroupUser + "&Mst_DesignationID=" + Mst_DesignationID
            + "&Mst_Menu1=" + Mst_Menu1 + "&Mst_Menu2=" + Mst_Menu2 + "&Mst_NIKKTP=" + Mst_NIKKTP 
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
async function getLastPINID() {
    $(".preloader").fadeIn();  
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getLastPINID';
    // data form
    var form_data = "DY";
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'params=' + form_data
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
        })
}
function slice_word() {
    var IdTranasksiAuto = $("[name='IdTranasksiAuto']").val();
    var nik = $("[name='Mst_ID_Pegawai']").val();
    console.log(nik);
    if (IdTranasksiAuto == '' ){
        if (nik.length == 10) { 
            var filter = nik.slice(6, 10);
            $("#Mst_Username").val(filter); 
        } else { 
            var kosng = '-';
            $("#Mst_Username").val(kosng); 
        }
    } 
}
async function asyncShowMain() {
    try {
        await getHakAksesByForm(3);
        const datagetGroupUser = await getGroupUser();  
        updateUIdatagetGroupUser(datagetGroupUser);
        const datagetMenu = await getMenu(); 
        updateUIdatagetMenu(datagetMenu);
        const datagetMenu2 = await getMenu2();
        updateUIdatagetMenu2(datagetMenu2);
        const datagetDataPegawai = await getDataPegawai();
        updateUIgetDataPegawai(datagetDataPegawai);
        const datagetUserLoginbyId = await getUserLoginbyId();
        updateUIdatagetUserLoginbyId(datagetUserLoginbyId);
        console.log(datagetUserLoginbyId);
        $("#Mst_DesignationID").select2(); 
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetUserLoginbyId(data) { 
    $("#Mst_NamaPegawai").val(convertEntities(data.Nama));
    $("#Mst_Username").val(convertEntities(data.NoPIN));
    $("#Mst_Password").val(convertEntities(data.Password));
    $("#Mst_JobTitle").val(convertEntities(data.Jobtitle));
    $('#Mst_ID_Pegawai').val(convertEntities(data.NIK)).trigger('change');
    $('#Mst_Status').val(convertEntities(data.UserStatus)).trigger('change');
    $('#Mst_Admin').val(convertEntities(data.Administrator)).trigger('change');
    $('#Mst_GroupUser').val(convertEntities(data.GroupUser)).trigger('change');
    $('#Mst_DesignationID').val(convertEntities(data.DesignationID)).trigger('change');
    $('#Mst_Menu1').val(convertEntities(data.Menu)).trigger('change');
    $('#Mst_Menu2').val(convertEntities(data.Menu2)).trigger('change');
    $("#Mst_NIKKTP").val(convertEntities(data.NIK_KTP));
    var IdTranasksiAuto = $("[name='IdTranasksiAuto']").val();
    if (IdTranasksiAuto == '') {
        document.getElementById("searchpins").disabled = false;
        document.getElementById("Mst_Username").disabled = false;
        document.getElementById("Mst_Password").disabled = false;
        document.getElementById("Mst_ID_Pegawai").disabled = false;
    } else if (IdTranasksiAuto != ''){
        document.getElementById("searchpins").disabled = true;
        document.getElementById("Mst_Username").disabled = true;
        document.getElementById("Mst_Password").disabled = true;
        document.getElementById("Mst_ID_Pegawai").disabled = true; 

    }
}
function getUserLoginbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getUserLoginbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdTranasksiAuto").val()
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
            $("#Mst_ID_Pegawai").select2();
        }).catch((err) => {
            console.log(err, "error")
        })
}
function updateUIgetDataPegawai(datagetDataPegawai) {
    let data = datagetDataPegawai;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_ID_Pegawai").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].NIP + '">' + data[i].NIP + ' - ' + data[i].Nama + '</option';
            $("#Mst_ID_Pegawai").append(newRow);
        }
    }
}
function getDataPegawai() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getDataPegawai/';
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
            $("#Mst_ID_Pegawai").select2();
        }).catch((err) => {
            console.log(err, "error")
        })
}
function updateUIdatagetMenu2(datagetMenu) {
    let data = datagetMenu;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_Menu2").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].Menu2 + '">' + data[i].Menu2 + '</option';
            $("#Mst_Menu2").append(newRow);
        }
    }
}
function getMenu2() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getMenu2/';
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
            $("#Mst_Menu2").select2();
        }).catch((err) => {
            console.log(err, "error")
        })
}
function updateUIdatagetMenu(datagetMenu) {
    let data = datagetMenu;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_Menu1").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].Menu + '">' + data[i].Menu + '</option';
            $("#Mst_Menu1").append(newRow);
        }
    }
}
function getMenu() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getMenu/';
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
            $("#Mst_Menu1").select2();
        }).catch((err) => {
            console.log(err, "error")
        })
}
function updateUIdatagetGroupUser(datagetGroupUser) {
    let data = datagetGroupUser;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_GroupUser").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].GroupUser + '">' + data[i].GroupUser + '</option';
            $("#Mst_GroupUser").append(newRow);
        }
    }
}
function getGroupUser() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getGroupUser/';
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
            $("#Mst_GroupUser").select2(); 
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
    window.location = base_url + "/SIKBREC/public/MasterLoginUser/";
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