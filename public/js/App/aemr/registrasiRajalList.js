$(document).ready(function () {
    document.getElementById("btnUpdateSEP").disabled = true;
    showDataPasienRajalAktif();
    $('#btnUpdateSEP').click(function(){
        swal({
                title: "Simpan",
                text: "Pastikan Data No. SEP terinput dengan Benar, Apakah Anda ingin Update No SEP ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            //goUpdateSEP();
                            goCekNoSEP();
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });

    });
    $('#btnSendAntrol').click(function () {
        BPJSCreateAntrian();
});

    $('#btnUpdateSEP_Manual').click(function () {
        swal("Alasan Edit:", {
            content: "input",
            buttons:true,
        })
        .then((value) => {
            if (value == '' ){
                swal("Alasan Edit Harus Diisi ! Simpan Gagal !");
                return false;
            }else if (value == null){
                return false;
            }
            goUpdateSEP_MasukRanap(value);
                });
        });
});
function showDataPasienRajalAktif() {
    var tglawal_Search = "";
    var tglakhir_Search = "";
    var base_url = window.location.origin;
    $('#tbl_aktif').DataTable().clear().destroy();
    $('#tbl_aktif').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiRajal/showDataPasienRajalAktif",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglawal_Search = tglawal_Search;
                d.tglakhir_Search = tglakhir_Search;
            }
        },
        "columns": [  
            { 
                "render": function (data, type, row) {
                    var html = ""
                    var html = `<div class="btn-group ">
                    <button type="button" class="btn btn-success btn-sm">${row.NoMR}</button>
                    <button type="button" class="btn btn-danger dropdown-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)" onclick="ViewPRB('${row.ID}')">PRB</a></li>
                    <li><a href="javascript:void(0)" onclick="ViewSkrinning('${row.ID}')">Skrining Batuk</a></li>
                    <li><a href="javascript:void(0)" onclick="ViewFormEdukasi('${row.ID}')" >Form Edukasi</a></li>
                    <li><a href="javascript:void(0)" onclick="ViewRencanaKontrol('${row.NoRegistrasi}') "  >Rencana Kontrol</a></li>
                    <li><a href="javascript:void(0)" onclick="PrintBuktiPelayananBPJS('${row.NoRegistrasi}')">Bukti Pelayanan BPJS</a></li>
                    <li><a href="javascript:void(0)" onclick="PrintSuketKontrolBPJS('${row.NoRegistrasi}')">Surat Keterangan Kontrol BPJS</a></li>
                    <li><a href="javascript:void(0)" onclick="frmUploadDocuments('${row.NoMR}')">Upload Document Pasien</a></li>

                    </ul>
                     </div>`;
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<font size= "2"><span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.ID+'","'+row.NoSEP+'","'+row.Perusahaan+'","'+row.NoRegistrasi+'","'+row.NoMR+'","'+row.NoPesertaBPJS+'")\'> '+row.PatientName+ '</span></font>'
                    return html
                }
            },
            { "data": "VisitDate" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Telemedicine =="TELEMEDICINE"){
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-danger">' + row.Telemedicine + '</span> ';
                        return html
                    }else{
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-info">' + row.Telemedicine + '</span> ';
                        return html
                    }
                    
                }
            },
            { "data": "DokterName" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Perusahaan + '</br> <b>' + row.NoSEP_edited + ' </b></font> <br><br><span class="label label-danger">' + row.Company + '</span> ';
                    return html
                }
            },
            { "data": "namauser" }, 
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowDataPasienPoliklinik(' + row.ID + ')" ><span class="visible-content" > View</span></button> &nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ShowHistoryDocuments("' +  row.NoRegistrasi + '")\' >'
                    return html
                }
                // "render": function (data, type, row) {
                //     var html = ""
                //     var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowDataPasienPoliklinik(' + row.ID + ')" ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ViewPRB(' + row.ID + ')" ><span class="visible-content" > PRB</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ViewSkrinning(' + row.ID + ')" ><span class="visible-content" > Skrinning</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>&nbsp<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ViewFormEdukasi(' + row.ID + ')" ><span class="visible-content" > Form Edukasi</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button><button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ViewRencanaKontrol("' +  row.NoRegistrasi + '")\'   ><span class="visible-content" > RENCANA KONTROL</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button><button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'PrintBuktiPelayananBPJS("' +  row.NoRegistrasi + '")\'   ><span class="visible-content" > Bukti Pelayanan BPJS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                //     return html
                // }
            },

        ]
    });
    $(".preloader").fadeOut();
    // console.log(frmUploadDocuments);
    // exit;
}
function showDataPasienRajalArsip() {
    $(".preloader").fadeIn();
    var tglAwalarsip = $("[name='tglAwalarsip']").val();
    var tglAkhirArsip = $("[name='tglAkhirArsip']").val();
    var base_url = window.location.origin;
    $('#tbl_arsip').DataTable().clear().destroy();
    $('#tbl_arsip').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/aRegistrasiRajal/showDataPasienRajalArsip",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.tglAwalarsip = tglAwalarsip;
                d.tglAkhirArsip = tglAkhirArsip;
            }
        },
        "columns": [
            { "data": "NoMR" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<font size= "2"><span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.ID+'","'+row.NoSEP+'","'+row.Perusahaan+'","'+row.NoRegistrasi+'","'+row.NoMR+'","'+row.NoPesertaBPJS+'")\'> '+row.PatientName+ '</span></font>'
                    return html
                }
            },
            { "data": "VisitDate" },
            { "data": "NoEpisode" },
            { "data": "NoRegistrasi" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.Telemedicine == "TELEMEDICINE") {
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-danger">' + row.Telemedicine + '</span> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.LokasiPasien + ' </font> <br><br><span class="label label-info">' + row.Telemedicine + '</span> ';
                        return html
                    }

                }
            },
            { "data": "DokterName" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Perusahaan + '</br> <b>' + row.NoSEP_edited + ' </b></font>  <br><br><span class="label label-danger">' + row.Company + '</span> ';
                    return html
                }
            },
            { "data": "namauser" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowDataPasienPoliklinik(' + row.ID + ')" ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button> <button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'PrintBuktiPelayananBPJS("' +  row.NoRegistrasi + '")\'   ><span class="visible-content" > Bukti Pelayanan BPJS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button><button type="button" class="btn btn-default border-primary btn-animated btn-xs" onclick=\'ViewRencanaKontrol("' +  row.NoRegistrasi + '")\'   ><span class="visible-content" > RENCANA KONTROL</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
}
function ShowDataPasienPoliklinik(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/' + str;
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/";
}

