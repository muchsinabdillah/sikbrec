$(document).ready(function () {   
    
    document.getElementById("caridiagnosaBPJS2").disabled = true;
    document.getElementById("cariPoliklinikBPJS").disabled = true;
    document.getElementById("cariDokterBPJS").disabled = true;
    $('#tiperegistrasi').select2();
    $("#admiedika").hide();
    clearForm();   
    onLoadFunctionAll();
    showModalJenisReg();
    $('#refreshjadwal').click(function () {
        var idjaminan = document.getElementById("namajaminanid").value;
        getJamPraktek(idjaminan);
    });
    $('#btnsendantrian').click(function () {
        var pxNoSep = document.getElementById("pxNoSep").value;
        console.log("nosep",pxNoSep);
    });
    $('#btnCloseVerifKartu').click(function () {
        $('#modal_BPJSCekPesertaa').modal('show');
    });
    $('#btnRefreshKecamatan').click(function () {
        GoGetDataBpjsKecamatan();
    });
    $('#btnSendAntrol').click(function () {
        BPJSCreateAntrian();
    });
    $('#btnSendAntrolClose').click(function () {
        $('#notif_Cetak').modal('show');
        $('#modal_AntrolJenisKunungan').modal('hide'); 
    });
   
    $('#btnFingerSearch').click(function () {
       VerificationFinger();
    });
    $('#logopasienadmedika').click(function () {
        $("#admiedika").show();
        
    });
    $('#btnModalSrcfingerClose').click(function () {
        $("#myModalFinger").modal('hide');
        $("#modal_VerifBPJS").modal('show');
    });
   
    $(document).on('click', '#btnclosemodalcetak', function () {
        MyBack();
    });
    $(document).on('click', '#btnInputTrsOrderRad', function () {
        showFormOrderRadiologi();
    });
    $(document).on('click', '#btnInputTrsOrderLab', function () {
        showFormOrderLaboratorium();
    });
    $(document).on('click', '#btnInputTrsOrderMCU', function () {
        showFormOrderMCU();
    });   
    $(document).on('click', '#btnInputFormEdukasi', function () {
            showFormEdukasiPasien();
    });
    // ADD BPJS 
    $(document).on('click', '#btnCloseVerifikasi', function () {
        MyBack();
    });
    // ADD BPJS
    $('#btncetakSep').click(function () {
        
        goCountCetak();
        
    });
    // ADD_BPJS
    $(document).on('click', '#btnCreateSEP', function () {
        BPJSCreateSEP();
    });
    $(document).on('click', '#btnRefreshSign', function () {
        goRefreshDigitalSign();
    });
    // ADD_BPJS
    $(document).on('click', '#btnCariRujukanMulti', function () {
        GoRujukanMultiByKartu();
    });
    
    // ADD_BPJS
    $(document).on('click', '#btnCekRujukanMulti', function () {
        $('#modal_BPJSCekRujukanMulti').modal('show');
        $('#modal_BPJSCekPesertaa').modal('hide');
    });
    // ADD_BPJS
    $(document).on('click', '#btnCekKepesertaan', function () {
        BPJSCekKepesertaan();
        var jenisPencarian = $("#JenisPencarianBPJS").val();
        if (jenisPencarian == "3"){
            BPJSCekJumlahSEPRujukan();
        } 
    });
    // ADD BPJS
    $("#cariPPKRujukanBPJS2").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetFaskesBPJS';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    jenisFaskes: document.getElementById("JenisRujukanFaskesBPJSx").value
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    // ADD BPJS
    $("#caridiagnosaBPJS2").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetDaignosaBPJS';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    }); 
    //add bpjs
    $('#caridiagnosaBPJS2').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodeDiagnosaBPJS").val(data.id);
        $("#NamaDiagnosaBPJS").val(data.text);
    });
    //add bpjs
    $('#cariPPKRujukanBPJS2').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#idppkrujukanBPJS").val(data.id);
        $("#namappkrujukanBPJS").val(data.text); 
    });
    // ADD BPJS
    $("#cariPoliklinikBPJS").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetPoliklinikBPJS'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    //add bpjs
    $('#cariPoliklinikBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodePoliklinikBPJS").val(data.id);
        $("#NamaPoliklinikBPJS").val(data.text);
    });
    $('#cariProvinsi').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSProvinsi").val(data.id);
        $("#SuplesiBPJSProvinsiName").val(data.text); 
        getKabupatenBPJS(data.id);
    });
    $('#cariKabupaten').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSKabupaten").val(data.id);
        $("#SuplesiBPJSKabupatenName").val(data.text);
        getKecamatanBPJS(data.id);
    });
    $('#cariKecamatan').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSKecamatan").val(data.id);
        $("#SuplesiBPJSKecamatanName").val(data.text); 
    });
    // ADD BPJS
    $("#cariDokterBPJS").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetDokterBPJS'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    IdPoliklinik: $('#KodePoliklinikBPJS').val(),
                    isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    //add bpjs
    $('#cariDokterBPJS').on('select2:select', function (e) {
        var datax = e.params.data;
        console.log("data2", datax.text);
        $("#NamaDokterBPJS").val(datax.text); 
        $("#KodeDokterBPJS").val(datax.id);
        // console.log("cari",data.text)
        // $("#NamaDokterBPJS").val(data.text);
        
    });
    $(document).on('click', '#logopasienumum', function () {
        $('#CekkepesertaanBPJS').hide();
        $('#Notif_awal_registrasi').modal('hide');
        var jenisdaftar = "1"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
        $('#PasienNoMR').focus();
    });
    $(document).on('click', '#logopasienadmedika', function () {
        $('#CekkepesertaanADMEDIKA').show();
        $('#Notif_awal_registrasi').modal('hide');
        var jenisdaftar = "3"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
        $('#PasienNoMR').focus();
    });
    $(document).on('click', '#logopasienbpjs', function () {
        $('#CekkepesertaanBPJS').show();
        $('#Notif_awal_registrasi').modal('hide');
        //$('#modal_VerifBPJS').modal('show');
        $('#modal_BPJSCekPesertaa').modal('show');
        var jenisdaftar = "2"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
        $('#PasienNoMR').focus();
    });
    $(document).on('click', '#pasienkaryawan', function () {
        $('#cekdatakaryawan').show();
        $('#Notif_awal_registrasi').modal('hide');
        var jenisdaftar = "4"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
    });
    $('#poliklinikid').click(function () {
        var noreservasi = $("#pxNoReservasi").val();
        if (noreservasi != "") {
            alert("Tranasksi Dari No. Booking. Edit tidak diizinkan !");
        } else {
            $("#dokterid").val('');
            //$("#hide_poli").show();
            $('#poliklinik').select2();
        }
    });
    $('#btnCreateNewMR').click(function () {
        showMedicalRecordbyId();
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
    $('#btnSearchMrAktif').click(function () {
        loaddatamr();
    });
    $('#btnSavePoli').click(function () {
        goCreatePolisAsuransi();
    });
    $('#btnSavePoli2').click(function () {
        goCreatePolisKaryawan();
    });
    $('#referralid').click(function () {
        //$("#hide_referal").show();
    });
    $('#btnVoidTrsReg').click(function () {
        var namajaminan = document.getElementById("shownamaperusahaanfix").value;
        var grupJaminanid = document.getElementById("grupJaminanid").value;
        var tanapsepBatal = document.getElementById("tanapsepBatal").value;
        if (namajaminan == "BPJS Kesehatan" && grupJaminanid == "5") {
            if (tanapsepBatal =="0"){
                //GoVoidSep();
                voidRegistrasi();
            }else{
                voidRegistrasi();
            } 
        }else{
            voidRegistrasi();
        } 
    });
    
    $('#btnValidateNIK').click(function () {
        var RSY_Kartu_NoPeserta = $("#RSY_Kartu_NoPeserta").val();
        loadNIKKartu(RSY_Kartu_NoPeserta);
    });
    $('#savetrs').click(function () {
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
        
    });
    $('#btnCariReservasi').click(function () {
        show_data_reservasi();
    });
    $(document).on('click', '#logocetakbuktireg', function () {
        var noreg = $("#cetaknoregis").val();
        PrintBuktiRegis(noreg);
    });

    $(document).on('click', '#logocetaklabelpasien', function () {
       var param = $("#cetaklabel").val();
       PrintLabelPasien(param);
   });

   $(document).on('click', '#logocetakgelanganak', function () {
    var param = $("#cetaklabel").val();
    PrintGelangAnak(param);
});

$(document).on('click', '#logocetakgelangdewasa', function () {
    var param = $("#cetaklabel").val();
    PrintGelangDewasa(param);
});

    $(document).on('click', '#logocetakbuktiSEP', function () {
        $('#notif_ShowTTD_Digital').modal('show');
        $('#notif_Cetak').modal('hide');
        var pxNoRegistrasi = $("#pxNoRegistrasi").val();
        var pxNoSep = $("#pxNoSep").val();
        $("#signNoRegistrasi").val(pxNoRegistrasi);
        $("#signNoSep").val(pxNoSep);
        document.getElementById("btncetakSep").disabled = true;
    });
    $(document).on('click', '#btnprint', function () {
        var idlayanan = $("#poliklinikid").val();
        var noregistrasi = $("#pxNoRegistrasi").val();
        var shownamaperusahaanfix = $("#shownamaperusahaanfix").val();
        console.log(shownamaperusahaanfix);
        $("#namajaminanlab").val(shownamaperusahaanfix);

        if (noregistrasi == "") {
            new PNotify({
                title: 'Notifikasi',
                text: 'No. Registrasi Kosong, Silahkan Masukan No. Registrasi Anda !',
                type: 'danger'
            });
        } else if (noregistrasi != "") {
            var substringnoreg = noregistrasi.substring(4, 0);
            console.log(substringnoreg);
            console.log(idlayanan, 'dd');
            if (substringnoreg == "RJUR") {
                document.getElementById("btnInputTrsOrderRad").disabled = false;
                document.getElementById("btnInputTrsOrderLab").disabled = true;
                document.getElementById("btnInputTrsOrderMCU").disabled = true;
            } else if (substringnoreg == "RJUL") {
                document.getElementById("btnInputTrsOrderRad").disabled = true;
                document.getElementById("btnInputTrsOrderLab").disabled = false;
                document.getElementById("btnInputTrsOrderMCU").disabled = true;
            }
            else if (idlayanan == "53") {
                document.getElementById("btnInputTrsOrderRad").disabled = false;
                document.getElementById("btnInputTrsOrderLab").disabled = false;
                document.getElementById("btnInputTrsOrderMCU").disabled = false;
            } else {
                document.getElementById("btnInputTrsOrderRad").disabled = false;
                document.getElementById("btnInputTrsOrderLab").disabled = false;
                document.getElementById("btnInputTrsOrderMCU").disabled = true;
            }

            $('#notif_Cetak').modal('show');
        }

    });

    $("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
        if (e.keyCode == 13) { // Jika user menekan tombol ENTER
            loaddatamr();
        }
  });

  $('#tglregistrasi').change(function () {
    resetsession();

    var date = $("#tglregistrasi").val();

    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    var dateconvert = [year, month, day].join('-');

    $("#tglnow").val(dateconvert)

    });

    
    $(document).on('click', '#print_kartumr', function () {
        var param = $("#Medrec_NoMR").val();
        PrintKartuMR(param);
    });
   
});

