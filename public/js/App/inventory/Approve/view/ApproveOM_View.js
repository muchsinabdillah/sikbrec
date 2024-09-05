$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();

    $('#btnSave').click(function () {
        $("#Modal_Approve").modal('show');
    });

        $("#nopin").keyup(function(event) {
            if (event.keyCode === 13) {
                goGetApproveName();
            }
        });


});

function updateUIdatagetBarangbyId(params) {
    if (params.status === 'success') { 
        $("#Satuan").val(params.data[0]['Satuan_Beli']);
        $("#QtyStok").val(50);

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
        await getHakAksesByForm(12); 
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#IdAuto").val();
        disableAll();
        if (id != ""){
            const datagetOrderMutasibyID = await getOrderMutasibyID();  
            updateUIdatagetOrderMutasibyID(datagetOrderMutasibyID);
            showDataDetil();
            enableAll() ;
        }
       
    } catch (err) {
        toast(err, "error")
    }
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
    //$("#btnSave").attr('disabled', true); 
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
    //$("#btnSave").attr('disabled', false);
    // $("#nama_Barang").attr('disabled', false);
    // $("#qty_Barang").attr('disabled', false);
    
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
                    var html = '<font size="1"> ' + row.Satuan + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.QtyStok + '</font>  ';
                    return html
                }
            },
             
            { "data": "QtyOrderMutasi", render: $.fn.dataTable.render.number(',', '', 0, '') }, 
             

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


    });
    $(".preloader").fadeOut();
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
    if (dataResponse.data[0].StatusPR == 'APPROVED'){
        $("#btnSave").attr('disabled', true);
    }else{
        $("#btnSave").attr('disabled', false);
    }
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
            $(".preloader").fadeOut();
        })
}



function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/InventoryApprove/ListApproveOM";
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
        // setTimeout(() => {
        //     MyBack();
        // }, 2000);
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
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    //var nopin = $("#nopin").val();
    var nopin_ext = $("#nopin_ext").val();
    var no_trs = $("#IdAuto").val();
    let url = base_url + '/SIKBREC/public/InventoryApprove/SaveApproveOM/';
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