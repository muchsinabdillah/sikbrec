$(document).ready(function () {
    onloadForm();
    $(".preloader").fadeOut();

    $('#btnSearchMutasi').click(function () {
        $('#btnSearching_modal').modal('show');
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
                VoidSales(value);
            });
    });

    $('#btnprint').click(function () {
        $("#notif_Cetak").modal('show');
    });

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

    // $('#btnAdd').click(function () {
    //     AddRow();
    // });

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
              //$("#HargaProduct").val(ui.item.NilaiHpp);
              $("#Satuan_Konversi").val(ui.item.Satuan);
              $("#Konversi_satuan").val(ui.item.konversisatuan);
              getHargaJualFix(ui.item.id); 
              return false; 
          }
  })

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

          if($('#totalrow').val()==0){
            var count =0;
            var countid =0;
          }else{
            var count = parseFloat($('#totalrow').val());
            var countid = parseFloat($('#datatable_prdetail >tbody >tr:last').attr('id'));
          }
          count = count + 1;
          countid = countid + 1;
          total_items = count;
          //document.getElementById('grantotalOrder').innerHTML = count;
          $('#totalrow').val(count);
          $('#grantotalOrder').text(count);

        hidden_kode_barang = $('#xIdBarang').val();
          hidden_nama_barang_ = $('#xNamaBarang').val();
          hidden_satuan_barang_ = $('#Satuan').val();
          Satuan_Konversi = $('#Satuan_Konversi').val();
          Konversi_satuan = $('#Konversi_satuan').val();
          hidden_min_barang_ = $('#Qty').val();
          hidden_qty_barang_ = 5;
          hidden_hpp_barang_ = 5;
          hidden_total_barang_ = 5;
          hidden_signa_terjemahan = $('#SignaTerjemahan').val();
          harga = number_to_price($('#HargaProduct').val());
          UangR = 0;
          Embalase = 0;

          var totalitem = $("#totalrow").val();
            for (i = 1; i <= totalitem; i++) { 
                if (hidden_kode_barang == $("#hidden_kode_barang"+$('#datatable_prdetail tr').eq(i).attr('id')).val() ){
                    swal({
                        title: "Warning",
                        text: hidden_nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!',
                        icon: "warning",
                    });
                    toast(hidden_nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!','warning');
                    return false;
                }
            }

          var isracik = 'NON RACIK'

          var val = {
            Racik: "0",
            Header: "0",
            ID: null,
            Satuan:hidden_satuan_barang_,
            Satuan_Konversi:Satuan_Konversi,
            Konversi_satuan:Konversi_satuan,
            KodeBarang:hidden_kode_barang,
            NamaBarang:hidden_nama_barang_,
            Signa:"",
            SignaTerjemahan:hidden_signa_terjemahan,
            QryOrder:hidden_min_barang_,
            Harga:harga,
            UangR:UangR,
            Embalase:Embalase,
            }
        //   var newRow = $("<tr id='row_'" + total_items + "'>");
        //     /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
        //     /*2*/ "'<td><font size='2'>" + isracik +"<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_'" + total_items + "' value='" + val.Racik +"' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_'" + total_items + "' value='" + val.Header +"' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'" + total_items + "' value='" + val.ID +"' ></font></td>'"+
        //     /*3*/"'<td><font size='1'>" + val.Satuan_Konversi + "<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'" + total_items + "' value='" + val.Satuan_Konversi +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'" + total_items + "' value='" + val.Konversi_satuan +"' ></font></td>'"+
        //     /*2*/ "'<td>" + val.KodeBarang +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang" + total_items + "' value='" + val.KodeBarang +"' ></td> '"+
        //     /*3*/"'<td><font size='2'>" + val.NamaBarang +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.NamaBarang +"' ></font></td>'"+
        //     /*3*/"'<td><font size='2'>" + val.Signa +"<input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_'" + total_items + "' value='" + val.Signa +"' ></font></td>'"+
        //     /*3*/"'<td><font size='2'><input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan'" + total_items + "' value='" + val.SignaTerjemahan +"'></font></td>'"+
        //     /*4*/"' <td>" + val.QryOrder + "<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +"' value='" + val.QryOrder +"' ></td> '"+
        //     /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + val.QryOrder +"' ></td> '"+
        //     /*5*/"' <td>" + number_to_price(val.Harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(val.Harga) + "' ></td> '"+
        //     /*3*/"'<td><font size='1'><input type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
        //     /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+val.UangR+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+val.Embalase+"'></td> '"+
        //     /*3*/"'<td><font size='1'><input type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
        //     // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus></td> " +
        //         "  </tr>")
        //         ;

            var newRow = `
                    <tr id='${countid}'>
                    <td><font size='2'>${isracik}<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_${countid}' value='${val.Racik}' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_${countid}' value='${val.Header}' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'${countid}' value='${val.ID}' ></font></td>
                    <td><font size='1'>${val.Satuan_Konversi}<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_${countid}' value='${val.Satuan}' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_${countid}' value='${val.Satuan_Konversi}' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'${countid}' value='${val.Konversi_satuan}' ></font></td>
                    <td>${val.KodeBarang}<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang${countid}' value='${val.KodeBarang}' ></td>
                    <td><font size='2'>${val.NamaBarang}<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_${countid}' value='${val.NamaBarang}' ></font></td>
                    <td><font size='2'>${val.Signa}<input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_'${countid}' value='${val.Signa}' ></font></td>
                    <td><font size='2'><input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan${countid}' value='${val.SignaTerjemahan}'></font></td>
                    <td>${val.QryOrder}<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_${countid}' value='${val.QryOrder}' ></td>
                    <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_${countid}' value='${val.QryOrder}' ></td>
                    <td>${number_to_price(val.Harga)}<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_${countid}' value='${parseFloat(val.Harga)}' ></td>
                    <td><font size='1'><input type='text' style="width: 75px;" name='hidden_subtotal_[]' id='hidden_subtotal_${countid}' readonly></font></td>
                    <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_${countid}' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_${countid}' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_${countid}' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_${countid}' ><input  size='2'  type='hidden'  name='uangr[]' id='uangr${countid}' value='${val.UangR}'><input  size='2'  type='hidden'  name='embalase[]' id='embalase${countid}' value='${val.Embalase}'></td>
                    <td><font size='1'><input type='text' style="width: 75px;" name='hidden_grandtotal_[]' id='hidden_grandtotal_${countid}' readonly></font></td>
                    <td><button type='button' name='cetak_label' class='btn btn-info btn-xs cetak_label btn-rounded'onclick='CetakLabelPdf("${countid}")'><i class="fa fa-print"></i> Label</button>&nbsp <button type='button' name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='${countid}' ><i class="fa fa-close"></i> Delete</Hapus></td>
            `

            // output = '<tr id="row_closing_' + count + '">';
            // output += '<td>' + hidden_kode_barang+ ' <input type="hidden" name="hidden_kode_barang[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_kode_barang+ '" /></td>';
            // output += '<td>' + hidden_nama_barang_+ ' <input type="hidden" name="hidden_nama_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_nama_barang_+ '" /></td>';
            // output += '<td>' + hidden_satuan_barang_+ ' <input type="hidden" name="hidden_satuan_barang_[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + hidden_satuan_barang_+ '" /></td>';
            // output += '<td>' + hidden_min_barang_ + ' <input type="hidden" name="hidden_min_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_min_barang_ + '" /></td>';
            // output += '<td>' + hidden_qty_barang_+ ' <input type="hidden" name="hidden_qty_barang_[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + hidden_qty_barang_+ '" /></td>';
            // output += '<td>' + hidden_hpp_barang_+ ' <input type="hidden" name="hidden_hpp_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_hpp_barang_+ '" /></td>';
            //  output += '<td>' + hidden_total_barang_+ ' <input type="hidden" name="hidden_total_barang_[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + hidden_total_barang_+ '" /></td>';
            // output += '<td><button type="button" title="Hapus" name="remove_details_closing" class="btn btn-danger btn-sm remove_details_closing" id="' +
            //   count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            // output += '</tr>';
            $('#user_data').append(newRow);
            
            calculateAllDetail();
            
            //$("#nama_Barang").select2('destroy');
            $("#xIdBarang").val("");
            $("#xNamaBarang").val("");
            $("#Satuan").val("");
            $("#Qty").val('');
            $("#nama_Barang").val('');
            $("#SignaTerjemahan").val('');
            $("#nama_Barang").focus();
            
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

});


