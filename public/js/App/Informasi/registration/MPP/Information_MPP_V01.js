$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        if ($("#PeriodeAwal").val() == ''){
            toast('Isi Periode Awal !', 'warning')
            return false
        }
    
        if ($("#PeriodeAkhir").val() == ''){
            toast('Isi Periode Akhir !', 'warning')
            return false
        }

        if ($("#JenisForm").val() == 'Form_A'){
            getDataListPasienA();
        }else if ($("#JenisForm").val() == 'Form_B'){
            getDataListPasienB();
        }else{
            toast('Pilih Jenis Form !', 'warning');
            return false
        }
    });
});

function getDataListPasienA() { 

    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable2').dataTable({
        "bDestroy": true
    }).fnDestroy();

    $("#datatable2").hide();
    $("#datatable").show();
    let PeriodeAwal ,PeriodeAkhir
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    //Noregistrasi = $("#Noregistrasi").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationMPP/getDataListA", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               //d.Noregistrasi = Noregistrasi;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.No + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.NoEpisode + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.NamaPasien + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.NoRegistrasi + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.NoMR + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Tgl_Lahir + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Umur + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.JenisKelamin + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.RuangPerawatan + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Identf_Resiko_Tinggi + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Komplen_Tinggi + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Peny_Kronis + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Renc_plg_Komplex + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Membutuhkan_Kontinu + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_kasus_rawat_lama + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_biaya_tinggi + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Perkiraan_maslh_Financial + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Kasus_rumit + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Riwayat_Gangguan_Mental + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_Bunuh_diri + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_terlantar + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_tinggalSendiri + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.IdentfPotensi_narkoba + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Asesment_Riwayat_Saatini + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Riwayat_Kesehatan + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Psiko_spiritual_sosial + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Dukungan_Kel + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Pemahaman_Kesehatan + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Financial + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.DPJP_Utama + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.DPJP_Raber + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Diagnosis_Medis + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Identifikasi_Masalah + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Perencanaan_Pelayanan + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Case_Manager + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Hipertensi + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Hipertensi_ket + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Jantung + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Jantung_ket + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.DM + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.DM_ket + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.PPOK + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.PPOK_ket + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Kanker + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Kanker_ket + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Lain_lain + '<font>'; return html } },
                {"render":function(data,type,row){ var html=""; var html = '<font size="1">'+ row.Lain_lain_ket + '<font>'; return html } }
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
            ]
       });
} 

function getDataListPasienB() { 
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable2').dataTable({
        "bDestroy": true
    }).fnDestroy();


    $("#datatable").hide();
    $("#datatable2").show();
    let PeriodeAwal ,PeriodeAkhir
    PeriodeAwal = $("#PeriodeAwal").val();
    PeriodeAkhir = $("#PeriodeAkhir").val();
    //Noregistrasi = $("#Noregistrasi").val();
    var base_url = window.location.origin;
    $('#datatable2').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable2').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/bInformationMPP/getDataListB", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = PeriodeAwal;
               d.TglAkhir = PeriodeAkhir;
               //d.Noregistrasi = Noregistrasi;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.No + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.NoEpisode + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.NamaPasien + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.NoRegistrasi + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.NoMR + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.Tgl_Lahir + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.Umur + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.JenisKelamin + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.RuangPerawatan + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.Penjamin + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.HasilPelayanan + '</font>'; return html }},
            {"render":function(data,type,row){var html=""; var html='<font size="1">'+ row.Terminasi + '</font>'; return html }},
           ],
           dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'print'
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