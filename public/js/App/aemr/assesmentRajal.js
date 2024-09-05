$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    asyncShowWakilPasien();
    asyncShowAssesment();
    asyncShowMasalahKeperawatan();
    asyncShowcppt();
    asyncShowListObat();
    asyncShowListResep();
    dataICD10Utama();
    dataICD10Sekunder();
    dataICDTindakan();
    $('#btn_modalmasalahkeperawatan').click(function () {
        clear_modal_masalahkeperawatan();
        $("#modalmasalahkeperawatan").modal('show');
    });
    $('#btn_modalcppt').click(function () {
        clear_modal_cppt();
        $("#modalcppt").modal('show');
    });

    $('#divResep').click(function () {
        $("#modalcppt").modal('show');
    });

    $('#divMedicalHistory').click(function () {
        var x = document.getElementById("resepdiv");
        x.style.display = "none";
        console.log('tai');
    });
    $( "#emr_select_diagnosa_utama" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: window.location.origin + "/SIKBREC/public/aEMR/searchdiagnosaICD10",
            dataType: "json",
            type: 'post',
            data: {
              searchTerm: request.term 
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
                $(this).val(ui.item.label);
                insertICD10Utama(ui.item.id); 
                return false; 
          }
    })
    $( "#emr_select_diagnosa_sekunder" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: window.location.origin + "/SIKBREC/public/aEMR/searchdiagnosaICD10",
            dataType: "json",
            type: 'post',
            data: {
              searchTerm: request.term 
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
                $(this).val(ui.item.label);
                goinsertDiagnosa10sekunder(ui.item.id);
                return false; 
          }
    })
    $( "#emr_select_diagnosa_tindakan" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: window.location.origin + "/SIKBREC/public/aEMR/searchdiagnosaICD9",
            dataType: "json",
            type: 'post',
            data: {
              searchTerm: request.term 
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        
        minLength: 3,
        select: function(event, ui)
          {
                $(this).val(ui.item.label);
                insertICDTindakan(ui.item.id);
                return false; 
          }
    })
});

function clear_modal_masalahkeperawatan(){
    $("#emr_id_masalahkeperawatan").val('');
    $("#emr_nodp_masalahkeperawatan").val('');
    $("#emr_diagnosa_masalahkeperawatan").val('');
}

function clear_modal_cppt(){
    $("#emr_id_cppt").val('');
    $("#emr_nodp_masalahkeperawatan").val('');
    $("#emr_cppt_s").val('');
    $("#emr_cppt_o").val('');
    $("#emr_cppt_a").val('');
    $("#emr_cppt_p").val('');
    $("#userentry").val('');
}
async function insertICDTindakan(data) {
    try {
        const datainsertICDTindakan = await goinsertICDTindakan(data); 
        updatedatainsertICDTindakan(datainsertICDTindakan); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updatedatainsertICDTindakan(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
        swal('Good job!', params.message + " !", "success");
}
function goinsertICDTindakan(data) {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var idicd = data; 
    let url = base_url + '/SIKBREC/public/aEMR/insertICDTindakan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + noreg_pasien + '&idicd=' + idicd
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
            dataICDTindakan();
            $("#emr_select_diagnosa_tindakan").val(''); 
        })
}
async function goinsertDiagnosa10sekunder(data) {
    try {
        const datainsertDiagnosa10sekunder = await insertDiagnosa10sekunder(data); 
        updateinsertDiagnosa10sekunder(datainsertDiagnosa10sekunder); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
async function insertICD10Utama(data){
    try{
        const dtinsertICD10Utama = await insertICD10Utama(data);
        updatedtinsertICD10Utama(dtinsertICD10Utama);
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateinsertDiagnosa10sekunder(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
        swal('Good job!', params.message + " !", "success");
}
function updatedtinsertICD10Utama(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
    swal('Good job!', params.message + " !", "success");
}
function insertDiagnosa10sekunder(data) {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var idicd = data; 
    let url = base_url + '/SIKBREC/public/aEMR/insertICD10sekunder';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + noreg_pasien + '&idicd=' + idicd
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
            dataICD10Sekunder();
            $("#emr_select_diagnosa_sekunder").val(''); 
        })
}
function  insertICD10Utama(data) {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var idicd = data; 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/insertICD10Utama';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + noreg_pasien + '&idicd=' + idicd
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
            dataICD10Utama();
            $("#emr_select_diagnosa_primer").val(''); 
        })
}
function dataICD10Sekunder() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listdiagnosekunder').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listdiagnosekunder').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/listICD10Sekunder", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
        "deferRender": true,
    }, 

    "columns": [ 
                { "data": "DESCRIPTION" }, 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    var html = 
                    ` <button type="button" title="Update" class="btn btn-success btn-xs" onclick="viewDataDetailResep('${row.id }')"> Hapus </button>`
                    return html
                    }
                },
                 

                ], 
                 
    });
    // $('#tbl_listproduct_resep').css('display', 'block');
}
function dataICDTindakan() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listdiagnosatindakan').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listdiagnosatindakan').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/listICDTindakan", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
        "deferRender": true,
    }, 

    "columns": [ 
                { "data": "DESCRIPTION" }, 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    var html = 
                    ` <button type="button" title="Update" class="btn btn-success btn-xs" onclick="viewDataDetailResep('${row.id }')"> Hapus </button>`
                    return html
                    }
                },
                 

                ], 
                 
    });
    // $('#tbl_listproduct_resep').css('display', 'block');
}