async function VerificationFinger() {
    try {
        var cariPoliklinikBPJS = document.getElementById("cariPoliklinikBPJS").value;
        var nokartubpjs = document.getElementById("nokartubpjs").value;
        var TglSEP = document.getElementById("TglSEP").value;
        $("#FingerNoKartu").val(nokartubpjs);
        $("#FingerTgl").val(TglSEP);

        if (cariPoliklinikBPJS == "IRM" || cariPoliklinikBPJS == "MAT" || cariPoliklinikBPJS == "JAN" || cariPoliklinikBPJS == "HDL"){
            $("#myModalFinger").modal('show');
            $("#modal_VerifBPJS").modal('hide');
            $(".preloader").fadeIn();
            const dataGoVerificationFinger = await GoVerificationFinger();
            await GoVerificationFingerList();
            updateUIdataGoVerificationFinger(dataGoVerificationFinger);
            $(".preloader").fadeOut();
        }
            

            
    } catch (err) {
        toast(err, "error")
    }
}
function GoVerificationFingerList() {
    var base_url = window.location.origin;
    var FingerNoKartu = $("#nokartubpjs").val();
    var FingerTgl = $("#TglSEP").val();
    $('#table-finger').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#table-finger').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoVerificationFingerList",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.FingerNoKartu = FingerNoKartu;
                d.FingerTgl = FingerTgl;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.noKartu + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.noSEP + ' </font>  ';
                    return html
                }
            }, 

        ]
    });
} 
function updateUIdataGoVerificationFinger(data) { 
    document.getElementById("FingerStatus").innerHTML = data.hasil[1].status;
    if (data.hasil[1].kode =="1"){
        document.getElementById("btnModalSrcfingerClose").disabled = false;
    }else{
        document.getElementById("btnModalSrcfingerClose").disabled = true;
    }
}
function GoVerificationFinger() {
    var FingerNoKartu = $("#nokartubpjs").val();
    var FingerTgl = $("#TglSEP").val(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoVerificationFinger';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "FingerNoKartu=" + FingerNoKartu + "&FingerTgl=" + FingerTgl
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function validatejeniskunjunganBPJS() {
    try {
        $(".preloader").fadeIn();
        var pxNoSep = $("#pxNoSep").val();
        var noreg = $("#pxNoRegistrasi").val(); 
        const datavalidatesep = await govalidatejeniskunjunganBPJS(pxNoSep, noreg);
        updateuivalidate(datavalidatesep); 
        //AntrolJenisKunungan
        $(".preloader").fadeOut(); 
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateuivalidate(data){
    $('#AntrolJenisKunungan').val(data.jeniskunjungan).trigger('change');
}
function govalidatejeniskunjunganBPJS(pxNoSep, noreg) {  
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/validatejeniskunjunganBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "pxNoSep=" + pxNoSep + "&noreg=" + noreg
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#pxNoSep").val();
        var noreg = $("#pxNoRegistrasi").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, noreg);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs, noreg);
        $(".preloader").fadeOut(); 
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUiSukseshistory(params, notrs, noreg) {
    if(params.status===200){

        var tanpaDigitalSign = document.getElementById("tanpaDigitalSign").value
        if (tanpaDigitalSign == "0") {
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSEP/" + notrs + "/" + noreg, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            MyBack();
        } else {
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSEP2/" + notrs + "/" + noreg, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            MyBack();
        }

       
    }
   
}
function CountCetak(notrs, signAlasanCetak, noreg) {
    var nomortransaksi = $("#signNoSep").val();
    var jeniscetakan = "SEP";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan + "&noreg=" + noreg
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function goRefreshDigitalSign() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCreateSEP = await RefreshDigitalSign();
        console.log(dataGoBPJSCreateSEP);
        updateUIRefreshDigitalSign(dataGoBPJSCreateSEP);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}

function updateUIRefreshDigitalSign(params) {
    var base_url = window.location.origin;
    if(params === false){
        document.getElementById("btncetakSep").disabled = true;
        swal("Oops", "Sorry.. Signature Belum Di Buat !!!", "error");
        $("#ImagesDigitalSEP").empty();
        var imgkosng = "images/nosign.png"; 
        $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + imgkosng + "'>");
      
    }else{ 
        document.getElementById("btncetakSep").disabled = false;
        $("#signNama").val(params.NAMA_PARAM_1);
        $("#ImagesDigitalSEP").empty();
        var imgkosng = "images/nosign.png";
        if (params.IMAGE_PATH == null) {
            $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + imgkosng + "'>");
        } else {
            $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + params.IMAGE_PATH + "'>");
        }
    }
    
    
}
function RefreshDigitalSign() { 
    var nomortransaksi = $("#signNoSep").val();
    var pxNoRegistrasi = $("#pxNoRegistrasi").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/RefreshDigitalSign';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nomortransaksi=" + nomortransaksi + "&noregistrasi=" + pxNoRegistrasi
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
// ADD_BPJS 
async function BPJSCreateSEP() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCreateSEP = await GoBPJSCreateSEP();
        console.log(dataGoBPJSCreateSEP);
        updateUIdataGoBPJSCreateSEP(dataGoBPJSCreateSEP); 
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
async function BPJSCreateAntrian(){
    try {
        $(".preloader").fadeIn(); 
        const dataTambahAntrianBPJS = await GoTambahAntrianBPJS();
        updateUIdataTambahAntrianBPJS(dataTambahAntrianBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
// ADD_BPJS
async function VoidAntrianBPJSkeshatan() {
    try {
        const dataGoBatalAntrianBPJS = await GoBatalAntrianBPJS();
        updateUIdataGoBatalAntrianBPJS(dataGoBatalAntrianBPJS);

    } catch (err) {
        swal('Oops', "Sorry... " + err, "error")
            .then((value) => {
                MyBack();
            }); 
    }
}
function updateUIdataGoBatalAntrianBPJS(params) {
    swal('Good job!', "Task Antrian berhasil Di Hapus Di BPJS Kesehatan !", "success")
        .then((value) => {
            //VoidAntrianBPJSkeshatan();
            //GoVoidSep();
            MyBack();
        });
}
function GoBatalAntrianBPJS() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBatalAntrianBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
function GoTambahAntrianBPJS() {
    var kodebooking = document.getElementById("pxNoRegistrasi").value;
    var NoSep = document.getElementById("pxNoSep").value;
    var NamaJaminan = document.getElementById("shownamaperusahaanfix").value;
    var AntrolJenisKunungan = document.getElementById("AntrolJenisKunungan").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoTambahAntrianBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "kodebooking=" + kodebooking + "&NoSep=" + NoSep + "&NamaJaminan=" + NamaJaminan + "&AntrolJenisKunungan=" + AntrolJenisKunungan
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
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
// ADD_BPJS
function updateUIdataTambahAntrianBPJS(data) {
    swal('Antrian Berhasil di Kirim Ke BPJS Kesehatan, Silahkan Cetak Bukti Registrasi dan SEP Pasien.')
        .then((value) => { 
            $('#notif_Cetak').modal('show'); 
        });
}
// ADD_BPJS
function updateUIdataGoBPJSCreateSEP(data) {
    swal('Sep Berhasil Dibuat ' + data.hasil[1].sep.noSep +', Selanjutnya adalah Kirim Antrian Ke BPJS Kesehatan. Please Wait.... ')
        .then((value) => { 
            $('#pxNoSep').val(data.hasil[1].sep.noSep);
            $('#modal_VerifBPJS').modal('hide');
            $('#modal_AntrolJenisKunungan').modal('show');
            $("#pxnoEpisode").val(response.NoEpisode);
            $("#pxNoRegistrasi").val(response.NoRegistrasi);
            $("#pxNoAntrian").val(response.NoAntrianPoli);
            $("#pxNoSep").val(response.NoAntrianPoli);
            $("#cetaknoregis").val(response.NoRegistrasi);
            $("#cetaknoregis2").val(response.NoRegistrasi);
            $("#cetaklabel").val(response.NoMR);
            $('#Notif_awal_registrasi2').modal('hide');
            //BPJSCreateAntrian(); 
    });
}
// ADD_BPJS
function GoBPJSCreateSEP() {
    var form_kepesertaan_Bpjs = $("#form_kepesertaan_Bpjs").serialize();
    var str = $("#frmSimpanTrsRegistrasi").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoCreateSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_kepesertaan_Bpjs + "&"+ str
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
           // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
// ADD_BPJS 
async function BPJSCekJumlahSEPRujukan() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCekJumlahSEPRujukan = await GoBPJSCekJumlahSEPRujukan();
        console.log(dataGoBPJSCekJumlahSEPRujukan);
        updateUIdataGoBPJSCekJumlahSEPRujukan(dataGoBPJSCekJumlahSEPRujukan);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGoBPJSCekJumlahSEPRujukan(data) {
    $('#JumlahKunjunganSepBPJS').val(data.hasil[1].jumlahSEP);
    if (data.hasil[1].jumlahSEP == "0" ){
        document.getElementById("caridiagnosaBPJS2").disabled = true;
        document.getElementById("cariPoliklinikBPJS").disabled = true;
        //document.getElementById("caridiagnosaBPJS2").disabled = true;
    }else{
        document.getElementById("caridiagnosaBPJS2").disabled = false;
        document.getElementById("cariPoliklinikBPJS").disabled = false;
        //document.getElementById("caridiagnosaBPJS2").disabled = false;
    }
    console.log("Jumlahsep",data.hasil[1].jumlahSEP);
    // Logika Auto Disini
    var RefPoliBPjs = document.getElementById("RefPoliBPjs").value; 
    var NamaPoliBPJS = document.getElementById("RefPoliSimrs").value;
    if(RefPoliBPjs != NamaPoliBPJS){ 
        var jenisKunjungan = "0"; //normal 
        $('#TujuanKunjunganBPJS').val(jenisKunjungan).trigger('change');
        var asses = "2"; // atas instruksi rs 
        $('#AsesmentPelayananBPJS').val(asses).trigger('change');
    }
    if (data.hasil[1].jumlahSEP == "0"){ // artinya skrg pertama kali
        var jenisKunjungan = "0"; //normal 
        $('#TujuanKunjunganBPJS').val(jenisKunjungan).trigger('change');
    } else if(data.hasil[1].jumlahSEP >= "1"){ // artinya skrg mau kunjungan ke 2
        //ambil kode poli dulu
        var KodePoli = document.getElementById("poliklinikid").value;
        if(KodePoli == "47"){ // Jika hemodialisa
            var jenisKunjungan = "0"; //Normal 
            $('#TujuanKunjunganBPJS').val(jenisKunjungan).trigger('change');
        }else{
            var jenisKunjungan = "2"; //Konsul 
            $('#TujuanKunjunganBPJS').val(jenisKunjungan).trigger('change');
            var asses = "2"; // atas instruksi rs 
            $('#AsesmentPelayananBPJS').val(asses).trigger('change');
        }
    }
}
function GoBPJSCekJumlahSEPRujukan() {
    var jenisPencarian = $("#JenisPencarianBPJS").val();
    var kodePeserta = $("#idPesertaBPJS").val();
    var JenisRujukanFaskesBPJSx = $("#JenisRujukanFaskesBPJSx").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/xGoBPJSCekJumlahSEPRujukan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta + "&JenisRujukanFaskesBPJSx=" + JenisRujukanFaskesBPJSx
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function BPJSCekKepesertaan() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        console.log(dataGoBPJSCekKepesertaan);
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
} 
// ADD_BPJS
function updateUIdataGoBPJSCekKepesertaan(data) { 
    var JenisPencarianBPJS = document.getElementById("JenisPencarianBPJS").value;
    var JenisxPasienBPJS = document.getElementById("JenisxPasienBPJS").value;
    var JenisRujukanFaskesBPJSx2 = document.getElementById("JenisRujukanFaskesBPJSx").value;
    if(JenisPencarianBPJS =="3"){ 
        document.getElementById("caridiagnosaBPJS2").disabled = true;
        document.getElementById("cariPoliklinikBPJS").disabled = true;
        document.getElementById("cariDokterBPJS").disabled = true;
        $('#JenisFaskesKodeBPJS').val(data.hasil[1].asalFaskes);
        if (data.hasil[1].asalFaskes == "1"){
            $('#JenisFaskesNamaBPJS').val("Faskes 1");
        }else{
            $('#JenisFaskesNamaBPJS').val("Faskes 2");
        }
       // $('#isJenisPelayananBPJS').val(data.Medical_Provinsi).trigger('change');
        //$('#kdkelasperawatanBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.kode).trigger('change');
        $('#isJenisPelayananBPJS').val(JenisxPasienBPJS).trigger('change'); 
        $('#nokartubpjs').val(data.hasil[1].rujukan.peserta.noKartu);
        $('#nonikktpBPJS').val(data.hasil[1].rujukan.peserta.nik);
        $('#Kartu_NoPeserta').val(data.hasil[1].rujukan.peserta.noKartu);
        $('#Medrec_NoIdPengenal').val(data.hasil[1].rujukan.peserta.nik);
        $('#namapesertaBPJS').val(data.hasil[1].rujukan.peserta.nama);
        $('#Medrec_NamaPasien').val(data.hasil[1].rujukan.peserta.nama);
        $('#Kartu_NamaPemegangKartu').val(data.hasil[1].rujukan.peserta.nama);
        $('#cobnosuratBPJS').val(data.hasil[1].rujukan.peserta.cob.noAsuransi);
        $('#cobNamaAsuransiBPJS').val(data.hasil[1].rujukan.peserta.cob.nmAsuransi);
        $('#idhakKelasBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.kode);
        $('#hakKelasBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.keterangan);
        $('#keteranganprbBPJS').val(data.hasil[1].rujukan.peserta.informasi.prolanisPRB);
        $('#TglTMTBPJS').val(data.hasil[1].rujukan.peserta.tglTAT);
        if (data.hasil[1].rujukan.peserta.statusPeserta.keterangan == "AKTIF") { 
            swal("Status Kepesertaan " + data.hasil[1].rujukan.peserta.statusPeserta.keterangan)
                .then((value) => {
                    $('#IsVerifBPJSPesertax').val("1");
                    $('#modal_BPJSCekPesertaa').modal('hide');
                });
        } else {
            swal("Status Kepesertaan " + data.hasil[1].rujukan.peserta.statusPeserta.keterangan)
                .then((value) => {
                    swal('Pendaftaran Tidak Bisa DiLanjutkan !');
                });
        }
        $('#idppkrujukanBPJS').val(data.hasil[1].rujukan.provPerujuk.kode);
        $('#namappkrujukanBPJS').val(data.hasil[1].rujukan.provPerujuk.nama);
        $('#statuspesertaBPJS').val(data.hasil[1].rujukan.peserta.statusPeserta.keterangan);
        
        $('#norujukan').val(data.hasil[1].rujukan.noKunjungan);
        $('#TglRujukan').val(data.hasil[1].rujukan.tglKunjungan);

        $('#KodeDiagnosaBPJS').val(data.hasil[1].rujukan.diagnosa.kode);
        $('#NamaDiagnosaBPJS').val(data.hasil[1].rujukan.diagnosa.nama);
        $('#KodePoliklinikBPJS').val(data.hasil[1].rujukan.poliRujukan.kode);
        $('#NamaPoliklinikBPJS').val(data.hasil[1].rujukan.poliRujukan.nama);
        $('#RefPoliBPjs').val(data.hasil[1].rujukan.poliRujukan.nama); 
        $('#kdjenispelayananbpjsBPJS').val(data.hasil[1].rujukan.pelayanan.kode);
        $('#nmjenispelayananbpjsBPJS').val(data.hasil[1].rujukan.pelayanan.nama);
        $('#idfaskesBPJS').val(data.hasil[1].rujukan.peserta.provUmum.kdProvider);
        $('#TglLahirBPJS').val(data.hasil[1].rujukan.peserta.tglLahir);
        $('#Medrec_Tgl_Lahir').val(data.hasil[1].rujukan.peserta.tglLahir);
        $('#jenisPesertaKodeBPJS').val(data.hasil[1].rujukan.peserta.jenisPeserta.kode);
        $('#jenisPesertaNamaBPJS').val(data.hasil[1].rujukan.peserta.jenisPeserta.keterangan);
        $('#jenisKelaminKodeBPJS').val(data.hasil[1].rujukan.peserta.sex); 
        $('#Medical_JKel').val(data.hasil[1].rujukan.peserta.sex).trigger('change');
        if (data.hasil[1].rujukan.peserta.sex == "P") {
            $('#jenisKelaminNamaBPJS').val("PEREMPUAN");
        } else {
            $('#jenisKelaminNamaBPJS').val("LAKI-LAKI");
        }
    //tambahan
    //$('#TglTATAsuransiBPJS').val(data.hasil[1].rujukan.cob.tglTAT);
    //$('#TglTMTAsuransiBPJS').val(data.hasil[1].rujukan.cob.tglTMT);
    //$('#DinsosBPJS').val(data.hasil[1].rujukan.informasi.dinsos);
    //$('#NoSktmBPJS').val(data.hasil[1].rujukan.informasi.noSKTM);
    //$('#NamaJenisPesertaBPJS').val(data.hasil[1].rujukan.jenisPeserta.keterangan);
    //$('#KodeJenisPesertaBPJS').val(data.hasil[1].rujukan.jenisPeserta.kode);
    //$('#NoMRPesertaBPJS').val(data.hasil[1].rujukan.mr.noMR);
    //$('#NoTelponPesertaBPJS').val(data.hasil[1].rujukan.mr.noTelepon);
    //$('#PisaBPJS').val(data.hasil[1].rujukan.pisa);
    //$('#JenisKelaminBPJS').val(data.hasil[1].rujukan.sex);
    //$('#TanggalLahirBPJS').val(data.hasil[1].rujukan.tglLahir);
    //$('#KodestatuspesertaBPJS').val(data.hasil[1].rujukan.statusPeserta.kode);
    }else{
        $('#JenisFaskesKodeBPJS').val(JenisRujukanFaskesBPJSx2);
        if (JenisRujukanFaskesBPJSx2 == "1") {
            $('#JenisFaskesNamaBPJS').val("Faskes 1");
            //console.log("Faskes 1")
        } else {
            $('#JenisFaskesNamaBPJS').val("Faskes 2");
            //onsole.log("Faskes2")
        }
        $('#isJenisPelayananBPJS').val(JenisxPasienBPJS).trigger('change');
        $('#nokartubpjs').val(data.hasil[1].peserta.noKartu);
        $('#Kartu_NoPeserta').val(data.hasil[1].peserta.noKartu);
        $('#nonikktpBPJS').val(data.hasil[1].peserta.nik);
        $('#Medrec_NoIdPengenal').val(data.hasil[1].peserta.nik);
        $('#namapesertaBPJS').val(data.hasil[1].peserta.nama);
        $('#Kartu_NamaPemegangKartu').val(data.hasil[1].peserta.nama);
        $('#Medrec_NamaPasien').val(data.hasil[1].peserta.nama);
        $('#cobnosuratBPJS').val(data.hasil[1].peserta.cob.noAsuransi);
        $('#cobNamaAsuransiBPJS').val(data.hasil[1].peserta.cob.nmAsuransi);
        $('#idhakKelasBPJS').val(data.hasil[1].peserta.hakKelas.kode);
        $('#hakKelasBPJS').val(data.hasil[1].peserta.hakKelas.keterangan);
        $('#keteranganprbBPJS').val(data.hasil[1].peserta.informasi.prolanisPRB);
        if (data.hasil[1].peserta.statusPeserta.keterangan == "AKTIF") {
            $('#IsVerifBPJSPesertax').val("1");
            swal("Status Kepesertaan " + data.hasil[1].peserta.statusPeserta.keterangan)
                .then((value) => {
                    $('#modal_BPJSCekPesertaa').modal('hide');
                });
        } else {
            swal("Status Kepesertaan " + data.hasil[1].peserta.statusPeserta.keterangan)
                .then((value) => {
                    swal('Pendaftaran Tidak Bisa DiLanjutkan !');
                });
        }
        $('#idfaskesBPJS').val(data.hasil[1].peserta.provUmum.kdProvider);
        $('#namafaskesBPJS').val(data.hasil[1].peserta.provUmum.nmProvider);
        $('#statuspesertaBPJS').val(data.hasil[1].peserta.statusPeserta.keterangan);
        $('#TglLahirBPJS').val(data.hasil[1].peserta.tglLahir);
        $('#Medrec_Tgl_Lahir').val(data.hasil[1].peserta.tglLahir);
        $('#jenisPesertaKodeBPJS').val(data.hasil[1].peserta.jenisPeserta.kode);
        $('#jenisPesertaNamaBPJS').val(data.hasil[1].peserta.jenisPeserta.keterangan);
        $('#jenisKelaminKodeBPJS').val(data.hasil[1].peserta.sex); 
        $('#Medical_JKel').val(data.hasil[1].peserta.sex).trigger('change');
        
        $('#TglTMTBPJS').val(data.hasil[1].peserta.tglTAT);
        if (data.hasil[1].peserta.sex == "P"){
            $('#jenisKelaminNamaBPJS').val("PEREMPUAN");
        }else{
            $('#jenisKelaminNamaBPJS').val("LAKI-LAKI");
        }

    //tambahan
    //$('#TglTATAsuransiBPJS').val(data.hasil[1].peserta.cob.tglTAT);
    //$('#TglTMTAsuransiBPJS').val(data.hasil[1].peserta.cob.tglTMT);
    //$('#DinsosBPJS').val(data.hasil[1].peserta.informasi.dinsos);
    //$('#NoSktmBPJS').val(data.hasil[1].peserta.informasi.noSKTM);
    //$('#NamaJenisPesertaBPJS').val(data.hasil[1].peserta.jenisPeserta.keterangan);
    //$('#KodeJenisPesertaBPJS').val(data.hasil[1].peserta.jenisPeserta.kode);
    //$('#NoMRPesertaBPJS').val(data.hasil[1].peserta.mr.noMR);
    //$('#NoTelponPesertaBPJS').val(data.hasil[1].peserta.mr.noTelepon);
    //$('#PisaBPJS').val(data.hasil[1].peserta.pisa);
    //$('#JenisKelaminBPJS').val(data.hasil[1].peserta.sex);
    //$('#TanggalLahirBPJS').val(data.hasil[1].peserta.tglLahir);
    //$('#KodestatuspesertaBPJS').val(data.hasil[1].peserta.statusPeserta.kode);
    } 
    $('#modal_BPJSCekPesertaa').modal('hide');
    //$('#modal_VerifBPJS').modal('show');
}
// ADD_BPJS
function GoBPJSCekKepesertaan() { 
    var jenisPencarian = $("#JenisPencarianBPJS").val();
    var kodePeserta = $("#idPesertaBPJS").val();
    var JenisRujukanFaskesBPJSx = $("#JenisRujukanFaskesBPJSx").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekKepesertaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta + "&JenisRujukanFaskesBPJSx=" + JenisRujukanFaskesBPJSx
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function showFormOrderLaboratorium() {
    const base_url = window.location.origin;
    var NoRegistrasi = $("#pxNoRegistrasi").val();
    var str = btoa(NoRegistrasi);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/OrderLaboratorium/' + str;
}
function showFormOrderRadiologi() {
    const base_url = window.location.origin;
    var NoRegistrasi = $("#pxNoRegistrasi").val();
    var str = btoa(NoRegistrasi);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/OrderRadiologi/' + str;
}
function showFormOrderMCU() {
    const base_url = window.location.origin;
    var NoRegistrasi = $("#pxNoRegistrasi").val();
    var str = btoa(NoRegistrasi);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/OrderMCU/' + str;
}
function showFormEdukasiPasien() {
    const base_url = window.location.origin;
    //var NoRegistrasi = $("#NoRegistrasi").val();
    var IdRegistrasi = document.getElementById("IdRegistrasi").value;
    // console.log(NoRegistrasi);
    // return false;
    var str = btoa(IdRegistrasi);
    // console.log(str);
    // return false;
    window.location = base_url + '/SIKBREC/public/form/' + str;
}
function show_data_reservasi() {
    var base_url = window.location.origin;
    var tglAwalReservasi = $("[name='tglawal_Search']").val();
    var tglAkhirReservasi = $("[name='tglakhir_Search']").val();
    var iswalkin = $("#iswalkin").val();
    $('#table-load-data-reservasi').DataTable().clear().destroy();
    $('#table-load-data-reservasi').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aReservasiPasien/showListReservasi",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglAwalReservasi = tglAwalReservasi;
                d.tglAkhirReservasi = tglAkhirReservasi;
                d.iswalkin = iswalkin;
            }
        },
        "columns": [
            { "data": "no" },
            { "data": "NoMR" },
            { "data": "NamaPasien" },
            { "data": "ApmDate" },
            { "data": "NamaUnit" },
            { "data": "First_Name" },
            { "data": "NoAntrianAll" },
            { "data": "JenisPembayaran" },
            { "data": "JamPraktek" },
            { "data": "Alamat" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    // if(row.Company == "JKN MOBILE" ){
                    //     var html = "JKN MOBILE" 
                    //     return html 
                    // }else{
                        var html = "" 
                        var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showIDReservasi("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-log-in"></span></button> '
                        return html
                    //}
                    
                }
            },

        ]
    });
}
function loaddatamr() {
    var base_url = window.location.origin; 
    var txSearchData = $("#txSearchData").val();
    var cmbxcrimr = $("#cmbxcrimr").val();
    if (txSearchData == '' || txSearchData == null){
        toast('Silahkan Isi Kata Kunci!', "warning")
        return false
    }
    var iswalkin = $("#iswalkin").val();
    $('#table-load-data').DataTable().clear().destroy();
    $('#table-load-data').DataTable({
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aMedicalRecord/getListMedicalRecord",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.txSearchData = txSearchData;
                d.iswalkin = iswalkin;
                d.cmbxcrimr = cmbxcrimr;
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            { "data": "NoMR" },
            { "data": "NamaPasien" },
            { "data": "TglLahir" },
            { "data": "Alamat" },
            { "data": "TlpRumah" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""

                    var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showIDMR("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-log-in"></span></button> '
                    return html
                }
            },

        ]
    });
}
async function showIDReservasi(params) {
    try {
        $(".preloader").fadeIn();
        const dataGoshowIDReservasi = await GoshowIDReservasi(params);
        updateUIdataGoshowIDReservasi(dataGoshowIDReservasi);
        console.log(dataGoshowIDReservasi);
        const dataGetNamaPoli = await getNamaPoliShow(dataGoshowIDReservasi.IdPoli);
        updateUIgetNamaPoliShow(dataGetNamaPoli);
        const dataGetDokterNameById = await GetDokterNameById(dataGoshowIDReservasi.DoctorID);
        updateUIGetDokterNameById(dataGetDokterNameById); 
        document.getElementById("btnModalSrcReservasi").click();
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
async function updateUIdataGoshowIDReservasi(params) {
    let data = params;
    $("#pxNoReservasi").val(data.NoBooking);
    $("#PasienNoMR").val(data.NoMR);
    $("#PasienNama").val(data.NamaPasien);
    $("#PasienAlamat").val(data.Alamat);
    $("#PasienTglLahir").val(data.TglLahir);
    $("#PasienIdJKel").val(data.JenisKelamin);
    $("#poliklinikid").val(data.IdPoli); 
    $("#dokterid").val(data.DoctorID); 
    $("#pxNoAntrian").val(data.NoAntrianAll);

    $("#grupJaminan").val(data.JenisPembayaran).trigger('change');
    $("#grupJaminanid").val(data.JenisPembayaran);
    $("#namajaminanid").val(data.ID_Penjamin);
    $("#shownamaperusahaanfix").val(data.NamaPerusahaan);
    await getJamPraktek(data.ID_Penjamin);
    $("#Jampraktek").val(data.ID_JadwalPraktek);
    $("#NamaSesionPraktek").val(data.JamPraktek);

    //09-09-2023 update jika reservasi disabled tombol
    $("#poliklinik").attr('disabled', true);
    $("#dokter").attr('disabled', true);
    $("#grupJaminan").attr('disabled', true);
    $("#namajaminan").attr('disabled', true);
    $("#Jampraktek").attr('readonly', true);
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    const dates = now.toISOString().slice(0,16);
    $("#tglregistrasi").val(dates);
    $("#tglregistrasi").attr('readonly', true);
    $('#Jampraktek option:not(:selected)').prop('disabled', true);
    $("#refreshjadwal").attr('disabled', true);
    const dataGetAdministrasibyGroupJaminan = await GetAdministrasibyGroupJaminan();
    updateUIGetAdministrasibyGroupJaminan(dataGetAdministrasibyGroupJaminan);




    if (data.MrExist == 0) {
        document.getElementById("btnCreateNewMR").click();
      //  $('#ModalInputMRBAru').modal('show');
        $("#Medrec_NamaPasien").val(data.NamaPasien);
        $("#Medrec_Alamat").val(data.Alamat);
        $("#Medrec_Tgl_Lahir").val(data.TglLahir);
        $("#Medical_JKel").val(data.JenisKelamin);
        $("#Medrec_HomePhone").val(data.Telephone);
        $("#Medrec_handphone").val(data.HP);
        $("#Medrec_Email").val(data.Email);

    //$("#Medrec_NoMR").val(data.NoMR);
    //$("#Medrec_NamaPasien").val(data.PatientName);
    //$("#Medical_JKel").val(data.Gander);
    //$("#Medrec_Tgl_Lahir").val(data.Date_of_birth);
    //$("#Medrec_Alamat").val(data.Address);
    $("#Medrec_NoIdPengenal").val(data.ID_Card_number);
    $("#Medrec_Tpt_lahir").val(data.BirthPlace);
    $("#Medrec_Pekerjaan").val(data.Ocupation);
    $('#Medical_Provinsi').val(data.Medical_Provinsi).trigger('change');
    $("#Medrec_Warganegara").val(data.Medrec_Warganegara);
    //$("#Medrec_HomePhone").val(data.Medrec_HomePhone);
   // $("#Medrec_handphone").val(data.Medrec_handphone);
    $("#Medical_Agama").val(data.Medical_Agama);
    $("#Medrec_statusNikah").val(data.Medrec_statusNikah);
    $("#Medrec_Pendidikan").val(data.Medrec_Pendidikan);
    //$("#Medrec_Email").val(data.Medrec_Email);
    $("#Medrec_Status").val('1');
    $("#Medrec_NamaIbuKandung").val(data.Mother);
    //$("#Medrec_Ibu_Kandung").val(data.NoMR_IBU);
    $("#Medrec_Kodepos").val(data.kodepos);

    $("#Medrec_Bahasa").val(data.Bahasa);
    $("#Medrec_IdPengenal").val(data.Tipe_Idcard);
    $("#Medrec_Etnis").val(data.Etnis);
    
    await showGetKabupaten(data.Medical_Provinsi);
    await showGetKecamatan(data.Medrec_kabupaten);
    await showGetKelurahan(data.Medrec_Kecamatan);
    $('#Medrec_Kecamatan').val(data.Medrec_Kecamatan)//.trigger('change');
    $('#Medrec_kabupaten').val(data.Medrec_kabupaten)//.trigger('change');
    $('#Medrec_Kelurahan').val(data.Medrec_Kelurahan)//.trigger('change');

    $("#Medrec_kabupaten").select2();
    $('#Medrec_Kecamatan').select2();
    $('#Medrec_Kelurahan').select2();

    } else if (data.MrExist == 1) {
        if (data.Company == 'JKN MOBILE'){
        document.getElementById("btnCreateNewMR").click();
        swal({
            title: 'Lengkapi Data Pasien',
            text: "Silahkan Lengkapi Data Pasien Selengkap-lengkapnya !! ",
            icon: 'warning',
        }).then(function() {
            //location.reload()
        });
    }

    }
}
function GoshowIDReservasi(params) {
    var str = params;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasiPasien/GoshowIDReservasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + str
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function voidRegistrasi() {
    try {
        const dataVoidRegistrasi = await VoidRegistrasi(); 
        updateUIdataVoidRegistrasi(dataVoidRegistrasi); 

    } catch (err) {   
        swal("Oops", "Sorry... " + err, "error");
    }
}
async function GoVoidSep() {
    try { 
        $(".preloader").fadeIn();
        const dataVoidSEP = await VoidSEP();
        updateUIdataVoidSEP(dataVoidSEP);
        console.log(dataVoidSEP);
    } catch (err) { 
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateUIdataVoidSEP(dataVoidSEP) {
    let params = dataVoidSEP;
        swal('Good job!', params.message + " !, Sealnjutnya Hapus Registrasi, Silahkan Tunggu !", "success")
        .then((value) => {
            voidRegistrasi();
        });
}
function updateUIdataVoidRegistrasi(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
        swal('Good job!', params.message + " !", "success")
            .then((value) => {
                var namajaminan = document.getElementById("shownamaperusahaanfix").value;
                var grupJaminanid = document.getElementById("grupJaminanid").value;
                var tanapsepBatal = document.getElementById("tanapsepBatal").value;
                if (namajaminan == "BPJS Kesehatan" && grupJaminanid == "5") {
                    if (tanapsepBatal =="0"){
                        GoVoidSep();
                    }
                    VoidAntrianBPJSkeshatan();
                } else {
                    MyBack();
                } 
            });
}
// ADD BPJS
function VoidSEP() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoDeleteSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            } else if (response.status === "notfound") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
          // MyBack();
            $(".preloader").fadeOut();
        })
}
function VoidRegistrasi() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/VoidRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function goCreateRegistrasi() {
    try {
        const dataCreateRegistrasi = await CreateRegistrasi();
        updateUIdataCreateRegistrasi(dataCreateRegistrasi);
        LoadDataDocumentUploads();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataCreateRegistrasi(params) {
    let response = params;
    toast("Registrasi Berhasil, No. Registrasi : " +response.NoRegistrasi , "success")
    var noregistrasi = response.NoRegistrasi; 
    $("#NoRegistrasiSIMRSBPJS").val(response.NoRegistrasi);
    var substringnoreg = noregistrasi.substring(4, 0);
    var idlayanan = $("#poliklinikid").val();
    console.log(idlayanan, 'dd');
    console.log(substringnoreg);
    if (substringnoreg == "RJUR") {
        document.getElementById("btnInputTrsOrderRad").disabled = false;
        document.getElementById("btnInputTrsOrderLab").disabled = true;
        document.getElementById("btnInputTrsOrderMCU").disabled = true;
    } else if (substringnoreg == "RJUL") {
        document.getElementById("btnInputTrsOrderRad").disabled = true;
        document.getElementById("btnInputTrsOrderLab").disabled = false;
        document.getElementById("btnInputTrsOrderMCU").disabled = true;
    }
    else if (idlayanan == "53") {
        document.getElementById("btnInputTrsOrderRad").disabled = true;
        document.getElementById("btnInputTrsOrderLab").disabled = true;
        document.getElementById("btnInputTrsOrderMCU").disabled = false;
    } else {
        document.getElementById("btnInputTrsOrderRad").disabled = true;
        document.getElementById("btnInputTrsOrderLab").disabled = true;
        document.getElementById("btnInputTrsOrderMCU").disabled = true;
    }
    var RefPoliSimrs = $("#RefPoliSimrs").val();
    var RefKodePoliSimrs =  $("#RefKodePoliSimrs").val();
    $("#NamaPoliklinikBPJS").val(RefPoliSimrs);
    $("#KodePoliklinikBPJS").val(RefKodePoliSimrs);
    var shownamaperusahaanfix = document.getElementById("shownamaperusahaanfix").value;
    var grupJaminanid = document.getElementById("grupJaminanid").value;
    var PasienNoMR = document.getElementById("PasienNoMR").value;
    $("#NoMRBPJS").val(PasienNoMR);
    console.log(namajaminanid);
    console.log(grupJaminanid);
    // if ($("#idodc").val() != ''){
    //     getDataListPasienOperasibyNoReg();
    //     $("#modal_caripasien").modal('show');
    //     }
    if (shownamaperusahaanfix == "BPJS Kesehatan" && grupJaminanid =="5"){
        var IsVerifBPJSPesertax = document.getElementById("IsVerifBPJSPesertax").value;
        if (IsVerifBPJSPesertax =="1"){ 
            //-----SIGNUP
            swal({
                title: "Per 1 Januari 2023 Fitur Entri UserID RS YARSI Mobile & Website",
                text: "Apakah Anda ingin Membuat Akun Login Mobile YARSI dan Mengirimkan Username dan Password ke Pasien Ini ?",
                icon: "info",
                buttons: ['Tidak', "Ya, Buat Akun dan Kirim !"],
                closeOnClickOutside: false,
                closeOnEsc: false,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        // gosignupUser();
                        toast("Orang Kata per 1 Januari Malih. sabar ya... !!!", "error")
                         $('#modal_VerifBPJS').modal('show');
                        BPJSCekJumlahSEPRujukan();
                    } else {
                        $('#modal_VerifBPJS').modal('show');
                        BPJSCekJumlahSEPRujukan();
                    }
                });
                //-#END SIGNUP

        } else if (IsVerifBPJSPesertax != "1") {
            toast("Silahkan Verifikasi Kepesertaan Dulu, Create SEP Tidak Bisa Di Lanjutkan !!!", "error")
        }
        
    }else{
        //-----SIGNUP
        swal({
            title: "Per 1 Januari 2023 Fitur Entri UserID RS YARSI Mobile & Website",
            text: "Apakah Anda ingin Membuat Akun Login Mobile YARSI dan Mengirimkan Username dan Password ke Pasien Ini ?",
            icon: "info",
            buttons: ['Tidak', "Ya, Buat Akun dan Kirim !"],
            closeOnClickOutside: false,
            closeOnEsc: false,
        })
            .then((willDelete) => {
                if (willDelete) {
                    // gosignupUser();
                    toast("Orang Kata per 1 Januari Malih. sabar ya... !!!", "error")
                    $('#notif_Cetak').modal('show'); 
                    $('#Notif_awal_registrasi2').modal('hide');
                } else {
                   // swal("Transaction Rollback !");
                   $('#notif_Cetak').modal('show'); 
                   $('#Notif_awal_registrasi2').modal('hide');
                }
            });
            //-#END SIGNUP
    } 
    $("#pxnoEpisode").val(response.NoEpisode);
    $("#pxNoRegistrasi").val(response.NoRegistrasi);
    $("#pxNoAntrian").val(response.NoAntrianPoli);
    $("#pxNoSep").val(response.NoAntrianPoli);
    $("#cetaknoregis").val(response.NoRegistrasi);
    $("#cetaknoregis2").val(response.NoRegistrasi);
    $("#cetaklabel").val(response.NoMR);
    $('#tglregistrasi').prop('readonly', true);
}

function CreateRegistrasi() {
    var str = $("#frmSimpanTrsRegistrasi").serialize();
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/CreateRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str + "&iswalkin=" + iswalkin
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
            
})
}
async function goCreatePolisAsuransi() {
    try{
        const dataCreatePolisAsuransi = await createPolisAsuransi();
        updateUIcreatePolisAsuransi(dataCreatePolisAsuransi);
    } catch (err) {
        toast(err, "error")
    }
}
async function goCreatePolisKaryawan() {
    try {
        await createPolisKaryawan(); 
    } catch (err) {
        toast(err, "error")
    }
}
function createPolisKaryawan() {
    var str = $("#frmKartuRSYarsi").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/createPolisKaryawan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
function updateUIcreatePolisAsuransi(dataCreatePolisAsuransi) {
    let data = dataCreatePolisAsuransi;
    if (data.status == "warning") {
        toast(data.pesan,"error");
    } else if (data.status == "success") {
        toast(data.pesan, "success");
        document.getElementById("FrmDataPolisKartu").reset();
        $('#Notif_awal_registrasi2').modal('hide');
    }
}
function createPolisAsuransi() {
    var str = $("#FrmDataPolisKartu").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/createPolisAsuransi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
async function simpanMR(params) { 
    try {
        const responsePost = await CreateMedicalRecord(params);
        console.log("CreateMedicalRecord",responsePost);
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
        $("#idMrkemkes").val(data.idMrkemkes);
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
        $("#NoHpBPJS").val(data.NoHp);
        toast("Rekam Medik Berhasil dirubah !", "success")
        document.getElementById("CloseMeC").click();
        document.getElementById("CloseMeMR").click();
        document.getElementById("FRMcreatemr").reset();
        showIDMxR();
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

async function showMedicalRecordbyId() {
    try {
        $(".preloader").fadeIn();
        var xTempMr = $("#PasienNoMR").val();
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
                    var html = '<font size="1"> ' + row.TipePasien + ' - '+row.namapenjamin+'</font>  ';
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
function GetMedicalRecordbyId(xTempMr) {
    var base_url = window.location.origin;
    var iswalkin = $("#iswalkin").val();
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
async function loadkartujaminan(){
    try {
        var noMR = $("[name='PasienNoMR']").val();
        var NamaPasien = $("[name='PasienNama']").val();
        var GroupJaminan = document.getElementById("grupJaminan").value;
        var NamaJaminan = document.getElementById("namajaminan").value;
        $("#Kartu_GroupJaminan").val(GroupJaminan);
        $("#kartu_NoRM").val(noMR);
        $("#Kartu_NamaJaminan").val(NamaJaminan);
        $("#Kartu_NamaPasien").val(NamaPasien);
        $("#Kartu_NamaPemegangKartu").val(NamaPasien);
        const datagetLoadKartuPasien = await getLoadKartuPasien();
        updateUIgetLoadKartuPasien(datagetLoadKartuPasien);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgetLoadKartuPasien(datagetLoadKartuPasien) {
    let responseApi = datagetLoadKartuPasien;
    var noMR = $("[name='PasienNoMR']").val();
    var NamaPasien = $("[name='PasienNama']").val();
    var GroupJaminan = document.getElementById("grupJaminan").value;
    var NamaJaminan = document.getElementById("namajaminan").value;
    if (NamaJaminan === '274') {_
        $("#nosep").hide();
        $('#Modal_Karyawn_Polis').modal('show');
        $("#RSY_Kartu_NamaJaminan").val(NamaJaminan);
        $("#RSY_Kartu_GroupJaminan").val(GroupJaminan);
        $("#RSY_kartu_NoRM").val(noMR);
        $("#RSY_Kartu_NamaPasien").val(NamaPasien);
        $("#RSY_Kartu_NoPeserta").val(responseApi.NoKartu);
        $("#RSY_Kartu_NamaPemegangKartu").val(responseApi.NamaPemegangKartu);
        $("#Kartu_ID2").val(responseApi.ID);
        $("#RSY_Kartu_StatusPeserta").val(responseApi.StatusPasien);
        loadNIKKartu(responseApi.NoKartu);
    }else{
        $("#nosep").hide();
        $('#Notif_awal_registrasi2').modal('show');
        //  $("#Kartu_GroupJaminan").val(data.KodeGroupJaminan);
        $("#Kartu_NamagroupJaminan").val(responseApi.TipePasien);
        //$("#Kartu_NamaJaminan").val(responseApi.KodeJaminan);
        $("#Kartu_NamaJaminanx").val(responseApi.NamaPerusahaan);
        $("#Kartu_NoPeserta").val(responseApi.NoKartu);
        $("#Kartu_NamaPemegangKartu").val(responseApi.NamaPemegangKartu);
        $("#Kartu_Keterangan").val(responseApi.Keterangan);
        $("#Kartu_ID").val(responseApi.ID);
        $("#Kartu_HakKelas").val(responseApi.HakKelas);
        $("#Kartu_StatusPeserta").val(responseApi.StatusPasien);
    }
     
}
async function loadNIKKartu (params) {
    try {
        const dataGetPolisKaryawan = await GetPolisKaryawan(params);
        console.log("dataGetPolisKaryawan",dataGetPolisKaryawan);
        updateUIGetPolisKaryawan(dataGetPolisKaryawan);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetPolisKaryawan(data) {
    if (data.Nama == null || data.Nama == ''){
        toast("NIK Invalid, Silahkan Validasi NIK Karyawan !","error");
        $("#RSY_Kartu_NamaPemegangKartu").val('');
        $("#RSY_Kartu_HakKelas").val('');
        $("#RSY_Kartu_PlafonRJ").val('');
        $("#RSY_PlafonRI").val('');
        $("#RSY_stsPeg").val('');
    }else{
        $("#RSY_Kartu_NamaPemegangKartu").val(data.Nama);
        $("#RSY_Kartu_HakKelas").val(data.HakKelasPlafonRS);
        $("#RSY_Kartu_PlafonRJ").val(data.Plafon_RJ);
        $("#RSY_PlafonRI").val(data.Plafon_RI);
        $("#RSY_stsPeg").val(data.Status_Aktif);
    }
}
function GetPolisKaryawan(params) {
    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/GetPolisKaryawan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "params=" + params
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
function getidjenisjaminan() {
    $("#namajaminanid").val('');
    var xdi = document.getElementById("grupJaminan").value;
    $("#grupJaminanid").val(xdi);
}
function getLoadKartuPasien(){
    var base_url = window.location.origin;
    var noMR = $("[name='PasienNoMR']").val();
    var NamaPasien = $("[name='PasienNama']").val();
    var GroupJaminan = document.getElementById("grupJaminan").value;
    var NamaJaminan = document.getElementById("namajaminan").value;
    $("#Kartu_GroupJaminan").val(GroupJaminan);
    $("#kartu_NoRM").val(noMR);
    $("#Kartu_NamaJaminan").val(NamaJaminan);
    $("#Kartu_NamaPasien").val(NamaPasien);
    $("#Kartu_NamaPemegangKartu").val(NamaPasien);

    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getPolis';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "noMR=" + noMR + "&GroupJaminan=" + GroupJaminan + "&NamaJaminan=" + NamaJaminan
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
async function getidnamajaminan() {
    try {
        const dataGetJaminanByIdJaminan = await GetJaminanByIdJaminan(); 
        updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan);
        const dataGetAdministrasibyGroupJaminan = await GetAdministrasibyGroupJaminan();
        console.log("cekdataadmin", dataGetAdministrasibyGroupJaminan);
        updateUIGetAdministrasibyGroupJaminan(dataGetAdministrasibyGroupJaminan);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetAdministrasibyGroupJaminan(dataGetAdministrasibyGroupJaminan) {
    let responseApi = dataGetAdministrasibyGroupJaminan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#jenisadministrasi").empty();
        $("#jenisadministrasi").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Nama_Karcis + '</option';
            $("#jenisadministrasi").append(newRow);
        }
    }
}
function GetAdministrasibyGroupJaminan() {
    var namajaminanId = document.getElementById("namajaminanid").value;
    var grupJaminanId = document.getElementById("grupJaminan").value;
    //$("#namajaminanid").val(namajaminanId);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataKarcis/GetAdministrasibyGroupJaminan';
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
            $('#jenisadministrasi').select2();
        })
}
function updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan){
    let data = dataGetJaminanByIdJaminan;
    $("#shownamaperusahaanfix").val(data.NamaPerusahaan); 
}
function GetJaminanByIdJaminan() {
    var namajaminanId = document.getElementById("namajaminan").value;
    var grupJaminanId = document.getElementById("grupJaminan").value;
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
            //$("#hide_jaminan").hide();
        })
}
async function getjaminannama() {
    try
    {
        var getIdJainan = document.getElementById("grupJaminan").value;
        const dataGetJaminanById = await GetJaminanById(getIdJainan);
        updateUIGetJaminanById(dataGetJaminanById);
        console.log("datajaminan", dataGetJaminanById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetJaminanById(dataGetJaminanById) {
    let responseApi = dataGetJaminanById;
     
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#namajaminan").empty();
        $("#namajaminan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
            $("#namajaminan").append(newRow);
        }
    }
}
function GetJaminanById(getIdJainan) {
      
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getJaminanByIdGroup';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idGroupJaminan=' + getIdJainan
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
            if (getIdJainan == 1) {
                document.getElementById("show_notif_pilih_jaminan").innerHTML = "*) Jika anda memilih Jenis Jaminan PRIBADI, silahkan masukan Nama Jaminan = UMUM pada pilihan nama jaminan (Nama Jaminan tidak boleh kosong).";
            } else {
                document.getElementById("show_notif_pilih_jaminan").innerHTML = "";
            }
            $("#grupJaminan").select2();
            //$("#hide_jaminan").show();
            $('#namajaminan').select2();
        })
}
function updateUIgetDataDokterByJadwal(datagetDataDokterByJadwal) {
    let responseApi = datagetDataDokterByJadwal;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#dokter").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].First_Name + '</option';
            $("#dokter").append(newRow);
        }
    }
}
function updateUIgetNamaPoliShow(dataGetNamaPoli) {
    let responseApi = dataGetNamaPoli;
    $("#shownamapolifix").val(responseApi.data.NamaUnit);
    $("#poliklinikid").val(responseApi.data.ID);
    $("#idUnitKemkes").val(responseApi.data.idUnitKemkes);
    $("#KodePoliklinikBPJS").val(responseApi.data.codeBPJS);
    $("#NamaPoliklinikBPJS").val(responseApi.data.NamaBPJS);
    $("#RefPoliSimrs").val(responseApi.data.NamaBPJS);
    $("#RefKodePoliSimrs").val(responseApi.data.codeBPJS);
} 
function updateUIgetLoadGroupJaminan(datagetGroupJaminan) {
    let responseApi = datagetGroupJaminan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#grupJaminan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].TipePasien + '</option';
            $("#grupJaminan").append(newRow);
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
            $("#grupJaminan").select2();
        })
}
function getdatacaramasuk() {
    var xdi = document.getElementById("caramasuk").value;
    $("#caramasukid").val(xdi);
}
async function getreferal() {
    try{
        const dataGetRefferalByIdGroup = await GetRefferalByIdGroup();
        console.log("dataGetRefferalByIdGroup", dataGetRefferalByIdGroup);
        updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup) {
    let responseApi = dataGetRefferalByIdGroup;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#referral").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaCaraMasukRef + '</option';
            $("#referral").append(newRow);
        }
    }
    
}
function GetRefferalByIdGroup() {
    var xdi = document.getElementById("caramasuk").value;
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
            $("#referral").select2();
        })
}
async function getreferalname() {
    try{
        const datagetReferalId = await getReferalId();
        console.log("datagetReferalId", datagetReferalId);
        updateUIdGetReferalId(datagetReferalId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdGetReferalId(datagetReferalId) {
    let apiresponse = datagetReferalId;
    $("#showrefferalfix").val(apiresponse.data.NamaCaraMasukRef);
    $("#referralid").val(apiresponse.data.id);
    //$("#hide_referal").hide();
}
function getReferalId() {
    var xdi = document.getElementById("referral").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataReferal/getReferalId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + xdi
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
            $("#dokter").select2();
        })
}
async function getadministrasinilai() {
    try{
        const dataGetAdministrasiById = await GetAdministrasiById();
        console.log("dataGetAdministrasiById", dataGetAdministrasiById);
        updateUIGetAdministrasiById(dataGetAdministrasiById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetAdministrasiById(dataGetAdministrasiById) {
    let data = dataGetAdministrasiById;
    $("#jenisadminnilai").val(data.Nilai_Karcis);
    $("#jenisadministrasiid").val(data.ID);
}
function GetAdministrasiById() {
    var xdi = document.getElementById("jenisadministrasi").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataKarcis/GetAdministrasiById';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idAdministrasi=' + xdi
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
            $("#dokter").select2();
        })
}
async function getDoktername() {
    try{
        var idDokter = document.getElementById("dokter").value;
        const dataGetDokterNameById = await GetDokterNameById(idDokter);
        updateUIGetDokterNameById(dataGetDokterNameById);
        console.log("datanamadr",dataGetDokterNameById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetDokterNameById(dataGetDokterNameById) {
    let responseApi = dataGetDokterNameById; 
    if (responseApi.message == "warning") {
        new PNotify({
            title: 'Notifikasi',
            text: responseApi.data.errorname,
            type: 'danger'
        });
        $("#dokterid").val('');
        $("#shownamdokterfix").val('');
    } else if (responseApi.message == "success") {
        // handle the response
        $("#shownamdokterfix").val(responseApi.data.First_Name);
        $("#dokterid").val(responseApi.data.ID);
        $("#idDoktertKemkes").val(responseApi.data.idDoktertKemkes);
        $("#KodeDokterBPJS").val(responseApi.data.ID_Dokter_BPJS);
        $("#NamaDokterBPJS").val(responseApi.data.NAMA_Dokter_BPJS);

    }
   // $("#hide_dokter").hide();
}
function GetDokterNameById(idDokter) {
    var getidPoliKlinik = idDokter;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDokterId';
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
            $("#dokter").select2();
        })
}
async function getDokter(){
    try{
        const datagetDataDokterByJadwal =  await getDataDokterByJadwal();
        updateUIgetDataDokterByJadwal(datagetDataDokterByJadwal); 
        var xdi = document.getElementById("poliklinik").value;
        const dataGetNamaPoli = await getNamaPoliShow(xdi);
        //$("#hide_poli").hide();
        document.getElementById("show_notif_poliklinik").innerHTML = "";
        updateUIgetNamaPoliShow(dataGetNamaPoli);
        console.log("show poli ", dataGetNamaPoli);
    } catch (err) {
        toast(err, "error")
    }
}
function getNamaPoliShow(idPoliKlinik) {  
    var getidPoliKlinik = idPoliKlinik;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataUnit/getUnitId';
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
            $("#dokter").select2();
        })
}
function getDataDokterByJadwal() {
    var base_url = window.location.origin;
    $("#dokter").empty();
    //$("#hide_dokter").show(); 
    var tglnow = $('#tglnow').val();
    const days = getWeekdays(tglnow);
    var xdi = document.getElementById("poliklinik").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/JadwalAbsensi/getHariJadwalDokterCurrent';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kode_prop=' + xdi + '&days=' + days
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
            $("#dokter").select2();
        })
}
async function onLoadFunctionAll() {
    try{
        const datagetNamaCaraMasuk = await getNamaCaraMasuk();
        const datagetProvinsi =  await getProvinsi();
        const dataGetLayananPoliPenunjangIgd = await GetLayananPoliPenunjangIgd();
        const datagetGroupJaminan = await getLoadGroupJaminan();
        //const dataGetShift =  await getShift(); 
        const datagetStatusHubunganKeluarga =  await getStatusHubunganKeluarga();
        const dataGetregistrasiRajalbyId = await GetregistrasiRajalbyId();
        // const dataGetJadwalDokterBPJS = await GetJadwalDokterBPJS();
        // console.log("dataGetJadwalDokterBPJS",dataGetJadwalDokterBPJS);
        // ADD BPJS 
        // const dataProvinsiBPJS =  await GetDataProvinsiBPJS();
        // console.log("dataProvinsiBPJS", dataProvinsiBPJS)
        //console.log("dataProvinsiBPJS", dataProvinsiBPJS);
        updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk);
        updateUIGetLayananPoliPenunjangIgd(dataGetLayananPoliPenunjangIgd);
        updateUIgetLoadGroupJaminan(datagetGroupJaminan);
       // updateUIgetShift(dataGetShift);
        updateUIgetStatusHubunganKeluarga(datagetStatusHubunganKeluarga);
        updateUIgetProvinsi(datagetProvinsi);
        // updateUIgetProvinsiBPJS(dataProvinsiBPJS);
        updateUIdataGetregistrasiRajalbyId(dataGetregistrasiRajalbyId);
        if ($("#idodc").val() != ''){
        const data = await GetDataPasienbyIDODC();
        updateUIGetDataPasienbyIDODC(data);
        }
        LoadDataDocumentUploads();
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function GetJadwalDokterBPJS() {
    var kodepoli = '';
    var tanggal = '';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekJadwalDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'kodepoli=' + kodepoli + '&tanggal=' + tanggal
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
            // $("#cariKabupaten").select2();
        })
}
async function GoGetDataBpjsKecamatan() {
    try {
        const dataProvinsiBPJS = await GetDataProvinsiBPJS();
        updateUIgetProvinsiBPJS(dataProvinsiBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
async function getKabupatenBPJS(id) {
    try {
        const dataGetDataKabupatenBPJS = await GetDataKabupatenBPJS(id);
        console.log("dataGetDataKabupatenBPJS", dataGetDataKabupatenBPJS)
        updateUIGetDataKabupatenBPJS(dataGetDataKabupatenBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
async function getKecamatanBPJS(id) {
    try {
        const dataGetDataKecamatanBPJS = await GetDataKecamatanBPJS(id);
        console.log("dataGetDataKecamatanBPJS", dataGetDataKecamatanBPJS)
        updateUIGetDataKecamatanBPJS(dataGetDataKecamatanBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetDataKecamatanBPJS(dataGetDataKecamatanBPJS) {
    let responseApi = dataGetDataKecamatanBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariKecamatan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariKecamatan").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariKecamatan").append(newRow);
        }
    }
}
function updateUIGetDataKabupatenBPJS(dataGetDataKabupatenBPJS) {
    let responseApi = dataGetDataKabupatenBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariKabupaten").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariKabupaten").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariKabupaten").append(newRow);

        }
    }
}
function updateUIgetProvinsiBPJS(dataProvinsiBPJS) {
    let responseApi = dataProvinsiBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariProvinsi").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariProvinsi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariProvinsi").append(newRow);

        }
    }
}
// ADD BPJS
function GetDataKecamatanBPJS(idProv) {
    var SuplesiBPJSKabupaten = idProv;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GetDataKecamatanBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'SuplesiBPJSKabupaten=' + SuplesiBPJSKabupaten
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
            $("#cariKecamatan").select2();
        })
}
function GetDataKabupatenBPJS(idProv) {
    var SuplesiBPJSProvinsia = idProv;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/getKabupatenBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'SuplesiBPJSProvinsi=' + SuplesiBPJSProvinsia
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
            $("#cariKabupaten").select2();
        })
}
function GetDataProvinsiBPJS() { 
    var iswalkin = "";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoGetProvinsiBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'iswalkin=' + iswalkin
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
            $("#cariProvinsi").select2();
        })
}
function Passingbatal() {
    var nosep = $("#pxNoSep").val();
    var noregistrasi = $("#pxNoRegistrasi").val();
    $("#nosepbatal").val(nosep);
    $("#noregbatal").val(noregistrasi);
} 
async function updateUIdataGetregistrasiRajalbyId(params) {
    let data = params;
    $("#PasienNoMR").val(data.NoMR);
    $("#PasienNama").val(data.PatientName);
    $("#PasienIdJKel").val(data.Gander);
    $("#PasienTglLahir").val(data.Date_of_birth);
    $("#PasienAlamat").val(data.Address);
    $("#PasienNamaJKel").val(data.NamaGander);
    $("#PasienNIK").val(data.ID_Card_number);
    $("#PasienTptLahir").val(data.BirthPlace);
    $("#PasienPekerjaan").val(data.Ocupation);
    $("#pxNoReservasi").val(data.NoBooking);
    $("#pxNoRegistrasi").val(data.NoRegistrasi);
    $("#noregbatal").val(data.NoRegistrasi);
    $("#pxNoteRegistrasi").val(data.Catatan);
   

    $("#cetaklabel").val(data.NoMR);
    $("#idRegKemenkes").val(data.idRegKemenkes);
    $("#idDoktertKemkes").val(data.idDoktertKemkes);
    $("#idUnitKemkes").val(data.idUnitKemkes);

    $("#cetaknoregis").val(data.NoRegistrasi);
    $("#cetaknoregis2").val(data.NoRegistrasi);
    $("#pxnoEpisode").val(data.NoEpisode);
    $("#pxNoSep").val(data.NoSEP);
   
    $("#nosepbatal").val(data.NoSEP);

    $("#pxNoAntrian").val(data.NoAntrianAll);

    $("#poliklinik").val(data.Unit);
    $("#poliklinikid").val(data.Unit); 
 
    $("#shownamapolifix").val(data.LokasiPasien);
    $("#shownamdokterfix").val(data.namadokter);
    $("#dokter").val(data.Doctor1);
    $("#dokterid").val(data.Doctor1);
    $("#grupJaminan").val(data.PatientType);
    $("#grupJaminanid").val(data.PatientType);
    //getjaminannama2(data.PatientType);
    $("#namajaminan").val(data.Perusahaanid);
    //console.log(data.Perusahaanid);
    $("#namajaminanid").val(data.Perusahaanid);
    $("#shownamaperusahaanfix").val(data.Perusahaan);
    
    $('#jenisadministrasi').val(data.idAdmin).trigger('change');
    $("#jenisadministrasiid").val(data.idAdmin);
    $("#tiperegistrasi").val(data.Tipe_Registrasi).trigger('change');
    //$("#COB").val(data.KodeJaminanCOB).trigger('change');
  
   // getadministrasinilai2(data.idAdmin);
   // $("#caramasuk").val(data.idCaraMasuk);
    $('#caramasuk').val(data.idCaraMasuk).trigger('change');
    $("#caramasukid").val(data.idCaraMasuk);
    $("#referral").val(data.idCaraMasuk2);
   // getreferalname2(data.idCaraMasuk2);
    $("#referralid").val(data.idCaraMasuk2);
    $("#PasienJenisDaftar").val(data.JenisDaftar);
    $('#poliklinik').select2();
    $('#dokter').select2();
    $('#grupJaminan').select2();
    $('#referral').select2();
   // $("#hide_dokter").hide();
    $('#caramasuk').select2();
    TglNowTemp = $("#TglNowTemp").val();
    $("#tglregistrasi").val(TglNowTemp);
    // console.log("xxxxxxx", data.NoSEP)
    $("#NoHpBPJS").val(data.noHp);
    //getidnamajaminan();

    
    getCOB();
    

    console.log("TglNowTemp",TglNowTemp);
    console.log("ID", data.ID);
    if (data.ID != null) {
       $("#tglregistrasi").val(data.VisitDate + "\T" + data.JamDate);
        $('#tglregistrasi').prop('readonly', true);
        //console.log("BETUL")
       // GetAdministrasibyGroupJaminan();
       const dataGetAdministrasibyGroupJaminan = await GetAdministrasibyGroupJaminan();
        updateUIGetAdministrasibyGroupJaminan(dataGetAdministrasibyGroupJaminan);
        $("#jenisadministrasi").val(data.KODE_TARIF).trigger('change');

        await getJamPraktek(data.Perusahaanid);
        $("#Jampraktek").val(data.ID_JadwalPraktek);
        $("#NamaSesionPraktek").val(data.JamPraktek);
        //getCOB();
        $("#COB").val(data.KodeJaminanCOB).trigger('change');

        if (data.Perusahaanid == '313'){
            if (data.Unit == '25' || data.Unit == '9' || data.Unit == '10'){
                $('#pxNoSep').prop('readonly', false);
            }
        }
    }else{
        console.log("TIDAK BETUL")
        TglNowTemp = $("#TglNowTemp").val();
        $("#tglregistrasi").val(TglNowTemp);
        //$('#tglregistrasi').prop('readonly', true);
        //getCOB();
    }
    const dataGetNamaPoli = await getNamaPoliShow(data.Unit);
    document.getElementById("show_notif_poliklinik").innerHTML = "";
    updateUIgetNamaPoliShow(dataGetNamaPoli);

     //09-09-2023 update jika reservasi disabled tombol
    if (data.NoBooking != null){
        $("#poliklinik").attr('disabled', true);
        $("#dokter").attr('disabled', true);
        $("#grupJaminan").attr('disabled', true);
        $("#namajaminan").attr('disabled', true);
        $("#Jampraktek").attr('readonly', true);
        $('#Jampraktek option:not(:selected)').prop('disabled', true);
        $("#refreshjadwal").attr('disabled', true);
    }
}
function GetregistrasiRajalbyId() {
    var IdRegistrasi = document.getElementById("IdRegistrasi").value;
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyId';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdRegistrasi=' + IdRegistrasi + "&iswalkin=" +iswalkin
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
            // $("#caramasuk").select2();
        })
}
function updateUIgetStatusHubunganKeluarga(datagetStatusHubunganKeluarga) {
    let responseApi = datagetStatusHubunganKeluarga;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Medrec_DaruratHub").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].CONTACT_STATUS + '">' + responseApi.data[i].CONTACT_STATUS + '</option';
            $("#Medrec_DaruratHub").append(newRow);
        }
    }
}
function getStatusHubunganKeluarga() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/getStatusHubunganKeluarga';
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
            // $("#caramasuk").select2();
        })
}
function updateUIgetShift(dataGetShift) {
    let responseApi = dataGetShift;
    $("#NamaSesionPraktek").val(responseApi.NamaSesion);
}
function getShift() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getShift';
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
           // $("#caramasuk").select2();
        })
}

