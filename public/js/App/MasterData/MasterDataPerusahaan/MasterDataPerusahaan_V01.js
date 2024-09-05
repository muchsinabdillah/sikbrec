$(document).ready(function () {
    asyncShowMain();
    // format number to price
    convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterPerusahaan();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function asyncShowMain() {
    try {
        await getHakAksesByForm(14);
        const dataGetRekeningPiutang = await getRekeningPiutang();
        const dataGetDataJaminan = await getDataJaminan();
        updateUIGetRekeningPiutang(dataGetRekeningPiutang);
        updateUIGetDataJaminan(dataGetDataJaminan);
        console.log(dataGetDataJaminan);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetDataJaminan(dataGetDataJaminan){
    let dataResponse = dataGetDataJaminan;
    if(dataResponse.data.ID === null){
        $("#ri_disc_sewaalat").val('0');
        $("#ri_disc_kamarperawatan").val('0');
        $("#ri_disc_tindakanoperasi").val('0');
        $("#special_benefit_silver").val('0');
        $("#special_benefit_gold").val('0');
        $("#ri_disc_administrasi").val('0');
        $("#ri_disc_lab").val('0');
        $("#ri_disc_radiologi").val('0');
        $("#ri_disc_resep").val('0');
        $("#ri_disc_jasadokter").val('0');
        $("#rj_disc_radiologi").val('0');
        $("#rj_disc_resep").val('0');
        $("#rj_disc_jasadokter").val('0');
        $("#rj_disc_sewaalat").val('0');
        $("#ri_disc_global").val('0');
    }else{
        $("#IdAuto").val(convertEntities(dataResponse.data.ID));
        $("#CPPerusahaan").val(convertEntities(dataResponse.data.ContacPerson));
        $("#TelpCPPerusahaan").val(convertEntities(dataResponse.data.TlpConcatP));
        $("#MasaBerlakuAwal").val(convertEntities(dataResponse.data.awal));
        $("#MasaBerlakuAkhir").val(convertEntities(dataResponse.data.akhir));
        $("#FaxPerusahaan").val(convertEntities(dataResponse.data.Fax));
        $("#NamaPerusahaan").val(convertEntities(dataResponse.data.NamaPerusahaan));
        $("#AlamatPerusahaan").val(convertEntities(dataResponse.data.Alamat));
        $("#KotaPerusahaan").val(convertEntities(dataResponse.data.Kota));
        $("#TelponPerusahaan").val(convertEntities(dataResponse.data.Telephone));
        $("#GenBP").val(convertEntities(dataResponse.data.Gen_BP)).trigger('change');
        $("#special_benefit_platinum").val(convertEntities(dataResponse.data.Special_benefit_Platinum));
        $("#special_benefit_diamond").val(convertEntities(dataResponse.data.Special_benefit_Diamond));
        $("#GruptarifPerusahaan").val(convertEntities(dataResponse.data.Group_Jaminan)).trigger('change');
        $("#AlamatPenagihan").val(convertEntities(dataResponse.data.Alamat_Penagihan));
        $("#KodeRekening").val(convertEntities(dataResponse.data.Rekening)).trigger('change');
        $("#ri_disc_sewaalat").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Sewaalat)));
        $("#ri_disc_kamarperawatan").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_KamarPerawatan)));
        $("#ri_disc_tindakanoperasi").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Operasi)));
        $("#special_benefit_silver").val(convertEntities(dataResponse.data.Special_benefit_Silver));
        $("#special_benefit_gold").val(convertEntities(dataResponse.data.Special_benefit_Gold));
        $("#ri_disc_administrasi").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Administrasi)));
        $("#ri_disc_lab").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Laboratorium)));
        $("#ri_disc_radiologi").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Radiologi)));
        $("#ri_disc_resep").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Resep)));
        $("#ri_disc_jasadokter").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_JasaDokter)));
        $("#rj_disc_radiologi").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Radiologi)));
        $("#rj_disc_resep").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Resep)));
        $("#rj_disc_jasadokter").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_JasaDokter)));
        $("#rj_disc_sewaalat").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Sewaalat)));
        $("#ri_disc_global").val(convertEntities(number_to_price(dataResponse.data.RI_Disc_Global)));
        $("#BenefitPerusahaan").val(convertEntities(dataResponse.data.Benefit));
        $("#StatusPerusahaan").val(convertEntities(dataResponse.data.StatusAktif)).trigger('change');
        $("#rj_disc_global").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Global)));
        $("#rj_disc_administrasi").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Administrasi)));
        $("#rj_disc_lab").val(convertEntities(number_to_price(dataResponse.data.RJ_Disc_Laboratorium)));
        $("#IDFormularium").val(convertEntities(dataResponse.data.IDFormularium)).trigger('change');
    }     
}
function getDataJaminan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataPerusahaan/getPerusahaanId/';
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
            $(".preloader").fadeOut();
        })
}
async function saveMasterPerusahaan() {
 
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataPerusahaan/addPerusahaan';

    // data form
    var rj_disc_global = price_to_number(document.getElementById("rj_disc_global").value);
    var rj_disc_administrasi = price_to_number(document.getElementById("rj_disc_administrasi").value);
    var rj_disc_lab = price_to_number(document.getElementById("rj_disc_lab").value);
    var rj_disc_radiologi = price_to_number(document.getElementById("rj_disc_radiologi").value);
    var rj_disc_resep = price_to_number(document.getElementById("rj_disc_resep").value);
    var rj_disc_jasadokter = price_to_number(document.getElementById("rj_disc_jasadokter").value);
    var rj_disc_sewaalat = price_to_number(document.getElementById("rj_disc_sewaalat").value);
    var ri_disc_global = price_to_number(document.getElementById("ri_disc_global").value);
    var ri_disc_administrasi = price_to_number(document.getElementById("ri_disc_administrasi").value);
    var ri_disc_lab = price_to_number(document.getElementById("ri_disc_lab").value);
    var ri_disc_radiologi = price_to_number(document.getElementById("ri_disc_radiologi").value);
    var ri_disc_resep = price_to_number(document.getElementById("ri_disc_resep").value);
    var ri_disc_jasadokter = price_to_number(document.getElementById("ri_disc_jasadokter").value);
    var ri_disc_sewaalat = price_to_number(document.getElementById("ri_disc_sewaalat").value);
    var ri_disc_kamarperawatan = price_to_number(document.getElementById("ri_disc_kamarperawatan").value);
    var ri_disc_tindakanoperasi = price_to_number(document.getElementById("ri_disc_tindakanoperasi").value);
    var IdAuto = document.getElementById("IdAuto").value;
    var NamaPerusahaan = document.getElementById("NamaPerusahaan").value;
    var AlamatPerusahaan = document.getElementById("AlamatPerusahaan").value;
    var AlamatPenagihan = document.getElementById("AlamatPenagihan").value;
    var KotaPerusahaan = document.getElementById("KotaPerusahaan").value;
    var TelponPerusahaan = document.getElementById("TelponPerusahaan").value;
    var FaxPerusahaan = document.getElementById("FaxPerusahaan").value;
    var CPPerusahaan = document.getElementById("CPPerusahaan").value;
    var TelpCPPerusahaan = document.getElementById("TelpCPPerusahaan").value;
    var MasaBerlakuAwal = document.getElementById("MasaBerlakuAwal").value;
    var MasaBerlakuAkhir = document.getElementById("MasaBerlakuAkhir").value;
    var BenefitPerusahaan = document.getElementById("BenefitPerusahaan").value;
    var special_benefit_silver = document.getElementById("special_benefit_silver").value;
    var special_benefit_gold = document.getElementById("special_benefit_gold").value;
    var special_benefit_platinum = document.getElementById("special_benefit_platinum").value;
    var special_benefit_diamond = document.getElementById("special_benefit_diamond").value; 
    var GenBP = document.getElementById("GenBP").value;
    var StatusPerusahaan = document.getElementById("StatusPerusahaan").value;
    var GruptarifPerusahaan = document.getElementById("GruptarifPerusahaan").value;
    var KodeRekening = document.getElementById("KodeRekening").value;
    var IDFormularium = document.getElementById("IDFormularium").value;

        return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto + "&rj_disc_global=" + rj_disc_global
            + "&rj_disc_administrasi=" + rj_disc_administrasi + "&rj_disc_lab=" + rj_disc_lab 
            + "&rj_disc_radiologi=" + rj_disc_radiologi
            + "&rj_disc_resep=" + rj_disc_resep + "&rj_disc_jasadokter=" + rj_disc_jasadokter
            + "&rj_disc_sewaalat=" + rj_disc_sewaalat + "&ri_disc_global=" + ri_disc_global
            + "&ri_disc_administrasi=" + ri_disc_administrasi + "&ri_disc_lab=" + ri_disc_lab
            + "&ri_disc_radiologi=" + ri_disc_radiologi + "&ri_disc_resep=" + ri_disc_resep
            + "&ri_disc_sewaalat=" + ri_disc_sewaalat + "&ri_disc_jasadokter=" + ri_disc_jasadokter
            + "&ri_disc_kamarperawatan=" + ri_disc_kamarperawatan + "&ri_disc_tindakanoperasi=" + ri_disc_tindakanoperasi
            + "&NamaPerusahaan=" + NamaPerusahaan + "&AlamatPerusahaan=" + AlamatPerusahaan
            + "&AlamatPenagihan=" + AlamatPenagihan + "&KotaPerusahaan=" + KotaPerusahaan
            + "&TelponPerusahaan=" + TelponPerusahaan + "&FaxPerusahaan=" + FaxPerusahaan 
            + "&CPPerusahaan=" + CPPerusahaan + "&TelpCPPerusahaan=" + TelpCPPerusahaan
            + "&MasaBerlakuAwal=" + MasaBerlakuAwal + "&MasaBerlakuAkhir=" + MasaBerlakuAkhir
            + "&BenefitPerusahaan=" + BenefitPerusahaan + "&StatusPerusahaan=" + StatusPerusahaan
            + "&GruptarifPerusahaan=" + GruptarifPerusahaan + "&KodeRekening=" + KodeRekening
            + "&GenBP=" + GenBP + "&IDFormularium=" + IDFormularium
            + "&special_benefit_silver=" + special_benefit_silver + "&special_benefit_gold=" + special_benefit_gold
            + "&special_benefit_platinum=" + special_benefit_platinum + "&special_benefit_diamond=" + special_benefit_diamond 
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        }) 
}
function updateUIGetRekeningPiutang(dataGetRekeningPiutang) {
    let data = dataGetRekeningPiutang;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekening").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekening").append(newRow);
        }
    }
}
function getRekeningPiutang() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/GetRekeningPiutang';
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
            $("#KodeRekening").select2();
            $("#StatusPerusahaan").select2();
            $("#GruptarifPerusahaan").select2();
            $("#GenBP").select2();
            $("#IDFormularium").select2();
            $(".preloader").fadeOut();
        })
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataPerusahaan";
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
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var rj_disc_global = document.getElementById("rj_disc_global");
    rj_disc_global.addEventListener("keyup", function (e) {
        rj_disc_global.value = formatRupiah(this.value);
    });
    var rj_disc_administrasi = document.getElementById("rj_disc_administrasi");
    rj_disc_administrasi.addEventListener("keyup", function (e) {
        rj_disc_administrasi.value = formatRupiah(this.value);
    });
    var rj_disc_lab = document.getElementById("rj_disc_lab");
    rj_disc_lab.addEventListener("keyup", function (e) {
        rj_disc_lab.value = formatRupiah(this.value);
    });
    var rj_disc_radiologi = document.getElementById("rj_disc_radiologi");
    rj_disc_radiologi.addEventListener("keyup", function (e) {
        rj_disc_radiologi.value = formatRupiah(this.value);
    });
    var rj_disc_resep = document.getElementById("rj_disc_resep");
    rj_disc_resep.addEventListener("keyup", function (e) {
        rj_disc_resep.value = formatRupiah(this.value);
    });
    var rj_disc_jasadokter = document.getElementById("rj_disc_jasadokter");
    rj_disc_jasadokter.addEventListener("keyup", function (e) {
        rj_disc_jasadokter.value = formatRupiah(this.value);
    });
    var rj_disc_sewaalat = document.getElementById("rj_disc_sewaalat");
    rj_disc_sewaalat.addEventListener("keyup", function (e) {
        rj_disc_sewaalat.value = formatRupiah(this.value);
    });
    var ri_disc_global = document.getElementById("ri_disc_global");
    ri_disc_global.addEventListener("keyup", function (e) {
        ri_disc_global.value = formatRupiah(this.value);
    });
    var ri_disc_administrasi = document.getElementById("ri_disc_administrasi");
    ri_disc_administrasi.addEventListener("keyup", function (e) {
        ri_disc_administrasi.value = formatRupiah(this.value);
    });
    var ri_disc_lab = document.getElementById("ri_disc_lab");
    ri_disc_lab.addEventListener("keyup", function (e) {
        ri_disc_lab.value = formatRupiah(this.value);
    });
    var ri_disc_radiologi = document.getElementById("ri_disc_radiologi");
    ri_disc_radiologi.addEventListener("keyup", function (e) {
        ri_disc_radiologi.value = formatRupiah(this.value);
    });
    var ri_disc_resep = document.getElementById("ri_disc_resep");
    ri_disc_resep.addEventListener("keyup", function (e) {
        ri_disc_resep.value = formatRupiah(this.value);
    });
    var ri_disc_jasadokter = document.getElementById("ri_disc_jasadokter");
    ri_disc_jasadokter.addEventListener("keyup", function (e) {
        ri_disc_jasadokter.value = formatRupiah(this.value);
    });
    var ri_disc_sewaalat = document.getElementById("ri_disc_sewaalat");
    ri_disc_sewaalat.addEventListener("keyup", function (e) {
        ri_disc_sewaalat.value = formatRupiah(this.value);
    });
    var ri_disc_kamarperawatan = document.getElementById("ri_disc_kamarperawatan");
    ri_disc_kamarperawatan.addEventListener("keyup", function (e) {
        ri_disc_kamarperawatan.value = formatRupiah(this.value);
    });
    var ri_disc_tindakanoperasi = document.getElementById("ri_disc_tindakanoperasi");
    ri_disc_tindakanoperasi.addEventListener("keyup", function (e) {
        ri_disc_tindakanoperasi.value = formatRupiah(this.value);
    });
}