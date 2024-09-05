$(document).ready(function () {
    asyncShowMain();
    // format number to price
    //convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveTrs();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })

    // const saveButtonx = document.querySelector('#btnSave');
    // saveButtonx.addEventListener('click', async function () {
    //     try {
    //         const result = await saveTarifAddLayanan();
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             //setTimeout(function () { MyBack(); }, 1000);
    //             asyncShowMain();
    //         }

    //     } catch (err) {

    //         toast(err, "error")
    //     }
    // })

    $('#btnbatal').click(function () {
        if($("#IdAuto").val() == ''){
            swal("Oops", "ID Transaksi Tidak Ditemukan", "warning");
            return false;
        }
            swal("Alasan Batal:", {
                content: "input",
                buttons:true,
              })
              .then((value) => {
                  if (value == '' ){
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                  }else if (value == null){
                    return false;
                  }
               goBatalTrs(value);
              });
    });

    // $(document).ready(function () { 
    // var getUrl = window.location;
    // var baseUrl2 = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    //     $('#form_import').submit(
    //         function (e) {
    //             var base_url = window.location.origin;
    //             var form_data = new FormData(); 
    //             form_data.append("file", $('input[type=file]')[0].files[0]); 
    //             form_data.append("IdAuto", $("#IdAuto").val());
    //             $.ajax({
    //                 url: baseUrl2 + '/public/MasterDataTarif/ImportFile/',
    //                 type: 'POST',
    //                 data: form_data,
    //                 processData: false,
    //                 contentType: false,
    //                 dataType: "JSON",
    //                 beforeSend: function () {
    //                     $(".preloader").fadeIn();
    //                 },
    //                 success: function (data) {
    //                     $(".preloader").fadeOut();
    //                     swal({
    //                         title: "Success",
    //                         text: data.message,
    //                         icon: "success",
    //                     })
    //                         .then((willDelete) => {
    //                             if (willDelete) {
    //                                 location.reload();
    //                             } else {
    //                                 swal("Transaction Rollback !");
    //                             }
    //                         });
    //                 }, error: function (data) {
    //                     // Welcome notification
    //                     toastr.options = {
    //                         "closeButton": true,
    //                         "debug": false,
    //                         "newestOnTop": false,
    //                         "progressBar": false,
    //                         "positionClass": "toast-top-right",
    //                         "preventDuplicates": false,
    //                         "onclick": null,
    //                         "showDuration": "300",
    //                         "hideDuration": "1000",
    //                         "timeOut": "3500",
    //                         "extendedTimeOut": "1000",
    //                         "showEasing": "swing",
    //                         "hideEasing": "linear",
    //                         "showMethod": "fadeIn",
    //                         "hideMethod": "fadeOut"
    //                     }
    //                     toastr["error"](data.responseText);
    //                     $(".preloader").fadeOut();
    //                 }
    //             });
    //             e.preventDefault();
    
    //         }
    //     );
    // });

//     $('#form_import').on("submit", function(e){  
//         e.preventDefault(); //form will not submitted  
//         var base_url = window.location.origin;
//         var form_data = $("#form_import").serialize();
//         let url = base_url + '/SIKBREC/public/MasterDataTarif/ImportFile/';
//         $.ajax({  
//              url: url,  
//              method:"POST",  
//              data:new FormData(this),  
//              contentType:false,          // The content type used when sending data to the server.  
//              cache:false,                // To unable request pages to be cached  
//              processData:false,          // To send DOMDocument or non processed data file it is set to false  
//              success: function(data){  
//                 alert(data);
//              }  
//         })  
//    });

    // $('#btnimport').click(function () {
    //     //console.log(document.getElementById("file").files.length == 0);
    //     if(document.getElementById("file_import").files.length == 0){
    //         swal("Oops", "File Tidak Ditemukan ! Mohon Pilih File Terlebih Dahulu !", "warning");
    //         return false;
    //     }
    //     swal({
    //         title: "Import",
    //         text: "Apakah Anda ingin Import File ?",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                     goImport();
    //             } else {
    //                // swal("Transaction Rollback !");
    //             }
    //         });
    // });
    
    
});
async function asyncShowMain() {
    try {
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

       // getListDataOrderDetails();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatabyID(datagetDatabyID){
    let dataResponse = datagetDatabyID;

        //$("#IdAuto").val(convertEntities(dataResponse.data.ID_TR_TARIF));
        $("#TglEntry").val(convertEntities(dataResponse.data.TGL_ENTRY));
        $("#UserEntry").val(convertEntities(dataResponse.data.username));
        $("#Note").val(convertEntities(dataResponse.data.NOTE));
         $("#TglBerlaku").val(convertEntities(dataResponse.data.TglBerlaku));
         $("#TglExpired").val(convertEntities(dataResponse.data.TglExpired));
         $("#Status").val(convertEntities(dataResponse.data.BATAL));
         $("#TglBatal").val(convertEntities(dataResponse.data.TANGGAL_BATAL));
         $("#AlasanBatal").val(convertEntities(dataResponse.data.ALASAN));;
         $("#kd_instalasi").val(convertEntities(dataResponse.data.KD_INSTALASI));

}
function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getTransaksiTarifbyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val()
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

function saveTrs() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/saveTrs_Tarif/';
    var form_data = $("#form_cuti").serialize();
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        })
}


