
$(document).ready(function () {
    $(".preloader").fadeOut(); 

    $('#addnewdeposit').fadeOut().fadeIn('fast');
    $('#addnewdepositx1').fadeOut('fast').fadeIn('fast');
    $('#addnewdepositx1b1').fadeOut('fast');
    $('#addnewdepositx1b2').fadeOut('fast');
    $('#addnewdepositx3a').fadeOut('fast');
    $('#addnewdepositx3b').fadeOut('fast');
    
    // $('#addnewdepositx2').fadeOut().fadeIn('fast');
    convertNumberToRp();
    
    asyncShowMain();
    // getTarifSum(data);
    $("#add_row").click(function () { 

        // if($("#TotalPembayaran").val() == ''){
        //     toast("Mohon Lakukan Generate Total Untuk Melanjutkan !", 'warning');
        //     return false;
        // }
    
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

            // var rtrn = BtnSubmitBayar();
            // if (rtrn == false){
            //     toast('WARNING', 'warning')
            //     return false
            // }
        
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

        var harga = parseFloat(price_to_number(harga));
        console.log(harga);
        harga = harga + NilaiBayar;
        
        $("#grantotalharga").text(number_to_price(harga))
        $("#totalharga").val(number_to_price(harga));
        $("#GrandTotalPembayaran").val(number_to_price(harga));
    


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


            // output += '<td>' + count + ' <input type="hidden" name="count[]" id="first_name' + count +'" class="hidden_count" value="' + count + '" /></td>';
            // output += '<td>' + billto + ' <input type="hidden" name="billto[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + billto + '" /><input type="hidden" name="kodejaminan[]" id="kodejaminan' + count +'" class="kodejaminan" value="' + kodejaminan + '" /></td>';
            // output += '<td>' + ammount + ' <input type="hidden" name="totalinput[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + ammount + '" /></td>';
            // output += '<td>' + tipepembayaran + ' <input type="hidden" name="tipepembayaran[]" id="first_name' + count +'" class="hidden_kode_barang" value="' + tipepembayaran + '" /></td>';
            // output += '<td>' + edc + ' <input type="hidden" name="namabank[]" id="first_name' + count +'" class="hidden_nama_barang" value="' + edc + '" /></td>';
            // output += '<td>' + nokartu + ' <input type="hidden" name="nokartu[]" id="first_name' + count +'" class="hidden_qty_barang" value="' + nokartu + '" /></td>';
            // output += '<td>' + expired + ' <input type="hidden" name="expired[]" id="first_name' + count +'" class="hidden_expired" value="' + expired + '" /></td>';
            // output += '<td><button type="button" title="Hapus" name="remove_details" class="btn btn-danger btn-sm remove_details" id="' + count + '" amount="' + ammount + '"><span class="glyphicon glyphicon-remove"></span></button></td>';

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
        var row_tipebayar = $(this).attr("tipepembayaran");

        // console.log(row_id);
        // console.log(row_amount);
        // console.log(row_tipebayar);
        // return false;
        
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
                $("#GrandTotalPembayaran").val(number_to_price(harga));

                toast('Berhasil Hapus !', "success");
            } else {
              //swal("Your imaginary file is safe!");
            }
          });
    
        });


$('#savetrs_payment_deposit').click(function () {
    var trsnew = $("#newTRS").val();
    
    if(trsnew == ''){
        toast('Silahkan Generate New TRS terlebih dahulu !', "error");
        return false;
    }

    var keterangan = $("#KeteranganDeposit").val();
    if(keterangan == ''){
        toast('Silahkan Masukkan Keteranagan terlebih dahulu !', "error");
        return false;
    }

    var GrandTotal = $("#GrandTotalPembayaran").val();
    if(GrandTotal == '0,00' || GrandTotal == ''){
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
                       goSaveTrsPayment_deposit();
                } 
            });
    }

});

});


