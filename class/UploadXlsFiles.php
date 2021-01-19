<?php

//TODO: Transformar em classe para upload de arquivos

$response = array();

if (move_uploaded_file($_FILES['xlsfilename']['tmp_name'], '../xls_files/'.$_FILES['xlsfilename']['name'])) {
    
    $response['upload'] = true;
    $response['upfile'] = $_FILES['xlsfilename']['name'];
    $response['upmsg']  = "Arquivo recebido ".$_FILES['xlsfilename']['name']." - tamanho ".$_FILES['xlsfilename']['size'];
        
} else {
    
    $response['upload'] = false;
    $response['upfile'] = $_FILES['xlsfilename']['name'];
    $response['upmsg']  = "Falha ao fazer upload do arquivo: " . $_FILES['xlsfilename']['name'];
    
}

echo json_encode($response);

?>

