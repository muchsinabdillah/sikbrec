<!DOCTYPE html>
<html lang="ar">
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?= BASEURL; ?>/js/qrcode/jquery.qrcode.min.js"></script>
    <script>
    $(document).ready(function() {
        var id = $('#NoRegistrasi').val();
        $('#output').qrcode(id);
    });
    </script>
    </script>
    <title>Bukti Registrasi</title>
    <style>
    @media print {
        @page {
            margin: 0 auto;
            /* imprtant to logo margin */
            sheet-size: 600px 250mm;
            /* imprtant to set paper size */
        }

    }
        #xh1 {
        font-size: 0.6em; /* 40px/16=2.5em */
        }
        #xh2 {
        font-size: 1em; /* 40px/16=2.5em */
        }
        #xh3 {
        font-size: 0.8em; /* 40px/16=2.5em */
        }
        #noantrian {
        font-size: 2em; /* 40px/16=2.5em */
        }
        #printContainer{
            margin-left: 10px;
            margin-right: 10px;
        }
        #hr2 {
      border: 0;
      height: 5px;
      background-color: #333; /* warna garis */
      width: 80%; /* lebar garis */
      margin: 20px auto; /* memberikan jarak di atas dan bawah */
    }
    </style>

</head>

<body onload="window.print();">
    

    <div id='printContainer'>
        
        <div id="xh3" align="center"><b>Klinik Utama Brebes Eye Center </b></div>
        <div id="xh1" align="center"><b>Jl. Angkasa No. 19, Blubuk, Losari</b></div> 
        <hr/> 
        <table border="0" width="100%">
        <tr class="hr2">
        <td colspan="3"><div id="xh3" align="center">BUKTI PENDAFTARAN </div></td>
        </tr>
            <tr>  
                <td id="xh3" colspan="3"></td> 
            </tr>
            <tr>  
                <td id="xh3" colspan="3"  align="center"> <?= $data['listdata1']['tglfix'] ?> / <?= $data['listdata1']['jamfix'] ?> </td> 
            </tr> 
            <tr>
                <td id="xh3" width="25%"> Nama Pasien </td> 
                <td id="xh3">:</td> 
                <td id="xh3"><?= $data['listdata1']['PatientName'] ?></td> 
            </tr> 
            <tr>
                <td id="xh3" width="25%"> No. MR</td> 
                <td id="xh3" width="1%"> : </td> 
                <td id="xh3"><?= $data['listdata1']['NoMR'] ?></td> 
            </tr> 
            <tr>
                <td id="xh3" width="30%"> No. Reg </td> 
                <td id="xh3" width="1%"> : </td> 
                <td id="xh3"><?= $data['listdata1']['NoRegistrasi'] ?></td> 
            </tr> 
            <tr>
                <td id="xh3" width="25%"> Ruang </td> 
                <td id="xh3" width="1%"> : </td> 
                <td id="xh3"><?= $data['listdata1']['NamaUnit'] ?></td> 
            </tr> 
            <tr>
                <td id="xh3" width="25%"> Dokter </td> 
                <td id="xh3" width="1%"> : </td> 
                <td id="xh3"><?= $data['listdata1']['dokternama'] ?></td> 
            </tr> 
            
        </table>
        <table border="0">
             
        </table>
        <p class="text-center">
        </p>
        <input class="form-control input-sm" type="hidden" id="NoRegistrasi" readonly name="NoRegistrasi"
            value="<?= $data['listdata1']['NoRegistrasi'] ?>">
       
        <table border="0" width="100%"> 
            <tr>
                <td width="100%" colspan="2" align="center" id="xh2">
                 No. Antrian Dokter :
                </td>
            </tr> 
            <tr>
                <td width="100%" colspan="2" align="center" id="noantrian">
                 <?= $data['listdata1']['NoAntrianAll'] ?> 
                </td>
            </tr>
        </table>
        
    </div>
</body>

</html>