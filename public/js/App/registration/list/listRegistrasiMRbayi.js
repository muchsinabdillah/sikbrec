$(document).ready(function () {
    $(".preloader").fadeOut(); 
    getDataListMRbayi();
     onLoadFunctionAll();
    //  asyncShowMain();

    //  showID();

$('#Medical_Provinsi').change(function () {
    //Some code
    $("#Medrec_kabupaten").empty();
    var newRow = '<option value="">-- Pilih Kabupaten --</option';
    $("#Medrec_kabupaten").append(newRow);
   // $("#Medrec_kabupaten").select2();

    $("#Medrec_Kecamatan").empty();
    var newRow = '<option value="">-- Pilih Kecamatan --</option';
    $("#Medrec_Kecamatan").append(newRow);
   // $("#Medrec_Kecamatan").select2();

    $("#Medrec_Kelurahan").empty();
    var newRow = '<option value="">-- Pilih Kelurahan --</option';
    $("#Medrec_Kelurahan").append(newRow);
    //$("#Medrec_Kelurahan").select2();
    var Medrec_NoMR = $("#Medrec_NoMR").val();
    console.log("datamr",Medrec_NoMR)
    //  if (Medrec_NoMR == ""){ 
        //showGetKabupaten();
    // }else{
        var xdi = document.getElementById("Medical_Provinsi").value;
        showGetKabupaten(xdi);
    //}
});

$('#Medrec_kabupaten').change(function () {
    var xdi = document.getElementById("Medrec_kabupaten").value;
    showGetKecamatan(xdi);
});
$('#Medrec_Kecamatan').change(function () {
    var xdi = document.getElementById("Medrec_Kecamatan").value;
    showGetKelurahan(xdi);
});
$('#Medrec_Kelurahan').change(function () {
    var xdi = document.getElementById("Medrec_Kelurahan").value;
    showGetKodePos(xdi);
});
$(document).on('click', '#simapnMR', function () {
    var y = 'simpan';
    //simpanMR(y);
    var email = $("#Medrec_Email").val();
    if (validateEmail(email)){
            simpanMR(y);
    }else{
            // new PNotify({
            //         title: 'Notifikasi',
            //         text: 'Format Email Tidak Sesuai! Mohon Input Sesuai Format Email Yang Benar!',
            //         type: 'danger'
            // });
            toast('Format Email Tidak Sesuai! Mohon Input Sesuai Format Email Yang Benar!', "error")
    }
});
$(document).on('click', '#simapnMRx', function () {
    
    var y = 'lanjutsimpan';
    simpanMR(y);
});
$(document).on('click', '#print_kartumr', function () {
    var param = $("#Medrec_NoMR").val();
    PrintKartuMR(param);
});
$(document).on('click', '#logopasienumum', function () {
    $('#CekkepesertaanBPJS').hide();
    $('#Notif_awal_registrasi').modal('hide');
    // $('#modalPendaftaranRanap').modal('show');
    $('#modal_regist_ranap').appendTo("body").modal('show');
    asyncShowMain();

    var jenisdaftar = "1"; // umum
    $('#PasienJenisDaftar').val(jenisdaftar);
    $('#PasienNoMR').focus();
    // showID(str);
}); 
$(document).on('click', '#logopasienbpjs', function () {
    $('#CekkepesertaanBPJS').show();
    $('#Notif_awal_registrasi').modal('hide');
    // $('#modalPendaftaranRanap').modal('show');
    $('#modal_regist_ranap').appendTo("body").modal('show');
    asyncShowMain();
    //$('#modal_VerifBPJS').modal('show');
    $('#modal_BPJSCekPesertaa').modal('show');
    var jenisdaftar = "2"; // umum
    $('#PasienJenisDaftar').val(jenisdaftar);
    $('#PasienNoMR').focus();
    // showID(str);
});
$('#TipePenjamin').change(function () {
    let typatient = $("#TipePenjamin").val();
    getIDPenjamin(typatient);
});
$('#savetrs').click(function () {
    if ($("#NoREGRI").val() == ''){
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Registrasi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                        goCreateRegistrasi();
                } else {
                   // swal("Transaction Rollback !");
                }
            });
    }else{
        swal("Alasan Edit:", {
            content: "input",
            buttons:true,
          })
          .then((value) => {
              if (value == '' ){
                swal("Alasan Edit Harus Diisi ! Simpan Gagal !");
                return false;
              }else if (value == null){
                return false;
              }
           // swal(`You typed: ${value}`);
           goUpdateRegistrasi(value);
          });
    }
});
});

