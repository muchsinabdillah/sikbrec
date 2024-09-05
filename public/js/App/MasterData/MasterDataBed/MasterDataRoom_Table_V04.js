$(document).ready(function () {
    console.log("CCCCCCCCCCCCCCC")
    $(".preloader").fadeOut();
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(20);
    await loadtabel();
}
function loadtabel() {
    const base_url = window.location.origin;
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataRoom/getAllDataRoom",
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
                    var html = '<font size="1"> ' + row.CLASS_ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.LANTAI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ROOM + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.BED + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"   onclick=\'showDataGroupShift("' + row.RoomID + '")\'><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.BRIDGE_BPJS == "0") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" onclick=\'sendBPJS("' + row.RoomID + '")\'>Send Data Room<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled next-btn"  onclick=\'cancelsendBPJS("' + row.RoomID + '")\'>Hapus Data Room<span class="btn-label btn-label-right"><i class="fa fa-times"></i></span></button>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
 
                        var html = ""
                    var html = '<button type="button" class="btn btn-primary btn-xs btn-labeled" onclick=\'sendBPJSUpdate("' + row.RoomID + '")\'>Update Kapasitas Bed<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                     
                }
            },
        ]
    });
}
function loadtabelbyLantai() {
    const base_url = window.location.origin;
    $(".preloader").fadeIn();
    var LantaiID = $("[name='LantaiID']").val();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataRoom/getAllDataRoomByLantai",
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
                    var html = '<font size="1"> ' + row.CLASS_ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.LANTAI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ROOM + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.BED + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"   onclick=\'showDataGroupShift("' + row.RoomID + '")\'><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    if (row.BRIDGE_BPJS == "0") {
                        var html = ""
                        var html = '<button type="button" class="btn btn-success btn-xs btn-labeled" onclick=\'sendBPJS("' + row.RoomID + '")\'>Send Data Room<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                    } else {
                        var html = ""
                        var html = '<button type="button" class="btn btn-danger btn-xs btn-labeled next-btn"  onclick=\'cancelsendBPJS("' + row.RoomID + '")\'>Hapus Data Room<span class="btn-label btn-label-right"><i class="fa fa-times"></i></span></button>';
                        return html
                    }
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi

                    var html = ""
                    var html = '<button type="button" class="btn btn-primary btn-xs btn-labeled" onclick=\'sendBPJSUpdate("' + row.RoomID + '")\'>Update Kapasitas Bed<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                    return html

                }
            },
        ]
    });
    $(".preloader").fadeOut();
}
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataRoom/viewRoom/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataRoom/viewRoom/";
}
function sendBPJSUpdate(params) {
    var dataId = params;
    console.log("idauto", dataId)
    swal({
        title: "Bridging BPJS",
        text: "Apakah Anda ingin Lakukan Update Ketersediaan Tempat Tidur Ke BPJS Aplicares ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                PrepareSendBPJSUpdate(dataId);
            } else {
                // swal("Transaction Rollback !");
            }
        }); 
}
function sendBPJS(params) {
    var dataId = params;
    console.log("idauto", dataId)
    swal({
        title: "Batal Bridging BPJS",
        text: "Apakah Anda ingin Kirim Data Ke BPJS Aplicares ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) { 
                PrepareSendBPJS(dataId);
            } else {
                // swal("Transaction Rollback !");
            }
        }); 
}
function cancelsendBPJS(params) {
    var dataId = params;
    console.log("idauto", dataId)
    swal({
        title: "Batal Bridging BPJS",
        text: "Apakah Anda ingin Kirim Data Ke BPJS Aplicares ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                PrepareSendBPJSDel(dataId);
            } else {
                // swal("Transaction Rollback !");
            }
        });
}
async function PrepareSendBPJSDel(params) {
    try {
        var idauto = params;
        console.log("idauto2", idauto)
        const result = await GosendBPJSBatal(idauto);
        updateUIGosendBPJS(result);
        loadtabel();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function GosendBPJSBatal(dataId) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/GosendBPJSBatal';
    // data form 
    var IdAuto = dataId;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })

}
async function PrepareSendBPJS(params) {
    try {
        var idauto = params;
        console.log("idauto2", idauto)
        const result = await GosendBPJS(idauto);
        updateUIGosendBPJS(result);
        loadtabel();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
async function PrepareSendBPJSUpdate(params) {
    try {
        var idauto = params;
        console.log("idauto2", idauto)
        const result = await GosendBPJSUpdate(idauto);
        updateUIGosendBPJSupdate(result);
        loadtabel();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUIGosendBPJSupdate(params) {
    swal('Good job!', 'BPJS Bridging - ' + params.message + " !", "success")
        .then((value) => {
            Location.reload();
        });
}
function updateUIGosendBPJS(params) {
    swal('Good job!', 'BPJS Bridging - '+params.message + " !", "success")
        .then((value) => {
          Location.reload();
        });
}
function GosendBPJSUpdate(dataId) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/GosendBPJSUpdate';
    // data form 
    var IdAuto = dataId;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })

}
function GosendBPJS(dataId) {
    $(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/GosendBPJS';
    // data form 
    var IdAuto = dataId; 
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })

}