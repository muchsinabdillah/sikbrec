<?php
class MasterDataPerusahaan_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataPerusahaan()
    {
        try {
            $this->db->query("SELECT ID,NamaPerusahaan,Alamat,
                            case when StatusAktif='1' then 'AKTIF' else 'TIDAK AKTIF' end AS StatusAktif,Benefit 
                            from MasterdataSQL.dbo.MstrPerusahaanJPK");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['Alamat'] = $key['Alamat'];
                $pasing['StatusAktif'] = $key['StatusAktif'];
                $pasing['Benefit'] = $key['Benefit'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['NamaPerusahaan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Perusahaan !',
                );
                return $callback;
                exit;
            }
            if ($data['StatusPerusahaan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status Aktif !',
                );
                return $callback;
                exit;
            }
            if ($data['GruptarifPerusahaan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Grup Tarif Perusahaan !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekening'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Rekening Perusahaan !',
                );
                return $callback;
                exit;
            }
            if ($data['GenBP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Gen BP !',
                );
                return $callback;
                exit;
            }
            if ($data['IDFormularium'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input ID Formularium !',
                );
                return $callback;
                exit;
            }
            $nama = strlen($data['NamaPerusahaan']);
            if ($nama > 50) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Simpan Gagal! Nama Payer Harus Kurang Dari 50 Karakter !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $CPPerusahaan = $data['CPPerusahaan'];
            $TelpCPPerusahaan = $data['TelpCPPerusahaan'];
            $MasaBerlakuAwal = $data['MasaBerlakuAwal'];
            $MasaBerlakuAkhir = $data['MasaBerlakuAkhir'];
            $FaxPerusahaan = $data['FaxPerusahaan'];
            $NamaPerusahaan = $data['NamaPerusahaan'];
            $AlamatPerusahaan = $data['AlamatPerusahaan'];
            $KotaPerusahaan = $data['KotaPerusahaan'];
            $TelponPerusahaan = $data['TelponPerusahaan'];
            $GenBP = $data['GenBP'];
            $special_benefit_platinum = $data['special_benefit_platinum'];
            $special_benefit_diamond = $data['special_benefit_diamond'];
            $GruptarifPerusahaan = $data['GruptarifPerusahaan'];
            $AlamatPenagihan = $data['AlamatPenagihan'];
            $KodeRekening = $data['KodeRekening'];
            $ri_disc_sewaalat = $data['ri_disc_sewaalat'];
            $ri_disc_kamarperawatan = $data['ri_disc_kamarperawatan'];
            $ri_disc_tindakanoperasi = $data['ri_disc_tindakanoperasi'];
            $special_benefit_silver = $data['special_benefit_silver'];
            $special_benefit_gold = $data['special_benefit_gold'];
            $ri_disc_administrasi = $data['ri_disc_administrasi'];
            $ri_disc_lab = $data['ri_disc_lab'];
            $ri_disc_radiologi = $data['ri_disc_radiologi'];
            $ri_disc_resep = $data['ri_disc_resep'];
            $ri_disc_jasadokter = $data['ri_disc_jasadokter'];
            $rj_disc_administrasi = $data['rj_disc_administrasi'];
            $rj_disc_resep = $data['rj_disc_resep'];
            $rj_disc_jasadokter = $data['rj_disc_jasadokter'];
            $rj_disc_sewaalat = $data['rj_disc_sewaalat'];
            $ri_disc_global = $data['ri_disc_global'];
            $BenefitPerusahaan = $data['BenefitPerusahaan'];
            $StatusPerusahaan = $data['StatusPerusahaan'];
            $rj_disc_global = $data['rj_disc_global'];
            $rj_disc_radiologi = $data['rj_disc_radiologi'];
            $rj_disc_lab = $data['rj_disc_lab'];
            $IDFormularium = $data['IDFormularium'];

            if ($data['IdAuto'] == "") {

                $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrPerusahaanJPK 
                                (NamaPerusahaan,Alamat,Kota,Telephone,Fax,ContacPerson,TlpConcatP,
                                Benefit,StatusAktif,RJ_Disc_Global,RJ_Disc_Administrasi,RJ_Disc_Laboratorium,
                                RJ_Disc_Radiologi,RJ_Disc_Resep,RJ_Disc_JasaDokter,
                                RJ_Disc_Sewaalat,RI_Disc_Global,RI_Disc_Administrasi,RI_Disc_Laboratorium,RI_Disc_Radiologi,
                                RI_Disc_Resep,RI_Disc_JasaDokter,RI_Disc_Sewaalat,
                                RI_Disc_KamarPerawatan,RI_Disc_Operasi,Special_benefit_Silver,Special_benefit_Gold,
                                Special_benefit_Platinum,Special_benefit_Diamond,masaberlaku_awal,masaberlaku_akhir,
                                Group_Jaminan,Alamat_Penagihan,Rekening,Gen_BP,IDFormularium) 
                                VALUES
                                (:NamaPerusahaan,:AlamatPerusahaan,:KotaPerusahaan,:TelponPerusahaan,
                                :FaxPerusahaan,:CPPerusahaan,:TelpCPPerusahaan,:BenefitPerusahaan,:StatusPerusahaan,
                                :rj_disc_global,:rj_disc_administrasi,:rj_disc_lab,:rj_disc_radiologi,:rj_disc_resep,
                                :rj_disc_jasadokter,:rj_disc_sewaalat,:ri_disc_global,:ri_disc_administrasi,:ri_disc_lab,
                                :ri_disc_radiologi,:ri_disc_resep,:ri_disc_jasadokter,:ri_disc_sewaalat,:ri_disc_kamarperawatan,
                                :ri_disc_tindakanoperasi,:special_benefit_silver,:special_benefit_gold,:special_benefit_platinum,
                                :special_benefit_diamond,:MasaBerlakuAwal,:MasaBerlakuAkhir,:GruptarifPerusahaan,:AlamatPenagihan,
                                :KodeRekening,:GenBP,:IDFormularium)");
                $this->db->bind('NamaPerusahaan', $NamaPerusahaan);
                $this->db->bind('AlamatPerusahaan', $AlamatPerusahaan);
                $this->db->bind('KotaPerusahaan', $KotaPerusahaan);
                $this->db->bind('TelponPerusahaan', $TelponPerusahaan);
                $this->db->bind('FaxPerusahaan', $FaxPerusahaan);
                $this->db->bind('CPPerusahaan', $CPPerusahaan);
                $this->db->bind('TelpCPPerusahaan', $TelpCPPerusahaan);
                $this->db->bind('BenefitPerusahaan', $BenefitPerusahaan);
                $this->db->bind('StatusPerusahaan', $StatusPerusahaan);
                $this->db->bind('rj_disc_global', $rj_disc_global);
                $this->db->bind('rj_disc_administrasi', $rj_disc_administrasi);
                $this->db->bind('rj_disc_lab', $rj_disc_lab);
                $this->db->bind('rj_disc_radiologi', $rj_disc_radiologi);
                $this->db->bind('rj_disc_resep', $rj_disc_resep);
                $this->db->bind('rj_disc_jasadokter', $rj_disc_jasadokter);
                $this->db->bind('rj_disc_sewaalat', $rj_disc_sewaalat);
                $this->db->bind('ri_disc_global', $ri_disc_global);
                $this->db->bind('ri_disc_administrasi', $ri_disc_administrasi);
                $this->db->bind('ri_disc_lab', $ri_disc_lab);
                $this->db->bind('ri_disc_radiologi', $ri_disc_radiologi);
                $this->db->bind('ri_disc_resep', $ri_disc_resep);
                $this->db->bind('ri_disc_jasadokter', $ri_disc_jasadokter);
                $this->db->bind('ri_disc_sewaalat', $ri_disc_sewaalat);
                $this->db->bind('ri_disc_kamarperawatan', $ri_disc_kamarperawatan);
                $this->db->bind('ri_disc_tindakanoperasi', $ri_disc_tindakanoperasi);
                $this->db->bind('special_benefit_silver', $special_benefit_silver);
                $this->db->bind('special_benefit_gold', $special_benefit_gold);
                $this->db->bind('special_benefit_platinum', $special_benefit_platinum);
                $this->db->bind('special_benefit_diamond', $special_benefit_diamond);
                $this->db->bind('MasaBerlakuAwal', $MasaBerlakuAwal);
                $this->db->bind('MasaBerlakuAkhir', $MasaBerlakuAkhir);
                $this->db->bind('GruptarifPerusahaan', $GruptarifPerusahaan);
                $this->db->bind('AlamatPenagihan', $AlamatPenagihan);
                $this->db->bind('KodeRekening', $KodeRekening);
                $this->db->bind('GenBP', $GenBP);
                $this->db->bind('IDFormularium', $IDFormularium);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrPerusahaanJPK set  
                            NamaPerusahaan=:NamaPerusahaan,Alamat=:AlamatPerusahaan,Kota=:KotaPerusahaan,Telephone=:TelponPerusahaan,Fax=:FaxPerusahaan,ContacPerson=:CPPerusahaan,TlpConcatP=:TelpCPPerusahaan,
          Benefit=:BenefitPerusahaan,StatusAktif=:StatusPerusahaan,RJ_Disc_Global=:rj_disc_global,RJ_Disc_Administrasi=:rj_disc_administrasi,RJ_Disc_Laboratorium=:rj_disc_lab,RJ_Disc_Radiologi=:rj_disc_radiologi,RJ_Disc_Resep=:rj_disc_resep,RJ_Disc_JasaDokter=:rj_disc_jasadokter,
        RJ_Disc_Sewaalat=:rj_disc_sewaalat,RI_Disc_Global=:ri_disc_global,RI_Disc_Administrasi=:ri_disc_administrasi,RI_Disc_Laboratorium=:ri_disc_lab,RI_Disc_Radiologi=:ri_disc_radiologi,RI_Disc_Resep=:ri_disc_resep,RI_Disc_JasaDokter=:ri_disc_jasadokter,RI_Disc_Sewaalat=:ri_disc_sewaalat,
      RI_Disc_KamarPerawatan=:ri_disc_kamarperawatan,RI_Disc_Operasi=:ri_disc_tindakanoperasi,Special_benefit_Silver=:special_benefit_silver,Special_benefit_Gold=:special_benefit_gold,Special_benefit_Platinum=:special_benefit_platinum,Special_benefit_Diamond=:special_benefit_diamond,masaberlaku_awal=:MasaBerlakuAwal,masaberlaku_akhir=:MasaBerlakuAkhir,Group_Jaminan=:GruptarifPerusahaan,Alamat_Penagihan=:AlamatPenagihan,Rekening=:KodeRekening,Gen_BP=:GenBP,IDFormularium=:IDFormularium
                            WHERE ID=:IdAuto");
                $this->db->bind('NamaPerusahaan', $NamaPerusahaan);
                $this->db->bind('AlamatPerusahaan', $AlamatPerusahaan);
                $this->db->bind('KotaPerusahaan', $KotaPerusahaan);
                $this->db->bind('TelponPerusahaan', $TelponPerusahaan);
                $this->db->bind('FaxPerusahaan', $FaxPerusahaan);
                $this->db->bind('CPPerusahaan', $CPPerusahaan);
                $this->db->bind('TelpCPPerusahaan', $TelpCPPerusahaan);
                $this->db->bind('BenefitPerusahaan', $BenefitPerusahaan);
                $this->db->bind('StatusPerusahaan', $StatusPerusahaan);
                $this->db->bind('rj_disc_global', $rj_disc_global);
                $this->db->bind('rj_disc_administrasi', $rj_disc_administrasi);
                $this->db->bind('rj_disc_lab', $rj_disc_lab);
                $this->db->bind('rj_disc_radiologi', $rj_disc_radiologi);
                $this->db->bind('rj_disc_resep', $rj_disc_resep);
                $this->db->bind('rj_disc_jasadokter', $rj_disc_jasadokter);
                $this->db->bind('rj_disc_sewaalat', $rj_disc_sewaalat);
                $this->db->bind('ri_disc_global', $ri_disc_global);
                $this->db->bind('ri_disc_administrasi', $ri_disc_administrasi);
                $this->db->bind('ri_disc_lab', $ri_disc_lab);
                $this->db->bind('ri_disc_radiologi', $ri_disc_radiologi);
                $this->db->bind('ri_disc_resep', $ri_disc_resep);
                $this->db->bind('ri_disc_jasadokter', $ri_disc_jasadokter);
                $this->db->bind('ri_disc_sewaalat', $ri_disc_sewaalat);
                $this->db->bind('ri_disc_kamarperawatan', $ri_disc_kamarperawatan);
                $this->db->bind('ri_disc_tindakanoperasi', $ri_disc_tindakanoperasi);
                $this->db->bind('special_benefit_silver', $special_benefit_silver);
                $this->db->bind('special_benefit_gold', $special_benefit_gold);
                $this->db->bind('special_benefit_platinum', $special_benefit_platinum);
                $this->db->bind('special_benefit_diamond', $special_benefit_diamond);
                $this->db->bind('MasaBerlakuAwal', $MasaBerlakuAwal);
                $this->db->bind('MasaBerlakuAkhir', $MasaBerlakuAkhir);
                $this->db->bind('GruptarifPerusahaan', $GruptarifPerusahaan);
                $this->db->bind('AlamatPenagihan', $AlamatPenagihan);
                $this->db->bind('KodeRekening', $KodeRekening);
                $this->db->bind('GenBP', $GenBP);
                $this->db->bind('IDFormularium', $IDFormularium);
                $this->db->bind('IdAuto', $IdAuto);
            }
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getPerusahaanId($id)
    {
        try{
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), masaberlaku_awal, 111), '/','-') as awal,
                        replace(CONVERT(VARCHAR(11), masaberlaku_akhir, 111), '/','-') as akhir
                        from MasterdataSQL.dbo.MstrPerusahaanJPK
                        WHERE ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NamaPerusahaan'] = $data['NamaPerusahaan'];
            $pasing['Alamat'] = $data['Alamat'];
            $pasing['Kota'] = $data['Kota'];
            $pasing['Telephone'] = $data['Telephone'];
            $pasing['Fax'] = $data['Fax'];
            $pasing['ContacPerson'] = $data['ContacPerson'];
            $pasing['TlpConcatP'] = $data['TlpConcatP'];
            $pasing['awal'] = $data['awal'];
            $pasing['akhir'] = $data['akhir'];
            $pasing['Benefit'] = $data['Benefit'];
            $pasing['StatusAktif'] = $data['StatusAktif'];
            $pasing['RJ_Disc_Global'] = $data['RJ_Disc_Global'];
            $pasing['RJ_Disc_Administrasi'] = $data['RJ_Disc_Administrasi'];
            $pasing['RJ_Disc_Laboratorium'] = $data['RJ_Disc_Laboratorium'];
            $pasing['RJ_Disc_Radiologi'] = $data['RJ_Disc_Radiologi'];
            $pasing['RJ_Disc_Resep'] = $data['RJ_Disc_Resep'];
            $pasing['RJ_Disc_JasaDokter'] = $data['RJ_Disc_JasaDokter'];
            $pasing['RJ_Disc_Sewaalat'] = $data['RJ_Disc_Sewaalat'];
            $pasing['RI_Disc_Global'] = $data['RI_Disc_Global'];
            $pasing['RI_Disc_Administrasi'] = $data['RI_Disc_Administrasi'];
            $pasing['RI_Disc_Laboratorium'] = $data['RI_Disc_Laboratorium'];
            $pasing['RI_Disc_Radiologi'] = $data['RI_Disc_Radiologi'];
            $pasing['RI_Disc_Resep'] = $data['RI_Disc_Resep'];
            $pasing['RI_Disc_JasaDokter'] = $data['RI_Disc_JasaDokter'];
            $pasing['RI_Disc_Sewaalat'] = $data['RI_Disc_Sewaalat'];
            $pasing['RI_Disc_KamarPerawatan'] = $data['RI_Disc_KamarPerawatan'];
            $pasing['RI_Disc_Operasi'] = $data['RI_Disc_Operasi'];
            $pasing['Special_benefit_Silver'] = $data['Special_benefit_Silver'];
            $pasing['Special_benefit_Gold'] = $data['Special_benefit_Gold'];
            $pasing['Special_benefit_Platinum'] = $data['Special_benefit_Platinum'];
            $pasing['Special_benefit_Diamond'] = $data['Special_benefit_Diamond'];
            $pasing['Group_Jaminan'] = $data['Group_Jaminan'];
            $pasing['Alamat_Penagihan'] = $data['Alamat_Penagihan'];
            $pasing['Rekening'] = $data['Rekening'];
            $pasing['Gen_BP'] = $data['Gen_BP'];
            $pasing['IDFormularium'] = $data['IDFormularium'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback; 
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
        
    }
}
