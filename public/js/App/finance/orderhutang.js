$(document).ready(function () {

    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    }

    $("#table-load-data").on('change', function() {
        var checkedCount = $("#table-load-data input:checked").length;
        var creditAmount = 0;
    
        for (var i = 0; i < checkedCount; i++) {
    
          var amount = $("#table-load-data input:checked")[i].parentNode.parentNode.children[4].innerHTML

          var amount_converted = intVal(amount)
          if (isNaN(amount_converted)) {
            amount_converted = 0;
          }
    
          if (amount != "") {
            creditAmount += parseFloat(amount_converted);
          } else {
            creditAmount = 0;
          }
        }
    
        $("#TotalHutang").val(creditAmount);
        $("#grandtotalTxt").text(number_to_price(creditAmount))
    
      });

    onLoadFunctionAll();
    // $('#btnSimpan').click(function () {
    //     swal({
    //         title: "Simpan",
    //         text: "Pastikan Data yang dimasukan sudah sesuai, Lanjut Simpan?",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //         .then((willDelete) => {
    //             if (willDelete) { 
    //                 goCreateOrderHutang();
    //             } else {
    //                 // swal("Transaction Rollback !");
    //             }
    //         });

    // });
    $('#btnSearchMrAktif').click(function () {
        getDatOrderHutang();
    });
    // $(document).on('click', '#passkodepox', function () {
    //    // var row_id = $(this).attr("value");
    //     //console.log(row_id);      
    //     ShowOrderHutangbyId(row_id); 
    // });
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

    $('#btn_caridatamr').click(function () {
        $("#myModal").modal('show');
    });
});
async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidHeader2 = await goVoidHeader2(param);
        updateUIdatagoFinishBatal(datagoVoidHeader2);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinishBatal(data) {
    if (data.status == "success") {
        toast("Data Order Hutang Berhasil Dibatalkan .", "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}
function goVoidHeader2(param) {
    var No_Transaksi = document.getElementById("NoTransaksi").value;  
    var url2 = "/SIKBREC/public/Hutang/goVoidOrderHutang";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi 
        + "&AlasanBatal=" + param  
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
async function ShowOrderHutangbyId(row_id) {
    try {
       
            const datagetOrderHutangbyId = await getOrderHutangbyId(row_id);
            updateOrderHutangbyId(datagetOrderHutangbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateOrderHutangbyId(data) {
    var tgltrs = data.TGL_ORDER;
    var d = new Date(tgltrs);
    d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
                $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
                 $("#NoTransaksi").val(data.KD_TRS_ORDER);
                  $("#Periode").val(data.PERIODE);  
                  $("#TotalHutang").val(data.TOTALHUTANG); 
                  $("#NamaSupplier").val(data.KD_REKANAN).trigger('change');

                   $('#TglTransaksi').prop('readonly', true)
                   $("#Periode").prop('readonly', true)
                   $("#TotalHutang").prop('readonly', true)
                   $("#NamaSupplier").prop('disabled', true)
                  loadOrderByID(data.ID);
                  $("#myModal").modal('hide');
}
function loadOrderByID(x){ 
    var nf = new Intl.NumberFormat();
       var IdTRS = x;
       $('#table-load-data').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-load-data').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/hutang/getOrderHutangDetailbyId",
              "type": "POST",
                  data: function ( d ) {
                  d.IdTRS = IdTRS; 
                },
              "dataSrc": "",
              "deferRender": true,
          },
              "columns": [ 
                { "data": "KD_HUTANG" },
                { "data": "KD_HUTANG" },
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="2">'+row.TGL_HUTANG+' </font>';
                        return html 
                    }
                  }, 
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="2">'+row.KET+' </font>';
                        return html 
                    }
                  }, 
                  { "data": "NILAI_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
              ], 
              "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
   
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
                  total3 = api
                  .column( 4 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
  
              // Update footer
              $( api.column( 4 ).footer() ).html(
                  $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total3 )
              );
              
          },
               dom: 'Bfrtip',
                buttons: [ 
                    'colvis'
                ] ,
        // 'columnDefs': [
        //    {
        //       'targets': 0,
        //       'checkboxes': {
        //          'selectRow': true
        //       }
        //    }
        // ],
        // 'select': {
        //    'style': 'multi'
        // },
        // 'order' : [1,'asc']
          });
  }
function getOrderHutangbyId(row_id) {
    var NoTrs = row_id;
    var url2 = "/SIKBREC/public/hutang/getOrderHutangbyId";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTrs=" + NoTrs
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
function getDatOrderHutang() {
    var tglperiodex = $("[name='PeriodePencarian']").val(); 
        $('#table-load-data-detilxx').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-load-data-detilxx').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/hutang/getListOrderHutangJatuhTempo",
              "type": "POST",
                  data: function ( d ) { 
                  d.Periode = tglperiodex; 
                },
              "dataSrc": "",
              "deferRender": true,
          },
              "columns": [  
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.KD_TRS_ORDER+' </font>';
                        return html 
                    }
                  }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.TGL_ORDER+' </font>';
                        return html 
                    }
                  }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.Company+' </font>';
                        return html 
                    }
                  }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.NamaUser+' </font>';
                        return html 
                    }
                  },  
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                         
                          var html  = '<a class="btn btn-danger" id="passkodepox" name="passkodepox" onclick="ShowOrderHutangbyId('+row.ID+')"  value='+row.ID+'>PILIH</a> '
                             return html 
                      }
                  },
              ],
               dom: 'Bfrtip',
                buttons: [ 
                    'colvis'
                ] 
          });
  }
 
