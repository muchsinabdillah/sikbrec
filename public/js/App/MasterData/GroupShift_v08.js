$(document).ready(function () {
    const base_url = window.location.origin;
    defaultfoRms();
    ShowData();
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": { 
            "url": base_url + "/pms_gut/public/GroupShift/getAllGroupShifts",
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
                    var html = '<font size="1"> ' + row.KODE_GROUP_SHIFT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_GROUP_SHIFT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showDataGroupShift(' + row.ID +')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    }); 
});

function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str); 
    window.location = base_url + '/pms_gut/public/GroupShift/viewGroupShift/' + str;
}
function defaultfoRms() {
    $("#Mst_Kelas1").val('1.5');
    $("#Mst_Kelas2").val('2');
    $("#Mst_Kelas3").val('3');
    $("#Mst_Kelas4").val('4');
} 
function go_save() {
    var base_url = window.location.origin;
    var form_data = $("#form_cuti").serialize();
    $.ajax({
        url: base_url + '/pms_gut/public/GroupShift/addGroupShift',
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
        error: function () {

            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdTranasksiAuto").val();
    if (idx != '') {
        $.ajax({
            url: base_url + "/pms_gut/public/GroupShift/getGroupShiftById/",
            type: "POST",
            data: { id: idx },
            dataType: "JSON",
            success: function (data) {
                $("#IdTranasksi").val(convertEntities(data.ID));
                $("#Mst_KodeGroupShift").val(convertEntities(data.KODE_GROUP_SHIFT));
                $("#Mst_NamaGroupShift").val(convertEntities(data.NAMA_GROUP_SHIFT));
                $("#Mst_ValueGroupShift").val(convertEntities(data.NILAI));
                $("#Mst_ValuehariGroup").val(convertEntities(data.Nilai_hari));
                $("#Mst_Kelas1").val(convertEntities(data.KELAS_1));
                $("#Mst_Kelas2").val(convertEntities(data.KELAS_2));
                $("#Mst_Kelas3").val(convertEntities(data.KELAS_3));
                $("#Mst_Kelas4").val(convertEntities(data.KELAS_4));
                document.getElementById("Mst_KodeGroupShift").readOnly = true;
            }
        });
    } else {
        $("#Mst_Kelas1").val('1.5');
        $("#Mst_Kelas2").val('2');
        $("#Mst_Kelas3").val('3');
        $("#Mst_Kelas4").val('4');
    }
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url +"/pms_gut/public/GroupShift";
}
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/GroupShift/viewGroupShift";
}
function convertEntities($data){
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}