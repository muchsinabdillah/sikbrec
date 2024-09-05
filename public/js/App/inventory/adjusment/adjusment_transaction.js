$(document).ready(function () {
    $(".preloader").fadeOut();
    convertNumberToRp();
    asyncShowMain();
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
                    createHeaderTrs();
                } else {
                }
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
              Unit: $('#Unit').val(),
            },
            success: function( data ) {
              response( data );
              console.log(data)
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
              $(this).val(ui.item.label);
              $("#xIdBarang").val(ui.item.id);
              $("#QtyCurrent").focus();
              //$("#QtyStok").val(ui.item.qty);
              //getBarangbyId(ui.item.id);
              
                $("#xNamaBarang").val(ui.item.label);
                $("#QtyStok").val(ui.item.qty);
                $("#Satuan").val(ui.item.Satuan);
                $("#hpp_add").val(ui.item.NilaiHpp);
                $("#Satuan_Konversi").val(ui.item.Satuan_Beli);
                $("#Konversi_satuan").val(ui.item.konversisatuan); 
              return false; 
          }
  })

    // $("#nama_Barang").select2({
    //     ajax: {
    //         url: function (params) {
    //             return window.location.origin + '/SIKBREC/public/InfoStok/getStokBarangbyUnitNameLike';
    //         },
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 searchTerm: params.term,
    //                 grupBarang : $("#Group_Transaksi").val(),
    //                 Unit : $("#Unit").val(),

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
    //  //add bpjsa
    //  $('#nama_Barang').on('select2:select', function (e) {
    //     var data = e.params.data; 
    //     $("#xIdBarang").val(data.id);
    //     $("#xNamaBarang").val(data.text);
    //     $("#QtyStok").val(data.qty);
    //     $("#Satuan").val(data.Satuan);
    //     $("#hpp_add").val(data.NilaiHpp);
  
    //     //$("#Satuan_Konversi").val(data.Satuan); //satuan terkecil
    //     $("#Konversi_satuan").val(data.konversisatuan); 
        
    //   //  getBarangbyId(data.id)


    //     $("#QtyOrder").focus();
 
    // });
    //Btn add detail
    $("#btnAdd").click(function () { 
        AddRow();
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
            
                var count = $('#totalrow_closing').val();
                //console.log(count);
                count = count - 1 ;
                document.getElementById('grantotalOrder_closing').innerHTML = count;
                $('#totalrow_closing').val(count);
                toast('Berhasil Hapus !', "success")
                CalculateALL()
            } else {
              //swal("Your imaginary file is safe!");
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
                        goSave();
                    } else {
                        swal("Transaction Rollback !");
                    }
                });
    
        });
    
});