async function goSaveTrsPayment_deposit() {
    try {
        const dataSaveTrsPayment_deposit = await SaveTrsPayment_deposit();
        updateUIdataSaveTrsPayment_deposit(dataSaveTrsPayment_deposit);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveTrsPayment_deposit(params) {
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

function SaveTrsPayment_deposit() {
    var form = $("#form_deposit").serialize();
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
    var GrandTotalBayar = $("#GrandTotalPembayaran").val();
    var trsdeposit = $("#newTRS").val();
    var ktrDeposit = $("#KeteranganDeposit").val();

    // var totalkekurangan1 = $("#TotalKekurangan").val();
    // var totalkekurangan2 = $("#totalkekurangan").val();
    // var totalklaim1 = $("#TotalKlaim").val();
    // var totalklaim2 = $("#totalklaim").val();

    if(kodepjm == '315'){
        billtox  = namapasien;
    }
    else{
        billtox  = Penjamin;
    }

    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/aBillingPasien/SaveTrsPayment_deposit';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form + "&NoMR=" + NoMR + "&NoEpisode=" + NoEpisode 
        + "&NoRegistrasi=" + NoRegistrasi + "&tglpayment_closing=" 
        + tglpayment + "&TypePatientID=" + TypePatientID + "&totalbayar=" + totalbayar
        + "&billtox=" + billtox
        + "&GrandTotalBayar=" + GrandTotalBayar
        + "&trsdeposit=" + trsdeposit
        + "&ktrDeposit=" + ktrDeposit
        // + "&totalkekurangan1=" + totalkekurangan1
        // + "&totalkekurangan2=" + totalkekurangan2
        // + "&totalklaim1=" + totalklaim1
        // + "&totalklaim2=" + totalklaim2
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
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

async function printrincian(base_url) {
    var base_url = base_url;
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0,2);
    window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRincianAll"+kodereg+"/"+notrs, "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

// END print kuitansi

async function generateIDTRSNew(){
    namapasien = $("#NamaPasien").val();
    swal({
        title: "NEW DEPOSIT",
        text: "Tekan OK untuk,"+ " melanjutkan penambahan deposit pasien AN: " + namapasien,
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                   // ApproveCheckbox(id);
                   generateIDTRSNewFIX();
            } 
        });
}


async function SearchDepoModal(){
    $("#ModalDepoRincian").modal('show');
    getDataRincianRiwayatBillingDepo();
}

async function generateIDTRSNewFIX(){
    try {   
        const datagetgenerateIDTRSNew = await getgenerateIDTRSNew();
        updateUIgetgenerateIDTRSNew(datagetgenerateIDTRSNew);
    } catch (err) {
        toast(err.message, "error");
    }
}


function updateUIgetgenerateIDTRSNew(params) {
    let response = params;
    document.getElementById("form_deposit").reset();
    var dataHandler = $("#user_data");
    dataHandler.html("");
    // document.getElementById("tbl_rincianbillingx").reset();

    
    $("#newTRS").val(convertEntities(response.paramsid));
    // $('#cash_ui').fadeOut().fadeIn('fast') 
    // $('#addnewdeposit').fadeOut().fadeIn('fast');
    // $('#addnewdepositx1').fadeOut().fadeIn('fast');
    
    $('#addnewdepositx2').fadeOut().fadeIn('fast');
    $('#addnewdepositx1b1').fadeOut('fast');
    $('#addnewdepositx1b2').fadeOut('fast');
    $('#addnewdepositx3b').fadeOut('fast');
    $('#addnewdepositx3a').fadeIn('fast');
    $('#addnewdepositx3aa').fadeIn('fast');

}

function getgenerateIDTRSNew() {
    var NoRegistrasi = $("#NoRegistrasi").val();
    var NamaPasien = $("#NamaPasien").val();
    var NoMR = $("#NoMR").val();
    var NoEpisode = $("#NoEpisode").val();

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getgenerateIDTRSNew';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoRegistrasi=" + NoRegistrasi 
            + "&NamaPasien=" + NamaPasien
            + "&NoMR=" + NoMR
            + "&NoEpisode=" + NoEpisode
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



async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        const datagetPaymentType = await getPaymentType();
        updateUIgetPaymentType(datagetPaymentType);

    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
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


        // $("#pemail_pasien").val(convertEntities(dataresponse.data.emailpasien));

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

        
        getDataRincianBilling();
        $(".preloader").fadeOut();
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
    let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateKlaimBayarclose';
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
    let url = base_url + '/SIKBREC/public/aBillingPasien/getPaymentTypeNohutang';
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


function getDataRincianBilling() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    // var nomr = $("#NoMR").val();

        $('#tbl_rinciandeposit').DataTable().clear().destroy();
        $('#tbl_rinciandeposit').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailRincianDeposit", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NO_TRANSAKSI_REFF" },
            { "data": "NO_TRANSAKSI" },
            { "data": "NO_REGISTRASI" },
            { "data": "TglTRS" },
            { "data": "KETRANGAN" },
            { "data": "TIPE_PEMBAYARAN" },
            { "data": "NAMA_TIPE_PEMBAYARAN" },
            // { "data": "NOMINAL_BAYAR" },
            { "data": "NOMINAL_BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
               //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                  var html  = `<button type="button" onclick="showDataDepo2('${row.NO_TRANSAKSI_REFF}','${row.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>`
                     return html 
              }
       },
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
 
             // Update footer
                $( api.column( 7 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );

             $("#TotalPembayaran").val(number_to_price(total3));

         },
       });
       
} 
//

