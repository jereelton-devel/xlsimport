
var importar = true;
var filenameX = '';
var extensionX = '';
var cadIngRangeBody = $("#tbody-cad-ing-range");
var xlsDate = $("#xlsdate");

function importCsvFile(xfile) {

    $("#div-msg-action").html("Por favor aguarde . . .");

    $.ajax({

        type: "POST",
        url: "./class/ReaderSaveCsv.php",
        data: "csv=" + xfile,
        dataType: "json",

        success: function(rsp) {

            if(rsp.import === true) {

                $("#container-import").addClass('hide');
                $("#container-import").hide();

                $("#div-lock-screen").removeClass('hide');
                $("#div-lock-screen").show();
                $("#div-msg-action").html("");

                alert("Arquivo csv importado com sucesso");

            } else {
                alert('Erro na importação do arquivo\n\n' + rsp.error);
            }

        },

        error: function(err) {
            console.error("Error", err);
            $("#container-import").addClass('hide');
            $("#container-import").hide();
            $("#div-msg-action").html(err.responseText);
        }

    });
}

$(document).ready(function(){
    
    $("#btn-choose-file").on('click', function(){
        
        $("#csvfilename").val('');

        $("#container-import").removeClass('hide');
        $("#container-import").show();

        $("#div-lock-screen").removeClass('hide');
        $("#div-lock-screen").show();
        
    });
    
    $("#btn-cancel-import").on('click', function(){
        
        $("#container-import").addClass('hide');
        $("#container-import").hide();

        $("#div-lock-screen").addClass('hide');
        $("#div-lock-screen").hide();
        
    });
    
    $("#csvfilename").change(function(){
        filenameX = $("#csvfilename").val();
        extensionX = filenameX.split('.');
        
        if(extensionX[1] !== 'csv') {
            alert('Arquivo Invalido !');
            $("#csvfilename").val('');
        }
    });
    
    $("#btn-import").on('click', function(){
        
        if(!filenameX){
            alert('Escolha um arquivo CSV para importar');
            return false;
        }
        
        var formData = new FormData($("form[name='formX']")[0]);
        
        $.ajax({

            type: "POST",
            url: "./class/UploadCsvFile.php",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,

            success: function(rsp) {
                
                if(rsp.upload === true) {

                    importCsvFile(rsp.upfile);
                    //console.log('arquivo importado: ' + rsp.upfile);

                } else {
                    alert('Erro no upload do arquivo');
                }

            },

            error: function(err) {
                console.error("Error", err);
                $("#container-import").addClass('hide');
                $("#container-import").hide();
                $("#div-msg-action").html(err.responseText);
            }

        });
    });
});