<?php

class aaNotification extends Controller
{
    public function getOrderBHPRanap(){
        echo json_encode($this->model('AA_Notification_model')->getOrderBHPRanap($_POST));
    }
    public function getOrderBHPRajal(){
        echo json_encode($this->model('AA_Notification_model')->getOrderBHPRajal($_POST));
    }
    public function getOrderResepRajal(){
        echo json_encode($this->model('AA_Notification_model')->getOrderResepRajal($_POST));
    }
    public function getOrderResepRanap(){
        echo json_encode($this->model('AA_Notification_model')->getOrderResepRanap($_POST));
    }
    public function getNotifKasirfromFarmasi(){
        echo json_encode($this->model('AA_Notification_model')->getNotifKasirfromFarmasi($_POST));
    }
}