async function onLoadFunctionAll() {
    try{
        const datagetProvinsi =  await getProvinsi();
        updateUIgetProvinsi(datagetProvinsi);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}

function getDataListMRbayi() { 
    var base_url = window.location.origin;
    $('#example').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#example').DataTable({
           "searching" : true,
            "pagging": true,
            "processing": true, 
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
            "url": base_url + "/SIKBREC/public/aRegistrasiMRBayi/getDataListMRbayi", // URL file untuk proses select datanya
               "type": "POST", 
                "deferRender": true,
            }, 
            "columns": 
            [
                { "data": "ID" },  
                { "data": "NoMR_Ibu" },  
                { "data": "NoRegistrasi_Ibu" },  
                { "data": "Nama_Ibu" },  
                { "data": "Nama_Bayi" },  
                { "data": "Ruang_Rawat_Asal_Bayi" },  
                { "data": "Ruang_Rawat_Tujuan_Bayi" },  
                {
                    "render": function (data, type, row) {
                        var html = ""
                        var html = '<button title="Registrasi type="button" class="btn btn-primary" id="btn_directkamar" onclick=\'showMedicalRecordbyId("'+row.ID+'")\' > <span class="glyphicon glyphicon-log-in"></span></button>';
                        return html
                    }
                },
            ],
       });
} 

async function showMedicalRecordbyId(xTempMr) {
   
        try {
       
        $(".preloader").fadeIn();
        $("#ModalInputMRBAru").modal('show');
        //var xTempMr = $("#PasienNoMR").val();-------
        if (xTempMr != "") {
            const dataGetMedicalRecordbyId = await GetMedicalRecordbyId(xTempMr);
            updateUIGetMedicalRecordbyId(dataGetMedicalRecordbyId);
        }else{
            $("#Medrec_kabupaten").select2();
            $('#Medrec_Kecamatan').select2();
            $('#Medrec_Kelurahan').select2();
        }
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
async function updateUIGetMedicalRecordbyId(dataGetMedicalRecordbyId) {
    let data = dataGetMedicalRecordbyId;
    $("#ID_MRPermintaaBayi").val(data.ID);
    $("#Medrec_NoMR").val(data.NoMR);
    $("#Medrec_NamaPasien").val(data.PatientName);
    $("#Medical_JKel").val(data.Gander);
    $("#Medrec_Tgl_Lahir").val(data.Date_of_birth);
    $("#Medrec_Alamat").val(data.Address);
    $("#Medrec_NoIdPengenal").val(data.ID_Card_number);
    $("#Medrec_Tpt_lahir").val(data.BirthPlace);
    $("#Medrec_Pekerjaan").val(data.Ocupation);
    $('#Medical_Provinsi').val(data.Medical_Provinsi).trigger('change');
    $("#Medrec_Warganegara").val(data.Medrec_Warganegara);
    $("#Medrec_HomePhone").val(data.Medrec_HomePhone);
    $("#Medrec_handphone").val(data.Medrec_handphone);
    $("#Medical_Agama").val(data.Medical_Agama);
    $("#Medrec_statusNikah").val(data.Medrec_statusNikah);
    $("#Medrec_Pendidikan").val(data.Medrec_Pendidikan);
    $("#Medrec_Email").val(data.Medrec_Email);
    $("#Medrec_Status").val(data.Medrec_Status);
    $("#Medrec_NamaIbuKandung").val(data.Mother);
    $("#Medrec_Ibu_Kandung").val(data.NoMR_IBU);
    $("#Medrec_Kodepos").val(data.kodepos);
    $("#Medrec_DaruratNama").val(data.Contact_Name);
    $("#Medrec_DaruratAlamat").val(data.CONTACT_PHONE);
    $("#Medrec_DaruratTlp").val(data.Contact_Address);
    $("#Medrec_DaruratHub").val(data.CONTACT_STATUS);
    $("#Medrec_PerusahaanNama").val(data.Office_Name);
    $("#Medrec_PerusahaanAlamat").val(data.Office_Address);
    $("#Medrec_PerusahaanTlp").val(data.Office_Phone);
    $("#Medrec_PerusahaanFax").val(data.Office_Fax);
    $("#petugasupdate").val(data.Petugas_Update);
   // $("#jamupdate").val(data.UpdateDate.date);
    $("#Medrec_Bahasa").val(data.Bahasa);
    $("#Medrec_IdPengenal").val(data.Tipe_Idcard);
    $("#Medrec_Etnis").val(data.Etnis);
    $("#Medrec_NamaIbuKandung").val(data.Nama_Ibu);
    $("#Medrec_Bin").val(data.Father);
    document.getElementById("petugasupdate").innerHTML = data.Petugas_Update;
    document.getElementById("jamupdate").innerHTML = data.UpdateDate;
    document.getElementById("petugasinput").innerHTML = data.petugasinput;
    document.getElementById("jaminput").innerHTML = data.jaminput;
    await showGetKabupaten(data.Medical_Provinsi);
    await showGetKecamatan(data.Medrec_kabupaten);
    await showGetKelurahan(data.Medrec_Kecamatan);
    $('#Medrec_Kecamatan').val(data.Medrec_Kecamatan)//.trigger('change');
    $('#Medrec_kabupaten').val(data.Medrec_kabupaten)//.trigger('change');
    $('#Medrec_Kelurahan').val(data.Medrec_Kelurahan)//.trigger('change');
    await showDataArsipRawatJalan(data.NoMR);
    await showDataArsipRawatInap(data.NoMR);

    $("#Medrec_kabupaten").select2();
    $('#Medrec_Kecamatan').select2();
    $('#Medrec_Kelurahan').select2();
}
function GetMedicalRecordbyId(xTempMr) {
   
    var base_url = window.location.origin;
    // var iswalkin = $("#iswalkin").val();
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/GetMedicalRecordbyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + xTempMr
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

        })
}
async function showGetKabupaten(xdi) {
    try{
    //  var xdi = document.getElementById("Medical_Provinsi").value;
        const dataGetKabupaten = await GetKabupaten(xdi);
        console.log("datakabupaten",dataGetKabupaten)
        updateUIGetKabupaten(dataGetKabupaten);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKabupaten(dataGetKabupaten) {
    let responseApi = dataGetKabupaten;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data); 
        $("#Medrec_kabupaten").empty();
        var newRow = '<option value="">-- Pilih Kabupaten --</option';
        $("#Medrec_kabupaten").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].kabupatenId + '">' + responseApi.data[i].kabupatenNama + '</option';
            $("#Medrec_kabupaten").append(newRow);

        }
    }
}

