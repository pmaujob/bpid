function onLoadBody() {

    buscarProyectosRadicados(-2, null);

    $(document).ready(function () {
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
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
                window.self.location = "../formularios/frm_consultar_radicacion.php";
            }
        }
    });

}

function buscarProyectosRadicados(op, event) {

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
        url: '../../vistas/formulariosDinamicos/frmConsultarRadicacion.php',
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
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}

function cerrar() {
    $('#modal1').modal('close');
}
