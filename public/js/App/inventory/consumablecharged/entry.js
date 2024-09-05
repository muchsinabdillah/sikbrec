$(document).ready(function () {
    
    onloadForm();
    $('#example').dataTable({
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
            //   $("#HargaProduct").val(ui.item.NilaiHpp);
              $("#Satuan_Konversi").val(ui.item.Satuan);
              $("#Konversi_satuan").val(ui.item.konversisatuan); 
              getHargaJualFix(ui.item.id);
              return false; 
          }
    })
    $("#btnSearchReg").click(function () { 
        $("#btnSearching_modal").modal('show');
    });
    $('#btncarirajal').click(function () {
        var tglawal = $("#tglawalrajal").val();
        var tglakhir = $("#tglakhirrajal").val();

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        getListBillingRajal(tglawal,tglakhir);
    });

    $('#btncariranap').click(function () {
        var tglawal = $("#tglawalranap").val();
        var tglakhir = $("#tglakhirranap").val();

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        getDataListBillingRanap(tglawal,tglakhir);
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
        $("#notif_Cetak").modal('show');
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
    $("#btnAdd").click(function () { 
        AddRow();
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
          }else{
            var count = parseFloat($('#totalrow').val());
          }
          count = count + 1;
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
          harga = $('#HargaProduct').val();
          UangR = 0;
          Embalase = 0;

          var totalitem = $("#totalrow").val();
            for (i = 1; i <= totalitem; i++) { 
                if (hidden_kode_barang == $("#hidden_kode_barang"+i).val() ){
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
            console.log(number_to_price((val.QryOrder)),'dd');
          var newRow = $("<tr id='row_'" + total_items + "'>");
            /*1*/  newRow.html("<td><font size='1'>" + total_items + "<input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'" + total_items + "' value='" + val.ID +"' ></td>'"+
            /*3*/"'<td><font size='1'>" + val.Satuan_Konversi + "<input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items + "' value='" + val.Satuan +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'" + total_items + "' value='" + val.Satuan_Konversi +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'" + total_items + "' value='" + val.Konversi_satuan +"' ></font></td>'"+
            /*2*/ "'<td>" + val.KodeBarang +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang" + total_items + "' value='" + val.KodeBarang +"' ></td> '"+
            /*3*/"'<td><font size='2'>" + val.NamaBarang +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.NamaBarang +"' ></font></td>'"+
            /*3*/"'<td><font size='2'>" + val.Signa +"<input type='hidden'  name='hidden_signa_latin_[]' id='hidden_signa_latin_'" + total_items + "' value='" + val.Signa +"' ></font></td>'"+
            /*3*/"'<td><font size='2'><input type='text'  name='hidden_signa_terjemahan[]' id='hidden_signa_terjemahan'" + total_items + "' value='" + val.SignaTerjemahan +"'></font></td>'"+
            /*4*/"' <td>" + val.QryOrder + "<input type='hidden' name='hidden_qty_barang_[]' id='hidden_qty_barang_" + total_items +"' value='" + val.QryOrder +"' ></td> '"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + val.QryOrder +"' ></td> '"+
            /*5*/"' <td>" + number_to_price(val.Harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(val.Harga) + "' ></td> '"+
            /*3*/"'<td><font size='1'><input type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+val.UangR+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+val.Embalase+"'></td> '"+
            /*3*/"'<td><font size='1'><input type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
            // /*14*/"<td> <button type='button' onclick=goVoidDetails('" + val.ProductCode + "') name='remove_details' class='btn btn-gold btn-xs remove_details btn-rounded' id='" + total_items + "' >Delete</Hapus></td> " +
                "  </tr>")
                ;

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

});
 async function AddRow(){
    try {
        $(".preloader").fadeIn();
       const xdaataa = await addDetailsConsumableperitem();
       updateaddDetailsConsumableperitem(xdaataa);
    } catch (err) {
       toast(err, "error")
    }
 }
 function addDetailsConsumableperitem(){
    if($("#nama_Barang").val() == ''){
        $("#xNamaBarang").focus();
        toast("Nama Barang Kosong !", 'warning');
        return false;
    } kode_barang

    if($("#Qty").val() == '' || $("#Qty").val() == 0 ){
        $("#Qty").focus();
        toast("Qty Kosong !", 'warning');
        return false;
    }

    var No_Transaksi = $('#No_Transaksi').val();
    var kode_barang = $('#xIdBarang').val();  
    var nama_barang = $('#xNamaBarang').val();
    var satuanbesar = $('#Satuan').val();
    var qtypakai = $('#QtyOrder').val();
    var satuankecil = $('#Satuan_Konversi').val();
    var nilaikonversisatuan = $('#Konversi_satuan').val();
    var HargaProduct = $('#HargaProduct').val(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InventoryCharged/addConsumableChargedDetailv2/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kode_barang=' + kode_barang + '&nama_barang=' + nama_barang 
                + '&satuanbesar=' + satuanbesar + '&qtypakai=' + qtypakai 
                + '&satuankecil=' + satuankecil + '&nilaikonversisatuan=' + nilaikonversisatuan 
                + '&HargaProduct=' + HargaProduct  
                + '&No_Transaksi=' + No_Transaksi   
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
function updateaddDetailsConsumableperitem(params){
    if(params.status === true){
        toast(params.message, "success")
        var idtrs = $('#No_Transaksi').val();
        showDataDetil_View(idtrs);
         
    }else{
        toast(params.message, "error")
    }
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
    var NoRegistrasi = $("#NoRegistrasi").val(); 
    var KodeGroupJaminan = $("#KodeGroupJaminan").val();   
    var Kelasid = $("#Kelasid").val();     
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
function getListBillingRajal(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingrajal').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingrajal').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 3, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListBillingRajal", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoMR+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoRegistrasi+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TglKunjungan+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaUnit+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaDokter+'</font> '
                            return html 
                    }
                } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.TipePenjamin+'</font> '
                        return html 
                }
            } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPenjamin+'</font><br><font size="1">'+row.NoSEP+'</font> '
                            return html 
                    }
                } ,
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""

                    if (row.NamaStatus == 'New'){
                        var badgecol = "success";
                    }else if (row.NamaStatus == 'Invoice'){
                        var badgecol = 'info';
                    }else if (row.NamaStatus == 'Payment'){
                        var badgecol = 'warning';
                    }else if (row.NamaStatus == 'Lunas'){
                        var badgecol = 'danger';
                    }
                    
                    var html  = '<span class="badge badge-'+badgecol+'">'+row.NamaStatus+'</span>'
                        return html 
                }
            } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn-rounded btn-maroon border-maroon btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' > Pilih</button>'
                          return html 
                   }
               },
           ],
       });
} 

