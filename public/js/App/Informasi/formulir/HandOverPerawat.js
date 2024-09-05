$(document).ready(function () {
    // asyncShowMain();
    $(".preloader").fadeOut(); 
   
    $(document).on('click', '#btnLoadfHandoverPerawat', function () {
        //checking before get data
        CheckVar();
    });
});
function CheckVar (){
    //if not in creteria return false
    if ($("#Ruangan").val() == ''){
        toast ('Ruangan Harap Diisi', "warning");
        return false;
    }
    if ($("#Tanggal").val() == ''){
        toast ('Tanggal Harap Diisi', "warning");
        return false;
    } 
    if ($("#Jadwal_Shift").val() == ''){
        toast ('Jadwal Shift Harap Diisi', "warning");
        return false;
    }
    if ($("#Hari_Rawat_Ke").val() == ''){
        toast ('Hari Rawat Ke Harap Diisi', "warning");
        return false;
    }if ($("#DPJP").val() == ''){
        toast ('DPJP Harap Diisi', "warning");
        return false;
    }
    if ($("#Dokter_Rawat_Bersama").val() == ''){
        toast ('Dokter Rawat Bersama Harap Diisi', "warning");
        return false;
    }
    if ($("#Diagnosa_Medis").val() == ''){
        toast ('Diagnosa Medis Harap Diisi', "warning");
        return false;
    }
    if ($("#Masalah_utama_saat_ini_yang_menjadi_perhatian").val() == ''){
        toast ('Masalah utama saat ini yang menjadi perhatian Harap Diisi', "warning");
        return false;
    }
    if ($("#Obat_Terkini").val() == ''){
        toast ('Obat Terkini Harap Diisi', "warning");
        return false;
    }
    if ($("#Kesadaran").val() == ''){
        toast ('Kesadaran Harap Diisi', "warning");
        return false;
    }
    if ($("#GCS_E").val() == ''){
        toast ('GCS:E Harap Diisi', "warning");
        return false;
    }
        if ($("#V").val() == ''){
        toast ('V Harap Diisi', "warning");
        return false;
    }
    if ($("#M").val() == ''){
        toast ('M Harap Diisi', "warning");
        return false;
    }
    if ($("#Total").val() == ''){
        toast ('Total Harap Diisi', "warning");
        return false;
    }
    if ($("#Tingkat_Ketergantungan_Pasien").val() == ''){
        toast ('Tingkat Ketergantungan Pasien Harap Diisi', "warning");
        return false;
    }
    if ($("#TTV_TD").val() == ''){
        toast ('TTV:TD Harap Diisi', "warning");
        return false;
    }
    if ($("#Nadi").val() == ''){
        toast ('Nadi Harap Diisi', "warning");
        return false;
    }
    if ($("#Suhu").val() == ''){
        toast ('Suhu Harap Diisi', "warning");
        return false;
    }
    if ($("#RR").val() == ''){
        toast ('RR Harap Diisi', "warning");
        return false;
    }
    if ($("#Saturasi_O2").val() == ''){
        toast ('Saturasi O2 Harap Diisi', "warning");
        return false;
    }
    if ($("#Score_EWS").val() == ''){
        toast ('Score:EWS Harap Diisi', "warning");
        return false;
    }
    if ($("#Score_Jatuh").val() == ''){
        toast ('Score Jatuh Harap Diisi', "warning");
        return false;
    }
    if ($("#Skala_Nyeri").val() == ''){
        toast ('Skala Nyeri Harap Diisi', "warning");
        return false;
    }
    if ($("#Penggunaan_Restrain").val() == ''){
        toast ('Penggunaan Restrain Harap Diisi', "warning");
        return false;
    }
    if ($("#NGT").val() == ''){
        toast ('NGT Harap Diisi', "warning");
        return false;
    }
    if ($("#TGL_Pasang").val() == ''){
        toast ('TGL Pasang Harap Diisi', "warning");
        return false;
    }
    if ($("#Folley_Catheter").val() == ''){
        toast ('Folley Catheter Harap Diisi', "warning");
        return false;
    }
    if ($("#TGL_Psng").val() == ''){
        toast ('TGL Pasang Harap Diisi', "warning");
        return false;
    }
    //getInsert();
    goInsert();
}

