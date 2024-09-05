var base_url = window.location.origin;
var pemeriksaan=document.getElementById('pemeriksaan')
var lokasipemeriksaan=document.getElementById('lokasipemeriksaan')
var pemeriksaanpenunjang=document.getElementById('pemeriksaanpenunjang')
var datapemeriksaanpenunjang
var idtest=document.getElementById('idtest')
var Group_Spesialis=document.getElementById('Group_Spesialis')
var tarifitem=document.getElementById('tarifitem')
var rupiah = document.getElementById('tarif')
var header = document.getElementById('header')
var namapaket = document.getElementById('namapaket')
var pemeriksaan = document.getElementById('pemeriksaan')
var pemeriksaanmodal=document.getElementById('pemeriksaanmodal')
var lokasipemeriksaanmodal=document.getElementById('lokasipemeriksaanmodal')
var pemeriksaanpenunjangmodal=document.getElementById('peperiksaanpenunjangmodal')
var idtestmodal=document.getElementById('idtestmodal')
var tarifmodal=document.getElementById('tarifitemmodal')
var showkodejasamodal=document.getElementById('showkodejasamodal')
var kodejasamodal=document.getElementById('kodejasamodal')
var ubahitemodal = document.getElementById('ubahitemmodal')
var kodependapatanmodal = document.getElementById('kodependapatanmodal')
var iditemupdate
// var datatable = $('#tableitempemeriksaan').DataTable();
// var simpantarifmcu = document.getElementById('simpantarifmcu')
var dataitemtarif =[]
var detailisipaket =[] ;
var tablel = document.getElementById('tableitempemeriksaan'),
                rIndex;


$(document).ready( function() {
    var formData={
        namaPaket:PAKET,
    }
    // $('#tarifmcutbl').DataTable();
    $('.lokasi').hide()
    $.ajax({
        type:"POST",
        data: formData,
        url: base_url+'/SIKBREC/public/TarifMcu/detailPaket',
        dataType:'json',
    }).done(function (result) {
        // console.log(result)
        // detailisipaket.push(result)

        // sessionStorage.setItem("Result",JSON.stringify(result))
        $.each(result, function( index, value ) {
           sessionStorage.setItem(value.IDMCU,JSON.stringify(value))
           dataitemtarif.push({
            iditemmcu:value.IDMCU,
            namapemeriksaan:value.Pemeriksaan,
            lokasipemeriksaan:value.LokasiPemeriksaan,
            pemeriksaanpenunjang:value.Keterangan,
            idtest:value.IdTes,
            discontinue:value.Discontinue,
            tarifitem:value.Tarif,
            showjasa:value.ShowJasa,
            kodejasa:value.KD_JASA,
            kodependapatan:value.KD_PDP,
            Group_Spesialis:value.Group_Spesialis
           })
           
           $('#listitempaketmcu').append(
            `<tr id="${value.IDMCU}" class="remove">
            <td>${value.IDMCU}</td>
            <td>${value.Pemeriksaan}</td>
            <td>${value.LokasiPemeriksaan}</td>
            <td>${value.Keterangan}</td>
            <td>${value.IdTes}</td>
            <td>${value.Tarif}</td>
            <td>${value.ShowJasa}</td>
            <td>${value.KD_JASA}</td>
            <td>${value.KD_PDP}</td>
            </tr>`
         )       
          });


selectedtable()
            // <td><button class="btn btn-dange r" onclick="deleteitemmcu(${value.IDMCU})">X </button><button class="btn btn-warning" onclick="edititem(${value.IDMCU})">EDIT </button>

          
    })
    selectedtable()
    
});
showjasa.addEventListener('change',function () {
    if(this.value == 0){
        kodejasa.setAttribute('disabled',true)
    }else{
        kodejasa.disabled = false
    }
})
// var obj = JSON.parse(sessionStorage.getItem(850)).IDMCU
// console.log(dataitemtarif)
// console.log(retu)

