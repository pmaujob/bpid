function buscarCertificaciones(estado){
    
    
    value = document.getElementById("input_buscar").value;
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: value,op:estado},
        success: function (respuesta) {

            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });
    
}

function mas(codRadicacion,b,c){
    
    value = codRadicacion;
    direccion='../certificados/certificadoRadicar.php';
    window.open(direccion+'?value='+value);
   
}