async function goSave() {
    try {
        const data = await goSave2();
        updateUIgoSave(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgoSave(params) {
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
function goSave2() {
    var base_url = window.location.origin;
    var date = document.getElementById("TglTransaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var data = $("#user_form, #form_hdr").serialize();
    // var TransasctionCode = document.getElementById("IdAuto").value;
    var TotalQty =  price_to_number(document.getElementById("ttl_qtyAkhir").value);
    var TotalRow = price_to_number(document.getElementById("totalrow_closing").value);
    var Grandtotal = price_to_number(document.getElementById("grandtotalxl").value);
    // var Notes = document.getElementById("pr_ketTransaksi").value;
    let url = base_url + '/SIKBREC/public/aAdjusment/finishAdjusment/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data + '&TransasctionDate=' + TransasctionDate
                + '&TotalQty=' + TotalQty
                + '&TotalRow=' + TotalRow
                + '&Grandtotal=' + Grandtotal
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
function AddRow(){
    if($("#xNamaBarang").val() == ''){
        $("#xNamaBarang").focus();
        toast("Nama Barang Kosong !", 'warning');
        return false;
    }

    if($("#QtyOrder").val() == ''  ){
        $("#QtyOrder").focus();
        toast("Qty Kosong !", 'warning');
        return false;
    }
 

    kode_barang = $('#xIdBarang').val();
    nama_barang_ = $('#xNamaBarang').val();
    satuan_barang_ = $('#Satuan').val();
    qty_stok_barang_ = $('#QtyStok').val();
    qty_barang_ = $('#QtyCurrent').val();
    // qty_adj_barang_ = $('#QtyAdj').val();
    satuan_konversi_ = $('#Satuan_Konversi').val();
    satuan_qty_ = $('#Konversi_satuan').val();
    hpp_barang_ = $("#hpp_add").val();
    if(qty_stok_barang_ > qty_barang_){
        qty_adj_barang_ = qty_barang_-qty_stok_barang_;
    }else if(qty_stok_barang_ < qty_barang_){
        qty_adj_barang_ = qty_barang_-qty_stok_barang_;
    }
    xqty_adj_barang_ =  qty_adj_barang_;
    xqty_stok_barang_ =  qty_stok_barang_;
    xqty_barang_ = qty_barang_;
    total_barang_ = qty_adj_barang_*hpp_barang_;
    var totalitem = $("#totalrow_closing").val();
    console.log(totalitem);
    for (i = 1; i <= totalitem; i++) { 
        if (kode_barang == $("#kode_barang"+i).val() ){
            swal({
                title: "Warning",
                text: nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!',
                icon: "warning",
            });
            toast(nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!','warning');
            return false;
        }
    }

      if($('#totalrow_closing').val()==0){
        var count =0;
      }else{
        var count = parseFloat($('#totalrow_closing').val());
      }
      count = count + 1;
      document.getElementById('grantotalOrder_closing').innerHTML = count;
      $('#totalrow_closing').val(count);

        var newRow = $("<tr id='row_'" + count + "'>");
            //*1*/  newRow.html("<td><font size='1'>" + count + "</td>'"+
            /*2*/ newRow.html("'<td>" + kode_barang +"<input type='hidden' name='kode_barang[]' id='kode_barang" + count + "' class='kode_barang'"+count + "' value='" + kode_barang +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + nama_barang_ + "<input type='hidden'  name='nama_barang_[]' id='nama_barang_" + count + "' value='" + nama_barang_ +"' ></font></td>'"+
            /*4*/"' <td>" + satuan_barang_ + "<input type='hidden' name='satuan_barang_[]' id='satuan_barang_" + count +"' value='" + satuan_barang_ +"' ></td> '"+
            /*6*/"' <td>"+ number_to_price(qty_stok_barang_)+"<input  size='2'  type='hidden'  name='qty_stok_barang_[]' id='qty_stok_barang_" + count + "' value='" + qty_stok_barang_ +"' ></td> '"+
             /*7*/"' <td>"+ qty_adj_barang_+"<input size='1'  value='" + xqty_adj_barang_ + "' type='hidden' name='qty_adj_barang_[]'   id='qty_adj_barang_" + count +"' ></td>'"+
             /*7*/"'<td>"+ number_to_price(qty_barang_) +"<input size='1'  value='" + xqty_barang_ + "' type='hidden' name='qty_barang_[]'   id='qty_barang_" + count +"' ></td>'"+
            /*8*/"' <td>"+ number_to_price(hpp_barang_) +"<input size='5' readonly  type='hidden' name='hpp_barang_[]'   id='hpp_barang_" + count + "' class='harga'  value='" + hpp_barang_ + "' ></td> '"+
            /*9*/"' <td>" + number_to_price(total_barang_) + "<input size='1' readonly value='" + total_barang_ + "' type='hidden' name='total_barang_[]'   id='total_barang_" + count +"' >"+
               /*9*/"' <td><input size='1'   value='' type='text' name='batch_number_[]'   id='batch_number_" + count +"' >"+
            /*9*/"' <td><input size='1'   value='' type='date' name='expired_[]'   id='expired_" + count +"' >"+
            /*10*/"<td> <button type='button'   name='remove_details_closing' class='btn btn-warning btn-xs remove_details_closing' id='" + count + "' >Delete</Hapus> " +
                "</td>  </tr>")
                ;

        $('#user_data').append(newRow);
        
        $("#xNamaBarang").val("");
        $("#Satuan").val("");
        $("#Satuan_Konversi").val("");
        $("#Konversi_satuan").val("");
        $("#QtyStok").val('');
        $("#QtyCurrent").val('');
        $("#QtyAdj").val('');
        $("#hpp_add").val('');
        $("#nama_Barang").val('');
        $("#nama_Barang").focus();
        //$("#nama_Barang").empty();
        //$("#nama_Barang").select2('open');

        CalculateALL();
}

function CalculateALL() {
    var totalqty = 0;
    var totalsubtotal = 0;
    var totalhpp = 0;
    var totalitem = $("#totalrow_closing").val()

    for (i = 1; i <= totalitem; i++) {

        itemID = document.getElementById("qty_barang_" + i);
        var qty = $("#qty_barang_" + i).val(); 
        var persediaan = $("#total_barang_" + i).val(); 

        
        //console.log(total_items);
        //var Hpp = $("#hidden_hpp_barang_" + i).val();
       // var Subtotal = $("#hidden_total_barang_" + i).val();

            //var subtotalx = qty * parseFloat(Hpp);
            
            //TOTAL  
            var totalqty = totalqty + parseFloat(qty);
            var totalhpp = totalhpp + parseFloat(persediaan);
            // var totalhpp = totalhpp + parseFloat(Hpp);
            // var totalsubtotal = totalsubtotal + subtotalx;
            

    //FOOTER
    $("#ttl_qtyAkhir").val(number_to_price(totalqty)); 
    $("#grandtotalxl").val(number_to_price(persediaan)); 
    $("#TotalRows").val(number_to_price(i)); 
    }
    

}
function convertNumberToRp() {
    var QtyAdj = document.getElementById("QtyAdj");
    var hpp_add = document.getElementById("hpp_add"); 
    
    QtyAdj.addEventListener("keyup", function (e) { 
       QtyAdj.value = formatRupiah(this.value);  
    }); 
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
async function createHeaderTrs() {
    try {
        const dataGocreateHdr = await GocreateHdr();
        updateUIdataGocreateHdr(dataGocreateHdr);
    } catch (err) {
        toast(err, "error")
    }
}


function updateUIdataGocreateHdr(dataResponse) {
    //console.log("dataResponse", dataResponse);
    if (dataResponse.status == true){
    $('#No_Transaksi').val(dataResponse.data);
    $("#btnNewPurchase").attr('disabled', true);
    enableAll();
    toast(dataResponse.message,'success')
    }else{
        toast(dataResponse.message,'error')
    }

}
function GocreateHdr() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var data = $("#form_hdr").serialize();
    var  date  = document.getElementById("TglTransaksi").value;  
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    let url = base_url + '/SIKBREC/public/aAdjusment/addHeader/';
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
async function asyncShowMain() {
    try {
        
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        var id = $("#No_Transaksi").val();
        //disableAll();
        // if (id != ""){
        //     const data = await getDatabyID();  
        //     updateUIgetDatabyID(data);
        //     //showDataDetil();
        //     enableAll() ;
        //     $("#btnNewPurchase").attr('disabled', true);
        // }
       
    } catch (err) {
        toast(err, "error")
    }
}


function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aAdjusment/list";
}



function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unit").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option>';
            $("#Unit").append(newRow);
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
        })
}
function disableAll() { 
    $("#btnAdd").attr('disabled', true);
     $("#btn_batal").attr('disabled', true);
     $("#btnSave").attr('disabled', true); 
     $("#nama_Barang").attr('disabled', true);
 }
 function enableAll() {
     $("#nama_Barang").attr('disabled', false);
      $("#btnAdd").attr('disabled', false);
     $("#btn_batal").attr('disabled', false);
     $("#btnSave").attr('disabled', false);
     
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