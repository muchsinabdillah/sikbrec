$(document).ready(function () {
    $(".preloader").fadeOut();
    $(".js-example-placeholder").select2({
        placeholder: "Pilih Pegawai Disini."
    });
    window.onbeforeunload = function () {
        return "Do you want to leave?"
    }
    // A jQuery event (I think), which is triggered after "onbeforeunload"
    $(window).unload(function () {
        LogTime();
        //I will call my method
    });
    getLokasi(); disableForm();
    getpegawai();
    getPeg_ProjectM(); getPeg_ProjectA();
    getPeg_ProjectSO(); getPeg_ProjectSPV();
    // upload Daily Cost Plan
    $('#formUploadDailyProgress').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadDailyProgress').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=fieldailyProgress]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadDailyProgressPlan/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                GenerateDataDailyProgressingPlan();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
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
            e.preventDefault();
        }
    );
    // upload Daily Cost Plan
    $('#formUploadDailyCost').submit(
        function (e) {

            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadDailyCost').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=fieldailyCost]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadDailyCostPlan/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                GenerateDataDailyCostPlan();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
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
            e.preventDefault();
        }
    );
    // upload Daily Man Huors
    $('#formUploadDailyManHours').submit(
        function (e) {

            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadDailyManHours').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=fieldailymanhours]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadManHoursPlan/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                GenerateDataDailyManHoursPlan();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
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
            e.preventDefault();
        }
    );
    // upload TIM
    $('#formUploadTeams').submit(
        function (e) {
            
            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadTeams').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=fiel4]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadTeam/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                GenerateDataTIM();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
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
            e.preventDefault();
        }
    );
    // upload wbs
    $('#formId').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formId').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[type=file]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadWbs/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                }, 
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                GenerateData();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
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
            e.preventDefault();

        }
    );
    // upload wbs - end
    // upload MAN POWER
    $('#formUploadManPower').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadManPower').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=file2]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadManPower/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    if (data.status == "error") {
                        $(".preloader").fadeOut();
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
                        toastr["error"](data.errormessage);
                        $(".preloader").fadeOut();
                         
                    } else if (data.status == "success") {
                        $(".preloader").fadeOut();
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    GenerateDataManPower();
                                } else {
                                    swal("Transaction Rollback !");
                                }
                            });
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
            e.preventDefault();

        }
    );
    // upload MAN POWER - end
    // upload MAN HOUR
    $('#formUploadManHour').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData();
            var form = $('#formUploadManHour').serialize();
            form_data.append("upldwbs_IDtrs", $("#upldwbs_IDtrs").val());
            form_data.append("upldwbs_datestart", $("#upldwbs_datestart").val());
            form_data.append("upldwbs_dateend", $("#upldwbs_dateend").val());
            form_data.append("upldwbs_lokasi", $("#upldwbs_lokasi").val());
            form_data.append("file", $('input[name=file3]')[0].files[0]);
            $.ajax({
                url: base_url + '/pms_gut/public/UploadPlan/uploadManHour/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    if (data.status == "error") {
                        $(".preloader").fadeOut();
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
                        toastr["error"](data.errormessage);
                        $(".preloader").fadeOut();

                    } else if (data.status == "success") {
                        $(".preloader").fadeOut();
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    GenerateDataManHour();
                                } else {
                                    swal("Transaction Rollback !");
                                }
                            });
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
            e.preventDefault();

        }
    );
    // upload MAN HOUR - end
    // edit wbs 
    $(document).on('click', '#btnMdlWBSSimpan', function () {
        var str = $("#frmWBSDetailbyId").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST 
            url: base_url + '/pms_gut/public/UploadPlan/UpdateDataImportWbsById/',
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $('#btnMdlWBSSimpan').html('Please Wait...');
                $('#btnMdlWBSSimpan').disabled = true;
            },
            success: function (data) {
                if (data.status == "warning") {
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.pesan,
                        type: 'danger'
                    });
                    $('#btnMdlWBSSimpan').html('Simpan');
                    $('#btnMdlWBSSimpan').disabled = false;
                } else if (data.status == "success") {
                    document.getElementById("frmWBSDetailbyId").reset();
                    $('#Modal_verifikasi').modal('hide');
                    ShowlistDetilWbs();
                    $('#btnMdlWBSSimpan').html('Simpan');
                    $('#btnMdlWBSSimpan').disabled = false;
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
                $('#btnMdlWBSSimpan').html('Simpan');
                $('#btnMdlWBSSimpan').disabled = false;
            }
        });

    });
    // edit wbs
    // hapus wbs
    $(document).on('click', '#btnMdlWBSHapus', function () {
        var str = $("#frmWBSDetailbyId").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST 
            url: base_url + '/pms_gut/public/UploadPlan/HapusDataImportWbsById/',
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $('#btnMdlWBSHapus').html('Please Wait...');
                $('#btnMdlWBSHapus').disabled = true;
            },
            success: function (data) {
                if (data.status == "warning") {
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.pesan,
                        type: 'danger'
                    });
                    $('#btnMdlWBSHapus').html('Hapus');
                    $('#btnMdlWBSHapus').disabled = false;
                } else if (data.status == "success") {
                    document.getElementById("frmWBSDetailbyId").reset();
                    $('#Modal_verifikasi').modal('hide');
                    $('#btnMdlWBSHapus').html('Hapus');
                    $('#btnMdlWBSHapus').disabled = false;
                    ShowlistDetilWbs();
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
                $('#btnMdlWBSSimpan').html('Simpan');
                $('#btnMdlWBSSimpan').disabled = false;
            }
        });

    });
    // hapus wbs
    // hapus 1 trs import
    $("#btnCancel").click(function () { // Ketika user menekan tombol di keyboard
        //cc
        swal({
            title: "Batal",
            text: "Batalkan Transaksi Kontrak & Plan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    BatalImportWBS();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });
    // hapus 1 trs import
    // FINISH TRS IMPORT
    $(document).on('click', '#btnFinishTrs', function () {
        swal({
            title: "Finish Transaksi",
            text: "Apakah Transaksi Sudah Selesai, Lanjutkan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    GGo_GenHdr();
                    //swal("Bakekook... !");
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });
    // FINISH IMPORT
});
// finish
function GGo_GenHdr() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();
    var upldwbs_namaproject = $("#upldwbs_namaproject").val();
    var upldwbs_namaclient = $("#upldwbs_namaclient").val();
    var upldwbs_lokasi_nm = $("#upldwbs_lokasi_nm").val();
    var upldwbs_durasi = $("#upldwbs_durasi").val();
    var upldwbs_totalpegawai = $("#upldwbs_totalpegawai").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/FinishImportWBS/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi

            + "&upldwbs_idmou=" + upldwbs_idmou + "&upldwbs_namaproject=" + upldwbs_namaproject
            + "&upldwbs_namaclient=" + upldwbs_namaclient + "&upldwbs_lokasi_nm=" + upldwbs_lokasi_nm
            + "&upldwbs_durasi=" + upldwbs_durasi + "&upldwbs_totalpegawai=" + upldwbs_totalpegawai,
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
                $("#upldwbs_IDtrs").val(data.NoTRS); 
                enableForm();
                document.getElementById("btnJadwalCreate").disabled = true;
                document.getElementById("btnCancel").disabled = false;
                document.getElementById("btnFinishTrs").disabled = false;
                $(".preloader").fadeOut();
            } else if (data.status == "update") {
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
// finish
// LOAD DATA DETIL UPLOAD PLAN
function ShowDataTRsWBSUploadbyID(x) {
    console.log(x);
    var base_url = window.location.origin;
    $.ajax({ 
        "url": base_url + '/pms_gut/public/UploadPlan/ShowDataTRsWBSUploadbyID/',
        type: "POST",
        data: "q=" + x,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#upldwbs_IDtrs").val(data.KODE_TRANSAKSI);
            $('#upldwbs_lokasi').val(data.KODE_JO).trigger('change');
            $("#upldwbs_dateend").val(data.DATE_END);
            $("#upldwbs_datestart").val(data.DATE_START);
            $("#is_batal").val('0');
            $("#upldwbs_namaproject").val(data.NM_PROJECT);
            $("#upldwbs_idmou").val(data.ID_MOU);
            $("#upldwbs_durasi").val(data.FN_DURASI);
            $("#upldwbs_totalpegawai").val(data.TOTAL_PEG);
            $('#mdlloadtrsWbsUpload').modal('hide');
            ShowlistDetilTIM();
            ShowlistDetilWbs();
            ShowlistDMHPlan();
            ShowlistDCPPlan();
            ShowlistDPRPlan();
            //if(jenispeg == "SITE_MANAGER" ){
            show_data_ProjectM();
            //}else if(jenispeg == "PROJECT_SUPPORT" ){
            show_data_ProjectPS();
            //}else if(jenispeg == "PROJECT_ADMIN" ){
            show_data_ProjectA();
            //} else if(jenispeg == "SAFETY_OFFICER" ){
            show_data_ProjectSO();
            //}else if(jenispeg == "SUPERVISOR" ){
            show_data_ProjectSPV();
            //}
            document.getElementById("btnCancel").disabled = false;
            document.getElementById("btnUploads_tim").disabled = false;
            document.getElementById("btnUploads").disabled = false;
            document.getElementById("btnFinishTrs").disabled = false;
            document.getElementById("btnJadwalCreate").disabled = true;
            document.getElementById("upldwbs_ProjectM").disabled = false;
            document.getElementById("upldwbs_ProjectAdmin").disabled = false;
            document.getElementById("ep_lb_personel").disabled = false;
            document.getElementById("upldwbs_ProjectSO").disabled = false;
            document.getElementById("upldwbs_ProjectSPV").disabled = false;
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
//BATAL TRANSAKSI IMPORT

function BatalImportWBS() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var is_batal = $("#is_batal").val();

    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST 
        "url": base_url + '/pms_gut/public/UploadPlan/BatalImportWBS/',
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            if (data.status == "warning") {
                swal(data.errorname);
            } else if (data.status == "success") {
                $(".preloader").fadeOut();
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
                $("#is_batal").val('0');
                window.onbeforeunload = null;
                $(".preloader").fadeOut(); 
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
// load data wbs id per id 
function ShowForm(x) {
    $("#JM_ID").val(x);
    var base_url = window.location.origin;
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    $.ajax({
        data: "Id=" + x + "&upldwbs_IDtrs=" + upldwbs_IDtrs,
        "url": base_url + '/pms_gut/public/UploadPlan/showdetilTrsWbsByid/',
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#vrfWbs_idWBS").val(data.ID_WBS);
            $("#vrfWbs_Nama").val(data.NM_WBS);
            $("#vrfWbs_TipeWbs").val(data.KD_TIPE_WBS);
            $("#vrfWbs_KdLevel").val(data.KD_LEVEL);
            $("#vrfWbs_GroupLvl").val(data.FB_GRUP);
            $("#vrfWbs_Qty").val(data.QTY);
            $("#vrfWbs_MpNilai").val(data.MP_NILAI);
            $("#vrfWbs_EquipNilai").val(data.EQUIP_NILAI);
            $("#vrfWbs_ToolsNilai").val(data.TOOLS_NILAI);
            $("#vrfWbs_MhNilai").val(data.MH_NILAI);
            //$("#xNIlaiKomponen").focus(); 
            var Payroll_IDtrs = $("#Payroll_IDtrs").val();
            //$("#xNOTransaksi").val(Payroll_IDtrs);  
            $('#Modal_verifikasi').modal('show');
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
function ShowDataListTRsWBSUpload() {
    var base_url = window.location.origin;
    $('#tblCariwbstrs').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblCariwbstrs').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowDataListTRsWBSUploadAll/',
            "type": "POST",
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
                    var html = '<font size="2"> ' + row.DATE_IMPORT + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NamaLengkap + '</font> ';
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
                    var html = '<font size="2"> ' + row.ID_MOU + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_PROJECT + '</font> ';
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

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'ShowDataTRsWBSUploadbyID("' + row.KODE_TRANSAKSI + '")\'>PILIH</button> '
                    return html
                }
            },
        ],
    });
}
function ShowlistDetilMH() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tbl_manhourlist').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_manhourlist').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDetilMH/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm(' + row.ID + ')"><font size="1">' + row.No + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TAHUN + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ISO_WEEK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIPE + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.MULAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SELESAI + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}

// GENERATE MAN HOUR TO DB
function GenerateDataManHour() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/genUploadManHour/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDetilMH();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
// GENERATE WBS TO DB
function GenerateDataManPower() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/genUploadManPower/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDetilMP();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
function ShowlistDetilMP() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tbl_manpowerlist').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_manpowerlist').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDetilMP/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm(' + row.ID + ')"><font size="1">' + row.No + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TAHUN + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ISO_WEEK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIPE + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.MULAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SELESAI + '</font> ';
                    return html
                }
            }, 
        ],
    });
    $(".preloader").fadeOut();
}
function ShowlistDMHPlan() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tbl_DMH_Plan').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_DMH_Plan').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDMHPlan/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<font size="2"> ' + row.Date_DMH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Total_MH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Cumm_MH + '</font> ';
                    return html
                }
            }, 
        ],
    });
    $(".preloader").fadeOut();
}
function ShowlistDCPPlan() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tbl_DCP_Plan').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_DCP_Plan').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDCPPlan/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<font size="2"> ' + row.Date_DMH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Total_MH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Cumm_MH + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}
function ShowlistDPRPlan() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tbl_DPR_Plan').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_DPR_Plan').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDPRPlan/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<font size="2"> ' + row.Date_DMH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Total_MH + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Cumm_MH + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}
function ShowlistDetilTIM() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#tblx_team').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tblx_team').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDetilTIM/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<font size="2"> ' + row.Nip + '</font> ';
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
                    var html = '<font size="2"> ' + row.NAMA_TIM + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.StatusKaryawan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIM_DESCRIPTION + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Time_Start + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Time_End + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}
