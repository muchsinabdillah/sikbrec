$(document).ready(function () {
    $(".preloader").fadeIn();
    $('#datatable_pkt').dataTable({
    })
    asyncShowMain();
    //showDataDetil();
    // buton save ditekan
    // const saveButton = document.querySelector('#btnSave');
    // saveButton.addEventListener('click', async function () {
    //     try {
    //         const result = await saveGolongan();
    //         console.log(result);
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             setTimeout(function () { MyBack(); }, 1000);
    //         }

    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // })

    $('#btnPaket').click(function () {
        $("#btnPaket_modal").modal('show');
    });

    $('#btnNewPurchase').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Buat Transaksi Baru?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    createHeaderTrs();
                } else {
                    swal("Transaction Rollback !");
                }
            });
     });

    $('#btnAdd').click(function () {
        AddRow();
    });

    // $("#nama_Barang").select2({
    //     ajax: {
    //         url: function (params) {
    //             return window.location.origin + '/SIKBREC/public/PurchaseForm/getDataBarangbyName';
    //         },
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 searchTerm: params.term
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 3
    // });
    // //add bpjs
    // $('#nama_Barang').on('select2:select', function (e) {
    //     var data = e.params.data; 
    //     $("#xIdBarang").val(data.id);
    //     $("#xNamaBarang").val(data.text);

    //     getBarangbyId(data.id)
    // });

    $("#QtyOrder").keyup(function(event) {
        if (event.keyCode === 13) {
            AddRow();
        }
    });

    $('#btnSave').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goeditOrderMutasi();
                } else {
                    swal("Transaction Rollback !");
                }
            });

    });

    $('#btn_batal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                // swal(`You typed: ${value}`);
                goVoidHeader(value);
            });
    });

    $( "#nama_Barang" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: window.location.origin + "/SIKBREC/public/InfoStok/getStokBarangbyUnitNameLike",
            //url: window.location.origin + "/SIKBREC/public/PurchaseForm/getDataBarangbyName",
            dataType: "json",
            type: 'post',
            data: {
              searchTerm: request.term,
              grupBarang: $('#pr_jenistransaksi').val(),
              Unit: $('#LayananTujuanMutasi').val(),
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
            console.log(ui.item);
              $(this).val(ui.item.label);
              $("#xIdBarang").val(ui.item.id);
              $("#QtyOrder").focus();
              $("#xNamaBarang").val(ui.item.label);
            //   var qtystok = ui.item.qty/ui.item.konversisatuan
            //     $("#QtyStok").val(qtystok);
                 $("#QtyStok").val(ui.item.qty);
                $("#Satuan").val(ui.item.Satuan_Beli);
                $("#Satuan_Konversi").val(ui.item.Satuan);
                $("#Konversi_satuan").val(ui.item.konversisatuan); 
                
                
              //getBarangbyId(ui.item.id);
              //event.keyCode === 9;
              //document.valueSelectedForAutocomplete = ui.item.id 
              //$(this).closest('tr').find("input[id^='drawing_number']").val(ui.item.dwg); 
              return false; 
          }
  })

  $("#keywords").keyup(function(event) {
    if (event.keyCode === 13) {
        showDataPaket();
    }
});

    $('#btnPaketPilih').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Paket yang Dipilih?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    AddRowPaket();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });



});

// async function goeditOrderMutasi() {
//     try {
//         const dataeditOrderMutasi = await editOrderMutasi();
//         updateUIdataeditOrderMutasi(dataeditOrderMutasi);
//     } catch (err) {
//         toast(err, "error")
//     }
// }
// function updateUIdataeditOrderMutasi(params) {
//     if(params.status === true){
//         toast(params.message, "success")
//         swal({
//             title: 'Success',
//             text: params.message,
//             icon: 'success',
//         }).then(function() {
//             MyBack();
//         });
//     }else{
//         toast(params.message, "error")
//     }
// }
// function editOrderMutasi() {
//     var base_url = window.location.origin;
//     var date = document.getElementById("TglTransaksi").value;
//     var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
//     var data = $("#form_hdr").serialize();
//     // var TransasctionCode = document.getElementById("IdAuto").value;
//     var TotalQty = document.getElementById("pr_totalQty").value;
//     var TotalRow = document.getElementById("pr_totalRow").value;
//     // var Notes = document.getElementById("pr_ketTransaksi").value;
//     let url = base_url + '/SIKBREC/public/OrderMutasiBarang/editOrderMutasi/';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: data + '&TransasctionDate=' + TransasctionDate
//                 + '&TotalQty=' + TotalQty
//                 + '&TotalRow=' + TotalRow
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

