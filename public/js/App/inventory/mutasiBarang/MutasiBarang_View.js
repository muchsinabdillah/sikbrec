$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    //showDataDetil('TOM160120240004');

    $('#btnSearchMutasi').click(function () {
        $('#btnSearching_modal').modal('show');
    });

    $('#btnNewPurchase').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin buat transaksi baru ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    if ($("#NoOrderMutasi").val() == ''){
                        toast('No Order Mutasi Tidak Ditemukan !','warning');
                        return false
                    }
                    createHeaderTrs();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
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
                    goSaveMutasi();
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });

    $("#nama_Barang").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/PurchaseForm/getDataBarangbyName';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    //add bpjs
    $('#nama_Barang').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#xIdBarang").val(data.id);
        $("#xNamaBarang").val(data.text);

        getBarangbyId(data.id)
    });

    // $("#btnAdd").click(function () { 

    //     if($("#xNamaBarang").val() == ''){
    //         $("#xNamaBarang").focus();
    //         toast("Nama Barang Kosong !", 'warning');
    //         return false;
    //     }

    //     if($("#Qty").val() == '' || $("#Qty").val() == 0 ){
    //         $("#Qty").focus();
    //         toast("Qty Kosong !", 'warning');
    //         return false;
    //     }

    //       if($('#totalrow').val()==0){
    //         var count =0;
    //       }else{
    //         var count = parseFloat($('#totalrow').val());
    //       }
    //       count = count + 1;
    //       //document.getElementById('grantotalOrder').innerHTML = count;
    //       $('#totalrow').val(count);
        

    //       hidden_kode_barang = $('#xIdBarang').val();
    //       hidden_nama_barang_ = $('#xNamaBarang').val();
    //       hidden_satuan_barang_ = $('#Satuan').val();
    //       hidden_min_barang_ = $('#Qty').val();
    //       hidden_qty_barang_ = 5;
    //       hidden_hpp_barang_ = 5;
    //       hidden_total_barang_ = 5;
          
    //         output = '<tr id="row_' + count + '">';
    //         output = '<td>' + count + '</td>';
    //         output += '<td>' + hidden_kode_barang + ' <input type="hidden" name="hidden_kode_barang[]" id="hidden_kode_barang' + count +'" class="hidden_kode_barang" value="' + hidden_kode_barang + '" /></td>';
    //         output += '<td>' + hidden_nama_barang_ + ' <input type="hidden" name="hidden_nama_barang_[]" id="hidden_nama_barang_' + count +'" class="hidden_nama_barang_" value="' + hidden_nama_barang_ + '" /></td>';
    //         output += '<td>' + hidden_satuan_barang_ + ' <input type="hidden" name="hidden_satuan_barang_[]" id="hidden_satuan_barang_' + count +'" class="hidden_satuan_barang_" value="' + hidden_satuan_barang_ + '" /></td>';
    //         output += '<td>' + hidden_min_barang_ + ' <input type="hidden" name="hidden_min_barang_[]" id="hidden_min_barang_' + count +'" class="hidden_min_barang_" value="' + hidden_min_barang_ + '" /></td>';
    //         output += '<td>' + hidden_qty_barang_ + ' <input type="hidden" name="hidden_qty_barang_[]" id="hidden_qty_barang_' + count +'" class="hidden_qty_barang_" value="' + hidden_qty_barang_ + '" /></td>';
    //         output += '<td>' + hidden_hpp_barang_ + ' <input type="hidden" name="hidden_hpp_barang_[]" id="hidden_hpp_barang_' + count +'" class="hidden_hpp_barang_" value="' + hidden_hpp_barang_ + '" /></td>';
    //         output += '<td>' + hidden_total_barang_ + ' <input type="hidden" name="hidden_total_barang_[]" id="hidden_total_barang_' + count +'" class="hidden_total_barang_" value="' + hidden_total_barang_ + '" /></td>';
    //         output += '<td><button type="button" title="Hapus" name="remove_details_n" class="btn btn-danger btn-sm remove_details_n" id="' +
    //           count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
    //         output += '</tr>';
    //         $('#user_data').append(output);

    //         //$("#nama_Barang").select2('destroy');
    //         $("#xNamaBarang").val("");
    //         $("#Satuan").val("");
    //         $("#Qty").val('');
    //        // $('#tipepembayaran').focus(); 
            
    //     //}
    // });

    $("#btnAdd").click(function () { 

        if($("#xNamaBarang").val() == ''){
            $("#xNamaBarang").focus();
            toast("Nama Barang Kosong !", 'warning');
            return false;
        }

        if($("#Qty").val() == '' || $("#Qty").val() == 0 ){
            $("#Qty").focus();
            toast("Qty Kosong !", 'warning');
            return false;
        }

          if($('#totalrow_closing').val()==0){
            var count =0;
          }else{
            var count = parseFloat($('#totalrow_closing').val());
          }
          count = count + 1;
          document.getElementById('grantotalOrder_closing').innerHTML = count;
          $('#totalrow_closing').val(count);

        hidden_kode_barang = $('#xIdBarang').val();
          hidden_nama_barang_ = $('#xNamaBarang').val();
          hidden_satuan_barang_ = $('#Satuan').val();
          hidden_min_barang_ = $('#Qty').val();
          hidden_qty_barang_ = 5;
          hidden_hpp_barang_ = 5;
          hidden_total_barang_ = 5;

            output = '<tr id="row_closing_' + count + '">';
            output += '<td>' + hidden_kode_barang+ ' <input type="hidden" name="hidden_kode_barang[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_kode_barang+ '" /></td>';
            output += '<td>' + hidden_nama_barang_+ ' <input type="hidden" name="hidden_nama_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_nama_barang_+ '" /></td>';
            output += '<td>' + hidden_satuan_barang_+ ' <input type="hidden" name="hidden_satuan_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_satuan_barang_+ '" /></td>';
            output += '<td>' + hidden_min_barang_ + ' <input type="hidden" name="hidden_min_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_min_barang_ + '" /></td>';
            output += '<td>' + hidden_qty_barang_+ ' <input type="hidden" name="hidden_qty_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_qty_barang_+ '" /></td>';
            output += '<td>' + hidden_hpp_barang_+ ' <input type="hidden" name="hidden_hpp_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_hpp_barang_+ '" /></td>';
             output += '<td>' + hidden_total_barang_+ ' <input type="hidden" name="hidden_total_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_total_barang_+ '" /></td>';
            output += '<td><button type="button" title="Hapus" name="remove_details_closing" class="btn btn-danger btn-sm remove_details_closing" id="' +
              count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';
            $('#user_data_closing').append(output);
            
            //$("#nama_Barang").select2('destroy');
            $("#xNamaBarang").val("");
            $("#Satuan").val("");
            $("#Qty").val('');
            
    });

    $(document).on('click', '.remove_details_closing', function () {
    var row_id = $(this).attr("id");
    console.log(row_id);
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $('#row_closing_' + row_id + '').remove();
            $('#row_closing_')
            var count = $('#totalrow_closing').val();
            //console.log(count);
            count = count - 1 ;
            document.getElementById('grantotalOrder_closing').innerHTML = count;
            $('#totalrow_closing').val(count);
            toast('Berhasil Hapus !', "success")
        } else {
          //swal("Your imaginary file is safe!");
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
                goVoidMutasi(value);
            });
    });

