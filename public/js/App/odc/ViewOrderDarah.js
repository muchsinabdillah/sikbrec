$(document).ready(function () {
    // $(".preloader").fadeOut(); 
    asyncShowMain();
    $(document).on('click', '#btn_upload', function () {
        frmUploadDocuments($("#no_MR").val());
    });

    $('#btn_simpan').click(function () {
        if ($("#NoOrderTransaksi").val() == ''){
            toast('No Transaksi Tidak Ditemukan ! Silahkan Klik New Transaction Terlebih Dahulu !', 'warning');
            return false
        }
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Simpan ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goupdateHeaderTrs();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
     });

     $('#btn_batal').click(function () {
        if ($("#NoOrderTransaksi").val() == ''){
            toast('No Transaksi Tidak Ditemukan ! Silahkan Klik New Transaction Terlebih Dahulu !', 'warning');
            return false
        }
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Batal ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goBatalHeaderUseBlood();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
     });

     $('#btnBack').click(function () {
        MyBack();
     });

     $('#btntabhistorylab').click(function () {
        if (!$.fn.dataTable.isDataTable('#list_useblooddetail_arsip')){
            loadDataPemeriksaanLab();
         }
     });

     $('#btntranfusi_arsip').click(function () {
        if (!$.fn.dataTable.isDataTable('#list_tranfusi_arsip')){
            loadDataRiwayatTranfusi();
         }
     });

     $('#btnOrderLab').click(function () {
        showFormOrderLaboratorium($("#no_Reg").val());
     });

     $('#btnNewTransaksi').click(function () {
        createHeaderDetailTrs();
     });

     $('#btnAdd').click(function () {
        AddRow();
    });

    $("#Barcode").keyup(function(event) {
        if (event.keyCode === 13) {
            AddRow();
        }
    });

    // $('#list_useblooddetail').DataTable({});

    $("#add_row").click(function () { 

        if($("#totalrow").val() > 0){
            toast("Barcode Sudah Terisi !", 'warning');
            return false;
        }

        if($("#BarcodeHO").val() == ''){
            $("#BarcodeHO").focus();
            toast("Mohon Isi Barcode !", 'warning');
            return false;
        }

        goAddBarcodeHO();
        
    });

    $("#BarcodeHO").keyup(function(event) {
        if (event.keyCode === 13) {
            if($("#totalrow").val() > 0){
                toast("Barcode Sudah Terisi !", 'warning');
                return false;
            }
    
            if($("#BarcodeHO").val() == ''){
                $("#BarcodeHO").focus();
                toast("Mohon Isi Barcode !", 'warning');
                return false;
            }
    
            goAddBarcodeHO();
        }
    });

});

async function goAddBarcodeHO() {
    try {

        const datas = await gogetBarcode($("#BarcodeHO").val(),$("#IDDetail").val());
        if (datas.status == 'danger'){
            toast(datas.message, 'warning');
            return false;
          }

        if($('#totalrow').val()==0){
            var count =0;
          }else{
            var count = parseFloat($('#totalrow').val());
          }
          count = count + 1;
          document.getElementById('grantotalOrder').innerHTML = count;
          $('#totalrow').val(count);

          JenisDarah = datas.data.JenisDarah;
          Qty = datas.data.QtyPakai;
          ED = datas.data.ED;
          Barcode = datas.data.Barcode;

          output = '<tr id="row_' + count + '">';
          output += '<td>' + JenisDarah + ' <input type="hidden" name="JenisDarah[]" id="JenisDarah' + count +'" class="hidden_kode_barang" value="' + JenisDarah + '" /></td>';
          output += '<td>' + Qty + ' <input type="hidden" name="Qty[]" id="Qty' + count +'" class="hidden_kode_barang" value="' + Qty + '" /></td>';
          output += '<td>' + ED + ' <input type="hidden" name="ED[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ED + '" /></td>';
          output += '<td>' + Barcode + ' <input type="hidden" name="Barcode[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + Barcode + '" /></td>';
          output += '<td><input type="checkbox" onclick="return false;" readonly checked/></td>';
          output += '</tr>';
          $('#user_data').append(output);
          $("#BarcodeHO").val('');

    } catch (err) {
        toast(err, "error")
    }
}

