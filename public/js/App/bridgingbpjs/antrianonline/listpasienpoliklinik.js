$(document).ready(function () {
    $(".preloader").fadeOut();
    onLoadFunctionAll();
    $('#showCall').hide();
});
async function onLoadFunctionAll() {
    try {
        const datagetAllDataDokterAktif = await getAllDataDokterAktif();
        updateUIdatagetAllDataDokterAktif(datagetAllDataDokterAktif);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetAllDataDokterAktif(datagetNamaCaraMasuk) {
    let responseApi = datagetNamaCaraMasuk;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Dokterx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].First_Name + '</option';
            $("#Dokterx").append(newRow);
        }
    }
}
function getAllDataDokterAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getAllDataDokterAktif';
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
            $("#Dokterx").select2();
        })
}
function GoMonitoringBPJS() {
    $('#showCall').show();
    var dateReg = document.getElementById("dateReg").value;
    var Dokterx = document.getElementById("Dokterx").value;
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "order": [[6, "asc"]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/CallerDokter/GoCallerDokter",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.dateReg = dateReg;
                d.Dokterx = Dokterx;
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.NoMR
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.NoMR + '</span>'
                        if (row.StatusAntrian == "1") { 
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.NoMR + '</span>'
                        }
                    }
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.PatientName
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.PatientName + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.PatientName + '</span>'
                        }
                    }
                    return html 
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.NoEpisode
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.NoEpisode + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.NoEpisode + '</span>'
                        }
                    }
                    return html  
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.NoRegistrasi
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.NoRegistrasi + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.NoRegistrasi + '</span>'
                        }
                    }
                    return html   
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.LokasiPasien
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.LokasiPasien + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.LokasiPasien + '</span>'
                        }
                    }
                    return html    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.Perusahaan
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.Perusahaan + '<br>' + row.NoSEP + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.Perusahaan + '<br>' + row.NoSEP + '</span>'
                        }
                    }
                    return html    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Bridging == null) {
                        var html = ""
                        var html = '<span class="label label-danger" > NO </span>'
                    } else {
                        var html = ""
                        var html = ' YES '
                        
                    }
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.task2 == null) {
                        var html = ""
                        var html = row.NoAntrianAll
                    } else {
                        var html = ""
                        var html = '<span class="label label-primary" > ' + row.NoAntrianAll + '</span>'
                        if (row.StatusAntrian == "1") {
                            var html = ""
                            var html = '<span class="label label-danger" > ' + row.NoAntrianAll + '</span>'
                        }
                    }
                    return html  
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                   // if (row.StatusAntrian == "0") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger border-success btn-animated btn-xs"  onclick=\'GoServe2("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Task 2</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button><button type="button" class="btn btn-warning border-success btn-animated btn-xs"  onclick=\'GoServe("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Task 4</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>'
                        return html
                    // } else {
                    //     var html = ""
                    //     return html
                    // }
                }
            },
        ]
    });

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
async function GoServe(params) {
    try {
        let noreg = params;
        $(".preloader").fadeIn();
        const dataGoTambahTaskAntrianBPJS = await GoTambahTaskAntrianBPJS(noreg);
        updateUIdataGoTambahTaskAntrianBPJS(dataGoTambahTaskAntrianBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        GoMonitoringBPJS();
        swal("Oops", "Sorry.." + err, "error");
    }
}
async function GoServe2(params) {
    try {
        let noreg = params;
        $(".preloader").fadeIn();
        const dataGoTambahTaskAntrianBPJS = await GoTambahTaskAntrianBPJS2(noreg);
        updateUIdataGoTambahTaskAntrianBPJS(dataGoTambahTaskAntrianBPJS);
        GoMonitoringBPJS();
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function GoTambahTaskAntrianBPJS2(noreg) {
    var kodebooking = noreg;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CallerDokter/UpdateTaskAntrianBPJS2';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "kodebooking=" + kodebooking
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
            GoMonitoringBPJS();
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
function GoTambahTaskAntrianBPJS(noreg) {
    var kodebooking = noreg; 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/CallerDokter/UpdateTaskAntrianBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "kodebooking=" + kodebooking  
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
// ADD_BPJS
function updateUIdataGoTambahTaskAntrianBPJS(data) {
    swal('Antrian Berhasil di Kirim Ke BPJS Kesehatan, Silahkan Cetak Bukti Registrasi dan SEP Pasien.')
        .then((value) => {
           // $('#notif_Cetak').modal('show');
            GoMonitoringBPJS();
        });
} 

async function GoCallDokter() {
    try {
        const dataCallDokter = await CallDokter();
        updateUIdataCallDokter(dataCallDokter);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataCallDokter(params) {
    toast("OK", params, "success")
}
async function GoReCallDokter() {
    try {
        const dataReCallDokter = await ReCallDokter();
        updateUIdataReCallDokter(dataReCallDokter);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
 }
function updateUIdataReCallDokter(params) {
    toast("OK", params, "success")
}

async function GoSpecialCallDokter() {
    try {
        const dataGoSpecialCallDokter = await GoSpecialCallDokter();
        updateUIdataGoSpecialCallDokter(dataGoSpecialCallDokter);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGoSpecialCallDokter(params) {
    toast("OK", params, "success")
}
function GoSpecialCallDokter() {
    var base_url = window.location.origin;
    var kodedokter = $("#Dokterx").val();
    var koderuangan = $("#ruangan").val();
    var antrianNo = $("#antrianNo").val();
    let url = base_url + '/SIKBREC/public/CallerDokter/SpecialCallDokterCendana';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kodedokter=' + kodedokter + '&koderuangan=' + koderuangan + '&antrianNo=' + antrianNo
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
        })
}
function ReCallDokter() {
    var base_url = window.location.origin;
    var kodedokter = $("#Dokterx").val();
    var koderuangan = $("#ruangan").val();
    let url = base_url + '/SIKBREC/public/CallerDokter/ReCallDokterCendana';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kodedokter=' + kodedokter + '&koderuangan=' + koderuangan
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
        })
}
function CallDokter() {
    var base_url = window.location.origin;
    var kodedokter = $("#Dokterx").val();
    var koderuangan = $("#ruangan").val();
    let url = base_url + '/SIKBREC/public/CallerDokter/CallDokterCendana';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kodedokter=' + kodedokter + '&koderuangan=' + koderuangan 
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
        })
}