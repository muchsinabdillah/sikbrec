$(document).ready(function () {
    onloadForm();
    $('#example').dataTable({
    })

    $('#btnNewTransaksi').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Buat Transaksi Baru?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    addHeader();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    // $('#Save_Signa').click(function () {
    //     goSaveSigna();
    // });

    $('#btnSimpan').click(function () {
        swal({
            title: "Simpan",
            text: "Pastikan Data yang dimasukan sudah sesuai, Lanjut Simpan?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //goFinishPurchaseOrder();
                    goFinishEditOrder();
                } else {
                    // swal("Transaction Rollback !");
                }
            });
    });

    $('#btnprint').click(function () {
        //$("#notif_Cetak").modal('show');
        $('#notif_Cetak').modal(
            {
            backdrop: 'static',
            keyboard: false,
             show: true
            })  
    });

    $("#btnPrintLabelAll").click(function() {
        CetakLabelAll();
    })

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
                VoidSales(value);
            });
    });

    $("#btnCetakResep").click(function() {
        var notrs = $("#No_Order").val(); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aPenjualanDenganResep/CetakResepv2/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    })

    $("#btnCopyResep").click(function() {
        var notrs = $("#No_Order").val(); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aPenjualanDenganResep/CopyResepv2/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    })

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
              Unit: $('#Unit_Farmasi').val(),
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
              $(this).val(ui.item.label);
              $("#xIdBarang").val(ui.item.id);
              $("#Qty").focus();
              //getBarangbyId(ui.item.id);

              $("#xNamaBarang").val(ui.item.label);
              $("#QtyStok").val(ui.item.qty);
              $("#Satuan").val(ui.item.Satuan_Beli);
              //$("#hpp_add").val(ui.item.NilaiHpp);
              $("#HargaProduct").val(ui.item.NilaiHpp);
              $("#Satuan_Konversi").val(ui.item.Satuan);
              $("#Konversi_satuan").val(ui.item.konversisatuan); 
              return false; 
          }
  });

        $('#btnAdd').click(function () {
            AddRowTemp();
        });

        $("#Qty").keyup(function(event) {
            if (event.keyCode === 13) {
                AddRowTemp();
            }
        });

    //     const template = `
    //     <tr role="row">
    //         <td role="cell" data-label="#i" >
    //             <a href="javascript:void(0);" class="btn btn-danger btn-sm remove">
    //                 <i class="fa fa-times"></i>
    //             </a>
    //        </td>
    //        <td role="cell" data-label="Name">
    //             <input type="name" name="name[]" class="form-control"
    //                     data-validation-engine="validate[required,custom[onlyLetterSp],maxSize[20]]"
    //             />
    //        </td>
    //        <td role="cell" data-label="Email">
    //             <input type="email" name="email[]"  class="form-control"
    //                     data-validation-engine="validate[required,custom[email]]"
    //             />
    //        </td>
    //        <td role="cell" data-label="Phone">
    //             <input type="text" name="phone[]"  class="form-control"
    //                     data-validation-engine="validate[required,custom[phone]]"
    //             />
    //        </td>
    //         <td role="cell" data-label="Actions">
    //             <a href="javascript:void(0);" class="btn btn-warning btn-sm lock">
    //                 <i class="fa fa-unlock"></i>
    //             </a>
    //              <a href="javascript:void(0);" class="btn btn-success btn-sm edit">
    //                 <i class="fa fa-edit"></i>
    //             </a>
    //        </td>
    //    </tr>
    //   `;


    //     $('.table-clone-row').manageFormTables({
    //     templateRow: template,
    //     removeRowTarget: '.remove',
    //     addRowTarget: '.add-row',
    //     minRowsVisible: 1,
    //     debug: 1,
    //     senderTarget: '.sender',
    //     tableFormTitle: 'Example Form Table',
    //     onErrorRowsVisible: function (element, form) {
    //         $(element).parent().bootstrapAlert({
    //             heading: 'Error, Deleting Row',
    //             content: 'Cannot delete this record as at least one row must exist!',
    //             type: 'danger'
    //         });
    //     },
    //     onSubmit: function (form) {
    //         console.log(form);
    //     },
    //     events:[
    //         {
    //             targetName: '.lock',
    //             eventName: 'click',
    //             onEvent: function () {
    //                 const _this = $(this);
    //                 const tr = _this.closest("tr");
    //                 if(_this.hasClass('in-lock')){
    //                     tr.find('input').removeAttr('readonly').removeClass('disabled');
    //                     tr.find('.remove').removeClass('disabled');
    //                     _this.removeClass('in-lock btn-info').addClass('btn-warning');
    //                     _this.html('<i class="fa fa-unlock"></i>');
    //                 }else {
    //                     tr.find('input').attr('readonly', true).addClass('disabled');
    //                     _this.addClass('in-lock btn-info').removeClass('btn-warning');
    //                     tr.find('.remove').addClass('disabled');
    //                     _this.html('<i class="fa fa-lock"></i>');
    //                 }
    //             }
    //         }
    //     ]

    //     });

    $('#btnClosePrintModal').click(function () {
         MyBack();
    });
    

});
async function onloadForm() {
    //await getHakAksesByForm(18);
    const dataGetLayanan = await GetLayanan();
    updateUIdataGetLayanan(dataGetLayanan);
    
    //await showdatatabel();
    if ($("#No_Transaksi").val() != '') {
        const data = await getSalesbyID();  
        updateUIdatagetSalesbyID(data);
    }else{
        const dataunitbyIP = await getUnitbyIP();
        updateUIdataunitbyIP(dataunitbyIP);
        const data = await getHeader($("#No_Order").val());
        updateUIdataHeader(data);
    }
    $('#Unit option:not(:selected)').prop('disabled', true);
}
// function showdatatabel(OrderID) {
//     const base_url = window.location.origin;
//     //$(".preloader").fadeOut();
//     $('#example').dataTable({
//         "bDestroy": true
//     }).fnDestroy();
//     $('#example').DataTable({
//         "ordering": true,
//         "ajax": {
//             "url": base_url + "/SIKBREC/public/aPenjualanDenganResep/getOrderResepDetail",
//             "type":"POST",
//             "data": {
//                 "OrderID": OrderID
//             },
//             "dataSrc": "",
//             "deferRender": true,
//         },
//         "columns": [
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.ID + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.KodeBarang + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.NamaBarang + ' </font>  ';
//                     return html
//                 }
//             }, 

