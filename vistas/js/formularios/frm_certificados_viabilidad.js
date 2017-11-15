loading = false;
selectedId = 0;
certType = 0;
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

function seleccionar(idRad, tipo, rowId) {

    var contRow = document.getElementById("contRow").value;

    for (var i = 1; i <= contRow; i++) {

        document.getElementById("cerRow" + i).style.backgroundColor = "";

    }

    document.getElementById('divCertificados').style.display = "";
    document.getElementById('txtCertificate').innerHTML = tipo == 'A' ? "Certificado de NO Viabilidad" : "Certificado de Viabilidad";
    document.getElementById(rowId).style.backgroundColor = "#D2D2D2";
    selectedId = idRad;
    certType = tipo;

}

function creteCertificate() {

    var mapForm = document.createElement("form");
    mapForm.target = "Map";
    mapForm.method = "POST";
    mapForm.action = certType == 'R' ? "../certificados/certificadoViabilidad.php" : "../certificados/certificadoNoViabilidad.php";

    var idInput = document.createElement("input");
    idInput.type = "text";
    idInput.name = "idRad";
    idInput.value = selectedId;
    mapForm.appendChild(idInput);

    document.body.appendChild(mapForm);
    mapForm.submit();

}