//   $(document).on('click', '.remove_details_n', function () {
//     var row_id = $(this).attr("id");
//     console.log(row_id);
//     //$('#row_' + row_id ).remove();return false;
//    // $('#row_' + row_id ).remove();
//     //return false;
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
//             //document.getElementById('grantotalOrder').innerHTML = count;
//             $("#grantotalOrder").html(count);
//             $('#totalrow').val(count);
//             toast('Berhasil Hapus !', "success")
//         } else {
//           //swal("Your imaginary file is safe!");
//         }
//       });

//     });

});

async function createHeaderTrs() {
    try {
        const dataGocreateHdr = await GocreateHdr();
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataGocreateHdr(dataResponse) {
    if(dataResponse.status == true){
        toast(dataResponse.message, "success");
        $('#NoOrderTransaksi').val(dataResponse['data']);
        $("#btnNewPurchase").attr('disabled', true);
        showDataDetil($("#NoOrderMutasi").val());
        enableAll();
        $(".preloader").fadeOut();
    }else{
        toast(dataResponse.message, "error")
    }
}
function GocreateHdr() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var data = $("#form_hdr").serialize();
    var  date  = document.getElementById("TglTransaksi").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/createHeaderTrs_Mutasi/';
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

async function goSaveMutasi() {
    try {
        const datagoSaveMutasi = await goSaveMutasi2();
        updateUIdatagoSaveMutasi(datagoSaveMutasi);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoSaveMutasi(params) {
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
function goSaveMutasi2() {
    var base_url = window.location.origin;
    var date = document.getElementById("TglTransaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var data = $("#user_form, #form_hdr").serialize();
    // var TransasctionCode = document.getElementById("IdAuto").value;
    // var TotalQty = document.getElementById("pr_totalQty").value;
    // var TotalRow = document.getElementById("pr_totalRow").value;
    // var Notes = document.getElementById("pr_ketTransaksi").value;
    let url = base_url + '/SIKBREC/public/MutasiBarang/goSaveMutasiBarang/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data + '&TransasctionDate=' + TransasctionDate
                // + '&TotalQty=' + TotalQty
                // + '&TotalRow=' + TotalRow
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
    //  document.getElementById("xNamaBarang").disabled = true;
    //  document.getElementById("xIdBarang").disabled = true;
    //  document.getElementById("qty_Barang").disabled = true; 
    //  document.getElementById("SatuanBarang").disabled = true;
     // $("#btnAdd").attr('disabled', true);
    // $("#pr_btn_kembali").attr('disabled', true);
     $("#btn_batal").attr('disabled', true);
     $("#btnSave").attr('disabled', true); 
      $("#NamaBarang").attr('disabled', true);
     // $("#qty_Barang").attr('disabled', true);
     $("#nama_Barang").attr('disabled', true);
    // $("#btnAdd").attr('disabled', false);
     //$("#btnNewPurchase").attr('disabled', true);
 }
 function enableAll() {
     $("#nama_Barang").attr('disabled', false);
     // document.getElementById("pr_TglTransaksi").disabled = false;
     // document.getElementById("pr_status").disabled = false;
     // document.getElementById("pr_jenistransaksi").disabled = false;
     // document.getElementById("pr_unitTrnasaksi").disabled = false;
     // document.getElementById("pr_ketTransaksi").disabled = false;
    //  document.getElementById("xNamaBarang").disabled = false;
    //  document.getElementById("xIdBarang").disabled = false;
    //  document.getElementById("qty_Barang").disabled = false;
    //  document.getElementById("SatuanBarang").disabled = false;
    //  $("#btnAdd").attr('disabled', false);
     // $("#pr_btn_kembali").attr('disabled', false);
     $("#btn_batal").attr('disabled', false);
     $("#btnSave").attr('disabled', false);
      $("#NamaBarang").attr('disabled', false);
     // $("#qty_Barang").attr('disabled', false);
     // $("#btnAdd").attr('disabled', true);
     //$("#btnNewPurchase").attr('disabled', false);
     
 }

async function asyncShowMain() {
    try {
        await getHakAksesByForm(12); 
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#NoOrderTransaksi").val();
        disableAll();
        if (id != ""){
            const datagetMutasibyIDD = await getMutasibyID();  
            updateUIdatagetMutasibyIDD(datagetMutasibyIDD);
            enableAll();
        }
        
        $("#TglTransaksi").attr('readonly',true);
        $('#LokasiAwalOrderx option:not(:selected)').prop('disabled', true);
        $('#LokasiTujuanStokx option:not(:selected)').prop('disabled', true);
        $('#JenisStok').prop('readonly', true);
        $('#jenistransaksi').prop('readonly', true);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetMutasibyIDD(dataResponse) {
    var tgltrs = dataResponse.data[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
        
    $("#NoOrderMutasi").val(dataResponse.data[0].TransactionOrderCode);
    //$("#TransasctionDate").val(dataResponse.data[0].Golongan);
    $("#LokasiAwalOrderx").val(dataResponse.data[0].UnitTujuan).trigger('change');
    $("#LokasiTujuanStokx").val(dataResponse.data[0].UnitOrder).trigger('change');
    $("#UserInput").val(dataResponse.data[0].NamaUserCreate);
    $("#jenistransaksi").val(dataResponse.data[0].JenisMutasi);
    $("#JenisStok").val(dataResponse.data[0].JenisStok);
    $("#Notes").val(dataResponse.data[0].Notes);
    $("#LokasiAwalOrder").val(dataResponse.data[0].UnitTujuan);
    $("#LokasiTujuanStok").val(dataResponse.data[0].UnitOrder);


    $("#btnNewPurchase").attr('disabled', true);
    $("#btnSearchMutasi").attr('disabled', true);

    showDataDetil_View(dataResponse.data[0].TransactionCode);
}
function getMutasibyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/getMutasibyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + $("#NoOrderTransaksi").val()
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

function ShowApprovedDatabyDate() {
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();

    if (tglawal == '') {
        toast('Silahkan Isi Periode Awal !', 'warning')
        return false;
    }

    if (tglakhir == '') {
        toast('Silahkan Isi Periode Akhir !', 'warning')
        return false;
    }
    var base_url = window.location.origin;
    $('#datatable_pr').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_pr').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/OrderMutasiBarang/getOrderMutasibyPeriode",
            //"url": base_url + "/SIKBREC/public/PurchaseForm/getPurchaseRequisitionbyDateUser",
            "type": "POST",
            "data": {
                tglawal: tglawal,
                tglakhir: tglakhir
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransactionCode + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TransactionDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUserCreate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Notes + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JenisMutasi + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.StatusPR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""

                    if (row.Approved == '0'){
                        var approve = 'disabled';
                    }else{
                        var approve = '';
                    }
                    // var html = '<button type="button" class="btn btn-primary btn-xs border-primary"  onclick=ShowHeaderbyID("' + row.TransactionCode + '")'+approve+'>Pilih</button>'
                    var html = '<button type="button" class="btn btn-maroon btn-xs border-primary"  onclick=ShowHeaderbyID("' + row.TransactionCode + '") '+approve+'>Pilih</button>'
                    return html
                },
            },
        ]
    });
}


//GET HDR PR
async function ShowHeaderbyID(param) {
    try {
        const datagetOrderMutasibyID = await getOrderMutasibyID(param);
        updateUIdatagetOrderMutasibyID(datagetOrderMutasibyID);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetOrderMutasibyID(dataResponse) {
    if (dataResponse.status === true) {
        $(".preloader").fadeOut();
        var tgltrs = dataResponse.data[0].TransactionDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
            
        $("#NoOrderMutasi").val(dataResponse.data[0].TransactionCode);
        $("#LokasiAwalOrderx").val(dataResponse.data[0].UnitTujuan).trigger('change');
        $("#LokasiTujuanStokx").val(dataResponse.data[0].UnitOrder).trigger('change');
        $("#UserInput").val(dataResponse.data[0].NamaUserCreate);
        $("#jenistransaksi").val(dataResponse.data[0].JenisMutasi);
        $("#JenisStok").val(dataResponse.data[0].JenisStok);
        $("#Notes").val(dataResponse.data[0].Notes);
        $("#LokasiAwalOrder").val(dataResponse.data[0].UnitTujuan);
        $("#LokasiTujuanStok").val(dataResponse.data[0].UnitOrder);
        //unlockBtnCreate();
        enableAll();
        //showDataDetil(dataResponse.data[0].TransactionCode);

        toast('Data berhasil dipilih !', 'success');

        $('#btnSearching_modal').modal('hide');
    } else {
        toast(params.message, "error")
    }
}
function getOrderMutasibyID(TransasctionCode) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    //var TransasctionCode = 'TPR160820220002'; 
    let url = base_url + '/SIKBREC/public/OrderMutasiBarang/getOrderMutasibyID/';
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
            $(".preloader").fadeOut();
        })
}

function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#LokasiAwalOrderx").append(newRow);
        $("#LokasiTujuanStokx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#LokasiAwalOrderx").append(newRow);
            $("#LokasiTujuanStokx").append(newRow);
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
            $("#LokasiAwalOrderx").select2();
            $("#LokasiTujuanStokx").select2();
        })
}

function CalculateALL() {
    var totalqty = 0;
    var totalsubtotal = 0;
    var totalhpp = 0;

    for (i = 1; i <= total_items; i++) {

        itemID = document.getElementById("hidden_qty_barang_" + i);

        var qty = price_to_number($("#hidden_qty_barang_" + i).val());
        var Hpp = price_to_number($("#hidden_hpp_barang_" + i).val());
       // var Subtotal = $("#hidden_total_barang_" + i).val();

        if (typeof itemID === 'undefined' || itemID === null) {
            alert("No such item - " + "hidden_qty_barang_" + i);
        } else {

            var subtotalx = qty * (Hpp);
            
            //TOTAL  
            var totalqty = totalqty + parseFloat(qty);
            var totalhpp = totalhpp + parseFloat(Hpp);
            var totalsubtotal = totalsubtotal + subtotalx;
            
            $("#hidden_total_barang_" + i).val(number_to_price(subtotalx));
        }

    //FOOTER
    $("#grandtotalqty").val(number_to_price(totalqty));
    $("#HppTotal").val(number_to_price(totalhpp));
    $("#grandtotalxl").val(number_to_price(totalsubtotal));

    $("#grandtotalqty_text").text(number_to_price(totalqty));
    $("#HppTotal_text").text(number_to_price(totalhpp));
    $("#grandtotalxl_text").text(number_to_price(totalsubtotal));
    }
    

}

function showDataDetil(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data_closing");
    dataHandler.html("");

     //var TransasctionCode = "TOM050920220007"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/OrderMutasiBarang/getOrderMutasiDetailbyID/";

    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                total_items = total_items + 1;

                //convert titik jadi koma
                converted_QtySisaMutasi = val.QtySisaMutasi.replace(".", ",");
                converted_QtyOrderMutasi = val.QtyOrderMutasi.replace(".", ",");
                converted_discprosen = val.QtySisaMutasi.replace(".", ",");
                converted_hpp = val.Hpp.replace(".", ",");
                // converted_discrp = val.DiscountRp.replace(".", ",");
                // converted_discrpttl = val.DiscountRpTTL.replace(".", ",");
                // converted_sbttl = val.SubtotalDeliveryOrder.replace(".", ",");
                // converted_taxprosen = val.TaxProsen.replace(".", ",");
                // converted_taxrp = val.TaxRp.replace(".", ",");
                // converted_taxrpttl = val.TaxRpTTL.replace(".", ",");
                // converted_total = val.TotalDeliveryOrder.replace(".", ",");

                $("#totalrow").val(total_items);
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            //*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ newRow.html("'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.Satuan_Konversi + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.Satuan +"' ></td> '"+
            /*5*/"' <td>" + converted_QtySisaMutasi + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + converted_QtySisaMutasi + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + converted_QtySisaMutasi +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' onkeydown='FormatCell(this)' name='hidden_hpp_barang_[]'   id='hidden_hpp_barang_" + total_items + "' class='harga' value='" + converted_hpp + "' ></td> '"+
            /*8*/"' <td><input size='1' readonly value='" + converted_QtyOrderMutasi + "' type='text' name='hidden_total_barang_[]'   id='hidden_total_barang_" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.Konversi_QtyTotal + "' type='hidden' name='Konversi_QtyTotal[]'   id='Konversi_QtyTotal" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.Satuan_Konversi + "' type='hidden' name='Satuan_Konversi[]'   id='Satuan_Konversi" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.KonversiQty + "' type='hidden' name='KonversiQty[]'   id='KonversiQty" + total_items +"' ></td>"+
            // /*9*/"' <td><input size='5' readonly='true' value='" + val.DiscountRp + "' type='text' name='hidden_discrp_barang_[]'  style'width: 1sx' id='hidden_discrp_barang_" + total_items +"' ></td> '"+
            // /*10*/"' <td><input size='7' readonly='true' value='" + val.SubtotalPurchase + "' type='text' name='hidden_subtotal_[]' style'width: 1sx' id='hidden_subtotal_" + total_items +"' ></td> '"+
            // /*11*/"' <td><input size='1' readonly value='" + val.TaxProsen + "' type='text' onkeyup='CalculateItemsTax()'   name='hidden_taxprosen_[]' style'width: 1sx' id='hidden_taxprosen_" + total_items +"' ></td> '"+
            // /*12*/"' <td><input size='5' readonly='true' value='" + val.TaxRp + "'  type='text' name='hidden_taxrp_[]' style'width: 1sx' id='hidden_taxrp_" + total_items + "' ></td> '"+
            // /*13*/"' <td><input size='8' readonly='true'  value='" + val.TotalPurchase + "'   type='text' name='hidden_grandtotal_[]' style'width: 1sx' id='hidden_grandtotal_" + total_items +"' ></td>" +
            /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " +
                "</td>  </tr>")
                ;


                dataHandler.append(newRow);
            });
            CalculateALL();
            // CalculateQty();
            // CalculateItemsValueDiscon();
            // CalculateItemsValue();
            // CalculateItemsTax();

        }
    });

    $(".preloader").fadeOut();
}

