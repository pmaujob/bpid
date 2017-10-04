var proyectoActual = 0;
var collapsibleHtml = "";
var noCont = 0;
var tituloListaOld = "";
var tituloSublistaOld = "";
var $toastContent;

function onLoadBody() {


    buscarProyectos(1);
    $(document).ready(function () {

        $('.modal').modal({
            complete: function () {

                var toasts = new Array();

                if (document.getElementById('toast-container') != null) {
                    toasts = document.getElementById('toast-container').getElementsByTagName("div");
                }

                for (var i = toasts.length - 1; i >= 0; i--) {
                    toasts[i].parentNode.removeChild(toasts[i]);
                }

            }
        });

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
    if (value == '') {
        value = 'null';
    }

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
            mostrarMensaje('Error Inesperado', false);
        }
    });
}

function mas(cod, bpid, numProyecto) {

    $('#modal1').modal('open');

    if (collapsibleHtml == "") {
        collapsibleHtml = document.getElementById("collapsible").innerHTML;
    }

    if (proyectoActual == numProyecto) {
        return;
    } else {
        document.getElementById("collapsible").innerHTML = collapsibleHtml;
    }

    value = cod;
    var bpid = bpid;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmListas.php',
        async: true,
        timeout: 0,
        data: {value: value, bpid: bpid, numProyecto: numProyecto},
        success: function (respuesta) {
            document.getElementById('collapsible').innerHTML = respuesta;

            noCont = document.getElementById('noCont').value;
            focusear(document.getElementById('nOpcionesReq').value, document.getElementById('nOpcionesSub').value);

            $(document).ready(function () {
                $('.collapsible').collapsible();
            });

            proyectoActual = numProyecto;

        }, error: function () {
            mostrarMensaje('Error Inesperado', false);
            window.top.location = "../index.html";
        }
    });

}

function focusearTituloLista(idBodyLista) {
    $('#' + idBodyLista).focus();
}

function validar(enviarInfo) {

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
            var reqArchivo = document.getElementById('REQFILE' + i);

            if (opcionSeleccionada == "SI" && reqArchivoExist == "" && reqArchivo.value == '') {//preguntar si el archivo es obligatorio
                alert('Se debe adjuntar un archivo en esta pregunta.');
                reqArchivo.focus();
                return;
            } else if (opcionSeleccionada == "SI" && reqArchivo.value != '') {
                var archivoReqRow = new Array(2);
                archivoReqRow[0] = document.getElementById('REQH' + i).value;//id requisito
                archivoReqRow[1] = i;//posicion del contador para recorrer archivos más adelante
                archivosReq.push(archivoReqRow);
                console.log("Entró a guardar el archivo con la posicion: " + i + ", id: " + document.getElementById('REQH' + i).value);
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
                if (opcionSeleccionada == "SI" && document.getElementById('SUBFILEOB' + i).value == 1 && subArchivo.value == '') {
                    alert('Se debe adjuntar un archivo en esta pregunta.');
                    subArchivo.focus();
                    return;
                } else if (opcionSeleccionada == "SI" && subArchivo.value != '') {
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

    var waitGuardarProgreso = document.getElementById('waitGuardarProgreso');
    waitGuardarProgreso.style.display = "";
    
    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarListasChequeo.php',
        async: true,
        data: {idRad: idRad, reqData: reqData, subData: ((subData.length > 0) ? subData : null), noCont: (enviarInfo ? noCont : null)},
        success: function (respuesta) {

            if (respuesta == 1) {
                                
                var formData = new FormData($("#frm_listas")[0]);  //lo hago por la validacion
                $.ajax({
                    url: '../../controlador/ControladorArchivosRadicacion.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {

                        var fallidosReq = datos.split('|')[0];
                        var fallidosSub = datos.split('|')[1];
                        var alerta = "";

                        if (fallidosReq.trim() != "") {
                            alerta += "Los archivos fueron subidos con éxito.\n"
                                    + "Excepto los pertenecientes a los requisitos con los códigos: " + fallidosReq;
                        }

                        if (fallidosSub.trim() != "" && alerta == "") {
                            alerta += "Los archivos fueron subidos con éxito.\n"
                                    + "Excepto los pertenecientes a los subrequisitos con los códigos: " + fallidosSub;
                        } else if (fallidosSub.trim() != "" && alerta != "") {
                            alerta += "\nY los pertenecientes a los subrequisitos con los códigos: " + fallidosSub;
                        }

                        if (!enviarInfo) {

                            waitGuardarProgreso.style.display = "none";

                            var msjInfo = document.getElementById('msjInfo');
                            msjInfo.innerHTML = "Se ha guardado el progreso con éxito.";
                            msjInfo.style.display = "";

                            setTimeout(quitarEtiqueta, 3000);

                        } else if (enviarInfo && noCont > 0) {

                            noCont = 0;
                            $("#modal1").modal("close");

                            mostrarMensaje('Se ha guardado el progreso con éxito. Sin embargo, hay items sin aprobar, '
                                    + 'por lo tanto se enviará un informe a su correo registrado en bpid.', true);

                        } else if (enviarInfo && noCont == 0) {

                            $.ajax({
                                type: 'POST',
                                url: '../../controlador/RegistrarListasChequeo.php',
                                async: true,
                                data: {idRad: idRad, guardarEnviar: true},
                                success: function (respuesta2) {

                                    if (respuesta2) {
                                        mostrarMensaje('Su proyecto ha sido radicado con éxito.', true);
                                    } else {
                                        mostrarMensaje('No fue posible radicar el proyecto, sus cambios serán guardados.', false);
                                    }

                                }, error: function () {
                                    mostrarMensaje('No fue posible radicar el proyecto, sus cambios serán guardados.', false);
                                }
                            });

                            noCont = 0;
                            $("#modal1").modal("close");

                        }

                    }, error: function () {
                        mostrarMensaje('Se ha guardado el progreso con éxito, '
                                + 'pero hubo un error en la subida de archivos, vuelta a intentarlo.', true);
                    }
                });

            } else {

                console.log("no guardó nada: " + respuesta);

                waitGuardarProgreso.style.display = "none";

                var msjInfo = document.getElementById('msjInfo');
                msjInfo.innerHTML = "No se pudo guardar el progreso, vuelva a intentarlo.";
                msjInfo.style.color = "#e53935";
                msjInfo.style.wordBreak = "break-all";
                msjInfo.style.display = "";

            }
        },
        error: function () {
            mostrarMensaje('Error Inesperado', false);
            noCont = 0;
        }
    });

}

