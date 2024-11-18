
$(document).ready(function () {
    $(".preloader").fadeOut(); 

    $("#qty_fo2").attr('disabled', true);
    $("#diskon_fo2").attr('disabled', true);
    $("#btnupfo2update").attr('disabled', true);

    asyncShowMain();

    $('#btn_periode').click(function () {
        getDataDetailBilling();
        getDataRiwayatPayment();
        getTotalPembayaran();
        ('#bg1').fadeOut().fadeIn('slow') 
    });

    $('#btn_approvefrm').click(function () {
        $("#approvemodalfarmasibebas").modal('show');
        getDataApproveFarmasi();
    });

    $("#btn_payment").click(function () {
        var noreg = $("#NoRegistrasi").val();
                        showIDbyNoRegx(noreg);
    });

    function showIDbyNoRegx(str) {
        const base_url = window.location.origin;
        var str = btoa(str);
        window.location = base_url + '/SIKBREC/public/aBillingPasien/billingpembayaranbebas/' + str;
    }


    $('#tbl_rincianbiaya').DataTable( {
        "order": [[ 0, "asc" ]]
    } );
    $('#tbl_riwayatpayment').DataTable( {
        "order": [[ 0, "asc" ]]
    } );

    $('#btn_open_bill').click(function () {
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
});

async function asyncShowMain() {
    try {   
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);
        // const datagetPaymentType = await getPaymentType();
        if ($("#pkuitansi_notrs").val() != ''){
            $("#notif_ShowTTD_Digital").modal('show');
        }
        getTotalPembayaran();
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetDatabyID(datagetDatabyID) {
    let dataresponse = datagetDatabyID;
    // console.log('tai');
        $("#NamaPembeli").val(convertEntities(dataresponse.data.NamaPembeli));
        $("#JenisKelamin").val(convertEntities(dataresponse.data.GenderPembeli));
        $("#StatusPasien").val(convertEntities(dataresponse.data.JenisPasien));
        $("#TglLahir").val(convertEntities(dataresponse.data.TglLahir));
        $("#TglPembelian").val(convertEntities(dataresponse.data.TglKunjungan));
        $("#LokasiPembelian").val(convertEntities(dataresponse.data.NamaUnit));
        $("#Penjamin").val(convertEntities(dataresponse.data.NamaJaminan));
        $("#GroupJaminan").val(convertEntities(dataresponse.data.GroupJaminan));
        $("#penjamin_kode").val(convertEntities(dataresponse.data.KodeJaminan));
        // $("#TypePatientID").val(convertEntities(dataresponse.data.PatientName));
        $("#Alamat").val(convertEntities(dataresponse.data.AlamatPembeli));

        // 20/08/2024

        console.log(dataresponse.data.statusclose);
        if (dataresponse.data.statusclose == "close") {
            console.log('Masuk sini');
            $('#btn_openorclose_bill').html('Open Bill');
            $("#Ket_btn_closeoropenbill").val(convertEntities(dataresponse.data.statusclose));
        } else {
            console.log('Masuk sana');
            $('#btn_openorclose_bill').html('Close Bill');
            $("#Ket_btn_closeoropenbill").val(convertEntities(dataresponse.data.statusclose));
        }
        // 20/08/2024
        $('#statusreg').html(dataresponse.data.StatusReg);
        if (dataresponse.data.StatusReg == 'NEW'){
            var badge = 'success';
        }else if(dataresponse.data.StatusReg == 'APPROVED'){
            var badge = 'warning';
        }else if(dataresponse.data.StatusReg == 'PAYMENT'){
            var badge = 'danger';
        }else{
            var badge = 'default';
        }
        
        $('#statusreg').addClass('badge badge-'+badge);
        $("#tglawal").val(convertEntities(dataresponse.data.TglKunjungan));
                  var today = new Date();
                  var dd = String(today.getDate()).padStart(2, '0');
                  var mm = String(today.getMonth() + 1).padStart(2, '0');
                  var yyyy = today.getFullYear();
                  var datenow = yyyy +"-"+ mm +"-"+ dd;
        $("#tglakhir").val(datenow);
//new badrul UPDATE
        getDataDetailBilling();
        getDataRiwayatPayment();
}

function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/getDataPasienBebas';
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
             
             $("#grandTotalBillPerawataninput").val(total3);

             $("#grandTotalBillPerawataninputklaim").val(totalklaim);

             $("#grandTotalBillPerawataninputbayar").val(totalbayar);
         },
       });
       
} 

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
        // var xNoepisode = $('#NoEpisode').val();
        // var xNoMR = $('#NoMR').val();
        var xNamaPasien = $('#NamaPembeli').val();
        var xNamaJaminan = $('#Penjamin').val();
        // console.log(xNoMR);
        $('#bilNOreg').val(xNoreg);
        $('#bilNamaPasien').val(xNamaPasien);
        $('#bilNamaJaminan').val(xNamaJaminan);
        showdatafobill()
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
                var html  =
                // `<button type="button" onclick="printkuitansidetail('${row.NO_TRS}')" class="btn btn-warning border-warning btn-xs" style="min-width: 50px;"><i class="glyphicon glyphicon-print"> Kuitansi </i></button> 
                // <button type="button" onclick="printrinciandetail('${row.NO_TRS}')" class="btn btn-warning border-warning btn-xs" style="min-width: 50px;"><i class="glyphicon glyphicon-print">  Nota  </i></button>
                `<button type="button" onclick="btnbatalriwayatpembayaran('${row.NO_TRS}')" class="btn btn-danger border-danger btn-xs" style="min-width: 75px; margin-top: 2px;"><i class="glyphicon glyphicon-trash">  Batal  </i></button>`
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
        },

       });
}
// 22/08/2024
function goCetakKuitansiBynoKuitansi(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest){
    var base_url = window.location.origin;
    var jeniscetak = 'PrintKuitansi2';
    window.open(base_url + "/SIKBREC/public/aBillingPasien/"+jeniscetak+"/" + NO_KWITANSI +"/"+TIPE_PEMBAYARAN+"/"+NOMINAL_BAYAR+"/"+USER_KASIR+"/"+BILLTO+"/"+NO_TRS+"/"+NamaTest,"_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

async function goCetakKuitansiBynoKuitansix(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest) {

    try {
        const datagoCetakKuitansi = await goCetakKuitansi(NO_KWITANSI,TIPE_PEMBAYARAN,NOMINAL_BAYAR,USER_KASIR,BILLTO,NO_TRS,NamaTest);
        updateUIdatagoCetakKuitansi(datagoCetakKuitansi);
    } catch (err) {
        toast(err.message, "error")
    }
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
        "url": base_url + "/SIKBREC/public/aBillingPasien/getDataApproveFarmasiBebas", // URL file untuk proses select datanya
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
                            // { "data": "TransactionCode" },
                            { "data": "TransactionCode" },
                            { "data": "TglOrder" },
                            { "data": "Satuan_Beli" },
                            { "data": "ProductCode" },
                            { "data": "ProductName" },
                            { "data": "Qty" },
                            { "data": "Grandtotal", render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
                            // { "data": "NamaStatus" },
                            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                                var html = ""
                                  if(row.NamaStatus == "NEW"){ 
                                      var badge  = 'success'
                                  }else{
                                    var badge  = 'warning'
                                  }
                                  var html = '<span class="badge badge-'+badge+'">'+row.NamaStatus+'</span>'
                                     return html 
                              }
                          },
                           ],
     });
} 

