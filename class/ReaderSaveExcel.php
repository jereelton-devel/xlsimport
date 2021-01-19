<?php

require_once './PHPExcel.php';
require_once '../../../lib/configs.php';

class ReaderSaveExcel
{
    private $filename;
    private $xlsYear;
    private $readeX;
    private $readeXFile;
    private $rowsTot;
    private $colsTot;
    private $arrayData;
    private $query;
    private $values;
    private $response;
    private $tableName;
    private $dataRange;
    
    public function __construct($f, $y)
    {
        $this->tableName = "tb_cad_ing_range";
        $this->filename = $f;
        $this->xlsYear = $y;
        $this->readeX = PHPExcel_IOFactory::createReaderForFile($this->filename);
        $this->readeX->setReadDataOnly(true);
        $this->readeXFile = $this->readeX->load($this->filename);
        $this->countCols();
        $this->countRows();
        $this->setDataRange();
    }

    public function setDataRange()
    {
        if(preg_match('/JAN|JANEIRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-01-01";
        }
        elseif(preg_match('/FEV|FEVEREIRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-02-01";
        }
        elseif(preg_match('/MAR|MARCO|MARÇO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-03-01";
        }
        elseif(preg_match('/ABR[0-9]|ABRIL/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-04-01";
        }
        elseif(preg_match('/MAI|MAIO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-05-01";
        }
        elseif(preg_match('/JUN|JUNHO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-06-01";
        }
        elseif(preg_match('/JUL|JULHO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-07-01";
        }
        elseif(preg_match('/AGO|AGOSTO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-08-01";
        }
        elseif(preg_match('/SET|SETEMBRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-09-01";
        }
        elseif(preg_match('/OUT|OUTUBRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-10-01";
        }
        elseif(preg_match('/NOV|NOVEMBRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-11-01";
        }
        elseif(preg_match('/DEZ|DEZEMBRO/', strtoupper($this->filename))) {
            $this->dataRange = "{$this->xlsYear}-12-01";
        }
        else {
            die(json_encode(['error' => 'Não foi possivel identificar o mês da abrangência']));
        }
    }
    
    public function countCols()
    {
        $col = $this->readeXFile->setActiveSheetIndex(0)->getHighestColumn();
        $this->colsTot = PHPExcel_Cell::columnIndexFromString($col);
    }
    
    public function checkQtyCols($qty)
    {
        if($this->colsTot === $qty) {
            return true;
        }
        return false;
    }
    
    public function countRows()
    {
        $this->rowsTot = $this->readeXFile->setActiveSheetIndex(0)->getHighestRow();
    }
    
    public function setArrayData()
    {
        if($this->colsTot == 11) {

            // Ignorar cabeçalho da planilha
            for ($l = 3; $l <= $this->rowsTot; $l++) {

                for ($c = 0; $c < $this->colsTot - 1; $c++) {

                    if ($c != 5 && $c != 6) {

                        if ($c == 8 || $c == 9) {

                            if (strstr(utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()), '+')) {

                                $a = intval(explode('+', $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue())[1]);
                                $b = intval($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c-1, $l)->getValue());
                                $this->arrayData[$l - 2][$c] = (int) $a + $b;
                                //$this->arrayData[$l - 2][$c] = explode('+', utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()))[1];

                            } else {
                                $this->arrayData[$l - 2][$c] = $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue();
                            }

                        } else {
                            $this->arrayData[$l - 2][$c] = $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue();
                        }
                    }

                    if ($c == ($this->colsTot - 2)) {
                        $this->arrayData[$l - 2][$c + 1] = $this->dataRange;
                    }
                }
            }
        }
        elseif($this->colsTot == 9){

            // Ignorar cabeçalho da planilha
            for ($l = 3; $l <= $this->rowsTot; $l++) {

                for ($c = 0; $c < $this->colsTot - 1; $c++) {

                    if ($c == 6 || $c == 7) {

                        if (strstr(utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()), '+')) {

                            $a = intval(explode('+', $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue())[1]);
                            $b = intval($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c-1, $l)->getValue());
                            $this->arrayData[$l - 2][$c] = (int) $a + $b;
                            //$this->arrayData[$l - 2][$c] = explode('+', utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()))[1];

                        } else {
                            $this->arrayData[$l - 2][$c] = $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue();
                        }

                    } else {
                        $this->arrayData[$l - 2][$c] = $this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue();
                    }

                    if ($c == ($this->colsTot - 2)) {
                        $this->arrayData[$l - 2][$c + 1] = $this->dataRange;
                    }
                }
            }
        }
    }
    
    public function debugData()
    {
        echo count($this->arrayData);
        echo '<pre>';
        print_r($this->arrayData);
        echo '</pre>';
    }
    
    public function viewTableData()
    {
        echo "<table border='1'>";

        if($this->colsTot == 11) {

            for ($l = 2; $l <= $this->rowsTot; $l++) {

                echo '<tr>';

                for ($c = 0; $c < $this->colsTot - 1; $c++) {

                    if ($l <= 2) {

                        if ($c != 5 && $c != 6) {

                            echo '<th>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());

                        }

                        if ($c == ($this->colsTot - 2)) {
                            echo '<th>Data Range';
                        }

                    } else {

                        if ($c != 5 && $c != 6) {

                            if ($c == 8 || $c == 9) {

                                if (strstr(utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()), '+')) {
                                    echo '<td>' . explode('+', utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()))[1];
                                } else {
                                    echo '<td>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());
                                }

                            } else {

                                echo '<td>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());

                            }
                        }

                        if ($c == ($this->colsTot - 2)) {
                            echo '<td>' . $this->dataRange;
                        }
                    }
                }

                echo '</tr>';
            }

        }
        elseif($this->colsTot == 9) {

            for ($l = 2; $l <= $this->rowsTot; $l++) {

                echo '<tr>';

                for ($c = 0; $c < $this->colsTot - 1; $c++) {

                    if ($l <= 2) {

                        echo '<th>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());

                        if ($c == ($this->colsTot - 2)) {
                            echo '<th>Data Range';
                        }

                    } else {

                        if ($c == 8 || $c == 9) {

                            if (strstr(utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()), '+')) {
                                echo '<td>' . explode('+', utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue()))[1];
                            } else {
                                echo '<td>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());
                            }

                        } else {

                            echo '<td>' . utf8_decode($this->readeXFile->getActiveSheet()->getCellByColumnAndRow($c, $l)->getValue());

                        }

                        if ($c == ($this->colsTot - 2)) {
                            echo '<td>' . $this->dataRange;
                        }
                    }
                }

                echo '</tr>';
            }
        }

        echo "</table>";
    }
    
    public function saveData()
    {
        global $conn;

        date_default_timezone_set("America/Sao_Paulo");
        setlocale(LC_ALL, "pt_BR", "ptb");
        PHPExcel_Shared_TimeZone::setTimeZone("America/Sao_Paulo");
        
        //$this->response['error'] = array();
        //$this->response['success'] = array();

        if($this->colsTot == 11) {

            for ($l = 1; $l <= count($this->arrayData); $l++) {
                $this->values = "null,";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][0]) . "',";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][1]) . "',";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][2]) . "',";
                $this->values .= "'" . $this->arrayData[$l][3] . "',";
                $this->values .= "'" . $this->arrayData[$l][4] . "',";
                $this->values .= "'" . $this->arrayData[$l][8] . "',";
                $this->values .= "'" . $this->arrayData[$l][9] . "',";
                $this->values .= "'" . $this->arrayData[$l][9] . "',";
                $this->values .= "'" . $this->arrayData[$l][10] . "'";

