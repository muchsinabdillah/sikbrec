$(document).ready(function () {
    $(".preloader").fadeOut(); 
     $('#example').DataTable({});
     $('#riwayat_klaim_table').DataTable({});
     $('#import_klaim_table').DataTable({});
     
    $(document).on('click', '#btnLoadInformation', function () {
        getDataList_ImportKlaim();
    });

    $('#btnSearchMrAktif').click(function () {
        getDataList();
        getDataList_RiwayatEklaim();
    });

    $("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
        if (e.keyCode == 13) { // Jika user menekan tombol ENTER
            getDataList();
            getDataList_RiwayatEklaim();
        }
  });
  
    // $(".preloader").fadeOut(); 
    // onloadForm();
});

// function TrigerSEP() {
//     var SEP = document.getElementById("NOSEP_CEK").value;
//     var nowSEP = SEP;
//     // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
//     // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
//     console.log(nowSEP)
//     // $('#btnLoadInformation').attr('disabled', False);
//     if (nowSEP == '') 
//     {
//         alert("SEP Mohon Diisi !2");
//         $('#btnLoadInformation').attr('disabled', false);
//     } else {
//         alert("SEP Mohon Diisi !");
//         $("#NOSEP_CEK").val('');
//         $('#btnLoadInformation').attr('disabled', true);
//     }
// }



function getDataList() { 

   // var keyword = $("#NOSEP_CEK").val();
   var txSearchData = $("#txSearchData").val();
   var cmbxcrimr = $("#cmbxcrimr").val();
    var base_url = window.location.origin;
    $('#example').dataTable({
           "bDestroy": true
       }).fnDestroy();
       
       $('#example').DataTable({
           "ordering": false, // Set true agar bisa di sorting
           //"order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bEKlaim/getListDataReg", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.txSearchData = txSearchData;
                d.cmbxcrimr = cmbxcrimr;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NO_SEP + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_PESERTA + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.DateOfBirth + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NO_MR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglKunjungan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NO_REGISTRASI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.JenisPasien + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.IS_BRIDGING == 'YA'){
                        var stlye = 'success';
                    }else{
                        var stlye = 'danger';
                    }
                    var html = '<span class="badge badge-'+stlye+'">'+row.IS_BRIDGING+'</span>';
                    return html
                }
            },
            // {
            //     "render": function (data, type, row) { // Tampilkan kolom aksi
            //         var html = ""
            //         var html = '<font size="1"> ' + row.IS_BRIDGING + ' </font>  ';
            //         return html
            //     }
            // },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                        var html = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick=ViewNewEklaim("' + row.NO_REGISTRASI + '") ><span class="visible-content" >NEW KLAIM</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>';
                    
                    return html
                },
            },
        ]

    });

    // table.buttons().container()
    // .appendTo( '#example_wrapper .col-sm-6:eq(0)' );

    $(".preloader").fadeOut();

} 

function getDataList_RiwayatEklaim() { 

    // var keyword = $("#NOSEP_CEK").val();
    var txSearchData = $("#txSearchData").val();
    var cmbxcrimr = $("#cmbxcrimr").val();
     var base_url = window.location.origin;
     $('#riwayat_klaim_table').dataTable({
            "bDestroy": true
        }).fnDestroy();
        
        $('#riwayat_klaim_table').DataTable({
            "ordering": false, // Set true agar bisa di sorting
            //"order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bEKlaim/getListDataEklaim", // URL file untuk proses select datanya
                "type": "POST",
                data: function ( d ) {
                 d.txSearchData = txSearchData;
                 d.cmbxcrimr = cmbxcrimr;
                },
                 "dataSrc": "",
            "deferRender": true,
            }, 
            "columns": [
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.NAMA_PASIEN + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.TGL_LAHIR + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.NO_MR + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.TGL_MASUK + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.TGL_PULANG + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.PAYOR_CD + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.NO_SEP + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.NAMA_JENIS_RAWAT + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.GROUP_CODE + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.STATUS + '</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="2"> ' + row.PETUGAS + '</font>  ';
                        return html
                    }
                },
             
             {
                 "render": function (data, type, row) {
                     var html = ""
                         var html = '<button type="button" class="btn btn-success border-primary btn-animated btn-xs"  onclick=ViewEklaim("' + row.ID + '") ><span class="visible-content" >EDIT KLAIM</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>';
                     
                     return html
                 },
             },
         ]
 
     });
 
     // table.buttons().container()
     // .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
 
     $(".preloader").fadeOut();
 
 } 

function ViewEklaim(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/bEKlaim/EklaimById/" + str;
    var win = window.open(url, '_blank');
    win.focus()
}

function ViewNewEklaim(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/bEKlaim/EklaimByNoReg/" + str;
    var win = window.open(url, '_blank');
    win.focus()
}

function gocreatesensusranap() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPPI/createSensusRanap";
}
function gocreatesensusrajal() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aPPI/createSensusRajal";
}
function showDataGroupShift(str,typeR) {
    const base_url = window.location.origin;
    var str = btoa(str);
    //typeR = ' + row.Tipe_Rawat + '
    if(typeR=='Rawat Inap'){
        window.location = base_url + '/SIKBREC/public/aPPI/createSensusRanap/' + str;
    }
    if(typeR=='Rawat Jalan'){
        window.location = base_url + '/SIKBREC/public/aPPI/createSensusRajal/' + str;
    }
    //window.location = base_url + '/SIKBREC/public/aPPI/createSensusRanap/' + str;
}


function getDataList_ImportKlaim() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var JenisPasien = $("#JenisPasien").val();
    var PeriodeAwal = $("#PeriodeAwal").val();
    var PeriodeAkhir = $("#PeriodeAkhir").val();
    $('#import_klaim_table').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#import_klaim_table').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/bEKlaim/getListDataBPJS_SEP", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.JenisPasien = JenisPasien
         d.PeriodeAwal = PeriodeAwal
         d.PeriodeAkhir = PeriodeAkhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [

                            { "data": "ID" },
                            { "data": "NO_SEP" },
                            { "data": "NO_KARTU" },
                            { "data": "NAMA_PESERTA" },
                            { "data": "NO_MR" },
                            { "data": "DOB" },
                            { "data": "NO_REGISTRASI" },
                            { "data": "NAMA_POLI" },
                            { "data": "NAMA_DOKTER" },
                            { "data": "KELAS_RAWAT" },
                            { "data": "TGL_SEP" },
                           ],
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


