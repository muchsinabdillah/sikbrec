$(document).ready(function () {
    getpegawai();
    getLokasi();
    getJenisCuti();
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
            "url": base_url + '/pms_gut/public/Surat/showDataTrsSuratAll/',
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoCuti + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.TglCutiAwal + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglCutiAkhir + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JumlahHariCuti + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Group_Cuti + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NM_LOKASI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.AlasanCuti + ' </font>  ';
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
        ],
    });
    
});
function go_saveBatal() {
    var form_data = $("#form_cuti").serialize();
    const base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/Surat/BatalSurat/',
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
                document.getElementById("form_cuti").reset();
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
function myJsFuncBatal() {
    swal({
        title: "Batal",
        text: "Data yang sudah di Finalkan tidak bisa di Edit kembali, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                go_saveBatal();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function enable_jensCuti() {
    var jenisTransaksi = $("#Hr_TipeTransaksi").val();
    console.log(jenisTransaksi);

}
function ShowData() {
    var idx = $("#IdTranasksiAuto").val();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Surat/showSuratById/',
        type: "POST",
        data: { id: idx },
        dataType: "JSON",
        success: function (data) {
            $("#Hr_Nama_Pegawai").val(data.IdPegawai);
            $("#Hr_ID_Lokasi").val(data.ID_Lokasi);
            $("#IdTranasksi").val(data.NoCuti);
            $("#IdTranasksiAuto").val(data.ID);
            $('#Hr_TipeTransaksi').val(data.Group_Cuti).trigger('change');
            $('#Hr_JenisCuti').val(data.JenisCuti).trigger('change');
            $("#IdTranasksiAuto").val(data.ID);
            $("#Hr_tglcuti_akhir").val(data.TglCutiAkhir);
            $("#Hr_tglcuti_awal").val(data.TglCutiAwal);
            $("#Hr_jumlah_cuti").val(data.JumlahHariCuti);
            $("#catatan").val(data.AlasanCuti);
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
function go_save() {
    var form_data = $("#form_cuti").serialize(); 
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Surat/CreateTrsCuti/',
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
                document.getElementById("form_cuti").reset();

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
function goBack() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Surat/';
}
function myJsFunc() {
    swal({
        title: "Simpan",
        text: "Data yang sudah di Finalkan tidak bisa di Edit kembali, Lanjutan Transaksi ?",
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
function getHari() {
    var tglcuti_awal = $("#Hr_tglcuti_awal").val();
    var tglcuti_akhir = $("#Hr_tglcuti_akhir").val();
    const date1 = new Date(tglcuti_awal);
    const date2 = new Date(tglcuti_akhir);
    if (date1 > date2) {
        swal("Tanggal Cuti Awal Harus Lebih Kecil Dari Tanggal Cuti Akhir! Mohon Diperiksa Kembali!")
            .then((value) => {
                swal(`The returned value is: ${value}`);
            });

        $("#Hr_jumlah_cuti").val('0');
        return;
    }
    if (tglcuti_awal != '' && tglcuti_akhir != '') {
        const diffTime = Math.abs(date2 - date1 + 1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        $("#Hr_jumlah_cuti").val(diffDays);
        console.log(diffDays);
    }

}
function getJenisCuti() {
    var xdi = "1";
    const base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Surat/getJenisCuti/',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#Hr_JenisCuti").append(newRow);
            var elements = $();
            var dataarray = data.getJenisCuti.length;
            for (i = 0; i < data.getJenisCuti.length; i++) {
                var newRow = '<option value="' + data.getJenisCuti[i].KODE_CUTI + '">' + data.getJenisCuti[i].NAMA_CUTI + '</option';
                $("#Hr_JenisCuti").append(newRow);
            }

        }
    });
}
function getLokasi() {
    const base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Surat/getAllJobOrderbyHakAkses/',
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
        url: base_url + '/pms_gut/public/Surat/getpegawaiAllAktif/',
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
    window.location = base_url + '/pms_gut/public/Surat/viewForm/' + str;
}
function newTrsSurat() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Surat/viewForm';
}
function goBack() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/Surat/';
}