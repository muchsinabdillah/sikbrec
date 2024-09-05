$(document).ready(function () {
    //$(".preloader").fadeOut();
    asyncShowMain();
    $("#btnValidasiSITBUbah").hide();

    $(document).on("click", "#btn_Upload_Resume", function() {
        var file_data = $("#file_ResumeMedis").prop("files")[0];
        var file_class = 'resume_medis';
            UploadFile(file_data,file_class);
      });

      $(document).on("click", "#btn_Upload_KartuIdentitas", function() {
        var file_data = $("#file_KartuIdentitas").prop("files")[0];
        var file_class = 'kartu_identitas';
            UploadFile(file_data,file_class);
      });

      $(document).on("click", "#btn_Upload_BebasBiaya", function() {
        var file_data = $("#file_BebasBiaya").prop("files")[0];
        var file_class = 'bebas_biaya';
            UploadFile(file_data,file_class);
      });

      $(document).on("click", "#btn_Upload_SuratKematian", function() {
        var file_data = $("#file_SuratKematian").prop("files")[0];
        var file_class = 'surat_kematian';
            UploadFile(file_data,file_class);
      });
    
    //$('#table_resume_medis').DataTable({});

    $('#btnShowRiwayatKlaim').click(function () {
        Riwayat_Klaim();
     });

     $('#btnShowAutoGenerate').click(function () {
        AutoGenerateTarifx();
     });

    $('#btnNewPurchase').click(function () {
        createHeaderTrs();
     });

     $('#addDiagnosa').click(function () {
        AddRow_Diagnosa();
     });
     
     $('#addProsedur').click(function () {
        AddRow_Prosedur();
     });

     $('#addDiagnosav6').click(function () {
        AddRow_DiagnosaV6();
     });
     
     $('#addProsedurv6').click(function () {
        AddRow_ProsedurV6();
     });

    $('#btnNewClaim').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Ingin Buat Klaim Baru ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateNewClaim();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#btnSave').click(function () {
        // swal({
        //     title: "Simpan",
        //     text: "Apakah Anda Ingin Simpan Klaim ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
        //             goSave();
        //         } else {
        //             swal("Transaction Rollback !");
        //         }
        //     });
        goSave();
    });

    $('#btnGrouper').click(function () {
        // swal({
        //     title: "Simpan",
        //     text: "Apakah Anda Ingin Grouper ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
        //             goGrouper();
        //         } else {
        //             swal("Transaction Rollback !");
        //         }
        //     });
        goGrouper();
    });

    $('#btnHapusKlaim').click(function () {
            swal("Alasan :", {
                content: "input",
                buttons:true,
              })
              .then((value) => {
                  if (value == '' ){
                    swal("Alasan Harus Diisi ! Simpan Gagal !");
                    return false;
                  }else if (value == null){
                    return false;
                  }
                  goHapusKlaim(value);
              });
    });

    $('#btnFinalClaim').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Ingin Final Claim ?",
            // text: "Final Klaim Akan Menghapus Payment Yang Sudah Ada dan Otomatis Dibuat Payment Kembali Sesuai Dengan Selisih Tarif Inacbg Dengan Tarif RS, Lanjut ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goFinalClaim();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#btnReeditClaim').click(function () {
        // swal({
        //     title: "Simpan",
        //     text: "Anda akan membatalkan status final dan melakukan edit ulang klaim ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
        //             goReEditClaim(alasan);
        //         } else {
        //             //swal("Transaction Rollback !");
        //         }
        //     });
            swal("Alasan :", {
                content: "input",
                //text: "Edit Ulang Klaim Akan Menghapus Payment Yang Sudah Difinal. Alasan Edit :",
                text: "Alasan Edit :",
                buttons:true,
              })
              .then((value) => {
                  if (value == '' ){
                    swal("Alasan Harus Diisi ! Simpan Gagal !");
                    return false;
                  }else if (value == null){
                    return false;
                  }
                  goReEditClaim(value);
              });
    });

    $('#btnCetakKlaim').click(function () {
        goCetakKlaim();
    });

    $('#btnKirimKlaimOnline').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah anda yakin ingin kirim klaim online ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goKirimKlaimOnline();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#import_coding').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Ingin Import Coding ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    ImportCoding();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#btnCoInsidenseCovid').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Membuat Co-Inidense Covid-19 Atas Pasien Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCreateCoInsidenseCovid();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $("#search_diagnosis").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/bEKlaim/search_diagnosis';
            },
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Cari Diagnosa',
        minimumInputLength: 3
    });

    //  $( "#search_diagnosis" ).autocomplete({
    //     source: function( request, response ) {
    //                   $.ajax({
    //                     url: window.location.origin + "/SIKBREC/public/bEKlaim/search_diagnosis_new",
    //                     dataType: "json",
    //                     type: 'post',
    //                     data: {
    //                       keyword: request.term
    //                     },
    //                     success: function( data ) {
    //                       response( data );
    //                     }
    //                   });
    //                 },
                    
    //                 //minLength: 3,
    //                 select: function(event, ui)
    //                   {
    //                       $(this).val(ui.item.label);
    //                     $("#kode_diagnosa").val(ui.item.id);
    //                     $("#nama_diagnosa").val(ui.item.nama_diagnosa);
    //                     $("#addDiagnosa").focus();
    //                       return false; 
    //                   }
    //    });

    //   $('#search_diagnosis').keypress(function (e) {
    // var key = e.which;
    // if(key == 13) 
    //  {

    //  }
     
    // });


//     $("#x" ).autocomplete({
//         keypress: function (event, ui) {
//             if (event.which == 13) {
//                 console.log("Key Pressed");
//             }
//             else
//                 return false;
//         },
//         source: function( request, response ) {
//           $.ajax({
//             url: window.location.origin + "/SIKBREC/public/bEKlaim/search_diagnosis",
//             dataType: "json",
//             type: 'post',
//             data: {
//               keyword: request.term
//             },
//             success: function( data ) {
//               response( data );
//             }
//           });
//         },
        
//         //minLength: 3,
//         select: function(event, ui)
//           {
//               $(this).val(ui.item.nama_diagnosa);
//             //   $("#xIdBarang").val(ui.item.id);
//             $("#kode_diagnosa").val(ui.item.id);
//             $("#nama_diagnosa").val(ui.item.nama_diagnosa);
//             $("#addDiagnosa").focus();
//             //   $("#qty_barang").focus();
//               return false; 
//           }
//   })

//   $('#search_diagnosis').keypress(function (e) {
//     var key = e.which;
//     if(key == 13) 
//      {
//         $.ajax({
//             url: window.location.origin + "/SIKBREC/public/bEKlaim/search_diagnosis",
//             dataType: "json",
//             type: 'post',
//             data: {
//                 keyword: $(this).val()
//             },
//             success: function( responseApi ) {
//                 //console.log(responseApi);
//                 if (responseApi !== null && responseApi !== undefined) {
//                     console.log(responseApi);
//                       for (i = 0; i < responseApi.length; i++) {
//                         console.log(responseApi[i].id);
//                         //var newRow = '<li>' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</li>';
//                         //$("#search_diagnosis").append(newRow);
//                     }
//                     // var newRow = '<option value="">-- PILIH --</option';
//                     // $("#search_diagnosis").append(newRow);
//                     // for (i = 0; i < responseApi.length; i++) {
//                     //     var newRow = '<li>' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</li>';
//                     //     $("#search_diagnosis").append(newRow);
//                     // }
//                 }
//             }
//             });
        
//      }
//    });  

// $( "#search_procedures" ).autocomplete({
//     source: function( request, response ) {
//                   $.ajax({
//                     url: window.location.origin + "/SIKBREC/public/bEKlaim/search_procedures_new",
//                     dataType: "json",
//                     type: 'post',
//                     data: {
//                       keyword: request.term
//                     },
//                     success: function( data ) {
//                       response( data );
//                     }
//                   });
//                 },
                
//                 //minLength: 3,
//                 select: function(event, ui)
//                   {
//                       $(this).val(ui.item.label);
//                     $("#kode_prosedur").val(ui.item.id);
//                     $("#nama_prosedur").val(ui.item.nama_procedure);
//                     $("#addProsedur").focus();
//                       return false; 
//                   }
//    });


    $("#search_procedures").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/bEKlaim/search_procedures';
            },
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Cari Prosedur',
        minimumInputLength: 3
    });

    $('#search_diagnosis').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#kode_diagnosa").val(data.id);
        $("#nama_diagnosa").val(data.nama_diagnosa);
        $("#addDiagnosa").focus();
    });

    $('#search_procedures').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#kode_prosedur").val(data.id);
        $("#nama_prosedur").val(data.nama_prosedur);
        $("#addProsedur").focus();
    });

    $("#search_diagnosisv6").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/bEKlaim/search_diagnosis_inagrouper';
            },
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Cari Diagnosa',
        minimumInputLength: 3
    });

    $("#search_proceduresv6").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/bEKlaim/search_procedures_inagrouper';
            },
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Cari Prosedur',
        minimumInputLength: 3
    });

    $('#search_diagnosisv6').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#kode_diagnosav6").val(data.id);
        $("#nama_diagnosav6").val(data.nama_diagnosa);
        $("#addDiagnosav6").focus();
        
    });

    $('#search_proceduresv6').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#kode_prosedurv6").val(data.id);
        $("#nama_prosedurv6").val(data.nama_prosedur);
        $("#addProsedurv6").focus();
    });

    // $('#btn_batal').click(function () {
    //     swal("Alasan Batal:", {
    //         content: "input",
    //         buttons: true,
    //     })
    //         .then((value) => {
    //             if (value == '') {
    //                 swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
    //                 return false;
    //             } else if (value == null) {
    //                 return false;
    //             }
    //             // swal(`You typed: ${value}`);
    //             goVoidHeader(value);
    //         });
    // });

    //FORMAT NUMBER
    var prosedur_non_bedah = document.getElementById("prosedur_non_bedah");
    prosedur_non_bedah.addEventListener("keyup", function(e) { 
        prosedur_non_bedah.value = formatRupiah(this.value);
        CalculateALL();
    });
    var prosedur_bedah = document.getElementById("prosedur_bedah");
    prosedur_bedah.addEventListener("keyup", function(e) { 
        prosedur_bedah.value = formatRupiah(this.value);
        CalculateALL();
    });
    var konsultasi = document.getElementById("konsultasi");
    konsultasi.addEventListener("keyup", function(e) { 
        konsultasi.value = formatRupiah(this.value);
        CalculateALL();
    });
    var tenaga_ahli = document.getElementById("tenaga_ahli");
    tenaga_ahli.addEventListener("keyup", function(e) { 
        tenaga_ahli.value = formatRupiah(this.value);
        CalculateALL();
    });
    var keperawatan = document.getElementById("keperawatan");
    keperawatan.addEventListener("keyup", function(e) { 
        keperawatan.value = formatRupiah(this.value);
        CalculateALL();
    });
    var penunjang = document.getElementById("penunjang");
    penunjang.addEventListener("keyup", function(e) { 
        penunjang.value = formatRupiah(this.value);
        CalculateALL();
    });
    var radiologi = document.getElementById("radiologi");
    radiologi.addEventListener("keyup", function(e) { 
        radiologi.value = formatRupiah(this.value);
        CalculateALL();
    });
    var laboratorium = document.getElementById("laboratorium");
    laboratorium.addEventListener("keyup", function(e) { 
        laboratorium.value = formatRupiah(this.value);
        CalculateALL();
    });
    var pelayanan_darah = document.getElementById("pelayanan_darah");
    pelayanan_darah.addEventListener("keyup", function(e) { 
        pelayanan_darah.value = formatRupiah(this.value);
        CalculateALL();
    });
    var rehabilitasi = document.getElementById("rehabilitasi");
    rehabilitasi.addEventListener("keyup", function(e) { 
        rehabilitasi.value = formatRupiah(this.value);
        CalculateALL();
    });
    var kamar = document.getElementById("kamar");
    kamar.addEventListener("keyup", function(e) { 
        kamar.value = formatRupiah(this.value);
        CalculateALL();
    });
    var rawat_intensif = document.getElementById("rawat_intensif");
    rawat_intensif.addEventListener("keyup", function(e) { 
        rawat_intensif.value = formatRupiah(this.value);
        CalculateALL();
    });
    var obat = document.getElementById("obat");
    obat.addEventListener("keyup", function(e) { 
        obat.value = formatRupiah(this.value);
        CalculateALL();
    });
    var obat_kronis = document.getElementById("obat_kronis");
    obat_kronis.addEventListener("keyup", function(e) { 
        obat_kronis.value = formatRupiah(this.value);
        CalculateALL();
    });
    var obat_kemoterapi = document.getElementById("obat_kemoterapi");
    obat_kemoterapi.addEventListener("keyup", function(e) { 
        obat_kemoterapi.value = formatRupiah(this.value);
        CalculateALL();
    });
    var alkes = document.getElementById("alkes");
    alkes.addEventListener("keyup", function(e) { 
        alkes.value = formatRupiah(this.value);
        CalculateALL();
    });
    var bmhp = document.getElementById("bmhp");
    bmhp.addEventListener("keyup", function(e) { 
        bmhp.value = formatRupiah(this.value);
        CalculateALL();
    });
    var sewa_alat = document.getElementById("sewa_alat");
    sewa_alat.addEventListener("keyup", function(e) { 
        sewa_alat.value = formatRupiah(this.value);
        CalculateALL();
    });

     $('#btnCopyDiagnosaEMR').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah anda yakin ingin import diagnosa dari EMR ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goCopyDiagnosaEMR();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#btnValidasiSITB').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah anda yakin ingin validasi SITB ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goValidasiSITB();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });

    $('#btnValidasiSITBUbah').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah anda yakin ingin batal validasi SITB ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goValidasiSITB_Void();
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    });


});

