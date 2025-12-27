<?php
class DatabaseLab{
    private $host = DB_HOST_LAB;
    private $user = DB_USER_LAB;
    private $pass = DB_PASSWORD_LAB;
    private $db_name = DB_NAME_LAB;

    private $dbh;
    private $stmt;

    public function __construct()
    {
        $dsn = 'sqlsrv:Server=' . $this->host . ';Database=' . $this->db_name;
        $option = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{
            $this->dbh =  new PDO($dsn,$this->user,$this->pass, $option);

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function querylab($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bindlab($param, $value, $type =null){
        if(is_null($type)){
            switch (true) {
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param,$value, $type);
    }
    public function executelab(){
        $this->stmt->execute(); 
    }

    public function resultSetlab(){
        $this->executelab();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function singlelab(){
        $this->executelab(); 
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCountlab(){
        return $this->stmt->rowCount();
    }
     
    public function closeCon()
    {
        return $this->dbh = null;
    }

    
}