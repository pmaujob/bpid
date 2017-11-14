loading = false;
selectedId = 0;
function onLoadBody() {

}

function buscarProyectos(idEtapa, event) {

    if (loading) {
        return;
    }

    var buscarValue = document.getElementById("input_buscar").value;
    if (buscarValue.toString().trim().length == 0) {
        return;
    }

    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    var esperarListas = document.getElementById('esperarListas');
    esperarListas.style.display = "";

    var resultado = document.getElementById('resultado');

    loading = true;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmCertificadosViabilidad.php',
        async: true,
        data: {value: buscarValue, op: idEtapa},
        success: function (respuesta) {
            resultado.innerHTML = '<p>' + respuesta + '</p>';
            esperarListas.style.display = "none";
            loading = false;
        },
        error: function () {
            alert("Error inesperado");
            loading = false;
        }
    });

}

function seleccionar(idRad, tipo) {
    
    document.getElementById('divCertificados').style.display = "";
    selectedId = idRad;
    
}

function creteCertificate(){
    
}


