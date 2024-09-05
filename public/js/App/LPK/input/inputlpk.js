

var base_url = window.location.origin;
let kelasrawat = document.getElementById('kelasrawat')
let ruangrawat = document.getElementById('ruangrawat')
let spesialistik = document.getElementById('Spesialistik')
let carakeluar = document.getElementById('carakeluar')
// value field
// kelas rawa
const diagnosa_level = [];
const kirimlevel = [];
let datakelasrawat = datareverence.kelasrawat
let dataruangrawat = datareverence.ruangrawat
let dataspesialistik = datareverence.spesialistik
let datacarakeluar = datareverence.carakeluar
let datapascapulang = datareverence.pascapulang
console.log(datareverence)
datakelasrawat.forEach(kelasperawatan);
function kelasperawatan(item,index){
    $(kelasrawat).append(`<option value="${item.kode}">${item.nama}</option>`);
    // console.log(item.kode+" "+item.nama)
}

// dataruangrawat.forEach(ruangperawatan);
// function ruangperawatan(item,index){
//     $(ruangrawat).append(`<option value="${item.kode}">${item.nama}</option>`);
// }

dataspesialistik.forEach(spesialistikperawatan);
function spesialistikperawatan(item,index){
    $(spesialistik).append(`<option value="${item.kode}">${item.nama}</option>`);
}
datacarakeluar.forEach(carakeluarkeperawatan);
function carakeluarkeperawatan(item,index){
    $(carakeluar).append(`<option value="${item.kode}">${item.nama}</option>`);
}
datapascapulang.forEach(pascapulang)
function pascapulang(item,index){
    $(kondisipulang).append(`<option value="${item.kode}">${item.nama}</option>`);
}
$('#dirujukke').hide()
$('#kontrolKembali').hide()

$('#rencanatl').on('change', function() {
    //   alert( this.value );
    if(this.value == 3){
        $('#dirujukke').show()
$('#kontrolKembali').hide()

    }else if(this.value == 4){
$('#kontrolKembali').show()
$('#dirujukke').hide()

    }else{
        $('#dirujukke').hide()
$('#kontrolKembali').hide()

    }
});
var parent = document.getElementById('diagnosa');
var parentdokter = document.getElementById('cariDokterBPJS');
var child = parent.querySelectorAll('select2-search__field')
var childdokter = parentdokter.querySelectorAll('select2-search__field')
// var parent = document.querySelector('#diagnosa .select2-search__field');
// var datadiagnosa = $('#diagnosa').find('.select2-search__field');

// console.log(datadiagnosa)



$("#diagnosa").select2({
    ajax: {
        
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataDiagnosa'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                console.log(child.value)
                return {
                    searchTerm: params.term,
                    nama: child.value,
                    // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                var dataresponse = response
                console.log(dataresponse)
                return {
                    results: $.map(dataresponse.diagnosa, function (item) {
                        return {
                            text: item.nama,
                            id: item.kode
                        }
                    })
                };
            },
            cache: true
        },
    
        placeholder: 'Cari Diagnosa',
        minimumInputLength: 3
    
    })
