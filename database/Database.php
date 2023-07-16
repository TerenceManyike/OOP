<?php

require_once("config.php");

class Database
{
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_name = DB_NAME;
    private $db_pwd = DB_PWD;

    private $connection;
    private $error;
    private $statement;
    private $is_connected = false;

    public function __construct()
    {
        $dsn = 'mysql:host='. $this->db_host. ';dbname='. $this->db_name;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->connection = new PDO($dsn, $this->db_user, $this->db_pwd, $options);
            $is_connected = true;
        }catch(PDOException $e){
            $this->error = $e->getMessage().PHP_EOL;
            $is_connected = false;
        }
    }

    public function getError()
    {
        return $this->error;
    }

    public function isConnected()
    {
        return $this->is_connected;
    }
    
    public function query($query)
    {
        return $this->statement = $this->connection->prepare($query);
    }

    public function execute()
    {
        $this->statement->execute();
    }

    public function getAll()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOne()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        $this->execute();
        return $this->statement->rowCount();
    }

    public function bind($param, $value, $type=null)
    {
        if(is_null($type))
        {
            switch(true)
            {
                case is_int($type):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($type):
                    $type = PDO::PARAM_BOOL;
                    break;

                case is_null($type):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STRING;
                    break;
            }
        }
        $this->statement->bindValue($param, $value, $type);
    }

}