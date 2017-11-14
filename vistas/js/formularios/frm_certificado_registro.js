function buscarCertificaciones(estado, event) {
    
    var buscarValue = document.getElementById("input_buscar").value;
    if (buscarValue.toString().trim().length == 0) {
        return;
    }

    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: estado},
        success: function (respuesta) {

            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });

}

function mas(codRadicacion, codBpid, c) {


    value = codBpid;
    direccion = '../certificados/certificadoRadicar.php';
    window.open(direccion + '?value=' + value);

}

