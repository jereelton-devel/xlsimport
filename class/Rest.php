<?php

header("access-control-allow-origin: *");
header("Content-Type: application/json");

require_once './Query.php';

class Rest
{
    private $tbname;
    private $response = array();
    
    public function __construct($tbname, $target, $dataRange)
    {
        $this->tbname = $tbname;
        
        $stmt = new Query($this->tbname);
        
        if($target === 'cad_ing_range')
        {
            $stmt->queryCadIngRange($dataRange);
            $this->response['cad_ing_range'] = $stmt->queryResult();
        }
        
        echo json_encode($this->response);
        
    }
    
}

$tbname = $_GET['tbname'];
$target = (isset($_GET['target'])) ? $_GET['target'] : '';
$dataRange = (isset($_GET['datarange'])) ? $_GET['datarange'] : '';

new Rest($tbname, $target, $dataRange);

?>