function ShowlistDetilWbs() {
    $(".preloader").fadeIn();
    var VerifwbS_Kode = $("#upldwbs_IDtrs").val();
    $('#example').DataTable().clear().destroy();
    var base_url = window.location.origin; 

    $('#example').DataTable({
        "stateSave": true,
        "scrollY": 500,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            leftColumns: 2
        },
        "paging": true,
        "pageLength": 100,
        "order": [[2, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/UploadPlan/ShowlistDetilWbs/',
            "type": "POST",
            data: function (d) {
                d.VerifwbS_Kode = VerifwbS_Kode;
            },
            "dataSrc": "",
            "deferRender": true,
            "scroller": {
                loadingIndicator: true
            },
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<span class="badge badge-secondary" onclick="ShowForm(' + row.ID + ')"><font size="1">' + row.ID_WBS + ' </font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_WBS + '</font> ';
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
                    var html = '<font size="2"> ' + row.MP_NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.EQUIP_NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TOOLS_NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.MH_NILAI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_WBS_GRUP + '</font> ';
                    return html
                }
            },


            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_WBS_EKS + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.MP_CONFIG_CODE + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.MP_PLAN + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.UNIT_HOURS + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.unit + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ACTUAL_UNIT_ST + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ACTUAL_TOTAL_M_HOUR + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.WORKING_HOURS + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TOTAL_QTY + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SP_ID + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TASK_STATUS + '</font> ';
                    return html
                }
            },
        ],
    });
    $(".preloader").fadeOut();
}
function GenerateDataDailyProgressingPlan() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/GenerateDataDailyProgressingPlan/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDPRPlan();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
function GenerateDataDailyCostPlan() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/GenerateDataDailyCostPlan/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDCPPlan();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
function GenerateDataDailyManHoursPlan() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/genUploadDailyManHoursPlan/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDMHPlan();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
function GenerateDataTIM() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();

    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/genUploadTIM/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            ShowlistDetilTIM();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
