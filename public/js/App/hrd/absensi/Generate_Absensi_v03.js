$(document).ready(function () {
    $(".preloader").fadeOut();
    $("#pnlViewListDetil").hide();
    $(document).on('click', '#btnViewListDetil', function () {
        $("#pnlViewListDetil").show();
    });
    $(document).on('click', '#panelhideme', function () {
        $("#pnlViewListDetil").hide();
    });
    getpegawai();
    getLokasi();
    loaddataabsensimanualByPegawai();
});
function go_batal() { 
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_ID_Lokasi = $("#Hr_ID_Lokasi").val();
    var IdTranasksi = $("#IdTranasksiL").val();
    var IdTranasksiAuto = $("#IdTranasksiAutoL").val();
    var Hr_tglcuti_awal = $("#Hr_tglcuti_awal").val();
    var Hr_Jam_Awal = $("#Hr_Jam_Awal").val();
    var Hr_Jam_Akhir = $("#Hr_Jam_Akhir").val();
    var Hr_jumlah_Lembur = $("#Hr_jumlah_Lembur").val();
    var Hr_Jenis_lembur = $("#Hr_Jenis_lembur").val();
    var catatan = $("#catatan").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/BatalLembur/',
        method: "POST",
        data: "Hr_Nama_Pegawai=" + Hr_Nama_Pegawai + "&Hr_ID_Lokasi=" + Hr_ID_Lokasi
            + "&IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto
            + "&Hr_tglcuti_awal=" + Hr_tglcuti_awal + "&Hr_Jam_Awal=" + Hr_Jam_Awal
            + "&Hr_Jam_Akhir=" + Hr_Jam_Akhir
            + "&Hr_jumlah_Lembur=" + Hr_jumlah_Lembur
            + "&Hr_Jenis_lembur=" + Hr_Jenis_lembur
            + "&catatan=" + catatan,
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
                $(".preloader").fadeOut();
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
                toastr["success"]("Transaksi Berhasil Dihapus !");
                $('#Notif_awal_registrasi').modal('hide');
                getdataLembur();
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
function go_save() {
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_ID_Lokasi = $("#Hr_ID_Lokasi").val();
    var IdTranasksi = $("#IdTranasksiL").val();
    var IdTranasksiAuto = $("#IdTranasksiAutoL").val();
    var Hr_tglcuti_awal = $("#Hr_tglcuti_awal").val();
    var Hr_Jam_Awal = $("#Hr_Jam_Awal").val();
    var Hr_Jam_Akhir = $("#Hr_Jam_Akhir").val();
    var Hr_jumlah_Lembur = $("#Hr_jumlah_Lembur").val();
    var Hr_Jenis_lembur = $("#Hr_Jenis_lembur").val();
    var catatan = $("#catatan").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/CreateLembur/',
        method: "POST",
        data: "Hr_Nama_Pegawai=" + Hr_Nama_Pegawai + "&Hr_ID_Lokasi=" + Hr_ID_Lokasi
            + "&IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto
            + "&Hr_tglcuti_awal=" + Hr_tglcuti_awal + "&Hr_Jam_Awal=" + Hr_Jam_Awal
            + "&Hr_Jam_Akhir=" + Hr_Jam_Akhir
            + "&Hr_jumlah_Lembur=" + Hr_jumlah_Lembur
            + "&Hr_Jenis_lembur=" + Hr_Jenis_lembur
            + "&catatan=" + catatan ,
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
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('SIMPAN');
                document.getElementById("form_trs_lembur").reset();
                document.getElementById("btnreservasi").disabled = false;
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
                toastr["success"]("Transaksi Berhasil Disimpan !");
                getdataLembur();
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

function go_saveadd_Manual() {
    var IdTranasksi = $("#IdTranasksi").val();
    var IdTranasksiAuto = $("#IdTranasksiAuto").val();
    var Absen_Tanggal = $("#Absen_Tanggal").val();
    var Absen_Jam = $("#Absen_Jam").val();
    var Absen_PIN = $("#Absen_PIN").val();
    var Hr_Nama_Pegawai2 = $("#Hr_Nama_Pegawai2").val();
    var Absen_Status = $("#Absen_Status").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/AbsensiManual/CreateAbsenManual/',
        method: "POST",
        data: "IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto
            + "&Absen_Tanggal=" + Absen_Tanggal + "&Absen_Jam=" + Absen_Jam
            + "&Absen_PIN=" + Absen_PIN + "&Hr_Nama_Pegawai=" + Hr_Nama_Pegawai2
            + "&Absen_Status=" + Absen_Status,
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
                $(".preloader").fadeOut();

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
                toastr["success"]("Transaksi Berhasil Disimpan !");
                        loaddataabsensimanualByPegawai();
                        $("#IdTranasksi").val('');
                        $("#IdTranasksiAuto").val('');
                        $("#Absen_Tanggal").val('');
                        $("#Absen_Jam").val('');
                        $("#Absen_PIN").val('');
                        $("#Hr_Nama_Pegawai2").val('');
                        $("#Absen_Status").val('');
                $(".preloader").fadeOut();
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
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
                go_saveadd_Manual();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function loaddataabsensimanualByPegawai() {
    var base_url = window.location.origin;
    $('#tblabsensimanual').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblabsensimanual').DataTable({
        "order": [[1, 'desc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/AbsensiManual/showDataAbsensiManualAll/',
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FD_TGL + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_KD_PEG + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.IO + ' </font>  ';
                    return html
                }
            },

            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="ShowKasbonPegawai(' + row.ID + ')"  >View</button>'
                    return html
                },
            },
        ]
    });
}
function ShowKasbonPegawai(x) {
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/AbsensiManual/ShowDataAbsensiManualByID",
        data: "id=" + x,
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#IdTranasksi").val(data.ID);
            $("#Absen_PIN").val(data.FS_PIN);
            $('#Hr_Nama_Pegawai2').val(data.FS_KD_PEG).trigger('change');
            $('#Absen_Status').val(data.IO).trigger('change');
            $("#Absen_Tanggal").val(data.TglLog);
            $("#Absen_Jam").val(data.JamLog);
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
             
        }
    });
}
function getdataLembur() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Payroll_Lokasi = $("#Hr_Pilih_Lokasi").val();
    var title = 'Lembur Absensi';
    var base_url = window.location.origin;
    $('#example2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example2').DataTable({
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Lembur/showDataTrsLemburAllbyJO/',
            "type": "POST",
            data: function (d) {
                d.Hr_Periode = Hr_Periode;
                d.Payroll_Lokasi = Payroll_Lokasi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NoSPL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Jenislembur + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID_Lokasi + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TglLembur + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JamAwal + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JamAkhir + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JumlahJamLembur + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.AlasanLembur + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="ShowData(' + row.ID + ')"  >' + row.ID_Lokasi + '</button>'
                    return html


                    return html
                }
            },
        ],
    });
}
function clearformlembur() {
    document.getElementById("form_trs_lembur").reset();
}
function ShowData(x) {
    document.getElementById("form_trs_lembur").reset();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Lembur/ShowDatalemburByID/',
        type: "POST",
        data: "id=" + x,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $('#Notif_awal_registrasi').modal('show');
            //$("#Hr_Nama_Pegawai").val(data.IdPegawai);
            $("#Hr_ID_Lokasi").val(data.ID_Lokasi);

            $("#IdTranasksiL").val(data.NoSPL);
            $("#IdTranasksiAutoL").val(data.ID);

            $('#Hr_Nama_Pegawai').val(data.ID_Data).trigger('change');
            $('#Hr_ID_Lokasi').val(data.ID_Lokasi).trigger('change');


            $("#Hr_tglcuti_awal").val(data.TglLembur);
            $("#Hr_Jam_Awal").val(data.JamAwal);
            $("#Hr_Jam_Akhir").val(data.JamAkhir);
            $("#Hr_jumlah_Lembur").val(data.JumlahJamLembur);
            $("#Hr_Jenis_lembur").val(data.JenisLembur);
            $("#catatan").val(data.AlasanLembur);

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
function getDataJadwal() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Pilih_Lokasi = $("#Hr_Pilih_Lokasi").val();
    var title = 'Jadwal Absensi';
    var base_url = window.location.origin;
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "scrollY": 500,
        "scrollX": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/GenerateAbsensi/ShowDataAfterGenerate/',
            "type": "POST",
            data: function (d) {
                d.Hr_Periode = Hr_Periode;
                d.Hr_Pilih_Lokasi = Hr_Pilih_Lokasi;
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
                    var html = '<font size="2"> ' + row.JAM_ABSEN_MASUK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JAM_ABSEN_KELUAR + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.NOTE != "") {
                        var html = ""
                        var html = '<font size="2"><span class="badge badge-primary" style="background-color:#e39696;"> ' + row.NOTE + '</span></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.NOTE + ' </font> ';
                        return html
                    }

                }
            },
        ],
    });
}
function GenrateAbsensiAll() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Pilih_Lokasi = $("#Hr_Pilih_Lokasi").val(); 
    $.ajax({
        url: base_url + '/pms_gut/public/GenerateAbsensi/GenrateAbsensiAll',
        method: "POST",
        data: "Hr_Periode=" + Hr_Periode + "&Hr_Pilih_Lokasi=" + Hr_Pilih_Lokasi,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                document.getElementById("btnJadwalCreate").disabled = false;
                swal("Generate gagal, Pegawai " + data.Nama + ", dengan JO : " + data.kd_lokasi + " belum ada jadwal shift kerja.");
            } else if (data.status == "success") {
                swal("Transaksi Berhasil Disimpan !")
                    .then((value) => {
                        document.getElementById("btnJadwalCreate").disabled = false;
                        $(".preloader").fadeOut();
                        getDataJadwal();
                        getdataLembur();
                    });
                
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
        }
    });
    $(".preloader").fadeOut();
}
function loadJdwl() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Pilih_Lokasi = $("#Hr_Pilih_Lokasi").val();
    swal({
        title: "Generate Absen",
        text: "Apakah Anda Ingin Generate Absen, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                GenrateAbsensiAll();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function enable_jensCuti() {
    var jenisTransaksi = $("#Hr_TipeTransaksi").val();
    console.log(jenisTransaksi);

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
//getlokasi
function getLokasi() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/JobOrder/getLokasiJoByHakUser',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Hr_ID_Lokasi").append(newRow);
            $("#Hr_Pilih_Lokasi").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_Pilih_Lokasi").append(newRow);
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
        }
    });
}
// Getpegawai
function getpegawai() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/Pegawai/getpegawaiAllAktif/",
        dataType: "json",
        success: function (data) {
            if (data.data.getpegawai !== null && data.data.getpegawai !== undefined) {
                console.log(data.data);
                var newRow = '<option value=""></option';
                $("#Hr_Nama_Pegawai").append(newRow);
                $("#Hr_Nama_Pegawai2").append(newRow);
                var elements = $();
                var dataarray = data.data.getpegawai.length;
                for (i = 0; i < data.data.getpegawai.length; i++) {
                    var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                    $("#Hr_Nama_Pegawai").append(newRow);
                    $("#Hr_Nama_Pegawai2").append(newRow);
                }
                $('.js-example-basic-single').select2();
            }
        },error: function (data) {
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
        }
    });
}