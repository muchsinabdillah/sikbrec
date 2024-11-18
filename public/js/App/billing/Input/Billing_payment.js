
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
        
        var sisabayar = parseFloat(price_to_number( $('#sisabayar').val()));
        sisabayarx = sisabayar - NilaiBayar;
        
        if(sisabayarx < 0 ){
            toast('Nilai bayar gagal ditambahkan, Karena jumlah nilai melebihi sisa pembayaran', "warning")
            return false;
        }
        $("#sisabayar").val(number_to_price(sisabayarx));
        $("#grantotalharga").text(number_to_price(harga));
        $("#totalharga").val(number_to_price(harga));

        // document.getElementById('grantotalharga').innerHTML = harga;
        // $('#totalharga').val(harga);


        if($('#totalrow').val()==0){
            var count =0;
            }else{
            var count = parseFloat($('#totalrow').val());
            }
            count = count + 1;
            document.getElementById('grantotalOrder').innerHTML = count;
            $('#totalrow').val(count);
    

        var rtrn = BtnSubmitBayar();
        if (rtrn == false){
            toast('WARNING', 'warning')
            return false
        }

        
            billto = $('#NamaKuitansi').val();
            kodejaminan = $('#kodejaminan').val();

            tipepembayaran = $('#tipepembayaran').val();
            ammount = $('#NilaiBayar').val();
            edc = $('#namabank').val();
            
            // tipekartu = '';
            tipekartu = $('#tipekartu').val();
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


        $('#savetrs_payment').click(function () {
        var sisa = $("#sisabayar").val();
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
                           goSaveTrsPayment();
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
    $("#idkuitansi").val(convertEntities(response.paramsid));
    if (response.status == "success") {
        // toast(response.message, "success")
        swal({
            title: "Simpan Berhasil!",  
            // text: response.message,
            text: "Terimakasih",
            icon: "success",
        }).then((willDelete) => {
            if (willDelete) {
                location.reload();
                // printkuitansi();
                // swal({
                //     title: "Cetak Kuitansi Berhasil!",  
                //     // text: response.message,
                //     text: "Cetak Nota Pembayaran",
                //     icon: "success",
                // }).then((willDelete) => {
                //     if (willDelete) {
                //         printrincian();
                //         location.reload();
                //     }
                //     else{
                //         location.reload();
                //     }
                // });
            }
            else{
                location.reload();
            }
        });
    }else{
        toast(response.message, "error")
    }  
}

//payment Save
function SaveTrsPayment() {
    var form = $("#form_payment").serialize();
    var NoMR = $("#NoMR").val();
    var NoEpisode = $("#NoEpisode").val();
    var NoRegistrasi = $("#NoRegistrasi").val();
    // var tglpayment = $("#tglpayment").val();
    var tglpayment = $("#TglMasuk").val();
    var TypePatientID = $("#TypePatientID").val();
    var kodepjm = $("#penjamin_kode").val();
    var Penjamin = $("#Penjamin").val();
    var namapasien = $("#NamaPasien").val();
    var billtox  = '';
    var totalbayar = $("#TotalPembayaran").val();
    var kodereg = $("#NoRegistrasi").val().slice(0, 2);


    if(kodepjm == '315'){
        billtox  = namapasien;
    }
    else{
        billtox  = Penjamin;
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
        body: form + "&NoEpisode=" + NoEpisode + "&NoMR=" + NoMR + "&NoRegistrasi=" + NoRegistrasi + "&tglpayment=" + tglpayment + "&TypePatientID=" + TypePatientID + "&billtox=" + billtox + "&totalbayar=" + totalbayar + "&kodereg=" + kodereg
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

async function printkuitansi1() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#NoRegistrasi").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var jeniscetakan = $("#pkuitansi_jeniscetakan").val();
        var kodereg = $("#NoRegistrasi").val().slice(0, 2);
        var lang = $("#pkuitansi_lang").val();
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
        var base_urlx = window.location.origin;
        if (jeniscetakan == 'KUITANSIREKAP'){
            var jeniscetak = 'PrintKuitansiRekap';
        }else{
            var jeniscetak = 'PrintKuitansi';
        }

        window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + lang +"/"+kodereg+"/"+notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        printrincian(base_urlx);

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

async function printkuitansi() {
    var base_url = window.location.origin;
    var jeniscetak = 'PrintKuitansiDetail';
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0, 2);
    var lang = $("#idkuitansi").val();
    // window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + lang +"/"+kodereg+"/"+notrs,
    //         "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + lang +"/"+kodereg+"/"+notrs);
    // console.log(base_url);
}

async function printrincian() {
    // var base_url = window.location.origin;
    // var notrs = $("#NoRegistrasi").val();
    // var kodereg = $("#NoRegistrasi").val().slice(0,2);
    // var lang = $("#idkuitansi").val();
    // window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRinciandetail"+kodereg+"/"+lang +"/"+notrs,
    // "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");

    var base_url = window.location.origin;
    var notrs = $("#NoRegistrasi").val();
    var kodereg = $("#NoRegistrasi").val().slice(0,2);
    var lang = $("#idkuitansi").val();
    window.open(base_url + "/SIKBREC/public/aBillingPasien/PrintRinciandetail"+kodereg+"/"+lang +"/"+notrs);
    // location.reload();
}


// END print kuitansi

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
        $('#tbl_rincianbilling').DataTable().clear().destroy();
        $('#tbl_rincianbilling').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 2, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aBillingPasien/getDataDetailRincianBillingPayment", // URL file untuk proses select datanya
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
            { "data": "TglBilling" },
            { "data": "NAMA_TARIF" }, 
            { "data": "QTY" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "NILAI_TARIF" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "DISC_RP" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
            { "data": "GRANDTOTAL" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
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
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                totadisc = api
                 .column( 7 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                 totalbayar = api
                 .column( 8 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
 
             // Update footer
                $( api.column( 6 ).footer() ).html(
                $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  total3 )
                );
                $( api.column( 7 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totadisc )
                );
                $( api.column( 8 ).footer() ).html(
                    $.fn.dataTable.render.number( '.', ',', 0,'' ).display(  totalbayar )
                );

            //  $("#TotalPembayaran").val(number_to_price(totalbayar));
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
    else if(param=='Tunai' || param=='Piutang Rawat Inap' || param=='Setor Bank' || param=='Transfer Bank' || param=='Voucher' || param=='QRIS'){
       
        $('#card_ui').fadeOut().fadeOut('fast') 
        $('#telahterima_ui2').fadeOut().fadeOut('fast') 
        $('#telahterima_ui3').fadeOut().fadeOut('fast') 
        var namapasien = $("#NamaPasien").val();
        $("#billto").val(namapasien);
        $("#NamaKuitansi").val(namapasien);
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
    // swal({
    //     title: "Generate Tarif",
    //     text: "Apakah Anda ingin Melanjutkan ?",
    //     icon: "info",
    //     buttons: true,
    // })
    //     .then((willDelete) => {
    //         if (willDelete) {
    //                 getTarifSum(id);
    //         } 
    //     });
        getTarifSum(id);
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
    document.getElementById("form_payment").reset();
    var dataHandler = $("#user_data");
    dataHandler.html("");
    $("#grantotalharga").text(number_to_price(''));
    $("#grantotalOrder").text(number_to_price(''));

    $("#NilaiBayar").val('');
    $("#tipepembayaran").val('');
    $("#NamaKuitansi").val('');
    $("#totalharga").val('');
    $("#totalrow").val('');

    $('#card_ui').fadeOut().fadeOut('fast');
    $('#telahterima_ui2').fadeOut().fadeOut('fast'); 
    $('#telahterima_ui3').fadeOut().fadeOut('fast');

    let response = params
    $("#TotalPembayaran").val(number_to_price(response));
    $("#sisabayar").val(number_to_price(response));

    // $("#TotalPembayaran").val(number_to_price(totalbayar));
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
