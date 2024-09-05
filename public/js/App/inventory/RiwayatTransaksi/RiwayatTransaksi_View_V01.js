$(document).ready(function () {
    $(".preloader").fadeOut(); 
    asyncShowMain();

    getListDataOrderDetails();

    $('#btn_cetakresep').click(function () {
        CetakResep();
    });

    $('#btn_copyresep').click(function () {
        CopyResep();
    });

    $('#btn_cetaklabelall').click(function () {
        CetakLabelAll();
    });

    $('#Save_Signa').click(function () {
        goSaveSigna();
    });

});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        /*
        if ($("#IdAuto").val() != ''){ // if edit
            const datagetDatabyID = await getDatabyID();
            updateUIdatagetDatabyID(datagetDatabyID);
        }else{
            document.getElementById("labeledit").style.display = 'none';
            $("#TglMasuk").val(getDateNow);
            $("#JamMasuk").val(getTimeNow);
            $("#TglMasuk").attr('readonly', false);
            $("#JamMasuk").attr('readonly', false);
            $(".preloader").fadeOut(); 
        }
        */

    
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
         //await getRoomID(dataresponse.data.IDKelas);
         //await getBedID(dataresponse.data.RoomName);
        $("#NamaPasien").val(convertEntities(dataresponse.data.PatientName));
        $("#NoMR").val(convertEntities(dataresponse.data.NoMR));
        $("#NoRegistrasi").val(convertEntities(dataresponse.data.NoRegistrasi));
        $("#TanggalLahir").val(convertEntities(dataresponse.data.DOB));
        $("#Dokter").val(convertEntities(dataresponse.data.NamaDokter));
        $("#Unit").val(convertEntities(dataresponse.data.NamaUnit));
        $("#Iter").val(convertEntities(dataresponse.data.Iter));
        $("#IterRealisasi").val(convertEntities(dataresponse.data.IterRealisasi));
        $("#Apoteker").val(convertEntities(dataresponse.data.Apoteker));
        $("#JenisResep").val(convertEntities(dataresponse.data.JenisResep));
        $("#TglResep").val(convertEntities(dataresponse.data.tglorder));
        $("#judul").html(dataresponse.data.judul);
        $("#FreeText").val(convertEntities(dataresponse.data.Text));
        $("#HasilReviewFreeText").val(convertEntities(dataresponse.data.HasilReviewResep));

        //border
        if (dataresponse.data.judul == 'Rawat Inap'){
            $('#border').addClass('border-ranap');
        }else if (dataresponse.data.judul == 'Rawat Jalan'){
            $('#border').addClass('border-rajal');
        }else if (dataresponse.data.judul == 'Walkin'){
            $('#border').addClass('border-walkin');
        }else if (dataresponse.data.judul == 'Penjualan Bebas'){
            $('#border').addClass('border-bebas');
        }
        
        $('#statusreg').html(dataresponse.data.StatusReg);
        if (dataresponse.data.statusid == '0'){
            var badge = 'success';
        }else if(dataresponse.data.statusid == '1'){
            var badge = 'info';
        }else if(dataresponse.data.statusid == '2'){
            var badge = 'warning';
        }else if(dataresponse.data.statusid == '3'){
            var badge = 'danger';
        }else if(dataresponse.data.statusid == '4'){
            var badge = 'secondary';
        }else{
            var badge = 'default';
        }

        //Badge for Status if Penjualan Bebas
        if (dataresponse.data.NamaUnit == 'Penjualan Bebas'){
            if (dataresponse.data.statusid == '0'){
                var badge = 'success';
            }else if(dataresponse.data.statusid == '1'){
                var badge = 'warning';
            }else if(dataresponse.data.statusid == '2'){
                var badge = 'danger';
            }else if(dataresponse.data.statusid == '3'){
                var badge = 'secondary';
            }else if(dataresponse.data.statusid == '4'){
                var badge = 'secondary';
            }else{
                var badge = 'default';
            }
        }

        $(".preloader").fadeOut(); 
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoOrder=' + $("#NoOrder").val() 
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
            
        })
}

