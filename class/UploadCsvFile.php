<?php

//TODO: Transformar em classe para upload de arquivos

$response = array();

if (move_uploaded_file($_FILES['csvfilename']['tmp_name'], '../csv_files/'.$_FILES['csvfilename']['name'])) {
    
    $response['upload'] = true;
    $response['upfile'] = $_FILES['csvfilename']['name'];
    $response['upmsg']  = "Arquivo recebido ".$_FILES['csvfilename']['name']." - tamanho ".$_FILES['csvfilename']['size'];
        
} else {
    
    $response['upload'] = false;
    $response['upfile'] = $_FILES['csvfilename']['name'];
    $response['upmsg']  = "Falha ao fazer upload do arquivo: " . $_FILES['csvfilename']['name'];
    
}

echo json_encode($response);

?>

