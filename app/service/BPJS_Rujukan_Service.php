<?php
class BPJS_Rujukan_Service
{
    private $db;

    public function __construct(Rujukan_model $rujukan_model)
    {
        $this->db = new Database;
    }

    public function insertRujukanBpjs()
    {
    }
}
