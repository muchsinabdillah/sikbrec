$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        showdatatabel(); 
    });

    $( "#nama_Barang" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: window.location.origin + "/SIKBREC/public/PurchaseForm/getDataBarangbyName",
            dataType: "json",
            type: 'post',
            data: {
              searchTerm: request.term,
              grupBarang: $('#pr_jenistransaksi').val()
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
              $("#xNamaBarang").val(ui.item.label);
              return false; 
          }
  })
});

function TrigerTgl() {
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;

    
    var nowDateawal = new Date(PeriodeAwal);
    var nowDateakhir = new Date(PeriodeAkhir);
    var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if(Difference_In_Days > 30 ){
    //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
 
    // }
 }
 async function asyncShowMain() {
    try {
        const datagetNamaUnit = await getNamaUnit();
        updateUIgetNamaUnit(datagetNamaUnit);
        const dataBarang = await getBarang();
        console.log(dataBarang)
        // updateUIdataBarang(dataBarang);
    $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
    
}
function getBarang() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InfoBuku/getBarangAll';
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
            $("#NamaUnit").select2();
        })
}
function updateUIgetNamaUnit(datagetNamaUnit) {
    let data = datagetNamaUnit;
    if (data !== null && data !== undefined) {
        console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaUnit").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].NamaUnit + '</option';
            $("#NamaUnit").append(newRow);
        }
    }
}
function getNamaUnit() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InfoStok/getNamaUnit';
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
            $("#NamaUnit").select2();
        })
}
 function showdatatabel() {
        // console.log ('ssssss')
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var NamaUnit = $("#NamaUnit").val();
    var KodeBarang = $("#xIdBarang").val();

     var base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InfoBuku/getDataListInfoBuku",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                d.PeriodeAwal = PeriodeAwal;
                d.PeriodeAkhir = PeriodeAkhir;
                d.NamaUnit = NamaUnit;
                d.KodeBarang = KodeBarang;
            },
            "deferRender": true,
        },
        
        "columns": [
            { "data": "Kode_Transaksi" },
            { "data": "Tgl_Transaksi" },
            { "data": "Kode_Barang" },
            { "data": "Nama_Barang" },
            { "data": "Satuan" },
            { "data": "SaldoAwal"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "Qty_In"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "Qty_Out" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "SaldoAkhir"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "SaldoPersediaanAwal"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "PersediaanIn"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "PersediaanOut"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "SaldoPersediaanAkhir"  ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "No_Trs_Reff2" },
            
        ],
        dom: 'Bfrtip',
            buttons: [
               'excelHtml5'
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

                total6 = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total7 = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total8 = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
     
    
                $(api.column(5).footer()).html(
                    $.fn.dataTable.render.number('.', ',', 2,'').display(total15)
                );
                $(api.column(6).footer()).html(
                    $.fn.dataTable.render.number('.', ',', 2,'').display(total6)
                );
                $(api.column(7).footer()).html(
                    $.fn.dataTable.render.number('.', ',', 2,'').display(total7)
                );
                $(api.column(8).footer()).html(
                    $.fn.dataTable.render.number('.', ',', 2,'').display(total8)
                );
            },
    });
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
