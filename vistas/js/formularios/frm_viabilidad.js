numeroActividad = 0;
var valorFuentes = new Array();
var actividadDatos = new Array();
var FuentesDatos = new Array();
var totalfuentes = 0;
var r = [];
var idvidprod = [];
$(document).ready(function () {

    $("#d_ingreso").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Aceptar": function () {
                $(this).dialog("close");
                location.href = 'frm_criterios_viabilidad.php';
            }
        }
    });

    $("#d_confirmacion").dialog({
        autoOpen: false,
        modal: true,
        width: "50%",
        buttons: [
            {text: "Aceptar",
                click: function () {

                    var idRad = document.getElementById('idRad').value;

                    jQuery.ajax({
                        type: 'POST',
                        url: '../../controlador/CRollBack.php',
                        async: true,
                        data: {op: 2, idRad: idRad},
                        success: function (respuesta) {

                            if (respuesta == 1) {
                                alert("Su proyecto ha sido regresado a la etapa de Metas de Producto.");
                                window.self.location = "../formularios/frm_meta_producto.php";
                            } else {
                                alert("No fue posible realizar el proceso, vuelva a intentarlo.");
                            }

                        },
                        error: function () {
                            alert("Error inesperado");
                        }

                    });

                }
            },
            {text: "Cancelar",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

});


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
function onLoadBody() {
    buscarProyectos(3, null);

}

function buscarProyectos(op, event) {

    var buscarValue = document.getElementById("input_buscar").value;
    if (event != null && buscarValue.toString().trim().length == 0) {
        return;
    }
    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    var resultado = document.getElementById('resultado');

    //temporalmente
    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: op},
        success: function (respuesta) {

            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';


        },
        error: function () {
            alert("Error inesperado");
        }
    });

}

function mas(idRad, bpid, numProyecto) {

    bloquear_pantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmViabilizados.php',
        async: true,
        data: {idRad: idRad, bpid: bpid, numProyecto: numProyecto},
        success: function (respuesta) {

            quitar_pantalla()
            document.getElementById('buscador').innerHTML = '';
            document.getElementById('resultado').innerHTML = respuesta;
            $('.collapsible').collapsible();
            $("#d_errormetas").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }
                }
            });
            $("#d_error").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }
                }
            });
            Materialize.toast(document.getElementById('proyectName').value);

            var toast = document.getElementById('toast-container').getElementsByTagName("div")[0];
            toast.style.background = "#008643";
            toast.style.fontWeight = "400";

            $('.modal').modal();
            var acum = document.getElementById('frmacum').value;

            for (i = 1; i <= acum; i++)
            {
                var idprodestado = new Array(2);
                idprodestado[0] = 'PRODIV' + i;
                idprodestado[1] = false;
                idvidprod.push(idprodestado);

            }

        },
        error: function () {
            alert("Error inesperado");
        }
    });

}
function guardarMetas() {

    var acum = document.getElementById('frmacum').value;
    var idRad = document.getElementById('idRad').value;
    var contActs = document.getElementById('contActs').value;
    var contItemMeta = document.getElementById('contItemMeta');

    for (var i = 1; i <= acum; i++) {

        var unidadValor = document.getElementById('frm_unidad_' + i);
        var aux = i;
        
        if (unidadValor.value == "") {

            document.getElementById('d_error').innerHTML = '<p>Debe digitar una unidad de medida.</p>';
            
            console.log("acum: "+aux);
            
            $("#d_error").dialog("open");

            $("#d_error").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                        ejecutar(aux, 0);
                    }
                }
            });
            return;
        }

    }

    if (parseInt(contItemMeta.value) > parseInt(contActs)) {
        console.log("contItemMeta.value: " + contItemMeta.value + ", contActs: " + contActs);
        $("#d_confirmacion").dialog("open");
        return;
    }

    for (var j = 1; j <= contActs; j++) {
        var select = document.getElementById('METASELECT' + j);        
        var aux = document.getElementById("frm_collapsible_" + j).value;
        
        if (select.value == 0) {

            document.getElementById('d_errormetas').innerHTML = '<p>Debe seleccionar un item en esta meta.</p>';
            $("#d_errormetas").dialog("open");
            $("#d_errormetas").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                        ejecutar(aux, 1);
                        select.focus();
                    }
                }
            });

            return;

        }

    }

    var options = select.getElementsByTagName('option');
    for (var i = 1; i < options.length; i++) {
        var found = false;
        var option = options[i];
        var aux = i;

        for (var j = 1; j <= contActs; j++) {
            var select = document.getElementById('METASELECT' + (j));

            if (select.value == option.value) {
                found = true;
                break;
            }

        }

        if (!found) {
            document.getElementById('d_errormetas').innerHTML = '<p>No pueden quedar metas sin ser relacionadas a una actividad.</p>';
            $("#d_errormetas").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }
                }
            });
            return;
        }

    }

    var metaActividades = new Array();
    for (var i = 1; i <= contActs; i++) {
        var metaAct = new Array();
        var actId = document.getElementById('ACTID' + (i)).value;
        var select = document.getElementById('METASELECT' + (i)).value;

        metaAct.push(actId);
        metaAct.push(select);
        metaActividades.push(metaAct);
    }

    var unidades = new Array();
    for (var i = 1; i <= acum; i++) {
        var datosprod = new Array();
        var proId = document.getElementById('frm_producto_id' + i).value;
        var pronum = document.getElementById('frm_producto_' + i).value;
        var nompro = document.getElementById('frm_unidad_' + i).value;

        datosprod.push(proId);
        datosprod.push(pronum);
        datosprod.push(nompro);
        unidades.push(datosprod);
    }

    var btnGuardar = document.getElementById("btnGuardar");
    btnGuardar.disabled = true;

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/ActualizarActividades.php',
        async: true,
        data: {metaActividades: metaActividades, idRad: idRad, unidades: unidades},
        success: function (respuesta) {

            if (respuesta == 1) {

                document.getElementById('d_ingreso').innerHTML = '<p>Los datos se guardaron con éxito.</p>';
                $("#d_ingreso").dialog("open");

                btnGuardar.disabled = false;
            } else {
                document.getElementById('d_errormetas').innerHTML = '<p>No fue posible registrar los datos, Por favor vuelva a intentarlo.</p>';
                $("#d_errormetas").dialog("open");
                console.log("Error: " + respuesta);

                btnGuardar.disabled = false;
            }

        },
        error: function () {
            alert("Error inesperado");
            btnGuardar.enabled = false;
        }
    });



}
function verarchivoMga(opcion) {

    fila = document.getElementById("fila_mga");
    if (opcion == 1) {
        fila.style.display = 'none';
    } else {
        fila.style.display = '';
    }
}

function infoproductos(id)
{
    var elemento = id.id;
    for (i = 0; i < idvidprod.length; i++) {

        if (elemento == idvidprod[i][0])
        {
            if (idvidprod[i][1] == false) {
                Materialize.toast('DIGITE UNIDAD DE MEDIDA', 4000, "yellow-toast");

            }
            idvidprod[i][1] = !idvidprod[i][1];
        }
    }

}
function ejecutar(posicion, op) {

    if (!$("#PRODIV" + posicion).hasClass("active")) {
        document.getElementById("PRODIV" + posicion).click();
    }

    if (op == 0) {
        document.getElementById('frm_unidad_' + posicion).focus();
    }

}