//GET DETAIL MUTASI BY ID
function showDataDetil_View(TransasctionCode) {
    //var TransasctionCode = document.getElementById("IdAuto").value;
    total_items = 0;
    var dataHandler = $("#user_data_closing");
    dataHandler.html("");

     //var TransasctionCode = "TOM050920220007"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/OrderMutasiBarang/getMutasiDetailbyID/";

    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                total_items = total_items + 1;

                //convert titik jadi koma
                converted_QtyOrder = val.QtyOrder.replace(".", ",");
                converted_QtyMutasi = val.QtyMutasi.replace(".", ",");
                converted_Hpp = val.Hpp.replace(".", ",");

                $("#totalrow").val(total_items);
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            //*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ newRow.html("'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <td>" + val.Satuan_Konversi + "<input type='hidden' name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items +"' value='" + val.Satuan +"' ></td> '"+
            /*5*/"' <td>" + converted_QtyOrder + "<input type='hidden'  name='hidden_min_barang_[]' id='hidden_min_barang_" + total_items + "' value='" + converted_QtyOrder + "' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items + "' value='" + converted_QtyMutasi +"' ></td> '"+
            /*7*/"' <td><input size='5' readonly  type='text' name='hidden_hpp_barang_[]' onkeydown='FormatCell(this)'  id='hidden_hpp_barang_" + total_items + "' class='harga'  value='" + converted_Hpp + "' ></td> '"+
            /*8*/"' <td><input size='1' readonly value='" + val.Total + "' type='text' name='hidden_total_barang_[]'   id='hidden_total_barang_" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.Konversi_QtyTotal + "' type='hidden' name='Konversi_QtyTotal[]'   id='Konversi_QtyTotal" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.Satuan_Konversi + "' type='hidden' name='Satuan_Konversi[]'   id='Satuan_Konversi" + total_items +"' >"+
            /*8*/"<input size='1'  value='" + val.KonversiQty + "' type='hidden' name='KonversiQty[]'   id='KonversiQty" + total_items +"' ></td>"+
             /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</button> " +
            // /*14*/"<td>  " +
                "</td>  </tr>")
                ;


                dataHandler.append(newRow);
            });
            CalculateALL();

        }
    });

    $(".preloader").fadeOut();
}


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

