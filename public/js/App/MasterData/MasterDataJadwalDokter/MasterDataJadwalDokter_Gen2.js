$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut(); 
    $('#btnLoadJadwal').attr('enabled', true);
    $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadJadwal', function () {
        getDataListJadwalDokter();
    });
 });

function getDataListJadwalDokter() {
    let GrupPerawatan,Poli;
    GrupPerawatan = $("#GrupPerawatan").val();
    Poli = $("#Poli").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
            "url": base_url + "/SIKBREC/public/MasterDataJadwalDokter/getAllDataJadwalDokterr", // URL file untuk proses select datanya
            "type": "POST",
            data: function ( d ) {
                d.GrupPerawatan = GrupPerawatan;
                d.Poli = Poli;
            },
             "dataSrc": "",
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
                    var html = '<font size="1"> ' + row.NamaDokter + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Poli + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Senin_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Selasa_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Rabu_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Kamis_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Jumat_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Sabtu_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Minggu_Waktu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Note + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Group_Jadwal + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Status_Aktif + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="showDataGroupShift(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                },
            }, 
        ]
    });
}
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterDataJadwalDokter/viewJadwalDokter/' + str;
}

async function asyncShowMain() {
    try { 
        const datagetGrupPerawatan = await getGrupPerawatan(); 
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
    
    } catch (err) {
        toast(err, "error")
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataDokter";
}