$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveGolongan();
            console.log(result);
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {
            toast(err, "error")
        }
    })
    // buton save ditekan
    const btn_batal = document.querySelector('#btn_batal');
    btn_batal.addEventListener('click', async function () {
        try {
            const result = await HapusTransaksi();
            console.log(result);
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {
            toast(err, "error")
        }
    })



});
async function HapusTransaksi() {

    $(".preloader").fadeIn();
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var NamaAsset = document.getElementById("NamaAsset").value;
    var KodeAsset = document.getElementById("KodeAsset").value;
    var MerkAsset = document.getElementById("MerkAsset").value;
    var TglTransaksi = document.getElementById("TglTransaksi").value;
    var JenisAsset = document.getElementById("JenisAsset").value;
    var SerialNumberAsset = document.getElementById("SerialNumberAsset").value;
    var AnydeskAsset = document.getElementById("AnydeskAsset").value;
    var UnitIndukAsset = document.getElementById("UnitIndukAsset").value;
    var IpAddressAsset = document.getElementById("IpAddressAsset").value;
    var MacAdressAsset = document.getElementById("MacAdressAsset").value;
    var StatusAsset = document.getElementById("StatusAsset").value;
    var LantaiAsset = document.getElementById("LantaiAsset").value; 
    var url = '';
    url = base_url + '/SIKBREC/public/MasterAsset/deleteAsset';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaAsset=" + NamaAsset
            + "&KodeAsset=" + KodeAsset
            + "&MerkAsset=" + MerkAsset
            + "&TglTransaksi=" + TglTransaksi
            + "&JenisAsset=" + JenisAsset
            + "&SerialNumberAsset=" + SerialNumberAsset
            + "&AnydeskAsset=" + AnydeskAsset
            + "&UnitIndukAsset=" + UnitIndukAsset
            + "&IpAddressAsset=" + IpAddressAsset
            + "&MacAdressAsset=" + MacAdressAsset
            + "&StatusAsset=" + StatusAsset
            + "&LantaiAsset=" + LantaiAsset
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
            document.getElementById("btnSave").disabled = false;
        })
}

async function asyncShowMain() {
    try {
        await getHakAksesByForm(12);

        const dtGetJenisAssetAktif = await GetJenisAssetAktif();
        updateUIdtGetJenisAssetAktif(dtGetJenisAssetAktif);
        const dtGetUnitAktif = await GetUnitAktif();
        updateUIdtGetUnitAktif(dtGetUnitAktif);
        const dataGetAssetID = await GetAssetID();
        console.log("dataGetAssetID", dataGetAssetID);
        updateUIdatadataGetAssetID(dataGetAssetID);
        showdatatabel_history();

    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdtGetUnitAktif(response) {
    let responseApi = response;
    console.log("responseApi", responseApi);
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#UnitIndukAsset").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#UnitIndukAsset").append(newRow);
        }
    }
}
function GetUnitAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterAsset/GetUnitAktif/';
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
            $(".preloader").fadeOut();
            $("#UnitIndukAsset").select2();
            // $("#LantaiAsset").select2(); 
        })
}
function updateUIdatadataGetAssetID(dataResponse) {
    $("#KodeAsset").val(dataResponse.data.Kode_Asset);
    $("#NamaAsset").val(dataResponse.data.Nama_Asset);
    $("#MerkAsset").val(dataResponse.data.Merk_Asset);
    $("#SerialNumberAsset").val(dataResponse.data.Serial_Number_Asset);
    $("#TglTransaksi").val(dataResponse.data.Tanggal_Pembelian); 
    $("#IpAddressAsset").val(dataResponse.data.IP_Address);
    $("#MacAdressAsset").val(dataResponse.data.Mac_Address);
    $("#StatusAsset").val(dataResponse.data.Id_Status_Asset);
    $("#AnydeskAsset").val(dataResponse.data.Anydesk); 
    $('#UnitIndukAsset').val(dataResponse.data.Unit_Induk_Asset).trigger('change');
    $('#LantaiAsset').val(dataResponse.data.LANTAI).trigger('change');
    $('#JenisAsset').val(dataResponse.data.Id_Jenis_Asset).trigger('change');
}
function GetAssetID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterAsset/GetAssetID/';
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
function updateUIdtGetJenisAssetAktif(response) {
    let responseApi = response;
    console.log("responseApi", responseApi);
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#JenisAsset").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].Id_Jenis_Asset + '">' + responseApi[i].Nama_Jenis_Asset + '</option';
            $("#JenisAsset").append(newRow);
        }
    }
}
function GetJenisAssetAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterAsset/GetJenisAssetAktif/';
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
            $(".preloader").fadeOut();
            $("#JenisAsset").select2();
            $("#StatusAsset").select2();
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterAsset/list";
}
async function saveGolongan() {

    $(".preloader").fadeIn();
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;

    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var NamaAsset = document.getElementById("NamaAsset").value;
    var KodeAsset = document.getElementById("KodeAsset").value;
    var MerkAsset = document.getElementById("MerkAsset").value;
    var TglTransaksi = document.getElementById("TglTransaksi").value;
    var JenisAsset = document.getElementById("JenisAsset").value;
    var SerialNumberAsset = document.getElementById("SerialNumberAsset").value;
    var AnydeskAsset = document.getElementById("AnydeskAsset").value;
    var UnitIndukAsset = document.getElementById("UnitIndukAsset").value;
    var IpAddressAsset = document.getElementById("IpAddressAsset").value;
    var MacAdressAsset = document.getElementById("MacAdressAsset").value;
    var StatusAsset = document.getElementById("StatusAsset").value;
    var LantaiAsset = document.getElementById("LantaiAsset").value; 
    var url = '';
    url = base_url + '/SIKBREC/public/MasterAsset/addAsset';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaAsset=" + NamaAsset
            + "&KodeAsset=" + KodeAsset
            + "&MerkAsset=" + MerkAsset
            + "&TglTransaksi=" + TglTransaksi
            + "&JenisAsset=" + JenisAsset
            + "&SerialNumberAsset=" + SerialNumberAsset
            + "&AnydeskAsset=" + AnydeskAsset
            + "&UnitIndukAsset=" + UnitIndukAsset
            + "&IpAddressAsset=" + IpAddressAsset
            + "&MacAdressAsset=" + MacAdressAsset
            + "&StatusAsset=" + StatusAsset
            + "&LantaiAsset=" + LantaiAsset
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
            document.getElementById("btnSave").disabled = false;
        })
}

