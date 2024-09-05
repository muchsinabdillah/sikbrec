$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#permintaanrawat_all').DataTable({});
    getDataListRS();

 });

 

function getDataListRS() { 
    var base_url = window.location.origin;
    $('#List_dataRS').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#List_dataRS').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/dataRumahSakit/getDataListRS", // URL file untuk proses select datanya
               "type": "POST",
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.ID+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.NamaRS+'</font> '
                        return html 
                }
            },
                
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.AlamatRS+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.Phone+'</font> '
                            return html 
                    }
                },
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'showID("' + row.ID + '")\' ><span class="visible-content" > Edit</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>'
                          return html 
                   }
               },
           ],
       });
} 



function showID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/dataRumahSakit/' + str;
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