
$(document).ready(function () {
    $(".preloader").fadeOut(); 
    $("#namatindakannew").attr('disabled', true);
    $("#dokterpemeriksanew").attr('disabled', true);
    $("#qty_addvisitnew").attr('disabled', true);
    $("#btnaddtindakanx").attr('disabled', true);
    $("#btnSaveAll").attr('disabled', true);

    $("#qty_fo2").attr('disabled', true);
    $("#diskon_fo2").attr('disabled', true);
    $("#btnupfo2update").attr('disabled', true);

    
    // $("#approvemodalBDRS").modal('show');
    // getDataApproveBDRS();

    
    // BtnTindakanByUnit();
    // $("#btn_Pasien_kabur").click(function () {
    //     $("#modal_TransferBill_Kabur").modal('show');
    // });
    asyncShowMain();
   
    // BtnTindakanByUnit();
     
    $('#tbl_rekapbiaya').DataTable( {
    } );

    $('#submit_checkout').click(function () {
        goCheckout();
    });
    $('#BtnNewInput').click(function () {
        Newtrs();
    });
    
    // $('#tarif_tindakan').change(function () {
    //     //Some code
    //     $("#tarif_tindakan").empty();
    //     var newRow = '<option value="">-- Pilih Tarif Tindakan --</option';
    //     $("#tarif_tindakan").append(newRow);
    //    $("#tarif_tindakan").select2();
    //    var xdii = document.getElementById("tarif_tindakan").value;
    //    showTarifTindakan(xdii);
    // });

    $('#btn_periode').click(function () {
       // $(".preloader").fadeIn(); 
        getDataDetailBilling();
        getDataDetailRincianHutang();
        getDataRekapBiaya();
        getDataRiwayatPayment();
        getPerusahaan();
        getAsuransi();

        getTotalPembayaranx();
        // getTotalPembayaran();
        


       // $(".preloader").fadeOut(); 
       //var x = document.getElementById("bg1");
            //x.style.display = "block";
            //$("#bg1").animate( { "opacity": "show", top:"0"} , 500 );
            $('#bg1').fadeOut().fadeIn('slow') 
    });

    $('#btn_approvefrm').click(function () {
        $("#approvemodal").modal('show');
        getDataApproveFarmasi();
    });
    $('#btn_approvefrmlabo').click(function () {
        $("#approvemodalLabo").modal('show');
        getDataApproveLabo();
    });
    $('#btn_approvefrmRad').click(function () {
        $("#approvemodalRad").modal('show');
        getDataApproveRad();
    });
    $('#btn_approvefrmBDRS').click(function () {
        $("#approvemodalBDRS").modal('show');
        getDataApproveBDRS();
    });

    $('#savetrs_payment_closing').click(function () {
            swal({
                title: "Simpan",
                text: "Apakah Anda ingin Simpan ?",
                icon: "info",
                buttons: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                           // ApproveCheckbox(id);
                           goSaveTrsPayment_closing();
                    } 
                });
    });

    $('#savetrs_payment').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan ?",
            icon: "info",
            buttons: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                       // ApproveCheckbox(id);
                       goSaveTrsPayment();
                } 
            });
});
$("#btn_Voucher").click(function () {

    swal("Pilih Pembayaran ?", {
        buttons: {
          cancel: "Cancel",
        
          Pengembalian: {
            text: "Voucher",
            value: "Pengembalian",
          },
         
          defeat: false,
        },
      })
      .then((value) => {
        switch (value) {

            case "Pengembalian":
        swal({
            title: "Are you sure?",
            text: "Apakah anda akan melanjutkan Ke form Voucher Pengembalian ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                var noreg = $("#NoRegistrasi").val();
                showIDbyNoRegVoucher(noreg);
            } else {
                //swal("Your imaginary file is safe!");
            }
        });
        break;
       
        default:
           // swal("Got away safely!");
        }
      });
      
});


    $("#btn_payment").click(function () {

        swal("Pilih Pembayaran ?", {
            buttons: {
                // voucher: {text: "Voucher",value: "Voucher",},
                // deposit: {text: "Deposit",value: "Deposit",},
                // catch: {text: "Payment",value: "catch",},
                // closing: {text: "Closing",value: "Closing",},
                cancel: "Cancel",
                defeat: false,
               voucher: {
                text: "Voucher",
                value: "Voucher",
              },
              deposit: {
                text: "Deposit",
                value: "Deposit",
              },
              catch: {
                text: "Payment",
                value: "catch",
              },
              closing: {
                text: "Closing",
                value: "Closing",
              },
             
              
            },
          })
          .then((value) => {
            switch (value) {

            case "Voucher":
                swal({
                    title: "Are you sure?",
                    text: "Apakah anda akan melanjutkan Voucher Pengembalian pada form Voucher Pengembalian ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        var noreg = $("#NoRegistrasi").val();
                        showIDbyNoRegVoucher(noreg);
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });
                break;

            case "Deposit":
            swal({
                title: "Are you sure?",
                text: "Apakah anda akan melanjutkan Deposit pada form Deposit ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    var noreg = $("#NoRegistrasi").val();
                    showIDbyNoRegx2(noreg);
                } else {
                    //swal("Your imaginary file is safe!");
                }
            });
            break;

            case "Closing":
                // $("#modal_payment_closing").modal('show');
                // goDataBillClosingan();
                swal({
                    title: "Are you sure?",
                    text: "Apakah anda akan melanjutkan Closebill pada form Clossing ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                        var noreg = $("#NoRegistrasi").val();
                        showIDbyNoRegx(noreg);
                    } else {
                      //swal("Your imaginary file is safe!");
                    }
                });
                break;
        
            case "catch":
                    // $("#modal_payment").modal('show');
                    // getDataDetailBilling_Payment();
                    // showIDbyNoReg();
                    swal({
                        title: "Are you sure?",
                        text: "Apakah anda akan melanjutkan payment pada form partial ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                      })
                      .then((willDelete) => {
                        if (willDelete) {
                            var noreg = $("#NoRegistrasi").val();
                            showIDbyNoReg(noreg);
                        } else {
                          //swal("Your imaginary file is safe!");
                        }
                      });

                break;
           
              default:
               // swal("Got away safely!");
            }
          });
          
    });


 

    function showIDbyNoReg(str) {
        // console.log(str);
        // return false;

        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aBillingPasien/billingpayment/' + str;
        // const base_url = window.location.origin;
        // var str = btoa(str);
        // var judul = 'Billing Rawat Jalan';
        // //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
        // window.open(base_url + '/SIKBREC/public/aBillingPasien/billingpayment/' + str , "_blank");
    }
    

    function showIDbyNoRegx(str) {
        // console.log(str);
        // return false;

        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aBillingPasien/billingclose/' + str;
        // const base_url = window.location.origin;
        // var str = btoa(str);
        // var judul = 'Billing Rawat Jalan';
        // //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
        // window.open(base_url + '/SIKBREC/public/aBillingPasien/billingpayment/' + str , "_blank");
    }

    function showIDbyNoRegx2(str) {
        // console.log(str);
        // return false;

        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aBillingPasien/billingdeposit/' + str;
        // const base_url = window.location.origin;
        // var str = btoa(str);
        // var judul = 'Billing Rawat Jalan';
        // //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
        // window.open(base_url + '/SIKBREC/public/aBillingPasien/billingpayment/' + str , "_blank");
    }
    function showIDbyNoRegVoucher(str) {
        // console.log(str);
        // return false;

        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aBillingPasien/BillingVoucher/' + str;
        // const base_url = window.location.origin;
        // var str = btoa(str);
        // var judul = 'Billing Rawat Jalan';
        // //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
        // window.open(base_url + '/SIKBREC/public/aBillingPasien/billingpayment/' + str , "_blank");
    }

    $("#add_row").click(function () { 

        if($("#tipepembayaran").val() == "Piutang Asuransi" || $("#tipepembayaran").val() == "Piutang Perusahaan"){
            if ($('#kodejaminan').val() == '') {
                $("#kodejaminan").trigger('focus');
                toast("Mohon Isi Nama Perusahaan / Asuransi !", 'warning');
                return false;
                }
            }else{
                if($("#billto").val() == ''){
                    $("#billto").trigger('focus');
                    toast("Mohon Isi Telah Terima !", 'warning');
                    return false;
                }
            }

        if($("#totalinput").val() == ''){
            $("#totalinput").focus();
            toast("Mohon Isi Amount !", 'warning');
            return false;
        }

        if($("#tipepembayaran").val() == "Kartu Debit" || $("#tipepembayaran").val() == "Kartu Kredit"){
                if($('#namabank').val() == ''){
                $("#namabank").select2('open');
                toast("Mohon Isi EDC !", 'warning');
                return false;
                } 
                }


    //   if ($('#tipepembayaran').val() == '') {
    //        $('#tipepembayaran').css('border-color', '#cc0000'); tipepembayaran = '';
    //        $('#tipepembayaran').focus();
    //        new PNotify({
    //             title: 'Notifikasi',
    //             text: 'Harap Masukkan Tipe Pembayaran!',
    //             type: 'WARNING'
    //         });
    //        return false;
    //        } else {
    //                  error_tipepembayaran = ''; $('#error_tipepembayaran').text(error_tipepembayaran);
    //                  $('#tipepembayaran').css('border-color', ''); tipepembayaran = $('#tipepembayaran').val();
    //        }
    //   if ($('#totalinput').val() == '') {
    //        $('#totalinput').css('border-color', '#cc0000'); totalinput = '';
    //        $('#totalinput').focus();
    //         new PNotify({
    //             title: 'Notifikasi',
    //             text: 'Harap Masukkan Ammount!',
    //             type: 'WARNING'
    //         });
    //        return false;
    //        } else {
    //                  error_totalinput = ''; $('#error_totalinput').text(error_totalinput);
    //                  $('#totalinput').css('border-color', ''); totalinput = $('#totalinput').val();
    //        }
    //        var tipepembayaran = $("#tipepembayaran").val(); 
    //        if(tipepembayaran == "Piutang Asuransi" || tipepembayaran == "Piutang Perusahaan" ||  tipepembayaran == "Piutang Karyawan" || tipepembayaran== "Piutang Rumah Sakit"){
    //   if ($('#kode_billto').val() == '') {
    //        new PNotify({
    //             title: 'Notifikasi',
    //             text: 'Harap Masukkan Nama Telah Terima!',
    //             type: 'WARNING'
    //       });
    //        exit();
    //        }
    //        if($('#kode_billto').val() != $('#penjamin_modal').val()){
    //         swal({
    //               text: "PERINGATAN! 'Telah Terima Dari' tidak sama dengan registrasi penjamin pasien! Mohon diperiksa kembali!",
    //             });
    //        }
    //       }else if(tipepembayaran == "Kartu Debit" || tipepembayaran == "Kartu Kredit"){
    //       if($('#namabank').val() == ''){
    //         new PNotify({
    //             title: 'Notifikasi',
    //             text: 'EDC Kosong! Harap Masukkan EDC!',
    //             type: 'WARNING'
    //       });
    //        return false;
    //        } 
    //       }

    //       if ($('#tgl_payment').val() == '') {
    //         $('#tgl_payment').css('border-color', '#cc0000'); tgl_payment = '';
    //        $('#tgl_payment').focus();

    //        new PNotify({
    //             title: 'Notifikasi',
    //             text: 'Tanggal Payment Kosong, Harap Masukkan Tanggal Payment!',
    //             type: 'WARNING'
    //   });
    //       return false;
    //        }else {
    //                  $('#tgl_payment').css('border-color', ''); 
    //        }




        // if (error_tipepembayaran != ''  || error_totalinput !='' ) {
        // return false;
        // } else {

            var rtrn = BtnSubmitBayar();
            if (rtrn == false){
                toast('WARNING', 'warning')
                return false
            }

        if($('#totalrow').val()==0){
        var count =0;
        }else{
            var count = parseFloat($('#totalrow').val());
        }
        count = count + 1;
        document.getElementById('grantotalOrder').innerHTML = count;
        $('#totalrow').val(count);

        //    var billto_cek = $('#kode_billto').val();
        //   if (billto_cek==''){
        //     billto = $('#namapasien').val();
        //     kodejaminan = $('#kode_billto').val();
        //   }else{
        //     billto = $('#kode_billto').val();
        //     kodejaminan = $('#kode_billto').val();
        //   }
        
        billto = $('#billto').val();
        kodejaminan = $('#kodejaminan').val();

        tipepembayaran = $('#tipepembayaran').val();
        ammount = $('#totalinput').val();
        edc = $('#namabank').val();
        tipekartu = $('#tipekartu').val();
        nokartu = $('#nokartu').val();
        gesek = $('#gesek').val();
        kd_rekening = $('#kd_rekening').val();

            output = '<tr id="row_' + count + '">';
            output += '<td>' + tipepembayaran + ' <input type="hidden" name="tipepembayaran[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + tipepembayaran + '" /></td>';
            output += '<td>' + billto + ' <input type="hidden" name="billto[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + billto + '" /><input type="hidden" name="kodejaminan[]" id="kodejaminan' + count +'" class="kodejaminan" value="' + kodejaminan + '" /></td>';
            output += '<td>' + ammount + ' <input type="hidden" name="totalinput[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ammount + '" /></td>';
            output += '<td>' + edc + ' <input type="hidden" name="namabank[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + edc + '" /></td>';
            output += '<td>' + tipekartu + ' <input type="hidden" name="tipekartu[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + tipekartu + '" /></td>';
            output += '<td>' + nokartu + ' <input type="hidden" name="nokartu[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + nokartu + '" /></td>';
             output += '<td>' + gesek + ' <input type="hidden" name="gesek[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + gesek + '" /></td>';
             output += '<td>' + kd_rekening + ' <input type="hidden" name="kd_rekening[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + kd_rekening + '" /></td>';
            output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' +
              count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';
            $('#user_data').append(output);
            //$("#tipepembayaran").val('');
            $("#tipepembayaran").val('').trigger('change');
            $("#perusahaanjpk").select2('destroy');
            $("#perusahaanasuransi").select2('destroy');
            $("#perusahaanjpk").val('');
            $("#perusahaanasuransi").val('');
            $("#perusahaanjpk").select2();
            $("#perusahaanasuransi").select2();

            $("#billto").val("");
            $("#kode_billto").val("");
            $("#totalinput").val('');
            $("#namabank").val('');
            $("#tipekartu").val('');
            $("#nokartu").val('');
            $("#gesek").val('');
            $('#kd_rekening').val('');
            $('#tipepembayaran').focus(); 
            
        //}
    });

  $(document).on('click', '.remove_details', function () {
    var row_id = $(this).attr("id");
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $('#row_' + row_id + '').remove();
            var count = $('#totalrow').val();
            //console.log(count);
            count = count - 1 ;
            document.getElementById('grantotalOrder').innerHTML = count;
            $('#totalrow').val(count);
            toast('Berhasil Hapus !', "success")
        } else {
          //swal("Your imaginary file is safe!");
        }
      });

    });


    $("#add_row_closing").click(function () { 

        if($("#tipepembayaran_closing").val() == ''){
            $("#tipepembayaran_closing").select2('open');
            toast("Mohon Isi Tipe Pembayaran !", 'warning');
            return false;
        }

        if($("#tipepembayaran_closing").val() == "Piutang Asuransi" || $("#tipepembayaran").val() == "Piutang Perusahaan"){
            if ($('#kodejaminan_closing').val() == '') {
              $("#kodejaminan_closing").trigger('focus');
              toast("Mohon Isi Nama Perusahaan / Asuransi !", 'warning');
              return false;
              }
          }else{
              if($("#billto_closing").val() == ''){
                  $("#billto_closing").trigger('focus');
                  toast("Mohon Isi Telah Terima !", 'warning');
                  return false;
              }
          }

        if($("#totalinput_closing").val() == ''){
            $("#totalinput_closing").focus();
            toast("Mohon Isi Amount !", 'warning');
            return false;
        }

        if($("#tipepembayaran_closing").val() == "Kartu Debit" || $("#tipepembayaran_closing").val() == "Kartu Kredit"){
                  if($('#namabank_closing').val() == ''){
                    $("#namabank_closing").select2('open');
                    toast("Mohon Isi EDC !", 'warning');
                   return false;
                   } 
                  }

          if($('#totalrow_closing').val()==0){
            var count =0;
          }else{
            var count = parseFloat($('#totalrow_closing').val());
          }
          count = count + 1;
          document.getElementById('grantotalOrder_closing').innerHTML = count;
          $('#totalrow_closing').val(count);

         billto = $('#billto_closing').val();
         kodejaminan = $('#kodejaminan_closing').val();

          tipepembayaran = $('#tipepembayaran_closing').val();
          ammount = $('#totalinput_closing').val();
          edc = $('#namabank_closing').val();
          tipekartu = $('#tipekartu_closing').val();
          nokartu = $('#nokartu_closing').val();
          gesek = $('#gesek_closing').val();
          kd_rekening = $('#kd_rekening_closing').val();

            output = '<tr id="row_closing_' + count + '">';
            output += '<td>' + tipepembayaran + ' <input type="hidden" name="tipepembayaran_closing[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + tipepembayaran + '" /></td>';
            output += '<td>' + billto + ' <input type="hidden" name="billto_closing[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + billto + '" /><input type="hidden" name="kodejaminan_closing[]" id="kodejaminan_closing' + count +'" class="kodejaminan" value="' + kodejaminan + '" /></td>';
            output += '<td>' + ammount + ' <input type="hidden" name="totalinput_closing[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ammount + '" /></td>';
            output += '<td>' + edc + ' <input type="hidden" name="namabank_closing[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + edc + '" /></td>';
            output += '<td>' + tipekartu + ' <input type="hidden" name="tipekartu_closing[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + tipekartu + '" /></td>';
            output += '<td>' + nokartu + ' <input type="hidden" name="nokartu_closing[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + nokartu + '" /></td>';
             output += '<td>' + gesek + ' <input type="hidden" name="gesek_closing[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + gesek + '" /></td>';
             output += '<td>' + kd_rekening + ' <input type="hidden" name="kd_rekening_closing[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + kd_rekening + '" /></td>';
            output += '<td><button type="button" title="Hapus" name="remove_details_closing" class="btn btn-danger btn-sm remove_details_closing" id="' +
              count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';
            $('#user_data_closing').append(output);
            //$("#tipepembayaran").val('');
            $("#tipepembayaran_closing").val('').trigger('change');
            $("#perusahaanjpk_closing").select2('destroy');
            $("#perusahaanasuransi_closing").select2('destroy');
            $("#perusahaanjpk_closing").val('');
            $("#perusahaanasuransi_closing").val('');
            $("#perusahaanjpk_closing").select2();
            $("#perusahaanasuransi_closing").select2();

            $("#billto_closing").val("");
            $("#kode_billto_closing").val("");
            $("#totalinput_closing").val('');
            $("#namabank_closing").val('');
            $("#tipekartu_closing").val('');
            $("#nokartu_closing").val('');
            $("#gesek_closing").val('');
            $('#kd_rekening_closing').val('');
            $('#tipepembayaran_closing').focus(); 
            
    });

  $(document).on('click', '.remove_details_closing', function () {
    var row_id = $(this).attr("id");
    console.log(row_id);
    swal({
        title: "Are you sure?",
        text: "Apakah anda yakin Ingin hapus data ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $('#row_closing_' + row_id + '').remove();
            $('#row_closing_')
            var count = $('#totalrow_closing').val();
            //console.log(count);
            count = count - 1 ;
            document.getElementById('grantotalOrder_closing').innerHTML = count;
            $('#totalrow_closing').val(count);
            toast('Berhasil Hapus !', "success")
        } else {
          //swal("Your imaginary file is safe!");
        }
      });

    });

   $('#examplex').DataTable( {
  "order": [[ 0, "desc" ]]
} );

    $('#tbl_rincianbiaya').DataTable( {
        "order": [[ 0, "asc" ]]
    } );

    $('#tbl_rincianbiaya_payment').DataTable( {
        "order": [[ 0, "asc" ]]
    } );

    $('#tbl_riwayatpayment').DataTable( {
        "order": [[ 0, "asc" ]]
    } );

    $('#tbl_rincianhutang').DataTable( {
        "order": [[ 0, "asc" ]]
    } );
    

    $('#btn_tambah_tindakan').click(function () {
        $("#addtindakan_modal").modal('show');
        getDokter();
        getTindakan();
    });

    $('#btn_print_rincian_modal').click(function () {
        $("#print_rincian_modal").modal('show');
    });

    //Auto Generate Total Tarif
    $('#qty_addvisit').on('input',function() {
        $("#diskon_addvisit").val('');
        var tarif_satuan = parseInt($('#tarif_satuan_addvisit').val());
        var qty = parseInt($('#qty_addvisit').val());
        var total_tarif_addvisit = qty*tarif_satuan;
        $('#total_tarif_addvisit_temp').val((total_tarif_addvisit ? total_tarif_addvisit : 0).toFixed(0));
      });

      //Auto Generate diskon Add Visit
      $('#diskon_addvisit').on('input',function() {
        var total_tarif_addvisit1 = parseInt($('#total_tarif_addvisit_temp').val());
        var diskon = parseFloat($('#diskon_addvisit').val());
        var hasil_diskon = total_tarif_addvisit1*(diskon/100);
        var subtotal = total_tarif_addvisit1-hasil_diskon;
        $('#total_tarif_addvisit').val((subtotal ? subtotal : 0).toFixed(0));
      });

    //   $('#btncetakDigital').click(function () {
    //     goCountCetak();
    // });

    $('#btn_rincian_biaya').click(function () {
        var base_url = window.location.origin;
        var notrs = $("#NoRegistrasi").val();
        var lang = 'ID';
        var kodereg = $("#NoRegistrasi").val().slice(0,2);
        var idunit = $("#IDUnit").val();
        var tglawal = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();
        window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRincian"+kodereg+"/"+lang +"/"+notrs+"/"+tglawal+"/"+tglakhir, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    $('#btn_rekap_kuintansi').click(function () {
            goCountCetak();
    });
    $('#btn_open_bill').click(function () {
        // var noregistrasi = $("#NoRegistrasi").val();
        goOpenBill();
});


    $('#btnSaveSend').click(function () {
        swal({
            title: "Kirim E-mail",
            text: "Apakah Anda yakin ingin simpan & kirim ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    
                    var email = $("#pemail_pasien").val();
                    if (!validateEmail(email)) {
                        swal({
                            title: "Email Tidak Sesuai Format",
                            text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
                            icon: "warning",
                        })
                        $("#pemail_pasien").focus();
                        $(".preloader").fadeOut();
                        return false;
                       }
    
                                var notrs = $("#pkuitansi_notrs").val();
                            var kodereg = $("#NoRegistrasi").val().slice(0,2);
                            // if (kodereg != 'RJ' || kodereg != 'RI'){
                            //     kodereg = 'PB';
                            // }
                            var lang = $("#pkuitansi_lang").val();
                            var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
                            if (jeniscetakan == 'KUITANSIREKAP'){
                                var url = 'SaveKuitansiRekap';
                            }else if(jeniscetakan == 'KUITANSI'){
                                var url = 'SaveKuitansi';
                            }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
                                var url = 'SaveRincianPB';
                            }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
                                var url = 'SaveRincianRJ';
                            }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
                                var url = 'SaveRincianRI';
                            }
                            gouploadtoAws(notrs,kodereg,lang,jeniscetakan,url,email);
                } 
            });
    });

    
    $('#btnSendEmailx').click(function () {
        swal({
            title: "Kirim E-mail",
            text: "Apakah Anda ingin Kirim E-mail ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    if ($("#pkuitansi_jeniscetakan").val() == 'KUITANSIREKAP'){
                        var url = 'SendMailKuitansiRekap';
                        var judul = 'Kuitansi Rekap';
                    }else if($("#pkuitansi_jeniscetakan").val() == 'KUITANSI'){
                        var url = 'SendMailKuitansi';
                        var judul = 'Kuitansi';
                    }else{
                        var url = 'SendMailRincian';
                        var judul = 'Rincian Biaya';
                    }
                    SendEmail(judul);
                } 
            });
});

