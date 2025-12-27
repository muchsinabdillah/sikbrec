<?php
class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASSWORD;
    private $db_name = DB_NAME;

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

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type =null){
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
    public function execute(){
        $this->stmt->execute(); 
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function single(){
        $this->execute(); 
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    public function transaksi()
    {
        $this->transaksi = $this->dbh;
        return $this->transaksi->beginTransaction();
    }

    public function Commit()
    {
        return $this->transaksi->commit();
    }

    public function rollback()
    {
        return $this->transaksi->rollBack();
    }
    public function closeCon()
    {
        return $this->dbh = null;
    }

    public function GetLastID(){
        $this->GetLastID = $this->dbh;
        return $this->GetLastID->lastInsertId();

    }
}