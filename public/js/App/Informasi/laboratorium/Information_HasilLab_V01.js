$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#table-load-data').DataTable({});
    $('#btnLoadInformation').attr('disabled', true);
    $(document).on('click', '#btnLoadInformation', function () {
        loadData();
    });
    $(document).on('click', '#btnAddNewOrder', function () {
        goNewOrder();
    });
    $(document).on('click', '#sendmail', function () {
        var nolab = $("#param_nolab").val();
        var email = $("#param_email").val();
        sendmail_hasillab(nolab,email);
    });
});
function TrigerTgl() {
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    var nowDateawal = new Date(PeriodeAwal);
    var nowDateakhir = new Date(PeriodeAkhir);
    var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    console.log(Difference_In_Days)
    if (Difference_In_Days > 30) {
        alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
        $("#PeriodeAwal").val('');
        $("#PeriodeAkhir").val('');
        $('#btnLoadInformation').attr('disabled', true);
    } else {
        $('#btnLoadInformation').attr('disabled', false);
    }
}
 

function loadData() { 
    let PeriodeAwal ,PeriodeAkhir;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#table-load-data').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#table-load-data').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "columnDefs": [
            { "width": "20%", "targets": 8 },
          ],
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationHasilLab/getDataList", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "NoMR" }, 
            { "data": "NamaPasien" },
            { "data": "birth_dt" },  
            { "data": "tglorder" },  
            { "data": "NoLab" },   
            { "data": "NoRegistrasi" },  
            { "data": "asuransi" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
               var html  = '<td>'+row.email+'<br>'+row.nohp+'</td>';
                  return html 

         }
       }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                    var html  = '<td><div style="display: block; border: 1px; height: 65px; overflow-y: scroll">'+row.NamaTes+'</div></td>';
                       return html 

              }
            },     
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                 var html = ""
                if(row.Result == "1"){ 
                    var html  = '<span class="badge badge-success">Sudah Ada</span> '
                }else{ 
                    var html  = '<span class="badge badge-danger">Belum Ada</span> '
                }
                return html

              }
            }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                  var html = ""
                   
                    // var html  = '<button title="Cetak Hasil" type="button" class="btn-xs btn-primary" id="btn_ctkhasil" onclick=\'print_hasillab("'+row.ID+'","'+row.DT_Validasi+'")\')"><i class="fa fa-print"></i> Cetak</button>&nbsp<button title="Cetak Hasil" type="button" class="btn-xs btn-warning" id="btn_sendmail" onclick=\'sendmail_hasillab("'+row.NoLab+'","'+row.email+'","'+row.DT_Validasi+'")\') )"><i class="fa fa-envelope" aria-hidden="true"></i> Kirim Email</button>&nbsp<button title="Kirim Hasil" type="button" class="btn-xs btn-success" id="btn_ctkhasil" onclick=\'sendwa_hasillab("'+row.ID+'","'+row.nohp+'","'+row.DT_Validasi+'")\')"><i class="fa fa-whatsapp" aria-hidden="true"></i> Kirim WA</button>'

                    var html  = '<button title="Cetak Hasil" type="button" class="btn-xs btn-primary" id="btn_ctkhasil" onclick=\'ConfirmGenerateHasil("'+row.NoLab+'","'+row.NoRegistrasi+'","'+row.email+'","'+row.DT_Validasi+'")\')"><i class="fa fa-print"></i> Generate Hasil</button'
                       return html 
                }
            },
               {
                   "render": function (data, type, row) { // Tampilkan kolom aksi
                       var html = ""

                       var html = '<button title="Kirim Hasil" type="button" class="btn-xs btn-success" id="btn_ctkhasil" onclick=\'sendwakritis_hasillab("' + row.ID + '","' + row.nohp + '","' + row.DT_Validasi + '")\')"><i class="fa fa-whatsapp" aria-hidden="true"></i> Kirim WA</button>'
                       return html
                   }
               },
           ],
       });
} 

