<?php
class aFormSkrinning extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'SKRINNING BATUK';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('form/FormSkrinningInput', $data);
        $this->View('templates/footer');
    }

    public function addSkrinningBatuk()
    {
        echo json_encode($this->model('FormSkrinningInput_Model')->addSkrinningBatuk($_POST));
    }
    public function insert()
    {
        echo json_encode($this->model('FormSkrinningInput_Model')->insert($_POST));
    }
    public function getAllSkrinningBatuk()
    {
        echo json_encode($this->model('FormSkrinningInput_Model')->getAllSkrinningBatuk($_POST));
    }
    public function delete($ID)
    {
        echo json_encode($this->model('FormSkrinningInput_Model')->delete($_POST));
    }

    //edit badrul
    public function uploadDataTTD()
    {
        echo json_encode($this->model('FormSkrinningInput_Model')->uploadDataTTD($_POST));
    }
    //edit badrul
}