async function goCreateOrderHutang() {
    try {
        $(".preloader").fadeIn(); 
        const datagoFinishDetil = await goFinishDetil();
        updateUIdatagoFinish(datagoFinishDetil); 
    } catch (err) {
        toast(err, "error")
    }
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Hutang/listOrderPembayaranHutan";
}
function updateUIdatagoFinish(data) {
    if (data.status == "success") {
        toast("Data Berhasil Disimpan .", "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}
async function goFinishDetil() {
    var data = $("#form_order, #form_table").serialize();
    var date = document.getElementById("TglTransaksi").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/hutang/createOrderHutang";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data  
        +"&TransasctionDate="+TransasctionDate 
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

async function DataHutangJatuhTempo(){
    var NoTransaksi = document.getElementById("NoTransaksi").value;
    if(NoTransaksi == ''){
        try {
            $(".preloader").fadeIn();
            const dataHutang = await getDataHutangJatuhTempo();
            //console.log(dataHutang);
           // updateUIdatagetSuppliers(dataHutang);
           $(".preloader").fadeOut();
        } catch (err) {
            toast(err, "error")
        }
    }
  
}
async function getDataHutangJatuhTempo() {
    var base_url = window.location.origin;
    var Periode1 = document.getElementById("Periode1").value;
    var Periode2 = document.getElementById("Periode2").value;
    var NamaSupplier = document.getElementById("NamaSupplier").value;
    let url = base_url + '/SIKBREC/public/hutang/getHutangJatuhTempo';
    $('#table-load-data').dataTable({
        "bDestroy": true
    }).fnDestroy();
    var xxd = $('#table-load-data').DataTable({
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      
       "ajax": {
        "url": url,
        "type": "POST",
            data: function ( d ) {
            d.NamaSupplier = NamaSupplier;
            d.Periode1 = Periode1; 
            d.Periode2 = Periode2; 
          },
        "dataSrc": "",
        "deferRender": true,
    },
        "columns": [  
           
            { "data": "KD_HUTANG" }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.KD_HUTANG+' </font>';
                  return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.TGL_HUTANG+' </font>';
                  return html 
              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                  var html = ""
                  var html  = '<font size="2">'+row.KET+' </font>';
                  return html 
              }
            }, 
            { "data": "NILAI_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'' )}, 
        ], 
    //     "footerCallback": function ( row, data, start, end, display ) {
    //     var api = this.api(), data;

    //     // Remove the formatting to get integer data for summation
    //     var intVal = function ( i ) {
    //         return typeof i === 'string' ?
    //             i.replace(/[\$,]/g, '')*1 :
    //             typeof i === 'number' ?
    //                 i : 0;
    //     };
    //     let count = api.rows({ selected: true }).count();
    //     console.log(count,'dddd');
    //         total3 = api
    //         .column( 4 )
    //         .data()
    //         .reduce( function (a, b) {
    //             return intVal(a) + intVal(b);
    //         }, 0 );
    //         $("#TotalHutang").val(total3);
    //     // Update footer
    //     $( api.column( 4 ).footer() ).html(
    //         $.fn.dataTable.render.number( ',','.','2','Rp. ').display( total3 )
            
           
    //     );
        
    // },
         dom: 'Bfrtip',
          buttons: [ 
              'colvis'
          ] ,
           'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order' : [1,'asc']
    });
}
async function onLoadFunctionAll() {
    try {

        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
      
        // if ($("#No_Transaksi").val() != '') {
        //     const datagetTukarFakturHeader = await getTukarFakturHeader();
        //     updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
        // }
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaSupplier").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#NamaSupplier").append(newRow);
        }
    }
}
function getSuppliers() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPurchaseOrder/getSuppliers';
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
            $("#NamaSupplier").select2();
        })
}

//

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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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

function btnCheckedBox(thisid){
    var table = $('#table-load-data').DataTable();
    var form = $("#form_table");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="iddetail\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'iddetail[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }
    //Swal
    swal({
        title: "Warning",
        text: "Apakah anda yakin ingin menyimpan yang dipilih ?",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                goCreateOrderHutang();
            } 
        });
}


async function saveCheckedBox() {
    try {
        const data = await gosaveCheckedBox();
        updateUIdata(data);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdata(params) {
    let response = params;
    if (response.status == "success") {
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        loaddetailPelunasan($("#NoPelunasan").val());
    }else{
        toast(response.message, "error")
    }
}

function gosaveCheckedBox() {
    const form = $("#form_table").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/hutang/goEditHutangDetailPelunasanChecklist';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
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
