$(document).ready(function () {
    asyncShowMain();
    // format number to price
    convertNumberToRp();
    // buton save ditekan
    // const saveButton = document.querySelector('#btnreservasi');
    // saveButton.addEventListener('click', async function () {
    //     try {
    //         const result = await saveDataBon();
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             setTimeout(function () { MyBack(); }, 1000);
    //         }
    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // })

    const saveButtonx = document.querySelector('#btnSave');
    saveButtonx.addEventListener('click', async function () {
        try {
            const result = await saveDataBon();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
                // asyncShowMain();
            }

        } catch (err) {

            toast(err, "error")
        }
    })
    // const saveButtony = document.querySelector('#btn_batal');
    // saveButtony.addEventListener('click', async function () {
    //     try {

    //         swal("Alasan Batal:", {
    //             content: "input",
    //             buttons:true,
    //           })
    //           .then((value) => {
    //               if (value == '' ){
    //                 swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
    //                 return false;
    //               }else if (value == null){
    //                 return false;
    //               }
    //               batalDataBon(value);
    //             //  const result = await batalDataBon(value);
    //             //   if (result.status == "success") {
    //             //       toast(result.message, "success")
    //             //       //setTimeout(function () { MyBack(); }, 1000);
    //             //       asyncShowMain();
    //             //   }
    //           });

            

    //     } catch (err) {

    //         toast(err, "error")
    //     }
    // })
});
async function asyncShowMain() {
    try {
        //await getHakAksesByForm(14);
        const datagetPegawai = await getPegawai();
        updateUIgetPegawai(datagetPegawai);
        // const datagetKodeJasa = await getKodeJasa(); 
        // updateUIgetKodeJasa(datagetKodeJasa);

        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);
        // const datagetGrupPerawatan = await getGrupPerawatan(); aa
        // updateUIgetGrupPerawatan(datagetGrupPerawatan);ssssss
        // getListDataOrderDetails();
        // getListDataHistori();
    $(".preloader").fadeOut();
    } catch (err) {
        // toast(err, "error")
    }
    function updateUIdatagetDatabyID(datagetDatabyID){
        let dataResponse = datagetDatabyID;

        // $pasing['ID'] = $data['ID'];
        // $pasing['No_Transaksi'] = $data['No_Transaksi'];
        // $pasing['No_Transaksi_Kasbon'] = $data['No_Transaksi_Kasbon'];
        // $pasing['Tgl_Transaksi'] = $data['Tgl_Transaksi'];
        // $pasing['Pegawai'] = $data['Pegawai'];
        // $pasing['Nominal'] = $data['Nominal'];
        // $pasing['Keterangan'] = $data['Keterangan'];
        // $pasing['STATUS'] = $data['STATUS'];
        // $pasing['NO_KASBON'] = $data['NO_KASBON'];
        // $pasing['Tgl_Input_First'] = $data['Tgl_Input_First'];
        // $pasing['Petugas_Input_First'] = $data['Petugas_Input_First'];
        // $pasing['ID_Group_Beban'] = $data['ID_Group_Beban'];
    
        $("#ID").val(convertEntities(dataResponse.data.ID));
        $("#No_Transaksi").val(convertEntities(dataResponse.data.No_Transaksi));
        $("#Tgl_Transaksi").val(convertEntities(dataResponse.data.Tgl_Transaksi));
        $("#Nominal").val(number_to_price(dataResponse.data.Nominal));
         $("#Pegawai").val(convertEntities(dataResponse.data.Pegawai)).trigger('change');
         $("#keterangan").val(convertEntities(dataResponse.data.Keterangan));
        
        //  $("#KodePDP").val(convertEntities(dataResponse.data.KD_PDP)).trigger('change');
        //  $("#KodeJasa").val(convertEntities(dataResponse.data.KD_JASA)).trigger('change');
    }
    
    function getDatabyID() {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/OrderBonSementara/getDataBonbyID/';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'id=' + $("#ID").val()
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
    function updateUIgetPegawai(datagetPegawai) {
        let data = datagetPegawai;
        if (data !== null && data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#Pegawai").append(newRow);
            for (i = 0; i < data.length; i++) {
                var newRow = '<option value="' + data[i].ID_Data + '">' + data[i].Nama + '</option';
                $("#Pegawai").append(newRow);
            }
        }
    }
    function getPegawai() {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/OrderBonSementara/getPegawai';
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
                $("#Pegawai").select2();
            })
    }
}
async function saveDataBon() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/OrderBonSementara/saveDataBon';

    // data form
    // var form_data = $("#form_cuti").serialize();
    var ID = $("#ID").val();
    var No_Transaksi = $("#No_Transaksi").val();
    var Tgl_Transaksi = $("#Tgl_Transaksi").val();
    var Nominal = price_to_number($("#Nominal").val());
    var Pegawai = $("#Pegawai").val();
    var keterangan = $("#keterangan").val(); 
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "ID=" + ID + "&No_Transaksi=" + No_Transaksi + "&Tgl_Transaksi=" + Tgl_Transaksi 
            + "&Nominal=" + Nominal + "&Pegawai=" + Pegawai + "&keterangan=" + keterangan
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

}
// async function batalDataBon(value) {

//     $(".preloader").fadeIn();
//     $('#btn_batal').html('Please Wait...');
//     $('#btn_batal').addClass('btn-danger');
//     document.getElementById("btn_batal").disabled = true;
//     var base_url = window.location.origin;
//     let url = base_url + '/SIKBREC/public/OrderBonSementara/batalDataBon';

    // data form
    
    //var form_data = $("#form_cuti").serialize();
    
    //var id_tarif = $("#IdAuto").val();
    // var id_layanan = $("#GrupPerawatan").val();
    // var kd_instalasi = $("#kd_instalasi").val();
    //console.log('sss');return false;
    
//     return fetch(url, {
//         method: 'POST',
//         headers: {
//             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
//         },
//         body: form_data + "&alasanbatal=" + value
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
//             $(".preloader").fadeOut();
//             $('#btn_batal').removeClass('btn-danger');
//             $('#btn_batal').html('Batal');
//             document.getElementById("btn_batal").disabled = false;

//             toast('Berhasil Disimpan', "success")
//             //       //setTimeout(function () { MyBack(); }, 1000);
//             //       asyncShowMain();
//         })

// }

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/OrderBonSementara/listOrderBon";
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
    var Nominal = document.getElementById("Nominal");
    Nominal.addEventListener("keyup", function (e) {
        Nominal.value = formatRupiah(this.value);
    });
}