lokasipemeriksaan.addEventListener('change',function (e) {
    if(this.value=="RADIOLOGI"){
        // get data radiologi
        $.ajax({
            type: "POST",
            url:  base_url + '/SIKBREC/public/TarifMcu/getRadiologi',
            dataType: "json",
        }).done(function (data) {
            console.log(data)
            const dataradiologi = data;
            $('#pemeriksaanpenunjang').empty()
            $('#pemeriksaanpenunjang').append(
                `<option value="">--Pilih--</optioon>`
            )
            dataradiologi.forEach(insertdataradiologi);
            function insertdataradiologi(item,index) {
                $('#pemeriksaanpenunjang').append(
                    `<option value="${item.ID}">${item.Proc_Description}</optioon>`
                )    
            }
            
            
        })
    }else if(this.value=="LABORATORIUM"){
        $.ajax({
            type: "POST",
            url:  base_url + '/SIKBREC/public/TarifMcu/getLaboratorium',
            dataType: "json",
        }).done(function (data) {
            console.log(data)
            const laboratorium = data;
            $('#pemeriksaanpenunjang').empty()
            $('#pemeriksaanpenunjang').append(
                `<option value="">--Pilih--</optioon>`
            )
            laboratorium.forEach(insertdatalaboratorium);
            function insertdatalaboratorium(item,index) {
                $('#pemeriksaanpenunjang').append(
                    `<option value="${item.IDTes}">${item.NamaTes}</optioon>`
                )    
            }
        })
    }else if(this.value=="UNIT MCU"){
        $.ajax({
            type: "POST",
            url:  base_url + '/SIKBREC/public/TarifMcu/getPemeriksaanMCU',
            dataType: "json",
        }).done(function (data) {
            console.log(data)
            const laboratorium = data;
            $('#pemeriksaanpenunjang').empty()
            $('#pemeriksaanpenunjang').append(
                `<option value="">--Pilih--</optioon>`
            )
            laboratorium.forEach(insertdatalaboratorium);
            function insertdatalaboratorium(item,index) {
                $('#pemeriksaanpenunjang').append(
                    `<option value="14259">${item.NamaPemeriksaan}</optioon>`
                )    
            }
        }) 
        idtest.value = 14259
    }
})

$('#pemeriksaanpenunjang').select2()
$('#kodejasa').select2()
// $('#kodejasamodal').select2()


$('#pemeriksaanpenunjang').on('select2:select', function (e) {
    var data = e.params.data;
    idtest.value = data.id
    datapemeriksaanpenunjang = data.text
});
pemeriksaanpenunjang.addEventListener('change',function (e) {
    idtest.value = this.value
})
rupiah.addEventListener('keyup',function (e) {
    rupiah.value = formatRupiah(this.value,'RP. ')
})

// var tarifitem = document.getElementById('tarifitem')
tarifitem.addEventListener('keyup',function (e) {
    tarifitem.value = formatRupiah(this.value,'RP. ')
})

var itemmcu = document.getElementById('additempaketmcu')
itemmcu.addEventListener('click',function (e) {
    e.preventDefault()

    if(pemeriksaan.value==""||lokasipemeriksaan.value==""||pemeriksaanpenunjang.value==""||idtest.value==""||tarifitem.value==""||$('#showjasa').val()==""){
        alert('Pemeriksaan,Lokasi Pemeriksaan,Pemeriksaan penunjang, Idtest,Tarif,showjasa tidak boleh kosong')
    }else{

        if(showjasa.value==1 && kodejasa.value==''){
            alert('kode jasa tidak boleh kosong')
            selectedtable()
        }else{
            var characters = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";  
              
            //specify the length for the new string  
    var lenString = 7;  
    var randomstring = '';  
  
            //loop to select a new character in each iteration  
    for (var i=0; i<lenString; i++) {  
        var rnum = Math.floor(Math.random() * characters.length);  
        randomstring += characters.substring(rnum, rnum+1);  
    }  
    var random = Math.random().toString(36).substring(2,7);
    if($("#header:checkbox:checked").val()){
        if(namapaket.value!='' && $('#tglberlaku').val()!=''&&$('#akhirberlaku').val()!=''&&$('#tarif').val()!=''){
         
            $('#listitempaketmcu').append(
                `<tr id="${randomstring}" class="remove">
                <td>${randomstring}</td>
                <td>${pemeriksaan.value}</td>
                <td>${lokasipemeriksaan.value}</td>
                <td>${datapemeriksaanpenunjang}</td>
                <td>${idtest.value}</td>
                <td>${tarifitem.value}</td>
                <td>${$("#showjasa").val()}</td>
                <td>${$('#kodejasa').val()}</td>
                <td>${$('#kodependapatan').val()}</td>
                </tr>
                `
             )       
                // <td><button class="btn btn-danger" onclick="deleteitemmcu('${randomstring}')">X </button><button class="btn btn-warning" onclick="edititem('${randomstring}')">EDIT </button>
            dataitemtarif.push({
            iditemmcu:randomstring,
            namapemeriksaan:pemeriksaan.value,
            lokasipemeriksaan:lokasipemeriksaan.value,
            pemeriksaanpenunjang:datapemeriksaanpenunjang,
            idtest:idtest.value,
            // discontinue:0,
            tarifitem:tarifitem.value,
            showjasa:$("#showjasa").val(),
            kodejasa:$('#kodejasa').val(),
            kodependapatan:$('#kodependapatan').val()
            })
            console.log(dataitemtarif)
            clearitem()
            selectedtable()


    // $('#pemeriksaanpenunjang').val(null).trigger(clearitem());

            }else{
                 alert('nama paket kosong')
            }
        }else{
            alert('header belum di pilih')
        }
    
            
        }
    // console.log(header.value)
    }
})

