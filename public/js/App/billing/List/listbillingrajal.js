$(document).ready(function () {
    $(".preloader").fadeOut(); 

  
    var modalShown = localStorage.getItem('modalShown');
    if (!modalShown) {
        $('#notif_Cetak').modal('show'); 
    }
    $('#notif_Cetak').modal('show'); 
    setInterval(function() {
        showNotification(); 
       
    }, 10000);


    //$('#permintaanrawat_all').DataTable({});
    //getListBillingRajal();
    $('#listbillingrajal').DataTable( {
    } );

    $('#listbillingrajal_arsip').DataTable( {
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
        getListBillingRajal(tglawal,tglakhir);
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
        getListBillingRajal_Arsip(tglawal,tglakhir);
    });

    $('#btn_today').click(function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var datenow = yyyy +"-"+ mm +"-"+ dd;
        var tglawal = datenow;
        var tglakhir = datenow;
        getListBillingRajal(tglawal,tglakhir);
    });

});
 
// 11122024
function showNotification() { 
    $.ajax({ 
        url: '/SIKBREC/public/aaNotification/getNotifKasirfromFarmasi', // URL PHP yang mengirimkan data notifikasi
        type: 'GET',
        dataType: 'json',
        success: function(data) { 
            if(data[0].rowData){

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();
        
                var datenow = yyyy +"-"+ mm +"-"+ dd;
                var tglawal = datenow;
                var tglakhir = datenow;
                getListBillingRajal(tglawal,tglakhir); 
                
                $('#notification-container').html(`
                    <div style="background-color: #f0f0f0; border: 1px solid #ccc; padding: 10px; margin-top: 20px;">
                        <strong>${data[0].title}</strong>
                        <p>${data[0].message}</p>
                    </div>
                `);
     
                var audio = document.getElementById('notification-sound');
                audio.play();
            }else{
                $('#notification-container').html('');
            }
            
        },
        error: function() {
            alert('Terjadi kesalahan dalam mengambil data notifikasi.');
        }
    });
}

function play() {
    var audio = document.getElementById("notification-sound");
    audio.play();
    $('#notif_Cetak').modal('hide');
}
function getListBillingRajal(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingrajal').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingrajal').DataTable({
           "processing":true,
           "ordering": false, // Set true agar bisa di sorting
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
                        
                        var html  = '<font size="2">'+row.No+'</font> '
                            return html 
                    }
                }, 
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
                // { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                //     var html = ""

                //     if (row.NamaStatus == 'New'){
                //         var badgecol = "success";
                //     }else if (row.NamaStatus == 'Invoice'){
                //         var badgecol = 'info';
                //     }else if (row.NamaStatus == 'Payment'){
                //         var badgecol = 'warning';
                //     }else if (row.NamaStatus == 'Lunas'){
                //         var badgecol = 'danger';
                //     }
                    
                //     var html  = '<span class="badge badge-'+badgecol+'">'+row.NamaStatus+'</span>'
                //         return html 
                // }
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = "" 
                        if (row.SelesaiPerawat == '1'){
                                var badgecol = "success";
                                var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-check"></i></span>'
                        
                        }else  {
                                var badgecol = 'danger';
                                var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-close"></i></span>'
                        
                        }
                         return html 
                    }, 
                } ,
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = "" 
                        if (row.SelesaiPoli == '1'){
                            var badgecol = "success";
                            var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-check"></i></span>'
                        
                        }else  {
                                var badgecol = 'danger';
                                var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-close"></i></span>'
                        
                        }
                         return html 
                    }, 
                } ,
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = "" 
                        if (row.SelesaiOptik == '1'){
                            var badgecol = "success";
                            var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-check"></i></span>'
                        
                        }else  {
                                var badgecol = 'danger';
                                var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-close"></i></span>'
                        
                        }
                       return html 
                    }, 
                } ,
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = "" 
                        if (row.SelesaiFarmasi == '1'){
                            var badgecol = "success";
                            var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-check"></i></span>'
                        
                        }else  {
                                var badgecol = 'danger';
                                var html  = '<span class="badge badge-'+badgecol+'"><i class="fa fa-close"></i></span>'
                        
                        }
                         return html 
                    }, 
                } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-eye"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'PrintbyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Cetak</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'SurveyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Survey</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>'
                          return html 
                   }
               },
           ],
           dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-3"l><"col-sm-3"i><"col-sm-3"p>>',
           rowCallback: function (row, data) {
             //console.log(data['lamarawat']);
            if (data['SelesaiPerawat'] == "1") {
               $(row).addClass('HighlightPerawat'); 
            }
            if (data['SelesaiPoli'] == "1") {
                $(row).addClass('HighlightDokter');
            }
            if (data['SelesaiFarmasi'] == "1") {
                $(row).addClass('HighlightFarmasi');
            }
           },
       });
} 

