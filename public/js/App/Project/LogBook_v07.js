$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $("#pnlViewListDetil").hide();
    getMou();
    disableForm(); 
    headerDisableForm(); 
    window.onbeforeunload = function () {
        return "Do you want to leave?"
    }
    // A jQuery event (I think), which is triggered after "onbeforeunload"
    $(window).unload(function () {
        LogTime();
        //I will call my method
    });
    $(document).on('click', '#btnBatalLogBook', function () {
        swal({
            title: "Konfirmasi",
            text: "Anda Yakin Ingin batalkan transaksi LogBook, Lanjutkan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                bataltrsLogbook();
            }   
        });
    });
    $(document).on('click', '#btnFinishLogBook', function () {
        swal({
            title: "Konfirmasi",
            text: "Anda Yakin Ingin Selesaikan transaksi LogBook, Lanjutkan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    finishTransaksi();
                } 
            });
    });
    $("#lb_kode_wbsid").select2({ 
        ajax: {
            
            url: function (params) {
                return window.location.origin+'/pms_gut/public/LogBook/getWBSbyMouJo/';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var x = $("#lb_Lokasi").val();
                return {
                    searchTerm: params.term,
                    zlb_Lokasi: x ,
                    lb_IdMOu: + $("#lb_IdMOu").val()  
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    $(document).on('click', '#btnAddLBdetil', function () {
        //$(".preloader").fadeIn();
        var ep_lb_personel = $("[name='ep_lb_personel[]']").val();
        var ep_lb_kegiatan = $("[name='ep_lb_kegiatan']").val();
        var lb_Lokasi = $("[name='lb_Lokasi']").val();
        var lb_spv = document.getElementById("lb_fleksibel_tim").value;
        var lb_kode_wbsid = document.getElementById("lb_kode_wbsid").value;
        var lb_tgl_logbook = $("[name='lb_tgl_logbook']").val(); 
        var ep_lb_timestart = $("[name='ep_lb_timestart']").val();
        var ep_lb_timeend = $("[name='ep_lb_timeend']").val(); 
        var lb_kode_peg_SM = $("[name='lb_kode_peg_SM']").val();
        var lb_IDTransaksi = $("[name='lb_IDTransaksi']").val();
        var lb_IdMOu = $("[name='lb_IdMOu']").val();
        var ep_lb_timestart_jadwal = $("[name='ep_lb_timestart_jadwal']").val();
        var ep_lb_timeend_jadwal = $("[name='ep_lb_timeend_jadwal']").val();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST 
            url: base_url + '/pms_gut/public/LogBook/SaveAddtools/',
            data: "ep_lb_personel=" + ep_lb_personel + "&ep_lb_kegiatan=" + ep_lb_kegiatan
                + "&lb_Lokasi=" + lb_Lokasi + "&lb_kode_wbsid=" + lb_kode_wbsid
                + "&lb_tgl_logbook=" + lb_tgl_logbook + "&ep_lb_timestart=" + ep_lb_timestart
                + "&ep_lb_timeend=" + ep_lb_timeend + "&lb_kode_peg_SM=" + lb_kode_peg_SM
                + "&lb_IDTransaksi=" + lb_IDTransaksi
                + "&lb_IdMOu=" + lb_IdMOu + "&lb_spv=" + lb_spv
                + "&ep_lb_timestart_jadwal=" + ep_lb_timestart_jadwal + "&ep_lb_timeend_jadwal=" + ep_lb_timeend_jadwal,
            dataType: "JSON",
            beforeSend: function () {
                $('#Confirm').html('Sending...');
                $('#Confirm').addClass('btn-danger');
            },
            success: function (data) {
                if (data.status == "warning") {
                    //new PNotify({
                    //          title: 'Notifikasi',
                    //          text: data.errorname,
                    //          type: 'danger'
                    //});

                    swal(data.errorname);
                    $(".preloader").fadeOut();
                } else if (data.status == "success") {
                    //document.getElementById("frm_logbook").reset(); 
                    $('#ep_lb_personel').val('').trigger('change');
                    $("[name='ep_lb_kegiatan']").val('');
                    $("[name='lb_kode_wbsid']").val('');
                    $("[name='ep_lb_timestart']").val(''); $("[name='ep_lb_timeend']").val('');
                    $("[name='lb_kode_wbsid_nama']").val('');
                    // location.reload();
                    getEntrylogBook(); ShowlistTeamsBySPV();
                    document.getElementById("lb_fleksibel_tim").disabled = true;
                    document.getElementById("lb_fleksibel_timLuar").disabled = true;
                    $(".preloader").fadeOut();
                }
                $(".preloader").fadeOut();
            },
            error: function (data) {
                $(".preloader").fadeOut();
            }
        });
    });
    $(document).on('click', '#btnDelLoogBookdetil', function () {
        var str = $("#frmDelLoogBookdetil").serialize();
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST 
            url: base_url + '/pms_gut/public/LogBook/DeleteLogBookdetil/',
            data: str,
            dataType: "JSON",
            beforeSend: function () {
                $(".preloader").fadeIn();
            },
            success: function (data) {
                if (data.status == "warning") {
                    swal(data.errorname);
                } else if (data.status == "success") {
                    document.getElementById("frmDelLoogBookdetil").reset();
                    $('#Modal_Del_logBook').modal('hide');
                    getEntrylogBook();
                }
                $(".preloader").fadeOut();
            },
            error: function (data) {
                $(".preloader").fadeOut();
            }
        });

    });
});
// show log book hari ini
function ShowDataListTRsWBSUpload() { 
    var base_url = window.location.origin;  
    var SrcLbDate1 = $("[name='SrcLbDate1']").val();
    var SrcLbDate2 = $("[name='SrcLbDate2']").val(); 
    $('#tblLogbookTRs').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblLogbookTRs').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url" : base_url + '/pms_gut/public/LogBook/showLogBookCurrentDate/',
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
                    var html = '<font size="2"> ' + row.TGL_LOG_BOOK + '</font> ';
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
                    var html = '<font size="2"> ' + row.KD_MOU + '</font> ';
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
                    var html = '<font size="2"> ' + row.TIME_START + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TIME_END + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'ShowDataTRsLogBookbyID("' + row.KD_TRS + '")\'>PILIH</button> '
                    return html
                }
            },
        ],
    });
}
// show detil per trs
function ShowDataTRsLogBookbyID(x){ 
    var base_url = window.location.origin;
    console.log(x); 
    $.ajax({ 
        "url": base_url + '/pms_gut/public/LogBook/ShowDataTRsLogBookbyID/',
           type: "POST",
           data: "q="+x,
           cache: false,
           dataType: "JSON",
              success: function(data){
                $("#lb_IDTransaksi").val(data.KD_TRS);  
                $('#lb_Lokasi').val(data.KD_JO).trigger('change'); 
                $("#is_batal").val('0');
                setTimeout(function() {
                      $('#lb_IdMOu').val(data.KD_MOU).trigger('change');
                       
                      enableForm();
                }, 500);
                setTimeout(function() {
                      $('#lb_SPV').val(data.KD_PEG_SPV).trigger('change');  
                       
                      enableForm();
                }, 1000);
                setTimeout(function() {
                     $('#lb_fleksibel_tim').val(data.KD_TIM).trigger('change'); 
                       
                      enableForm();
                }, 1500);
                document.getElementById("lb_kode_wbsid").disabled = false;
                //$('#lb_fleksibel_tim').val(data.KD_TIM).trigger('change'); 
                 
                $('#loadMdlLogbook').modal('hide');   
              }
    });
}
// show form 
function shwFormLogBookDel(x) {
    $("#ID_logNookDel").val(x);
    $('#Modal_Del_logBook').modal('show');
}
// del temp pegawai
function delTempLB(x) {
    var kodeLB = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $.ajax({ 
        url: base_url + '/pms_gut/public/LogBook/delTempLBByID/',
        type: "POST",
        data: "q=" + x + "&kodeLB=" + kodeLB,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "warning") {
                swal(data.errorname);
            } else if (data.status == "success") {
                ShowlistTeamsBySPV();
            }
        }
    });
}
// get entry log
function getEntrylogBookHistory() {
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var lb_IDTransaksi = $("#lb_IDTransaksi").val();
    $('#tbl_lb_child2').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_lb_child2').DataTable({
        "order": false, // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": { 
            url: base_url + '/pms_gut/public/LogBook/getEntrylogBookHistory/',
            "type": "POST",
            data: function (d) {
                d.lb_IDTransaksi = lb_IDTransaksi;
                d.lb_tgl_logbook = lb_tgl_logbook;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_TIM + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_START_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_END_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_START + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_END + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NM_WBS + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_KEGIATAN + '</font> ';
                    return html
                }
            },

        ],
    });


}
// create header
function GGo_GenHdr() {
    var dr_Lokasi = $("#lb_Lokasi").val();
    var dr_kode_peg_SM = $("#lb_kode_peg_SM").val();
    var dr_kode_peg_SPV = document.getElementById("lb_SPV").value;
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var lb_tgl_logbook = $("#lb_tgl_logbook").val();
    var base_url = window.location.origin; 
    $.ajax({
        url: base_url + '/pms_gut/public/LogBook/genHdrLogBook/',
        method: "POST",
        data: "dr_Lokasi=" + dr_Lokasi + "&dr_kode_peg_SM=" + dr_kode_peg_SM
            + "&dr_kode_peg_SPV=" + dr_kode_peg_SPV + "&lb_tgl_logbook=" + lb_tgl_logbook
            + "&lb_IdMOu=" + lb_IdMOu,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
            } else if (data.status == "success") {
                $("#lb_IDTransaksi").val(data.NoTRS);
                $("#is_batal").val('1');
                document.getElementById("lb_IDTransaksi").disabled = true;

                document.getElementById("lb_tgl_logbook").disabled = false;
                document.getElementById("ep_lb_kegiatan").disabled = false;
                document.getElementById("lb_Lokasi").disabled = false;
                document.getElementById("lb_kode_wbsid").disabled = false;
                document.getElementById("ep_lb_timestart").disabled = false;
                document.getElementById("ep_lb_timeend").disabled = false;
                document.getElementById("lb_IdMOu").disabled = false;
                document.getElementById("ep_lb_timestart_jadwal").disabled = false;
                document.getElementById("ep_lb_timeend_jadwal").disabled = false;
                document.getElementById("btnJadwalCreate").disabled = true;
                document.getElementById("ep_lb_personel").disabled = false;
                document.getElementById("lb_IdMOu").disabled = true;
                document.getElementById("lb_fleksibel_tim").disabled = false;
                document.getElementById("lb_fleksibel_timLuar").disabled = false;
                document.getElementById("lb_SPV").disabled = true;



                //  EnableForm(); 
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
        }
    });
}
function disableForm() {
    document.getElementById("ep_lb_timestart").disabled = true;
    document.getElementById("ep_lb_timeend").disabled = true;
    document.getElementById("ep_lb_kegiatan").disabled = true;
    document.getElementById("ep_lb_personel").disabled = true;
    document.getElementById("lb_kode_wbsid").disabled = true;
    document.getElementById("lb_fleksibel_tim").disabled = true;
    document.getElementById("lb_fleksibel_timLuar").disabled = true;
    document.getElementById("ep_lb_timestart_jadwal").disabled = true;
    document.getElementById("ep_lb_timeend_jadwal").disabled = true;
}
function enableForm() {
    document.getElementById("ep_lb_timestart").disabled = false;
    document.getElementById("ep_lb_timeend").disabled = false;
    document.getElementById("ep_lb_kegiatan").disabled = false;
    document.getElementById("lb_SPV").disabled = false;
    document.getElementById("ep_lb_timestart_jadwal").disabled = false;
    document.getElementById("ep_lb_timeend_jadwal").disabled = false;
}
function headerDisableForm() {
    document.getElementById("lb_IDTransaksi").disabled = true;
    document.getElementById("lb_tgl_logbook").disabled = false;
    document.getElementById("lb_Lokasi").disabled = true;
}
// add tim by lbid 
function AddTempLBByID() {
    var IdMou = document.getElementById("lb_IdMOu").value;
    var lb_SPV = document.getElementById("lb_fleksibel_tim").value;
    var kodeLB = $("#lb_IDTransaksi").val();
    var base_url = window.location.origin;
    $.ajax({ 
        "url": base_url + '/pms_gut/public/LogBook/AddTempLBByID/',
        type: "POST",
        data: "IdMou=" + IdMou + "&lb_SPV=" + lb_SPV + "&kodeLB=" + kodeLB,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            ShowlistTeamsBySPV();
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
// showlisttimbyspvtrs
function ShowlistTeamsBySPV() {
    $(".preloader").fadeIn();
    var IdMou = document.getElementById("lb_IdMOu").value;
    var lb_SPV = document.getElementById("lb_fleksibel_tim").value;
    var kodeLB = $("#lb_IDTransaksi").val();
    var title = 'Jadwal Absensi';
    $('#tblx_team').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tblx_team').DataTable({
        "paging": true,
        "order": [[2, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": { 
            "url": base_url + '/pms_gut/public/LogBook/ShowlistTeamsBySPV/',
            "type": "POST",
            data: function (d) {
                d.IdMou = IdMou;
                d.lb_SPV = lb_SPV;
                d.kodeLB = kodeLB;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""

                    var html = '<span class="badge badge-secondary" onclick="delTempLB(' + row.id + ')"><font size="1">' + row.Nip + ' </font></span>'
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.IsPermanen == 2) {
                        var html = ""
                        var html = '<font size="2">' + row.Nama + '<br><span class="badge badge-primary" style="background-color:#e39696;">PERMANEN</span></font> ';
                        return html
                    } else if (row.IsPermanen == 1) {
                        var html = ""
                        var html = '<font size="2">' + row.Nama + '<br><span class="badge badge-primary" style="background-color:#00FF00;">TIDAK PERMANEN</span></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.Nama + ' </font> ';
                        return html
                    }

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
// add personel tim
function AddTempLBByIDByLuar() {
    swal({
        title: "Konfirmasi",
        text: "Anda Menambahkan Personil Baru Dari TIM lain, Apakah anda ingin lakukan Rotasi Permanen ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                const Status = "2";
                AddLuarEx(Status);
            } else {
                const Status = "1";
                AddLuarEx(Status);
            }
        });
}
function AddLuarEx(Status) {
    var kodeLB = $("#lb_IDTransaksi").val();
    var lb_fleksibel_timLuar = document.getElementById("lb_fleksibel_timLuar").value;
    var lb_fleksibel_tim = document.getElementById("lb_fleksibel_tim").value;
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/LogBook/AddTempLBByIDByLuar',
        type:   "POST",
        data:   "lb_fleksibel_timLuar=" + lb_fleksibel_timLuar + "&kodeLB=" + kodeLB + "&Status=" + Status +
                "&lb_fleksibel_tim=" + lb_fleksibel_tim,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            getPersonelOtherTeam();
            ShowlistTeamsBySPV();

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
// GET TIM TAMBAHAN DI LUAR TIM
function getPersonelOtherTeam() {
    var lb_IdMOu = document.getElementById("lb_IdMOu").value;
    var lb_SPV = document.getElementById("lb_SPV").value;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "lb_IdMOu=" + lb_IdMOu + "&lb_SPV=" + lb_SPV,
        url: base_url + '/pms_gut/public/LogBook/getPersonelOtherTeam',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $("#lb_fleksibel_timLuar").empty();
            var newRow = '<option value=""></option';
            $("#lb_fleksibel_timLuar").append(newRow);
            var elements = $();
            var dataarray = data.getTeamBySPVbyKontrak.length;
            for (i = 0; i < data.getTeamBySPVbyKontrak.length; i++) {
                var newRow = '<option value="' + data.getTeamBySPVbyKontrak[i].ID_Data + '">' + data.getTeamBySPVbyKontrak[i].NAMA_TIM + ' - ' + data.getTeamBySPVbyKontrak[i].Nama + '</option';
                $("#lb_fleksibel_timLuar").append(newRow);
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
// get TIM BY ID SPV BY MOU
function getTeamBySPVbyKontrak() {
    var xdi = document.getElementById("lb_IdMOu").value;
    var kodespv = document.getElementById("lb_SPV").value;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "lb_IdMOu=" + xdi + "&kodespv=" + kodespv,
        url: base_url + '/pms_gut/public/LogBook/getAllSPVbyMou',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $("#lb_fleksibel_tim").empty();
            var newRow = '<option value=""></option';
            $("#lb_fleksibel_tim").append(newRow);
            var elements = $();
            var dataarray = data.getTeamBySPVbyKontrak.length;
            for (i = 0; i < data.getTeamBySPVbyKontrak.length; i++) {
                var newRow = '<option value="' + data.getTeamBySPVbyKontrak[i].ID_Data + '">' + data.getTeamBySPVbyKontrak[i].NAMA_TIM + ' - ' + data.getTeamBySPVbyKontrak[i].TIM_DESCRIPTION + '</option';
                $("#lb_fleksibel_tim").append(newRow);
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
// GET SPV BY MOU
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
            var newRow = '<option value=""></option';
            $("#lb_SPV").append(newRow); 
            for (i = 0; i < data.getSPVbyKontrak.length; i++) {
                var newRow = '<option value="' + data.getSPVbyKontrak[i].ID_Data + '">' + data.getSPVbyKontrak[i].Nama + '</option';
                $("#lb_SPV").append(newRow);
            }
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
        }
    });
}
// GET_ENTRY_LOGBOOK
function getEntrylogBook() {
    var lb_Lokasi = $("#lb_Lokasi").val();
    var lb_Lokasi2 = $("#lb_Lokasi2").val();
    var lb_IdMOu = $("#lb_IdMOu").val();
    var lb_IDTransaksi = $("#lb_IDTransaksi").val();
    $('#tbl_lb_child1').DataTable().clear().destroy();
    var base_url = window.location.origin;
    $('#tbl_lb_child1').DataTable({
        "order": false, // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": { 
            "url": base_url + '/pms_gut/public/LogBook/getEntrylogBookbyCurrentDay/',
            "type": "POST",
            data: function (d) {
                d.lb_IDTransaksi = lb_IDTransaksi;
                d.lb_IdMOu = lb_IdMOu;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_START_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_END_JADWAL + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_START + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TIME_END + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<font size="1">' + row.NM_WBS + ' </font><br><br><span class="badge badge-secondary" onclick="shwFormLogBookDel(' + row.detil + ')"><font size="1">EDIT</font></span>';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_KEGIATAN + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.FS_REFF_PEGAWAI + '</font> ';
                    return html
                }
            },

        ],
    });


}
// GET MOU AKTIF BY ID
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
            console.log(data);
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
// GET MUO AKTIF
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

function LogTime() {
    var lb_IDTransaksi = $("#lb_IDTransaksi").val();
    var is_batal = $("#is_batal").val();
    var base_url = window.location.origin;
    if (is_batal == "1") {
        jQuery.ajax({
            type: "POST",
            url: base_url + '/pms_gut/public/LogBook/DeleteLogBookTransaction/',
            data: "lb_IDTransaksi=" + lb_IDTransaksi,
            cache: false,
            success: function (response) {

            }
        });
    }
}

function bataltrsLogbook(){
    var lb_IDTransaksi = $("#lb_IDTransaksi").val();
    var is_batal = $("#is_batal").val();
    var base_url = window.location.origin;
    jQuery.ajax({
        type: "POST",
        url: base_url + '/pms_gut/public/LogBook/DeleteLogBookTransaction/',
        data: "lb_IDTransaksi=" + lb_IDTransaksi,
        cache: false,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            if (data.status == "warning") {
                //swal(data.errorname);
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
                $("#is_batal").val('0'); 
                window.onbeforeunload = null;
                $(".preloader").fadeOut();
                location.reload();
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
function finishTransaksi() {
    var base_url = window.location.origin;
    var lb_IDTransaksi = $("#lb_IDTransaksi").val();
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST 
        url: base_url + '/pms_gut/public/LogBook/finishLogBookTrs/',
        data: "lb_IDTransaksi=" + lb_IDTransaksi,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            if (data.status == "warning") {
                //swal(data.errorname);
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
                $("#is_batal").val('0');
                window.onbeforeunload = null;
                location.reload();
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