async function gouploadtoAws(notrs,kodereg,lang,jeniscetakan,url,email) {
    try {
        $(".preloader").fadeIn();
        const awsurl = await uploadtoAws_filepdfx(notrs,kodereg,lang,jeniscetakan,url);
        if ($("#pkuitansi_jeniscetakan").val() == 'KUITANSIREKAP'){
            var url = 'SendMailKuitansiRekap';
            var judul = 'Kuitansi Rekap';
        }else if($("#pkuitansi_jeniscetakan").val() == 'KUITANSI'){
            var url = 'SendMailKuitansi';
            var judul = 'Kuitansi';
        }else{
            var url = 'SendMailRincian';
            var judul = 'Rincian Biaya';
        }
        await SendEmail(judul,email,awsurl);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

async function uploadtoAws_filepdfx(notrs,kodereg,lang,jeniscetakan,urlx){
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/'+urlx;
    return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body:   'notrs='+notrs+
            '&jeniscetakan='+jeniscetakan+
            '&kodereg='+kodereg+
            '&lang='+lang+
            '&periode_awal='+$("#tglawal").val()+
            '&periode_akhir='+$("#tglakhir").val()+
            '&lang='+lang
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

    //  $('#tbl_approvefarmasi').DataTable( {
    //      "order": [[ 0, "asc" ]]
    //  } );
});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        const datagetPaymentType = await getPaymentType();
        updateUIgetPaymentType(datagetPaymentType);

        if ($("#pkuitansi_notrs").val() != ''){
            // const data = await CekPernahGenerate();
            // updateUICekPernahGenerate(data);
            $("#notif_ShowTTD_Digital").modal('show');
            //$("#notif_ShowTTD_Digital").modal('show');
           
        }
        // if ($("#pkuitansi_notrs").val() != ''){
        //     //$("#notif_ShowTTD_Digital").modal('show');
        //     swal({
        //         title: "Generate",
        //         text: "Apakah anda yakin Ingin generate terlebih dahulu ?",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //       })
        //       .then((willDelete) => {
        //         if (willDelete) {
        //             var notrs = $("#pkuitansi_notrs").val();
        //             var kodereg = $("#NoRegistrasi").val().slice(0,2);
        //             // if (kodereg != 'RJ' || kodereg != 'RI'){
        //             //     kodereg = 'PB';
        //             // }
        //             var lang = $("#pkuitansi_lang").val();
        //             var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
        //             if (jeniscetakan == 'KUITANSIREKAP'){
        //                 var url = 'SaveKuitansiRekap';
        //             }else if(jeniscetakan == 'KUITANSI'){
        //                 var url = 'SaveKuitansi';
        //             }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
        //                 var url = 'SaveRincianPB';
        //             }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
        //                 var url = 'SaveRincianRJ';
        //             }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
        //                 var url = 'SaveRincianRI';
        //             }
        //             uploadtoAws(notrs,kodereg,lang,jeniscetakan,url);
        //         } else {
        //           //swal("Your imaginary file is safe!");
        //         }
        //       });
        // }


        /*
        if ($("#IdAuto").val() != ''){ // if edit
            const datagetDatabyID = await getDatabyID();
            updateUIdatagetDatabyID(datagetDatabyID);
        }else{
            document.getElementById("labeledit").style.display = 'none';
            $("#TglMasuk").val(getDateNow);
            $("#JamMasuk").val(getTimeNow);
            $("#TglMasuk").attr('readonly', false);
            $("#JamMasuk").attr('readonly', false);
            $(".preloader").fadeOut(); 
        }
        */
        getTotalPembayaranx();
        // getTotalPembayaran();
        

    
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
    // console.log('tai');
         //await getRoomID(dataresponse.data.IDKelas);
         //await getBedID(dataresponse.data.RoomName);
        $("#NamaPasien").val(convertEntities(dataresponse.data.PatientName));
        $("#NoMR").val(convertEntities(dataresponse.data.NoMR));
        $("#NoEpisode").val(convertEntities(dataresponse.data.NoEpisode));
        $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
        $("#TanggalLahir").val(convertEntities(dataresponse.data.DOB+' ('+dataresponse.data.age+')'));
        $("#Penjamin").val(convertEntities(dataresponse.data.nama_penjamin));
        $("#GroupJaminan").val(convertEntities(dataresponse.data.GroupJaminan));
        $("#xgrupjaminan").val(convertEntities(dataresponse.data.GroupJaminan));
        
        $("#AlihStatusDari").val(convertEntities(dataresponse.data.NoRegisRWJ));
        $("#Dokter").val(convertEntities(dataresponse.data.NamaDokter));
        $("#IDUnit").val(convertEntities(dataresponse.data.Unit));
        $("#Unit").val(convertEntities(dataresponse.data.NamaUnit));
        $("#Kelas").val(convertEntities(dataresponse.data.NamaKelas));
        $("#IDKelas").val(convertEntities(dataresponse.data.IDKelas));
        $("#TglMasuk").val(convertEntities(dataresponse.data.TglMasuk));
        $("#TglKeluar").val(convertEntities(dataresponse.data.TglKeluar));
        $("#HakKelas").val(convertEntities(dataresponse.data.HakKelas));
        $("#Diagnosa").val(convertEntities(dataresponse.data.Diagnosa));
        $("#penjamin_kode").val(convertEntities(dataresponse.data.penjamin_kode));
        $("#Keterangan_Ext").val(convertEntities(dataresponse.data.TelemedicineIs+' / '+dataresponse.data.JenisPasien));
        $("#judul").html(dataresponse.data.judul);
        $("#TypePatientID").val(convertEntities(dataresponse.data.TypePatientID));

        $("#tglpayment").val(convertEntities(dataresponse.data.TglMasuk));
        $("#tglpayment_closing").val(convertEntities(dataresponse.data.TglMasuk));


        $("#pemail_pasien").val(convertEntities(dataresponse.data.emailpasien));
        $("#pnohp_pasien").val(convertEntities(dataresponse.data.nohp));


        // 20/08/2024
        if (dataresponse.data.StatusReg == "Close") {
            console.log('Masuk sini');
            $('#btn_openorclose_bill').html('Open Bill');
            $("#Ket_btn_closeoropenbill").val(convertEntities(dataresponse.data.StatusReg));
        } else {
            console.log('Masuk sana');
            $('#btn_openorclose_bill').html('Close Bill');
            $("#Ket_btn_closeoropenbill").val(convertEntities(dataresponse.data.StatusReg));
        }
        // 20/08/2024

        //border
        if (dataresponse.data.judul == 'Rawat Inap'){
            $('#border').addClass('border-ranap');
        }else if (dataresponse.data.judul == 'Rawat Jalan'){
            $('#border').addClass('border-rajal');
        }else if (dataresponse.data.judul == 'Walkin'){
            $('#border').addClass('border-walkin');
        }else if (dataresponse.data.judul == 'Penjualan Bebas'){
            $('#border').addClass('border-bebas');
        }
        
        $('#statusreg').html(dataresponse.data.StatusReg);
        if (dataresponse.data.statusid == '0'){
            var badge = 'success';
        }else if(dataresponse.data.statusid == '1'){
            var badge = 'info';
        }else if(dataresponse.data.statusid == '2'){
            var badge = 'warning';
        }else if(dataresponse.data.statusid == '3'){
            var badge = 'danger';
        }else if(dataresponse.data.statusid == '4'){
            var badge = 'secondary';
        }else{
            var badge = 'default';
        }

        //Badge for Status if Penjualan Bebas
        if (dataresponse.data.NamaUnit == 'Penjualan Bebas'){
            if (dataresponse.data.statusid == '0'){
                var badge = 'success';
            }else if(dataresponse.data.statusid == '1'){
                var badge = 'warning';
            }else if(dataresponse.data.statusid == '2'){
                var badge = 'danger';
            }else if(dataresponse.data.statusid == '3'){
                var badge = 'secondary';
            }else if(dataresponse.data.statusid == '4'){
                var badge = 'secondary';
            }else{
                var badge = 'default';
            }
        }
        
        $('#statusreg').addClass('badge badge-'+badge);

        $("#tglawal").val(convertEntities(dataresponse.data.awal_periode));

                  var today = new Date();
                  var dd = String(today.getDate()).padStart(2, '0');
                  var mm = String(today.getMonth() + 1).padStart(2, '0');
                  var yyyy = today.getFullYear();

                  var datenow = yyyy +"-"+ mm +"-"+ dd;
                  $("#tglakhir").val(datenow);

        $(".preloader").fadeOut(); 

//new badrul UPDATE
        getDataDetailBilling();
        getDataDetailRincianHutang();
        getDataRekapBiaya();
        getDataRiwayatPayment();
        getPerusahaan();
        getAsuransi();
        getDataHutangKabur();
        getCekHutang();



}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#NoRegistrasi").val() 
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

async function getClassID(classid) {
    try{
        const datagetClass = await getClass(classid);
        updateUIdatagetClass(datagetClass);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getClass() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
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
            $("#cb_editkelas").select2();
            $("#kelasedit").select2();
        })
}

function updateUIdatagetClass(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#cb_editkelas").append(newRow);
        $("#kelasedit").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
            $("#cb_editkelas").append(newRow);
            $("#kelasedit").append(newRow);
        }
    }
}

async function getTindakan(){
    try{
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetTindakanRajal =  await getTindakanRajal();
            updateUIgetDataTindakan(datagetTindakanRajal); 
        }else if (getreg == 'RI'){
            var datagetTindakanRanap =  await getTindakanRanap();
            updateUIgetDataTindakan(datagetTindakanRanap); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataTindakan(datagetTindakan) {
    let responseApi = datagetTindakan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        $("#namatindakan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#namatindakan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].ProductName + '</option';
            $("#namatindakan").append(newRow);
        }
    }
}

function getTindakanRajal() {
    var base_url = window.location.origin;
    var xdi = $('#IDUnit').val();
    var groupjaminan = $('#GroupJaminan').val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTindakanRajal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idunit=' + xdi + '&groupjaminan=' + groupjaminan
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
            $("#namatindakan").select2();
        })
}

function getTindakanRanap() {
    var base_url = window.location.origin;
    var groupjaminan = $('#GroupJaminan').val();
    var IDKelas = $('#IDKelas').val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTindakanRanap';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'groupjaminan=' + groupjaminan + '&IDKelas=' + IDKelas
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
            $("#namatindakan").select2();
        })
}
//---
async function getTarifTindakan(param){
    try{
        var val = $(param).val();
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetTarifTindakanRajal =  await getTarifTindakanRajal(val);
            updateUIgetDataTarifTindakan(datagetTarifTindakanRajal); 
        }else if (getreg == 'RI'){
            var datagetTarifTindakanRanap =  await getTarifTindakanRanap(val);
            updateUIgetDataTarifTindakan(datagetTarifTindakanRanap); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataTarifTindakan(datagetTindakan) {
    let responseApi = datagetTindakan;
    // console.log(datagetTindakan);
    if (responseApi.data !== null && responseApi.data !== undefined) {
       // console.log(responseApi.data);
        $("#tarif_satuan_addvisit").val(convertEntities(responseApi.data.GetTarif));
        $("#tindakan").val(convertEntities(responseApi.data.ProductName));

        $("#qty_addvisit").val('');
        
    }
}

function getTarifTindakanRajal(val) {
    var base_url = window.location.origin;
    var IDUnit = $('#IDUnit').val();;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTarifTindakanRajal';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + val
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
            $("#namatindakan").select2();
        })
}

function getTarifTindakanRanap(val) {
    var base_url = window.location.origin;
    var IDKelas = $('#IDKelas').val();;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTarifTindakanRanap';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDKelas=' + IDKelas + '&id=' + val
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
            $("#namatindakan").select2();
        })
}
//--------
async function getDokter(){
    try{
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetDataDokter =  await getDataDokterByJadwal();
            updateUIgetDataDokter(datagetDataDokter); 
        }else if (getreg == 'RI'){
            var datagetDataDokter =  await getDokterAllAktif();
            updateUIgetDataDokter(datagetDataDokter);
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataDokter(datagetDataDokter) {
    let responseApi = datagetDataDokter;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#dokterpemeriksa").append(newRow);
        $("#dokterpemeriksa_edit").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].First_Name + '</option';
            $("#dokterpemeriksa").append(newRow);
            $("#dokterpemeriksa_edit").append(newRow);
        }
    }
}


