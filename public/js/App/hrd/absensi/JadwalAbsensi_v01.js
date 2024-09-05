$(document).ready(function () {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    document.getElementById("btnUpdateJadwal").disabled = true;
    getpegawai();
    getLokasi();
    getLokasi2();
    getShiftkerjaAllAktif();
}); 
function SendUpdate() {
    var Hr_PeriodeUPdt1 = $("#Hr_PeriodeUPdt1").val();
    var Hr_PeriodeUPdt2 = $("#Hr_PeriodeUPdt2").val();
    var Hr_LokasiProject_Updt = $("#Hr_LokasiProject_Updt").val();
    var Hr_Kode_Shift = $("#Hr_Kode_Shift").val();
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    console.log(Hr_Kode_Shift);
    const base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/JadwalAbsensi/SendUpdateJadwal/",
        method: "POST",
        data: "Hr_PeriodeUPdt1=" + Hr_PeriodeUPdt1 + "&Hr_PeriodeUPdt2=" + Hr_PeriodeUPdt2
            + "&Hr_LokasiProject_Updt=" + Hr_LokasiProject_Updt + "&Hr_Kode_Shift=" + Hr_Kode_Shift
            + "&Hr_Nama_Pegawai=" + Hr_Nama_Pegawai,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                getDataJadwal(); 
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
                toastr["error"](data.errorname);

            } else if (data.status == "success") {
                $('#Notif_awal_registrasi').modal('hide');
                getDataJadwal();
            }
            $(".preloader").fadeOut();
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });

}
function getShiftkerjaAllAktif() {
    const base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + "/pms_gut/public/JadwalAbsensi/getShiftkerjaAllAktif/",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#Hr_Kode_Shift").append(newRow);
            var elements = $();
            var dataarray = data.getJadwal.length;
            for (i = 0; i < data.getJadwal.length; i++) {
                var newRow = '<option value="' + data.getJadwal[i].KODE_SHIFT + '">' + data.getJadwal[i].NAMA_SHIFT + ' - ' + data.getJadwal[i].JAM_SHIFT_MASUK + ' - ' + data.getJadwal[i].JAM_SHIFT_KELUAR + '</option';
                $("#Hr_Kode_Shift").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });
}
function UpdateLibur(x) {
    const base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "argument=" + x,
        url: base_url +  "/pms_gut/public/JadwalAbsensi/UpdateLibur/", 
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
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
                toastr["error"](data.errorname);

            } else if (data.status == "success") {
                getDataJadwal(); 
            }

        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });

}
function BatalUpdateLibur(x) {
    const base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "argument=" + x,
        url: base_url + "/pms_gut/public/JadwalAbsensi/BatalUpdateLibur/",
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") { 
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
                toastr["error"](data.errorname);

            } else if (data.status == "success") {
                getDataJadwal();

            }

        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });

}
function testing(argument) { 
    $('#example tbody').on('click', '.checkbox', function () {
        if (this.checked == true) {
            var valuedata = this.value; 
            UpdateLibur(valuedata); 
        } else {
            var valuedata2 = this.value; 
            BatalUpdateLibur(valuedata2);
        }
    });
}
// get jadwal
function getDataJadwal() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_LokasiProject = $("#Hr_LokasiProject").val();
    var title = 'Jadwal Absensi';
    const base_url = window.location.origin;
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({

        "scrollY": 500,
        "scrollX": true,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/JadwalAbsensi/ShowDataJadwalPegawai/", 
            "type": "POST",
            data: function (d) {
                d.Hr_Periode = Hr_Periode;
                d.Hr_Nama_Pegawai = Hr_Nama_Pegawai;
                d.Hr_LokasiProject = Hr_LokasiProject;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.namahari + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TGL_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.LIBUR == 1) {
                        var html = ""
                        var html = '<input class="checkbox" type="checkbox" id="edit_checkbox_operasi" name="edit_checkbox_operasi"  onclick=\'testing("' + row.ID + '")\' value ="' + row.ID + '" checked /> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<input class="checkbox" type="checkbox" id="edit_checkbox_operasi" name="edit_checkbox_operasi"  onclick=\'testing("' + row.ID + '")\'   value ="' + row.ID + '"  /> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_SHIFT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JAM_SHIFT_MASUK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JAM_SHIFT_KELUAR + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KETERANGAN + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_LOKASI + '</font> ';
                    return html
                }
            },
        ],
    });
}
// gen absensi
function loadJdwl() {
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_LokasiProject = $("#Hr_LokasiProject").val();
    var Hr_Group_Absen = $("#Hr_Group_Absen").val();
    var Hr_Periode = $("#Hr_Periode").val();
    const base_url = window.location.origin;  
    $.ajax({
        url: base_url + '/pms_gut/public/JadwalAbsensi/CreateJadwal/',
        method: "POST",
        data: "Hr_Nama_Pegawai=" + Hr_Nama_Pegawai + "&Hr_LokasiProject=" + Hr_LokasiProject
            + "&Hr_Group_Absen=" + Hr_Group_Absen + "&Hr_Periode=" + Hr_Periode,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                getDataJadwal();
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
                toastr["error"](data.errorname);
                document.getElementById("btnUpdateJadwal").disabled = false;
                 

            } else if (data.status == "success") { 
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
                toastr["success"](data.notrs);
                getDataJadwal();
                document.getElementById("btnUpdateJadwal").disabled = false;
            }
            $(".preloader").fadeOut();
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });
}
// load jo
function getLokasi2() {
    var xdi = "1";
    const base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/JadwalAbsensi/getAllJobOrderbyHakAkses/',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#Hr_LokasiProject_Updt").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].KD_LOKASI + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_LokasiProject_Updt").append(newRow);
            }
            //$('.js-example-basic-single').select2(); 

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });
}
function getLokasi() {
    const base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/JadwalAbsensi/getAllJobOrderbyHakAkses/',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#Hr_LokasiProject").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].KD_LOKASI + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_LokasiProject").append(newRow);
            }
            $('.js-example-basic-single').select2();

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });
}
// get data pegawai
function getpegawai() {
    var xdi = "1";
    const base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/JadwalAbsensi/getpegawaiAllAktif/',
        dataType: "json",
        success: function (data) {
            if (data.data.getpegawai !== null && data.data.getpegawai !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#Hr_Nama_Pegawai").append(newRow);
                var elements = $();
                var dataarray = data.data.getpegawai.length;
                for (i = 0; i < data.data.getpegawai.length; i++) {
                    var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                    $("#Hr_Nama_Pegawai").append(newRow);
                }
                $('.js-example-basic-single').select2();
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
            $(".preloader").fadeOut();
        }
    });
}
function pasingkode(){
    var lokasitemp = $("#Hr_LokasiProject").val();
    $('#Hr_LokasiProject_Updt').val(lokasitemp).trigger('change');
}