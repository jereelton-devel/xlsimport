<?php

require_once '../../../lib/configs.php';

class Query
{   
    private $query;
    private $tbname;
    
    public function queryCadIngRange($range)
    {
        $this->query = "SELECT * FROM ".$this->tbname." WHERE data_range LIKE '".$range."';";
    }
    
    public function queryResult()
    {
        global $conn;
        $rs = $conn->sql($this->query);

        return $conn->fetchAll($rs);
    }
    
    public function __construct($tbname)
    {
        $this->tbname = $tbname;
    }
    
}
?>