//--------------------------------------------------



function updateUIdataGetGolonganbyID(dataResponse) {
    $("#NamaGolongan").val(dataResponse.data[0].Golongan);
}
function GetGolonganbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterGolongan/getGolonganbyId/';
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MutasiBarang/list";
}
async function saveGolongan() {

    $(".preloader").fadeIn(); 
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    
    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var NamaGolongan = document.getElementById("NamaGolongan").value; 
    var url = '';
    if(IdAuto == "" ){
        url = base_url + '/SIKBREC/public/MasterGolongan/addGolongan';

    }else{
        url = base_url + '/SIKBREC/public/MasterGolongan/editGolongan';
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaGolongan=" + NamaGolongan 
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

function getIDAwal(e){
    $("#LokasiAwalOrder").val(e.value);
}

function getIDTujuan(e){
    $("#LokasiTujuanStok").val(e.value);
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
function convertNumberToRp() {
    var Nominal = document.getElementById("Nominal");
    Nominal.addEventListener("keyup", function (e) {
        Nominal.value = formatRupiah(this.value);
    });
}

function converttoCurrency(number){
    var n = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 12 }).format(number);
    return n
}

function FormatCell(element){
    var elementid = document.getElementById(element.id);
    elementid.addEventListener("keyup", function (e) {
    elementid.value = formatRupiah(this.value);
    CalculateALL();
});
}

async function goVoidMutasi(param) {
    try {
        $(".preloader").fadeIn();
        const data = await VoidMutasi(param);
        updateUIdatagoVoidMutasi(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function VoidMutasi(param) {
    var No_Transaksi = document.getElementById("NoOrderTransaksi").value;
    var LokasiAwalOrder = document.getElementById("LokasiAwalOrder").value;
    var LokasiTujuanStok = document.getElementById("LokasiTujuanStok").value;
    var NoOrderMutasi = document.getElementById("NoOrderMutasi").value;
    var JenisStok = document.getElementById("JenisStok").value;
    var url2 = "/SIKBREC/public/MutasiBarang/voidMutasi";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&LokasiAwalOrder=" + LokasiAwalOrder + "&LokasiTujuanStok=" + LokasiTujuanStok + "&NoOrderMutasi=" + NoOrderMutasi + "&JenisStok=" + JenisStok
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

function updateUIdatagoVoidMutasi(data) {
    if (data.status == true) {
        toast(data.message, "success");
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    } else {
        toast(data.message, "error")
    }
}

function goVoidDetails(product_code) {
    swal("Alasan Hapus:", {
        content: "input",
        buttons: true,
    })
        .then((value) => {
            if (value == '') {
                swal("Alasan Hapus Harus Diisi ! Simpan Gagal !");
                return false;
            } else if (value == null) {
                return false;
            }
            // swal(`You typed: ${value}`);
            goVoidMTDetailsByID(product_code, value);
        });
}

async function goVoidMTDetailsByID(product_code, param) {
    try {
        $(".preloader").fadeIn();
        const data = await VoidMTDetailsByID(product_code, param);
        updateUIdatagoVoidMTDetailsByID2(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function VoidMTDetailsByID(product_code, param) {
    var No_Transaksi = document.getElementById("NoOrderTransaksi").value;
    var LokasiAwalOrder = document.getElementById("LokasiAwalOrder").value;
    var LokasiTujuanStok = document.getElementById("LokasiTujuanStok").value;
    var NoOrderMutasi = document.getElementById("NoOrderMutasi").value;
    var url2 = "/SIKBREC/public/MutasiBarang/voidMutasiDetailbyItem";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&product_code=" + product_code + "&LokasiAwalOrder=" + LokasiAwalOrder + "&LokasiTujuanStok=" + LokasiTujuanStok + "&NoOrderMutasi=" + NoOrderMutasi
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

function updateUIdatagoVoidMTDetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_View($("#NoOrderTransaksi").val());
    } else {
        toast(data.message, "error")
    }
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