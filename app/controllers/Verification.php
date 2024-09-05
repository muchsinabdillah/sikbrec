<?php
class Verification extends Controller
{
    public function index($id = null)
    {
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Group Shift';
        $data['judul_child'] = 'Input';
            $this->View('templates/header_login', $data);
            $this->View('login/verification', $data);
            $this->View('templates/footer_login', $data);

    }
    public function sendOTP($id = null)
    {
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Group Shift';
        $data['judul_child'] = 'Input';
        $this->View('templates/header_login', $data);
        $this->View('login/otp', $data);
        $this->View('templates/footer_login', $data);
    }
    public function cekLogin()
    {
        echo json_encode($this->model('Login_Model')->cekLogin($_POST));
    }
}
