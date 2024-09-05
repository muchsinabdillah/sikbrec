var base_url = window.location.origin;
var nomorrujukan = document.getElementById('nomorrujukan')
var kodediagnosa = document.getElementById('diagnosarujukanKhusus')
var kodeprosedur = document.getElementById('prosedurRujukanKhusus')
var tipediagnosa = document.getElementById('tipediagnosa')
var namaprosedur
var namadiagnosa
var user = namauser
const diagnosa_level = [];
const diagnosa_kode =[];
const kirimlevel = [];
// kondisi ketika tipe rujukan 2

$("#polirujukan").select2({
    ajax: {
        url: function (params) {
            return window.location.origin + '/SIKBREC/public/Rujukan/getPoli'
        },
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                nama: params.term,
                // nama: childdokter.value,
                // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
            };
        },
        processResults: function (response) {
            var dataresponse = response
            console.log(dataresponse)
            return {
                results: $.map(dataresponse, function (item) {
                    return {
                        text: item.text,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    },

    placeholder: 'Cari Prosedur',
    minimumInputLength: 3

});
$("#diagnosarujukanKhusus").select2({
    ajax: {

        url: function (params) {
            return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataDiagnosa'
        },
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            // console.log(child.value)
            return {
                searchTerm: params.term,
                // nama: child.value,
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
$("#prosedurRujukanKhusus").select2({
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


$('#btnsimpan').click(function (e) {

    e.preventDefault()
    var formData = {
        nomorrujukan:nomorrujukan.value,
        kodediagnosa:kodediagnosa.value,
        kodeprosedur:kodeprosedur.value,
        datadiagnosa:diagnosa_kode,
        tipediagnosa:tipediagnosa.value,
        user: namauser
    }
    // console.log($("#diagnosa").val())
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/Rujukan/InputRujukanKhusus',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        // console.log(data)
        // if(data.status=="warning"){
        //     // alert(data.errorname,data.metadata.message)
        //     swal({
        //         title: "error",
        //         text: data.metadata.message,
        //         icon: "error",
        //     })
        // }else{
        //     swal({
        //         title: "success",
        //         text: "Data Rujukan berhasil di buat"+data.rujukan.noRujukan+"Tanggal Rujukan "+data.rujukan.tglRujukan,
        //         icon: "success",
        //     })
        // }
    })
});

$('#inputdiagnosa').click(function(e){
    e.preventDefault()

    inputdiagnosa()
})

function inputdiagnosa(){
    var iddiagnosa = kodediagnosa.value
    var diagnosa = $("#diagnosarujukanKhusus option:selected").text()
    var leveldiagnosa = $("#tipediagnosa option:selected" ).text()
    var idleveldiagnosa = tipediagnosa.value
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
$('#deleted').click(function(e){
    e.stopImmediatePropagation();
})

$('#diagnosa').on('select2:unselect', function (e) {
    console.log(e.params.data.id)
    document.getElementById(e.params.data.id+1).remove();
    var hapusidlevel = diagnosa_level.indexOf(e.params.data.id);
if (hapusidlevel !== -1) {
 diagnosa_level.splice(hapusidlevel, 1);
}
console.log(diagnosa_level)
 });

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
       <span  onclick="deletediagnosa(${diagnosadata.iddiagnosa})" class="btn btn-danger">Delete</span>
   </td>
   </tr>
`)
        diagnosa_level.push(json)
        
    }else{
        for (var i = 0; i < arr.length; i++) {
            var name = arr[i];
            if (name.kode == value) {
                status = 'Exist';
                alert('Diagnosa tidak boleh sama')
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
               <span  onclick="deletediagnosa(${diagnosadata.iddiagnosa})" class="btn btn-danger">Delete</span>
           </td>
           </tr>
       `)
                diagnosa_level.push(json)
        }
      
        return status;
    }
    
    



}


function deletediagnosa(params) {
    
    console.log('klik')
var diagnosa = diagnosa_level.indexOf(params);
diagnosa_level.splice(diagnosa, 1);
// var kirim = kirimlevel.indexOf(params);
// kirimlevel.splice(kirim, 1);
// console.log(kirimlevel)
console.log('diagnosa')
console.log(diagnosa_level)
    $(params).remove()
    
}

// create list for data diagnosa
var myNodelist = document.getElementById("myUL")
var itemdiagnosa;
for (itemdiagnosa=0;itemdiagnosa< myNodelist.length;itemdiagnosa++){
    var span = document.createElement("SPAN");
    var txt = document.createTextNode("\u00D7");
    span.className = "close";
    span.appendChild(txt);
    myNodelist[itemdiagnosa].appendChild(span);
}

// click on close button to hide current item

var Close = document.getElementsByClassName('close');
var itemclose;
for(itemclose=0;itemclose<Close.length;itemclose++){
    Close[itemclose].onclick = function () {
        var div = this.parentElement;
        div.style.display = "none";
    }
}

function newElement() {
    var status = 'Not exist';
    var li = document.createElement('li');
    li.className="list-group-item"
    var inputvalue = document.getElementById('diagnosarujukanKhusus').value
    var t = document.createTextNode("Kode "+inputvalue+" "+"|Nama Diagnosa "+$("#diagnosarujukanKhusus option:selected").text()+"| level Diagnosa "+$("#tipediagnosa option:selected").text());
    li.appendChild(t);
    if(inputvalue==''||tipediagnosa.value==''){
        alert('anda harus memasukkan diagnosa dan tipe diagnosa')
    }else{
        
        // if(status =="Not exist") {
            for(i=0;i<diagnosa_kode.length;i++){
                if(diagnosa_kode[i]['kodediagnosa']==kodediagnosa.value){
                    alert("kodediagnosa tidak boleh sama")
                    status ="Exist"
                    break
                }
            }
            if(status == 'Not exist'){
                document.getElementById('myUL').appendChild(li).setAttribute("id",kodediagnosa.value) ;
                diagnosa_kode.push({
                    // kodediagnosa : kodediagnosa.value,
                    // kode:tipediagnosa.value+";"+kodediagnosa.value
                })
                console.log(diagnosa_kode)
            }
            
    }
// document.getElementById("diagnosarujukanKhusus").value = "";
    
    // console.log(diagnosa_kode)


  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < Close.length; i++) {
    Close[i].onclick = function() {
      var div = this.parentElement;
      console.log(this.parentElement.getAttribute('id'))
      iddiagnosaremove = this.parentElement.getAttribute('id')
      const removediagnosa = diagnosa_kode.indexOf(iddiagnosaremove); // 2
        const removedDrink = diagnosa_kode.splice(removediagnosa,  1);
      div.style.display = "none";
    }
  }

}

function carippkrujukan() {
    var ppkrujukan = document.getElementById('ppkrujukan')
    var kodefakes = document.getElementById('tipefakes')
    var datappk = document.getElementById('ppkrujukandata')
    if(ppkrujukan.value==""||kodefakes.value==""){
                alert("PPk Rujukan dan kode fakes tidak boleh kosong")
            }else{
                var fromData ={
                    namafakes:ppkrujukan.value,
                    kodefakes:kodefakes.value
                }
                $.ajax({
                    type: "POST",
                    url:  base_url + '/SIKBREC/public/Rujukan/getFakes',
                    data: fromData,
                    dataType: "json",
                    encode: true,
                }).done(function (data) {
                    console.log(data.faskes)
                    $("#ppkrujukandata").empty();
                    for (i = 0; i < data.faskes.length; i++) {
                        var newRow = '<option value="' + data.faskes[i].kode + '">' + data.faskes[i].nama + '</option';
                        $("#ppkrujukandata").append(newRow);
                    }
                
                })
            }
}

function Carispesialistik() {
    var ppkrujukan = document.getElementById('ppkrujukandata');
    var tglrujukan = document.getElementById('tglrujukan')
    if(ppkrujukan.value==''||tglrujukan.value==''){
        alert('tglrujukan dan ppk rujukan tidak bole kosong')
    }else{
        var fromData ={
            kodeppk:ppkrujukan.value,
            tglrujukan:tglrujukan.value
        }
        $.ajax({
            type: "POST",
            url:  base_url + '/SIKBREC/public/Rujukan/getListrujukanspesialistik',
            data: fromData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data)
            // $("#ppkrujukandata").empty();
            // for (i = 0; i < data.faskes.length; i++) {
            //     var newRow = '<option value="' + data.faskes[i].kode + '">' + data.faskes[i].nama + '</option';
            //     $("#ppkrujukandata").append(newRow);
            // }
        
        })
    }
}