                $this->query = "INSERT INTO " . $this->tableName . " VALUES({$this->values});";

                $conn->begin();

                try {

                    $conn->sql($this->query);
                    $conn->commit();
                    //$this->response['success'][] = "[INSERT SUCCESSFULL QUERY]: " . $this->query;

                } catch (Exception $e) {

                    $conn->rollback();
                    //$this->response['error'][] = "[INSERT FAILED QUERY]: " . $this->query;

                }
            }

        }
        elseif($this->colsTot == 9) {

            for ($l = 1; $l <= count($this->arrayData); $l++) {
                $this->values = "null,";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][0]) . "',";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][1]) . "',";
                $this->values .= "'" . str_replace("'", "", $this->arrayData[$l][2]) . "',";
                $this->values .= "'" . $this->arrayData[$l][3] . "',";
                $this->values .= "'" . $this->arrayData[$l][4] . "',";
                $this->values .= "'" . $this->arrayData[$l][6] . "',";
                $this->values .= "'" . $this->arrayData[$l][7] . "',";
                $this->values .= "'" . $this->arrayData[$l][7] . "',";
                $this->values .= "'" . $this->arrayData[$l][8] . "'";

                $this->query = "INSERT INTO " . $this->tableName . " VALUES({$this->values});";

                $conn->begin();

                try {

                    $conn->sql($this->query);
                    $conn->commit();
                    //$this->response['success'][] = "[INSERT SUCCESSFULL QUERY]: " . $this->query;

                } catch (Exception $e) {

                    $conn->rollback();
                    //$this->response['error'][] = "[INSERT FAILED QUERY]: " . $this->query;

                }
            }
        }
        
        $this->response['import'] = true;
        //$this->response['qtyOs'] = count($this->arrayData);
        //$this->response['qtySuccess'] = count($this->response['success']);
        //$this->response['qtyError'] = count($this->response['error']);
        $this->response['tableName'] = $this->tableName;
        $this->response['dataRange'] = $this->dataRange;

        $conn->fechar();

        copy("../xls_files/".$this->filename, "../imported/".$this->filename);

        if(file_exists("../xls_files/".$this->filename)) {
            unlink("../xls_files/".$this->filename);
        }

        echo json_encode($this->response);

    }
}

$xlsFileRequest = $_POST['xls'];
$xlsYearRequest = $_POST['ano'];

$oX = new ReaderSaveExcel("../xls_files/".$xlsFileRequest, $xlsYearRequest);

if($oX->checkQtyCols(11) === true || $oX->checkQtyCols(9) === true) {

    //$oX->viewTableData();
    $oX->setArrayData();
    //$oX->debugData();
    $oX->saveData();

} else {
    echo json_encode(['error' => 'Estrutura de arquivo não reconhecida pelo sistema']);
}

?>

