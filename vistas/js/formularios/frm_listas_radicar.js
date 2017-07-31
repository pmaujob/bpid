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
                window.self.location = "../formularios/frm_radicar.php";
            }
        }
    });

}
function bloquearPantalla() {
    document.getElementById("dialogCargando").style.display = "block";    
    document.body.style.overflow = "hidden";
}

function quitarPantalla() {
    document.getElementById("dialogCargando").style.display = "none";
    document.body.style.overflow = "scroll";
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
            document.getElementById('resultado').innerHTML = '<p>' + respuesta + '</p>';


        },

        error: function () {
            //quitarPantalla();
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });

}

function mas(cod, bpid, numProyecto) {

    $('#modal1').modal('open');

    value = cod;
    var bpid = bpid;
    //bloquear_pantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListas.php',
        async: true,
        data: {value: value, bpid: bpid, numProyecto: numProyecto},
        success: function (respuesta) {
            document.getElementById('collapsible').innerHTML = respuesta;
            focusear(document.getElementById('nOpcionesReq').value, document.getElementById('nOpcionesSub').value);

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
        console.log("No se han cargado los complementos");
        return;
    }

    var idRad = document.getElementById('idRad').value;
    var nOpcionesReq = document.getElementById('nOpcionesReq').value;
    var nOpcionesSub = document.getElementById('nOpcionesSub').value;
    var totalArchivosReq = document.getElementById('totalArchivosReq');
    var totalArchivosSub = document.getElementById('totalArchivosSub');

    var reqData = new Array();
    var subData = new Array();
    var archivosReq = new Array();
    var archivosSub = new Array();

    for (var i = 1; i <= nOpcionesReq; i++) {
        var opcionSeleccionada = document.getElementById('REQ' + i).value;
        if (opcionSeleccionada != "NA") {

            var reqArchivoExist = document.getElementById('REQFILEEXIST' + i).value;
            if (reqArchivoExist == "") {//para evitar error de elemento para subir archivos
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
            }

            var reqRow = new Array(3);
            reqRow[0] = document.getElementById('REQH' + i).value;//id requisito
            reqRow[1] = document.getElementById('REQ' + i).value;//opción seleccionada        
            reqRow[2] = document.getElementById('REQOBS' + i).value.trim();//observación

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

            var subArchivoExist = document.getElementById('SUBFILEEXIST' + i).value;
            if (subArchivoExist == "") {//para evitar error de elemento para subir archivos

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

            }

            var subRow = new Array(3);
            subRow[0] = document.getElementById('SUBH' + i).value;//id subequisito
            subRow[1] = document.getElementById('SUB' + i).value;//opcion seleccionada
            subRow[2] = document.getElementById('SUBOBS' + i).value.trim();//observacion
            subData.push(subRow);
        }
    }

    totalArchivosReq.value = archivosReq;
    totalArchivosSub.value = archivosSub;

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarListasChequeo.php',
        async: true,
        data: {idRad: idRad, reqData: reqData, subData: ((subData.length > 0) ? subData : null)},
        success: function (respuesta) {

            if (respuesta == 1) {
                var formData = new FormData($("#frm_listas")[0]);  //lo hago por la validacion
                $.ajax({
                    url: '../../controlador/ControladorArchivosRadicacion.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos)
                    {
                        var fallidosReq = datos.split('|')[0];
                        var fallidosSub = datos.split('|')[1];

                        console.log("fallidosReq: " + fallidosReq + ", fallidosSub: " + fallidosSub);

                        var alerta = "";

                        if (fallidosReq.trim() != "") {
                            alerta += "Los archivos fueron subidos con éxito.\n"
                                    + "Excepto los pertenecientes a los requisitos con los códigos: " + fallidosReq;
                        }

                        if (fallidosSub.trim() != "" && alerta == "") {
                            alerta += "Los archivos fueron subidos con éxito.\n"
                                    + "Excepto los pertenecientes a los subrequisitos con los códigos: " + fallidosSub;
                        } else if (fallidosSub.trim() != "" && alerta != "") {
                            alerta += "\nY los pertenecientes a los subrequisitos con los coódigos: " + fallidosSub;
                        }

                        // alert("Se actualizaron las listas con éxito.\n"+alerta);
                        document.getElementById('d_ingreso').innerHTML = '<p>Se actualizaron las listas con éxito ' + alerta + '</p>';
                        $("#d_ingreso").dialog("open");

                    }
                });

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

function focusear(nOpcionesReq, nOpcionesSub) {

    for (var i = 1; i <= nOpcionesReq; i++) {
        if (document.getElementById('REQOBSLBL' + i) != null && document.getElementById('REQOBS' + i).value != "") {
            document.getElementById('REQOBS' + i).focus();
            document.getElementById('REQOBSLBL' + i).setAttribute("class", "active");
        }
    }

    for (var i = 1; i <= nOpcionesSub; i++) {
        if (document.getElementById('SUBOBSLBL' + i) != null && document.getElementById('SUBOBS' + i).value != "") {
            document.getElementById('SUBOBS' + i).focus();
            document.getElementById('SUBOBSLBL' + i).setAttribute("class", "active");
        }
    }

}