function GetKabupaten(data) {
    // console.log(data);
    // exit;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/GetKabupaten';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
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
           $("#Medrec_kabupaten").select2();
        })
}
async function showGetKecamatan(data) {
    try{
        const dataGetKecamatan = await GetKecamatan(data);
        console.log("datakecamatan", dataGetKecamatan)
        updateUIGetKecamatan(dataGetKecamatan);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKecamatan(dataGetKecamatan) {
    let responseApi = dataGetKecamatan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        $("#Medrec_Kecamatan").empty();
        var newRow = '<option value="">-- Pilih Kecamatan --</option';
        $("#Medrec_Kecamatan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].kecamatanId + '">' + responseApi.data[i].Kecamatan + '</option';
            $("#Medrec_Kecamatan").append(newRow);

        }
    }
}
function GetKecamatan(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/GetKecamatan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
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
            //$("#Medrec_kabupaten").select2();
        })
}

async function showGetKodePos(data) {
    try{
        const dataGetKodePos = await GetKodePos(data); 
        updateUIGetKodePos(dataGetKodePos);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKodePos(dataGetKodePos) {
    let responseApi = dataGetKodePos;
    $("#Medrec_Kodepos").val(responseApi.kodepos);
}
function GetKodePos(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/GetKodepos';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
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
            $("#Medical_Provinsi").select2();
        })
}
async function showGetKelurahan(data) {
    try{
        const dataGetKelurahan = await GetKelurahan(data);
        console.log("datakecamatan", dataGetKelurahan)
        updateUIGetKelurahan(dataGetKelurahan);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIGetKelurahan(dataGetKelurahan) {
    let responseApi = dataGetKelurahan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        $("#Medrec_Kelurahan").empty();
        var newRow = '<option value="">-- Pilih Kelurahan --</option';
        $("#Medrec_Kelurahan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].desaId + '">' + responseApi.data[i].Kelurahan + '</option';
            $("#Medrec_Kelurahan").append(newRow);

        }
    }
}
function GetKelurahan(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/GetKelurahan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
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
            $("#Medical_Provinsi").select2();
        })
}
function getProvinsi() {
    // console.log('xxxxxxx');
    // exit;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/getProvinsi';
    return fetch(url, {
        method: 'POST',
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
            $("#Medical_Provinsi").select2();
        })
}
function updateUIgetProvinsi(datagetProvinsi) {
    let responseApi = datagetProvinsi;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Medical_Provinsi").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].PovinsiID + '">' + responseApi.data[i].ProvinsiNama + '</option';
            $("#Medical_Provinsi").append(newRow);
            
        }
    }
    
}

