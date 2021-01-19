
var importar = true;
var filenameX = '';
var extensionX = '';
var cadIngRangeBody = $("#tbody-cad-ing-range");
var xlsDate = $("#xlsdate");

function getDataImported(tbname, dataRange) {
    
    $.ajax({

        type: "GET",
        url: "./class/Rest.php",
        data: "tbname=" + tbname + "&target=cad_ing_range&datarange=" + dataRange,
        dataType: "json",

        success: function(rsp) {

            $("#container-import").addClass('hide');
            $("#container-import").hide();

            $("#div-lock-screen").addClass('hide');
            $("#div-lock-screen").hide();

            $("#div-msg-action").html("");

            cadIngRangeBody.html("");

            $("#container-data").show();

            $.each(rsp.cad_ing_range, function(i, obj){
                
                cadIngRangeBody.append("<tr>\n\
                                <td>"+obj.Id+"</td>\n\
                                <td>"+obj.transportadora+"</td>\n\
                                <td>"+obj.uf+"</td>\n\
                                <td>"+obj.cidade+"</td>\n\
                                <td>"+obj.cep_inicial+"</td>\n\
                                <td>"+obj.cep_final+"</td>\n\
                                <td>"+obj.new+"</td>\n\
                                <td>"+obj.sla_demais_clientes+"</td>\n\
                                <td>"+obj.sla_fiserv+"</td>\n\
                                <td>"+obj.data_range+"</td>\n\
                            </tr>");
                
            });
            
        },

        error: function(err) {
            console.error("Error", err);
            $("#container-data").show();
            $("#container-data").html(err.responseText);
        }

    });
}

function importXlsFile(xfile) {

    $("#div-msg-action").html("Por favor aguarde . . .");
    $("#container-data").hide();

    $.ajax({

        type: "POST",
        url: "./class/ReaderSaveExcel.php",
        data: "xls=" + xfile + "&ano=" + xlsDate.val(),
        dataType: "json",

        success: function(rsp) {

            if(rsp.import === true) {
            
                viewDataFromDatabase(rsp.tableName, rsp.dataRange);

                $("#container-import").addClass('hide');
                $("#container-import").hide();

                $("#div-msg-action").html("");

            } else {
                alert('Erro na importação do arquivo\n\n' + rsp.error);
            }

        },

        error: function(err) {
            console.error("Error", err);
            $("#container-data").show();
            $("#container-data").html(err.responseText);
        }

    });
}

function viewDataFromDatabase(tbname, dataRange) {
    getDataImported(tbname, dataRange);
}

$(document).ready(function(){
    
    $("#btn-choose-file").on('click', function(){
        
        $("#xlsfilename").val('');

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
    
    $("#xlsfilename").change(function(){
        filenameX = $("#xlsfilename").val();
        extensionX = filenameX.split('.');
        
        if(extensionX[1] !== 'xlsx' && extensionX[1] !== 'xls') {
            alert('Arquivo Invalido !');
            $("#xlsfilename").val('');
        }
    });
    
    $("#btn-import").on('click', function(){

        if(!xlsDate.val()){
            alert('Informe o ano da abrangencia');
            return false;
        }
        
        if(!filenameX){
            alert('Escolha um arquivo XLS ou XLSX');
            return false;
        }
        
        var formData = new FormData($("form[name='formX']")[0]);
        
        $.ajax({

            type: "POST",
            url: "./class/UploadXlsFiles.php",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,

            success: function(rsp) {
                
                if(rsp.upload === true) {

                    importXlsFile(rsp.upfile);
                    //console.log('arquivo importado: ' + rsp.upfile);

                } else {
                    alert('Erro no upload do arquivo');
                }

            },

            error: function(err) {
                console.error("Error", err);
                $("#container-data").show();
                $("#container-data").html(err.responseText);
            }

        });
    });
});