function getListDataOrderDetails() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var orderid = $("#NoOrder").val();
    $('#datadetail').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datadetail').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/Farmasi/getListDataOrderDetails", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.orderid = orderid
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                if (row.o_racikan == '1'){
                                    var html = '<font size="1" >'+row.otid+' - '+row.ProductType+' <br>(Jumlah Kemasan: ' +row.QtyOrderType+')</font>';
                                }else{
                                    var html = '<font size="1">'+row.otid+' - '+row.ProductType+'</font>';
                                }
                                    return html 
                            }
                        },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                   var html  = '<font color="#1E13F9">'+row.NamaObat+'</font '
                                     return html 
                              }
                          },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                            if (row.Dosis == null){
                                var dosis = '';
                            }else{
                                var dosis = row.Dosis;
                            }
                               var html  = '<font color="#BA25C5">'+dosis+'</font> '
                                 return html 
                          }
                      },
                            { "data": "KekuatanDosis" },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                if (row.Signa == null){
                                    var signa = "";
                                }else{
                                    var signa = row.Signa;
                                }
                                   var html  = '<font >'+signa+'</font><br><a class="btn btn-default btn-xs" onclick=\'EditSigna("' + row.ID + '","' + row.NamaObat + '","' + signa + '")\'  > Edit Signa</a>'
                                     return html 
                              }
                          },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                if (row.ED == null){
                                    var ed = '';
                                }else{
                                    var ed = row.ED;
                                }

                                   var html  = '<font color="#BA25C5">'+ed+'</font '
                                     return html 
                              }
                          },
                            { "data": "Note1" },
                            { "data": "Note2" },
                            { "data": "Quantity" },
                            { "data": "QtyRealisasi" },
                            // { "data": "UnitPrice" },
                            // { "data": "Discount" },
                            { "data": "TotalTarif" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' ) },
                        //     { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        //         var html = ""
                        //           if(row.Review == "0"){ 
                        //               var html  = '<span class="badge badge-danger">No</span> '
                        //           }else if(row.Review == "1"){ // Jika bukan 1
                        //               var html  = '<span class="badge badge-success">Yes</span> '
                        //           }else{ // Jika bukan 1
                        //            var html  = '<span>Unknown</span> '
                        //        }
                        //              return html 
                        //       }
                        //   },
                        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                            var html2 = ""
                            var html3 = ""
                            var html4 = ""

                            //var html3 = '<input name="namasatelit" id="namasatelit" value="'+row.NamaSatelit+'" readonly></input>'
                            var html3 = '<td>'+row.NamaSatelit+'</td>'
                           var html4 = '<a class="btn btn-info btn-xs" onclick=\'CetakLabel("' + row.ID + '")\'  > Cetak Label</a>'
                            //var html4 = ''

                            if(row.UDD == "0"){ 
                                var html2  = '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" onclick="return false;"> UDD &nbsp'
                            }else if(row.UDD == "1"){ // Jika bukan 1
                                var html2  = '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" onclick="return false;" checked> UDD'
                            }

                              if(row.Review == "0"){ 
                                  var html  = '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" onclick="return false;"> direview'
                              }else if(row.Review == "1"){ // Jika bukan 1
                                  var html  = '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" onclick="return false;" checked> direview'
                              }
                                 return html3+'<br>'+html+'&nbsp'+html2+html4
                          }
                      },
                           ],
     });
} 

function EditSigna(id_detail,namaobat,signa){
    $("#modal_editsigna").modal('show');
    $("#id_detail").val(id_detail);
    $("#namaobat_signa").val(namaobat);
    $("#Signa_edit").val(signa);
}

async function goSaveSigna() {
    try {
        const datagoSaveSigna = await goSaveSigna2();
        updateUIdatagoSaveSigna(datagoSaveSigna);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagoSaveSigna(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getListDataOrderDetails();
        $("#modal_editsigna").modal('hide');
    }else{
        toast(response.message, "error")
    }  

}

function goSaveSigna2() {
    var data = $("#form_editsigna").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/EditSigna';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  data 
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


function CetakResep(){
    var notrs = $("#NoOrder").val(); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/Farmasi/CetakResep/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function CopyResep(){
    var notrs = $("#NoOrder").val(); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/Farmasi/CopyResep/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function CetakLabel(iddetail){
    var notrs = iddetail; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/Farmasi/CetakLabel/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

// async function CetakLabel(iddetail) {
//     try {
//         const data = await goCetakLabel(iddetail);
//         updateUIdataLabel(data);
//     } catch (err) {
//         toast(err.message, "error")
//     }
// }

function updateUIdataLabel(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        // swal({
        //     title: "Simpan Berhasil!",
        //     text: response.message,
        //     icon: "success",
        // })
    }else{
        toast(response.message, "error")
    }  

}

function goCetakLabel(iddetail) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/CetakLabel';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "iddetail="+iddetail 
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

async function CetakLabelAll() {
    try {
        const data = await goCetakLabelAll();
        updateUIdataLabelAll(data);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataLabelAll(params) {
    let response = params;
    if (response.status == "success") {
        //toast(response.message, "success")
        // swal({
        //     title: "Simpan Berhasil!",
        //     text: response.message,
        //     icon: "success",
        // })
    }else{
        toast(response.message, "error")
    }  

}

function goCetakLabelAll() {
    var orderid = $("#NoOrder").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/CetakLabelAll';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "orderid="+orderid 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            //console.log(response.status);return false;
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



function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
    }

// Primary function always
function toast(data, status) {
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
    toastr[status](data);
}