function showDataArsipRawatJalan(params) {
    var base_url = window.location.origin;
    $('#tbl_arsip_rajal').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_arsip_rajal').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aMedicalRecord/getArsipRawatJalan",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.myKey = params;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoRegistrasi + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoMR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.TglKunjungan + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaUnit + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.TipePasien + ' - '+row.namapenjamin+' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.StatusName + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.diagnosa + ' </font>  ';
                    return html
                }
            },
             
        ]
    });
}
function showDataArsipRawatInap(params) {
    var base_url = window.location.origin;
    $('#tbl_arsip_ranap').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_arsip_ranap').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aMedicalRecord/getArsipRawatInap",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.myKey = params;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoMR + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PatientName + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NoRegRI + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.StartDate + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.EndDate + ' </font>  ';
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
                    var html = '<font size="1"> ' + row.JenisPasien + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NamaKelas + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.namapenjamin + ' </font>  ';
                    return html
                }
            },

        ]
    });
}
async function showID(str) {
    try {   
        const datagetStatusRegRajal = await getStatusRegRajal(str);;
        updateUIdatagetStatusRegRajal(datagetStatusRegRajal);
    
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetStatusRegRajal(datagetStatusRegRajal) {
        let response = datagetStatusRegRajal;
        if (response.status == "success") {
            //toast(response.message, "success")
            const base_url = window.location.origin;
            var str = btoa(response.idspr);
            window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
        }else{
            toast(response.message, "error")
        }  
    }

function getStatusRegRajal(str) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getStatusRegRajal/';
    return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + str
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.statusText)
        }
        return response.json();
    })
    .then(response => {
        
        //console.log(response)
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

    })/*.catch((err) =>{
        console.log(err, "error")
        console.log(err,'aaa');
        toast(err,"error")
    })*/
}
async function simpanMR(params) { 
    try {
        const responsePost = await CreateMedicalRecord(params);
        updateUICreateMedicalRecord(responsePost);
        // const datagetStatusRegRajal = await getStatusRegRajal(str);;
        // updateUIdatagetStatusRegRajal(datagetStatusRegRajal);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUICreateMedicalRecord(responsePost){
    let data = responsePost;
    if (data.status == "warning") {
        new PNotify({
            title: 'Notifikasi',
            text: data.errorname,
            type: 'danger'
        });
    } else if (data.status == "success") { 
        toast("Rekam Medik Berhasil disimpan !", "success")
        $("#PasienNoMR").val(data.NoMR);
        $("#PasienNama").val(data.PatientName);
        $("#PasienAlamat").val(data.Address);
        $("#PasienIdJKel").val(data.Gander);
        //$("#PasienNamaJKel").val(data.NoEpisode); 
        $("#PasienTptLahir").val(data.TptLahir);
        $("#PasienTglLahir").val(data.Date_of_birth);
        $("#PasienPekerjaan").val(data.Pekerjaan);
        $("#PasienNIK").val(data.NIK);
        $("#NoHpBPJS").val(data.NoHp);
        const base_url = window.location.origin;

        //Update Status Regist di MR_PermintaanMR_Bayi
        // goUpdateStatuss();
       //update status regis
       var idpermintaan = $("#ID_MRPermintaaBayi").val();
       UpdateStatusRegis(idpermintaan);
        

        var str= btoa($("#ID_MRPermintaaBayi").val());
        var str2= btoa(data.NoMR);
        window.location = base_url + '/SIKBREC/public/aRegistrasiMRBayi/goRegistrasi/' + str + '/' +str2;
        // document.getElementById("CloseMeC").click();
        // document.getElementById("CloseMeMR").click();
        //$('#ModalInputMRBAru').modal('hide');
        //$('#Notif_awal_registrasi').appendTo("body").modal('show');


        document.getElementById("FRMcreatemr").reset();
    } else if (data.status == "update") {
        toast("Rekam Medik Berhasil dirubah !", "success")
        document.getElementById("CloseMeC").click();
        document.getElementById("CloseMeMR").click();
        document.getElementById("FRMcreatemr").reset();
        //$('#Notif_awal_registrasi').appendTo("body").modal('show');


       // showIDMxR();
    } else if (data.status == "double") { 
        toast("Ada Kemiripan Data, Pastikan Data yang anda input belum ada di Sistem, agar tidak Dobel Rekam Medik!", "error")
        //$('#ModalInputMRBAru').modal('hide');
        $('#modalcariDataMRSave').appendTo("body").modal('show');
        //$('#Notif_awal_registrasi').appendTo("body").modal('show');

        // $('#modalcariDataMRSave').modal('show');
        var dataHandler = $("#user_data");
        dataHandler.html("");
        //var resultObj = JSON.parse(result);
        if ($('#totalrow').val() == 0) {
            var count = 0;
        } else {
            var count = parseFloat($('#totalrow').val());
        }
        $.each(data.data.datarekammedik, function (key, val) {
            countx = count + 1;
            var newRow = $("<tr  id='row_" + count + "'>");
            newRow.html("<td><font size='1'>" + val.NoMR + "</td><td><font size='1'>" + val.PatientName + "</td><td><font size='1'>" + val.Address + "</td><td><font size='1'>" + val.tgl_lahir.date + "</td> <td><font size='1'>" + val.Mother + "<br> Tlp Rumah : " + val.tlprumah + "<br> Tlp Hp : " + val.hp + "</td>  <td><font size='1'>" + val.ID_Card_number + "</td>   </tr>");
            dataHandler.append(newRow);
        });
        $('#totalrow').val(countx);


    }
}
function UpdateStatusRegis(data){
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/goUpdateStatus';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: "q=" + data

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
        // $("#Kelas").select2(); 
    })
}
async function goUpdateStatuss() {
    try{
        const datagoUpdateStatus =  await getUpdateStatus();
        goUpdateStatus(datagoUpdateStatus);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function goUpdateStatus() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/goUpdateStatus';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    //body: 'id=' + $("#IdAuto").val()
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
        // $("#Kelas").select2(); 
    })
}
function CreateMedicalRecord(params) {
    $(".preloader").fadeIn();
    var dtForm = $("#FRMcreatemr").serialize();
    // var iswalkin = $("#iswalkin").val();
   // console.log(iswalkin,'sssfffffffffffffff');
   var ProvinsiNama = $('#Medical_Provinsi option:selected').text();
   var kabupatenNama = $('#Medrec_kabupaten option:selected').text();
   var Kecamatan = $('#Medrec_Kecamatan option:selected').text();
   var Kelurahan = $('#Medrec_Kelurahan option:selected').text();
    let jenisCreate = params;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiMRBayi/CreateMedicalRecord&q=' + jenisCreate;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: dtForm +"&iswalkin=" +iswalkin
        + "&ProvinsiNama=" + ProvinsiNama 
            + "&kabupatenNama=" + kabupatenNama 
            + "&Kecamatan=" + Kecamatan 
            + "&Kelurahan=" + Kelurahan 
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
            $(".preloader").fadeOut();
            //$('#btnreservasi').removeClass('btn-danger');
            //$('#btnreservasi').html('Submit');
            //document.getElementById("btnreservasi").disabled = false;
        })
    
}
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  function updateUIdatagetStatusRegRajal(datagetStatusRegRajal) {
    let response = datagetStatusRegRajal;
    if (response.status == "success") {
        //toast(response.message, "success")
        const base_url = window.location.origin;
        var str = btoa(response.NoMR_Ibu);
        window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
    }else{
        toast(response.message, "error")
    }  
}

