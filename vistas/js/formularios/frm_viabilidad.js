numeroActividad = 0;
var valorFuentes = new Array();
var actividadDatos = new Array();
var FuentesDatos = new Array();
var totalfuentes = 0;
var r = [];
$(document).ready(function () {


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
            Materialize.toast(document.getElementById('proyectName').value);

            var toast = document.getElementById('toast-container').getElementsByTagName("div")[0];
            toast.style.background = "#008643";
            toast.style.fontWeight = "400";

            $('.modal').modal();

        },
        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}

function editarActividades(codRadicacion, idProducto, idActividad, valorActividad)
{
    numeroActividad = 0;
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmActividadesValores.php',
        async: true,
        data: {codRadicacion: codRadicacion, idProducto: idProducto, idActividad: idActividad, valorActividad: valorActividad},
        success: function (respuesta) {
            //alert(respuesta);
            $('select').material_select();
            $('#modal1').modal('open');
            document.getElementById('respuestaact').innerHTML = '';
            document.getElementById('respuestaact').innerHTML = respuesta;
            $('.modal').modal();
            $('select').material_select();
        },
        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });


}
function agregarFuente(idActividad)
{
    numeroActividad = numeroActividad + 1;

    document.getElementById('codigoActividad').value = idActividad;
    document.getElementById('numeroActividad').value = numeroActividad;
    var tabla = document.getElementById('tableActividades_' + idActividad);
    var unidad = document.getElementById('frmUnidad_' + idActividad).value;
    var cantidad = document.getElementById('frmCantidad_' + idActividad);
    var unitario = document.getElementById('frmCosto_' + idActividad);
    var total = document.getElementById('frmTotal_' + idActividad).value;
    var valorActividad = document.getElementById('valorActividad').value;

    if (unidad == "")
    {
        Materialize.toast('Error, Seleccione Unidad de Media', 4000);
        document.getElementById('frmUnidad_' + idActividad);
    }

    if (valorActividad != total)
    {
        Materialize.toast('Error, verifique los montos', 4000);
        document.getElementById('frmCantidad_' + idActividad).focus();
        return  false;
    } else
    {

        jQuery.ajax({
            type: 'POST',
            url: '../../vistas/formulariosDinamicos/frmViabilizadosFuentes.php',
            async: true,
            data: {idActividad: idActividad, numeroActividad: numeroActividad},
            success: function (respuesta) {

                // document.getElementById('datosActividad_'+idActividad).innerHTML = '';

                var rows = document.createElement("tr");
                rows.innerHTML = respuesta
                $('select').material_select();
                //contiene una cadena con los td
                tabla.appendChild(rows);
                //document.getElementById('datosActividad_'+idActividad).innerHTML = respuesta;
            },
            error: function () {
                alert("Error inesperado")
                window.top.location = "../index.html";
            }
        });
    }
}

function calcularValorActividad(idActividad)
{
    var unidad = document.getElementById('frmUnidad_' + idActividad).value;
    var cantidad = document.getElementById('frmCantidad_' + idActividad).value;
    var unitario = document.getElementById('frmCosto_' + idActividad).value;
    var valorActividad = document.getElementById('valorActividad').value;

    if (cantidad == "") {
        Materialize.toast('Digite Cantidad', 4000);
        return
    }
    if (unitario == "") {
        Materialize.toast('Digite Valor unitario', 4000);
        return
    }
    var total = cantidad * unitario;

    document.getElementById('frmTotal_' + idActividad).value = total;
    if (valorActividad != total)
    {
        Materialize.toast('Error, El valor Total deber ser igual al Valor de la Actividad', 4000);
        return   false
    }
    if (valorActividad == total)
    {
        Materialize.toast('VALOR CORRECTO', 4000);
        return
    }

}


function calcularValorFuente(idcampo, idActividad)
{

    var bool = true;
    var campo = idcampo.id;//seleccionar campo
    var valor = document.getElementById(campo).value;//valor del campo enviado
    var valorActividad = document.getElementById('valorActividad').value;
    var totalact = 0;
    var campototal = document.getElementById('frmValorFuenteNacional_' + idActividad);
    var suma = document.getElementById('sumaValores');

    if (valorFuentes.length != 0) {

        for (var i = 0; i < valorFuentes.length; i++)
        {
            if (valorFuentes[i][0] == campo)
            {
                //encontro el campo
                valorFuentes[i][1] = valor;
                bool = false;
            }
        }
    } else {
        bool = true;
    }

    if (bool) {
        //ingreso datos por no encontrarlo
        var datosvalores = new Array(2);
        datosvalores[0] = campo;
        datosvalores[1] = valor;
        valorFuentes.push(datosvalores);
        //console.log(valorFuentes);

    }


    for (var k = 0; k < valorFuentes.length; k++)
    {

        var prueba = valorFuentes[k][1];
        totalact = parseInt(totalact) + parseInt(valorFuentes[k][1]);
        console.log(totalact);
    }



    if (valorActividad != totalact)
    {
        Materialize.toast('Error, El valor Total deber ser igual al Valor de la Actividad', 4000);
        campototal.value = totalact;
        suma.value = totalact;
        return   false
    }
    if (valorActividad == totalact)
    {
        Materialize.toast('VALOR CORRECTO', 4000);
        campototal.value = prueba;
        suma.value = totalact;
        return
    }
    //campototal.value=totalact;


}


