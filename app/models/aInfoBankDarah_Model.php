<?php
class aInfoBankDarah_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataInfoIndikatorWaktu($data)
    {
        // var_dump($data);
        // exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.ID,a.NoMR,a.NoEpisode,a.NoRegistrasi,a.UserOrderName,a.UnitOrderName,
            case when a.StatusOrder='0' then 'Belum Approve' when a.StatusOrder='1' then 'Approve' else '-' end as ApproveKasir,
            case when a.ReviewQtyOrder='0' then 'Belum Approve' when a.ReviewQtyOrder='1' then 'Approve' else '-' end as ApproveBDRS,
            c.NamaTarifDarah,c.Barcode,c.Expired_Date as TglExpiredPMI,c.End_ExpiredDate as TglExpiredPemakaian,
            replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-')  as TglOrder,a.DateApproveBDRS as TglReviewBDRS,a.DateApproveKasir as TglApproveKasir,b.DateUpdate as TglDarahDisiapkanBDRS,
            b.TglTerima as TglHandOverBDRS_Perawat, b.PetugasMenyerahkan as PetugasBDRS,b.PetugasMenerima as Perawat,
            b.TglHandOverPerawat,b.PerawatHandOverSerah as HandoverPerawat1,b.PerawatHandOverTerima as HandoverPerawat2,
            b.HistoryIncompatibility,b.AutoControl
            from LaboratoriumSQL.dbo.OrderBloods a 
            inner join LaboratoriumSQL.dbo.UseBloods b on a.ID=b.IDOrder
            inner join LaboratoriumSQL.dbo.UseBloodDetails c on b.ID=c.IDHdr
            where a.Batal='0' and b.Batal='0' and c.Batal='0' AND replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-')
            between :TglAwal and :TglAkhir
       ");

            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoEpisode'] = $row['NoEpisode'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['UserOrderName'] = $row['UserOrderName'];
                $pasing['UnitOrderName'] = $row['UnitOrderName'];
                $pasing['ApproveKasir'] = $row['ApproveKasir'];
                $pasing['ApproveBDRS'] = $row['ApproveBDRS'];
                $pasing['NamaTarifDarah'] = $row['NamaTarifDarah'];
                $pasing['Barcode'] = $row['Barcode'];

                $pasing['TglExpiredPMI'] = $row['TglExpiredPMI'];
                $pasing['TglExpiredPemakaian'] = $row['TglExpiredPemakaian'];
                $pasing['TglOrder'] = $row['TglOrder'];
                $pasing['TglReviewBDRS'] = $row['TglReviewBDRS'];
                $pasing['TglApproveKasir'] = $row['TglApproveKasir'];
                $pasing['TglDarahDisiapkanBDRS'] = $row['TglDarahDisiapkanBDRS'];
                $pasing['TglHandOverBDRS_Perawat'] = $row['TglHandOverBDRS_Perawat'];
                $pasing['PetugasBDRS'] = $row['PetugasBDRS'];
                $pasing['Perawat'] = $row['Perawat'];
                $pasing['TglHandOverPerawat'] = $row['TglHandOverPerawat'];

                $pasing['HandoverPerawat1'] = $row['HandoverPerawat1'];
                $pasing['HandoverPerawat2'] = $row['HandoverPerawat2'];
                $pasing['HistoryIncompatibility'] = $row['HistoryIncompatibility'];
                $pasing['AutoControl'] = $row['AutoControl'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataInfoIndikatorQTY($data)
    {

        // var_dump($data);
        // exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.ID,a.NoMR,a.NoEpisode,a.NoRegistrasi,a.UserOrderName,a.UnitOrderName,
            case when a.StatusOrder='0' then 'Belum Approve' when a.StatusOrder='1' then 'Approve' else '-' end as ApproveKasir,
            case when a.ReviewQtyOrder='0' then 'Belum Approve' when a.ReviewQtyOrder='1' then 'Approve' else '-' end as ApproveBDRS,
            replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-') as TglOrder,
            x.QtyOrder_Old,x.QtyOrder,x.QtyPakai,x.QtySisa,x.QtyPakaiPerawat,b.PatientName
            from LaboratoriumSQL.dbo.OrderBloodDetails x
            inner join LaboratoriumSQL.dbo.OrderBloods a on a.ID=x.IDHdr
			inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
            where a.Batal='0' and x.Batal='0' AND replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-')
            between :TglAwal and :TglAkhir
       ");

            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);


            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {

                $pasing['ID'] = $row['ID'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoEpisode'] = $row['NoEpisode'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['UserOrderName'] = $row['UserOrderName'];
                $pasing['UnitOrderName'] = $row['UnitOrderName'];
                $pasing['ApproveKasir'] = $row['ApproveKasir'];
                $pasing['ApproveBDRS'] = $row['ApproveBDRS'];
                $pasing['TglOrder'] = $row['TglOrder'];
                $pasing['QtyOrder_Old'] = $row['QtyOrder_Old'];
                $pasing['QtyOrder'] = $row['QtyOrder'];
                $pasing['QtyPakai'] = $row['QtyPakai'];
                $pasing['QtySisa'] = $row['QtySisa'];
                $pasing['QtyPakaiPerawat'] = $row['QtyPakaiPerawat'];
                $pasing['PatientName'] = $row['PatientName'];




                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
