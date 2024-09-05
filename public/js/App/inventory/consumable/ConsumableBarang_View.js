$(document).ready(function () {

    $(document).on('click', '.remove_details', function () {
        $('#row_closing_' + row_id + '').remove();
        $('#row_closing_')
        var count = $('#totalrow_closing').val();
        //console.log(count);
        count = count - 1 ;
        document.getElementById('grantotalOrder_closing').innerHTML = count;
        $('#totalrow_closing').val(count);
        CalculateALL()
    });
    //$(".preloader").fadeOut();
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
                        toast('No Order Mutasi Tidak Ditemukan !');
                        return false
                    }
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
              $("#QtyOrder").focus();
              //$("#QtyStok").val(ui.item.qty);

              $("#xNamaBarang").val(ui.item.label);
                $("#QtyStok").val(ui.item.qty);
                $("#Satuan").val(ui.item.Satuan_Beli);
                //$("#hpp_add").val(ui.item.NilaiHpp);
                $("#Satuan_Konversi").val(ui.item.Satuan);
                $("#Konversi_satuan").val(ui.item.konversisatuan); 
              //getBarangbyId(ui.item.id);
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
    // //add bpjsa
    // $('#nama_Barang').on('select2:select', function (e) {
    //     var data = e.params.data; 
    //     $("#xIdBarang").val(data.id);
    //     $("#xNamaBarang").val(data.text);
    //     $("#QtyStok").val(data.qty);
    //     $("#Satuan").val(data.Satuan);
  
    //     //$("#Satuan_Konversi").val(data.Satuan); //satuan terkecil
    //     $("#Konversi_satuan").val(data.konversisatuan); 
        
    //     getBarangbyId(data.id)


    //     $("#QtyOrder").focus();
 
    // });

    $('#btnPaket').click(function () {
        $("#btnPaket_modal").modal('show');
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


    //Btn add detail
    $("#btnAdd").click(function () { 
        AddRow();
    });

    $("#QtyOrder").keyup(function (e) { 
        if (e.keyCode == 13) { 
            AddRow();
        }
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
                CalculateALL()
            } else {
              //swal("Your imaginary file is safe!");
            }
          });
    
        });

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
    var TotalQty = document.getElementById("totalQty").value;
    var TotalRow = document.getElementById("totalrow_closing").value;
    // var Notes = document.getElementById("pr_ketTransaksi").value;
    let url = base_url + '/SIKBREC/public/InventoryConsumable/addConsumableDetail/';
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
        // $("#Satuan").val(params.data[0]['Satuan_Beli']);
        //$("#QtyStok").val(50);
        // $("#Satuan_Konversi").val(params.data[0]['Unit Satuan']);
        // // $("#Konversi_satuan").val(params.data[0]['Konversi_satuan']);

        // //$("#xIdBarang").val(data.id);
        // $("#xNamaBarang").val(params.data[0]['Product Name']);
        // $("#QtyStok").val(data.qty);
        // $("#Satuan").val(data.Satuan);
  
        // //$("#Satuan_Konversi").val(data.Satuan); //satuan terkecil
        // $("#Konversi_satuan").val(data.konversisatuan); 

        
        $("#xNamaBarang").val(params.data[0]['Product Name']);
        $("#Satuan").val(params.data[0]['Satuan_Beli']);
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
        var id = $("#No_Transaksi").val();
        disableAll();
        if (id != ""){
            const data = await getDatabyID();  
            updateUIgetDatabyID(data);
            //showDataDetil();
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
    let url = base_url + '/SIKBREC/public/InventoryConsumable/addConsumableHeader/';
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
function addDetailsConsumableperitem(){
    if($("#xNamaBarang").val() == ''){
        $("#xNamaBarang").focus();
        toast("Nama Barang Kosong !", 'warning');
        return false;
    } kode_barang

    if($("#QtyOrder").val() == '' || $("#QtyOrder").val() == 0 ){
        $("#QtyOrder").focus();
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
    var UnitTujuan = document.getElementById("Unit").value;
    var hpp_barang = 0;
    var persediaan = 0;
    var totalpakai = 0;

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InventoryConsumable/addConsumableDetailv2/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kode_barang=' + kode_barang + '&nama_barang=' + nama_barang 
                + '&satuanbesar=' + satuanbesar + '&qtypakai=' + qtypakai 
                + '&satuankecil=' + satuankecil + '&nilaikonversisatuan=' + nilaikonversisatuan 
                + '&hpp_barang=' + hpp_barang + '&persediaan=' + persediaan + '&totalpakai=' + totalpakai 
                + '&No_Transaksi=' + No_Transaksi    
                + '&UnitTujuan=' + UnitTujuan   
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
async function AddRow(){
    try {
        $(".preloader").fadeIn();
       const xdaataa = await addDetailsConsumableperitem();
       updateaddDetailsConsumableperitem(xdaataa);
    } catch (err) {
       toast(err, "error")
    }


    // var totalitem = $("#totalrow_closing").val();
    // for (i = 1; i <= totalitem; i++) {
    //     if (kode_barang == $("#kode_barang"+i).val() ){
    //         swal({
    //             title: "Warning",
    //             text: nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!',
    //             icon: "warning",
    //         });
    //         toast(nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!','warning');
    //         return false;
    //     }
    // }

    //   if($('#totalrow_closing').val()==0){
    //     var count =0;
    //   }else{
    //     var count = parseFloat($('#totalrow_closing').val());
    //   }
    //   count = count + 1;
    //   document.getElementById('grantotalOrder_closing').innerHTML = count;
    //   $('#totalrow_closing').val(count);
    //     var newRow = $("<tr id='row_'" + count + "'>");
    //         //*1*/  newRow.html("<td><font size='1'>" + count + "</td>'"+
    //         /*2*/ newRow.html("'<td>" + kode_barang +"<input type='hidden' name='kode_barang[]' id='kode_barang" + count + "' class='kode_barang'"+count + "' value='" + kode_barang +"' ></font></td> '"+
    //         /*3*/"'<td><font size='1'>" + nama_barang_ + "<input type='hidden'  name='nama_barang_[]' id='nama_barang_" + count + "' value='" + nama_barang_ +"' ></font></td>'"+
    //         /*4*/"" + satuan_barang_ + "<input type='hidden' name='satuan_barang_[]' id='satuan_barang_" + count +"' value='" + satuan_barang_ +"'>"+
    //         /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='qty_barang_[]' id='qty_barang_" + count + "' value='" + qty_barang_ +"' ></td> '"+
    //          /*7*/"' <td>"+satuan_konversi_+"<input size='1'  value='" + satuan_konversi_ + "' type='hidden' name='satuan_konversi_[]'   id='satuan_konversi_" + count +"' ></td>'"+
    //          /*7*/"'<td>"+satuan_qty_+"<input size='1'  value='" + satuan_qty_ + "' type='hidden' name='satuan_qty_[]'   id='satuan_qty_" + count +"' ></td>'"+
    //         /*8*/"' <td><input size='5' readonly  type='text' name='hpp_barang_[]' onkeydown='FormatCell(this)'  id='hpp_barang_" + count + "' class='harga'  value='" + hpp_barang_ + "' ></td> '"+
    //         /*9*/"' <td><input size='1' readonly value='" + total_barang_ + "' type='text' name='total_barang_[]'   id='total_barang_" + count +"' >"+
    //         /*10*/"<td> <button type='button' onclick=\'deletedetilPerItemx("+kode_barang+","+count+")\'  name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + count + "' >Delete</Hapus> " +
    //             "</td>  </tr>")
    //             ;

    //     $('#user_data_closing').append(newRow);
        
    //     $("#xNamaBarang").val("");
    //     $("#Satuan").val("");
    //     $("#QtyStok").val('');
    //     $("#QtyOrder").val('');
    //     $("#hpp_add").val('');
    //     $("#nama_Barang").val('');
    //     $("#nama_Barang").focus(); 
    //     CalculateALL();

}

// function updateUIdataGocreateDtl(dataResponse) {
//     if(dataResponse.status == false){
//         toast(dataResponse.message, "error")
//     }else{
//         toast(dataResponse.message, "success")
//         $('#xNamaBarang').val('');
//         $('#xIdBarang').val('');
//         $('#QtyStok').val('');
//         $('#QtyOrder').val('');
//         $('#Satuan').val('');
//         $('#Konversi_Satuan').val('');
//         showDataDetil();
//     }
     
// }
// function GocreateDtl() {
//     var base_url = window.location.origin;
//     var TransasctionCode = $("#No_Transaksi").val();
//     var ProductName = $("#xNamaBarang").val();
//     var ProductCode = $("#xIdBarang").val();
//     var QtyStok = $("#QtyStok").val();
//     var QtyOrder = $("#QtyOrder").val();
//     var SatuanBarang = $("#Satuan").val();
//     var Satuan_Konversi = $("#Satuan_Konversi").val();
//     var Konversi_satuan = $("#Konversi_satuan").val();
//     // var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
//     let url = base_url + '/SIKBREC/public/InventoryConsumable/addConsumableDetails/';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: 'TransasctionCode=' + TransasctionCode
//             + '&ProductCode=' + ProductCode
//             + '&ProductName=' + ProductName
//             + '&QtyStok=' + QtyStok 
//             + '&QtyOrder=' + QtyOrder 
//             + '&SatuanBarang=' + SatuanBarang 
//             + '&Satuan_Konversi=' + Satuan_Konversi 
//             + '&Konversi_satuan=' + Konversi_satuan 
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

function showDataDetil() {
    var TransasctionCode = document.getElementById("No_Transaksi").value;
     //var TransasctionCode = "TOM050920220004"; 
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/InventoryConsumable/getConsumableDetailbyIDs/",
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
                    var html = '<font size="1"> ' + row.ProductSatuan + '</font>  ';
                    return html
                }
            },
            { "data": "QtyStok" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "Qty", render: $.fn.dataTable.render.number('.', ',', 2, '') }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="deletedetilPerItem(' + row.ProductCode + ')" ><span class="visible-content" > Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
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


    });
    $(".preloader").fadeOut();
} 


