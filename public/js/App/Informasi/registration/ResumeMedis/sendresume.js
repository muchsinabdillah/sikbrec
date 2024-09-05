$(document).ready(function () {
    //$(".preloader").fadeOut();
    GenerateHasil($("#kodeResumeMEdis").val());  
});

async function GenerateHasil(id) {
    try{
        const data = await goGenerateHasil(id);
        updateUIgoGenerateHasil(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgoGenerateHasil(data) {
    let responseApi = data;
    if (responseApi['status'] == 200){
        swal({
            title: "success",
            text: responseApi['message'],
            icon: "success",
        });
        $("#param_id").val(responseApi.data); 
        $("#aws_url").val(responseApi.aws_url); 
        //$("#param_noreg").val(noreg); 
        //$('#modalSend').modal('show');
    }else{
        swal({
            title: "warning",
            text: responseApi['message'],
            icon: "warning",
        }) 
    }
}
function goGenerateHasil(id) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationResumeMedis/SaveMedical';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + id 
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

function ceklis_noemail(){
    if ($("#ceklis_noemailx").is(":checked") == true){
        $("#email_send").val("edocrsy@gmail.com");
    }
    // else{
    //     $("#email_send").val($("#email_send_backup").val());
    // }
}

async function goSendMailx (){
    var aws_url = $("#aws_url").val()
    var email_send = $("#email_send").val();
    var param = $("#param_id").val();
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/bInformationResumeMedis/SendMail";
              $.ajax({
                  url: url,
                  type: "POST",
                  data: "notrs="+param+"&email_send="+email_send+"&aws_url="+aws_url,
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

                      //toast(data.message, data.status);

                      swal({
                        title: title,
                        text: data.message,
                        icon: data.status,
                    }).then(function() {
                        //location.reload();

                    });

                    //INSERT TZ LOG EMAIL
                    //goInsertLog(nolab,statuskirim,email);
                $(".preloader").fadeOut();

                  },
                  error: function (xhr, status) {
                    $(".preloader").fadeOut();
                    toast(xhr, status);
                      // handle errors
                      console.log(xhr,status);
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