async function asyncShowMain() {
    try {
        //await getHakAksesByForm(12); 
        const datagoGetCOB = await goGetCOB();
        updateUIdatagoGetCOB(datagoGetCOB);

        if($("#ID_EKLAIM").val() == ''){
            const datagoGetDatabyNoSEP = await goGetDatabyNoSEP();
            updateUIdatagoGetDatabyNoSEP(datagoGetDatabyNoSEP);
        }else{

            $("#btnNewClaim").attr('disabled',true);
            document.getElementById("hasil_grouper_v5").style.display = 'block';
    
            await showDataSaved();
            await showDataDetil_Diagnosa();
            await showDataDetil_Prosedur();
            await showDataDetil_DiagnosaV6();
            await showDataDetil_ProsedurV6();
            await showGrouper();
            await getJaminanCovid();
            await showDataDetil_UploadResume();
            await showDataDetil_UploadKartuIdentitas();
            await showDataDetil_UploadBebasBiaya();
            await showDataDetil_UploadSuratKematian();
    
            $(".preloader").fadeOut();
            //return false;

        }
        
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoGetCOB(dataGetRefferalByIdGroup) {
    let responseApi = dataGetRefferalByIdGroup;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="#">-- PILIH --</option';
        $("#cob_cd").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].Kode_INACBG + '">' + responseApi[i].NamaCOB + '</option>';
            $("#cob_cd").append(newRow);
        }
    }
}

function goGetCOB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterCOB/getCOBAktif_Inacbg';
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
            $("#cob_cd").select2();
        })
}

async function updateUIdatagoGetDatabyNoSEP(dataResponse) {
    
   // $('#ID_EKLAIM').val(dataResponse.data.ID_EKLAIM);
   
   //await showDataDetil_DiagnosaEMR();

    //$('#payor_id option:not(:selected)').prop('disabled', true);
    //$('#gender option:not(:selected)').prop('disabled', true);

    $("#penjamin").val(dataResponse.data.NamaPenjamin);
    $('#nomor_sep').val(dataResponse.data.NO_SEP);
    $('#nomor_kartu').val(dataResponse.data.NO_KARTU);
   // $('#kelas_rawat').val(dataResponse.data.KODE_KELAS_RAWAT);
   //$('#nomor_registrasi').val(dataResponse.data.NO_REGISTRASI);

   $("#tgl_masuk").val(dataResponse.data.StartDate + "\T" + dataResponse.data.jamkunjungan);
   $("#tgl_pulang").val(dataResponse.data.EndDate + "\T" + dataResponse.data.jamkunjungan);

    $('#los').val(dataResponse.data.LOS);
    $('#los_jam').val(dataResponse.data.JAM_LOS);
    $('#berat_lahir').val(dataResponse.data.BeratLahir);

    $("#jenis_rawat").val(dataResponse.data.KODE_JENIS_RAWAT).trigger('change');
    
    $("#kelas_rawat").val(dataResponse.data.KODE_KELAS_RAWAT).trigger('change');

    if (dataResponse.data.IS_EKSEKUTIF == '1'){
        $("#kelas_eksekutif").prop('checked',true);
        myFunctionKelasEksekutif();
    }

    if (dataResponse.data.NAIK_KELAS == '1'){
        $("#upgrade_class_ind").prop('checked',true);
        myFunctionNaikTurunKelas();
    }

    //checkbox rawat intensif
    if (dataResponse.data.is_intensif != null){
        $('#icu_indikator').attr('checked',true);
        $("#icu_los").val(dataResponse.data.is_intensif);
        $("#ventilator_hour").val(dataResponse.data.VentiUsed);
        myFunctionRawatIntensif();
    }

        
    //}else{
        $("#laboratorium").val(dataResponse.data.TotalLab);
        $("#radiologi").val(dataResponse.data.TotalRad);
        $("#obat").val(dataResponse.data.TotalAptk);
        $("#prosedur_bedah").val(dataResponse.data.TotalOP);
        $("#kamar").val(dataResponse.data.TotalKamar);
        $("#keperawatan").val(dataResponse.data.TotalTindakan);

        if ($("#nomor_registrasi").val().substring(0, 2) == 'RJ'){
            $("#konsultasi").val(dataResponse.data.TarifKonsultasi);
            $("#penunjang").val(dataResponse.data.TarifTindakan);
            
            $("#pelayanan_darah").val(dataResponse.data.TarifPelayananDarah);
            $("#rehabilitasi").val(dataResponse.data.TarifFisio);


         }else{
             $("#konsultasi").val(dataResponse.data.TotalKonsul);
         }

        getJaminanCovid();
        //CalculateALL();
        //Riwayat_Klaim();

        $('#nomor_rm').val(dataResponse.data.NO_MR);
        $('#nama_pasien').val(dataResponse.data.NAMA_PESERTA);
        $('#gender').val(dataResponse.data.GENDER);
        $('#tgl_lahir').val(dataResponse.data.DOB);
        $('#umur').val(dataResponse.data.UMUR);
        $('#nama_dokter').val(dataResponse.data.NAMA_DOKTER);

        if (dataResponse.is_bridging == false){
            EnableForm();
        }

        

        var x = document.getElementById("final_button");
        x.style.display = "none";

        $(".preloader").fadeOut();
   // }

}

async function goGetDatabyNoSEP() {
    var base_url = window.location.origin;
    var  id  = $("#nomor_registrasi").val();
    let url = base_url + '/SIKBREC/public/bEKlaim/goGetDatabyNoSEP/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + id 
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
            //$(".preloader").fadeOut();
        })
}

//TRS
async function goCreateNewClaim() {
    try {
        $(".preloader").fadeIn();
        // $("#btnNewClaim").prop('disabled',true);
        // $("#btnNewClaim").html('Loading...');
        const dataCreateNewClaim = await CreateNewClaim();
        updateUIdataCreateNewClaim(dataCreateNewClaim);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataCreateNewClaim(dataCreateNewClaim) {
    if (dataCreateNewClaim.status == 'success') {
        toast(dataCreateNewClaim.message, "success");
        $("#btnNewClaim").attr('disabled',true)
         $("#ID_EKLAIM").val(dataCreateNewClaim.data.ID_EKLAIM);
         $("#nomor_sep").val(dataCreateNewClaim.data.nomor_sep);

    } else {
        toast(dataCreateNewClaim.message, "error")
        $("#btnNewClaim").attr('disabled',false)
    }
}

async function CreateNewClaim() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/new_claim';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
           // $("#btnNewClaim").html('Klaim Baru');
        })
}

async function goSave() {
    try {
        //$(".preloader").fadeIn();
        $("#btnSave").prop('disabled',true);
        $("#btnSave").html('Loading...');
        const data = await goSave2();
        updateUIdatagoSave(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoSave(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        goGrouper();
    } else {
        toast(data.message, "error");
        $("#btnSave").prop('disabled',false);
        $("#btnSave").html('Simpan & Grouper');
    }
}

function goSave2() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/set_claim_data';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                $("#btnSave").prop('disabled',false);
                $("#btnSave").html('Simpan & Grouper');
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                $("#btnSave").prop('disabled',false);
                $("#btnSave").html('Simpan & Grouper');
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

async function goHapusKlaim(alasan) {
    try {
        $(".preloader").fadeIn();
        const data = await goHapusKlaim2(alasan);
        updateUIgoHapusKlaim(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgoHapusKlaim(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        // setTimeout(() => {
        //     location.reload();
        // }, 1000);
        swal('Success',data.message, "success")
        .then((value) => {
            MyBack();
        });

    } else {
        toast(data.message, "error")
    }
}

async function goHapusKlaim2(alasan) {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/delete_claim';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data + "&alasan=" + alasan
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

async function AddRow_Diagnosa(){
    try {

        const dataGocreateDtl_Diagnosa = await GocreateDtl_Diagnosa();
        updateUIdataGocreateDtl_Diagnosa(dataGocreateDtl_Diagnosa);
        showDataDetil_Diagnosa();
        //$(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}

async function showDataDetil_Diagnosa() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#table_diagnosa_v5').DataTable().clear().destroy();
    $('#table_diagnosa_v5').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_Diagnosa/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.No + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_DIAGNOSA + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_DIAGNOSA + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STATUS_PRIMER + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var button = ""
                    if (row.IS_PRIMER == 0){
                        var button = '<button type="button" class="btn btn-secondary border-primary btn-animated btn-xs"  onclick="SetPrimer_Diagnosa(' + row.ID + ')" ><span class="visible-content" >Set Primer</span></span></button>&nbsp'
                    }
                    var html = button+'<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'deletedetilPerItem_Diag("' + row.ID + '","' + row.KODE_DIAGNOSA + '")\' ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 
    });
} 
function updateUIdataGocreateDtl_Diagnosa(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success")
        $('#nama_diagnosa').val('');
        $('#kode_diagnosa').val('');
        // $('#search_diagnosis').val('');
        // $('#search_diagnosis').focus();
        $("#search_diagnosis").empty();
        $("#search_diagnosis").select2('open');
    }else{
        toast(dataResponse.message, "error")
    }
}

async function GocreateDtl_Diagnosa() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nama_diagnosa = document.getElementById("nama_diagnosa").value;
    var kode_diagnosa = document.getElementById("kode_diagnosa").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/addDiagnosa/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
            + '&nama_diagnosa=' + nama_diagnosa
            + '&kode_diagnosa=' + kode_diagnosa
            + '&nomor_sep=' + nomor_sep
            + '&payor_id=' + payor_id
            + '&nomor_registrasi=' + nomor_registrasi
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

async function AddRow_Prosedur(){
    try {

        const dataGocreateDtl_Prosedur = await GocreateDtl_Prosedur();
        updateUIdataGocreateDtl_Prosedur(dataGocreateDtl_Prosedur);
        showDataDetil_Prosedur();
    } catch (err) {
        toast(err, "error")
    }
}

async function showDataDetil_Prosedur() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#table_prosedur_v5').DataTable().clear().destroy();
    $('#table_prosedur_v5').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_Prosedur/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.No + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_PROSEDUR + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_PROSEDUR + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="deletedetilPerItem_Prosedur(' + row.ID + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 
    });
    //$(".preloader").fadeOut();
} 
function updateUIdataGocreateDtl_Prosedur(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success")
        $('#nama_prosedur').val('');
        $('#kode_prosedur').val('');
        // $('#search_procedures').val('');
        // $('#search_procedures').focus();
        $("#search_procedures").empty();
        $("#search_procedures").select2('open');
    }else{
        toast(dataResponse.message, "error")
    }
     
}
async function GocreateDtl_Prosedur() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nama_prosedur = document.getElementById("nama_prosedur").value;
    var kode_prosedur = document.getElementById("kode_prosedur").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/addProsedur/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
            + '&nama_prosedur=' + nama_prosedur
            + '&kode_prosedur=' + kode_prosedur
            + '&nomor_sep=' + nomor_sep
            + '&payor_id=' + payor_id
            + '&nomor_registrasi=' + nomor_registrasi
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