async function getJamPraktek(IDJaminan) {
    try{
        //var iddokter = $(param).val();
        const datagetSessionDokter = await getSessionDokter(IDJaminan);
        updateUIgetSessionDokter(datagetSessionDokter);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetSessionDokter(datagetSessionDokter) {
    let responseApi = datagetSessionDokter;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        $("#Jampraktek").empty();
        $("#NamaSesionPraktek").val('');
        var newRow = '<option value="">-- PILIH --</option';
        $("#Jampraktek").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].HariWaktu + '</option';
            $("#Jampraktek").append(newRow);
        }
    }
}

function getSessionDokter(IDJaminan) {
    var id = $("[name='tglregistrasi']").val(); 
    var IdDokter = $("#dokterid").val();
    if (IDJaminan == '313'){
        var groupjadwal = '1';
    }else{
        var groupjadwal = '2';
    }
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";
    var dx = new Date(id);
    var n = weekday[dx.getDay()];
    console.log(n,'hariii')
    var Poliklinik = $("[name='poliklinikid']").val();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getSessionDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'hari=' + n + "&idlayanan=" + Poliklinik + "&iddokter=" + IdDokter + "&groupjadwal=" + groupjadwal
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
           // $("#caramasuk").select2();
        })
}

async function GetSession(param) {
    try{
        var idjampraktek = $(param).val();
        const datagetNamaSessionDokter = await getNamaSessionDokter(idjampraktek);
        updateUIgetNamaSessionDokter(datagetNamaSessionDokter);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetNamaSessionDokter(datagetNamaSessionDokter) {
    let responseApi = datagetNamaSessionDokter;
    $("#NamaSesionPraktek").val(responseApi.NamaSesion);
}

function getNamaSessionDokter(idjampraktek) {

    var id = $("[name='tglregistrasi']").val(); 
    var weekday = new Array(7);
    weekday[0] = "Minggu_Sesion";
    weekday[1] = "Senin_Sesion";
    weekday[2] = "Selasa_Sesion";
    weekday[3] = "Rabu_Sesion";
    weekday[4] = "Kamis_Sesion";
    weekday[5] = "Jumat_Sesion";
    weekday[6] = "Sabtu_Sesion";
    var dx = new Date(id);
    var n = weekday[dx.getDay()];

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getNamaSessionDokter';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'hari=' + n + "&idjampraktek=" + idjampraktek
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
           // $("#caramasuk").select2();
        })
}

