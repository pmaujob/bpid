var idRad;

function onLoadBody() {

    $(document).ready(function () {

        $('.modal').modal({
            complete: function () {

                document.getElementById('semaforo').style.display = "none";
                document.getElementById('semaforo').style.right = "-60px";

                var toasts = new Array();

                if (document.getElementById('toast-container') != null) {
                    toasts = document.getElementById('toast-container').getElementsByTagName("div");
                }

                for (var i = toasts.length - 1; i >= 0; i--) {
                    toasts[i].parentNode.removeChild(toasts[i]);
                }

            }
        });

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

    $("#d_ingreso").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Aceptar": function () {
                $(this).dialog("close");
                window.self.location = "../formularios/frm_listas_radicar.php";
            }
        }
    });

}

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
            resultado.innerHTML = '<p>' + respuesta + '</p>';
        },
        error: function () {
            //quitarPantalla();
            alert("Error inesperado");
            window.top.location = "../index.html";
        }
    });
}

function mas(cod, bpid, numProyecto) {

    document.getElementById('modalc1').style.display = "none";
    document.getElementById('modalc2').style.display = "none";

    $('#modal1').modal('open');

    idRad = cod;

    document.getElementById('collapsible').innerHTML = "<div style='text-align: center; margin-left: auto; margin-right: auto;'><img id='esperarListas' src='./../css/wait.gif' style='width: 275px; height: 174,5px;' ></div>";

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListaCriterios.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad},
        success: function (respuesta) {

            document.getElementById('collapsible').innerHTML = respuesta;
            document.getElementById('semaforo').style.display = "block";
            document.getElementById('semaforo').style.right = "0";
            document.getElementById('modalc1').style.display = "block";
            document.getElementById('modalc2').style.display = "block";

        }, error: function () {
            alert("Error inesperado");
            document.getElementById('modalc1').style.display = "block";
            document.getElementById('modalc2').style.display = "block";
            window.top.location = "../index.html";
        }
    });

}

function registrarCriterios(op) {

    bloquear_pantalla();

    var cont = document.getElementById('cont').value;
    var contDimensiones = document.getElementById('contDimensiones').value;

    var obsdimensiones = new Array();
    var criterios = new Array();

    for (var i = 0; i < contDimensiones; i++) {

        var obsdimen = new Array(2);
        var contTotal = 0;
        var contChequeados = 0;
        var res = 0;

        $("#LISTA" + i + " input").each(function () {
            contTotal++;
            if ($(this).prop('checked'))
                contChequeados++;
        });

        res = (contChequeados * 100) / (contTotal - 1);

        obsdimen[0] = document.getElementById('IDDIMEN' + i).value;
        obsdimen[1] = document.getElementById('OBS' + i).value;
        obsdimen[2] = res.toFixed(2);

        obsdimensiones.push(obsdimen);

    }

    for (var i = 0; i < obsdimensiones.length; i++) {

        if (obsdimensiones[i][2] == 0) {
            document.getElementById('d_error').innerHTML = "Debe haber por lo menos un critero por cada dimensión.";
            $('#modal1').modal('close');
            $('#d_error').dialog("open");
            $("#d_error").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Cerrar": function () {
                        $(this).dialog("close");
                        $('#modal1').modal('open');
                    }
                }
            });
            quitar_pantalla();
            return;
        }

    }

    if (obsdimensiones.length < 1)
        obsdimensiones = 'nohave';

    var j = 0;

    for (var i = 0; i < cont; i++) {

        var criteriosRow = new Array(2);

        criteriosRow[0] = document.getElementById('PRE' + i).value;
        criteriosRow[1] = document.getElementById('PRE' + i).checked ? "Si" : "No";
        //criteriosRow[2] = document.getElementById('OBS' + i).value;

        criterios.push(criteriosRow);

        j++;

    }

    $('#modal1').modal('close');

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/CRegistrarCriterios.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, preguntas: criterios, observaciones: obsdimensiones, op: op},
        success: function (respuesta) {

            if (respuesta.trim() == "1") {
                document.getElementById('d_error').innerHTML = "Los criterios de viabilidad se han registrado con exito.";
                $('#d_error').dialog("open");
                $("#d_error").dialog({
                            autoOpen: false,
                            modal: true,
                            buttons: {
                                "Cerrar": function () {
                                    $(this).dialog("close");
                                    window.top.location = "../../vistas/formularios/frm_criterios_viabilidad.php";
       

                                }
                            }
                        });
            } else {
                document.getElementById('d_error').innerHTML = "Los criterios de viabilidad no han podido ser registrados, por favor intentelo de nuevo mas tarde.";
                $('#d_error').dialog("open");
            }

            quitar_pantalla();

        }, error: function () {
            alert("Error inesperado");
            quitar_pantalla();
            window.top.location = "../index.html";
        }
    });

}

function semaforo(id) {

    var contTotal = 0;
    var contChequeados = 0;
    var res = 0;
    var texto;

    texto = $("#" + id).children('div').html();

    $("#" + id + " input").each(function () {
        contTotal++;
        if ($(this).prop('checked'))
            contChequeados++;
    });

    res = (contChequeados * 100) / (contTotal - 1);

    if (res < 50)
        document.getElementById('bonbilla').style.backgroundColor = "red";
    else if (res >= 50 && res < 90)
        document.getElementById('bonbilla').style.backgroundColor = "orange";
    else
        document.getElementById('bonbilla').style.backgroundColor = "green";

    crearToast(texto + " (" + res.toFixed(2) + "%)");

}

function crearToast(texto) {

    var toasts = new Array();

    if (document.getElementById('toast-container') != null) {
        toasts = document.getElementById('toast-container').getElementsByTagName("div");
    }

    for (var i = toasts.length - 1; i >= 0; i--) {
        toasts[i].parentNode.removeChild(toasts[i]);
    }

    Materialize.toast(texto, 500000);

    var toast = document.getElementById('toast-container').getElementsByTagName("div")[0];
    toast.style.background = "#008643";
    toast.style.fontWeight = "400";

}

function cerrarModal() {

    $('#modal1').modal('close');
    document.getElementById('toast-container').innerHTML = "";

}