//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.QryOrder + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.QryRealisasi + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.QryRealisasi + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.QryRealisasi + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""
//                     var html = '<font size="1"> ' + row.QryRealisasi + ' </font>  ';
//                     return html
//                 }
//             },
//             {
//                 "render": function (data, type, row) {
//                     var html = ""
//                     var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick=showPenjualanBarangDenganResep("' + row.ID + '") ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
//                     return html
//                 },
//             },
//         ]
//     });
// }

function showdatatabel(OrderID) {
    total_items = 0;
    var NoRegistrasi = $("#NoRegistrasi").val();
    var KodeKelas = $("#KodeKelas").val();
    var dataHandler = $("#user_data");
    //dataHandler.html("");

    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/getOrderResepDetail";

    $.ajax({
        type: "POST",
        data: "OrderID=" + OrderID + "&NoRegistrasi=" + NoRegistrasi + "&KodeKelas=" + KodeKelas ,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                
                if (val.SignaTerjemahan == null || val.SignaTerjemahan == ''){
                    var LabelClassNamaBarang = 'danger';
                }else{
                    var LabelClassNamaBarang = 'success'
                }

                

                if (val.SignaTerjemahan == null){
                    var  signaterjemahan = '';
                }else{
                    var signaterjemahan = val.SignaTerjemahan
                }

                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                var NamaBarang = val.NamaBarang;

                if (val.Racik != 0){
                    if (val.Header == true){
                        //var isracik = '<span class="label label-info">RACIK NO '+val.Racik+'</span>';
                        var isracik = 'RACIK NO '+val.Racik;
                        //var issignaracik = "<br>Signa Latin: "+val.Signa+"<br>Signa Terjemahan: "+val.SignaTerjemahan;
                        //var NamaBarang = '<span class="label label-info onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                        var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value='" + signaterjemahan +"'>";
                    }else{
                        //var isracik = '<span class="label label-info">KOMPONEN RACIK NO '+val.Racik+'</span>';
                        var isracik = 'KOMPONEN RACIK NO '+val.Racik;
                        //var issignaracik = "";
                        //var NamaBarang = '<span class="label label-info" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                        var signaterjemahanext = "<input type='hidden'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value=''>";
                    }
                }else{
                      //var isracik = '<span class="label label-warning">NON RACIK</span>';
                      var isracik = 'NON RACIK';
                      //var issignaracik = "<br>Signa Latin: "+val.Signa+"<br>Signa Terjemahan: "+val.SignaTerjemahan;
                     // var NamaBarang = '<span class="label label-warning onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                      var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value='" + signaterjemahan +"'>";
                }

                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='" + total_items + "'>");
            /*1*/  newRow.html(
            /*2*/ "'<td><font size='2'>" + isracik +"<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_" + total_items + "' value='" + val.Racik +"' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_" + total_items + "' value='" + val.Header +"' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_" + total_items + "' value='" + val.ID +"' ></font></td>'"+
            /*3*/"'<td><font size='1'>" + val.Satuan + "<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_" + total_items + "' value='" + val.Konversi_satuan +"' ></font></td>'"+
            /*2*/ "'<td>" + val.KodeBarang +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang" + total_items + "'  value='" + val.KodeBarang +"' ></font></td> '"+
            /*3*/"'<td><font size='3'>" + NamaBarang +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_" + total_items + "' value='" + val.NamaBarang +"' ></font></td>'"+
            /*3*/"'<td><font size='1'>" + val.Signa +"<input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_" + total_items + "' value='" + val.Signa +"' ></font></td>'"+
            /*3*/"'<td><font size='2'>"+signaterjemahanext+"</font></td>'"+
            /*4*/"' <td>" + val.QryOrder + "<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +"' value='" + parseFloat(val.QryOrder) +"' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + parseFloat(val.QryOrder) +"' ></td> '"+
            /*5*/"' <td>" + number_to_price(val.Harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(val.Harga) + "' ></td> '"+
            /*3*/"'<td><font size='1'><input style='width: 75px;' type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+val.UangR+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+val.Embalase+"'></td> '"+
            /*3*/"'<td><font size='1'><input style='width: 75px;' type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
                `<td><button type='button' onclick='CetakLabelPdf(${total_items})' name='cetak_label' class='btn btn-info btn-xs cetak_label btn-rounded' ><i class="fa fa-print"></i> Label</button>&nbsp<button type='button' name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='${total_items}' ><i class="fa fa-close"></i> Delete</button></td>`+
            // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus></td> " +
                "  </tr>")
                ;


                dataHandler.append(newRow);
            });
            calculateAllDetail();
            // CalculateQty();
            // CalculateItemsValueDiscon();
            // CalculateItemsValue();
            // CalculateItemsTax();

        }
    });

    $(".preloader").fadeOut();
}

function showPenjualanBarangDenganResep(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aPenjualanDenganResep/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanDenganResep/";
}

