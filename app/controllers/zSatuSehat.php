<?php

class zSatuSehat extends Controller
{
    public function genToken(){
        echo json_encode($this->model('Z_Satu_Sehat_Model')->genToken($_POST));
    }
    public function getihspatient(){
        echo json_encode($this->model('Z_Satu_Sehat_Model')->getihspatient($_POST));
    }
    public function Encounter(){
        echo json_encode($this->model('Z_Satu_Sehat_Model')->postEncounterRegistration($_POST));
    }
    public function Bundle(){
        echo json_encode($this->model('Z_Satu_Sehat_Model')->postBundling($_POST));
    }
    public function loopdata(){
        echo json_encode($this->model('Z_Satu_Sehat_Model')->loopdata($_POST));
    }
}
