<?php

class Config
{   
    private $hostanme;
    private $username;
    private $password;
    private $dbname;
    private $server;
    
    public function getHostName()
    {
        return $this->hostanme;
    }
    
    public function getUserName()
    {
        return $this->username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getDbName()
    {
        return $this->dbname;
    }
    
    public function getServerName()
    {
        return $this->server;
    }

    public function __construct()
    {
        $fileconf = "config.dat";
        $linesconf = file($fileconf);

        $this->hostanme = explode(":", trim($linesconf[0]))[1];
        $this->username = explode(":", trim($linesconf[1]))[1];
        $this->password = explode(":", trim($linesconf[2]))[1];
        $this->dbname = explode(":", trim($linesconf[3]))[1];
        $this->server = explode(":", trim($linesconf[4]))[1];
        $this->port = explode(":", trim($linesconf[5]))[1];
        $this->driver = explode(":", trim($linesconf[6]))[1];
        
    }
	
}
?>