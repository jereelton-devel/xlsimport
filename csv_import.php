<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>XLS IMPORT</title>
    <meta name="description" content="DASHBOARD">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    
    <div id="header" class="container-fluid">
        
        <div class="row">
            <div class="col-xs-12">
                <div class="pull-left">
                    <strong>CSV IMPORT</strong>
                </div>
                <div class="pull-right">
                    <a id="btn-choose-file" class="btn btn-default">
                        <i class="fa fa-user fa-fw"></i>
                        ESCOLHER ARQUIVO
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <div id="div-lock-screen">
        <div id="div-msg-action"></div>
    </div>
    <div id="container-import" class="panel panel-default">
        
        <div class="panel-heading text-left">Importar arquivo CSV</div>
        
        <div class="msg text-left">
            Escolha um arquivo para processamento e importação
        </div>
        
        <div class="panel-body">
            <form name="formX" enctype="multipart/form-data">
                <div class="msg text-left">
                    <input type="file" name="csvfilename" id="csvfilename" />
                </div>
            </form>
        </div>
        
        <hr />
        
        <div class="pull-center">
            <a id="btn-import" class="btn btn-primary">
                <i class="fa fa-user fa-fw"></i>
                IMPORTAR
            </a>
            <a id="btn-cancel-import" class="btn btn-danger">
                <i class="fa fa-user fa-fw"></i>
                CANCELAR
            </a>
        </div>
        
    </div>
    
    <div id="container-footer" class="container-fluid">
        <div class="row">
            <div class="padding-footer"></div>
        </div>
    </div>

    <script type="text/javascript" src="./js/vendor/jquery/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="./js/csv_script.js"></script>
    
</body>
</html>
