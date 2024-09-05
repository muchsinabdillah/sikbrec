$(document).ready(function () {
    const base_url = window.location.origin;
    //defaultfoRms();
    ShowData();
    $(".preloader").fadeOut();

});


function go_save() {
    var base_url = window.location.origin;
    var form_data = $("#form_cuti").serialize();
    $.ajax({
        url: base_url + '/pms_gut/public/Jabatan/addJabatan',
        data: form_data,
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#btnreservasi').html('Please Wait...');
            $('#btnreservasi').addClass('btn-danger');
            document.getElementById("btnreservasi").disabled = true;
        },
        success: function (data) {
            if (data.status == "warning") {
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
                toastr["error"](data.errorname);
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('Submit');
                document.getElementById("btnreservasi").disabled = false;

            } else if (data.status == "success") {
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('Submit');
                document.getElementById("form_cuti").reset();
                document.getElementById("btnreservasi").disabled = false;
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
                toastr["success"](data.message);
                setTimeout(function () { MyBack(); }, 1000);
            }
        },
        error: function (data) {
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdJabatan").val();
    if (idx != '' || idx != null || idx != undefined) {
        $.ajax({
            url: base_url + "/pms_gut/public/Jabatan/getJabatanId/",
            type: "POST",
            data: { id: idx },
            dataType: "JSON",
            success: function (data) {
                $("#IdJabatan").val(convertEntities(data.Id_JF));
                $("#NamaJabatan").val(convertEntities(data.Jabatan_Fungsional));
                $('#StatusJabatan').val(data.STATUS).trigger('change');
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
                //  toastr["error"](data.responseText);
                $(".preloader").fadeOut();
            }
        });
    }
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/Jabatan";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}