async function addHeader() {
    try {
        $(".preloader").fadeIn();
        const data = await createHeader();
        updateUIdatacreateHeader(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeader(params) {

    if (params.status === true) {
        swal({
            title: "Success",
            text: 'Berhasil Membuat Transaksi Baru!',
            icon: "success",
        });
        toast(params.message, "success");
        $("#No_Transaksi").val(params.data);
        unlockBtnCreate();
        showdatatabel($("#No_Order").val());
        //showDataDetil_PO($("#No_PurchasingOrder").val());
        //MyBack();
    } else if(params.message == 'The given data was invalid.') {
        const message = Object.values(params.errors)[0][0];
        toast(params.message, "error");
        swal({
            title: "Warning",
            text: message,
            icon: "warning",
        })
    }else{
        toast(params.message, "error")
        swal({
            title: "Warning",
            text: params.message,
            icon: "warning",
        })
    }

}
function createHeader() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_Penjualan").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/addSalesHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate=" +TransasctionDate
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

function unlockBtnCreate() {
    if ($("#No_Transaksi").val() == '') {
        $("#btnNewTransaksi").attr('disabled', false);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);
        $("#nama_Barang").attr('disabled', true);
        $("#btnAdd").attr('disabled', true);
        $("#Qty").attr('disabled', true);
        $("#SignaTerjemahan").attr('disabled', true);

    // } else if ($("#No_Transaksi").val() == '' && $("#No_PurchasingOrder").val() == '') {
    //     $("#btnNewTransaksi").attr('disabled', true);
    //     $("#btnSimpan").attr('disabled', true);
    //     $("#btn_batal").attr('disabled', true);
    } else {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', false);
        $("#btn_batal").attr('disabled', false);
        $("#btnSearching").attr('disabled', true);
        $("#nama_Barang").attr('disabled', false);
        $("#btnAdd").attr('disabled', false);
        $("#Qty").attr('disabled', false);
        $("#SignaTerjemahan").attr('disabled', false);
    }
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

function updateUIdataHeader(params) {
    if (params.status === true) {

        //$("#No_Transaksi").val(params.data[0].TransactionCode);
        $("#No_MR").val(params.data[0].NoMR);
        $("#NoRegistrasi").val(params.data[0].NoRegistrasi);
        //$("#Tgl_Penjualan").val(params.data[0].TglPenjualan);
        $("#JenisKelamin").val(params.data[0].JenisKelamin);
        $("#No_Order").val(params.data[0].OrderID);
        $("#Tgl_Lahir").val(params.data[0].dob);
        $("#Umur").val(params.data[0].umur+' Tahun');
        $("#Tgl_Order").val(params.data[0].TglResepRaw);
        $("#Nama").val(params.data[0].PatientName);
        $("#Dokter").val(params.data[0].NamaDokter);
        $("#Alamat").val(params.data[0].Address);
        $("#Unit").val(params.data[0].UnitOrder).trigger('change');
        //$("#Unit_Farmasi").val(params.data[0].UnitSales).trigger('change');
        $("#Jaminan").val(params.data[0].NamaJaminan);
        $("#KodeJaminan").val(params.data[0].KodeJaminan);
        $("#TipePasien").val(params.data[0].TipePasien);
        $("#KodeKelas").val(params.data[0].KodeKelas);
        //$("GrupJaminan").val('UM');
        $("#No_Episode").val(params.data[0].NoEpisode);
        $("#Iter").val(params.data[0].Iter);
        //$("#Notes").val(params.data[0].Notes);
        //$("#Unit").prop("disabled", true);
        
        // var tgltrs = params.data[0].TglPenjualan;
        // var d = new Date(tgltrs);
        // d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        // $('#Tgl_Penjualan').val(d.toISOString().substring(0,d.toISOString().length-1));

        //if (params.data[0].TransactionCode != null){
        //showdatatabel(params.data[0].OrderID);
        //}
        
        unlockBtnCreate();

    } else {
        //toast(params.message, "error")
        swal({
            title: "Warning",
            text: params.message,
            icon: "warning",
        })
    }
}
function getHeader(OrderID) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPenjualanDenganResep/viewOrderResepbyOrderIDV2/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'OrderID=' + OrderID
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
        $("#Unit").append(newRow);
        $("#Unit_Farmasi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#Unit").append(newRow);
            $("#Unit_Farmasi").append(newRow);
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
            // $("#Unit").select2();
            // $("#Unit_Farmasi").select2();
        })
}

// function updateSignaTerjemahan(ID,Racik,Header,NamaBarang,SignaLatin,SignaTerjemahan){
//     if (Header == false && Racik != 0){
//         toast("Tidak bisa edit signa di komponen racik ! Silahkan ubah pada Header Racik !",'warning')
//         return false;
//     }
//     $("#modal_editsigna").modal('show');
//     $("#id_detail").val(ID);
//     $("#namaobat_signa").val(NamaBarang);
//     $("#Signa_latin").val(SignaLatin);
//     if (SignaTerjemahan == 'null'){
//         var SignaTerjemahan = null;
//     }
//     $("#Signa_edit").val(SignaTerjemahan);
// }

// async function goSaveSigna() {
//     try {
//         const datagoSaveSigna = await goSaveSigna2();
//         updateUIdatagoSaveSigna(datagoSaveSigna);
//     } catch (err) {
//         toast(err.message, "error")
//     }
// }

// function updateUIdatagoSaveSigna(params) {
//     let response = params;
//     if (response.status == "success") {
//         toast(response.message, "success")
//         swal({
//             title: "Simpan Berhasil!",
//             text: response.message,
//             icon: "success",
//         })
//         getListDataOrderDetails();
//         $("#modal_editsigna").modal('hide');
//     }else{
//         toast(response.message, "error")
//     }  

// }

// function goSaveSigna2() {
//     var data = $("#form_editsigna").serialize();
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/Farmasi/EditSignaNew';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body:  data 
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
    if (v == 0) { return '0'; }
    v = parseFloat(v);
    v = v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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
    calculateAllDetail();
});
}

