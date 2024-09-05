$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut();

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
 
    var Periode = document.getElementById("Periode").value;
    var JenisPasien = document.getElementById("JenisPasien").value; 
    var JenisRekap = document.getElementById("JenisRekap").value; 

    if (JenisRekap == '3') {
       
        window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist4/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;
    }
    else if (JenisRekap == '2') {
        window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist3/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;

} else if (JenisRekap == '4') {
    window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist5/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;
} else if (JenisRekap == '6') {
    window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist6/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;
} else if (JenisRekap == '7') {
    window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist6/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;
}else{
    window.location = base_url + "/SIKBREC/public/ExcelInfoDetailRegist/ExcelInfoDetailRegist2/" + Periode + "/" + JenisPasien + "/" + JenisRekap ;
}
}

function clearVal() {
    $("#JenisTipe").val('');
}

function chageV(val) {

    //let id = $(val).attr('id');
    let value = $(val).val();
    let JenisRekap = $("#JenisRekap").val();
    //console.log(id);return false;
    if (value == '1') {//jika milih pivot per dokter
        if (JenisRekap == '1') {
            $("#GrupPerawatan").attr('disabled', true);
            $("#NamaDokter").attr('disabled', false);
        } else if (JenisRekap == '2') {
            $("#GrupPerawatan").attr('disabled', false);
            $("#NamaDokter").attr('disabled', true);
        }
    } else {
        $("#GrupPerawatan").attr('disabled', true);
        $("#NamaDokter").attr('disabled', true);
    }


}

function CheckVar() {
    //if not in creteria return false
    if ($("#Periode").val() == '') {
        toast('Isi Periode', "warning");
        return false;
    }
    if ($("#JenisPasien").val() == '') {
        toast('Isi Jenis Pasien', "warning");
        return false;
    }
    if ($("#JenisRekap").val() == '') {
        toast('Isi Rekap', "warning");
        return false;
    }

    //if True, get data
    getDataListPasien();
}


function getDataListPasien() {
    let Periode, JenisPasien, JenisRekap;
    Periode = $("#Periode").val();
    JenisPasien = $("#JenisPasien").val();
    JenisRekap = $("#JenisRekap").val();
    var base_url = window.location.origin;
    $('#datatable_Rujukan').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_unit').dataTable({
        "bDestroy": true
    }).fnDestroy();


    if (JenisRekap == '3') {

        $('#datatable_Rujukan').show()
        $('#datatable').hide()
        $('#datatable_unit').hide()
        $('#datatable_unit_only').hide()
        $('#datatable_perusaahn_only').hide()
        $('#datatable_Rujukan').DataTable().clear().destroy();
        $('#datatable_Rujukan').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "paging": false,
            "searching": false,
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekap", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable_Rujukan").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },
                { "data": "NamaRujukan" },
                { "data": "NamaUNIT" },
                { "data": "NamaDokter" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    }

    else if (JenisRekap == '2') {

        $('#datatable_Rujukan').hide()
        $('#datatable').hide()
        $('#datatable_unit').show()
        $('#datatable_perusaahn_only').hide()
        $('#datatable_unit_only').hide()
        $('#datatable_unit').DataTable().clear().destroy();
        $('#datatable_unit').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "paging": false,
            "searching": false,
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekap", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },
                { "data": "NamaUNIT" },
                { "data": "NamaDokter" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    } else if (JenisRekap == '4') {
        $('#datatable_Rujukan').hide()
        $('#datatable_unit_only').show()
        $('#datatable_unit').hide()
        $('#datatable_perusaahn_only').hide()
        $('#datatable').hide()
        $('#datatable_unit_only').DataTable().clear().destroy();
        $('#datatable_unit_only').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": false,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekapOnlyUnit", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },

                { "data": "NamaUNIT" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    } else if (JenisRekap == '6') {
        $('#datatable_Rujukan').hide()
        $('#datatable_perusaahn_only').show()
        $('#datatable_unit').hide()
        $('#datatable_unit_only').hide()
        $('#datatable').hide()
        $('#datatable_perusaahn_only').DataTable().clear().destroy();
        $('#datatable_perusaahn_only').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": false,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekap", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },

                { "data": "NamaUNIT" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    } else if (JenisRekap == '7') {
        $('#datatable_Rujukan').hide()
        $('#datatable_perusaahn_only').show()
        $('#datatable_unit').hide()
        $('#datatable_unit_only').hide()
        $('#datatable').hide()
        $('#datatable_perusaahn_only').DataTable().clear().destroy();
        $('#datatable_perusaahn_only').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": false,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekap", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },

                { "data": "NamaUNIT" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    } else {
        $('#datatable_Rujukan').hide()
        $('#datatable').show()
        $('#datatable_unit').hide()
        $('#datatable_unit_only').hide()

        $('#datatable').DataTable().clear().destroy();
        $('#datatable').DataTable({
            "ordering": true, // Set true agar bisa di sorting
            "order": [[0, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "paging": false,
            "searching": false,
            "ajax":
            {
                "url": base_url + "/SIKBREC/public/bInformationDetilRegistrasi/getDataListRekap", // URL file untuk proses select datanya
                "type": "POST",
                data: function (d) {
                    d.Periode = Periode;
                    d.JenisPasien = JenisPasien;
                    d.JenisRekap = JenisRekap;

                },
                error: function (xhr, error, code) {
                    toast('Error! Data Not Found!', "error")
                    $("#datatable").hide();
                },
                "dataSrc": "",
                "deferRender": true,
            },
            "columns": [
                { "data": "no", render: $.fn.dataTable.render.number('', '', 0, '') },

                { "data": "NamaDokter" },
                { "data": "01" },
                { "data": "02" },
                { "data": "03" },
                { "data": "04" },
                { "data": "05" },
                { "data": "06" },
                { "data": "07" },
                { "data": "08" },
                { "data": "09" },
                { "data": "10" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
                { "data": "15" },
                { "data": "16" },
                { "data": "17" },
                { "data": "18" },
                { "data": "19" },
                { "data": "20" },
                { "data": "21" },
                { "data": "22" },
                { "data": "23" },
                { "data": "24" },
                { "data": "25" },
                { "data": "26" },
                { "data": "27" },
                { "data": "28" },
                { "data": "29" },
                { "data": "30" },
                { "data": "31" },
                { "data": "total" },
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5'
            ]
        });

    }
}


async function asyncShowMain() {
    try {

        const datagetGrupPerawatan = await getGrupPerawatan();
        const datagetDokterAllAktif = await getDokterAllAktif();
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        updateUIgetDokterAllAktif(datagetDokterAllAktif);

    } catch (err) {
        toast(err, "error")
    }
}

async function getIDPenjamin() {
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
/*
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
*/
function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
    return fetch(url, {
        method: 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
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
            $("#GrupPerawatan").select2();
        })
}

function updateUIgetDokterAllAktif(datagetDokterAllAktif) {
    let data = datagetDokterAllAktif;
    if (data !== null && data !== undefined) {
        $("#NamaDokter").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaDokter").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].First_Name + '</option';
            $("#NamaDokter").append(newRow);
        }
    }
}

function getDokterAllAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/bInformationRekamMedik/getIDDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
        //body: 'idpoli=' + $("#GrupPerawatan").val()
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
            $("#NamaDokter").select2();
        })
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