function dataICD10Utama() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listdiagnosautama').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listdiagnosautama').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/listICD10Utama", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
        "deferRender": true,
    }, 

    "columns": [ 
                { "data": "DESCRIPTION" }, 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    var html = 
                    ` <button type="button" title="Update" class="btn btn-success btn-xs" onclick="viewDataDetailResep('${row.id }')"> Hapus </button>`
                    return html
                    }
                },
                 

                ], 
                 
    });
    // $('#tbl_listproduct_resep').css('display', 'block');
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
async function asyncShowMain(){
    try{
        const datagetPasienByNoReg = await getPasienByNoReg();
        updateUIdatagetPasienByNoReg(datagetPasienByNoReg);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getPasienByNoReg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
function updateUIdatagetPasienByNoReg(datagetPasienByNoReg) {
    let datapasien = datagetPasienByNoReg;
    $("#emr_idvisit").val(datapasien.data.ID);
    $("#emr_nama").val(datapasien.data.PatientName);
    $("#emr_norm").val(datapasien.data.NoMR);
    $("#emr_tanggallahir").val(datapasien.data.Date_of_birth);
    $("#emr_nohp").val(datapasien.data.No_Phone);
    $("#emr_nik").val(datapasien.data.Nik);
    $("#emr_pekerjaan").val(datapasien.data.Pekerjaan);
    $("#emr_alamat").val(datapasien.data.Address);
    $("#emr_agama").val(datapasien.data.Religion);
    $("#emr_jeniskelamin").val(datapasien.data.Gander);

    // Masalah Keperawatan
    $("#emr_mr_masalahkeperawatan").val(datapasien.data.NoMR);
    $("#emr_noreg_masalahkeperawatan").val(datapasien.data.NoRegistrasi);
    
    // CPPT
    $("#emr_mr_cppt").val(datapasien.data.NoMR);
    $("#emr_noreg_cppt").val(datapasien.data.NoRegistrasi);

    // Asesment Mata
    $("#emr_namapasienmata").val(datapasien.data.PatientName);
    $("#emr_tanggallahirmata").val(datapasien.data.Date_of_birth);
    $("#emr_noregmata").val(datapasien.data.NoRegistrasi);
    $("#emr_normmata").val(datapasien.data.NoMR);

    // RESEP
    $("#emr_nomr_resep").val(datapasien.data.NoMR);
    $("#emr_namapasien_resep").val(datapasien.data.PatientName);
    $("#emr_episode_resep").val(datapasien.data.NoEpisode);
    $("#emr_noreg_resep").val(datapasien.data.NoRegistrasi);
    $("#emr_dob_resep").val(datapasien.data.Date_of_birth);
    $("#emr_dpjp_resep").val(datapasien.data.First_Name);

    // $("#emr_iduserentri_resep").val(datapasien.data.IdUser);
    $("#emr_iduserentri_resep").val(datapasien.data.IdEmploye);
    $("#emr_userentri_resep").val(datapasien.data.NamaUser);
    $("#emr_idunit_resep").val(datapasien.data.IDUNIT);
    $("#emr_unit_resep").val(datapasien.data.NamaUnit);
}

async function asyncShowWakilPasien(){
    try{
        const datagetWakilPasienByNoreg = await getWakilPasienByNoreg();
        updateUIdatagetWakilPasienByNoreg(datagetWakilPasienByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getWakilPasienByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getDataWakilPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
function updateUIdatagetWakilPasienByNoreg(datagetWakilPasienByNoreg) {
    let datawakilpasien = datagetWakilPasienByNoreg;
    $("#emer_namawakil").val(datawakilpasien.data.Nama_Wakil_Pasien);
    $("#emr_umurwakil").val(datawakilpasien.data.Umur_Wakil_Paisen);
    $("#emr_nohpwakil").val(datawakilpasien.data.NoHp_Wakil_Pasien);
    $("#emr_nikwakil").val(datawakilpasien.data.NIK_Wakil_Pasien);
    $("#emr_pekerjaanwakil").val(datawakilpasien.data.Pekerjaan_Wakil_Pasien);
    $("#emr_alamatwakil").val(datawakilpasien.data.Alamat_Wakil_Pasien);
    $("#emr_hubunganwakil").val(datawakilpasien.data.Hubungan_Wakil_Pasien);
    $("#emr_keteranganwakil").val(datawakilpasien.data.Keterangan_Wakil_Pasien);
    $("#emr_jeniskelaminwakil").val(datawakilpasien.data.JenisKelamin_Wakil_Pasien);
    
}

async function asyncShowAssesment(){
    try{
        const datagetAssesmentByNoreg = await getAssesmentByNoreg();
        updateUIdatagetAssesmentByNoreg(datagetAssesmentByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getAssesmentByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getDataAssesment';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
function updateUIdatagetAssesmentByNoreg(datagetAssesmentByNoreg) {
    let dataassesment = datagetAssesmentByNoreg;
    //ASSESMENT
    $("#emr_keluhan_utama").val(dataassesment.data.Keluhan_Utama);
    $("#emr_pernapasan").val(dataassesment.data.Pernapasan);
    $("#emr_tensi").val(dataassesment.data.Tensi);
    $("#emr_sistole").val(dataassesment.data.Sistole);
    $("#emr_diastole").val(dataassesment.data.Diastole);
    $("#emr_suhu").val(dataassesment.data.Suhu);
    $("#emr_nadi").val(dataassesment.data.Nadi);
    $("#emr_spo2").val(dataassesment.data.SpO2);
    $("#emr_tinggibadan").val(dataassesment.data.Tinggi_Badan);
    $("#emr_beratbadan").val(dataassesment.data.Berat_Badan);
    $("#emr_hamil").val(dataassesment.data.Hamil);
    $("#emr_menyusui").val(dataassesment.data.Menyusui);
    $("#emr_riwayatalergi").val(dataassesment.data.Riwayat_Alergi);
    $("#emr_riwayatalergiya").val(dataassesment.data.Riwayat_Alergi_Detail);
    document.getElementById("emr_nariwayatalergi").checked = convertBitToBolean(dataassesment.data.NA_Assesment);

    $("#emr_pulang").val(dataassesment.data.Pulang);
    $("#emr_rawatinap").val(dataassesment.data.Rawat_Inap);
    $("#emr_rujukuntuk").val(dataassesment.data.Rujuk_Detail);
    document.getElementById("emr_rujuk").checked = convertBitToBolean(dataassesment.data.Rujuk);

    //TRIAGE COVID
    $("#emr_batutenggorokantersumbat").val(dataassesment.data.Batuk_SakitTenggorokan_HidungTersumbat);
    $("#emr_frekuensispo2").val(dataassesment.data.Sesak_PeningkatanFreskuensiNafas);
    $("#emr_demam1").val(dataassesment.data.Demam_1);
    $("#emr_riwayatkontakerat").val(dataassesment.data.Riwayat_Kontak_Pasien_Covid);
    $("#emr_riwayatperjalanan").val(dataassesment.data.Riwayat_Perjalanan);
    $("#emr_tandapeunomiadenganct").val(dataassesment.data.Tanda_Pneumia);
    $("#emr_riwayatkontakeratdenganpasiencovid").val(dataassesment.data.Riwayat_Kontak_Pasien_Covid_2);
    $("#emr_demam2").val(dataassesment.data.Demam_2);
    $("#emr_usialebihdarisamadengan44").val(dataassesment.data.Usia_Diatas_43Thn);
    $("#emr_jeniskelamincek").val(dataassesment.data.Jenis_Kelamin);
    $("#emr_suhumaxsejaksampai").val(dataassesment.data.Suhu_Max_38C);
    $("#emr_gejalagangguanrespirasi").val(dataassesment.data.Gejala_Gangguan_Respirasi);
    $("#emr_rasioneutrofil").val(dataassesment.data.RasioNeutrofildanLimfosit_lebihdari_57);

    //TBC
    $("#emr_adakahbatukselama2minggu").val(dataassesment.data.Batuk_Max_2Minggu);
    $("#emr_dahakbercampurdarah").val(dataassesment.data.Dahak_Bercampur_Darah);
    $("#emr_demammerianglebihdari1bulan").val(dataassesment.data.DemamMeriang_Max_1Bulan);
    $("#emr_sesaknafas").val(dataassesment.data.Sesak_Nafas);
    $("#emr_riwayatbatukberdarah").val(dataassesment.data.Riwayat_Batuk_Berdarah);
    $("#emr_lemah").val(dataassesment.data.Lemah);
    $("#emr_badanlemas").val(dataassesment.data.Badan_Lemas_Berdarah);
    $("#emr_keringatmalamtanpaaktifitas").val(dataassesment.data.Keringatan_Malam_Tanpa_Aktifitas);
    $("#emr_beratbadanmenurundrastis").val(dataassesment.data.BB_Menurun_Drastis);
    document.getElementById("emr_naskrinningtbc").checked = convertBitToBolean(dataassesment.data.NA_Skrining_TBC);
    document.getElementById("emr_negatif").checked = convertBitToBolean(dataassesment.data.Kesimpulan_Negatif);
    document.getElementById("emr_odp").checked = convertBitToBolean(dataassesment.data.Kesimpulan_ODP_PDP);
    document.getElementById("emr_tbc").checked = convertBitToBolean(dataassesment.data.Kesimpulan_Tuberkulosis);
    document.getElementById("emr_pinerelainnya").checked = convertBitToBolean(dataassesment.data.Kesimpulan_Pinere_Lainnya);

    //ANAMNESIS
    $("#emr_anamnesis").val(dataassesment.data.Anamnesis);
    $("#emr_keluhanutamaanamnesis").val(dataassesment.data.Keluhan_Utama_Anamnesis);
    $("#emr_riwayatpenyakitsekarang").val(dataassesment.data.Riwayat_Penyakit_Sekarang);
    $("#emr_riwayatpenyakitterdahulu").val(dataassesment.data.Riwayat_Penyakit_Terdahulu);
    $("#emr_riwayatpenyakitterdahulurincian").val(dataassesment.data.Riwayat_Penyakit_Terdahulu_Detail);
    $("#emr_pembedahan").val(dataassesment.data.Riwayat_Pembedahan);
    $("#emr_pembedahanrincian").val(dataassesment.data.Riwayat_Pembedahan_Detail);
    $("#emr_riwayatrawatsebelumnya").val(dataassesment.data.Riwayat_Rawat_Sebelumnya);
    $("#emr_riwayatrawatsebelumnyarincian").val(dataassesment.data.Riwayat_Rawat_Sebelumnya_Detail);
    $("#emr_adaobatrutinyangdiminum").val(dataassesment.data.Obat_Rutin_Dari_Rumah);
    $("#emr_adaobatrutinyangdiminumrincian").val(dataassesment.data.Obat_Rutin_Dari_Rumah_Detail);

    //SKRININNG JATUH
    $("#emr_adariwayatjatuhdalam3bulan").val(dataassesment.data.Riwayat_Jatuh_Dalam_3Bulan);
    $("#emr_riwayatseizures").val(dataassesment.data.Riwayat_Seizures);
    $("#emr_anakmengkonmsumsiobat").val(dataassesment.data.Anak_Konsumsi_Narkotik);
    $("#emr_caraberjalanpasiensaatakanduduk").val(dataassesment.data.Cara_Berjalan_Saat_Akan_Duduk);
    $("#emr_pasienmemegangpinggirankursi").val(dataassesment.data.Pasien_Memegang_Pinggiran_Kursi);
    $("#emr_keluhannyeri").val(dataassesment.data.Keluhan_Nyeri);
    $("#emr_lokasinyeri").val(dataassesment.data.Lokasi_Nyeri);
    $("#emr_nyeritimbul").val(dataassesment.data.Nyeri_Timbul_Sejak);
    $("#emr_frekwensinyeri").val(dataassesment.data.Frekwensi_Nyeri);
    $("#emr_karakteristiknyeri").val(dataassesment.data.Karakteristik_Nyeri);
    $("#emr_etensitasnyeri").val(dataassesment.data.Etensitas_Nyeri);
    $("#emr_metodepenilaiannyeri").val(dataassesment.data.Metode_Penilaian_Nyeri);
    $("#emr_tipenyeri").val(dataassesment.data.Tipe_Nyeri);
    $("#emr_pemberatnyeri").val(dataassesment.data.Pencetus_Nyeri);
    $("#emr_halyangdapatmeredakannyeri").val(dataassesment.data.Pereda_Nyeri);
    $("#emr_tindakanmandiriperawatdetail").val(dataassesment.data.Tindakan_Mandiri_Perawat_Detail);
    $("#emr_kolaborasidetail").val(dataassesment.data.Kolaborasi_Detail);
    document.getElementById("emr_naskrinningjatuhanak").checked = convertBitToBolean(dataassesment.data.NA_Skrining_Jatuh_Anak);
    document.getElementById("emr_risikorendahjatuh").checked = convertBitToBolean(dataassesment.data.Risiko_Rendah_Jatuh_Anak);
    document.getElementById("emr_risikotinggijatuh").checked = convertBitToBolean(dataassesment.data.Risiko_Tinggi_Jatuh_Anak);
    document.getElementById("emr_naskrinningrisikojatuhmobilisasi").checked = convertBitToBolean(dataassesment.data.NA_Skrining_Jatuh_Dewasa);
    document.getElementById("emr_risikorendahpoinpencegahan").checked = convertBitToBolean(dataassesment.data.Risiko_Rendah_Jatuh_Dewasa);
    document.getElementById("emr_risikotinggipoinpencegahan").checked = convertBitToBolean(dataassesment.data.Risiko_Tinggi_Jatuh_Dewasa);
    document.getElementById("emr_tindakanmandiriperawat").checked = convertBitToBolean(dataassesment.data.Tindakan_Mandiri_Perawat);
    document.getElementById("emr_kolaborasi").checked = convertBitToBolean(dataassesment.data.Kolaborasi);

    //SKRINNING NUTRISI
    $("#emr_risikonutrisi").val(dataassesment.data.Resiko_Nutrisional);
    $("#emr_pasientampakkurus").val(dataassesment.data.Tampak_Kurus);
    $("#emr_penurunanbb").val(dataassesment.data.Penurunan_BB_1Bulan_Terakhir);
    $("#emr_terdapatsalahsatukondisi").val(dataassesment.data.Terdapat_Kondisi_DiareMuntahKurangasupan);
    $("#emr_beresikomengalamimalnutrisi").val(dataassesment.data.RiwayatPenyakit_Beresiko_Malnutrisi);
    $("#emr_nilaiskore").val(dataassesment.data.Nilai_Skor_Malnutrisi);
    $("#emr_nilaiskoreskrinningdewasa").val(dataassesment.data.Nilai_Skor_Nutirisi_Dewasa);
    $("#emr_penurunanberatbadandewasa").val(dataassesment.data.Penurunan_BB_6Bulan_TidakDisengaja);
    $("#emr_berapapenurunanbbdewasa").val(dataassesment.data.Skala_Penurunan_BB);
    $("#emr_asupanmakananberkurang").val(dataassesment.data.Asupan_Makanan_Berkurang);
    $("#emr_kondisikhusus").val(dataassesment.data.Pasien_Kebutuhan_Khusus);
    $("#emr_lila").val(dataassesment.data.LILA);

    document.getElementById("emr_skrinningnutrisianak").checked = convertBitToBolean(dataassesment.data.NA_Skrining_Nutrisi_Anak);
    document.getElementById("emr_diarekronik").checked = convertBitToBolean(dataassesment.data.Diare_Konik);
    document.getElementById("emr_jantungbawaan").checked = convertBitToBolean(dataassesment.data.Penyakit_Jantung_Bawaan);
    document.getElementById("emr_hiv").checked = convertBitToBolean(dataassesment.data.HIV);
    document.getElementById("emr_kanker").checked = convertBitToBolean(dataassesment.data.Kanker);
    document.getElementById("emr_hatikronik").checked = convertBitToBolean(dataassesment.data.Penyakit_Hati_Kronik);
    document.getElementById("emr_ginjalkronik").checked = convertBitToBolean(dataassesment.data.Penyakit_Ginjal_Kronik);
    document.getElementById("emr_tbparu").checked = convertBitToBolean(dataassesment.data.TB_Paru);
    document.getElementById("emr_terpasangstoma").checked = convertBitToBolean(dataassesment.data.Terpasang_Stoma);
    document.getElementById("emr_trauma").checked = convertBitToBolean(dataassesment.data.Tauma);
    document.getElementById("emr_lukabakarluas").checked = convertBitToBolean(dataassesment.data.Luka_Bakar_Luas);
    document.getElementById("emr_kelainananatomidaerahmulut").checked = convertBitToBolean(dataassesment.data.Kelainan_Anatomi_Daerah_Mulut);
    document.getElementById("emr_rencanapascaoperasi").checked = convertBitToBolean(dataassesment.data.Pasca_Operasi);
    document.getElementById("emr_kelainanmetabolikbawaan").checked = convertBitToBolean(dataassesment.data.Kelainan_Metabolik_Bawaan);
    document.getElementById("emr_retardasimetal").checked = convertBitToBolean(dataassesment.data.Retardasi_Metal);
    document.getElementById("emr_stunting").checked = convertBitToBolean(dataassesment.data.Keterlambatan_Perkembangan);
    document.getElementById("emr_risikotinggikolaborasiahligizi").checked = convertBitToBolean(dataassesment.data.Resiko_Tinggi_Skrining_Nutrisi_Anak);
    document.getElementById("emr_skrinningnutrisidewasa").checked = convertBitToBolean(dataassesment.data.NA_Skrining_Nutrisi_Dewasa);
    document.getElementById("emr_risikotinggipilihandengandiagnosisi").checked = convertBitToBolean(dataassesment.data.Resiko_Tinggi_Skrining_Nutrisi_Dewasa);
    document.getElementById("emr_skrinningnutrisiibuhamil").checked = convertBitToBolean(dataassesment.data.NA_Skrining_Nutrisi_Ibu_Hamil);

    //KOMUNIKASI DAN EDUKASI
    $("#emr_fungsibicara").val(dataassesment.data.Fungsi_Bicara);
    $("#emr_kelainanfungsibicara").val(dataassesment.data.Fungsi_Bicara_Detail);
    $("#emr_bahasasehari").val(dataassesment.data.Bahasa_Sehari_Hari);
    $("#emr_bahaseharidetail").val(dataassesment.data.Bahasa_Sehari_Hari_Detail);
    $("#emr_perlupenerjemah").val(dataassesment.data.Perlu_Penerjemah);
    $("#emr_perlupenerjemahdetail").val(dataassesment.data.Perlu_Penerjemah_Detail);
    $("#emr_bhsisyarat").val(dataassesment.data.Bahasa_Isyarat);
    $("#emr_bhsisyaratdetail").val(dataassesment.data.Bahasa_Isyarat_Detail);
    $("#emr_hambatanbelajarsecarafisik").val(dataassesment.data.Hambatan_Belajar_Secara_Fisik);
    $("#emr_hambatanbelajarsecarafisikdetail").val(dataassesment.data.Hambatan_Belajar_Secara_Fisik_Detail);
    $("#emr_hambatanbelajarsecarabudaya").val(dataassesment.data.Hambatan_Belajar_Secara_Budaya);
    $("#emr_hambatanbelajarsecarabudayadetail").val(dataassesment.data.Hambatan_Belajar_Secara_Budaya_Detai);
    $("#emr_hambatanbelajarsecarabahasa").val(dataassesment.data.Hambatan_Belajar_Secara_Bahasa);
    $("#emr_hambatanbelajarsecarabahasadetail").val(dataassesment.data.Hambatan_Belajar_Secara_Bahasa_Detail);
    $("#emr_hambatanbelajarsecaraemosi").val(dataassesment.data.Hambatan_Belajar_Secara_Emosi);
    $("#emr_hambatanbelajarsecaraemosidetail").val(dataassesment.data.Hambatan_Belajar_Secara_Emosi_Detail);
    $("#emr_lainkebutuhandeukasidetail").val(dataassesment.data.Kebutuhan_Lain_Detail);

    document.getElementById("emr_pengobatan").checked = convertBitToBolean(dataassesment.data.Pengobatan);
    document.getElementById("emr_nutrisi").checked = convertBitToBolean(dataassesment.data.Nutrisi);
    document.getElementById("emr_tindakanmedis").checked = convertBitToBolean(dataassesment.data.Tindakan_Medis);
    document.getElementById("emr_keperawatan").checked = convertBitToBolean(dataassesment.data.keperawatan);
    document.getElementById("emr_lainkebutuhandeukasi").checked = convertBitToBolean(dataassesment.data.Kebutuhan_Lain);


    //SPIRITUAL
    $("#emr_tingkkatpendidikan").val(dataassesment.data.TingkatPendidikan);
    $("#emr_tingkkatpendidikanselain").val(dataassesment.data.TingkatPendidikan_Detail);
    $("#emr_pekerjaansaatini").val(dataassesment.data.Pekerjaan);
    $("#emr_pekerjaansaatiniselain").val(dataassesment.data.Pekerjaan_Detail);
    $("#emr_tinggalsaatini").val(dataassesment.data.Tinggal_Bersama);
    $("#emr_tinggalsaatiniselain").val(dataassesment.data.Tinggal_Bersama_Detail);
    $("#emr_agamasaatini").val(dataassesment.data.Agama);
    $("#emr_agamasaatiniselain").val(dataassesment.data.Agama_Detail);
    $("#emr_hambatanmenjalankanibadah").val(dataassesment.data.Hambatan_Menjalankan_Ibadah);
    $("#emr_hambatanmenjalankanibadahket").val(dataassesment.data.Hambatan_Menjalankan_Ibadah_Detail);
    $("#emr_nilaikepercayaandiriyangdianut").val(dataassesment.data.Nilai_Kepercayaan_Dianut);
    $("#emr_nilaikepercayaandiriyangdianutket").val(dataassesment.data.Nilai_Kepercayaan_Dianut_Detail);
    $("#emr_pantangmakanananminuman").val(dataassesment.data.Pantang_Makanan_Minuman);
    $("#emr_pantangmakanananminumanket").val(dataassesment.data.Pantang_Makanan_Minuman_Detail);
    $("#emr_riwayattindakkekerasanket").val(dataassesment.data.Riwayat_Tindak_Kekerasan);

    document.getElementById("emr_tenang").checked = convertBitToBolean(dataassesment.data.Tenang);
    document.getElementById("emr_sedihmenangis").checked = convertBitToBolean(dataassesment.data.Sedih_Menangis_MenarikDiri);
    document.getElementById("emr_cemasgelisah").checked = convertBitToBolean(dataassesment.data.Cemas_Gelisah);
    document.getElementById("emr_takutsekitar").checked = convertBitToBolean(dataassesment.data.TakutTerapi_Tindakan_Lingkungan);
    document.getElementById("emr_mudahmarah").checked = convertBitToBolean(dataassesment.data.Marah_Mudah_Tersinggung);

    //GIGI
    $("#emr_riwayatperawatangigi ").val(dataassesment.data.Riwayat_Perawatan_Gigi);
    $("#emr_riwayatperawatangigikapan ").val(dataassesment.data.Riwayat_Perawatan_Gigi_Detail);
    $("#emr_riwayatperawatangigimenjaditrauma ").val(dataassesment.data.TakutCemas_Setelah_PerawatanGigi);
    $("#emr_pasienmengetahuiperwatangigiyangbenar ").val(dataassesment.data.Pemeliharaan_Gigi_Baik);
    $("#emr_sikatgigimax2kali ").val(dataassesment.data.SikatGigi_Min_2xSehari);
    $("#emr_sikatgigidenganbenar ").val(dataassesment.data.Menyikat_Gigi_Benar);
    $("#emr_mengurangimakananyangmanis ").val(dataassesment.data.Mengurangi_Makanan_ManisLengket);
    $("#emer_warnabibir ").val(dataassesment.data.Warna_Bibir);
    $("#emr_bibirsimetris ").val(dataassesment.data.Bibir_Simetris);
    $("#emr_bibirsimetrisket").val(dataassesment.data.Bibir_Simetris_Detail);
    $("#emr_bibirlembab").val(dataassesment.data.Bibir_Lembab);
    $("#emr_bibirlembabdetail").val(dataassesment.data.Bibir_Lembab_Detail);
    $("#emr_beratbadanlahir").val(dataassesment.data.BB_Lahir);
    $("#emr_panjanglahir").val(dataassesment.data.TB_Lahir);
    $("#emr_cacatbawaan").val(dataassesment.data.Cacat_Bawaan);
    $("#emr_cacatbawaanket").val(dataassesment.data.Cacat_Bawaan_Detail);
    $("#emr_riwayatpenyakitsetelahlahir").val(dataassesment.data.Penyakit_Setelah_Lahir);
    $("#emr_riwayatpenyakitsetelahlahirket").val(dataassesment.data.Penyakit_Setelah_Lahir_Detail);
    $("#emr_bcgusia").val(dataassesment.data.BCG_Usia);
    $("#emr_dptusia").val(dataassesment.data.DPT_Usia1);
    $("#emr_poliousia").val(dataassesment.data.Polio_Usia);
    $("#emr_campakusia").val(dataassesment.data.Campak_Usia);
    $("#emr_mmrusia").val(dataassesment.data.MMR_Usia);
    $("#emr_hepbusia").val(dataassesment.data.HEPB_Usia1);
    $("#emr_hepausia").val(dataassesment.data.HEPA_Usia);
    $("#emr_bosterusia").val(dataassesment.data.Boster_Usia);
    $("#emr_hibiusia").val(dataassesment.data.HIBI_Usia);
    $("#emr_varicelausia").val(dataassesment.data.Varicela_Usia);
    $("#emr_rotavirususia").val(dataassesment.data.Rotavirus_Usia);
    $("#emr_thypoidusia").val(dataassesment.data.Thypoid_Usia);
    $("#emr_pneumoniausia").val(dataassesment.data.Pneunomia_Usia);
    $("#emr_influenzausia").val(dataassesment.data.Influenza_Usia);
    $("#emr_riwayatasi").val(dataassesment.data.Riwayat_Asi);
    $("#emr_riwayatsufor").val(dataassesment.data.Susu_Formnula);
    $("#emr_makanantambahanusia").val(dataassesment.data.Makanan_Tambahan);
    $("#emr_riwayatkelainanpertumbuhan").val(dataassesment.data.kelainan_Pertumbuhan);
    $("#emr_riwayatkelainanpertumbuhanket").val(dataassesment.data.kelainan_Pertumbuhan_Detail);

    document.getElementById("emr_napengkajiangigi").checked = convertBitToBolean(dataassesment.data.NA_Keperawatan_Gigi);
    document.getElementById("emr_bibirpecah").checked = convertBitToBolean(dataassesment.data.Bibir_Pecah_Pecah);
    document.getElementById("emr_bibirberdarah").checked = convertBitToBolean(dataassesment.data.Bibir_Berdarah);
    document.getElementById("emr_bibirsianosis").checked = convertBitToBolean(dataassesment.data.Bibir_Biru);
    document.getElementById("emr_bibirpucat").checked = convertBitToBolean(dataassesment.data.Bibir_Pucat);
    document.getElementById("emr_bibirbengkak").checked = convertBitToBolean(dataassesment.data.Bibir_Bengkak);
    document.getElementById("emr_bcg").checked = convertBitToBolean(dataassesment.data.BCG);
    document.getElementById("emr_dpt").checked = convertBitToBolean(dataassesment.data.DPT);
    document.getElementById("emr_polio").checked = convertBitToBolean(dataassesment.data.Polio);
    document.getElementById("emr_campak").checked = convertBitToBolean(dataassesment.data.Campak);
    document.getElementById("emr_mmr").checked = convertBitToBolean(dataassesment.data.MMR);
    document.getElementById("emr_hepb").checked = convertBitToBolean(dataassesment.data.HEPB);
    document.getElementById("emr_hepa").checked = convertBitToBolean(dataassesment.data.HEPA);
    document.getElementById("emr_boster").checked = convertBitToBolean(dataassesment.data.Boster);
    document.getElementById("emr_hibi").checked = convertBitToBolean(dataassesment.data.HIBI);
    document.getElementById("emr_varicela").checked = convertBitToBolean(dataassesment.data.Varicela);
    document.getElementById("emr_rotavirus").checked = convertBitToBolean(dataassesment.data.Rotavirus);
    document.getElementById("emr_pneumonia").checked = convertBitToBolean(dataassesment.data.Pneunomia);
    document.getElementById("emr_thypoid").checked = convertBitToBolean(dataassesment.data.Thypoid);
    document.getElementById("emr_influenza").checked = convertBitToBolean(dataassesment.data.Influenza);

    //DISCHARGE PLANNING
    $("#emr_memerlukanbantuanuntukaktifitas").val(dataassesment.data.Butuhkan_Bantuan_Untuk_Aktifitas);
    $("#emr_memerlukanbantuanuntukaktifitasket").val(dataassesment.data.Butuhkan_Bantuan_Untuk_Aktifitas_Detail);
    $("#emr_memerlukanperalatanmedis").val(dataassesment.data.Butuh_Peralatan_Medis_Setelah_Dari_RS);
    $("#emr_memerlukanperalatanmedisket").val(dataassesment.data.Butuh_Peralatan_Medis_Setelah_Dari_RS_Detail);
    $("#emr_memerlukanedukasikesehatan").val(dataassesment.data.Perlu_Edukasi_Kesehatan_Setelah_Dari_RS);
    $("#emr_memerlukanedukasikesehatanket").val(dataassesment.data.Perlu_Edukasi_Kesehatan_Setelah_Dari_RS_Detail);
    $("#emr_tinggalsendiri").val(dataassesment.data.Tinggal_Sendiri_Setelah_Dari_RS);
    $("#emr_tinggalsendiriket").val(dataassesment.data.Tinggal_Sendiri_Setelah_Dari_RS_Detail);
    $("#emr_perwatanlanjutan").val(dataassesment.data.Perawatan_Lanjutan_Setelah_Dari_RS);
    $("#emr_perwatanlanjutanket").val(dataassesment.data.Perawatan_Lanjutan_Setelah_Dari_RS_Detail);
    $("#emr_dekatdenganpelayanankesehatan").val(dataassesment.data.TempatTinggal_Dekat_Pelayanan_Kesehatan);
    $("#emr_dekatdenganpelayanankesehatanket").val(dataassesment.data.TempatTinggal_Dekat_Pelayanan_Kesehatan_Detail);
    $("#emr_dirumahadayangmerawat").val(dataassesment.data.Ada_Yang_Merawat_Dirumah);
    $("#emr_dirumahadayangmerawatket").val(dataassesment.data.Ada_Yang_Merawat_Dirumah_Detail);
    $("#emr_memilikinyerikronis").val(dataassesment.data.Nyeri_Kronis_Kelelahan);
    $("#emr_memilikinyerikronisket").val(dataassesment.data.Nyeri_Kronis_Kelelahan_Detail);
    $("#emr_memerlukantransport").val(dataassesment.data.Memerlukan_Transportasi);
    $("#emr_memerlukantransportket").val(dataassesment.data.Memerlukan_Transportasi_Detail);
    $("#emr_bantuanperawatankhusus").val(dataassesment.data.Perlu_Bantuan_Khusus);
    $("#emr_bantuanperawatankhususket").val(dataassesment.data.Perlu_Bantuan_Khusus_Detail);

    //FORM KESIMPULAN
    // document.getElementById("emr_influenza").checked = convertBitToBolean(dataassesment.data.Influenza);
    // $("#emr_bantuanperawatankhususket").val(dataassesment.data.Perlu_Bantuan_Khusus_Detail);
    // $("#emr_bantuanperawatankhususket").val(dataassesment.data.Perlu_Bantuan_Khusus_Detail);
    // $("#emr_bantuanperawatankhususket").val(dataassesment.data.Perlu_Bantuan_Khusus_Detail);

    // ASSESMENT MATA
$("#emr_anamnesismata").val(dataassesment.data.Anamnesis);
$("#emr_pemeriksaanmata").val(dataassesment.data.PemerisaanMata);
$("#emr_tanpakoreksi_avod").val(dataassesment.data.Tako_AVOD);
$("#emr_tanpakoreksi_avos").val(dataassesment.data.Tako_AVOS);
$("#emr_setelahkoreksi_avods").val(dataassesment.data.Seko_AVODS);
$("#emr_setelahkoreksi_avodc").val(dataassesment.data.Seko_AVODC);
$("#emr_setelahkoreksi_avodaxis").val(dataassesment.data.Seko_AVODAxis);
$("#emr_avodc_keterangan1").val(dataassesment.data.Seko_AVODMenjadi);
$("#emr_avodc_keterangan2").val(dataassesment.data.Seko_AVODKet);
$("#emr_setelahkoreksi_avoss").val(dataassesment.data.Seko_AVOSS);
$("#emr_setelahkoreksi_avosc").val(dataassesment.data.Seko_AVOSC);
$("#emr_setelahkoreksi_avosaxis").val(dataassesment.data.Seko_AVOSAxis);
$("#emr_avosc_keterangan1").val(dataassesment.data.Seko_AVOSMenjadi);
$("#emr_avosc_keterangan2").val(dataassesment.data.Seko_AVOSKet);
$("#emr_setelahkoreksi_adds").val(dataassesment.data.Seko_Add);
$("#emr_setelahkoreksi_pd").val(dataassesment.data.Seko_PD);
$("#emr_kacamata_avods").val(dataassesment.data.Kcmt_AVODS);
$("#emr_kacamata_avodc").val(dataassesment.data.Kcmt_AVODC);
$("#emr_kacamata_avodaxis").val(dataassesment.data.Kcmt_AVODAxis);
$("#emr_avodc_keterangan1_kacamata").val(dataassesment.data.Kcmt_AVODMenjadi);
$("#emr_kacamata_avoss").val(dataassesment.data.Kcmt_AVOSS);
$("#emr_kacamata_avosc").val(dataassesment.data.Kcmt_AVOSC);
$("#emr_kacamata_avosaxis").val(dataassesment.data.Kcmt_AVOSAxis);
$("#emr_avosc_keterangan1_kacamata").val(dataassesment.data.Kcmt_AVOSMenjadi);
$("#emr_kacamata_adds").val(dataassesment.data.Kcmt_Add);
$("#emr_palbebra_kanan").val(dataassesment.data.PalpebraKa);
$("#emr_palbebra_kanan_detail").val(dataassesment.data.PalpebraKaNote);
$("#emr_palbebra_kiri").val(dataassesment.data.PalpebraKi);
$("#emr_palbebra_kiri_detail").val(dataassesment.data.PalpebraKiNote);
$("#emr_konjungtiva_kanan").val(dataassesment.data.KonjungtivaKa);
$("#emr_konjungtiva_kanan_detail").val(dataassesment.data.KonjungtivaKaNote);
$("#emr_konjungtiva_kiri").val(dataassesment.data.KonjungtivaKi);
$("#emr_konjungtiva_kiri_detail").val(dataassesment.data.KonjungtivaKiNote);
$("#emr_kornea_kanan").val(dataassesment.data.KorneaKa);
$("#emr_kornea_kanan_detail").val(dataassesment.data.KorneaKaNote);
$("#emr_kornea_kiri").val(dataassesment.data.KorneaKi);
$("#emr_kornea_kiri_detail").val(dataassesment.data.KorneaKiNote);
$("#emr_kamera_kanan").val(dataassesment.data.KameraKa);
$("#emr_kamera_kanan_detail").val(dataassesment.data.KameraKaNote);
$("#emr_kamera_kiri").val(dataassesment.data.KameraKi);
$("#emr_kamera_kiri_detail").val(dataassesment.data.KameraKiNote);
$("#emr_pupil_kanan").val(dataassesment.data.PupilKa);
$("#emr_pupil_kanan_detail").val(dataassesment.data.PupilKaNote);
$("#emr_pupil_kiri").val(dataassesment.data.PupilKi);
$("#emr_pupil_kiri_detail").val(dataassesment.data.PupilKiNote);
$("#emr_iris_kanan").val(dataassesment.data.IrisKa);
$("#emr_iris_kanan_detail").val(dataassesment.data.IriKaNote);
$("#emr_iris_kiri").val(dataassesment.data.IriKi);
$("#emr_iris_kiri_detail").val(dataassesment.data.IriKiNote);
$("#emr_lensa_kanan").val(dataassesment.data.LensaKa);
$("#emr_lensa_kanan_detail").val(dataassesment.data.LenasKaNote);
$("#emr_lensa_kiri").val(dataassesment.data.LensaKi);
$("#emr_lensa_kiri_detail").val(dataassesment.data.LensaKiNote);
$("#emr_lainlain_kanan").val(dataassesment.data.Lain2Ka);
$("#emr_lainlain_kanan_detail").val(dataassesment.data.Lain2KaNote);
$("#emr_lainlain_kiri").val(dataassesment.data.Lain2Ki);
$("#emr_lainlain_kiri_detail").val(dataassesment.data.Lain2KiNote);
$("#emr_retina_kanan").val(dataassesment.data.RetinaKa);
$("#emr_retina_kanan_detail").val(dataassesment.data.RetinakaNote);
$("#emr_retina_kiri").val(dataassesment.data.RetinaKi);
$("#emr_retina_kiri_detail").val(dataassesment.data.RetinaKiNote);
$("#emr_disknoptikus_kanan").val(dataassesment.data.OptikusKa);
$("#emr_disknoptikus_kanan_detail").val(dataassesment.data.OptikusKaNote);
$("#emr_disknoptikus_kiri").val(dataassesment.data.OptikusKi);
$("#emr_disknoptikus_kiri_detail").val(dataassesment.data.OptikusKiNote);
$("#emr_cdratio_kanan_detail").val(dataassesment.data.CDRatioKa);
$("#emr_cdratio_kiri_detail").val(dataassesment.data.CDRatioKi);
$("#emr_keseimbanganotot_kanan").val(dataassesment.data.KesOtotKa);
$("#emr_keseimbanganotot_kanan_detail").val(dataassesment.data.KesOtotKaNote);
$("#emr_keseimbanganotot_kiri").val(dataassesment.data.KesOtotKi);
$("#emr_keseimbanganotot_kiri_detail").val(dataassesment.data.KesOtotKiNote);
$("#emr_tekananintraokuler_kanan_detail").val(dataassesment.data.TIOKa);
$("#emr_tekananintraokuler_kiri_detail").val(dataassesment.data.TIOKi);
$("#emr_malulalutea_kanan").val(dataassesment.data.MakulaLutKa);
$("#emr_malulalutea_kanan_detail").val(dataassesment.data.MakulaLutKaNote);
$("#emr_malulalutea_kiri").val(dataassesment.data.MakulaLutKi);
$("#emr_malulalutea_kiri_detail").val(dataassesment.data.MakulaLutKiNote);
$("#emr_kompusvitreum_kanan").val(dataassesment.data.KorpusVitreumKa);
$("#emr_kompusvitreum_kanan_detail").val(dataassesment.data.KorpusVitreumKaNote);
$("#emr_kompusvitreum_kiri").val(dataassesment.data.KorpusVitreumKi);
$("#emr_kompusvitreum_kiri_detail").val(dataassesment.data.KorpusVitreumKiNote);
$("#emr_arterivena_kanan").val(dataassesment.data.ArteriVenaKa);
$("#emr_arterivena_kanan_detail").val(dataassesment.data.ArteriVenaKaNote);
$("#emr_arterivena_kiri").val(dataassesment.data.ArteriVenaKi);
$("#emr_arterivena_kiri_detail").val(dataassesment.data.ArteriVenaKiNote);
$("#emr_testbutawarna_kanan").val(dataassesment.data.TBWaranaKa);
$("#emr_testbutawarna_kanan_detail").val(dataassesment.data.TBWaranaKaNote);
$("#emr_testbutawarna_kiri").val(dataassesment.data.TBWaranaKi);
$("#emr_testbutawarna_kiri_detail").val(dataassesment.data.TBWaranaKiNote);
$("#emr_kesimpulan_mata").val(dataassesment.data.Kesimpulan);
$("#emr_saran_mata").val(dataassesment.data.Saran);
$("#emr_dokter_mata").val(dataassesment.data.DokterPemeri);
}

function asyncShowMasalahKeperawatan() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_masalahkeperawatan').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_masalahkeperawatan').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataMasalahKeperawatan", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg_pasien = noreg_pasien
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "ID" },
                            { "data": "No_DP" },
                            { "data": "Diagnosa_Keperawatan" },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                            //   var html  = '<button type="button" title="Update" class="btn btn-success btn-xs" id="btn_updatemasalahkeperawatan" onclick="UpdateMasalahKeperawatan(' + row.ID + ',this)" ><span class="glyphicon glyphicon-pencil"></span> Edit Data</button>'
                            //      return html 
                                 var html = `<button type="button" title="Update" class="btn btn-success btn-xs" id="btn_updatemasalahkeperawatan" onclick="UpdateMasalahKeperawatan('${row.ID }','${row.No_DP }','${row.Diagnosa_Keperawatan }')" ><span class="glyphicon glyphicon-pencil"></span> Edit Data</button>`
                                 return html
                          }
                      },
                           ],
        'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        },
        'order' : [1,'asc']
     });
}
async function UpdateCPPT(idmasalah,nodpmasalah,S,O,A,P,userentry){
    $("#emr_id_cppt").val(idmasalah);
    $("#emr_nodp_cppt").val(nodpmasalah);
    $("#emr_cppt_s").val(S); 
    $("#emr_cppt_o").val(O); 
    $("#emr_cppt_a").val(A); 
    $("#emr_cppt_p").val(P); 
    $("#userentry").val(userentry); 
    $('#modalcppt').modal('show');
}
async function UpdateMasalahKeperawatan(idmasalah,nodpmasalah,diagnosamasalah){
    $("#emr_id_masalahkeperawatan").val(idmasalah);
    $("#emr_nodp_masalahkeperawatan").val(nodpmasalah);
    $("#emr_diagnosa_masalahkeperawatan").val(diagnosamasalah);
    $('#modalmasalahkeperawatan').modal('show');
}
function BtnBtlCPPT(thisid){
    var table = $('#tbl_cppt').DataTable();
    var form = $("#form_cpptlist");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idcppt\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idcppt[]')
              .val(rowId)
       );
    });
   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }
    //Swal
    swal({
        title: "Warning",
        text: "Pastikan menceklis data sesuai yang akan di hapus !",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    BtlCPPT(id);
            } 
        });
}
async function BtlCPPT(data) {
    try {
        const dataBtlCPPT = await BtlCPPTExecute(data);
        updateUIdataBtlCPPTa(dataBtlCPPT);
    } catch (err) {
        toast(err.message, "error")
    }
}
function updateUIdataBtlCPPTa(params) {
    let dataparams = params;
    console.log("dataparams",dataparams);
    if (dataparams.status == "success") {
        swal("Transaksi CPPT",  "BERHASIL DIHAPUS", "success");
        asyncShowcppt();
    }else{
        toast(response.message, "error")
    }
}
function BtlCPPTExecute(data) {
    var form = $("#form_cpptlist").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/setBatalCPPT';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
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

function BtnBtlMasalahKeperawatan(thisid){
    var table = $('#tbl_masalahkeperawatan').DataTable();
    var form = $("#form_masalahkeperawatan1");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idmasalahkeperawatan\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idmasalahkeperawatan[]')
              .val(rowId)
       );
    });
   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }
    //Swal
    swal({
        title: "Warning",
        text: "Pastikan menceklis data sesuai yang akan di hapus !",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    BtlMasalahKeperawatan(id);
            } 
        });
}
async function BtlMasalahKeperawatan(data) {
    try {
        const dataBtlMasalah = await BtlMasalah(data);
        updateUIdataBtlMasalah(dataBtlMasalah);
    } catch (err) {
        toast(err.message, "error")
    }
}