async function onloadForm() {
    unlockBtnCreate();
    const dataGetLayanan = await GetLayanan();
    updateUIdataGetLayanan(dataGetLayanan);
    const dataunitbyIP = await getUnitbyIP();
    updateUIdataunitbyIP(dataunitbyIP);
    var id = $("#No_Transaksi").val();
        disableAll();
        if (id != ""){
            const data = await getSalesbyID();  
            updateUIdatagetSalesbyID(data);
            enableAll();
        }
    // await getHakAksesByForm(18);
    // await showdatatabel();
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

function showdatatabel(TransactionCode) {
    total_items = 0;
    var dataHandler = $("#user_data");
    dataHandler.html("");

    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/aPenjualanTanpaResep/getSalesDetailbyID";

    $.ajax({
        type: "POST",
        data: "TransactionCode=" + TransactionCode,
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
                

                // if (val.SignaTerjemahan == null){
                //     var  signaterjemahan = '';
                // }else{
                //     var signaterjemahan = val.SignaTerjemahan
                // }

                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                // if (val.Racik != 0){
                //     if (val.Header == true){
                //         var isracik = '<span class="label label-info">RACIK NO '+val.Racik+'</span>';
                //         //var issignaracik = "<br>Signa Latin: "+val.Signa+"<br>Signa Terjemahan: "+val.SignaTerjemahan;
                //         var NamaBarang = '<span class="label label-'+LabelClassNamaBarang+'" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                //         var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan'" + total_items + "' value='" + signaterjemahan +"'>";
                //     }else{
                //         var isracik = '<span class="label label-info">KOMPONEN RACIK NO '+val.Racik+'</span>';
                //         //var issignaracik = "";
                //         var NamaBarang = '<span class="label label-info" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                //         var signaterjemahanext = "<input type='hidden'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan'" + total_items + "' value=''>";
                //     }
                // }else{
                      //var isracik = '<span class="label label-warning">NON RACIK</span>';
                      var isracik = 'NON RACIK';
                      //var issignaracik = "<br>Signa Latin: "+val.Signa+"<br>Signa Terjemahan: "+val.SignaTerjemahan;
                      var NamaBarang = '<span class="label label-'+LabelClassNamaBarang+'" onclick=\'updateSignaTerjemahan("'+val.ID+'","'+val.Racik+'","'+val.Header+'","'+val.NamaBarang+'","'+val.Signa+'","'+val.SignaTerjemahan+'")\'> '+val.NamaBarang+ '</span>';
                      var signaterjemahanext = "<input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan" + total_items + "' value='" + val.AturanPakai +"'>";
                //}

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

                var newRow = $("<tr id='" + total_items + "'>");
            /*1*/  newRow.html(
                //"<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ "'<td><font size='2'>" + isracik +"<input type='hidden'  name='hidden_racik_[]' id='hidden_racik_'" + total_items + "' value='" + val.Racik +"' ><input type='hidden'  name='hidden_racik_header_[]' id='hidden_racik_header_'" + total_items + "' value='" + val.Header +"' ><input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'" + total_items + "' value='" + val.ID +"' ></font></td>'"+
            /*3*/"'<td><font size='1'>" + val.Satuan + "<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'" + total_items + "' value='" + val.Satuan_Beli +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'" + total_items + "' value='" + val.Konversi_satuan +"' ></font><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+converted_uangr+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+converted_embalase+"'></td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang" + total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='2'>" + val.ProductName +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*3*/"'<td><font size='2'><input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_'" + total_items + "' value='' ></font></td>'"+
            /*3*/"'<td><font size='2'>"+signaterjemahanext+"</font></td>'"+
            /*4*/"' <td>" + converted_qty + "<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +"' value='" + converted_qty +"' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + converted_qtyresep +"' ></td> '"+
            /*5*/"' <td>" + number_to_price(converted_harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(converted_harga) + "' ></td> '"+
            /*3*/"'<td><font size='1'><input type='text' style='width: 75px;' name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ></td> '"+
            /*3*/"'<td><font size='1'><input type='text' style='width: 75px;' name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
            `<td><button type='button' name='cetak_label' class='btn btn-info btn-xs cetak_label btn-rounded'onclick='CetakLabelPdf("${total_items}")'><i class="fa fa-print"></i> Label</button>&nbsp <button type='button' name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='${total_items}' ><i class="fa fa-close"></i> Delete</Hapus></td>`+
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
    window.location = base_url + '/SIKBREC/public/aPenjualanTanpaResep/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanTanpaResep/";
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

function unlockBtnCreate() {
    if ($("#No_Transaksi").val() == '') {
        $("#btnNewTransaksi").attr('disabled', false);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);
        $("#btnAdd").attr('disabled', true);
        $("#nama_Barang").attr('disabled', true);

        //$("#btnSearchMutasi").prop('disabled',false)
        $("#Tgl_Lahir").prop('readonly',false)
        $("#Nama").prop('readonly',false)
        $("#Alamat").prop('readonly',false)
        $("#Tgl_Penjualan").prop('readonly',false)
        $("#Unit_Select").prop('disabled',false)
        $("#Notes").prop('readonly',false)
        $("#TipePasien").prop('readonly',false)
        $("#KodeJaminan_Select").prop('disabled',false)
        // $('#JenisPasien option:not(:selected)').prop('disabled', false);
        // $('#JenisKelamin option:not(:selected)').prop('disabled', false);
        
    } else {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', false);
        $("#btn_batal").attr('disabled', false);
        $("#btnSearching").attr('disabled', true);
        $("#btnAdd").attr('disabled', false);
        $("#nama_Barang").attr('disabled', false);

        $("#btnSearchMutasi").prop('disabled',true)
        $("#Tgl_Lahir").prop('readonly',true)
        $("#Nama").prop('readonly',true)
        $("#Alamat").prop('readonly',true)
        $("#Tgl_Penjualan").prop('readonly',true)
        $("#Unit_Select").prop('disabled',true)
        $("#Notes").prop('readonly',true)
        $("#TipePasien").attr('readonly',true)
        $("#KodeJaminan_Select").prop('disabled',true)
        // $('#JenisKelamin option:not(:selected)').prop('disabled', true);
        // $('#JenisPasien option:not(:selected)').prop('disabled', true);
    }
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
    var url2 = "/SIKBREC/public/aPenjualanTanpaResep/addSalesHeaderTanpaResep";
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

function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unit_Select").append(newRow);
        $("#Unit_Farmasi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#Unit_Select").append(newRow);
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
            $("#Unit_Select").select2();
            $("#Unit_Farmasi").select2();
        })
}

//------------------------------------

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
        $("#Qty").focus();
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
        $('#xNamaBarang').val('');
        $('#xIdBarang').val('');
        $('#QtyStok').val('');
        $('#QtyOrder').val('');
        $('#Satuan').val('');
        $('#Konversi_Satuan').val('');
        showDataDetil();
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
    let url = base_url + '/SIKBREC/public/aPenjualanTanpaResep/createDtlTrs/';
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
            $("#notif_Cetak").modal('show');
            
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
    var Unit = document.getElementById("Unit").value;
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

function disableAll() { 
     $("#btn_batal").attr('disabled', true);
     $("#btnSimpan").attr('disabled', true); 
      $("#NamaBarang").attr('disabled', true);
     $("#nama_Barang").attr('disabled', true);
     $("#btnAdd").attr('disabled', true);
 }
 function enableAll() {
     $("#nama_Barang").attr('disabled', false);
     $("#btn_batal").attr('disabled', false);
     $("#btnSimpan").attr('disabled', false);
      $("#NamaBarang").attr('disabled', false);
      $("#btnAdd").attr('disabled', false);
     
 }

 async function updateUIdatagetSalesbyID(dataResponse) {
    var tgltrs = dataResponse.data[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#Tgl_Penjualan').val(d.toISOString().substring(0,d.toISOString().length-1));

    $("#JenisKelamin").val(dataResponse.data[0].GenderPembeli);
    $("#Tgl_Lahir").val(dataResponse.data[0].TglLahirPembeli);
    $("#Nama").val(dataResponse.data[0].NamaPembeli);
    $("#Alamat").val(dataResponse.data[0].AlamatPembeli);
    $("#Notes").val(dataResponse.data[0].Notes);
    $("#Unit").val(dataResponse.data[0].UnitSales);
    $("#Unit_Select").val(dataResponse.data[0].UnitSales).trigger('change');
    $("#Unit_Farmasi").val(dataResponse.data[0].UnitSales).trigger('change');
    $("#NIP_Karyawan").val(dataResponse.data[0].NIPKaryawan);
    $("#JenisPasien").val(dataResponse.data[0].JenisPasien);
    $("#TipePasien").val(dataResponse.data[0].GroupJaminan);
    await getIDPenjamin(dataResponse.data[0].GroupJaminan);
    $("#KodeJaminan_Select").val(dataResponse.data[0].KodeJaminan).trigger('change');

    isKaryawan(dataResponse.data[0].JenisPasien);
    unlockBtnCreate()


    $("#btnNewTransaksi").attr('disabled', true);
    $('#JenisPasien option:not(:selected)').prop('disabled', true);
    $('#JenisKelamin option:not(:selected)').prop('disabled', true);

    showdatatabel(dataResponse.data[0].TransactionCode);
}
async function getSalesbyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPenjualanTanpaResep/getSalesbyID/';
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPenjualanTanpaResep/list";
}


function showDataKaryawan() {
    if ($("#namakaryawan").val() == ''){
        toast('Ketik kata kunci','warning');
        return false;
    }
    var base_url = window.location.origin;
    $('#examplex').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#examplex').DataTable({
        "ordering": true,
        "searching" : false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aPenjualanTanpaResep/getDataKaryawan",
            "type":"POST",
            "data": {
                "search" : $("#namakaryawan").val(),
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.employment_number + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.name + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.birth_date + ' </font>  ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.phone_number + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.email + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<button type="button" class="btn-rounded btn-maroon btn-sm"  onclick=ShowHeaderbyID("' + row.id + '") > Pilih </button>'
                    return html
                },
            },
        ]
    });
}

