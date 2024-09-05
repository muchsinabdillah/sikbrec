$(document).ready(function () {
    $(".preloader").fadeOut();
    DisableForm();
    getpegawai();
    getLokasi(); 
    $('#btnprint2').click(function () {
        var notrs = $("#Payroll_IDtrs").val();
        var Hr_Periode = $("#Payroll_Periode").val();
        var Hr_LokasiProject_Updt = $("#Payroll_Lokasi").val();
        var Payroll_Pegawai = $("#Payroll_Pegawai").val();
        var base_url = window.location.origin;
        window.open(base_url + "/pms_gut/public/InfoPayroll/PrintTimeSheet/" + Hr_Periode + "/" + Hr_LokasiProject_Updt + "/" + notrs + "/" + Payroll_Pegawai, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    $('#btnprint').click(function () {
        var notrs = $("#Payroll_IDtrs").val();
        var Hr_Periode = $("#Payroll_Periode").val();
        var Hr_LokasiProject_Updt = $("#Payroll_Lokasi").val();
        var Payroll_Pegawai = $("#Payroll_Pegawai").val();
        var base_url = window.location.origin;
        window.open(base_url + "/pms_gut/public/InfoPayroll/PrintSlipGaji/" + Hr_Periode + "/" + Hr_LokasiProject_Updt + "/" + notrs + "/" + Payroll_Pegawai, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    $(document).on('click', '#btnSavePoli2', function () {
        var statuspegawaix = $("#RSY_stsPeg").val();
        var base_url = window.location.origin;
        var str = $("#frmKartuRSYarsi").serialize();
        var x = "2";
        console.log(x);
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: base_url + "/pms_gut/public/ProsesPayroll/updateValueKomponenPayrollbyID",
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $('#Confirm').html('Sending...');
                $('#Confirm').addClass('btn-danger');
            },
            success: function (data) {
                if (data.status == "warning") {
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.pesan,
                        type: 'danger'
                    });
                } else if (data.status == "success") {
                    document.getElementById("frmKartuRSYarsi").reset();
                    $('#Modal_verifikasi').modal('hide');
                    getKomponenImbalan(); getKomponenPotongan(); GetHitungHDR();
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

    });
    $('#btnprint').click(function () {
        var notrs = $("#Payroll_IDtrs").val();
        window.open("Halaman/hr_transaksi/Print_slipgaji.php?id=" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    $('#btnprint2').click(function () {
        var notrs = $("#Payroll_IDtrs").val();
        window.open("Halaman/hr_transaksi/Print_absensi.php?id=" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
});
function goVoid() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "Payroll_IDtrs=" + Payroll_IDtrs,
        url: base_url + "/pms_gut/public/ProsesPayroll/goVoidProsesPayroll",
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

            } else if (data.status == "success") {
                swal("Transaksi Berhasil Dihapus !")
                    .then((value) => {
                        //DO
                        location.reload();
                    });

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


function VoidTRansaksi() {
    swal({
        title: "Transaksi Payroll",
        text: "Anda Yakin ingin Batalkan Transaksi, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                goVoid();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function ShowDatabyID(x) {
    // url = "../SIRYARSI/home.php?page=order-rad&rand="+x+"&woid="+y;
    //var win = window.open(url, '_blank');
    //win.focus();
    console.log(x);
    var base_url   = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/ProsesPayroll/GeHdrPayrollByIDtrsAuto",
        type: "POST",
        data: "Payroll_IDtrs=" + x,
        cache: false,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            $(".preloader").fadeOut();
            $('#Notif_awal_registrasi').modal('hide');
            $("#Payroll_IDtrs").val(data.KODE_TRANSAKSI);
            $('#Payroll_Lokasi').val(data.KODE_LOKASI).trigger('change');
            $('#Payroll_Pegawai').val(data.KODE_PEGAWAI).trigger('change');
            $("#Payroll_Periode").val(data.PERIODE);
            getKomponenImbalan(); getKomponenPotongan(); GetHitungHDR();
            getDataJadwal();
            getdataLembur();
            document.getElementById("btnJadwalCreate").disabled = true;
            document.getElementById("Payroll_Lokasi").disabled = true;
            document.getElementById("Payroll_Pegawai").disabled = true;
            document.getElementById("Payroll_Periode").disabled = true;
            
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

function getdataLembur() {
    var Hr_Periode = $("#Payroll_Periode").val();
    var Hr_Nama_Pegawai = $("#Payroll_Pegawai").val();
    var Payroll_Lokasi = $("#Payroll_Lokasi").val();
    var title = 'Lembur Absensi';
    var base_url = window.location.origin;
    $('#example2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example2').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/Lembur/showDataTrsLemburAllbyJOPeg",
            "type": "POST",
            data: function (d) {
                d.Hr_Periode = Hr_Periode;
                d.Hr_Nama_Pegawai = Hr_Nama_Pegawai;
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
                    var html = '<font size="2"> ' + row.NM_LOKASI + '</font> ';
                    return html
                }
            },
        ],
    });
}


function getDataJadwal() {
    var Hr_Periode = $("#Payroll_Periode").val();
    var Hr_Nama_Pegawai = $("#Payroll_Pegawai").val();
    var Hr_Pilih_Lokasi  = $("#Payroll_Lokasi").val();
    var title = 'Jadwal Absensi';
    var base_url = window.location.origin;
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({

        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/GenerateAbsensi/ShowDataAfterGeneratebyIdPegawai",
            "type": "POST",
            data: function (d) {
                d.Hr_Periode = Hr_Periode;
                d.Hr_Nama_Pegawai = Hr_Nama_Pegawai;
                d.Hr_Pilih_Lokasi = Hr_Pilih_Lokasi ;
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
                    var html = '<font size="2"> ' + row.JML_TELAT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.JML_PULANG_DULU + '</font> ';
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
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.NOTE != "" || row.NOTE != " ") {
                        var html = ""
                        var html = '<font size="2"><span class="badge badge-primary" style="background-color:#e39696;">' + row.NOTE + '</span></font> ';
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
function ShowDataListPayroll() {
    var SrcPeriodeBln = $("#SrcPeriodeBln").val();
    var SrcKodeJO = $("#SrcKodeJO").val();
    var title = 'Jadwal Absensi';
    var base_url = window.location.origin;
    $('#tblCariPayroll').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblCariPayroll').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/ProsesPayroll/ShowDataListPayroll",
            "type": "POST",
            data: function (d) {
                d.SrcPeriodeBln = SrcPeriodeBln;
                d.SrcKodeJO = SrcKodeJO;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_TRANSAKSI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.PERIODE + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_LOKASI + '</font> ';
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
                    var html = '<font size="2"> ' + row.GRANTOTAL_GAJI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.statustransaksi + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit"  data-dismiss="modal" name="buttonedit" onclick=\'ShowDatabyID("' + row.ID + '")\'>PILIH</button> '
                    return html
                }
            },
        ],
    });
}
function FinishTRansaksi() {
    swal({
        title: "Transaksi Payroll",
        text: "Anda Yakin ingin Selesaikan Transaksi, Lanjutan Transaksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                goFinish();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function goFinish() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "Payroll_IDtrs=" + Payroll_IDtrs,
        url: base_url + "/pms_gut/public/ProsesPayroll/goFinish",
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
                    swal("Transaksi Selesai !")
                    .then((value) => {
                        //DO
                        location.reload();
                    }); 
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
function ShowForm(x) {
    $("#JM_ID").val(x);
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var base_url = window.location.origin;
    $.ajax({
        data: "Id=" + x + "&Payroll_IDtrs=" + Payroll_IDtrs,
        url: base_url + "/pms_gut/public/ProsesPayroll/getDetailPayrolById",
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
            if(data.status == "warning"){
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
            } else if (data.status == "success"){
                $("#xNamaKomponen").val(data.NAMA_KOMPONEN);
                $("#xNIlaiKomponen").val(data.NILAI);
                $("#xNIlaiKomponen").focus();
                var Payroll_IDtrs = $("#Payroll_IDtrs").val();
                $("#xNOTransaksi").val(Payroll_IDtrs);
                $('#Modal_verifikasi').modal('show');
                $(".preloader").fadeOut();
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
function GetHitungHDR() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/ProsesPayroll/GeHdrPayrollByIDtrs",
        method: "POST",
        data: "Payroll_IDtrs=" + Payroll_IDtrs,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
            } else if (data.status == "success") {
                $("#SUBTOTAL").val(data.SUB_TOTAL);
                $("#PPH_21").val(data.PPH21);
                $("#KASBON").val(data.KASBON);
                $("#GRANTOTAL_GAJI").val(data.GRANTOTAL_GAJI);
            }

        },
        error: function () {
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
function getKomponenPotongan() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var title = 'Jadwal Absensi';
    var base_url = window.location.origin;
    $('#tblkomponenPotongan').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblkomponenPotongan').DataTable({

        "ajax": {
            "url": base_url + "/pms_gut/public/ProsesPayroll/getKomponenPotongan",
            "type": "POST",
            data: function (d) {
                d.Payroll_IDtrs = Payroll_IDtrs;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_URUT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm(' + row.KODE_KOMPONEN + ')"><font size="1">' + row.NAMA_KOMPONEN + ' </font></span>';
                    return html
                }
            },
            { "data": "NILAI", render: $.fn.dataTable.render.number(',', '', 0, '') },  // Tampilkan nama 
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(2).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total)
            );

        },
    });
}

function getKomponenImbalan() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var title = 'Jadwal Absensi';
    var base_url = window.location.origin;
    $('#tblkomponenImbalan').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblkomponenImbalan').DataTable({
        "ajax": {
            "url": base_url + "/pms_gut/public/ProsesPayroll/getKomponenImbalan/", 
            "type": "POST",
            data: function (d) {
                d.Payroll_IDtrs = Payroll_IDtrs;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_URUT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm(' + row.KODE_KOMPONEN + ')"><font size="1">' + row.NAMA_KOMPONEN + ' </font></span>';
                    return html
                }
            },
            { "data": "NILAI", render: $.fn.dataTable.render.number(',', '', 0, '') },  // Tampilkan nama  
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(2).footer()).html(
                $.fn.dataTable.render.number(',', '', '0', '').display(total)
            );

        },
    });
}
function GGo_GenDtl() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var Payroll_Lokasi = $("#Payroll_Lokasi").val();
    var Payroll_Pegawai = $("#Payroll_Pegawai").val();
    var Payroll_Periode = $("#Payroll_Periode").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/ProsesPayroll/genDtlPayroll/',
        method: "POST",
        data: "Payroll_IDtrs=" + Payroll_IDtrs + "&Payroll_Lokasi=" + Payroll_Lokasi
            + "&Payroll_Pegawai=" + Payroll_Pegawai + "&Payroll_Periode=" + Payroll_Periode,
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
                toastr["success"]("Transaksi Komponen Payroll Dibuat !");
                        getKomponenImbalan(); 
                        getKomponenPotongan(); 
                        GetHitungHDR();
                        getDataJadwal();
                        getdataLembur();
            }

        },
        error: function () {
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
function GenerateDtl() {
    swal({
        title: "Generate",
        text: "Anda yakin ingin load transaksi ini, Lanjutkan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                GGo_GenDtl();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function GGo_GenHdr() {
    var Payroll_IDtrs = $("#Payroll_IDtrs").val();
    var Payroll_Lokasi = $("#Payroll_Lokasi").val();
    var Payroll_Pegawai = $("#Payroll_Pegawai").val();
    var Payroll_Periode = $("#Payroll_Periode").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/ProsesPayroll/genHdrPayroll/',
        method: "POST",
        data: "Payroll_IDtrs=" + Payroll_IDtrs + "&Payroll_Lokasi=" + Payroll_Lokasi
            + "&Payroll_Pegawai=" + Payroll_Pegawai + "&Payroll_Periode=" + Payroll_Periode,
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
                toastr["success"]("Transaksi Payroll Dibuat !");
                $("#Payroll_IDtrs").val(data.NoTRS);
                EnableForm();
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
function GenerateHdr() {
    swal({
        title: "New Transaksi",
        text: "Buat Transaksi Baru, Lanjutkan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                GGo_GenHdr();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
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
            $("#Payroll_Lokasi").append(newRow);
            $("#SrcKodeJO").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length;
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Payroll_Lokasi").append(newRow);
                $("#SrcKodeJO").append(newRow);
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
function getpegawai() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/Pegawai/getpegawaiAllAktif/",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Payroll_Pegawai").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#Payroll_Pegawai").append(newRow);
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
function EnableForm() {
    document.getElementById("Payroll_Lokasi").disabled = false;
    document.getElementById("Payroll_Pegawai").disabled = false;
    document.getElementById("Payroll_Periode").disabled = false;
    document.getElementById("btnJadwalCreateDtl").disabled = false;
    document.getElementById("btnJadwalCreate").disabled = true;
}
function DisableForm() {
    document.getElementById("Payroll_IDtrs").disabled = true;
    document.getElementById("Payroll_IDtrs").disabled = true;
    document.getElementById("Payroll_Lokasi").disabled = true;
    document.getElementById("Payroll_Pegawai").disabled = true;
    document.getElementById("btnJadwalCreateDtl").disabled = true;
}