$(document).ready(function () {
    $(".preloader").fadeOut(); 
   getpegawai();
 getLokasi(); 
});
function getdataLembur() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
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
            "url": base_url + '/pms_gut/public/Lembur/showDataTrsLemburAllbyJOPeg/',
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
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            {
                extend: 'excelHtml5',
                title: title
            },
            'csv'
        ],
    });
}
function getDataJadwal() {
    var Hr_Periode = $("#Hr_Periode").val();
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_Pilih_Lokasi  = $("#Hr_Pilih_Lokasi").val();
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
            "url": base_url + '/pms_gut/public/GenerateAbsensi/ShowDataAfterGeneratebyIdPegawai/',
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
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            {
                extend: 'excelHtml5',
                title: title
            },
            'csv'
        ],
    });
}
function loadJdwl() {
    var Hr_Nama_Pegawai = $("#Hr_Nama_Pegawai").val();
    var Hr_Periode = $("#Hr_Periode").val();
    if (Hr_Periode != '') {
        swal({
            title: "Generate Absen",
            text: "Anda yakin, Lanjutan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    getDataJadwal();
                    getdataLembur();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    }
}
function getLokasi() {
    var xdi = "1"; 
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/JobOrder/getLokasiJoByHakUser',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Hr_Pilih_Lokasi").append(newRow);
            var elements = $();
            var dataarray = data.dataJoAll.length; 
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#Hr_Pilih_Lokasi").append(newRow); 
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
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/Pegawai/getpegawaiAllAktif/",
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
        }
    });
}