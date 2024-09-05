<div class="left-sidebar fixed-sidebar bg-black-300 box-shadow tour-three">
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
                    <a href="#"><i class="fa fa-lock"></i> <span>ADMINISTRATOR</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li class="active" onclick="getHakAkses(1)"><a href="#"><i class="fa fa-gear"></i> <span>Master Menu</span></a></li>
                        <li class="active" onclick="getHakAkses(2)"><a href="#"><i class="fa fa-gears"></i> <span>Master Sub Menu</span></a></li>
                        <li class="active" onclick="getHakAkses(3)"><a href="#"><i class="fa fa-bolt"></i> <span>User Login Aplikasi</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/Eticket"><i class="fa fa-bolt"></i> <span>List E-Ticket</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/ParameterRekening"><i class="fa fa-bolt"></i> <span>Parameter Rekening</span></a></li>
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
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listtransaksitarif"><i class="fa fa-puzzle-piece"></i> <span>Transaksi Tarif</span></a></li>
                        <li class="active" onclick="getHakAkses(23)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Kamar</span></a></li>
                        <!--
                    <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a></li>
                    -->
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listrajal"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Jalan</span></a></li>
                        <li class="active" onclick="getHakAkses(12)"><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listtindakanlab"><i class="fa fa-puzzle-piece"></i> <span>Master Tindakan Laboratorium</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listlab"><i class="fa fa-puzzle-piece"></i> <span>Tarif Laboratorium</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listranap"><i class="fa fa-puzzle-piece"></i> <span>Tarif Rawat Inap</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataTarif/listradiologi"><i class="fa fa-puzzle-piece"></i> <span>Tarif Radiologi</span></a></li>
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
                        <li class="active"><a href="<?= BASEURL; ?>/OrderBonSementara/listOrderBon"><i class="fa fa-puzzle-piece"></i> <span>Order Bon Sementara</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataBeban/listMasterBeban"><i class="fa fa-puzzle-piece"></i> <span>Master Beban</span></a></li>
                    </ul>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-fax"></i> <span>INVENTORY</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li class="active"><a href="<?= BASEURL; ?>/MasterSatuan/list"><i class="fa fa-map"></i> <span>Master Satuan</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/GroupBarang/list"><i class="fa fa-paper-plane-o"></i> <span>Master Group Barang</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterGolongan/list"><i class="fa fa-map-pin"></i> <span>Master Golongan Barang</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataJenisBarang/list"><i class="fa fa-star"></i> <span>Master Jenis Barang</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterKelompokBarang/list"><i class="fa fa-star-half"></i> <span>Master Kelompok Barang</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataPabrik/list"><i class="fa fa-tag"></i> <span>Master Pabrik</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterSupplier/list"><i class="fa fa-tags"></i> <span>Master Supplier</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterDataBarang/list"><i class="fa fa-puzzle-piece"></i> <span>Master Barang</span></a></li>
                        <li class="active"><a href="<?= BASEURL; ?>/MasterMarginObat/"><i class="fa fa-puzzle-piece"></i> <span>Master Margin Barang</span></a></li>
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
                        <li><a href="<?= BASEURL; ?>/aMedicalRecord"><i class="fa fa-lock"></i> <span>Medical Record Pasien</span></a></li>
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
                    </ul>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-paint-brush"></i> <span>INFO REGISTRASI</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li onclick="getHakAkses(58)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi CPPT</span></a></li>
                        <li onclick="getHakAkses(59)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Komplain</span></a></li>
                        <li onclick="getHakAkses(60)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Pasien Ranap</span></a></li>
                        <li onclick="getHakAkses(61)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Registrasi</span></a></li>
                        <li><a href="<?= BASEURL; ?>/form"><i class="fa fa-bank"></i> <span>Form</span></a></li>
                        <li><a href="<?= BASEURL; ?>/fPelaksanaanEdukasi"><i class="fa fa-bank"></i> <span>Pelaksanaan Edukasi</span></a></li>
                        <li><a href="<?= BASEURL; ?>/fHandoverPerawat"><i class="fa fa-bank"></i> <span>Formulir Hand Over <br>Perawat Antar Shift Jaga</span></a></li>

                        <li onclick="getHakAkses(62)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Rekap MCU</span></a></li>
                        <li onclick="getHakAkses(63)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Suket Covid-19</span></a></li>
                        <li><a href="<?= BASEURL; ?>/bInformasiWaktuTunggu"><i class="fa fa-bank"></i> <span>Informasi Waktu Tunggu Poliklinik</span></a></li>
                        <li><a href="<?= BASEURL; ?>/bInformasiWaktuTunggu/WaktuVisiteDJPJ"><i class="fa fa-bank"></i> <span>Informasi Waktu Visite DPJP</span></a></li>
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
                <li class="has-children">
                    <a href="#"><i class="fa fa-paint-brush"></i> <span>PENUNJANG</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="<?= BASEURL; ?>/bInformationHasilLab"><i class="fa fa-file-text"></i><span>Info Hasil Laboratorium</span></a></li>
                    </ul>
                </li>
                <li class="nav-header">
                    <span class="">MANAGEMENT</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>REKAP PASIEN</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="<?= BASEURL; ?>/bInformationRekapRegistrasi"><i class="fa fa-bank"></i> <span>Monthly Report</span></a></li>
                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i class="fa fa-lock"></i> <span>Daily Report</span></a></li>
                        <li onclick="getHakAkses(57)"><a href="#"><i class="fa fa-bank"></i> <span>Rekap Dashboard Pasien</span></a></li>
                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i class="fa fa-lock"></i> <span>Grafik Monthly Report</span></a></li>
                        <li><a href="<?= BASEURL; ?>/bInformationDetilRegistrasi"><i class="fa fa-lock"></i> <span>Grafik Daily Report</span></a></li>
                        <li onclick="getHakAkses(54)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi LMA</span></a></li>
                        <li onclick="getHakAkses(55)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Rekam Medik</span></a></li>
                        <li onclick="getHakAkses(56)"><a href="#"><i class="fa fa-bank"></i> <span>Informasi Resume Medis</span></a></li>
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
                        <!--
                      <li onclick="getHakAkses(42)"><a href="#"><i class="fa fa-lock"></i> <span>Dashboard Per Tanggal</span></a></li>
                    -->
                        <li><a href="<?= BASEURL; ?>/DashboardAntrianBPJS/dashboardpertgl"><i class="fa fa-lock"></i> <span>Dashboard Per Tanggal</span></a></li>
                        <!--
                    <li onclick="getHakAkses(43)"><a href="#"><i class="fa fa-lock"></i> <span>Dashboard Per Bulan</span></a></li>
                  -->
                        <li><a href="<?= BASEURL; ?>/DashboardAntrianBPJS/dashboardperbulan"><i class="fa fa-lock"></i> <span>Dashboard Per Bulan</span></a></li>
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
                <li class="nav-header">
                    <span class="">INVENTORY</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-bars"></i> <span>Resep</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="<?= BASEURL; ?>/UDD/list"><i class="fa fa-bar-chart"></i> <span>UDD</span></a></li>
                    </ul>
                    <ul class="child-nav">
                        <li><a href="<?= BASEURL; ?>/Farmasi/RiwayatTransaksi"><i class="fa fa-bar-chart"></i> <span> Riwayat Transaksi Order</span></a></li>
                    </ul>
                </li>

                <li class="nav-header">
                    <span class="">FINANCE</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-bars"></i> <span>KAS PENGELUARAN</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="<?= BASEURL; ?>/OrderBonSementara/listOrderBon"><i class="fa fa-bar-chart"></i> <span>Order Bon Sementara</span></a></li>
                        <li><a href="<?= BASEURL; ?>/PencairanKasbon"><i class="fa fa-bar-chart"></i> <span>Realisasi Bon Sementara</span></a></li>
                        <li><a href="<?= BASEURL; ?>/PencairanKasbon/listpenyelesaian/"><i class="fa fa-bar-chart"></i> <span>Peny. Bon Sementara</span></a></li>
                        <li><a href="<?= BASEURL; ?>/PencairanKasbon"><i class="fa fa-bar-chart"></i> <span>Informasi Bon Sementara</span></a></li>
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
                <!-- <li class="nav-header">
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
                </li>  -->
            </ul>
            <!-- /.side-nav -->
        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
</div>
<!-- /.left-sidebar -->