// cek isi array
    // input diagnosa
    $('#inputdiagnosa').click(function(e){
        e.preventDefault()

        inputdiagnosa()
    })
    function checkValue(value, arr,diagnosadata,json) {
        var status = 'Not exist';
        console.log(arr.length)
        if(arr.length == 0){
                    $("#leveldiagnosa").append(`
        <tr id="${diagnosadata.iddiagnosa}">
       <td align='center'>
           ${diagnosadata.iddiagnosa}
       </td>
       <td align='center'>
           ${diagnosadata.diagnosa}
       </td>
       <td align='center'>
           ${diagnosadata.leveldiagnosa}
       </td>
       <td align='center'>
           <button onclick="deletediagnosa(${diagnosadata.iddiagnosa})" class="btn btn-danger">Delete</button>
       </td>
       </tr>
   `)
            diagnosa_level.push(json)
            
        }else{
            for (var i = 0; i < arr.length; i++) {
                var name = arr[i];
                if (name.kode == value) {
                    status = 'Exist';
                    break;
                }
                
            } 
            if(status == 'Not exist'){
                $("#leveldiagnosa").append(`
                <tr id="${diagnosadata.iddiagnosa}">
               <td align='center'>
                   ${diagnosadata.iddiagnosa}
               </td>
               <td align='center'>
                   ${diagnosadata.diagnosa}
               </td>
               <td align='center'>
                   ${diagnosadata.leveldiagnosa}
               </td>
               <td align='center'>
                   <button onclick="deletediagnosa(${diagnosadata.iddiagnosa})" class="btn btn-danger">Delete</button>
               </td>
               </tr>
           `)
                    diagnosa_level.push(json)
            }
          
            return status;
        }
        
        


    
    }
    function inputdiagnosa(){
        var iddiagnosa = $("#diagnosa").val()
        var diagnosa = $("#diagnosa").find(':selected').text()
        var leveldiagnosa = $("#level option:selected" ).text()
        var idleveldiagnosa = $("#level" ).val()
        var diagnosadata = {
            iddiagnosa:iddiagnosa,
            diagnosa:diagnosa,
            leveldiagnosa:leveldiagnosa,
            idleveldiagnosa:idleveldiagnosa
        }
        var jsondiagnosa = {
            kode:iddiagnosa,
            level:idleveldiagnosa
        }

        
        console.log(checkValue(iddiagnosa,diagnosa_level,diagnosadata,jsondiagnosa))
        
        
        // diagnosa_level.push(jsondiagnosa)
        
        // console.log(diagnosa)
            
      
        console.log(diagnosa_level)
        

    }

    $('#deletediagnosa').click(function(e){
        e.stopImmediatePropagation();
    })
    // delete diagnosa
    
    // .on("select2:select", function(e){
    //     console.log(e.params.data);
    //     $( "#leveldiagnosa" ).append(`
    //     <div class="from-group poli gut" id="${e.params.data.id}1">
    //                                     <label for="tglmasuk" class="col-sm-8 control-label">${e.params.data.text} <sup class="color-danger">*</sup></label>
    //                                     <div class="col-sm-3">
    //                                         <select id="${e.params.data.id}" name="${e.params.data.id}" class="form-control input-sm level-diagnosa">
    //                                             <option value="">--pilih--</option>
    //                                             <option value="1">Primer</option>
    //                                             <option value="2">Sekunder</option>
    //                                         </select>
    //                                     </div>
    //                                 </div>
    //     `)
    //     diagnosa_level.push(e.params.data.id)
    //     console.log(diagnosa_level)
    // });

    $('#diagnosa').on('select2:unselect', function (e) {
       console.log(e.params.data.id)
       document.getElementById(e.params.data.id+1).remove();
       var hapusidlevel = diagnosa_level.indexOf(e.params.data.id);
if (hapusidlevel !== -1) {
    diagnosa_level.splice(hapusidlevel, 1);
}
console.log(diagnosa_level)
    });
    $("#prosedur").select2({
        ajax: {
                url: function (params) {
                    return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataProcedure'
                },
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        nama: $('.select2-search__field').val(),
                        // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                    };
                },
                processResults: function (response) {
                    var dataresponse = response
                    console.log(dataresponse.procedure)
                    return {
                        results: $.map(dataresponse.procedure, function (item) {
                            return {
                                text: item.nama,
                                id: item.kode
                            }
                        })
                    };
                },
                cache: true
            },
        
            placeholder: 'Cari Prosedur',
            minimumInputLength: 3
        
        });
       
        // $("#cariDokterBPJS").select2({
        //     ajax: {
        //             url: function (params) {
        //                 return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataDokter'
        //             },
        //             type: "post",
        //             dataType: 'json',
        //             delay: 250,
        //             data: function (params) {
        //                 return {
        //                     nama: params.term,
        //                     // nama: childdokter.value,
        //                     // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
        //                 };
        //             },
        //             processResults: function (response) {
        //                 var dataresponse = response
        //                 console.log(dataresponse.procedure)
        //                 return {
        //                     results: $.map(dataresponse.procedure, function (item) {
        //                         return {
        //                             text: item.nama,
        //                             id: item.kode
        //                         }
        //                     })
        //                 };
        //             },
        //             cache: true
        //         },
            
        //         placeholder: 'Cari Prosedur',
        //         minimumInputLength: 3
            
        //     });

$('#btnsimpan').click(function(e){
    console.log('click')
    e.preventDefault()
    // if($(".level-diagnosa").val()==""){
    //     console.log('level tidak boleh kosong')
       
    // }else{
    //     diagnosa_level.forEach(level_diagnosa)
    //     function level_diagnosa(item,index){
    //         //    console.log(document.getElementById(item).value)
    //            kirimlevel.push(document.getElementById(item).value)
    //        }
    //        console.log(kirimlevel)
    var formData = {
        noSep: $('#noseppasien').val(),
        tglMasuk: $("#tglmasuk").val(),
        tglKeluar: $("#tglkeluar").val(),
        jaminan: "1",
        poli: $("#poli").val(),
        ruangRawat: $("#ruangrawat").val(),
        kelasRawat: $("#kelasrawat").val(),
        spesialistik: $("#Spesialistik").val(),
        caraKeluar: $("#carakeluar").val(),
        kondisiPulang: $("#kondisipulang").val(),
        diagnosa: $("#diagnosa").val(),
        diagnosa_level,
        prosedur: $("#prosedur").val(),
        rencanaTL: $("#rencanaTL").val(),
        dirujukKe: $("#dirujukke").val(),
        tglKontrol: $("#tglrujuk").val(),
        polikontrol: $("#polirujuk").val(),
        DPJP: $("#cariDokterBPJS").val(),
        user: "Coba Ws"
     
    }
    // console.log($("#diagnosa").val())
    $.ajax({
        type: "POST",
        url:  base_url + '/SIKBREC/public/LembarPengajuanKlaim/inputlpk',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data)
        kirimlevel=[]
        swal({
            title: "Cek",
            text: data,
            icon: "warning",
        })
        })
    // }

   
});
