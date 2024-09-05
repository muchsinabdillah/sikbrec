<?php
class aEMR extends Controller
{
    use hari;
    use Edocuments;

    public function AssesmentRawatJalan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  $id;
        $data['judul'] = 'Assesment Rawat Jalan';
        $data['judul_child'] = 'Asesment Rawat Jalan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/assesmentRajal', $data);
        $this->View('templates/footer');
    }

    public function AssesmentMata($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  $id;
        $data['judul'] = 'Assesment Mata';
        $data['judul_child'] = 'Asesment Mata';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/assesmentMata', $data);
        $this->View('templates/footer');
    }

    public function ResumeMedis($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  $id;
        $data['judul'] = 'Resume Medis';
        $data['judul_child'] = 'Resume Medis';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/resumeMedis', $data);
        $this->View('templates/footer');
    }

    public function SuratKeteranganSakit($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  $id;
        $data['judul'] = 'Surat Keterangan Sakit';
        $data['judul_child'] = 'Surat keterangan Sakit';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/suratKeteranganSakit', $data);
        $this->View('templates/footer');
    }

    public function FormEdukasi($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  $id;
        $data['judul'] = 'FORMULIR PEMBERIAN EDUKASI
        PASIEN TERINTREGRASI';
        $data['judul_child'] = 'FORMULIR PEMBERIAN EDUKASI
        PASIEN TERINTREGRASI';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/formEdukasi', $data);
        $this->View('templates/footer');
    }

    public function getDataPasien()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataPasien($_POST));
    }
    public function listPasienPoliklinikPerawat()
    {
        echo json_encode($this->model('B_EMR_Model')->listPasienPoliklinikPerawat($_POST));
    }

    public function setSaveAssesment()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveAssesment($_POST));
    }

    public function getDataWakilPasien()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataWakilPasien($_POST));
    }

    public function getDataAssesment()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataAssesment($_POST));
    }

    public function setSaveMasalahKeperawatan()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveMasalahKeperawatan($_POST));
    }
    public function setSaveCPPT()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveCPPT($_POST));
    }
    public function getDataMasalahKeperawatan()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataMasalahKeperawatan($_POST));
    }
    public function getDataCPPT()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataCPPT($_POST));
    }
    public function setBatalMasalahKeperawatan()
    {
        echo json_encode($this->model('B_EMR_Model')->setBatalMasalahKeperawatan($_POST));
    }
    public function setBatalCPPT()
    {
        echo json_encode($this->model('B_EMR_Model')->setBatalCPPT($_POST));
    }

    public function setSaveResume()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveResume($_POST));
    }

    public function getResumePasien()
    {
        echo json_encode($this->model('B_EMR_Model')->getResumePasien($_POST));
    }

    public function PrintResumeMedis($NoRegistrasi = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['NoRegistrasi'] = $NoRegistrasi;
            $datanoreg = $data['NoRegistrasi'];
            $data['listdataheader'] = $this->model('B_EMR_Model')->getDataPasien($data);
            $data['listdatadetail'] = $this->model('B_EMR_Model')->getSuratKeteranganSakit($data);
            $this->View('print/emr/suratsakit/print_suratsakit', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function setSaveSuket()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveSuket($_POST));
    }

    public function getSuratKeteranganSakit()
    {
        echo json_encode($this->model('B_EMR_Model')->getSuratKeteranganSakit($_POST));
    }

    public function PrintSuratKeteranganSakit($NoRegistrasi = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['NoRegistrasi'] = $NoRegistrasi;
            $datanoreg = $data['NoRegistrasi'];
            $data['listdataheader'] = $this->model('B_EMR_Model')->getDataPasien($data);
            $data['listdatadetail'] = $this->model('B_EMR_Model')->getSuratKeteranganSakit($data);
            $this->View('print/emr/suratsakit/print_suratsakit', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function setFormEdukasi()
    {
        echo json_encode($this->model('B_EMR_Model')->setFormEdukasi($_POST));
    }

    public function getFormEdukasi()
    {
        echo json_encode($this->model('B_EMR_Model')->getFormEdukasi($_POST));
    }

    public function setSaveEdukasiLanjutan()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveEdukasiLanjutan($_POST));
    }

    public function getDataTableEdukasiLanjutan()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataTableEdukasiLanjutan($_POST));
    }

    public function setBatalEdukasiLanjutan()
    {
        echo json_encode($this->model('B_EMR_Model')->setBatalEdukasiLanjutan($_POST));
    }

    public function setSaveAssesmentMata()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveAssesmentMata($_POST));
    }
    public function setAnamnesis()
    {
        echo json_encode($this->model('B_EMR_Model')->setAnamnesis($_POST));
    }
    public function setSaveAssesmentRajal()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveAssesmentRajal($_POST));
    }

    public function getDataListProductObat()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListProductObat($_POST));
    }

    public function getDataListResepByNoreg()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListResepByNoreg($_POST));
    }

    public function getDataDetailResepByIDHDR()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataDetailResepByIDHDR($_POST));
    }

    public function getDataListResepByIDHDR()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListResepByIDHDR($_POST));
    }

    public function setDeleteDetailResepByID()
    {
        echo json_encode($this->model('B_EMR_Model')->setDeleteDetailResepByID($_POST));
    }

    public function setSaveGetNewOrderResep()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveGetNewOrderResep($_POST));
    }

    public function newSetTambahResepDetail()
    {
        echo json_encode($this->model('B_EMR_Model')->newSetTambahResepDetail($_POST));
    }

    public function SetUpdateFinalResepDokter()
    {
        echo json_encode($this->model('B_EMR_Model')->SetUpdateFinalResepDokter($_POST));
    }

    public function SetNewResepDetailHeader()
    {
        echo json_encode($this->model('B_EMR_Model')->SetNewResepDetailHeader($_POST));
    }

    public function getDataListResepByIDHDRRacik()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListResepByIDHDRRacik($_POST));
    }

    public function newSetTambahResepDetailRacikObat()
    {
        echo json_encode($this->model('B_EMR_Model')->newSetTambahResepDetailRacikObat($_POST));
    }
    public function searchdiagnosaICD10()
    {
        echo json_encode($this->model('B_EMR_Model')->searchdiagnosaICD10($_POST));
    }
    public function searchdiagnosaICD9()
    {
        echo json_encode($this->model('B_EMR_Model')->searchdiagnosaICD9($_POST));
    }
    public function insertICD10Utama()
    {
        echo json_encode($this->model('B_EMR_Model')->insertICD10Utama($_POST));
    }
    public function insertICD10sekunder()
    {
        echo json_encode($this->model('B_EMR_Model')->insertICD10sekunder($_POST));
    }
    public function insertICDTindakan()
    {
        echo json_encode($this->model('B_EMR_Model')->insertICDTindakan($_POST));
    }
    public function listICD10Sekunder()
    {
        echo json_encode($this->model('B_EMR_Model')->listICD10Sekunder($_POST));
    }
    public function listICD10Utama()
    {
        echo json_encode($this->model('B_EMR_Model')->listICD10Utama($_POST));
    }
    public function listICDTindakan()
    {
        echo json_encode($this->model('B_EMR_Model')->listICDTindakan($_POST));
    }
    public function setTriageCovid19()
    {
        echo json_encode($this->model('B_EMR_Model')->setTriageCovid19($_POST));
    }
    public function setSpiritual()
    {
        echo json_encode($this->model('B_EMR_Model')->setSpiritual($_POST));
    }
    public function listPerawat()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Pasien Poli Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/list/listperawat', $data);
        $this->View('templates/footer');
    }
    public function setOrderOperasi()
    {
        echo json_encode($this->model('B_EMR_Model')->setOrderOperasi($_POST));
    }
    public function setOrderOperasiBatal()
    {
        echo json_encode($this->model('B_EMR_Model')->setOrderOperasiBatal($_POST));
    }

    public function getDataListOrderOperasi()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListOrderOperasi($_POST));
    }

    public function getDataDetailOrderOperasiByIDHDR()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataDetailOrderOperasiByIDHDR($_POST));
    }
    public function searchTarifOperasi()
    {
        echo json_encode($this->model('B_EMR_Model')->searchTarifOperasi($_POST));
    }
    public function searchTarifOperasibyId()
    {
        echo json_encode($this->model('B_EMR_Model')->searchTarifOperasibyId($_POST));
    }
    public function getDataListOrderOperasibyNoRekamMedikPeriodik()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListOrderOperasibyNoRekamMedikPeriodik($_POST));
    }
    public function getDataListOrderOperasibyPeriodik()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataListOrderOperasibyPeriodik($_POST));
    }
    public function AssesmentOperasi($noreg = null, $id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noreg'] =  Utils::setDecode($noreg);
        $data['idorder'] =  Utils::setDecode($id);
        $data['judul'] = 'Assesment Operasi';
        $data['judul_child'] = 'Asesment Operasi';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/assesmentOperasi', $data);
        $this->View('templates/footer');
    }
    //ASS OPERASI
    public function getDataNurseAssOperasi()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataNurseAssOperasi($_POST));
    }

    public function setSavePreOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSavePreOperasiNA($_POST));
    }

    public function setSavePersiapanOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSavePersiapanOperasiNA($_POST));
    }

    public function setSaveIntraOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveIntraOperasiNA($_POST));
    }

    public function setSaveSignInOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveSignInOperasiNA($_POST));
    }

    public function setSaveTimeOutOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveTimeOutOperasiNA($_POST));
    }

    public function setSaveSignOutOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveSignOutOperasiNA($_POST));
    }

    public function setSaveSerahTerimasOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSaveSerahTerimasOperasiNA($_POST));
    }

    public function setSavePostOperasiNA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSavePostOperasiNA($_POST));
    }


    // dokter assm operasi

    public function getDataDokterAssOperasi()
    {
        echo json_encode($this->model('B_EMR_Model')->getDataDokterAssOperasi($_POST));
    }

    public function setSavePraBedahOperasiDA()
    {
        echo json_encode($this->model('B_EMR_Model')->setSavePraBedahOperasiDA($_POST));
    }




    public function listOrderOperasi()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Order Operasi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/list/listorderoperasi', $data);
        $this->View('templates/footer');
    }
}