function updateUIgetDatabyID(dataResponse) {
    var tgltrs = dataResponse[0].TransactionDate;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
        
    $("#Unit").val(dataResponse[0].UnitCode).trigger('change');
    $("#Group_Transaksi").val(dataResponse[0].Group_Transaksi);
    $("#NoRegistrasi").val(dataResponse[0].NoRegistrasi);
    $("#Notes").val(dataResponse[0].Notes);
    $("#UserInput").val(dataResponse[0].NamaUserCreate);
    
    
    showDataDetil_View(dataResponse[0].TransactionCode);
}
function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InventoryConsumable/getConsumablebyID/';
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

function deletedetilPerItem(param,row_id) {
    try {
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
                    deletedetilPerItem2(param,value,row_id)
                });
    } catch (err) {
        toast(err, "error")
    }
    
}



async function deletedetilPerItem2(param,alasan,row_id) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetails = await goVoidDetails(param,alasan);
        updateUIdatagoVoidDetails(datagoVoidDetails,row_id);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails(params,row_id) {
    if(params.status === true){
        toast(params.message, "success")
        showDataDetil_View();
        $('#row_closing_' + row_id + '').remove();
                $('#row_closing_')
                var count = $('#totalrow_closing').val();
                //console.log(count);
                count = count - 1 ;
                document.getElementById('grantotalOrder_closing').innerHTML = count;
                $('#totalrow_closing').val(count);
                CalculateALL()
    }else{
        toast(params.message, "error")
    }
}

