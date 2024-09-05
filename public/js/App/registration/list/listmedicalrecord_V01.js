$(document).ready(function () {
    onLoadFunctionAll();

    $('#btnSearchMrAktif').click(function () {
        var namatabel = 'table-load-data';
        var iswalkin = 'RAJAL';
        loaddatamr(namatabel,iswalkin);
    });

    $("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
        if (e.keyCode == 13) { // Jika user menekan tombol ENTER
            var namatabel = 'table-load-data';
            var iswalkin = 'RAJAL';
            loaddatamr(namatabel,iswalkin);
        }
  });

  $('#btnSearchMrWalkin').click(function () {
      var namatabel = 'loaddatamr_walkin';
      var iswalkin = 'WALKIN';
    loaddatamr(namatabel,iswalkin);
});

$("#txSearchDataWalkin").keyup(function (e) { // Ketika user menekan tombol di keyboard
    if (e.keyCode == 13) { // Jika user menekan tombol ENTER
        var namatabel = 'loaddatamr_walkin';
        var iswalkin = 'WALKIN';
        loaddatamr(namatabel,iswalkin);
    }
});

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


});

async function onLoadFunctionAll() {
    try{
        const datagetProvinsi =  await getProvinsi();
        updateUIgetProvinsi(datagetProvinsi);
        if ($("#txSearchData").val() != ''){
            $("#btnSearchMrAktif").trigger("click");
            showMedicalRecordbyId($("#txSearchData").val(),'RAJAL')
        }
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}

function loaddatamr(namatabel,iswalkin) {
    var base_url = window.location.origin; 
    if (iswalkin == 'WALKIN'){
        var txSearchData = $("#txSearchDataWalkin").val();
        if (txSearchData == '' || txSearchData == null){
            toast('Silahkan Isi Kata Kunci!', "warning")
            return false
        }

    }else{
        var txSearchData = $("#txSearchData").val();
    if (txSearchData == '' || txSearchData == null){
        toast('Silahkan Isi Kata Kunci!', "warning")
        return false
    }

    }
    
    //var iswalkin = 
    $('#'+namatabel).DataTable().clear().destroy();
    $('#'+namatabel).DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aMedicalRecord/getListMedicalRecordAll",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.txSearchData = txSearchData;
                d.iswalkin = iswalkin;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [ 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
              
                      var html = '<font size="1"> ' + row.NoMR + '</font> <br><br>IHS Number Satu Sehat : <span class="label label-danger">' + row.idMrkemkes + '</span> ';
                      return html
                   
              }
            },
            { "data": "NamaPasien" },
            { "data": "TglLahir" },
            { "data": "Alamat" },
            { "data": "TlpRumah" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                  if(row.Aktif == "1"){ 
                      var html  = '<span class="badge badge-success">Aktif</span> '
                  }else{ 
                      var html  = '<span class="badge badge-danger">Tidak Aktif</span> '
                  }
                     return html 
              }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button id="btnCreateNewMR" name="btnCreateNewMR" onclick=\'showMedicalRecordbyId("' + row.NoMR + '","' + iswalkin + '")\'  class="btn-xs btn-primary"><span class="glyphicon glyphicon-log-in"></span></button>&nbsp<button id="cetaklabel" name="cetaklabel" onclick=\'PrintLabelPasien("' + row.NoMR + '")\'  class="btn-xs btn-info"><i class="fa fa-tags"></i></button>&nbsp<button type="button" class="btn btn-warning border-success btn-animated btn-xs"  onclick=\'ShowDataRegistrasiSPRI("' + row.NoMR + '")\' ><span class="visible-content" > SPRI</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-success btn-animated btn-xs"  onclick=\'frmUploadDocuments("' + row.NoMR +'")\' ><span class="visible-content" > UPLOAD DOCUMENT</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>&nbsp<button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick=\'SignupMobile("' + row.NoMR +'")\' ><span class="visible-content" > Signup Mobile</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>'
                    return html
                }
            },

        ]
    });
}


