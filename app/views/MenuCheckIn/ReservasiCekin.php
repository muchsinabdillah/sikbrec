<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <title>CHECK IN RESERVATION</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" alt="Image" class="img-fluid" data-pagespeed-url-hash="4289692523" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3>Verify Data Booking</h3>
                        </div>
                        <form action="#" method="post">
                            <div class="form-group first">
                                <label for="username">No. Booking</label>
                                <input type="text" class="form-control mt-2" id="nobooking" name="nobooking" readonly>
                            </div>
                            <div class="form-group first mt-3">
                                <label for="username">Nama Anda</label>
                                <input type="text" class="form-control mt-2" id="namaanda" name="namaanda" readonly>
                            </div>
                            <div class="form-group first mt-3">
                                <label for="username">Poliklinik</label> 
                                <input type="text" class="form-control mt-2" id="poliklinikname" name="poliklinikname" readonly>
                            </div>
                            <div class="form-group first mt-3">
                                <label for="username">Dokter</label> 
                                <input type="text" class="form-control mt-2" id="doktername" name="doktername" readonly>
                            </div>
                            <div class="form-group first mt-3">
                                <label for="username">Jam Praktek</label>
                                <input type="text" class="form-control mt-2" id="jamprakter" name="jamprakter" readonly>
                            </div>
                            <div class="d-flex mb-5 align-items-center ">
                                <div class="control__indicator"></div>
                            </div>
                            <input type="submit" value="Check In" class="btn btn-block btn-primary" style="margin-top: -50px;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
</body>

</html>