<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKBREC v2.0.4</title>
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
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/jquery-ui/jquery-ui.css">

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
    .navigationColorLeft{
        background-color: #990000;
    }
    .navigationColorTop{
        background-color: #043699;
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
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/newbutton.css">
</head>
<div class="preloader">
    <div class="loading">
        <img src="<?= BASEURL; ?>/images/loading.gif" width="80">
        <p>Harap Tunggu</p>
    </div>
</div>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <nav class="navbar top-navbar bg-white box-shadow">
            <div class="container-fluid">
                <div class="row">
                    <div class="navbar-header no-padding">
                        <a class="navbar-brand" href="<?= BASEURL; ?>">

                            <img src="<?= BASEURL; ?>/images/yarsi.png" alt="PMS System - GUT" class="logo"
                                height="60px" width="80px">
                        </a>
                        <span class="small-nav-handle hidden-sm hidden-xs"><i class="fa fa-outdent"></i></span>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <button type="button" class="navbar-toggle mobile-nav-toggle">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- /.navbar-header -->

                    <div class="collapse navbar-collapse" id="navbar-collapse-1">
                        <ul class="nav navbar-nav" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li class="hidden-sm hidden-xs"><a href="#" class="user-info-handle"><i
                                        class="fa fa-user"></i></a></li>
                            <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i
                                        class="fa fa-arrows-alt"></i></a></li>
                            <li class="hidden-xs hidden-xs">
                                <!-- <a href="#">My Tasks</a> -->
                            </li>
                        </ul>
                        <!-- /.nav navbar-nav -->
                        <ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <!-- /.dropdown -->
                            <li class="dropdown tour-two">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false"><?= $data->name; ?> </a> 
                            </li>
                            <li class="dropdown tour-two">
                                <a href="<?= BASEURL; ?>/LogOut" class="color-danger text-center"><i
                                class="fa fa-sign-out"></i> Logout</a>
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                        <!-- /.nav navbar-nav navbar-right -->
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <!-- ========== LEFT SIDEBAR ========== bg-black-300 -->
                <div class="left-sidebar  navigationColorLeft box-shadow tour-three">
                    <div class="sidebar-content">
                        <div class="user-info closed">
                            <img src="#" alt="<?= $data->name; ?>" class="img-circle profile-img">
                            <h6 class="title"> <?= $data->name; ?></h6>
                            <small class="info">User</small>
                        </div>
                        <!-- /.user-info -->
                        <div class="sidebar-nav">
                            <ul class="side-nav color-gray">
                                <li class="nav-header">
                                    <span class="">MASTER DATA</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-lock"></i> <span>ADMINISTRATOR</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active" onclick="getHakAkses(1)"><a href="#"><i
                                                    class="fa fa-gear"></i> <span>Master Menu</span></a></li>
                                        <li class="active" onclick="getHakAkses(2)"><a href="#"><i
                                                    class="fa fa-gears"></i> <span>Master Sub Menu</span></a></li>
                                        <li class="active" onclick="getHakAkses(3)"><a href="#"><i
                                                    class="fa fa-bolt"></i> <span>User Login Aplikasi</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/Eticket"><i class="fa fa-bolt"></i>
                                                <span>List E-Ticket</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MaintenanceAsetIT/list"><i
                                                    class="fa fa-bolt"></i> <span>Maintenance Asset IT</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterAsset/list"><i
                                                    class="fa fa-bolt"></i> <span>Asset IT</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/ParameterRekening/list"><i
                                                    class="fa fa-bolt"></i> <span>Parameter Rekening</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/dataRumahSakit/list"><i
                                        class="fa fa-bolt"></i> <span>Data RS</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterIPUnitFarmasi/List"><i
                                                    class="fa fa-spoon"></i> <span>IP Komputer Farmasi</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterPrinterLabel/List"><i
                                                    class="fa fa-spoon"></i> <span>Master Printer Label</span></a></li> 
                                        
                                    </ul>
                                </li>
                                <!-- <li class="has-children">
                                <a href="#"><i class="fa fa-building"></i> <span>HRD</span> <i class="fa fa-angle-right arrow"></i></a>
                                <ul class="child-nav">
                                    <li class="active" onclick="getHakAkses(4)"><a href="#"><i class="fa fa-institution"></i> <span>Data Department</span></a></li>
                                    <li onclick="getHakAkses(5)"><a href="#"><i class="fa fa-life-ring"></i> <span>Data Unit Kerja</span></a></li>
                                    <li onclick="getHakAkses(6)"><a href="#"><i class="fa fa-flag-o"></i> <span>Data Jabatan</span></a></li>
                                    <li onclick="getHakAkses(7)"><a href="#">><i class="fa fa-bookmark"></i> <span>Data Status Pegawai</span></a></li>
                                    <li onclick="getHakAkses(8)"><a href="#"><i class="fa fa-comments-o"></i> <span>Data Group Shift</span></a></li>
                                    <li onclick="getHakAkses(9)"><a href="#"><i class="fa fa-calendar-check-o"></i> <span>Data Shift Pegawai</span></a></li>
                                    <li onclick="getHakAkses(10)"><a href="#"><i class="fa fa-child"></i> <span>Data Pegawai</span></a></li>
                                    <li onclick="getHakAkses(11)"><a href="#"><i class="fa fa-cubes"></i> <span>Data Komponen Payroll</span></a></li>
                                </ul>
                                </li>-->
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-building-o"></i> <span>BILLING</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Dokter</span></a></li>
                                        <li class="active" onclick="getHakAkses(13)"><a hre f="#"><i
                                                    class="fa fa-tasks"></i> <span>Master Jadwal Dokter</span></a></li>
                                        <li class="active" onclick="getHakAkses(14)"><a href="#"><i
                                                    class="fa fa-map-o"></i> <span>Master Perusahaan</span></a></li>
                                        <li class="active" onclick="getHakAkses(15)"><a href="#"><i
                                                    class="fa fa-map-o"></i> <span>Master Asuransi</span></a></li>
                                        <li class="active" onclick="getHakAkses(16)"><a href="#"><i
                                                    class="fa fa-money"></i> <span>Master Refferal</span></a></li>
                                        <li class="active" onclick="getHakAkses(17)"><a href="#"><i
                                                    class="fa fa-tasks"></i> <span>Master Cuti Dokter</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterLiburNasional"><i
                                                    class="fa fa-tasks"></i> <span>Master Libur Nasional</span></a></li>
                                        <li class="active" onclick="getHakAkses(18)"><a href="#"><i
                                                    class="fa fa-ticket"></i> <span>Master Data Karcis</span></a></li>
                                        <li class="active" onclick="getHakAkses(19)"><a href="#"><i
                                                    class="fa fa-ticket"></i> <span>Master Unit</span></a></li>
                                        <li class="active" onclick="getHakAkses(20)"><a href="#"><i
                                                    class="fa fa-spoon"></i> <span>Master Kamar</span></a></li>
                                        <li class="active" onclick="getHakAkses(21)"><a href="#"><i
                                                    class="fa fa-spoon"></i> <span>Master Bed</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterCOB/"><i
                                                    class="fa fa-spoon"></i> <span>Master COB</span></a></li>
                                
                                    </ul>
                                </li>

                                <li class="has-children">
                                    <a href="#"><i class="fa fa-building-o"></i> <span>TARIF</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/InfoMasterTarif/MasterTarif"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Info Master Tarif</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(23)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Kamar</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listrajal"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listtindakanlab"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Tindakan
                                                    Laboratorium</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listlab"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Laboratorium</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listranap"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listradiologi"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Operasi</span></a></li>
                                        <li class="active" onclick="getHakAkses(44)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif MCU</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Paket</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-fax"></i> <span>FINANCE</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/TipePembayaran"><i class="fa fa-map"></i>
                                                <span>Master Tipe Pembayaran</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterGroupRekening"><i class="fa fa-map"></i>
                                                <span>Group Rekening</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterGroupCOARekening"><i class="fa fa-map"></i>
                                                <span>COA Group Rekening</span></a></li> 
                                        <li class="active"><a href="<?= BASEURL; ?>/Coa"><i class="fa fa-map"></i>
                                                <span>Master C.O.A</span></a></li> 
                                        <li class="active"><a href="<?= BASEURL; ?>/Pdp"><i class="fa fa-tag"></i>
                                                <span>Master PDP</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/PdpDetil"><i class="fa fa-tags"></i>
                                                <span>Master PDP Detil</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/Jasa"><i class="fa fa-star"></i>
                                                <span>Master Jasa Medis</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/JasaDetil"><i
                                                    class="fa fa-star-half"></i> <span>Master Jasa Medis
                                                    Detil</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataBeban/listMasterBeban"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Beban</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-fax"></i> <span>INVENTORY</span> <i
                                            class="fa fa-angle-right arrow"></i></a>


                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterKelompokBarang/list"><i
                                                    class="fa fa-star-half"></i> <span>Master Kelompok Barang</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterGolongan/list"><i
                                                    class="fa fa-map-pin"></i> <span>Master Golongan Barang</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataJenisBarang/list"><i
                                                    class="fa fa-star"></i> <span>Master Jenis Barang</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/GroupBarang/list"><i
                                                    class="fa fa-paper-plane-o"></i> <span>Master Group
                                                    Barang</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterSatuan/list"><i
                                                    class="fa fa-map"></i> <span>Master Satuan</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataPabrik/list"><i
                                                    class="fa fa-industry"></i> <span>Master Pabrik</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterSupplier/list"><i
                                                    class="fa fa-tags"></i> <span>Master Supplier</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataFormularium/list"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Formularium</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterMarginObat/"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Margin
                                                    Barang</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataBarang/list"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Master Barang</span></a></li> 
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterPaketInventory/list"><i
                                        class="fa fa-puzzle-piece"></i> <span>Master Paket Inventory</span></a></li> 
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">MASTER TARIF 2024</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-building-o"></i> <span>NAMA TARIF</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">

                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listtindakanlab"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tindakan/Nilai Rujukan
                                                    Laboratorium</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listrajal"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listlab"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Laboratorium</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listranap"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listradiologi"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a>
                                        </li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Operasi</span></a></li>
                                        <li class="active" onclick="getHakAkses(44)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif MCU</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Paket</span></a></li>
                                        <li class="active" onclick="getHakAkses(23)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Kamar</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-building-o"></i> <span>TRANSAKSI TARIF</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">

                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/MasterDataTarif/listtransaksitarif"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/MasterDataTarif/listtransaksitariflab"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Laboratorium</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/MasterDataTarif/listtransaksitarifrad"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/MasterDataTarif/listtransaksitarifri"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a>
                                        </li>

                                        <li class="active" onclick="getHakAkses(44)"><a href="#"><i
                                                    class="fa fa-puzzle-piece"></i> <span>Tarif MCU</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">ADMINISTRASI</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RESERVASI PASIEN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(46)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Rencana Kontrol</span> <span style="margin-left: 10px;"
                                                    class="label label-danger">RI</a></li>
                                        <li onclick="getHakAkses(47)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Rencana Kontrol</span> <span style="margin-left: 10px;"
                                                    class="label label-success">Faskes 1</span></a></li>
                                        <li onclick="getHakAkses(48)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Reservasi Pasien Walkin</span></a></li>
                                        <li onclick="getHakAkses(49)"><a href="#"><i class="fa fa-thumb-tack"></i>
                                                <span>Reservasi Pasien non Walkin</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>REGISTRASI PASIEN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aMedicalRecord"><i class="fa fa-lock"></i>
                                                <span>Medical Record Pasien</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aAntrianCaller/pendaftaran"><i class="fa fa-lock"></i>
                                                <span>Antrian Pendaftaran</span></a></li>
                                        <li onclick="getHakAkses(50)"><a href="#"><i class="fa fa-unlock"></i>
                                                <span>Registrasi Rawat Jalan</span></a></li>
                                        <li onclick="getHakAkses(51)"><a href="#"><i class="fa fa-unlock"></i>
                                                <span>Registrasi Pasien Walkin</span></a></li>
                                        <!--  <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Pasien Telemedicine</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Lihat jadwal Dokter</span></a></li>
                     <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Registrasi Rawat Jalan</span></a></li>-->
                                        <li onclick="getHakAkses(52)"><a href="#"><i class="fa fa-unlock"></i>
                                                <span>Permintaan Rawat</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aRegistrasiMRBayi"><i class="fa fa-unlock"></i>
                                                <span>Permintaan MR Bayi</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aRegistrasiRajal/list_odc"><i
                                                    class="fa fa-unlock"></i>
                                                <span>Permintaan ODC</span></a></li>
                                        <li onclick="getHakAkses(53)"><a href="#"><i class="fa fa-unlock"></i>
                                                <span>List Pasien Rawat Inap</span></a></li> 
                                        <li><a href="<?= BASEURL; ?>/aBookingKamar"><i class="fa fa-unlock"></i>
                                                <span>Booking Kamar Rawat Inap</span></a></li> 
                                        <li><a href="<?= BASEURL; ?>/bInformationDashboardBed"><i class="fa fa-unlock"></i>
                                                <span>Dashboard Bed</span></a></li> 
                                        <li><a href="<?= BASEURL; ?>/aregistrasikamar/listCleaningRoom"><i class="fa fa-unlock"></i>
                                                <span>Cleaning Kamar</span></a></li> 
                                        <!-- <li><a href="<?= BASEURL; ?>/aapproveOT/"><i class="fa fa-unlock"></i>
                                        <span>Approve OT</span></a></li>  -->
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>BILLING PASIEN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                    <li><a href="<?= BASEURL; ?>/aApproveOT"><i
                                        class="fa fa-lock"></i> <span>Approval Kamar Operasi</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listbebas"><i
                                                    class="fa fa-lock"></i> <span>Penjualan Bebas</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listrajal"><i
                                                    class="fa fa-thumb-tack"></i> <span>Rawat Jalan</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listranap"><i
                                                    class="fa fa-thumb-tack"></i> <span>Rawat Inap</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listwalkin"><i
                                                    class="fa fa-thumb-tack"></i> <span>Billing Pasien Walkin</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listvoucher"><i
                                                    class="fa fa-thumb-tack"></i> <span>Voucher Pelunasan</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/InfoLaporanKasir"><i class="fa fa-thumb-tack"></i>
                                                <span>Info Laporan Kasir</span></a>
                                        </li>
                                        <!--<li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Deposit</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Kamar</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Pengembalian</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Laporan Harian Pasien</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Laporan Kasir</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Print Formulir</span></a></li>-->
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO REKAM MEDIK</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">

                                        <li onclick="getHakAkses(54)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi LMA</span></a></li>
                                        <li onclick="getHakAkses(55)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Rekam Medik</span></a></li>
                                        <li onclick="getHakAkses(56)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Resume Medis</span></a></li>
                                    </ul>
                                </li> 
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO REGISTRASI</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav"> 
                                        <li onclick="getHakAkses(60)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Pasien Ranap</span></a></li>
                                        <li onclick="getHakAkses(61)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Registrasi</span></a></li> 
                                        <li onclick="getHakAkses(62)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Rekap MCU</span></a></li> 
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO MUTU LAYANAN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                         
                                        <li><a href="<?= BASEURL; ?>/bInformasiWaktuTunggu"><i class="fa fa-bank"></i>
                                                <span>Waktu Tunggu Poliklinik</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInformasiWaktuTunggu/WaktuVisiteDJPJ"><i
                                                    class="fa fa-bank"></i> <span>Waktu Visite DPJP</span></a>
                                        </li> 
                                        <li onclick="//getHakAkses(64)"><a href="<?= BASEURL; ?>/binformationMPP/"><i
                                                    class="fa fa-bank"></i>
                                                <span>MPP</span></a></li> 
                                    </ul>
                                </li> 
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO BPJS</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav"> 
                                        <li onclick="getHakAkses(45)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Pasien BPJS</span></a></li>
                                        <li onclick="getHakAkses(65)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Grafik BPJS</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/xBPJSBridging_PRB/"><i class="fa fa-bank"></i>
                                                <span>Pasien Rujuk Balik (PRB)</span></a></li> 
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>PENUNJANG</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInformationHasilLab"><i
                                                    class="fa fa-file-text"></i><span>Info Hasil Laboratorium</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aInfoTindakanFisio"><i
                                                    class="fa fa-file-text"></i><span>Info Tindakan
                                                    Fisioteraphy</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfoRadiologi/"><i
                                                    class="fa fa-file-text"></i><span>Info Radiologi</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfoOrderDarah/"><i
                                                    class="fa fa-file-text"></i><span>Hasil List Order Darah</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfoBankDarah/"><i
                                                    class="fa fa-file-text"></i><span>Info Bank Darah</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfoBankDarah/"><i
                                                    class="fa fa-file-text"></i><span>Generate PDF</span></a>
                                        </li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/LabGlucosa/entri"><i
                                                    class="fa fa-file-text"></i><span>Entri Hasil Glukosa</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO LAINNYA</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(58)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi CPPT</span></a></li>
                                        <li onclick="getHakAkses(59)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Komplain Pasien</span></a></li> 
                                        <li><a href="<?= BASEURL; ?>/fPelaksanaanEdukasi"><i class="fa fa-bank"></i>
                                                <span>Pelaksanaan Edukasi</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/fHandoverPerawat"><i class="fa fa-bank"></i>
                                                <span>Formulir Hand Over <br>Perawat Antar Shift Jaga</span></a></li>  
                                        <li><a href="<?= BASEURL; ?>/bInformationRiwayatImunisasi/"><i class="fa fa-bank"></i>
                                                <span>Info Riwayat Imunisasi Anak </span></a></li>
                                        <li><a href="<?= BASEURL; ?>/MasterDataDokter/list"><i class="fa fa-bank"></i>
                                                <span>Update Data Dokter </span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aRegistrasiKamar/listCleaningRoom"><i class="fa fa-bank"></i>
                                                <span>Update Tempat Tidur </span></a></li>    
                                        <li><a href="<?= BASEURL; ?>/aRegistrasiRajal/listkehadiranmcu"><i class="fa fa-bank"></i>
                                                <span>Scan QR MCU </span></a></li>    
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">MANAGEMENT</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>REKAP PASIEN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInformationRekapRegistrasi"><i
                                                    class="fa fa-bank"></i> <span>Monthly Report</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i
                                                    class="fa fa-lock"></i> <span>Daily Report</span></a></li>
                                        <li onclick="getHakAkses(57)"><a href="#"><i class="fa fa-bank"></i> <span>Rekap
                                                    Dashboard Pasien</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i
                                                    class="fa fa-lock"></i> <span>Grafik Monthly Report</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i
                                                    class="fa fa-lock"></i> <span>Grafik Daily Report</span></a></li>
                                        <li onclick="getHakAkses(54)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi LMA</span></a></li>
                                        <li onclick="getHakAkses(55)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Rekam Medik</span></a></li>
                                        <li onclick="getHakAkses(56)"><a href="#"><i class="fa fa-bank"></i>
                                                <span>Informasi Resume Medis</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInfoHariPerawatan"><i class="fa fa-bank"></i>
                                                <span>Informasi Hari Perawatan</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInfoHariPerawatan/infobor"><i
                                                    class="fa fa-bank"></i> <span>Informasi BOR</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">INFO ICD</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>INFO ICD 9/10</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfo_ICD9"><i class="fa fa-info"></i> <span>INFO
                                                    ICD 9 REKAP</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInfo_ICDX"><i class="fa fa-info"></i> <span>INFO
                                                    ICD 10 REKAP</span></a></li>
                                    </ul>
                                </li>

                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>AUDIT INPUT ICD</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bInfo_Outstanding_icd"><i class="fa fa-info"></i>
                                                <span>Data
                                                    Outstanding ICD</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">DIGITAL SIGN</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>DIGITAL SIGN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(35)"><a href="#"><i class="fa fa-lock"></i> <span>Input
                                                    Digital sign</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">BRIDGING EKLAIM</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>DATA EKLAIM</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/bEKlaim/ListCheckEklaim"><i class="fa fa-lock"></i>
                                                <span>Input Klaim</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bEKlaim/KirimDataOnline"><i class="fa fa-lock"></i>
                                                <span>Kirim Data Online Harian</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>INFORMASI</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aInfoEklaim"><i class="fa fa-lock"></i>
                                                <span>Rekap Diagnosa</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aInfoEklaim/detail"><i class="fa fa-lock"></i>
                                                <span>Detail Klaim</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">BRIDGING BPJS</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>ANTRIAN ONLINE</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(39)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Caller Dokter</span></a></li>
                                        <li onclick="getHakAkses(41)"><a href="#"><i class="fa fa-lock"></i> <span>List
                                                    Waktu Task</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/DashboardAntrianBPJS/dashboardperbulan"><i
                                                    class="fa fa-lock"></i> <span>Dashboard Per Bulan</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/bInformationBPJS/InfoMonitoringBPJS"><i
                                                    class="fa fa-lock"></i> <span>Monitoring Antrian BPJS</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>MONITORING</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(24)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Kunjungan</span><span style="margin-left: 10px;"
                                                    class="label label-success">SEP Induk</span></a></li>
                                        <li onclick="getHakAkses(37)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Kunjungan</span><span style="margin-left: 10px;"
                                                    class="label label-danger">SEP Internal</span></a></li>
                                        <li onclick="getHakAkses(25)"><a href="#"><i class="fa fa-thumb-tack"></i>
                                                <span>Data Klaim</span></a></li>
                                        <li onclick="getHakAkses(26)"><a href="#"><i class="fa fa-unlock"></i>
                                                <span>History Pelayanan Peserta</span></a></li>
                                        <li><a href="#"><i class="fa fa-unlock"></i> <span>Klaim Jasa Raharja</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>PRB</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/xBPJSBridging_PRB"><i
                                                    class="fa fa-lock"></i> <span>Data PRB</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>APPROVAL SEP</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(27)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Pengajuan Approval SEP</span></a></li>
                                        <li onclick="getHakAkses(28)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Approval SEP</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RENCANA KONTROL</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(29)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Rencana Kontrol <span style="margin-left: 10px;"
                                                        class="label label-danger">RI</span></a></span></a></li>
                                        <li onclick="getHakAkses(36)"><a href="#"><i class="fa fa-lock"></i>
                                                <span>Rencana Kontrol <span style="margin-left: 10px;"
                                                        class="label label-success">Faskes 1</span></a></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>L. PENGAJUAN KLAIM</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(33)"><a href="#"><i class="fa fa-lock"></i> <span>Entry
                                                    LPK</span></a></li>
                                        <li onclick="getHakAkses(34)"><a href="#"><i class="fa fa-lock"></i> <span>Edit
                                                    LPK</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RUJUKAN</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(30)"><a href="#"><i class="fa fa-lock"></i> <span>Entry
                                                    Rujukan</span></a></li>
                                        <li onclick="getHakAkses(31)"><a href="#"><i class="fa fa-thumb-tack"></i>
                                                <span>Edit Rujukan</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RUJUKAN <span
                                                style="margin-left: 10px;"
                                                class="label label-success">Khusus</span></span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(32)"><a href="#"><i class="fa fa-lock"></i> <span>Entry
                                                    Rujukan</span></a></li>
                                        <!--   <li><a href="<?= BASEURL; ?>/Rujukan/updateRujukan"><i class="fa fa-thumb-tack"></i> <span>List Rujukan</span></a></li> -->
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">INVENTORY</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Approval</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/InventoryApprove/ListApprovePR"><i
                                                    class="fa fa-credit-card-alt"></i> <span>Purchase
                                                    Requisition</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/InventoryApprove/ListApprovePO"><i
                                                    class="fa fa-credit-card-alt"></i> <span>Purchase Order</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/InventoryApprove/ListApproveOM"><i
                                                    class="fa fa-info"></i> <span>Order Mutasi</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/InventoryApprove/ListApprovePO"><i
                                                    class="fa fa-info"></i> <span>Mutasi</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Purchase Requisition</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/PurchaseForm/list"><i
                                                    class="fa fa-credit-card-alt"></i> <span>Purchase
                                                    Requisition</span></a></li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoPurchaseRequisition/ViewInfoPurchaseRequisition"><i
                                                    class="fa fa-info-circle"></i> <span>Info Detail</span></a></li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoPurchaseRequisitionRekap/ViewInfoPurchaseRequisitionRekap"><i
                                                    class="fa fa-wpforms"></i> <span>Info Rekap</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Purchase Order</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/purchase/list">
                                                <i class="fa fa-credit-card-alt"></i> <span>Purchase Order</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoPurchaseOrder/ViewInfoPurchaseOrder"><i
                                                    class="fa fa-info"></i> <span>Info Detail</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoPurchaseOrderRekap/ViewInfoPurchaseOrderRekap"><i
                                                    class="fa fa-wpforms"></i> <span>Info Rekap</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Delivery Order</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/DeliveryOrder/list"><i
                                                    class="fa fa-truck"></i> <span>Delivery Order</span></a></li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoDeliveryOrder/ViewInfoDeliveryOrder"><i
                                                    class="fa fa-info-circle"></i> <span>Info Detail</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoDeliveryOrderRekap/ViewInfoDeliveryOrderRekap"><i
                                                    class="fa fa-info-circle"></i> <span>Info Rekap</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Retur</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/DeliveryOrder/list"><i
                                                    class="fa fa-truck"></i> <span>Delivery Order</span></a></li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoDeliveryOrder/ViewInfoDeliveryOrder"><i
                                                    class="fa fa-info-circle"></i> <span>Info Detail</span></a>
                                        </li>
                                        <li class="active"><a
                                                href="<?= BASEURL; ?>/InfoDeliveryOrderRekap/ViewInfoDeliveryOrderRekap"><i
                                                    class="fa fa-info-circle"></i> <span>Info Rekap</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Retur Pembelian</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/ReturBeli/list"><i class="fa fa-bar-chart"></i>
                                                <span>Retur Beli</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/ReturJual/list"><i class="fa fa-bar-chart"></i>
                                                <span>Retur Jual</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/ReturJual/listreg"><i class="fa fa-bar-chart"></i>
                                                <span>Retur Jual Per Register</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Faktur Pembelian</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/TukarFaktur/list"><i
                                                    class="fa fa-indent"></i> <span>Tukar Faktur</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/TukarFaktur/manuallist"><i
                                                    class="fa fa-indent"></i> <span>Tukar Faktur <span
                                                        style="margin-left: 10px;"
                                                        class="label label-success">Manual</span></span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/bInfoFaktur/ViewInfoFaktur"><i
                                                    class="fa fa-indent"></i>Info Tukar Faktur</a></li>
                                    </ul>
                                    
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Mutasi</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/OrderMutasiBarang/list"><i
                                                    class="fa fa-credit-card-alt"></i> <span>Order Mutasi</span></a>
                                        </li>
                                        <li class="active"><a href="<?= BASEURL; ?>/MutasiBarang/list"><i
                                                    class="fa fa-credit-card-alt"></i> <span>Mutasi Barang</span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Data Stok</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/InfoBuku/ViewInfobuku"><i
                                                    class="fa fa-book"></i> <span>Info Buku</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/InfoStok/ViewInfostok"><i
                                                    class="fa fa-area-chart"></i> <span>Info Stok</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Resep</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/UDD/list"><i class="fa fa-bar-chart"></i>
                                                <span>UDD</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/Farmasi/RiwayatTransaksi"><i
                                                    class="fa fa-bar-chart"></i> <span> Riwayat Transaksi
                                                    Order</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Penjualan</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                            <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aPenjualanDenganResep/listRJ"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Dengan Resep Dokter Rawat Jalan</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aPenjualanDenganResep/listRI"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Dengan Resep Dokter Rawat Inap</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aPenjualanTanpaResep/list"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Tanpa Resep Dokter</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aTebusResep/list"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Tebus Resep</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/binformasiPenjualan"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Info Penjualan</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Consumable</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                            <li><a href="<?= BASEURL; ?>/InventoryConsumable/list"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Uncharge Consumable</span></a>
                                            </li>
                                            <li><a href="<?= BASEURL; ?>/InventoryCharged/list"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Charged Consumable</span></a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Adjusment</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aAdjusment/list"><i class="fa fa-bar-chart"></i>
                                                <span>List</span></a></li>
                                    </ul>
                                </li>


                                <li class="nav-header">
                                    <span class="">FINANCE</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Kas Pengeluaran</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <!-- <li><a href="<?= BASEURL; ?>/OrderBonSementara/listOrderBon"><i class="fa fa-bar-chart"></i> <span>Order Bon Sementara</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/PencairanKasbon"><i class="fa fa-bar-chart"></i>
                                                <span>Realisasi Bon Sementara</span></a></li> -->
                                        <li><a href="<?= BASEURL; ?>/PencairanKasbon/listpengajuanbonsementara"><i
                                                    class="fa fa-bar-chart"></i> <span>Pengajuan Bon Sementara</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/PencairanKasbon/listpenyelesaian/"><i
                                                    class="fa fa-bar-chart"></i> <span>Realisasi Bon Sementara</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/PengeluaranRutin/listpengeluaranrutin/"><i
                                                    class="fa fa-bar-chart"></i> <span>Pengeluaran Rutin</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/PencairanKasbon"><i class="fa fa-bar-chart"></i>
                                                <span>Informasi Bon Sementara</span></a></li>

                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Generate Data</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/InfoLedger/generateLedger"><i
                                                    class="fa fa-bar-chart"></i> <span>Laporan Keuangan</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Informasi</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/InfoLedger"><i class="fa fa-bar-chart"></i>
                                                <span>Info Ledger Detil</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/InfoLedger/InfoLedgerRekap"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Info Ledger Rekap</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/InfoLedger/jurnalharian"><i
                                                    class="fa fa-bar-chart"></i> <span>Info Jurnal Harian</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InformasiHutang"><i
                                                    class="fa fa-bar-chart"></i> <span> Hutang Detil
                                                </span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/InformasiPiutang"><i
                                                    class="fa fa-bar-chart"></i> <span> Info Piutang
                                                </span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InformasiRekapHutang"><i
                                                    class="fa fa-bar-chart"></i> <span> Rekap Sisa Hutang
                                                </span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InfoOrderPelunasanHutang"><i
                                                    class="fa fa-bar-chart"></i> <span>Pengajuan Pembayaran Hutang</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InfoPengajuanHutangRekap"><i
                                                    class="fa fa-bar-chart"></i> <span>Pengajuan Pembayaran Hutang Rekap</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InfoPelunasanHutangRekap"><i
                                                    class="fa fa-bar-chart"></i> <span>Pelunasan Hutang Rekap</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/InfoPelunasanHutangDetail"><i
                                                    class="fa fa-bar-chart"></i> <span>Pelunasan Hutang Detil</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Hutang</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/Hutang/listOrderPembayaranHutan"><i
                                                    class="fa fa-bar-chart"></i> <span>Pengajuan Pelunasan Hutang</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Hutang/ListPelunasanHutang"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Pelunasan Hutang</span></a></li> 
                                    </ul>
                                </li>

                                <li class="has-children">
                                    <a href="#"><i class="fa fa-bars"></i> <span>Piutang</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/Piutang/listOrderPembayaranPiutang"><i
                                                    class="fa fa-bar-chart"></i> <span>Order Pembayaran
                                                    Piutang</span></a>
                                        </li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/PelunasanPiutang"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Pelunasan Piutang</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/PengirimanBerkasPiutang"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Pengiriman Berkas Piutang</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/InfoMonitoringBerkasPenagihanPiutang"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Monitoring Pengiriman Berkas</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/InformasiPiutangAging"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Aging Piutang</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/Piutang/InfoRekapPiutangInvoice"><i
                                                    class="fa fa-bar-chart"></i>
                                                <span>Buku Besar Piutang</span></a></li>
                                    </ul>
                                </li>

                                <li class="nav-header">
                                    <span class="">HRD</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>Master Data</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/FormDataPegawai"><i class="fa fa-lock"></i>
                                                <span>Upload Document</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">PPI</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-pencil-square-o"></i> <span>Surveilans HAIs</span> <i
                                            class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aPPI"><i class="fa fa-list"></i>
                                                <span>Surveilans Harian</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aPPI/LaporanKuman"><i class="fa fa-signal"></i>
                                                <span>Kuman</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">EMR</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-pencil-square-o"></i> <span>RAWAT JALAN</span>
                                        <i class="fa fa-angle-right arrow"></i></a>
                                    <!-- <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/RegistrasiRajalList"><i
                                                    class="fa fa-list"></i>
                                                <span>Pasien Rawat Jalan List</span></a></li>
                                    </ul> -->
                                    <!-- <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/AssesmentRawatJalan"><i
                                                    class="fa fa-list"></i>
                                                <span>Assesment Rawat Jalan</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/AssesmentOperasi"><i
                                                    class="fa fa-list"></i>
                                                <span>Assesment Operasi</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/AssesmentMata"><i
                                                    class="fa fa-list"></i>
                                                <span>Assesment Mata</span></a></li>
                                    </ul> -->
                                    <!-- <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/ResumeMedis"><i class="fa fa-list"></i>
                                                <span>Resume Medis</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/SuratKeteranganSakit"><i
                                                    class="fa fa-list"></i>
                                                <span>Surat Keterangan Sakit</span></a></li>
                                    </ul>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aEMR/FormEdukasi"><i class="fa fa-list"></i>
                                                <span>Form Edukasi</span></a></li>
                                    </ul> -->
                                </li>
                                <!-- <li class="has-children">
                  <a href="#"><i class="fa fa-map-signs"></i> <span>Informasi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/InfoAbsensi"><i class="fa fa-newspaper-o "></i> <span>Absensi Pegawai</span></a></li>
                  </ul>
                </li> -->
                            </ul>
                            <!-- /.side-nav -->
                        </div>
                        <!-- /.sidebar-nav -->
                    </div>
                    <!-- /.sidebar-content -->
                </div>
                <!-- /.left-sidebar -->