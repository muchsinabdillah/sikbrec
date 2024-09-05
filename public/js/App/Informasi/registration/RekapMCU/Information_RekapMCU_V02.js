$(document).ready(function () {
    //asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        //checking before get data
        CheckVar();
    });
    $(document).on('click', '#excelLanscape', function () {
        excelLanscape();
    });
});
function excelLanscape() {
    var base_url = window.location.origin;
 
    var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    var TipePenjamin = document.getElementById("TipePenjamin").value; 
    var NamaPenjamin = document.getElementById("NamaPenjamin").value; 

        window.location = base_url + "/SIKBREC/public/ExcelInfoRekapMCU/ExcelInfoRekapMCU2/" + PeriodeAwal + "/" + PeriodeAkhir+ "/" + TipePenjamin+ "/" + NamaPenjamin;
   
}
function CheckVar (){
    //if not in creteria return false
    if ($("#PeriodeAwal").val() == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if ($("#PeriodeAkhir").val() == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }
    if ($("#TipePenjamin").val() != '4'){
        if ($("#NamaPenjamin").val() == ''){
            toast ('Isi Nama Penjamin', "warning");
            return false;
        }
    }
    //if True
    getDataListPasien();
}


function getDataListPasien() { 
    let PeriodeAwal ,PeriodeAkhir,TipePenjamin,NamaPenjamin;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    TipePenjamin = $("#TipePenjamin").val();
    NamaPenjamin = $("#NamaPenjamin").val();

    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 7 ?
                        data.replace(/<br>/g,String.fromCharCode(10)) :
       data;
                }
            }
        }
    };
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5',footer: true, title: 'Informasi Rekap MCU Pasien',orientation: 'landscape', pageSize: 'LEGAL', Image:('../public/images/yarsi.png'),
            customize: function ( xlsx ){
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // jQuery selector to add a border
                $('row c[r^="C"]', sheet).attr( 's', '25' );
                $('row c[r^="A"]', sheet).attr( 's', '25' );
                $('row c[r^="B"]', sheet).attr( 's', '25' );
                $('row c[r^="D"]', sheet).attr( 's', '25' );
                $('row c[r^="E"]', sheet).attr( 's', '25' );
                $('row c[r^="F"]', sheet).attr( 's', '25' );
                $('row c[r^="G"]', sheet).attr( 's', '25' );
                $('row c[r^="H"]', sheet).attr( 's', '25' );
                $('row c[r^="I"]', sheet).attr( 's', '25' );
                $('row c[r^="J"]', sheet).attr( 's', '25' );
                $('row c[r^="K"]', sheet).attr( 's', '25' );
                $('row c[r^="L"]', sheet).attr( 's', '25' );
                     } //c[r^="C"]'
        },
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,title: 'Rekapitulasi Hasil MCU',orientation: 'landscape',
            pageSize: 'LEGAL'}
        ],
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'ASC' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationRekapMCU/getDataListRekapMCUPasien", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               d.TipePenjamin = TipePenjamin;
               d.NamaPenjamin = NamaPenjamin;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
                { "data": "no" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' ) }, 
                { "data": "tgl"}, 
                { "data": "PatientName" }, 
                { "data": "Gander" },  
                { "data": "UMUR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' ) }, 
                { "data": "PemfisikTB"  }, 
                { "data": "PemfisikBB"}, 
                { "data": "Kelainan" }, 
                { "data": "DiagnosaKerja" }, 
                { "data": "AnjuranKonsulKe" },  
                { "data": "KetKesehatan" }, 
                { "data": "kategorikesehatan" }, 
           ],
        //    dom: 'Btirpl',
        //    buttons: [  $.extend( true, {}, buttonCommon, {
        //                extend: 'excelHtml5',
        //                text: 'Excel',
        //                filename: 'Rekapitulasi Hasil MCU',
        //                footer: true,
        //            } )],
       });
} 

async function asyncShowMain() {
    try {
        const datagetNamaPenjamin = await getNamaPenjamin();
        updateUIgetNamaPasien(datagetNamaPenjamin);
    } catch (err) {
        toast(err, "error")
    }
}

function getNamaPenjamin() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'tp_penjamin=' + $("#TipePenjamin").val()
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
            $("#NamaPenjamin").select2();
        })
}

function updateUIgetNamaPasien(datagetNamaPasien) {
    let responseApi = datagetNamaPasien; 
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        $("#NamaPenjamin").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaPenjamin").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
            $("#NamaPenjamin").append(newRow);
        }
    }
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