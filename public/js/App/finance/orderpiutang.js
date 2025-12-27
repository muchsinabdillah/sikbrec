$(document).ready(function () {
    $("#btnCariMrx").click(function () {
      $("#modalcariDatapasien").modal("show");
    });
  
    // $('#print').click(function () {
    //     $("#modal_alert_print").modal('show')
    // });
  
    onLoadFunctionAll();
    // $('#tgltagih').attr('disabled', true);
    // $('#Periode').attr('disabled', true);
    // $('#Periode2').attr('disabled', true);
    // $('#JenisPenjamin').attr('disabled', true);
    // $('#Fs_Code_Jenis_Reg').attr('disabled', true);
    // $('#kodejaminan').attr('disabled', true);
    // $('#btnbatal').attr('disabled', true);
    // $('#btnSimpan').attr('disabled', true);
  
    $("#btnSimpan").click(function () {
      swal({
        title: "Simpan",
        text: "Pastikan Data yang dimasukan sudah sesuai, Lanjut Simpan?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          goCreateOrderPiutang();
        } else {
          // swal("Transaction Rollback !");
        }
      });
    });
    $("#print").click(function () {
      swal({
        buttons: {
          cancel: "Cancel",
          defeat: false,
          voucher: {
            text: "PRINT SURAT",
            value: "PRINTSURAT",
          },
          deposit: {
            text: "PRINT RINCIAN",
            value: "PRINTRINCIAN",
          },
        },
      }).then((value) => {
        switch (value) {
          case "PRINTSURAT":
            var base_url = window.location.origin;
            var jeniscetak = "PRINTSURAT";
            var NoJurnal = $("#NoTagihan").val();
            // var noreg = noregistrasi;
            window.open(
              base_url +
                "/SIKBREC/public/Piutang/" +
                jeniscetak +
                "/" +
                NoJurnal,
              "_blank",
              "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800"
            );
            break;
  
          case "PRINTRINCIAN":
            var base_url = window.location.origin;
            var jeniscetak = "PRINTRINCIAN";
            var NoJurnal = $("#NoTagihan").val();
            // var noreg = noregistrasi;
            window.open(
              base_url +
                "/SIKBREC/public/Piutang/" +
                jeniscetak +
                "/" +
                NoJurnal,
              "_blank",
              "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800"
            );
            break;
          default:
          // swal("Got away safely!");
        }
      });
    });
  
    $("#btnSearchMrAktif").click(function () {
      getDatOrderPiutang();
    });
    $(document).on("click", "#btnSyncTransaction", function () {
      var row_id = $(this).attr("value");
  
      // $("#TempNoTrsTagihan").val(row_id);
      ShowSyncTransaction(row_id);
      $("#modal_sync_transaction_owlexa").modal("show");
      // $('.modal-backdrop').hide();
    });
    $(document).on("click", "#btnUploadFiletoOwlexa", function () {
      var row_id = $(this).attr("value");
      // $("#TempNoTrsTagihan").val(row_id);
      // ShowOrderPiutangbyId(row_id);
      $("#modal_upload_document_owlexa").modal("show");
      // $('.modal-backdrop').hide();
    });
    $(document).on("click", "#btnFinalGenerate", function () {
      FinalGenerate();
  
      $("#modal_sync_transaction_owlexa").modal("hide");
      $(".modal-backdrop").hide();
    });
  
    $("#btnVoidTrsRegBatalHdr").click(function () {
      MyBack();
    });
    $("#synctransaction").click(function () {
      synctransaction();
    });
    // $('#btnFinalGenerate').click(function() {
    //     FinalGenerate();
    // });
    $("#kodejaminan").change(function () {
      //Some code
      var xx = $("#kodejaminan").val();
      $("#kodejaminantemp").val(xx);
      getIDPenjamin($("#JenisPenjamin").val());
  
      getalamatJaminan();
      LoadOrderPenagihanDetailByID();
    });
    $("#JenisPenjamin").click(function () {
      //Some code
      getIDPenjamin($("#JenisPenjamin").val());
    });
    $(document).on("click", "#passkodepox", function () {
      var row_id = $(this).attr("value");
      $("#TempNoTrsTagihan").val(row_id);
      ShowOrderPiutangbyId(row_id);
  
      $("#modalcariDatapasien").modal("hide");
      $(".modal-backdrop").hide();
    });
    $(document).on("click", "#passkodepo2", function () {
      var row_id = $(this).attr("value");
  
      bataltagih(row_id);
      // console.log(row_id);
      // return false;
    });
    $(document).on("click", "#passkodepo", function () {
      var row_id = $(this).attr("value");
  
      tagih(row_id);
      // console.log(row_id);
      // return false;
    });
    $(document).on("click", "#btnbatal", function () {
      var x = "2";
      var NoJurnal = $("#NoTagihan").val();
      $("#noregbatalHdr").val(NoJurnal);
    });
  
    $(document).on("click", "#btnVoidTrsRegHdr", function () {
      var noregbatal = $("#noregbatalHdr").val();
      var alasanbatal = $("#alasanbatalHdr").val();
      var x = "2";
      console.log(x, noregbatal, alasanbatal);
      voidRegistrasi();
    });
  });
  
  // async function btnSyncTransaction() {
  //     // const base_url = window.location.origin;
  //     $('#modal_sync_transaction_owlexa').modal('show');
  //     const dataGetMedicalRecordbyId = await GetMedicalRecordbyId();
  //     updateUIGetMedicalRecordbyId(dataGetMedicalRecordbyId);
  
  // }
  
  // function btnUploadFiletoOwlexa() {
  //     // const base_url = window.location.origin;
  //     $('#modal_upload_document_owlexa').modal('show');
  // }
  async function goCreateOrderPiutang() {
    try {
      // $(".preloader").fadeIn();
      const datagoFinishDetil = await goFinishDetil();
      updateUIdatagoFinish(datagoFinishDetil);
    } catch (err) {
      swal("Oops", "Sorry... " + err, "error");
  
      // toast(err, "error");
    }
  }
  function updateUIdatagoFinish(data) {
    if (data.status == "success") {
      toast("Data Berhasil Disimpan .", "success");
      setTimeout(() => {
        MyBack();
      }, 2000);
    } else {
      toast(data.message, "error");
    }
  }
  function goFinishDetil() {
    // var data = $("#form_order").serialize();
    var tgltagih = $("#tgltagih").val();
    var Periode = $("#Periode").val();
    var Periode2 = $("#Periode2").val();
    var JenisPenjamin = $("#JenisPenjamin").val();
    var NoSuratTagihan = $("#NoSuratTagihan").val();
    var NominalTagihan = $("#NominalTagihan").val();
    var kodejaminan = $("#kodejaminan").val();
    var NoTrsTagihan = $("#NoTrsTagihan").val();
    var Fs_Code_Jenis_Reg = $("#Fs_Code_Jenis_Reg").val();
    var alamattagih = $("#alamattagih").val();
  
    // var date = document.getElementById("TglTransaksi").value;
    // var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
  
    var url2 = "/SIKBREC/public/piutang/createOrderPiutang";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "tgltagih=" +
        tgltagih +
        "&NoSuratTagihan=" +
        NoSuratTagihan +
        "&NoTrsTagihan=" +
        NoTrsTagihan +
        "&NominalTagihan=" +
        NominalTagihan +
        "&Periode=" +
        Periode +
        "&Periode2=" +
        Periode2 +
        "&kodejaminan=" +
        kodejaminan +
        "&JenisPenjamin=" +
        JenisPenjamin +
        "&Fs_Code_Jenis_Reg=" +
        Fs_Code_Jenis_Reg +
        "&alamattagih=" +
        alamattagih,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
      });
  }
  
  function synctransaction() {
    var base_url = window.location.origin;
    var owlexa_cardnumber = $("#owlexa_cardnumber").val();
    var owlexa_claimnumber = $("#owlexa_claimnumber").val();
    var provideramount = $("#provideramount").val();
    var noregistrasi = $("#owlexa_provider_transasction_number").val();
    // console.log(noregistrasi);
    // return false;
  
    let url = base_url + "/SIKBREC/public/Piutang/synctransaction";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "owlexa_cardnumber=" +
        owlexa_cardnumber +
        "&owlexa_claimnumber=" +
        owlexa_claimnumber +
        "&provideramount=" +
        provideramount +
        "&noregistrasi=" +
        noregistrasi,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        //$("#alamattagih").val(data.Alamat);
      });
  }
  function FinalGenerate() {
    var base_url = window.location.origin;
    var owlexa_kode_piutang = $("#owlexa_kode_piutang").val();
  
    var owlexa_owlexaTransactionNumber = $(
      "#owlexa_owlexaTransactionNumber"
    ).val();
  
    // console.log(noregistrasi,provideramount,owlexa_claimnumber,owlexa_cardnumber);
    // return false;
  
    let url = base_url + "/SIKBREC/public/Piutang/FinalGenerate";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "owlexa_owlexaTransactionNumber=" +
        owlexa_owlexaTransactionNumber +
        "&owlexa_kode_piutang=" +
        owlexa_kode_piutang,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        //$("#alamattagih").val(data.Alamat);
      });
  }
  ////////
  
  async function ShowSyncTransaction(row_id) {
    try {
      const datagetShowSyncTransaction = await getShowSyncTransaction(row_id);
      updateShowSyncTransaction(datagetShowSyncTransaction);
    } catch (err) {
      toast(err, "error");
    }
  }
  
  function updateShowSyncTransaction(datagetShowSyncTransaction) {
    // console.log(datagetShowSyncTransaction);
    // return false;
    $("#owlexa_kode_piutang").val(datagetShowSyncTransaction.owlexa_kode_piutang);
  
    $("#owlexa_provider_transasction_number").val(
      datagetShowSyncTransaction.NO_TRANSAKSI
    );
    $("#owlexa_cardnumber").val(datagetShowSyncTransaction.NoKartu);
    $("#owlexa_provideramount").val(datagetShowSyncTransaction.fn_piutang);
  }
  function getShowSyncTransaction(row_id) {
    var owlexa_kode_piutang = row_id;
  
    var url2 = "/SIKBREC/public/piutang/getShowSyncTransaction";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "owlexa_kode_piutang=" + owlexa_kode_piutang,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
      });
  }
  //////////////
  async function bataltagih(row_id) {
    try {
      const databataltagih = await bataltagih(row_id);
      updateUIdatabataltagih(databataltagih);
    } catch (err) {
      swal("Oops", "Sorry... " + err, "error");
    }
  }
  function bataltagih(row_id) {
    // console.log(row_id);
    // return false;
    var NoTrs = row_id;
  
    var tgltagih = $("#tgltagih").val();
    var Periode = $("#Periode").val();
    var Periode2 = $("#Periode2").val();
    var JenisPenjamin = $("#JenisPenjamin").val();
    var NoSuratTagihan = $("#NoSuratTagihan").val();
    var NominalTagihan = $("#NominalTagihan").val();
    var kodejaminan = $("#kodejaminan").val();
    var NoTagihan = $("#NoTagihan").val();
    var base_url = window.location.origin;
    let url = base_url + "/SIKBREC/public/Piutang/bataltagih";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "NoTrs=" +
        NoTrs +
        "&tgltagih=" +
        tgltagih +
        "&Periode=" +
        Periode +
        "&Periode2=" +
        Periode2 +
        "&JenisPenjamin=" +
        JenisPenjamin +
        "&NoSuratTagihan=" +
        NoSuratTagihan +
        "&NominalTagihan=" +
        NominalTagihan +
        "&kodejaminan=" +
        kodejaminan +
        "&NoTagihan=" +
        NoTagihan,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
        LoadOrderPenagihanDetailByID();
      });
  }
  function updateUIdatabataltagih(databataltagih) {
    let params = databataltagih;
    swal("Good job!", params.message + " !", "success").then((value) => {
      $("#NominalTagihan").val(data.nilaipiutangtagih);
    });
  }
  /////////////
  async function tagih(row_id) {
    try {
      const datatagih = await tagih2(row_id);
      updateUIdatatagih(datatagih);
    } catch (err) {
      swal("Oops", "Sorry... " + err, "error");
    }
  }
  function tagih2(row_id) {
    // console.log(row_id);
    // return false;
    var NoTrs = row_id;
  
    var tgltagih = $("#tgltagih").val();
    var Periode = $("#Periode").val();
    var Periode2 = $("#Periode2").val();
    var JenisPenjamin = $("#JenisPenjamin").val();
    var NoSuratTagihan = $("#NoSuratTagihan").val();
    var NominalTagihan = $("#NominalTagihan").val();
    var kodejaminan = $("#kodejaminan").val();
    var NoTagihan = $("#NoTagihan").val();
    var Fs_Code_Jenis_Reg = $("#Fs_Code_Jenis_Reg").val();
    var alamattagih = $("#alamattagih").val();
  
    var base_url = window.location.origin;
    let url = base_url + "/SIKBREC/public/Piutang/tagih";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "NoTrs=" +
        NoTrs +
        "&tgltagih=" +
        tgltagih +
        "&Periode=" +
        Periode +
        "&Periode2=" +
        Periode2 +
        "&JenisPenjamin=" +
        JenisPenjamin +
        "&NoSuratTagihan=" +
        NoSuratTagihan +
        "&NominalTagihan=" +
        NominalTagihan +
        "&kodejaminan=" +
        kodejaminan +
        "&NoTagihan=" +
        NoTagihan +
        "&Fs_Code_Jenis_Reg=" +
        Fs_Code_Jenis_Reg +
        "&alamattagih=" +
        alamattagih,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
        LoadOrderPenagihanDetailByID();
      });
  }
  function updateUIdatatagih(datatagih) {
    let params = datatagih;
    swal("Good job!", params.message + " !", "success").then((value) => {
      $("#NominalTagihan").val(params.NominalTagihan);
    });
  }
  
  async function voidRegistrasi() {
    try {
      const dataVoidRegistrasi = await VoidRegistrasi();
      updateUIdataVoidRegistrasi(dataVoidRegistrasi);
    } catch (err) {
      swal("Oops", "Sorry... " + err, "error");
    }
  }
  function VoidRegistrasi() {
    var noregbatal = $("#noregbatalHdr").val();
    var alasanbatal = $("#alasanbatalHdr").val();
    var base_url = window.location.origin;
    let url = base_url + "/SIKBREC/public/Piutang/VoidRegistrasi";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "alasanbatal=" + alasanbatal + "&noregbatal=" + noregbatal,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
        // document.getElementById("frmKartuRSYarsi").reset();
        // $('#Modal_Karyawn_Polis').modal('hide');
      });
  }
  function updateUIdataVoidRegistrasi(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
    swal("Good job!", params.message + " !", "success").then((value) => {
      var noregbatal = $("#noregbatalHdr").val();
      var alasanbatal = $("#alasanbatalHdr").val();
      MyBack();
    });
  }
  async function BtnNewInput(id) {
    try {
      var datagetNoTagihan = await getNoTagihan(id);
      updateUIgetNoTagihan(datagetNoTagihan);
    } catch (err) {
      toast(err, "error");
    }
  }
  function updateUIgetNoTagihan(datagetNoTagihan) {
    let responseApi = datagetNoTagihan;
    // console.log(responseApi.data.NoTagihan);
    $("#NoTagihan").val(convertEntities(responseApi.data.NoTagihan));
    $("#tgltagih").attr("disabled", false);
    $("#Periode").attr("disabled", false);
    $("#Periode2").attr("disabled", false);
    $("#JenisPenjamin").attr("disabled", false);
    $("#Fs_Code_Jenis_Reg").attr("disabled", false);
    $("#kodejaminan").attr("disabled", false);
    $("#btnnew").attr("disabled", true);
    $("#btnbatal").attr("disabled", false);
    $("#btnSimpan").attr("disabled", false);
  
    // searchTindakan();
    // searchDokter();
  }
  
  function getNoTagihan(id) {
    var base_url = window.location.origin;
    var NoTagihan = $("#NoTagihan").val();
  
    var tglbill = $("#dateabilling").val();
    var tglbill2 = $("#dateabilling").val() + " " + $("#timeabilling").val();
    var timeabilling = $("#timeabilling").val();
    var NoRegistrasi = $("#NoRegistrasi").val();
    var NoEpisode = $("#NoEpisode").val();
    var NoMR = $("#NoMR").val();
    var GroupJaminan = $("#TypePatientID").val();
    var penjamin_kode = $("#penjamin_kode").val();
    var IDUnit = $("#IDUnit").val();
    // var kodereg = $("#NoRegistrasi").val().slice(0, 2);
  
    let url = base_url + "/SIKBREC/public/Piutang/newInsertTagihan";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body:
        "ID=" +
        id +
        "&tglbill=" +
        tglbill +
        "&NoRegistrasi=" +
        NoRegistrasi +
        "&NoEpisode=" +
        NoEpisode +
        "&NoMR=" +
        NoMR +
        "&GroupJaminan=" +
        GroupJaminan +
        "&penjamin_kode=" +
        penjamin_kode +
        "&IDUnit=" +
        IDUnit +
        "&timeabilling=" +
        timeabilling +
        "&tglbill2=" +
        tglbill2 +
        "&NoTagihan=" +
        NoTagihan,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
      });
  }
  async function BtnGennow() {
    try {
      var datagetGennow = await getGennow();
      updateUIgetGennow(datagetGennow);
    } catch (err) {
      toast(err, "error");
    }
  }
  
  function updateUIgetGennow(datagetGennow) {
    let responseApi = datagetGennow;
    $("#NoSuratTagihan").val(convertEntities(responseApi.AutoNumberBAFix));
    $("#Fs_Code_Jenis_Reg").attr("disabled", true);
    $("#btngen").attr("disabled", true);
    $("#NoSuratTagihan").attr("disabled", true);
    $("#tgltagih").attr("disabled", true);
    $("#Periode").attr("disabled", true);
    $("#Periode2").attr("disabled", true);
    $("#JenisPenjamin").attr("disabled", true);
    $("#kodejaminan").attr("disabled", true);
  
    // searchTindakan();
    // searchDokter();
  }
  
  function getGennow() {
    var base_url = window.location.origin;
    var Fs_Code_Jenis_Reg = $("#Fs_Code_Jenis_Reg").val();
  
    let url = base_url + "/SIKBREC/public/Piutang/newInsertGennow";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "Fs_Code_Jenis_Reg=" + Fs_Code_Jenis_Reg,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
      });
  }
  async function getalamatJaminan() {
    try {
      const datagetalamatJaminan = await getalamatJamin();
      updateUIdatagetalamatJaminan(datagetalamatJaminan);
    } catch (err) {
      swal("Oops", "Sorry... " + err, "error");
    }
  }
  
  function getalamatJamin() {
    var base_url = window.location.origin;
    var kodejaminan = $("#kodejaminantemp").val();
    var JenisPenjamin = $("#JenisPenjamin").val();
  
    let url = base_url + "/SIKBREC/public/Piutang/getalamatJaminan";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "JenisPenjamin=" + JenisPenjamin + "&kodejaminan=" + kodejaminan,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        // $("#alamattagih").val(data.Alamat);
      });
  }
  function updateUIdatagetalamatJaminan(datagetalamatJaminan) {
    let params = datagetalamatJaminan;
    console.log(params);
    swal("Good job!", params.message + " !", "success").then((value) => {
      // $("#NominalTagihan").val(data.nilaipiutangtagih);
      $("#alamattagih").val(params.Alamat);
    });
  }
  async function getIDPenjamin(jenispenjamin) {
    try {
      const datagetNamaPenjamin = await getNamaPenjamin(jenispenjamin);
      updateUIgetNamaPenjamin(datagetNamaPenjamin);
      $(".preloader").fadeOut();
    } catch (err) {
      toast(err, "error");
    }
  }
  
  function getNamaPenjamin(jenispenjamin) {
    var base_url = window.location.origin;
    // var FS_JENIS_CUSTOMER = $('#FS_JENIS_CUSTOMER').val();
    // var FS_KD_CUSTOMER = $('#FS_KD_CUSTOMER').val();
  
    let url = base_url + "/SIKBREC/public/Piutang/getNamaPenjamin";
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "JenisPenjamin=" + jenispenjamin,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $("#kodejaminan").select2();
      });
  }
  
  function updateUIgetNamaPenjamin(datagetNamaPenjamin) {
    let responseApi = datagetNamaPenjamin;
    if (responseApi.data !== null && responseApi.data !== undefined) {
      //console.log(responseApi.data);
      // $("#kodejaminan").empty();
      var newRow = '<option value="">-- PILIH --</option';
      $("#kodejaminan").append(newRow);
      for (i = 0; i < responseApi.data.length; i++) {
        var newRow =
          '<option value="' +
          responseApi.data[i].ID +
          '">' +
          responseApi.data[i].NamaPerusahaan +
          "</option";
        $("#kodejaminan").append(newRow);
      }
    }
  }
  async function ShowOrderPiutangbyId(row_id) {
    try {
      const datagetOrderPiutangbyId = await getOrderPiutangbyId(row_id);
      updateOrderPiutangbyId(datagetOrderPiutangbyId);
    } catch (err) {
      toast(err, "error");
    }
  }
  
  async function updateOrderPiutangbyId(datagetOrderPiutangbyId) {
    await getIDPenjamin(datagetOrderPiutangbyId.FS_JENIS_CUSTOMER);
  
    $("#NoTagihan").val(datagetOrderPiutangbyId.FS_KD_TRS);
    $("#tgltagih").val(datagetOrderPiutangbyId.FD_TGL_TRS);
    $("#JenisPenjamin")
      .val(datagetOrderPiutangbyId.FS_JENIS_CUSTOMER)
      .trigger("change");
    //setTimeout(function() {
    //}, 100);
    console.log("idasuransi", datagetOrderPiutangbyId.FS_KD_CUSTOMER);
    // $('#kodejaminan').val(datagetOrderPiutangbyId.FS_KD_CUSTOMER).trigger('change');
    $("#kodejaminantemp").val(datagetOrderPiutangbyId.FS_KD_CUSTOMER);
    $("#NoSuratTagihan").val(datagetOrderPiutangbyId.FS_KET);
    $("#NominalTagihan").val(datagetOrderPiutangbyId.FN_TOTAL_TAGIH);
    $("#Periode2").val(datagetOrderPiutangbyId.fd_periode2);
    $("#Periode").val(datagetOrderPiutangbyId.fd_periode1);
    $("#Fs_Code_Jenis_Reg").val(datagetOrderPiutangbyId.Fs_Code_Jenis_Reg);
  
    $("#alamattagih").val(datagetOrderPiutangbyId.FS_Alamat_Tagih);
    $("#btnnew").attr("disabled", true);
    $("#btngen").attr("disabled", true);
    $("#btnbatal").attr("disabled", false);
    $("#btnSimpan").attr("disabled", false);
    document.getElementById("btnnew").disabled = true;
    document.getElementById("btngen").disabled = true;
  
    $("#kodejaminan")
      .val(datagetOrderPiutangbyId.FS_KD_CUSTOMER)
      .trigger("change");
  
    // $("#NoTagihan").val(datagetOrderPiutangbyId.FS_KD_TRS);
    // $("#NoTagihan").val(datagetOrderPiutangbyId.FS_KD_TRS);
  
    //   $("#NoSuratTagihan").val(datagetOrderPiutangbyId.FS_KET);
    //   $("#tgltagih").val(datagetOrderPiutangbyId.FD_TGL_TRS);
    //   $("#NominalTagihan").val(datagetOrderPiutangbyId.FN_TOTAL_TAGIH);
    //   $("#Periode").val(datagetOrderPiutangbyId.fd_periode1);
    //   $("#Periode2").val(datagetOrderPiutangbyId.fd_periode2);
    //   $("#alamattagih").val(datagetOrderPiutangbyId.FS_Alamat_Tagih);
    //   $("#Fs_Code_Jenis_Reg").val(datagetOrderPiutangbyId.Fs_Code_Jenis_Reg);
    //   $('#kodejaminan').val(datagetOrderPiutangbyId.NamaPerusahaan);
    //   $('#kodejaminantemp').val(datagetOrderPiutangbyId.FS_KD_CUSTOMER);
  
    //   $("#JenisPenjamin").val(datagetOrderPiutangbyId.FS_JENIS_CUSTOMER).trigger('change');
    //  $("#ket").val(datagetOrderPiutangbyId.FS_ALASAN);
    //   LoadOrderPenagihanDetailByID();
    //   getalamatJaminan();
  }
  function getOrderPiutangbyId(row_id) {
    var NoTrs = row_id;
    var url2 = "/SIKBREC/public/piutang/getOrderPiutangbyId";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: "NoTrs=" + NoTrs,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(response.statusText);
        }
        return response.json();
      })
      .then((response) => {
        if (response.status === "error") {
          throw new Error(response.message.errorInfo[2]);
          // console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
          throw new Error(response.errorname);
          // console.log("ok " + response.message.errorInfo[2])
        }
        return response;
      })
      .finally(() => {
        $(".preloader").fadeOut();
      });
  }
  function LoadOrderPenagihanDetailByID() {
    var JenisRegistrasi = $("#Fs_Code_Jenis_Reg").val();
    var JenisPenjamin = $("#JenisPenjamin").val();
    var TglPeriode1 = $("#Periode").val();
    var TglPeriode2 = $("#Periode2").val();
    var kodejaminan = $("#kodejaminantemp").val();
    var TempNoTrsTagihan = $("#TempNoTrsTagihan").val();
  
    $("#table-id2")
      .dataTable({
        bDestroy: true,
      })
      .fnDestroy();
    $("#table-id2").DataTable({
      order: [[6, "desc"]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      ajax: {
        url: "/SIKBREC/public/piutang/caridataPasienTagihlAll",
        type: "POST",
        dataSrc: "",
        deferRender: true,
        data: function (d) {
          d.myKey = TempNoTrsTagihan;
          d.JenisRegistrasi = JenisRegistrasi;
          d.JenisPenjamin = JenisPenjamin;
          d.TglPeriode2 = TglPeriode2;
          d.TglPeriode1 = TglPeriode1;
          d.kodejaminan = kodejaminan;
        },
      },
      columns: [
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.KD_PIUTANG + "</font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.FD_TGL_PIUTANG + "</font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.NoRegistrasi + "</font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.PatientName + "</font>";
            return html;
          },
        },
        {
          data: "Fn_piutang",
          render: $.fn.dataTable.render.number(",", ".", 2, ""),
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.FS_NO_REFF_BRIDGING + "</font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            if (row.FB_TAGIH == "1") {
              // Jika jenis kelaminnya 1
              var html =
                '<a class="btn btn-danger dropdown-toggle" id="passkodepo2" name="passkodepo2" value=' +
                row.KD_PIUTANG +
                ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BATAL</a>';
            } else {
              // Jika bukan 1
              var html =
                '<a class="btn btn-success dropdown-toggle" id="passkodepo" name="passkodepo"  value=' +
                row.KD_PIUTANG +
                ">TAGIH</a>";
            }
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            if (row.FB_TAGIH == "1") {
              // Jika jenis kelaminnya 1
              // var html =
              // `<div class="dropdown">
              // <button class="btn btn-success dropdown-toggle" type="button" id="btnSyncTransactiontemp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-cog"></span> OWLEXA</button>
              // <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              // <li><a href="#modal_upload_document_owlexa" onclick="ViewPRB('${row.KD_PIUTANG}')">PRB</a></li>
  
              // <li><a  href="#modal_sync_transaction_owlexa"  data-toggle="modal" id="btnSyncTransaction" name="btnSyncTransaction"  value=' +
              //     row.KD_PIUTANG +'>Sync Transaction</a></li>
              // <li><a href="#modal_upload_document_owlexa"  data-toggle="modal" id="btnUploadFiletoOwlexa" name="btnUploadFiletoOwlexa"  value=' + row.KD_PIUTANG + '>Upload Document</a></li></ul></div>`;
              var html =
                '<a class="btn btn-success dropdown-toggle" id="btnSyncTransaction" name="btnSyncTransaction" value=' +
                row.KD_PIUTANG +
                ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sync Transaction</a><a class="btn btn-warning dropdown-toggle" id="btnUploadFiletoOwlexa" name="btnUploadFiletoOwlexa" value=' +
                row.KD_PIUTANG +
                ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload Document</a>';
              // var html = '<button type="button" class="btn btn-success border-primary btn-animated btn-xs"  onclick=\'btnSyncTransaction("' + row.KD_PIUTANG + '")\' ><span class="glyphicon glyphicon-cog" >Sync Transaction</span></button> &nbsp<button type="button" class="btn btn-success border-primary btn-animated btn-xs" onclick=\'btnUploadFiletoOwlexa("' +  row.KD_PIUTANG + '")\' ><span class="glyphicon glyphicon-cog" >Upload Document</span></button>'
            }
            return html;
          },
        },
      ],
    });
  }
  function loadOrderByID(x) {
    var nf = new Intl.NumberFormat();
    var ID = x;
    $("#table-load-data")
      .dataTable({
        bDestroy: true,
      })
      .fnDestroy();
    $("#table-load-data").DataTable({
      order: [[0, "desc"]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
  
      ajax: {
        url: "/SIKBREC/public/piutang/getOrderPiutangDetailbyId",
        type: "POST",
        data: function (d) {
          d.ID = ID;
        },
        dataSrc: "",
        deferRender: true,
      },
      columns: [
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.KD_HUTANG + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.TGL_HUTANG + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="2">' + row.KET + " </font>";
            return html;
          },
        },
        {
          data: "NILAI_HUTANG",
          render: $.fn.dataTable.render.number(",", ".", 2, "Rp "),
        },
      ],
      footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
          data;
  
        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\$,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };
        total3 = api
          .column(2)
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
  
        // Update footer
        $(api.column(2).footer()).html(
          $.fn.dataTable.render.number(",", ".", "2", "Rp. ").display(total3)
        );
      },
      dom: "Bfrtip",
      buttons: ["colvis"],
    });
  }
  
  function getDatOrderPiutang() {
    var tglperiodex = $("[name='PeriodePencarian']").val();
    $("#table-load-data-detilxx")
      .dataTable({
        bDestroy: true,
      })
      .fnDestroy();
    $("#table-load-data-detilxx").DataTable({
      order: [[0, "desc"]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
  
      ajax: {
        url: "/SIKBREC/public/Piutang/getListOrderPiutangJatuhTempo",
        type: "POST",
        data: function (d) {
          d.Periode = tglperiodex;
        },
        dataSrc: "",
        deferRender: true,
      },
      columns: [
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="1">' + row.ID + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="1">' + row.FS_KD_TRS + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="1">' + row.FD_TGL_TRS + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="1">' + row.NamaPerusahaan + " </font>";
            return html;
          },
        },
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
            var html = '<font size="1">' + row.FS_KET + " </font>";
            return html;
          },
        },
        {
          data: "FN_TOTAL_TAGIH",
          render: $.fn.dataTable.render.number(".", ",", 0, ""),
        }, // Tampilkan nama
  
        {
          render: function (data, type, row) {
            // Tampilkan kolom aksi
            var html = "";
  
            var html =
              '<a class="btn btn-danger" id="passkodepox" name="passkodepox"  value=' +
              row.ID +
              ">PILIH</a> ";
            return html;
          },
        },
      ],
      dom: "Bfrtip",
      buttons: ["colvis"],
    });
  }
  
  function MyBack() {
    const base_url = window.location.origin;
    window.location =
      base_url + "/SIKBREC/public/Piutang/listOrderPembayaranPiutang";
  }
  
  async function onLoadFunctionAll() {
    try {
      // const datagetalamatJaminan = await getalamatJamin();
      // updateUIdatagetalamatJaminan(datagetalamatJaminan);
      // const datagetNamaPenjamin = await getNamaPenjamin();
      // updateUIgetNamaPenjamin(datagetNamaPenjamin);
      // const datagetSuppliers = await getSuppliers();
      // updateUIdatagetSuppliers(datagetSuppliers);
      $("#tgltagih").attr("disabled", true);
      $("#Periode").attr("disabled", true);
      $("#Periode2").attr("disabled", true);
      $("#JenisPenjamin").attr("disabled", true);
      $("#Fs_Code_Jenis_Reg").attr("disabled", true);
      $("#kodejaminan").attr("disabled", true);
      $("#btnbatal").attr("disabled", true);
      $("#btnSimpan").attr("disabled", true);
      // if ($("#No_Transaksi").val() != '') {
      //     const datagetTukarFakturHeader = await getTukarFakturHeader();
      //     updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
      // }
      $(".preloader").fadeOut();
    } catch (err) {
      toast(err, "error");
    }
  }
  
  // function updateUIdatagetSuppliers(responseApi) {
  //     if (responseApi.data !== null && responseApi.data !== undefined) {
  //         // console.log(responseApi.data);
  //         var newRow = '<option value="">-- PILIH --</option';
  //         $("#NamaSupplier").append(newRow);
  //         for (i = 0; i < responseApi.data.length; i++) {
  //             var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
  //             $("#NamaSupplier").append(newRow);
  //         }
  //     }
  // }
  // function getSuppliers() {
  //     var base_url = window.location.origin;
  //     let url = base_url + '/SIKBREC/public/aPurchaseOrder/getSuppliers';
  //     return fetch(url, {
  //         method: 'POST',
  //         headers: {
  //             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
  //         },
  //         body: 'id=' + $("#IdAuto").val()
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
  //             $("#NamaSupplier").select2();
  //         })
  // }
  
  //
  
  // Primary function always
  function toast(data, status) {
    toastr.options = {
      closeButton: true,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "3500",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    toastr[status](data);
  }
  function convertEntities($data) {
    $xonvert = $("<textarea />").html($data).text();
    return $xonvert;
  }
  function number_to_price(v) {
    if (v == 0) {
      return "0,00";
    }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split(".").join("*").split(",").join(".").split("*").join(",");
    return v;
  }
  function price_to_number(v) {
    if (!v) {
      return 0;
    }
    v = v.split(".").join("");
    v = v.split(",").join(".");
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
  