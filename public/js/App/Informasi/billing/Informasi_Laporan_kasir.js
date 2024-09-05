$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $('#btn_infokasir').attr('disabled', false);
    $(document).on('click', '#btn_infokasir', function () {
        //checking before get data
        CheckVar();
    });
   
});


async function asyncShowMain() {
    try { 
        
        const datagetkasir =  await getkasir();
        const datagetPaymentType =  await getPaymentType();

        updateUIgetkasir(datagetkasir);
        updateUIgetPaymentType(datagetPaymentType);
    } catch (err) {
        toast(err, "error")
    }
}



function updateUIgetkasir(datagetkasir) {
    let data = datagetkasir;
    if (data !== null && data !== undefined) {
        // $("#kasir").empty();
        // var newRow = '<option value="">-- PILIH --</option';
        $("#kasir").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].username + '">' + data.data[i].username + '</option';
            $("#kasir").append(newRow);
        }
    }
}

function getkasir() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InfoLaporanKasir/getListKasir';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#tipepembayaran").val()
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
            $("#kasir").select2();
        })
}
function updateUIgetPaymentType(datagetPaymentType) {
    let data = datagetPaymentType;
    if (data !== null && data !== undefined) {
        // $("#kasir").empty();
        // var newRow = '<option value="">-- PILIH --</option';
        $("#tipepembayaran").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].PaymentType + '">' + data.data[i].PaymentType + '</option';
            $("#tipepembayaran").append(newRow);
        }
    }
}

function getPaymentType() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/InfoLaporanKasir/getPaymentType';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#tipepembayaran").val()
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
            $("#tipepembayaran").select2();
        })
}
function clearVal(val){
    //------07-03-2023
    if (val == '1' ){
        $("#tipepembayaran").val('').trigger('change');
        $("#tipepembayaran").attr('disabled', true);
        return false;
    }

    $("#tipepembayaran").val('');
    $("#tipepembayaran").attr('disabled', false);
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

    getDataLaporan();
}
function getDataLaporan() { 
    let PeriodeAwal ,PeriodeAkhir,kasir,jenispasien,tipepembayaran,tipeinfo;
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    kasir = $("#kasir").val();
    jenispasien = $("#jenispasien").val();
    tipepembayaran = $("#tipepembayaran").val();
    tipeinfo = $("#tipeinfo").val();
    var base_url = window.location.origin;
    
    $('#datatable1').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable2').dataTable({
        "bDestroy": true
    }).fnDestroy();
    if (tipeinfo == '2'  && jenispasien == '1' || (tipeinfo == '2' && jenispasien == '2') || (tipeinfo == '2' && jenispasien == '3') || (tipeinfo == '2' && jenispasien == '4')){
        $("#datatable1").show();
        $("#datatable2").hide();

       $('#datatable1').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/InfoLaporanKasir/getDataLaporan", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.kasir = kasir;
                d.jenispasien = jenispasien;
                d.tipeinfo = tipeinfo;
                d.tipepembayaran = tipepembayaran;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "NoTransaksi" }, 
            { "data": "NoKwitansi" }, 
             { "data": "NoEpisode" }, 
             { "data": "NoReg" }, 
             { "data": "NoMR" },
             { "data": "NamaPasien" }, 
             { "data": "NamaJaminan" },    
             { "data": "Nama_Unit" }, 
              { "data": "Nama_Dokter"}, 
             { "data": "TGL_Transaksi" },  
             { "data": "User_Kasir" },  
             { "data": "Total_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
             { "data": "Tipe_Pembayaran" },  
             { "data": "Nama_Perusahaan" },  
             { "data": "Nomor_Kartu" },  
             { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
                   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });

    }else if (tipeinfo == '1'  && jenispasien == '1' || (tipeinfo == '1' && jenispasien == '2') || (tipeinfo == '1' && jenispasien == '3') || (tipeinfo == '1' && jenispasien == '4')){
        $("#datatable1").hide();
        $("#datatable2").show();
        // $('#datatable2').dataTable({
        //     "bDestroy": true
        // }).fnDestroy();

       $('#datatable2').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/InfoLaporanKasir/getDataLaporan", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = PeriodeAwal;
                d.TglAkhir = PeriodeAkhir;
                d.kasir = kasir;
                d.jenispasien = jenispasien;
                d.tipeinfo = tipeinfo;
                d.tipepembayaran = tipepembayaran;
               // d.custom = $('#myInput').val();
               // etc
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "data": "NoTransaksi" }, 
            { "data": "NoKwitansi" }, 
             { "data": "NoEpisode" }, 
             { "data": "NoReg" }, 
             { "data": "NoMR" },
             { "data": "NamaPasien" }, 
             { "data": "NamaJaminan" },    
             { "data": "Nama_Unit" }, 
              { "data": "Nama_Dokter"}, 
             { "data": "TGL_Transaksi" },  
             { "data": "User_Kasir" },  
             { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
             { "data": "Cash" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
             { "data": "Debit" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
             { "data": "Kredit" ,render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
            //  { "data": "Nominal_Bayar" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'')},  
                   
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
       });
    }else{
        $("#datatable1").hide();
        $("#datatable2").hide();
        toast('Error! Data Not Found!',"error")
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