$(document).ready(function () {
    $(".preloader").fadeOut();

    $('#datatable').dataTable({});

    $(document).on('click', '#btnLoadInformation', function () {
        //checking before get data
        getDataListPasien();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var Periode = document.getElementById("Periode").value;
       
        window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist4/" + Periode ;
}

function CheckVar() {
    //if not in creteria return false
    if ($("#Periode").val() == '') {
        toast('Periode Kosong!', "warning");
        return false;
    }

    swal({
        title: "Memuat Data",
        text: "Proses ini memerlukan generate data terlebih dahulu untuk memuat data beberapa saat. Apakah anda yakin ingin melanjutkannya ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $(".preloader").fadeIn();
                getDataListPasien();
                $(".preloader").fadeOut();
                } else {
                return false;
                }
        });

}


function getDataListPasien() {
    var Periode = '';
    var base_url = window.location.origin;

    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    //$('#datatable').DataTable().clear().destroy();
        $('#datatable').DataTable({
            "ordering": false, // Set true agar bisa di sorting
           //"order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": true,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInfoHargaJual/getDataList", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    //$("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "ID" },
                { "data": "Nama" },
                { "data": "Harga" }, 
            ],
            
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
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