function print_hasillab(x,valdt) {
    //Cek Sudah Divalidasi?
    if (valdt=='' || valdt=='null')
    {
        toast('Maaf, Data Belum Divalidasi!', "warning")
      return false;
    }

    var base_url = window.location.origin;
            var win = window.open(base_url + "/SIKBREC/public/bInformationHasilLab/PrintHasil/" + x ,  "_blank", 
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            win.focus();
}

// function sendmail_hasillab(nolab,email,valdt) {
//     //Cek Sudah Divalidasi?
//     if (valdt=='' || valdt=='null')
//     {
//         toast('Maaf, Data Belum Divalidasi!', "warning")
//       return false;
//     }

//     //Cek Format Email Sesuai?
//     if (!validateEmail(email)) {
//         toast('Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!', "warning")
//         return false;
//        }

//     var base_url = window.location.origin;
//             var win = base_url + "/SIKBREC/public/bInformationHasilLab/SendMailHasil/" + nolab;
//             //win.focus();
// }

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  function sendmail_hasillab(nolab,email){
    //     //Cek Sudah Divalidasi?
    // if (valdt=='' || valdt=='null')
    //     {
    //         toast('Maaf, Data Belum Divalidasi!', "warning")
    //       return false;
    //     }
    
        //Cek Format Email Sesuai?
        if (!validateEmail(email)) {
            toast('Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!', "warning")
            return false;
           }

           swal({
            title: "Kirim Email",
            text: "Apakah Anda Yakin Ingin Mengirim Hasil Melalui Email Ke "+email+" ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    var viakirim = 'EMAIL';
                    //goSendMail(nolab,email);
                    goCekPernahKirim(nolab,email,viakirim);
                } else {
                   // swal("Transaction Rollback !");
                }
            });

           
}

function goSendMail (nolab,email){
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var param_id = $("#param_id").val();
    const url = base_url + "/SIKBREC/public/bInformationHasilLab/SendMailHasil/" + nolab+"/"+param_id;
              $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                    $(".preloader").fadeOut();
                      if (data.status=='success'){
                        var title = 'Kirim Email Berhasil!';
                        var statuskirim = 'TERKIRIM';
                      }else{
                        var title = 'Kirim Email Gagal!';
                        var statuskirim = 'GAGAL';
                      }

                      toast(data.message, data.status);

                      swal({
                        title: title,
                        text: data.message,
                        icon: data.status,
                    }).then(function() {

                    });

                    //INSERT TZ LOG EMAIL
                    goInsertLog(nolab,statuskirim,email);

                  },
                  error: function (xhr, status) {
                    $(".preloader").fadeOut();
                    toast(xhr, status);
                      // handle errors
                      console.log(xhr,status);
                  }
              });

}


function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

function sendwa_hasillab(nolab,nohp,valdt){
    //     //Cek Sudah Divalidasi?
    if (valdt=='' || valdt=='null')
        {
            toast('Maaf, Data Belum Divalidasi!', "warning")
          return false;
        }

           swal({
            title: "Kirim Whatsapp",
            text: "Apakah Anda Yakin Ingin Mengirim Hasil Melalui Whatsapp Ke "+nohp+" ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    var viakirim = 'WHATSAPP';
                    goCekPernahKirim(nolab,nohp,viakirim);

                } else {
                   // swal("Transaction Rollback !");
                }
            });
}
function sendwakritis_hasillab(nolab, nohp, valdt) {
    //     //Cek Sudah Divalidasi?
    if (valdt == '' || valdt == 'null') {
        toast('Maaf, Data Belum Divalidasi!', "warning")
        return false;
    }

    swal({
        title: "Kirim Whatsapp",
        text: "Apakah Anda Yakin Ingin Mengirim Nilai Kritis Melalui Whatsapp ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var viakirim = 'WHATSAPP';
                goCekPernahKirimKritis(nolab, nohp, viakirim);
            } else {
                // swal("Transaction Rollback !");
            }
        });
}

