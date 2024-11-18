$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#permintaanrawat_all').DataTable({});
    //getListBillingRajal();
    $('#listbillingbebas').DataTable( {
    } );

    $('#listbillingbebas_arsip').DataTable( {
    } );

    $('#btn_periode').click(function () {
        var tglawal = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        getListBillingBebas(tglawal,tglakhir);
    });

    $('#btn_periode_arsip').click(function () {
        var tglawal = $("#tglawal_arsip").val();
        var tglakhir = $("#tglakhir_arsip").val();
        console.log(tglawal,tglakhir);

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        getListBillingBebas_Arsip(tglawal,tglakhir);
    });

    $('#btn_today').click(function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var datenow = yyyy +"-"+ mm +"-"+ dd;
        var tglawal = datenow;
        var tglakhir = datenow;
        getListBillingBebas(tglawal,tglakhir);
    });

});
 

function getListBillingBebas(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingbebas').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingbebas').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 3, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListBillingBebas", // URL file untuk proses select datanya
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
                        
                        var html  = '<font size="2">'+row.No+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TransactionCode+'</font> '
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
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""

                    if (row.NamaStatus == 'NEW'){
                        var badgecol = "success";
                    }else if (row.NamaStatus == 'APPROVED'){
                        var badgecol = 'warning';
                    }else if (row.NamaStatus == 'PAYMENT'){
                        var badgecol = 'danger';
                    }
                    
                    var html  = '<span class="badge badge-'+badgecol+'">'+row.NamaStatus+'</span>'
                        return html 
                }
            } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      //--13-09-2024 editan fiqri
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick=\'showID("' + row.TransactionCode + '")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-eye"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'PrintbyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Cetak</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>'
                          return html 
                   }
               },
           ],
       });
} 

function getListBillingBebas_Arsip(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingbebas_arsip').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingbebas_arsip').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 3, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListBillingBebas_Arsip", // URL file untuk proses select datanya
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
                        
                        var html  = '<font size="2">'+row.No+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TransactionCode+'</font> '
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
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""

                    if (row.NamaStatus == 'NEW'){
                        var badgecol = "success";
                    }else if (row.NamaStatus == 'APPROVED'){
                        var badgecol = 'warning';
                    }else if (row.NamaStatus == 'PAYMENT'){
                        var badgecol = 'danger';
                    }
                    
                    var html  = '<span class="badge badge-'+badgecol+'">'+row.NamaStatus+'</span>'
                        return html 
                }
            } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      //--13-09-2024 editan fiqri
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick=\'showID("' + row.TransactionCode + '")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-eye"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'PrintbyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Cetak</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>'
                          return html 
                   }
               },
           ],
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}


function showID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    // var judul = 'Billing Rawat Jalan';
    //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
    //window.open(base_url + '/SIKBREC/public/aBillingPasien/' + str , "_blank");
    //---13-09-2024 editan fiqri
    window.open(base_url + '/SIKBREC/public/aBillingPasien/viewbebas/' + str , "_blank");
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