function BtlMasalah(data) {
    var form = $("#form_masalahkeperawatan1").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/setBatalMasalahKeperawatan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message);
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

function updateUIdataBtlMasalah(params) {
    let dataparams = params;
    if (dataparams.status == "success") {
        swal("Transaksi Masalah Keperawatan",  "BERHASIL DIHAPUS", "success");
        asyncShowMasalahKeperawatan();
    }else{
        toast(response.message, "error")
    }
}

async function BtnSimpanData(){
    try{
        const dataSaveAssesment = await SaveAssesment();
        updateUIdataSaveAssesment(dataSaveAssesment);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveAssesment() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var mr_pasien = $("#emr_norm").val();
    var nama_wakil = $("#emer_namawakil").val();
    var umur_wakil = $("#emr_umurwakil").val();
    var nik_wakil = $("#emr_nikwakil").val();
    var nohp_wakil = $("#emr_nohpwakil").val();
    var pekerjaan_wakil = $("#emr_pekerjaanwakil").val();
    var alamat_wakil = $("#emr_alamatwakil").val();
    var hubungan_wakil = $("#emr_hubunganwakil").val();
    var keterangan_wakil = $("#emr_keteranganwakil").val();
    var jeniskelamin_wakil = $("#emr_jeniskelaminwakil").val();

    var form_assesment = $("#form_assesment").serialize();
    var checkbox_nariwayatalergi=convertBoleanToBit($("#emr_nariwayatalergi").is(":checked"));

    var form_triagecovid = $("#form_triagecovid").serialize();
    var checkbox_naskrinningtbc=convertBoleanToBit($("#emr_naskrinningtbc").is(":checked"));
    var checkbox_negatif=convertBoleanToBit($("#emr_negatif").is(":checked"));
    var checkbox_odp=convertBoleanToBit($("#emr_odp").is(":checked"));
    var checkbox_tbc=convertBoleanToBit($("#emr_tbc").is(":checked"));
    var checkbox_pinerelainnya=convertBoleanToBit($("#emr_pinerelainnya").is(":checked"));

    var form_anamnesis = $("#form_anamnesis").serialize();
    var form_skriningjatuh = $("#form_skriningjatuh").serialize();
    var checkbox_emr_naskrinningjatuhanak=convertBoleanToBit($("#emr_naskrinningjatuhanak").is(":checked"));
    var checkbox_emr_risikorendahjatuh=convertBoleanToBit($("#emr_risikorendahjatuh").is(":checked"));
    var checkbox_emr_risikotinggijatuh=convertBoleanToBit($("#emr_risikotinggijatuh").is(":checked"));
    var checkbox_emr_naskrinningrisikojatuhmobilisasi=convertBoleanToBit($("#emr_naskrinningrisikojatuhmobilisasi").is(":checked"));
    var checkbox_emr_risikorendahpoinpencegahan=convertBoleanToBit($("#emr_risikorendahpoinpencegahan").is(":checked"));
    var checkbox_emr_risikotinggipoinpencegahan=convertBoleanToBit($("#emr_risikotinggipoinpencegahan").is(":checked"));
    var checkbox_emr_tindakanmandiriperawat=convertBoleanToBit($("#emr_tindakanmandiriperawat").is(":checked"));
    var checkbox_emr_kolaborasi=convertBoleanToBit($("#emr_kolaborasi").is(":checked"));

    var form_skriningnutrisi = $("#form_skriningnutrisi").serialize();
    var checkbox_emr_skrinningnutrisianak=convertBoleanToBit($("#emr_skrinningnutrisianak").is(":checked"));
    var checkbox_emr_diarekronik=convertBoleanToBit($("#emr_diarekronik").is(":checked"));
    var checkbox_emr_jantungbawaan=convertBoleanToBit($("#emr_jantungbawaan").is(":checked"));
    var checkbox_emr_hiv=convertBoleanToBit($("#emr_hiv").is(":checked"));
    var checkbox_emr_kanker=convertBoleanToBit($("#emr_kanker").is(":checked"));
    var checkbox_emr_hatikronik=convertBoleanToBit($("#emr_hatikronik").is(":checked"));
    var checkbox_emr_ginjalkronik=convertBoleanToBit($("#emr_ginjalkronik").is(":checked"));
    var checkbox_emr_tbparu=convertBoleanToBit($("#emr_tbparu").is(":checked"));
    var checkbox_emr_terpasangstoma=convertBoleanToBit($("#emr_terpasangstoma").is(":checked"));
    var checkbox_emr_trauma=convertBoleanToBit($("#emr_trauma").is(":checked"));
    var checkbox_emr_lukabakarluas=convertBoleanToBit($("#emr_lukabakarluas").is(":checked"));
    var checkbox_emr_kelainananatomidaerahmulut=convertBoleanToBit($("#emr_kelainananatomidaerahmulut").is(":checked"));
    var checkbox_emr_rencanapascaoperasi=convertBoleanToBit($("#emr_rencanapascaoperasi").is(":checked"));
    var checkbox_emr_kelainanmetabolikbawaan=convertBoleanToBit($("#emr_kelainanmetabolikbawaan").is(":checked"));
    var checkbox_emr_retardasimetal=convertBoleanToBit($("#emr_retardasimetal").is(":checked"));
    var checkbox_emr_stunting=convertBoleanToBit($("#emr_stunting").is(":checked"));
    var checkbox_emr_risikotinggikolaborasiahligizi=convertBoleanToBit($("#emr_risikotinggikolaborasiahligizi").is(":checked"));
    var checkbox_emr_skrinningnutrisidewasa=convertBoleanToBit($("#emr_skrinningnutrisidewasa").is(":checked"));
    var checkbox_emr_risikotinggipilihandengandiagnosisi=convertBoleanToBit($("#emr_risikotinggipilihandengandiagnosisi").is(":checked"));
    var checkbox_emr_skrinningnutrisiibuhamil=convertBoleanToBit($("#emr_skrinningnutrisiibuhamil").is(":checked"));

    var form_komunikasi = $("#form_komunikasi").serialize();
    var checkbox_emr_pengobatan=convertBoleanToBit($("#emr_pengobatan").is(":checked"));
    var checkbox_emr_nutrisi=convertBoleanToBit($("#emr_nutrisi").is(":checked"));
    var checkbox_emr_tindakanmedis=convertBoleanToBit($("#emr_tindakanmedis").is(":checked"));
    var checkbox_emr_keperawatan=convertBoleanToBit($("#emr_keperawatan").is(":checked"));
    var checkbox_emr_lainkebutuhandeukasi=convertBoleanToBit($("#emr_lainkebutuhandeukasi").is(":checked"));

    var form_spiritual = $("#form_spiritual").serialize();
    var checkbox_emr_tenang=convertBoleanToBit($("#emr_tenang").is(":checked"));
    var checkbox_emr_sedihmenangis=convertBoleanToBit($("#emr_sedihmenangis").is(":checked"));
    var checkbox_emr_cemasgelisah=convertBoleanToBit($("#emr_cemasgelisah").is(":checked"));
    var checkbox_emr_takutsekitar=convertBoleanToBit($("#emr_takutsekitar").is(":checked"));
    var checkbox_emr_mudahmarah=convertBoleanToBit($("#emr_mudahmarah").is(":checked"));

    var form_gigi = $("#form_gigi").serialize();
    var checkbox_emr_napengkajiangigi=convertBoleanToBit($("#emr_napengkajiangigi").is(":checked"));

    var checkbox_emr_bibirpecah=convertBoleanToBit($("#emr_bibirpecah").is(":checked"));
    var checkbox_emr_bibirberdarah=convertBoleanToBit($("#emr_bibirberdarah").is(":checked"));
    var checkbox_emr_bibirsianosis=convertBoleanToBit($("#emr_bibirsianosis").is(":checked"));
    var checkbox_emr_bibirpucat=convertBoleanToBit($("#emr_bibirpucat").is(":checked"));
    var checkbox_emr_bibirbengkak=convertBoleanToBit($("#emr_bibirbengkak").is(":checked"));

    var checkbox_emr_bcg=convertBoleanToBit($("#emr_bcg").is(":checked"));
    var checkbox_emr_dpt=convertBoleanToBit($("#emr_dpt").is(":checked"));
    var checkbox_emr_polio=convertBoleanToBit($("#emr_polio").is(":checked"));
    var checkbox_emr_campak=convertBoleanToBit($("#emr_campak").is(":checked"));
    var checkbox_emr_mmr=convertBoleanToBit($("#emr_mmr").is(":checked"));
    var checkbox_emr_hepb=convertBoleanToBit($("#emr_hepb").is(":checked"));
    var checkbox_emr_hepa=convertBoleanToBit($("#emr_hepa").is(":checked"));
    var checkbox_emr_boster=convertBoleanToBit($("#emr_boster").is(":checked"));
    var checkbox_emr_hibi=convertBoleanToBit($("#emr_hibi").is(":checked"));
    var checkbox_emr_varicela=convertBoleanToBit($("#emr_varicela").is(":checked"));
    var checkbox_emr_rotavirus=convertBoleanToBit($("#emr_rotavirus").is(":checked"));
    var checkbox_emr_pneumonia=convertBoleanToBit($("#emr_pneumonia").is(":checked"));
    var checkbox_emr_thypoid=convertBoleanToBit($("#emr_thypoid").is(":checked"));
    var checkbox_emr_influenza=convertBoleanToBit($("#emr_influenza").is(":checked"));

    var form_planning = $("#form_planning").serialize();
    var form_kesimpulan = $("#form_kesimpulan").serialize();
    var checkbox_emr_rujuk=convertBoleanToBit($("#emr_rujuk").is(":checked"));

    

    let url = base_url + '/SIKBREC/public/aEMR/setSaveAssesment';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'noreg_pasien=' +  noreg_pasien +
                '&mr_pasien=' + mr_pasien +
                '&nama_wakil=' + nama_wakil +
                '&umur_wakil=' + umur_wakil +
                '&nik_wakil=' + nik_wakil +
                '&nohp_wakil=' + nohp_wakil +
                '&pekerjaan_wakil=' + pekerjaan_wakil +
                '&alamat_wakil=' + alamat_wakil +
                '&hubungan_wakil=' + hubungan_wakil +
                '&keterangan_wakil=' + keterangan_wakil +
                '&jeniskelamin_wakil=' + jeniskelamin_wakil +

                '&checkbox_nariwayatalergi=' + checkbox_nariwayatalergi +

                '&checkbox_naskrinningtbc=' + checkbox_naskrinningtbc +
                '&checkbox_negatif=' + checkbox_negatif +
                '&checkbox_odp=' + checkbox_odp +
                '&checkbox_tbc=' + checkbox_tbc +
                '&checkbox_pinerelainnya=' + checkbox_pinerelainnya +

                '&checkbox_emr_naskrinningjatuhanak=' + checkbox_emr_naskrinningjatuhanak +
                '&checkbox_emr_risikorendahjatuh=' + checkbox_emr_risikorendahjatuh +
                '&checkbox_emr_risikotinggijatuh=' + checkbox_emr_risikotinggijatuh +
                '&checkbox_emr_naskrinningrisikojatuhmobilisasi=' + checkbox_emr_naskrinningrisikojatuhmobilisasi +
                '&checkbox_emr_risikorendahpoinpencegahan=' + checkbox_emr_risikorendahpoinpencegahan +
                '&checkbox_emr_risikotinggipoinpencegahan=' + checkbox_emr_risikotinggipoinpencegahan +
                '&checkbox_emr_tindakanmandiriperawat=' + checkbox_emr_tindakanmandiriperawat +
                '&checkbox_emr_kolaborasi=' + checkbox_emr_kolaborasi +

                '&checkbox_emr_skrinningnutrisianak=' + checkbox_emr_skrinningnutrisianak +
                '&checkbox_emr_diarekronik=' + checkbox_emr_diarekronik +
                '&checkbox_emr_jantungbawaan=' + checkbox_emr_jantungbawaan +
                '&checkbox_emr_hiv=' + checkbox_emr_hiv +
                '&checkbox_emr_kanker=' + checkbox_emr_kanker +
                '&checkbox_emr_hatikronik=' + checkbox_emr_hatikronik +
                '&checkbox_emr_ginjalkronik=' + checkbox_emr_ginjalkronik +
                '&checkbox_emr_tbparu=' + checkbox_emr_tbparu +
                '&checkbox_emr_terpasangstoma=' + checkbox_emr_terpasangstoma +
                '&checkbox_emr_trauma=' + checkbox_emr_trauma +
                '&checkbox_emr_lukabakarluas=' + checkbox_emr_lukabakarluas +
                '&checkbox_emr_kelainananatomidaerahmulut=' + checkbox_emr_kelainananatomidaerahmulut +
                '&checkbox_emr_rencanapascaoperasi=' + checkbox_emr_rencanapascaoperasi +
                '&checkbox_emr_kelainanmetabolikbawaan=' + checkbox_emr_kelainanmetabolikbawaan +
                '&checkbox_emr_retardasimetal=' + checkbox_emr_retardasimetal +
                '&checkbox_emr_stunting=' + checkbox_emr_stunting +
                '&checkbox_emr_risikotinggikolaborasiahligizi=' + checkbox_emr_risikotinggikolaborasiahligizi +
                '&checkbox_emr_skrinningnutrisidewasa=' + checkbox_emr_skrinningnutrisidewasa +
                '&checkbox_emr_risikotinggipilihandengandiagnosisi=' + checkbox_emr_risikotinggipilihandengandiagnosisi +
                '&checkbox_emr_skrinningnutrisiibuhamil=' + checkbox_emr_skrinningnutrisiibuhamil +

                '&checkbox_emr_pengobatan=' + checkbox_emr_pengobatan +
                '&checkbox_emr_nutrisi=' + checkbox_emr_nutrisi +
                '&checkbox_emr_tindakanmedis=' + checkbox_emr_tindakanmedis +
                '&checkbox_emr_keperawatan=' + checkbox_emr_keperawatan +
                '&checkbox_emr_lainkebutuhandeukasi=' + checkbox_emr_lainkebutuhandeukasi +

                '&checkbox_emr_tenang=' + checkbox_emr_tenang +
                '&checkbox_emr_sedihmenangis=' + checkbox_emr_sedihmenangis +
                '&checkbox_emr_cemasgelisah=' + checkbox_emr_cemasgelisah +
                '&checkbox_emr_takutsekitar=' + checkbox_emr_takutsekitar +
                '&checkbox_emr_mudahmarah=' + checkbox_emr_mudahmarah +

                '&checkbox_emr_napengkajiangigi=' + checkbox_emr_napengkajiangigi +

                '&checkbox_emr_bibirpecah=' + checkbox_emr_bibirpecah +
                '&checkbox_emr_bibirberdarah=' + checkbox_emr_bibirberdarah +
                '&checkbox_emr_bibirsianosis=' + checkbox_emr_bibirsianosis +
                '&checkbox_emr_bibirpucat=' + checkbox_emr_bibirpucat +
                '&checkbox_emr_bibirbengkak=' + checkbox_emr_bibirbengkak +

                '&checkbox_emr_bcg=' + checkbox_emr_bcg +
                '&checkbox_emr_dpt=' + checkbox_emr_dpt +
                '&checkbox_emr_polio=' + checkbox_emr_polio +
                '&checkbox_emr_campak=' + checkbox_emr_campak +
                '&checkbox_emr_mmr=' + checkbox_emr_mmr +
                '&checkbox_emr_hepb=' + checkbox_emr_hepb +
                '&checkbox_emr_hepa=' + checkbox_emr_hepa +
                '&checkbox_emr_boster=' + checkbox_emr_boster +
                '&checkbox_emr_hibi=' + checkbox_emr_hibi +
                '&checkbox_emr_varicela=' + checkbox_emr_varicela +
                '&checkbox_emr_rotavirus=' + checkbox_emr_rotavirus +
                '&checkbox_emr_pneumonia=' + checkbox_emr_pneumonia +
                '&checkbox_emr_thypoid=' + checkbox_emr_thypoid +
                '&checkbox_emr_influenza=' + checkbox_emr_influenza +

                '&checkbox_emr_rujuk=' + checkbox_emr_rujuk +

                '&form_assesment=' + form_assesment +
                '&form_triagecovid=' + form_triagecovid +
                '&form_anamnesis=' + form_anamnesis +
                '&form_skriningjatuh=' + form_skriningjatuh +
                '&form_skriningnutrisi=' + form_skriningnutrisi +
                '&form_komunikasi=' + form_komunikasi +
                '&form_spiritual=' + form_spiritual +
                '&form_gigi=' + form_gigi +
                '&form_planning=' + form_planning +
                '&form_kesimpulan=' + form_kesimpulan
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
function updateUIdataSaveAssesment(dataSaveAssesment) {
    let dataAssesment = dataSaveAssesment;
    if (dataAssesment.status == "success") {
        swal("DATA ASSESMENT",  "BERHASIL DISIMPAN", "success");
        asyncShowWakilPasien();
        asyncShowAssesment();
    }else{
        toast(response.message, "error")
    }
}

async function btnSaveModalMasalahKeperawatan(){
    try{
        const dataSaveMasalahKeperawatan = await SaveMasalahKeperawatan();
        updateUIdataSaveMasalahKeperawatan(dataSaveMasalahKeperawatan);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveMasalahKeperawatan() {
    var base_url = window.location.origin;
    var form_masalahkeperawatan = $("#form_masalahkeperawatan").serialize();

    let url = base_url + '/SIKBREC/public/aEMR/setSaveMasalahKeperawatan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_masalahkeperawatan
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
function updateUIdataSaveMasalahKeperawatan(dataSaveMasalahKeperawatan) {
    let dataMasalahKeperawatan = dataSaveMasalahKeperawatan;
    if (dataMasalahKeperawatan.status == "success") {
        swal("Transaksi Masalah Keperawatan",  "BERHASIL DISIMPAN", "success");
        asyncShowMasalahKeperawatan();
        $('#modalmasalahkeperawatan').modal('hide');

    }else{
        toast(response.message, "error")
    }
}

async function btnCloseModalMasalahKeperawatan(){
    $('#modalmasalahkeperawatan').modal('hide');
    clear_modal_masalahkeperawatan();
}
async function btnCloseModalCppt(){
    $('#modalcppt').modal('hide');
    clear_modal_cppt();
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

function convertBoleanToBit($data) {
    var convertboleanbit = $data ? 1 : 0;
    return convertboleanbit;
}

function convertBitToBolean($data) {
    // var convertbitbolean = $data ? true : false;
    // return convertbitbolean;
    var convertbitbolean = $data;
    if(convertbitbolean == "1"){
        convertbitbolean = true;
    }
    else{
        convertbitbolean = false;
    }
    return convertbitbolean;
}
// cppt
async function btnSaveModalCPPT(){
    try{
        const dataSaveCPPT = await SaveCPPT();
        updateUIdataSaveCPPT(dataSaveCPPT);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveCPPT() {
    var base_url = window.location.origin;
    var form_CPPT = $("#form_cppt").serialize();

    let url = base_url + '/SIKBREC/public/aEMR/setSaveCPPT';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_CPPT
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
function updateUIdataSaveCPPT(dataCPPT) {
    let dataMasalahKeperawatan = dataCPPT;
    if (dataMasalahKeperawatan.status == "success") {
        clear_modal_cppt();
        swal("Transaksi SOAP",  "BERHASIL DISIMPAN", "success");
        asyncShowcppt();
        
        $('#modalcppt').modal('hide');

    }else{
        toast(response.message, "error")
    }
}
function asyncShowcppt() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_cppt').DataTable().clear().destroy();

    $('#tbl_cppt').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aEMR/getDataCPPT",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.noreg_pasien = noreg_pasien
            }
        }, 
            "columns": [
                            { "data": "ID" },
                            { 
                                "render": function (data, type, row) {
                                    var html = ""
                                    var html = `<span class="label label-primary">Input ( User/Date ) : </span><br>${row.User_Input}<br> ${row.Date_Input}
                                    <br><br><span class="label label-success">Update ( User/Date ) : </span><br> ${row.User_Update}<br> ${row.Date_Update}`;
                                    return html
                                }
                            },
                            { 
                                "render": function (data, type, row) {
                                    var html = ""
                                    var html = `<B>S : </B><br> ${row.S}<br><br><B>O : </B><br> ${row.O}<br><br><B>A : </B><br> ${row.A}<br><br><B>P : </B><br> ${row.P}
                                    <br><br><button type="button" title="Update" class="btn btn-success btn-xs" id="btn_updatecppt" onclick="UpdateCPPT('${row.ID }','${row.No_DP }','${row.S }','${row.O }','${row.A }','${row.P }','${row.User_InputID}')" ><span class="glyphicon glyphicon-pencil"></span> Edit Data</button>`;
                                    return html
                                }
                            }, 
                           
                           ],
        'columnDefs': [
           {
              'targets': 0,
              'checkboxes': {
                 'selectRow': true
              }
           }
        ],
        'select': {
           'style': 'multi'
        }, 

     });
}
// assesment rajal 
async function BtnSimpanDataAssesmentRajal(){
    try{
        const dataSaveAssesmentRajal = await SaveAssesmentRajal();
        updateUIdataSaveAssesmentRajal(dataSaveAssesmentRajal);
    }catch (err) {
        toast(err.message, "error")
    }
}
function updateUIdataSaveAssesmentRajal(dataSaveAssesmentRajal) {
    let datasave = dataSaveAssesmentRajal;
    if (datasave.status == "success") {
        swal("Transaksi Save Assesment Rajal",  "BERHASIL DISIMPAN", "success");
    }else{
        toast(response.message, "error")
    }
}
function SaveAssesmentRajal() {
    var base_url = window.location.origin;
    var form_mata = $("#form_assesment").serialize();
    var noreg_pasien = $("#emr_noreg").val();
    var mr_pasien = $("#emr_norm").val();
    var checkbox_nariwayatalergi=convertBoleanToBit($("#emr_nariwayatalergi").is(":checked"));
    var checkbox_emr_rujuk=convertBoleanToBit($("#emr_rujuk").is(":checked"));
    var form_planning = $("#form_planning").serialize();
    var form_kesimpulan = $("#form_kesimpulan").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/setSaveAssesmentRajal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_mata + '&noreg_pasien=' +  noreg_pasien + '&mr_pasien=' +  mr_pasien + '&form_planning=' +  form_planning 
        + '&form_kesimpulan=' +  form_kesimpulan + '&checkbox_nariwayatalergi=' +  checkbox_nariwayatalergi
        + '&checkbox_emr_rujuk=' +  checkbox_emr_rujuk 
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
// Asesment Mata
async function BtnSimpanDataMata(){
    try{
        const dataSaveAssesmentMata = await SaveAssesmentMata();
        updateUIdataSaveAssesmentMata(dataSaveAssesmentMata);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveAssesmentMata() {
    var base_url = window.location.origin;
    var form_mata = $("#asesementmata").serialize();

    let url = base_url + '/SIKBREC/public/aEMR/setSaveAssesmentMata';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_mata
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
function updateUIdataSaveAssesmentMata(dataSaveAssesmentMata) {
    let datasavemata = dataSaveAssesmentMata;
    if (datasavemata.status == "success") {
        swal("Transaksi Save Assesment Mata",  "BERHASIL DISIMPAN", "success");
    }else{
        toast(response.message, "error")
    }
}

// RESEP
function modalResepDokterNew(){
    newResepDokter();
}

async function newResepDokter(){
    try{
        const dataGetNewResepDokter = await GetNewResepDokter();
        updateUIdataGetNewResepDokter(dataGetNewResepDokter);
    }catch (err) {
        toast(err.message, "error")
    }
}
function GetNewResepDokter() {
    var base_url = window.location.origin;
    var form_resepdetail = $("#form_resepdetail").serialize();

    let url = base_url + '/SIKBREC/public/aEMR/setSaveGetNewOrderResep';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  form_resepdetail
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
function updateUIdataGetNewResepDokter(dataGetNewResepDokter) {
    let datagetgenid = dataGetNewResepDokter;
    $("#emr_orderid_resep").val(datagetgenid.data.GenID);
    $("#modalresepdokterdetail").modal('show');
}

function asyncShowListObat() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listproduct_resep').css('display', 'none');
    $('#tbl_listproduct_resep').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listproduct_resep').DataTable({
        paging: false,
        scrollCollapse: true,
        scrollY: '50vh',
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataListProductObat", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
    "deferRender": true,
    }, 

    "columns": [
                    // { "data": "ID" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTable('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:100px; height:100%"> ${row.ID} </div> </a></td>`
                        return html
                        }
                    },
                    // { "data": "ProductName" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTable('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:380px; height:100%"> ${row.ProductName} </div> </a></td>`
                        return html
                        }
                    },
                    // { "data": "UnitSatuan" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTable('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:150px; height:100%"> ${row.UnitSatuan} </div> </a></td>`
                        return html
                        }
                    },
                ]
    });
    $('#tbl_listproduct_resep').css('display', 'block');
}