async function showDataDepo2(reff, detail){
    $("#newTRSdetail").val(detail);
    $("#newTRS").val(reff);
    $('#addnewdepositx1b1').fadeOut('fast').fadeIn('fast');
    $('#addnewdepositx1b2').fadeOut('fast').fadeIn('fast');
    $('#addnewdepositx3').fadeOut('fast').fadeIn('fast');
}

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

function getDataRincianRiwayatBillingDepo() { 
    var base_url = window.location.origin;
    var noreg = $("#NoRegistrasi").val();
    // var nomr = $("#NoMR").val();

        $('#tbl_RiwayatDepo').DataTable().clear().destroy();
        $('#tbl_RiwayatDepo').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailRincianDeposit", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                d.noreg = noreg
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NO_TRANSAKSI" },
            { "data": "TGL_TRS" },
            { "data": "NOMINAL_BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
               //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                //   var html  = `<button type="button" onclick="showDataDepo2('${row.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>`
                //      return html 
                     var html  = `<button type="button" onclick="showDataDepoRincianAll('${row.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>`
                     return html 
              }
       },
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
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
             // Update footer
                $( api.column( 3 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );

            //  $("#TotalPembayaran").val(number_to_price(total3));

         },
       });
}
async function showDataDepoRincianAll(notrs){
    $("#newTRS").val(notrs);
    $("#ModalDepoRincian").modal('hide');
    $('#addnewdepositx3aa').fadeOut('fast');
    $('#addnewdepositx3a').fadeOut('fast');
    $('#addnewdepositx3b').fadeIn('fast');
    
    // getDataRincianRiwayatBillingDepo2(notrs);
    getDataRincianRiwayatBillingDepo2x(notrs);
}

function getDataRincianRiwayatBillingDepo2(notrs) { 
    var base_url = window.location.origin;
    // var noreg = $("#NoRegistrasi").val();
    // var noreg = $("#newTRS").val();
    var notrshdr = notrs;

        $('#tbl_rincianbillingx').DataTable().clear().destroy();
        $('#tbl_rincianbillingx').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailRincianDeposit2", // URL file untuk proses select datanya
               "type": "POST",
               data: function (d) {
                // d.noreg = noreg
                d.notrshdr = notrshdr
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
            { "data": "No" },
            { "data": "NAMA_TIPE_PEMBAYARAN" },
            { "data": "NOMINAL_BAYAR" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "TIPE_PEMBAYARAN" },
            { "data": "NAMA_TIPE_PEMBAYARAN" },
            { "data": "NO_KARTU_REFRENSI" },
            { "data": "EXPIRED_DATE" },
            // { "data": "Kode_Tipe_Reff" },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                 
               //    var html  = '<button type="button" class="btn btn-default border-default btn-animated btn-xs"><span class="glyphicon glyphicon-lock"></span></button>&nbsp<button type="button" onclick="ShowDataTarif('+row.ID+')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>&nbsp<button type="button" class="btn btn-danger border-danger btn-animated btn-xs"  onclick="BatalDetailBill('+row.ID+')" ><span class="glyphicon glyphicon-remove"></span></button>'
                //   var html  = `<button type="button" onclick="showDataDepo2('${row.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>`
                //      return html 
                     var html  = `<button type="button" onclick="showDataDepoRincianAll('${row.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button>`
                     return html 
              }
       },
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
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
             // Update footer
                $( api.column( 2 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );

            //  $("#TotalPembayaran").val(number_to_price(total3));

         },
       });
}

