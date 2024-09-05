<?php
class JadwalAbsensi_Service  
{
    private $MasterDataJadwalDokter_Model;
 
    public function __construct(MasterDataJadwalDokter_Model $MasterDataJadwalDokter_Model)
    {
        $this->MasterDataJadwalDokter_Model = $MasterDataJadwalDokter_Model;
    }
    function addJadwalDokter($data){
        $go = $this->MasterDataJadwalDokter_Model->insert($data);
        return $go;
    }
}