function asyncShowListResep() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listresep_byreg').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listresep_byreg').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataListResepByNoreg", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
    "deferRender": true,
    }, 

    "columns": [
                    { "data": "ID" },
                    { "data": "IdOrderResep" },
                    { "data": "NamaBarang" },
                    { "data": "QryOrder" },
                    { "data": "QryRealisasi" },
                    { "data": "Signa" },
                    { "data": "StatusResep" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        ` <button type="button" title="Update" class="btn btn-success btn-xs" onclick="viewDataDetailResep('${row.IdOrderResep }')"> View Data </button>`
                        return html
                        }
                    },

                ],
                'columnDefs': [
                    {
                       'targets': 0,
                       'checkboxes': {
                          'selectRow': true
                       }
                    }
                 ],
                 'select': {
                    'style': 'multi'
                 }, 
                 
    });
    // $('#tbl_listproduct_resep').css('display', 'block');
}

async function viewDataDetailResep(IdOrderResep){
    try{
        const dataGetviewDataDetailResep = await GetviewDataDetailResep(IdOrderResep);
        updateUIdataGetviewDataDetailResep(dataGetviewDataDetailResep);
    }catch (err) {
        toast(err.message, "error")
    }
}
function GetviewDataDetailResep(IdOrderResep) {
    var base_url = window.location.origin;
    var idhdr = IdOrderResep;
    // console.log(idhdr);
    // return false;

    let url = base_url + '/SIKBREC/public/aEMR/getDataDetailResepByIDHDR';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                'idhdr=' +  idhdr 
                // '&mr_pasien=' + mr_pasien +
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
function updateUIdataGetviewDataDetailResep(dataGetviewDataDetailResep) {
    let dataresep = dataGetviewDataDetailResep;
    $("#modalresepdokterdetail").modal('show');
    $("#emr_orderid_resep").val(dataresep.data.ID);
    $("#emr_orderdate_resep").val(dataresep.data.TglResep);
    $("#emr_iduserentri_resep").val(dataresep.data.UserOrder);
    $("#emr_userentri_resep").val(dataresep.data.NamaUserOrder);
    $("#emr_jenis_resep").val(dataresep.data.JenisResep);
    $("#emr_idunit_resep").val(dataresep.data.UnitOrder);
    $("#emr_unit_resep").val(dataresep.data.NamaUnitOrder);
    $("#emr_iter_resep").val(dataresep.data.Iter);
    asyncShowListResepbyOrderID();
}

function asyncShowListResepbyOrderID() {
    var base_url = window.location.origin;
    var idhdr = $("#emr_orderid_resep").val();
    $('#tbl_listresep_detail_byidorder').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listresep_detail_byidorder').DataTable({
            // responsive:true,
            dom: 'Qfrtip',
            // paging: false,
            // scrollCollapse: true,
            // scrollY: '20vh',
            'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataListResepByIDHDR", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.idhdr = idhdr
        },
        "dataSrc": "",
    "deferRender": true,
    }, 

    "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                          if(row.Racik == "0"){ 
                              var cek1  = 'Non Racik'
                          }else{
                            var cek1  = 'Racik'
                          }
                          var html = '<span>'+cek1+'</span>'
                             return html 
                      }
                    },
                    { "data": "NamaBarang" },
                    { "data": "QryOrder" },
                    { "data": "Signa" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        ` <button type="button" title="Update" class="btn btn-danger btn-xs" onclick="btlResepDetail('${row.ID }')"> Delete </button>`
                        return html
                        }
                    },

                ]
    });
}

