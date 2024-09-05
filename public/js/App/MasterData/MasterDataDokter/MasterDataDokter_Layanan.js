$(document).ready(function () {
    const base_url = window.location.origin;
    //defaultfoRms();
    getGrupPerawatan();
    ShowData();
    $(".preloader").fadeOut();

});


function ShowTableLayanan(ID){
    var base_url = window.location.origin;
     $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataDokter/getDataLayanan/",
             "type": "POST",
            "data": { id: ID },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
        {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.No + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUnit + ' </font>  ';
                    return html
                }
            },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" id="btndelete" name="btndelete" class="btn btn-danger border-danger btn-animated btn-wide"  onclick="DeleteLayanan(' + row.ID + ')" ><span class="visible-content" >Delete</span><span class="hidden-content"><i class="fa fa-trash"></i></span></button>'
                    return html
                },
            },
        ]
    });
}

function DeleteLayanan(IdDoctors_2) {
    var base_url = window.location.origin;
   // var id = $("#IdAuto").val();
    $.ajax({
        url: base_url + '/SIKBREC/public/MasterDataDokter/DeleteDokterLayanan' ,
        data: { id: IdDoctors_2 },
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#btndelete').html('Please Wait...');
            $('#btndelete').addClass('btn-danger');
            document.getElementById("btndelete").disabled = true;
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
                $('#btndelete').removeClass('btn-danger');
                $('#btndelete').html('Delete');
                document.getElementById("btndelete").disabled = false;

            } else if (data.status == "success") {
                $('#btndelete').removeClass('btn-danger');
                $('#btndelete').html('Delete');
                document.getElementById("btndelete").disabled = false;
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
                ShowTableLayanan(IdDoctors_2);
                //setTimeout(function () { MyBack(); }, 1000);
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
            $('#btnsave').removeClass('btn-danger');
            $('#btnsave').html('Add');
            document.getElementById("btnsave").disabled = false;
        }
    });
}


function go_save() {
    var base_url = window.location.origin;
    var form_data = $("#form_cuti").serialize();
    $.ajax({
        url: base_url + '/SIKBREC/public/MasterDataDokter/addDokterLayanan' ,
        data: form_data,
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#btnsave').html('Please Wait...');
            $('#btnsave').addClass('btn-danger');
            document.getElementById("btnsave").disabled = true;
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
                $('#btnsave').removeClass('btn-danger');
                $('#btnsave').html('Add');
                document.getElementById("btnsave").disabled = false;

            } else if (data.status == "success") {
                $('#btnsave').removeClass('btn-danger');
                $('#btnsave').html('Add');
                $("#GrupPerawatan").val('').trigger('change');
                document.getElementById("btnsave").disabled = false;
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
                ShowTableLayanan(data.IdDoctors);
                //setTimeout(function () { MyBack(); }, 1000);
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
            $('#btnsave').removeClass('btn-danger');
            $('#btnsave').html('Add');
            document.getElementById("btnsave").disabled = false;
        }
    });
}
function ShowData() {
    const base_url = window.location.origin;
    var idx = $("#IdAuto").val();
    if (idx != '' || idx != null || idx != undefined) {
        $.ajax({
            url: base_url + "/SIKBREC/public/MasterDataDokter/getDokterId/",
            type: "POST",
            data: { id: idx },
            dataType: "JSON",
            success: function (data) {
                $("#IdAuto").val(convertEntities(data.ID));
                $("#NamaDokter").val(convertEntities(data.First_Name));
                ShowTableLayanan(data.ID);
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
    window.location = base_url + "/SIKBREC/public/MasterDataDokter";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}


function getGrupPerawatan() {
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        url: base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan',
        dataType: "json",
        success: function (data) {
            if (data !== null && data !== undefined) {
                var newRow = '<option value="">-- PILIH LAYANAN --</option';
                $("#GrupPerawatan").append(newRow);
                var elements = $();
                var dataarray = data.length;
                for (i = 0; i < data.length; i++) {
                    var newRow = '<option value="' + data[i].ID + '">' + data[i].NamaUnit + '</option';
                    $("#GrupPerawatan").append(newRow);
                }
                $("#GrupPerawatan").select2();
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

}