// function AddRow(){
//     var count = 0
//     count = count + 1;
//                     //grandtotal = grandtotal + parseInt(qty);
//                     //document.getElementById('grantotalOrder').innerHTML = grandtotal;
//                     //$('#grandtotalstok').val(grandtotal);

//                     nama_barang = $('#nama_Barang').val();
//                    // var xp = stok.toPrecision(2);
//                     satuan = $('#satuan_Barang').val();
//                     qty = $('#qty_Barang').val();
//                     stok = '10';
//                     kodebarang = '1';
//                       output = '<tr id="row_' + count + '">';
//                       output += '<td>' + count + ' </td>';
//                       output += '<td>' + kodebarang + ' <input type="hidden" name="hidden_kode_barang[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + kodebarang + '" /></td>';
//                       output += '<td>' + nama_barang + ' <input type="hidden" name="hidden_nama_barang[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + nama_barang + '" /></td>';
//                       output += '<td>' + satuan + ' <input type="hidden" name="hidden_satuan_barang[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + satuan + '" /></td>';
//                       output += '<td>' + stok + ' <input type="hidden" name="hidden_min_barang[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + stok + '" /></td>';
//                       output += '<td>' + qty + ' <input type="hidden" name="hidden_qty_barang[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + qty + '" /></td>';
//                       output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="' +
//                         count + '">Hapus</button></td>';
//                       output += '</tr>';
//                       $('#user_data').append(output);
//                     //   $("#pilihnamabarang").val('');
//                     //   $("#namabarangd").val('');
//                     //   $("#satuan").val('');
//                     //   $("#qtyorderx").val('');
//                     //   $('#pilihnamabarang').focus();   
// }

// $(document).on('click', '.remove_details', function () {
//     var row_id = $(this).attr("id");
//     swal({
//         title: "Are you sure?",
//         text: "Apakah anda yakin Ingin hapus data ini ?",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//       })
//       .then((willDelete) => {
//         if (willDelete) {
//             $('#row_' + row_id + '').remove();
//             var count = $('#totalrow').val();
//             //console.log(count);
//             count = count - 1 ;
//             document.getElementById('grantotalOrder').innerHTML = count;
//             $('#totalrow').val(count);
//             toast('Berhasil Hapus !', "success")
//         } else {
//           //swal("Your imaginary file is safe!");
//         }
//       });

//     });

function showdatatabel_history() {
    const base_url = window.location.origin;
    var id = $("#IdAuto").val();
    $(".preloader").fadeOut();
    $('#examplex').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#examplex').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/MaintenanceAsetIT/showDataMaintenancebyID",
            "type": "POST",
            data: function (d) {
                d.id = id
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
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
        ]
    });
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