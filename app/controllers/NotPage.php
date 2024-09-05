<?php
class NotPage extends Controller
{
    public function index()
    { 
        $this->View('templates/header_login');
        $this->View('page404/page404');
        $this->View('templates/footer_login');
    }
     
}
