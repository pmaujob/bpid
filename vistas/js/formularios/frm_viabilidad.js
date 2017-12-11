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

                            $("#d_ingreso").dialog("close");

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
    if (buscarValue.toString().trim().length == 0) {
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

    //bloquearPantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: op},
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

function mas(idRad, bpid, numProyecto) {

    bloquear_pantalla()
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmViabilizados.php',
        async: true,
        data: {idRad: idRad, bpid: bpid, numProyecto: numProyecto},
        success: function (respuesta) {

            //alert(respuesta);


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
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}
function guardarMetas() {

    var acum = document.getElementById('frmacum').value;
    var idRad = document.getElementById('idRad').value;
    var contMeta = document.getElementById('contMeta').value;
    var contItemMeta = document.getElementById('contItemMeta');
   
    for (var i = 1; i <= acum; i++) {
      
        var unidadValor = document.getElementById('frm_unidad_' + i);
        var aux = i;
        if (unidadValor.value == "") {
           
            document.getElementById('d_error').innerHTML = '<p>ERROR, DIGITE UNIDAD DE MEDIDA</p>';
            $("#d_error").dialog("open");
            $("#d_error").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        ejecutar(aux,0);
                         
                        $(this).dialog("close");

                    }
                }
            });
             //break;
           
            return ;
        }
        
    }

    if (contItemMeta.value > contMeta) {
        console.log("contItemMeta.value: " + contItemMeta.value + ", contMeta: " + contMeta);
        $("#d_errormetas").dialog("open");
      
        return;
    }

    for (var i = 1; i <= contMeta; i++) {
        var select = document.getElementById('METASELECT' + i);
        var collapsible = document.getElementById('frm_collapsible_' + i).value;

        if (select.value == 0) {
            
            document.getElementById('d_errormetas').innerHTML = '<p>DEBE SELECCIONAR UN ITEM EN ESTA META</p>';
            $("#d_errormetas").dialog("open");
            $("#d_errormetas").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        ejecutar(collapsible, 1);
                        $(this).dialog("close");

                    }
                }
            });
            select.focus();
            

             return;
            


        }
    }

    var options = select.getElementsByTagName('option');
    for (var i = 1; i < options.length; i++) {
        var found = false;
        var option = options[i];

        for (var j = 1; j <= contMeta; j++) {
            var select = document.getElementById('METASELECT' + (j));

            if (select.value == option.value) {
                found = true;
                break;
            }

        }

        if (!found) {
            document.getElementById('d_errormetas').innerHTML = '<p>NO SE PUEDE QUEDAR UNA META SIN ACTIVIDAD</p>';
            $("#d_errormetas").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        ejecutar(collapsible, 1);
                        $(this).dialog("close");

                    }
                }
            });
           
            return;
        }

    }

    var metaActividades = new Array();
    for (var i = 1; i <= contMeta; i++) {
        var metaAct = new Array();
        var actId = document.getElementById('ACTID' + (i)).value;
        var select = document.getElementById('METASELECT' + (i)).value;

        metaAct.push(actId);
        metaAct.push(select);
        metaActividades.push(metaAct);
    }
    var unidades=new Array();
     for (var i = 1; i <= acum; i++) {
        var datosprod = new Array();
        var proId = document.getElementById('frm_producto_id' + i).value;
        var pronum = document.getElementById('frm_producto_' + i).value;
        var nompro = document.getElementById('frm_unidad_' + i).value;

        datosprod .push(proId);
        datosprod .push(pronum);
        datosprod .push(nompro);
        unidades.push(datosprod);
    }
    
   

    
    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/ActualizarActividades.php',
        async: true,
        data: {metaActividades: metaActividades, idRad: idRad,unidades:unidades},
        success: function (respuesta) {
                   
            if (respuesta == 1) {
                        
                document.getElementById('d_errormetas').innerHTML = '<p>LOS DATOS SE GUARDARON CON EXITO.</p>';
                $("#d_errormetas").dialog("open");
                location.href = 'frm_viabilidad.php';

            } else {
                document.getElementById('d_errormetas').innerHTML = '<p>NO SE REGISTRARON LAS METAS, VUELVA A INTENTARLO</p>';
                $("#d_errormetas").dialog("open");

            }

        },
        error: function () {
            alert("Error inesperado");
        }
    });



}
function verarchivoMga(opcion)
{

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
    var acum = document.getElementById('frmacum').value;
    var toasts = document.getElementById('toast-container').getElementsByTagName("div");//traer

    for (i = 0; i < idvidprod.length; i++)
    {



        if (elemento == idvidprod[i][0])
        {
            if (idvidprod[i][1] == false) {
                Materialize.toast('DIGITE UNIDAD DE MEDIDA', 4000);
                if (toasts.length > 1)
                {
                    toasts[1].style.background = "#FFCA04";
                    toasts[1].style.fontWeight = "400";
                }

            }

            idvidprod[i][1] = !idvidprod[i][1];


        }
    }

}
function ejecutar(posicion, op)
{
    
    if (op == 0)
    
    {
        var collapos = document.getElementById('frm_collapsible_' + posicion).value;
        var lugar = collapos - 1;
        $('.collapsible').collapsible('open', lugar);
        document.getElementById('frm_unidad_' + posicion).focus();
       return ;
       
    }
    if (op == 1)
    {
        $('.collapsible').collapsible('open', posicion - 1);
    }
}


