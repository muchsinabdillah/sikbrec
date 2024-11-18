
$(document).ready(function () {
    $(".preloader").fadeOut(); 
    convertNumberToRp();
    
    asyncShowMain();
    // getTarifSum(data);
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
              if($("#billto").val() == ''){
                  $("#billto").trigger('focus');
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
        
        if($('#totalharga').val() == 0){
        var harga = 0;
        }else{
        var harga = $('#totalharga').val();
        }
        
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
            var sisakurang = parseFloat(price_to_number( $('#SisaKekurangan').val()));
            sisakurangx = sisakurang - NilaiBayar;
            if(sisakurangx < 0 ){
                toast('Nilai bayar gagal ditambahkan, Karena jumlah nilai melebihi total Kekurangan', "warning")
                return false;
            }
            $("#SisaKekurangan").val(number_to_price(sisakurangx));


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
    
        

            // billto = $('#billto').val();
            billto = $('#NamaKuitansi').val();
            kodejaminan = $('#kodejaminan').val();

            tipepembayaran = $('#tipepembayaran').val();
            ammount = $('#NilaiBayar').val();
            edc = $('#namabank').val();
            tipekartu = $('#tipekartu').val();
            // tipekartu = '';
            nokartu = $('#nokartu').val();
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
            output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' + count + '" amount="' + ammount + '" tipepembayaran="' + tipepembayaran + '"><span class="glyphicon glyphicon-remove"></span></button></td>';
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
        var row_tipebayar = $(this).attr("tipepembayaran");

        
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
                var count = $('#totalrow').val();


                // var count = $('#totalrow').val();
                var harga = parseFloat(price_to_number( $('#totalharga').val()));
                var NilaiBayar = parseFloat(price_to_number(row_amount));
                harga = harga - NilaiBayar;
                $("#grantotalharga").text(number_to_price(harga));
                $("#totalharga").val(number_to_price(harga));

                var sisabayar = parseFloat(price_to_number( $('#SisaPembayaran').val()));
                sisabayarx = sisabayar + NilaiBayar;
                $("#SisaPembayaran").val(number_to_price(sisabayarx));

                if($('#totalklaim').val() == ''){
                    var hargaklaim = '0,00';
                    }else{
                    var hargaklaim = $('#totalklaim').val();
                    }
                if($('#totalkekurangan').val() == ''){
                    var hargakurang = '0,00';
                    }else{
                    var hargakurang = $('#totalkekurangan').val();
                    }

                if(row_tipebayar == "Piutang Asuransi" || row_tipebayar == "Piutang Perusahaan"){
                    var sisaklaim = parseFloat(price_to_number( $('#SisaKlaim').val()));
                    sisaklaimx = sisaklaim + NilaiBayar;
                    $("#SisaKlaim").val(number_to_price(sisaklaimx));
                   
                    var hargaklaim = parseFloat(price_to_number(hargaklaim));
                    hargaklaim = hargaklaim - NilaiBayar;
                    $("#totalklaim").val(number_to_price(hargaklaim));
                }else{
                    var sisakurang = parseFloat(price_to_number( $('#SisaKekurangan').val()));
                    sisakurangx = sisakurang + NilaiBayar;
                    $("#SisaKekurangan").val(number_to_price(sisakurangx));

                   
                    var hargakurang = parseFloat(price_to_number(hargakurang));
                    hargakurang = hargakurang - NilaiBayar;
                    $("#totalkekurangan").val(number_to_price(hargakurang));
                }

                toast('Berhasil Hapus !', "success");
            } else {
              //swal("Your imaginary file is safe!");
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

    $('#savetrs_payment_closing').click(function () {
        var sisa = $("#SisaPembayaran").val();
        var total = $("#TotalPembayaran").val();

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
                           goSaveTrsPayment_closing();
                    } 
                });
        }
       
});

});

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
//payment Save
function SaveTrsPayment() {
    // var form = $("#form_payment").serialize();
    // var NoMR = $("#NoMR").val();
    // var NoEpisode = $("#NoEpisode").val();
    // var NoRegistrasi = $("#NoRegistrasi").val();
    // var tglpayment = $("#TglMasuk").val();
    // var TypePatientID = $("#TypePatientID").val();
    // var kodepjm = $("#penjamin_kode").val();
    // var Penjamin = $("#Penjamin").val();
    // var namapasien = $("#NamaPasien").val();
    // var billto  = '';

    // if(kodepjm == '315'){
    //     billto  = namapasien;
    // }
    // else{
    //     billto  = Penjamin;
    // }
    

    var form = $("#form_payment").serialize();
    var NoMR = $("#NoMR").val();
    var NoEpisode = $("#NoEpisode").val();
    var NoRegistrasi = $("#NoRegistrasi").val();
    var tglpayment = $("#TglMasuk").val();
    var TypePatientID = $("#TypePatientID").val();
    var kodepjm = $("#penjamin_kode").val();
    var Penjamin = $("#Penjamin").val();
    var namapasien = $("#NamaPasien").val();
    var billtox  = '';
    var totalbayar = $("#TotalPembayaran").val();

    if(kodepjm == '315'){
        billtox  = namapasien;
    }
    else{
        billtox  = Penjamin;
    }

    // console.log(bilito);
    // return false;
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/SaveTrsPayment';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&NoEpisode=" + NoEpisode + "&NoMR=" + NoMR + "&NoRegistrasi=" 
        + NoRegistrasi + "&tglpayment=" + tglpayment + "&TypePatientID=" + TypePatientID + "&billtox=" + billtox
        + "&totalbayar=" + totalbayar
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
        var base_url = window.location.origin;
        printkuitansi(base_url);
        printrincian(base_url);
        location.reload();
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }  

}

