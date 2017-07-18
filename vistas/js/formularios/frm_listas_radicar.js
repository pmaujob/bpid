function onLoadBody() {

    $(document).ready(function () {
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
    });
    
    $('.REQOBS').trigger('autoresize');

}

function buscarProyectos() {

    value = document.getElementById("input_buscar").value;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: value},
        success: function (respuesta) {

            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });

}

function mas(cod) {

    $('#modal1').modal('open');

    value = cod;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListas.php',
        async: true,
        data: {value: value},
        success: function (respuesta) {

            document.getElementById('collapsible').innerHTML = respuesta;

            $(document).ready(function () {
                $('.collapsible').collapsible();
            });

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}

function validar() {

    if (document.getElementById('nOpcionesReq') == null) {
        return;
    }

    var idRad = document.getElementById('idRad').value;
    var nOpcionesReq = document.getElementById('nOpcionesReq').value;
    var nOpcionesSub = document.getElementById('nOpcionesSub').value;

    var reqData = new Array();
    var subData = new Array();

    for (var i = 1; i <= nOpcionesReq; i++) {
        var opcionSeleccionada = document.getElementById('REQ' + i).value;
        if (opcionSeleccionada != "NA") {
            var reqRow = new Array(3);
            reqRow[0] = document.getElementById('REQH' + i).value;//id requisito
            reqRow[1] = document.getElementById('REQ' + i).value;//opción seleccionada        
            reqRow[2] = document.getElementById('REQOBS' + i).value;//observación
            reqData.push(reqRow);
        }
    }

    if (reqData.length == 0) {        
        alert("Debe cambiar el estado de al menos 1 item de la Lista General para guardar cambios.");        
        return;
    }

    for (var i = 1; i <= nOpcionesSub; i++) {
        var opcionSeleccionada = document.getElementById('SUB' + i).value;
        if (opcionSeleccionada != "NA") {
            var subRow = new Array(3);
            subRow[0] = document.getElementById('SUBH' + i).value;//id subequisito
            subRow[1] = document.getElementById('SUB' + i).value;//opcion seleccionada
            subRow[2] = document.getElementById('SUBOBS' + i).value;//observacion
            subData.push(subRow);
        }
    }

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarListasChequeo.php',
        async: true,
        data: {idRad: idRad, reqData: reqData, subData: ((subData.length > 0) ? subData : null)},
        success: function (respuesta) {

            alert((respuesta == 1) ? "Las listas de chequeo se han actualizado con éxito." : "No se pudo realizar la actualización, vuelva a intentarlo.");

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });
    
    $('#modal1').modal('close');

}