async function ShowHeaderbyID(param) {
    try {
        const FormData = 'param='+param;
        const ctlrname = 'aPenjualanTanpaResep';
        const funcname = 'getKaryawanbyID';
        const response = await getpostData(FormData,ctlrname,funcname);
        updateUIdatagetKaryawanbyID(response);
    } catch (err) {
        toast(err, "error")
    }
}

async function getpostData(data,ctlrname,funcname) {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/'+ctlrname+'/'+funcname+'/';
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function updateUIdatagetKaryawanbyID(dataResponse) {
        $(".preloader").fadeOut();
        $("#NIP_Karyawan").val(dataResponse.employment_number);
        $("#Nama").val(dataResponse.name);
        $("#JenisKelamin").val(dataResponse.sex.name);
        $("#Alamat").val(dataResponse.current_address);
        $("#Tgl_Lahir").val(dataResponse.birth_date);
        //$('#JenisKelamin option:not(:selected)').prop('disabled', true);
        //toast('Data karyawan berhasil dipilih', 'success')

        // $("#Nama").prop('readonly', true);
        // $("#JenisKelamin").prop('readonly', true);
        // $("#Alamat").prop('readonly', true);
        // $("#Tgl_Lahir").prop('readonly', true);

        $('#btnSearching_modal').modal('hide');

}

$("#namakaryawan").keyup(function (e) { // Ketika user menekan tombol di keyboard
    if (e.keyCode == 13) { // Jika user menekan tombol ENTER\
        showDataKaryawan()
    }
});

function changeVal (e){
    $("#Unit_Farmasi").val(e.value).trigger('change')
    $("#Unit").val(e.value)
}

async function changeValJaminan (e){
    // $("#KodeJaminan").val(e.value)
    // $("#KodeJaminan_Nama").val($('#KodeJaminan_Select option:selected').text())
    const dataPenjamin = await getPenjeminbyID(e.value,$("#TipePasien").val());
    updateUIgetPenjeminbyID(dataPenjamin);
}

function isKaryawan (param){
    if (param == 'Karyawan'){
        $("#btnSearchMutasi").prop('disabled',false)
        $("#JenisKelamin").prop('readonly',true)
        $("#Tgl_Lahir").prop('readonly',true)
        $("#Nama").prop('readonly',true)
        $("#Alamat").prop('readonly',true)
       // $('#JenisKelamin option:not(:selected)').prop('disabled', true);
    }else{
        $("#NIP_Karyawan").val('')
        $("#btnSearchMutasi").prop('disabled',true)
        //$("#JenisKelamin").prop('readonly',false)
        $("#Tgl_Lahir").prop('readonly',false)
        $("#Nama").prop('readonly',false)
        $("#Alamat").prop('readonly',false)
       // $('#JenisKelamin option:not(:selected)').prop('disabled', false);
    }
}

// function disabledAll (){
//     $("#btnSearchMutasi").prop('disabled',false)
//     $("#JenisKelamin").prop('readonly',true)
//     $("#Tgl_Lahir").prop('readonly',true)
//     $("#Nama").prop('readonly',true)
//     $("#Alamat").prop('readonly',true)
//     $("#Tgl_Penjualan").prop('readonly',true)
//     $("#Unit_Select").prop('disabled',true)
//     //$("#Notes").prop('readonly',true)
// }

$("#btnPrintLabelAll").click(function() {
    CetakLabelAll();
})

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
    var TransactionCode = $("#No_Transaksi").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/CetakLabelAll_NewTanpaResep';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "TransactionCode="+TransactionCode 
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

function updateUIdataunitbyIP(dataResponse) {
    if (dataResponse.status == true){
        $("#Unit").val(dataResponse.data[0].UnitCode);
        $("#Unit_Select").val(dataResponse.data[0].UnitCode).trigger('change');
        $("#Unit_Farmasi").val(dataResponse.data[0].UnitCode).trigger('change');
        $("#Unit_Select").prop('disabled',true)
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


async function getIDPenjamin(x) {
    try {
        const datagetNamaPenjamin = await getNamaPenjamin(x);
        updateUIgetNamaPenjamin(datagetNamaPenjamin);
    } catch (err) {
        toast(err, "error")
    }
    }

    function updateUIgetNamaPenjamin(datagetNamaPenjamin) {
        let responseApi = datagetNamaPenjamin; 
        if (responseApi.data !== null && responseApi.data !== undefined) {
            $("#KodeJaminan_Select").empty();
            $("#KodeJaminan").val('');
            $("#KodeJaminan_Nama").val('');
            var newRow = '<option value="">-- PILIH --</option';
            $("#KodeJaminan_Select").append(newRow);
            for (i = 0; i < responseApi.data.length; i++) {
                var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
                $("#KodeJaminan_Select").append(newRow);
            }
        }
        }
        
function getNamaPenjamin(x) {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'tp_penjamin=' + x//$("#TipePenjamin").val()
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
        $("#KodeJaminan_Select").select2();
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

    function CetakLabelPdf(index){
        const code = $("#hidden_kode_barang"+index).val()
        const signa = $("#hidden_signa_terjemahan"+index).val()
        const qty = $("#hidden_qtyreal_barang_"+index).val()
        const NoMR = '-'
        const PatientName = $("#Nama").val() 
        const NoRegistrasi = $("#NoRegistrasi").val() 
        const dob = $("#Tgl_Lahir").val() 
        const TglResep = $("#Tgl_Penjualan").val() 
        const notrs = '-'
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

    async function getHargaJualFix(idbarang){  
        const data = await gogetHargaJualFix(idbarang);
        updategogetHargaJualFix(data);
    }
    function updategogetHargaJualFix(params){
    
        if (params.status) {
            $("#HargaProduct").val(params.data);
        } else {
            $("#HargaProduct").val('0');
           toast(params.message, "error") 
        } 
    }
    function gogetHargaJualFix(idbarang) {
    
        var kodebarang = idbarang; 
        var NoRegistrasi = '-'; 
        var KodeGroupJaminan = $("#GroupJaminan").val(); //xedit  
        var Kelasid = '3';     
        var tgl = document.getElementById("Tgl_Penjualan").value; 
        var TransasctionDate = tgl.replace('Z', '').replace('T', ' ').replace('.000', '');
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/InventoryCharged/gogetHargaJualFix/';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'kodebarang=' + kodebarang + '&NoRegistrasi=' + NoRegistrasi + '&GroupJaminan=' + KodeGroupJaminan + '&TransasctionDate=' + TransasctionDate 
            + '&Kelasid=' + Kelasid 
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

    
function updateUIgetPenjeminbyID(dataGetDataJaminan) {
    let dataResponse = dataGetDataJaminan;
    $("#GroupJaminan").val(dataResponse.data.Group_Jaminan)
    $("#KodeJaminan").val(dataResponse.data.ID)
    $("#KodeJaminan_Nama").val(dataResponse.data.NamaPerusahaan)
}

async function getPenjeminbyID(id,tipepasien) {
    var base_url = window.location.origin;
    if (tipepasien == '2'){
        var endpoint = '/SIKBREC/public/MasterDataAsuransi/getAsuransiId/';
    }else{
        var endpoint = '/SIKBREC/public/MasterDataPerusahaan/getPerusahaanId/';
    }
    let url = base_url + endpoint;
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