function deletedetilPerItem_Diag(param,kodeicd) {
    try {
        swal({
            title: "Hapus",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem2_diag(param,kodeicd)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function deletedetilPerItem2_diag(param,kodeicd) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetails = await goVoidDetails_Diag(param,kodeicd);
        updateUIdatagoVoidDetails_diag(datagoVoidDetails);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails_diag(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_Diagnosa();
    }else{
        toast(params.message, "error")
    }
}

async function goVoidDetails_Diag(param,kodeicd) {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/bEKlaim/goVoidDetails_Diag/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
        + '&nomor_registrasi=' + nomor_registrasi
        + '&kodeicd=' + kodeicd
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

function deletedetilPerItem_Prosedur(param) {
    try {
        swal({
            title: "Hapus",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem2_prosedur(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function deletedetilPerItem2_prosedur(param) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetails = await godeletedetilPerItem2_prosedur(param);
        updateUIdatagoVoidDetails_prosedur(datagoVoidDetails);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails_prosedur(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_Prosedur();
    }else{
        toast(params.message, "error")
    }
}

async function godeletedetilPerItem2_prosedur(param) {
    var ProductCode = param;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var url2 = "/SIKBREC/public/bEKlaim/goVoidDetails_Prosedur/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
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

function SetPrimer_Diagnosa(param) {
    try {
        swal({
            title: "Set Primer",
            text: "Apakah Anda ingin Menjadikan Item Ini Primer ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    SetPrimer2_Diagnosa(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function SetPrimer2_Diagnosa(param) {
    try {
         $(".preloader").fadeIn();
        const data = await goSetPrimer2_Diagnosa(param);
        updateUIdatagoSetPrimer2_Diagnosa(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoSetPrimer2_Diagnosa(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_Diagnosa();
    }else{
        toast(params.message, "error")
    }
}

async function goSetPrimer2_Diagnosa(param) {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/bEKlaim/SetPrimer_Diagnosa/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
        + '&nomor_registrasi=' + nomor_registrasi
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

async function goGrouper() {
    try {
        //$(".preloader").fadeIn();
        const data = await goGrouping();
        updateUIdatagoGrouper(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoGrouper(data) {

    if (data.status == 'success') {
        toast(data.message, "success");
        document.getElementById("hasil_grouper_v5").style.display = 'block';
        var x = document.getElementById("final_button");
        x.style.display = "block";

        $('#info').html(data['data_local'][0]['NAMAUSER']+' @ '+data['data_local'][0]['DATETIME']+'..'+data['data_local'][0]['KELAS_RS']+'.. Tarif: '+data['data_local'][0]['TARIF_RS']); 

        $('#jenis_rawat_grouper').html(data['data_local'][0]['JENIS_RAWAT']+' '+data['data_local'][0]['JENIS_RAWAT_DESC']);

        if (data['data_local'][0]['JENIS_RAWAT'] == 'RAWAT JALAN'){
    
            document.getElementById("hasil_grouper_v6").style.display = 'none';
            
    
        }else{

            //INA GROUPER V6
            document.getElementById("hasil_grouper_v6").style.display = 'block';
            $('#info_v6').html(data['data_local'][0]['NAMAUSER']+' @ '+data['data_local'][0]['DATETIME']+'..'+data['data_local'][0]['KELAS_RS']+'.. Tarif: '+data['data_local'][0]['TARIF_RS']); 
            $('#jenis_rawat_grouper_v6').html(data['data_local'][0]['JENIS_RAWAT']+' Kelas '+data['data_local'][0]['JENIS_RAWAT_DESC']); 
            $("#mdc_description").html(data['data_api']['response_inagrouper']['mdc_description']);
            $("#mdc_number").html(data['data_api']['response_inagrouper']['mdc_number']);
            $("#drg_description").html(data['data_api']['response_inagrouper']['drg_description']);
            $("#drg_code").html(data['data_api']['response_inagrouper']['drg_code']);

            $('#jenis_rawat_grouper').html(data['data_local'][0]['JENIS_RAWAT']+' Kelas '+data['data_local'][0]['JENIS_RAWAT_DESC']);

        }

        $('#cbg_description').html(data['data_api']['response']['cbg']['description']); 
        $('#cbg_code').html(data['data_api']['response']['cbg']['code']); 
        $('#cbg_tarif').html(data['data_api']['response']['cbg']['tariff']); 


        // if (data['data_api']['response']['add_payment_amt'] == undefined){
        //     var add_payment_amt = 0;
        // }else{
        //     var add_payment_amt = data['data_api']['response']['add_payment_amt'];
        // }
        // $("#addpayment_grouper_total").html(add_payment_amt);

        $('#sp_procedure_code').html('-'); 
        $('#sp_procedure_tarif').html(0);
        $('#sp_prosthesis_code').html('-'); 
        $('#sp_prosthesis_tarif').html(0); 
        $('#sp_investigation_code').html('-'); 
        $('#sp_investigation_tarif').html(0);
        $('#sp_drug_code').html('-'); 
        $('#sp_drug_tarif').html(0);

        if (data['data_api']['special_cmg_option'] !== null && data['data_api']['special_cmg_option'] !== undefined) {
            $("#sp_procedure").empty();
            $("#sp_prosthesis").empty();
            $("#sp_investigation").empty();
            $("#sp_drug").empty();
            var newRow = "<option value=''>None</option>"
            $("#sp_procedure").append(newRow);
            $("#sp_prosthesis").append(newRow);
            $("#sp_investigation").append(newRow);
            $("#sp_drug").append(newRow);

            for (i = 0; i < data['data_api']['special_cmg_option'].length; i++) {
                var newRow = '<option value="' + data['data_api']['special_cmg_option'][i].code + '">' +  data['data_api']['special_cmg_option'][i].description + '</option>';


                if(data['data_api']['special_cmg_option'][i].type == 'Special Procedure'){
                    $("#sp_procedure").append(newRow);
                }else if(data['data_api']['special_cmg_option'][i].type == 'Special Prosthesis'){
                    $("#sp_prosthesis").append(newRow);
                }else if(data['data_api']['special_cmg_option'][i].type == 'Special Investigation'){
                    $("#sp_investigation").append(newRow);
                }else if(data['data_api']['special_cmg_option'][i].type == 'Special Drug'){
                    $("#sp_drug").append(newRow);
                    
                }
            }
            
        }

        if (data['data_api']['response']['add_payment_amt'] !== null && data['data_api']['response']['add_payment_amt'] !== undefined){
            $('#hasilgrouperv5 tr#hdr_tambahan_biaya').remove();

            $('#hasilgrouperv5 > tbody:last-child').append('<tr id="hdr_tambahan_biaya"> <th>Tambahan Biaya</th> <th colspan="2"> </th><th>Rp </th><th id="addpayment_grouper_total" style="text-align:right"> '+data['data_api']['response']['add_payment_amt']+'</th></tr>');
        }

        if (data['data_api']['response']['covid19_data'] !== null && data['data_api']['response']['covid19_data'] !== undefined) {

            $('#hasilgrouperv5 tr#hdr_pemulasaraan_jenazah').remove();
            $('#hasilgrouperv5 tr#hdr_terapi_konvalesen').remove();
            $('#hasilgrouperv5 tr#paket_biaya').remove();
            $('#hasilgrouperv5 tr#hdr_paket_biaya2').remove();
            $('#hasilgrouperv5 tr#hdr_rawat_igd').remove();

            var pemulasaraan_jenazah = parseFloat(data['data_api']['response']['covid19_data']['top_up_jenazah']);
            if (pemulasaraan_jenazah != 0 ){

                $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_pemulasaraan_jenazah"><th>  Pemulasaraan Jenazah  </th> <th colspan="2" ></th><th>Rp </th> <th id="pemulasaraan_jenazah_grouper" style="text-align:right">'+number_to_price(pemulasaraan_jenazah)+'</th> </tr>');
            }

            var terapi_konvalesen = parseFloat(data['data_api']['response']['covid19_data']['terapi_konvalesen']);
            if (terapi_konvalesen != 0 ){

                $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_terapi_konvalesen"><th>  Terapi Plasma  </th> <th colspan="2" ></th><th>Rp </th> <th style="text-align:right">'+number_to_price(terapi_konvalesen)+'</th> </tr>');
            }
           
           // document.getElementById("tr_paket_biaya").style.display = "block";
           if (data['data_api']['response']['covid19_data']['rs_darurat_ind'] == '1'){
             $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="paket_biaya"><th> Paket Biaya </th> <th colspan="2" > RS DARURAT / LAPANGAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
           }

           if (data['data_api']['response']['covid19_data']['isoman_ind'] == '1'){
            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_paket_biaya2"><th> Paket Biaya </th> <th colspan="2" > ISOMAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
          }

          if (data['data_api']['response']['covid19_data']['igd_ind'] == '1'){
            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_rawat_igd"><th> Rawat IGD </th> <th></th><th>'+data['data_api']['response']['covid19_data']['top_up_rawat_factor']*100+'%</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat'])+'</th> </tr>');
          }
          
          var nilai_klaim = data['data_api']['response']['covid19_data']['nilai_klaim'];
            
        }

        CalculateGrouper(nilai_klaim);

    } else {
        toast(data.message, "error");
        
        $("#btnSave").prop('disabled',false);
        $("#btnSave").html('Simpan & Grouper');
    }
}

function goGrouping() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/grouping_stage_1';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                $("#btnSave").prop('disabled',false);
                $("#btnSave").html('Simpan & Grouper');
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                $("#btnSave").prop('disabled',false);
                $("#btnSave").html('Simpan & Grouper');
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
            $("#btnSave").prop('disabled',false);
            $("#btnSave").html('Simpan & Grouper');
        })
}

async function goGrouper_stage2() {
    try {
        $(".preloader").fadeIn();
        const data = await goGrouping_stage2();
        updateUIdatagoGrouper_stage2(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoGrouper_stage2(data) {

    if (data['data_api']['metadata']['code'] == 200) {
        toast(data.message, "success");

        $("#btnCetakKlaim").attr('disabled',true);
        $("#btnReeditClaim").attr('disabled',true);
        $("#btnKirimKlaimOnline").attr('disabled',true);

        var x = document.getElementById("final_button");
        x.style.display = "block";
        document.getElementById("hasil_grouper_v5").style.display = 'block';

        //INA GROUPER V6
        document.getElementById("hasil_grouper_v6").style.display = 'block';
        $("#mdc_description").html(data['data_api']['response_inagrouper']['mdc_description']);
        $("#mdc_number").html(data['data_api']['response_inagrouper']['mdc_number']);
        $("#drg_description").html(data['data_api']['response_inagrouper']['drg_description']);
        $("#drg_code").html(data['data_api']['response_inagrouper']['drg_code']);

        if (data['data_api']['response']['add_payment_amt'] !== null && data['data_api']['response']['add_payment_amt'] !== undefined){
            $('#hasilgrouperv5 tr#hdr_tambahan_biaya').remove();

            $('#hasilgrouperv5 > tbody:last-child').append('<tr id="hdr_tambahan_biaya"> <th>Tambahan Biaya</th> <th colspan="2"> </th><th>Rp </th><th id="addpayment_grouper_total" style="text-align:right"> '+data['data_api']['response']['add_payment_amt']+'</th></tr>');
        }

        //$('#cbg_description').html(data['data_api']['response']['special_cmg']['description']); 
        if (data['data_api']['response']['special_cmg'] !== null && data['data_api']['response']['special_cmg']!== undefined) {

            for (i = 0; i < data['data_api']['response']['special_cmg'].length; i++) {

                if(data['data_api']['response']['special_cmg'][i].type == 'Special Procedure'){
                    $('#sp_procedure_code').html(data['data_api']['response']['special_cmg'][i]['code']); 
                    $('#sp_procedure_tarif').html(data['data_api']['response']['special_cmg'][i]['tariff']);
                }else if(data['data_api']['response']['special_cmg'][i].type == 'Special Prosthesis'){
                    $('#sp_prosthesis_code').html(data['data_api']['response']['special_cmg'][i]['code']); 
                    $('#sp_prosthesis_tarif').html(data['data_api']['response']['special_cmg'][i]['tariff']); 
                }else if(data['data_api']['response']['special_cmg'][i].type == 'Special Investigation'){
                    $('#sp_investigation_code').html(data['data_api']['response']['special_cmg'][i]['code']); 
                    $('#sp_investigation_tarif').html(data['data_api']['response']['special_cmg'][i]['tariff']);
                }else if(data['data_api']['response']['special_cmg'][i].type == 'Special Drug'){
                    $('#sp_drug_code').html(data['data_api']['response']['special_cmg'][i]['code']); 
                    $('#sp_drug_tarif').html(data['data_api']['response']['special_cmg'][i]['tariff']);
                }
            }

        }else{
                    $('#sp_procedure_code').html('-'); 
                    $('#sp_procedure_tarif').html(0);
                    $('#sp_prosthesis_code').html('-'); 
                    $('#sp_prosthesis_tarif').html(0); 
                    $('#sp_investigation_code').html('-'); 
                    $('#sp_investigation_tarif').html(0);
                    $('#sp_drug_code').html('-'); 
                    $('#sp_drug_tarif').html(0);
        }

        if (data['data_api']['response']['covid19_data'] !== null && data['data_api']['response']['covid19_data'] !== undefined) {

            var nilai_klaim = data['data_api']['response']['covid19_data']['nilai_klaim'];

            $('#hasilgrouperv5 tr#hdr_pemulasaraan_jenazah').remove();
            $('#hasilgrouperv5 tr#hdr_terapi_konvalesen').remove();
            $('#hasilgrouperv5 tr#paket_biaya').remove();
            $('#hasilgrouperv5 tr#hdr_paket_biaya2').remove();
            $('#hasilgrouperv5 tr#hdr_rawat_igd').remove();

           var pemulasaraan_jenazah = parseFloat(data['data_api']['response']['covid19_data']['top_up_jenazah']);
            if (pemulasaraan_jenazah != 0 ){

                $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_pemulasaraan_jenazah"><th>  Pemulasaraan Jenazah  </th> <th colspan="2" ></th><th>Rp </th> <th id="pemulasaraan_jenazah_grouper" style="text-align:right">'+number_to_price(pemulasaraan_jenazah)+'</th> </tr>');
            }

            var terapi_konvalesen = parseFloat(data['data_api']['response']['covid19_data']['terapi_konvalesen']);
            if (terapi_konvalesen != 0 ){

                $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_terapi_konvalesen"><th>  Terapi Plasma  </th> <th colspan="2" ></th><th>Rp </th> <th style="text-align:right">'+number_to_price(terapi_konvalesen)+'</th> </tr>');
            }

           
           // document.getElementById("tr_paket_biaya").style.display = "block";
           if (data['data_api']['response']['covid19_data']['rs_darurat_ind'] == '1'){
             $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="paket_biaya"><th> Paket Biaya </th> <th colspan="2" > RS DARURAT / LAPANGAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
           }

           if (data['data_api']['response']['covid19_data']['isoman_ind'] == '1'){
            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_paket_biaya2"><th> Paket Biaya </th> <th colspan="2" > ISOMAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
          }

          if (data['data_api']['response']['covid19_data']['igd_ind'] == '1'){
            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_rawat_igd"><th> Rawat IGD </th> <th></th><th>'+data['data_api']['response']['covid19_data']['top_up_rawat_factor']*100+'%</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['covid19_data']['top_up_rawat'])+'</th> </tr>');
          }
            
        }
        CalculateGrouper(nilai_klaim);

    } else {
        toast(data.message, "error")
    }
}

async function goGrouping_stage2() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
     var sp_procedure = $("#sp_procedure").val();
     var sp_prosthesis = $("#sp_prosthesis").val();
     var sp_investigation = $("#sp_investigation").val();
     var sp_drug = $("#sp_drug").val();
    let url = base_url + '/SIKBREC/public/bEKlaim/grouping_stage_2';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data + 
            "&sp_procedure=" + sp_procedure
            +"&sp_prosthesis=" + sp_prosthesis
            +"&sp_investigation=" + sp_investigation
            +"&sp_drug=" + sp_drug
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


async function goFinalClaim() {
    try {
        $(".preloader").fadeIn();
        const data = await FinalClaim();
        updateUIdataFinalClaim(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataFinalClaim(data) {
    if (data.status == 'success') {
        toast(data.message, "success")
        showGrouper();
        DisableForm();
    } else {
        toast(data.message, "error")
    }
}

async function FinalClaim() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    var total_grouper_input = $("#total_grouper_input").val();
    var tarif_rs = $("#tarif_rs").val();
    let url = base_url + '/SIKBREC/public/bEKlaim/claim_final';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data 
                +'&total_grouper_input=' +total_grouper_input
                +'&tarif_rs=' +tarif_rs
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

async function showGrouper() {
    try {
        const data = await goshowGrouper();
        updateUIdatagoshowGrouper(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoshowGrouper(data) {
    // console.log(data)
    // return false;

    //GROUPER 
    if (data['data_api']['response']['data']['grouper']['response'] != null){

    if (data['data_api']['response']['data']['kode_tarif'] == 'BS'){
        var kode_tarif = 'TARIF RS KELAS B SWASTA';
    }

    $('#info').html(data['data_api']['response']['data']['coder_nm']+' @ '+data['data_local'][0]['DATE_UPDATE']+'..'+'Kelas '+data['data_api']['response']['data']['kelas_rs']+'.. Tarif: '+kode_tarif); 

    var los = '';

    if (data['data_api']['response']['data']['jenis_rawat'] == '2'){
        var jenis_rawat = 'RAWAT JALAN';

        if (data['data_api']['response']['data']['kelas_rawat'] == '3'){
            var kelas_rawat = 'Regular';
        }else{
            var kelas_rawat = 'Eksekutif';
        }
    }else if (data['data_api']['response']['data']['jenis_rawat'] == '1'){
        var jenis_rawat = 'RAWAT INAP';
        var kelas_rawat = ' Kelas '+data['data_api']['response']['data']['kelas_rawat'];
        var los = ' ('+data['data_api']['response']['data']['los']+' Hari)';

        //INA GROUPER V6
        document.getElementById("hasil_grouper_v6").style.display = 'block';
        $('#info_v6').html(data['data_api']['response']['data']['coder_nm']+' @ '+data['data_local'][0]['DATE_UPDATE']+'..'+'Kelas '+data['data_api']['response']['data']['kelas_rs']+'.. Tarif: '+kode_tarif); 
        $('#jenis_rawat_grouper_v6').html(jenis_rawat+' '+los); 
        $("#mdc_description").html(data['data_api']['response']['data']['grouper']['response_inagrouper']['mdc_description']);
        $("#mdc_number").html(data['data_api']['response']['data']['grouper']['response_inagrouper']['mdc_number']);
        $("#drg_description").html(data['data_api']['response']['data']['grouper']['response_inagrouper']['drg_description']);
        $("#drg_code").html(data['data_api']['response']['data']['grouper']['response_inagrouper']['drg_code']);


    }else if (data['data_api']['response']['data']['jenis_rawat'] == '3'){
        var jenis_rawat = 'RAWAT IGD';
        var kelas_rawat = 'Regular';
    }

    $('#jenis_rawat_grouper').html(jenis_rawat+kelas_rawat+los); 

    $('#cbg_description').html(data['data_api']['response']['data']['grouper']['response']['cbg']['description']); 
    $('#cbg_code').html(data['data_api']['response']['data']['grouper']['response']['cbg']['code']); 
    $('#cbg_tarif').html(data['data_api']['response']['data']['grouper']['response']['cbg']['tariff']); 

    if (data['data_api']['response']['data']['kemenkes_dc_status_cd'] == 'unsent'){
        var kemenkes_status = 'Klaim belum terkirim ke Pusat Data Kementerian Kesehatan';
        $("#status_dc_kemkes").css("color", "red");
    }else if (data['data_api']['response']['data']['kemenkes_dc_status_cd'] == 'sent'){
        var kemenkes_status = 'Terkirim';
        $("#status_dc_kemkes").css("color", "green");
    }else{
        var kemenkes_status = data['data_api']['response']['data']['kemenkes_dc_status_cd'];
        $("#status_dc_kemkes").css("color", "black");
    }

    var x = document.getElementById("final_button");
     x.style.display = "block";

    $("#status_dc_kemkes").html(kemenkes_status)
    $("#status_klaim").html(data['data_api']['response']['data']['klaim_status_cd'])

    var tambahan_biaya = parseFloat(data['data_api']['response']['data']['add_payment_amt']);
    $("#addpayment_grouper_total").html(tambahan_biaya);

    if (data['data_api']['response']['data']['grouper']['response']['add_payment_amt'] !== null && data['data_api']['response']['data']['grouper']['response']['add_payment_amt'] !== undefined){
        $('#hasilgrouperv5 tr#hdr_tambahan_biaya').remove();

        $('#hasilgrouperv5 > tbody:last-child').append('<tr id="hdr_tambahan_biaya"> <th>Tambahan Biaya</th> <th colspan="2"> </th><th>Rp </th><th id="addpayment_grouper_total" style="text-align:right"> '+data['data_api']['response']['data']['grouper']['response']['add_payment_amt']+'</th></tr>');
    }
    

    //GROUPER SPECIAL CMG
    if (data['data_api']['response']['data']['grouper']['response']['special_cmg'] !== null && data['data_api']['response']['data']['grouper']['response']['special_cmg']!== undefined) {
        

        $("#sp_procedure").empty();
        $("#sp_prosthesis").empty();
        $("#sp_investigation").empty();
        $("#sp_drug").empty();

        for (i = 0; i < data['data_api']['response']['data']['grouper']['response']['special_cmg'].length; i++) {
            var newRow = '<option value="' + data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].code + '">' +  data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].description + '</option>';

            if(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].type == 'Special Procedure'){
                $("#sp_procedure").append(newRow);
                $('#sp_procedure_code').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['code']); 
                $('#sp_procedure_tarif').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['tariff']); 
            }else if(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].type == 'Special Prosthesis'){
                $("#sp_prosthesis").append(newRow);
                $('#sp_prosthesis_code').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['code']); 
                $('#sp_prosthesis_tarif').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['tariff']); 
            }else if(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].type == 'Special Investigation'){
                $("#sp_investigation").append(newRow);
                $('#sp_investigation_code').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['code']); 
                $('#sp_investigation_tarif').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['tariff']);
            }else if(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i].type == 'Special Drug'){
                $("#sp_drug").append(newRow);
                $('#sp_drug_code').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['code']); 
                $('#sp_drug_tarif').html(data['data_api']['response']['data']['grouper']['response']['special_cmg'][i]['tariff']);
            }

            var newRow = "<option value=''>None</option>"
            $("#sp_procedure").append(newRow);
            $("#sp_prosthesis").append(newRow);
            $("#sp_investigation").append(newRow);
            $("#sp_drug").append(newRow);
        }
    }else{
                $('#sp_procedure_code').html('-'); 
                $('#sp_procedure_tarif').html(0);
                $('#sp_prosthesis_code').html('-'); 
                $('#sp_prosthesis_tarif').html(0); 
                $('#sp_investigation_code').html('-'); 
                $('#sp_investigation_tarif').html(0);
                $('#sp_drug_code').html('-'); 
                $('#sp_drug_tarif').html(0);
    }

    if (data['data_api']['response']['data']['klaim_status_cd'] == 'final'){
        $('#header_v5').css({'background-color': '#ccddcc'}); 
        $('#hasilgrouperv5 tr').css({'background-color': '#d7fad7'}); 
        $("#btnCetakKlaim").attr('disabled',false);
        $("#btnReeditClaim").attr('disabled',false);
        $("#btnKirimKlaimOnline").attr('disabled',false);
        $('#header_v6').css({'background-color': '#ccddcc'}); 
        $('#hasilgrouperv6 tr').css({'background-color': '#d7fad7'}); 
    }else{
        $('#header_v5').css({'background-color': ''}); 
        $('#hasilgrouperv5 tr').css({'background-color': ''}); 
        $("#btnCetakKlaim").attr('disabled',true);
        $("#btnReeditClaim").attr('disabled',true);
        $("#btnKirimKlaimOnline").attr('disabled',true);
        $('#header_v6').css({'background-color': ''}); 
        $('#hasilgrouperv6 tr').css({'background-color': ''}); 
    }

    if (data['data_api']['response']['data']['grouper']['response']['covid19_data'] !== null && data['data_api']['response']['data']['grouper']['response']['covid19_data'] !== undefined) {

        var nilai_klaim = data['data_api']['response']['data']['grouper']['response']['covid19_data']['nilai_klaim'];

        $('#hasilgrouperv5 tr#hdr_pemulasaraan_jenazah').remove();
        $('#hasilgrouperv5 tr#hdr_terapi_konvalesen').remove();
        $('#hasilgrouperv5 tr#paket_biaya').remove();
        $('#hasilgrouperv5 tr#hdr_paket_biaya2').remove();
        $('#hasilgrouperv5 tr#hdr_rawat_igd').remove();

       var pemulasaraan_jenazah = parseFloat(data['data_api']['response']['data']['grouper']['response']['covid19_data']['top_up_jenazah']);
        if (pemulasaraan_jenazah != 0 ){

            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_pemulasaraan_jenazah"><th>  Pemulasaraan Jenazah  </th> <th colspan="2" ></th><th>Rp </th> <th id="pemulasaraan_jenazah_grouper" style="text-align:right">'+number_to_price(pemulasaraan_jenazah)+'</th> </tr>');
        }

        var terapi_konvalesen = parseFloat(data['data_api']['response']['data']['grouper']['response']['covid19_data']['terapi_konvalesen']);
        if (terapi_konvalesen != 0 ){

            $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_terapi_konvalesen"><th>  Terapi Plasma  </th> <th colspan="2" ></th><th>Rp </th> <th style="text-align:right">'+number_to_price(terapi_konvalesen)+'</th> </tr>');
        }

       
       // document.getElementById("tr_paket_biaya").style.display = "block";
       if (data['data_api']['response']['data']['grouper']['response']['covid19_data']['rs_darurat_ind'] == '1'){
         $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="paket_biaya"><th> Paket Biaya </th> <th colspan="2" > RS DARURAT / LAPANGAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['data']['grouper']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
       }

       if (data['data_api']['response']['data']['grouper']['response']['covid19_data']['isoman_ind'] == '1'){
        $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_paket_biaya2"><th> Paket Biaya </th> <th colspan="2" > ISOMAN</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['data']['grouper']['response']['covid19_data']['top_up_rawat_gross'])+'</th> </tr>');
      }

      if (data['data_api']['response']['data']['grouper']['response']['covid19_data']['igd_ind'] == '1'){
        $('#hasilgrouperv5 > tbody:last-child').append(' <tr id="hdr_rawat_igd"><th> Rawat IGD </th> <th></th><th>'+data['data_api']['response']['data']['grouper']['response']['covid19_data']['top_up_rawat_factor']*100+'%</th><th>Rp </th> <th id="paket_biaya" style="text-align:right">'+number_to_price(data['data_api']['response']['data']['grouper']['response']['covid19_data']['top_up_rawat'])+'</th> </tr>');
      }
        
    }

        CalculateGrouper(nilai_klaim);

        if ($("#nomor_register_sitb").val() == ''){
            $("#btnValidasiSITB").show();
            $("#btnValidasiSITBUbah").hide();
        }else{
            $("#btnValidasiSITB").hide();
            $("#btnValidasiSITBUbah").show();
        }
    
    }

    //Riwayat_Klaim();

    // if (data.status == 'success') {
    //     toast(data.message, "success");

    // } else {
    //     toast(data.message, "error")
    // }
}

async function goshowGrouper() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/get_claim_data';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
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
           // $(".preloader").fadeOut();
        })
}

//GET Data From Local DB
async function showDataSaved() {
    try {
        const data = await goGetDatabyIDEKLAIM();
        updateUIdatagoGetDatabyIDEKLAIM(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoGetDatabyIDEKLAIM(data) {
    //console.log(data.data);

    $('#penjamin').val(data.data.PENJAMIN);
    $('#nomor_rm').val(data.data.NO_MR);
    $('#nama_pasien').val(data.data.NAMA_PASIEN);
    $("#gender").val(data.data.GENDER);
    $('#tgl_lahir').val(data.data.TGL_LAHIR);
    $('#nomor_registrasi').val(data.data.NO_REGISTRASI);
    $('#nomor_sep').val(data.data.NO_SEP);
    $("#tgl_masuk").val(data.data.StartDate + "\T" + data.data.JamMasuk);
    $("#tgl_pulang").val(data.data.EndDate + "\T" + data.data.JamKeluar);
    $("#jenis_rawat").val(data.data.JENIS_RAWAT).trigger('change');;
    $("#kelas_rawat").val(data.data.KELAS_RAWAT).trigger('change');;
    $("#adl_sub_acute").val(data.data.ADL_SUB_ACUTE);
    $("#adl_chronic").val(data.data.ADL_CHRONIC);
    $("#icu_los").val(data.data.ICU_LOS);
    $("#ventilator_hour").val(data.data.VENTILATOR_HOUR);
    $("#upgrade_class_class").val(data.data.UPGRADE_CLASS_CLASS);
    $("#upgrade_class_los").val(data.data.UPGRADE_CLASS_LOS);
    $("#add_payment_pct").val(data.data.ADD_PAYMENT_PCT);
    $("#birth_weight").val(data.data.BIRTH_WEIGHT);
    $("#discharge_status").val(data.data.DISCHARGE_STATUS);


    $("#prosedur_non_bedah").val(number_to_price(data.data.TARIF_PROSEDUR_NON_BEDAH));
    $("#prosedur_bedah").val(number_to_price(data.data.TARIF_PROSEDUR_BEDAH));
    $("#konsultasi").val(number_to_price(data.data.TARIF_KONSULTASI));
    $("#tenaga_ahli").val(number_to_price(data.data.TARIF_TENAGA_AHLI));
    $("#keperawatan").val(number_to_price(data.data.TARIF_KEPERAWATAN));
    $("#penunjang").val(number_to_price(data.data.TARIF_PENUNJANG));
    $("#radiologi").val(number_to_price(data.data.TARIF_RADIOLOGI));
    $("#laboratorium").val(number_to_price(data.data.TARIF_LABORATORIUM));
    $("#pelayanan_darah").val(number_to_price(data.data.TARIF_PELAYANAN_DARAH));
    $("#rehabilitasi").val(number_to_price(data.data.TARIF_REHABILITASI));
    $("#kamar").val(number_to_price(data.data.TARIF_KAMAR));
    $("#rawat_intensif").val(number_to_price(data.data.TARIF_RAWAT_INTENSIF));
    $("#obat").val(number_to_price(data.data.TARIF_OBAT));
    $("#obat_kronis").val(number_to_price(data.data.TARIF_OBAT_KRONIS));
    $("#obat_kemoterapi").val(number_to_price(data.data.TARIF_OBAT_KEMOTERAPI));
    $("#alkes").val(number_to_price(data.data.TARIF_ALKES));
    $("#bmhp").val(number_to_price(data.data.TARIF_BMHP));
    $("#sewa_alat").val(number_to_price(data.data.TARIF_SEWA_ALAT));

    $("#terapi_konvalesen").val(data.data.TERAPI_KONVALESEN);
    $("#tarif_poli_eks").val(data.data.TARIF_POLI_EKS);
    $("#nama_dokter").val(data.data.NAMA_DOKTER);
    $("#kode_tarif").val(data.data.KODE_TARIF);
    $("#payor_id").val(data.data.PAYOR_ID);
    //$("#").val(data.data.PAYOR_CD);
    $("#cob_cd").val(data.data.COB_CD).trigger('change');
    // $("#").val(data.data.CODER_NIK);
    // $("#").val(data.data.DATE_UPDATE);
    // $("#").val(data.data.USER_UPDATE);
    // $("#").val(data.data.FINAL_KLAIM);
    // $("#").val(data.data.SEND_CLAIM_INDIVIDUAL);

    $('#los').val(data.data.LOS);
   // $('#los_jam').val(dataResponse.data.JAM_LOS);
    $('#umur').val(data.data.UMUR);
    $('#berat_lahir').val(data.data.BIRTH_WEIGHT);
    $('#nomor_kartu').val(data.data.NO_KARTU);
    
    $('#covid19_rs_darurat_ind').val(data.data.COVID19_RS_DARURAT_IND);
    $('#isoman_ind').val(data.data.ISOMAN_IND);

    $("#nomor_register_sitb").val(data.data.NO_REGISTER_SITB);
    if (data.data.NO_REGISTER_SITB != null){
        $("#nomor_register_sitb").attr('readonly', true);
        $("#btnValidasiSITB").hide();
        $("#btnValidasiSITBUbah").show();
    }else{
        $("#nomor_register_sitb").attr('readonly', false);
        $("#btnValidasiSITB").show();
        $("#btnValidasiSITBUbah").hide();
    }

    //checkbox naik kelas
    if (data.data.UPGRADE_CLASS_IND == '1'){
        $('#upgrade_class_ind').attr('checked',true);
        myFunctionNaikTurunKelas();
    }

    //checkbox rawat intensif
    if (data.data.ICU_INDIKATOR == '1'){
        $('#icu_indikator').attr('checked',true);
        myFunctionRawatIntensif();
    }

    //checkbox poli eksekutif
    if (data.data.JENIS_RAWAT == '2' && data.data.KELAS_RAWAT == '1'){
        $('#kelas_eksekutif').attr('checked',true);
        myFunctionKelasEksekutif();
    }

    //checkbox co insidense
    if (data.data.COVID19_CO_INSIDENSE_IND == '1'){
        $('#covid19_co_insidense_ind').attr('checked',true);
        $('#covid19_no_sep').val(data.data.COVID19_NO_SEP);
        myFunctionCoYa();
    }

    $("#tarif_rs").val(number_to_price(data.data.TOTAL_TARIF_RS));
    //CalculateALL();
    if (data.data.PAYOR_CD == '3'){
        getUpgradeClass();
    }

    if (data.data.PEMULASARAAN_JENAZAH == '1'){
        $('#pemulasaraan_jenazah').attr('checked',true);
    }
    if (data.data.KANTONG_JENAZAH == '1'){
        $('#kantong_jenazah').attr('checked',true);
    }
    if (data.data.PETI_JENAZAH == '1'){
        $('#peti_jenazah').attr('checked',true);
    }
    if (data.data.PLASTIK_ERAT == '1'){
        $('#plastik_erat').attr('checked',true);
    }
    if (data.data.DESINFEKTAN_JENAZAH == '1'){
        $('#desinfektan_jenazah').attr('checked',true);
    }
    if (data.data.MOBIL_JENAZAH == '1'){
        $('#mobil_jenazah').attr('checked',true);
    }
    if (data.data.DESINFEKTAN_MOBIL_JENAZAH == '1'){
        $('#desinfektan_mobil_jenazah').attr('checked',true);
    }
    
    if (data.data.FINAL_KLAIM == '1'){
        DisableForm();
    }
    

}

async function goGetDatabyIDEKLAIM() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/goGetDatabyIDEKLAIM';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
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
            //$(".preloader").fadeOut();
        })
}

async function goReEditClaim(alasan) {
    try {
        $(".preloader").fadeIn();
        const data = await ReEditClaim(alasan);
        updateUIdataReEditClaim(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataReEditClaim(data) {
    if (data.status == 'success') {
        toast(data.message, "success")
        showGrouper();
        //EnableForm();
        $("#prosedur_non_bedah").prop('readonly', false);
        $("#prosedur_bedah").prop('readonly', false);
        $("#konsultasi").prop('readonly', false);
        $("#tenaga_ahli").prop('readonly', false);
        $("#keperawatan").prop('readonly', false);
        $("#penunjang").prop('readonly', false);
        $("#radiologi").prop('readonly', false);
        $("#laboratorium").prop('readonly', false);
        $("#pelayanan_darah").prop('readonly', false);
        $("#rehabilitasi").prop('readonly', false);
        $("#kamar").prop('readonly', false);
        $("#rawat_intensif").prop('readonly', false);
        $("#obat").prop('readonly', false);
        $("#obat_kronis").prop('readonly', false);
        $("#obat_kemoterapi").prop('readonly', false);
        $("#alkes").prop('readonly', false);
        $("#bmhp").prop('readonly', false);
        $("#sewa_alat").prop('readonly', false);
    } else {
        toast(data.message, "error")
    }
}

async function ReEditClaim(alasan) {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/reedit_claim';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data + "&alasan=" + alasan
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

async function goKirimKlaimOnline() {
    try {
        $(".preloader").fadeIn();
        const data = await KirimKlaimOnline();
        updateUIdataKirimKlaimOnline(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataKirimKlaimOnline(data) {
    if (data.status == 'success') {
        toast(data.message, "success")
        showGrouper();
    } else {
        toast(data.message, "error")
    }
}

async function KirimKlaimOnline() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/send_claim_individual';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
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

function goCetakKlaim(){
    var idParams = $("#nomor_sep").val();
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bEKLaim/claim_print/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function ViewUploadFile(idParams){
        var base_url = window.location.origin;
        var notrs = btoa(idParams); 
        window.open(base_url + "/SIKBREC/public/bEKLaim/ViewUploadFile/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

//CODING V6
async function AddRow_DiagnosaV6(){
    try {

        const dataGocreateDtl_DiagnosaV6 = await GocreateDtl_DiagnosaV6();
        updateUIdataGocreateDtl_DiagnosaV6(dataGocreateDtl_DiagnosaV6);
        showDataDetil_DiagnosaV6();
    } catch (err) {
        toast(err, "error")
    }
}

async function showDataDetil_DiagnosaV6() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#table_diagnosa_v6').DataTable().clear().destroy();
    $('#table_diagnosa_v6').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_DiagnosaV6/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.No + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_DIAGNOSA + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_DIAGNOSA + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STATUS_PRIMER + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var button = ""
                    if (row.IS_PRIMER == 0){
                        var button = '<button type="button" class="btn btn-secondary border-primary btn-animated btn-xs"  onclick="SetPrimer_Diagnosav6(' + row.ID + ')" ><span class="visible-content" >Set Primer</span></span></button>&nbsp'
                    }
                    var html = button+'<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="deletedetilPerItem_Diagv6(' + row.ID + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                     return html
                }
            },

        ], 
    });
    //$(".preloader").fadeOut();
} 
function updateUIdataGocreateDtl_DiagnosaV6(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success")
        $('#nama_diagnosav6').val('');
        $('#kode_diagnosav6').val('');
        $("#search_diagnosisv6").empty();
        $("#search_diagnosisv6").select2('open');
    }else{
        toast(dataResponse.message, "error")
    }
     
}
async function GocreateDtl_DiagnosaV6() {
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nama_diagnosa = document.getElementById("nama_diagnosav6").value;
    var kode_diagnosa = document.getElementById("kode_diagnosav6").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/addDiagnosav6/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
            + '&nama_diagnosa=' + nama_diagnosa
            + '&kode_diagnosa=' + kode_diagnosa
            + '&nomor_sep=' + nomor_sep
            + '&payor_id=' + payor_id
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

function deletedetilPerItem_Diagv6(param) {
    try {
        swal({
            title: "Hapus",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem2_diagv6(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function deletedetilPerItem2_diagv6(param) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetailsv6 = await goVoidDetails_Diagv6(param);
        updateUIdatagoVoidDetails_diagv6(datagoVoidDetailsv6);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails_diagv6(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_DiagnosaV6();
    }else{
        toast(params.message, "error")
    }
}

function SetPrimer_Diagnosav6(param) {
    try {
        swal({
            title: "Set Primer",
            text: "Apakah Anda ingin Menjadikan Item Ini Primer ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    SetPrimer2_DiagnosaV6(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function SetPrimer2_DiagnosaV6(param) {
    try {
         $(".preloader").fadeIn();
        const data = await goSetPrimer2_Diagnosav6(param);
        updateUIdatagoSetPrimer2_Diagnosav6(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoSetPrimer2_Diagnosav6(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_DiagnosaV6();
    }else{
        toast(params.message, "error")
    }
}

async function goSetPrimer2_Diagnosav6(param) {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/bEKlaim/SetPrimer_Diagnosav6/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
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

function deletedetilPerItem_Prosedurv6(param) {
    try {
        swal({
            title: "Hapus",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    deletedetilPerItem2_prosedurv6(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function deletedetilPerItem2_prosedurv6(param) {
    try {
         $(".preloader").fadeIn();
        const datagoVoidDetails = await godeletedetilPerItem2_prosedurv6(param);
        updateUIdatagoVoidDetails_prosedurv6(datagoVoidDetails);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoVoidDetails_prosedurv6(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_ProsedurV6();
    }else{
        toast(params.message, "error")
    }
}

async function godeletedetilPerItem2_prosedurv6(param) {
    var ProductCode = param;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var url2 = "/SIKBREC/public/bEKlaim/goVoidDetails_Prosedurv6/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
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

async function goVoidDetails_Diagv6(param) {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    var ProductCode = param;
    var url2 = "/SIKBREC/public/bEKlaim/goVoidDetails_Diagv6/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
        + '&payor_id=' + payor_id
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

async function AddRow_ProsedurV6(){
    try {

        const dataGocreateDtl_ProsedurV6 = await GocreateDtl_ProsedurV6();
        updateUIdataGocreateDtl_ProsedurV6(dataGocreateDtl_ProsedurV6);
        showDataDetil_ProsedurV6();
    } catch (err) {
        toast(err, "error")
    }
}

async function showDataDetil_ProsedurV6() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var base_url = window.location.origin;
    $('#table_prosedur_v6').DataTable().clear().destroy();
    $('#table_prosedur_v6').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_Prosedurv6/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.No + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_PROSEDUR + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KODE_PROSEDUR + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STATUS_PRIMER + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    if (row.IS_PRIMER == '1'){
                        var html = '<input type="text" value="' + row.JUMLAH + '" id="jumlah_multiplicity" name="jumlah_multiplicity">';
                     }
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var button = ""
                    var button2 = ""
                    //  var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="deletedetilPerItem_Prosedur(' + row.ID + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    if (row.IS_PRIMER == 1){
                        var button = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="UpdateMultiplicity(' + row.ID + ')" ><span class="visible-content" >Update Jumlah</span></span></button>&nbsp'
                    }
                    // else{
                    //     var button2 = '<button type="button" class="btn btn-secondary border-primary btn-animated btn-xs"  onclick="SetPrimer_ProsedurV6(' + row.ID + ')" ><span class="visible-content" >Set Primer</span></span></button>&nbsp'
                    // }
                    var html = button+button2+'<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="deletedetilPerItem_Prosedurv6(' + row.ID + ')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 
    });
    //$(".preloader").fadeOut();
} 
function updateUIdataGocreateDtl_ProsedurV6(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success")
        $('#nama_prosedurv6').val('');
        $('#kode_prosedurv6').val('');
        $("#search_proceduresv6").empty();
        $("#search_proceduresv6").select2('open');
    }else{
        toast(dataResponse.message, "error")
    }
}

async function UpdateMultiplicity(param) {
    try {
        $(".preloader").fadeIn();
        const data = await goUpdateMultiplicity(param);
        updateUIgoUpdateMultiplicity(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgoUpdateMultiplicity(data) {
    if (data.status == 'success') {
        toast(data.message, "success")
        showDataDetil_ProsedurV6()
    } else {
        toast(data.message, "error")
    }
}

async function goUpdateMultiplicity(param) {
    var base_url = window.location.origin;
    var jumlah = $("#jumlah_multiplicity").val();
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/goUpdateMultiplicity';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : 'ID='+param+
                '&Jumlah='+jumlah+
                '&ID_EKLAIM=' + ID_EKLAIM
                + '&nomor_sep=' + nomor_sep
                + '&payor_id=' + payor_id
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



async function GocreateDtl_ProsedurV6() {
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nama_prosedur = document.getElementById("nama_prosedurv6").value;
    var kode_prosedur = document.getElementById("kode_prosedurv6").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/addProsedurv6/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
            + '&nama_prosedur=' + nama_prosedur
            + '&kode_prosedur=' + kode_prosedur
            + '&nomor_sep=' + nomor_sep
            + '&payor_id=' + payor_id
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

async function ImportCoding(){
    try {

        const data = await goImportCoding();
        updateUIdatagoImportCoding(data);
        showDataDetil_DiagnosaV6();
        showDataDetil_ProsedurV6();
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoImportCoding(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success")
    }else{
        toast(dataResponse.message, "error")
    }
     
}
async function goImportCoding() {
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/ImportCoding/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
                + '&nomor_sep=' + nomor_sep
                + '&payor_id=' + payor_id
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

function showDataDetil_DiagnosaEMR() {
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#table_resume_medis').DataTable().clear().destroy();
    $('#table_resume_medis').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_DiagnosaEMR/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.nomor_registrasi = nomor_registrasi; 
            }
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Diagnosa_Awal + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Diagnosa_Akhir + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Komordibitas + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Alasan_Dirawat_Inap + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Anjuran + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Riwayat_Penyakit + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Obat_obatan + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Obat_obatanPulang + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Dokter_Merawat + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.Tindak_Lanjut + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STUATUSPULANG + '</font>  ';
                    return html
                }
            },

        ], 
    });
   // $(".preloader").fadeOut();
} 

function Riwayat_Klaim() {
    var nomor_rm = document.getElementById("nomor_rm").value;
    // var TransasctionCode = "TPR150720220001"; 
    var base_url = window.location.origin;
    $('#riwayat_klaim').DataTable().clear().destroy();
    $('#riwayat_klaim').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_RiwayatKlaim/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.nomor_rm = nomor_rm; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TGL_MASUK + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.TGL_PULANG + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.PAYOR_CD + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NO_SEP + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_JENIS_RAWAT + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.GROUP_CODE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.STATUS + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.PETUGAS + '</font>  ';
                    return html
                }
            },

        ], 
    });
    //$(".preloader").fadeOut();
} 

//CALCULATE TARIF
function CalculateALL() {

    var grandtotal = 0;

    var prosedur_non_bedah = parseFloat(price_to_number($("#prosedur_non_bedah").val()));
    var prosedur_bedah = parseFloat(price_to_number($("#prosedur_bedah").val()));
    var konsultasi = parseFloat(price_to_number($("#konsultasi").val()));
    var tenaga_ahli = parseFloat(price_to_number($("#tenaga_ahli").val()));
    var keperawatan = parseFloat(price_to_number($("#keperawatan").val()));
    var penunjang = parseFloat(price_to_number($("#penunjang").val()));
    var radiologi = parseFloat(price_to_number($("#radiologi").val()));
    var laboratorium = parseFloat(price_to_number($("#laboratorium").val()));
    var pelayanan_darah = parseFloat(price_to_number($("#pelayanan_darah").val()));
    var rehabilitasi = parseFloat(price_to_number($("#rehabilitasi").val()));
    var kamar = parseFloat(price_to_number($("#kamar").val()));
    var rawat_intensif = parseFloat(price_to_number($("#rawat_intensif").val()));
    var obat = parseFloat(price_to_number($("#obat").val()));
    var obat_kronis = parseFloat(price_to_number($("#obat_kronis").val()));
    var obat_kemoterapi = parseFloat(price_to_number($("#obat_kemoterapi").val()));
    var alkes = parseFloat(price_to_number($("#alkes").val()));
    var bmhp = parseFloat(price_to_number($("#bmhp").val()));
    var sewa_alat = parseFloat(price_to_number($("#sewa_alat").val()));

    grandtotal = 
    prosedur_non_bedah + prosedur_bedah + konsultasi + tenaga_ahli + keperawatan + penunjang + radiologi + laboratorium + pelayanan_darah + rehabilitasi + kamar + rawat_intensif + obat + obat_kronis + obat_kemoterapi + alkes + bmhp + sewa_alat

    $("#tarif_rs").val(number_to_price(grandtotal));

    $("#prosedur_non_bedah").val(number_to_price(prosedur_non_bedah))
    $("#prosedur_bedah").val(number_to_price(prosedur_bedah))
    $("#konsultasi").val(number_to_price(konsultasi))
    $("#tenaga_ahli").val(number_to_price(tenaga_ahli))
    $("#keperawatan").val(number_to_price(keperawatan))
    $("#penunjang").val(number_to_price(penunjang))
    $("#radiologi").val(number_to_price(radiologi))
    $("#laboratorium").val(number_to_price(laboratorium))
    $("#pelayanan_darah").val(number_to_price(pelayanan_darah))
    $("#rehabilitasi").val(number_to_price(rehabilitasi))
    $("#kamar").val(number_to_price(kamar))
    $("#rawat_intensif").val(number_to_price(rawat_intensif))
    $("#obat").val(number_to_price(obat))
    $("#obat_kronis").val(number_to_price(obat_kronis))
    $("#obat_kemoterapi").val(number_to_price(obat_kemoterapi))
    $("#alkes").val(number_to_price(alkes))
    $("#bmhp").val(number_to_price(bmhp))
    $("#sewa_alat").val(number_to_price(sewa_alat))

}


//CALCULATE GROUPER
function CalculateGrouper(nilai_klaim = null) {

    var grandtotal = 0;

    var cbg_tarif =parseFloat(price_to_number($("#cbg_tarif").html()));
    var sp_procedure =parseFloat(price_to_number($("#sp_procedure_tarif").html()));
    var sp_prosthesis =parseFloat(price_to_number($("#sp_prosthesis_tarif").html()));
    var sp_investigation =parseFloat(price_to_number($("#sp_investigation_tarif").html()));
    var sp_drug =parseFloat(price_to_number($("#sp_drug_tarif").html()));
    grandtotal = 
    cbg_tarif + sp_procedure + sp_prosthesis + sp_investigation + sp_drug
    if (!isNaN(parseFloat($("#addpayment_grouper_total").html()))){
        var tambahan_biaya = parseFloat($("#addpayment_grouper_total").html());
    }else{
        var tambahan_biaya = 0;
    }

    if (nilai_klaim == null){
        var grandtotal = grandtotal
    }else{
        var grandtotal = nilai_klaim
    }

    $("#total_grouper").html(number_to_price(grandtotal));
    $("#total_grouper_input").val(parseFloat(grandtotal)+parseFloat(tambahan_biaya));

    $("#cbg_tarif").html(number_to_price(cbg_tarif));
    $("#sp_procedure_tarif").html(number_to_price(sp_procedure));
    $("#sp_prosthesis_tarif").html(number_to_price(sp_prosthesis));
    $("#sp_investigation_tarif").html(number_to_price(sp_investigation));
    $("#sp_drug_tarif").html(number_to_price(sp_drug));
    $("#addpayment_grouper_total").html(number_to_price(tambahan_biaya));

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

//
function myFunctionJenisRawat() {

    // var x = document.getElementById("myDIV");
    // x.style.display = "block";
    var x = document.getElementById("myDIV_KelasEksekutif");
    x.style.display = "block";

    var x = document.getElementById("myDIV_NaikTurunKelas");
    x.style.display = "none";
    var x = document.getElementById("myDIV_RawatIntensif");
    x.style.display = "none";

    var x = document.getElementById("myDIV_KelasHakRanap");
    x.style.display = "none";
    var x = document.getElementById("myDIV_KelasHakRajal");
    x.style.display = "block";

    var x = document.getElementById("myDIV_Co");
    x.style.display = "none";


    var x = document.getElementById("myLi_Coding5");
    x.style.display = "block";

    var x = document.getElementById("myLi_Coding6");
    x.style.display = "none";
    var x = document.getElementById("myDiv_Coding6");
    x.style.display = "none";

    var x = document.getElementById("myDiv_Coding5");
    x.style.display = "block";

    var x = document.getElementById("MyDIV_ranap_covid");
    x.style.display = "none";

    var x = document.getElementById("myDIV_CovidRanap");
    x.style.display = "none";

    $('#kelas_rawat option:not(:selected)').prop('disabled', false);
    
    // var x = document.getElementById("myDiv_Coding5");
    // x.style.display = "block";

}

function getUpgradeClass(){
    if ($("#kelas_rawat").val() == '3'){
        $("#upgrade_class_class").val('kelas_2');
        $('#upgrade_class_class option[value="kelas_3"]').attr("disabled", true);
        $('#upgrade_class_class option[value="kelas_2"]').attr("disabled", false);
        $('#upgrade_class_class option[value="kelas_1"]').attr("disabled", false);
        document.getElementById("naik_kelas_vip").style.display = "none";
        document.getElementById("naik_kelas_vip2").style.display = "block";
    }else if ($("#kelas_rawat").val() == '2'){
        $("#upgrade_class_class").val('kelas_1');
        $('#upgrade_class_class option[value="kelas_3"]').attr("disabled", true);
        $('#upgrade_class_class option[value="kelas_2"]').attr("disabled", true);
        $('#upgrade_class_class option[value="kelas_1"]').attr("disabled", false);
        document.getElementById("naik_kelas_vip").style.display = "none";
        document.getElementById("naik_kelas_vip2").style.display = "block";
    }else if ($("#kelas_rawat").val() == '1'){
        $("#upgrade_class_class").val('vip');
        $('#upgrade_class_class option[value="kelas_3"]').attr("disabled", true);
        $('#upgrade_class_class option[value="kelas_2"]').attr("disabled", true);
        $('#upgrade_class_class option[value="kelas_1"]').attr("disabled", true);
        document.getElementById("naik_kelas_vip").style.display = "block";
        document.getElementById("naik_kelas_vip2").style.display = "none";
    }
}

function getElementChange(e){
        // if (e == '2'){
        //     myFunctionJenisRawat();
        // }else{
        //     myFunctionJenisRawat2();
        // }
        getJaminanCovid();
}

function myFunctionJenisRawat2() {

    var x = document.getElementById("myDIV_KelasEksekutif");
    x.style.display = "none";

    var x = document.getElementById("myDIV_TarifPoli");
    x.style.display = "none";

    var x = document.getElementById("myDIV_NaikTurunKelas");
    x.style.display = "block";
    var x = document.getElementById("myDIV_RawatIntensif");
    x.style.display = "block";

    var x = document.getElementById("myDIV_KelasHakRanap");
    x.style.display = "block";
    var x = document.getElementById("myDIV_KelasHakRajal");
    x.style.display = "none";

    var x = document.getElementById("myDIV_Co");
    x.style.display = "block";

    var x = document.getElementById("myLi_Coding5");
    x.style.display = "block";
    var x = document.getElementById("myLi_Coding6");
    x.style.display = "block";
    var x = document.getElementById("MyDIV_ranap_covid");
    x.style.display = "none";
    var x = document.getElementById("myDIV_CovidRanap");
    x.style.display = "none";
    
    $('#kelas_rawat option:not(:selected)').prop('disabled', false);
    // var x = document.getElementById("myDiv_Coding5");
    // x.style.display = "block";
    // var x = document.getElementById("myDiv_Coding6");
    // x.style.display = "block";
}

function myFunctionJenisRawat3() {

    var x = document.getElementById("myDIV_KelasEksekutif");
    x.style.display = "none";

    var x = document.getElementById("myDIV_TarifPoli");
    x.style.display = "none";

    var x = document.getElementById("myDIV_NaikTurunKelas");
    x.style.display = "none";
    var x = document.getElementById("myDIV_RawatIntensif");
    x.style.display = "block";

    var x = document.getElementById("myDIV_KelasHakRanap");
    x.style.display = "block";
    var x = document.getElementById("myDIV_KelasHakRajal");
    x.style.display = "none";

    var x = document.getElementById("myDIV_Co");
    x.style.display = "none";

    var x = document.getElementById("myLi_Coding5");
    x.style.display = "block";
    var x = document.getElementById("myLi_Coding6");
    x.style.display = "block";
    
    var x = document.getElementById("MyDIV_ranap_covid");
    x.style.display = "block";

    var x = document.getElementById("myDIV_CovidRanap");
    x.style.display = "block";
    
    $('#kelas_rawat option:not(:selected)').prop('disabled', true);
}

function myFunctionJenisRawat4() {

    // var x = document.getElementById("myDIV");
    // x.style.display = "block";
    var x = document.getElementById("myDIV_KelasEksekutif");
    x.style.display = "none";

    var x = document.getElementById("myDIV_NaikTurunKelas");
    x.style.display = "none";
    var x = document.getElementById("myDIV_RawatIntensif");
    x.style.display = "none";

    var x = document.getElementById("myDIV_KelasHakRanap");
    x.style.display = "none";
    var x = document.getElementById("myDIV_KelasHakRajal");
    x.style.display = "block";

    var x = document.getElementById("myDIV_Co");
    x.style.display = "none";


    var x = document.getElementById("myLi_Coding5");
    x.style.display = "block";

    var x = document.getElementById("myLi_Coding6");
    x.style.display = "none";
    var x = document.getElementById("myDiv_Coding6");
    x.style.display = "none";

    var x = document.getElementById("myDiv_Coding5");
    x.style.display = "block";

    var x = document.getElementById("MyDIV_ranap_covid");
    x.style.display = "none";

    var x = document.getElementById("myDIV_CovidRanap");
    x.style.display = "none";

    $('#kelas_rawat option:not(:selected)').prop('disabled', false);
    
    // var x = document.getElementById("myDiv_Coding5");
    // x.style.display = "block";

}

function myFunctionKelasEksekutif() {
    var x = document.getElementById("myDIV_TarifPoli");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function myFunctionCoYa() {
    var x = document.getElementById("myDIV_NoKlaim");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    // var x = document.getElementById("myDIV_Validasi");
    // if (x.style.display === "none") {
    //     x.style.display = "block";
    // } else {
    //     x.style.display = "none";
    // }
}

function myFunctionNaikTurunKelas() {
    var x = document.getElementById("myDIV_KelasPelayanan");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function myFunctionRawatIntensif() {
    var x = document.getElementById("myDIV_RawatIntensifInput");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function myFunctionCodingResume() {
    showDataDetil_DiagnosaEMR();

    var x = document.getElementById("myDiv_Coding5");
    x.style.display = "none";
    var x = document.getElementById("myDiv_Coding6");
    x.style.display = "none";
    var x = document.getElementById("resume_medis_emr2");
    x.style.display = "block";
}

function myFunctionCodingv5() {
    var x = document.getElementById("myDiv_Coding5");
    x.style.display = "block";
    var x = document.getElementById("myDiv_Coding6");
    x.style.display = "none";
    var x = document.getElementById("resume_medis_emr2");
    x.style.display = "none";
}

function myFunctionCodingv6() {
    var x = document.getElementById("myDiv_Coding5");
    x.style.display = "none";
    var x = document.getElementById("myDiv_Coding6");
    x.style.display = "block";
    var x = document.getElementById("resume_medis_emr2");
    x.style.display = "none";
}

async function getJaminanCovid(){
    $('#payor_id option[value="72"]').attr("disabled", true);
    $('#payor_id option[value="73"]').attr("disabled", true);
    $('#payor_id option[value="74"]').attr("disabled", true);
    $('#payor_id option[value="75"]').attr("disabled", true);
    $('#payor_id option[value="76"]').attr("disabled", true);
    var x = document.getElementById("payor_id");
    if (x.value == '71') {
        if ($("#discharge_status").val() == '4'){
            document.getElementById("covid_meninggal").style.display = 'block';
        }else{
            document.getElementById("covid_meninggal").style.display = 'none';
        }

        if ($("#jenis_rawat").val() == '2'){
            document.getElementById("kantong_plasma").style.display = 'none';
        }else{
            document.getElementById("kantong_plasma").style.display = 'block';
        }
        

        if ($("#jenis_rawat").val() == '2'){
            $('#isoman_ind option:not(:selected)').prop('disabled', false);
            myFunctionJenisRawat4();
        }else if($("#jenis_rawat").val() == '3'){
            $("#isoman_ind").val('0');
            $('#isoman_ind option:not(:selected)').prop('disabled', true);
            $('#covid19_rs_darurat_ind option:not(:selected)').prop('disabled', false);
            myFunctionJenisRawat3();
        }else{
            $('#isoman_ind option:not(:selected)').prop('disabled', false);
            myFunctionJenisRawat3();
        }

        document.getElementById("upload_file_covid").style.display = 'block';
        $('#jenis_rawat option[value="3"]').attr("disabled", false);
        document.getElementById("covid_kartu").style.display = 'block';
        document.getElementById("margin_covid").style.display = 'none';
        $("#nomor_kartu").prop('readonly', false);

    }else{
        document.getElementById("covid_meninggal").style.display = 'none';
        document.getElementById("kantong_plasma").style.display = 'none';
        document.getElementById("upload_file_covid").style.display = 'none';
        $('#jenis_rawat option[value="3"]').attr("disabled", true);
        document.getElementById("covid_kartu").style.display = 'none';
        document.getElementById("margin_covid").style.display = 'block';
       // $("#nomor_kartu").prop('readonly', true);

        if ($("#jenis_rawat").val() == '2'){
            myFunctionJenisRawat();
        }else{
            myFunctionJenisRawat2();
        }
        
    }
}

function Is_isoman_ind(e){
    if (e.id == 'isoman_ind'){
        if (e.value == '1'){
            $("#covid19_rs_darurat_ind").val('0');
            $('#covid19_rs_darurat_ind option:not(:selected)').prop('disabled', true);
        }else{
            $('#covid19_rs_darurat_ind option:not(:selected)').prop('disabled', false);
        }
    }else{
        if (e.value == '1'){
            $("#isoman_ind").val('0');
            $('#isoman_ind option:not(:selected)').prop('disabled', true);
        }else{
            $('#isoman_ind option:not(:selected)').prop('disabled', false);
        }

    }
}

function DisableForm (){
    $(".form-control").prop('readonly', true);
    $('#jenis_rawat option:not(:selected)').prop('disabled', true);
    $('#discharge_status option:not(:selected)').prop('disabled', true);
    $('#kelas_rawat option:not(:selected)').prop('disabled', true);
    $('#upgrade_class_class option:not(:selected)').prop('disabled', true);
    $("#btnValidasiSITB").hide();
    $("#btnValidasiSITBUbah").hide();
}

function EnableForm (){
    $(".form-control").prop('readonly', false);
    $('#jenis_rawat option:not(:selected)').prop('disabled', false);
    $('#discharge_status option:not(:selected)').prop('disabled', false);
    $('#kelas_rawat option:not(:selected)').prop('disabled', false);
    $('#upgrade_class_class option:not(:selected)').prop('disabled', false);
    $("#nomor_registrasi").prop('readonly', true);
    $("#nomor_rm").prop('readonly', true);
    $("#nama_pasien").prop('readonly', true);
    $("#tgl_lahir").prop('readonly', true);
    $("#tarif_rs").prop('readonly', true);
    $("#penjamin").prop('readonly', true);
    $("#ID_EKLAIM").prop('readonly', true);
    if ($("#nomor_register_sitb").val() == ''){
        $("#btnValidasiSITB").show();
        $("#btnValidasiSITBUbah").hide();
    }else{
        $("#btnValidasiSITB").hide();
        $("#btnValidasiSITBUbah").show();
    }
}

function number_to_price(v){
    if(v==0){return '0';}
    v=parseFloat(v);
    v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v=v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v){
    if(!v){return 0;}
    v=v.split('.').join('');
    v=v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);
  
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }
  
    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
  }

  function UploadFile(file_data,file_class){
    var base_url = window.location.origin;
    var form_data = new FormData();
    form_data.append("file", file_data) ;
    form_data.append("nomor_sep", $("#nomor_sep").val());
    form_data.append("ID_EKLAIM", $("#ID_EKLAIM").val());
    form_data.append("file_class", file_class);
    $.ajax({
        url: base_url + '/SIKBREC/public/bEKlaim/file_upload/',
      dataType: 'JSON',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data, 
      type: 'POST',
      beforeSend: function () {
        $(".preloader").fadeIn();
                    },
      success: function(data) {
        $(".preloader").fadeOut();
        if (data.status == 'success'){
            toast(data.message,'success');
            if (file_class == 'resume_medis'){
                showDataDetil_UploadResume();
                $("#file_ResumeMedis").val('');
            }else if (file_class == 'kartu_identitas'){
                showDataDetil_UploadKartuIdentitas();
                $("#file_KartuIdentitas").val('');
            }else if (file_class == 'bebas_biaya'){
                showDataDetil_UploadBebasBiaya();
                $("#file_BebasBiaya").val('');
            }else if (file_class == 'surat_kematian'){
                showDataDetil_UploadSuratKematian();
                $("#file_SuratKematian").val('');
            }
        }else{
            toast(data.message,'error');
        }
      }
    });
  }

  function showDataDetil_UploadResume() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var file_class = 'resume_medis';
    var base_url = window.location.origin;
    $('#table_file_resume_medis').DataTable().clear().destroy();
    $('#table_file_resume_medis').DataTable({
        "ordering": false,
        "paging": false,
        "searching": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_UploadFile/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
                d.file_class = file_class; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_FILE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.DATE_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.USER_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=ViewUploadFile(' + row.ID + ') ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-xs"  onclick=DeleteUploadFile(' + row.ID + ') ><span class="visible-content" > Delete</button>'
                    return html
                }
            },


        ], 
    });
    //$(".preloader").fadeOut();
} 

function showDataDetil_UploadKartuIdentitas() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var file_class = 'kartu_identitas';
    var base_url = window.location.origin;
    $('#table_file_kartuidentitas').DataTable().clear().destroy();
    $('#table_file_kartuidentitas').DataTable({
        "ordering": false,
        "paging": false,
        "searching": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_UploadFile/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
                d.file_class = file_class; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_FILE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.DATE_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.USER_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=ViewUploadFile(' + row.ID + ') ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-xs"  onclick=DeleteUploadFile(' + row.ID + ') ><span class="visible-content" > Delete</button>'
                    return html
                }
            },


        ], 
    });
    //$(".preloader").fadeOut();
} 

function showDataDetil_UploadBebasBiaya() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var file_class = 'bebas_biaya';
    var base_url = window.location.origin;
    $('#table_file_bebasbiaya').DataTable().clear().destroy();
    $('#table_file_bebasbiaya').DataTable({
        "ordering": false,
        "paging": false,
        "searching": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_UploadFile/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
                d.file_class = file_class; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_FILE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.DATE_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.USER_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=ViewUploadFile(' + row.ID + ') ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-xs"  onclick=DeleteUploadFile(' + row.ID + ') ><span class="visible-content" > Delete</button>'
                    return html
                }
            },


        ], 
    });
    //$(".preloader").fadeOut();
} 

function showDataDetil_UploadSuratKematian() {
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var file_class = 'surat_kematian';
    var base_url = window.location.origin;
    $('#table_file_suratkematian').DataTable().clear().destroy();
    $('#table_file_suratkematian').DataTable({
        "ordering": false,
        "paging": false,
        "searching": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/bEKlaim/getList_UploadFile/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID_EKLAIM = ID_EKLAIM; 
                d.file_class = file_class; 
            }
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.ID + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.NAMA_FILE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.DATE_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.USER_CREATE + '</font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=ViewUploadFile(' + row.ID + ') ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-xs"  onclick=DeleteUploadFile(' + row.ID + ') ><span class="visible-content" > Delete</button>'
                    return html
                }
            },


        ], 
    });
    //$(".preloader").fadeOut();
} 

function DeleteUploadFile(param) {
    try {
        swal({
            title: "Hapus",
            text: "Apakah Anda ingin Hapus Item Ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                   goDeleteUploadFile(param)
                } else {
                    //swal("Transaction Rollback !");
                }
            });
    } catch (err) {
        toast(err, "error")
    }
}

async function goDeleteUploadFile(param) {
    try {
         $(".preloader").fadeIn();
        const data = await DeleteUploadFile2(param);
        updateUIdataDeleteUploadFile2(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataDeleteUploadFile2(params) {
    if(params.status === 'success'){
        toast(params.message, "success")
        showDataDetil_UploadResume();
        showDataDetil_UploadKartuIdentitas();
        showDataDetil_UploadBebasBiaya();
        showDataDetil_UploadSuratKematian();
    }else{
        toast(params.message, "error")
    }
}

async function DeleteUploadFile2(param) {
    var ProductCode = param;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var url2 = "/SIKBREC/public/bEKlaim/file_delete/";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID_EKLAIM=" + ID_EKLAIM + "&ID=" + ProductCode 
        + '&nomor_sep=' + nomor_sep
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

async function goCreateCoInsidenseCovid() {
    try {
        $(".preloader").fadeIn();
        const data = await CreateCoInsidenseCovid();
        updateUIdataCreateCoInsidenseCovid(data);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataCreateCoInsidenseCovid(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        const base_url = window.location.origin;
        var str = btoa(data.data.nomor_registrasi);
        window.open(base_url + "/SIKBREC/public/bEKlaim/EklaimById/" + str , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    } else {
        toast(data.message, "error")
    }
}

async function CreateCoInsidenseCovid() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/create_co_insidense';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/bEklaim/ListCheckEklaim";
}

async function AutoGenerateTarifx(param) {
    try {
         $(".preloader").fadeIn();
        const data = await AutoGenerateTarif(param);
        updateUIdataAutoGenerateTarif(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function updateUIdataAutoGenerateTarif(dataResponse) {

    console.log(dataResponse,'datas');

         $("#laboratorium").val(dataResponse.data.TotalLab);
         $("#radiologi").val(dataResponse.data.TotalRad);
         $("#obat").val(dataResponse.data.TotalAptk);
         $("#prosedur_bedah").val(dataResponse.data.TotalOP);
         $("#kamar").val(dataResponse.data.TotalKamar);
         $("#keperawatan").val(dataResponse.data.TotalTindakan);
 
         if ($("#nomor_registrasi").val().substring(0, 2) == 'RJ'){
             $("#konsultasi").val(dataResponse.data.TarifKonsultasi);
             $("#penunjang").val(dataResponse.data.TarifTindakan);
             
             $("#pelayanan_darah").val(dataResponse.data.TarifPelayananDarah);
             $("#rehabilitasi").val(dataResponse.data.TarifFisio);
          }else{
              $("#konsultasi").val(dataResponse.data.TotalKonsul);
          }
          CalculateALL();

         $(".preloader").fadeOut();

 }
 
 async function AutoGenerateTarif() {
     var base_url = window.location.origin;
     var  id  = $("#nomor_registrasi").val();
     let url = base_url + '/SIKBREC/public/bEKlaim/AutoGenerateTarif/';
     return fetch(url, {
         method: 'POST',
         headers: {
             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
         },
         body: 'id=' + id 
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
             //$(".preloader").fadeOut();
         })
 }

 async function goCopyDiagnosaEMR(){
    try {
        const data = await goCopyDiagnosaEMR2();
        updateUIdatagoCopyDiagnosaEMR(data);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagoCopyDiagnosaEMR(dataResponse) {
    if(dataResponse.status == "success"){
        toast(dataResponse.message, "success");
        showDataDetil_Diagnosa();
        showDataDetil_Prosedur();
    }else{
        toast(dataResponse.message, "error")
    }
}

async function goCopyDiagnosaEMR2() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var ID_EKLAIM = document.getElementById("ID_EKLAIM").value;
    var nomor_registrasi = document.getElementById("nomor_registrasi").value;
    var nomor_sep = document.getElementById("nomor_sep").value;
    var payor_id = document.getElementById("payor_id").value;
    let url = base_url + '/SIKBREC/public/bEKlaim/CopyDiagnosaEMR/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID_EKLAIM=' + ID_EKLAIM
            + '&nomor_registrasi=' + nomor_registrasi
            + '&nomor_sep=' + nomor_sep
            + '&payor_id=' + payor_id
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

async function goValidasiSITB() {
    try {
        $(".preloader").fadeIn();
        const dataValidasiSITB = await ValidasiSITB();
        updateUIdataValidasiSITB(dataValidasiSITB);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataValidasiSITB(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        swal({
            title: "Success",
            text: data.message.detail+' - ID: '+data.message.validation.data[0].id+' - NAMA: '+data.message.validation.data[0].nama+' - NIK: '+data.message.validation.data[0].nik,
            icon: "success",
        });
        $("#nomor_register_sitb").attr('readonly', true);
        $("#btnValidasiSITB").hide();
        $("#btnValidasiSITBUbah").show();

    } else {
        toast(data.message, "error");
        swal({
            title: "Warning",
            text: data.message,
            icon: "warning",
        });
    }
}

async function ValidasiSITB() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/sitb_validate';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

async function goValidasiSITB_Void() {
    try {
        $(".preloader").fadeIn();
        const dataValidasiSITB = await ValidasiSITB_Void();
        updateUIdataValidasiSITBVoid(dataValidasiSITB);
       
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataValidasiSITBVoid(data) {
    if (data.status == 'success') {
        toast(data.message, "success");
        swal({
            title: "Success",
            text: data.message,
            icon: "success",
        });
        $("#nomor_register_sitb").val('');
        $("#nomor_register_sitb").attr('readonly', false);
        $("#btnValidasiSITB").show();
        $("#btnValidasiSITBUbah").hide();

    } else {
        toast(data.message, "error");
        swal({
            title: "Warning",
            text: data.message,
            icon: "warning",
        });
    }
}

async function ValidasiSITB_Void() {
    var base_url = window.location.origin;
    var data = $("#formdata").serialize();
    let url = base_url + '/SIKBREC/public/bEKlaim/sitb_invalidate';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body : data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                //$("#btnNewClaim").attr('disabled',false)
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}