$(document).ready(function () {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    //defaultfoRms();
    getGroupShift();
    ShowData();
   
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/pms_gut/public/Shift/getAllShifts",
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
                    var html = '<font size="1"> ' + row.KODE_SHIFT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_SHIFT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JAM_SHIFT_MASUK + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JAM_SHIFT_KELUAR + ' </font>  ';
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
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.AKTIF + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showDataShift(' + row.ID +')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
});
function showDataShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/Shift/viewShift/' + str;
}

function getGroupShift() {
    const base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/GroupShift/getGroupShiftCombo/",
        dataType: "json",
        success: function (response) {
            console.log(response);
            var newRow = '<option value=""></option';
            $("#Mst_KodeGroupShift").append(newRow); 
            for (i = 0; i < response.data.length; i++) {
                var newRow = '<option value="' + response.data[i].KODE_GROUP_SHIFT + '">' + response.data[i].NAMA_GROUP_SHIFT + '</option';
                $("#Mst_KodeGroupShift").append(newRow);
            }

        }
    });
}
function go_save() {
    var form_data = $("#form_cuti").serialize();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Shift/addShift',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () {
            $('#btnAddShift').html('Please Wait...');
            $('#btnAddShift').addClass('btn-danger');
            document.getElementById("btnAddShift").disabled = true;
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
                $('#btnAddShift').html('<i class="fa fa-check"></i>Submit');
                $('#btnAddShift').removeClass('btn-danger');
                document.getElementById("btnAddShift").disabled = false;

            } else if (data.status == "success") { 
                $('#btnAddShift').html('<i class="fa fa-check"></i>Submit');
                $('#btnAddShift').removeClass('btn-danger');
                document.getElementById("form_cuti").reset();
                document.getElementById("btnAddShift").disabled = false;

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
 
            $('#btnAddShift').html('<i class="fa fa-check"></i>Submit');
            $('#btnAddShift').removeClass('btn-danger');
            document.getElementById("btnAddShift").disabled = false;
        }
    });
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdTranasksiAuto").val();
    if(idx != "" ){
        $.ajax({
            url: base_url + "/pms_gut/public/Shift/getShiftById/",
            type: "POST",
            data: { id: idx },
            cache: false,
            dataType: "JSON",
            success: function (data) {
                $("#IdTranasksi").val(convertEntities(data.ID));
                $("#Mst_KodeShift").val(convertEntities(data.KODE_SHIFT));
                $("#Mst_NamaShift").val(convertEntities(data.NAMA_SHIFT));
                $("#Mst_JamAwal").val(convertEntities(data.JAM_SHIFT_MASUK));
                $("#Mst_JamAkhir").val(convertEntities(data.JAM_SHIFT_KELUAR));
                $("#Mst_KodeGroupShift").val(convertEntities(data.KODE_GROUP_SHIFT));
                $("#MSt_Status").val(convertEntities(data.AKTIF));
                $("#masuk_kurang").val(convertEntities(data.MASUK_KURANG));
                $("#masuk_lebih").val(convertEntities(data.MASUK_LEBIH));
                $("#keluar_kurang").val(convertEntities(data.KELUAR_KURANG));
                $("#keluar_lebih").val(convertEntities(data.KELUAR_LEBIH));

            }
        });
    }else{
        $("#masuk_kurang").val('60');
        $("#masuk_lebih").val('60');
        $("#keluar_kurang").val('60');
        $("#keluar_lebih").val('60');
    }
    
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/Shift";
}
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/Shift/viewShift";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}