function ViewPRB(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + "/SIKBREC/public/xBPJSBridging_PRB/viewData/" + str;
}

function ViewSkrinning(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + "/SIKBREC/public/aFormSkrinning/" + str;
}
//alim
function ViewFormEdukasi(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + "/SIKBREC/public/form/" + str;
}
function ViewRencanaKontrol(str) {
    const base_url = window.location.origin;
 
    window.location = base_url + "/SIKBREC/public/aReservasiPasiennonWalkin/inputNoLogin/" + str;
}

function PrintBuktiPelayananBPJS(str) {
    const base_url = window.location.origin;
 
    url = base_url + "/SIKBREC/public/aKontrolUlang/CetakBuktiPelayananBPJS/" + str;

    var win = window.open(url, '_blank');
    win.focus()
}

function PrintSuketKontrolBPJS(str) {
    const base_url = window.location.origin;
 
    url = base_url + "/SIKBREC/public/aKontrolUlang/CetakBuktiSuketKontrol/" + str;

    var win = window.open(url, '_blank');
    win.focus()
}
function frmUploadDocuments(str) {
    // console.log(str);
    // exit;
    const base_url = window.location.origin;
    var str = btoa(str);
    
    window.location = base_url + '/SIKBREC/public/aMedicalRecord/frmUploadDocuments/' + str;
    var win = window.open(url, '_blank');
    win.focus()
}
function AkadIjaroh(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/Akadijaroh/" + str;

    var win = window.open(url);
    win.focus()
}

function GeneralConsen(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/GeneralConsern/" + str;

    var win = window.open(url);
    win.focus()
}

function HakdanKewajiban(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/HakdanKewajiban/" + str;

    var win = window.open(url);
    win.focus()
}

function TataTertib(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/TataTertib/" + str;

    var win = window.open(url);
    win.focus()
}

function PerkiraanBiayaNonOP(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PerkiraanBiayaNonOP/" + str;

    var win = window.open(url);
    win.focus()
}

