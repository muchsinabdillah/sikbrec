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
            "url": base_url + "/pms_gut/public/JobOrder/getAllJobOrder",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.KD_LOKASI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NM_PROJECT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NM_KEGIATAN + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NM_CLIENT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ALAMAT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showFormJobOrder(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
});
function showFormJobOrder(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/JobOrder/viewJobOrder/' + str;
}
function go_save_kontrak() {
    var base_url = window.location.origin;
    var form_data = $("#form_cuti").serialize();
    $.ajax({
        url: base_url + '/pms_gut/public/JobOrder/addJobOrder',
        data: form_data  ,
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#btnAddJObOrder').html('Please Wait...');
            $('#btnAddJObOrder').addClass('btn-danger');
            document.getElementById("btnAddJObOrder").disabled = true;
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
                $('#btnAddJObOrder').removeClass('btn-danger');
                $('#btnAddJObOrder').html('Submit');
                document.getElementById("btnAddJObOrder").disabled = false;

            } else if (data.status == "success") {
                $('#btnAddJObOrder').removeClass('btn-danger');
                $('#btnAddJObOrder').html('Submit');
                document.getElementById("form_cuti").reset();
                document.getElementById("btnAddJObOrder").disabled = false;

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

            $('#btnAddJObOrder').removeClass('btn-danger');
            $('#btnAddJObOrder').html('Submit');
            document.getElementById("btnAddJObOrder").disabled = false;
        }
    });
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdTranasksiAuto").val();
    if (idx != '') {
        $.ajax({
            url: base_url + "/pms_gut/public/JobOrder/getJobOrderById/",
            type: "POST",
            data: { id: idx }, 
            dataType: "JSON",
            success: function (data) {
                $("#IdTranasksi").val(convertEntities(data.KD_LOKASI));
                $("#Mst_KdGroup").val(convertEntities(data.KD_GRUP_LOKASI));
                $("#Mst_NamaLokasi").val(convertEntities(data.NM_LOKASI));
                $("#Mst_NamaClient").val(convertEntities(data.NM_CLIENT));
                $("#Mst_Alamat").val(convertEntities(data.ALAMAT));
                $("#Mst_UMK").val(convertEntities(data.UMK_LOKASI));
                $("#Mst_NamaProject").val(convertEntities(data.NM_PROJECT));
                $("#Mst_Kegiatan").val(convertEntities(data.NM_KEGIATAN));
                document.getElementById("IdTranasksi").readOnly = true;
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
    window.location = base_url + "/pms_gut/public/JobOrder";
}
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/JobOrder/viewJobOrder";
}
 
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}