function formatRupiah(angka="0", prefix='Rp. '){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
 
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
// simpantarifmcu.addEventListener('click',function (e) {

//     if(dataitemtarif.length==0){
//         alert("item paket belum di tambahkan")
//     }
//     var formData={
//         namapaket:namapaket.value,
//         tglberlaku:$('#tglberlaku').val(),
//         sampaidengan:$('#akhirberlaku').val(),
//         tarif:$('#tarif').val(),
//         header:$("#header:checkbox:checked").val(),
//         ekg:$("#ekg:checkbox:checked").val(),
//         treadmil:$("#treadmil:checkbox:checked").val(),
//         discontinue:$("#discontinue:checkbox:checked").val(),
//         spirometri:$("#spirometri:checkbox:checked").val(),
//         dataitemtarif:dataitemtarif
//     }
//     $.ajax({
//         type: "POST",
//         url: base_url + '/SIKBREC/public/TarifMcu/inputdatarujukan',
//         data: formData,
//         dataType: "json",
//         encode: true,
//     }).done(function (data) {
//         console.log(data)
//         if(data.status==200){
//             swal({
//                 title: "success",
//                 text: "Tarif Mcu Berhasil Di buat",
//                 icon: "success",
//             })
//             resetform()

//         }else{
//             swal({
//                 title: "Warning",
//                 text: "Something went wrong",
//                 icon: "Warning",
//             })
//         }
            
      
//     })
// })

updatetarifmcu.addEventListener('click',function (e) {
    
    var formData = {
        idheader:$('#idheader').val(),
        namapaket:namapaket.value,
        tglberlaku:$('#tglberlaku').val(),
        sampaidengan:$('#akhirberlaku').val(),
        tarif:$('#tarif').val(),
        header:$("#header:checkbox:checked").val() ? $("#header:checkbox:checked").val() : 0,
        ekg:$("#ekg:checkbox:checked").val() ? $("#ekg:checkbox:checked").val() : 0,
        treadmil:$("#treadmil:checkbox:checked").val() ? $("#treadmil:checkbox:checked").val() : 0,
        discontinue:$("#discontinue:checkbox:checked").val() ? $("#discontinue:checkbox:checked").val() : 0,
        spirometri:$("#spirometri:checkbox:checked").val() ? $("#spirometri:checkbox:checked").val() : 0,
//         dataitemtarif:dataitemtarif
        Group_Spesialis:$('#Group_Spesialis').val(),
        dataitemtarif:dataitemtarif
    }
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/TarifMcu/updateItemMcu',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data)
        if(data.status==200){
            swal({
                title: "success",
                text: "Tarif Mcu Berhasil Di Perbaharui",
                icon: "success",
            })
            resetform()
            loaddata()
            selectedtable()


            location.reload(); 

        }else{
            swal({
                title: "Warning",
                text: "Something went wrong",
                icon: "Warning",
            })
            selectedtable()
        }
            
      
    })
})

