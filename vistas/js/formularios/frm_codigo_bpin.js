var idRad;

function onLoadBody() {

    buscarProyectos(7, null);

    $(document).ready(function () {

        $('.modal').modal({
            complete: function () {

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
    if (event != null && buscarValue.toString().trim().length == 0) {
        return;
    }

    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    var resultado = document.getElementById('resultado');

    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

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

    idRad = cod;

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/CDatosBPIN.php',
        async: true,
        timeout: 0,
        data: {op: 1, idRad: idRad},
        success: function (respuesta) {

            var content = JSON.parse(respuesta);

            document.getElementById('frm_numero').value = content.numero;
            document.getElementById('frm_numero').focus();
            document.getElementById('frm_nombre').value = content.nombre;
            document.getElementById('frm_nombre').focus();

            $('#modal1').modal('open');

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function registrarCodigoBpin() {

    bpin = document.getElementById('frm_codigo').value;

    if (bpin == "") {
        Materialize.toast("El código BPIN no puede estar vacio.", 2000, "green-toast");
        return;
    }

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/CDatosBPIN.php',
        async: true,
        timeout: 0,
        data: {op: 2, idRad: idRad, codBPIN: bpin},
        success: function (respuesta) {

            if (respuesta.trim() == "1") {
                document.getElementById('d_error').innerHTML = "El código BPIN ha sido guardado con exito.";
                $('#modal1').modal('close');
                $('#d_error').dialog("open");
                $("#d_error").dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        "Cerrar": function () {
                            $(this).dialog("close");
                            location.href = "../../vistas/formularios/frm_codigo_bpin.php";
                        }
                    }
                });

            } else {
                document.getElementById('d_error').innerHTML = "El código BPIN no ha podido ser registrado, por favor intentelo de nuevo mas tarde.";
                $('#modal1').modal('close');
                $('#d_error').dialog("open");
            }

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function cerrarModal() {

    $('#modal1').modal('close');
    document.getElementById('toast-container').innerHTML = "";

}