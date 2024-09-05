<?php
class aInfoHutang_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataInformasiHutang($data)
    {
        // var_dump($data);
        // exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenisinfo = $_POST['jenisinfo'];

            if ($jenisinfo == "1") {
                $this->db->query("SELECT A.KD_HUTANG,b.Company,a.NAMA_BANK_SUPPLIER,a.NO_REKENING_SUPPLIER,
            a.KET,a.NO_FAKTUR,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') AS TGL_HUTANG,
            replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') AS TGL_TEMPO,
            a.NILAI_HUTANG,a.SISA_HUTANG,a.KET3,c.Keterangan
            FROM Keuangan.dbo.HUTANG_REKANAN A
            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B
            ON A.KD_REKANAN = B.ID
            left join [Apotik_V1.1SQL].dbo.FakturManuals c on a.KET2=c.TransactionCode
            where FS_TGL_VOID='1900-01-01 00:00:00.000' AND 
            replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir
      ");
            } else {
                $this->db->query("SELECT A.KD_HUTANG,b.Company,a.NAMA_BANK_SUPPLIER,a.NO_REKENING_SUPPLIER,
                a.KET,a.NO_FAKTUR,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') AS TGL_HUTANG,
                replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') AS TGL_TEMPO,
                a.NILAI_HUTANG,a.SISA_HUTANG,a.KET3,c.Keterangan
                FROM Keuangan.dbo.HUTANG_REKANAN A
                INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B
                ON A.KD_REKANAN = B.ID
                left join [Apotik_V1.1SQL].dbo.FakturManuals c on a.KET2=c.TransactionCode
                where FS_TGL_VOID='1900-01-01 00:00:00.000' AND 
                replace(CONVERT(VARCHAR(11), a.TGL_HUTANG, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir
       ");
            }

            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                $pasing['KD_HUTANG'] = $row['KD_HUTANG'];
                $pasing['Company'] = $row['Company'];
                $pasing['NAMA_BANK_SUPPLIER'] = $row['NAMA_BANK_SUPPLIER'];
                $pasing['NO_REKENING_SUPPLIER'] = $row['NO_REKENING_SUPPLIER'];
                $pasing['TGL_HUTANG'] = date('d/m/Y', strtotime($row['TGL_HUTANG']));
                $pasing['TGL_TEMPO'] = date('d/m/Y', strtotime($row['TGL_TEMPO']));
                $pasing['KET'] = $row['KET'];
                $pasing['NO_FAKTUR'] = $row['NO_FAKTUR'];
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['KET3'] = $row['KET3'];
                $pasing['Keterangan'] = $row['Keterangan'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