async function getBarangbyId(param) {
    try {
        const datagetBarangbyId = await getBarangbyId2(param);
        updateUIdatagetBarangbyId(datagetBarangbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetBarangbyId(params) {
    if (params.status === 'success') { 
        $("#xNamaBarang").val(params.data[0]['Product Name']);
        $("#Satuan").val(params.data[0]['Satuan_Beli']);
        $("#QtyStok").val(0);
        $("#Satuan_Konversi").val(params.data[0]['Unit Satuan']);
        $("#Konversi_satuan").val(params.data[0]['Konversi_satuan']);

    } else {
        toast(params.message, "error")
    }
}

function getBarangbyId2(param) {
    var base_url = window.location.origin; 
    let url = base_url + '/SIKBREC/public/PurchaseForm/getBarangbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDbarang=' + param 
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

async function asyncShowMain() {
    try {
        //await getHakAksesByForm(12); 
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#IdAuto").val();
        disableAll();
        if (id != ""){
            const datagetOrderMutasibyID = await getOrderMutasibyID();  
            updateUIdatagetOrderMutasibyID(datagetOrderMutasibyID);
            showDataDetil();
            enableAll() ;
            $("#btnNewPurchase").attr('disabled', true);
        }
        $(".preloader").fadeOut();
       
    } catch (err) {
        toast(err, "error")
    }
}

async function createHeaderTrs() {
    try {
        $(".preloader").fadeIn();
        const dataGocreateHdr = await GocreateHdr();
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocreateHdr(dataResponse) {
    if (dataResponse != null || dataResponse != ''){
        swal({
            title: "Success",
            text: 'Berhasil Membuat Transaksi Baru!',
            icon: "success",
        });
        $('#IdAuto').val(dataResponse);
        $("#btnNewPurchase").attr('disabled', true);
        enableAll();
    }else{
        swal({
            title: "Gagal",
            text: 'Gagal Membuat Transaksi Baru!',
            icon: "error",
        });
    }
    
}
function GocreateHdr() {
    var base_url = window.location.origin;
    var data = $("#form_hdr").serialize();
    var  date  = document.getElementById("TglTransaksi").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/createHeaderTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data+'&TransasctionDate=' + TransasctionDate 
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

function disableAll() { 
   //document.getElementById("pr_status").disabled = true;  
    // document.getElementById("xNamaBarang").disabled = true;
    // document.getElementById("xIdBarang").disabled = true;
    // document.getElementById("qty_Barang").disabled = true; 
    // document.getElementById("SatuanBarang").disabled = true;
     $("#btnAdd").attr('disabled', true);
   // $("#pr_btn_kembali").attr('disabled', true);
    $("#btn_batal").attr('disabled', true);
    $("#btnSave").attr('disabled', true); 
    // $("#nama_Barang").attr('disabled', true);
    // $("#qty_Barang").attr('disabled', true);
    $("#nama_Barang").attr('disabled', true);
}
function enableAll() {
    $("#nama_Barang").attr('disabled', false);
    // document.getElementById("pr_TglTransaksi").disabled = false;
    // document.getElementById("pr_status").disabled = false;
    // document.getElementById("pr_jenistransaksi").disabled = false;
    // document.getElementById("pr_unitTrnasaksi").disabled = false;
    // document.getElementById("pr_ketTransaksi").disabled = false;
    // document.getElementById("xNamaBarang").disabled = false;
    // document.getElementById("xIdBarang").disabled = false;
    // document.getElementById("qty_Barang").disabled = false;
    // document.getElementById("SatuanBarang").disabled = false;
     $("#btnAdd").attr('disabled', false);
    // $("#pr_btn_kembali").attr('disabled', false);
    $("#btn_batal").attr('disabled', false);
    $("#btnSave").attr('disabled', false);
    // $("#nama_Barang").attr('disabled', false);
    // $("#qty_Barang").attr('disabled', false);
    
}

async function AddRow(){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtl = await GocreateDtl();
        updateUIdataGocreateDtl(dataGocreateDtl);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocreateDtl(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        toast(dataResponse.message, "success")
        $('#nama_Barang').val('');
        $('#xNamaBarang').val('');
        $('#xIdBarang').val('');
        $('#QtyStok').val('');
        $('#QtyOrder').val('');
        $('#Satuan').val('');
        $('#Konversi_Satuan').val('');
        showDataDetil();
        $('#nama_Barang').focus();
    }
     
}
function GocreateDtl() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value;
    var ProductName = document.getElementById("xNamaBarang").value;
    var ProductCode = document.getElementById("xIdBarang").value;
    var QtyStok = document.getElementById("QtyStok").value;
    var QtyOrder = document.getElementById("QtyOrder").value;
    var SatuanBarang = document.getElementById("Satuan").value;
    var Satuan_Konversi = document.getElementById("Satuan_Konversi").value;
    var Konversi_satuan = document.getElementById("Konversi_satuan").value;
    // var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/createDtlTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
            + '&ProductCode=' + ProductCode
            + '&ProductName=' + ProductName
            + '&QtyStok=' + QtyStok 
            + '&QtyOrder=' + QtyOrder 
            + '&SatuanBarang=' + SatuanBarang 
            + '&Satuan_Konversi=' + Satuan_Konversi 
            + '&Konversi_satuan=' + Konversi_satuan 
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

function showDataDetil() {
    var TransasctionCode = document.getElementById("IdAuto").value;
     //var TransasctionCode = "TOM050920220004"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/OrderMutasiBarang/getOrderMutasiDetailbyID/",
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
                    var html = '<font size="1"> ' + row.Satuan_Konversi + '</font>  ';
                    return html
                }
            },
            { "data": "QtyStok" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "QtyOrderMutasi", render: $.fn.dataTable.render.number('.', ',', 2, '') },  // 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-gold border-rounded btn-animated btn-xs"  onclick="deletedetilPerItem(' + row.ProductCode + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

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
                $.fn.dataTable.render.number(',', '', '', '').display(total15)
            );
            
             
        },
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
                $.fn.dataTable.render.number(',', '', '', '').display(total15)
            );
            $("#pr_totalQty").val(total15);
            var table = $('#tbl_aktif').DataTable();
            var table_length = table.data().count();
            $("#pr_totalRow").val(table_length)
            
             
        },


    });
    //$(".preloader").fadeOut();
} 


