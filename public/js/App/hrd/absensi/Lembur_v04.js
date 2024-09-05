$(document).ready(function () {
    getpegawai(); getLokasi();
    var idx = $("#IdTranasksiAuto").val();
    if (idx != null) {
        setTimeout(function () { ShowData(); }, 200);
    }
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({
        "order": [[0, 'desc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Lembur/showDataTrsLemburAll/',
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoSPL + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Nama + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglLembur + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JamAwal + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JamAkhir + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JumlahJamLembur + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.AlasanLembur + ' </font>  ';
                    return html
                }
            },

            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button title="Show Data" type="button" class="btn btn-default border-success btn-animated btn-wide" id="btn_showkasbon" onclick="ShowKasbonPegawai(' + row.ID + ')"  ><span class="visible-content" >View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
   
}); 
function BatalTRsLembur() {
    swal({
        title: "BATAL",
        text: "Data yang sudah di Batalkan tidak bisa di Edit kembali, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                go_batal();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function go_batal() {
    var form_data = $("#form_trs_lembur").serialize();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/BatalLembur/',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                $(".preloader").fadeOut();
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
                $(".preloader").fadeOut(); 
                document.getElementById("form_trs_lembur").reset();  
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
                toastr["success"](data.message);
                setTimeout(function () { goBack(); }, 1000);
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
function SaveTRsLembur() {
    swal({
        title: "Simpan",
        text: "Data yaA1naag sudah di Finalkan tidak bisa di Edit kembali, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                go_save();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function go_save() {
    var form_data = $("#form_trs_lembur").serialize();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/CreateLembur/',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) { 
            if (data.status == "warning") {
                $(".preloader").fadeOut(); 
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
                $(".preloader").fadeOut(); 
                document.getElementById("form_trs_lembur").reset(); 

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
                toastr["success"](data.message);
                setTimeout(function () { goBack(); }, 1000);

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
function ShowData() {
    var idx = $("#IdTranasksiAuto").val();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/ShowDatalemburByID/',
        type: "POST",
        data: { id: idx }, 
        dataType: "JSON",
        success: function (data) {
            $("#Hr_Nama_Pegawai").val(data.IdPegawai);
            $("#Hr_ID_Lokasi").val(data.ID_Lokasi);
            $("#IdTranasksi").val(data.NoSPL);
            $("#IdTranasksiAuto").val(data.ID);
            $('#Hr_Nama_Pegawai').val(data.ID_Data).trigger('change');
            $('#Hr_ID_Lokasi').val(data.ID_Lokasi).trigger('change');
            $("#Hr_tglcuti_awal").val(data.TglLembur);
            $("#Hr_Jam_Awal").val(data.JamAwal);
            $("#Hr_Jam_Akhir").val(data.JamAkhir);
            $("#Hr_jumlah_Lembur").val(data.JumlahJamLembur);
            $("#Hr_Jenis_lembur").val(data.JenisLembur);
            $("#catatan").val(data.AlasanLembur);
            $('.js-example-basic-single').select2();
        } , error: function (data) {
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
function getWaktuLembur() {
    var Hr_tglcuti_awal = $("#Hr_tglcuti_awal").val();
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_ID_Lokasi = $("#Hr_ID_Lokasi").val();
    console.log(Hr_tglcuti_awal)
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/Lembur/getDataJamLemburDefault/",
        method: "POST",
        data: "Hr_tglcuti_awal=" + Hr_tglcuti_awal + "&Hr_Nama_Pegawai=" + Hr_Nama_Pegawai
            + "&Hr_ID_Lokasi=" + Hr_ID_Lokasi,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $("#Hr_tglcuti_awal").val('');

            } else if (data.status == "success") {
                 //
                console.log(data.JAM_SHIFT_MASUK_AFTER)
                $("#Hr_Jam_Awal").val(data.JAM_SHIFT_MASUK_AFTER);
                $("#Hr_Jam_Akhir").val(data.JAM_SHIFT_KELUAR_AFTER);
                getJam();
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
function getJam() {
    var xtglLembur = $("#Hr_tglcuti_awal").val();
    var tglcuti_awal = $("#Hr_Jam_Awal").val();
    var tglcuti_akhir = $("#Hr_Jam_Akhir").val();

    var tempWaktu_awal = xtglLembur + ' ' + tglcuti_awal;
    var tempWaktu_akhir = xtglLembur + ' ' + tglcuti_akhir;

    const date1 = new Date(tempWaktu_awal);
    const date2 = new Date(tempWaktu_akhir);
    var firstDate = new Date(date1).getHours();
    var secondDate = new Date(date2).getHours();
    if (date1 > date2) {
        swal("Jam Awal Lebih besar Dari Jam Akhir! Mohon Diperiksa Kembali!")
            .then((value) => {
                swal(`The returned value is: ${value}`);
            });

        $("#Hr_jumlah_cuti").val('0');
        return;
    }
    if (firstDate > secondDate) {
        swal("Jam Awal Lebih besar Dari Jam Akhir! Mohon Diperiksa Kembali!")
            .then((value) => {
                swal(`The returned value is: ${value}`);
            });

        $("#Hr_jumlah_cuti").val('0');
        return;
    }
    if (tglcuti_awal != '' && tglcuti_akhir != '') {
        var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds

        var selisih = secondDate - firstDate;
        $("#Hr_jumlah_Lembur").val(selisih);
        console.log(oneDay, 'oneDay');
        console.log(firstDate);
        console.log(secondDate);
        console.log(selisih);
    }
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
            $("#Hr_ID_Lokasi").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].KD_LOKASI + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_ID_Lokasi").append(newRow);
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
function getpegawai() {
    var xdi = "1";
    const base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/AbsensiManual/getpegawaiAllAktif/',
        dataType: "json",
        success: function (data) {
            if (data.data.getpegawai !== null && data.data.getpegawai !== undefined) {
                console.log(data);
                var newRow = '<option value=""></option';
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
function ShowKasbonPegawai(x) {
    var str = btoa(x);
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Lembur/viewForm/' + str;
}
function newTrsLembur() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Lembur/viewForm';
}
function goBack() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Lembur/';
}