async function BtnApprovePenjualanBebas(thisid) {
    // var data = $("#NoRegistrasi");
    var data = $("#NoRegistrasi").val();
    // var idbtn = $(thisid).attr("id");
    var idbtn = thisid;
    try {
        const dataApprovePenjualanBebasAll = await ApprovePenjualanBebas(data,idbtn);
        updateUIdataApprovePenjualanBebasAll(dataApprovePenjualanBebasAll);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataApprovePenjualanBebasAll(params) {
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

function ApprovePenjualanBebas(data,passingidbtn) {
    var idbtn = $(passingidbtn).attr("id");
    var noreg =  $("#NoRegistrasi").val();
    var datebill = $("#tglawal").val();
    var noeps = '-';
    var nomr = '-';
    var getreg = $("#NoRegistrasi").val().substring(0, 2);
    var GROUP_JAMINAN =  $('#GroupJaminan').val();
    var PatientType =  $('#GroupJaminan').val();
    var perusahaanid =  $('#penjamin_kode').val();
    var lokasipembelian =  $('#LokasiPembelian').val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aBillingPasien/ApprovePenjualanBebas';
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
        + '&PatientType=' + PatientType
        + '&perusahaanid=' + perusahaanid
        + '&lokasipembelian=' + lokasipembelian

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

async function printkuitansidetail(no_trs) {
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

    let url = base_url + '/SIKBREC/public/aBillingPasien/SetSaveBatalRiwayatPembayaranBebas';
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
    var jeniscetak = 'PrintKuitansiAllBebas';
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


function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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
                        var html = '<font size="1"> ' + row.KODE_TARIF + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.NAMA_TARIF + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.QTY + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.NILAI_TARIF + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.SUB_TOTAL + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.DISC + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) { // Tampilkan kolom aksi
                        var html = ""
                        var html = '<font size="1"> ' + row.SUB_TOTAL_2 + ' </font>  ';
                        return html
                    }
                },
                {
                    "render": function (data, type, row) {
                        var html = ""
                        var html = `<button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="deleteDataGroupShiftbyfo2('${row.ID }')" ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> &nbsp <button type="button" class="btn btn-default border-danger btn-animated btn-xs"  onclick="editDataGroupShiftbyfo2('${row.ID }','${row.KODE_TARIF }','${row.NAMA_TARIF }','${row.NILAI_TARIF }','${row.QTY }','${row.DISC }','${row.NILAI_PDP }')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>`
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

async function editDataGroupShiftbyfo2(id,kode,namatarif_fo2,NILAI_TARIF,QTY, DISC){
    $("#qty_fo2").attr('disabled', false);
    $("#diskon_fo2").attr('disabled', false);
    $("#btnupfo2update").attr('disabled', false);

    $("#id_fo2").val(convertEntities(id));
    $("#kodetarif_fo2").val(kode);
    $("#namatarif_fo2").val(namatarif_fo2);
    $("#nilai_fo2").val(NILAI_TARIF);
    $("#qty_fo2").val(number_to_price(QTY));
    $("#diskon_fo2").val(number_to_price(DISC));
    $("#nilaipdp_fo2").val(number_to_price(NILAI_PDP));
}

async function BtnCLoseClear(){
    $("#id_fo2").val('');
    $("#kodetarif_fo2").val('');
    $("#namatarif_fo2").val('');
    $("#qty_fo2").val('');
    $("#diskon_fo2").val('');
    $("#nilai_fo2").val('');
    $("#nilaipdp_fo2").val('');
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
                    $("#kodetarif_fo2").val('');
                    $("#namatarif_fo2").val('');
                    $("#qty_fo2").val('');
                    $("#diskon_fo2").val('');
                    $("#nilai_fo2").val('');
                    $("#nilaipdp_fo2").val('');
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
    var NILAI_TARIF = $('#nilai_fo2').val();
    var QTY = $('#qty_fo2').val();
    var DISCx = $('#diskon_fo2').val();
    var NILAI_PDP = $('#nilaipdp_fo2').val(); 
    var NoTRSBill1 = $('#NoTRSBill1').val();
    var Noreg = $('#NoRegistrasi').val();
    var TypePatientID = $('#GroupJaminan').val();
    

    var DISC = DISCx.replace(/,/g, '.');

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

async function btnrRefershTable(){
    getDataDetailBilling();
    getDataRiwayatPayment();
    getTotalPembayaran();
}

async function getTotalPembayaran(){
    try {   
        const datagetTotalPembayaranx = await getTotalPembayarandata();
        updateUIdatagetTotalPembayaran(datagetTotalPembayaranx);
    } catch (err) {
        toast(err.message, "error")
    }
}

async function updateUIdatagetTotalPembayaran(datagetTotalPembayaranx) {
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
}

function getTotalPembayarandata() {
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
async function btnCloseOrOpenBill(){
    try{
        const dataSaveCloseOrOpenBill = await SaveCloseOrOpenBill();
        updateUIdataSaveCloseOrOpenBill(dataSaveCloseOrOpenBill);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveCloseOrOpenBill() {
    var base_url = window.location.origin;

    var NoRegistrasi = $("#NoRegistrasi").val();
    var NoMR = '-';
    var Ket_btn_closeoropenbill = $("#Ket_btn_closeoropenbill").val();

    let url = base_url + '/SIKBREC/public/aBillingPasien/setSaveCloseOrOpenBillBebas';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'NoRegistrasi=' +  NoRegistrasi +
                '&Ket_btn_closeoropenbill=' + Ket_btn_closeoropenbill + 
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
