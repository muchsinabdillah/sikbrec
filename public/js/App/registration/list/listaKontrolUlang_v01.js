$(document).ready(function () {
    showDataPasienRajalAktif();
});
function showDataPasienRajalAktif() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
         "searching" : true,
     "pagging": true,
     "processing": true, 
     "serverSide": true,
     "ordering": true, // Set true agar bisa di sorting
     "order": [[ 0, 'desc' ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aKontrolUlang/showKOntrolUlang",
            "type": "POST",
            "deferRender": true,
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [ 
            { "data": "TglKontrol" }, 
            { "data": "NoMR" },
            { "data": "PatientName" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" },
            { "data": "Jam" },
            { "data": "Dokter" },
            { "data": "PoliKlinik" },
            { "data": "Keterangan" },
            { "data": "NoReservasi" }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowDataPasienPoliklinik(' + row.ID + ')" ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
function showDataPasienRajalAktif_old() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "searching" : true,
        "pagging": true,
        "processing": true, 
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aKontrolUlang/showKOntrolUlang",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [ 
            { "data": "TglKontrol" }, 
            { "data": "NoMR" },
            { "data": "PatientName" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" },
            { "data": "Jam" },
            { "data": "Dokter" },
            { "data": "PoliKlinik" },
            { "data": "Keterangan" },
            { "data": "NoReservasi" }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowDataPasienPoliklinik(' + row.ID + ')" ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
 
function ShowDataPasienPoliklinik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aKontrolUlang/Entry/' + str;
}
 
 