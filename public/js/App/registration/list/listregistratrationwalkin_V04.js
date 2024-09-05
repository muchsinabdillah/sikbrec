$(document).ready(function () {
    showDataPasienRajalAktif();
});
function showDataPasienRajalAktif() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false, //[[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiWalkin/showDataPasienWalkinAktif",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [ 
            { "data": "NoMR" },
            { "data": "PatientName" },
            { "data": "VisitDate" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Telemedicine =="TELEMEDICINE"){
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-danger">' + row.Telemedicine + '</span> ';
                        return html
                    }else{
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-info">' + row.Telemedicine + '</span> ';
                        return html
                    }
                    
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Perusahaan + '</br> <b>' + row.NoSEP + ' </b></font>  ';
                    return html
                }
            },
            { "data": "namauser" }, 
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
function showDataPasienRajalArsip() {
    $(".preloader").fadeIn();
    var tglAwalarsip = $("[name='tglAwalarsip']").val();
    var tglAkhirArsip = $("[name='tglAkhirArsip']").val();
    var base_url = window.location.origin;
    $('#tbl_arsip').DataTable().clear().destroy();
    $('#tbl_arsip').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiWalkin/showDataPasienWalkinArsip",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglAwalarsip = tglAwalarsip;
                d.tglAkhirArsip = tglAkhirArsip;
            }
        },
        "columns": [
            { "data": "NoMR" },
            { "data": "PatientName" },
            { "data": "VisitDate" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Telemedicine == "TELEMEDICINE") {
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-danger">' + row.Telemedicine + '</span> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-info">' + row.Telemedicine + '</span> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Perusahaan + '</br> <b>' + row.NoSEP + ' </b></font>  ';
                    return html
                }
            },
            { "data": "namauser" },
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
    window.location = base_url + '/SIKBREC/public/aRegistrasiWalkin/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiWalkin/";
}