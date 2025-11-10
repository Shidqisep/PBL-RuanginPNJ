<?php

class Database 
{
//kredensial database dari .env
private $host;
private $dbname;
private $username;
private $password;
private $stmt;
private $dbh;


public function __construct() {
    $this->host = getenv('DB_HOST');
    $this->username = getenv('DB_USERNAME');
    $this->password = getenv('DB_PASSWORD');
    $this->dbname = getenv('DB_DATABASE');
    
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->dbh = new PDO($dsn, $this->username, $this->password, $option);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

     public function query($query){
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type=NULL){
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute(){
            $this->stmt->execute();
        }

        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function singleSet(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

        public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }

}
