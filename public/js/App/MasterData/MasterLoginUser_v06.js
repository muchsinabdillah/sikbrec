$(document).ready(function () {
    const base_url = window.location.origin;
    getpegawai(); getDataUserAkses(); gethakskses(); gethaksksesJO(); getDataUserAksesJO();
    setTimeout(function () { ShowData(); }, 200);
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url +"/SIKBREC/public/MasterLoginUser/getAllUserLogin",
            "dataSrc": "",
            "type": "POST",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Username + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaLengkap + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaLengkap + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="showMasterLoginByID(' + row.ID + ')"  >View</button> | <button title="Show Data" type="button" class="btn btn-sm btn-warning" id="btn_showkasbon" onclick="showMasterHakAksesLoginByID(' + row.ID + ')"  >Hak Akses</button> '
                    return html
                },
            },
        ]
    });
   
});
function gethaksksesJO() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi, 
        url: base_url + '/pms_gut/public/JobOrder/getAllJobOrder',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value=""></option';
            $("#Mst_ID_Hak_AksesJO").append(newRow);
            var elements = $();
            var dataarray = data.length;
            for (i = 0; i < data.length; i++) {
                var newRow = '<option value="' + data[i].KD_LOKASI + '">' + data[i].KD_LOKASI + ' - ' + data[i].NM_CLIENT + '</option';
                $("#Mst_ID_Hak_AksesJO").append(newRow);
            }
            $('.js-example-basic-single').select2();

        }
    });
}
function deleteaksesJO(x) {
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/MasterLoginUser/DeleteHakAksesJObyUserID',
        data: "q=" + x,
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
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
            toastr["success"]("Hak Akses Berhasil Dihapus !");
            getDataUserAksesJO();
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
            $(".preloader").fadeOut();
        }
    });
}
function deleteakses(x) {
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/MasterLoginUser/DeleteHakAksesbyUserID',
        data: "q=" + x,
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
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
            toastr["success"]("Hak Akses Berhasil Dihapus !");
            getDataUserAkses();
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
            $(".preloader").fadeOut();
        }
    });
}