// GENERATE WBS TO DB - END
function GenerateData() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var upldwbs_datestart = $("#upldwbs_datestart").val();
    var upldwbs_dateend = $("#upldwbs_dateend").val();
    var upldwbs_lokasi = $("#upldwbs_lokasi").val();
    var upldwbs_idmou = $("#upldwbs_idmou").val();
 
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/genUploadWbs/',
        method: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs + "&upldwbs_datestart=" + upldwbs_datestart
            + "&upldwbs_dateend=" + upldwbs_dateend + "&upldwbs_lokasi=" + upldwbs_lokasi
            + "&upldwbs_idmou=" + upldwbs_idmou,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                toastr["error"](data.pesan);
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                swal({
                    title: "Success",
                    text: "Generate Data Sukses, Load Data. Please Wait...",
                    icon: "success",
                })
                    .then((willDelete) => {
                        if (willDelete) { 
                            ShowlistDetilWbs();
                        } else {
                            swal("Transaction Rollback !");
                        }
                    });
                // swal(data.pesan);  
                document.getElementById("formId").reset();
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
// GENERATE WBS TO DB - END

// show enerate data_pegawai_SM_SPV_So
function deletePegSPV(x) {
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/delProjectPS',
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $(".preloader").fadeOut();

            } else if (data.status == "success") {
                show_data_ProjectSPV();
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
function show_data_ProjectSPV() {
    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/showdataProjectSPV',
        type: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            $("#view_spv").empty();
            if (data.data.showdataProjectSPV !== null && data.data.showdataProjectSPV !== undefined) {
                for (i = 0; i < data.data.showdataProjectSPV.length; i++) {
                    var newRow = '<tr><td><span class="label label-primary label-bordered" onclick="deletePegSPV(' + data.data.showdataProjectSPV[i].ID + ')">' + data.data.showdataProjectSPV[i].Nama + '</span></td></tr><br>';
                    $("#view_spv").append(newRow).html();
                }
            }
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
            $(".preloader").fadeOut();
        }
    });
}
function deletePegSO(x) {
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/delProjectPS',
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $(".preloader").fadeOut();

            } else if (data.status == "success") {
                show_data_ProjectSO();
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
function show_data_ProjectSO() {
    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/showdataProjectSO',
        type: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            $("#view_safety_officer").empty();
            if (data.data.showdataProjectSO !== null && data.data.showdataProjectSO !== undefined) {
                for (i = 0; i < data.data.showdataProjectSO.length; i++) {
                    var newRow = '<tr><td><span class="label label-primary label-bordered" onclick="deletePegSO(' + data.data.showdataProjectSO[i].ID + ')">' + data.data.showdataProjectSO[i].Nama + '</span></td></tr><br>';
                    $("#view_safety_officer").append(newRow).html();
                }
            }
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
            $(".preloader").fadeOut();
        }
    });
}
function deletePegAdmin(x) {
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/delProjectPS',
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $(".preloader").fadeOut();

            } else if (data.status == "success") {
                show_data_ProjectA();
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
function show_data_ProjectA() {
    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/showdataProjectA',
        type: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            $("#view_project_admin").empty();
            if (data.data.showdataProjectA !== null && data.data.showdataProjectA !== undefined) {
                for (i = 0; i < data.data.showdataProjectA.length; i++) {
                    var newRow = '<tr><td><span class="label label-primary label-bordered" onclick="deletePegAdmin(' + data.data.showdataProjectA[i].ID + ')">' + data.data.showdataProjectA[i].Nama + '</span></td></tr><br>';
                    $("#view_project_admin").append(newRow).html();
                }
            }
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
            $(".preloader").fadeOut();
        }
    });
}
function show_data_ProjectPS() {
    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val(); 
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/showdataProjectPS',
        type: "POST",
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) { 
                $("#view_project_support").empty();
                if (data.data.showdataProjectM !== null && data.data.showdataProjectM !== undefined) {
                    for (i = 0; i < data.data.showdataProjectM.length; i++) {
                        var newRow = '<tr><td><span class="label label-primary label-bordered" onclick="deletePegPS(' + data.data.showdataProjectM[i].ID + ')">' + data.data.showdataProjectM[i].Nama + '</span></td></tr><br>';
                        $("#view_project_support").append(newRow).html();
                    }
                } 
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
            $(".preloader").fadeOut();
        }
    });
}
function deletePegPS(x) {
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/delProjectPS',
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $(".preloader").fadeOut();
                
            } else if (data.status == "success") {
                show_data_ProjectPS();
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
function show_data_ProjectM() {
    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/showdataProjectM',
        data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
        type: "POST",
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {  
                $("#view_siteManager").empty(); 
                if (data.data.showdataProjectM !== null && data.data.showdataProjectM !== undefined){
                    for (i = 0; i < data.data.showdataProjectM.length; i++) {
                        var newRow = '<tr><td><span class="label label-primary label-bordered" onclick="deletePegSM(' + data.data.showdataProjectM[i].ID + ')">' + data.data.showdataProjectM[i].Nama + '</span></td></tr><br>';
                        $("#view_siteManager").append(newRow).html();
                    }
                } 
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
function deletePegSM(x) {
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/delProjectM',
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
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
                $(".preloader").fadeOut();
            } else if (data.status == "success") {
                show_data_ProjectM();
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
            $(".preloader").fadeOut();
        }
    });
}
/// generate data_pegawai_SM_SPV_SO
function add_upldwbs_ProjectM(jenispeg) {
    if (jenispeg == "SITE_MANAGER") {
        var upldwbs_ProjectM = document.getElementById("upldwbs_ProjectM").value;
    } else if (jenispeg == "PROJECT_SUPPORT") {
        var upldwbs_ProjectM = document.getElementById("ep_lb_personel").value;
    } else if (jenispeg == "PROJECT_ADMIN") {
        var upldwbs_ProjectM = document.getElementById("upldwbs_ProjectAdmin").value;
    }
    else if (jenispeg == "SAFETY_OFFICER") {
        var upldwbs_ProjectM = document.getElementById("upldwbs_ProjectSO").value;
    }
    else if (jenispeg == "SUPERVISOR") {
        var upldwbs_ProjectM = document.getElementById("upldwbs_ProjectSPV").value;
    }

    var upldwbs_IDtrs = $("[name='upldwbs_IDtrs']").val();
    var jenispeg = jenispeg;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + '/pms_gut/public/Pegawai/addPegawaibyProjectMou',
        data: "upldwbs_ProjectM=" + upldwbs_ProjectM + "&upldwbs_IDtrs=" + upldwbs_IDtrs + "&jenispeg=" + jenispeg,
        dataType: "JSON",
        success: function (data) {
           if (data.status == "success") {
                if (jenispeg == "SITE_MANAGER") {
                    show_data_ProjectM();
                } else if (jenispeg == "PROJECT_SUPPORT") {
                    show_data_ProjectPS();
                } else if (jenispeg == "PROJECT_ADMIN") {
                    show_data_ProjectA();
                } else if (jenispeg == "SAFETY_OFFICER") {
                    show_data_ProjectSO();
                } else if (jenispeg == "SUPERVISOR") {
                    show_data_ProjectSPV();
                }
            } else if (data.status == "warning") {
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
// GET DATA PEGAWAI ALL
function getpegawai() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getpegawaiAllAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#ep_lb_personel").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#ep_lb_personel").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
function getPeg_ProjectM() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getpegawaiAllAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#upldwbs_ProjectM").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#upldwbs_ProjectM").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
function getPeg_ProjectA() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getpegawaiAllAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#upldwbs_ProjectAdmin").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#upldwbs_ProjectAdmin").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}

function getPeg_ProjectSO() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getpegawaiAllAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#upldwbs_ProjectSO").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#upldwbs_ProjectSO").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
function getPeg_ProjectSPV() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getpegawaiAllAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#upldwbs_ProjectSPV").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#upldwbs_ProjectSPV").append(newRow);
            }
            // $('.js-example-basic-single').select2(); 

        },error: function (data) {
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
/// get data 
function GenerateHdr() {   
    const base_url = window.location.origin;
    var form_data = $("#form_hdr_plan").serialize();
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/createHdrUploadPlan',
        method: "POST",
        data: form_data,
        dataType: "JSON",
        beforeSend: function () { 
            document.getElementById("btnJadwalCreate").disabled = true;
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
                $("#upldwbs_IDtrs").val(data.NoTRS);
                $("#is_batal").val('1');
                enableForm();
                document.getElementById("btnJadwalCreate").disabled = true;
                document.getElementById("btnCancel").disabled = false;
                document.getElementById("btnFinishTrs").disabled = false; 
            
            } else if (data.status == "update") {
                location.reload();
            }
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
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
            document.getElementById("btnJadwalCreate").disabled = false;
            $('#btnJadwalCreate').html('TRANSAKSI BARU');
        }
    });
}
function getLokasi() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/UploadPlan/getLokasiJoByHakUser',
        dataType: "json",
        success: function (data) {
            console.log(data.dataJoAll.length);
            var newRow = '<option value=""></option';
            $("#upldwbs_lokasi").append(newRow); 
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_CLIENT + '</option';
                $("#upldwbs_lokasi").append(newRow);
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
function getDataJo() {
    var base_url = window.location.origin;
    var x = $("#upldwbs_lokasi").val();
    $.ajax({
        url: base_url + '/pms_gut/public/UploadPlan/getDataJobyId/',
        type: "POST",
        data: "id=" + x, 
        dataType: "JSON",
        success: function (data) {
            $("#upldwbs_lokasi_nm").val(data.NM_PROJECT);
            $("#upldwbs_namaclient").val(data.NM_CLIENT);
            $("#upldwbs_alamatclient").val(data.ALAMAT);
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
function disableForm() {
    document.getElementById("upldwbs_IDtrs").readonly = true;
    document.getElementById("file").disabled = true;  
    document.getElementById("btnUploads").disabled = true;
    document.getElementById("btnUploads_tim").disabled = true;
    document.getElementById("btnCancel").disabled = true;
    document.getElementById("btnFinishTrs").disabled = true;
    document.getElementById("upldwbs_ProjectM").disabled = true;
    document.getElementById("upldwbs_ProjectAdmin").disabled = true;
    document.getElementById("ep_lb_personel").disabled = true;
    document.getElementById("upldwbs_ProjectSO").disabled = true;
    document.getElementById("upldwbs_ProjectSPV").disabled = true;
}
function enableForm() {
    document.getElementById("upldwbs_IDtrs").readonly = false;
    document.getElementById("file").disabled = false;
    document.getElementById("btnUploads").disabled = false;
    document.getElementById("btnUploads_tim").disabled = false;
    document.getElementById("btnCancel").disabled = true;
    document.getElementById("btnJadwalCreate").disabled = true;
    document.getElementById("upldwbs_ProjectM").disabled = false;
    document.getElementById("upldwbs_ProjectAdmin").disabled = false;
    document.getElementById("ep_lb_personel").disabled = false;
    document.getElementById("upldwbs_ProjectSO").disabled = false;
    document.getElementById("upldwbs_ProjectSPV").disabled = false;
}
function LogTime() {
    var upldwbs_IDtrs = $("#upldwbs_IDtrs").val();
    var is_batal = $("#is_batal").val();
    var base_url = window.location.origin;
    if(is_batal =="1"){
        jQuery.ajax({
            type: "POST",
            url: base_url + '/pms_gut/public/UploadPlan/BatalImportWBS/',
            data: "upldwbs_IDtrs=" + upldwbs_IDtrs,
            cache: false,
            success: function (response) {

            }
        });
    }
}