function guardarActividades()
{

    var numeroActividad = document.getElementById('numeroActividad').value;
    var i = document.getElementById('codigoActividad').value;
    var total = document.getElementById('frmTotal_' + i).value
    var suma = document.getElementById('sumaValores').value;

    if (total == "")
    {
        Materialize.toast('Error, Debe Completar todos los datos', 4000);
        return;

    }
    if (numeroActividad == 0) {
        Materialize.toast('Debe Agregar Fuentes de Financiacion', 4000);
        return;
    }

    var fuente = document.getElementById('frmFuente_' + numeroActividad).value;
    var unidad = document.getElementById('frmUnidad_' + i).value;
    var cantidad = document.getElementById('frmCantidad_' + i).value;
    var unitario = document.getElementById('frmCosto_' + i).value;
    var valorActividad = document.getElementById('valorActividad').value;
    if (cantidad == "") {
        Materialize.toast('Digite Cantidad', 4000);
        return
    }
    if (unitario == "") {
        Materialize.toast('Digite Valor unitario', 4000);
        return
    }

    if (fuente == "")
    {
        Materialize.toast('Seleccione Fuente de Financiacion', 4000);
        document.getElementById('frmFuente_' + i).focus();
        return
    }

    if (valorActividad != suma)
    {

        Materialize.toast('Error, El valor Total deber ser igual al Valor de la Actividad', 4000);
        document.getElementById('frmUnidad_' + i).focus();
        return;
    } else
    {
        var datosact = new Array(3);
        datosact[0] = document.getElementById('frmUnidad_' + i).value;//unidad de medida
        datosact[1] = document.getElementById('frmCantidad_' + i).value;//cantidad de medida
        datosact[2] = document.getElementById('frmCosto_' + i).value;//costoactividad
        actividadDatos.push(datosact);

        if (numeroActividad > 0)
        {
            var datofuente = new Array(5);
            for (j = 1; j <= numeroActividad; j++) {
                datofuente[0] = i; //codigo de actividad  
                datofuente[1] = document.getElementById('frmFuente_' + j).value;
                datofuente[2] = document.getElementById('frmValorFuenteNacional_' + j).value;
                datofuente[3] = document.getElementById('frmValorEfectivoNacional_' + j).value;
                datofuente[4] = document.getElementById('frmValorEspecieNacional_' + j).value;
                FuentesDatos.push(datofuente);
                $('#modal1').modal('close');

            }

        }
        numeroActividad = 0;
        //  alert(FuentesDatos);

    }
}

function subtotal(tupla)
{
    valorEspecie = "frmValorEfectivoNacional_" + tupla;
    valorEfectivo = "frmValorEspecieNacional_" + tupla;
    valorsubtotal = "frmValorFuenteNacional_" + tupla;
    document.getElementById(valorsubtotal).value = "";
    var vEsp = parseInt(document.getElementById(valorEspecie).value == "" ? 0 : document.getElementById(valorEspecie).value);
    var vEfec = parseInt(document.getElementById(valorEfectivo).value == "" ? 0 : document.getElementById(valorEfectivo).value);
    document.getElementById(valorsubtotal).value = vEsp + vEfec;

}

function guardarMetas() {

    var idRad = document.getElementById('idRad').value;
    var contMeta = document.getElementById('contMeta').value;
    var contItemMeta = document.getElementById('contItemMeta');
    if (contItemMeta.value > contMeta) {
        $("#d_ingreso").dialog("open");
        return;
    }

    for (var i = 1; i <= contMeta; i++) {
        var select = document.getElementById('METASELECT' + (i));

        if (select.value == 0) {
            alert('Debe seleccionar una meta en este item.');
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
            alert("No puede quedar ninguna meta sin actividades.");
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

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/ActualizarActividades.php',
        async: true,
        data: {metaActividades: metaActividades, idRad: idRad},
        success: function (respuesta) {

            if (respuesta == 1) {
                alert("Los datos se actualizaron con éxito.");
                location.href = 'frm_viabilidad.php';

            } else {
                alert("No se pudo registrar las metas, por favor vuelva a intentarlo.");
            }

        },
        error: function () {
            alert("Error inesperado");
        }
    });



}
function vermga(opcion)//verga
{

    fila = document.getElementById("fila_mga");
    if (opcion == 1) {
        fila.style.display = 'none';
    } else {
        fila.style.display = '';
    }
}