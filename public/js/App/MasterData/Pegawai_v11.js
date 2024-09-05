$(document).ready(function () {
    $(".preloader").fadeOut();
   // document.getElementById("hrd_nilai_UMK").disabled = true;
    $('#hrd_nilai_UMK').val('0');
 
    var newRow = '<option value="">-- Pilih Kabupaten --</option';
    $("#Medrec_kabupaten").append(newRow);
    // $("#Medrec_kabupaten").select2();

    var newRow2 = '<option value="">-- Pilih Kecamatan --</option';
    $("#Medrec_Kecamatan").append(newRow2);
    //  $("#Medrec_Kecamatan").select2();

    var newRow3 = '<option value="">-- Pilih Kelurahan --</option';
    $("#Medrec_Kelurahan").append(newRow3);
    getProvinsi(); 
    getDepartment();
    getUnit(); 
    getStatusNikah();
    getAgama();
    getPendidikan();
    getJabatan();
    getStatusPegawai(); 
    getJenisSP();
    getLokasi();
    $("#Medrec_kabupaten").select2();
    $("#Medrec_Kecamatan").select2();
    $("#Medrec_Kelurahan").select2();
    $('#Medical_Provinsi').change(function () {
        getKabupaten();
        $("#Medrec_kabupaten").empty();
        var newRow = '<option value="">-- Pilih Kabupaten --</option';
        $("#Medrec_kabupaten").append(newRow);
        // $("#Medrec_kabupaten").select2();

        $("#Medrec_Kecamatan").empty();
        var newRow = '<option value="">-- Pilih Kecamatan --</option';
        $("#Medrec_Kecamatan").append(newRow);
        //  $("#Medrec_Kecamatan").select2();

        $("#Medrec_Kelurahan").empty();
        var newRow = '<option value="">-- Pilih Kelurahan --</option';
        $("#Medrec_Kelurahan").append(newRow);
        //  $("#Medrec_Kelurahan").select2();
    });
    // Medical_Provinsi Focus Out
    //$('#Medical_Provinsi').focusout(function () {
    //    getKabupaten();
    //});
    // Medical_Provinsi Focus Out
    //$('#Medrec_kabupaten').focusout(function () {
    //    getKecamtan();
    //});
    $('#Medrec_kabupaten').change(function () {
        getKecamtan();
    });
    // Medical_Provinsi Focus Out
    //$('#Medrec_Kecamatan').focusout(function () {
    //    getKelurahan();
    //});

    $('#Medrec_Kecamatan').change(function () {
        getKelurahan();

    });
    $('#Medrec_Kelurahan').change(function () {
        getKodepos();
    });
    $(document).on('click', '#btnsimpanTrsReg', function () {
         var str = $("#FRMcreatemr").serialize();
        var form_data = new FormData(); 
        form_data.append("pilihnamabarang", $("#pilihnamabarang").val());
        form_data.append("hrd_id", $("#hrd_id").val());
        form_data.append("hrd_status", $("#hrd_status").val());
        form_data.append("hrd_nip", $("#hrd_nip").val());
        form_data.append("hrd_namapegawai", $("#hrd_namapegawai").val());
        form_data.append("hrd_department", $("#hrd_department").val());
        form_data.append("hrd_alamat", $("#hrd_alamat").val());
        form_data.append("hrd_unitkerja", $("#hrd_unitkerja").val());
        form_data.append("hrd_alamat_domisili", $("#hrd_alamat_domisili").val());
        form_data.append("hrd_jabatan", $("#hrd_jabatan").val());
        form_data.append("hrd_status_pegawai", $("#hrd_status_pegawai").val());
        form_data.append("hrd_jeniskelamin", $("#hrd_jeniskelamin").val());
        form_data.append("hrd_agama", $("#hrd_agama").val());
        form_data.append("Medical_Provinsi", $("#Medical_Provinsi").val());
        form_data.append("Medrec_Warganegara", $("#Medrec_Warganegara").val());
        form_data.append("Medrec_kabupaten", $("#Medrec_kabupaten").val());
        form_data.append("Medrec_Tpt_lahir", $("#Medrec_Tpt_lahir").val());
        form_data.append("Medrec_Kecamatan", $("#Medrec_Kecamatan").val());
        form_data.append("Medrec_Tgl_Lahir", $("#Medrec_Tgl_Lahir").val());
        form_data.append("Medrec_Kelurahan", $("#Medrec_Kelurahan").val());
        form_data.append("Hrd_statusNikah", $("#Hrd_statusNikah").val());
        form_data.append("Medrec_Kodepos", $("#Medrec_Kodepos").val());
        form_data.append("hrd_HomePhone", $("#hrd_HomePhone").val());
        form_data.append("hrd_handphone", $("#hrd_handphone").val());
        form_data.append("hrd_Pendidikan", $("#hrd_Pendidikan").val());
        form_data.append("hrd_status_pajak", $("#hrd_status_pajak").val());
        form_data.append("hrd_jurusan2", $("#hrd_jurusan2").val());
        form_data.append("hrd_jmltanggungan", $("#hrd_jmltanggungan").val());
        form_data.append("hrd_npwp", $("#hrd_npwp").val());
        form_data.append("hrd_ktp", $("#hrd_ktp").val());
        form_data.append("hrd_bpjstk", $("#hrd_bpjstk").val());
        form_data.append("hrd_bpjs_kes", $("#hrd_bpjs_kes").val());
        form_data.append("hrd_norekenig", $("#hrd_norekenig").val());
        form_data.append("hrd_hakKelas", $("#hrd_hakKelas").val());
        form_data.append("hrd_namabank", $("#hrd_namabank").val());
        form_data.append("hrd_tipeKaryawan", $("#hrd_tipeKaryawan").val());
        form_data.append("hrd_str", $("#hrd_str").val());
        form_data.append("hrd_tglmasuk", $("#hrd_tglmasuk").val());
        form_data.append("hrd_plafonRajal", $("#hrd_plafonRajal").val());
        form_data.append("hrd_plafonRanap", $("#hrd_plafonRanap").val());
        form_data.append("hrd_hakKelas_PlafonRS", $("#hrd_hakKelas_PlafonRS").val());
        form_data.append("statusmr", $("#statusmr").val());
        form_data.append("hrd_keterangan_atributx", $("#hrd_keterangan_atributx").val());
        form_data.append("hrd_tgl_resign", $("#hrd_tgl_resign").val());
        form_data.append("hrd_keterangan_resign", $("#hrd_keterangan_resign").val());
        var base_url = window.location.origin;
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST 
            url: base_url + '/pms_gut/public/Pegawai/createPegawai',
            data: form_data,
            processData: false,
            contentType: false,
            dataType: "JSON",
            beforeSend: function () {
                
            },
            success: function (data) {
                if (data.status == "warning") { 
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
                    toastr["error"](data.errorname);
                } else if (data.status == "success") { 
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
                    toastr["success"]('Data Pegawai Berhasil disimpan !');
                    location.reload();
                }  
            },
            error: function (data) {
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
                toastr["error"](data.responseText);
            }
        });
    });
    $("#addsp").click(function () { // Ketika user menekan tombol di keyboard 
        add_sp_kerja();
    });
   
});
function delspkerjaList(x) {
    var hrd_id = $('#hrd_id').val();
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + "/pms_gut/public/Pegawai/delspkerjaList/", 
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "success") {
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
                toastr["success"]('Data Pendidikan Berhasil Dihapus !');
                getdatasplist(hrd_id);
                $('#hrd_jenis_sp').val('');
                $('#hrd_keterangan_sp').val('');
                $('#hrd_tgl_sp').val('');
                $('#hrd_jenis_sp').focus();
            } else if (data.status == 'error') {
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
                toastr["error"](data.errorname);
            }
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function add_sp_kerja() {
    var hrd_jenis_sp = $('#hrd_jenis_sp').val();
    var hrd_keterangan_sp = $('#hrd_keterangan_sp').val();
    var hrd_tgl_sp = $('#hrd_tgl_sp').val();
    var hrd_tgl_sp2 = $('#hrd_tgl_sp2').val();
    var hrd_id = $('#hrd_id').val();
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/Pegawai/add_sp_kerja/", 
            method: "POST",
            data: "hrd_id=" + hrd_id + "&hrd_jenis_sp=" + hrd_jenis_sp +
                "&hrd_keterangan_sp=" + hrd_keterangan_sp +
                "&hrd_tgl_sp=" + hrd_tgl_sp + "&hrd_tgl_sp2=" + hrd_tgl_sp2,
            dataType: "JSON",
            beforeSend: function () {
                //$('#savetrs').html('Loading...');
                //$('#savetrs').addClass('btn-danger');
                // document.getElementById("savetrs").disabled = true;
            },
            success: function (data) {
                if (data.status == "success") {
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
                        toastr["success"](data.message);
                    getdatasplist(hrd_id);
                    $('#hrd_jenis_sp').val('');
                    $('#hrd_keterangan_sp').val('');
                    $('#hrd_tgl_sp').val('');
                    $('#hrd_tgl_sp2').val('');
                    $('#hrd_jenis_sp').focus();
                } else {
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
                    toastr["error"](data.errorname);
                }
            },
            error: function (data) {
                // Welcome notification
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
                toastr["error"](data.responseText);
            }
        })
     
}
function getdatasplist(x) {
    var base_url = window.location.origin;
    $('#tbl_sp').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_sp').DataTable({
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getdatasplist/',
            "type": "POST",
            data: function (d) {
                d.q = x;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.no + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.stautsperingatan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Peringatan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Peringatan2 + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Alasan + '</font> ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="delspkerjaList(' + row.Id_Pelanggaran + ')" ><span class="visible-content" >Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ],
    });
}
function getdataPelatihanList(x) {
    var base_url = window.location.origin;
    $('#tbl_pelatihan').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_pelatihan').DataTable({
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getdataPelatihanList/',
            "type": "POST",
            data: function (d) {
                d.q = x;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.no + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Jenis_Pelatihan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama_Pelatihan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Awal + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Akhir + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Alamat_Pelatihan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Lama_Pelatihan_Internal + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.No_Sertifikat + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Berlaku + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="delpelatihanKerjaList(' + row.Id_Pelatihan + ')" ><span class="visible-content" >Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ],
    });
}
function add_pelatihan_kerja() {
    var hrd_jenis_Pelatihan = $('#hrd_jenis_Pelatihan').val();
    var hrd_nama_pelatihan = $('#hrd_nama_pelatihan').val();
    var hrd_tgl_mulai_pelatihan = $('#hrd_tgl_mulai_pelatihan').val();
    var hrd_tgl_akhir_pelatihan = $('#hrd_tgl_akhir_pelatihan').val();
    var hrd_alamat_Pelatihan = $('#hrd_alamat_Pelatihan').val();
    var hrd_lama_pelatihan = $('#hrd_lama_pelatihan').val();
    var hrd_noSertifikat_pelatihan = $('#hrd_noSertifikat_pelatihan').val();
    var hrd_id = $('#hrd_id').val();
    var hrd_tglexpiredsertifikat = $('#hrd_tglexpiredsertifikat').val();
    var base_url = window.location.origin;
    $.ajax({
            url: base_url + "/pms_gut/public/Pegawai/add_pelatihan_kerja/", 
            method: "POST",
            data: "hrd_id=" + hrd_id + "&hrd_jenis_Pelatihan=" + hrd_jenis_Pelatihan +
                "&hrd_nama_pelatihan=" + hrd_nama_pelatihan +
                "&hrd_tgl_akhir_pelatihan=" + hrd_tgl_akhir_pelatihan +
                "&hrd_tgl_mulai_pelatihan=" + hrd_tgl_mulai_pelatihan +
                "&hrd_alamat_Pelatihan=" + hrd_alamat_Pelatihan +
                "&hrd_lama_pelatihan=" + hrd_lama_pelatihan +
                "&hrd_noSertifikat_pelatihan=" + hrd_noSertifikat_pelatihan +
                "&hrd_tglexpiredsertifikat=" + hrd_tglexpiredsertifikat,
            dataType: "JSON",
            beforeSend: function () {
                //$('#savetrs').html('Loading...');
                //$('#savetrs').addClass('btn-danger');
                // document.getElementById("savetrs").disabled = true;
            },
            success: function (data) {
                console.log(data);
                if (data.status == "success") {
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
                    toastr["success"](data.message);
                    getdataPelatihanList(hrd_id);
                    $('#hrd_nama_pelatihan').val('');
                    $('#hrd_jenis_Pelatihan').val('');
                    $('#hrd_tgl_akhir_pelatihan').val('');
                    $('#hrd_tgl_mulai_pelatihan').val('');
                    $('#hrd_alamat_Pelatihan').val('');
                    $('#hrd_lama_pelatihan').val('');
                    $('#hrd_lama_pelatihan').val('');
                    $('#hrd_jenis_Pelatihan').focus();
                } else {
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
                    toastr["error"](data.errorname);
                }
            },
            error: function (data) {
                // Welcome notification
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
                toastr["error"](data.responseText);
            }
        })
}
function delpelatihanKerjaList(x) {
    var hrd_id = $('#hrd_id').val();
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + "/pms_gut/public/Pegawai/delpelatihanKerjaList/",
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "success") {

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
                toastr["success"]('Data Pendidikan Berhasil Dihapus !');
                getdataPelatihanList(hrd_id);
                $('#hrd_status_kerja2').val('');
                $('#hrd_tgl_awal_kontrak').val('');
                $('#hrd_tgl_akhir_kontrak').val('');
                $('#hrd_no_surat_statuskerjad').val('');
                $('#hrd_status_kerja2').focus();
            } else if (data.status == 'error') {
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
                toastr["error"](data.errorname);

            }
            //   location.reload();
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function delStatusKerjaList(x) {
    var hrd_id = $('#hrd_id').val();
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + "/pms_gut/public/Pegawai/delStatusKerjaList/", 
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "success") {

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
                toastr["success"]('Data Pendidikan Berhasil Dihapus !');
                getdataStatusKerjaList(hrd_id);
                $('#hrd_status_kerja2').val('');
                $('#hrd_tgl_awal_kontrak').val('');
                $('#hrd_tgl_akhir_kontrak').val('');
                $('#hrd_no_surat_statuskerjad').val('');
                $('#hrd_status_kerja2').focus();
            } else if (data.status == 'error') {
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
                toastr["error"](data.errorname);

            }
            //   location.reload();
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getdataStatusKerjaList(x) {
    var base_url = window.location.origin;
    $('#tbl_status_kerja').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_status_kerja').DataTable({
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getdataStatusKerjaList/',
            "type": "POST",
            data: function (d) {
                d.q = x;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.no + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Status_Kerja + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Mulai_Kontrak + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Akhir_Kontrak + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.SK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_LOKASI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Kd_Tipe + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Kd_Grade + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.tipe_kontrak + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="delStatusKerjaList(' + row.Id_Status_Pegawai + ')" ><span class="visible-content" >Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ],
    });
}
function add_datastatus_Kerja() {
    var hrd_status_kerja2 = $('#hrd_status_kerja2').val();
    var hrd_tgl_awal_kontrak = $('#hrd_tgl_awal_kontrak').val();
    var hrd_tgl_akhir_kontrak = $('#hrd_tgl_akhir_kontrak').val();
    var hrd_no_surat_statuskerjad = $('#hrd_no_surat_statuskerjad').val();
    var hrd_Lokasi = $('#hrd_Lokasi').val();
    var Hrd_Grade = $('#Hrd_Grade').val();
    var Hrd_Tipe = $('#Hrd_Tipe').val();
    var hrd_id = $('#hrd_id').val();
    var hrd_nilai_UMK = $('#hrd_nilai_UMK').val();
    var Hrd_Tipe_Kontrak = $('#Hrd_Tipe_Kontrak').val();
    var base_url = window.location.origin;
    $.ajax({
            url: base_url + "/pms_gut/public/Pegawai/add_datastatus_Kerja/", 
            method: "POST",
            data: "hrd_id=" + hrd_id + "&hrd_status_kerja2=" + hrd_status_kerja2 +
                "&hrd_tgl_awal_kontrak=" + hrd_tgl_awal_kontrak +
                "&hrd_no_surat_statuskerjad=" + hrd_no_surat_statuskerjad +
                "&hrd_tgl_akhir_kontrak=" + hrd_tgl_akhir_kontrak + "&hrd_Lokasi=" + hrd_Lokasi
                + "&Hrd_Grade=" + Hrd_Grade + "&Hrd_Tipe=" + Hrd_Tipe + "&hrd_nilai_UMK=" + hrd_nilai_UMK
                + "&Hrd_Tipe_Kontrak=" + Hrd_Tipe_Kontrak,
            dataType: "JSON",
            beforeSend: function () {
                //$('#savetrs').html('Loading...');
                //$('#savetrs').addClass('btn-danger');
                // document.getElementById("savetrs").disabled = true;
            },
            success: function (data) {
                console.log(data);
                if (data.status == "success") {
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
                        toastr["success"](data.message);
                    getdataStatusKerjaList(hrd_id);
                    $('#hrd_status_kerja2').val('');
                    $('#hrd_tgl_awal_kontrak').val('');
                    $('#hrd_tgl_akhir_kontrak').val('');
                    $('#hrd_no_surat_statuskerjad').val('');
                    $('#hrd_status_kerja2').focus();
                } else {
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
                    toastr["error"](data.errorname);
                }

            },
            error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
        })
     
}
function getkeluargaList(x) {
    var base_url = window.location.origin;
    $('#tbl_keluargax').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_keluargax').DataTable({
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getkeluargaList/',
            "type": "POST",
            data: function (d) {
                d.q = x;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.no + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.statuskeluarga + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.nama + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tgl_Lahir + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tpt_Lahir + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NIK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_KK + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_TLP + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_BPJS + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="delkeluargaList(' + row.Id_Keluarga + ')" ><span class="visible-content" >Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ],
    });
}
function delkeluargaList(x) {
    var hrd_id = $('#hrd_id').val();
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + "/pms_gut/public/Pegawai/delkeluargaList/", 
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "success") {

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
                toastr["success"]('Data Pendidikan Berhasil Dihapus !');
                getkeluargaList(hrd_id);
                $('#hrd_jenis_Keluarga').val('');
                $('#hrd_nama_keluarga').val('');
                $('#hrd_Tahun_lahir').focus();
                $('#hrd_tempat_lahir').focus();
            } else   {

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
                toastr["error"](data.errorname);
            }
            //   location.reload();
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function add_keluarga() {
    var hrd_jenis_Keluarga = $('#hrd_jenis_Keluarga').val();
    var hrd_nama_keluarga = $('#hrd_nama_keluarga').val();
    var hrd_tempat_lahir = $('#hrd_tempat_lahir').val();
    var hrd_Tahun_lahir = $('#hrd_Tahun_lahir').val();
    var hrd_id = $('#hrd_id').val();
    var hrd_Kel_NoKtp = $('#hrd_Kel_NoKtp').val();
    var hrd_Kel_NoKK = $('#hrd_Kel_NoKK').val();
    var hrd_Kel_Tlp = $('#hrd_Kel_Tlp').val();
    var hrd_Kel_BPJS = $('#hrd_Kel_BPJS').val();
    var base_url = window.location.origin;
        $.ajax({
            url: base_url + "/pms_gut/public/Pegawai/add_keluarga/", 
            method: "POST",
            data: "hrd_id=" + hrd_id + "&hrd_jenis_Keluarga=" + hrd_jenis_Keluarga +
                "&hrd_nama_keluarga=" + hrd_nama_keluarga +
                "&hrd_Tahun_lahir=" + hrd_Tahun_lahir + "&hrd_tempat_lahir=" + hrd_tempat_lahir
                + "&hrd_Kel_NoKtp=" + hrd_Kel_NoKtp + "&hrd_Kel_NoKK=" + hrd_Kel_NoKK
                + "&hrd_Kel_Tlp=" + hrd_Kel_Tlp + "&hrd_Kel_BPJS=" + hrd_Kel_BPJS,
            dataType: "JSON",
            beforeSend: function () {
                 
            },
            success: function (data) {
                console.log(data);
                if (data.status == "success") {

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
                    toastr["success"](data.message); 
                    getkeluargaList(hrd_id);  
                    $('#hrd_tempat_lahir').val('');
                    $('#hrd_Tahun_lahir').val(''); 
                    $('#hrd_Kel_NoKtp').val('');
                    $('#hrd_Kel_NoKK').val('');
                    $('#hrd_Kel_Tlp').val('');
                    $('#hrd_Kel_BPJS').val('');
                    $('#hrd_jenis_Keluarga').val('');
                    $('#hrd_nama_keluarga').val(''); 
                    $('#hrd_Tahun_lahir').focus();
                    $('#hrd_tempat_lahir').focus();
                } else { 
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
                    toastr["error"](data.errorname); 
                } 
            },
            error: function (data) {
                // Welcome notification
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
                toastr["error"](data.responseText);
            }
        })
    
}
function getPendidikanList(x) { 
    var base_url = window.location.origin;
    $('#tblPendidikan').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblPendidikan').DataTable({
        "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getPendidikanList/',
            "type": "POST",
            data: function (d) {
                d.q = x; 
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.no + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Jenis_Pendidikan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama_Pendidikan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Jurusan + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tahun_Lulus + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="delPendidikanList(' + row.ID + ')" ><span class="visible-content" >Del</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ],
    });
} 
function delPendidikanList(x) {
    var hrd_id = $('#hrd_id').val();
    var iddetil = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url + "/pms_gut/public/Pegawai/delPendidikanList/", 
        data: "iddetil=" + iddetil,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "success") {
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
                toastr["success"]('Data Pendidikan Berhasil Dihapus !');
                getPendidikanList(hrd_id);
                $('#hrd_jenis_Pendidikan').val('');
                $('#hrd_Nama_Pendidikan').val('');
                $('#hrd_Jurusan').val('');
                $('#hrd_Tahun_Lulus').val('');
                $('#hrd_Tahun_Lulus').focus();
            } else if (data.status == 'error') {
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
                toastr["error"](data.errorname);

            }
            //   location.reload();
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function add_Pendidikan() {
    var hrd_jenis_Pendidikan = $('#hrd_jenis_Pendidikan').val();
    var hrd_Nama_Pendidikan = $('#hrd_Nama_Pendidikan').val();
    var hrd_Jurusan = $('#hrd_Jurusan').val();
    var hrd_Tahun_Lulus = $('#hrd_Tahun_Lulus').val();
    var hrd_id = $('#hrd_id').val(); 
    var base_url = window.location.origin;
        $.ajax({
            url: base_url + "/pms_gut/public/Pegawai/add_Pendidikan/",
            method: "POST",
            data: "hrd_id=" + hrd_id + "&hrd_jenis_Pendidikan=" + hrd_jenis_Pendidikan +
                "&hrd_Nama_Pendidikan=" + hrd_Nama_Pendidikan +
                "&hrd_Tahun_Lulus=" + hrd_Tahun_Lulus + "&hrd_Jurusan=" + hrd_Jurusan,
            dataType: "JSON",
            beforeSend: function () {
                //$('#savetrs').html('Loading...');
                //$('#savetrs').addClass('btn-danger');
                // document.getElementById("savetrs").disabled = true;
            },
            success: function (data) {
                console.log(data);
                if (data.status == "success") {

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
                    toastr["success"](data.message);
                    getPendidikanList(hrd_id);
                    $('#hrd_jenis_Pendidikan').val('');
                    $('#hrd_Nama_Pendidikan').val('');
                    $('#hrd_Jurusan').val('');
                    $('#hrd_Tahun_Lulus').val('');
                    $('#hrd_Tahun_Lulus').focus();
                } else { 
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
                    toastr["error"](data.errorname);
                }

            },
            error: function (data) {
                // Welcome notification
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
                toastr["error"](data.responseText);
            }
        })
    
}
function showDataAllPegawai() {
    $('#loadMdlLogbook').modal('show'); 
    var base_url = window.location.origin;
    $('#tblpeagwaiAll').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblpeagwaiAll').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Pegawai/getpegawaiAll/',
            "type": "POST", 
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nip + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Nama + '</font> ';
                    return html
                }
            }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = "" 
                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'ShowDataTRsDRbyID("' + row.ID_Data + '")\'>PILIH</button> '
                    return html
                }
            },
        ],
    });
}
function valtipe(){
  
  var Hrd_Tipe =   $('#Hrd_Tipe').val();
  if(Hrd_Tipe == "C"){
      document.getElementById("hrd_nilai_UMK").disabled = false;
       $('#hrd_nilai_UMK').val('0');
  }else{
      document.getElementById("hrd_nilai_UMK").disabled = true;
       $('#hrd_nilai_UMK').val('0');
  }
}
function ShowDataTRsDRbyID(params) {
    getPendidikanList(params);
    get_dataPegawai(params);
    getkeluargaList(params);
    getdataStatusKerjaList(params);
    getdataPelatihanList(params);
    getdatasplist(params);
}
function get_dataPegawai(x) {
    
    var x = x;
    var base_url = window.location.origin;
    $.ajax({ 
        data: "q=" + x,
        url: base_url + '/pms_gut/public/Pegawai/getdataPegawaibyID',
        type: "POST", 
        cache: false,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            $("#hrd_id").val(data.ID);
            $("#hrd_status").val(data.productcode);
            $("#hrd_nip").val(data.Nip);
            $("#hrd_namapegawai").val(data.Nama);
            $("#hrd_alamat").val(data.Alamat);
            $("#hrd_unitkerja").val(data.Unit_1);
            $("#hrd_jabatan").val(data.Jabatan);
            $("#hrd_status_pegawai").val(data.Status_Pegawai);
            $("#hrd_jeniskelamin").val(data.Jenis_Kelamin);
            $("#hrd_agama").val(data.Agama);
            $("#hrd_department").val(data.Departemen);
            $("#hrd_status").val(data.Status_Aktif);
            $("#Medrec_Tpt_lahir").val(data.Tempat_Lahir);
            $("#Medrec_Tgl_Lahir").val(data.Date_of_birthx);

            $("#Hrd_statusNikah").val(data.Status_Menikah);
            $("#hrd_HomePhone").val(data.mobile);
            $("#hrd_handphone").val(data.hp);
            $("#hrd_Pendidikan").val(data.Pendidikan);
            $("#hrd_status_pajak").val(data.StatusPajak);
            $("#hrd_jurusan2").val(data.Jurusan);
            // $("#hrd_jmltanggungan").val(data.Date_of_birthx); 
            $("#hrd_npwp").val(data.NoNPWP);
            $("#hrd_ktp").val(data.No_KTP);
            $("#hrd_bpjstk").val(data.NoBPJSKetenagakerjaan);
            $("#hrd_bpjs_kes").val(data.NoBPJSKesehatan);
            $("#hrd_norekenig").val(data.No_Rek);
            $("#hrd_hakKelas").val(data.HakKelasBPJSKes);
            $("#hrd_namabank").val(data.NamaBank);
            $("#hrd_plafonRajal").val(data.Plafon_RJ);
            $("#hrd_plafonRanap").val(data.Plafon_RI);
            $("#hrd_tglmasuk").val(data.Tgl_Masukx);
            $("#hrd_hakKelas_PlafonRS").val(data.HakKelasPlafonRS);
            $("#hrd_jmltanggungan").val(data.Jml_Tanggungan);
            $("#hrd_keterangan_resign").val(data.AlasanKeluar);
            $("#hrd_tgl_resign").val(data.Tgl_Keluarx);
            $("#hrd_keterangan_atributx").val(data.Atribut_Pegawai_Kembali);
            $("#hrd_alamat_domisili").val(data.Alamat_Domisili);
            $("#Medrec_Kodepos").val(data.kodepos);
            $('#Medical_Provinsi').val(data.Medical_Provinsi).trigger('change');
            $('#hrd_tipeKaryawan').val(data.KD_JENIS_PEG).trigger('change');
            // $("#Medical_Provinsi").val(data.Medical_Provinsi);
            setTimeout(function () {
                $(".preloader").fadeIn(); 
                $('#Medrec_kabupaten').val(data.Medrec_kabupaten).trigger('change');
                // $("#Medrec_kabupaten").val(data.Medrec_kabupaten);
                setTimeout(function () {
                    $(".preloader").fadeIn();
                    // $("#Medrec_Kecamatan").val(data.Medrec_Kecamatan); 
                    $('#Medrec_Kecamatan').val(data.Medrec_Kecamatan).trigger('change');
                    setTimeout(function () {
                        $(".preloader").fadeIn();
                        $('#Medrec_Kelurahan').val(data.Medrec_Kelurahan).trigger('change');
                        //$("#Medrec_Kelurahan").val(data.Medrec_Kelurahan); 
                        $(".preloader").fadeOut();
                    }, 3000);
                  //  $(".preloader").fadeOut();
                }, 2000);
               // $(".preloader").fadeOut();
            }, 1000);
            
           // getProvinsi();
           // getKabupaten();
           // getKelurahan2(data.Medrec_Kecamatan);
           // getKecamtan2(data.Medrec_kabupaten);

        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
    $('#loadMdlLogbook').modal('hide');
}
function getKelurahan2(x) {
    var xdi = x;
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getKelurahanByID',
        dataType: "json",
        success: function (data) {
            if (data.getKelurahan !== null && data.getKelurahan !== undefined) {
                console.log(data); 
                var elements = $();
                var dataarray = data.getKelurahan.length;
                for (i = 0; i < data.getKelurahan.length; i++) {
                    var newRow = '<option value="' + data.getKelurahan[i].desaId + '">' + data.getKelurahan[i].Kelurahan + '</option';
                    $("#Medrec_Kelurahan").append(newRow);

                }
            }
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getKelurahan() {
    var xdi = document.getElementById("Medrec_Kecamatan").value;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getKelurahanByID',
        dataType: "json",
        success: function (data) {
            if (data.getKelurahan !== null && data.getKelurahan !== undefined) {
                console.log(data);
                $("#Medrec_Kelurahan").empty();
                var newRow = '<option value=""></option';
                $("#Medrec_Kelurahan").append(newRow);
                var elements = $();
                var dataarray = data.getKelurahan.length;
                for (i = 0; i < data.getKelurahan.length; i++) {
                    var newRow = '<option value="' + data.getKelurahan[i].desaId + '">' + data.getKelurahan[i].Kelurahan + '</option';
                    $("#Medrec_Kelurahan").append(newRow);

                }
            }
        },
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getKodepos() {
    var xdi = document.getElementById("Medrec_Kelurahan").value;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getKodepos',
        dataType: "json",
        success: function (data) {
            $("#Medrec_Kodepos").val(data.kodepos);
        }, 
        error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getKecamtan2(x) {
    var xdi = x;
    var xdi = document.getElementById("Medical_Provinsi").value;
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getKecamtanByID',
        dataType: "json",
        success: function (data) {
            if (data.getKecamtan !== null && data.getKecamtan !== undefined) {
                console.log(data); 
                var elements = $();
                var dataarray = data.getKecamtan.length;
                for (i = 0; i < data.getKecamtan.length; i++) {
                    var newRow = '<option value="' + data.getKecamtan[i].kecamatanId + '">' + data.getKecamtan[i].Kecamatan + '</option';
                    $("#Medrec_Kecamatan").append(newRow);
                    //$("#Medrec_kabupaten").select2();

                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getKecamtan() {
    var xdi = document.getElementById("Medrec_kabupaten").value; 
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getKecamtanByID',
        dataType: "json",
        success: function (data) {
            if (data.getKecamtan !== null && data.getKecamtan !== undefined) {
                console.log(data);
                $("#Medrec_Kecamatan").empty();
                var newRow = '<option value="">-- Pilih Kecamatan --</option';
                $("#Medrec_Kecamatan").append(newRow);
                var elements = $();
                var dataarray = data.getKecamtan.length;
                for (i = 0; i < data.getKecamtan.length; i++) {
                    var newRow = '<option value="' + data.getKecamtan[i].kecamatanId + '">' + data.getKecamtan[i].Kecamatan + '</option';
                    $("#Medrec_Kecamatan").append(newRow);
                    // $("#Medrec_Kecamatan").select2();

                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getKabupaten() {
    var base_url = window.location.origin;
    var xdi = document.getElementById("Medical_Provinsi").value;
    console.log(xdi, 'xasdw');
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getKabupatenByID',
        dataType: "json",
        success: function (data) {
            if (data.getKabupaten !== null && data.getKabupaten !== undefined) {
                console.log(data);
                var elements = $();
                var dataarray = data.getKabupaten.length;
                for (i = 0; i < data.getKabupaten.length; i++) {
                    var newRow = '<option value="' + data.getKabupaten[i].kabupatenId + '">' + data.getKabupaten[i].kabupatenNama + '</option';
                    $("#Medrec_kabupaten").append(newRow);
                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
function searchnilaiumklokasi() {
    var hrd_Lokasi = $('#hrd_Lokasi').val();
    var base_url = window.location.origin;
    $.ajax({ 
        url: base_url + '/pms_gut/public/Pegawai/searchnilaiumklokasi',
        data: "q=" + hrd_Lokasi,
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {

            $("#hrd_nilaiumk_lokasi").val(formatNumber(data.UMK_LOKASI));
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getJenisSP() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getJenisSP',
        dataType: "json",
        success: function (data) {
            if (data.datastatussp !== null && data.datastatussp !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_jenis_sp").append(newRow);
                var elements = $();
                var dataarray = data.datastatussp.length;
                for (i = 0; i < data.datastatussp.length; i++) {
                    var newRow = '<option value="' + data.datastatussp[i].id + '">' + data.datastatussp[i].statusperingatan + '</option';
                    $("#hrd_jenis_sp").append(newRow);
                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getLokasi() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getLokasi',
        dataType: "json",
        success: function (data) {
            if (data.getpegawai !== null && data.getpegawai !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_Lokasi").append(newRow);
                var elements = $();
                var dataarray = data.getpegawai.length;
                for (i = 0; i < data.getpegawai.length; i++) {
                    var newRow = '<option value="' + data.getpegawai[i].ID_Data + '">' + data.getpegawai[i].ID_Data + ' - ' + data.getpegawai[i].NM_CLIENT + '</option';
                    $("#hrd_Lokasi").append(newRow);
                }
                $('.js-example-basic-single').select2();
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getStatusPegawai() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/Pegawai/getStatusPegawai',
        dataType: "json",
        success: function (data) {
            if (data.datastatuspegawai !== null && data.datastatuspegawai !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_status_pegawai").append(newRow);
                $("#hrd_status_kerja2").append(newRow);
                var elements = $();
                var dataarray = data.datastatuspegawai.length;
                for (i = 0; i < data.datastatuspegawai.length; i++) {
                    var newRow = '<option value="' + data.datastatuspegawai[i].id + '">' + data.datastatuspegawai[i].Status_Kerja + '</option';
                    $("#hrd_status_pegawai").append(newRow);
                    $("#hrd_status_kerja2").append(newRow);
                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getJabatan() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getJabatan', 
        dataType: "json",
        success: function (data) {
            if (data.datajabatan !== null && data.datajabatan !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_jabatan").append(newRow);
                var elements = $();
                var dataarray = data.datajabatan.length;
                for (i = 0; i < data.datajabatan.length; i++) {
                    var newRow = '<option value="' + data.datajabatan[i].id + '">' + data.datajabatan[i].Jabatan_Fungsional + '</option';
                    $("#hrd_jabatan").append(newRow);
                }
            }
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
function getPendidikan() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getPendidikan',
        dataType: "json",
        success: function (data) {
            if (data.datapendidikan !== null && data.datapendidikan !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_Pendidikan").append(newRow);
                for (i = 0; i < data.datapendidikan.length; i++) {
                    var newRow = '<option value="' + data.datapendidikan[i].id + '">' + data.datapendidikan[i].Pendidikan + '</option';
                    $("#hrd_Pendidikan").append(newRow);
                }
            }

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });

}
function getAgama() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getAgama',
        dataType: "json",
        success: function (data) {
            if (data.dataAgama !== null && data.dataAgama !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_agama").append(newRow);
                for (i = 0; i < data.dataAgama.length; i++) {
                    var newRow = '<option value="' + data.dataAgama[i].id + '">' + data.dataAgama[i].Agama + '</option';
                    $("#hrd_agama").append(newRow);
                }
            }

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });

}
function getStatusNikah() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getStatusNikah',
        dataType: "json",
        success: function (data) {
            if (data.dataMenikah !== null && data.dataMenikah !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#Hrd_statusNikah").append(newRow);
                for (i = 0; i < data.dataMenikah.length; i++) {
                    var newRow = '<option value="' + data.dataMenikah[i].id + '">' + data.dataMenikah[i].Status_Menikah + '</option';
                    $("#Hrd_statusNikah").append(newRow);
                }
            }

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });

}
function getUnit() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getUnit',
        dataType: "json",
        success: function (data) {
            if (data.dataUnit !== null && data.dataUnit !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_unitkerja").append(newRow); 
                for (i = 0; i < data.dataUnit.length; i++) {
                    var newRow = '<option value="' + data.dataUnit[i].id + '">' + data.dataUnit[i].Unit + '</option';
                    $("#hrd_unitkerja").append(newRow);
                }
            }

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });

}
function getDepartment() {
    var base_url = window.location.origin;
    var xdi = "1";
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/Pegawai/getDepartment',
        dataType: "json",
        success: function (data) {
            if (data.dataDepartment !== null && data.dataDepartment !== undefined) {
                console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#hrd_department").append(newRow);
                var elements = $();
                var dataarray = data.dataDepartment.length;
                for (i = 0; i < data.dataDepartment.length; i++) {
                    var newRow = '<option value="' + data.dataDepartment[i].id + '">' + data.dataDepartment[i].Department + '</option';
                    $("#hrd_department").append(newRow);
                }
            }

        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });

}
function getProvinsi() {
    var base_url = window.location.origin;
    $("#Medical_Provinsi").empty();
    $.ajax({
        type: "POST",
        url: base_url + '/pms_gut/public/Pegawai/getProvinsi', 
        dataType: "json",
        success: function (data) {
            if (data.getProvinsi !== null && data.getProvinsi !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- Pilih Provinsi --</option>';
                $("#Medical_Provinsi").append(newRow);
                for (i = 0; i < data.getProvinsi.length; i++) {
                    var newRow = '<option value="' + data.getProvinsi[i].PovinsiID + '">' + data.getProvinsi[i].ProvinsiNama + '</option';
                    $("#Medical_Provinsi").append(newRow);
                }
            } 
        }, error: function (data) {
            // Welcome notification
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
            toastr["error"](data.responseText);
        }
    });
}
