<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIRYARSI v2.0.4</title>
    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/js/DataTables/datatables.min.css" />
    <link rel="shortcut icon" href="<?= BASEURL; ?>/images/gutlogo.PNG" />
    <!-- ========== COMMON STYLES ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/lobipanel/lobipanel.min.css" media="screen">

    <!-- ========== PAGE STYLES ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/prism/prism.css" media="screen">
    <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/icheck/skins/line/blue.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/icheck/skins/line/red.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/icheck/skins/line/green.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap-tour/bootstrap-tour.css">
    <!-- ========== THEME CSS ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/main.css" media="screen">

    <!-- ========== MODERNIZR ========== -->
    <script src="<?= BASEURL; ?>/js/modernizr/modernizr.min.js"></script>
    <!-- ========== DATATABLES ========== -->

    <link href="<?= BASEURL; ?>/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
    }

    .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font: 14px arial;
    }

    @font-face {
        font-family: "Lato";
        src: url('698242188-Lato-Bla.eot');
        src: url('698242188-Lato-Bla.eot?#iefix') format('embedded-opentype'),
            url('698242188-Lato-Bla.svg#Lato Black') format('svg'),
            url('698242188-Lato-Bla.woff') format('woff'),
            url('698242188-Lato-Bla.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        font-family: 'Lato', sans-serif;
    }

    .form-group {
        font-size: 12px;

    }

    .gut {
        margin-top: -13px;

    }

    input[type=text],
    input[type=number],
    input[type=date] {
        font-family: 'Lato', sans-serif;
        font-size: 12px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        padding: 5px;

    }

    input[type=text]:focus,
    input[type=number]:focus,
    input[type=date]:focus {
        background-color: lightblue;
    }

    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 10px;
    }
    </style>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/newtable.css" media="screen">
</head>
<div class="preloader">
    <div class="loading">
        <img src="<?= BASEURL; ?>/images/loading.gif" width="80">
        <p>Harap Tunggu</p>
    </div>
</div>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">