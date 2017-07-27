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

function mas(cod, bpid, numProyecto) {

    $('#modal1').modal('open');

    value = cod;
    var bpid = bpid;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListas.php',
        async: true,
        data: {value: value, bpid: bpid, numProyecto: numProyecto},
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
    var bpid = document.getElementById('bpid').value;
    var numProyecto = document.getElementById('numProyecto').value;        
    var nOpcionesReq = document.getElementById('nOpcionesReq').value;
    var nOpcionesSub = document.getElementById('nOpcionesSub').value;

    var reqData = new Array();
    var subData = new Array();
    var archivosReq = new Array();
    var archivosSub = new Array();

    for (var i = 1; i <= nOpcionesReq; i++) {
        var opcionSeleccionada = document.getElementById('REQ' + i).value;
        if (opcionSeleccionada != "NA") {

            var reqArchivo = document.getElementById('REQFILE' + i);
            if (document.getElementById('REQFILEOB' + i).value == 1 && reqArchivo.value == '') {
                alert('Se debe adjuntar un archivo en esta pregunta.');
                reqArchivo.focus();
                return;
            } else if (reqArchivo.value != '') {
                var archivoReqRow = new Array(2);
                archivoReqRow[0] = document.getElementById('REQH' + i).value;//id requisito
                archivoReqRow[1] = i;//posicion del contador para recorrer archivos más adelante
                archivosReq.push(archivoReqRow);
            }

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

            var subArchivo = document.getElementById('SUBFILE' + i);
            if (document.getElementById('SUBFILEOB' + i).value == 1 && subArchivo.value == '') {
                alert('Se debe adjuntar un archivo en esta pregunta.');
                subArchivo.focus();
                return;
            } else if (subArchivo.value != '') {
                var archivoSubRow = new Array(2);
                archivoSubRow[0] = document.getElementById('SUBH' + i).value;//id requisito
                archivoSubRow[1] = i;//posicion del contador para recorrer archivos más adelante
                archivosSub.push(archivoSubRow);
            }

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

            var frmListas = document.getElementById('frm_listas');

            var indicesArchivosReq = document.createElement("input");
            indicesArchivosReq.setAttribute("type", "hidden");
            indicesArchivosReq.setAttribute("name", "indicesArchivosReq");
            indicesArchivosReq.setAttribute("value", archivosReq);

            var indicesArchivosSub = document.createElement("input");
            indicesArchivosSub.setAttribute("type", "hidden");
            indicesArchivosSub.setAttribute("name", "indicesArchivosSub");
            indicesArchivosSub.setAttribute("value", archivosSub);

            var enviarBpid = document.createElement("input");
            enviarBpid.setAttribute("type", "hidden");
            enviarBpid.setAttribute("name", "bpid");
            enviarBpid.setAttribute("value", bpid);
            
            var enviarNumProyecto = document.createElement("input");
            enviarNumProyecto.setAttribute("type", "hidden");
            enviarNumProyecto.setAttribute("name", "numProyecto");
            enviarNumProyecto.setAttribute("value", numProyecto);

            frmListas.appendChild(indicesArchivosReq);
            frmListas.appendChild(indicesArchivosSub);
            frmListas.appendChild(enviarBpid);
            frmListas.appendChild(enviarNumProyecto);

            frmListas.submit();

            if (respuesta == 1) {

                alert("Las listas de chequeo se han actualizado con éxito.");

            } else {

                alert("No se pudo realizar la actualización, vuelva a intentarlo.");

            }
        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

    $('#modal1').modal('close');

}

function validarExtension(fileNombre) {

    var adjunto = document.getElementById(fileNombre);
    var extension = (adjunto.value.substring(adjunto.value.lastIndexOf("."))).toLowerCase();
    if (extension === '.php' || extension === '.js' || extension === '.sql' || extension === '.java' || extension === '.html' || extension === '.exe' || extension === '.bat') {
        alert("El formato del archivo adjunto no es válido.");
        adjunto.value = null;
        return;
    }

}