function getStatusRegRajal(str) {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getStatusRegRajal/';
return fetch(url, {
method: 'POST',
headers: {
    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
},
body: 'id=' + str
})
.then(response => {
    if (!response.ok) {
        throw new Error(response.statusText)
    }
    return response.json();
})
.then(response => {
    
    //console.log(response)
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

})/*.catch((err) =>{
    console.log(err, "error")
    console.log(err,'aaa');
    toast(err,"error")
})*/
}
async function asyncShowMain() {
    try {   
        const datagetGroupJaminan = await getLoadGroupJaminan();
        const datagetNamaPenjamin = await getNamaPenjamin();
        const datagetDokterAllAktif =  await getDokterAllAktif();
        const datagetNamaCaraMasuk = await getNamaCaraMasuk();
        const datagetKelas = await getKelas();
        const datagetDataSPRDetail =  await getDataSPRDetail();
        updateUIgetLoadGroupJaminan(datagetGroupJaminan);
        updateUIgetNamaPenjamin(datagetNamaPenjamin);
        updateUIgetDokterAllAktif(datagetDokterAllAktif);
        updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk);
        updateUIgetKelas(datagetKelas);
        updateUIgetDataSPRDetail(datagetDataSPRDetail);
        // await showModalJenisReg();
        getCOB();
    } catch (err) {
        toast(err, "error")
    }
}

