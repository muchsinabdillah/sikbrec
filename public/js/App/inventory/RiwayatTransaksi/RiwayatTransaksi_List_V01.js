$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#permintaanrawat_all').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        $('#permintaanrawat_all').dataTable({
            "bDestroy": true
        }).fnDestroy();
        getListDataOrder();
    });
});

 

function getListDataOrder() { 
    
    let PeriodeAwal ,PeriodeAkhir,StatusOrder,JenisPasien,JenisResep;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();

    //CHECK
    // if (PeriodeAwal == ''){
    //     toast("Mohon Isi Periode Awal !", 'warning');
    //     $("#PeriodeAwal").focus();
    //     return false
    // }
    // if (PeriodeAkhir == ''){
    //     toast("Mohon Isi Periode Akhir !", 'warning')
    //     $("#PeriodeAkhir").focus();
    //     return false
    // }
    StatusOrder = $("#StatusOrder").val();
    JenisPasien = $("#JenisPasien").val();
    JenisResep = $("#JenisResep").val();
    var base_url = window.location.origin;
   
       $('#permintaanrawat_all').DataTable({
           "ordering":false,
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/Farmasi/getListDataOrder", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               d.StatusOrder = StatusOrder;
               d.JenisPasien = JenisPasien;
               d.JenisResep = JenisResep;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "OrderID"  }, //
               { "data": "OrderID" ,  render: $.fn.dataTable.render.number( '', '', 0,'' ) }, // Tampilkan telepon
               { "data": "NoMR" }, // Tampilkan alamat
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                      var html  = '<font color="red">'+row.PatientName+'</font> '
                     return html 
              }
          },
               { "data": "NoRegistrasi" },  // Tampilkan nama 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                  if(row.LokasiPasien == "RAWAT JALAN"){ 
                      var html  = '<span class="badge badge-info">'+row.LokasiPasien+'</span> '
                  }else if(row.LokasiPasien == "RAWAT INAP"){ // Jika bukan 1
                      var html  = '<span class="badge badge-warning">'+row.LokasiPasien+'</span> '
                  }else if(row.LokasiPasien == "OBATBEBAS"){ // Jika bukan 1
                      var html  = '<span class="badge badge-danger">'+row.LokasiPasien+'</span> '
                  }else{ // Jika bukan 1
                   var html  = '<span>'+row.LokasiPasien+'</span> '
               }
                     return html 
              }
          },
          { "data": "AsalPasien" },  // Tampilkan nama
               { "data": "Dokter" },  // Tampilkan nama
               { "data": "tgl" },  // Tampilkan nama
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                       if(row.Status == "0"){ 
                           var html  = '<font color="green"><b>New</b></font> '
                       }else if(row.Status == "1"){ // Jika bukan 1
                           var html  = '<font color="#FFBF00"><b>Review</b></font> '
                       }else if(row.Status == "2"){ // Jika bukan 1
                           var html  = '<font color="red"><b>Lunas</b></font> '
                       }else if(row.Status == "3"){ // Jika bukan 1
                           var html  = '<font color="indigo"><b>Printed</b></font> '
                       }else if(row.Status == "4"){ // Jika bukan 1
                           var html  = '<font color="default"><b>Closed</b></font>  '
                       }else{ // Jika bukan 1
                        var html  = '<span>Unknown</span> '
                    }
                          return html 
                   }
               },
               { "data": "JenisResep" },  // Tampilkan nama
               //{ "data": "penjamin" },  // Tampilkan nama 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                      var html  = row.penjamin + '<br> Note: '+row.Catatan +'<br> COB: '+row.NamaCOB
                     return html 
                    }
                },
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<a class="btn btn-danger btn-xs" onclick=\'showID("' + row.OrderID + '")\'  value='+row.OrderID+'> View</a>'
                       
                          return html 
                   }
               },
           ],
           dom: 'lBfrtip',
           buttons: [
               'copyHtml5',
               'excelHtml5'
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

function showID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
    window.open(base_url + '/SIKBREC/public/Farmasi/' + str , "_blank");
}

function BtnApprove(thisid){
    var table = $('#permintaanrawat_all').DataTable();
    var form = $("#form_approve");
    //var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapprove\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapprove[]')
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
        title: "Simpan",
        text: "Apakah Anda ingin Simpan Yang Dipilih ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    ApproveCheckbox();
            } 
        });
}

async function ApproveCheckbox() {
    try {
        const dataApproveAll = await ApproveAll();
        updateUIdataApproveAll(dataApproveAll);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAll(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getListDataOrder();
    }else{
        toast(response.message, "error")
    }  

}

function ApproveAll() {
    $(".preloader").fadeIn();
    var form = $("#form_approve").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Farmasi/goSelesaiAll';
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

/*
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}
*/