function SaveTrsPayment_closing() {
    var form = $("#form_payment").serialize();
    var NoMR = '-';
    var NoEpisode = '-';
    var NoRegistrasi = $("#NoRegistrasi").val();
    var tglpayment = $("#TglMasuk").val();
    var TypePatientID = $("#TypePatientID").val();
    var kodepjm = $("#penjamin_kode").val();
    var Penjamin = $("#Penjamin").val();
    var namapasien = $("#NamaPasien").val();
    var billtox  = '';
    var totalbayar = $("#TotalPembayaran").val();

    var totalkekurangan1 = $("#TotalKekurangan").val();
    var totalkekurangan2 = $("#totalkekurangan").val();
    var totalklaim1 = $("#TotalKlaim").val();
    var totalklaim2 = $("#totalklaim").val();

    if(kodepjm == '315'){
        billtox  = namapasien;
    }
    else{
        billtox  = Penjamin;
    }

    var base_url = window.location.origin;

    let url = base_url + '/ESIRYARSI/public/aBillingPasien/SaveTrsPayment_closing_Bebas';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&NoMR=" + NoMR + "&NoEpisode=" + NoEpisode 
        + "&NoRegistrasi=" + NoRegistrasi + "&tglpayment_closing=" 
        + tglpayment + "&TypePatientID=" + TypePatientID + "&totalbayar=" + totalbayar
        + "&billtox=" + billtox
        + "&totalkekurangan1=" + totalkekurangan1
        + "&totalkekurangan2=" + totalkekurangan2
        + "&totalklaim1=" + totalklaim1
        + "&totalklaim2=" + totalklaim2
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

async function printkuitansi(base_url) {
    var base_url = base_url;
    var jeniscetak = 'PrintKuitansiAll';
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0, 2);
    window.open(base_url + "/ESIRYARSI/public/aBillingPasien/"+jeniscetak+"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

async function printrincian(base_url) {
    var base_url = base_url;
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0,2);
    window.open(base_url + "/ESIRYARSI/public/aBillingPasien/PrintRincianAll"+kodereg+"/"+notrs, "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

// END print kuitansi


async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        const datagetPaymentType = await getPaymentType();
        updateUIgetPaymentType(datagetPaymentType);
//new
        const datagetTotalPembayaranx = await getTotalPembayaranxx();
        updateUIdatagetTotalPembayaranx(datagetTotalPembayaranx);
//new
    } catch (err) {
        toast(err.message, "error")
    }
}
//new
async function updateUIdatagetTotalPembayaranx(datagetTotalPembayaranx) {
    let dataresponse = datagetTotalPembayaranx;
    // $("#TotalDeposit").val(dataresponse.data.TOTALDEPOSIT);
    // $("#TotalVoucher").val(dataresponse.data.TOTALPENGEMBALIAN);
    // var totalDeposit = dataresponse.data.TOTALDEPOSIT;
    // var totalpengembalian = dataresponse.data.TOTALPENGEMBALIAN;
    // $("#TotalDeposit").val(dataresponse.data.TOTALDEPOSIT);
    // $("#TotalVoucher").val(dataresponse.data.TOTALPENGEMBALIAN);

    // $("#TotalDeposit").val(dataresponse.data.TOTALDEPOSIT);
    // $("#TotalVoucher").text(number_to_price(dataresponse.data.TOTALDEPOSIT));
    // $("#TotalVoucher").val(dataresponse.data.TOTALPENGEMBALIAN);
    // $("#TotalVoucher").text(number_to_price(dataresponse.data.TOTALPENGEMBALIAN));
    // $("#TotalDeposit").text(number_to_price(totalDeposit));
    // $("#TotalVoucher").text(number_to_price(totalpengembalian));

    // console.log(totalDeposit);
    // console.log(totalpengembalian);
    // exit;
    $("#TotalDeposit").val(number_to_price(dataresponse.data.TOTALDEPOSIT));
    $("#TotalVoucher").val(number_to_price(dataresponse.data.TOTALPENGEMBALIAN));
    
    var T_Kekurangan = $("#TotalKekurangan").val();
    var T_Deposit = number_to_price(dataresponse.data.TOTALDEPOSIT);

    T_Kekurangan = parseInt(number(T_Kekurangan));
    T_Deposit = parseInt(number(T_Deposit));

    // console.log(T_Kekurangan);
    // console.log(T_Deposit);

    if(T_Deposit != 0){
        var T_Sisakekurangan = T_Deposit - T_Kekurangan;
        console.log(T_Sisakekurangan);
        $("#SisaKekurangan").val(T_Sisakekurangan);
    }
    

}

function getTotalPembayaranxx() {
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    var nomr = $("#NoMR").val();
    // console.log(noreg);
    
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/getTotalPembayaran';
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
//new


async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;

        $("#NamaPasien").val(convertEntities(dataresponse.data.NamaPembeli));
        $("#Penjamin").val(convertEntities(dataresponse.data.NamaJaminan));
        $("#GroupJaminan").val(convertEntities(dataresponse.data.GroupJaminan));
        $("#penjamin_kode").val(convertEntities(dataresponse.data.penjamin_kode));
        $("#TypePatientID").val(convertEntities(dataresponse.data.GroupJaminan));
        $("#TglLahir").val(convertEntities(dataresponse.data.TglLahir));
        $("#Unit").val(convertEntities(dataresponse.data.NamaUnit));
        $("#TglMasuk").val(convertEntities(dataresponse.data.TglKunjungan));

        $("#Keterangan_Ext").val(convertEntities(dataresponse.data.TelemedicineIs+' / '+dataresponse.data.JenisPasien));
        $("#judul").html(dataresponse.data.judul);

        getDataRincianBilling();
        $(".preloader").fadeOut();
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/getDataPasienBebas';
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

//btn bayar
function BtnSubmitBayar(){
    var table = $('#tbl_rincianbilling').DataTable();
    // console.log(table);
    // return false;
    var form = $("#form_payment");
    //var id = $(thisid).attr("id");

    // Remove added elements
//     $('input[name="idbillingdtl\[\]"]', form).remove();
    
//     var rows_selected = table.column(0).ID();

//     $.each(rows_selected, function(index, rowId){
//        $(form).append(
//            $('<input>')
//               .attr('type', 'hidden')
//               .attr('name', 'idbillingdtl[]')
//               .val(rowId)
//        );
//    });

//    //Cek if checkbox check at least 1 item
//     var list = [(rows_selected.join(","))];
//     if (list == ''){
//         toast('Silahkan Pilih Minimal 1 Item di tabel !','warning');
//         return false;
//     }

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
    var NoRegistrasi = $("#NoRegistrasi").val();
    // var tglpayment = $("#tglpayment").val();
    var tipepembayaran = $("#tipepembayaran").val();
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/UpdateKlaimBayarclose';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&tipepembayaran=" + tipepembayaran + "&NoRegistrasi=" + NoRegistrasi
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
//end btn bayar

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
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/getPaymentType';
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
    let url = base_url + '/ESIRYARSI/public/MasterDataPerusahaan/getAllDataPerusahaan';
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
    let url = base_url + '/ESIRYARSI/public/MasterDataAsuransi/getAllDataAsuransi';
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

//update
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
               "url": base_url + "/ESIRYARSI/public/aBillingPasien/getDataDetailBillingx", // URL file untuk proses select datanya
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


function getDataRincianBilling() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    // var nomr = $("#NoMR").val();

        $('#tbl_rincianbilling').DataTable().clear().destroy();
        $('#tbl_rincianbilling').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/ESIRYARSI/public/aBillingPasien/getDataDetailRincianBilling", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "ID" },
            { "data": "No" },
            { "data": "NO_TRS_BILLING" },
            { "data": "NO_REGISTRASI" },
            { "data": "TglBilling" },
            { "data": "NAMA_TARIF" }, 
            { "data": "QTY" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "NILAI_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "DISC_RP" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KEKURANGAN" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "KLAIM" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "GRANDTOTAL" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
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
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                totadisc = api
                 .column( 8 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalbayar = api
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

                 totalharga = api
                 .column( 11 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
 
             // Update footer
                $( api.column( 7 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );
                $( api.column( 8 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totadisc )
                );
                $( api.column( 9 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalbayar )
                );
                $( api.column( 10 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalklaim )
                );
                $( api.column( 11 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalharga )
                );

             $("#TotalPembayaran").val(number_to_price(totalharga));
             $("#TotalKekurangan").val(number_to_price(totalbayar));
             $("#TotalKlaim").val(number_to_price(totalklaim));
             $("#SisaPembayaran").val(number_to_price(totalharga));
             $("#SisaKekurangan").val(number_to_price(totalbayar));
             $("#SisaKlaim").val(number_to_price(totalklaim));

             $("#totalkekurangan").val('0,00');
             $("#totalklaim").val('0,00');
         },
       });
       
} 
//update

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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

function getBillto(param){
    $("#billto").val('');
    $("#kodejaminan").val('');
    if (param=='Kartu Debit' || param=='Kartu Kredit'){
        // var namapasien = $("#NamaPasien").val();
        var namapasien = $("#NamaPasien").val();
        $("#NamaKuitansi").val('');
        $('#telahterima_ui2').fadeOut('fast') 
        $('#telahterima_ui3').fadeOut('fast') 
        $("#billto").val(namapasien);
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#card_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        var attr = 'BAYAR';
        getDataDetailBilling_Payment(attr);
        
    }else if (param=='Piutang Perusahaan'){
        $("#NamaKuitansi").val('');
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui2').fadeOut().fadeIn('fast') 
        var attr = 'KLAIM';
        getPerusahaan();
        getDataDetailBilling_Payment(attr);
    }else if (param=='Piutang Asuransi'){
        $("#NamaKuitansi").val('');
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#cash_ui').fadeOut().fadeIn('fast') 
        $('#telahterima_ui3').fadeOut().fadeIn('fast') 
        var attr = 'KLAIM';
        getAsuransi();
        getDataDetailBilling_Payment(attr);
    }
    else if(param==''){
        $('#cash_ui').fadeOut().fadeOut('fast') 
        $('#card_ui').fadeOut().fadeOut('fast') 
        var attr = null;
        getDataDetailBilling_Payment(attr);
    }
    else if(param=='Tunai' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher' || param=='QRIS'){
       
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        // var namapasien = $("#NamaPasien").val();
        // $("#billto").val(namapasien);
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $("#NamaKuitansi").val(namapasien);
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        $('#cash_ui').fadeOut().fadeIn('slow') 
        var attr = 'BAYAR';
        getDataDetailBilling_Payment(attr);
    }

    else if(param=='Piutang Rawat Inap'){
        document.getElementById("form_payment").reset();
        var dataHandler = $("#user_data");
        dataHandler.html("");
        $("#grantotalharga").text(number_to_price(''));
        $("#grantotalOrder").text(number_to_price(''));
    
        $("#NilaiBayar").val('');
        // $("#tipepembayaran").val('');
        $("#NamaKuitansi").val('');
        $("#namabank").val('');
        $("#nokartu").val('');
        $("#TglExpired").val('');
        $("#perusahaanjpk").val('');
        $("#perusahaanasuransi").val('');

        $("#totalharga").val('');
        $("#totalrow").val('');
    
        $('#card_ui').fadeOut().fadeOut('fast');
        $('#telahterima_ui2').fadeOut().fadeOut('fast'); 
        $('#telahterima_ui3').fadeOut().fadeOut('fast');


        // var totalharga1 = '0,0';
        var totalklaim1 = '0,00';
        var totalkekurangan = '0,00';
        $("#totalharga").val('');
        $("#totalklaim").val(totalklaim1);
        $("#totalkekurangan").val(totalkekurangan);


        var kekurangan = $("#TotalKekurangan").val();
        var klaim = $("#TotalKlaim").val();
        var keseluruhan = $("#TotalPembayaran").val();


        $("#SisaKekurangan").val(kekurangan);
        $("#SisaKlaim").val(klaim);
        $("#SisaPembayaran").val(keseluruhan);

    
        // let response = params
        // $("#TotalPembayaran").val(number_to_price(response));
        // $("#sisabayar").val(number_to_price(response));


        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast')
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $("#NamaKuitansi").val(namapasien);
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        $('#cash_ui').fadeOut().fadeIn('slow') 
        var attr = 'UTANGRANAP';
        getDataDetailBilling_Payment(attr);
    }

    else if(param=='Pasien Kabur'){
        document.getElementById("form_payment").reset();
        var dataHandler = $("#user_data");
        dataHandler.html("");
        $("#grantotalharga").text(number_to_price(''));
        $("#grantotalOrder").text(number_to_price(''));
    
        $("#NilaiBayar").val('');
        // $("#tipepembayaran").val('');
        $("#NamaKuitansi").val('');
        $("#namabank").val('');
        $("#nokartu").val('');
        $("#TglExpired").val('');
        $("#perusahaanjpk").val('');
        $("#perusahaanasuransi").val('');

        $("#totalharga").val('');
        $("#totalrow").val('');
    
        $('#card_ui').fadeOut().fadeOut('fast');
        $('#telahterima_ui2').fadeOut().fadeOut('fast'); 
        $('#telahterima_ui3').fadeOut().fadeOut('fast');


        $("#totalharga").val('');
        $("#totalrow").val('');

        var kekurangan = $("#TotalKekurangan").val();
        var klaim = $("#TotalKlaim").val();
        var keseluruhan = $("#TotalPembayaran").val();


        $("#SisaKekurangan").val(kekurangan);
        $("#SisaKlaim").val(klaim);
        $("#SisaPembayaran").val(keseluruhan);

        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast')
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $("#NamaKuitansi").val(namapasien);
        $('#telahterima_ui').fadeOut().fadeIn('fast') 
        $('#cash_ui').fadeOut().fadeIn('slow') 
        var attr = 'KABUR';
        getDataDetailBilling_Payment(attr);
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
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/getPaymentEDC';
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

async function getnamaperusahaan(param) {
    console.log(param);
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
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/getKodeRekening';
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

// SUM TARIF

function btnSumTarif(thisid){
    // console.log(thisid);
    // return false;
    var table = $('#tbl_rincianbilling').DataTable();
    var form = $("#form_sumtarif_all");
    var id = $(thisid).attr("id");

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
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdatagetTarifAllSum(params) {
    let response = params
    $("#TotalPembayaran").val(convertEntities(response));
}

function getTarifAllSum(data) {
    var form = $("#form_sumtarif_all").serialize();

    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/aBillingPasien/sumAllTarif';
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

    var xNoreg = $('#NoRegistrasi').val();
    $("#notif_ShowTTD_Digital").modal('show');
}
