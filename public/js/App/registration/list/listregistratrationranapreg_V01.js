$(document).ready(function () {
    $(".preloader").fadeOut(); 
    getDataListPasienRawat();

    $('#btnUpdateSEP').click(function(){
        swal({
                title: "Simpan",
                text: "Apakah Anda ingin Update No SEP ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            //goUpdateSEP();
                            goCekNoSEP();
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });
    });
});
function getDataListPasienRawat_old() { 
    var base_url = window.location.origin;
    // $('#permintaanrawat_all').dataTable({
    //        "bDestroy": true
    //    }).fnDestroy();
    $('#permintaanrawat_all').DataTable().clear().destroy();
       $('#permintaanrawat_all').DataTable({
        "searching" : true,
        "pagging": true,
        "processing": true, 
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiRanap/getDataListPasienRawat", 
            "deferRender": true,
            "type": "POST" ,

        },
           
         
        "columns": [
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.NoMR+'</font> '
                    return html 
            }
        },
        {
            "render": function (data, type, row) {
                var html = ""
                var html = '<font size= "2"><span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.InpatientID+'","'+row.NoSEP_raw+'","'+row.NamaPerusahaan+'")\'> '+row.PatientName+ '</span></font>'
                return html
            }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.VisitDate+'</font> '
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
              if(row.Status == "Close"){ 
                  var html  = '<span class="badge badge-secondary">'+row.Status+'</span> '
              }else if(row.Status == "New"){ // Jika bukan 1
                  var html  = '<span class="badge badge-success">'+row.Status+'</span> '
              }else if(row.Status == "Payment"){ // Jika bukan 1
                  var html  = '<span class="badge badge-warning">'+row.Status+'</span> '
              }else if(row.Status == "Lunas"){ // Jika bukan 1
                  var html  = '<span class="badge badge-danger">'+row.Status+'</span> '
              }else{ // Jika bukan 1
                  var html  = '<span class="badge badge-info">'+row.Status+'</span> '
              }
                 return html 
          }
      },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.NamaDokter+'</font> '
                    return html 
            }
        }  ,   
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.JenisRawat+'</font> '
                    return html 
            }
        } ,  
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.NamaPerusahaan+'</font><br><font size="1">'+row.NoSEP+'</font> '
                    return html 
            }
        } ,
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
                  var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="PrintSPR(' + row.NoRegistrasi + ')" ><span class="visible-content" > Print</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Edit</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>&nbsp<button type="button" class="btn btn-warning border-warning btn-animated btn-xs"  onclick=\'showKamar("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Input Kamar</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button> &nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowHistoryDocuments("' +  row.NoRegistrasi + '")\' ><span class="visible-content" > E-Documents</span></button>'
                     return html 
              }
          },
             
        ],
         dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        buttons: [
            'copyHtml5',
             'excelHtml5',
            'print',
            'csv'
        ]
  } );

}    


function getDataListPasienRawat() { 
    var base_url = window.location.origin;
    $('#permintaanrawat_all').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#permintaanrawat_all').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aRegistrasiRanap/getDataListPasienRawat", // URL file untuk proses select datanya
               "type": "POST",
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoMR+'</font> '
                            return html 
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                        var html = '<font size= "2"><span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.InpatientID+'","'+row.NoSEP_raw+'","'+row.NamaPerusahaan+'")\'> '+row.PatientName+ '</span></font>'
                        return html
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.VisitDate+'</font> '
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
                      if(row.Status == "Close"){ 
                          var html  = '<span class="badge badge-secondary">'+row.Status+'</span> '
                      }else if(row.Status == "New"){ // Jika bukan 1
                          var html  = '<span class="badge badge-success">'+row.Status+'</span> '
                      }else if(row.Status == "Payment"){ // Jika bukan 1
                          var html  = '<span class="badge badge-warning">'+row.Status+'</span> '
                      }else if(row.Status == "Lunas"){ // Jika bukan 1
                          var html  = '<span class="badge badge-danger">'+row.Status+'</span> '
                      }else{ // Jika bukan 1
                          var html  = '<span class="badge badge-info">'+row.Status+'</span> '
                      }
                         return html 
                  }
              },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaDokter+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.JenisRawat+'</font> '
                            return html 
                    }
                } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPerusahaan+'</font><br><font size="1">'+row.NoSEP+'</font> '
                            return html 
                    }
                } ,
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="PrintSPR(' + row.NoRegistrasi + ')" ><span class="visible-content" > Print</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'showID("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Edit</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>&nbsp<button type="button" class="btn btn-warning border-warning btn-animated btn-xs"  onclick=\'showKamar("' + row.NoRegistrasi + '")\' ><span class="visible-content" > Input Kamar</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button> &nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowHistoryDocuments("' +  row.NoRegistrasi + '")\' ><span class="visible-content" > E-Documents</span></button>'
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
    window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
}

function showKamar(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiKamar/list/' + str;
}

function ShowHistoryDocuments(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/SignatureDigital/ListEdocuments/' + str;
}

function updateDataSEP2(ID, sep, NamaJaminan){
    if(NamaJaminan == "BPJS Kesehatan"){
        $('#modal_edit_sep').modal('show');
        $('#NOID_Reg').val(ID);
        $('#NoSEPLama').val(sep);
        
    }else{
       swal({
          title: "Warning",
          text: "Edit SEP Hanya Untuk Pasien BPJS Kesehatan !",
          icon: "warning", 
          dangerMode: true,
        });
    }
        
  }

  async function goUpdateSEP() {
    try {
        const dataUpdateNoSEP = await UpdateNoSEP();
        updateUIdataUpdateNoSEP(dataUpdateNoSEP);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdataUpdateNoSEP(params) {
    let response = params;
   // toast(response.message, "success")
        if (response.status == 'success'){
            swal({
                title: "Save Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
                location.reload();
            });
        }else if (response.status = 'warning'){
            swal({
                title: 'Warning',
                text: response.message,
                icon: "warning",
            })
        }
    //var noregistrasi = response.NoRegistrasi; ;
}
function UpdateNoSEP() {
    //$(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var JenisPasien = 'RANAP';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/UpdateNoSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&JenisPasien=" + JenisPasien
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
            //$(".preloader").fadeOut();
        })
}

//CEK NO SEP---------------
async function goCekNoSEP() {
    try {
        const data = await CekNoSEP();
        updateUIdatagoCekNoSEP(data);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdatagoCekNoSEP(params) {
    let response = params;
        if (response.status == 'success'){
                goUpdateSEP();
        }else if (response.status = 'warning'){
                swal({
                    title: "Simpan",
                    text: response.message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                                goUpdateSEP();
                        } else {
                        // swal("Transaction Rollback !");
                        }
                    });
            
        }
    //var noregistrasi = response.NoRegistrasi; ;
}

function CekNoSEP() {
    //$(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var JenisPasien = 'RANAP';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/CekNoSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&JenisPasien=" + JenisPasien
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
            } 
            return response
        })
        .finally(() => {
            //$(".preloader").fadeOut();
        })
}
//#END CEK NO SEP------------


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