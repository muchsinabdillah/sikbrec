var getUrl = window.location;
var baseUrl2 = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

$(document).ready(function () { 
    GoRujukanMultiByKartu();
    $(".preloader").fadeOut();
    $('#formUploadManual').submit(
        function (e) {
            var base_url = window.location.origin;
            var form_data = new FormData(); 
            form_data.append("file", $('input[type=file]')[0].files[0]); 
            form_data.append("doc_jenisdocument", $("#doc_jenisdocument").val());
            form_data.append("doc_keterangan", $("#doc_keterangan").val());
            form_data.append("doc_nomr", $("#doc_nomr").val()); 
            $.ajax({
                url: baseUrl2 + '/public/aMedicalRecord/uploaddocument/',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $(".preloader").fadeIn();
                },
                success: function (data) {
                    $(".preloader").fadeOut();
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.reload();
                            } else {
                                swal("Transaction Rollback !");
                            }
                        });
                }, error: function (data) {
                    // Welcome notification
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
                    toastr["error"](data.responseText);
                    $(".preloader").fadeOut();
                }
            });
            e.preventDefault();

        }
    );
});


function GoRujukanMultiByKartu() {
    var doc_nomr = document.getElementById("doc_nomr").value;
    var base_url = window.location.origin;
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],s
        "ajax": {
            "url": baseUrl2 + '/public/aMedicalRecord/listuploaddocument',
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.doc_nomr = doc_nomr;
            }
        },
        "columns": [
            { "data": "JENIS_DOCUMENT" },
            { "data": "KETERANGAN" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.EXTENSION == "pdf") {
                        var html = ""
                        var html = '<span class="badge bg-danger">PDF File</span>';
                        return html
                    }else{
                        var html = ""
                        var html = '<img class="img-thumbnail" src="' + row.URL + '" data-title="' + row.CAPTION + '" width="300" height="200">';
                        return html
                    }
                    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    if (row.EXTENSION == "pdf"){
                        var html = ""
                        var html = '<span class="badge bg-danger">' + row.EXTENSION +  '</span>';
                        return html
                    }else{
                        var html = ""
                        var html = '<span class="badge bg-primary">' + row.EXTENSION + '</span>';
                        return html
                    }
                    
                }
            },
              
            { "data": "date_update" },
            { "data": "USERID" }, 

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowrujukanDataMulti("' + row.URL + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },


        ]
    });

}
function ShowrujukanDataMulti(params) {
    window.open(params, "_blank");
}