async function btlResepDetail(id){
    try{
        const dataSetBtlResepDetail = await SetBtlResepDetail(id);
        updateUIdataSetBtlResepDetail(dataSetBtlResepDetail);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SetBtlResepDetail(id) {
    var base_url = window.location.origin;
    var iddetail = id;
    // console.log(iddetail);
    // return false;
    let url = base_url + '/SIKBREC/public/aEMR/setDeleteDetailResepByID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                'iddetail=' +  iddetail 
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
function updateUIdataSetBtlResepDetail(dataGetviewDataDetailResep) {
    let dataresep = dataGetviewDataDetailResep;
    console.log("datasssssss",dataresep);
    if (dataresep.status == "success") {
        swal("Transaksi Obat",  "BERHASIL DIHAPUS", "success");
    }else{
        toast(response.message, "error")
    }
    asyncShowListResepbyOrderID();
}

// async function btnSaveResepDokter(){
//     $('#modalresepdokterdetail').modal('hide');
//     location.reload();
// }
async function btnCloseModalResepDokter(){
        $('#modalresepdokterdetail').modal('hide');
        location.reload();
}

async function GetObatByTable(param1, param2, param3, param4){
    // console.log(param1);
    // console.log(param2);
    // console.log(param3);
    console.log(param4);
    $("#emr_namaobat_resep").val(param2);
    $("#emr_satuan_resep").val(param3);
    $("#emr_productcode_resep").val(param1);
}

async function btnTambahResepDetail(){
    try{
        const dataSetTambahResepDetail = await SetTambahResepDetail();
        updateUIdataSetTambahResepDetail(dataSetTambahResepDetail);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SetTambahResepDetail() {
    var base_url = window.location.origin;
    // var iddetail = id;
    // console.log(iddetail);
    // return false;
    var form_resepdetail = $("#form_resepdetail").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/newSetTambahResepDetail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                // 'iddetail=' +  iddetail 
                form_resepdetail
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
function updateUIdataSetTambahResepDetail(dataSetTambahResepDetail) {
    let dataresepdetail = dataSetTambahResepDetail;
    if (dataresepdetail.status == "success") {
        swal("Transaksi Resep Detail",  "Berhasil Ditambahkan", "success");
    }else{
        toast(response.message, "error")
    }
    asyncShowListResepbyOrderID();
}

async function BtnSimpanDataResepFinal(){
    try{
        const dataSetUpdateFinalResep = await SetUpdateFinalResep();
        updateUIdataSetUpdateFinalResep(dataSetUpdateFinalResep);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SetUpdateFinalResep() {
    var base_url = window.location.origin;
    var form_resepdetail = $("#form_resepdetail").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/SetUpdateFinalResepDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                // 'iddetail=' +  iddetail 
                form_resepdetail
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
function updateUIdataSetUpdateFinalResep(dataSetUpdateFinalResep) {
    let dataresepfinish = dataSetUpdateFinalResep;
    if (dataresepfinish.status == "success") {
        swal("Transaksi Resep Selesai",  "Berhasil", "success")
        .then((result) => {
                    if(result) {
                        $('#modalresepdokterdetail').modal('hide');
                        location.reload();
                    } else {
                    }
                });
    }else{
        toast(response.message, "error")
    }
}

function btnTambahResepDetailRacik() {
    asyncShowListObatRacik();
    $('#modalresepdokterdetailracik').modal('show');
}

function asyncShowListObatRacik() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    $('#tbl_listproduct_resep_racik').css('display', 'none');
    $('#tbl_listproduct_resep_racik').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listproduct_resep_racik').DataTable({
        dom: 'Qfrtip',
        paging: false,
        scrollCollapse: true,
        scrollY: '50vh',
        // responsive: true,
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataListProductObat", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.noreg_pasien = noreg_pasien
        },
        "dataSrc": "",
    "deferRender": true,
    }, 

    "columns": [
                    // { "data": "ID" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTableRacik('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:50px; height:100%"> ${row.ID} </div> </a></td>`
                        return html
                        }
                    },
                    // { "data": "ProductName" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTableRacik('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:130px; height:100%"> ${row.ProductName} </div> </a></td>`
                        return html
                        }
                    },
                    // { "data": "UnitSatuan" },
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        var html = 
                        `<td><a onclick="GetObatByTableRacik('${row.ID }','${row.ProductName }','${row.UnitSatuan }','${row.ProductCode}')"> <div id="e1" style="width:100px; height:100%"> ${row.UnitSatuan} </div> </a></td>`
                        return html
                        }
                    },
                ]
    });
    $('#tbl_listproduct_resep_racik').css('display', 'block');
}

