$(document).ready(function () {
    const base_url = window.location.origin;
    $(".preloader").fadeOut(); 
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({
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



                    var html = '<button title="Show Data" type="button" class="btn btn-default border-success btn-animated btn-wide" id="btn_showkasbon" onclick="ShowKasbonPegawai(' + row.ID + ')"  ><span class="visible-content" >View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
    var idx = $("#IdTranasksiAuto").val();
    if (idx != null ) {
        setTimeout(function () { ShowData(); }, 200);
    }
    getpegawai();
});
// go save
function disableinOut() {
    var Absen_Status = document.getElementById("Absen_Status").value;
    if(Absen_Status == "1"){
        document.getElementById("Absen_Jam").disabled = false;
        document.getElementById("Absen_Jam_Out").disabled = true;
    } else if (Absen_Status == "2") {
        document.getElementById("Absen_Jam").disabled = true;
        document.getElementById("Absen_Jam_Out").disabled = false;
    } else if (Absen_Status == "3") {
        document.getElementById("Absen_Jam").disabled = false;
        document.getElementById("Absen_Jam_Out").disabled = false;
    }
}
function go_save() {
    var form_data = $("#form_cuti").serialize();
    const base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/AbsensiManual/CreateAbsenManual/',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () {
            $('#btnreservasi').html('Please Wait...');
            $('#btnreservasi').addClass('btn-danger');
            document.getElementById("btnreservasi").disabled = true;
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('SIMPAN');
                document.getElementById("btnreservasi").disabled = false;

            } else if (data.status == "success") {
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('SIMPAN');
                document.getElementById("form_cuti").reset();
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
                toastr["success"](data.message);
                setTimeout(function () { goBack(); }, 1000);
            }

        },
        error: function () {

            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
// show data pegawai 
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
//show data by id
function ShowData() {
  //  $(".preloader").fadeIn();
    var idx = $("#IdTranasksiAuto").val();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/AbsensiManual/ShowDataAbsensiManualByID/',
        type: "POST",
        data: { id: idx },
        dataType: "JSON",
        success: function (data) {
            $("#IdTranasksi").val(data.ID);
            $("#Absen_PIN").val(data.FS_PIN);
            $('#Hr_Nama_Pegawai').val(data.FS_KD_PEG).trigger('change');
            $('#Absen_Status').val(data.IO).trigger('change');
            $("#Absen_Tanggal").val(data.TglLog);
            $("#Absen_Jam").val(data.JamLog);
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
function ShowKasbonPegawai(x) {
    var str = btoa(x);
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/AbsensiManual/viewForm/' + str;
}
function newTrsAbsensiManual() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/AbsensiManual/viewForm/';
}
function goBack() {
    const base_url = window.location.origin;
    window.location = base_url + '/pms_gut/public/AbsensiManual/';
}