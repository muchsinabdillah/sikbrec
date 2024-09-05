$(document).ready(function () {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    //defaultfoRms();
    //getGroupShift();
    ShowData();

    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/pms_gut/public/KomponenPayroll/getAllKomponenPayroll",
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
                    var html = '<font size="1"> ' + row.NAMA_KOMPONEN + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JENIS_KOMPONEN + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NILAI_KOMPONEN + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.KETERANGAN_KOMPONEN + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.AKTIF + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = "" 
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showFormKomponenPayroll(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
});
function showFormKomponenPayroll(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/KomponenPayroll/viewKomponenPayroll/' + str;
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdTranasksiAuto").val();
    $.ajax({
        url: base_url + "/pms_gut/public/KomponenPayroll/getKomponenPayrollById/",
        type: "POST",
        data: { id: idx },
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#IdTranasksi").val(convertEntities(data.ID));
            $("#IdTranasksiAuto").val(convertEntities(data.ID));
            $('#Mst_JenisKomponen').val(data.JENIS_KOMPONEN).trigger('change');
            $('#Mst_Aktif').val(data.AKTIF).trigger('change');
            $("#Mst_NamaKOmponen").val(convertEntities(data.NAMA_KOMPONEN));
            $("#Mst_NilaiKomponen").val(convertEntities(data.NILAI_KOMPONEN));
            $("#Mst_NoUrut").val(convertEntities(data.NO_URUT));
            $("#Mst_Catatan").val(convertEntities(data.KETERANGAN_KOMPONEN));
            $('.js-example-basic-single').select2();
        }
    });
}
function go_save() {
    var form_data = $("#form_cuti").serialize();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/KomponenPayroll/addKomponenPayroll',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () {
            $('#btnAddKomponenPayroll').html('Please Wait...');
            $('#btnAddKomponenPayroll').addClass('btn-danger');
            document.getElementById("btnAddKomponenPayroll").disabled = true;
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
                $('#btnAddKomponenPayroll').html('<i class="fa fa-check"></i>Submit');
                $('#btnAddKomponenPayroll').removeClass('btn-danger');
                document.getElementById("btnAddKomponenPayroll").disabled = false;

            } else if (data.status == "success") {
                $('#btnAddKomponenPayroll').html('<i class="fa fa-check"></i>Submit');
                $('#btnAddKomponenPayroll').removeClass('btn-danger');
                document.getElementById("form_cuti").reset();
                document.getElementById("btnAddKomponenPayroll").disabled = false;

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
                setTimeout(function () { MyBack(); }, 1000);

            }

        },
        error: function () {
            $('#btnAddKomponenPayroll').html('<i class="fa fa-check"></i>Submit');
            $('#btnAddKomponenPayroll').removeClass('btn-danger');
            document.getElementById("btnAddKomponenPayroll").disabled = false;
        }
    });
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/KomponenPayroll";
}
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/KomponenPayroll/viewKomponenPayroll";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}