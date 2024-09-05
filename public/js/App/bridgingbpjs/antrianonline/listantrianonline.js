$(document).ready(function () {
    $(".preloader").fadeOut();
});
  
function GoMonitoringBPJS() {
    var MNoTrs = document.getElementById("MNoTrs").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]]s,
        "ajax": {
            "url": base_url + "/SIKBREC/public/ListWaktuTask/GoListWaktuTask",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MNoTrs = MNoTrs;
            }
        },
        "columns": [
            { "data": "wakturs" },
            { "data": "waktu" },
            { "data": "taskname" },
            { "data": "taskid" },
            { "data": "kodebooking" },
        ]
    });

}  