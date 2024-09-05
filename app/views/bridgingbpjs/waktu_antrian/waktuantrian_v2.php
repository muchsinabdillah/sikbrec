<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap error page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&family=Lemonada:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: 'Cardo', serif;

        }

        .row {
            margin: 0;
        }

        a {
            background-color: #182C61;
            border: 0px;
            text-decoration: none;
            padding: 10px;
            color: #000;
            font-family: 'Lemonada', cursive;

        }

        a:hover {
            text-decoration: none;
            color: #000;
            background-color: #000;
        }

        h1 {
            font-size: 180px;
        }

        h4 {
            padding-bottom: 20px;
            font-family: 'Lemonada', cursive;

        }

        p {
            font-family: 'Lemonada', cursive;
            text-align: center;

        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12 d-flex flex-column justify-content-center align-items-center text-black vh-100">
        <div class="col-sm-6">
                                      <input type="hidden" id="MNoTrs" name="MNoTrs" value="<?=$data['noreg']?>">
                                      <input type="hidden" id="TaskID" name="TaskID" value="<?=$data['taskid']?>">
                                      </div>
            <h4>Bridging BPJS</h4>
            <p>Halaman Ini Untuk Bridging Ke BPJS, Silahkan Ditutup Setelah Muncul Pesan !</p>
            <a href="<?= Utils::delSession(); ?>" class="btn btn-primary btn-lg btn-rounded">Close</a>
        </div>
    </div>
</body>

</html>

<!-- /.error-box -->
</div>
</div>
</div>

</div>
<!-- /.container-fluid -->
</section>


</div>
<!-- /.main-page -->

<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/bridgingbpjs/waktuantrian/waktuantrian.js"></script>