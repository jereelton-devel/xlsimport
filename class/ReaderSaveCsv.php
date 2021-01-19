<?php

require_once './PHPExcel.php';
require_once '../../../lib/configs.php';

class ReaderSaveCsv
{
    private $filename;
    private $tableName;
    private $query;
    private $values;
    private $response;
    private $arrayData = array();

    public function __construct($f)
    {
        $this->tableName = "tb_cad_modalidade_fedex";
        $this->filename = $f;
        $this->setArrayData();
    }
    
    public function setArrayData()
    {
        $fh = fopen($this->filename, "r");
        while(!feof($fh)){

            $ln = fgets($fh);

            if(strstr($ln, ';') == true) {
                $this->arrayData[] = explode(";", $ln);
            }
        }
        fclose($fh);
    }

    public function importCsvData()
    {
        global $conn;

        date_default_timezone_set("America/Sao_Paulo");
        setlocale(LC_ALL, "pt_BR", "ptb");

        for ($i = 0; $i < count($this->arrayData); $i++) {

            $this->values = "null,";
            $this->values .= "'" . str_replace("'", "", trim($this->arrayData[$i][0])) . "',";
            $this->values .= "'" . str_replace("'", "", trim($this->arrayData[$i][1])) . "',";
            $this->values .= "'" . str_replace("'", "", trim($this->arrayData[$i][2])) . "',";
            $this->values .= "'" . str_replace("'", "", trim($this->arrayData[$i][3])) . "',";
            $this->values .= "'" . str_replace("'", "", trim($this->arrayData[$i][4])) . "',";
            $this->values .= "now(),";
            $this->values .= "null";

            $this->query = "INSERT INTO " . $this->tableName . " VALUES({$this->values});";

            $conn->begin();

            try {

                $conn->sql($this->query);
                $conn->commit();

            } catch (Exception $e) {

                $conn->rollback();

            }
        }
        
        $this->response['import'] = true;

        $conn->fechar();

        copy("../csv_files/".$this->filename, "../imported/".$this->filename);

        if(file_exists("../csv_files/".$this->filename)) {
            unlink("../csv_files/".$this->filename);
        }

        echo json_encode($this->response);

    }
}

$csvFileRequest = $_POST['csv'];

$oX = new ReaderSaveCsv("../csv_files/".$csvFileRequest);

$oX->importCsvData();

?>

