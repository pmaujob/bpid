function onLoadBody() {

    buscarCertificaciones(-7, null);

}

function buscarCertificaciones(estado, event) {

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
        data: {value: buscarValue, op: estado},
        success: function (respuesta) {

            resultado.innerHTML = '<p>' + respuesta + '</p>';

        },error: function () {
            alert("Error inesperado");
        }, complete: function () {
            resultado.style.display = "";
            wait.style.display = "none";
        }

    });

}

function mas(codRadicacion, codBpid, c) {


    value = codRadicacion;
    direccion = '../certificados/certificadoRegistro.php';
    window.open(direccion + '?idRad=' + value + '&codBpid=' + codBpid);

}