function getDataDokterByJadwal() {
    var base_url = window.location.origin;
    var tglnow = $('#TglMasuk').val();
    const days = getWeekdays(tglnow);
    var xdi = $('#IDUnit').val();
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
            $("#dokterpemeriksa").select2();
            $("#dokterpemeriksa_edit").select2();
        })
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
            $("#dokterpemeriksa").select2();
        })
    }

    async function getDataDetailBill(id) {
        try{
            const DataDetailBillbyID = await getDataDetailBillbyID(id);
            updateUIDataDetailBillbyID(DataDetailBillbyID);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function getDataDetailBillbyID(id) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aBillingPasien/getDataDetailBillbyID';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'ID_BILL=' + id 
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
    
    function updateUIDataDetailBillbyID(DataDetailBillbyID) {
        let dataresponse = DataDetailBillbyID;
        // console.log(DataDetailBillbyID);
        // return exit;
            //  $("#Idbilling").val(convertEntities(dataresponse.data.NO_TRS_BILLING));

            $("#Idbilling").attr('disabled', false);
            $("#namatindakannew").attr('disabled', false);
            $("#dokterpemeriksanew").attr('disabled', false);
            $("#qty_addvisitnew").attr('disabled', false);
            $("#btnaddtindakanx").attr('disabled', false);
            $("#btnSaveAll").attr('disabled', false);
            $("#tbtnhdradd").attr('disabled', true);
            searchTindakan();
            searchDokter();
            // $("#id_details").val(convertEntities(dataresponse.data.ID));
            // $("#tarif").val(convertEntities(dataresponse.data.NILAI_TARIF));
            // $("#nama").val(convertEntities(dataresponse.data.NAMA_TARIF));
            // $("#total_tarif").val(convertEntities(dataresponse.data.GRANDTOTAL));
            // $("#dokterpemeriksa_edit").val(convertEntities(dataresponse.data.KD_DR)).trigger('change');
            // $("#kelasedit").val(convertEntities(dataresponse.data.KD_KELAS)).trigger('change');
            // $("#tgledit").val(convertEntities(dataresponse.data.TGL_BILLING));
            // $("#qtyedit").val(convertEntities(dataresponse.data.QTY));
        }
    

    // async function getDataDetailBillfo2(id) {
    //     try{
    //         const DataDetailBillbyIDfo2 = await getDataDetailBillbyIDfo2(id);
    //         updateUIDataDetailBillbyIDfo2(DataDetailBillbyIDfo2);
    //     } catch (err) {
    //         toast(err.message, "error")
    //     }
    // }
    
    // function getDataDetailBillbyIDfo2(id) {
    //     var base_url = window.location.origin;
    //     let url = base_url + '/SIKBREC/public/aBillingPasien/getDataDetailBillbyID';
    //     return fetch(url, {
    //         method: 'POST',
    //         headers: {
    //             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    //         },
    //         body: 'ID_BILL=' + id 
    //     })
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error(response.statusText)
    //             }
    //             return response.json();
    //         })
    //         .then(response => {
    //             if (response.status === "error") {
    //                 throw new Error(response.message.errorInfo[2]);
    //                 // console.log("ok " + response.message.errorInfo[2])
    //             } else if (response.status === "warning") {
    //                 throw new Error(response.errorname);
    //                 // console.log("ok " + response.message.errorInfo[2])
    //             }
    //             return response
    //         })
    //         .finally(() => {
    //         })
    // }
    
    // function updateUIDataDetailBillbyIDfo2(DataDetailBillbyID) {
    //     let dataresponse = DataDetailBillbyID;
    //     if (dataresponse !== null && dataresponse !== undefined) {
    //         $("#id_details").val(convertEntities(dataresponse.data.ID));
    //         $("#tarif").val(convertEntities(dataresponse.data.NILAI_TARIF));
    //         $("#nama").val(convertEntities(dataresponse.data.NAMA_TARIF));
    //         $("#total_tarif").val(convertEntities(dataresponse.data.GRANDTOTAL));
    //         $("#dokterpemeriksa_edit").val(convertEntities(dataresponse.data.KD_DR)).trigger('change');
    //         $("#kelasedit").val(convertEntities(dataresponse.data.KD_KELAS)).trigger('change');
    //         $("#tgledit").val(convertEntities(dataresponse.data.TGL_BILLING));
    //         $("#qtyedit").val(convertEntities(dataresponse.data.QTY));
    //     }
    // }

function getDataDetailBilling() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    var getreg = noreg.substring(0,2);

        $('#tbl_rincianbiaya').DataTable().clear().destroy();
        $('#tbl_rincianbiaya').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailBilling", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.tglawal = tglawal
                d.tglakhir = tglakhir
                d.getreg = getreg
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "NO_TRS_BILLING" },
            { "data": "ID" },
            { "data": "TGL_BILLING" }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                html = `${row.NAMA_TARIF} <br>  ${row.NM_DR}`;
                 return html 
              }
            },
            { "data": "NamaUnit" },
            { "data": "KD_KELAS" }, 
            { "data": "QTY" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "NILAI_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "DISC_RP" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "GRANDTOTAL" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KLAIM" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KEKURANGAN" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )}, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                    //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                       var html  = '<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>'
                          return html 
                   }
            },
           ],
         "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

                totadisc = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                 total3 = api
                 .column( 9 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalklaim = api
                 .column( 10 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalkekurangan = api
                 .column( 11 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                 
                 totalbayar = api
                 .column( 12 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                
 
             // Update footer
                $( api.column( 8 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totadisc )
                );
                $( api.column( 9 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );
                $( api.column( 10 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalklaim )
                );
                $( api.column( 11 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalkekurangan )
                );
                $( api.column( 12 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalbayar )
                );
             $("#tblRincian_TotalBill").val(total3);
             $("#T_Tagihan").val(number_to_price(total3));
             
             $("#tblRincian_klaim").val(number_to_price(totalklaim)); 
             $("#T_Klaim").val(number_to_price(totalklaim));
             $("#T_Kekurangan").val(number_to_price(totalkekurangan)); 
             $("#tblRincian_bayar").val(number_to_price(totalbayar));
             $("#T_Bayar").val(number_to_price(totalbayar));
             $("#T_SisaBayar").val(number_to_price(total3-totalbayar));
             $("#T_DiskonGlobal").val(number_to_price(totadisc));
             $("#T_GrandTotal").val(number_to_price(total3));


            //  $("#grandTotalBillPerawatan").val(number_to_price(total3));
            //  $("#grandTotalBillPerawatan").text(number_to_price(total3));
             $("#grandTotalBillPerawataninput").val(total3);

            //  $("#grandTotalBillPerawatanklaim").text(number_to_price(totalklaim));
             $("#grandTotalBillPerawataninputklaim").val(totalklaim);

            //  $("#grandTotalBillPerawatanbayar").text(number_to_price(totalbayar));
             $("#grandTotalBillPerawataninputbayar").val(totalbayar);

            //  $("#tax").val('0');
            //  $("#tax2").val('0');
         },
       });
       
} 


function BtnEditDtlBill_tgl(thisid){
    var table = $('#tbl_rincianbiaya').DataTable();
    var form = $("#form_cbeditbill_tgl");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl_tgl\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl_tgl[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    $("#modal_cbedittanggal").modal('show');

}

function BtnEditDtlBill_kls(thisid){
    getClassID();
    var table = $('#tbl_rincianbiaya').DataTable();
    var form = $("#form_cbeditbill_kls");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl_kls\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl_kls[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    $("#modal_cbeditkelas").modal('show');

}

function BtnEditDtlBill_qty(thisid){
    var table = $('#tbl_rincianbiaya').DataTable();
    var form = $("#form_cbeditbill_qty");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl_qty\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl_qty[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    $("#modal_cbeditqty").modal('show');

}

function BtnEditDtlBill_hrg(thisid){
    var table = $('#tbl_rincianbiaya').DataTable();
    var form = $("#form_cbeditbill_hrg");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl_hrg\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

    $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl_hrg[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    $("#modal_cbeditharga").modal('show');

}

function BtnEditDtlBill_disc(thisid){
    var table = $('#tbl_rincianbiaya').DataTable();
    var form = $("#form_cbeditbill_disc");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl_disc\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl_disc[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item','warning');
        return false;
    }

    $("#modal_cbeditdiskon").modal('show');

}

// function ShowDataTarif(ID_BILL){
//     // $("#modaltindakanbyorderOperasi").modal('show');
//     getDataDetailBill(ID_BILL);
// }

async function ShowDataTarif(ID) {
    try{
        const goTindakanbyFO1 = await showTindakanbyFO1(ID);
        updateUIshowTindakanbyFO1(goTindakanbyFO1);
    } catch (err) {
        toast(err.message, "error")
    }
}

function showTindakanbyFO1(ID) {
    var IDFO1 = ID;
    var base_url = window.location.origin;
    // console.log(IDFO1);
    // return false;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ShowTindakanbyFO1';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDFO1=' + IDFO1
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

function updateUIshowTindakanbyFO1(goTindakanbyFO1) {
    let dataresponse = goTindakanbyFO1;

        $("#Idbilling").val(convertEntities(dataresponse.data.NO_TRS_BILLING));
        $("#dateabilling").val(convertEntities(dataresponse.data.TGL_BILLING));
        $("#timeabilling").val(convertEntities(dataresponse.data.TIME_BILLING));
        
        $("#modaltindakanbyorderOperasi").modal('show');
        
        $("#tbtnhdradd").attr('disabled', true);
        $("#dateabilling").attr('disabled', true);
        $("#timeabilling").attr('disabled', true);
        $("#namatindakannew").attr('disabled', false);
        $("#dokterpemeriksanew").attr('disabled', false);
        $("#qty_addvisitnew").attr('disabled', false);
        $("#btnaddtindakanx").attr('disabled', false);
        $("#btnSaveAll").attr('disabled', false);

        var xNoreg = $('#NoRegistrasi').val(); 
        var xNoepisode = $('#NoEpisode').val();
        var xNoMR = $('#NoMR').val();
        var xNamaPasien = $('#NamaPasien').val();
        var xNamaJaminan = $('#Penjamin').val();
    
        console.log(xNoMR);
        $('#bilNOreg').val(xNoreg);
        $('#bilNoEpisode').val(xNoepisode);
        $('#bilNoMr').val(xNoMR);
        $('#bilNamaPasien').val(xNamaPasien);
        $('#bilNamaJaminan').val(xNamaJaminan);


        // searchTindakan();
        // searchDokter();

        // ("#namatindakannew").attr('disabled', false);
        // $("#dokterpemeriksanew").attr('disabled', false);

        showdatafobill()
        searchTindakan();
        searchDokter();
    
}






function BatalDetailBill(ID){
    swal("Alasan Batal:", {
        content: "input",
        buttons:true,
      })
      .then((value) => {
          if (value == '' ){
            swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
            return false;
          }else if (value == null){
            return false;
          }
       goBatalDetailBill(ID,value);
      });
}

async function goBatalDetailBill(ID,value) {
    try{
        const goBatalDetailBillbyID = await getgoBatalDetailBillbyID(ID,value);
        updateUIBatalDetailBillbyIDD(goBatalDetailBillbyID);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getgoBatalDetailBillbyID(ID,value) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/goBatalDetailBillbyID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'ID=' + ID + '&alasan=' + value
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

function updateUIBatalDetailBillbyIDD(goBatalDetailBillbyID) {
    let dataresponse = goBatalDetailBillbyID;
    if (dataresponse !== null && dataresponse !== undefined) {
        toast(dataresponse.message,'success');
        getDataDetailBilling();
    }
}

function getDataRekapBiaya() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_rekapbiaya').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#tbl_rekapbiaya').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataRekapBiaya", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "Keterangan" },
            // { "data": "Jumlah" },
            { "data": "Jumlah" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
           ],
           "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
              
                totalbayar = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
               $( api.column( 2 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display( totalbayar )
               ); 
               
        },

       });
} 
// 22/08/2024
function getDataRiwayatPayment(){ 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_riwayatpayment').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#tbl_riwayatpayment').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataRiwayatPayment", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NO_TRS" },
            { "data": "NO_KWITANSI" },
            { "data": "TGL_TRS" },
            { "data": "TIPE_PEMBAYARAN" },
            { "data": "NOMINAL_BAYAR" },
            { "data": "USER_KASIR" },
            { "data": "BILLTO" },
            { "data": "NamaTest" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
               //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                //   var html  = '<button type="button" onclick="printkuitansi('+row.NO_TRS+')" class="btn btn-warning border-warning btn-xs"><i class="glyphicon glyphicon-print"></i></button>'
               var html  =
                `<button type="button" onclick="printkuitansidetail('${row.NO_TRS}')" class="btn btn-warning border-warning btn-xs" style="min-width: 50px;"><i class="glyphicon glyphicon-print"> Kuitansi </i></button> 
                <button type="button" onclick="printrinciandetail('${row.NO_TRS}')" class="btn btn-warning border-warning btn-xs" style="min-width: 50px;"><i class="glyphicon glyphicon-print">  Nota  </i></button>
                <button type="button" onclick="btnbatalriwayatpembayaran('${row.NO_TRS}')" class="btn btn-danger border-danger btn-xs" style="min-width: 75px; margin-top: 2px;"><i class="glyphicon glyphicon-trash">  Batal  </i></button>`
                // `<button type="button" onclick="goCetakKuitansiBynoKuitansi('${row.NO_KWITANSI }','${row.TIPE_PEMBAYARAN }','${row.NOMINAL_BAYAR }','${row.USER_KASIR }','${row.BILLTO}','${row.NO_TRS}','${row.NamaTest}')" class="btn btn-warning border-warning btn-xs"><i class="glyphicon glyphicon-print"></i></button> <button type="button" onclick="goCountCetak('${row.No }')" class="btn btn-warning border-warning btn-xs"><i class="glyphicon glyphicon-print"></i></button>`
                     return html 
              }
       },

           ],
           "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
              
                totalbayar = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
               $( api.column( 2 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display( total3 )
               ); 
           //  $("#subtotal").val(total3);
           //  $("#subtotal2").val(number_to_price(total3));
           //  $("#grandtotal").val(total3);
           //  $("#grandtotal2").val(number_to_price(total3));
           //  $("#tax").val('0');
           //  $("#tax2").val('0');
        },

       });
}
// 22/08/2024
function goCetakKuitansiBynoKuitansi(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest){

    // console.log(NO_KWITANSI);
    // console.log(TIPE_PEMBAYARAN);
    // console.log(NOMINAL_BAYAR);
    // console.log(USER_KASIR);
    // console.log(BILLTO);
    // console.log(NO_TRS);
    // console.log(NamaTest);
    // return false;
    var base_url = window.location.origin;
    var jeniscetak = 'PrintKuitansi2';
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + NO_KWITANSI +"/"+TIPE_PEMBAYARAN+"/"+NOMINAL_BAYAR+"/"+USER_KASIR+"/"+BILLTO+"/"+NO_TRS+"/"+NamaTest,"_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    //MyBack();
    // $("#notif_ShowTTD_Digital").modal('hide');
    // toast(params.message, 'success');

}

async function goCetakKuitansiBynoKuitansix(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest) {

    try {
        const datagoCetakKuitansi = await goCetakKuitansi(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest);
        updateUIdatagoCetakKuitansi(datagoCetakKuitansi);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagoCetakKuitansi(params) {
    let response = params;
    // if (response.status == "success") {
    //     swal({
    //         title: "Simpan Berhasil!",
    //         text: response.message,
    //         icon: "success",
    //     })
    //     getDataApproveBDRS();
    //      var ID = $("#bdrsidxx").val();
    //     approvemodalBDRSdetail(ID);
    // }else{
    //     toast(response.message, "error")
    // }
}

function goCetakKuitansi(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest) {

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/PrintKuitansi2';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NO_KWITANSI=' + NO_KWITANSI
        + '&TIPE_PEMBAYARAN=' + TIPE_PEMBAYARAN 
        + '&NOMINAL_BAYAR=' + NOMINAL_BAYAR
        + '&USER_KASIR=' + USER_KASIR
        + '&BILLTO=' + BILLTO
        + '&NO_TRS=' + NO_TRS
        + '&NamaTest=' + NamaTest
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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}




function getDataApproveBDRS() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_approveBDRS').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_approveBDRS').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveBDRS", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg = noreg
         d.tglawal = tglawal
         d.tglakhir = tglakhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [

                            { "data": "ID" },
                            { "data": "DateOrder" },
                            { "data": "UserOrderName" },
                            { "data": "NamaTarifDarah" },
                            { "data": "Keterangan" },
                            // { "data": "Total" },

                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                if(row.Status_Order == "New"){ 
                                    var badge  = 'success'
                                }else if(row.Status_Order == "Approved"){ 
                                  var badge  = 'danger'
                                }else if(row.Status_Order == "Reviewed"){ 
                                    var badge  = 'warning'
                                }else{
                                  var badge  = ''
                                }
                                
                                  var html = '<span class="badge badge-'+badge+'">'+row.Status_Order+'</span>'
                                     return html 
                              }
                          },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                             
                              var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approve" onclick="approvemodalBDRSdetail(' + row.ID + ',this)" ><span class="glyphicon glyphicon-check"></span></button>'
                                 return html 
                          }
                      },
                           ],
   
     });
}
function approvemodalBDRSdetail(thisid){
    $("#approvemodalBDRSdetail").modal('show');
    $("#bdrsidxx").val(thisid);
    approvemodalBDRSdetail2(thisid);
}
function approvemodalBDRSdetail2(thisid){
    var base_url = window.location.origin;
    var id = thisid;
    $('#tbl_approvebdrs_detail').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_approvebdrs_detail').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveBDRSdetail", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.id = id
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [

                            { "data": "iddetail" },
                            { "data": "iddetail" },
                            { "data": "NamaTarifDarah" },
                            { "data": "Harga" },

                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.Batal == "Aktif"){ 
                                      var badge  = 'success'
                                  }else if(row.Batal == "Batal"){ 
                                      var badge  = 'danger'
                                  }else{
                                    var badge  = ''
                                  }
                                  var html = '<span class="badge badge-'+badge+'">'+row.Batal+'</span>'
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


function BtnApproveBDRS(thisid){
    var table = $('#tbl_approvebdrs_detail').DataTable();
    var form = $("#form_approvebdrs_detail");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapproveBDRS\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapproveBDRS[]')
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
        title: "Simpan",
        text: "Pastikan Pilih Orderan yang tepat untuk di Approve karena orderan yang tidak dipilih akan otomatis batal",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                ApproveCheckboxBDRS(id);
            } 
        });
}


async function ApproveCheckboxBDRS(data) {

    try {
        const dataApproveAllBDRS = await ApproveAllBDRS(data);
        updateUIdataApproveAllBDRS(dataApproveAllBDRS);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAllBDRS(params) {
    let response = params;
    if (response.status == "success") {
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveBDRS();
         var ID = $("#bdrsidxx").val();
        approvemodalBDRSdetail(ID);
    }else{
        toast(response.message, "error")
    }
}

function ApproveAllBDRS(data) {
    var form = $("#form_approvebdrs_detail").serialize();
    // var idbtn = $(passingidbtn).attr("id");
    // var noreg = $("#NoRegistrasi").val();
    // var datebill = $("#tglawal").val();
    // var noeps = $("#NoEpisode").val();
    // var nomr = $("#NoMR").val();

    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();
    var idX = $("#bdrsidxx").val();
    var getreg = $("#NoRegistrasi").val().substring(0, 2);
    var IDUnit =  $('#IDUnit').val();
    // console.log(data,passingidbtn,noreg,idbtn);
    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveAllBDRS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
        + '&noreg=' + noreg
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&idX=' + idX
        + '&getreg=' + getreg
        + '&IDUnit=' + IDUnit

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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}


//---------///
// function getDataApproveBDRSdetail() { 
//     //$(".preloader").fadeIn(); 
//     var base_url = window.location.origin;
//     var noreg = $("#NoRegistrasi").val();
//     var tglawal = $("#tglawal").val();
//     var tglakhir = $("#tglakhir").val();
//     $('#tbl_approveBDRSdetail').dataTable({
//         "bDestroy": true
//     }).fnDestroy();
//        $('#tbl_approveBDRSdetail').DataTable({
//          'ajax':
//     {
//         "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveBDRS", // URL file untuk proses select datanya
//         "type": "POST",
//         data: function (d) {
//          d.noreg = noreg
//          d.tglawal = tglawal
//          d.tglakhir = tglakhir
//      },
//          "dataSrc": "",
//     "deferRender": true,
//     }, 
//     "columns": [

//                             { "data": "ID" },
//                             { "data": "ID" },
//                             { "data": "DateOrder" },
//                             { "data": "UserOrderName" },
//                             { "data": "NamaTarifDarah" },
//                             { "data": "Keterangan" },
//                             { "data": "Total" },

//                             { "render": function ( data, type, row ) { // Tampilkan kolom aksi
//                                 var html = ""
//                                 if(row.Status_Order == "New"){ 
//                                     var badge  = 'success'
//                                 }else if(row.Status_Order == "Approved"){ 
//                                   var badge  = 'danger'
//                                 }else{
//                                   var badge  = ''
//                                 }
                                
//                                   var html = '<span class="badge badge-'+badge+'">'+row.Status_Order+'</span>'
//                                      return html 
//                               }
//                           },
//                           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
//                             var html = ""
                             
//                               var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approve" onclick="ApproveSatuanbdrs(' + row.ID + ',this)" ><span class="glyphicon glyphicon-check"></span></button>&nbsp<button type="button" title="Batal Approve" class="btn btn-danger btn-xs" id="btn_btlapprove"  onclick="ApproveSatuanbdrs(' + row.ID + ',this)" ><i class="fa fa-ban"></i></button>'
//                                  return html 
//                           }
//                       },
//                            ],
//         'columnDefs': [
//            {
//               'targets': 0,
//               'checkboxes': {
//                  'selectRow': true
//               }
//            }
//         ],
//         'select': {
//            'style': 'multi'
//         },
//         'order' : [1,'asc']
//      });
// }
// ApproveSatuanbdrs


function getDataApproveRad() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_approveRadiology').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_approveRadiology').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveRad", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg = noreg
         d.tglawal = tglawal
         d.tglakhir = tglakhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "WOID" },
                            { "data": "WOID" },
                            { "data": "ORDER_DATE" },
                            { "data": "DokterOrder" },
                            { "data": "NamaTarif" },
                            { "data": "ACCESSION_NO" },
                            { "data": "Service_Charge" },

                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.PaymentStatus == "0"){ 
                                      var badge  = 'success'
                                  }else if(row.PaymentStatus == "1"){ 
                                    var badge  = 'info'
                                  }else if(row.PaymentStatus == "2"){ 
                                    var badge  = 'warning'
                                  }else if(row.PaymentStatus == "3"){ 
                                    var badge  = 'danger'
                                  }else{
                                    var badge  = ''
                                  }
                                  var html = '<span class="badge badge-'+badge+'">'+row.Status+'</span>'
                                     return html 
                              }
                          },
                    //       { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    //         var html = ""
                             
                    //           var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approveRad" onclick="ApproveSatuanRad(' + row.WOID + ',this)" ><span class="glyphicon glyphicon-check"></span></button>&nbsp<button type="button" title="Batal Approve" class="btn btn-danger btn-xs" id="btn_btlapproveRad"  onclick="ApproveSatuanRad(' + row.WOID + ',this)" ><i class="fa fa-ban"></i></button>'
                    //              return html 
                    //       }
                    //   },
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
function BtnApproveRad(thisid){
    var table = $('#tbl_approveRadiology').DataTable();
    var form = $("#form_approveRad");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapproveRad\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapproveRad[]')
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
        // title: "Simpan",
        // text: "Apakah Anda ingin Simpan Yang Dipilih ?",
        // icon: "info",
        // buttons: true,
        title: "Warning",
        text: "Pastikan sebelum approve dan batal approve, Konfirmasi terlebih dahulu ke pihak radiology perihal orderan yang dilakukan dan yang tidak dilakukan, karena ketika di batal approve orderan akan otomatis batal dan tidak bisa di approve kembali",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    ApproveCheckboxRad(id);
            } 
        });
}

async function ApproveSatuanRad(data,idbtn) {

    swal({
        title: "Warning",
        text: "Pastikan sebelum approve dan batal approve, Konfirmasi terlebih dahulu ke pihak radiology perihal orderan yang dilakukan dan yang tidak dilakukan, karena ketika di batal approve orderan akan otomatis batal dan tidak bisa di approve kembali",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                ApproveSatuanRadYes(data,idbtn);
            } 
        });
}

async function ApproveSatuanRadYes(data,idbtn) {
    try {
        const dataApproveAllRad = await ApproveRad(data,idbtn);
        updateUIdataApproveAllRad(dataApproveAllRad);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function ApproveCheckboxRad(data) {

    try {
        const dataApproveAllRad = await ApproveAllRad(data);
        updateUIdataApproveAllRad(dataApproveAllRad);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAllRad(params) {
    let response = params;
    if (response.status == "success") {
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveRad();
    }else{
        toast(response.message, "error")
    }
}

function ApproveRad(data,passingidbtn) {
    var idbtn = $(passingidbtn).attr("id");
    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();

    var getreg = $("#NoRegistrasi").val().substring(0, 2);

    var GROUP_JAMINAN =  $('#TypePatientID').val();
    var IDUnit =  $('#IDUnit').val();

    // console.log(data,passingidbtn,noreg,idbtn);
    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveRad';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'data=' + data 
        + '&idbtn=' + idbtn 
        + '&noreg=' + noreg 
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&getreg=' + getreg
        + '&GROUP_JAMINAN=' + GROUP_JAMINAN
        + '&IDUnit=' + IDUnit
        
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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function ApproveAllRad(data) {
    var form = $("#form_approveRad").serialize();
    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();
    var getreg = $("#NoRegistrasi").val().substring(0, 2);
    var GROUP_JAMINAN =  $('#TypePatientID').val();
    var IDUnit =  $('#IDUnit').val();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveAllRad';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
        + '&noreg=' + noreg
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&getreg=' + getreg
        + '&GROUP_JAMINAN=' + GROUP_JAMINAN
        + '&IDUnit=' + IDUnit
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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function getDataApproveLabo() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_approveLaboratorium').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_approveLaboratorium').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveLabo", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg = noreg
         d.tglawal = tglawal
         d.tglakhir = tglakhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "LabID" },
                            { "data": "LabDate" },
                            { "data": "First_Name" },
                            { "data": "NamaTest" },
                            { "data": "NoLAB" },
                            // { "data": "Status" },

                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.StatusID == "0"){ 
                                      var badge  = 'success'
                                  }else if(row.StatusID == "1"){ 
                                      var badge  = 'info'
                                  }else if(row.StatusID == "2"){ 
                                    var badge  = 'warning'
                                  }else if(row.StatusID == "3"){ 
                                    var badge  = 'danger'
                                  }else if(row.StatusID == "4"){ 
                                    var badge  = 'secondary'
                                  }else{
                                    var badge  = ''
                                  }
                                  var html = '<span class="badge badge-'+badge+'">'+row.StatusOrders+'</span>'
                                     return html 
                              }
                          },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                             
                              var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approve" onclick="ApproveSatuanlabdetail1(' + row.LabID + ',this)" ><span class="glyphicon glyphicon-check">'
                                 return html 
                          }
                      },
                           ],
     });
}

