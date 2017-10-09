function onLoadBody() {
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

function buscarProyectosRadicados(op,event) {
    
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
    
    var valorBusqueda = document.getElementById("input_buscar").value;
    
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmConsultarRadicacion.php',
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

function listarDatosRadicacion(idRad,numProyecto){
    
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

function cerrar(){
    $('#modal1').modal('close');
}
