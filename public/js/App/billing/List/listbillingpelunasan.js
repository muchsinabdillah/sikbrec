$(document).ready(function () {
    $(".preloader").fadeOut(); 

    convertNumberToRp();
    //$('#permintaanrawat_all').DataTable({});
    //getListBillingRajal();

    
    $('#trs_pelunasan_ui').fadeOut('fast')
    $("#CloseMe").click(function () { 
        $('#trs_pelunasan_ui').fadeOut('fast')
    });
    // $('#trs_pelunasan_ui').fadeOut().fadeIn('fast')

    $('#tbl_pelunasan_voucher_aktif').DataTable( {
    } );

    $('#tbl_pelunasan_voucher_arsip').DataTable( {
    } );

    $('#btn_periode').click(function () {
        var tglawal = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        // getListBillingBebas(tglawal,tglakhir);
        getListBillingvoucherpengembalian(tglawal,tglakhir);


    });

    $('#btn_periode_arsip').click(function () {
        var tglawal = $("#tglawal_arsip").val();
        var tglakhir = $("#tglakhir_arsip").val();
        console.log(tglawal,tglakhir);

        if (tglawal == '' || tglawal == null){
            toast('Silahkan Isi Tanggal Periode Awal','warning');
            return false;
        }
        if (tglakhir == '' || tglakhir == null){
            toast('Silahkan Isi Tanggal Periode Akhir','warning');
            return false;
        }
        // getListBillingBebas_Arsip(tglawal,tglakhir);
        getListBillingvoucherpengembalianArsip(tglawal,tglakhir);
    });

    $('#btn_today').click(function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var datenow = yyyy +"-"+ mm +"-"+ dd;
        var tglawal = datenow;
        var tglakhir = datenow;
        // getListBillingBebas(tglawal,tglakhir);
        getListBillingvoucherpengembalian(tglawal,tglakhir);
    });



    $("#add_row").click(function () { 

        if($("#TotalPembayaran").val() == ''){
            toast("Mohon Lakukan Generate Total Untuk Melanjutkan !", 'warning');
            return false;
        }
    
        if($("#NilaiBayar").val() == ''){
            $("#NilaiBayar").focus();
            toast("Mohon Isi Nilai Bayar !", 'warning');
            return false;
        }
        
        if($("#tipepembayaran").val() == ''){
            $("#tipepembayaran").select2('open');
            toast("Mohon Isi Tipe Pembayaran !", 'warning');
            return false;
        }

        if($("#tipepembayaran").val() == ''){
            $("#tipepembayaran").select2('open');
            toast("Mohon Isi Tipe Pembayaran !", 'warning');
            return false;
        }

        if($("#tipepembayaran").val() == "Piutang Asuransi" || $("#tipepembayaran").val() == "Piutang Perusahaan"){
            if ($('#kodejaminan').val() == '') {
              $("#kodejaminan").trigger('focus');
              toast("Mohon Isi Nama Perusahaan / Asuransi !", 'warning');
              return false;
              }
          }else{
            //   if($("#billto").val() == ''){
            //       $("#billto").trigger('focus');
            //       toast("Mohon Isi Telah Terima !", 'warning');
            //       return false;
            //   }

              if($("#NamaKuitansi").val() == ''){
                $("#NamaKuitansi").trigger('focus');
                toast("Mohon Isi Telah Terima !", 'warning');
                return false;
            }
        }

        if($("#tipepembayaran").val() == "Kartu Debit" || $("#tipepembayaran").val() == "Kartu Kredit"){
                if($('#namabank').val() == ''){
                $("#namabank").select2('open');
                toast("Mohon Isi Nama Bank !", 'warning');
                return false;
                }
                if($('#nokartu').val() == ''){
                    $("#nokartu").select2('open');
                    toast("Mohon Isi no Kartu !", 'warning');
                    return false;
                    }
                if($('#TglExpired').val() == ''){
                    $("#TglExpired").select2('open');
                    toast("Mohon Isi Tanggal Expired !", 'warning');
                    return false;
                }
        }
        

            var rtrn = BtnSubmitBayar();
            if (rtrn == false){
                toast('WARNING', 'warning')
                return false
            }
        
        // console.log($('#totalrow').val());
        // return false;
        

        if($('#totalharga').val() == 0){
            var harga = 0;
            }else{
            var harga = $('#totalharga').val();
            }
            // var string = $('#NilaiBayar').val();
            // var stringx = string.replace(/./g, '');
            // console.log(stringx);
            // return false;
            
            var NilaiBayar = parseFloat(price_to_number($("#NilaiBayar").val()));
    
            if($("#tipepembayaran").val() == "Piutang Asuransi" || $("#tipepembayaran").val() == "Piutang Perusahaan"){
                var sisaklaim = parseFloat(price_to_number( $('#SisaKlaim').val()));
                sisaklaimx = sisaklaim - NilaiBayar;
                if(sisaklaimx < 0 ){
                    toast('Nilai klaim gagal ditambahkan, Karena jumlah nilai melebihi total klaim', "warning")
                    return false;
                }
                $("#SisaKlaim").val(number_to_price(sisaklaimx));
    
                var NilaiBayarX = parseFloat(price_to_number($("#NilaiBayar").val()));
                if($('#totalklaim').val() == 0){
                var hargaklaim = 0;
                }else{
                var hargaklaim = $('#totalklaim').val();
                }
                var hargaklaim = parseFloat(price_to_number(hargaklaim));
                hargaklaim = hargaklaim + NilaiBayarX;
                $("#totalklaim").val(number_to_price(hargaklaim));
    
            }else{
                // var sisakurang = parseFloat(price_to_number( $('#SisaKekurangan').val()));
                var sisakurang = parseFloat(price_to_number( $('#sisabayar').val()));
                
                sisakurangx = sisakurang - NilaiBayar;
                console.log(sisakurang);
                console.log(NilaiBayar);
                if(sisakurangx < 0 ){
                    toast('Nilai bayar gagal ditambahkan, Karena jumlah nilai melebihi total Kekurangan', "warning")
                    return false;
                }
                $("#sisabayar").val(number_to_price(sisakurangx));
    
    
                var NilaiBayarX = parseFloat(price_to_number($("#NilaiBayar").val()));
                if($('#totalkekurangan').val() == 0){
                var hargakurang = 0;
                }else{
                var hargakurang = $('#totalkekurangan').val();
                }
                var hargakurang = parseFloat(price_to_number(hargakurang));
                hargakurang = hargakurang + NilaiBayarX;
                $("#totalkekurangan").val(number_to_price(hargakurang));
            }
    
    
            var harga = parseFloat(price_to_number(harga));
            console.log(harga);
            harga = harga + NilaiBayar;
            
            $("#grantotalharga").text(number_to_price(harga))
            $("#totalharga").val(number_to_price(harga));
            
            var sisabayar = parseFloat(price_to_number( $('#SisaPembayaran').val()));
            sisabayarx = sisabayar - NilaiBayar;
            $("#SisaPembayaran").val(number_to_price(sisabayarx));


            if($('#totalrow').val()==0){
                var count =0;
                }else{
                var count = parseFloat($('#totalrow').val());
                }
                count = count + 1;
                document.getElementById('grantotalOrder').innerHTML = count;
                $('#totalrow').val(count);
        
            // new
            billto = $('#NamaKuitansi').val();
            kodejaminan = $('#kodejaminan').val();

            // new
            tipepembayaran = $('#NamaKuitansi').val();
            ammount = $('#NilaiBayar').val();
            edc = $('#namabank').val();
            
            // tipekartu = '';
            tipekartu = $('#tipekartu').val();
            // nokartu = $('#nokartu').val();

            // new
            nokartu = $('#tipepembayaran').val();
            // gesek = $('#gesek').val();
            gesek = $('#gesek').val();
            expired = $('#TglExpired').val();
            kd_rekening = $('#kd_rekening').val();

            // console.log(kodejaminan);
            // return false;

            output = '<tr id="row_' + count + '">';
            output += '<td>' + count + ' <input type="hidden" name="count[]" id="first_name' + count +'" class="hidden_count" value="' + count + '" /></td>';
            output += '<td>' + billto + ' <input type="hidden" name="billto[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + billto + '" /><input type="hidden" name="kodejaminan[]" id="kodejaminan' + count +'" class="kodejaminan" value="' + kodejaminan + '" /></td><input type="hidden" name="kd_rekening[]" id="kd_rekening' + count +'" class="kd_rekening" value="' + kd_rekening + '" /></td></td><input type="hidden" name="tipekartu[]" id="tipekartu' + count +'" class="tipekartu" value="' + tipekartu + '" /></td>';
            output += '<td>' + ammount + ' <input type="hidden" name="totalinput[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ammount + '" /></td>';
            output += '<td>' + tipepembayaran + ' <input type="hidden" name="tipepembayaran[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + tipepembayaran + '" /></td>';
            output += '<td>' + edc + ' <input type="hidden" name="namabank[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + edc + '" /></td>';
            output += '<td>' + nokartu + ' <input type="hidden" name="nokartu[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + nokartu + '" /></td>';
            output += '<td>' + expired + ' <input type="hidden" name="expired[]" id="first_name' + count +'" class="hidden_expired" value="' + expired + '" /></td>';
            output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' + count + '" amount="' + ammount + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            //output += '<td>' + tipepembayaran + ' <input type="hidden" name="tipepembayaran[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + tipepembayaran + '" /></td>';
            // output += '<td>' + billto + ' <input type="hidden" name="billto[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + billto + '" /><input type="hidden" name="kodejaminan[]" id="kodejaminan' + count +'" class="kodejaminan" value="' + kodejaminan + '" /></td>';
            // output += '<td>' + ammount + ' <input type="hidden" name="totalinput[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ammount + '" /></td>';
            // output += '<td>' + edc + ' <input type="hidden" name="namabank[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + edc + '" /></td>';
            // output += '<td>' + tipekartu + ' <input type="hidden" name="tipekartu[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + tipekartu + '" /></td>';
            // output += '<td>' + nokartu + ' <input type="hidden" name="nokartu[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + nokartu + '" /></td>';
            // output += '<td>' + gesek + ' <input type="hidden" name="gesek[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + gesek + '" /></td>';
            // output += '<td>' + kd_rekening + ' <input type="hidden" name="kd_rekening[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + kd_rekening + '" /></td>';
            // output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' +
            // count + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
            output += '</tr>';

            $('#user_data').append(output);
            // $("#tipepembayaran").val('');
            

            $("#NilaiBayar").val('');
            $("#billto").val('');
            $("#kode_billto").val('');
            
            $("#namabank").val('');
            $("#tipekartu").val('');
            $("#nokartu").val('');
            $("#TglExpired").val('');
            // $("#totalharga").val(ammount);

            $("#tipepembayaran").val('').trigger('change');
            $("#perusahaanjpk").select2('destroy');
            $("#perusahaanasuransi").select2('destroy');
            $("#perusahaanjpk").val('');
            $("#perusahaanasuransi").val('');
            $("#perusahaanjpk").select2();
            $("#perusahaanasuransi").select2();

          
            // $("#gesek").val('');
            $('#kd_rekening').val('');
            $('#tipepembayaran').focus(); 
            
        //}
    });

    $(document).on('click', '.remove_details', function () {
        var row_id = $(this).attr("id");
        var row_amount = $(this).attr("amount");
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

                 // var count = $('#totalrow').val();
                 var harga = parseFloat(price_to_number( $('#totalharga').val()));
                 var NilaiBayar = parseFloat(price_to_number(row_amount));
                 harga = harga - NilaiBayar;
                 $("#grantotalharga").text(number_to_price(harga));
                 $("#totalharga").val(number_to_price(harga));

                 var sisabayar = parseFloat(price_to_number( $('#sisabayar').val()));
                 sisabayarx = sisabayar + NilaiBayar;
                 $("#sisabayar").val(number_to_price(sisabayarx));

                toast('Berhasil Hapus !', "success");
            } else {
              //swal("Your imaginary file is safe!");
            }
          });
    
        });


        $('#savetrs_payment_Pelunasan_Voucher').click(function () {
        var sisa = $("#sisabayar").val();
        var total = $("#TotalPembayaran").val();

        // goSaveTrsPaymentVoucherPelunasan();
        if(sisa == total){
            toast('Silahkan Lakukan Transaksi Payment Dengan Benar !', "error");
        }
        else{
            swal({
                title: "Simpan",
                text: "Apakah Anda ingin Simpan ?",
                icon: "info",
                buttons: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                           // ApproveCheckbox(id);
                           goSaveTrsPaymentVoucherPelunasan();
                    } 
                });
        }
    });

});