function updateUIGetLayananPoliPenunjangIgd(dataGetLayananPoliPenunjangIgd) {
    let responseApi = dataGetLayananPoliPenunjangIgd;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#poliklinik").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaUnit + '</option';
            $("#poliklinik").append(newRow);
        }
    }
}

function updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk) {
    let responseApi = datagetNamaCaraMasuk;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
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
        body: 'id=' + $("#IdAuto").val()
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
function GetLayananPoliPenunjangIgd() {
    var base_url = window.location.origin;
    var iswalkin = $("#iswalkin").val();
    var idodc = $("#idodc").val();
    let url = base_url + '/SIKBREC/public/MasterDataUnit/GetLayananPoliPenunjangIgd';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val() + "&iswalkin="+iswalkin
        + "&idodc="+idodc
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
function getdataJenisJaminan() {
    return console.log("getdataJenisJaminan")
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
async function showIDMR(params) {
    try{
        const dataShowIdMr = await GetMedicalRecordbyIDTrs(params);
        updateUIGetMedicalRecordbyIDTrs(dataShowIdMr);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetMedicalRecordbyIDTrs(dataShowIdMr) {
    let data = dataShowIdMr;
    $("#PasienNoMR").val(data.NoMR);
    $("#PasienNama").val(data.PatientName);
    $("#PasienIdJKel").val(data.Gander);
    $("#PasienTglLahir").val(data.Date_of_birth);
    $("#PasienAlamat").val(data.Address);
    $("#PasienNamaJKel").val(data.NamaGander);
    $("#idMrkemkes").val(data.idMrkemkes);
    //$("#PasienNamaJKel").val(data.NamaGander);
    $("#PasienNIK").val(data.ID_Card_number);
    $("#PasienTptLahir").val(data.BirthPlace);
    $("#PasienPekerjaan").val(data.Ocupation);
    $("#NoHpBPJS").val(data.mobilephone);
    document.getElementById("btnModalSrcPasienClose").click();
}
async function showIDMxR(){
    try{
        const dataShowIdMr = await GetMedicalRecordbyQRCode();
        updateUIGetMedicalRecordbyQRCode(dataShowIdMr);
    } catch (err) {
        toast(err, "error")
    }
}
function GetMedicalRecordbyIDTrs(params) {
    var x = params;
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetMedicalRecordbyIDTrs';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + x +"&iswalkin=" +iswalkin
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
function GetMedicalRecordbyQRCode() {
    var x = $("#PasienNoMR").val();
    var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetMedicalRecordbyQRCode';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + x +"&iswalkin=" +iswalkin
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
function updateUIGetMedicalRecordbyQRCode(dataShowIdMr) {
    let responseApi = dataShowIdMr;
    $("#PasienNoMR").val(responseApi.NoMR);
    $("#PasienNama").val(responseApi.PatientName);
    $("#PasienIdJKel").val(responseApi.Gander);
    $("#PasienTglLahir").val(responseApi.Date_of_birth);
    $("#PasienAlamat").val(responseApi.Address);
    $("#PasienNamaJKel").val(responseApi.NamaGander);
    $("#PasienNIK").val(responseApi.ID_Card_number);
    $("#PasienTptLahir").val(responseApi.BirthPlace);
    $("#PasienPekerjaan").val(responseApi.Ocupation);
    $("#PasienNIK_Karyawan").val(responseApi.NiK_PegawaiRS);
    $("#PasienNIK_StatusPeserta").val(responseApi.Status_Nik);
   // document.getElementById("CloseMe").click();
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
function showModalJenisReg() {
    var idreg = document.getElementById("IdRegistrasi").value;
    if (idreg != "") {
        $('#Notif_awal_registrasi').modal('hide');
    } else {
        $('#Notif_awal_registrasi').modal('show');
    }
    
}
function clearForm() {
   
    // $("#hide_poli").hide();
    // $("#hide_dokter").hide();
    // $("#hide_jaminan").hide();
    // $("#hide_referal").hide();
    $('#cekdatakaryawan').hide();
    $('#namajaminan').select2();
    $('#isDiagnosaawalBPJSx').select2();
    $('#iscatarakBPJS').select2();  
    $("#jenisadministrasi").empty();
    var newRow = '<option value="">-- Pilih --</option';
    $("#jenisadministrasi").append(newRow);
    $("#jenisadministrasi").select2();
}
function getWeekdays(params){
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";
    var dx = new Date(params);
    var days = weekday[dx.getDay()];
    return days;
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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
    console.log(responseApi);
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#COB").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaCOB + '</option';
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    var iswalkin = $("#iswalkin").val();
    if (iswalkin == 'WALKIN'){
        var page = "aRegistrasiWalkin";
    }else{
        var page = "aRegistrasiRajal";
    }
    window.location = base_url + "/SIKBREC/public/"+page+"/list";
}
// add BPJS
function GoRujukanMultiByKartu() { 
    var MultiNoKartu = document.getElementById("MultiNoKartu").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoRujukanMultiByKartu",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MultiNoKartu = MultiNoKartu; 
            }
        },
        "columns": [
            { "data": "noKunjungan" },
            { "data": "keluhan" },
            { "data": "tglKunjungan" },
            { "data": "diagnosa" },
            { "data": "pelayanan" },
            { "data": "poliRujukan" },
            { "data": "provPerujuk" },
            { "data": "pesertanama" },
            { "data": "pesertanoKartu" },
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowrujukanDataMulti("' + row.noKunjungan + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },


        ]
    });

}
// add bpjs
function ShowrujukanDataMulti(params) {
    $("#idPesertaBPJS").val(params);
    $('#modal_BPJSCekPesertaa').modal('show');
    $('#modal_BPJSCekRujukanMulti').modal('hide');
}
function setdata() {
    document.getElementById("caridiagnosaBPJS2").disabled = false;
    document.getElementById("cariPoliklinikBPJS").disabled = false;
    document.getElementById("cariDokterBPJS").disabled = false;
}

function PrintBuktiRegis(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintBuktiRegis/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function PrintLabelPasien(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintLabelPasien/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function PrintGelangAnak(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintGelangAnak/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function PrintGelangDewasa(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintGelangDewasa/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function gotanpaDigitalSign() {
    var tanpaDigitalSign = document.getElementById("tanpaDigitalSign").value
    if (tanpaDigitalSign == "0"){
        document.getElementById("btncetakSep").disabled = true;
        document.getElementById("btnRefreshSign").disabled = false;
    }else{
        document.getElementById("btncetakSep").disabled = false;
        document.getElementById("btnRefreshSign").disabled = true;
    }
}
function resetsession() {
    $("#NamaSesionPraktek").val('');
    var idjaminan = document.getElementById("namajaminanid").value;
    getJamPraktek(idjaminan);
}

function PrintKartuMR(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aMedicalRecord/PrintKartuMR/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}


function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjunganBPJS_akhir = document.getElementById("MTglKunjunganBPJS_akhir").value;
    var MNoKartuPeserta = document.getElementById("nokartubpjs").value;
    var base_url = window.location.origin;
    $('#tbl_history_Kunjungan').DataTable().clear().destroy();
    $('#tbl_history_Kunjungan').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringHistoriPelayananBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MTglKunjunganBPJS_akhir = MTglKunjunganBPJS_akhir;
                d.MNoKartuPeserta = MNoKartuPeserta;
            }
        },
        "columns": [
            { "data": "noSep" },
            { "data": "noKartu" },
            { "data": "noRujukan" },
            { "data": "tglSep" },
            { "data": "namaPeserta" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.jnsPelayanan == "1") {
                        var html = ""
                        var html = 'Rawat Inap';
                        return html
                    } else {
                        var html = ""
                        var html = 'Rawat Jalan';
                        return html
                    }

                }
            },
            { "data": "diagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" },
            { "data": "tglPlgSep" },
            { "data": "ppkPelayanan" },
        ]
    });

}

var getUrl = window.location;
var baseUrl2 = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];


function LoadDataDocumentUploads() {
    var doc_nomr = document.getElementById("PasienNoMR").value;
    var base_url = window.location.origin;
    $('#table-load-data-document').DataTable().clear().destroy();
    $('#table-load-data-document').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],s
        "ajax": {
            "url": baseUrl2 + '/public/aMedicalRecord/listuploaddocument',
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.doc_nomr = doc_nomr;
            }
        },
        "columns": [
            { "data": "JENIS_DOCUMENT" },
            { "data": "KETERANGAN" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi 
                    var html = ""
                    var html = '<img src="' + row.URL + '" data-title="' + row.CAPTION + '" width="300" height="200">';
                    return html
                }
            },
            { "data": "date_update" },
            { "data": "USERID" },

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowrujukanDataMulti("' + row.URL + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },


        ]
    });

}
function ShowrujukanDataMulti(params) {
    window.open(params, "_blank");
}