function goSendWA (nolab,nohp){
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/bInformationHasilLab/SendWAHasil/" + nolab;
              $.ajax({
                  url: url,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                    $(".preloader").fadeOut();
                      if (data.status=='success'){
                        var title = 'Kirim Whatsapp Berhasil!';
                        var statuskirim = 'TERKIRIM';
                      }else{
                        var title = 'Kirim Whatsapp Gagal!';
                        var statuskirim = 'GAGAL';
                      }

                      toast(data.message, data.status);

                      swal({
                        title: title,
                        text: data.message,
                        icon: data.status,
                    }).then(function() {

                    });

                    //INSERT TZ LOG WA
                    goInsertLogWA(nolab,statuskirim,nohp);

                  },
                  error: function (xhr, status) {
                    $(".preloader").fadeOut();
                   // toast(xhr, status);
                      // handle errors
                      console.log(xhr,status);
                  }
              });

}
async function goSendWAKritis(nolab, nohp) {
    try {
        $(".preloader").fadeIn();
        const dataSendWhatsappKritis = await SendWhatsappKritis(nolab, nohp);
        console.log("dataSendWhatsappKritis",dataSendWhatsappKritis);
        updatedataSendWhatsappKritis(dataSendWhatsappKritis,nolab);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
} 
function updatedataSendWhatsappKritis(data,nolab){
    if (data.status == 'success') {
        var title = data.errorname;
        var statuskirim = 'TERKIRIM';
    } else {
        var title =data.errorname;
        var statuskirim = 'GAGAL';
    }

    toast(data.message, data.status);

    
     
}
function SendWhatsappKritis(nolab, nohp) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/SendWAHasilKritis/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nolab=" + nolab + "&nohp=" + nohp 
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



//Transaction
async function goInsertLog(nolab,status,email) {
    try {
        const dataInsertLog = await InsertLog(nolab,status,email);
        updateUIdataInsertLog(dataInsertLog);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataInsertLog(params) {
    let response = params;
    console.log('Success insert tz_log_sentemail');
    //$(".preloader").fadeOut();
}
function InsertLog(nolab,status,email) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/InsertLog';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nolab=" + nolab + "&status=" + status + "&email=" + email
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


async function goInsertLogWA(nolab,status,nohp) {
    try {
        const dataInsertLogWA = await InsertLogWA(nolab,status,nohp);
        updateUIdataInsertLogWA(dataInsertLogWA);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataInsertLogWA(params) {
    let response = params;
    console.log('Success insert tz_log_whatsappsent');
    //$(".preloader").fadeOut();
}
function InsertLogWA(nolab,status,nohp) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/InsertLogWA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nolab=" + nolab + "&status=" + status + "&nohp=" + nohp 
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

async function goCekPernahKirim(nolab,val,viakirim) {
    try {
        const dataCekPernahKirim = await CekPernahKirim(nolab,val,viakirim);
        updateUIdataCekPernahKirim(dataCekPernahKirim,nolab,val,viakirim);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCekPernahKirim(params,nolab,val,viakirim) {
    let response = params;
    if (response.status == 'warningx'){
        swal({
            title: "Peringatan",
            text: response.errorname,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    if (viakirim == 'EMAIL'){
                         goSendMail(nolab,val);
                    }else{
                       // goSendWAKritis(nolab,val);
                        goSendWA(nolab,val);
                    }
                } else {
                   //swal("Transaction Rollback !");
                }
            });
    }else{
        if (viakirim == 'EMAIL'){
            goSendMail(nolab,val);
        }else{
            goSendWA(nolab,val);
        }
    }

    //$(".preloader").fadeOut();
}

async function goCekPernahKirimKritis(nolab,val,viakirim) {
    try {
        const dataCekPernahKirimKritis = await CekPernahKirimKritis(nolab,val,viakirim);
        updateUIdataCekPernahKirimKritis(dataCekPernahKirimKritis,nolab,val,viakirim);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCekPernahKirimKritis(params,nolab,val,viakirim) {
    let response = params;
    if (response.status == 'warningx'){
        swal({
            title: "Peringatan",
            text: response.errorname,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) { 
                        goSendWAKritis(nolab,val); 
                } else {
                   //swal("Transaction Rollback !");
                }
            });
    }else{
        goSendWAKritis(nolab,val); 
    }

    //$(".preloader").fadeOut();
}
function CekPernahKirimKritis(nolab,val,viakirim) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/CekPernahKirim';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nolab=" + nolab + "&val=" + val + "&viakirim=" + viakirim
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
function CekPernahKirim(nolab,val,viakirim) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/CekPernahKirim';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nolab=" + nolab + "&val=" + val + "&viakirim=" + viakirim
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

function goNewOrder() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/bInformationHasilLab/ListRegOrderLab/";
}

function ConfirmGenerateHasil(nolab,noreg,email,valdt) {
    try{
        if (valdt=='' || valdt=='null')
        {
          toast('Maaf, Data Belum Divalidasi!', "warning")
          return false;
        }
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Generate ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(".preloader").fadeIn();
                    GenerateHasil(nolab,noreg,email)
                } else {
                   // swal("Transaction Rollback !");
                   return false;
                }
            });
       
    } catch (err) {
        toast(err, "error")
    }
}

async function GenerateHasil(nolab,noreg,email) {
    try{
        const data = await goGenerateHasil(nolab,noreg);
        updateUIgoGenerateHasil(data,noreg,email,nolab);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgoGenerateHasil(data,noreg,email,nolab) {
    let responseApi = data;
    if (responseApi['status'] == 200){
        swal({
            title: "success",
            text: responseApi['message'],
            icon: "success",
        });
        $("#param_id").val(responseApi.data); 
        $("#param_noreg").val(noreg); 
        $("#param_email").val(email);
        $("#param_nolab").val(nolab); 
        $('#modalSend').modal('show');
    }else{
        swal({
            title: "warning",
            text: responseApi['message'],
            icon: "warning",
        }) 
    }
}
function goGenerateHasil(nolab,noreg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationHasilLab/SaveHasilLaboratorium';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + nolab + "&NoRegistrasi=" + noreg
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
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}