async function updateUIgetDataSPRDetail(datagetDataSPRDetail) {
let dataResponse = datagetDataSPRDetail;
$("#IdAuto").val(convertEntities(dataResponse.data.ID));
$("#NoMR").val(convertEntities(dataResponse.data.NoMR));
$("#NamaPasien").val(convertEntities(dataResponse.data.PatientName));
$("#JenisRawat").val(convertEntities(dataResponse.data.JenisRawat)).trigger('change');
$("#NamaDokter").val(convertEntities(dataResponse.data.ID_Dokter)).trigger('change');
$("#NikPasien").val(convertEntities(dataResponse.data.ID_Card_number));
$("#AlamatPasien").val(convertEntities(dataResponse.data.Address));
$("#NoEpisode").val(convertEntities(dataResponse.data.NoEpisode));
$("#NoREGRI").val(convertEntities(dataResponse.data.NoRegRI));
$("#pxNoteRegistrasi").val(convertEntities(dataResponse.data.Note));
$("#DOB").val(convertEntities(dataResponse.data.DOB));
$("#NoRegistrasi").val(convertEntities(dataResponse.data.NoRegistrasi));
$("#NoEpisodeRWJ").val(convertEntities(dataResponse.data.noepisode_rwj));
    if(dataResponse.data.NoRegRI != null)// if not null then update reg
    {
        $("#TipePenjamin").val(convertEntities(dataResponse.data.TypePatient)).trigger('change');
        $("#caramasuk").val(convertEntities(dataResponse.data.idCaraMasuk)).trigger('change');
        await getIDPenjamin(convertEntities(dataResponse.data.TypePatient));
        await getreferal(convertEntities(dataResponse.data.idCaraMasuk));
        $("#NamaPenjamin").val(convertEntities(dataResponse.data.idperusahaan));
        $("#referral").val(convertEntities(dataResponse.data.idCaraMasuk2));
        $("#Paket").val(convertEntities(dataResponse.data.Paket)).trigger('change');
        $("#Kelas").val(convertEntities(dataResponse.data.KlsID)).trigger('change');
        $("#COB").val(convertEntities(dataResponse.data.KodeJaminanCOB)).trigger('change');
        $("#NoSEP").val(convertEntities(dataResponse.data.NoSEP));
        ActiveSEP(dataResponse.data.idperusahaan);
    }
    $("#NamaPenjamin").select2();
    $("#referral").select2();
    $(".preloader").fadeOut();
    getidnamajaminan();
}
function getDataSPRDetail() {
var base_url = window.location.origin;
var noregri = $("#NoREGRI").val();
var id = $("#IdAuto").val();
let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getDataSPRDetail/';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + id + '&noregri=' + noregri
})
    .then(response => {
        if (!response.ok) {
            throw new Error(response.statusText)
        }
        return response.json();
    })
    .then(response => {
        //console.log(response)
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
        $("#TipePenjamin").select2();
        $("#JenisRawat").select2();
        $("#Paket").select2();
       // $(".preloader").fadeOut(); 
    }).catch((err) =>{
        console.log(err, "error")
    })
}

