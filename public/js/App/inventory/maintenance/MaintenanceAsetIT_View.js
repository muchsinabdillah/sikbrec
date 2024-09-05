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
    var AssetData = document.getElementById("AssetData").value;
    var TglTransaksi = document.getElementById("TglTransaksi").value;
    var KodePetugas = document.getElementById("KodePetugas").value;
    var Ram = document.getElementById("Ram").value;
    var Cleaning = document.getElementById("Cleaning").value;
    var Repair = document.getElementById("Repair").value;
    var keterangan = document.getElementById("keterangan").value;
    var Install_app = document.getElementById("Install_app").value;
    var url = '';
    url = base_url + '/SIKBREC/public/MaintenanceAsetIT/deleteMaintenance';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&AssetData=" + AssetData
            + "&TglTransaksi=" + TglTransaksi
            + "&KodePetugas=" + KodePetugas
            + "&Ram=" + Ram
            + "&Cleaning=" + Cleaning
            + "&Repair=" + Repair
            + "&keterangan=" + keterangan
            + "&Install_app=" + Install_app
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
        
            const dataGetAssetAktif = await GetAssetAktif(); 
            updateUIdataGetAssetAktif(dataGetAssetAktif);  
            const dataGetMaintenanceAssetID  = await GetMaintenanceAssetID();   
            updateUIdataGetMaintenanceAssetID(dataGetMaintenanceAssetID);
       
       
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetMaintenanceAssetID(dataResponse) {
    $("#TglTransaksi").val(dataResponse.data.DATE_TRANSACTION); 
    $('#AssetData').val(dataResponse.data.KODE_ASSET).trigger('change');
    $("#Cleaning").val(dataResponse.data.M_CLEANING);
    $("#Install_app").val(dataResponse.data.M_INSTAL_APP);
    $("#Ram").val(dataResponse.data.M_RAM);
    $("#Repair").val(dataResponse.data.M_REPAIR_OS);
    $("#SSD").val(dataResponse.data.M_SSD);
    $("#CHARGER").val(dataResponse.data.M_CHARGER);
    $("#LCD").val(dataResponse.data.M_LCD);
    $("#KEYBOARD").val(dataResponse.data.M_KEYBOARD);
    $("#ADAPTER").val(dataResponse.data.M_ADAPTER);
    $("#NamaPetugas").val(dataResponse.data.NamaIT);
    $("#KodePetugas").val(dataResponse.data.USER_IT);
}
function GetMaintenanceAssetID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MaintenanceAsetIT/GetMaintenanceAssetID/';
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
function updateUIdataGetAssetAktif(response) {
    let responseApi = response;
    console.log("responseApi", responseApi);
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#AssetData").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].Id_Asset + '">' + responseApi[i].Nama_Asset + ' - Mac : ' + responseApi[i].Mac_Address + ' - IP : ' + responseApi[i].IP_Address + '</option';
            $("#AssetData").append(newRow);
        }
    }
}
function GetAssetAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MaintenanceAsetIT/showListAssetAktif/';
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
            $("#AssetData").select2(); 
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MaintenanceAsetIT/list";
}
async function saveGolongan() {

    $(".preloader").fadeIn(); 
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    
    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var AssetData = document.getElementById("AssetData").value;
    var TglTransaksi = document.getElementById("TglTransaksi").value;
    var KodePetugas = document.getElementById("KodePetugas").value;
    var Ram = document.getElementById("Ram").value;
    var Cleaning = document.getElementById("Cleaning").value;
    var Repair = document.getElementById("Repair").value;
    var SSD = document.getElementById("SSD").value;
    var CHARGER = document.getElementById("CHARGER").value;
    var LCD = document.getElementById("LCD").value;
    var ADAPTER = document.getElementById("ADAPTER").value;
    var KEYBOARD = document.getElementById("KEYBOARD").value;
    var keterangan = document.getElementById("keterangan").value; 
    var Install_app = document.getElementById("Install_app").value; 
    var url = '';
    url = base_url + '/SIKBREC/public/MaintenanceAsetIT/addMaintenance';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&AssetData=" + AssetData
            + "&TglTransaksi=" + TglTransaksi
            + "&KodePetugas=" + KodePetugas
            + "&Ram=" + Ram
            + "&Cleaning=" + Cleaning
            + "&Repair=" + Repair
            + "&keterangan=" + keterangan
            + "&Install_app=" + Install_app
            + "&SSD=" + SSD
            + "&CHARGER=" + CHARGER
            + "&LCD=" + LCD
            + "&ADAPTER=" + ADAPTER
            + "&KEYBOARD=" + KEYBOARD 
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