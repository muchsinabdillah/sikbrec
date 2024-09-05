$(document).ready(function () {
    //$(".preloader").fadeOut();
    asyncShowMain(); 

    $('#btnSave').click(function () {
        $("#Modal_Approve").modal('show');
    });

        $("#nopin").keyup(function(event) {
            if (event.keyCode === 13) {
                goGetApproveName();
            }
        });


    // $('#pr_btn_batal').click(function () {

    //     swal("Alasan Batal:", {
    //         content: "input",
    //         buttons: true,
    //     })
    //         .then((value) => {
    //             if (value == '') {
    //                 swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
    //                 return false;
    //             } else if (value == null) {
    //                 return false;
    //             }
    //             // swal(`You typed: ${value}`);
    //             goVoidPurchaseRequisition(value);
    //         });

    // });
    
    
});


//BACKUP VOID APPROVE
// async function goVoidPurchaseRequisition(param) {
//     try {
//         const dtax = await goVoidPurchaseRequisition2(param);
//         updateUIdatagoVoidPurchase(dtax);
//     } catch (err) {
//         toast(err, "error")
//     }
// }
// function updateUIdatagoVoidPurchase(params) {
//     if (params.status === true) { 
//         toast(params.message, "success")
//         MyBack();
//     } else {
//         toast(params.message, "error")
//     }
// }
// function goVoidPurchaseRequisition2(param) {
//     var base_url = window.location.origin; 
//     var TransasctionCode = document.getElementById("IdAuto").value;
//     var Void = "1"; 
//     let url = base_url + '/SIKBREC/public/PurchaseForm/voidPurchaseRequisition/';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: 'TransasctionCode=' + TransasctionCode 
//             + '&Void=' + Void 
//             + '&AlasanBatal=' + param
//     })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(response.statusText)
//             }
//             return response.json();
//         })
//         .then(response => {
//             if (response.status === "error") {
//                 throw new Error(response.message.errorInfo[2]);
//                 // console.log("ok " + response.message.errorInfo[2])
//             } else if (response.status === "warning") {
//                 throw new Error(response.errorname);
//                 // console.log("ok " + response.message.errorInfo[2])
//             }
//             return response
//         })
//         .finally(() => {
//             $(".preloader").fadeOut();
//         })
// }
async function goSaveApprove() {
    try {
        const dataSaveApprove = await SaveApprove();
        updateUIdataSaveApprove(dataSaveApprove);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataSaveApprove(params) {
    if(params.status === true){
        toast(params.message, "success")
        swal({
            title: 'Success',
            text: params.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    }else{
        toast(params.message, "error")
    }
}
function SaveApprove() {
    var base_url = window.location.origin;
    //var nopin = $("#nopin").val();
    var nopin_ext = $("#nopin_ext").val();
    var no_trs = $("#IdAuto").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/SaveApprovePR/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'no_trs=' + no_trs +
              '&nopin_ext=' + nopin_ext
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

async function goGetApproveName() {
    try {
        const dataGetApproveName = await GetApproveName();
        updateUIdataGetApproveName(dataGetApproveName);
    } catch (err) {
        toast(err, "error")
        $("#nama_ext").val('');
        $("#nopin_ext").val('');
        var parent = $('embed#file').parent();
        var newElement = "<embed src='' id='file'>";
        $('embed#file').remove();
        parent.append(newElement);
    }
}
function updateUIdataGetApproveName(params) {
        //toast(params.message, params.status);

        if (params.data.FileDocument == null){
            toast('Tanda Tangan Tidak Ditemukan !', 'warning');
        }else{
            $("#nama_ext").val(params.data.username);
            $("#nopin_ext").val(params.data.NoPIN);
            var parent = $('embed#file').parent();
            var newElement = "<embed src='"+params.data.FileDocument+"' id='file'>";
            $('embed#file').remove();
            parent.append(newElement);
            toast('No PIN Berhasil dan Tanda Tangan Ditemukan !', 'success');
            $("#btnSearching").focus();
        }
       
}
function GetApproveName() {
    var base_url = window.location.origin;
    var nopin = $("#nopin").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/GetApproveName/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'nopin=' + nopin 
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


async function createHeaderTrs() {
    try {
        const dataGocreateHdr = await GocreateHdr();
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}
async function asyncShowMain() {
    try {
        $(".preloader").fadeIn();
        //await getHakAksesByForm(12); 
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#IdAuto").val();
        //disableAll();
        if (id != ""){
            const dataGetPurchasebyId = await GetPurchasebyId();  
            updateUIdataGetPurchasebyId(dataGetPurchasebyId); 
            showDataDetil();
            //enableAll();
        }
        $(".preloader").fadeOut();
       
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetPurchasebyId(params) {
    if(params.status === true ){
        console.log("params.status", params.data[0].Approved);
        var tgltrs = params.data[0].TransasctionDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        console.log(d.toISOString());
        $('#pr_TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));

        // $('#pr_TglTransaksi').val(params.data[0].TransasctionDate);
        $('#pr_userEntriCode').val(params.data[0].UserCreate);
        $('#pr_userEntri').val(params.data[0].NamaUserCreate);
        $('#pr_status').val(params.data[0].StatusPR); 
        $('#pr_unitTrnasaksi').val(params.data[0].Unit).trigger('change');
        $('#pr_jenistransaksi').val(params.data[0].Type).trigger('change');
        $('#pr_ketTransaksi').val(params.data[0].Notes);

        if (params.data[0].StatusPR == 'APPROVED'){
            $("#btnSave").attr('disabled', true);
        }else{
            $("#btnSave").attr('disabled', false);
        }
    }else{
        toast(params.message,"error")
    }
}
function GetPurchasebyId() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode 
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
            //$(".preloader").fadeOut();
        })
}
function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#pr_unitTrnasaksi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#pr_unitTrnasaksi").append(newRow);
        }
    }
}
function GetLayanan() {
    var base_url = window.location.origin; 
 
    let url = base_url + '/SIKBREC/public/MasterDataUnit/getAllDataUnit';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        } 
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
            $("#pr_unitTrnasaksi").select2();
        })
}

// function disableAll() { 
//     document.getElementById("pr_status").disabled = true;  
//     document.getElementById("xNamaBarang").disabled = true;
//     document.getElementById("xIdBarang").disabled = true;
//     document.getElementById("qty_Barang").disabled = true; 
//     document.getElementById("SatuanBarang").disabled = true;
//     $("#pr_btnAdd").attr('disabled', true);
//     $("#pr_btn_kembali").attr('disabled', true);
//     $("#pr_btn_batal").attr('disabled', true);
//     $("#pr_btnSave").attr('disabled', true); 
//     $("#nama_Barang").attr('disabled', true);
//     $("#qty_Barang").attr('disabled', true);
// }
// function enableAll() {
//     document.getElementById("pr_TglTransaksi").disabled = false;
//     document.getElementById("pr_status").disabled = false;
//     document.getElementById("pr_jenistransaksi").disabled = false;
//     document.getElementById("pr_unitTrnasaksi").disabled = false;
//     document.getElementById("pr_ketTransaksi").disabled = false;
//     document.getElementById("xNamaBarang").disabled = false;
//     document.getElementById("xIdBarang").disabled = false;
//     document.getElementById("qty_Barang").disabled = false;
//     document.getElementById("SatuanBarang").disabled = false;
//     $("#pr_btnAdd").attr('disabled', false);
//     $("#pr_btn_kembali").attr('disabled', false);
//     $("#pr_btn_batal").attr('disabled', false);
//     $("#pr_btnSave").attr('disabled', false);
//     $("#nama_Barang").attr('disabled', false);
//     $("#qty_Barang").attr('disabled', false);
    
// }



function updateUIdataGocreateHdr(dataResponse) {
    console.log("dataResponse", dataResponse);
    $('#IdAuto').val(dataResponse);
    $("#btnNewPurchase").attr('disabled', true);
    enableAll();
}
function GocreateHdr() {
    var base_url = window.location.origin;
    var  date  = document.getElementById("pr_TglTransaksi").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var Type = document.getElementById("pr_jenistransaksi").value; 
    var Unit = document.getElementById("pr_unitTrnasaksi").value;
    var pr_ketTransaksi = document.getElementById("pr_ketTransaksi").value; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/createHeaderTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionDate=' + TransasctionDate  
            + '&Type=' + Type
            + '&Unit=' + Unit
            + '&Notes=' + pr_ketTransaksi
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/InventoryApprove/ListApprovePR";
} 

function showDataDetil() {
    var TransasctionCode = document.getElementById("IdAuto").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionDetailbyID/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.TransasctionCode = TransasctionCode; 
            }
        },
        "columns": [
        
            
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductCode + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ProductName + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Satuan + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.QtySafe + '</font>  ';
                    return html
                }
            },
             
            { "data": "QtyPR", render: $.fn.dataTable.render.number('.', ',', 2, '') },  // 

        ], 
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
         

            total15 = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 

            $(api.column(5).footer()).html(
                $.fn.dataTable.render.number('.', ',', 2, '').display(total15)
            );
            
             
        },


    });
    //$(".preloader").fadeOut();
} 

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