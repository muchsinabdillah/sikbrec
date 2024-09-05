$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
    $('#datatable').DataTable({});
    $('#datatable_listuse').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        var sd = $("#PeriodeAwal").val()
        var ed = $("#PeriodeAkhir").val()
        var cek = CheckVar(sd,ed);
        if (cek == true){
             getDataListOrderDarah(sd,ed);
        }

    });
    $(document).on('click', '#btnLoadInformation_use', function () {
        var sd = $("#PeriodeAwal_use").val()
        var ed = $("#PeriodeAkhir_use").val()
        var cek = CheckVar(sd,ed);
        if (cek == true){
            getDataListUseDarah(sd,ed);
       }
    });
});

function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if (Difference_In_Days > 31) {
    //     alert("Periode Penarikan Data Adalah 31 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
    //     $('#btnLoadInformation').attr('disabled', true);
    // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // }
}
function CheckVar (sd,ed){
    //if not in creteria return false
    if (sd == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if (ed == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }

    return true;

    // getDataListOrderDarah();
}


function getDataListOrderDarah(sd,ed) { 
    // let PeriodeAwal ,PeriodeAkhir;
    // PeriodeAwal = $("#PeriodeAwal").val();
    // PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataListOrderDarah", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = sd;
               d.TglAkhir = ed;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.ID+'</font> ';
            return html 
        }
      },
       { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.DateOrder+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoMR+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoRegistrasi+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.NamaTarifDarah+'</font> ';
        return html 
    }
    },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.PatientName+'</font> ';
            return html 
        }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.NamaJaminan+'</font> ';
        return html 
    }
},
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.GolonganDarah+'</font> ';
        return html 
    }
    },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.UserOrderName+'</font> ';
                return html 
            }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.JenisOrder+'</font> ';
            return html 
        }
    },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.StatusOrder+'</font> ';
            return html 
        }
    },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html2 = ""

            if (row.ReviewQtyOrder == '0'){
                var html2 = '<button type="button" class="btn btn-info btn-xs"  onclick="showInputReviewDarah(' + row.ID + ')" >Review</button>';
            }else{
                var html2 = '<button type="button" class="btn btn-info btn-xs"  onclick="showInputReviewDarah(' + row.ID + ')" disabled>Review</button>';
            }
            // if (row.StatusOrder == 'Approved'){
            //     var html  =  ' <button type="button" class="btn btn-danger btn-xs"  onclick="showInputPakaiDarah(' + row.ID + ')" >Pakai</button>  <button type="button" class="btn btn-danger btn-xs"  onclick="showReturDarah(' + row.ID + ')" >Retur</button>';
            // }else{
            //     var html  =  '<button type="button" class="btn btn-danger btn-xs"  onclick="showInputPakaiDarah(' + row.ID + ')" disabled>Pakai</button>  <button type="button" class="btn btn-danger btn-xs"  onclick="showReturDarah(' + row.ID + ')" disabled>Retur</button>';
            // }
            if (row.StatusOrder == 'Approved'){
                var html  =  ' <button type="button" class="btn btn-danger btn-xs"  onclick="showInputPakaiDarah(' + row.ID + ','+row.IsUsed+')" >Pakai</button>';
            }else{
                var html  =  '<button type="button" class="btn btn-danger btn-xs"  onclick="showInputPakaiDarah(' + row.ID + ','+row.IsUsed+')" disabled>Pakai</button>';
            }
            
            return html2+html 
        }
      }

                ],
//        dom: 'Bfrtip',
//       buttons: [
//       'copyHtml5',
//       {
//           extend: 'excelHtml5',
          
//       },
//       'print',
//       'csv'
//   ]
});

}
// badrul
function showInputReviewDarah(str) {
    // console.log(str);
    // exit;
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/bInfoOrderDarah/reviewOrderDarah/' + str;
}
// badrul
function showInputPakaiDarah(str,IsUsed) {
    // console.log(str);
    // exit;
    if (IsUsed != null){
        toast("Order Ini Sudah Pernah Dalam Pemakaian! Silahkan Cek Di Tab List Pemakaian !", "warning");
        return false;
    }
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/bInfoOrderDarah/viewOrderDarah/' + str;
}

function showInputPakaiDarahbyID(str) {
    // console.log(str);
    // exit;
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/bInfoOrderDarah/viewOrderDarahbyID/' + str;
}

function showReturDarah(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/bInfoOrderDarah/viewReturDarah/' + str;
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

//15-04-2023
function getDataListUseDarah(sd,ed) { 
    // let PeriodeAwal ,PeriodeAkhir;
    // PeriodeAwal = $("#PeriodeAwal_use").val();
    // PeriodeAkhir = $("#PeriodeAkhir_use").val();
    var base_url = window.location.origin;
    $('#datatable_listuse').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_listuse').DataTable({
        "ordering": true, 
        "order": [[ 0, 'desc' ]], 
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/bInfoOrderDarah/getDataListUseDarah", 
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = sd;
               d.TglAkhir = ed;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.ID+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.IDOrder+'</font> ';
            return html 
        }
      },
           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.DateConsume+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoMR+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoRegistrasi+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.PatientName+'</font> ';
                return html 
            }
      },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.DOB+'</font> ';
            return html 
        }
        },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    var html  =  '<font size="2"> '+row.GolonganDarah+'</font> ';
                    return html 
                }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.QtyTotal+'</font> ';
                return html 
            }
        },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.Keterangan+'</font> ';
                return html 
            }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.UserConsumeName+'</font> ';
            return html 
        }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.UserUpdate+'</font> ';
            return html 
        }
        },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                    var html  =  '<button type="button" class="btn btn-danger btn-xs"  onclick="showInputPakaiDarahbyID(' + row.ID + ')" >View</button>';
                
                return html 
            }
          },
        ],
});

}

function showFormOrderLaboratorium(NoRegistrasi) {
    const base_url = window.location.origin;
    var str = btoa(NoRegistrasi);
    url = base_url + '/SIKBREC/public/aRegistrasiRajal/OrderLaboratorium/' + str;

    var win = window.open(url, '_blank');
    win.focus()

}