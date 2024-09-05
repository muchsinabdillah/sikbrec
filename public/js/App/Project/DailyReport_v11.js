$(document).ready(function () {
    $(".preloader").fadeOut();
    $("#jahanam").hide();
    getMou(); 
    disableForm(); 
    getdataTools();
    window.onbeforeunload = function () {
        return "Do you want to leave?"
    }
    // A jQuery event (I think), which is triggered after "onbeforeunload"
    $(window).unload(function () {
        LogTime();
        //I will call my method
    });
    // Get the input field
    var inputep_dr3_qty = document.getElementById("ep_dr3_qty");

    // Execute a function when the user releases a key on the keyboard
    inputep_dr3_qty.addEventListener("keyup", function (event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            calculateProgressAkr();
        }
    });
    $(document).on('click', '#btndrAddKegiatan', function () {
        addkegiatan();
    });
    // batal kegiatan 
    $(document).on('click', '#btnSavePoliacTIVITY', function () {
        $(".preloader").fadeIn();
        var str = $("#frmKartuRSYarsi3").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: base_url + "/pms_gut/public/DailyReport/updateBatalEntryKegiatan/", 
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $('#Confirm').html('Sending...');
                $('#Confirm').addClass('btn-danger');
            },
            success: function (data) {
                if (data.status == "warning") {
                    $(".preloader").fadeOut();
                } else if (data.status == "success") {

                    document.getElementById("frmKartuRSYarsi3").reset();
                    $('#Modal_verifikasi3').modal('hide');
                    getEntryActivity();
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
                $(".preloader").fadeOut();
            }
        });
    });
    $("#upload").click(function () {
        ambilId("progressBar").style.display = "block";
        var file = ambilId("file").files[0];
        var dr_IDTransaksi = $("#lb_IDTransaksi").val();
        var ep_dr3_img_caption = $("#ep_dr3_img_caption").val();
        var base_url = window.location.origin;
        if (file != "") {
            var formdata = new FormData();
            formdata.append("file", file);
            formdata.append("dr_IDTransaksi", dr_IDTransaksi);
            formdata.append("ep_dr3_img_caption", ep_dr3_img_caption);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false); 
            ajax.responseType = 'json';
            ajax.open("POST", base_url + "/pms_gut/public/DailyReport/uploadFotoDailyReport/");
            ajax.send(formdata);
            ajax.onload = function (e) {
                console.log('Masuk onload');
                //   var jsonResponse = JSON.parse(ajax.responseText);
                console.log(this.status);
                if (this.status == "200") {

                    if (this.response.status == "warning") {
                        ambilId("status").innerHTML = "Upload Failed";
                        swal(this.response.errorname);
                    } else {
                        ambilId("status").innerHTML = this.response.errorname;
                        swal(this.response.errorname);
                        show_data_ProjectAa();

                        document.getElementById("upload_form").reset();
                    }
                }
            }

        }
    });
    $(document).on('click', '#btnSaveAddtools', function () {
        var str = $("#frmAddToolsMaster").serialize();
        var base_url = window.location.origin;
        var x = "2";
        console.log(x);
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: base_url + "/pms_gut/public/DailyReport/SaveAddtools/",
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
                    document.getElementById("frmAddToolsMaster").reset();
                    $('#Modal_Add_Tools').modal('hide');
                    getdataTools();
                }
            },
            error: function (data) {

            }
        });


    });
    $(document).on('click', '#btndrAddTools', function () {
        addDRTools();
    });
    $(document).on('click', '#btnSavePolitOOLS', function () {
        var str = $("#frmKartuRSYarsi2").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: base_url + "/pms_gut/public/DailyReport/UpdateBatalDataTools",
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
                    document.getElementById("frmKartuRSYarsi2").reset();
                    $('#Modal_verifikasi2').modal('hide');
                    getEntryTools();
                }
            },
            error: function (data) {

            }
        });

    });
    $(document).on('click', '#btnBatalRencanaKeg', function () {
        var str = $("#frmDataRencanaKegiatan").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: base_url + "/pms_gut/public/DailyReport/UpdateBatalDataRencanaKeg",
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $(".preloader").fadeIn();
            },
            success: function (data) {
                if (data.status == "warning") {
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.pesan,
                        type: 'danger'
                    });
                } else if (data.status == "success") {
                    document.getElementById("frmDataRencanaKegiatan").reset();
                    $('#Modal_KegiatanID').modal('hide');
                    getEntryTools_Rencana();
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

    });
    $(document).on('click', '#btndrAddTools_Rencana', function () {
        addDRTools_Rencana();
    });
    $('#btnprint').click(function () {
        var notrs = $("#lb_IDTransaksi").val(); 
        var base_url = window.location.origin;
        window.open(base_url + "/pms_gut/public/InfoDailyReport/PrintDailyReport/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
}); 
function ShowDataTRsDRbyID(x) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    console.log(x);
    $.ajax({
        
        url: base_url + "/pms_gut/public/DailyReport/ShowDataTRsDRbyID",
        type: "POST",
        data: "q=" + x,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#lb_IDTransaksi").val(data.KD_TRS);
            $("#dr_kode_peg_SPV").val(data.KD_PEG_SM);
            $("#is_batal").val('0');
            if (data.FB_PURCHASE == 1) {
                document.getElementById("IsPurchase").checked = true;
            } else {
                document.getElementById("IsPurchase").checked = false;
            }
            //$('#dr_Lokasi').val(data.KD_JO).trigger('change'); 
            setTimeout(function () {
                $('#lb_IdMOu').val(data.KD_MOU).trigger('change');

            }, 500);
            setTimeout(function () {
                $('#lb_SPV').val(data.KD_PEG_SPV).trigger('change');

            }, 1000);
            setTimeout(function () {
                $('#lb_fleksibel_tim').val(data.KD_TIM).trigger('change');
                $('#dr_timLBDate').val(data.KD_TIM).trigger('change');
                EnableForm();
                $('#loadMdlLogbook').modal('hide');

                getEntryTools();
                getEntryActivity();
                show_data_ProjectAa();
                getEntryTools_Weather();
                getEntryTools_Rencana();
                document.getElementById("btnJadwalCreate").disabled = true;
                document.getElementById("lb_IdMOu").disabled = true;
                document.getElementById("lb_SPV").disabled = true;
                document.getElementById("dr_timLBDate").disabled = true;
                document.getElementById("lb_fleksibel_tim").disabled = true;
                document.getElementById("IsPurchase").disabled = true;
                $(".preloader").fadeOut();
            }, 1500);
            
        }

    });
}
function BatalTransaksi() {
    swal({
        title: "Batal Transaksi",
        text: "Buat Transaksi Batal, Lanjutkan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                GGo_Bataltrs();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function GGo_Bataltrs() {
    var dr_Lokasi = $("#dr_Lokasi").val();
    var dr_kode_peg_SM = $("#dr_kode_peg_SM").val();
    var dr_kode_peg_SPV = $("#dr_kode_peg_SPV").val();
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var  base_url = window.location.origin;
    $.ajax({ 
        url: base_url + "/pms_gut/public/DailyReport/batalTrsDR",
        method: "POST",
        data: "dr_Lokasi=" + dr_Lokasi + "&dr_kode_peg_SM=" + dr_kode_peg_SM
            + "&dr_kode_peg_SPV=" + dr_kode_peg_SPV + "&dr_IDTransaksi=" + dr_IDTransaksi,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
            } else if (data.status == "success") {
                $("#is_batal").val('0');
                window.onbeforeunload = null;
                $(".preloader").fadeOut();
                location.reload(); 
            }

        },
        error: function () {
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
// add personel tim
function AddTempLBByIDByLuar() {
    swal({
        title: "Konfirmasi",
        text: "Apakah Anda yakin Finish Tranasksi ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                FinishTRansaksi();
            } else {
                swal("Transaction Rollback !");
            } 
        });
}
function FinishTRansaksi() {
    var dr_Lokasi = $("#dr_Lokasi").val();
    var dr_kode_peg_SM = $("#dr_kode_peg_SM").val();
    var dr_kode_peg_SPV = $("#lb_SPV").val();
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var lb_IdMOu = $("#lb_IdMOu").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/FinishTRansaksi",
        method: "POST",
        data: "dr_Lokasi=" + dr_Lokasi + "&dr_kode_peg_SM=" + dr_kode_peg_SM
            + "&dr_kode_peg_SPV=" + dr_kode_peg_SPV + "&dr_IDTransaksi=" + dr_IDTransaksi
            + "&lb_tgl_logbook=" + lb_tgl_logbook + "&lb_IdMOu=" + lb_IdMOu,
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
                $("#is_batal").val('0');
                window.onbeforeunload = null;
                location.reload(); 
               
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
function getEntryTools_Rencana() {
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $('#tbl_rencana').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_rencana').DataTable({

        "ajax": {
            "url": base_url + "/pms_gut/public/DailyReport/getEntryTools_Rencana", 
            "type": "POST",
            data: function (d) {
                d.dr_IDTransaksi = dr_IDTransaksi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowMdlKegiatan(' + row.ID + ')"><font size="1">' + row.NAMA_TIM + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.PLANNING + '</font> ';
                    return html
                }
            },
        ],
    });
}
function ShowMdlKegiatan(x) {
    $("#JM_ID_Toolsx").val(x);
    $('#Modal_KegiatanID').modal('show');
}
function addDRTools_Rencana() {
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var ep_dr5_TIM = $("#ep_dr5_rencanan_tim").val();;
    var ep_dr5_rencanan_keg = $("#ep_dr5_rencanan_keg").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/addDRTools_Rencana",
        method: "POST",
        data: "ep_dr5_rencanan_keg=" + ep_dr5_rencanan_keg + "&ep_dr5_TIM=" + ep_dr5_TIM
            + "&dr_IDTransaksi=" + dr_IDTransaksi,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
            
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname); 
            } else if (data.status == "success") { 
                $("#ep_dr5_rencanan_tim").val('');;
                $("#ep_dr5_rencanan_keg").val('');
                getEntryTools_Rencana();
                 
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
function ShowForm2(x) {
    $("#JM_ID_Tools").val(x);
    $('#Modal_verifikasi2').modal('show');    
}
function getEntryTools() {
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $('#tbl_dr_child2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_dr_child2').DataTable({

        "ajax": {
            "url": base_url + "/pms_gut/public/DailyReport/getEntryTools",
            "type": "POST",
            data: function (d) {
                d.dr_IDTransaksi = dr_IDTransaksi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm2(' + row.ID + ')"><font size="1">' + row.Nama + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.QTY + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SATUAN + '</font> ';
                    return html
                }
            },
        ],
    });
}
function addDRTools() { 
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var ep_dr2_tools = $("#ep_dr2_tools").val();
    var ep_dr2_qty = $("#ep_dr2_qty").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/addDRTools/" ,
        method: "POST",
        data: "ep_dr2_tools=" + ep_dr2_tools + "&ep_dr2_qty=" + ep_dr2_qty
            + "&dr_IDTransaksi=" + dr_IDTransaksi,
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
                getEntryTools();
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
            $(".preloader").fadeOut();
        }
    });
}
function newTools() {
    $('#Modal_Add_Tools').modal('show');
}
// show tools
function getdataTools() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/DailyReport/getdataTools/",
        dataType: "json",
        success: function (data) {
            if (data.getdataTools !== null && data.getdataTools !== undefined) {
                console.log(data);
                $("#ep_dr2_tools").empty();
                var newRow = '<option value=""></option';
                $("#ep_dr2_tools").append(newRow);
                var elements = $();
                var dataarray = data.getdataTools.length;
                for (i = 0; i < data.getdataTools.length; i++) {
                    var newRow = '<option value="' + data.getdataTools[i].ID + '">' + data.getdataTools[i].NAMA_BARANG + '</option';
                    $("#ep_dr2_tools").append(newRow);
                }
                $('.js-example-basic-single').select2();
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
// show foto uploads 
function show_data_ProjectAa() {
    var idreg = "<?php echo BASE_URL ?>";
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    $('#tbl_dr_img').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_dr_img').DataTable({
        "ajax": {
            "url": base_url + "/pms_gut/public/DailyReport/showfotoDailyReport/",
            "type": "POST",
            data: function (d) {
                d.dr_IDTransaksi = dr_IDTransaksi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<img src="' + window.location.origin + "/pms_gut/public" + row.images_location + '" alt="' + row.CAPTION + '" data-id="' + row.id + '" data-title="' + row.CAPTION + '" width="300" height="200">';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.CAPTION + '</font> ';
                    return html
                }
            },
        ],
    });
}
function ambilId(file) {
    return document.getElementById(file);
}
function progressHandler(event) {
    ambilId("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    ambilId("progressBar").value = Math.round(percent);
    ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}
function completeHandler(event) {
    ambilId("status").innerHTML = event.target.responseText;
    ambilId("progressBar").value = 0;
}
function errorHandler(event) {
    ambilId("status").innerHTML = "Upload Failed";
}
function abortHandler(event) {
    ambilId("status").innerHTML = "Upload Aborted";
}
// show modal 
function ShowForm3(x) { 
    $("#JM_ID_Activity").val(x);
    $('#Modal_verifikasi3').modal('show');
}
// show kegiatan
function getEntryActivity() {
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $('#tbl_dr_child3').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_dr_child3').DataTable({

        "ajax": {
            "url": base_url + "/pms_gut/public/DailyReport/getEntryActivity/", 
            "type": "POST",
            data: function (d) {
                d.dr_IDTransaksi = dr_IDTransaksi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm3(' + row.ID + ')"><font size="1">' + row.KEGIATAN + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIM + '</font> ';
                    return html
                }
            },
        ],
    });
}
// add kegiatan
function addkegiatan() {
    $(".preloader").fadeIn();
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    // var ep_dr3_tim = $("#lb_fleksibel_tim").val();
    var ep_dr3_kegiatan = $("#ep_dr3_kegiatan").val();
    var ep_dr3_wbslog = $("#ep_dr3_wbslog").val();
    var lb_IdMOu = $("#lb_IdMOu").val();
    var ep_dr3_qty = $("#ep_dr3_qty").val();
    var dr_timLBDate = document.getElementById("dr_timLBDate").value;
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/addkegiatan/",
        method: "POST",
        data: "ep_dr3_kegiatan=" + ep_dr3_kegiatan
            + "&dr_IDTransaksi=" + dr_IDTransaksi + "&ep_dr3_wbslog=" + ep_dr3_wbslog
            + "&lb_IdMOu=" + lb_IdMOu + "&ep_dr3_qty=" + ep_dr3_qty + "&dr_timLBDate=" + dr_timLBDate,
        dataType: "JSON",
        beforeSend: function () {

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
                getEntryActivity();
                $(".preloader").fadeOut(); 
                document.getElementById("lb_fleksibel_tim").disabled = true; 
                $("#ep_dr3_qty").val('0');
                $("#ep_dr3_wbslog").val('');
                $("#ep_dr3_progress").val('0');
                $("#ep_dr3_progress_hasil").val('0');
                $("#ep_dr3_kegiatan").val('');
                getWbsNew();
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
// hitung progress akhir
function calculateProgressAkr() {
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var wbsid = document.getElementById("ep_dr3_wbslog").value;
    var lb_SPV = document.getElementById("lb_SPV").value;
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var ep_dr3_qty = $("#ep_dr3_qty").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/calculateProgressAkr/",
        method: "POST",
        data: "lb_IdMOu=" + lb_IdMOu + "&wbsid=" + wbsid + "&lb_SPV=" + lb_SPV + "&lb_tgl_logbook=" + lb_tgl_logbook
            + "&ep_dr3_qty=" + ep_dr3_qty,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
            $("#ep_dr3_progress_hasil").val(data.PROC_AKHIR);
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
// hitung progress wbs
function calculateProgressAwl() {
    var base_url = window.location.origin;
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var wbsid = document.getElementById("ep_dr3_wbslog").value;
    var lb_SPV = document.getElementById("lb_SPV").value;
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    window.location.origin; 
    $.ajax({
        url: base_url + "/pms_gut/public/DailyReport/calculateProgressAwl/",
        method: "POST",
        data: "lb_IdMOu=" + lb_IdMOu + "&wbsid=" + wbsid + "&lb_SPV=" + lb_SPV + "&lb_tgl_logbook=" + lb_tgl_logbook,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data); 
            $("#ep_dr3_progress").val(data.PROC_RUNNING);
            $("#ep_dr3_qty").focus();
            $(".preloader").fadeOut();
        },  error: function (data) {
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
// show wbs per log book
function getWbsNew() {
    var IsPurchase = document.querySelector('input[value="others"]');
    var base_url = window.location.origin;
    if (IsPurchase.checked) {
        isPurchaseValue = 1;
    } else {
        isPurchaseValue = 0;
    }
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var lb_IdMOu = $("#lb_IdMOu").val();
    var zlb_Lokasi = $("#lb_Lokasi").val();
    $("#ep_dr3_wbslog").empty();
    
    $.ajax({
        type: "POST",
        data: "isPurchase=" + isPurchaseValue + "&zlb_Lokasi=" + zlb_Lokasi + "&lb_IdMOu=" + lb_IdMOu +
            "&lb_tgl_logbook=" + lb_tgl_logbook,
        url: base_url + "/pms_gut/public/DailyReport/showWBSAllAktifFilterPurchase/",
        dataType: "json",
        success: function (data) {
            if (data.getMou !== null && data.getMou !== undefined) {
                console.log(data);
                var newRow = '<option value=""></option';
                $("#ep_dr3_wbslog").append(newRow);
                var elements = $();
                var dataarray = data.getMou.length;
                for (i = 0; i < data.getMou.length; i++) {
                    var newRow = '<option value="' + data.getMou[i].ID_WBS + '">' + data.getMou[i].NM_WBS + ' - ' + data.getMou[i].QTY + '</option';
                    $("#ep_dr3_wbslog").append(newRow);
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

// edit cuaca 
function EditWeather(value, field) {
    $(".preloader").fadeIn();
   
    console.log(value);
    console.log(field);
    var field = field;
    var datavalue = value;
    var dr_IDTransaksi = $("#lb_IDTransaksi").val(); 
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/DailyReport/EditWeather/',
        method: "POST",
        data: "datavalue=" + datavalue + "&field=" + field
            + "&dr_IDTransaksi=" + dr_IDTransaksi,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                getEntryTools_Weather();
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
            $(".preloader").fadeOut();
        }
    });

}
// gen weather
function getEntryTools_Weather() {
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $('#tbl_dr_child_Rencana').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_dr_child_Rencana').DataTable({

        "ajax": { 
            "url": base_url + '/pms_gut/public/DailyReport/getEntryWeather/',
            "type": "POST",
            data: function (d) {
                d.dr_IDTransaksi = dr_IDTransaksi;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "0";
                    if (row.JAM_00 == "0") {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_00 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_00 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "1";
                    if (row.JAM_001 == "0") {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_001 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_001 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "2";
                    if (row.JAM_002 == "0") {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_002 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_002 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "3";
                    if (row.JAM_003 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_003 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_003 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var paramVal = "4";
                    if (row.JAM_004 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_004 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_004 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "5";
                    if (row.JAM_005 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_005 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_005 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "6";
                    if (row.JAM_006 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_006 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_006 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "7";
                    if (row.JAM_007 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_007 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_007 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "8";
                    if (row.JAM_008 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_008 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_008 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "9";
                    if (row.JAM_009 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_009 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_009 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "10";
                    if (row.JAM_0010 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0010 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0010 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "11";
                    if (row.JAM_0011 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0011 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0011 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "12";
                    if (row.JAM_0012 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0012 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0012 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "13";
                    if (row.JAM_0013 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0013 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0013 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "14";
                    if (row.JAM_0014 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0014 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0014 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "15";
                    if (row.JAM_0015 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0015 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0015 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "16";
                    if (row.JAM_0016 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0016 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0016 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "17";
                    if (row.JAM_0017 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0017 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0017 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },


            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "18";
                    if (row.JAM_0018 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0018 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0018 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "19";
                    if (row.JAM_0019 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0019 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0019 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "20";
                    if (row.JAM_0020 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0020 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0020 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "21";
                    if (row.JAM_0021 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0021 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0021 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "22";
                    if (row.JAM_0022 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0022 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0022 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var paramVal = "23";
                    if (row.JAM_0023 == "0") {

                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0023 + ',' + paramVal + ');"><font size="1">H</font></span>';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="badge badge-secondary" onclick="EditWeather(' + row.JAM_0023 + ',' + paramVal + ');"><font size="1">C</font></span>';
                        return html
                    }
                }
            },
        ],
    });
}
// show tim berdasarkan spv
function ShowlistTeamsBySPV() {
    $(".preloader").fadeIn();
    var IdMou = document.getElementById("lb_IdMOu").value;
    var lb_SPV = document.getElementById("lb_SPV").value;
    var dr_timLBDate = document.getElementById("dr_timLBDate").value;
    var kodeLB = $("#lb_IDTransaksi").val();
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var title = 'Jadwal Absensi';
    $('#tblx_team').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tblx_team').DataTable({
        "paging": true,
        "order": [[2, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": { 
            "url": base_url + '/pms_gut/public/DailyReport/ShowlistTeamsBySPVOnly/',
            "type": "POST",
            data: function (d) {
                d.IdMou = IdMou;
                d.lb_SPV = lb_SPV;
                d.kodeLB = kodeLB;
                d.lb_tgl_logbook = lb_tgl_logbook;
                d.dr_timLBDate = dr_timLBDate;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    var html = ""
                    var html = '<font size="2"> ' + row.Nama + ' </font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    var html = ""
                    var html = '<font size="2"> ' + row.Jabatan + ' </font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIME_START_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIME_END_JADWAL + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}
// create hdr daily report
function GGo_GenHdr() {
    
    var dr_Lokasi = $("#lb_Lokasi").val();
    var dr_kode_peg_SM = $("#dr_kode_peg_SM").val();
    var dr_kode_peg_SPV = document.getElementById("lb_SPV").value;
    var dr_timLBDate = document.getElementById("dr_timLBDate").value;
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var IsPurchase = document.querySelector('input[value="others"]');
    var isPurchaseValue = null;
    if (IsPurchase.checked) {
        isPurchaseValue = 1;
    } else {
        isPurchaseValue = 0;
    }
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/DailyReport/genHdrDailyReport/',
        method: "POST",
        data: "dr_Lokasi=" + dr_Lokasi + "&dr_kode_peg_SM=" + dr_kode_peg_SM
            + "&dr_kode_peg_SPV=" + dr_kode_peg_SPV + "&lb_tgl_logbook=" + lb_tgl_logbook
            + "&lb_IdMOu=" + lb_IdMOu + "&IsPurchase=" + isPurchaseValue + "&dr_timLBDate=" + dr_timLBDate,
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
                $("#lb_IDTransaksi").val(data.NoTRS);
                $("#is_batal").val('1');
                EnableForm();
                document.getElementById("btnJadwalCreate").disabled = true;
                document.getElementById("lb_IdMOu").disabled = true;
                document.getElementById("lb_SPV").disabled = true;
                document.getElementById("dr_timLBDate").disabled = true;
                document.getElementById("IsPurchase").disabled = true;
                $(".preloader").fadeOut();
                getEntryTools_Weather();
                getWbsNew();
                
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
function getAllSPVbyKontrak() {
    var xdi = document.getElementById("lb_IdMOu").value;
    var base_url = window.location.origin;
    $("#lb_SPV").empty();
    $.ajax({
        type: "POST",
        data: "id=" + xdi,
        url: base_url + '/pms_gut/public/LogBook/getAllSPVbyKontrak',
        dataType: "json",
        success: function (data) {
            console.log(data); 
            if (data.getSPVbyKontrak !== null && data.getSPVbyKontrak !== undefined) {
                var newRow = '<option value=""></option';
                $("#lb_SPV").append(newRow);
                for (i = 0; i < data.getSPVbyKontrak.length; i++) {
                    var newRow = '<option value="' + data.getSPVbyKontrak[i].ID_Data + '">' + data.getSPVbyKontrak[i].Nama + '</option';
                    $("#lb_SPV").append(newRow);
                }
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
function getMoubyID() {
    var xdi = document.getElementById("lb_IdMOu").value; 
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/LogBook/getMoubyIDAktif/',
        method: "POST",
        data: "xdi=" + xdi,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
 
                $("#lb_nama_project").val(data.NM_PROJECT);
                $("#lb_lokasi_nm").val(data.ALAMAT);
                $("#lb_Lokasi").val(data.KD_JO);
                $("#lb_Alamat").val(data.NM_CLIENT); 
        
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
        }
    });
}
// show data mou
function getMou() {
    var xdi = "2";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/LogBook/getDataMouAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#lb_IdMOu").append(newRow);
            var elements = $();
            var dataarray = data.getMou.length;
            for (i = 0; i < data.getMou.length; i++) {
                var newRow = '<option value="' + data.getMou[i].KODE_TRANSAKSI + '">' + data.getMou[i].ID_MOU + ' - ' + data.getMou[i].NM_PROJECT + '</option';
                $("#lb_IdMOu").append(newRow);
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
function ShowModalMrpint() {
    // body...
    $('#modal_alert_print').modal('show');
}
function ShowDataListTRsWBSUpload() {
    $('#loadMdlLogbook').modal('show');
    var SrcLbDate1 = $("[name='SrcLbDate1']").val();
    var SrcLbDate2 = $("[name='SrcLbDate2']").val();
    var base_url = window.location.origin;
    $('#tblLogbookTRs').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblLogbookTRs').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": { 
            "url": base_url + '/pms_gut/public/DailyReport/ShowDailyReportCurrentDate/',
            "type": "POST",
            data: function (d) {
                d.SrcLbDate1 = SrcLbDate1;
                d.SrcLbDate2 = SrcLbDate2;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_TRS + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID_MOU + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_JO + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_CLIENT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SPVName + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ALAMAT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.FD_TGL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'ShowDataTRsDRbyID("' + row.ID + '")\'>PILIH</button> '
                    return html
                }
            },
        ],
    });
}
function disableForm() {
    document.getElementById("lb_fleksibel_tim").disabled = true;
    document.getElementById("ep_dr3_wbslog").disabled = true;
    document.getElementById("ep_dr3_kegiatan").disabled = true;
    document.getElementById("ep_dr3_qty").disabled = true;
    document.getElementById("btndrAddKegiatan").disabled = true;

    document.getElementById("ep_dr5_rencanan_keg").disabled = true;
    document.getElementById("btndrAddTools_Rencana").disabled = true;
    document.getElementById("ep_dr2_tools").disabled = true;
    document.getElementById("ep_dr2_qty").disabled = true;
    document.getElementById("btndrAddTools").disabled = true;
    document.getElementById("file").disabled = true;
    document.getElementById("ep_dr3_img_caption").disabled = true;
    document.getElementById("upload").disabled = true;
}
function EnableForm() {
    document.getElementById("lb_fleksibel_tim").disabled = false;
    document.getElementById("ep_dr3_wbslog").disabled = false;
    document.getElementById("ep_dr3_kegiatan").disabled = false;
    document.getElementById("ep_dr3_qty").disabled = false;
    document.getElementById("btndrAddKegiatan").disabled = false;

    document.getElementById("ep_dr5_rencanan_keg").disabled = false;
    document.getElementById("btndrAddTools_Rencana").disabled = false;
    document.getElementById("ep_dr2_tools").disabled = false;
    document.getElementById("ep_dr2_qty").disabled = false;
    document.getElementById("btndrAddTools").disabled = false;
    document.getElementById("file").disabled = false;
    document.getElementById("ep_dr3_img_caption").disabled = false;
    document.getElementById("upload").disabled = false;
    document.getElementById("btnSearch").disabled = false;
}
function LogTime() {
    var dr_Lokasi = $("#dr_Lokasi").val();
    var dr_kode_peg_SM = $("#dr_kode_peg_SM").val();
    var dr_kode_peg_SPV = $("#dr_kode_peg_SPV").val();
    var dr_IDTransaksi = $("#lb_IDTransaksi").val();
    var is_batal = $("#is_batal").val();
    var base_url = window.location.origin;
    if (is_batal == "1") {
        jQuery.ajax({
            type: "POST",
            url: base_url + "/pms_gut/public/DailyReport/batalTrsDR",
            data: "dr_Lokasi=" + dr_Lokasi + "&dr_kode_peg_SM=" + dr_kode_peg_SM
                + "&dr_kode_peg_SPV=" + dr_kode_peg_SPV + "&dr_IDTransaksi=" + dr_IDTransaksi,
            cache: false,
            success: function (response) {

            }
        });
    }
}
function ShowlistTeamsByDateLogBook() {
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var lb_SPV = document.getElementById("lb_SPV").value;
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();

    var base_url = window.location.origin;
    $("#dr_timLBDate").empty();
    $.ajax({
        type: "POST",
        data: "IdMou=" + lb_IdMOu + "&lb_SPV=" + lb_SPV + "&lb_tgl_logbook=" + lb_tgl_logbook,
        url: base_url + '/pms_gut/public/DailyReport/ShowlistTeamsByDateLogBook',
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data !== null && data !== undefined) {
                var newRow = '<option value="">-- PILIH --</option';
                $("#dr_timLBDate").append(newRow);
                for (i = 0; i < data.length; i++) {
                    var newRow = '<option value="' + data[i].kd_tim + '">' + data[i].NAMA_TIM + '</option';
                    $("#dr_timLBDate").append(newRow);
                }
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