function getListBillingRajal_Arsip(tglawal,tglakhir) { 
    var base_url = window.location.origin;
    $('#listbillingrajal_arsip').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#listbillingrajal_arsip').DataTable({
           "processing":true,
           "ordering": false, // Set true agar bisa di sorting
           "order": [[ 3, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataListBillingRajal_Arsip", // URL file untuk proses select datanya
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
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-eye"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'PrintbyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Cetak</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'SurveyID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Survey</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>'
                          return html 
                   }
               },
           ],
           dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-3"l><"col-sm-3"i><"col-sm-3"p>>',
           rowCallback: function (row, data) {
             //console.log(data['lamarawat']);
            if (data['SelesaiPerawat'] == "1") {
               $(row).addClass('HighlightPerawat'); 
            }
            if (data['SelesaiPoli'] == "1") {
                $(row).addClass('HighlightDokter');
            }
            if (data['SelesaiFarmasi'] == "1") {
                $(row).addClass('HighlightFarmasi');
            }
           },
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
    var judul = 'Billing Rawat Jalan';
    //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
    window.open(base_url + '/SIKBREC/public/aBillingPasien/' + str , "_blank");
}
function SurveyID(noregistrasi){
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/surveycustomer/" + noregistrasi;
}
function PrintbyID(noregistrasi){
    swal("Pilih Document yang Masuk di Print", {
        buttons: { 
            cancel: "Cancel",
            defeat: false,
            voucher: {
            text: "Surat Keterangan Sakit",
            value: "SuketSakit",
          },
            deposit: {
            text: "Surat Keterangan Sehat",
            value: "SuketSehat",
          },
          catch: {
            text: "Surat Keterangan Mata",
            value: "SuketMata",
          },
          closing: {
            text: "Resep Kacamata",
            value: "SuketResepKacamata",
          },
         
          
        },
      })
      .then((value) => {
        switch (value) {

        case "SuketSakit": 
            var base_url = window.location.origin;
            var jeniscetak = 'PrintSuratKeteranganSakit';
            var noreg = noregistrasi;
            window.open(base_url + "/SIKBREC/public/aEMR/"+jeniscetak+"/"+noreg, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            break;

        case "SuketSehat":
            var base_url = window.location.origin;
            var noreg = noregistrasi;
            window.open(base_url + "/SIKBREC/public/aEMR/PrintSuratKeteranganSehat/"+noreg, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            break;

        case "SuketMata":
            var base_url = window.location.origin;
            var jeniscetak = 'PrintSuratKeteranganMata';
            var noreg = noregistrasi;
            window.open(base_url + "/SIKBREC/public/aEMR/"+jeniscetak+"/"+noreg, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            break;
        case "SuketResepKacamata":
            var base_url = window.location.origin;
            var jeniscetak = 'PrintResepKacamata';
            var noreg = noregistrasi;
            window.open(base_url + "/SIKBREC/public/aEMR/"+jeniscetak+"/"+noreg, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            break;
       
          default:
           // swal("Got away safely!");
        }
      });
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