function ApproveSatuanlabdetail1(thisid){
    $("#approvemodalLabodetail").modal('show');
    $("#labidxx").val(thisid);
    ApproveSatuanlabdetail2(thisid);
}
function ApproveSatuanlabdetail2(thisid){
    var base_url = window.location.origin;
    var id = thisid;
    $('#tbl_approveLaboratorium_detail').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_approveLaboratorium_detail').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveLabodetail", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.id = id
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "LabDetailID" },
                            { "data": "LabDetailID" },
                            { "data": "NamaTes" },
                            // { "data": "Tarif" },
                            { "data": "Tarif" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},

                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.Batal == "0"){ 
                                      var badge  = 'success'
                                  }else if(row.Batal == "1"){ 
                                      var badge  = 'danger'
                                  }else{
                                    var badge  = ''
                                  }
                                  var html = '<span class="badge badge-'+badge+'">'+row.StatusBatal+'</span>'
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

function BtnApprovelabo(thisid){
    var table = $('#tbl_approveLaboratorium_detail').DataTable();
    var form = $("#form_approvelab_detail");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapprovelab\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapprovelab[]')
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
        text: "Pastikan approve dengan benar, Karena orderan yang tidak di ceklis / batal approve akan otomatis membatalkan orderan, silahkan hubungi pihak lab untuk memastikan orderan yang di lakukan pemeriksaannya !",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    ApproveCheckboxlab(id);
            } 
        });
}

async function ApproveCheckboxlab(data) {
    try {
        const dataApproveAllLab = await ApproveAllLab(data);
        updateUIdataApproveAllLab(dataApproveAllLab);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAllLab(params) {
    let response = params;
    if (response.status == "success") {
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveLabo();
        // $("#labidxx").val(thisid);
        var idlab = $("#labidxx").val();
        ApproveSatuanlabdetail1(idlab);
    }else{
        toast(response.message, "error")
    }
}

function ApproveAllLab(data) {
    var form = $("#form_approvelab_detail").serialize();
    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();
    var labidx = $("#labidxx").val();
    var getreg = $("#NoRegistrasi").val().substring(0, 2);

    var GROUP_JAMINAN =  $('#TypePatientID').val();
    var IDUnit =  $('#IDUnit').val();
    // console.log(getreg);
    // return false;

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveAllLab';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
        + '&noreg=' + noreg
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&labidx=' + labidx
        + '&getreg=' + getreg
        + '&GROUP_JAMINAN=' + GROUP_JAMINAN
        + '&IDUnit=' + IDUnit

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

function btnSumTarif(thisid){
    // console.log(thisid);
    // return false;
    var table = $('#tbl_rincianbiaya_payment').DataTable();
    var form = $("#form_sumtarif_all");
    var id = $(thisid).attr("id");

    // console.log(table);
    // console.log(form);
    // console.log(id);
    // return false;

    // Remove added elements
    $('input[name="cb_tarifall\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'cb_tarifall[]')
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
        title: "Simpan",
        text: "Apakah Anda ingin Simpan Yang Dipilih ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    getTarifSum(id);
            } 
        });
}

async function getTarifSum(data) {

    // console.log(data);
    // return false;
    try {
        const datagetTarifAllSum = await getTarifAllSum(data);
        updateUIdatagetTarifAllSum(datagetTarifAllSum);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagetTarifAllSum(params) {
    let response = params;
    // console.log(response);
    // return false;
    $("#totalinput").val(convertEntities(response));
    // if (response.status == "success") {
    //     swal({
    //         title: "Simpan Berhasil!",
    //         text: response.message,
    //         icon: "success",
    //     })
        // getDataApproveLabo();
        // $("#labidxx").val(thisid);
        // var idlab = $("#labidxx").val();
        // ApproveSatuanlabdetail1(idlab);
    // }else{
    //     toast(response.message, "error")
    // }
}

function getTarifAllSum(data) {
    var form = $("#form_sumtarif_all").serialize();
    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();
    // var labidx = $("#labidxx").val();
    var getreg = $("#NoRegistrasi").val().substring(0, 2);

    var GROUP_JAMINAN =  $('#TypePatientID').val();
    // console.log(getreg);
    // return false;

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/sumAllTarif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + '&idbtn=' + data 
        + '&noreg=' + noreg
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&getreg=' + getreg
        + '&GROUP_JAMINAN=' + GROUP_JAMINAN

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


function getDataApproveFarmasi() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    $('#tbl_approvefarmasi').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#tbl_approvefarmasi').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveFarmasi", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg = noreg
         d.tglawal = tglawal
         d.tglakhir = tglakhir
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "orderid" },
                            { "data": "orderid" },
                            { "data": "tglResep" },
                            { "data": "JenisResep" },
                            { "data": "NoResep" },
                            { "data": "Jumlah" },
                        //     { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        //         var html = ""
                        //           if(row.StatusID == "0"){ 
                        //               var badge  = 'success'
                        //           }else if(row.StatusID == "1"){ 
                        //               var badge  = 'warning'
                        //           }else if(row.StatusID == "2"){ 
                        //             var badge  = 'danger'
                        //           }else if(row.StatusID == "3"){ 
                        //             var badge  = 'info'
                        //           }else if(row.StatusID == "4"){ 
                        //             var badge  = 'secondary'
                        //           }else{
                        //             var badge  = ''
                        //           }
                        //           var html = '<span class="badge badge-'+badge+'">'+row.StatusName+'</span>'
                        //              return html 
                        //       }
                        //   },

                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                              if(row.StatusResep == "Review"){ 
                                  var badge  = 'warning'
                              }else if(row.StatusResep == "Approve"){ 
                                var badge  = 'danger'
                              }else{
                                var badge  = 'success'
                              }
                              var html = '<span class="badge badge-'+badge+'">'+row.StatusResep+'</span>'
                                 return html 
                          }
                      },
                          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                            var html = ""
                             
                            var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approve" onclick="ApproveSatuan(' + row.orderid + ',this)" ><span class="glyphicon glyphicon-check"></span></button>&nbsp<button type="button" title="Batal Approve" class="btn btn-danger btn-xs" id="btn_btlapprove"  onclick="ApproveSatuan(' + row.orderid + ',this)" ><i class="fa fa-ban"></i></button>'
                            //   var html  = '<button type="button" title="Approve" class="btn btn-success btn-xs" id="btn_approve" onclick="ApproveSatuan(' + row.orderid + ',this)" ><span class="glyphicon glyphicon-check"></span></button>'
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

function BtnApprove(thisid){
    var table = $('#tbl_approvefarmasi').DataTable();
    var form = $("#form_approve");
    var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idorderapprove\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idorderapprove[]')
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
        title: "Simpan",
        text: "Apakah Anda ingin Simpan Yang Dipilih ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                    ApproveCheckbox(id);
            } 
        });
}