function calculateAllDetail(){
    var subtotal = 0;
    var grandtotal = 0;  
    var qtytotal = 0;
    var hargamindiskon = 0;
    var grandtotaldiskonrp = 0;
    var totalSubtotalAfterDiskon = 0;
    var grandtotaltax = 0;
    var grandtotalPurchase = 0;
    var grandtotalPurchase = 0;
    var taxrp = 0;
    var grantotalxloop = 0;
    var taxrp_stn = 0;
    var hargatotal = 0;
    var subtotal_all = 0;
    var disconprosen_all = 0;
    var total_items = $('#totalrow').val();
    //console.log($("#hidden_qty_barang_2").val());return false; 
    for (i = 1; i <= total_items; i++) {
        var idx = $('#datatable_prdetail tr').eq(i).attr('id');
        //var qtyx = document.getElementById("hidden_qty_barang_" + i);

        var qty = parseFloat(price_to_number($("#hidden_qtyreal_barang_" + idx).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_qty_barang_" + idx).val()));
        var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + idx).val()));
        //var disconprosen = 0;
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + idx).val()));
        var taxprosen = parseFloat(price_to_number($("#hidden_taxprosen_" + idx).val()));
        //var taxprosen = 0;


        // if (typeof qtyx === 'undefined' || qtyx === null) {
        //     alert("No such item - " + "hidden_qty_barang_" + idx); 
        // } else {
            if (qty > qtymr) {
                toast('Qty Order Lebih Besar daripada Qty Real !', 'warning'); 
                $("#hidden_qtyreal_barang_"+idx).val(0);
                return false;
            } else  { 
                subtotal = parseFloat(harga) * qty;
                hargamindiskon = (parseFloat(disconprosen) * parseFloat(harga)) / 100; 
                hargamindiskonQty = (parseFloat(harga) - hargamindiskon) * qty;
                hargamindiskonTok = (parseFloat(harga) - hargamindiskon);
                totaldiskonrp = hargamindiskon*qty;
                disconprosen_all += disconprosen;

                grandtotaldiskonrp = grandtotaldiskonrp + totaldiskonrp;

                hargatotal += harga;

               
                qtytotal = qtytotal + parseFloat(qty);
                totalSubtotalAfterDiskon = hargamindiskonQty+totalSubtotalAfterDiskon;

                taxrp = (parseFloat(taxprosen)*hargamindiskonQty) / 100;
                grandtotal = hargamindiskonQty;
                grandtotaltax = grandtotaltax + taxrp;
                grandtotalPurchase = hargamindiskonQty ;
                grantotalxloop = grantotalxloop + grandtotalPurchase;
                taxrp_stn = (parseFloat(taxprosen)*hargamindiskonTok)/100;
                subtotal_all = subtotal_all + subtotal;
                
            }
            $("#hidden_discrpttl_barang_" + idx).val(number_to_price(totaldiskonrp));
            $("#hidden_discrp_barang_" + idx).val(number_to_price(hargamindiskon));
            $("#hidden_subtotal_" + idx).val(number_to_price(subtotal));
            $("#grandtotalqty" + idx).val(number_to_price(qtytotal));
            $("#hidden_taxrp_" + idx).val(number_to_price(taxrp));
            $("#hidden_taxrp2_" + idx).val(number_to_price(taxrp_stn));
            $("#hidden_grandtotal_" + idx).val(number_to_price(grandtotalPurchase));
            $("#hidden_harga_barang_" + idx).val(number_to_price(harga));
 

        //}
      
    }

    $("#diskonxPros").val(number_to_price(disconprosen_all));
    $("#diskonxRp").val(number_to_price(grandtotaldiskonrp));
    $("#grandtotalqty").val(number_to_price(qtytotal));
    $("#subtotalttlrp").val(number_to_price(subtotal_all));
    $("#taxxRp").val(number_to_price(grandtotaltax));
    $("#grandtotalxl").val(number_to_price(grantotalxloop));

    $("#diskonxRp_tmp").text(number_to_price(grandtotaldiskonrp));
    $("#grandtotalqty_tmp").text(number_to_price(qtytotal));
    $("#subtotalttlrp_tmp").text(number_to_price(subtotal_all));
    $("#taxxRp_tmp").text(number_to_price(grandtotaltax));
    $("#grandtotalxl_tmp").text(number_to_price(grantotalxloop));
    $("#hargatotal").val(number_to_price(hargatotal));
    $("#hargatotal_tmp").text(number_to_price(hargatotal));
}

async function goFinishEditOrder() {
    try {
        $(".preloader").fadeIn();
        const data = await goEditFinish();
        updateUIdatagoFinish(data);
    } catch (err) {
        console.log(err);
        toast(err, "error");
    }
}

function goEditFinish() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Penjualan").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/addSalesDetail";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
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

function updateUIdatagoFinish(data) {
    if (data.status == true) {
        toast(data.message, "success");
        goFinishEditOrder2();
        // swal({
        //     title: 'Success',
        //     text: data.message,
        //     icon: 'success',
        // }).then(function() {
        //     MyBack();
        // });
    } else {
        toast(data.message, "error")
        swal({
            title: "Warning",
            text: data.message,
            icon: "warning",
        })
    }
}

async function goFinishEditOrder2() {
    try {
        $(".preloader").fadeIn();
        const data = await goEditFinish2();
        updateUIdatagoFinish2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function goEditFinish2() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Penjualan").value;
    // var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    // var TransactionCode = $("#No_Transaksi").val();
    // var Unit_Farmasi = $("#Unit_Farmasi").val()
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/finishSalesTransaction";
    var base_url = window.location.origin;
    let url = base_url + url2;
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

function updateUIdatagoFinish2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            //MyBack();
            $('#notif_Cetak').modal(
                {
                 backdrop: 'static',
                 keyboard: false,
                 show: true
                })  
        });
    } else {
        toast(data.message, "error")
        swal({
            title: "Warning",
            text: data.message,
            icon: "warning",
        })
    }
}

