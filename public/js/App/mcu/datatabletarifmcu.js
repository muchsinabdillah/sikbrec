$(document).ready(function() {
    $('#tarifmcutbl').DataTable();
    $('.lokasi').hide()
} );
$('#kodejasa').select2()
$('#kodependapatan').select2()
var base_url = window.location.origin;
var pemeriksaan=document.getElementById('pemeriksaan')
var lokasipemeriksaan=document.getElementById('lokasipemeriksaan')
var pemeriksaanpenunjang=document.getElementById('pemeriksaanpenunjang')
var datapemeriksaanpenunjang
var idtest=document.getElementById('idtest')
var tarifitem=document.getElementById('tarifitem')
var rupiah = document.getElementById('tarif')
var header = document.getElementById('header')
var namapaket = document.getElementById('namapaket')
var pemeriksaan = document.getElementById('pemeriksaan')
var simpantarifmcu = document.getElementById('simpantarifmcu')
var showjasa = document.getElementById('showjasa')
var kodejasa = document.getElementById('kodejasa')
var dataitemtarif =[]

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

var tarifitem = document.getElementById('tarifitem')
tarifitem.addEventListener('keyup',function (e) {
    tarifitem.value = formatRupiah(this.value,'RP. ')
})

var itemmcu = document.getElementById('additempaketmcu')
itemmcu.addEventListener('click',function (e) {
    // console.log(header.value)
    var random = Math.floor(Math.random()*100)+1;
    e.preventDefault()
    if($("#header:checkbox:checked").val()){
        if(namapaket.value!='' && $('#tglberlaku').val()!='' && $('#akhirberlaku').val()!='' &&$('#tarif').val()!=''&& pemeriksaanpenunjang.value!=''&&lokasipemeriksaan.value!=''&&pemeriksaan.value!=''&&idtest.value!=''&&tarifitem.value!=''&& $('#showjasa').val()!=''){
            if(showjasa.value==1 && kodejasa.value==''){
                alert('kode jasa tidak boleh kosong')
            }else{
                $('#listitempaketmcu').append(
                    `<tr id="${random}" class="remove">
                    <td>${pemeriksaan.value}</td>
                    <td>${lokasipemeriksaan.value}</td>
                    <td>${datapemeriksaanpenunjang}</td>
                    <td>${idtest.value}</td>
                    <td>${tarifitem.value}</td>
                    <td>${$("#showjasa option:selected").text()}</td>
                    <td>${$('#kodejasa').val()}</td>
                    <td>${$('#kodependapatan').val()}</td>
                    <td><button class="btn btn-danger" onclick="deleteitemmcu(${random})">X </button>
                    </tr>
                    `
                 )       
                dataitemtarif.push({
                iditemmcu:random,
                namapemeriksaan:pemeriksaan.value,
                lokasipemeriksaan:lokasipemeriksaan.value,
                pemeriksaanpenunjang:datapemeriksaanpenunjang,
                idtest:idtest.value,
                tarifitem:tarifitem.value,
                showjasa:$("#showjasa").val(),
                kodejasa:$('#kodejasa').val(),
                kodependapatan:$('#kodependapatan').val(),
                })
                console.log(dataitemtarif)
                clearitem()
            }
            

        }else{
            swal({
                title: "Warning",
                text: "nama paket,masa berlaku,Sampai dengan, tarif,header,pemeriksaan lokasi pemeriksaan pemeriksaan ponunjang idtest tarif dan showjasa wajib di isi",
                icon: "error",
            })
            // alert('')
        }
    }else{
        swal({
            title: "Warning",
            text: "Header Belum Di pilih",
            icon: "error",
        })
    }
    
   

})

function formatRupiah(angka, prefix){
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
simpantarifmcu.addEventListener('click',function (e) {

    if(dataitemtarif.length==0){
        alert("item paket belum di tambahkan")
    }
    var formData={
        namapaket:namapaket.value,
        tglberlaku:$('#tglberlaku').val(),
        sampaidengan:$('#akhirberlaku').val(),
        tarif:$('#tarif').val(),
        header:$("#header:checkbox:checked").val(),
        ekg:$("#ekg:checkbox:checked").val(),
        treadmil:$("#treadmil:checkbox:checked").val(),
        discontinue:$("#discontinue:checkbox:checked").val(),
        spirometri:$("#spirometri:checkbox:checked").val(),
        Group_Spesialis:$("#Group_Spesialis").val(),
        dataitemtarif:dataitemtarif
    }
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/TarifMcu/inputdatarujukan',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data)
        if(data.status==200){
            swal({
                title: "success",
                text: "Tarif Mcu Berhasil Di buat",
                icon: "success",
            })
            resetform()

        }else{
            swal({
                title: "Warning",
                text: "Something went wrong",
                icon: "Warning",
            })
        }
            
      
    })
})

function deleteitemmcu(params) {
    $('#'+params).remove()
    var item = dataitemtarif.indexOf(params);
dataitemtarif.splice(item, 1);
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
showjasa.addEventListener('change',function () {
    if(this.value == 0){
        $('#kodejasa').attr('disabled')
        kodejasa.setAttribute("disabled", true);
    }else{
        // $('#kodejasa').attr('enabled')
        kodejasa.disabled = false
    }
})

namapaket.addEventListener('keyup',function () {
    console.log(this.value)
    formData ={
        namapaket:this.value
    }
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/TarifMcu/getHeaderByName',
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data)
        var form = document.getElementById("mcutarif");
        var elements = form.elements;
        if(data.status==200){
            document.getElementById('warning').innerHTML="<span>Data Sudah ADA</span>"
           for (var i = 1, len = elements.length; i < len; ++i) {
               elements[i].readOnly = true;
           }

        }else{
           document.getElementById('warning').innerHTML=""
           for (var i = 1, len = elements.length; i < len; ++i) {
            elements[i].readOnly = false;
            }
        }
            
      
    })
})