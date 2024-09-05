$(document).ready(function () {
    //asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#btnLoadInformation').attr('disabled', false);
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
    var JenisInfo = document.getElementById("JenisInfo").value; 
    var TipePenjamin = document.getElementById("TipePenjamin").value; 
    var NamaPenjamin = document.getElementById("NamaPenjamin").value; 

        window.location = base_url + "/SIKBREC/public/ExcelInfoPasienRanap/ExcelInfoPasienRanap2/" + PeriodeAwal + "/" + PeriodeAkhir + "/" + JenisInfo + "/" + TipePenjamin + "/" + NamaPenjamin;
   
}
function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // // if (Difference_In_Days > 30) {
    // //     alert("Periode Penarikan Data Adalah 30 Hari maksimal dari Tanggal Awal. !");
    // //     $("#PeriodeAwal").val('');
    // //     $("#PeriodeAkhir").val('');
    // //     $('#btnLoadInformation').attr('disabled', true);
    // // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // // }
}
function CheckVar (){
    getDataListPasien();
}


function getDataListPasien() { 
    let PeriodeAwal ;
    Ruangan = $("#Ruangan").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": false, // Set true agar bisa di sorting
           //"order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationDashboardBed/getData", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.Ruangan = Ruangan;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
                { "data" : "KodeLokasi"},
                { "data" : "Class"},
                { "data" : "Ward"},
                { "data" : "Bad"},
                { "data" : "TarifKamar"},
                //{ "data" : "JasaKeperawatan"},
                {
                    "render": function (data, type, row) {
                        var html = ""
                        if (row.Status=='0'){
                            var html = '<font size= "2"><span class="label label-danger">READY</span></font>'
                        }else if (row.Status=='1'){
                            var html = '<font size= "2"><span class="label label-success">USED</span></font>'
                        }else if (row.Status=='2'){
                            var html = '<font size= "2"><span class="label label-success">BOOKED</span></font>'
                        }else if (row.Status=='1'){
                            var html = '<font size= "2"><span class="label label-success">CLENED</span></font>'
                        }
                        
                        return html
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                       
                            var html = `<font size= "2">Nama Pasien : ${row.PasienRanap}<br>In/Out : ${row.tglMasuk}/${row.tglKeluar}<br></font>`
                       
                        
                        return html
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                       
                            var html = `<font size= "2">Nama Pasien : ${row.patientname}<br>Tgl Booking : ${row.bookingbeddate}<br>Datang : ${row.bookingstatus}</font>`
                       
                        
                        return html
                    }
                },
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

async function getdataRuangan() {
    try {
        const data = await getRuangan();
        updateUIgetRuangan(data);
    } catch (err) {
        toast(err, "error")
    }
}

function getRuangan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationDashboardBed/getRuangan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'lantai=' + $("#Lantai").val()
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
            $("#Ruangan").select2();
        })
}

function updateUIgetRuangan(data) {
    let responseApi = data; 
    if (responseApi.data !== null && responseApi.data !== undefined) {
        $("#Ruangan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#Ruangan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ROOM_ID + '">' + responseApi.data[i].ROOM + '</option';
            $("#Ruangan").append(newRow);
        }
    }
}