function deleteitemmcu(params) {
    // console.log(isString(params))
    $('#'+params).remove()
    // console.log(params)
    var deleteitemcu = dataitemtarif.findIndex((obj=>obj.iditemmcu==params))
    console.log(dataitemtarif[deleteitemcu].discontinue)
if(dataitemtarif[deleteitemcu].discontinue==undefined){
        var item = dataitemtarif.indexOf(params);
        dataitemtarif.splice(item, 1);
}else{
    if(dataitemtarif[deleteitemcu].discontinue ==undefined){
        var item = dataitemtarif.indexOf(params);
        dataitemtarif.splice(item, 1);
    }
    dataitemtarif[deleteitemcu].discontinue =1
}
console.log(dataitemtarif)

}

function clearitem() 
{
    pemeriksaan.value=""
    lokasipemeriksaan.value=""
    pemeriksaanpenunjang.value=""
    idtest.value =""
    tarifitem.value=""
    $('#kodejasa').val("")  
    $('#showjasa').val("")  
}

function resetform() {
    document.getElementById("mcutarif").reset();
    $('.remove').remove()
    dataitemtarif=[]

}

function loaddata() {
    var formData={
        namaPaket:PAKET,
    }
    $.ajax({
        type:"POST",
        data: formData,
        url: base_url+'/SIKBREC/public/TarifMcu/detailPaket',
        dataType:'json',
    }).done(function (result) {
        // console.log(result)
        // detailisipaket.push(result)

        // sessionStorage.setItem("Result",JSON.stringify(result))
        $.each(result, function( index, value ) {
           sessionStorage.setItem(value.IDMCU,JSON.stringify(value))
           dataitemtarif.push({
            iditemmcu:value.IDMCU,
            namapemeriksaan:value.Pemeriksaan,
            lokasipemeriksaan:value.LokasiPemeriksaan,
            pemeriksaanpenunjang:value.Keterangan,
            idtest:value.IdTes,
            discontinue:value.Discontinue,
            tarifitem:value.Tarif,
            showjasa:value.ShowJasa,
            kodejasa:value.KD_JASA,
            kodependapatan:value.KD_PDP
           })
         
           $('#listitempaketmcu').append(
            `<tr id="${value.IDMCU}" class="remove">
            <td>${value.IDMCU}</td>
            <td>${value.Pemeriksaan}</td>
            <td>${value.LokasiPemeriksaan}</td>
            <td>${value.Keterangan}</td>
            <td>${value.IdTes}</td>
            <td>${value.Tarif}</td>
            <td>${value.ShowJasa}</td>
            <td>${value.KD_JASA}</td>
            <td>${value.KD_PDP}</td>
            </tr>`
         )       
          });
            // <td><button class="btn btn-danger" onclick="deleteitemmcu(${value.IDMCU})">X </button><button class="btn btn-warning" onclick="edititem(${value.IDMCU})">EDIT </button>
    selectedtable()
          
    })
    selectedtable()
    console.log(dataitemtarif)
}

function isString(value) {
	return typeof value === 'string' || value instanceof String;
}

