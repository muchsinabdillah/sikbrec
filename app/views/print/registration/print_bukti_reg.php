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
            sheet-size: 300px 250mm;
            /* imprtant to set paper size */
        }

    }
        #xh1 {
        font-size: 0.5em; /* 40px/16=2.5em */
        }
        #xh2 {
        font-size: 1em; /* 40px/16=2.5em */
        }
        #xh3 {
        font-size: 0.7em; /* 40px/16=2.5em */
        }
    </style>

</head>

<body onload="window.print();">
    

    <div id='printContainer'>
  <img src='<?= BASEURL; ?>/images/yarsi.png' width="50px" height="25px" alt='Logo'> 
        <div id="xh3" align="center">BUKTI REGISTRASI </div>

        <table border="0" width="100%">
            <tr>
                <td id="xh1"><b> Tanggal : <?= $data['listdata1']['tglfix'] ?></b></td> 
            </tr>
            <tr>
                <td id="xh1"><b> Jam : <?= $data['listdata1']['jamfix'] ?> <br></b></td> 
            </tr>

            <tr>
                <td colspan="2" align="center" id="xh1"><b><?= $data['listdata1']['NamaUnit'] ?></b></td>

            </tr>
        </table>
        <table border="0">
             
        </table>
        <p class="text-center">
        </p>
        <input class="form-control input-sm" type="hidden" id="NoRegistrasi" readonly name="NoRegistrasi"
            value="<?= $data['listdata1']['NoRegistrasi'] ?>">
        <hr>

        <table border="0" width="100%">
            <tr>
                <td width="100%" colspan="2" align="center" id="xh1"><b><?= $data['listdata1']['PatientName'] ?></b></td>

            </tr>
            <tr>
                <td width="100%" colspan="2" align="center" id="xh1"><?= $data['listdata1']['NoMR'] ?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" align="center" id="xh1"><?= $data['listdata1']['dokternama'] ?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" align="center" id="xh2">
                 <?= $data['listdata1']['NoAntrianAll'] ?> 
                </td>
            </tr>
            <tr>
           
          
        </table>
        <hr>

    </div>
</body>

</html>