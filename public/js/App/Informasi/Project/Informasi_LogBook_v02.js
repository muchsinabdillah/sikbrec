$(document).ready(function () {
    $(".preloader").fadeOut();
    getMou();
    $("#tbl_detil").hide();
    $('#tbl_info_logbook_detil').DataTable().clear().destroy();
    $('#tbl_info_logbook_rekap').DataTable().clear().destroy();
    //disableForm(); 
    //getdataTools();
    $(document).on('click', '#btn_Info', function () {
        $(".preloader").fadeIn();
        var Info_Tipe = document.getElementById("Info_Tipe").value;
            if(Info_Tipe =="1"){
                $("#tbl_detil").hide();
                $("#tbl_rekap").show();
                $('#tbl_info_logbook_detil').DataTable().clear().destroy();
                informationRekap();
            }else if (Info_Tipe == "2") {
                $("#tbl_rekap").hide();
                $("#tbl_detil").show();
                $('#tbl_info_logbook_rekap').DataTable().clear().destroy();
                informationdetil();
            } 
        $(".preloader").fadeOut();
         
    });
});
function informationdetil() {
    var base_url = window.location.origin;
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var Info_Client = document.getElementById("Info_Client").value;
    var Info_SPV = document.getElementById("Info_SPV").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var base_url = window.location.origin;
    $('#tbl_info_logbook_detil').DataTable().clear().destroy();
    $('#tbl_info_logbook_detil').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoLogBook/getInformationLBDetil/',
            "type": "POST",
            data: function (d) {
                d.Info_Tipe = Info_Tipe;
                d.Info_Client = Info_Client;
                d.Info_SPV = Info_SPV;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
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
                    var html = '<font size="2"> ' + row.KD_MOU + '</font> ';
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
                    var html = '<font size="2"> ' + row.TGL_ENTRY + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_TIM + '</font> ';
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
                    var html = '<font size="2"> ' + row.Nama + '</font> ';
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
                    var html = '<font size="2"> ' + row.ID_WBS + '</font> ';
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
                    var html = '<font size="2"> ' + row.FS_KEGIATAN + '</font> ';
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
        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            {
                extend: 'excelHtml5'
            },
            'print',
            'csv'
        ]
    });
}
function informationRekap() {
    var base_url = window.location.origin;
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var Info_Client = document.getElementById("Info_Client").value;
    var Info_SPV = document.getElementById("Info_SPV").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val(); 
    var base_url = window.location.origin;
    $('#tbl_info_logbook_rekap').DataTable().clear().destroy();
    $('#tbl_info_logbook_rekap').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoLogBook/getInformationLBRekap/',
            "type": "POST",
            data: function (d) { 
                d.Info_Tipe = Info_Tipe;
                d.Info_Client = Info_Client;
                d.Info_SPV = Info_SPV;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
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
                    var html = '<font size="2"> ' + row.KD_MOU + '</font> ';
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
                    var html = '<font size="2"> ' + row.TGL_ENTRY + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_TIM + '</font> ';
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
                    var html = '<font size="2"> ' + row.NAMA_SPV + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STAFF + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID_WBS + '</font> ';
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
                    var html = '<font size="2"> ' + row.FS_KEGIATAN + '</font> ';
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
        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            {
                extend: 'excelHtml5'
            },
            'print',
            'csv'
        ]
    });
}
function getAllSPVbyKontrak() {
    var xdi = document.getElementById("Info_Client").value;
    var base_url = window.location.origin;
    $("#Info_SPV").empty();
    $.ajax({
        type: "POST",
        data: "id=" + xdi,
        url: base_url + '/pms_gut/public/LogBook/getAllSPVbyKontrak',
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.getSPVbyKontrak !== null && data.getSPVbyKontrak !== undefined) {
                var newRow = '<option value=""></option';
                $("#Info_SPV").append(newRow);
                for (i = 0; i < data.getSPVbyKontrak.length; i++) {
                    var newRow = '<option value="' + data.getSPVbyKontrak[i].ID_Data + '">' + data.getSPVbyKontrak[i].Nama + '</option';
                    $("#Info_SPV").append(newRow);
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
// show data mou
function getMou() {
    var xdi = "2";
    var base_url = window.location.origin;
    $("#Info_Client").empty();
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/LogBook/getDataMouAktif',
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.getMou !== null && data.getMou !== undefined) {
                var newRow = '<option value=""></option';
                $("#Info_Client").append(newRow); 
                for (i = 0; i < data.getMou.length; i++) {
                    var newRow = '<option value="' + data.getMou[i].KODE_TRANSAKSI + '">' + data.getMou[i].KD_JO + ' - ' + data.getMou[i].NM_PROJECT + '</option';
                    $("#Info_Client").append(newRow);
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
        }
    });
}