async function ApproveSatuan(data,idbtn) {
    try {
        const dataApproveAll = await Approve(data,idbtn);
        updateUIdataApproveAll(dataApproveAll);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function ApproveCheckbox(data) {
    try {
        const dataApproveAll = await ApproveAll(data);
        updateUIdataApproveAll(dataApproveAll);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApproveAll(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

function Approve(data,passingidbtn) {
    var idbtn = $(passingidbtn).attr("id");
    var noreg = $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = $("#NoEpisode").val();
    var nomr = $("#NoMR").val();
    var getreg = $("#NoRegistrasi").val().substring(0, 2);
    var GROUP_JAMINAN =  $('#TypePatientID').val();
    var IDUnit =  $('#IDUnit').val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/Approve';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'data=' + data 
        + '&idbtn=' + idbtn 
        + '&noreg=' + noreg 
        + '&datebill=' + datebill
        + '&noeps=' + noeps
        + '&nomr=' + nomr
        + '&getreg=' + getreg
        + '&GROUP_JAMINAN=' + GROUP_JAMINAN
        + '&IDUnit=' + IDUnit

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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

function ApproveAll(data) {
    var form = $("#form_approve").serialize();
    
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveAll';
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

//PAYMENT ACT


function getDataDetailBilling_Payment(attr) { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    var ispayment = 'tbl_payment_modal';

    // console.log(attr);
    // return false;
    $('#tbl_rincianbiaya_payment').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#tbl_rincianbiaya_payment').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailBillingx", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.tglawal = tglawal
                d.tglakhir = tglakhir
                d.ispayment = ispayment
                d.attr = attr
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "NO_TRS_BILLING" },
            { "data": "No" },
            { "data": "NO_TRS_BILLING" },
            { "data": "TGL_BILLING" },
            { "data": "NamaTest" },
            { "data": "TOTAL_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "SUBTOTAL_2" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            
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

function btnAmountByTRS(thisid){
    var table = $('#tbl_rincianbiaya_payment').DataTable();
    var notrs = $(thisid).attr("id");

    // Remove added elements
    $('input[name="btnAmountByTRS\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     var count = $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'btnAmountByTRS[]')
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
        title: "Simpan",
        text: "Apakah Anda ingin Simpan Yang Dipilih ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                ApproveCheckboxAmount(notrs);
            } 
        });
}


async function ApproveCheckboxAmount(data) {

    console.log(data);
    exit;

    // try {
    //     const dataApproveAllBDRS = await ApproveAllBDRS(data);
    //     updateUIdataApproveAllBDRS(dataApproveAllBDRS);
    // } catch (err) {
    //     toast(err.message, "error")
    // }
}

// function updateUIdataApproveAllBDRS(params) {
//     let response = params;
//     if (response.status == "success") {
//         swal({
//             title: "Simpan Berhasil!",
//             text: response.message,
//             icon: "success",
//         })
//         getDataApproveBDRS();
//          var ID = $("#bdrsidxx").val();
//         approvemodalBDRSdetail(ID);
//     }else{
//         toast(response.message, "error")
//     }
// }

// function ApproveAllBDRS(data) {
//     var form = $("#form_approvebdrs_detail").serialize();
//     // var idbtn = $(passingidbtn).attr("id");
//     // var noreg = $("#NoRegistrasi").val();
//     // var datebill = $("#tglawal").val();
//     // var noeps = $("#NoEpisode").val();
//     // var nomr = $("#NoMR").val();

//     var noreg = $("#NoRegistrasi").val();
//     var datebill = $("#tglawal").val();
//     var noeps = $("#NoEpisode").val();
//     var nomr = $("#NoMR").val();
//     var idX = $("#bdrsidxx").val();
//     var getreg = $("#NoRegistrasi").val().substring(0, 2);

//     // var GROUP_JAMINAN =  $('#TypePatientID').val();
//     // console.log(data,passingidbtn,noreg,idbtn);
//     // return false;
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/aBillingPasien/ApproveAllBDRS';
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: form + '&idbtn=' + data 
//         + '&noreg=' + noreg
//         + '&datebill=' + datebill
//         + '&noeps=' + noeps
//         + '&nomr=' + nomr
//         + '&idX=' + idX
//         + '&getreg=' + getreg
//         // + '&GROUP_JAMINAN=' + GROUP_JAMINAN


//     })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(response.statusText)
//             }
//             return response.json();
//         })
//         .then(response => {
//             if (response.status === "error") {
//                 throw new Error(response.message.errorInfo[2]);
//                 // console.log("ok " + response.message.errorInfo[2])
//             } else if (response.status === "warning") {
//                 throw new Error(response.message);
//                 // console.log("ok " + response.message.errorInfo[2])
//             }
//             return response
//         })
//         .finally(() => {
//             $(".preloader").fadeOut();
//         })
// }

function BtnSubmitBayar(){
    var table = $('#tbl_rincianbiaya_payment').DataTable();
    var form = $("#form_payment");
    //var id = $(thisid).attr("id");

    // Remove added elements
    $('input[name="idbillingdtl\[\]"]', form).remove();
    
    var rows_selected = table.column(0).checkboxes.selected();

     $.each(rows_selected, function(index, rowId){
       $(form).append(
           $('<input>')
              .attr('type', 'hidden')
              .attr('name', 'idbillingdtl[]')
              .val(rowId)
       );
   });

   //Cek if checkbox check at least 1 item
    var list = [(rows_selected.join(","))];
    if (list == ''){
        toast('Silahkan Pilih Minimal 1 Item di tabel !','warning');
        return false;
    }

    //$("#modal_cbedittanggal").modal('show');

    //CEK LIST ADA ATAU TIDAK
    // var count_data = 0;
    //     $('.hidden_kode_barang').each(function () {
    //             count_data = count_data + 1;
    //           });
    //    if (count_data == 0) {
    //     toast("List Pembayaran Masih Kosong, Mohon  Isi Terlebih Dahulu!", 'warning');
    //     return false;
    //    }

    //Swal
    // swal({
    //     title: "Simpan",
    //     text: "Apakah Anda ingin Simpan ?",
    //     icon: "info",
    //     buttons: true,
    // })
    //     .then((willDelete) => {
    //         if (willDelete) {
    //                // ApproveCheckbox(id);
    //                goSaveTrsPayment();
    //         } 
    //     });
    goUpdateKlaimBayar()
    return true;
}

async function goUpdateKlaimBayar() {
    try {
        const dataUpdateKlaimBayar = await UpdateKlaimBayar();
        updateUIdataUpdateKlaimBayar(dataUpdateKlaimBayar);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataUpdateKlaimBayar(params) {
    let response = params;
   
    if (response.status == "success") {
        toast(response.message, "success")
        // swal({
        //     title: "Tambah Berhasil!",
        //     text: response.message,
        //     icon: "success",
        // })
        //return true;
    }else{
        toast(response.message, "error")
    }  

}

function UpdateKlaimBayar() {
     var form = $("#form_payment").serialize();
    // var NoMR = $("#NoMR").val();
    // var NoEpisode = $("#NoEpisode").val();
    // var NoRegistrasi = $("#NoRegistrasi").val();
    // var tglpayment = $("#tglpayment").val();
    var tipepembayaran = $("#tipepembayaran").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateKlaimBayar';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&tipepembayaran=" + tipepembayaran
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
////////
async function goOpenBill() {
    try {
        const dataOpenBill = await OpenBill();
        updateUIdataOpenBill(dataOpenBill);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataOpenBill(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

function OpenBill() {
    var base_url = window.location.origin;
    var groupjaminan = $('#GroupJaminan').val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/OpenBilling';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoRegistrasi=" + $("#NoRegistrasi").val() +
        "&groupjaminan=" + groupjaminan
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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $(".preloader").fadeOut();
        })
}

//#END PAYMENT ACT

//GET PAYMENT TYPE
function updateUIgetPaymentType(datagetPaymentType) {
    let data = datagetPaymentType;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#tipepembayaran").append(newRow);
        $("#tipepembayaran_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].PaymentType + '">' + data[i].PaymentType + '</option';
            $("#tipepembayaran").append(newRow);
            $("#tipepembayaran_closing").append(newRow);
        }
    }
}
////
async function goSaveTrsPayment() {
    try {
        const dataSaveTrsPayment = await SaveTrsPayment();
        updateUIdataSaveTrsPayment(dataSaveTrsPayment);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveTrsPayment(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

function SaveTrsPayment() {
    var form = $("#form_payment").serialize();
    var NoMR = $("#NoMR").val();
    var NoEpisode = $("#NoEpisode").val();
    var NoRegistrasi = $("#NoRegistrasi").val();
    var tglpayment = $("#tglpayment").val();
    var TypePatientID = $("#TypePatientID").val();
    var kodepjm = $("#penjamin_kode").val();
    var Penjamin = $("#Penjamin").val();
    var namapasien = $("#NamaPasien").val();
    var bilito  = '';

    // console.log(Penjamin);
    // console.log(kodepjm);= ''
    // }

    if(kodepjm == '315'){
        bilito  = namapasien;
    }
    else{
        bilito  = Penjamin;
    }
    

    // console.log(bilito);
    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/SaveTrsPayment';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&NoMR=" + NoMR + "&NoEpisode=" + NoEpisode + "&NoRegistrasi=" + NoRegistrasi + "&tglpayment=" + tglpayment + "&TypePatientID=" + TypePatientID + "&bilito=" + bilito
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

//#END PAYMENT ACT

//GET PAYMENT TYPE
function updateUIgetPaymentType(datagetPaymentType) {
    let data = datagetPaymentType;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#tipepembayaran").append(newRow);
        $("#tipepembayaran_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].PaymentType + '">' + data[i].PaymentType + '</option';
            $("#tipepembayaran").append(newRow);
            $("#tipepembayaran_closing").append(newRow);
        }
    }
}
function getPaymentType() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getPaymentType';
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
            $("#tipepembayaran").select2();
            $("#tipepembayaran_closing").select2();
        })
}
//#END GET PAYMENT TYPE

//GET EDC
async function getEDC(param) {
    try {   
        const datagetEDC = await getPaymentEDC(param);
        updateUIgetEDC(datagetEDC);
    
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIgetEDC(datagetEDC) {
    let data = datagetEDC;
    if (data !== null && data !== undefined) {
        //console.log(data);
        $("#namabank").empty();
        $("#namabank_closing").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#namabank").append(newRow);
        $("#namabank_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].NAMA_BANK + '">' + data[i].NAMA_BANK + '</option';
            $("#namabank").append(newRow);
            $("#namabank_closing").append(newRow);
        }
    }
}
function getPaymentEDC(param) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getPaymentEDC';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'tipekartu=' + param
        
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
            $("#namabank").select2();
            $("#namabank_closing").select2();
        })
}
//#END GET EDC

//GET KODE REKENING
async function getKDREKENING(param) {
    try {   
        const datagetKodeRekening = await getKodeRekening(param);
        updateUIgetKodeRekening(datagetKodeRekening);
    
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIgetKodeRekening(param) {
    let data = param;
    if (data !== null && data !== undefined) {
        $("#kd_rekening").val(data.data.FS_KD_REKENING);
        $("#kd_rekening_closing").val(data.data.FS_KD_REKENING);
    }
}
function getKodeRekening(param) {
    var base_url = window.location.origin;
    var jenispasien = 'RAJAL';
    var namabank = $("#namabank").val();
    var idjaminan = $("#penjamin_kode").val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/getKodeRekening';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'tipekartu=' + param +"&pasien="+jenispasien +"&namabank="+namabank +"&idjaminan="+idjaminan
        
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
//#END KODE REKENING

//GET MASTER PERUSAHAAN
async function getPerusahaan() {
    try {   
        const datagetAllDataPerusahaan = await getAllDataPerusahaan();
        updateUIdatagetAllDataPerusahaan(datagetAllDataPerusahaan);
    
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagetAllDataPerusahaan(param) {
    let data = param;
    if (data !== null && data !== undefined) {
        $("#perusahaanjpk").empty();
        $("#perusahaanjpk_closing").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#perusahaanjpk").append(newRow);
        $("#perusahaanjpk_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].NamaPerusahaan + '</option';
            $("#perusahaanjpk").append(newRow);
            $("#perusahaanjpk_closing").append(newRow);
        }
    }
}
function getAllDataPerusahaan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataPerusahaan/getAllDataPerusahaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        
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
            $("#perusahaanjpk").select2();
            $("#perusahaanjpk_closing").select2();
        })
}
//#END MASTER PERUSAHAAN

//GET MASTER ASURANSI
async function getAsuransi() {
    try {   
        const datagetAllDataAsuransi = await getAllDataAsuransi();
        updateUIdatagetAllDataAsuransi(datagetAllDataAsuransi);
    
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagetAllDataAsuransi(param) {
    let data = param;
    if (data !== null && data !== undefined) {
        $("#perusahaanasuransi").empty();
        $("#perusahaanasuransi_closing").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#perusahaanasuransi").append(newRow);
        $("#perusahaanasuransi_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].ID + '">' + data[i].NamaPerusahaan + '</option';
            $("#perusahaanasuransi").append(newRow);
            $("#perusahaanasuransi_closing").append(newRow);
        }
    }
}
function getAllDataAsuransi() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataAsuransi/getAllDataAsuransi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        
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
            $("#perusahaanasuransi").select2();
            $("#perusahaanasuransi_closing").select2();
        })
}
//#END MASTER ASURANSI

function getBillto(param){
    $("#billto").val('');
    $("#kodejaminan").val('');
    if (param=='Kartu Debit' || param=='Kartu Kredit'){
        var namapasien = $("#NamaPasien").val();
        $('#telahterima_ui2').fadeOut('fast') 
        $('#telahterima_ui3').fadeOut('fast') 
        $("#billto").val(namapasien);
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#card_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        var attr = 'BAYAR';
        getDataDetailBilling_Payment(attr);
        
    }else if (param=='Piutang Perusahaan'){
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui2').fadeOut().fadeIn('fast') 
        var attr = 'KLAIM';
        getDataDetailBilling_Payment(attr);
    }else if (param=='Piutang Asuransi'){
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui3').fadeOut().fadeIn('fast') 
        var attr = 'KLAIM';
        getDataDetailBilling_Payment(attr);
    }
    else if(param==''){
        $('#cash_ui').fadeOut().fadeOut('fast') 
        $('#card_ui').fadeOut().fadeOut('fast') 
        var attr = null;
        getDataDetailBilling_Payment(attr);
    }
    else if(param=='Tunai' || param=='Piutang Rawat Inap' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher'){
       
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        $('#cash_ui').fadeOut().fadeIn('slow') 
        var attr = 'BAYAR';
        getDataDetailBilling_Payment(attr);
    }

}

function passingVal(f){
     var value = $(f).val();
     var getid = $(f).attr('name');
     $("#kodejaminan").val(value);

     var selected = $('#'+getid+' option:selected').text()
     $("#billto").val(selected);

     if(value != $('#penjamin_kode').val()){
        swal({
                text: "PERINGATAN! 'Telah Terima Dari' tidak sama dengan registrasi penjamin pasien! Mohon diperiksa kembali!",
            });
        }
}

//GET BILL CLOSING

function getBillto_closing(param){
    $("#billto_closing").val('');
    $("#kodejaminan_closing").val('');
    if (param=='Kartu Debit' || param=='Kartu Kredit'){
        var namapasien = $("#NamaPasien").val();
        $('#telahterima_ui2_closing').fadeOut('fast') 
        $('#telahterima_ui3_closing').fadeOut('fast') 
        $("#billto_closing").val(namapasien);
        $('#cash_ui_closing').fadeOut().fadeIn('fast') 
        $('#card_ui_closing').fadeOut().fadeIn('fast') 
        $('#telahterima_ui_closing').fadeOut().fadeIn('fast') 
        // var attr = 'BAYAR';
        // getDataDetailBilling_Payment(attr);
        
    }else if (param=='Piutang Perusahaan'){
        $('#card_ui_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3_closing').fadeOut().fadeOut('fast') 
        $('#cash_ui_closing').fadeOut().fadeIn('fast') 
        $('#telahterima_ui2_closing').fadeOut().fadeIn('fast') 
        // var attr = 'KLAIM';
        // getDataDetailBilling_Payment(attr);
    }else if (param=='Piutang Asuransi'){
        $('#card_ui_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2_closing').fadeOut().fadeOut('fast') 
        $('#cash_ui_closing').fadeOut().fadeIn('fast') 
        $('#telahterima_ui3_closing').fadeOut().fadeIn('fast') 
        // var attr = 'KLAIM';
        // getDataDetailBilling_Payment(attr);
    }
    else if(param==''){
        $('#cash_ui_closing').fadeOut().fadeOut('fast') 
        $('#card_ui_closing').fadeOut().fadeOut('fast') 
        // var attr = null;
        // getDataDetailBilling_Payment(attr);
    }
    else if(param=='Tunai' || param=='Piutang Rawat Inap' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher'){
        $('#card_ui_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2_closing').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3_closing').fadeOut().fadeOut('fast') 
        var namapasien = $("#NamaPasien").val();
        $("#billto_closing").val(namapasien);
        $('#telahterima_ui_closing').fadeOut().fadeIn('fast') 
        $('#cash_ui_closing').fadeOut().fadeIn('slow') 
        // var attr = 'BAYAR';
        // getDataDetailBilling_Payment(attr);
    }

}

function passingVal_closing(f){
    var value = $(f).val();
    var getid = $(f).attr('name');

    $("#kodejaminan_closing").val(value);
    var selected = $('#'+getid+' option:selected').text()
    $("#billto_closing").val(selected);

    if(value != $('#penjamin_kode').val()){
       swal({
               text: "PERINGATAN! 'Telah Terima Dari' tidak sama dengan registrasi penjamin pasien! Mohon diperiksa kembali!",
           });
       }
}

async function goDataBillClosingan() {
    try{
        const DatagetDataBillClosingan = await getDataBillClosingan();
        updateUIDatagetDataBillClosingan(DatagetDataBillClosingan);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getDataBillClosingan() {
    var base_url = window.location.origin;
    var NoRegistrasi = $("#NoRegistrasi").val()
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataBillClosingan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + NoRegistrasi 
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

function updateUIDatagetDataBillClosingan(param) {
    let dataresponse = param;
    if (dataresponse !== null && dataresponse !== undefined) {

        $("#T_Administrasi").val(convertEntities(dataresponse.data.Adm));
        $("#T_Konsultasi").val(convertEntities(dataresponse.data.Konsultasi));
        //$("#T_Visite").val(convertEntities(dataresponse.data.Visite));
        $("#T_Tindakan").val(convertEntities(dataresponse.data.Tindakan));
        $("#T_Laboratorium").val(convertEntities(dataresponse.data.Lab));
        $("#T_Radiologi").val(convertEntities(dataresponse.data.Rad));
        $("#T_Farmasi").val(convertEntities(dataresponse.data.Far));
        $("#T_Total").val(convertEntities(dataresponse.data.TOTAL));
    }
}

async function goSaveTrsPayment_closing() {
    try {
        const dataSaveTrsPayment_closing = await SaveTrsPayment_closing();
        updateUIdataSaveTrsPayment_closing(dataSaveTrsPayment_closing);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveTrsPayment_closing(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

function SaveTrsPayment_closing() {
    var form = $("#form_payment_closing").serialize();
    var NoMR = $("#NoMR").val();
    var NoEpisode = $("#NoEpisode").val();
    var NoRegistrasi = $("#NoRegistrasi").val();
    var tglpayment = $("#tglpayment_closing").val();
    var TypePatientID = $("#TypePatientID").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/SaveTrsPayment_closing';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&NoMR=" + NoMR + "&NoEpisode=" + NoEpisode + "&NoRegistrasi=" + NoRegistrasi + "&tglpayment_closing=" + tglpayment + "&TypePatientID=" + TypePatientID
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

//#END PAYMENT ACT

//#END BILL CLOSING


async function printkuitansidetailshow(no_trs) {
    var base_url = window.location.origin;
    // var base_urlx = window.location.origin;
    var jeniscetak = 'PrintKuitansiDetail';
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0, 2);
    var lang = no_trs;
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + lang +"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    // printrincian(base_urlx);
}

async function printrinciandetail(no_trs) {
    var base_url = window.location.origin;
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0,2);
    var lang = no_trs;
    window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRinciandetail"+kodereg+"/"+lang +"/"+notrs, "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

// 22/08/2024
// async function batalriwayatpembayaran(no_trs) {
//     var base_url = window.location.origin;
//     var noreg = $("#NoRegistrasi").val();
//     var notrs = no_trs;
//     console.log(notrs);
// }
async function btnbatalriwayatpembayaran(no_trs){
    $("#mAlasanBtlPayment").modal('show');
    $('#tNoTrs').val(no_trs);
}
async function btnbatalriwayatpembayaranbymodal(){
    var tNoTrs = $("#tNoTrs").val();
    btnbatalriwayatpembayaranbymodalnotrs(tNoTrs);
}
async function btnbatalriwayatpembayaranbymodalnotrs(no_trs){
    try{
        const dataSetBatalRiwayatPembayaran = await SetBatalRiwayatPembayaran(no_trs);
        updateUIdataSetBatalRiwayatPembayaran(dataSetBatalRiwayatPembayaran);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SetBatalRiwayatPembayaran(no_trs) {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var alasanBtlPayment = $("#alasanBtlPayment").val();
    var notrs = no_trs;

    let url = base_url + '/SIKBREC/public/aBillingPasien/SetSaveBatalRiwayatPembayaran';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'noreg=' +  noreg +
                '&notrs=' + notrs +
                '&alasanBtlPayment=' + alasanBtlPayment 

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

function updateUIdataSetBatalRiwayatPembayaran(dataSetBatalRiwayatPembayaran) {
    let dataSaveTampung = dataSetBatalRiwayatPembayaran;
    if (dataSaveTampung.status == "success") {
        swal("DATA RIWAYAT PEMBAYARAN",  "BERHASIL DI BATALKAN", "success");
        asyncShowMain();
        $("#mAlasanBtlPayment").modal('hide');
    }else{
        toast(response.message, "error")
    }
}
// 22/08/2024


async function printkuitansiAll() {
    var base_url = window.location.origin;
    // var base_urlx = window.location.origin;
    var jeniscetak = 'PrintKuitansiAll';
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0, 2);
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    // printrincian(base_urlx);
}

async function printrincianAll() {
    var base_url = window.location.origin;
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0,2);
    window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRincianAll"+kodereg+"/"+notrs, "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

async function goCountCetak(No) {

    
    try {
        $(".preloader").fadeIn();
        var notrs = $("#NoRegistrasi").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var jeniscetakan = 'KUITANSIREKAP';
        var kodereg = $("#NoRegistrasi").val().slice(0, 2);
        var lang = 'ID';
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, jeniscetakan, kodereg);
        updateUiSukseshistory(dataCountCetak, notrs,lang,kodereg,jeniscetakan);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}

function updateUiSukseshistory(params, notrs,lang,kodereg,jeniscetakan) {
    if (params.status === 200) {
        var base_url = window.location.origin;
        if (jeniscetakan == 'KUITANSIREKAP'){
            var jeniscetak = 'PrintKuitansiRekap';
        }else{
            var jeniscetak = 'PrintKuitansi';
        }

        window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + lang +"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        //MyBack();
        $("#notif_ShowTTD_Digital").modal('hide');
        toast(params.message, 'success');
    }
}

function CountCetak(notrs, signAlasanCetak, jeniscetakan,kodereg) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan + "&kodereg=" + kodereg
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




function uploadtoAws(notrs,kodereg,lang,jeniscetakan,url){
    $(".preloader").fadeIn();
    //if ($)
    var FormData = {
        notrs:notrs,
        // namaparam2:$("#signAlasanCetak").val(),
        jeniscetakan:jeniscetakan,
        kodereg:kodereg,
        lang:lang,
        periode_awal:$("#tglawal").val(),
        periode_akhir:$("#tglakhir").val(),
        lang:lang,
    }
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/SIKBREC/public/aBillingPasien/'+url,
        data: FormData,
        type: 'post',
        dataType: 'json',
        success: function(response) {
            $(".preloader").fadeOut();
            if (response.status != 200) { 
                swal({
                    title: "error",
                    text: "Data Gagal di Simpan ke Sistem !",
                    icon: "error",
                })
            } else {
                swal({
                    title: "success",
                    text: "Generate Berhasil",
                    icon: "success",
                }) 
                //$("#notif_ShowTTD_Digital").modal('show');
            }
        }
    });
}

// async function goSendEmail() {
//     try {
//         const data = await SendEmail();
//         //updateUISendEmail(data);
//     } catch (err) {
//         toast(err.message, "error")
//     }
// }

function updateUISendEmail(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Kirim Berhasil!",
            text: response.message,
            icon: "success",
        })
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

async function SendEmail(judul,email,awsurl) {
    $(".preloader").fadeIn();
    var pkuitansi_notrs = $("#pkuitansi_notrs").val();
    var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
    var noregistrasi = $("#NoRegistrasi").val();
    var aws_url = awsurl['aws_url'];
    // var email = $("#pemail_pasien").val();
    // if (!validateEmail(email)) {
    //     swal({
    //         title: "Email Tidak Sesuai Format",
    //         text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
    //         icon: "warning",
    //     })
    //     $("#pemail_pasien").focus();
    //     $(".preloader").fadeOut();
    //     return false;
    //    }
    var FormData = {
        notrs:pkuitansi_notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
        aws_url:aws_url,
    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aBillingPasien/SendMail/";
    $.ajax({
        url: url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
        success: function (data) {
          $(".preloader").fadeOut();
            if (data.status=='success'){
              var title = 'Kirim Email Berhasil!';
              var statuskirim = 'TERKIRIM';
            }else{
              var title = 'Kirim Email Gagal!';
              var statuskirim = 'GAGAL';
            }
            
            $("#notif_ShowTTD_Digital").modal('hide');
            swal({
              title: title,
              text: data.message,
              icon: data.status,
          }).then(function() {

          });
          //INSERT TZ LOG EMAIL
          //goInsertLog(nolab,statuskirim,email);

        },
        error: function (xhr, status) {
          $(".preloader").fadeOut();
          toast(xhr, status);
            // handle errors
            console.log(xhr,status);
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  async function updateUICekPernahGenerate(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
    uploadtoAws(notrs,kodereg,lang,jeniscetakan,url);

    //if (dataresponse['ID'] == null){
        // swal({
        //     title: "Generate",
        //     text: "Apakah anda yakin Ingin generate terlebih dahulu ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        //   })
        //   .then((willDelete) => {
        //     if (willDelete) {
        //         var notrs = $("#pkuitansi_notrs").val();
        //         var kodereg = $("#NoRegistrasi").val().slice(0,2);
        //         // if (kodereg != 'RJ' || kodereg != 'RI'){
        //         //     kodereg = 'PB';
        //         // }
        //         var lang = $("#pkuitansi_lang").val();
        //         var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
        //         if (jeniscetakan == 'KUITANSIREKAP'){
        //             var url = 'SaveKuitansiRekap';
        //         }else if(jeniscetakan == 'KUITANSI'){
        //             var url = 'SaveKuitansi';
        //         }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
        //             var url = 'SaveRincianPB';
        //         }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
        //             var url = 'SaveRincianRJ';
        //         }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
        //             var url = 'SaveRincianRI';
        //         }
        //         uploadtoAws(notrs,kodereg,lang,jeniscetakan,url);
        //     } else {
        //       //swal("Your imaginary file is safe!");
        //     }
        //   });
    // }else{
    //     $("#notif_ShowTTD_Digital").modal('show');
    // }
    

        $(".preloader").fadeOut(); 
}

function CekPernahGenerate() {
    var base_url = window.location.origin;
    var noregistrasi = $("#NoRegistrasi").val()
    var jeniscetakan = $("#pkuitansi_jeniscetakan").val() 
    var notrs = $("#pkuitansi_notrs").val()
    let url = base_url + '/SIKBREC/public/aBillingPasien/CekPernahGenerate';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'noregistrasi=' + noregistrasi +'&jeniscetakan='+ jeniscetakan +'&notrs=' + notrs
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


function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
    }

async function BtnTindakanByUnit(){
    document.getElementById("form_tindakan_new").reset();
    var dataHandler = $("#user_datas");
    dataHandler.html("");
    
    $("#dateabilling").attr('disabled', false);
    $("#timeabilling").attr('disabled', false);
    $("#tbtnhdradd").attr('disabled', false);

    $("#namatindakannew").attr('disabled', true);
    $("#dokterpemeriksanew").attr('disabled', true);
    $("#qty_addvisitnew").attr('disabled', true);
    $("#btnaddtindakanx").attr('disabled', true);
    $("#btnSaveAll").attr('disabled', true);


    $("#modaltindakanbyorderOperasi").modal('show');

    var xNoreg = $('#NoRegistrasi').val(); 
    var xNoepisode = $('#NoEpisode').val();
    var xNoMR = $('#NoMR').val();
    var xNamaPasien = $('#NamaPasien').val();
    var xNamaJaminan = $('#Penjamin').val();

    console.log(xNoMR);
    $('#bilNOreg').val(xNoreg);
    $('#bilNoEpisode').val(xNoepisode);
    $('#bilNoMr').val(xNoMR);
    $('#bilNamaPasien').val(xNamaPasien);
    $('#bilNamaJaminan').val(xNamaJaminan);

}







function getTarifChanger(){ 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var GroupJaminan = $('#TypePatientID').val();
    var penjamin_kode = $('#penjamin_kode').val();
    var IDUnit = $('#IDUnit').val();

    // console.log(IDUnit);
    // exit;
    $('#tbl_update_tarif').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#tbl_update_tarif').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataTarifNext", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.GroupJaminan = GroupJaminan
                d.penjamin_kode = penjamin_kode
                d.IDUnit = IDUnit
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NO_KWITANSI" },
            { "data": "TGL_TRS" },
            { "data": "TIPE_PEMBAYARAN" },
            { "data": "NOMINAL_BAYAR" },
            { "data": "USER_KASIR" },
            { "data": "BILLTO" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
               //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                  var html  = '<button type="button" onclick="ShowDataTarifx('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>'
                     return html 
              }
       },

           ],

       });
}

function BtnTindakanLab(){
    // $("#modaltindakanbyorderLab").modal('show');
}

function BtnTindakanRad(){
    // $("#modaltindakanbyorderRad").modal('show');
}

async function BtnTindakanOperasi(){
    // var base_url = window.location.origin;
    // base_url.reload();
    console.log('au ah');
    window.location.reload();
    
    // $("#modaltindakanbyorderOperasi").modal('show');
    // getDokter();
    // getTindakan();
    // searchTindakan();
    // searchDokter();
}


async function searchTindakan(){
    try{
        var getreg = $("#NoRegistrasi").val().substring(0, 2);
        if (getreg == 'RJ'){
            var datagetTindakanRJ =  await getTindakanRJ();
            updateUIgetDataTindakanNew(datagetTindakanRJ); 
        }else if (getreg == 'RI'){
            var datagetTindakanRI =  await getTindakanRI();
            updateUIgetDataTindakanNew(datagetTindakanRI); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataTindakanNew(datagetTindakan) {
    let responseApi = datagetTindakan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        $("#namatindakannew").empty();
        
        var newRow = '<option value="">-- PILIH --</option>';
        $("#namatindakannew").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].ProductName + '</option>';
            $("#namatindakannew").append(newRow);

        }

    }
}

function getTindakanRJ() {
    var base_url = window.location.origin;
    // var tglbill = $('#datebilling').val();
    var tglbill = $('#dateabilling').val();
    var xdi = $('#IDUnit').val();
    var groupjaminan = $('#GroupJaminan').val();
    var jenispasien = 'RJ';
    let url = base_url + '/SIKBREC/public/aBillingPasien/gettarifnew';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idunit=' + xdi + '&groupjaminan=' + groupjaminan + '&tglbill=' + tglbill + '&jenispasien=' + jenispasien
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
            $("#namatindakannew").select2();
        })
}

function getTindakanRI() {
    var base_url = window.location.origin;
    // var groupjaminan = $('#GroupJaminan').val();
    var IDKelas = $('#IDKelas').val();

    var tglbill = $('#dateabilling').val();
    var xdi = $('#IDUnit').val();
    var groupjaminan = $('#GroupJaminan').val();
    var noreg = $('#NoRegistrasi').val();
    var jenispasien = 'RI';
    // let url = base_url + '/SIKBREC/public/aBillingPasien/getTindakanRanap';
    let url = base_url + '/SIKBREC/public/aBillingPasien/gettarifnew';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'groupjaminan=' + groupjaminan 
        + '&IDKelas=' + IDKelas
        + '&tglbill=' + tglbill
        + '&xdi=' + xdi
        + '&jenispasien=' + jenispasien
        + '&noreg=' + noreg
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
            // $("#namatindakannew").select2();
        })
}

async function searchDokter(){
    try{
        var getreg = $("#NoRegistrasi").val().substring(0, 2);;
        if (getreg == 'RJ'){
            var datagetDataDokter =  await getDataDokterRJ();
            updateUIgetDataDokterNew(datagetDataDokter); 
        }else if (getreg == 'RI'){
            var datagetDataDokter =  await getDataDokterRI();
            updateUIgetDataDokterNew(datagetDataDokter); 
        }
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetDataDokterNew(datagetDataDokter) {
    let responseApi = datagetDataDokter;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);

        $("#dokterpemeriksanew").empty();
        var newRow = '<option value="">-- PILIH --</option>';
        $("#dokterpemeriksanew").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].First_Name + '</option>';
            $("#dokterpemeriksanew").append(newRow);
        }
    }
}

function getDataDokterRJ() {
    var base_url = window.location.origin;
    var tglnow = $('#TglMasuk').val();
    const days = getWeekdays(tglnow);
    var xdi = $('#IDUnit').val();
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
            $("#dokterpemeriksanew").select2();
        })
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

function getDataDokterRI() {
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
            $("#dokterpemeriksanew").select2();
        })
    }

    async function getTarifDetail(param){
        try{
            var val = $(param).val();
            var getreg = $("#NoRegistrasi").val().substring(0, 2);;
            if (getreg == 'RJ'){
                var datagetTarifTindakanRajal =  await getTarifTindakanRJ(val);
                updateUIgetDataTarifDetail(datagetTarifTindakanRajal); 
            }else if (getreg == 'RI'){
                var datagetTarifTindakanRanap =  await getTarifTindakanRI(val);
                updateUIgetDataTarifDetail(datagetTarifTindakanRanap); 
            }
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetDataTarifDetail(datagetTindakan) {
        let responseApi = datagetTindakan;
        // console.log(datagetTindakan);
        if (responseApi.data !== null && responseApi.data !== undefined) {
           // console.log(responseApi.data);
            $("#hargatarifnew").val(convertEntities(responseApi.data.GetTarif));
            $("#tindakannew").val(convertEntities(responseApi.data.ProductName));
            $("#kategorinewproduct").val(convertEntities(responseApi.data.CategoryProduct));
            $("#idtrstariftdk").val(convertEntities(responseApi.data.ID_TR_TARIF));
            
            $("#qty_addvisitnew").val('1');
            
        }
    }
    
    function getTarifTindakanRJ(val) {
        var base_url = window.location.origin;
        var tarifvalue = val;
        // var tglnow = val;
        var tglbill = $('#dateabilling').val();
        var xdi = $('#IDUnit').val();
        var groupjaminan = $('#GroupJaminan').val();
        var jenispasien = 'RJ';
        let url = base_url + '/SIKBREC/public/aBillingPasien/gettarifdetailnew';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'tarifvalue=' + tarifvalue + 
            '&tglbill=' + tglbill +
            '&idunit=' + xdi +
            '&groupjaminan=' + groupjaminan +
            '&jenispasien=' + jenispasien
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
                // $("#namatindakan").select2();
            })
    }
    
    function getTarifTindakanRI(val) {
        var base_url = window.location.origin;
        var IDKelas = $('#IDKelas').val();
        let url = base_url + '/SIKBREC/public/aBillingPasien/getTarifTindakanRanap';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'IDKelas=' + IDKelas + '&id=' + val
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
                $("#namatindakan").select2();
            })
    }

    async function getDokterdetail(param){
        try{
            var val = $(param).val();
                var datagetDokterbyid =  await getDokterbyid(val);
                updateUIgetDokterbyidDetail(datagetDokterbyid);
        } catch (err) {
            toast(err, "error")
        }
    }
    function getDokterbyid(val) {
        var base_url = window.location.origin;
        var iddokter = val;
        let url = base_url + '/SIKBREC/public/aBillingPasien/getdokterdetailnew';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'iddokter=' + iddokter
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
                // $("#namatindakan").select2();
            })
    }

    function updateUIgetDokterbyidDetail(datagetDokterbyid) {
        let responseApi = datagetDokterbyid;
            $("#dokternew").val(convertEntities(responseApi.data.First_Name));
    }

    async function BtnNewInput(id){
        try{
            // $(".preloader").fadeIn();
            var tglbill = $('#dateabilling').val();
            if (tglbill == '') {
                toast("Warning! Isi tanggal billing terlebih dahulu", 'warning');
                return false;
            }
            var timebill = $('#timeabilling').val();
            if (timebill == '') {
                toast("Warning! Isi jam terlebih dahulu", 'warning');
                return false;
            }
            else{
                var datagetNoTrsBilling =  await getNoTrsBilling(id);
                updateUIgetNoTrsBilling(datagetNoTrsBilling);
            }
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetNoTrsBilling(datagetNoTrsBilling) {
        let responseApi = datagetNoTrsBilling;
        $("#Idbilling").val(convertEntities(responseApi.data.notrsbill));
        $("#namatindakannew").attr('disabled', false);
        $("#dokterpemeriksanew").attr('disabled', false);
        $("#qty_addvisitnew").attr('disabled', false);
        $("#btnaddtindakanx").attr('disabled', false);
        $("#btnSaveAll").attr('disabled', false);
        $("#tbtnhdradd").attr('disabled', true);
        searchTindakan();
        searchDokter();
    }
    
    function getNoTrsBilling(id) {
        var base_url = window.location.origin;
        var tglbill = $('#dateabilling').val();
        var tglbill2 = $('#dateabilling').val()+ ' ' + $('#timeabilling').val(); 
        var timeabilling = $('#timeabilling').val();
        var NoRegistrasi = $('#NoRegistrasi').val();
        var NoEpisode = $('#NoEpisode').val();
        var NoMR = $('#NoMR').val();
        var GroupJaminan = $('#TypePatientID').val();
        var penjamin_kode = $('#penjamin_kode').val();
        var IDUnit = $('#IDUnit').val();
        var kodereg = $("#NoRegistrasi").val().slice(0, 2);

        let url = base_url + '/SIKBREC/public/aBillingPasien/newInsertFO';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body:
            'ID=' + id 
            + '&tglbill=' + tglbill 
            + '&NoRegistrasi=' + NoRegistrasi 
            + '&NoEpisode=' + NoEpisode 
            + '&NoMR=' + NoMR 
            + '&GroupJaminan=' + GroupJaminan 
            + '&penjamin_kode=' + penjamin_kode 
            + '&IDUnit=' + IDUnit 
            + '&timeabilling=' + timeabilling  
            + '&tglbill2=' + tglbill2  
            + '&kodereg=' + kodereg  

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

    async function BtnNewInputedit(id){
        try{
            $(".preloader").fadeIn();
            var tglbill = $('#dateabilling').val();
            if (tglbill == '') {
                toast("Warning! Isi tanggal billing terlebih dahulu", 'warning');
                return false;
            }
            else{
                var datagetNoTrsBillingedit =  await getNoTrsBillingedit(id);
                updateUIgetNoTrsBillingedit(datagetNoTrsBillingedit);
            }
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetNoTrsBillingedit(datagetNoTrsBillingedit) {
        let responseApi = datagetNoTrsBillingedit;
        $("#Idbilling").val(convertEntities(responseApi.data.notrsbill));
        $("#namatindakannew").attr('disabled', false);
        $("#dokterpemeriksanew").attr('disabled', false);
        $("#qty_addvisitnew").attr('disabled', false);
        $("#btnaddtindakanx").attr('disabled', false);
        $("#btnSaveAll").attr('disabled', false);
        $("#tbtnhdradd").attr('disabled', true);
        searchTindakan();
        searchDokter();
    }
    
    function getNoTrsBillingedit(id) {
        var base_url = window.location.origin;
        var tglbill = $('#dateabilling').val();
        var tglbill2 = $('#dateabilling').val()+ ' ' + $('#timeabilling').val(); 
        var timeabilling = $('#timeabilling').val();
        var NoRegistrasi = $('#NoRegistrasi').val();
        var NoEpisode = $('#NoEpisode').val();
        var NoMR = $('#NoMR').val();
        var GroupJaminan = $('#TypePatientID').val();
        var penjamin_kode = $('#penjamin_kode').val();
        var IDUnit = $('#IDUnit').val();
        var kodereg = $("#NoRegistrasi").val().slice(0, 2);
        
        let url = base_url + '/SIKBREC/public/aBillingPasien/newInsertFO';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body:
            'ID=' + id + 'tglbill=' + tglbill + '&NoRegistrasi=' + NoRegistrasi 
            + '&NoEpisode=' + NoEpisode 
            + '&NoMR=' + NoMR 
            + '&GroupJaminan=' + GroupJaminan 
            + '&penjamin_kode=' + penjamin_kode 
            + '&IDUnit=' + IDUnit 
            + '&timeabilling=' + timeabilling  
            + '&tglbill2=' + tglbill2  
            + '&kodereg=' + kodereg  

            
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

    async function BtnNewInputBill(){
        try{
            var NO_TRS_BILLING = $('#Idbilling').val();
            var KODE_TARIF = document.getElementById("namatindakannew").value;
            var KD_DR = document.getElementById("dokterpemeriksanew").value;
            var idtrstariftdk = document.getElementById("idtrstariftdk").value;
            var QTY = $('#qty_addvisitnew').val();
            if (NO_TRS_BILLING == '' || KODE_TARIF =='' || KD_DR == '' || QTY ==''|| idtrstariftdk =='') {
                toast("Warning! Periksa kembali pastikan data sudah terisi", 'warning');
                return false;
            }
            else{
                var datagetNoTrsBilling =  await getinsertbill();
                updateUIgetinsertbill(datagetNoTrsBilling);
            }
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetinsertbill(datagetNoTrsBilling) {
        let responseApi = datagetNoTrsBilling;
        // $("#Idbilling").val(convertEntities(responseApi.data.notrsbill));
        showdatafobill();
    }
    
    function getinsertbill() {
        var base_url = window.location.origin;

        var NO_TRS_BILLING = $('#Idbilling').val();
        var TGL_BILLING = $('#dateabilling').val()+ ' ' + $('#timeabilling').val();
        var NO_MR = $('#NoMR').val();
        
        
        var NO_REGISTRASI = $('#NoRegistrasi').val();
        var NO_EPISODE = $('#NoEpisode').val();
        
        var GROUP_JAMINAN =  $('#TypePatientID').val();
        var KODE_JAMINAN = $('#penjamin_kode').val();
        var UNIT = $('#IDUnit').val();

        var KODE_TARIF = document.getElementById("namatindakannew").value;
        var NILAI_TARIF = $('#hargatarifnew').val(); 
        var NAMA_TARIF = $('#tindakannew').val();

        var QTY = $('#qty_addvisitnew').val();
        var NAMA_TARIF = $('#tindakannew').val();
        var GROUP_ENTRI = 'RAJAL';
        
        var GROUP_TARIF = $('#kategorinewproduct').val();
        

        var KD_DR = document.getElementById("dokterpemeriksanew").value;
        var NM_DR = $('#dokternew').val();

        var KDREG = $("#NoRegistrasi").val().slice(0,2);

        var idtrstariftdk = document.getElementById("idtrstariftdk").value;

        let url = base_url + '/SIKBREC/public/aBillingPasien/newInsertBill';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 
            'NO_TRS_BILLING=' + NO_TRS_BILLING
            + '&TGL_BILLING=' + TGL_BILLING
            + '&NO_MR=' + NO_MR
            + '&NO_EPISODE=' + NO_EPISODE
            + '&NO_REGISTRASI=' + NO_REGISTRASI 
            + '&UNIT=' + UNIT
            + '&GROUP_JAMINAN=' + GROUP_JAMINAN 
            + '&KODE_JAMINAN=' + KODE_JAMINAN 

            + '&NAMA_TARIF=' + NAMA_TARIF 
            + '&NILAI_TARIF=' + NILAI_TARIF 
            
            + '&KODE_TARIF=' + KODE_TARIF 

            + '&QTY=' + QTY 
            + '&GROUP_TARIF=' + GROUP_TARIF
            + '&KD_DR=' + KD_DR 
            + '&NM_DR=' + NM_DR 
            + '&GROUP_ENTRI=' + GROUP_ENTRI  
            + '&KDREG=' + KDREG  
            + '&idtrstariftdk=' + idtrstariftdk
            
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
                // $("#namatindakan").select2();
            })
    }

    function showdatafobill() {
         total_items = 0;
        var dataHandler = $("#user_datas");
        dataHandler.html("");
        var NoTRS = $("#Idbilling").val();
        var base_url = window.location.origin;
        var url2 = "/SIKBREC/public/aBillingPasien/showDatafoBill";

        $.ajax({
            type: "POST",
            data: "NoTRS=" + NoTRS,
            url: base_url + url2,
            success: function (result) {
               

              
                var resultObj = JSON.parse(result);
                console.log(resultObj);
                $.each(resultObj, function (key, val) {
                    total_items = total_items + 1;

                    // console.log(val.KLAIM);
                    // return false;

                    if (val.KLAIM == '0') {
                        var html = `<td><button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="deleteDataGroupShift('${val.ID }')" ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="editDataGroupShift('${val.ID }','${val.KODE_TARIF }')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="Btnklaim('${val.ID }','${val.KEKURANGAN }')" ><span class="visible-content" >Klaim</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button></td>`
                    } else {
                        var html = `<td><button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="deleteDataGroupShift('${val.ID }')" ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="editDataGroupShift('${val.ID }','${val.KODE_TARIF }')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="BtnUnklaim('${val.ID }','${val.KLAIM }')" ><span class="visible-content" >Unklaim</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button></td>`
                    }
                   
                    var newRow = $("<tr id='row_'" + total_items + "'>");
                    /*1*/  newRow.html("<td><font size='1'>" + total_items + "</td>'"+
                    /*2*/ "'<td>" + val.ID +"<input type='hidden' name='hidden_id[]' id='hidden_id'" + total_items + "' class='hidden_id'"+total_items + "' value='" + val.ID +"' ></font></td> '"+
                    /*3*/"'<td><font size='1'>" + val.NAMA_TARIF + "<input type='hidden'  name='hidden_nama_tarif_[]' id='hidden_nama_tarif_'" + total_items + "' value='" + val.NAMA_TARIF +"' ></font></td>'"+
                    /*4*/"'<td><font size='1'>" + val.NM_DR + "<input type='hidden'  name='hidden_nama_tarif_[]' id='hidden_nama_tarif_'" + total_items + "' value='" + val.NM_DR +"' ></font></td>'"+
                    /*5*/"'<td><font size='1'>" + val.TGL_BILLING + "<input type='hidden'  name='hidden_nama_tarif_[]' id='hidden_nama_tarif_'" + total_items + "' value='" + val.TGL_BILLING +"' ></font></td>'"+
                    /*6*/"' <td><input  size='5'  type='text' onkeyup='calculateAllDetail()'  name='hidden_qty_[]' id='hidden_qty_" + total_items + "' value='" + val.QTY +"' ></td> '"+
                    /*7*/"' <td><input size='15' readonly  type='text' name='hidden_harga_[]'   id='hidden_harga_" + total_items + "' class='harga' onkeyup='calculateAllDetail()' value='" + val.NILAI_TARIF + "' ></td> '"+
                    /*7b*/"' <td><input size='15'  type='text' name='hidden_subtotal_[]'   id='hidden_subtotal_" + total_items + "' class='date' value='"+val.SUB_TOTAL+"'  ></td> '"+
                    /*7c*/"' <td><input size='5'  type='text' name='hidden_diskon_[]'   id='hidden_diskon_" + total_items + "' class='hidden_nobatch_' value='"+val.DISC+"' ></td> '"+
                
                    /*8*/"' <td><input size='15' readonly value='" + val.SUB_TOTAL_2 + "' onkeyup='calculateAllDetail()' type='text' name='hidden_subtotal2_[]'   id='hidden_subtotal2_" + total_items +"' ></td>'"+

                    /*9*/"' <td><input size='10' readonly value='" + val.GROUP_ENTRI + "' onkeyup='calculateAllDetail()' type='text' name='GROUP_ENTRI_[]'   id='GROUP_ENTRI_" + total_items +"' ><input size='1' readonly value='" + val.KODE_TARIF + "' onkeyup='calculateAllDetail()' type='hidden' name='KODE_TARIF_[]'   id='KODE_TARIF_" + total_items +"' ><input size='1' readonly value='" + val.KODE_REF + "' onkeyup='calculateAllDetail()' type='hidden' name='KODE_REF_[]'   id='KODE_REF_" + total_items +"' ></td>'"+

                    html

                // /*9*/"<td> <button type='button' onclick=deleteDataGroupShift('" + val.ID + "') name='remove_details' class='btn btn-warning btn-xs remove_details' id='" + total_items + "' >Delete</Hapus> " + 
                + " </tr>");

                console.log("total_items",newRow);
                dataHandler.append(newRow);
            });
        }
        });

    }

    async function btnGantiTarif(){
        // var x = document.getElementById("tbl_Tarif_ganti");
        // if (x.style.display === "none") {
        //     x.style.display = "block";
        //   } else {
        //     x.style.display = "none";
        //   }
        //   getTarifChanger();
        // changetarifbill();
        try{
            var datachangetarifbill =  await changetarifbill();
            updateUIdatachangetarifbill(datachangetarifbill);
        } catch (err) {
            toast(err, "error")
        }
    }
    function changetarifbill(){
        var data = $("#detail_fo_bill, #form_tindakan_new").serialize();
        var groupjaminan = $('#xgrupjaminan').val();
        var GROUP_JAMINANNO =  $('#TypePatientID').val();
        var penjamin_kodex =  $('#penjamin_kode').val();
        var ID_UNIT = $('#IDUnit').val();
        // console.log(penjamin_kodex);
        // return false;
    
        var url2 = "/SIKBREC/public/aBillingPasien/changeBillingJaminan";
        var base_url = window.location.origin;
        let url = base_url + url2;
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: data 
            +"&groupjaminan="+groupjaminan
            +"&GROUP_JAMINANNO="+GROUP_JAMINANNO
            +"&penjamin_kodex="+penjamin_kodex
            +"&ID_UNIT="+ID_UNIT
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
                    throw new Error(response.message);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                $(".preloader").fadeOut();
            })
    }
    
    
    function updateUIdatachangetarifbill(datachangetarifbill) {
        let responseApi = datachangetarifbill;
            swal("Terima Kasih",  "Transaksi berhasil : ", "success")
        showdatafobill();
    }

    async function Btnklaim(id, kekurangan){
        try{
               var datagetklaim =  await getklaim(id, kekurangan);
               updateUIgetklaim(datagetklaim);
       } catch (err) {
           toast(err, "error")
       }
   }
   
   function updateUIgetklaim(datagetklaim) {
    //    let responseApi = datagetklaim;
       showdatafobill();
   }
   
   function getklaim(id, kekurangan) {
        var base_url = window.location.origin;
        var Idfo1 = id;
        var ValueKekurangan = kekurangan;
        var Notrs = $('#Idbilling').val();
        var Noreg = $('#NoRegistrasi').val();

       let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateKlaimbyFO1';
       return fetch(url, {
           method: 'POST',
           headers: {
               "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
           },
           body: 
           'Idfo1=' + Idfo1
           + '&ValueKekurangan=' + ValueKekurangan
           + '&Notrs=' + Notrs
           + '&Noreg=' + Noreg
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
               // $("#namatindakan").select2();
           })
   }


   async function BtnUnklaim(id, klaim){
    try{
           var datagetunklaim =  await getunklaim(id, klaim);
           updateUIgetunklaim(datagetunklaim);
   } catch (err) {
       toast(err, "error")
   }
}

function updateUIgetunklaim(datagetunklaim) {
//    let responseApi = datagetklaim;
   showdatafobill();
}

function getunklaim(id, klaim) {
   var base_url = window.location.origin;
   var Idfo1 = id;
   var ValueKlaim = klaim;
   var Notrs = $('#Idbilling').val();
   var Noreg = $('#NoRegistrasi').val();

   let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateUnklaimbyFO1';
   return fetch(url, {
       method: 'POST',
       headers: {   
           "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
       },
       body: 
       'Idfo1=' + Idfo1
       + '&ValueKlaim=' + ValueKlaim
       + '&Notrs=' + Notrs
       + '&Noreg=' + Noreg
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
           // $("#namatindakan").select2();
       })
}

    async function deleteDataGroupShift(params){
         try{
                var datagetupdatebillfo1 =  await getupdatebillfo1(params);
                updateUIgetupdatebillfo1(datagetupdatebillfo1);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetupdatebillfo1(datagetupdatebillfo1) {
        let responseApi = datagetupdatebillfo1;
        showdatafobill();
    }
    
    function getupdatebillfo1(params) {
        var base_url = window.location.origin;
        var Idfo1 = params;
        var Notrs = $('#Idbilling').val();
        var Noreg = $('#NoRegistrasi').val();

        let url = base_url + '/SIKBREC/public/aBillingPasien/updateBatalBill';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 
            'Idfo1=' + Idfo1
            + '&Notrs=' + Notrs
            + '&Noreg=' + Noreg
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
                // $("#namatindakan").select2();
            })
    }


    async function BtnNewSaveBill(){
        try{
                var datagetsavebill =  await getsavebill();
                updateUIgetsavebill(datagetsavebill);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetsavebill(datagetsavebill) {
        // let responseApi = datagetsavebill;
            swal("Terima Kasih",  "Transaksi penambahan tindakan berhasil : ", "success")
        .then((result) => {
                    if(result) {
                        // ok click
                        console.log("benar");
                        $("#modaltindakanbyorderOperasi").modal('hide');
                    } else {
                        // not clicked
                    }
                });
    }
    
    function getsavebill() {
        var base_url = window.location.origin;
        var Noreg = $('#NoRegistrasi').val();

        let url = base_url + '/SIKBREC/public/aBillingPasien/saveDataBill';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body:
            'Noreg=' + Noreg
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
                // $("#namatindakan").select2();
            })
    }

    async function editDataGroupShift(params,KODE_TARIF){
        try{
                var datagetshowbill2 =  await getshowbill2(params,KODE_TARIF);
                updateUIgetshowbill2(datagetshowbill2,KODE_TARIF);
        } catch (err) {
            toast(err, "error")
        }
    }
    
    function updateUIgetshowbill2(datagetshowbill2,KODE_TARIF) {
        let responseApi = datagetshowbill2;
            $("#Idbillingfo1").val(convertEntities(responseApi.data.ID));
            $("#NoTRSBill1").val(convertEntities(responseApi.data.NO_TRS_BILLING));
            $("#tgltransaksi").val(convertEntities(responseApi.data.TGL_BILLING));
            $("#KodeTarifBill").val(convertEntities(responseApi.data.KODE_TARIF));
            $("#NamaTarifBill").val(convertEntities(responseApi.data.NAMA_TARIF));
            $("#TotalTarifBill").val(convertEntities(responseApi.data.GRANDTOTAL));

            showDataGroupShiftFO2(KODE_TARIF);
            $("#modaltindakanbyorderOperasi").modal('hide');
            $("#modaltablefo2").modal('show');
    }
    
    function getshowbill2(params,KODE_TARIF) {
        var base_url = window.location.origin;
        var idfo1 = params;

        let url = base_url + '/SIKBREC/public/aBillingPasien/showUpdateBillByFO1';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body:
            'idfo1=' + idfo1+'&KODE_TARIF=' + KODE_TARIF
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
                // $("#namatindakan").select2();
            })
    }


    async function showDataGroupShiftFO2(KODE_TARIF) {
        const base_url = window.location.origin;

        var notrsbillfo1 = $('#NoTRSBill1').val();
        
        // var tglbillfo1 = $('#tgltransaksi').val();

        $(".preloader").fadeOut();
        $('#tbl_fo_bill_2').dataTable({
            "bDestroy": true
        }).fnDestroy();
        $('#tbl_fo_bill_2').DataTable({
            "ordering": true,
            "ajax": {
                "url": base_url + "/SIKBREC/public/aBillingPasien/showDataBillFO2",
                "dataSrc": "",
                "deferRender": true,
                "type": "POST",
                data: function (d) {
                    d.notrsbillfo1 = notrsbillfo1
                    d.KODE_TARIF = KODE_TARIF
                    // d.tglbillfo1 = tglbillfo1
                },
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
                        var html = '<font size="1"> ' + row.KODE_KOMPONEN_TARIF + '<br>' + '(' + row.JasaBill + ')' +'</font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.QTY) + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.SUB_TOTAL) + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.NILAI_PROSEN) + ' </font>  ';
                        return html
                    }
                },

                // { "data": "Grandtotal" ,  render: $.fn.dataTable.render.number( ',', '.', 2,'Rp ' )},
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.NILAI_PDP) + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.NILAI_DISKON_PDP) + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + parseFloat(row.SUB_TOTAL_2) + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                        // var html = '<button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="deleteDataGroupShiftbyfo2(' + row.ID + ')" ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="editDataGroupShiftfo2(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                        var html = `<button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="deleteDataGroupShiftbyfo2('${row.ID }')" ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="editDataGroupShiftbyfo2('${row.ID }','${row.KODE_TARIF }','${row.NAMA_TARIF }','${row.NILAI_TARIF }','${row.QTY }','${row.NILAI_DISKON_PDP }','${row.NILAI_PDP }','${row.KODE_KOMPONEN_TARIF}','${row.NILAI_PROSEN}')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>`
                        return html
                    },
                },
            ]
        });
    }

    async function deleteDataGroupShiftbyfo2x(params){
        try{
               var datagetupdatebillfo2 =  await getupdatebillfo2(params);
               updateUIgetupdatebillfo2(datagetupdatebillfo2);
       } catch (err) {
           toast(err, "error")
       }
   }
   
   function updateUIgetupdatebillfo2x(datagetupdatebillfo2) {
       let responseApi = datagetupdatebillfo2;
       var KODE_TARIF = $('#kodetarif_fo2').val();
       showDataGroupShiftFO2(KODE_TARIF);
   }
   
   function getupdatebillfo2x(params) {
       var base_url = window.location.origin;
       var Idfo2 = params;
       // var Noreg = $('#NoRegistrasi').val();

       let url = base_url + '/SIKBREC/public/aBillingPasien/updateBatalBillfo2';
       return fetch(url, {
           method: 'POST',
           headers: {
               "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
           },
           body: 
           'Idfo2=' + Idfo2
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
               // $("#namatindakan").select2();
           })
   }

   async function deleteDataGroupShiftbyfo2(params){
    try{
           var datagetupdatebillfo2 =  await getupdatebillfo2(params);
           updateUIgetupdatebillfo2(datagetupdatebillfo2);
   } catch (err) {
       toast(err, "error")
   }
}