function updateUIgetLoadGroupJaminan(datagetGroupJaminan) {
let responseApi = datagetGroupJaminan;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#TipePenjamin").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].TipePasien + '</option';
        $("#TipePenjamin").append(newRow);
    }
}
}

function getLoadGroupJaminan() {
var getidPoliKlinik = "1";
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getAllGroupJaminan';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + getidPoliKlinik
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
        $("#TipePenjamin").select2();
    })
}

async function getIDPenjamin(x) {
try {
    const datagetNamaPenjamin = await getNamaPenjamin(x);
    updateUIgetNamaPenjamin(datagetNamaPenjamin);
    /*
    if ($("#NoREGRI").val() != ''){
        $("#NamaPenjamin").val(convertEntities(x));
        ActiveSEP(x);
    }
    */
} catch (err) {
    toast(err, "error")
}
}

async function getreferal(x) {
try{
    const dataGetRefferalByIdGroup = await GetRefferalByIdGroup(x);
    //console.log("dataGetRefferalByIdGroup", dataGetRefferalByIdGroup);
    updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup);
    
} catch (err) {
    toast(err, "error")
}
}

function updateUIgetNamaPenjamin(datagetNamaPenjamin) {
let responseApi = datagetNamaPenjamin; 
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

function getNamaPenjamin(x) {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'tp_penjamin=' + x//$("#TipePenjamin").val()
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
        //$("#NamaPenjamin").select2();
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

function updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk) {
let responseApi = datagetNamaCaraMasuk;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#caramasuk").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].id + '">' + responseApi.data[i].NamaCaraMasuk + '</option';
        $("#caramasuk").append(newRow);
    }
}
}
function getNamaCaraMasuk() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataReferal/getNamaCaraMasuk';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    //body: 'id=' + $("#IdAuto").val()
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
        $("#caramasuk").select2(); 
    })
}

function updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup) {
let responseApi = dataGetRefferalByIdGroup;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    $("#referral").empty();
    var newRow = '<option value="">-- PILIH --</option';
    $("#referral").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaCaraMasukRef + '</option';
        $("#referral").append(newRow);
    }
    //$("#referral").val(convertEntities('3')).trigger('change');
    
}

}
function GetRefferalByIdGroup(xdi) {
//var xdi = document.getElementById("caramasuk").value;
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataReferal/GetRefferalByIdGroup';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'idGroupRefferal=' + xdi
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
        //$("#referral").select2();
    })
}

function updateUIgetKelas(datagetKelas) {
let responseApi = datagetKelas;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#Kelas").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].IDKelas + '">' + responseApi.data[i].NamaKelas + '</option';
        $("#Kelas").append(newRow);
    }
}
}
function getKelas() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    //body: 'id=' + $("#IdAuto").val()
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
        $("#Kelas").select2(); 
    })
}

async function getidnamajaminan() {
    try {
        const dataGetJaminanByIdJaminan = await GetJaminanByIdJaminan();
        updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan); 
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan) {
    let data = dataGetJaminanByIdJaminan;
    $("#NamaPenjaminTemp").val(data.NamaPerusahaan);
}
function GetJaminanByIdJaminan() {
    var namajaminanId = document.getElementById("NamaPenjamin").value;
    var grupJaminanId = document.getElementById("TipePenjamin").value;
    $("#namajaminanid").val(namajaminanId);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/GetJaminanByIdJaminan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'grupJaminanId=' + grupJaminanId + '&namajaminanId=' + namajaminanId
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
            $("#hide_jaminan").hide();
        })
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
async function getCOB() {
    try{
        const datagoGetCOB = await goGetCOB();
        updateUIdatagoGetCOB(datagoGetCOB);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoGetCOB(dataGetRefferalByIdGroup) {
    let responseApi = dataGetRefferalByIdGroup;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#COB").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaCOB + '</option>';
            $("#COB").append(newRow);
        }
    }
}
function goGetCOB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterCOB/getCOBAktif';
    return fetch(url, {
        method: 'POST',
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
            $("#COB").select2();
        })
}
function PrintKartuMR(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aMedicalRecord/PrintKartuMR/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