function updateUIdatagetOrderMutasibyID(dataResponse) {
    var tgltrs = dataResponse.data[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
        
    //$("#TransasctionDate").val(dataResponse.data[0].Golongan);
    $("#LayananOrderMutasi").val(dataResponse.data[0].UnitTujuan).trigger('change');
    $("#LayananTujuanMutasi").val(dataResponse.data[0].UnitOrder).trigger('change');
    $("#UserInput").val(dataResponse.data[0].NamaUserCreate);
    $("#jenistransaksi").val(dataResponse.data[0].JenisMutasi);
    $("#JenisStok").val(dataResponse.data[0].JenisStok);
    $("#Notes").val(dataResponse.data[0].Notes);
}
function getOrderMutasibyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/getOrderMutasibyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + $("#IdAuto").val()
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
           // $(".preloader").fadeOut();
        })
}

function deletedetilPerItem(param) {
    try {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem2(param)
                } else {
                    swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function deletedetilPerItem2(param) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetails = await goVoidDetails(param);
        updateUIdatagoVoidDetails(datagoVoidDetails);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails(params) {
    if(params.status === true){
        toast(params.message, "success")
        showDataDetil();
    }else{
        toast(params.message, "error")
    }
}

function goVoidDetails(param) {
    var No_Transaksi = document.getElementById("IdAuto").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/OrderMutasiBarang/voidOrderDetailsMutasi";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&ProductCode=" + ProductCode 
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


async function goeditOrderMutasi() {
    try {
        const dataeditOrderMutasi = await editOrderMutasi();
        updateUIdataeditOrderMutasi(dataeditOrderMutasi);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataeditOrderMutasi(params) {
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
function editOrderMutasi() {
    var base_url = window.location.origin;
    var date = document.getElementById("TglTransaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var data = $("#form_hdr").serialize();
    // var TransasctionCode = document.getElementById("IdAuto").value;
    var TotalQty = document.getElementById("pr_totalQty").value;
    var TotalRow = document.getElementById("pr_totalRow").value;
    // var Notes = document.getElementById("pr_ketTransaksi").value;
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/editOrderMutasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data + '&TransasctionDate=' + TransasctionDate
                + '&TotalQty=' + TotalQty
                + '&TotalRow=' + TotalRow
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
    window.location = base_url + "/SIKBREC/public/OrderMutasiBarang/list";
}



function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#LayananOrderMutasi").append(newRow);
        $("#LayananTujuanMutasi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#LayananOrderMutasi").append(newRow);
            $("#LayananTujuanMutasi").append(newRow);
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
            $("#LayananOrderMutasi").select2();
            $("#LayananTujuanMutasi").select2();
        })
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

async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const dtax = await goVoidOrderMutasi(param);
        updateUIdatagoVoidOrderMutasi(dtax);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoVoidOrderMutasi(params) {
    if (params.status === true) { 
        toast(params.message, "success")
        //MyBack();
        swal({
            title: 'Success',
            text: params.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    } else {
        toast(params.message, "error")
    }
}
function goVoidOrderMutasi(param) {
    var base_url = window.location.origin; 
    var TransasctionCode = document.getElementById("IdAuto").value;
    var Void = "1"; 
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/voidOrderMutasi/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'No_Transaksi=' + TransasctionCode 
            + '&Void=' + Void 
            + '&AlasanBatal=' + param
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

function showDataPaket() {
    var keywords = $("#keywords").val();

    if (keywords == '') {
        toast('Silahkan isi keywords !', 'warning')
        return false;
    }

    var base_url = window.location.origin;
    $('#datatable_pkt').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_pkt').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getDataPaketbyNameLike",
            "type": "POST",
            "data": {
                keywords: keywords
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.nama_paket + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.user_create + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.date_create + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {

                    var html = '<button type="button" class="btn btn-maroon btn-xs border-primary"  onclick=viewPaketDetail("' + row.ID + '")>View</button>'
                    return html
                },
            },
        ]
    });
}

function viewPaketDetail(id_hdr){
    $("#btnPaketDetail_modal").modal('show')
    $("#id_header_paket").val(id_hdr)
    showDataPaketDetail(id_hdr)
}

function showDataPaketDetail(id_hdr) {

    var base_url = window.location.origin;
    $('#datatable_pktdtl').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_pktdtl').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getDataPaketDetailbyIDHdr",
            "type": "POST",
            "data": {
                id_header: id_hdr
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.product_id + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.nama_product + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.quantity + ' </font>  ';
                    return html
                }
            },
        ]
    });
}

async function AddRowPaket(){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtlPaket = await GocreateDtlPaket();
        updateUIdataGocreateDtlPaket(dataGocreateDtlPaket);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocreateDtlPaket(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        // toast(dataResponse.message, "success")
         var arrayLength = dataResponse['data'].length;
        // for (var i = 0; i < arrayLength; i++) {
        //     console.log(dataResponse.data[i]);
        // }
        if (arrayLength > 0){
            var icon = 'warning'
            var title = 'Berhasil Input Paket Dengan Catatan!'
        }else{
            var icon = 'Success'
            var title = 'Berhasil Input Paket!'
        }
        const text = dataResponse['data'].join("\r\n");
            swal({
            title: title,
            text: text,
            icon: icon,
        })
        $('#nama_Barang').val('');
        $('#xNamaBarang').val('');
        $('#xIdBarang').val('');
        $('#QtyStok').val('');
        $('#QtyOrder').val('');
        $('#Satuan').val('');
        $('#Konversi_Satuan').val('');
        showDataDetil();
        $("#btnPaketDetail_modal").modal('hide')
        $("#btnPaket_modal").modal('hide')
       // $('#nama_Barang').focus();
    }
     
}
async function GocreateDtlPaket() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value;
    var UnitOrder = document.getElementById("LayananTujuanMutasi").value;
    var IdPaket = document.getElementById("id_header_paket").value;
    // var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/createDtlTrsPaket/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
            + '&UnitOrder=' + UnitOrder 
            + '&IdPaket=' + IdPaket 
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