var idRad;
var num;
var bp;

function onLoadBody() {

    buscarProyectos(6, null);

    $(document).ready(function () {
        $('.modal').modal();
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
    if (event != null && buscarValue.toString().trim().length == 0) {
        return;
    }

    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    var resultado = document.getElementById('resultado');
    var wait = document.getElementById('wait');

    resultado.style.display = "none";
    wait.style.display = "";

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: op},
        success: function (respuesta) {
            resultado.innerHTML = '<p>' + respuesta + '</p>';
        }, error: function () {
            alert("Error inesperado");
        }, complete: function () {
            resultado.style.display = "";
            wait.style.display = "none";
        }
    });
}

function mas(cod, bpid, numProyecto) {

    var container = document.getElementById('container');

    idRad = cod;
    bp = bpid;
    num = numProyecto;

    document.getElementById('collapsible').innerHTML = "<div style='text-align: center; margin-left: auto; margin-right: auto;'><img id='esperarListas' src='./../css/wait.gif' style='width: 275px; height: 174,5px;' ></div>";

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmDatosRegistro.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, bpid: bp, nump: num},
        success: function (respuesta) {

            container.innerHTML = "";
            container.innerHTML = respuesta;

            $('.collapsible').collapsible();
            $('select').material_select();

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function listarDatosRadicacion(idRad, numProyecto) {

    $('#modal1').modal('open');

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListarConsultaRad.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, numProyecto: numProyecto},
        success: function (respuesta) {

            document.getElementById('collapsible').innerHTML = respuesta;

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function registrar() {

    bloquear_pantalla();

    tipoReg = document.getElementById('tipo_reg').selectedIndex; //select
    conceptoPost = document.getElementById('concepto_post').selectedIndex; //select
    motivacion = document.getElementById('motivacion').value;
    archivo = document.getElementById('archivo').value; //file
    archivoText = document.getElementById('archivo_text').value; //texto file
    secretario = document.getElementById('secretario').selectedIndex; //select

    if (tipoReg != 0 && conceptoPost != 0 && motivacion !== "" && secretario != 0) {

        var formData = new FormData($("#frm_registro")[0]);
        $.ajax({
            url: '../../controlador/CRegistro.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {

                if (datos == 1) {
                    var mensaje = "Se han registrado los datos de registro con exito.";
                } else {
                    var mensaje = "Error al registrar los datos intentelo de nuevo.";
                }
                document.getElementById('d_error').innerHTML = '<p>' + mensaje + '</p>';
                $("#d_error").dialog("open");
                quitar_pantalla();

                if (datos == 1)
                    location.href = "../../vistas/formularios/frm_codigo_bpin.php";

            }
        });

    } else {
        var mensaje = "Error, Verifique que todos los campos esten diligenciados correctamente.";
        document.getElementById('d_error').innerHTML = '<p>' + mensaje + '</p>';
        $("#d_error").dialog("open");
        quitar_pantalla();
    }

}

function cerrar() {
    $('#modal1').modal('close');
}