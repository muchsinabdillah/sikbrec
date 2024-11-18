$(document).ready(function () {

    $(document).on('click', '#btn_caridatamr', function () {
        $("#myModal").modal('show');
    });
    onLoadFunctionAll();
    $('#btnNewOrder').click(function(){
        createHeaderPelunasanHutang();
    });
    $('#btnSearchMrAktif').click(function () {
        getDatOrderHutang();
    });
    $(document).on('click', '#passkodepox', function () {
        var row_id = $(this).attr("value"); 
        ShowOrderHutangbyId(row_id); 
    });
    $(document).on('click', '#detailorder', function () {
        var row_id = $(this).attr("value");     
        getOrderHutangDetailbyIdOrder(row_id); 
    });
    $(document).on('click', '#btnModalSrcPasienClose', function () {
        $("#myModaldetilHutang").modal('hide');
        $("#myModal").modal('show');
    });
    $(document).on('click', '#btnModalSrcPasienCloseX', function () {
        $("#myModal").modal('hide'); 
    });
    $(document).on('click', '#btnSavePoli2', function () {
        editDetailPelunasanHutang();
    });
    $('#VoidPelunasanHutang').click(function () {
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
        toast("Data Pelunasan Hutang Berhasil Dibatalkan .", "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}
function goVoidHeader2(param) {
    var NoPelunasan = document.getElementById("NoPelunasan").value;  
    // console.log(param);return false;
    var url2 = "/SIKBREC/public/Hutang/goVoidPelunasanHutang";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoPelunasan=" + NoPelunasan 
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
    window.location = base_url + "/SIKBREC/public/Hutang/ListPelunasanHutang";
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
    var KodeSupplier = document.getElementById("NamaSupplier").value;  
    var Periode1 = document.getElementById("Periode1").value;  
    var Periode2 = document.getElementById("Periode2").value;  
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
        + "&Periode1=" + Periode1   
        + "&Periode2=" + Periode2   
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
function getOrderHutangDetailbyIdOrder(row_id) {
    $("#myModal").modal('hide');
    $("#myModaldetilHutang").modal('show'); 
        $('#table-order-hutang-details').dataTable({
              "bDestroy": true
          }).fnDestroy();
          $('#table-order-hutang-details').DataTable({
              "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            
             "ajax": {
              "url": "/SIKBREC/public/hutang/getOrderHutangDetailbyIdOrder",
              "type": "POST",
                  data: function ( d ) { 
                  d.NoTrs = row_id; 
                },
              "dataSrc": "",
              "deferRender": true,
          },
              "columns": [  
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.KD_HUTANG+' </font>';
                        return html 
                    }
                  }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1"> '+row.TGL_FAKTUR+' </font>';
                        return html 
                    }
                  }, 
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                    var html = ""
                    var html  = '<font size="1">'+row.TGL_HUTANG +'</font>';
                    return html 
                        }
                    }, 
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1"> '+row.TGL_TEMPO+' </font>';
                        return html 
                            }
                        }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+row.KET+' </font>';
                        return html 
                    }
                  }, 
                   { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                        var html = ""
                        var html  = '<font size="1">'+ number_to_price(row.NILAI_HUTANG) +' </font>';
                        return html 
                    }
                  }, 
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                    var html = ""
                    var html  = '<font size="1">'+ number_to_price(row.SISA_HUTANG) +' </font>';
                    return html 
                }
              },   
              ]
               
          });
  }
 
async function ShowOrderHutangbyId(row_id) {
    try {
       
            const datagetOrderHutangbyId = await getOrderHutangbyId(row_id);
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
                  $("#Periode1").val(data.PeriodeHutangAwal);  
                  $("#Periode2").val(data.PeriodeHutangAkhir);  
                  $("#KodeSupplier").val(data.KD_REKANAN);  
                //   $("#TotalHutang").val(data.TOTALHUTANG); 
                 $("#NamaSupplier").val(data.KD_REKANAN).trigger('change');
                  toast('Berhasil dipilih','success')
                  $("#myModal").modal('hide');
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
    document.getElementById("btn_caridatamr").disabled = true;
    loaddetailPelunasan(nohutang.notransaksi);
}
function loaddetailPelunasan(notransaksi){  
    var base_url = window.location.origin;
    const NoPelunasan = $("#NoPelunasan").val();
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
            d.notransaksi = NoPelunasan; 
          },
        "dataSrc": "",
        "deferRender": true,
    },
        "columns": [  
            { "data": "ID" },
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
function goCreatePelunasanHutang() {
    var TglTransaksi = document.getElementById("TglTransaksi").value;  
    var TransasctionDate = TglTransaksi.replace('Z', '').replace('T', ' ').replace('.000', '');
    var NoOrder = document.getElementById("NoOrder").value;  
    var RekeningPelunasan = document.getElementById("RekeningPelunasan").value;  
    var Periode1 = document.getElementById("Periode1").value;  
    var Periode2 = document.getElementById("Periode2").value;  
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
        + "&Periode1=" +  Periode1
        + "&Periode2=" +  Periode2
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
            const datagetTukarFakturHeader = await getTukarFakturHeader();
            updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
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
                        var html  = '<font size="1">'+ number_to_price(row.NILAI_HUTANG) +' </font>';
                        return html 
                    }
                  }, 
                  { "render": function ( data, type, row ) { // Tampilkan kolom aksi 
                    var html = ""
                    var html  = '<font size="1">'+ number_to_price(row.SISA_HUTANG) +' </font>';
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
                         
                          var html  = '<a class="btn btn-success" id="detailorder" name="detailorder"  value='+row.ID+'>VIEW</a><a class="btn btn-danger" id="passkodepox" name="passkodepox"  value='+row.ID+'>PILIH</a> '
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

function btnCheckedBox(thisid){
    var table = $('#table-pelunasan-hutang').DataTable();
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
        text: "Apakah anda yakin ingin menyimpan nilai pelunasan yang dipilih ?",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    saveCheckedBox();
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


function updateUIdatagetTukarFakturHeader(params) {
    let response = params;
    if (response.status == "success") {
        $("#TglTransaksi").val(response.data.TGL_PAY)
        $("#NoOrder").val(response.data.KD_TRS_ORDER)
        $("#Periode1").val(response.data.PeriodeHutangAwalx)
        $("#Periode2").val(response.data.PeriodeHutangAkhirx)
        $("#NamaSupplier").val(response.data.KD_REKANAN).trigger('change')
        $("#RekeningPelunasan").val(response.data.REK_PELUNASAN).trigger('change')
        $("#btnNewOrder").prop('disabled',true)
        $("#btn_caridatamr").prop('disabled',true)
        
        loaddetailPelunasan(response.data.KD_TRS_ORDER)
    }else{
        toast(response.message, "error")
    }
}

async function getTukarFakturHeader() {
    const NoPelunasan = $("#NoPelunasan").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/hutang/getTukarFakturHeader';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoPelunasan=" +NoPelunasan
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