function getDataRincianRiwayatBillingDepo2x(notrs) {
   total_items = 0;
   var dataHandler = $("#user_data");
   dataHandler.html("");
   var notrshdr = notrs;
   var base_url = window.location.origin;
   var url2 = "/SIKBREC/public/aBillingPasien/getDataDetailRincianDeposit2";

   $.ajax({
       type: "POST",
       data: "notrshdr=" + notrshdr,
       url: base_url + url2,
       success: function (result) {
          

         
           var resultObj = JSON.parse(result);
           console.log(resultObj);
           $.each(resultObj, function (key, val) {
               total_items = total_items + 1;

              
               var html  = `<td><button type="button" onclick="UpdateDataDepo2a('${val.NO_TRANSAKSI}')" class="btn btn-warning border-warning btn-xs"><i class="fa fa-pencil"></i></button> &nbsp <button type="button" onclick="batalDataDepo2('${val.NO_TRANSAKSI}')" class="btn btn-danger border-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></td>`
              
               var newRow = $("<tr id='row_'" + total_items + "'>");

                /*1*/  newRow.html("<td><font size='1'>" + total_items + "<input type='hidden'  name='hidden_no_trs_[]' id='hidden_no_trs_'" + total_items + "' value='" + val.NO_TRANSAKSI +"' ></td>'"+

                // /*2*/ "'<td>" + val.NAMA_TIPE_PEMBAYARAN +"<input type='hidden' name='hidden_id[]' id='hidden_nama_diterima_'" + total_items + "' class='hidden_id'"+total_items + "' value='" + val.NAMA_TIPE_PEMBAYARAN +"' ></font></td> '"+
                 /*2*/"' <td><input  size='15'  type='text' onkeyup='calculateAllDetail()'  name='hidden_nama_diterima_[]' id='hidden_nama_diterima_" + total_items + "' value='" + val.NAMA_TIPE_PEMBAYARAN +"' ></td> '"+

                // /*3*/"'<td><font size='1'>" + val.NOMINAL_BAYAR + "<input type='hidden'  name='hidden_nama_nominal_[]' id='hidden_nama_nominal_'" + total_items + "' value='" + val.NOMINAL_BAYAR +"' ></font></td>'"+
                /*3*/"' <td><input  size='15'  type='text' onkeyup='calculateAllDetail()'  name='hidden_nama_nominal_[]' id='hidden_nama_nominal_" + total_items + "' value='" + val.NOMINAL_BAYAR +"' ></td> '"+


                /*4*/"'<td><font size='1'>" + val.TIPE_PEMBAYARAN + "<input type='hidden'  name='hidden_jenis_pembayaran_[]' id='hidden_jenis_pembayaran_'" + total_items + "' value='" + val.TIPE_PEMBAYARAN +"' ></font></td>'"+

                /*5*/"'<td><font size='1'>" + val.NAMA_TIPE_PEMBAYARAN + "<input type='hidden'  name='hidden_nama_pembayaran_[]' id='hidden_nama_pembayaran_'" + total_items + "' value='" + val.NAMA_TIPE_PEMBAYARAN +"' ></font></td>'"+

                // /*6*/"'<td><font size='1'>" + val.NO_KARTU_REFRENSI + "<input type='hidden'  name='hidden_kartu_no_[]' id='hidden_kartu_no_'" + total_items + "' value='" + val.NO_KARTU_REFRENSI +"' ></font></td>'"+
                /*6*/"' <td><input  size='15'  type='text' onkeyup='calculateAllDetail()'  name='hidden_kartu_no_[]' id='hidden_kartu_no_" + total_items + "' value='" + val.NO_KARTU_REFRENSI +"' ></td> '"+

                // /*7*/"'<td><font size='1'>" + val.EXPIRED_DATE + "<input type='hidden'  name='hidden_xpired_kartu_[]' id='hidden_xpired_kartu_'" + total_items + "' value='" + val.EXPIRED_DATE +"' ></font></td>'"+
                /*7*/"' <td><input  size='20'  type='text' onkeyup='calculateAllDetail()'  name='hidden_xpired_kartu_[]' id='hidden_xpired_kartu_" + total_items + "' value='" + val.EXPIRED_DATE +"' ></td> '"+

            //    /*6*/"' <td><input  size='20'  type='text' onkeyup='calculateAllDetail()'  name='hidden_qty_[]' id='hidden_qty_" + total_items + "' value='" + val.NO_KARTU_REFRENSI +"' ></td> '"+

            //    /*7*/"' <td><input size='1' type='text' name='hidden_harga_[]'   id='hidden_harga_" + total_items + "' class='harga' onkeyup='calculateAllDetail()' value='" + val.EXPIRED_DATE + "' readonly></td> '"+

               html

           + " </tr>");

           console.log("total_items",newRow);
           dataHandler.append(newRow);
       });
       //validate
       console.log("total_row",total_items);
       $('#totalrow').val(total_items);
       document.getElementById('grantotalOrder').innerHTML = total_items;
       //end validate
   }
   
   });
           
}


