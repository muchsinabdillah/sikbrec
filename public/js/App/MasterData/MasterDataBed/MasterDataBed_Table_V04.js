$(document).ready(function () { 
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(21);
    await loadtabeldata();
}
function loadtabeldata() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBed/getAllDataBed",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.RoomID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Class + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.LANTAI == "TIDAK TERISI") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >' + row.LANTAI + '</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.LANTAI + ' </font>  ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Room + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Bad + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + number_to_price(row.TarifKamar) + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.BOR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.statusterpakai + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.statusaktif == "TIDAK") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >TIDAK</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" >YA</button>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Keterangan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.PUBLISHBPJS == "TIDAK") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >TIDAK</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" >YA</button>';
                        return html
                    }
                } 
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="showDataGroupShift(' + row.RoomID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function loadtabeldatabylantai() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    var LantaiID = $("[name='LantaiID']").val();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBed/getAllDataBedbyLantai",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.LantaiID = LantaiID;
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.RoomID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Class + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.LANTAI == "TIDAK TERISI") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >' + row.LANTAI + '</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.LANTAI + ' </font>  ';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Room + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Bad + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + number_to_price(row.TarifKamar) + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.BOR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.statusterpakai + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.statusaktif == "TIDAK") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >TIDAK</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" >YA</button>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Keterangan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.PUBLISHBPJS == "TIDAK") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled" >TIDAK</button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" >YA</button>';
                        return html
                    }
                } 
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="showDataGroupShift(' + row.RoomID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataBed/viewBed/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataBed/viewBed/";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}