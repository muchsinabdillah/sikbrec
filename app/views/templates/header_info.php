<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIRYARSI v01.01</title>
    <link rel="shortcut icon" href="<?= BASEURL; ?>/images/gutlogo.PNG" />
    <!-- ========== COMMON STYLES ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/lobipanel/lobipanel.min.css" media="screen">

    <!-- ========== PAGE STYLES ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/js/DataTables/datatables.min.css" />

    <!-- ========== THEME CSS ========== -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/main.css" media="screen">

    <!-- ========== MODERNIZR ========== -->
    <script src="<?= BASEURL; ?>/js/modernizr/modernizr.min.js"></script>


</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <nav class="navbar top-navbar bg-white box-shadow">
            <div class="container-fluid">
                <div class="row">
                    <div class="navbar-header no-padding">
                        <a class="navbar-brand" href="<?= BASEURL; ?>">

                            <img src="<?= BASEURL; ?>/images/yarsi.png" alt="PMS System - GUT" class="logo" height="60px" width="80px">
                        </a>
                        <span class="small-nav-handle hidden-sm hidden-xs"><i class="fa fa-outdent"></i></span>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
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
                            <li class="hidden-sm hidden-xs"><a href="#" class="user-info-handle"><i class="fa fa-user"></i></a></li>
                            <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i class="fa fa-arrows-alt"></i></a></li>
                            <li class="hidden-xs hidden-xs">
                                <!-- <a href="#">My Tasks</a> -->
                            </li>
                        </ul>
                        <!-- /.nav navbar-nav -->
                        <ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <!-- /.dropdown -->
                            <li class="dropdown tour-two">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $data->name; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu profile-dropdown">
                                    <li class="profile-menu bg-gray">
                                        <div class="">
                                            <img src="http://placehold.it/60/c2c2c2?text=User" alt="<?= $data->name; ?>" class="img-circle profile-img">
                                            <div class="profile-name">
                                                <h6><?= $data->name; ?></h6>
                                                <a href="pages-profile.html">View Profile</a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </li>
                                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                                    <li><a href="#"><i class="fa fa-sliders"></i> Account Details</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= BASEURL; ?>/LogOut" class="color-danger text-center"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>
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

                <!-- ========== LEFT SIDEBAR ========== -->
                <div class="left-sidebar fixed-sidebar bg-black-300 box-shadow tour-three">
                    <div class="sidebar-content">
                        <div class="user-info closed">
                            <img src="http://placehold.it/90/c2c2c2?text=User" alt="<?= $data->name; ?>" class="img-circle profile-img">
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
                                    <a href="#"><i class="fa fa-lock"></i> <span>ADMINISTRATOR</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active" onclick="getHakAkses(1)"><a href="#"><i class="fa fa-gear"></i> <span>Master Menu</span></a></li>
                                        <li class="active" onclick="getHakAkses(2)"><a href="#"><i class="fa fa-gears"></i> <span>Master Sub Menu</span></a></li>
                                        <li class="active" onclick="getHakAkses(3)"><a href="#"><i class="fa fa-bolt"></i> <span>User Login Aplikasi</span></a></li>
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
                                    <a href="#"><i class="fa fa-building-o"></i> <span>BILLING</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Master Dokter</span></a></li>
                                        <li class="active" onclick="getHakAkses(13)"><a href="#"><i class="fa fa-tasks"></i> <span>Master Jadwal Dokter</span></a></li>
                                        <li class="active" onclick="getHakAkses(14)"><a href="#"><i class="fa fa-map-o"></i> <span>Master Perusahaan</span></a></li>
                                        <li class="active" onclick="getHakAkses(15)"><a href="#"><i class="fa fa-map-o"></i> <span>Master Asuransi</span></a></li>
                                        <li class="active" onclick="getHakAkses(16)"><a href="#"><i class="fa fa-money"></i> <span>Master Refferal</span></a></li>
                                        <li class="active" onclick="getHakAkses(17)"><a href="#"><i class="fa fa-tasks"></i> <span>Master Cuti Dokter</span></a></li>
                                        <li class="active" onclick="getHakAkses(18)"><a href="#"><i class="fa fa-ticket"></i> <span>Master Data Karcis</span></a></li>
                                        <li class="active" onclick="getHakAkses(19)"><a href="#"><i class="fa fa-ticket"></i> <span>Master Unit</span></a></li>
                                        <li class="active" onclick="getHakAkses(20)"><a href="#"><i class="fa fa-spoon"></i> <span>Master Kamar</span></a></li>
                                        <li class="active" onclick="getHakAkses(21)"><a href="#"><i class="fa fa-spoon"></i> <span>Master Bed</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-building-o"></i> <span>TARIF</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active" onclick="getHakAkses(23)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Kamar</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Laboratorium</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Operasi</span></a></li>
                                        <li class="active" onclick="getHakAkses(44)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif MCU</span></a></li>
                                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Paket</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-fax"></i> <span>FINANCE</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li class="active"><a href="<?= BASEURL; ?>/Coa"><i class="fa fa-map"></i> <span>Master C.O.A</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/JobOrder"><i class="fa fa-paper-plane-o"></i> <span>Master Tarif</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/JobOrder"><i class="fa fa-map-pin"></i> <span>Master Paket</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/Pdp"><i class="fa fa-tag"></i> <span>Master PDP</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/PdpDetil"><i class="fa fa-tags"></i> <span>Master PDP Detil</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/Jasa"><i class="fa fa-star"></i> <span>Master Jasa Medis</span></a></li>
                                        <li class="active"><a href="<?= BASEURL; ?>/JasaDetil"><i class="fa fa-star-half"></i> <span>Master Jasa Medis Detil</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">ADMINISTRASI</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RESERVASI PASIEN</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(46)"><a href="#"><i class="fa fa-lock"></i> <span>Rencana Kontrol</span> <span style="margin-left: 10px;" class="label label-danger">RI</a></li>
                                        <li onclick="getHakAkses(47)"><a href="#"><i class="fa fa-lock"></i> <span>Rencana Kontrol</span> <span style="margin-left: 10px;" class="label label-success">Faskes 1</span></a></li>
                                        <li onclick="getHakAkses(48)"><a href="#"><i class="fa fa-lock"></i> <span>Reservasi Pasien Walkin</span></a></li>
                                        <li onclick="getHakAkses(49)"><a href="#"><i class="fa fa-thumb-tack"></i> <span>Reservasi Pasien non Walkin</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>REGISTRASI PASIEN</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="#"><i class="fa fa-lock"></i> <span>Medical Record Pasien</span></a></li>
                                        <li onclick="getHakAkses(50)"><a href="#"><i class="fa fa-unlock"></i> <span>Registrasi Rawat Jalan</span></a></li>
                                        <li onclick="getHakAkses(51)"><a href="#"><i class="fa fa-unlock"></i> <span>Registrasi Pasien Walkin</span></a></li>
                                        <!--  <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Pasien Telemedicine</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Lihat jadwal Dokter</span></a></li>
                     <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Registrasi Rawat Jalan</span></a></li>-->
                                        <li onclick="getHakAkses(52)"><a href="#"><i class="fa fa-unlock"></i> <span>Permintaan Rawat</span></a></li>
                                        <li onclick="getHakAkses(53)"><a href="#"><i class="fa fa-unlock"></i> <span>List Pasien Rawat Inap</span></a></li>
                                        <!--    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Permintaan Biaya</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Permintaan Pindah Ruang Rawat</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Permintaan Mr Bayi</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Permintaan Kontrol Bayi</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Jadwal Drive Thru</span></a></li>-->
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>BILLING PASIEN</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listbebas"><i class="fa fa-lock"></i> <span>Penjualan Bebas</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listrajal"><i class="fa fa-thumb-tack"></i> <span>Rawat Jalan</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listranap"><i class="fa fa-thumb-tack"></i> <span>Rawat Inap</span></a></li>
                                        <li><a href="<?= BASEURL; ?>/aBillingPasien/listwalkin"><i class="fa fa-thumb-tack"></i> <span>Billing Pasien Walkin</span></a></li>
                                        <!--<li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Deposit</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Kamar</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Pengembalian</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Laporan Harian Pasien</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Laporan Kasir</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Print Formulir</span></a></li>-->
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO REKAM MEDIK</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">

                                        <li onclick="getHakAkses(54)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi LMA</span></a></li>
                                        <li onclick="getHakAkses(55)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Rekam Medik</span></a></li>
                                        <li onclick="getHakAkses(56)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Resume Medis</span></a></li>
                                        <li onclick="getHakAkses(57)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Rekap Pasien</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO REGISTRASI</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(58)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi CPPT</span></a></li>
                                        <li onclick="getHakAkses(59)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Komplain</span></a></li>
                                        <li onclick="getHakAkses(60)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Pasien Ranap</span></a></li>
                                        <li onclick="getHakAkses(61)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Registrasi</span></a></li>
                                        <li onclick="getHakAkses(62)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Rekap MCU</span></a></li>
                                        <li onclick="getHakAkses(63)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Suket Covid-19</span></a></li>
                                        <li onclick="getHakAkses(64)"><a href="#"><i class="fa fa-bank"></i> <span>Pasien Rujuk Balik (PRB)</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO BPJS</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">

                                        <li onclick="getHakAkses(45)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Pasien BPJS</span></a></li>
                                        <li onclick="getHakAkses(65)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Grafik BPJS</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">DIGITAL SIGN</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>DIGITAL SIGN</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(35)"><a href="#"><i class="fa fa-lock"></i> <span>Input Digital sign</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-header">
                                    <span class="">BRIDGING BPJS</span>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>ANTRIAN ONLINE</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(39)"><a href="#"><i class="fa fa-lock"></i> <span>Caller Dokter</span></a></li>
                                        <!--  <li onclick="getHakAkses(40)"><a href="#"><i class="fa fa-lock"></i> <span>Caller Farmasi</span></a></li>-->
                                        <li onclick="getHakAkses(41)"><a href="#"><i class="fa fa-lock"></i> <span>List Waktu Task</span></a></li>
                                        <li onclick="getHakAkses(42)"><a href="#"><i class="fa fa-lock"></i> <span>Dashboard Per Tanggal</span></a></li>
                                        <li onclick="getHakAkses(43)"><a href="#"><i class="fa fa-lock"></i> <span>Dashboard Per Bulan</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>MONITORING</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(24)"><a href="#"><i class="fa fa-lock"></i> <span>Kunjungan</span><span style="margin-left: 10px;" class="label label-success">SEP Induk</span></a></li>
                                        <li onclick="getHakAkses(37)"><a href="#"><i class="fa fa-lock"></i> <span>Kunjungan</span><span style="margin-left: 10px;" class="label label-danger">SEP Internal</span></a></li>
                                        <li onclick="getHakAkses(25)"><a href="#"><i class="fa fa-thumb-tack"></i> <span>Data Klaim</span></a></li>
                                        <li onclick="getHakAkses(26)"><a href="#"><i class="fa fa-unlock"></i> <span>History Pelayanan Peserta</span></a></li>
                                        <li><a href="#"><i class="fa fa-unlock"></i> <span>Klaim Jasa Raharja</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>PRB</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li><a href="#"><i class="fa fa-lock"></i> <span>Data PRB</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>APPROVAL SEP</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(27)"><a href="#"><i class="fa fa-lock"></i> <span>Pengajuan Approval SEP</span></a></li>
                                        <li onclick="getHakAkses(28)"><a href="#"><i class="fa fa-lock"></i> <span>Approval SEP</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RENCANA KONTROL</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(29)"><a href="#"><i class="fa fa-lock"></i> <span>Rencana Kontrol <span style="margin-left: 10px;" class="label label-danger">RI</span></a></span></a></li>
                                        <li onclick="getHakAkses(36)"><a href="#"><i class="fa fa-lock"></i> <span>Rencana Kontrol <span style="margin-left: 10px;" class="label label-success">Faskes 1</span></a></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>L. PENGAJUAN KLAIM</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(33)"><a href="#"><i class="fa fa-lock"></i> <span>Entry LPK</span></a></li>
                                        <li onclick="getHakAkses(34)"><a href="#"><i class="fa fa-lock"></i> <span>Edit LPK</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RUJUKAN</span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(30)"><a href="#"><i class="fa fa-lock"></i> <span>Entry Rujukan</span></a></li>
                                        <li onclick="getHakAkses(31)"><a href="#"><i class="fa fa-thumb-tack"></i> <span>Edit Rujukan</span></a></li>
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="#"><i class="fa fa-file-text"></i> <span>RUJUKAN <span style="margin-left: 10px;" class="label label-success">Khusus</span></span> <i class="fa fa-angle-right arrow"></i></a>
                                    <ul class="child-nav">
                                        <li onclick="getHakAkses(32)"><a href="#"><i class="fa fa-lock"></i> <span>Entry Rujukan</span></a></li>
                                        <!--   <li><a href="<?= BASEURL; ?>/Rujukan/updateRujukan"><i class="fa fa-thumb-tack"></i> <span>List Rujukan</span></a></li> -->
                                    </ul>
                                </li>
                                <!--  <li class="nav-header">
                  <span class="">INVENTORY</span>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Purchase Order</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/aPurchaseOrder"><i class="fa fa-bar-chart"></i> <span>Purchase Order</span></a></li>
                    <li><a href="<?= BASEURL; ?>/LogBook"><i class="fa fa-bar-chart"></i> <span>Delivery Order</span></a></li>
                    <li><a href="<?= BASEURL; ?>/DailyReport"><i class="fa fa-bar-chart"></i> <span>Delivery Order Non PO</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Mutasi Barang</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/UploadPlan"><i class="fa fa-bar-chart"></i> <span>Order Mutasi</span></a></li>
                    <li><a href="<?= BASEURL; ?>/LogBook"><i class="fa fa-bar-chart"></i> <span>Mutasi Barang</span></a></li>
                    <li><a href="<?= BASEURL; ?>/DailyReport"><i class="fa fa-bar-chart"></i> <span>Pemakaian BHP</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Penjualan</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/UploadPlan"><i class="fa fa-bar-chart"></i> <span>Penjualan Bebas</span></a></li>
                    <li><a href="<?= BASEURL; ?>/LogBook"><i class="fa fa-bar-chart"></i> <span>Penjualan Rajal</span></a></li>
                    <li><a href="<?= BASEURL; ?>/DailyReport"><i class="fa fa-bar-chart"></i> <span>Penjualan Ranap</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Informasi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/InfoLogBook"><i class="fa fa-bar-chart"></i> <span>LogBook</span></a></li>
                    <li><a href="<?= BASEURL; ?>/InfoDailyReport"><i class="fa fa-bar-chart"></i> <span>Daily Report</span></a></li>
                    <li><a href="<?= BASEURL; ?>/InfoProgressing"><i class="fa fa-bar-chart"></i> <span>Progressing</span></a></li>
                  </ul>
                </li>
                <li class="nav-header">
                  <span class="">FINANCE</span>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Project</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/UploadPlan"><i class="fa fa-bar-chart"></i> <span>Upload Kontrak & Plan</span></a></li>
                    <li><a href="<?= BASEURL; ?>/LogBook"><i class="fa fa-bar-chart"></i> <span>Log Book</span></a></li>
                    <li><a href="<?= BASEURL; ?>/DailyReport"><i class="fa fa-bar-chart"></i> <span>Daily Report</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-bars"></i> <span>Informasi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/InfoLogBook"><i class="fa fa-bar-chart"></i> <span>LogBook</span></a></li>
                    <li><a href="<?= BASEURL; ?>/InfoDailyReport"><i class="fa fa-bar-chart"></i> <span>Daily Report</span></a></li>
                    <li><a href="<?= BASEURL; ?>/InfoProgressing"><i class="fa fa-bar-chart"></i> <span>Progressing</span></a></li>
                  </ul>
                </li>
                <li class="nav-header">
                  <span class="">HRD</span>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-file-text"></i> <span>Absensi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/JadwalAbsensi"><i class="fa fa-lock"></i> <span>Jadwal Pegawai</span></a></li>
                    <li><a href="<?= BASEURL; ?>/Lembur"><i class="fa fa-thumb-tack"></i> <span>Lembur Pegawai</span></a></li>
                    <li><a href="<?= BASEURL; ?>/aRegistrasiRajal"><i class="fa fa-unlock"></i> <span>Surat S/I/C</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-file-text"></i> <span>Log Absensi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/AbsensiManual"><i class="fa fa-lock"></i> <span>Absensi Manual</span></a></li>
                    <li><a href="<?= BASEURL; ?>/GenerateAbsensi"><i class="fa fa-thumb-tack"></i> <span>Generate Absensi</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-paint-brush"></i> <span>Penggajian</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/ProsesPayroll"><i class="fa fa-bank"></i> <span>Proses Penggajian</span></a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="#"><i class="fa fa-map-signs"></i> <span>Informasi</span> <i class="fa fa-angle-right arrow"></i></a>
                  <ul class="child-nav">
                    <li><a href="<?= BASEURL; ?>/InfoAbsensi"><i class="fa fa-newspaper-o "></i> <span>Absensi Pegawai</span></a></li>
                    <li><a href="<?= BASEURL; ?>/InfoPayroll"><i class="fa fa-leaf "></i> <span>Penggajian Pegawai</span></a></li>
                  </ul>
                </li>========== -->
                            </ul>
                            <!-- /.side-nav -->
                        </div>
                        <!-- /.sidebar-nav -->
                    </div>
                    <!-- /.sidebar-content -->
                </div>
                <!-- /.left-sidebar -->