function PerkiraanbiayaOP(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    url = base_url + "/SIKBREC/public/signatureDigital/PerkiraanbiayaOP/" + str;

    var win = window.open(url);
    win.focus()
}

function ShowHistoryDocuments(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/SignatureDigital/ListEdocuments/' + str;
}
async function Icare(noreg){
    try {
        $(".preloader").fadeIn(); 
        const xaddIcare = await addIcare(noreg);
        console.log(xaddIcare);
        updateIcare(xaddIcare);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateIcare(data){ 
    if(data.status == "success"){
        window.location = data.hasil;
        // swal({
        //     title: "success",
        //     text: "Data Berhasil dikirim Ke i-Care, Url : " + data.hasil,
        //     icon: "success", 
        //     dangerMode: true,
        // });
    }else{
        swal({
            title: "success",
            text: "Data Gagal dikirim Ke i-Care !",
            icon: "success", 
            dangerMode: true,
        });
    }
}
function addIcare(noreg) {
    var base_url = window.location.origin;
    var Noreg = noreg;  
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GoAddIcare';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },


        body: 'Noreg='+ Noreg
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
            // $('#notif_Cetak').modal('show'); 
        });
}
function updateDataSEP2(ID, sep, NamaJaminan,noreg,No_MR,NoPesertaBPJS){
    if(NamaJaminan == "BPJS Kesehatan"){
        $('#modal_edit_sep').modal('show');
        $('#frmUpdateSEP')[0].reset();
        $('#NOID_Reg').val(ID);
        $('#NoSEPLama').val(sep);
        $('#Noreg').val(noreg);
        $('#No_MR').val(No_MR);
        $('#NoPesertaBPJS').val(NoPesertaBPJS);

    }else{
        swal({
            title: "Warning",
            text: "Edit SEP Hanya Untuk Pasien BPJS Kesehatan !",
            icon: "warning", 
            dangerMode: true,
        });
    }
        
}