function go_saveHakAksesJO() {
    var base_url = window.location.origin;
    var IdTranasksi = $('#IdTranasksi').val();
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_ID_Pegawai = $('#Mst_ID_Pegawai').val();
    var Mst_ID_Hak_AksesJO = $('#Mst_ID_Hak_AksesJO').val();
    $.ajax({
        url: base_url + '/pms_gut/public/MasterLoginUser/CreateHakAksesJObyUserID',
        method: "POST",
        data: "IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto +
            "&Mst_ID_Pegawai=" + Mst_ID_Pegawai +
            "&Mst_ID_Hak_AksesJO=" + Mst_ID_Hak_AksesJO,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                $(".preloader").fadeOut();

            } else if (data.status == "success") {
                location.reload();
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
            $(".preloader").fadeOut();
        }
    });
}
function go_saveHakAkses() {
    var base_url = window.location.origin;
    var IdTranasksi = $('#IdTranasksi').val();
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_ID_Pegawai = $('#Mst_ID_Pegawai').val();
    var Mst_ID_Hak_Akses = $('#Mst_ID_Hak_Akses').val();  
    $.ajax({
        url: base_url + '/pms_gut/public/MasterLoginUser/CreateHakAksesbyUserID',
        method: "POST",
        data: "IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto +
            "&Mst_ID_Pegawai=" + Mst_ID_Pegawai +
            "&Mst_ID_Hak_Akses=" + Mst_ID_Hak_Akses,
        dataType: "JSON",
        beforeSend: function () {
            $(".preloader").fadeIn();
        },
        success: function (data) {
            console.log(data);
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
                $(".preloader").fadeOut();

            } else if (data.status == "success") {
                location.reload();
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
            $(".preloader").fadeOut();
        }
    });
}
function gethakskses() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "POST",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/MasterLoginUser/getDataSubMenu',
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Mst_ID_Hak_Akses").append(newRow);
            for (i = 0; i < data.getSubmenu.length; i++) {
                var newRow = '<option value="' + data.getSubmenu[i].id_submenu + '">' + data.getSubmenu[i].nama_submenu + '</option';
                $("#Mst_ID_Hak_Akses").append(newRow);
            }
            $('.js-example-basic-single').select2();

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
function getDataUserAksesJO() {
    var IdTranasksiAuto = $("#IdTranasksiAuto").val();
    var title = 'Jadwal Absensi';
    const base_url = window.location.origin;
    $('#tblHakAksesJO').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblHakAksesJO').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/MasterLoginUser/ShowListHakAksesJO",
            "type": "POST",
            data: function (d) {
                d.IdTranasksiAuto = IdTranasksiAuto;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.id + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KD_LOKASI + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NM_CLIENT + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {

                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="deleteaksesJO(' + row.id + ')"  >HAPUS</button>'
                    return html
                },
            },

        ],
    });
}
function getDataUserAkses() {
    var IdTranasksiAuto = $("#IdTranasksiAuto").val();
    var title = 'Jadwal Absensi';
    const base_url = window.location.origin;
    $('#tblHakAkses').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tblHakAkses').DataTable({
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + "/pms_gut/public/MasterLoginUser/ShowListHakAkses", 
            "type": "POST",
            data: function (d) {
                d.IdTranasksiAuto = IdTranasksiAuto;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.id + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.nama_menu + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.nama_submenu + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""



                    var html = '<button title="Show Data" type="button" class="btn btn-sm btn-success" id="btn_showkasbon" onclick="deleteakses(' + row.id + ')"  >HAPUS</button>'
                    return html
                },
            },

        ],
    });
}
function ShowData() {
    var x = $("#IdTranasksiAuto").val();
    const base_url = window.location.origin;
    if (x != '') {
        $.ajax({
            url: base_url +"/pms_gut/public/MasterLoginUser/getUserLoginbyId/",
            data: { id: x },
            type: "POST",
            cache: false,
            dataType: "JSON",
            success: function (data) {
                $("#IdTranasksi").val(data.ID);
                $('#Mst_ID_Pegawai').val(data.ID_Data).trigger('change');
                $("#Mst_Username").val(data.Username);
                $("#Mst_Username2").val(data.NamaLengkap);
                $("#Mst_Password").val(data.Password);
                $('#Mst_Status').val(data.Aktif).trigger('change');
                $('#Mst_Admin').val(data.Admin).trigger('change');
                 
                document.getElementById("Mst_ID_Pegawai").disabled = true;
            }
        });
    } else {

    }

}
function ShowAddHakAksesJO(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/MasterLoginUser/UserLoginHakAksesJO/' + str;
}
function showMasterHakAksesLoginByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/MasterLoginUser/UserLoginHakAkses/' + str;
}
function showMasterLoginByID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/pms_gut/public/MasterLoginUser/UserLoginForm/' + str;
}
function go_save() { 
    var IdTranasksi = $('#IdTranasksi').val();
    var IdTranasksiAuto = $('#IdTranasksiAuto').val();
    var Mst_ID_Pegawai = $('#Mst_ID_Pegawai').val();
    var Mst_Username = $('#Mst_Username').val();
    var Mst_Username2 = $('#Mst_Username2').val();
    var Mst_Password = $('#Mst_Password').val();
    var Mst_Status = $('#Mst_Status').val();
    var Mst_Admin = $('#Mst_Admin').val();
    const base_url = window.location.origin;
    $.ajax({
        url: base_url + "/pms_gut/public/MasterLoginUser/createUserLogin",
        method: "POST",
        data: "IdTranasksi=" + IdTranasksi + "&IdTranasksiAuto=" + IdTranasksiAuto +
            "&Mst_ID_Pegawai=" + Mst_ID_Pegawai +
            "&Mst_Username=" + Mst_Username +
            "&Mst_Username2=" + Mst_Username2 +
            "&Mst_Password=" + Mst_Password +
            "&Mst_Status=" + Mst_Status +
            "&Mst_Admin=" + Mst_Admin,
        dataType: "JSON",
        beforeSend: function () {
            $('#btnreservasi').html('Please Wait...');
            $('#btnreservasi').addClass('btn-danger');
            document.getElementById("btnreservasi").disabled = true;
        },
        success: function (data) {
            console.log(data);
            if (data.status == "warning") {
                swal(data.errorname);
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('SIMPAN');
                document.getElementById("btnreservasi").disabled = false;

            } else if (data.status == "success") {
                $('#btnreservasi').removeClass('btn-danger');
                $('#btnreservasi').html('SIMPAN');
                document.getElementById("form_cuti").reset();
                document.getElementById("btnreservasi").disabled = false;

                swal("Transaksi Berhasil Disimpan !")
                    .then((value) => {
                        const base_url = window.location.origin;
                        window.location = base_url + "/pms_gut/public/MasterLoginUser";
                    });

            }

        },
        error: function () {

            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('SIMPAN');
            document.getElementById("btnreservasi").disabled = false;
        }
    });
}
function myJsFunc() {
    swal({
        title: "Simpan",
        text: "Apakah Anda yakin Simpan User Login, Lanjutkan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                go_save();
            } else {
                swal("Transaction Rollback !");
            }
        });
}
function get_dataPegawai() {
    var x = document.getElementById("Mst_ID_Pegawai").value;
    console.log(x);
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/Pegawai/getdataPegawaibyID',
        data: "q=" + x,
        type: "POST",
        cache: false,
        dataType: "JSON",
        success: function (data) {
            $("#Mst_Username2").val(data.Nama);
            //$("#hrd_department").val(data.Departemen); 
            console.log(data.Nama);

        },
        error: function () {
            new PNotify({
                title: 'Notifikasi',
                text: 'Data Tidak Dapat Diproses, Hubungi IT !',
                type: 'danger'
            });
            $('#savetrs').removeClass('btn-danger');
            $('#savetrs').html('Simpan');
            document.getElementById("savetrs").disabled = false;

            document.getElementById("close").disabled = false;
        }
    });
}
function getpegawai() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + "/pms_gut/public/Pegawai/getpegawaiAllAktif/",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Mst_ID_Pegawai").append(newRow);
            var elements = $();
            var dataarray = data.data.getpegawai.length;
            for (i = 0; i < data.data.getpegawai.length; i++) {
                var newRow = '<option value="' + data.data.getpegawai[i].ID_Data + '">' + data.data.getpegawai[i].Nama + '</option';
                $("#Mst_ID_Pegawai").append(newRow);
            }
            $('.js-example-basic-single').select2();

        }
    });
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/MasterLoginUser";
}
 
function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/pms_gut/public/MasterLoginUser/UserLoginForm";
}