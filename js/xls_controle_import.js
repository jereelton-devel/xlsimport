
var message_param = shared_data_from_php.frm_cadastro_message;
var dialog_param = shared_data_from_php.dialog_buttons;

$(document).ready(function() {
// validar dados
$('#frm_cadastro').validate({
    rules:{
        modelo: "required"
    },
    messages:{
        modelo: message_param
    },
    submitHandler: function(form) {
        // anexos
        var msg = ""
        var xls = "";
        var anexo = "";

        var xml = "";
        /*$(".xml").each(function() {
            // validar extensão .XML
            anexo = $(this).val();
            if (f_right(anexo, 3).toLowerCase() != "xml")
                msg += "Extensão do arquivo (" + anexo + ") inválida!\n";

            // lista de anexos separada por vírgula
            xml += anexo + ",";
        });
        if (xml == ""){
            alert("Selecione ao menos um arquivo XML!");
            return false;
        }
        var type = $("#type").val();
        //
        if( type == '' && typeof(type) != 'undefined' ){
            alert("Selecione o campo TYPE!");
            return false;
        }

        /*$(".xls").each(function() {
            // validar extensão .XLS
            anexo = $(this).val();
            if (f_right(anexo, 3).toLowerCase() != "xls" && f_right(anexo, 4).toLowerCase() != "xlsx" && f_right(anexo, 4).toLowerCase() != "xlsb")
                msg += "File (" + anexo + ") Invalid!\n";

            // lista de anexos separada por vírgula
            xls += anexo + ",";
        });*/

        /*if (xls == ""){
            alert("Selecione a planilha!");
            return false;
        }*/

        if (msg != ""){
            alert(msg);
            return false;
        }

        // confirmar operação e submeter formulário via ajax
        if (confirm("Confirm Upload da Planilha?")){
            //$("#xls").val(xls);
            $.ajax({
                type: "POST",
                url: 'os_planilha_reenvio_controle_acao.php',
                data: $("#frm_cadastro").serialize(),
                async: false,
                success: function(data) {
                    //alert(data);
                    //return;
                    $.Dialog({
                        'title'      : 'Resposta',
                        'content'    : MontaResposta(data),
                        'draggable'  : true,
                        'keepOpened' : true,
                        'position'   : {
                            'offsetY' : 30
                        },
                        'closeButton': true,
                        'buttonsAlign': 'right',
                        'buttons'    : {
                            dialog_param : { //TODO: Verificar se isso funciona
                                'action': function() {
                                    var cliente_id = $("#cliente_id").val();
                                    var empresacliente_id = $("#empresacliente_id").val();
                                    var clienteconfig_id = $("#clienteconfig_id").val();

                                    window.location.href = 'os_avaliacao_processo.php';
                                }
                            }
                        }
                    });
                    return false;
                }
            });
        }
        return false;
    }
});
});

body = $("body");

$(document).on({
ajaxStart: function() { body.addClass("loading");    },
ajaxStop: function() { body.removeClass("loading");  }
});

function MontaResposta(data){

var resposta = '<div class="div_resposta" style="width:900px; height:350px; overflow: auto;">'+data+'</div>';

return resposta;

}

function f_right(str, n){
if (n <= 0)
return "";
else if (n > String(str).length)
return str;
else {
var iLen = String(str).length;
return String(str).substring(iLen, iLen - n);
}
}

function exportaBaseAprovar(){
var filtro_sql = $("#filtro_sql").val();
var formato = "xls";
window.location = "exportar_aprovar.php";
//$("#sql").val(filtro_sql);
//$("#acao").val(formato);
//$("#frm_exportar").submit();
}
