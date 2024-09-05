<?php
 
class Eticket extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Worklist/e-Ticket User';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/maintenance/MaintenanceAsetIT_List', $data);
        $this->View('templates/footer');
    }
} 