function getDataListBillingRanap(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingranap').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingranap').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 3, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListBillingRanap", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoMR+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoRegistrasi+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TglKunjungan+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaUnit+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaDokter+'</font> '
                            return html 
                    }
                } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.TipePenjamin+'</font> '
                        return html 
                }
            } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPenjamin+'</font><br><font size="1">'+row.NoSEP+'</font> '
                            return html 
                    }
                } ,
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""

                    if (row.NamaStatus == 'New'){
                        var badgecol = "success";
                    }else if (row.NamaStatus == 'Invoice'){
                        var badgecol = 'info';
                    }else if (row.NamaStatus == 'Payment'){
                        var badgecol = 'warning';
                    }else if (row.NamaStatus == 'Lunas'){
                        var badgecol = 'danger';
                    }
                    
                    var html  = '<span class="badge badge-'+badgecol+'">'+row.NamaStatus+'</span>'
                        return html 
                }
            } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn-rounded btn-maroon border-primary btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' > Pilih</button>'
                          return html 
                   }
               },
           ],
       });
} 
async function showID(noreg){  
    const data = await getNoregistrasibyNoreg(noreg);
    updategetNoregistrasibyNoreg(data);
}
function updategetNoregistrasibyNoreg(params){

    if (params.status === true) {
        $("#No_MR").val(params.data[0].NoMR);
        $("#NoRegistrasi").val(params.data[0].NoRegistrasi);
        if(params.data[0].Gander == "F"){
            $("#JenisKelamin").val("Perempuan");
        }else if(params.data[0].Gander == "F"){
            $("#JenisKelamin").val("Laki-Laki");
        }else{
            $("#JenisKelamin").val("-");
        }
     
        
        $("#KodeGroupJaminan").val(params.data[0].groupjaminan);
        $("#Kelasid").val(params.data[0].kodekelas);
        $("#KelasNama").val(params.data[0].NamaKelas);
        
        $("#No_Order").val(params.data[0].OrderID);
        $("#Tgl_Lahir").val(params.data[0].Date_of_birth);
        $("#Umur").val(params.data[0].Usia+' Tahun');
        $("#Tgl_Order").val(params.data[0].TglResepRaw);
        $("#Nama").val(params.data[0].PatientName);
        $("#Dokter").val(params.data[0].NamaDokter);
        $("#Alamat").val(params.data[0].Address);
        $("#Unit").val(params.data[0].IdUnit).trigger('change');
        $("#Unit_Farmasi").val(params.data[0].IdUnit).trigger('change');
        $("#Jaminan").val(params.data[0].NamaJaminan);
        $("#KodeJaminan").val(params.data[0].KodeJaminan);
        $("#TipePasien").val(params.data[0].TipePasien);
        $("#KodeKelas").val(params.data[0].KodeKelas); 
        $("#No_Episode").val(params.data[0].NoEpisode); 
        $("#Unit").prop("disabled", true);
        $("#Unit_Farmasi").prop("disabled", true);
         
        $("#GroupJaminan").val(params.data[0].KodeJaminan); 
        if(params.data[0].NamaJaminan == "Bpjs Kesehatan"){
            $("#GroupJaminan").val("BS"); 
        }else if(params.data[0].NamaJaminan == "Umum"){
            $("#GroupJaminan").val("UM"); 
        }
        // var tgltrs = params.data[0].TglPenjualan;
        // var d = new Date(tgltrs);
        // d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        // $('#Tgl_Penjualan').val(d.toISOString().substring(0,d.toISOString().length-1));

        //if (params.data[0].TransactionCode != null){
        showdatatabel(params.data[0].OrderID);
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
    $("#btnSearching_modal").modal('hide');
}
function getNoregistrasibyNoreg(noreg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InventoryCharged/getNoregistrasibyNoreg/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noreg=' + noreg
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
async function onloadForm() {
    //await getHakAksesByForm(18);
    
    unlockBtnCreate();
    const dataGetLayanan = await GetLayanan();
    updateUIdataGetLayanan(dataGetLayanan);
    //await showdatatabel();
     

    var id = $("#No_Transaksi").val();
    disableAll();
    $(".preloader").fadeOut();
    if (id != ""){
        const data = await getSalesbyID();  
        updateUIdatagetSalesbyID(data);
        enableAll();
    }
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
    $("#KodeJaminan_Select").val(dataResponse.data[0].KodeJaminan).trigger('change');
    showID(dataResponse.data[0].NoRegistrasi); 
    unlockBtnCreate()


    $("#btnNewTransaksi").attr('disabled', true);

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
    var No_Transaksi = $("#No_Transaksi").val(); 
    var dataHandler = $("#user_data");
    dataHandler.html("");

    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/InventoryCharged/viewInventoryChargeddetail";

    $.ajax({
        type: "POST",
        data: "No_Transaksi=" + No_Transaksi ,
        url: base_url + url2,
        success: function (result) {
            //console.log(result);
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                
              
                total_items = total_items + 1;
                $("#totalrow").val(total_items);

                 console.log(val.ProductName);

                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+ 
            /*3*/"'<td><font size='1'>" + val.Satuan_Beli + "<input type='hidden'  name='hidden_ID_[]' id='hidden_ID_'" + total_items + "' value='" + val.ID +"' ><input type='hidden'  name='hidden_satuan_barang_[]' id='hidden_satuan_barang_'" + total_items + "' value='" + val.Satuan_Beli +"' ><input type='hidden'  name='hidden_satuan_konversi_[]' id='hidden_satuan_konversi_'" + total_items + "' value='" + val.Satuan_Beli +"' ><input type='hidden'  name='hidden_konversi_satuan_[]' id='hidden_konversi_satuan_'" + total_items + "' value='" + val.KonversiQty +"' ></font></td>'"+
            /*2*/ "'<td>" + val.ProductCode +"<input type='hidden' name='hidden_kode_barang[]' id='hidden_kode_barang'" + total_items + "' class='hidden_kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='2'>" + val.ProductName +"<input type='hidden'  name='hidden_nama_barang_[]' id='hidden_nama_barang_'" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_qtyreal_barang_[]' id='hidden_qtyreal_barang_" + total_items + "' value='" + parseFloat(val.Qty) +"' ></td> '"+
            /*5*/"' <td>" + number_to_price(val.Harga) + "<input type='hidden'  name='hidden_harga_barang_[]' id='hidden_harga_barang_" + total_items + "' value='" + parseFloat(val.Harga) + "' ></td> '"+
            /*3*/"'<td><font size='1'><input type='text'  name='hidden_subtotal_[]' id='hidden_subtotal_" + total_items + "' readonly></font></td>'"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='hidden_discpros_barang_[]' id='hidden_discpros_barang_" + total_items + "' value='0'><input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_discrp_barang_[]' id='hidden_discrp_barang_" + total_items + "' value='0'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxprosen_[]' id='hidden_taxprosen_" + total_items + "' value='11'> <input  size='2'  type='hidden' onkeydown='FormatCell(this)'  name='hidden_taxrp_[]' id='hidden_taxrp_" + total_items + "' ><input  size='2'  type='hidden'  name='uangr[]' id='uangr" + total_items + "' value='"+val.UangR+"'><input  size='2'  type='hidden'  name='embalase[]' id='embalase" + total_items + "' value='"+val.Embalase+"'></td> '"+
            /*3*/"'<td><font size='1'><input type='text'  name='hidden_grandtotal_[]' id='hidden_grandtotal_" + total_items + "' readonly></font></td>'"+
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
function unlockBtnCreate() {
    console.log("xxx",$("#No_Transaksi").val());
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

function createHeader() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_Penjualan").value;
    var Unit = document.getElementById("Unit").value;
    var Unit_Farmasi = document.getElementById("Unit_Farmasi").value;
    var JenisPasien = "Pasien Berobat";
    var No_Order  = 0;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/InventoryCharged/addSalesHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate=" +TransasctionDate +"&Unit=" +Unit +"&Unit_Farmasi=" +Unit_Farmasi+"&No_Order=" +No_Order+"&JenisPasien=" +JenisPasien
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
        //$("#Notes").val(params.data[0].Notes);
        //$("#Unit").prop("disabled", true);
        
        // var tgltrs = params.data[0].TglPenjualan;
        // var d = new Date(tgltrs);
        // d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        // $('#Tgl_Penjualan').val(d.toISOString().substring(0,d.toISOString().length-1));

        //if (params.data[0].TransactionCode != null){
        showdatatabel(params.data[0].OrderID);
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
            $("#Unit").select2();
            $("#Unit_Farmasi").select2();
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
       
        //var qtyx = document.getElementById("hidden_qty_barang_" + i);

        var qty = parseFloat(price_to_number($("#hidden_qtyreal_barang_" + i).val()));
        var qtymr = parseFloat(price_to_number($("#hidden_qty_barang_" + i).val()));
        var disconprosen = parseFloat(price_to_number($("#hidden_discpros_barang_" + i).val()));
        //var disconprosen = 0;
        var harga = parseFloat(price_to_number($("#hidden_harga_barang_" + i).val()));
        var taxprosen = parseFloat(price_to_number($("#hidden_taxprosen_" + i).val()));
        //var taxprosen = 0;


        // if (typeof qtyx === 'undefined' || qtyx === null) {
        //     alert("No such item - " + "hidden_qty_barang_" + i); 
        // } else {
            if (qty > qtymr) {
                toast('Qty Order Lebih Besar daripada Qty Real !', 'warning'); 
                $("#hidden_qtyreal_barang_"+i).val(0);
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
            $("#hidden_discrpttl_barang_" + i).val(number_to_price(totaldiskonrp));
            $("#hidden_discrp_barang_" + i).val(number_to_price(hargamindiskon));
            $("#hidden_subtotal_" + i).val(number_to_price(subtotal));
            $("#grandtotalqty" + i).val(number_to_price(qtytotal));
            $("#hidden_taxrp_" + i).val(number_to_price(taxrp));
            $("#hidden_taxrp2_" + i).val(number_to_price(taxrp_stn));
            $("#hidden_grandtotal_" + i).val(number_to_price(grandtotalPurchase));
            $("#hidden_harga_barang_" + i).val(number_to_price(harga));
 

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
    var No_Order = '0';
    var Unit  = document.getElementById("Unit").value;
    var Unit_Farmasi   = document.getElementById("Unit_Farmasi").value;
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
        +"&No_Order="+No_Order
        +"&Unit="+Unit
        +"&Unit_Farmasi="+Unit_Farmasi
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
        // toast(data.message, "success");
        goFinishEditOrder2();
        swal({
            title: 'Success',
            text: data.message,
            icon: 'success',
        }).then(function() {
            MyBack();
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/InventoryCharged/list";
    //location.reload();
}