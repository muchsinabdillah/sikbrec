$(document).ready(function () {
    $(".preloader").fadeOut();
    $("#tbl_report2").hide(); 
    $("#tbl_report3").hide();
    $("#tbl_report4").hide(); 

    getMou();  
    $(document).on('click', '#btn_Info', function () {
        $(".preloader").fadeIn();  
        var Info_Tipe = document.getElementById("Info_Tipe").value;
        if (Info_Tipe == "1") {
            $("#tbl_report2").hide();
            $("#tbl_report3").hide();
            $("#tbl_report4").hide(); 
            $("#tbl_report1").show(); 
            $('#tbl_report2').DataTable().clear().destroy();
            $('#tbl_report3').DataTable().clear().destroy();
            $('#tbl_report4').DataTable().clear().destroy();
            informationRekap();
            informationRekap_footer();
        } else if (Info_Tipe == "2") {
            $("#tbl_report3").hide();
            $("#tbl_report1").hide();
            $("#tbl_report4").hide(); 
            $("#tbl_report2").show(); 
            $('#tbl_report1').DataTable().clear().destroy();
            $('#tbl_report3').DataTable().clear().destroy();
            $('#tbl_report4').DataTable().clear().destroy();
            informationRekap2();
            informationRekap2_footer();
        } else if (Info_Tipe == "3") {
            $("#tbl_report2").hide();
            $("#tbl_report1").hide();
            $("#tbl_report3").show();
            $("#tbl_report4").hide();  
            $('#tbl_report1').DataTable().clear().destroy();
            $('#tbl_report2').DataTable().clear().destroy();
            $('#tbl_report4').DataTable().clear().destroy();
            informationRekap3();
            informationRekap3_footer();
        } else if (Info_Tipe == "4") {
            $("#tbl_report2").hide();
            $("#tbl_report1").hide();
            $("#tbl_report3").hide();
            $("#tbl_report4").show();  
            $('#tbl_report1').DataTable().clear().destroy();
            $('#tbl_report2').DataTable().clear().destroy();
            $('#tbl_report3').DataTable().clear().destroy();
            informationRekap4();
            informationRekap4_footer();
        }
        $(".preloader").fadeOut(); 
    });
}); 
function informationRekap() { 
    var Info_Client = document.getElementById("kd_mou").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val(); 
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var Info_Date_StartKontrak = $("[name='Info_Date_StartKontrak']").val();
    var Info_Date_EndKontrak = $("[name='Info_Date_EndKontrak']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $('#tbl_report1').DataTable().clear().destroy();
    $('#tbl_report1').DataTable({
        "paging": false,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoProgressing/getInformationProgressing/',
            "type": "POST",
            data: function (d) {
                d.Info_Client = Info_Client; 
                d.lb_Lokasi = lb_Lokasi;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
                d.Info_Date_StartKontrak = Info_Date_StartKontrak;
                d.Info_Date_EndKontrak = Info_Date_EndKontrak;
                d.kd_mou = kd_mou;
                d.Info_Tipe = Info_Tipe;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER"){
                        var html = ""
                        var html = '<font size="2"><b>' + row.URUT + '</b></font> ';
                        return html
                    }else{
                        var html = ""
                        var html = '<font size="2"> ' + row.URUT + '</font> ';
                        return html
                    }
                    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_JO + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_JO + '</font> ';
                        return html
                    } 
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_MOU + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2">' + row.KD_MOU + '</font> ';
                        return html
                    }
                    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.WBS_NAME + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.WBS_NAME + '</font> ';
                        return html
                    } 
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_WBS + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_WBS + '</font> ';
                        return html
                    } 
                }
            },
            { "data": "QTY", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "QTY_PROGRESS_MATERIAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "QTY_PROGRESS_DIRECT_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "QTY_PROGRESS_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "QTY_PROGRESS_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRESS_UNIT_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRESS_UNIT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
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
function informationRekap_footer() { 
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val(); 
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $.ajax({ 
        url: base_url + "/pms_gut/public/InfoProgressing/getInformationProgressingFooter",
        type: "POST",
        data: "lb_Lokasi=" + lb_Lokasi + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End + "&kd_mou=" + kd_mou + "&Info_Tipe=" + Info_Tipe ,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            document.getElementById("total_material").innerHTML = "TOTAL PROG MATERIAL";
            document.getElementById("total_Progress").innerHTML = "TOTAL PROG DIRECT";
            document.getElementById("total_Progressunit").innerHTML = "TOTAL PROG UNIT";
            $("#tx_total_material").val(data.TOTAL_PROGRES_MATERIAL);
            $("#tx_total_Progress").val(data.TOTAL_PROGRES_DIRECT);
            $("#tx_total_Progressunit").val(data.TOTAL_PROGRESS_UNIT);
        }

    });
}
function informationRekap2_footer() {
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/InfoProgressing/getInformationProgressingFooter",
        type: "POST",
        data: "lb_Lokasi=" + lb_Lokasi + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End + "&kd_mou=" + kd_mou + "&Info_Tipe=" + Info_Tipe,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            document.getElementById("total_material").innerHTML = "TOTAL PROG WF MATERIAL";
            document.getElementById("total_Progress").innerHTML = "TOTAL PROG WF DIRECT";
            document.getElementById("total_Progressunit").innerHTML = "TOTAL PROG WF";
            $("#tx_total_material").val(data.PROGRES_WF_MATERIAL);
            $("#tx_total_Progress").val(data.PROGRES_WF_DIRECT);
            $("#tx_total_Progressunit").val(data.TOTAL_PROGRESS_WF);
        }

    });
}
function informationRekap2() {
    var Info_Client = document.getElementById("kd_mou").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var Info_Date_StartKontrak = $("[name='Info_Date_StartKontrak']").val();
    var Info_Date_EndKontrak = $("[name='Info_Date_EndKontrak']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $('#tbl_report2').DataTable().clear().destroy();
    $('#tbl_report2').DataTable({
        "paging": false,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoProgressing/getInformationProgressing/',
            "type": "POST",
            data: function (d) {
                d.Info_Client = Info_Client;
                d.lb_Lokasi = lb_Lokasi;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
                d.Info_Date_StartKontrak = Info_Date_StartKontrak;
                d.Info_Date_EndKontrak = Info_Date_EndKontrak;
                d.kd_mou = kd_mou;
                d.Info_Tipe = Info_Tipe;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.URUT + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.URUT + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_JO + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_JO + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_MOU + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2">' + row.KD_MOU + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.WBS_NAME + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.WBS_NAME + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_WBS + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_WBS + '</font> ';
                        return html
                    }
                }
            },
            { "data": "QTY", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "WF_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "WF_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_MATERIAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_DIRECT_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
             

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
function informationRekap3_footer() {
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/InfoProgressing/getInformationProgressingFooter",
        type: "POST",
        data: "lb_Lokasi=" + lb_Lokasi + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End + "&kd_mou=" + kd_mou + "&Info_Tipe=" + Info_Tipe,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            document.getElementById("total_material").innerHTML = "PAYMENT MATERIAL";
            document.getElementById("total_Progress").innerHTML = "PAYMENT DIRECT";
            document.getElementById("total_Progressunit").innerHTML = "PAYMENT TOTAL";
            $("#tx_total_material").val(data.PAYMENT_MATERIAL);
            $("#tx_total_Progress").val(data.PAYMENT_DIRECT);
            $("#tx_total_Progressunit").val(data.PAYMENT_TOTAL);
        }

    });
}
function informationRekap3() {
    var Info_Client = document.getElementById("kd_mou").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var Info_Date_StartKontrak = $("[name='Info_Date_StartKontrak']").val();
    var Info_Date_EndKontrak = $("[name='Info_Date_EndKontrak']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $('#tbl_report3').DataTable().clear().destroy();
    $('#tbl_report3').DataTable({ 
        "paging": false,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoProgressing/getInformationProgressing/',
            "type": "POST",
            data: function (d) {
                d.Info_Client = Info_Client;
                d.lb_Lokasi = lb_Lokasi;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
                d.Info_Date_StartKontrak = Info_Date_StartKontrak;
                d.Info_Date_EndKontrak = Info_Date_EndKontrak;
                d.kd_mou = kd_mou;
                d.Info_Tipe = Info_Tipe;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.URUT + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.URUT + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_JO + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_JO + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_MOU + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2">' + row.KD_MOU + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.WBS_NAME + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.WBS_NAME + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_WBS + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_WBS + '</font> ';
                        return html
                    }
                }
            },
            { "data": "QTY", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PRICE_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PRICE_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "GRAND_TOTAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_MATERIAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_DIRECT_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_TOTAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_TOTAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
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
function informationRekap4() {
    var Info_Client = document.getElementById("kd_mou").value;
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var Info_Date_StartKontrak = $("[name='Info_Date_StartKontrak']").val();
    var Info_Date_EndKontrak = $("[name='Info_Date_EndKontrak']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $('#tbl_report4').DataTable().clear().destroy();
    $('#tbl_report4').DataTable({
        "paging": false,
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/InfoProgressing/getInformationProgressing/',
            "type": "POST",
            data: function (d) {
                d.Info_Client = Info_Client;
                d.lb_Lokasi = lb_Lokasi;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
                d.Info_Date_StartKontrak = Info_Date_StartKontrak;
                d.Info_Date_EndKontrak = Info_Date_EndKontrak;
                d.kd_mou = kd_mou;
                d.Info_Tipe = Info_Tipe;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.URUT + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.URUT + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_JO + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_JO + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_MOU + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2">' + row.KD_MOU + '</font> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.WBS_NAME + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.WBS_NAME + '</font> ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.KET == "HEADER") {
                        var html = ""
                        var html = '<font size="2"><b>' + row.KD_WBS + '</b></font> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="2"> ' + row.KD_WBS + '</font> ';
                        return html
                    }
                }
            },
            { "data": "QTY", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PRICE_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PRICE_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "GRAND_TOTAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "WF_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "WF_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_MATERIAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_DIRECT_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_MATERIAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PAYMENT_DIRECT_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan 
            { "data": "PAYMENT_TOTAL_PREV", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_MATERIAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan
            { "data": "PROGRES_DIRECT", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan 
            { "data": "PAYMENT_TOTAL", render: $.fn.dataTable.render.number(',', '.', 2, '') },  // Tampilkan 

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
function informationRekap4_footer() {
    var Info_Date_Start = $("[name='Info_Date_Start']").val();
    var Info_Date_End = $("[name='Info_Date_End']").val();
    var lb_Lokasi = $("[name='lb_Lokasi']").val();
    var kd_mou = $("[name='kd_mou']").val();
    var Info_Tipe = document.getElementById("Info_Tipe").value;
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/InfoProgressing/getInformationProgressingFooter",
        type: "POST",
        data: "lb_Lokasi=" + lb_Lokasi + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End + "&kd_mou=" + kd_mou + "&Info_Tipe=" + Info_Tipe,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            document.getElementById("total_material").innerHTML = "PAYMENT MATERIAL";
            document.getElementById("total_Progress").innerHTML = "PAYMENT DIRECT";
            document.getElementById("total_Progressunit").innerHTML = "PAYMENT TOTAL";
            $("#tx_total_material").val(data.PAYMENT_MATERIAL);
            $("#tx_total_Progress").val(data.PAYMENT_DIRECT);
            $("#tx_total_Progressunit").val(data.PAYMENT_TOTAL);
        }

    });
}
// GET MOU AKTIF BY ID
function getMoubyID() {
    var xdi = document.getElementById("Info_Client").value;
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
            $("#lb_Lokasi").val(data.KD_JO); 
            $("#kd_mou").val(data.ID_MOU);
            $("#Info_NmProject").val(data.NM_KEGIATAN);
            $("#Info_NmLokasi").val(data.LOKASI_KERJA);
            $("#Info_NmProjectClient").val(data.NM_CLIENT);
            $("#Info_SM_Nama").val(data.Sm_name);
            $("#Info_Date_StartKontrak").val(data.DATE_START);
            $("#Info_Date_EndKontrak").val(data.DATE_END);
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