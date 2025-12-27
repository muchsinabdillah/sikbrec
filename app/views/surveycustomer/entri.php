
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Klinik</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 20px;
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        h2 {
            font-size: 20px;
            color: #00cec9;
            margin-bottom: 8px;
        }

        .emoji-options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 25px;
        }

        .emoji-options label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            border-radius: 10px;
            padding: 5px;
            transition: transform 0.2s ease;
            width: 120px;
        }

        .emoji-options label:hover {
            background-color: #465d73;
        }

        .emoji-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .label-text {
            margin-top: 5px;
            color: #000000;
            font-size: 14px;
        }

        .emoji-options input[type="radio"] {
            display: none;
        }

        .emoji-options input[type="radio"]:checked + img {
            transform: scale(1.1);
            border: 3px solid #00cec9;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Survey Kepuasan Pasien<br>Klinik Mata Brebes Eye Center</h2>
        <form method="POST" action="">
            <div class="emoji-options">
            <input type="hidden" name="noreg" id="noreg" value="-"   >
                <label>
                    <input type="radio" name="penilaian" value="Sangat Puas"   onclick="handleSangatPuas(this.value)">
                    <img src="<?= BASEURL; ?>/images/sangatpuas.png" class="emoji-img" alt="Sangat Puas">
                    <div class="label-text">Sangat Puas</div>
                </label>
                <label>
                    <input type="radio" name="penilaian" value="Puas" onclick="handlePuas(this.value)" >
                    <img src="<?= BASEURL; ?>/images/puas.png" class="emoji-img" alt="Puas">
                    <div class="label-text">Puas</div>
                </label>
                <label>
                    <input type="radio" name="penilaian" value="Tidak Puas" onclick="handleTidakPuas(this.value)">
                    <img src="<?= BASEURL; ?>/images/tidakpuas.png" class="emoji-img" alt="Tidak Puas">
                    <div class="label-text">Tidak Puas</div>
                </label>
            </div>
        </form>
    </div>
</body>
</html>

<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>


<script src="<?= BASEURL; ?>/js/App/surveycustomer/entri.js?v=<?php echo time(); ?>"></script>