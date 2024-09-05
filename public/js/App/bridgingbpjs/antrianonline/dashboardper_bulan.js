$(document).ready(function () {  
    $(".preloader").fadeOut();
});
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var waktu =  document.getElementById("waktu").value;

    if (MTglKunjunganBPJS == null || MTglKunjunganBPJS == ''){
        toast ('Isi Tanggal', "warning");
        $(".preloader").fadeOut();
        return false;
    }

    if (waktu == null || waktu == ''){
        toast ('Isi Waktu', "warning");
        $(".preloader").fadeOut();
        return false;
    }

    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/DashboardAntrianBPJS/Dashboardper_Bulan",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.waktu = waktu;
            }
        },
        "columns": [

            { "data": "kdppk" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "nmppk" },
            { "data": "kodepoli" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "namapoli" },
            { "data": "jumlah_antrean" ,  render: $.fn.dataTable.render.number( '', '', 0 )},
            { "data": "tanggal" },
            
            { "data": "waktu_task1" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task1" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "waktu_task2" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task2"  ,  render: $.fn.dataTable.render.number( '', '', 0 )}, 
            { "data": "waktu_task3" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task3" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "waktu_task4" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task4" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "waktu_task5" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task5" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 
            { "data": "waktu_task6" ,  render: $.fn.dataTable.render.number( '', '', 0 ) },
            { "data": "avg_waktu_task6" ,  render: $.fn.dataTable.render.number( '', '', 0 ) }, 

        ],
        dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
    });
    
} 
function GoMonitoringBPJSbelumdilayani() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var waktu =  document.getElementById("waktu").value;

    if (MTglKunjunganBPJS == null || MTglKunjunganBPJS == ''){
        toast ('Isi Tanggal', "warning");
        $(".preloader").fadeOut();
        return false;
    }

    if (waktu == null || waktu == ''){
        toast ('Isi Waktu', "warning");
        $(".preloader").fadeOut();
        return false;
    }

    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring_belum').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring_belum').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/DashboardAntrianBPJS/Dashboardper_Bulan_belumdilayani",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.waktu = waktu;
            }
        },
        "columns": [

           
            { "data": "kodebooking" },
            { "data": "tanggal" },
            { "data": "kodepoli" },
            { "data": "kodedokter" },
            { "data": "jampraktek" },
            { "data": "nik" },
            { "data": "nokapst" },
            { "data": "nohp" },
            { "data": "norekammedis" },
            { "data": "jeniskunjungan" },
            { "data": "nomorreferensi" },
            { "data": "sumberdata" },
            { "data": "noantrean" },
            { "data": "status" }, 

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