async function CetakLabelAll() {
    try {
        $(".preloader").fadeIn();
        const data = await goCetakLabelAll();
        updateUIdataLabelAll(data);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataLabelAll(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        // swal({
        //     title: "Simpan Berhasil!",
        //     text: response.message,
        //     icon: "success",
        // })
    }else{
        //toast(response.message, "error")
        swal({
            title: "Warning",
            text: response.message,
            icon: "warning",
        })
    }  
    $(".preloader").fadeOut();

}

function goCetakLabelAll() {
    var orderid = $("#No_Order").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/CetakLabelAll_New';
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

async function VoidSales(param) {
    try {
        $(".preloader").fadeIn();
        const data = await goVoidSales(param);
        updateUIgoVoidSales(data);
    } catch (err) {
        toast(err, "error")
    }
}

function goVoidSales(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var Unit = document.getElementById("Unit_Farmasi").value;
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/voidSales";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&Unit=" + Unit
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


function updateUIgoVoidSales(params) {
    let response = params;
    if (response.status == true) {
        toast(response.message, "success")
         swal({
            title: 'Success',
            text: response.message,
            icon: 'success',
        }).then(function() {
            MyBack();
        });
    }else{
        //toast(response.message, "error")
        swal({
            title: "Warning",
            text: response.message,
            icon: "warning",
        })
    }  
    $(".preloader").fadeOut();

}

function MyBack() {
    // const base_url = window.location.origin;
    // window.location = base_url + "/SIKBREC/public/aPenjualanDenganResep/list";
    // //location.reload();
    window.close();
}

async function updateUIdatagetSalesbyID(dataResponse) {
    //console.log(dataResponse);return false;
    var tgltrs = dataResponse.data[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#Tgl_Penjualan').val(d.toISOString().substring(0,d.toISOString().length-1));
    $('#Tgl_Penjualan').prop('readonly',true);

    dob = new Date(dataResponse.data[0].TglLahirPembeli);
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

    $("#JenisKelamin").val(dataResponse.data[0].GenderPembeli);
    $("#Tgl_Lahir").val(dataResponse.data[0].TglLahirPembeli);
    $("#Nama").val(dataResponse.data[0].NamaPembeli);
    $("#Alamat").val(dataResponse.data[0].AlamatPembeli);
    $("#Notes").val(dataResponse.data[0].Notes);
    $("#Tgl_Order").val(dataResponse.data[0].TglResepRaw);
    // $("#Unit").val(dataResponse.data[0].UnitSales);
    // $("#Unit_Select").val(dataResponse.data[0].UnitSales).trigger('change');
    // $("#Unit_Farmasi").val(dataResponse.data[0].UnitSales).trigger('change');
    // $("#NIP_Karyawan").val(dataResponse.data[0].NIPKaryawan);
    //$("#JenisPasien").val(dataResponse.data[0].JenisPasien);
    $("#TipePasien").val(dataResponse.data[0].GroupJaminan);
    //$("#KodeJaminan_Select").val(dataResponse.data[0].KodeJaminan).trigger('change');

    $("#No_MR").val(dataResponse.data[0].NoMR);
    $("#NoRegistrasi").val(dataResponse.data[0].NoRegistrasi);
    //$("#JenisKelamin").val(dataResponse.data[0].JenisKelamin);
    $("#No_Order").val(dataResponse.data[0].OrderID);
    //$("#Tgl_Lahir").val(dataResponse.data[0].dob);
    $("#Umur").val(age+' Tahun');
    //$("#Tgl_Order").val(dataResponse.data[0].TglResepRaw);
    //$("#Nama").val(dataResponse.data[0].PatientName);
    $("#Dokter").val(dataResponse.data[0].NamaDokter);
    //$("#Alamat").val(dataResponse.data[0].Address);
    $("#Unit").val(dataResponse.data[0].UnitOrder).trigger('change');
    $("#Unit_Farmasi").val(dataResponse.data[0].UnitSales).trigger('change');
    $("#Jaminan").val(dataResponse.data[0].NamaJaminan);
    $("#KodeJaminan").val(dataResponse.data[0].KodeJaminan);
    //$("#TipePasien").val(dataResponse.data[0].TipePasien);
    $("#KodeKelas").val(dataResponse.data[0].KodeKelas);
    $("#No_Episode").val(dataResponse.data[0].NoEpisode);
    $("#Iter").val(dataResponse.data[0].Iter);
    $("#No_Order").val(dataResponse.data[0].NoResep);
    $("#HasilReview").val(dataResponse.data[0].HasilReview);

    
    //$('#Unit_Farmasi option:not(:selected)').prop('disabled', true);

    unlockBtnCreate()


    $("#btnNewTransaksi").attr('disabled', true);

    showdatatabelview(dataResponse.data[0].TransactionCode);
    //await showDataDetilTable()
}
async function getSalesbyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPenjualanDenganResep/getSalesbyIDandNoResep/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + $("#No_Transaksi").val() + '&NoResep=' + $("#No_Order").val() 
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

function updateUIdataunitbyIP(dataResponse) {
    if (dataResponse.status == true){
        $("#Unit_Farmasi").val(dataResponse.data[0].UnitCode).trigger('change');
        $('#Unit_Farmasi option:not(:selected)').prop('disabled', true);
    }else{
        swal("IP komputer ini belum disetting / dimapping di master unit ! Silahkan cek dan tambahkan IP ini di Master IP Unit Farmasi !",{
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then(function() {
            MyBack();
        });
        $("#Unit_Select").prop('disabled',true)
    }
}

async function getUnitbyIP() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPenjualanTanpaResep/getUnitbyIP/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + $("#No_Transaksi").val()
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

function showdatatabelview(TransactionCode) {
    total_items = 0;
    var dataHandler = $("#user_data");
    //dataHandler.html("");

    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/aPenjualanDenganResep/getSalesDetailbyIDandNoResep";

    $.ajax({
        type: "POST",
        data: "TransactionCode=" + TransactionCode + "&NoResep=" + $("#No_Order").val(),
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                //console.log(val);
                
                if (val.SignaTerjemahan == null || val.SignaTerjemahan == ''){
                    var LabelClassNamaBarang = 'danger';
                }else{
                    var LabelClassNamaBarang = 'success'
                }
                

                if (val.AturanPakai == null){
                    var  signaterjemahan = '';
                }else{
                    var signaterjemahan = val.AturanPakai
                }

                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                if (val.Racik != 0){
                    if (val.Header == true){
                        var isracik = '<span class="label label-info">RACIK NO '+val.Racik+'</span>';
                        var isracik = 'RACIK NO '+val.Racik+'';
                        var NamaBarang = '<span class="label label-'+LabelClassNamaBarang+'" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                        var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value='" + signaterjemahan +"'>";
                    }else{
                        var isracik = '<span class="label label-info">KOMPONEN RACIK NO '+val.Racik+'</span>';
                        var isracik =  'KOMPONEN RACIK NO '+val.Racik+'';
                        var NamaBarang = '<span class="label label-info" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                        var signaterjemahanext = "<input type='hidden'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value=''>";
                    }
                }else{
                      //var isracik = '<span class="label label-warning">NON RACIK</span>';
                      var isracik = 'NON RACIK';
                      var NamaBarang = '<span class="label label-'+LabelClassNamaBarang+'" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                      var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value='" + val.AturanPakai +"'>";
                }

                // document.getElementById('totalrow').innerHTML = total_items;
                
                //convert titik jadi koma
                converted_disc = val.Discount.replace(".", ",");
                converted_grandtotal = val.Grandtotal.replace(".", ",");
                converted_harga = val.Harga.replace(".", ",");
                converted_hpp = val.Hpp.replace(".", ",");
                converted_konversiqtytotal = val.Konversi_QtyTotal.replace(".", ",");
                converted_qty = val.Qty.replace(".", ",");
                converted_qtyresep = val.QtyResep.replace(".", ",");
                converted_qtysalesremain = val.QtySalesRemain.replace(".", ",");
                converted_subtotal = val.Subtotal.replace(".", ",");
                converted_tax = val.Tax.replace(".", ",");
                converted_uangr = val.UangR.replace(".", ",");
                converted_embalase = val.Embalase.replace(".", ",");

                var newRow = `
                            <tr id="${total_items}">
                            <td><font size='2'>${isracik}</font><input type='hidden'  name='hidden_racik_[]' id='hidden_racik_'${total_items}' value='${val.Racik}' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_'${total_items}' value='${val.Header}' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'${total_items}' value='${val.ID}'><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'${total_items}' value='${val.Satuan}' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'${total_items}' value='${val.KonversiQty}' ></font><input  size='2'  type='hidden'  name='uangr[]' id='uangr${total_items}' value='${converted_uangr}'><input  size='2'  type='hidden'  name='embalase[]' id='embalase${total_items}' value='${converted_embalase}'></td>
                            <td><font size='1'>${val.Satuan}<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'${total_items}' value='${val.Satuan}' ></td>
                            <td>${val.ProductCode}<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang${total_items}' value='${val.ProductCode}' ></font></td>'
                            <td><font size='2'>${val.ProductName}<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'${total_items}' value='${val.ProductName}' ></font></td>
                            <td>${val.Signa}<font size='2'><input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_${total_items}' value='${val.Signa}' ></font></td>
                            <td><input type="text" name="hidden_signa_terjemahan[]" id="hidden_signa_terjemahan${total_items}" value="${val.AturanPakai}"</td>
                            <td>${converted_qtyresep}<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_${total_items}' value='${converted_qtyresep}' ></td>
                            <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_${total_items}' value='${converted_qty}' ></td> 
                            <td>${number_to_price(converted_harga)}<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_${total_items}' value='${parseFloat(converted_harga)}' ></td>
                            <td><font size='1'><input style="width: 75px;" type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_${total_items}' readonly></font></td>
                            <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_${total_items}' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_${total_items}' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_${total_items}' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_${total_items}' ></td>
                            <td><font size='1'><input style="width: 75px;" type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_${total_items}' readonly></font></td>
                            <td><button type='button' name='cetak_label' class='btn btn-info btn-xs cetak_label btn-rounded' value='${val.ID}' 
                            onclick='CetakLabelPdf("${total_items}")
                            '><i class="fa fa-print"></i> Label</button>&nbsp<button type='button'  name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='${total_items}' ><i class="fa fa-close"></i> Delete</button></td>
                            </tr>
                `;
                //   onclick='CetakLabelPerItem("${val.ProductCode}","${val.SignaTerjemahan}","${converted_qty}")

            //     var newRow = $("<tr id='row_'" + total_items + "'>");
            // /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            // /*2*/ "'<td><font size='2'>" + isracik +"<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_'" + total_items + "' value='" + val.Racik +"' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_'" + total_items + "' value='" + val.Header +"' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'" + total_items + "' value='" + val.ID +"' ></font></td>'"+
            // /*3*/"'<td><font size='1'>" + val.Satuan + "<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'" + total_items + "' value='" + val.Satuan_Beli +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'" + total_items + "' value='" + val.Konversi_satuan +"' ></font><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+converted_uangr+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+converted_embalase+"'></td>'"+
            // /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang" + total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            // /*3*/"'<td><font size='2'>" + val.ProductName +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            // /*3*/"'<td><font size='2'><input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_'" + total_items + "' value='' ></font></td>'"+
            // /*3*/"'<td><font size='2'>"+signaterjemahanext+"</font></td>'"+
            // /*4*/"' <td>" + converted_qty + "<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +"' value='" + converted_qty +"' ></td> '"+
            // /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + converted_qtyresep +"' ></td> '"+
            // /*5*/"' <td>" + number_to_price(converted_harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(converted_harga) + "' ></td> '"+
            // /*3*/"'<td><font size='1'><input type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
            // /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ></td> '"+
            // /*3*/"'<td><font size='1'><input type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
            // // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus></td> " +
            //     "  </tr>")
            //     ;


                dataHandler.append(newRow);
            });
            calculateAllDetail();
            // CalculateQty();
            // CalculateItemsValueDiscon();
            // CalculateItemsValue();
            // CalculateItemsTax();

        }
    });

    $(".preloader").fadeOut();
}

async function AddRow(){
    try {
        $(".preloader").fadeIn();
        const dataGocreateDtl = await GocreateDtl();
        updateUIdataGocreateDtl(dataGocreateDtl);
        //showDataDetilTable();
    } catch (err) {
        toast(err, "error")
    }
}

async function showDataDetilTable() {
    var TransasctionCode = document.getElementById("No_Transaksi").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPenjualanTanpaResep/getSalesDetailbyID/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.TransactionCode = TransasctionCode; 
            }
        },
        "columns": [
        
            
            { "data": "ID" },
            { "data": "ProductCode" },
            { "data": "Satuan" },
            { "data": "ProductCode" },
            { "data": "ProductName" },
            { "data": "AturanPakai" },
            { "data": "AturanPakai" },
            { "data": "QtyResep" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = "<input  size='2'  type='text'   value='" + row.Qty +"' >"
                    return html
                }
            },
            { "data": "Harga", render: $.fn.dataTable.render.number('.', ',', 2, '') }, 
            { "data": "Subtotal", render: $.fn.dataTable.render.number('.', ',', 2, '') }, 
            { "data": "Discount", render: $.fn.dataTable.render.number('.', ',', 2, '') }, 
            { "data": "Grandtotal", render: $.fn.dataTable.render.number('.', ',', 2, '') }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-gold btn-animated btn-xs"  ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
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
        //         .column(5)
        //         .data()
        //         .reduce(function (a, b) {
        //             return intVal(a) + intVal(b);
        //         }, 0);
 

        //     $(api.column(5).footer()).html(
        //         $.fn.dataTable.render.number('.', ',', 2,'').display(total15)
        //     );
        //     $("#pr_totalQty").val(total15);
        //     var table = $('#tbl_aktif').DataTable();
        //     var table_length = table.data().count();
        //     $("#pr_totalRow").val(table_length)
            
             
        // },
    });
    //$(".preloader").fadeOut();
} 
function updateUIdataGocreateDtl(dataResponse) {
    if(dataResponse.status == false){
        toast(dataResponse.message, "error")
    }else{
        toast(dataResponse.message, "success")
        $('#nama_Barang').val('');
        $('#xNamaBarang').val('');
        $('#xIdBarang').val('');
        $('#qty_Barang').val('');
        $('#SatuanBarang').val('');
        $('#SatuanBarang_Konversi').val('');
        $('#Konversi_Satuan').val('');
        $("#nama_Barang").focus();
    }
     
}
function GocreateDtl() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("IdAuto").value;
    var ProductName = document.getElementById("xNamaBarang").value;
    var ProductCode = document.getElementById("xIdBarang").value;
    var QtyPR = document.getElementById("qty_Barang").value;
    var SatuanBarang = document.getElementById("SatuanBarang").value;
    var SatuanBarang_Konversi = document.getElementById("SatuanBarang_Konversi").value;
    var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/aPenjualanDenganResep/createDtlTrs/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
            + '&ProductCode=' + ProductCode
            + '&ProductName=' + ProductName
            + '&QtyPR=' + QtyPR 
            + '&SatuanBarang=' + SatuanBarang 
            + '&SatuanBarang_Konversi=' + SatuanBarang_Konversi 
            + '&Konversi_Satuan=' + Konversi_Satuan 
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

