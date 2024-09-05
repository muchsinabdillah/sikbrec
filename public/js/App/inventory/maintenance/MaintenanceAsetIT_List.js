$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(18);
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MaintenanceAsetIT/showDataMaintenance",
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
                    var html = '<font size="1"> ' + row.Nama_Asset + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.DATE_TRANSACTION + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.USER_IT + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                
                    if (row.M_RAM == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_RAM + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_RAM + '</span>'
                    }
                    return html  
                }
            }, 
             {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                  
                     if (row.M_CLEANING == "YES") {
                         var html = ""
                         var html = '<span class="label label-success" > ' + row.M_CLEANING + '</span>'
                     } else {
                         var html = ""
                         var html = '<span class="label label-danger" > ' + row.M_CLEANING + '</span>'
                     }
                     return html  
                }
            }, 
             {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    
                     if (row.M_REPAIR_OS == "YES") {
                         var html = ""
                         var html = '<span class="label label-success" > ' + row.M_REPAIR_OS + '</span>'
                     } else {
                         var html = ""
                         var html = '<span class="label label-danger" > ' + row.M_REPAIR_OS + '</span>'
                     }
                     return html  
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                 
                    if (row.M_INSTAL_APP == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_INSTAL_APP + '</span>' 
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_INSTAL_APP + '</span>' 
                    }
                    return html  
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.M_SSD == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_SSD + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_SSD + '</span>'
                    }
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.M_CHARGER == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_CHARGER + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_CHARGER + '</span>'
                    }
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.M_LCD == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_LCD + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_LCD + '</span>'
                    }
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.M_ADAPTER == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_ADAPTER + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_ADAPTER + '</span>'
                    }
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.M_KEYBOARD == "YES") {
                        var html = ""
                        var html = '<span class="label label-success" > ' + row.M_KEYBOARD + '</span>'
                    } else {
                        var html = ""
                        var html = '<span class="label label-danger" > ' + row.M_KEYBOARD + '</span>'
                    }
                    return html
                }
            }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showMaintenance(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
        ]
    });
}
function showMaintenance(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MaintenanceAsetIT/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MaintenanceAsetIT/";
}