function batalDataDepo2(notrsdetail){
    swal({
        title: "DELETE PEMBAYARAN",
        text: "Apakah Anda ingin Melanjutkan ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                batalDataDepo2x(notrsdetail);
            } 
        });
}

async function batalDataDepo2x(notrsdetail) {
    try {
        const dataupdtaebatalDataDepo2= await updtaebatalDataDepo2(notrsdetail);
        updateUIdataupdtaebatalDataDepo2(dataupdtaebatalDataDepo2);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataupdtaebatalDataDepo2(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        var notrs = $("#newTRS").val();
        getDataRincianRiwayatBillingDepo2x(notrs);
    }else{
        toast(response.message, "error")
    }
}

function updtaebatalDataDepo2(notrsdetail) {
    var newTRSdetail = notrsdetail;
    // var newTRShdr = notrsdetail;
    var newTRShdr = $("#newTRS").val();


    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/aBillingPasien/DeleteTrsPayment_depositdetial';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "newTRSdetail=" + newTRSdetail
        + "&newTRShdr=" + newTRShdr
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

function updateDataDepo2bdetail(){
    swal({
        title: "UPDATE PEMBAYARAN",
        text: "Apakah Anda ingin Melanjutkan ?",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                updateDataDepo2bx();
            } 
        });
}

async function updateDataDepo2bx() {
    try {
        const dataupdatedetailDataDepo2b= await updatedetailDataDepo2b();
        updateUIdataupdatedetailDataDepo2b(dataupdatedetailDataDepo2b);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataupdatedetailDataDepo2b(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        var notrs = $("#newTRS").val();
        getDataRincianRiwayatBillingDepo2x(notrs);
    }else{
        toast(response.message, "error")
    }
}

function updatedetailDataDepo2b() {
    // var newTRSdetail = notrsdetail;
    var form = $("#form_deposit").serialize();
    var newTRShdr = $("#newTRS").val();
    var rowdata = $("#totalrow").val();
    var rowdata = $("#totalrow").val();
    var noreg = $("#NoRegistrasi").val();


    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/aBillingPasien/updatedetailDataDepo2Detail';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form
        + "&newTRShdr=" + newTRShdr
        + "&rowdata=" + rowdata
        + "&noreg=" + noreg

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
    else if(param=='Tunai' || param=='Piutang Rawat Inap' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher'){
       
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

    else if(param=='Pasien Kabur'){
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
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
//#END KODE REKENING

// SUM TARIF

function btnSumTarif(thisid){
    // console.log(thisid);
    // return false;
    var table = $('#tbl_rincianbilling').DataTable();
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
    let url = base_url + '/SIKBREC/public/aBillingPasien/sumAllTarif';
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


//update detial depo
async function updateDepo2() {
    try {
        const dataSaveupdateDepo2 = await SaveupdateDepo2();
        updateUIdataSaveupdateDepo2(dataSaveupdateDepo2);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveupdateDepo2(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        // var base_url = window.location.origin;
        // printkuitansi(base_url);
        // printrincian(base_url);
        location.reload();
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }
}

function SaveupdateDepo2() {

    var NilaiBayar = $("#NilaiBayar").val();
    var tipepembayaran = $("#tipepembayaran").val();
    var namabank = $("#namabank").val();
    var nokartu = $("#nokartu").val();
    var TglExpired = $("#TglExpired").val();
    var kd_rekening = $("#kd_rekening").val();
    var perusahaanjpk = $("#perusahaanjpk").val();
    var perusahaanasuransi = $("#perusahaanasuransi").val();
    var kodejaminan = $("#kodejaminan").val();
    var newTRSdetail = $("#newTRSdetail").val();
    var NamaKuitansi = $("#NamaKuitansi").val();
    var NoRegistrasi = $("#NoRegistrasi").val();


    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/aBillingPasien/UpdateTrsPayment_deposit';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NilaiBayar=" + NilaiBayar 
        + "&tipepembayaran=" + tipepembayaran
        + "&namabank=" + namabank
        + "&nokartu=" + nokartu
        + "&TglExpired=" + TglExpired
        + "&kd_rekening=" + kd_rekening
        + "&perusahaanjpk=" + perusahaanjpk
        + "&perusahaanasuransi=" + perusahaanasuransi
        + "&kodejaminan=" + kodejaminan
        + "&newTRSdetail=" + newTRSdetail
        + "&NamaKuitansi=" + NamaKuitansi
        + "&NoRegistrasi=" + NoRegistrasi
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


async function updateDepo2() {
    try {
        const dataSaveupdateDepo2 = await SaveupdateDepo2();
        updateUIdataSaveupdateDepo2(dataSaveupdateDepo2);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataSaveupdateDepo2(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        // var base_url = window.location.origin;
        // printkuitansi(base_url);
        // printrincian(base_url);
        location.reload();
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }
}


async function deleteDepo2() {
    try {
        const dataupdtaedeleteDepo2 = await updtaedeleteDepo2();
        updateUIdataupdtaedeleteDepo22(dataupdtaedeleteDepo2);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataupdtaedeleteDepo22(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",
            text: response.message,
            icon: "success",
        })
        // var base_url = window.location.origin;
        // printkuitansi(base_url);
        // printrincian(base_url);
        location.reload();
        //getDataApproveFarmasi();
    }else{
        toast(response.message, "error")
    }
}

function updtaedeleteDepo2() {

    // var NilaiBayar = $("#NilaiBayar").val();
    // var tipepembayaran = $("#tipepembayaran").val();
    // var namabank = $("#namabank").val();
    // var nokartu = $("#nokartu").val();
    // var TglExpired = $("#TglExpired").val();
    // var kd_rekening = $("#kd_rekening").val();
    // var perusahaanjpk = $("#perusahaanjpk").val();
    // var perusahaanasuransi = $("#perusahaanasuransi").val();
    // var kodejaminan = $("#kodejaminan").val();
    var newTRSdetail = $("#newTRS").val();
    // var newTRSdetail = $("#newTRSdetail").val();
    var NoRegistrasi = $("#NoRegistrasi").val();



    var base_url = window.location.origin;

    let url = base_url + '/SIKBREC/public/aBillingPasien/DeleteTrsPayment_deposit';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "newTRSdetail=" + newTRSdetail
        +"&NoRegistrasi=" + NoRegistrasi
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

//end update detail depo
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