function updateUIgetupdatebillfo2(datagetupdatebillfo2) {
   let responseApi = datagetupdatebillfo2;
   var KODE_TARIF = $('#kodetarif_fo2').val();
   showDataGroupShiftFO2(KODE_TARIF);
}

function getupdatebillfo2(params) {
   var base_url = window.location.origin;
   var Idfo2 = params;
   var Notrs = $('#NoTRSBill1').val();
   var Idfo1 = $('#Idbillingfo1').val();
   var Noreg = $('#NoRegistrasi').val();

   let url = base_url + '/SIKBREC/public/aBillingPasien/updateBatalBillfo2';
   return fetch(url, {
       method: 'POST',
       headers: {
           "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
       },
       body: 
       'Idfo2=' + Idfo2
       + '&Notrs=' + Notrs
       + '&Idfo1=' + Idfo1
       + '&Noreg=' + Noreg
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
           // $("#namatindakan").select2();
       })
}

async function editDataGroupShiftbyfo2(id,kode,namatarif_fo2,NILAI_TARIF,QTY, NILAI_DISKON_PDP, NILAI_PDP, KODE_KOMPONEN_TARIF, NILAI_PROSEN){
    $("#qty_fo2").attr('disabled', false);
    $("#diskon_fo2").attr('disabled', false);
    $("#btnupfo2update").attr('disabled', false);

    $("#id_fo2").val(convertEntities(id));
    $("#komponenName").val(convertEntities(KODE_KOMPONEN_TARIF));
    $("#kodetarif_fo2").val(kode);
    $("#namatarif_fo2").val(namatarif_fo2);
    // $("#nilai_fo2").val(NILAI_TARIF);
    $("#qty_fo2").val(number_to_price(QTY));
    $("#diskon_fo2").val(parseFloat(NILAI_DISKON_PDP) * 100);
    $("#nilai_fo2").val(number_to_price(NILAI_TARIF));
    $("#nilaipdp_fo2").val(number_to_price(NILAI_PDP));
    $("#nilaiprosen_fo2").val(parseFloat(NILAI_PROSEN));
}

