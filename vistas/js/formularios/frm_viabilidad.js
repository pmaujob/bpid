function bloquear_pantalla()
{
   
    document.getElementById("cargando").style.display = "block";
    document.body.style.overflow = "hidden";
}
function quitar_pantalla()
{
   
    document.getElementById("cargando").style.display = "none";
    document.body.style.overflow = "scroll";
}
$(document).ready(function() {
    
   // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
   $('.modal').modal();
    $('select').material_select();
    $("#d_error").dialog({
                        autoOpen: false,
                        modal: true,
                        buttons: {
                        "Cerrar": function () {
                        $(this).dialog("close");
                                              }
                                }
                        });
     $("#d_ingreso").dialog({
                        autoOpen: false,
                        modal: true,
                        buttons: {
                        "Aceptar": function () {
                        $(this).dialog("close");
                        window.self.location="../formularios/frm_radicar.php";
                                              }
                                }
                        });
});

function buscarProyectos(op) {

    var resultado = document.getElementById('resultado');

    //temporalmente
    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

    value = document.getElementById("input_buscar").value;
    //bloquearPantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: value, op: op},
        success: function (respuesta) {

            //quitarPantalla();
            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';


        },

        error: function () {
            //quitarPantalla();
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });

}
function mas(cod, bpid,numProyecto) {


        jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmViabilizados.php',
        async: true,
        data: {bpid: bpid, numProyecto: numProyecto},
        success: function (respuesta) {
            //alert(respuesta);
            document.getElementById('buscador').innerHTML = '';
            document.getElementById('resultado').innerHTML = respuesta;
          
        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}