async function goUpdateSEP() {
    try {
        const dataUpdateNoSEP = await UpdateNoSEP();
        updateUIdataUpdateNoSEP(dataUpdateNoSEP);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

function updateUIdataUpdateNoSEP(params) {
    let response = params;
    // console.log(params);
   // toast(response.message, "success")
        if (response.status == 'success'){
            swal({
                title: "Save Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
                //location.reload();

                $("#modal_edit_sep").modal('hide');
                // $('#frmUpdateSEP').serialize();
                $('#modal_AntrolJenisKunungan').modal('show');
                // $('#frmUpdateSEP')[0].reset();
            //    $("#NoSEPBaru").val('');
            //    $("#keteranganprbBPJS").val('');
            //    $("#hakKelasBPJS").val('');
            });
        }else if (response.status = 'warning'){
            swal({
                title: 'Warning',
                text: response.message,
                icon: "warning",
            })
        }
    //var noregistrasi = response.NoRegistrasi; ;
}
function UpdateNoSEP() {
    $(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var jenisPencarian  = '2';
    var NoPesertaBPJS = $("#NoPesertaBPJS").val();
    var JenisRujukanFaskesBPJSx = '';
    var JenisPasien = 'RAJAL';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/UpdateNoSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&JenisPasien=" + JenisPasien + '&jenisPencarian=' + jenisPencarian + '&NoPesertaBPJS=' + NoPesertaBPJS + '&JenisRujukanFaskesBPJSx=' + JenisRujukanFaskesBPJSx
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

//CEK NO SEP---------------
async function goCekNoSEP() {
    try {
        const data = await CekNoSEP();
        updateUIdatagoCekNoSEP(data);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdatagoCekNoSEP(params) {
    let response = params;
        if (response.status == 'success'){
                goUpdateSEP();
        }else if (response.status = 'warning'){
                swal({
                    title: "Simpan",
                    text: response.message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                                goUpdateSEP();

                        } else {
                        // swal("Transaction Rollback !");
                        }
                    });
        }
    //var noregistrasi = response.NoRegistrasi; ;
}

function CekNoSEP() {
    //$(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var JenisPasien = 'RAJAL';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/CekNoSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&JenisPasien=" + JenisPasien
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
            } 
            return response
        })
        .finally(() => {
            //$(".preloader").fadeOut();
        })
}
//#END CEK NO SEP------------


async function verifySEp(){
    
    $(".preloader").fadeIn(); 
    const data = await getSEPbyNosep(); 
    updateUIgetSEPbyNosep(data); 

    const datasetDataSEPRujukanByID = await setDataSEPRujukanByID(); 
    updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID); 

 }

 function getSEPbyNosep() {
     
    var base_url = window.location.origin;
    var NoSEPBaru = $("#NoSEPBaru").val();
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/getSEPbyNosep/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoSEPBaru=' + NoSEPBaru 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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

        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
function updateUIgetSEPbyNosep(datasetDataSEPRujukanByID) {
    $(".preloader").fadeOut(); 
    //console.log(datasetDataSEPRujukanByID);return false;
    let data = datasetDataSEPRujukanByID.hasil;
    console.log(data.noSep);
    $("#hakKelasBPJS").val(data.peserta.hakKelas);
    $("#NoPesertaBPJS").val(data.peserta.noKartu); 
    

}

 function setDataSEPRujukanByID() {
     
    var base_url = window.location.origin;
    //var NoSEPBaru = $("#NoSEPBaru").val();
    var jenisPencarian  = '2';
    var NoPesertaBPJS = $("#NoPesertaBPJS").val();
    var JenisRujukanFaskesBPJSx = '';

    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GoBPJSCekKepesertaan/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'jenisPencarian=' + jenisPencarian + '&NoPesertaBPJS=' + NoPesertaBPJS + '&JenisRujukanFaskesBPJSx=' + JenisRujukanFaskesBPJSx
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
function updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID) {
    $(".preloader").fadeOut(); 
    let data = datasetDataSEPRujukanByID.hasil;
    let status = datasetDataSEPRujukanByID.status;
    if (status == "success" ){
        console.log(datasetDataSEPRujukanByID.hasil[1].peserta.informasi.prolanisPRB);
        $("#hakKelasBPJS").val(datasetDataSEPRujukanByID.hasil[1].peserta.hakKelas.keterangan);
        $("#keteranganprbBPJS").val(datasetDataSEPRujukanByID.hasil[1].peserta.informasi.prolanisPRB); 
        document.getElementById("btnUpdateSEP").disabled = false;
    }else{
        document.getElementById("btnUpdateSEP").disabled = true;
        $("#hakKelasBPJS").val('');
        $("#keteranganprbBPJS").val(''); 
    }
    
 
}
async function BPJSCreateAntrian(){
    try {
        $(".preloader").fadeIn(); 
        const dataTambahAntrianBPJS = await GoTambahAntrianBPJS();
        updateUIdataTambahAntrianBPJS(dataTambahAntrianBPJS);
        // $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function GoTambahAntrianBPJS() {
    var base_url = window.location.origin;
    var Noreg = document.getElementById("Noreg").value;
    var NoSEPBaru = $("#NoSEPBaru").val();
    // console.log(Noreg);exit;
    // var NamaJaminan = document.getElementById("shownamaperusahaanfix").value;
        var NamaJaminan = 'BPJS Kesehatan';
    var AntrolJenisKunungan = document.getElementById("AntrolJenisKunungan").value;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GoTambahAntrianBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },


        body: 'Noreg='+ Noreg + '&NoSEPBaru=' + NoSEPBaru + '&NamaJaminan=' + NamaJaminan + '&AntrolJenisKunungan=' + AntrolJenisKunungan
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
            // $('#notif_Cetak').modal('show'); 
        });
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

async function goUpdateSEP_MasukRanap(alasan) {
    try {
        const data = await UpdateSEP_MasukRanap(alasan);
        updateUIdataUpdateSEP_MasukRanap(data);

    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

function updateUIdataUpdateSEP_MasukRanap(params) {
    let response = params;
        if (response.status == 'success'){
            swal({
                title: "Save Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
                $("#modal_edit_sep").modal('hide');
                //$('#modal_AntrolJenisKunungan').modal('show');
            });
        }else if (response.status = 'warning'){
            swal({
                title: 'Warning',
                text: response.message,
                icon: "warning",
            })
        }
}
async function UpdateSEP_MasukRanap(alasan) {
    $(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize();
    var nosepbaru = '0000000000000000000';
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/UpdateNoSEP_MasukRanap';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str +"&alasan=" + alasan +"&nosep_baru="+ nosepbaru
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