async function gogetBarcode(barcode,id) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/gogetBarcode';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'Barcode=' + barcode + '&id=' + id 
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function getDataOrderDarah() {
    // console.log($("#id_Order").val());
    // exit;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/getOrderData/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#id_Order").val()
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

async function asyncShowMain() {
    try {
        // await getHakAksesByForm(46);
        if($('#id_Order').val()!=''){
        const datagetDataOrderDarah = await getDataOrderDarah();
        updateUIgetDataOrderDarah(datagetDataOrderDarah);
        // const data = await GetListNamaOrderDetail();
        // updateUIdataGetListNamaOrderDetail(data);
        }else if ($("#NoOrderTransaksi").val() != ''){
            $("#btnNewTransaksi").attr('disabled', true);
            const data = await getDataPakaiDarah($("#NoOrderTransaksi").val());
            updateUIgetDataPakaiDarah(data);
            //ListDataOrderDarah();
            //showDataDetil();
            $(".preloader").fadeOut();
            
        }
    } catch (err) {
        toast(err, "error")
    }
}

function getDataOrderDarah() {
    // console.log($("#id_Order").val());
    // exit;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/getOrderData/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#id_Order").val()
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function updateUIgetDataOrderDarah(datagetDataOrderDarah) {

    let dataResponse = datagetDataOrderDarah;
    // console.log(dataResponse);
    // exit;

        $("#tgl_Order").val(dataResponse.data.DateOrder);
        $("#ket_order").val(dataResponse.data.Keterangan);
        $("#no_MR").val(dataResponse.data.NoMR);
        $("#no_Eps").val(dataResponse.data.NoEpisode);
        $("#no_Reg").val(dataResponse.data.NoRegistrasi);
        $("#user_Order").val(dataResponse.data.UserOrderName);
        $("#dokter_DPJP").val(dataResponse.data.DPJPName);
        $("#nama_Pasien").val(dataResponse.data.PatientName);
        $("#GolonganDarah").val(dataResponse.data.GolonganDarah);
        $("#nama_Jaminan").val(dataResponse.data.NamaJaminan);
        $("#Gender").val(dataResponse.data.gender);
        $("#Domisili").val(dataResponse.data.Domisili);
        $("#Tgl_Lahir").val(dataResponse.data.Tgl_Lahir);
        $("#Ruang").val(dataResponse.data.Ruang);
        $("#user_Entry").val(dataResponse.data.UserFirst);
        $("#JenisOrder").val(dataResponse.data.JenisOrder);
        $("#BeratBadan").val(dataResponse.data.BeratBadan);
        $("#HbSaatIni").val(dataResponse.data.Hb_SaatIni);
        $("#HbTarget").val(dataResponse.data.Hb_Target);
        $("#Rhesus").val(dataResponse.data.Rhesus);
        $("#TrombositSaatIni").val(dataResponse.data.Trombosit_SaatIni);
        $("#TrombositTarget").val(dataResponse.data.Trombosit_Target);

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

//fiqri 09-04-2023 19:08

async function goupdateHeaderTrs() {
    try {
        $(".preloader").fadeIn();
        const data = await updateHeaderTrs();
        updateUIdataupdateHeaderTrs(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataupdateHeaderTrs(dataResponse) {
    if(dataResponse.status == 'success'){
        toast(dataResponse.message, "success");
        swal({
            title: "Save Success!",
            text: dataResponse.message,
            icon: "success",
        }).then(function() {
            MyBack();
        });
    }else{
        toast(dataResponse.message, "error")
    }
}
function updateHeaderTrs() {
    var base_url = window.location.origin;
    var data = $("#frmSimpanTrsRegistrasi").serialize();
    var  date  = document.getElementById("tgl_Pakai").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/updateHeaderTrs/';
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

async function goBatalHeaderUseBlood() {
    try {
        $(".preloader").fadeIn();
        const data = await BatalHeaderUseBlood();
        updateUIdataBatalHeaderUseBlood(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataBatalHeaderUseBlood(dataResponse) {
    if(dataResponse.status == 'success'){
        toast(dataResponse.message, "success");
        swal({
            title: "Save Success!",
            text: dataResponse.message,
            icon: "success",
        }).then(function() {
            MyBack();
        });
    }else{
        toast(dataResponse.message, "error")
    }
}
function BatalHeaderUseBlood() {
    var base_url = window.location.origin;
    var data = $("#frmSimpanTrsRegistrasi").serialize();
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/BatalHeaderUseBlood/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data
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

async function ListDataOrderDarah() {
    try {
        const data = await GetListNamaOrderDetail();
        updateUIdataGetListNamaOrderDetail(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGetListNamaOrderDetail(data) {
    let responseApi = data;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#ListOrderDarah").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaTarifDarah + '</option>';
            $("#ListOrderDarah").append(newRow);
        }
    }
}
function GetListNamaOrderDetail() {
    var base_url = window.location.origin; 
 
    let url = base_url + '/SIKBREC/public/bInfoOrderDarah/GetListNamaOrderDetail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idhdr=' + $("#id_Order").val()
        
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
            $("#ListOrderDarah").select2();
        })
}

// $("#btnAdd").click(function () { 

//     // if($("#tipepembayaran_closing").val() == ''){
//     //     $("#tipepembayaran_closing").select2('open');
//     //     toast("Mohon Isi Tipe Pembayaran !", 'warning');
//     //     return false;
//     // }

//     // if($("#totalinput_closing").val() == ''){
//     //     $("#totalinput_closing").focus();
//     //     toast("Mohon Isi Amount !", 'warning');
//     //     return false;
//     // }

//       if($('#totalrow_closing').val()==0){
//         var count =0;
//       }else{
//         var count = parseFloat($('#totalrow_closing').val());
//       }
//       count = count + 1;
//       document.getElementById('grantotalOrder_closing').innerHTML = count;
//       $('#totalrow_closing').val(count);

//       NamaTarifDarah = $('#NamaTarifDarah').val();
//       Id_dtl = $("#Id_dtl").val();
//       QtyOrder = $('#QtyOrder').val();
//       QtySisa = $('#QtySisa').val();
//       QtyPakai = $('#QtyPakai').val();

//         output = '<tr id="row_closing_' + count + '">';
//         output += '<td>' + NamaTarifDarah + ' <input type="hidden" name="NamaTarifDarah[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + NamaTarifDarah + '" /><input type="hidden" name="Id_dtl[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + Id_dtl + '" /></td>';
//         output += '<td>' + QtyPakai + ' <input type="hidden" name="QtyPakai[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + QtyPakai + '" />';
//         output += '<td><button type="button" title="Hapus" name="remove_details_closing" class="btn btn-danger btn-sm remove_details_closing" id="' +
//           count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
//         output += '</tr>';
//         $('#user_data_closing').append(output);
//         //$("#NamaTarifDarah").val('');
//         //$("#NamaTarifDarah_closing").val('').trigger('change');
//         // $("#perusahaanjpk_closing").select2('destroy');
//         // $("#perusahaanasuransi_closing").select2('destroy');
//         // $("#perusahaanjpk_closing").val('');
//         // $("#perusahaanasuransi_closing").val('');
//         // $("#perusahaanjpk_closing").select2();
//         // $("#perusahaanasuransi_closing").select2();

//         // $("#billto_closing").val("");
//         // $("#kode_billto_closing").val("");
//         // $("#totalinput_closing").val('');
//         // $("#namabank_closing").val('');
//         // $("#tipekartu_closing").val('');
//         // $("#nokartu_closing").val('');
//         // $("#gesek_closing").val('');
//         // $('#kd_rekening_closing').val('');
//         // $('#tipepembayaran_closing').focus(); 
        
// });


// $(document).on('click', '.remove_details_closing', function () {
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
//             $('#row_closing_' + row_id + '').remove();
//             $('#row_closing_')
//             var count = $('#totalrow_closing').val();
//             //console.log(count);
//             count = count - 1 ;
//             document.getElementById('grantotalOrder_closing').innerHTML = count;
//             $('#totalrow_closing').val(count);
//             toast('Berhasil Hapus !', "success")
//         } else {
//           //swal("Your imaginary file is safe!");
//         }
//       });

//     });

    async function getDataDetail(val) {
        try {
            const data = await GetNamaOrderDetail(val);
            updateUIdataGetNamaOrderDetail(data);
        } catch (err) {
            toast(err, "error")
        }
    }

    function GetNamaOrderDetail(val) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/GetNamaOrderDetail';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'id=' + val
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
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }
    
    function updateUIdataGetNamaOrderDetail(data) {
        let dataResponse = data;
            $("#Id_dtl").val(dataResponse.data.ID);
            $("#NamaTarifDarah").val(dataResponse.data.NamaTarifDarah);
            $("#QtyOrder").val(dataResponse.data.QtyOrder);
            //$("#QtyPakai").val(dataResponse.data.QtyPakai);
            $("#QtySisa").val(dataResponse.data.QtySisa);
            $("#Harga").val(dataResponse.data.Harga);
            $("#Total").val(dataResponse.data.Total);
            $("#IdTarifDarah").val(dataResponse.data.IdTarifDarah);
            $("#QtyCC").val(dataResponse.data.CC);
    }

    async function createDetailTrs(idhdr_useblood) {
        try {
            const data = await gocreateDetailTrs(idhdr_useblood);
            updateUIdatagocreateDetailTrs(data);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function updateUIdatagocreateDetailTrs(params) {
        let response = params;
        if (response.status == "success") {
            toast(response.message, "success")
            swal({
                title: "Simpan Berhasil!",
                text: response.message,
                icon: "success",
            })
            //getDataApproveFarmasi();
        }else{
            toast(response.message, "error")
        }  
    
    }
    
    function gocreateDetailTrs(idhdr_useblood) {
        var form = $("#form_payment_closing").serialize();
        var id_Order = document.getElementById("id_Order").value;  
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/createDetailTrs_UseBlood';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: form + "&idhdr_useblood=" + idhdr_useblood + "&id_Order=" + id_Order
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


    // badrul
    async function createHeaderDetailTrs() {
        try {
            const dataGocreateHeaderDetailTrs = await GocreateHeaderDetailTrs();
            updateUIdataGocreateHeaderDetailTrs(dataGocreateHeaderDetailTrs);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function GocreateHeaderDetailTrs() {        
        var form = $("#frmSimpanTrsRegistrasi").serialize();
        //var id_Order = document.getElementById("id_Order").value;
        var  date  = document.getElementById("tgl_Pakai").value;  
    
        var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');

        var base_url = window.location.origin; 
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/createHeaderTrs_UseBlood';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: form + "&TransasctionDate=" + TransasctionDate
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

    function updateUIdataGocreateHeaderDetailTrs(dataResponse) {
        //console.log(dataResponse);
        if(dataResponse.status == "success"){
            toast(dataResponse.message, "success");
            $('#NoOrderTransaksi').val(dataResponse.idhdr_useblood);
            $("#btnNewTransaksi").attr('disabled', true)
            ListDataOrderDarah();
        }else{
            toast(dataResponse.message, "error")
        }
    }
    // badrul

    async function AddRow(){
        try {
    
            const dataGocreateDtl = await GocreateDtl();
            updateUIdataGocreateDtl(dataGocreateDtl);
            //showDataDetil();
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function showDataDetil() {
        var IDHdr = $("#NoOrderTransaksi").val();
        var base_url = window.location.origin;
        $('#list_useblooddetail').DataTable().clear().destroy();
        $('#list_useblooddetail').DataTable({
            "ordering": false,
            "paging": false,
            //"order": [[ 2, "desc" ]],
            "ajax": {
                "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataListUseBloodDetail/",
                "dataSrc": "",
                "deferRender": true,
                "type": "POST",
                data: function (d) {
                    d.IDHdr = IDHdr; 
                }
            },
            "columns": [
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.KantongKe + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.NamaTarifDarah + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.QtyPakai + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.Expired_Date + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.Barcode + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.Keterangan + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        if (row.StatusHandOver == '1'){
                            var html = '<span class="badge badge-success">Sudah Hand Over</span>';
                        }else{
                            var html = '<span class="badge badge-secondary">Belum Hand Over</span>';

                        }
                        return html
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                        var html = '<button type="button" class="btn btn-default border-primary btn-xs"  onclick="showCetakLabel(' + row.ID + ')" > Label</button>&nbsp<button type="button" class="btn btn-warning btn-xs"  onclick=\'showHandover("'+row.ID+'")\'  >Hand Over</button>&nbsp<button type="button" class="btn btn-danger btn-animated btn-xs"  onclick="goVoidDetails(' + row.IdTarifDarah + ', '+row.ID+')" ><span class="visible-content" > Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                        return html
                    }
                },
    
            ], 
            // "footerCallback": function (row, data, start, end, display) {
            //     var api = this.api(), data;
    
            //     // Remove the formatting to get integer data for summation
            //     var intVal = function (i) {
            //         return typeof i === 'string' ?
            //             i.replace(/[\$,]/g, '') * 1 :
            //             typeof i === 'number' ?
            //                 i : 0;
            //     };
             
    
            //     total15 = api
            //         .column(1)
            //         .data()
            //         .reduce(function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0);
     
    
            //     $(api.column(1).footer()).html(
            //         $.fn.dataTable.render.number(',', '', '', '').display(total15)
            //     );
                
                 
            // },
    
    
        });
        $(".preloader").fadeOut();
    } 
    function showCetakLabel(idParams){
        // console.log(idParams);
        // exit;
        var notrs = btoa(idParams); 
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/bInfoOrderDarah/PrintLabelPasien/" + notrs , "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    }
    function updateUIdataGocreateDtl(dataResponse) {
        //console.log(dataResponse);
        if(dataResponse.status == "success"){
            toast(dataResponse.message, "success")
            $("#ListOrderDarah").empty();
            $("#NamaTarifDarah").val('');
            $("#QtyOrder").val('');
            //$("#QtyPakai").val('');
            $("#QtySisa").val('');
            $("#Harga").val('');
            $("#Total").val('');
            $("#qtytotal").val(dataResponse.qtytotal);
            $("#ExpiredDate").val('');
            $("#Barcode").val('');
            $("#KeteranganDtl").val('');
            $("#KantongKe").val('');
            ListDataOrderDarah();
            showDataDetil();
        }else{
            toast(dataResponse.message, "error")
           
        }
         
    }
    function GocreateDtl() {
        var base_url = window.location.origin;
        IdTarifDarah = $("#IdTarifDarah").val();
        id_Order = $("#id_Order").val();
        id_noOrder = $("#NoOrderTransaksi").val();
        Id_dtl = $("#Id_dtl").val();
        NamaTarifDarah = $("#NamaTarifDarah").val();
        QtyOrder = $("#QtyOrder").val();
        QtyPakai = $("#QtyPakai").val();
        QtySisa = $("#QtySisa").val();
        Harga = $("#Harga").val();
        Total = $("#Total").val();
        KeteranganDtl = $("#KeteranganDtl").val();
        KantongKe = $("#KantongKe").val();
        var  date  = document.getElementById("ExpiredDate").value;  
        var ExpiredDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
        Barcode = $("#Barcode").val();
        QtyCC = $("#QtyCC").val();
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/createDetailTrs_UseBlood';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 
                    'Id_dtl=' + Id_dtl
                   + '&NamaTarifDarah=' + NamaTarifDarah
                   + '&QtyOrder=' + QtyOrder
                   + '&QtyPakai=' + QtyPakai
                   + '&QtySisa=' + QtySisa
                   + '&Harga=' + Harga
                   + '&Total=' + Total
                   + '&id_Order=' + id_Order
                   + '&id_noOrder=' + id_noOrder
                   + '&IdTarifDarah=' + IdTarifDarah
                   + '&ExpiredDate=' + ExpiredDate
                   + '&Barcode=' + Barcode
                   + '&KeteranganDtl=' + KeteranganDtl
                   + '&QtyCC=' + QtyCC
                   + '&KantongKe=' + KantongKe
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

    function goVoidDetails(product_code,ID) {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem(product_code,ID);
                } else {
                   // swal("Transaction Rollback !");
                }
            });
    }
    
    async function deletedetilPerItem(product_code,ID) {
        try {
            $(".preloader").fadeIn();
            const data = await deletedetilPerItem2(product_code,ID);
            updateUIdeletedetilPerItem2(data);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIdeletedetilPerItem2(data) {
        if (data.status == 'success') {
            toast(data.message, "success");
            $("#qtytotal").val(data.qtytotal);
            $("#ListOrderDarah").empty();
            $("#NamaTarifDarah").val('');
            $("#QtyOrder").val('');
            //$("#QtyPakai").val('');
            $("#QtySisa").val('');
            $("#Harga").val('');
            $("#Total").val('');
            ListDataOrderDarah();
            showDataDetil();
        } else {
            toast(data.message, "error")
        }
    }
    
    function deletedetilPerItem2(product_code,ID) {
        var IDHdr_Order = $("#id_Order").val();
        var url2 = "/SIKBREC/public/bInfoOrderDarah/voidUseBloodbyID";
        var base_url = window.location.origin;
        let url = base_url + url2;
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: "IDHdr_Order=" + IDHdr_Order + "&product_code=" + product_code + "&ID=" + ID 
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

    function getDataPakaiDarah(id) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/getDataPakaiDarah/';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'id=' + id
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
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }
    
    function updateUIgetDataPakaiDarah(data) {
        let dataResponse = data;
    
            $("#tgl_Order").val(dataResponse.data.DateOrder);
            $("#ket_order").val(dataResponse.data.Keterangan);
            $("#no_MR").val(dataResponse.data.NoMR);
            $("#no_Eps").val(dataResponse.data.NoEpisode);
            $("#no_Reg").val(dataResponse.data.NoRegistrasi);
            $("#user_Order").val(dataResponse.data.UserOrderName);
            $("#dokter_DPJP").val(dataResponse.data.DPJPName);
            $("#nama_Pasien").val(dataResponse.data.PatientName);
            $("#GolonganDarah").val(dataResponse.data.GolonganDarah);
            $("#tgl_Pakai").val(dataResponse.data.DateConsume);
            $("#ket_order").val(dataResponse.data.KetUseBlood);
            $("#id_Order").val(dataResponse.data.ID);
            $("#nama_Jaminan").val(dataResponse.data.NamaJaminan);
            $("#qtytotal").val(dataResponse.data.QtyTotal);
            
            $("#Gender").val(dataResponse.data.gender);
            $("#Domisili").val(dataResponse.data.Domisili);
            $("#Tgl_Lahir").val(dataResponse.data.Tgl_Lahir);
            $("#Ruang").val(dataResponse.data.Ruang);
            $("#user_Entry").val(dataResponse.data.UserFirst);
            $("#JenisOrder").val(dataResponse.data.JenisOrder);
            $("#BeratBadan").val(dataResponse.data.BeratBadan);
            $("#HbSaatIni").val(dataResponse.data.Hb_SaatIni);
            $("#HbTarget").val(dataResponse.data.Hb_Target);
            $("#Rhesus").val(dataResponse.data.Rhesus);
            $("#TrombositSaatIni").val(dataResponse.data.Trombosit_SaatIni);
            $("#TrombositTarget").val(dataResponse.data.Trombosit_Target);
            $("#incompatibility").val(dataResponse.data.HistoryIncompatibility);
            $("#autocontrol").val(dataResponse.data.AutoControl);
            
            ListDataOrderDarah();
            showDataDetil();
    
    }

    function MyBack() {
        const base_url = window.location.origin;
        window.location = base_url + "/SIKBREC/public/bInfoOrderDarah/list";
    }
    function frmUploadDocuments(str) {
        // console.log(str);
        // exit;
        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aMedicalRecord/frmUploadDocuments/' + str;
        var win = window.open(url, '_blank');
        win.focus()
    }

    function showCetakLabel(idParams){
        // console.log(idParams);
        // exit;
        var notrs = btoa(idParams); 
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/bInfoOrderDarah/PrintLabelPasien/" + notrs , "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    }

    function showFormOrderLaboratorium(NoRegistrasi) {
        const base_url = window.location.origin;
        var str = btoa(NoRegistrasi);
        url = base_url + '/SIKBREC/public/bInfoOrderDarah/AddPemeriksaan/' + str;
    
        var win = window.open(url, '_blank');
        win.focus()
    
    }

    function showAddPemeriksaan(NoRegistrasi) {
        const base_url = window.location.origin;
        var str = btoa(NoRegistrasi);
        url = base_url + '/SIKBREC/public/bInfoOrderDarah/AddPemeriksaan/' + str;
    
        var win = window.open(url, '_blank');
        win.focus()
    
    }

    function loadDataPemeriksaanLab() { 
        var no_MR = $("#no_MR").val();
        var base_url = window.location.origin;
        $('#list_useblooddetail_arsip').dataTable({
               "bDestroy": true
           }).fnDestroy();
           $('#list_useblooddetail_arsip').DataTable({
               "ordering": true, // Set true agar bisa di sorting
               "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
               "columnDefs": [
                { "width": "20%", "targets": 8 },
              ],
               "ajax":
               {
                   "url": base_url + "/SIKBREC/public/bInformationHasilLab/getDataListbyNoMR", // URL file untuk proses select datanya
                   "type": "POST",
                   data: function ( d ) {
                   d.no_MR = no_MR;
                   },
                    "dataSrc": "",
               "deferRender": true,
               }, 
               "columns": [
                { "data": "NoMR" }, 
                { "data": "NamaPasien" },
                { "data": "birth_dt" },  
                { "data": "tglorder" },  
                { "data": "NoLab" },   
                { "data": "NoRegistrasi" },  
                { "data": "asuransi" },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                   var html  = '<td>'+row.email+'<br>'+row.nohp+'</td>';
                      return html 
    
             }
           }, 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                         var html = ""
                        var html  = '<td><div style="display: block; border: 1px; height: 65px; overflow-y: scroll">'+row.NamaTes+'</div></td>';
                           return html 
    
                  }
                },     
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                    if(row.Result == "1"){ 
                        var html  = '<span class="badge badge-success">Sudah Ada</span> '
                    }else{ 
                        var html  = '<span class="badge badge-danger">Belum Ada</span> '
                    }
                    return html
    
                  }
                }, 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                      var html = ""
                       
                        var html  = '<button title="Cetak Hasil" type="button" class="btn-xs btn-primary" id="btn_ctkhasil" onclick=\'print_hasillab("'+row.ID+'","'+row.DT_Validasi+'")\')"><i class="fa fa-print"></i> Cetak</button>'
                           return html 
                    }
                },
               ],
           });
    } 

    function print_hasillab(x,valdt) {
        //Cek Sudah Divalidasi?
        if (valdt=='' || valdt=='null')
        {
            toast('Maaf, Data Belum Divalidasi!', "warning")
          return false;
        }
    
        var base_url = window.location.origin;
                var win = window.open(base_url + "/SIKBREC/public/bInformationHasilLab/PrintHasil/" + x ,  "_blank", 
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
                win.focus();
    }

    async function showHandover(param) {
        try {
            $("#totalrow").val(0);
            document.getElementById('grantotalOrder').innerHTML = 0;
            const data = await goshowHandover(param);
            updateUIgoshowHandover(data);
        } catch (err) {
            toast(err, "error")
        }
    }

    async function goshowHandover(param) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/goshowHandover';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'IDDetail=' + param 
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
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }

    function updateUIgoshowHandover(data){
        if (data.status=='success'){
            $("#IDDetail").val(data.data.ID);
            $("#QtyPakaiHO").val(data.data.QtyPakai);
            $("#KantongKeHO").val(data.data.KantongKe);
            $("#JenisDarahHO").val(data.data.JenisDarah);
            $("#KetHO").val(data.data.Keterangan);
            $("#dateHO").val(data.data.handover_bdrs_perawat_date);
            $("#PetugasBDRS").val(data.data.handover_bdrs_perawat_petugasBDRS);
            $("#PetugasPerawat").val(data.data.handover_bdrs_perawat_petugasPerawat);
            $('#myModal').modal('show');
            showBarcodeList(data.data.ID);
        }else{
            toast(data.message,'warning')
        }
    }

    async function SaveHandOver() {
        try {
            if($("#totalrow").val() == 0){
                toast("Barcode Belum Diinput ! Silahkan Masukkan/Scan Barcode Terlebih Dahulu", 'warning');
                return false;
            }
            const data = await goSaveHandOver();
            updateUIgoSaveHandOver(data);
        } catch (err) {
            toast(err, "error")
        }
    }

    async function goSaveHandOver() {
        var base_url = window.location.origin;
        var IDDetail = $("#IDDetail").val();
        //var BarcodeHO = $("#BarcodeHO").val();
        var PetugasBDRS = $("#PetugasBDRS").val();
        var PetugasPerawat = $("#PetugasPerawat").val();
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/goHandOver';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'IDDetail=' + IDDetail +
                  '&PetugasBDRS=' + PetugasBDRS +
                  '&PetugasPerawat=' + PetugasPerawat 
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
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }
    
    function updateUIgoSaveHandOver(data) {
        let dataResponse = data;

        if (dataResponse.status=='success'){
            toast(dataResponse.message,'success')
            $('#myModal').modal('hide');
            showDataDetil();
        }else{
            toast(dataResponse.message,'warning')
        }
        
    }

    
    function showModalNoPIN(attr){
        $("#attribute").val(attr);
        $('#modalNoPIN').modal('show');
    }

    async function SaveTTDNoPIN() {
        try {
            const data = await goSaveTTDNoPIN();
            updateUIgoSaveTTDNoPIN(data);
        } catch (err) {
            toast(err, "error")
        }
    }

    async function goSaveTTDNoPIN() {
        var base_url = window.location.origin;
        var NoPIN_HO = $("#NoPIN_HO").val();
        var Password_HO = $("#Password_HO").val();
        var attribute = $("#attribute").val();
        let url = base_url + '/SIKBREC/public/bInfoOrderDarah/goSaveTTDNoPIN';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'NoPIN_HO=' + NoPIN_HO +
                  '&Password_HO=' + Password_HO +
                  '&attribute=' + attribute 
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
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }
    
    function updateUIgoSaveTTDNoPIN(data) {
        let dataResponse = data;
        if (dataResponse.status=='success'){
            toast(dataResponse.message,'success');
           $('#modalNoPIN').modal('hide');
           if (dataResponse.data.attribute == 'BDRS'){
              $("#PetugasBDRS").val(dataResponse.data.username);
           }else{
             $("#PetugasPerawat").val(dataResponse.data.username);
           }
        }else{
            toast(dataResponse.message,'warning')
        }
        
    }

    //GET DTL PO
function showBarcodeList(ID) {
    count = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/bInfoOrderDarah/showBarcodeList/";

    $.ajax({
        type: "POST",
        data: "ID=" + ID,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                count = count + 1;
                $("#totalrow").val(count);
                document.getElementById('grantotalOrder').innerHTML = count;
                // document.getElementById('totalrow').innerHTML = total_items;
                output = '<tr id="row_' + count + '">';
          output += '<td>' + val.JenisDarah + ' <input type="hidden" name="JenisDarah[]" id="JenisDarah' + count +'" class="hidden_kode_barang" value="' + val.JenisDarah + '" /></td>';
          output += '<td>' + val.Qty + ' <input type="hidden" name="Qty[]" id="Qty' + count +'" class="hidden_kode_barang" value="' + val.Qty + '" /></td>';
          output += '<td>' + val.ED + ' <input type="hidden" name="ED[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + val.ED + '" /></td>';
          output += '<td>' + val.Barcode + ' <input type="hidden" name="Barcode[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + val.Barcode + '" /></td>';
          output += '<td><input type="checkbox" onclick="return false;" readonly checked/></td>';
          output += '</tr>';


                dataHandler.append(output);
            });
            // CalculateQty();
            // CalculateItemsValueDiscon();
            // CalculateItemsValue();
            // CalculateItemsTax();

        }
    });

    $(".preloader").fadeOut();
}

function loadDataRiwayatTranfusi() { 
    var no_MR = $("#no_MR").val();
    var base_url = window.location.origin;
    $('#list_tranfusi_arsip').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#list_tranfusi_arsip').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "columnDefs": [
            { "width": "20%", "targets": 8 },
          ],
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataTranfusibyNoMR", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.no_MR = no_MR;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "NoRegistrasi" }, 
            { "data": "NoEpisode" },
            { "data": "NamaTarifDarah" },  
            { "data": "DateConsume" }, 
            { "data": "username" }, 
            { "data": "Barcode" },  
            { "data": "HistoryIncompatibility" },   
            { "data": "AutoControl" },  
            { "data": "ScreeningAntiBody" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
               if(row.Selesai_Tranfusi == "1"){ 
                   var html  = '<span class="badge badge-success">Selesai</span> '
               }else{ 
                   var html  = '<span class="badge badge-warning">Belum</span> '
               }
               return html

             }
           }, 
           ],
       });
} 