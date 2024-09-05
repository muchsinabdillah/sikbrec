$(document).ready(function () {
    asyncShowMain(); 
    const btnreservasi = document.querySelector('#btnreservasi');
    btnreservasi.addEventListener('click', async function () {
        try { 
            const result = await go_saveHakAkses(); 
            getDataUserAkses();
        } catch (err) {
            toast(err, "error")
        }
    })
    const btnCopyHakAkses = document.querySelector('#btnCopyHakAkses');
    btnCopyHakAkses.addEventListener('click', async function () {
        try {
            const result = await go_saveCopiHakAkses();
            getDataUserAkses();
        } catch (err) {
            toast(err, "error")
        }
    })
    
}); 
function go_saveCopiHakAkses() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_UserCopi_Hak_Akses = $('#Mst_UserCopi_Hak_Akses').val(); 
    let url = base_url + '/SIKBREC/public/MasterLoginUser/saveCopiHakAkses';

    // data form
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdTranasksiAuto=" + IdTranasksiAuto +
            "&Mst_UserCopi_Hak_Akses=" + Mst_UserCopi_Hak_Akses 
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
function getDataUserAkses() {
    var IdTranasksiAuto = $("#IdTranasksiAuto").val(); 
    const base_url = window.location.origin;
    $('#tblHakAkses').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblHakAkses').DataTable({
        "order": [[0, 'desc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterLoginUser/ShowListHakAkses",
            "type": "POST",
            data: function (d) {
                d.IdTranasksiAuto = IdTranasksiAuto;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.id + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.nama_menu + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.nama_submenu + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Is_Create == "NO") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled"  onclick =\'updateCreate("' + row.id + '","' + row.Is_Create + '")\'>' + row.Is_Create + '<span class="btn-label btn-label-right"><i class="fa fa-times"></i></span></button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled next-btn" onclick =\'updateCreate("' + row.id + '","' + row.Is_Create + '")\'>' + row.Is_Create + '<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                    } 
                }
                
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi  
                    if (row.Is_Delete == "NO") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled"  onclick =\'updateDelete("' + row.id + '","' + row.Is_Delete + '")\'>' + row.Is_Delete + '<span class="btn-label btn-label-right"><i class="fa fa-times"></i></span></button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled next-btn" onclick =\'updateDelete("' + row.id + '","' + row.Is_Delete + '")\'>' + row.Is_Delete + '<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) {
                    var html = "" 
                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-warning" id="btn_showkasbon" onclick="deleteakses(' + row.id + ')"  >HAPUS</button>'
                    return html
                },
            },

        ],
    });
}
async function updateDelete(id, isDelete) {
    try {
        const response = await GoupdateDelete(id, isDelete);
        if (response.status == "success") {
            toast("Data Hak Akses Berhasil di Rubah !", "success")
            getDataUserAkses();
        }
    } catch (err) {
        toast(err, "error")
    }
}
function GoupdateDelete(id, isDelete) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/GoupdateDelete';

    // data form
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + id + "&isDelete=" + isDelete
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
async function updateCreate(id,isDelete) {
    try {
        const response = await GoupdateCreate(id,isDelete);
        if (response.status == "success") {
            toast("Data Hak Akses Berhasil di Rubah !", "success")
            getDataUserAkses(); 
        }
    } catch (err) {
        toast(err, "error")
    }
}
function GoupdateCreate(id, isDelete) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin; 
    let url = base_url + '/SIKBREC/public/MasterLoginUser/GoupdateCreate';

    // data form
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "id=" + id + "&isDelete=" + isDelete
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
function go_saveHakAkses() {
    $(".preloader").fadeIn(); 
    var base_url = window.location.origin; 
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_ID_Hak_Akses = $('#Mst_ID_Hak_Akses').val();
    var Mst_Create = $('#Mst_Create').val();
    var Mst_Delete = $('#Mst_Delete').val(); 
    let url = base_url + '/SIKBREC/public/MasterLoginUser/CreateHakAksesbyUserID';

    // data form
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdTranasksiAuto=" + IdTranasksiAuto +
            "&Mst_Create=" + Mst_Create +
            "&Mst_ID_Hak_Akses=" + Mst_ID_Hak_Akses +
            "&Mst_Delete=" + Mst_Delete
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
function deleteakses(data) {
    swal({
        title: "Batal",
        text: "Apakah Anda ingin Batalkan Hak Akses ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                isdelete(data);
            } else {
                // swal("Transaction Rollback !");
            }
        });
}
async function isdelete(data) {
    try {
        const response = await Godelete(data);
        if (response.status == "success") {
            toast("Data Berhasil Dihapus !", "success")
            getDataUserAkses();

        }
    } catch (err) {
        toast(err, "error")
    }
}
function Godelete(params) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var dataParam = params; 
    let url = base_url + '/SIKBREC/public/MasterLoginUser/DeleteHakAksesbyUserID';

    // data form
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + dataParam 
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
async function asyncShowMain() {
    try { 
        await getHakAksesByForm(3);
        await getDataUserAkses();
        const datagetDataPegawai = await getDataPegawai();
        updateUIgetDataPegawai(datagetDataPegawai);
        const datagetDataSubMenu = await getDataSubMenu();
        updateUIdatagetDataSubMenu(datagetDataSubMenu);
        const datagetDatagetAllUserLogin = await getDatagetAllUserLogin();
       // console.log("datagetDatagetAllUserLogin", datagetDatagetAllUserLogin);
        updateUIdatagetDatagetAllUserLogin(datagetDatagetAllUserLogin);
        const datagetUserLoginbyId = await getUserLoginbyId();
        updateUIdatagetUserLoginbyId(datagetUserLoginbyId); 
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatagetAllUserLogin(datagetDatagetAllUserLogin) {
    let data = datagetDatagetAllUserLogin;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_UserCopi_Hak_Akses").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].ID + ' - ' + data[i].NamaLengkap + '</option';
            $("#Mst_UserCopi_Hak_Akses").append(newRow);
        }
    }
}
function getDatagetAllUserLogin() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterLoginUser/getAllUserLogin/';
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
            //$(".preloader").fadeOut(); 
            $("#Mst_UserCopi_Hak_Akses").select2();
            //$("#CodeRegis").select2();
            //$("#GrupInstalasi").select2();
        }).catch((err) => {
            console.log(err, "error")
        })
}
function updateUIdatagetDataSubMenu(datagetDataSubMenu) {
    let data = datagetDataSubMenu;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Mst_ID_Hak_Akses").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].ID + ' - ' + data[i].nama_submenu + '</option';
            $("#Mst_ID_Hak_Akses").append(newRow);
        }
    }
}
function getDataSubMenu() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSubmenu/getAllDataSubMenu/';
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
            //$(".preloader").fadeOut();
            $("#Mst_ID_Hak_Akses").select2();
            $("#Mst_Create").select2();
            $("#Mst_Delete").select2();
            $("#Mst_Status").select2();
            $("#Mst_Admin").select2();
            //$("#CodeRegis").select2();
            //$("#GrupInstalasi").select2();
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
function updateUIdatagetUserLoginbyId(data) {
    $("#Mst_NamaPegawai").val(convertEntities(data.Nama)); 
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