async function goInsert() {
    try {
        const dataCreateData = await CreateData();
        updateUIdataCreateData(dataCreateData);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCreateData(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        //$("#idhdr_bpjs").val(response);
        // asyncShowMain();

    }else{
        toast(response.message, "error")
    }  

}
function CreateData() {
    var str = $("#form3").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/fHandoverPerawat/getInsert';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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

function getInsert() { 
    //if ($("#TglJamEdukasi").val() == ''){
        let Ruangan,Tanggal,Jadwal_Shift,Hari_Rawat_Ke,DPJP,Dokter_Rawat_Bersama,Diagnosa_Medis,Masalah_utama_saat_ini_yang_menjadi_perhatian,Kesadaran,V,M,Total,Tingkat_Ketergantungan_Pasien,TTV_TD,Nadi,Suhu,RR,Saturasi_O2,Score_EWS,Score_Jatuh,Skala_Nyeri,Penggunaan_Restrain,NGT,TGL_Pasang,Folley_Catheter,TGL_Psng;
        Ruangan = $("#Ruangan").val();
    Tanggal = $("#Tanggal").val();
    Jadwal_Shift = $("#Jadwal_Shift").val();
    Hari_Rawat_Ke = $("#Hari_Rawat_Ke").val();
    DPJP = $("#DPJP").val();
    Dokter_Rawat_Bersama = $("#Dokter_Rawat_Bersama").val();
    Diagnosa_Medis = $("#Diagnosa_Medis").val();
    Masalah_utama_saat_ini_yang_menjadi_perhatian = $("#Masalah_utama_saat_ini_yang_menjadi_perhatian").val();
    Kesadaran = $("#Kesadaran").val();
    V = $("#V").val();
    M= $("#M").val();
    CaraEdukasi = $("#CaraEdukasi").val();
    Total = $("#Total").val();
    Tingkat_Ketergantungan_Pasien = $("#Tingkat_Ketergantungan_Pasien").val();
    TTV_TD = $("#TTV_TD").val();
    Nadi = $("#Nadi").val();
    Suhu = $("#Suhu").val();
    RR = $("#RR").val();
    Saturasi_O2 = $("#Saturasi_O2").val();
    Score_EWS = $("#Score_EWS").val();
    Score_Jatuh = $("#Score_Jatuh").val();
    Skala_Nyeri = $("#Skala_Nyeri").val();
    Penggunaan_Restrain = $("#Penggunaan_Restrain").val();
    NGT = $("#NGT").val();
    TGL_Pasang = $("#TGL_Pasang").val();
    Folley_Catheter = $("#Folley_Catheter").val();
    TGL_Psng = $("#TGL_Psng").val();


        var base_url = window.location.origin;
        $('#datatable').dataTable({
            "bDestroy": true
        }).fnDestroy();
        $('#datatable').dataTable({
            "bDestroy": true
        }).fnDestroy();
        if (JenisPasien == '1' && JenisRekap == '3') {
            $('#datatable').show()
            $('#datatable').hide()
          
    
            $('#datatable').DataTable({
                "ordering": true, // Set true agar bisa di sorting
                "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                "ajax":
                {
                    "url": base_url + "/SIKBREC/public/fHandoverPerawat/getInsert", // URL file untuk proses select datanya
                    "type": "POST",
                    data: function ( d ) {
                    d.Tanggal = Tanggal;
                    d.Jadwal_Shift = Jadwal_Shift;
                    d.Hari_Rawat_Ke = Hari_Rawat_Ke;
                    d.DPJP = DPJP;
                    d.Dokter_Rawat_Bersama = Dokter_Rawat_Bersama;
                    d.Diagnosa_Medis = Diagnosa_Medis;
                    d.Pemberi_Edukasi = Pemberi_Edukasi;
                    d.Masalah_utama_saat_ini_yang_menjadi_perhatian = Masalah_utama_saat_ini_yang_menjadi_perhatian;
                    d.Kesadaran = Kesadaran;
                    d.V = V;
                    d.M =M;
                    d.CaraEdukasi = CaraEdukasi;
                    d.Total = Total;
                    d.Tingkat_Ketergantungan_Pasien = Tingkat_Ketergantungan_Pasien;
                    d.TTV_TD = TTV_TD;
                    d.Nadi = Nadi;
                    d.Suhu = Suhu;
                    d.RR = RR;
                    d.Saturasi_O2 = Saturasi_O2;
                    d.Score_EWS = Score_EWS;
                    d.Score_Jatuh = Score_Jatuh;
                    d.Skala_Nyeri = Skala_Nyeri;
                    d.Penggunaan_Restrain = Penggunaan_Restrain;
                    d.NGT = NGT;
                    d.TGL_Pasang = TGL_Pasang;
                    d.Folley_Catheter = Folley_Catheter;
                    d.TGL_Psng = TGL_Psng;


                    },
                    error: function (xhr, error, code)
                    {
                        toast('Error! Data Not Found!',"error")
                        $("#datatable").hide();
                    },
                     "dataSrc": "",
                "deferRender": true,
                }, 
                "columns": [
                //  { "data": "no" ,  render: $.fn.dataTable.render.number( '', '', 0,'' )}, 
                 { "data": "Tanggal" },
                 { "data": "Jadwal_Shift" },
                 { "data": "Hari_Rawat_Ke" }, 
                 { "data": "DPJP"},
                 { "data": "Dokter_Rawat_Bersama"},
                 { "data": "Diagnosa_Medis"},
                 { "data": "Pemberi_Edukasi"},
                 { "data": "Masalah_utama_saat_ini_yang_menjadi_perhatian"},
                 { "data": "Kesadaran"},
                 { "data": "V"},
                 { "data": "M"},
                 { "data": "CaraEdukasi"},
                 { "data": "Total"},
                 { "data": "Tingkat_Ketergantungan_Pasien"},
                 { "data": "TTV_TD"},
                 { "data": "Nadi"},
                 { "data": "Suhu"},
                 { "data": "RR"},
                 { "data": "Saturasi_O2"},
                 { "data": "Score_EWS"},
                 { "data": "Score_Jatuh"},
                 { "data": "Skala_Nyeri"},
                 { "data": "NGT"},
                 { "data": "TGL_Pasang"},
                 { "data": "Folley_Catheter"},
                 { "data": "TGL_Psng"},
                                 ],
            });
    
        }
   // }
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


// var form = document.getElementById('form1');
// var values = [];
// form.addEventListener('submit', function(e) {
//     e.preventDefault();
//     var checkboxes = document.getElementsByname('TinggalBersama');
//     for(var i=0 ; i < checkboxes.length; i++){
//         if(checkboxes[i].checked == true){
//             values.push(checkboxes[i].value);
//         }
//     }
//     alert('The vales(s):' + values.toString());
// });

// var expanded = [false, false, false];
// function showCheckboxes(i) {
//   checkboxes = checkboxes || document.getElementsByClassName("checkboxes");
//   if (!expanded[i]) {
//     checkboxes[i].style.display = "block";
//     expanded[i] = true;
//   } else {
//     checkboxes[i].style.display = "none";
//     expanded[i] = false;
//   }
// }   

// var expanded = false;
//     function showCheckboxes() {
//         var checkboxes = document.getElementById("checkboxes");
//         if (!expanded) {
//             checkboxes.style.display = "block";
//             expanded = true;
//         } else {
//             checkboxes.style.display = "none";
//             expanded = false;
//         }
//     }