function validarExtension(fileNombre) {

    var adjunto = document.getElementById(fileNombre);
    var extension = (adjunto.value.substring(adjunto.value.lastIndexOf("."))).toLowerCase();
    if (extension === '.php' || extension === '.js' || extension === '.sql' || extension === '.java' || extension === '.html' || extension === '.exe' || extension === '.bat' || extension === '.css') {
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

function validarNo(idSelection) {

    var selection = document.getElementById(idSelection);

    if (selection.value == "NO") {
        noCont++;
    } else if (selection.value != "NO" && noCont > 0) {
        noCont--;
    }

    console.log("noCont: " + noCont);

}

function mostrarMensaje(mensaje, info) {
    if (info) {
        document.getElementById('d_ingreso').innerHTML = '<p>' + mensaje + '</p>';
        $("#d_ingreso").dialog("open");
    } else {
        document.getElementById('d_error').innerHTML = '<p>' + mensaje + '</p>';
        $("#d_error").dialog("open");
    }
}

function quitarEtiqueta() {
    document.getElementById('msjInfo').style.display = "none";
}

function cerrarModal() {

    $('#modal1').modal('close');
    document.getElementById('toast-container').innerHTML = "";

}

function mostrarTitulo(tituloLista) {

    var toasts = new Array();

    if (document.getElementById('toast-container') != null) {
        toasts = document.getElementById('toast-container').getElementsByTagName("div");
    }

    for (var i = toasts.length - 1; i >= 0; i--) {
        toasts[i].parentNode.removeChild(toasts[i]);
    }

    if (tituloListaOld == tituloLista) {
        tituloListaOld = "";
        return;
    }

    var tituloCut = "";
    if (tituloLista.length > 25) {
        tituloCut = tituloLista.substring(0, 25) + '...';
    }

    Materialize.toast((tituloCut == "" ? tituloLista : tituloCut), 500000);
    tituloListaOld = tituloLista;

    var toast = document.getElementById('toast-container').getElementsByTagName("div")[0];
    toast.style.background = "#008643";
    toast.style.fontWeight = "400";

}


function mostrarSubtitulo(tituloSublista) {

    var subToasts = document.getElementById('toast-container').getElementsByTagName("div");

    if (subToasts.length == 2) {
        subToasts[1].parentNode.removeChild(subToasts[1]);
    }

    if (tituloSublistaOld == tituloSublista) {
        tituloSublistaOld = "";
        return;
    }

    var subtituloCut = "";
    if (tituloSublista.length > 25) {
        subtituloCut = tituloSublista.substring(0, 25) + '...';
    }

    Materialize.toast((subtituloCut == "" ? tituloSublista : subtituloCut), 500000);
    tituloSublistaOld = tituloSublista;

    var subToast = document.getElementById('toast-container').getElementsByTagName("div")[1];
    subToast.style.color = "black";
    subToast.style.background = "white";
    subToast.style.fontWeight = "400";

}