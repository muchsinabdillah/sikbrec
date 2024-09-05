$(document).ready(function () {

    onLoadFunctionAll();
    $('#btnNewOrder').click(function(){
        createHeaderPelunasanHutang();
    });
    $('#btnSearchMrAktif').click(function () {
        getDatOrderHutang();
    });
    $(document).on('click', '#passkodepox', function () {
        var row_id = $(this).attr("value");
        console.log(row_id);      
        ShowOrderHutangbyId(row_id); 
    });
    $(document).on('click', '#btnSavePoli2', function () {
        editDetailPelunasanHutang();
    });
    $('#btnSimpan').click(function(){
        swal({
                title: "Final Verifikasi",
                text: "Data yang sudah di Finalkan tidak bisa di Edit kembali, Lanjutan Transaksi ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
                .then((willDelete) => {
                if (willDelete) {
                    go_save();
                } else {
                   swal("Transaction Rollback !");
                }
              }); 
        });
});
async function go_save(){
        try { 
            const datago_save_final = await go_save_final(); 
            updatego_save_final(datago_save_final);
        } catch (err) {
            toast(err, "error")
        }
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Hutang/PelunasanHutang";
}
function updatego_save_final(data) {
    if (data.status == "success") {
        toast("Data  Berhasil Disimpan .", "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}
function go_save_final() {
    var RekeningPelunasan = document.getElementById("RekeningPelunasan").value;   
    var KodeSupplier = document.getElementById("KodeSupplier").value;  
    var Periode = document.getElementById("Periode").value;  
    var NoOrder = document.getElementById("NoOrder").value;   
    var NoPelunasan = document.getElementById("NoPelunasan").value;   
    
    var url2 = "/SIKBREC/public/Hutang/goVerifikasiPelunasanHutangFinish";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTranSaksiPelunasan=" + NoPelunasan 
        + "&NoTranSaksiOrder=" + NoOrder  
        + "&kdrekanan=" + KodeSupplier  
        + "&tglperiode=" + Periode   
        + "&RkeningKas=" + RekeningPelunasan   
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
async function editDetailPelunasanHutang() {
    try {
       
            const datagoEditHutangDetailPelunasan = await goEditHutangDetailPelunasan();
            //console.log(datagoEditHutangDetailPelunasan);
             updategoEditHutangDetailPelunasan(datagoEditHutangDetailPelunasan);
    } catch (err) {
        toast(err, "error")
    }
}
function updategoEditHutangDetailPelunasan(data){
    var nopelunasan =   $("#NoPelunasan").val(); 
    $('#Modal_verifikasi').modal('hide'); 
    loaddetailPelunasan(nopelunasan);
}
function goEditHutangDetailPelunasan() {
    var JM_ID = document.getElementById("JM_ID").value;   
    var JM_Keterangan = document.getElementById("JM_Keterangan").value;  
    var JM_NIlaiSisa = document.getElementById("JM_NIlaiSisa").value;  
    var JM_NilaiVerif = document.getElementById("JM_NilaiVerif").value;   
    
    var url2 = "/SIKBREC/public/Hutang/goEditHutangDetailPelunasan";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "JM_ID=" + JM_ID 
        + "&JM_Keterangan=" + JM_Keterangan  
        + "&JM_NIlaiSisa=" + JM_NIlaiSisa  
        + "&JM_NilaiVerif=" + JM_NilaiVerif   
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
async function ShowForm(row_id){
    try {
        $("#JM_ID").val(row_id);
            const dtgetDetailPelunasan = await getDetailPelunasan(row_id);
            updategetDetailPelunasan(dtgetDetailPelunasan);
    } catch (err) {
        toast(err, "error")
    }
}
function updategetDetailPelunasan(data){
   $('#Modal_verifikasi').modal('show');
      
        $("#JM_Keterangan").val(data.KET);
        $("#JM_NIlaiSisa").val(data.SISA_HUTANG); 
        $("#JM_NilaiVerif").val(data.NILAI_PAY); 
}
function getDetailPelunasan(row_id) {
    var NoTrs = row_id;
    var url2 = "/SIKBREC/public/hutang/getPelunasanHutanfDetailbyID";
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
async function ShowOrderHutangbyId(row_id) {
    try {
       
            const datagetOrderHutangbyId = await getOrderHutangbyId(row_id);
            console.log(datagetOrderHutangbyId);
            updateOrderHutangbyId(datagetOrderHutangbyId);
    } catch (err) {
        toast(err, "error")
    }
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
function updateOrderHutangbyId(data) {
    // var tgltrs = data.TGL_ORDER;
    // var d = new Date(tgltrs);
    // d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
    //             $('#TglTransaksi').val(d.toISOString().substring(0,d.toISOString().length-1));
                 $("#NoOrder").val(data.KD_TRS_ORDER);
                  $("#Periode").val(data.PERIODE);  
                  $("#KodeSupplier").val(data.KD_REKANAN);  
                //   $("#TotalHutang").val(data.TOTALHUTANG); 
                 $("#NamaSupplier").val(data.KD_REKANAN).trigger('change');
                  
                 // $("#myModal").modal('hide');
}
async function createHeaderPelunasanHutang() {
    try {
        const datagoCreatePelunasanHutang = await goCreatePelunasanHutang();
        updatedatagoCreatePelunasanHutang(datagoCreatePelunasanHutang);
    } catch (err) {
        toast(err, "error")
    }
}
function updatedatagoCreatePelunasanHutang(nohutang){
    $("#NoPelunasan").val(nohutang.notransaksi); 
    document.getElementById("btnNewOrder").disabled = true;
    loaddetailPelunasan(nohutang.notransaksi);
}
function loaddetailPelunasan(notransaksi){
    var base_url = window.location.origin;
    var notransaksi = notransaksi; 
    let url = base_url + '/SIKBREC/public/hutang/loadDetilPelunasanHutang';
    $('#table-pelunasan-hutang').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#table-pelunasan-hutang').DataTable({
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      
       "ajax": {
        "url": url,
        "type": "POST",
            data: function ( d ) {
            d.notransaksi = notransaksi; 
          },
        "dataSrc": "",
        "deferRender": true,
    },
        "columns": [  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = ""
                var html  = '<font size="2">'+row.KD_TRS_ORDER+' </font>';
                return html 
            }
          }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                var html = "" 
                var html  = '<span class="badge badge-secondary" onclick="ShowForm('+row.ID+')"><font size="1">'+row.KD_HUTANG+' </font></span>';
                return html 
            }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                    var html = ""
                    var html  = '<font size="2">'+row.KET+' </font>';
                    return html 
                }
            }, 
            { "data": "SISA_HUTANG" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
            { "data": "NILAI_PAY" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )}, 
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
          ] 
    });
}
function goCreatePelunasanHutang() {
    var TglTransaksi = document.getElementById("TglTransaksi").value;  
    var TransasctionDate = TglTransaksi.replace('Z', '').replace('T', ' ').replace('.000', '');
    var NoOrder = document.getElementById("NoOrder").value;  
    var RekeningPelunasan = document.getElementById("RekeningPelunasan").value;  
    var Periode = document.getElementById("Periode").value;  
    var KodeSupplier = document.getElementById("KodeSupplier").value;  
    var NoPelunasan = document.getElementById("NoPelunasan").value;  
    
    var url2 = "/SIKBREC/public/Hutang/createPelunasanHUtangHeader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "TglTransaksi=" + TransasctionDate 
        + "&NoOrder=" + NoOrder  
        + "&RekeningPelunasan=" + RekeningPelunasan  
        + "&NoPelunasan=" + NoPelunasan  
        + "&Periode=" +  Periode
        + "&KodeSupplier=" +  KodeSupplier
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
async function onLoadFunctionAll() {
    try {
        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        const datagetSupplieras = await getRekening();
        updateUIdatagetRekening(datagetSupplieras);
   
        if ($("#NoPelunasan").val() != '') {
            // const datagetTukarFakturHeader = await getTukarFakturHeader();
            // updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
        }
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
function updateUIdatagetRekening(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) { 
        var newRow = '<option value="">-- PILIH --</option';
        $("#RekeningPelunasan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].FS_KD_REKENING + '">' + responseApi.data[i].FS_NM_REKENING + '</option>';
            $("#RekeningPelunasan").append(newRow);
        }
    }
}
function getRekening() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningAllAktif';
    return fetch(url, {
        method: 'GET',
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
            $("#RekeningPelunasan").select2();
        })
}

function getDatOrderHutang() {
    var tglperiodex = $("[name='PeriodePencarian']").val(); 
        $('#table-order-hutang').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-order-hutang').DataTable({
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
                         
                          var html  = '<a class="btn btn-danger" id="passkodepox" name="passkodepox"  value='+row.ID+'>PILIH</a> '
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