async function BtnCLoseClear(){
    $("#id_fo2").val('');
    $("#komponenName").val('');
    $("#kodetarif_fo2").val('');
    $("#namatarif_fo2").val('');
    $("#qty_fo2").val('');
    $("#diskon_fo2").val('');
    $("#nilai_fo2").val('');
    $("#nilaipdp_fo2").val('');
    $("#nilaiprosen_fo2").val('');
}


async function BtnUpdateBillfo2(){
    var notrsfo2 = $('#kodetarif_fo2').val();
    var qtyfo2 = $('#qty_fo2').val();
    var diskonfo2 = $('#diskon_fo2').val();
    if(notrsfo2 == ''){
        toast('Silahkan Pilih orderan yang mau di edit', "warning");
        return false;
    }
    if(qtyfo2 == ''){
        toast('Silahkan Masukkan QTY orderan', "warning");
        return false;
    }
    if(diskonfo2 == ''){
        toast('Silahkan Masukkan Diskon orderan', "warning");
        return false;
    }
    try{
            var datagetsavebillfo2 =  await getsavebillfo2();
            updateUIgetsavebillfo2(datagetsavebillfo2);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetsavebillfo2(datagetsavebillfo2) {
    let responseApi = datagetsavebillfo2;
   
        swal("Terima Kasih",  "Transaksi penambahan tindakan berhasil : ", "success")
    .then((result) => {
                if(result) {
                    // ok click
                    console.log("benar");
                    var KODE_TARIF = $('#kodetarif_fo2').val();
                    showDataGroupShiftFO2(KODE_TARIF);
                    $("#id_fo2").val('');
                    $("#komponenName").val('');
                    $("#kodetarif_fo2").val('');
                    $("#namatarif_fo2").val('');
                    $("#qty_fo2").val('');
                    $("#diskon_fo2").val('');
                    $("#nilai_fo2").val('');
                    $("#nilaipdp_fo2").val('');
                    $("#nilaiprosen_fo2").val('');
                    // $("#modaltindakanbyorderOperasi").modal('hide');
                } else {
                    // not clicked
                }
            });
}

function getsavebillfo2() {
    var base_url = window.location.origin;
    var id_fo1 = $('#Idbillingfo1').val();
    var id_fo2 = $('#id_fo2').val();
    var kodetarif_fo2 = $('#kodetarif_fo2').val();
    var NILAI_TARIFx = $('#nilai_fo2').val();
    var QTY = $('#qty_fo2').val();
    var DISC = $('#diskon_fo2').val() / 100;
    var NILAI_PDPx = $('#nilaipdp_fo2').val();
    var NoTRSBill1 = $('#NoTRSBill1').val();
    var Noreg = $('#NoRegistrasi').val();
    var TypePatientID = $('#TypePatientID').val();
    var NILAIPROSEN = $('#nilaiprosen_fo2').val();
    
    // DISCx = DISCx / 100;
    // console.log(DISCx);
    // exit;
    // var DISC = DISCx.replace(",", "");
    // var NILAIPROSEN = NILAIPROSENx.replace(/,/g, '.');
    var NILAI_PDP = NILAI_PDPx.replace(".", "");
    var NILAI_TARIF = NILAI_TARIFx.replace(".", "");
    // console.log(NILAI_PDPx);
    // console.log(NILAIPROSEN);
    // return false;

    let url = base_url + '/SIKBREC/public/aBillingPasien/getsavebillfo2';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'id_fo2=' + id_fo2 
        +'&NILAI_TARIF=' + NILAI_TARIF 
        + '&QTY=' + QTY 
        +'&DISC=' + DISC 
        +'&kodetarif_fo2=' + kodetarif_fo2 
        +'&NILAI_PDP=' + NILAI_PDP
        +'&NoTRSBill1=' + NoTRSBill1
        +'&Noreg=' + Noreg
        +'&TypePatientID=' + TypePatientID
        +'&id_fo1=' + id_fo1
        +'&NILAIPROSEN=' + NILAIPROSEN

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
            // $("#namatindakan").select2();
        })
}
function getDataHutangKabur() { 
    //$(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();

    // console.log(noreg);
    // console.log(nomr);
    // return false;

    $('#tbl_PasienKabur').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbl_PasienKabur').DataTable({
        'ajax':
    {
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataHutangKabur", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.noreg = noreg
         d.nomr = nomr
        //  d.tglawal = tglawal
        //  d.tglakhir = tglakhir
        //  d.NoMR = NoMR

     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [

                            { "data": "No" },
                            { "data": "NO_REGISTRASI" },
                            { "data": "TGL_BILLING" },
                            { "data": "KEKURANGAN" },
                            ],
});
}

async function BtnTransferBill(){
    try{
            var datasetTransferBill =  await setTransferBill();
            updateUIsetTransferBill(datasetTransferBill);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIsetTransferBill(datasetTransferBill) {
    let responseApi = datasetTransferBill;
        swal("Terima Kasih",  "Transaksi Transfer Hutang Berhasil", "success")
        .then((result) => {
                if(result) {
                    console.log("benar");
                } else {
                    // not clicked
                }
            });
    $("#TransferBill_Kabur").modal('hide');
    btnrRefershTable();
}

function setTransferBill() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    let url = base_url + '/SIKBREC/public/aBillingPasien/transferBillPasienHutang';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'nomr=' + nomr 
        +'&noreg=' + noreg 
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
            // $("#namatindakan").select2();
        })
}

function getDataDetailRincianHutang() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
        $('#tbl_rincianhutang').DataTable().clear().destroy();
        $('#tbl_rincianhutang').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailRincianHutang", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
                d.nomr = nomr
                // d.tglawal = tglawal
                // d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "NO_TRS_BILLING" },
            { "data": "ID" },
            { "data": "NO_REGISTRASI" },
            { "data": "TGL_BILLING" }, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                html = `${row.NAMA_TARIF} <br>  ${row.NM_DR}`;
                 return html 
              }
            },
            { "data": "NamaUnit" },
            { "data": "KD_KELAS" }, 
            { "data": "QTY" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "NILAI_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "DISC_RP" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "GRANDTOTAL" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KLAIM" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KEKURANGAN" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )}, 
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                    //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                       var html  = '<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>'
                          return html 
                   }
            },
           ],
         "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

                totadisc = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                 total3 = api
                 .column( 10 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalklaim = api
                 .column( 11 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalkekurangan = api
                 .column( 12 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                 
                 totalbayar = api
                 .column( 13 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                

             // Update footer
                $( api.column( 9 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totadisc )
                );
                $( api.column( 10 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );
                $( api.column( 11 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalklaim )
                );
                $( api.column( 12 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalkekurangan )
                );
                $( api.column( 13 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalbayar )
                );

            //  $("#grandTotalHutang").val(total3);

            //  $("#grandTotalHutang").text(number_to_price(total3));
             $("#grandTotalHutanginput").val(total3);

            //  $("#grandTotalHutangklaim").text(number_to_price(totalklaim));
             $("#grandTotalHutanginputklaim").val(totalklaim);

            //  $("#grandTotalHutangbayar").text(number_to_price(totalbayar));
             $("#grandTotalHutanginputbayar").val(totalbayar);


            //  $("#T_Tagihan").val(number_to_price(total3));
             
            //  $("#tblRincian_klaim").val(number_to_price(totalklaim)); 
            //  $("#T_Klaim").val(number_to_price(totalklaim));
            //  $("#T_Kekurangan").val(number_to_price(totalkekurangan)); 
            //  $("#tblRincian_bayar").val(number_to_price(totalbayar));
            //  $("#T_Bayar").val(number_to_price(totalbayar));
            //  $("#T_SisaBayar").val(number_to_price(total3-totalbayar));
            //  $("#T_DiskonGlobal").val(number_to_price(totadisc));
            //  $("#T_GrandTotal").val(number_to_price(total3));

            //  $("#tax").val('0');
            //  $("#tax2").val('0');
         },
       });
       
}

async function btnrRefershTable(){
    getDataDetailBilling();
    getDataDetailRincianHutang();
    getDataRekapBiaya();
    getDataRiwayatPayment();
}

// async function getCekHutang(){

//     $("#TransferBill_Kabur").modal('show');
// }

async function getCekHutang(){
    try{
            var datagetCekHutangx =  await getCekHutangx();
            updateUIgetCekHutangx(datagetCekHutangx);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetCekHutangx(datasetTransferBill) {
    let responseApi = datasetTransferBill;
    console.log(responseApi);
    if(responseApi != '0'){
        $("#TransferBill_Kabur").modal('show');
    }
}

function getCekHutangx() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    // console.log(noreg);
    let url = base_url + '/SIKBREC/public/aBillingPasien/getCekHutangPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'nomr=' + nomr 
        +'&noreg=' + noreg
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
            // $("#namatindakan").select2();
        })
}



async function getTotalPembayaran(){
//subtotal
    var totalHutang = $("#grandTotalHutanginput").val();
    var totalBill = $("#grandTotalBillPerawataninput").val();
    var totalHutang = parseFloat(price_to_number(totalHutang));
    var totalBill = parseFloat(price_to_number(totalBill));
    var subtotal = totalHutang + totalBill;
    $("#subTotal1").text(number_to_price(subtotal));
    $("#subTotal1input").val(subtotal);

//grandtotal
    // var administrasi = $("#grandTotalHutanginput").val();
    // var biayamaterai = $("#grandTotalBillPerawataninput").val();
    var administrasi = '50000';
    var biayamaterai = '10000';
    var administrasi = parseFloat(price_to_number(administrasi));
    var biayamaterai = parseFloat(price_to_number(biayamaterai));
    $("#administrasi").text(number_to_price(administrasi));
    $("#biayamaterai").text(number_to_price(biayamaterai));
    var grandtotal = administrasi + biayamaterai + subtotal;
    $("#grandTotal1").text(number_to_price(grandtotal));
    $("#grandTotal1input").val(grandtotal);

//totalpembayaran
    var totalHutangbayar = $("#grandTotalHutanginputbayar").val();
    var totalBillbayar = $("#grandTotalBillPerawataninputbayar").val();
    var totalHutangbayar = parseFloat(price_to_number(totalHutangbayar));
    var totalBillbayar = parseFloat(price_to_number(totalBillbayar));
    var totalpembayaran = totalHutangbayar + totalBillbayar;
    $("#totalpembayaran1").text(number_to_price(totalpembayaran));
    $("#totalpembayaran1input").val(totalpembayaran);

    var totalDeposit = $("#totaldepositinput").val();
    console.log(totalDeposit);
    exit;
    var totalDeposit = parseFloat(price_to_number(totalDeposit));
    var grandTotalpembayaran = totalpembayaran + totalDeposit;
    $("#grandTotalpembayaran1").text(number_to_price(grandTotalpembayaran));
    $("#grandTotalpembayaran1input").val(grandTotalpembayaran);

}

async function getTotalPembayaranx(){
    try {   
        const datagetTotalPembayaranx = await getTotalPembayaranxx();
        updateUIdatagetTotalPembayaranx(datagetTotalPembayaranx);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetTotalPembayaranx(datagetTotalPembayaranx) {
    let dataresponse = datagetTotalPembayaranx;

    console.log(dataresponse);
    // 1
    $("#grandTotalHutang").text(number_to_price(dataresponse.data.TOTALHUTANG));
    // 2
    $("#grandTotalBillPerawatan").text(number_to_price(dataresponse.data.TOTALBILL));
    // SUB TOTAL
    // var hutang = dataresponse.data.TOTALHUTANG;
    // var billperawatan = dataresponse.data.TOTALBILL;
    // var subtotal = hutang + billperawatan;
    $("#subTotal1").text(number_to_price(dataresponse.data.TOTALSUBTOTAL));
    // 3
    $("#administrasi").text(number_to_price(dataresponse.data.TOTALADMIN));
    // 4
    $("#biayamaterai").text(number_to_price(dataresponse.data.TOTALMATERAI));
    // GRAND TOTAL
    $("#grandTotal1").text(number_to_price(dataresponse.data.TOTALGRANDTOTAL));
    // 5
    $("#totalpembayaran1").text(number_to_price(dataresponse.data.TOTALTERBAYAR));
    // 6
    $("#totaldeposit").text(number_to_price(dataresponse.data.TOTALDEPOSIT));
    // TOTAL PEMBAYARAN
    $("#grandTotalpembayaran1").text(number_to_price(dataresponse.data.TOTALPEMBAYARAN));
    // YANG HARUS DIBAYAR
    $("#yangharusdibayarkan1").text(number_to_price(dataresponse.data.TOTALHARUSDIBAYAR));
    // PENGEMBALIAN
    $("#pengembalian1").text(number_to_price(dataresponse.data.TOTALPENGEMBALIAN));

    // $("#totaldepositinput").val(dataresponse.data.TOTALDEPOSIT);
    // $("#totaldeposit").text(number_to_price(dataresponse.data.TOTALDEPOSIT));
    // $("#totalpengembalianinput").val(dataresponse.data.TOTALPENGEMBALIAN);
    // $("#totalpengembalian").text(number_to_price(dataresponse.data.TOTALPENGEMBALIAN));

    // var totalDeposit = dataresponse.data.TOTALDEPOSIT;
    // var totalpengembalian = dataresponse.data.TOTALPENGEMBALIAN;

    //subtotal
    // var totalHutang = $("#grandTotalHutanginput").val();
    // var totalBill = $("#grandTotalBillPerawataninput").val();
    // var totalHutang = parseFloat(price_to_number(totalHutang));
    // var totalBill = parseFloat(price_to_number(totalBill));
    // var subtotal = totalHutang + totalBill;
    // $("#subTotal1").text(number_to_price(subtotal));
    // $("#subTotal1input").val(subtotal);

//grandtotal
// var kodereg = $("#NoRegistrasi").val().slice(0,2);

// var administrasi = '0';
// var biayamaterai = '0';

    // if(kodereg == 'RI'){
    //     var administrasi = '50000';
    //     var biayamaterai = '10000';
    // }

    // var administrasi = parseFloat(price_to_number(administrasi));
    // var biayamaterai = parseFloat(price_to_number(biayamaterai));
    // $("#administrasi").text(number_to_price(administrasi));
    // $("#biayamaterai").text(number_to_price(biayamaterai));

    // var grandtotal = administrasi + biayamaterai + subtotal;
    // $("#grandTotal1").text(number_to_price(grandtotal));
    // $("#grandTotal1input").val(grandtotal);

//totalpembayaran
    // var totalHutangbayar = $("#grandTotalHutanginputbayar").val();
    // var totalBillbayar = $("#grandTotalBillPerawataninputbayar").val();
    // var totalHutangbayar = parseFloat(price_to_number(totalHutangbayar));
    // var totalBillbayar = parseFloat(price_to_number(totalBillbayar));
    // var totalpembayaran = totalHutangbayar + totalBillbayar;
    // $("#totalpembayaran1").text(number_to_price(totalpembayaran));
    // $("#totalpembayaran1input").val(totalpembayaran);

    // totalpembayaran = parseInt(totalpembayaran);
    // totalDeposit = parseInt(totalDeposit);
    // var grandTotalpembayaran = totalpembayaran + totalDeposit;
    // $("#grandTotalpembayaran1").text(number_to_price(grandTotalpembayaran));
    // $("#grandTotalpembayaran1input").val(grandTotalpembayaran);



// yang harus dibayarkan
    // var yangharusdibayarkan = grandtotal - grandTotalpembayaran;
    // yangharusdibayarkan = parseInt(yangharusdibayarkan);
    // if(totalpengembalian == 0){
    //     totalpengembalian1 = totalpengembalian;
    // }
    // else{
    //     totalpengembalian1 = parseInt(totalpengembalian);
    // }
    // yangharusdibayarkan = yangharusdibayarkan + totalpengembalian1;
    // $("#yangharusdibayarkan1").text(number_to_price(yangharusdibayarkan));
    // $("#yangharusdibayarkan1input").val(yangharusdibayarkan);

// pengembalian
    // var pengembalian = totalpengembalian;
    // $("#pengembalian1").text(number_to_price(pengembalian));
    // $("#pengembalian1input").val(pengembalian);

}

function getTotalPembayaranxx() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    // console.log(noreg);
    
    let url = base_url + '/SIKBREC/public/aBillingPasien/getTotalPembayaran';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'nomr=' + nomr 
        +'&noreg=' + noreg
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
            // $("#namatindakan").select2();
        })
}