function selectedtable() {
    console.log('run')
    lokasipemeriksaanmodal.addEventListener('change',function (e) {
        console .log('click')
        if(this.value=="RADIOLOGI"){
            // get data radiologi
            $.ajax({
                type: "POST",
                url:  base_url + '/SIKBREC/public/TarifMcu/getRadiologi',
                dataType: "json",
            }).done(function (data) {
                console.log(data)
                const dataradiologi = data;
                $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="">--Pilih--</optioon>`
                ) 
            idtestmodal.value = ""

                dataradiologi.forEach(insertdataradiologi);
                function insertdataradiologi(item,index) {
                    $('#peperiksaanpenunjangmodal').append(
                        `<option value="${item.ID}">${item.Proc_Description}</optioon>`
                    )    
                }
                
                // idtestmodal.value = pemeriksaanpenunjangmodal.value
            })
        }else if(this.value=="LABORATORIUM"){
            $.ajax({
                type: "POST",
                url:  base_url + '/SIKBREC/public/TarifMcu/getLaboratorium',
                dataType: "json",
            }).done(function (data) {
                console.log(data)
                const laboratorium = data;
                $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="">--Pilih--</optioon>`
                ) 
            idtestmodal.value = ""

                laboratorium.forEach(insertdatalaboratorium);
                function insertdatalaboratorium(item,index) {
                    $('#peperiksaanpenunjangmodal').append(
                        `<option value="${item.IDTes}">${item.NamaTes}</optioon>`
                    )    
                }
            })
            // idtestmodal.value = pemeriksaanpenunjangmodal.value
        }else if(this.value=="UNIT MCU"){
            $.ajax({
                type: "POST",
                url:  base_url + '/SIKBREC/public/TarifMcu/getPemeriksaanMCU',
                dataType: "json",
            }).done(function (data) {
                console.log(data)
                const laboratorium = data;
                $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="">--Pilih--</optioon>`
                ) 
            idtestmodal.value = ""
                laboratorium.forEach(insertdatalaboratorium);
                function insertdatalaboratorium(item,index) {
                    $('#peperiksaanpenunjangmodal').append(
                        `<option value="14259">${item.NamaPemeriksaan}</optioon>`
                    )    
                }
            }) 
            idtestmodal.value = 14259
        }
    })
    pemeriksaanpenunjangmodal.addEventListener('change',function () {
        idtestmodal.value = this.value
    })
    for (var i = 1; i < tablel.rows.length; i++) {
        tablel
            .rows[i].onclick = function() {
                // get the seected row index
                rIndex = this.rowIndex;
                // console.log(this.cells.attr('data-key'))
                // alert('diklik')

                $('#itemtarifmcumodal').modal('show')
                
                iditemupdate = this.cells[0].innerHTML
                pemeriksaanmodal.value = this.cells[1].innerHTML
                lokasipemeriksaanmodal.value = this.cells[2].innerHTML
                var pemeriksaanvalue = this.cells[3].innerHTML
                var pemeriksaankode =this.cells[4].innerHTML
                if(lokasipemeriksaanmodal.value=="RADIOLOGI"){
                    // get data radiologi
                    $.ajax({
                        type: "POST",
                        url:  base_url + '/SIKBREC/public/TarifMcu/getRadiologi',
                        dataType: "json",
                    }).done(function (data) {
                        console.log(data)
                        const dataradiologi = data;
                        $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="${pemeriksaankode}">${pemeriksaanvalue}</optioon>`
                ) 
        
                        dataradiologi.forEach(insertdataradiologi);
                        function insertdataradiologi(item,index) {
                            $('#peperiksaanpenunjangmodal').append(
                                `<option value="${item.ID}">${item.Proc_Description}</optioon>`
                            )    
                        }
                        
                        // idtestmodal.value = pemeriksaanpenunjangmodal.value
                    })
                }else if(lokasipemeriksaanmodal.value=="LABORATORIUM"){
                    $.ajax({
                        type: "POST",
                        url:  base_url + '/SIKBREC/public/TarifMcu/getLaboratorium',
                        dataType: "json",
                    }).done(function (data) {
                        console.log(data)
                        const laboratorium = data;
                        $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="${pemeriksaankode}">${pemeriksaanvalue}</optioon>`
                ) 
        
                        laboratorium.forEach(insertdatalaboratorium);
                        function insertdatalaboratorium(item,index) {
                            $('#peperiksaanpenunjangmodal').append(
                                `<option value="${item.IDTes}">${item.NamaTes}</optioon>`
                            )    
                        }
                    })
                    // idtestmodal.value = pemeriksaanpenunjangmodal.value
                }else if(lokasipemeriksaanmodal.value=="UNIT MCU"){
                    $.ajax({
                        type: "POST",
                        url:  base_url + '/SIKBREC/public/TarifMcu/getPemeriksaanMCU',
                        dataType: "json",
                    }).done(function (data) {
                        console.log(data)
                        const laboratorium = data;
                        $('#peperiksaanpenunjangmodal').empty()
                $('#peperiksaanpenunjangmodal').append(
                    `<option value="${pemeriksaankode}">${pemeriksaanvalue}</optioon>`
                ) 
                        laboratorium.forEach(insertdatalaboratorium);
                        function insertdatalaboratorium(item,index) {
                            $('#peperiksaanpenunjangmodal').append(
                                `<option value="14259">${item.NamaPemeriksaan}</optioon>`
                            )    
                        }
                    }) 
                    idtestmodal.value = 14259
                }
                // $('#peperiksaanpenunjangmodal').empty()
                // $('#peperiksaanpenunjangmodal').append(
                //     `<option value="${this.cells[4].innerHTML}">${this.cells[3].innerHTML}</optioon>`
                // ) 
                idtestmodal.value = this.cells[4].innerHTML
                tarifmodal.value = formatRupiah(this.cells[5].innerHTML,"RP. ")
                showkodejasamodal.value = this.cells[6].innerHTML
                kodejasamodal.value = this.cells[7].innerHTML
                kodependapatanmodal.value = this.cells[8].innerHTML
                var hapusitem = document.getElementById('hapusitemmcumodal')
                hapusitem.addEventListener('click',function () {
                    deleteitemmcu(iditemupdate)
                    // loaddata()
                $('#itemtarifmcumodal').modal('hide')

                })
            };
    }
// update array data 
ubahitemodal.addEventListener('click',function () {
    // validasi form modal
    if(pemeriksaanmodal.value==''){
        swal({
            title: "Warning",
            text: "Pemeriksaan modal harus di isi",
            icon: "Warning",
        })
    }else if(lokasipemeriksaanmodal.value==""){
        swal({
            title: "Warning",
            text: "lokasi Pemeriksaan harus di isi",
            icon: "Warning",
        })
    }else if(pemeriksaanpenunjangmodal.value==""){
        swal({
            title: "Warning",
            text: "pemeriksaan penunjang harus di isi",
            icon: "Warning",
        })
    }else if(tarifmodal.value==""){
        swal({
            title: "Warning",
            text: "tarif harus di isi",
            icon: "Warning",
        })
    }else if(kodependapatanmodal.value==""){
        swal({
            title: "Warning",
            text: "Kode Pendapatan harus di pilih",
            icon: "Warning",
        })
    }else{
        
    
    var updatedatamcu = dataitemtarif.findIndex((obj=>obj.iditemmcu==iditemupdate))
    dataitemtarif[updatedatamcu].namapemeriksaan = pemeriksaanmodal.value
    dataitemtarif[updatedatamcu].lokasipemeriksaan = lokasipemeriksaanmodal.value
    dataitemtarif[updatedatamcu].pemeriksaanpenunjang = $( "#peperiksaanpenunjangmodal option:selected" ).text();
    dataitemtarif[updatedatamcu].idtest = idtestmodal.value
    dataitemtarif[updatedatamcu].tarifitem = tarifmodal.value
    dataitemtarif[updatedatamcu].showjasa = showkodejasamodal.value
    dataitemtarif[updatedatamcu].kodejasa = kodejasamodal.value
    // dataitemtarif[updatedatamcu].kodependapatan = kodependapatanmodal.value
    dataitemtarif[updatedatamcu].kodependapatan = kodependapatanmodal.value
    var close = document.getElementById('btnModalSrcPasienClose')
    $('#itemtarifmcumodal').modal('hide')
    console.log(dataitemtarif)
    $('#listitempaketmcu').empty()

    loaddataarray()
    }
    })
    }

function loaddataarray() {
dataitemtarif.forEach(myFunction);
    function myFunction(item, index) {
       
        $('#listitempaketmcu').append(
            `<tr id="${item.iditemmcu}" class="remove">
            <td>${item.iditemmcu}</td>
            <td>${item.namapemeriksaan}</td>
            <td>${item.lokasipemeriksaan}</td>
            <td>${item.pemeriksaanpenunjang}</td>
            <td>${item.idtest}</td>
            <td>${item.tarifitem}</td>
            <td>${item.showjasa}</td>
            <td>${item.kodejasa}</td>
            <td>${item.kodependapatan}</td>
            </tr>`
         )       
    }
    selectedtable()

}
