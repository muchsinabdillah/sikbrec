var tandatangan = document.getElementById('tandatangan')
var table = document.getElementById('tbl_kunjungan_monitoring')
var rIndex ;
var namapasien = document.getElementById('NAMA_PARAM_1')
var medicalrecord=document.getElementById('NO_MR')
var noregistrasi=document.getElementById('NO_REGISTRASI')
var noepisode=document.getElementById('NO_EPISODE')
var datatable;
// var datatable = $('#tbl_kunjungan_monitoring').DataTable();
selectedtable()
$(document).ready(function() {
    $(".signature-area").signaturePad({
        penColour: '#000000',
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90,
        lineWidth: 0,
        validateFields: true,

    })
    if (signature != '') {

    }

    $(".btn-clear").click(function(e) {
        $(".signature-area").signaturePad().clearCanvas();
    });
});
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MJenisPelayananBPJS =  document.getElementById("MJenisPelayananBPJS").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    datatable = $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/getSepSIMRSAllbyDate",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MJenisPelayananBPJS = MJenisPelayananBPJS;
            }
        },
        "columns": [
            { "data": "noSep" },
            { "data": "noKartu" },
            { "data": "noRujukan" },
            { "data": "tglSep" },
            { "data": "nama" },
            { "data": "jnsPelayanan" },
            { "data": "diagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" },
            { "data": "noreg" }, 
           
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<button id="tandatangan" class="btn btn-primary">Input Tanda Tangan</button>`
                    return html
                }
            },
            

        ]
    });
    
} 
function selectedtable() {
    for(var i = 1;i<table.rows.length;i++){
        table.rows[i].onclick =function () {
            namapasien.value = this.cells[4].innerHTML
            noregistrasi.value = this.cells[3].innerHTML
            noepisode.value = this.cells[3].innerHTML
            medicalrecord.value = this.cells[3].innerHTML
            console.log(this.cells[4].innerHTML)
    // $('#formtandatangan').modal('show');

        }
     }
}
// tandatangan.addEventListener('click',function (e) {
//     e.preventDefault()
//     $('#formtandatangan').modal('show');
//     console.log('di click')
    
// })

    // $('#tbl_kunjungan_monitoring tbody').on('click', '[id*=tandatangan]', function () {
    //     var data = datatable.row( this ).data();
    //     var customerID = data[0];
    //     var name = data[1];
    //     var title = data[2];
    //     var city = data[3];
    //     alert("Customer ID : " + customerID + "\n" + "Name : " + name + "\n" + "Title : " + title + "\n" + "City : " + city);
    // });

   