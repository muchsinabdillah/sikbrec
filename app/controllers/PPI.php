<?php
class PPI extends Controller
{
    public function list()
    {
        // $session = SessionManager::getCurrentSession();
        // $data['id'] =  Utils::setDecode($id);
        // $data['jenispasien'] =  'RAJAL';
        // $data['judul'] = 'PERALATAN PEMAKAIAN MEDIS';
        // $data['judul_child'] = 'Input';
        // $data['session'] = $session;
        // $this->View('templates/header', $session);
        $this->View('PPI/PPIListView');
        // $this->View('templates/footer');
    }
    

}