function goVoidDetails(param,alasan) {
    //var No_Transaksi = document.getElementById("No_Transaksi").value;
    var No_Transaksi = $("#No_Transaksi").val();
    var Unit = document.getElementById("Unit").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/InventoryConsumable/voidConsumableDetailbyItem";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&ProductCode=" + ProductCode 
        + "&Unit=" + Unit + "&AlasanBatal=" + alasan 
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
        setTimeout(() => {
            MyBack();
        }, 2000);
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
    var TotalQty = document.getElementById("totalQty").value;
    var TotalRow = document.getElementById("totalrow_closing").value;
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
    window.location = base_url + "/SIKBREC/public/InventoryConsumable/list";
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
        const data = await goVoidHeader2(param);
        updateUIdatagoVoidHeader2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function goVoidHeader2(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var Unit = document.getElementById("Unit").value;
    var url2 = "/SIKBREC/public/InventoryConsumable/voidConsumable";
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

function updateUIdatagoVoidHeader2(data) {
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

//GET DETAIL MUTASI BY ID
function showDataDetil_View(TransasctionCode) {
    var TransasctionCode = $("#No_Transaksi").val()
    total_items = 0;
    var dataHandler = $("#user_data_closing");
    dataHandler.html("");

     //var TransasctionCode = "TCS050220230004"; 
    var base_url = window.location.origin;
    var url2 = "/SIKBREC/public/InventoryConsumable/getConsumableDetailbyID/";

    $.ajax({
        type: "POST",
        data: "TransasctionCode=" + TransasctionCode,
        url: base_url + url2,
        success: function (result) {
            var resultObj = JSON.parse(result);
            $.each(resultObj, function (key, val) {
                total_items = total_items + 1;
                //$("#totalrow").val(total_items);
                // document.getElementById('totalrow').innerHTML = total_items;
                var newRow = $("<tr id='row_'" + total_items + "'>");
            //*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
            /*2*/ newRow.html("'<td>" + val.ProductCode +"<input type='hidden' name='kode_barang[]' id='kode_barang" + total_items + "' class='kode_barang'"+total_items + "' value='" + val.ProductCode +"' ></font></td> '"+
            /*3*/"'<td><font size='1'>" + val.ProductName + "<input type='hidden'  name='nama_barang_[]' id='nama_barang_" + total_items + "' value='" + val.ProductName +"' ></font></td>'"+
            /*4*/"' <input type='hidden' name='satuan_barang_[]' id='satuan_barang_" + total_items +"' value='" + val.Satuan +"'>"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='qty_barang_[]' id='qty_barang_" + total_items + "' value='" + val.Qty +"' ></td> '"+
             /*7*/"' <td>"+val.Satuan_Konversi+"<input size='1'  value='" + val.Satuan_Konversi + "' type='hidden' name='satuan_konversi_[]'   id='satuan_konversi_" + total_items +"' ></td>'"+
             /*7*/"'<td>"+val.KonversiQty+"<input size='1'  value='" + val.KonversiQty + "' type='hidden' name='satuan_qty_[]'   id='satuan_qty_" + total_items +"' ></td>'"+
            /*8*/"' <td><input size='5' readonly  type='text' name='hpp_barang_[]' onkeydown='FormatCell(this)'  id='hpp_barang_" + total_items + "' class='harga'  value='" + val.Hpp + "' ></td> '"+
            /*9*/"' <td><input size='1' readonly value='" + val.Total + "' type='text' name='total_barang_[]'   id='total_barang_" + total_items +"' >"+
            /*10*/"<td> <button type='button' onclick=\'deletedetilPerItem("+val.ProductCode+","+total_items+")\'  name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " +
                "</td>  </tr>")
                ;


                dataHandler.append(newRow);
            });
            $("#totalrow_closing").val(total_items);
            CalculateALL();

        }
    });

    $(".preloader").fadeOut();
}

function CalculateALL() {
    var totalqty = 0;
    var totalsubtotal = 0;
    var totalhpp = 0;
    var totalitem = $("#totalrow_closing").val()

    for (i = 1; i <= totalitem; i++) {

        itemID = document.getElementById("qty_barang_" + i);
        var qty = $("#qty_barang_" + i).val();
        //console.log(total_items);
        var Hpp = $("#hpp_barang_" + i).val();
        //var Subtotal = $("#hidden_total_barang_" + i).val();

            var subtotalx = parseFloat(qty) * parseFloat(Hpp);
            var Subtotal = $("#total_barang_" + i).val(subtotalx);
            
            //TOTAL  
            var totalqty = totalqty + parseFloat(qty);
             var totalhpp = totalhpp + parseFloat(Hpp);
             var totalsubtotal = totalsubtotal + subtotalx;
            

    //FOOTER
    $("#totalQty").val(number_to_price(totalqty));
    //$("#totalRow").val(number_to_price(total_items));

    // $("#grandtotalqty").val(number_to_price(totalqty));
    // $("#HppTotal").val(number_to_price(totalhpp));
    // $("#grandtotalxl").val(number_to_price(totalsubtotal));

     $("#grandtotalqty_text").text(number_to_price(totalqty));
     $("#HppTotal_text").text(number_to_price(totalhpp));
     $("#grandtotalxl_text").text(number_to_price(totalsubtotal));
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
    if (v == 0) { return '0,00'; }
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
    CalculateALL();
});
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

function showID(noreg){
    $("#NoRegistrasi").val(noreg);
    toast('Pasien berhasil dipilih !', "success");
        swal({
            title: 'Success',
            text: 'Pasien berhasil dipilih !',
            icon: 'success',
        }).then(function() {
            $("#btnSearching_modal").modal('hide')
        });
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
        for (var i = 0; i < arrayLength; i++) {
    kode_barang = dataResponse.data[i].ProductCode;
    nama_barang_ = dataResponse.data[i].ProductName;
    satuan_barang_ = dataResponse.data[i].Satuan;
    qty_barang_ = dataResponse.data[i].Qty;
    satuan_konversi_ = dataResponse.data[i].Satuan_Konversi;
    satuan_qty_ = dataResponse.data[i].KonversiQty;
    //hpp_barang_ = $("#hpp_add").val(1);
    hpp_barang_ = 1;
    total_barang_ = qty_barang_*hpp_barang_;

    var totalitem = $("#totalrow_closing").val();
    var istaken = '0';
    for (x = 1; x <= totalitem; x++) {
        if (kode_barang == $("#kode_barang"+x).val() ){
            swal({
                title: "Warning",
                text: nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!',
                icon: "warning",
            });
            toast(nama_barang_+' sudah ada di list! Tidak dapat input barang yang sama! Mohon diperiksa kembali!','warning');
            var istaken = '1';
        }
        //console.log(kode_barang,$("#kode_barang"+i).val(),istaken);

    }
    if (istaken == '1'){
        continue;
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
            /*4*/"" + satuan_barang_ + "<input type='hidden' name='satuan_barang_[]' id='satuan_barang_" + count +"' value='" + satuan_barang_ +"'>"+
            /*6*/"' <td><input  size='2'  type='text' onkeydown='FormatCell(this)'  name='qty_barang_[]' id='qty_barang_" + count + "' value='" + qty_barang_ +"' ></td> '"+
             /*7*/"' <td>"+satuan_konversi_+"<input size='1'  value='" + satuan_konversi_ + "' type='hidden' name='satuan_konversi_[]'   id='satuan_konversi_" + count +"' ></td>'"+
             /*7*/"'<td>"+satuan_qty_+"<input size='1'  value='" + satuan_qty_ + "' type='hidden' name='satuan_qty_[]'   id='satuan_qty_" + count +"' ></td>'"+
            /*8*/"' <td><input size='5' readonly  type='text' name='hpp_barang_[]' onkeydown='FormatCell(this)'  id='hpp_barang_" + count + "' class='harga'  value='" + hpp_barang_ + "' ></td> '"+
            /*9*/"' <td><input size='1' readonly value='" + total_barang_ + "' type='text' name='total_barang_[]'   id='total_barang_" + count +"' >"+
            /*10*/"<td> <button type='button' onclick=\'deletedetilPerItemx("+kode_barang+","+count+")\'  name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + count + "' >Delete</Hapus> " +
                "</td>  </tr>")
                ;

        $('#user_data_closing').append(newRow);
        
        // $("#xNamaBarang").val("");
        // $("#Satuan").val("");
        // $("#QtyStok").val('');
        // $("#QtyOrder").val('');
        // $("#hpp_add").val('');
        // $("#nama_Barang").val('');
        // $("#nama_Barang").focus();
        // $("#nama_Barang").empty();
        // $("#nama_Barang").select2('open');
        }
        CalculateALL();

        $("#btnPaketDetail_modal").modal('hide')
        $("#btnPaket_modal").modal('hide')
    }
     
}
async function GocreateDtlPaket() {
    var base_url = window.location.origin;
    var TransasctionCode = document.getElementById("No_Transaksi").value;
    var UnitTujuan = document.getElementById("Unit").value;
    var IdPaket = document.getElementById("id_header_paket").value;
    var NoRegistrasi = document.getElementById("NoRegistrasi").value;
    // var Konversi_Satuan = document.getElementById("Konversi_Satuan").value;
    let url = base_url + '/SIKBREC/public/InventoryConsumable/createDtlTrsPaket/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'TransasctionCode=' + TransasctionCode
            + '&UnitTujuan=' + UnitTujuan 
            + '&IdPaket=' + IdPaket 
            + '&NoRegistrasi=' + NoRegistrasi 
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