// 20/08/2024

// mAlasanOpenBill

async function btnCloseOrOpenBill(){
    var Ket_btn_closeoropenbill = $("#Ket_btn_closeoropenbill").val();
    if (Ket_btn_closeoropenbill == 'Close') {
        $("#mAlasanOpenBill").modal('show');
        $("#AlasanOpen").val('');
    }else{
        btnCloseOrOpenBillNext();
    }
}

async function btnCloseOrOpenBillNext(){
    try{
        const dataSaveCloseOrOpenBill = await SaveCloseOrOpenBill();
        updateUIdataSaveCloseOrOpenBill(dataSaveCloseOrOpenBill);
        $("#mAlasanOpenBill").modal('hide');
    }catch (err) {
        toast(err.message, "error");
    }
}
function SaveCloseOrOpenBill() {
    var base_url = window.location.origin;

    var NoRegistrasi = $("#NoRegistrasi").val();
    var NoMR = $("#NoMR").val();
    var Ket_btn_closeoropenbill = $("#Ket_btn_closeoropenbill").val();
    var AlasanOpen = $("#AlasanOpen").val();

    let url = base_url + '/SIKBREC/public/aBillingPasien/setSaveCloseOrOpenBill';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'NoRegistrasi=' +  NoRegistrasi +
                '&Ket_btn_closeoropenbill=' + Ket_btn_closeoropenbill + 
                '&AlasanOpen=' + AlasanOpen + 
                '&NoMR=' + NoMR

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

function updateUIdataSaveCloseOrOpenBill(dataSaveCloseOrOpenBill) {
    let dataSaveOperasi = dataSaveCloseOrOpenBill;
    if (dataSaveOperasi.status == "success") {
        $(".preloader").fadeIn();
        swal(dataSaveOperasi.ket_respons,  "BERHASIL", "success");
        asyncShowMain();
        $(".preloader").fadeOut();

    }else{
        toast(response.message, "error")
    }
}

// 20/08/2024

async function btnGantiTombol(){
    $("#modaltindakanbyorderOperasi").modal('hide');
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

function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function Showmodalcetak (No){
    let dataresponse = No;
    $("#pkuitansi_notrs").val(convertEntities(dataresponse.data.NO_KWITANSI));
// console.log(dataresponse);
// return;
    var xNoreg = $('#NoRegistrasi').val(); 

    $("#notif_ShowTTD_Digital").modal('show');
}




async function viewsPDF(){
    try{
        var datagetviewsPDF =  await getviewsPDF();
        updateUIdatagetviewsPDF(datagetviewsPDF);
    } catch (err) {
        toast(err, "error")
    }
}

function getviewsPDF() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    // console.log(noreg);
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataDocumentPDF';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'nomr=' + nomr 
        +'&noreg=' + noreg
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
            // $("#namatindakan").select2();
        })
}

function updateUIdatagetviewsPDF(datagetviewsPDF) {
    let responseLink = datagetviewsPDF;
    window.open(responseLink.link_response);
}
//bridging materai
async function printkuitansidetail(no_trs) {
    var base_url = window.location.origin;
    // var base_urlx = window.location.origin;
    // var jeniscetak = 'PrintKuitansiDetail';
    // var notrs = $("#NoRegistrasi").val();
    // var kodereg = $("#NoRegistrasi").val().slice(0, 2);
    // var lang = no_trs;
    $("#notif_ShowTTD_Digital").modal('show');
    $("#pkuitansi_notrs").val(convertEntities(no_trs));
    cekEmateraiByNotrs(no_trs);
    
    // printrincian(base_urlx);
}

$('#bubuhimaterai').click(function () {
    $("#notif_ShowTTD_Digital").modal('show');
    $("#pkuitansi_notrs").val(convertEntities(''));

});
$('#btnSaveSendX').click(function () {
    swal({
        title: "Kirim E-mail",
        text: "Apakah Anda yakin ingin Bubuhi E-Materai & kirim ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                
                var email = $("#pemail_pasien").val();
                if (!validateEmail(email)) {
                    swal({
                        title: "Email Tidak Sesuai Format",
                        text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
                        icon: "warning",
                    })
                    $("#pemail_pasien").focus();
                    $(".preloader").fadeOut();
                    return false;
                   }

                        var notrs = $("#pkuitansi_notrs").val();
                        var kodereg = $("#NoRegistrasi").val().slice(0,2);
                        var NoRegistrasi = $("#NoRegistrasi").val();

                        // if (kodereg != 'RJ' || kodereg != 'RI'){
                        //     kodereg = 'PB';
                        // }
                        var lang = $("#pkuitansi_lang").val();
                        // var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
                        jeniscetakan = 'KUITANSI';
                        var uploadurl='SaveKuitansi';
                        // if (jeniscetakan == 'KUITANSIREKAP'){
                        //     var url = 'SaveKuitansiRekap';
                        // }else if(jeniscetakan == 'KUITANSI'){
                        //     var url = 'SaveKuitansi';
                        // }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
                        //     var url = 'SaveRincianPB';
                        // }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
                        //     var url = 'SaveRincianRJ';
                        // }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
                        //     var url = 'SaveRincianRI';
                        // }
                        gouploadtoAws(notrs,kodereg,lang,jeniscetakan,uploadurl,email,NoRegistrasi);
                        // console.log(notrs,kodereg,lang,jeniscetakan,url,email);return false;
            } 
        });
    });

        $('#btnGenerateEmaterai').click(function () {
            swal({
                title: "Generate E-materi",
                text: "Apakah Anda yakin ingin Bubuhi E-Materai ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        
                        var email = $("#pemail_pasien").val();
                        // if (!validateEmail(email)) {
                        //     swal({
                        //         title: "Email Tidak Sesuai Format",
                        //         text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
                        //         icon: "warning",
                        //     })
                        //     $("#pemail_pasien").focus();
                        //     $(".preloader").fadeOut();
                        //     return false;
                        //    }
        
                                var notrs = $("#pkuitansi_notrs").val();
                                var kodereg = $("#NoRegistrasi").val().slice(0,2);
                                var NoRegistrasi = $("#NoRegistrasi").val();
                                var Alasan_Cetak = $("#Alasan_Cetak").val();
                                // if (kodereg != 'RJ' || kodereg != 'RI'){
                                //     kodereg = 'PB';
                                // }
                                var lang = $("#pkuitansi_lang").val();
                                // var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
                                jeniscetakan = 'KUITANSI';
                                var uploadurl='SaveKuitansi';
                                // if (jeniscetakan == 'KUITANSIREKAP'){
                                //     var url = 'SaveKuitansiRekap';
                                // }else if(jeniscetakan == 'KUITANSI'){
                                //     var url = 'SaveKuitansi';
                                // }else if(jeniscetakan == 'RINCIANBIAYA_PB'){
                                //     var url = 'SaveRincianPB';
                                // }else if(jeniscetakan == 'RINCIANBIAYA_RJ'){
                                //     var url = 'SaveRincianRJ';
                                // }else if(jeniscetakan == 'RINCIANBIAYA_RI'){
                                //     var url = 'SaveRincianRI';
                                // }
                                gouploadtoAwsEmaterai(notrs,kodereg,lang,jeniscetakan,uploadurl,email,NoRegistrasi,Alasan_Cetak);
                                // cekEmateraiByNotrs(notrs);
                                // console.log(notrs,kodereg,lang,jeniscetakan,url,email);return false;
                    } 
                });
});


async function gouploadtoAwsEmaterai(notrs,kodereg,lang,jeniscetakan,uploadurl,email,NoRegistrasi,Alasan_Cetak) {
    try {
        $(".preloader").fadeIn();

        const awsurl = await uploadtoAws_filepdfEmaterai(notrs,kodereg,lang,jeniscetakan,uploadurl,NoRegistrasi,Alasan_Cetak);
        // if ($("#pkuitansi_jeniscetakan").val() == 'KUITANSIREKAP'){
        //     var uploadurl = 'SendMailKuitansiRekap';
        //     var judul = 'Kuitansi Rekap';
        // }else if($("#pkuitansi_jeniscetakan").val() == 'KUITANSI'){
             var uploadurl = 'SendMailKuitansi';
             var judul = 'Kuitansi';
        // }else{
        //     var uploadurl = 'SendMailRincian';
        //     var judul = 'Rincian Biaya';
        // }
        updateUIdataGenerateEmaterai(awsurl);

        // await SendEmailEmaterai(judul,email,awsurl);
        // await CreateEmaterai(judul,email,awsurl);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
async function uploadtoAws_filepdfEmaterai(notrs,kodereg,lang,jeniscetakan,uploadurl,NoRegistrasi,Alasan_Cetak){
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aBillingPasien/'+uploadurl;
return fetch(url, {
method: 'POST',
headers: {
    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
},
body:   'notrs='+notrs+
        '&jeniscetakan='+jeniscetakan+
        '&kodereg='+kodereg+
        '&lang='+lang+
        '&periode_awal='+$("#tglawal").val()+
        '&periode_akhir='+$("#tglakhir").val()+
        '&NoRegistrasi='+NoRegistrasi+
        '&Alasan_Cetak='+Alasan_Cetak
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
function updateUIdataGenerateEmaterai(awsurl) {
    let dataGenerateEmaterai = awsurl;
    if (dataGenerateEmaterai.status == "success") {
        $(".preloader").fadeIn();
        swal(dataGenerateEmaterai.message,  "BERHASIL", "success");
        asyncShowMain();
        $(".preloader").fadeOut();

    }else{
        toast(response.message, "error")
    }
}
async function SendEmailEmaterai(judul,email,awsurl) {
    $(".preloader").fadeIn();

    // console.log(judul);
    // console.log(email);
    // console.log(awsurl);
    // return false;

    var pkuitansi_notrs = $("#pkuitansi_notrs").val();
    var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
    var noregistrasi = $("#NoRegistrasi").val();
    var aws_url = awsurl['UrlEmaterai'];
    var email = $("#pemail_pasien").val();

    var materai_url = awsurl;

// console.log(pkuitansi_notrs,
//     jeniscetakan,
//     noregistrasi,
//     aws_url,
//     email,
//     materai_url); return false;
    // var email = $("#pemail_pasien").val();
    // if (!validateEmail(email)) {
    //     swal({
    //         title: "Email Tidak Sesuai Format",
    //         text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
    //         icon: "warning",
    //     })
    //     $("#pemail_pasien").focus();
    //     $(".preloader").fadeOut();
    //     return false;
    //    }


    var FormData = {
        notrs:pkuitansi_notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
        email_send:email,

        aws_url:aws_url,
        materai_url:materai_url,

    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aBillingPasien/SendEmailEmaterai/";
    $.ajax({
        url: url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
        success: function (data) {
          $(".preloader").fadeOut();
            if (data.status=='success'){
              var title = 'Kirim Email Berhasil!';
              var statuskirim = 'TERKIRIM';
            }else{
              var title = 'Kirim Email Gagal!';
              var statuskirim = 'GAGAL';
            }
            
            $("#notif_ShowTTD_Digital").modal('hide');
            swal({
              title: title,
              text: data.message,
              icon: data.status,
          }).then(function() {

          });
          //INSERT TZ LOG EMAIL
          //goInsertLog(nolab,statuskirim,email);

        },
        error: function (xhr, status) {
          $(".preloader").fadeOut();
          toast(xhr, status);
            // handle errors
            console.log(xhr,status);
        }
    });
}
async function CreateEmaterai(judul,email,awsurl) {
    $(".preloader").fadeIn();
    var pkuitansi_notrs = $("#pkuitansi_notrs").val();
    var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
    var noregistrasi = $("#NoRegistrasi").val();
    var aws_url = awsurl['aws_url'];
    // var email = $("#pemail_pasien").val();
    // if (!validateEmail(email)) {
    //     swal({
    //         title: "Email Tidak Sesuai Format",
    //         text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
    //         icon: "warning",
    //     })
    //     $("#pemail_pasien").focus();
    //     $(".preloader").fadeOut();
    //     return false;
    //    }
    var FormData = {
        notrs:pkuitansi_notrs,
        jeniscetakan:jeniscetakan,
        noregistrasi:noregistrasi,
        judul:judul,
        email:email,
        aws_url:aws_url,
    }
    var base_url = window.location.origin;
    const url = base_url + "/SIKBREC/public/aBillingPasien/CreateEmaterai/";
    $.ajax({
        url: url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
        success: function (response) {
          $(".preloader").fadeOut();
            if (response.status=='success'){
              var title = 'Berhasil Bubuhi E-Materai!';
              var statuskirim = 'TERKIRIM';
            }else{
              var title = 'Gagal Bubuhi E-Materai!';
              var statuskirim = 'GAGAL';
            }
            
            $("#notif_ShowTTD_Digital").modal('hide');
            swal({
              title: title,
              text: response.message,
              icon: response.status,
          }).then(function() {

          });
          //INSERT TZ LOG EMAIL
          //goInsertLog(nolab,statuskirim,email);

        },
        error: function (xhr, status) {
          $(".preloader").fadeOut();
          toast(xhr, status);
            // handle errors
            console.log(xhr,status);
        }
    });
}

async function cekEmateraiByNotrs(notrs) {
    try {
        const datacekEmateraiByNotrsGet = await cekEmateraiByNotrsGet(notrs);
        updateUIdatacekEmateraiByNotrsGet(datacekEmateraiByNotrsGet);
    } catch (err) {
        toast(err.message, "error")
    }
}

//payment Save
function cekEmateraiByNotrsGet(notrs) {
    var notrs = notrs;

    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/cekEmateraibyNoTRS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs
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

function updateUIdatacekEmateraiByNotrsGet(params) {
    let response = params;
    console.log(response.link_response);
    if(response.link_response == '1'){
        var datacek = 'SUDAH ADA E-MATERAI';
    }else{
        var datacek = 'BELUM ADA E-MATERAI';
    }
    $("#pstatsu_Ematerai").val(convertEntities(datacek));
}

$('#btnSendEmail').click(function () {
    swal({
        title: "Kirim E-mail",
        text: "Apakah Anda ingin Kirim E-mail ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var email = $("#pemail_pasien").val();
                if (!validateEmail(email)) {
                    swal({
                        title: "Email Tidak Sesuai Format",
                        text: "Maaf, Format Email Tidak Sesuai! Mohon Diperiksa Kembali!",
                        icon: "warning",
                    })
                    $("#pemail_pasien").focus();
                    $(".preloader").fadeOut();
                    return false;
                   }
                   var Alasan_Cetak = $("#Alasan_Cetak").val();
                   if ($("#Alasan_Cetak").val() == '') {
                    swal({
                        title: "WARNING !!!",
                        text: "Harap Sertai Alasan !",
                        icon: "warning",
                    })
                    $("#Alasan_Cetak").focus();
                    $(".preloader").fadeOut();
                    return false;
                   }
                   var notrs = $("#pkuitansi_notrs").val();
                   var NoRegistrasi = $("#NoRegistrasi").val();
                   var kodereg = $("#NoRegistrasi").val().slice(0,2);
                   var lang = $("#pkuitansi_lang").val();


                   jeniscetakan = 'KUITANSI';

                goSendEmailmaterai(notrs,email,Alasan_Cetak,jeniscetakan,NoRegistrasi,kodereg,lang);
            } 
        });
});

async function goSendEmailmaterai(notrs,email,Alasan_Cetak,jeniscetakan,NoRegistrasi,kodereg) {
    try {
        const dataSendEmailmaterai = await SendEmailmaterai(notrs,email,Alasan_Cetak,jeniscetakan,NoRegistrasi,kodereg);
        updateUIdataSendEmailmaterai(dataSendEmailmaterai);
    } catch (err) {
        toast(err.message, "error")
    }
}

// async function SendEmailmaterai(notrs,email,Alasan_Cetak) {
//     $(".preloader").fadeIn();
//     var notrs = $("#pkuitansi_notrs").val();
//     var email = $("#pemail_pasien").val();
//     var Alasan_Cetak = $("#Alasan_Cetak").val();

//     var FormData = {
//         notrs:notrs,
//         email:email,
//         Alasan_Cetak:Alasan_Cetak,
       
//     }
//     var base_url = window.location.origin;
//     const url = base_url + "/SIKBREC/public/aBillingPasien/UpdateAlasanSendEmail/";
//     $.ajax({
//         url: url,
//         type: "POST",
//         data: FormData,
//         dataType: "JSON",
//         success: function (data) {
//           $(".preloader").fadeOut();
//             if (data.status=='success'){
//               var title = 'Kirim Email Berhasil!';
//               var statuskirim = 'TERKIRIM';
//             }else{
//               var title = 'Kirim Email Gagal!';
//               var statuskirim = 'GAGAL';
//             }
            
//             $("#notif_ShowTTD_Digital").modal('hide');
//             swal({
//               title: title,
//               text: data.message,
//               icon: data.status,
//           }).then(function() {

//           });
//           //INSERT TZ LOG EMAIL
//           //goInsertLog(nolab,statuskirim,email);

//         },
//         error: function (xhr, status) {
//           $(".preloader").fadeOut();
//           toast(xhr, status);
//             // handle errors
//             console.log(xhr,status);
//         }
//     });
// }
async function SendEmailmaterai(notrs,email,Alasan_Cetak,jeniscetakan,NoRegistrasi,kodereg) {
    var base_url = window.location.origin;

    var notrs = $("#pkuitansi_notrs").val();
    var email = $("#pemail_pasien").val();
    var Alasan_Cetak = $("#Alasan_Cetak").val();
    var jeniscetakan = 'KUITANSI';
    var NoRegistrasi = $("#NoRegistrasi").val();

    let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateAlasanSendEmail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'notrs=' +  notrs +
                '&email=' + email + 
                '&Alasan_Cetak=' + Alasan_Cetak + 
                '&jeniscetakan=' + jeniscetakan + 
                '&NoRegistrasi=' + NoRegistrasi+ 
                '&kodereg=' + kodereg

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
async function updateUIdataSendEmailmaterai(params) {
    let response = params;
    var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
    var noregistrasi = $("#NoRegistrasi").val();
    if(response.link_response == '1'){
        var datacek = 'SUDAH ADA E-MATERAI';
    }else{
        var datacek = 'BELUM ADA E-MATERAI';
        await SendEmailEmaterai(noregistrasi,jeniscetakan,response.link_response);
    }
    $("#pstatsu_Ematerai").val(convertEntities(datacek));
}
async function CetakPDF(){
    try{
        var datagetCetakPDF =  await getCetakPDF();
        updateUIdatagetCetakPDF(datagetCetakPDF);
    } catch (err) {
        toast(err, "error")
    }
}

function getCetakPDF() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    var pkuitansi_notrs = $("#pkuitansi_notrs").val();

    // console.log(noreg);
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataCetakDocumentPDF';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:
        'nomr=' + nomr 
        +'&noreg=' + noreg
        +'&pkuitansi_notrs=' + pkuitansi_notrs
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
            // $("#namatindakan").select2();
        })
}

function updateUIdatagetCetakPDF(datagetCetakPDF) {
    let responseLink = datagetCetakPDF;
    // console.log(responseLink.link_jumlah);return false;
    if(responseLink.link_jumlah == '0'){
        // console.log('sasdgd');return false;
var base_url = window.location.origin;

var jeniscetak = 'PrintKuitansiDetail';
var notrs = $("#NoRegistrasi").val();
var no_trs = $("#pkuitansi_notrs").val();

var kodereg = $("#NoRegistrasi").val().slice(0, 2);
var lang = no_trs;
// console.log(jeniscetak,notrs,kodereg,lang);return false;
window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintKuitansiDetail/" + lang +"/"+kodereg+"/"+notrs, "_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    }else if(responseLink.link_jumlah == '1'){
    window.open(responseLink.link_response);
    }else{
        var base_url = window.location.origin;

        var jeniscetak = 'PrintKuitansiDetail';
        var notrs = $("#NoRegistrasi").val();
        var no_trs = $("#pkuitansi_notrs").val();
        
        var kodereg = $("#NoRegistrasi").val().slice(0, 2);
        var lang = no_trs;
        // console.log(jeniscetak,notrs,kodereg,lang);return false;
        window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintKuitansiDetail/" + lang +"/"+kodereg+"/"+notrs, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    }
}
//bridging materai