async function goSaveTrsPaymentVoucherPelunasan() {
    try {
        const dataSaveTrsPaymentVoucherPelunasan = await SaveTrsPaymentVoucherPelunasan();
        updateUIdataSaveTrsPaymentVoucherPelunasan(dataSaveTrsPaymentVoucherPelunasan);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveTrsPaymentVoucherPelunasan(params) {
    let response = params;
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    if (response.status == "success") {
        // toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })

        getListBillingvoucherpengembalian(tglawal,tglakhir);
        $('#trs_pelunasan_ui').fadeOut('fast');
        // var base_url = window.location.origin;
        // printkuitansi(base_url);
        // printrincian(base_url);
        // location.reload();
        // getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  
}

//payment Save
function SaveTrsPaymentVoucherPelunasan() {
    var form = $("#form_pelunasan_payment").serialize();
    var totalbayar = $("#TotalPembayaran").val();


    // console.log(bilito);
    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/SaveTrsPaymentVoucherPelunasan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&totalbayar=" + totalbayar
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
                // toast(response.message)

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


//btn bayar
function BtnSubmitBayar(){
    var table = $('#tbl_pelunasan_voucher_aktif').DataTable();
    var form = $("#form_pelunasan_payment");
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

    goUpdateKlaimBayar()
    return true;
}

async function goUpdateKlaimBayar() {
    try {
        const dataUpdateKlaimBayar = await UpdateKlaimBayar();
        updateUIdataUpdateKlaimBayar(dataUpdateKlaimBayar);
    } catch (err) {
        // toast(err.message, "error")
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
    var form = $("#form_pelunasan_payment").serialize();
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


function getListBillingvoucherpengembalian(tglawal,tglakhir) {
    $("#tglawal").val(tglawal);
    $("#tglakhir").val(tglakhir);
    var base_url = window.location.origin;
        $('#tbl_pelunasan_voucher_aktif').DataTable().clear().destroy();
        $('#tbl_pelunasan_voucher_aktif').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataVoucherPengembalianAktif", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "NO_TRANSAKSI" },
            { "data": "NO_TRANSAKSI" },
            { "data": "PatientName" },
            { "data": "NO_REGISTRASI" },
            { "data": "JAMINAN" }, 
            { "data": "NOMINAL_BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
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
         "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

                total3 = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             // Update footer
                $( api.column( 5 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );

         },
       });
       
} 

function getListBillingvoucherpengembalianArsip(tglawal,tglakhir) { 
    var base_url = window.location.origin;
        $('#tbl_pelunasan_voucher_arsip').DataTable().clear().destroy();
        $('#tbl_pelunasan_voucher_arsip').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataVoucherPengembalianArsip", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.tglawal = tglawal
                d.tglakhir = tglakhir
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NO_TRANSAKSI" },
            { "data": "PatientName" },
            { "data": "NO_REGISTRASI" },
            { "data": "JAMINAN" }, 
            { "data": "NOMINAL_BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            ],
            // 'columnDefs': [
            //     {
            //     'targets': 0,
            //     'checkboxes': {
            //         'selectRow': true
                    
            //     }
            //     }
            // ],
            // 'select': {
            //     'style': 'multi'
            // },
         "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;
 
             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

                total3 = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             // Update footer
                $( api.column( 5 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );

         },
       });
       
}

function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/bInformationLma/PrintLMA/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}


function showID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    var judul = 'Billing Rawat Jalan';
    //window.location = base_url + '/SIKBREC/public/aBillingPasien/' + str;
    window.open(base_url + '/SIKBREC/public/aBillingPasien/' + str , "_blank");
}



// SUM TARIF

function btnSumTarifVoucher(thisid){
    // console.log(thisid);
    // return false;
    var table = $('#tbl_pelunasan_voucher_aktif').DataTable();
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
        title: "Generate Tarif",
        text: "Apakah Anda ingin Melanjutkan ?",
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
    try {
        const datagetTarifAllSum = await getTarifAllSum(data);
        updateUIdatagetTarifAllSum(datagetTarifAllSum);
        const datagetPaymentType = await getPaymentType();
        updateUIgetPaymentType(datagetPaymentType);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagetTarifAllSum(params) {
    

    document.getElementById("form_pelunasan_payment").reset();
    var dataHandler = $("#user_data");
    dataHandler.html("");

   
    let response = params
    $("#TotalPembayaran").val(number_to_price(response));
    $("#sisabayar").val(number_to_price(response));
    $('#trs_pelunasan_ui').fadeOut().fadeIn('fast');


    $("#NilaiBayar").val('');
    $("#tipepembayaran").val('');
    $("#NamaKuitansi").val('');
    $("#totalharga").val('');
    $("#totalrow").val('');

    $("#grantotalharga").text(number_to_price(''));
    $("#grantotalOrder").text(number_to_price(''));
    // $("#grantotalharga").val('');
    // $("#grantotalOrder").val('');


    // $('#tbl_rincianbillingx').DataTable().remove();
    // $("#TotalPembayaran").val(number_to_price(totalbayar));
}

function getTarifAllSum(data) {
    var form = $("#form_sumtarif_all").serialize();
    // console.log(data);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/sumAllTarifVoucherAktif';
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
// END SUM TARIF
//tarif key
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
function convertNumberToRp() {
    var Tarif = document.getElementById("NilaiBayar");
    Tarif.addEventListener("keyup", function (e) {
        Tarif.value = formatRupiah(this.value);
    });
}
//END tarif key


//TRS PEMBAYARAN


function getBillto(param){
    $("#billto").val('');
    $("#kodejaminan").val('');
    if (param=='Kartu Debit' || param=='Kartu Kredit'){
        var namapasien = $("#NamaPasien").val();
        $("#NamaKuitansi").val('');
        $('#telahterima_ui2').fadeOut('fast') 
        $('#telahterima_ui3').fadeOut('fast') 
        $("#billto").val(namapasien);
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#card_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        var attr = 'BAYAR';
        // getDataDetailBilling_Payment(attr);
        
    }else if (param=='Piutang Perusahaan'){
        $("#NamaKuitansi").val('');
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui2').fadeOut().fadeIn('fast') 
        var attr = 'KLAIM';
        getPerusahaan();
        // getDataDetailBilling_Payment(attr);
    }else if (param=='Piutang Asuransi'){
        $("#NamaKuitansi").val('');
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui3').fadeOut().fadeIn('fast') 
        
        var attr = 'KLAIM';
        getAsuransi();
        // getDataDetailBilling_Payment(attr);
    }
    else if(param==''){
        $('#cash_ui').fadeOut().fadeOut('fast') 
        $('#card_ui').fadeOut().fadeOut('fast') 
        var attr = null;
        // getDataDetailBilling_Payment(attr);
    }
    else if(param=='Tunai' || param=='Piutang Rawat Inap' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher'){
       
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $("#NamaKuitansi").val(namapasien);
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        $('#cash_ui').fadeOut().fadeIn('slow') 
        var attr = 'BAYAR';
        // getDataDetailBilling_Payment(attr);
    }

}

function passingVal(f){
     var value = $(f).val();
     var getid = $(f).attr('name');
     $("#kodejaminan").val(value);

     var selected = $('#'+getid+' option:selected').text()
     $("#billto").val(selected);
     $("#NamaKuitansi").val(selected);

     if(value != $('#penjamin_kode').val()){
        swal({
                text: "PERINGATAN! 'Telah Terima Dari' tidak sama dengan registrasi penjamin pasien! Mohon diperiksa kembali!",
            });
        }
}

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
    // console.log(param);
    // return false;
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

async function getnamabank(param) {
    console.log(param);
    var namabank = $("#namabank").val();
    $("#NamaKuitansi").val(namabank);
}

async function getnamatipe(f) {
    var value = $(f).val();
    var getid = $(f).attr('name');
    $("#kodejaminan").val(value);

    var selected = $('#'+getid+' option:selected').text()
    $("#billto").val(selected);
    $("#NamaKuitansi").val(selected);
}

async function getnamaperusahaan(param) {
    console.log(param);
    // var namaperusahaan = $("#perusahaanjpk").val();
    // $("#NamaKuitansi").val(namaperusahaan);
}



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

//END TRS PEMBAYARAN




//GET PAYMENT TYPE
function updateUIgetPaymentType(datagetPaymentType) {
    let data = datagetPaymentType;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#tipepembayaran").append(newRow);
        $("#tipepembayaran_closing").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].FS_KD_REKENING + '">' + data[i].FS_NM_REKENING + '</option';
            $("#tipepembayaran").append(newRow);
            $("#tipepembayaran_closing").append(newRow);
        }
    }
}
function getPaymentType() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getPaymentTypeREKENING';
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


//GET MASTER PERUSAHAAN
async function getPerusahaan() {
    try {   
        const datagetAllDataPerusahaan = await getAllDataPerusahaan();
        updateUIdatagetAllDataPerusahaan(datagetAllDataPerusahaan);
    
    } catch (err) {
        // toast(err.message, "error")
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
                throw new Error(response.message);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.message);
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