async function showMedicalRecordbyId(xTempMr,iswalkin) {
    try {
        $(".preloader").fadeIn();
        $("#ModalInputMRBAru").modal('show');
        if(iswalkin == 'WALKIN'){
            $("#iswalkin").val('WALKIN');
        }else{
            $("#iswalkin").val('RAJAL');
        }
        
        //var xTempMr = $("#PasienNoMR").val();
        if (xTempMr != "") {
            const dataGetMedicalRecordbyId = await GetMedicalRecordbyId(xTempMr,iswalkin);
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
    $("#Medrec_NoMR").val(data.NoMR);
    $("#Medrec_IhsNumber").val(data.idMrkemkes);
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

function GetMedicalRecordbyId(xTempMr,iswalkin) {
    var base_url = window.location.origin;
    //var iswalkin = $("#iswalkin").val();
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetMedicalRecordbyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + xTempMr +"&iswalkin=" +iswalkin
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
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKabupaten';
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
           // $("#Medrec_kabupaten").select2();
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
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKecamatan';
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
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKodepos';
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
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKelurahan';
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
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/getProvinsi';
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

async function simpanMR(params) { 
    try {
        const responsePost = await CreateMedicalRecord(params);
        updateUICreateMedicalRecord(responsePost);
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
        document.getElementById("CloseMeC").click();
        document.getElementById("CloseMeMR").click();
        //$('#ModalInputMRBAru').modal('hide');
        document.getElementById("FRMcreatemr").reset();
    } else if (data.status == "update") {
        toast("Rekam Medik Berhasil dirubah !", "success")
        document.getElementById("CloseMeC").click();
        document.getElementById("CloseMeMR").click();
        document.getElementById("FRMcreatemr").reset();
       // showIDMxR();
    } else if (data.status == "double") { 
        toast("Ada Kemiripan Data, Pastikan Data yang anda input belum ada di Sistem, agar tidak Dobel Rekam Medik!", "error")
        //$('#ModalInputMRBAru').modal('hide');
        $('#modalcariDataMRSave').appendTo("body").modal('show');
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
function CreateMedicalRecord(params) {
    $(".preloader").fadeIn();
    var dtForm = $("#FRMcreatemr").serialize();
    var iswalkin = $("#iswalkin").val();
   // console.log(iswalkin,'sssfffffffffffffff');
   var ProvinsiNama = $('#Medical_Provinsi option:selected').text();
   var kabupatenNama = $('#Medrec_kabupaten option:selected').text();
   var Kecamatan = $('#Medrec_Kecamatan option:selected').text();
   var Kelurahan = $('#Medrec_Kelurahan option:selected').text();
    let jenisCreate = params;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/CreateMedicalRecord&q=' + jenisCreate;
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


function ShowDataPasienPoliklinik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/' + str;
}

function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/";
}

function PrintLabelPasien(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintLabelPasien/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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

function PrintKartuMR(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aMedicalRecord/PrintKartuMR/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function ShowDataRegistrasiSPRI(str){
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/SPRI/CreateSPRI_Bayi/' + str;
}

function frmUploadDocuments(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aMedicalRecord/frmUploadDocuments/' + str;
}
 function SignupMobile(param){
    //-----SIGNUP
    swal({
        title: "Buat Akun Mobile YARSI",
        text: "Apakah Anda ingin Membuat Akun Login Mobile YARSI dan Mengirimkan Username dan Password ke Pasien Ini ?",
        icon: "info",
        buttons: ['Tidak', "Ya, Buat Akun dan Kirim !"],
        closeOnClickOutside: false,
        closeOnEsc: false,
    })
        .then((willDelete) => {
            if (willDelete) {
                gosignupUser(param)
            } else {
               // swal("Transaction Rollback !");
            }
        });
        //-#END SIGNUP
 }

async function gosignupUser(param) {
    try{
        
        const data = await signupUser(param);
        updateUIsignupUser(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIsignupUser(data) {
    if (data.status == "success") {
        toast(data.message, "success");
        swal('Berhasil !', data.message, "success")
    }else {
        toast(data.message,"error");
        swal('Gagal !', data.message, "error")
    }
}
function signupUser(nomr) {
    //var nomr = $("#PasienNoMR").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/signupUser';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'nomr=' +nomr
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
        })
}