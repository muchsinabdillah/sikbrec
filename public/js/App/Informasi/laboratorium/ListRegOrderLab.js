$(document).ready(function () {
    showDataPasienRajalAktif();
    showDataPasienRajalAktif_walkin();

});
function showDataPasienRajalAktif() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiRajal/showDataPasienRajalAktif",
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
            { "data": "DokterName" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Perusahaan + '</br> <b>' + row.NoSEP_edited + ' </b></font> <br><br><span class="label label-danger">' + row.Company + '</span> ';
                    return html
                }
            },
            { "data": "namauser" }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'showFormOrderLaboratorium("' +  row.NoRegistrasi + '")\' ><span class="visible-content" > New Order</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
function showDataPasienRajalAktif_walkin() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif_walkin').DataTable().clear().destroy();
    $('#tbl_aktif_walkin').DataTable({
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
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'showFormOrderLaboratorium("' +  row.NoRegistrasi + '")\' ><span class="visible-content" > New Order</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}

function showFormOrderLaboratorium(NoRegistrasi) {
    const base_url = window.location.origin;
    var str = btoa(NoRegistrasi);
    url = base_url + '/SIKBREC/public/aRegistrasiRajal/OrderLaboratorium/' + str;

    var win = window.open(url, '_blank');
    win.focus()

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