async function gosignupUser() {
    try{
        const data = await signupUser();
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
function signupUser() {
    var nomr = $("#PasienNoMR").val();
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

//18-04-2023 ODC
async function updateUIGetDataPasienbyIDODC(params) {
    let data = params;
    $("#PasienNoMR").val(data.NoMR).trigger('change');
    $("#noregistrasi_odc").val(data.NoRegistrasi);
    // $("#PasienNama").val(data.PatientName);
    // $("#PasienIdJKel").val(data.Gander);
    // $("#PasienTglLahir").val(data.Date_of_birth);
    // $("#PasienAlamat").val(data.Address);
    // $("#PasienNamaJKel").val(data.NamaGander);
    // $("#PasienNIK").val(data.ID_Card_number);
    // $("#PasienTptLahir").val(data.BirthPlace);
    // $("#PasienPekerjaan").val(data.Ocupation);
    ////auto generate poli one day care
    $("#poliklinik").val(55).trigger('change');
    // const dataGetNamaPoli = await getNamaPoliShow(55);
    // updateUIgetNamaPoliShow(dataGetNamaPoli);
}
function GetDataPasienbyIDODC() {
    var idodc = $("#idodc").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetDataPasienbyIDODC';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idodc=' + idodc 
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
            // $("#caramasuk").select2();
        })
}

function getDataListPasienOperasibyNoReg() { 
    var base_url = window.location.origin;
    var notrs = $("#noregistrasi_odc").val();
    $('#examplex').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#examplex').DataTable({
           "processing":true,
           "ordering": false, // Set true agar bisa di sorting
           //"order": [[ 0, 'desc' ]], 
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aRegistrasiRanap/getDataListPasienOperasibyNoReg", // URL file untuk proses select datanya
               "type": "POST",data: function (d) {
                d.notrs = notrs
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.ID+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.NoMR+'</font> '
                        return html 
                }
            },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoRegistrasi+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoEpisode+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TglOperasi+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.DrOperator+'</font> '
                        return html 
                }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.PetugasOrder+'</font> '
                    return html 
            }
        },  
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="TransferOPConfirm(' + row.ID + ')" ><span class="visible-content" > Transfer Reg</span></button>'
                          return html 
                   }
               },
           ],
       });
} 

function TransferOPConfirm(param){
    //-----SIGNUP
    swal({
        title: "Simpan",
        text: "Apakah Anda Yakin Ingin Simpan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                TransferOP(param)
            } else {
               // swal("Transaction Rollback !");
            }
        });
        //-#END SIGNUP
 }

async function TransferOP(param) {
    try{
        const data = await goTransferOP(param);
        updateUIgoTransferOP(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgoTransferOP(data) {
    if (data.status == "success") {
        toast(data.message, "success");
        swal('Berhasil !', data.message, "success");
        $("#modal_caripasien").modal('hide');
    }else {
        toast(data.message,"error");
        swal('Gagal !', data.message, "error")
    }
}
function goTransferOP(notrs) {
    var NoReg = $("#pxNoRegistrasi").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/goTransferOP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'notrs=' +notrs +'&noreg=' + NoReg
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