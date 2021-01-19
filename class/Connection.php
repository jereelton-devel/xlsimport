<?php

require_once './Config.php';

class Connection extends PDO
{   
    private $config;
    private $connection;
    
    public function getConnection()
    {
        return $this->connection;
    }
    
    public function __construct()
    {
        $this->config = new Config();
        
        $this->connection = new PDO(
                "mysql:"
                . "host=".$this->config->getHostName().";"
                . "dbname=".$this->config->getDbName(), 
                $this->config->getUserName(), 
                $this->config->getPassword());
        
    }

}
?>