async function GetObatByTableRacik(param1, param2, param3, param4){
    // console.log(param1);
    // console.log(param2);
    // console.log(param3);
    console.log(param4);
    $("#emr_namaobat_resepracikdetail").val(param2);
    $("#emr_satuan_resepracikdetail").val(param3);
    $("#emr_productcode_resepracikdetail").val(param1);
}

async function btnCloseModalResepDokteRacikan(){
    $('#modalresepdokterdetailracik').modal('hide');
}

async function btnNewResepDetailHeader(){
    try{
        const dataSetNewResepDetailHeader = await SetNewResepDetailHeader();
        updateUIdataSetNewResepDetailHeader(dataSetNewResepDetailHeader);
    }catch (err) {
        toast(err.message, "error")
    }
}

function SetNewResepDetailHeader() {
    var base_url = window.location.origin;
    var form_resepdetail = $("#form_resepdetail").serialize();
    var form_resepdetailracik = $("#form_resepdetailracik").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/SetNewResepDetailHeader';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                // 'iddetail=' +  iddetail 
                form_resepdetail + form_resepdetailracik
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
function updateUIdataSetNewResepDetailHeader(dataSetNewResepDetailHeader) {
    let dataresepracikheader = dataSetNewResepDetailHeader;
    $("#emr_number_resepracik").val(dataresepracikheader.data.nexturut);
    var noracik = dataresepracikheader.data.nexturut;

    asyncShowListResepbyOrderIDandHeader(noracik);
}

function asyncShowListResepbyOrderIDandHeader(noracik) {
    var base_url = window.location.origin;
    var idhdr = $("#emr_orderid_resep").val();
    var noracik = noracik;
    $('#tbl_listresep_detail_byidorderracik').dataTable({
        "bDestroy": true
    }).fnDestroy();
        $('#tbl_listresep_detail_byidorderracik').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aEMR/getDataListResepByIDHDRRacik", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
        d.idhdr = idhdr,
        d.noracik = noracik
        },
        "dataSrc": "",
    "deferRender": true,
    }, 

    "columns": [
                    { "data": "NamaBarang" },
                    { "data": "QryOrder" }
                ]
    });
}
async function btnTambahResepDetailRacikObat(){
    try{
        const dataSetTambahResepDetailRacikObat = await SetTambahResepDetailRacikObat();
        updateUIdataSetTambahResepDetailRacikObat(dataSetTambahResepDetailRacikObat);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SetTambahResepDetailRacikObat() {
    var base_url = window.location.origin;
    var form_resepdetail = $("#form_resepdetail").serialize();
    var form_resepdetailracik = $("#form_resepdetailracik").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/newSetTambahResepDetailRacikObat';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  
                // 'iddetail=' +  iddetail 
                form_resepdetail + form_resepdetailracik
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
function updateUIdataSetTambahResepDetailRacikObat(dataSetTambahResepDetailRacikObat) {
    let dataresepdetailracik = dataSetTambahResepDetailRacikObat;
    if (dataresepdetailracik.status == "success") {
        swal("Transaksi Resep Detail Racik",  "Berhasil Ditambahkan", "success");
    }else{
        toast(response.message, "error")
    }
    var noracik = dataresepdetailracik.data.numberracik;
    asyncShowListResepbyOrderIDandHeader(noracik);
}

async function BtnSimpanDataResepFinalRacikan(){

    $('#modalresepdokterdetailracik').modal('hide');
    asyncShowListResepbyOrderID();
    var datakosong = '';
    $("#emr_number_resepracik").val(datakosong);
    $("#emr_jenis_resepracik").val(datakosong);
    $("#emr_signa_resepracik").val(datakosong);
    $("#emr_qty_resepracik").val(datakosong);

    $("#emr_productcode_resepracikdetail").val(datakosong);
    $("#emr_namaobat_resepracikdetail").val(datakosong);
    $("#emr_satuan_resepracikdetail").val(datakosong);
    $("#emr_qty_resepracikdetail").val(datakosong);
    $('#tbl_listresep_detail_byidorderracik').DataTable().clear().destroy();
}