$(document).on('click', '.remove_details', function () {
    var row_id = $(this).attr("id");
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            //$('#row_' + row_id + '').remove();
            $(this).closest("tr").remove();
            var count = $('#totalrow').val();
            count = count - 1 ;
            //document.getElementById('grantotalOrder').innerHTML = count;
            $('#totalrow').val(count);
            toast('Berhasil Hapus !', "success")
            calculateAllDetail();
        } else {
          //swal("Your imaginary file is safe!");
        }
      });

    });

    async function AddRowTemp(){
        try {
            if ($("#xIdBarang").val() == ''){
                toast('Silahkan masukkan nama barang yang dipilih!','warning');
                $("#nama_Barang").focus();
                return false;
            }
            if ($("#Qty").val() == ''){
                toast('Silahkan masukkan qty !','warning');
                $("#Qty").focus();
                return false;
            }
            if ($("#SignaTerjemahan").val() == ''){
                toast('Silahkan masukkan Signa !','warning');
                $("#SignaTerjemahan").focus();
                return false;
            }

            const ProductCode = $("#xIdBarang").val()
            ,ProductName = $("#xNamaBarang").val()
            ,Satuan = $("#Satuan").val()
            ,Racik = 0
            ,Header = 0
            ,ID = null
            ,Satuan_Konversi = $("#Satuan_Konversi").val()
            ,Konversi_satuan = $("#Konversi_satuan").val()
            ,converted_uangr = 0
            ,converted_embalase=0
            ,SignaTerjemahan=$("#SignaTerjemahan").val()
            ,Qty=$("#Qty").val()
            ,HargaProduct=$("#HargaProduct").val().replace(".", ",")
            ,Subtotal=HargaProduct*Qty
            ,disc=0
            ,grandtotal=Subtotal

            if($('#totalrow').val()==0){
                var count =0;
                var countid =0;
              }else{
                var count = parseFloat($('#totalrow').val());
                var countid = parseFloat($('#datatable_prdetail >tbody >tr:last').attr('id'));
              }


              for (i = 1; i <= count; i++) { 
                //console.log($('#datatable_prdetail tr').eq(i).attr('id'))
                if (ProductCode == $("#hidden_kode_barang"+$('#datatable_prdetail tr').eq(i).attr('id')).val() ){
                    swal({
                        title: "Warning",
                        text: ProductName+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!',
                        icon: "warning",
                    });
                    toast(ProductName+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!','warning');
                    return false;
                }
            }

              count = count + 1;
              countid = countid + 1;
              $('#totalrow').val(count);

            output = `
            <tr id="${countid}">
            <td>NON RACIK<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_'${countid}' value='${Racik}' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_'${countid}' value='${Header}' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'${countid}' value='${ID}'><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'${countid}' value='${Satuan_Konversi}' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'${countid}' value='${Konversi_satuan}' ></font><input  size='2'  type='hidden'  name='uangr[]' id='uangr${countid}' value='${converted_uangr}'><input  size='2'  type='hidden'  name='embalase[]' id='embalase${countid}' value='${converted_embalase}'></td>
            <td>${Satuan_Konversi}<input type="hidden" name="hidden_satuan_barang_[]" id="hidden_satuan_barang_${countid}" value="${Satuan_Konversi}" /></td>
            <td>${ProductCode} <input type="hidden" name="hidden_kode_barang[]" id="hidden_kode_barang${countid}" value="${ProductCode}" /></td>
            <td><font size='2'>${ProductName}</font> <input type="hidden" name="hidden_nama_barang_[]" id="hidden_nama_barang_${countid}" value="${ProductName}" /></td>
            <td>${SignaTerjemahan}<input type="hidden" name="hidden_signa_latin_[]" id="hidden_signa_latin_${countid}" value="${SignaTerjemahan}" /></td>
            <td><input type="text" name="hidden_signa_terjemahan[]" id="hidden_signa_terjemahan${countid}" value="${SignaTerjemahan}" /></td>
            <td><div id='qtyordertemp${countid}'>${Qty}</div><input type="hidden" name="hidden_qty_barang_[]" id="hidden_qty_barang_${countid}" value="${Qty}" /></td>
            <td><input size='2' type="text" onkeydown='changeQtyInput(this,${countid});' name="hidden_qtyreal_barang_[]" id="hidden_qtyreal_barang_${countid}" value="${Qty}" /></td>
            <td>${HargaProduct}<input type="hidden" name="hidden_harga_barang_[]" id="hidden_harga_barang_${countid}" value="${HargaProduct}" /></td>
            <td><input style="width: 75px;" size="1" readonly type="text" name="hidden_subtotal_[]" id="hidden_subtotal_${countid}" value="${Subtotal}" /></td>
            <td><input size="1" type="text" onkeydown='FormatCell(this)' name="hidden_discpros_barang_[]" id="hidden_discpros_barang_${countid}" value="${disc}" /><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_${countid}' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_${countid}' value='0'></td>
            <td><input style="width: 75px;" size="1" readonly type="text" name="hidden_grandtotal_[]" id="hidden_grandtotal_${countid}" value="${grandtotal}" /></td>
            <td><button type='button' name='cetak_label' class='btn btn-info btn-xs cetak_label btn-rounded'
                            onclick='CetakLabelPdf("${countid}")
                            '><i class="fa fa-print"></i> Label</button>&nbsp <button type='button' name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='${countid}' ><i class="fa fa-close"></i> Delete</Hapus></td>
            </tr>
            `;

            $('#user_data').append(output);

            $('#nama_Barang').val('');
            $('#xNamaBarang').val('');
            $('#xIdBarang').val('');
            $('#Qty').val('');
            $('#SatuanBarang').val('');
            $('#Satuan_Konversi').val('');
            $('#Konversi_Satuan').val('');
            $('#QtyStok').val('');
            $('#HargaProduct').val('');
            $('#SignaTerjemahan').val('');
            $("#nama_Barang").focus();
            calculateAllDetail()
        } catch (err) {
            toast(err, "error")
        }
    }

  async function changeQtyInput (element,row) {
            var elementid = document.getElementById(element.id);
            elementid.addEventListener("keyup", function (e) {
                $("#hidden_qty_barang_"+row).val(this.value);
                $("#qtyordertemp"+row).html(this.value);
                elementid.value = formatRupiah(this.value);
                calculateAllDetail();
        });
    }

    async function CetakLabelPerItem(code,signa,qtyreal) {
        try {
            $(".preloader").fadeIn();
            const data = await goCetakLabelPerItem(code,signa,qtyreal);
            updateUIdataLabelAll(data);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function updateUIdataLabelAll(params) {
        let response = params;
        if (response.status == "success") {
            toast(response.message, "success")
        }else{
            swal({
                title: "Warning",
                text: response.message,
                icon: "warning",
            })
        }  
        $(".preloader").fadeOut();
    
    }
    
    async function goCetakLabelPerItem(code,signa,qtyreal) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aPenjualanDenganResep/CetakLabelPerItem';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body:  
            'NoMR=' + $("#No_MR").val() +
            '&PatientName=' + $("#Nama").val() +
            '&NoRegistrasi=' + $("#NoRegistrasi").val() +
            '&dob=' + $("#Tgl_Lahir").val() +
            '&TglResep=' + $("#Tgl_Order").val() +
            '&ProductCode=' + code +
            '&SignaTerjemahan=' + signa +
            '&QtyReal=' + qtyreal
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
//     $(document).on('click', '.cetak_label', function () {

//         CetakLabel();

//   });
    // function CetakLabel(){
    // // var notrs = $(this).attr("id");
    // var notrs = $("#No_Order").val(); 

    //     // var notrs = iddetail; 
    //     console.log(notrs);return false;
    //         var base_url = window.location.origin;
    //         window.open(base_url + "/SIKBREC/public/aPenjualanDenganResep/CetakLabel/" + notrs , "_blank",
    //             "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    // }

    function CetakLabelPdf(index){
        const code = $("#hidden_kode_barang"+index).val()
        const signa = $("#hidden_signa_terjemahan"+index).val()
        const qty = $("#hidden_qtyreal_barang_"+index).val()

        const NoMR = $("#No_MR").val() 
        const PatientName = $("#Nama").val() 
        const NoRegistrasi = $("#NoRegistrasi").val() 
        const dob = $("#Tgl_Lahir").val() 
        const TglResep = $("#Tgl_Order").val() 
        const notrs = $("#No_Order").val() 
            const obj = JSON.parse(`
                {
                "productcode":"${code}", 
                "signa":"${signa}", 
                "qty":"${qty}",
                "NoMR":"${NoMR}",
                "PatientName":"${PatientName}",
                "NoRegistrasi":"${NoRegistrasi}",
                "dob":"${dob}",
                "TglResep":"${TglResep}",
                "notrs":"${notrs}"
                }
                `);
            var mybj = JSON.stringify(obj);
            var mybj = btoa(mybj);
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/aPenjualanDenganResep/CetakLabelPdf/" + mybj , "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    }