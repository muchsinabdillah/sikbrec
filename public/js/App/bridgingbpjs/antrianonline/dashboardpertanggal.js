$(document).ready(function () {  
    $(".preloader").fadeOut();
});
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val(); 

    if (MTglKunjunganBPJS == null || MTglKunjunganBPJS == ''){
        toast ('Isi Tanggal', "warning");
        $(".preloader").fadeOut();
        return false;
    }

    

    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/DashboardAntrianBPJS/get_antreanPertanggal",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS; 
            }
        },
        "columns": [

            { "data": "kodebooking" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "tanggal" },
            { "data": "kodepoli" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "kodedokter" },
            { "data": "jampraktek" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "nik" },
            
            { "data": "nokapst" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "nohp" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "norekammedis" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "jeniskunjungan"  ,  render: $.fn.dataTable.render.number( '', '', 0 )}, 
            { "data": "nomorreferensi" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "sumberdata" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "noantrean" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "status" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },  

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