async function goBatalTrs(alasan) {
    try {
        const datagetBatalTrs = await getBatalTrs(alasan);
       updateUIdatagetBatalTrs(datagetBatalTrs);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetBatalTrs(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Batal Berhasil!",
            text: response.message,
            icon: "success",
        }).then(function() {
            MyBack();
        });
    }else{
        toast(response.message, "error")
    }  

}
function getBatalTrs(alasan) {
    var str = $("#form_cuti").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/BatalTransaksiTarif/"';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str  + '&alasan=' + alasan
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

// async function goImport() {
//     try {
//         const datagetImportFile = await getImportFile();
//        updateUIdatagetImportFile(datagetImportFile);
//     } catch (err) {
//         toast(err, "error")
//     }
// }

// function updateUIdatagetImportFile(params) {
//     let response = params;
//     if (response.status == "success") {
//         toast(response.message, "success")
//         swal({
//             title: "Batal Berhasil!",
//             text: response.message,
//             icon: "success",
//         }).then(function() {
//             MyBack();
//         });
//     }else{
//         toast(response.message, "error")
//     }  

// }
// function getImportFile() {
//     var str = $("#form_import").serialize();
//     var idtrs = $("#IdAuto").val();
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/MasterDataTarif/ImportFile/"';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: str  //+ '&idtrs=' + idtrs
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

// async function saveTarifAddLayanan() {

//     $(".preloader").fadeIn();
//     $('#btnSave').html('Please Wait...');
//     $('#btnSave').addClass('btn-danger');
//     document.getElementById("btnSave").disabled = true;
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/MasterDataTarif/addTarifLayanan';

//     // data form
//     //var form_data = $("#form_cuti").serialize();
//     var id_tarif = $("#IdAuto").val();
//     var id_layanan = $("#GrupPerawatan").val();
//     //console.log('sss');return false;
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: 'IdAuto=' + id_tarif + '&GrupPerawatan=' + id_layanan
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
//             $('#btnSave').removeClass('btn-danger');
//             $('#btnSave').html('Submit');
//             document.getElementById("btnSave").disabled = false;
//         })

// }

// async function DeleteLayanan(idTarif_2){
//     let DataId = idTarif_2;
//     await GoDelete(DataId);
//     await getListDataOrderDetails();
// }

// function GoDelete(DataId){
//     $(".preloader").fadeIn();
//     $('#btnSave').html('Please Wait...');
//     $('#btnSave').addClass('btn-danger');
//     document.getElementById("btnSave").disabled = true;
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/MasterDataTarif/deleteTarifLayanan';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         }, 
//         body: 'id=' + DataId
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
//             $('#btnSave').removeClass('btn-danger');
//             $('#btnSave').html('Submit');
//             document.getElementById("btnSave").disabled = false;
//             toast('Item Berhasil Dihapus', "success")
//         })
// }

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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataTarif/listtransaksitarif";
}
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}