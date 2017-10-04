var idRad;

function onLoadBody() {

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

function buscarProyectos(op) {

    var resultado = document.getElementById('resultado');

    //temporalmente
    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

    value = document.getElementById("input_buscar").value;
    //bloquearPantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: value, op: op},
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

        }, error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}

function registrarCriterios() {

    var cont = document.getElementById('cont').value;
    var contDimensiones = document.getElementById('contDimensiones').value;

    var obsdimensiones = new Array();
    var criterios = new Array();

    for (var i = 0; i < contDimensiones; i++) {

        if (document.getElementById('OBS' + i).value !== "") {

            var obsdimen = new Array(2);

            obsdimen[0] = document.getElementById('IDDIMEN' + i).value;
            obsdimen[1] = document.getElementById('OBS' + i).value;

            obsdimensiones.push(obsdimen);

        }

    }

//    if(obsdimensiones.length < 1)
//        obsdimensiones = 'nohave';

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
        data: {idRad: idRad, preguntas: criterios, observaciones: obsdimensiones},
        success: function (respuesta) {
            
            alert(respuesta);
            console.log(respuesta);

            if (respuesta.trim() == "1") {
                document.getElementById('d_error').innerHTML = "Los criterios de viabilidad se han registrado con exito.";
                $('#d_error').dialog("open");
            } else {
                document.getElementById('d_error').innerHTML = "Los criterios de viabilidad no han podido ser registrados, por favor intentelo de nuevo mas tarde.";
                $('#d_error').dialog("open");
            }

        }, error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}