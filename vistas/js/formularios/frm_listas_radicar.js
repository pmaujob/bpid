var proyectoActual = 0;
var collapsibleHtml = "";
var noCont = 0;
var tituloListaOld = "";
var tituloSublistaOld = "";
var $toastContent;

function onLoadBody() {

    buscarProyectos(1, null);

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

function buscarProyectos(op, event) {

    var buscarValue = document.getElementById("input_buscar").value;
    if (event != null && buscarValue.toString().trim().length == 0) {
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

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: op},
        success: function (respuesta) {
            resultado.innerHTML = '<p>' + respuesta + '</p>';
        },
        error: function () {
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

            document.getElementById('modale').style.display = "block";
            document.getElementById('modalg').style.display = "block";

            proyectoActual = numProyecto;

        }, error: function () {
            mostrarMensaje('Error Inesperado', false);
        }
    });

}

function focusearTituloLista(idBodyLista) {
    $('#' + idBodyLista).focus();
}

function validar(enviarInfo) {

    if (document.getElementById('nOpcionesReq') == null) {
        msjInforme("No se han cargado los complementos", true);
        return;
    }

    var idRad = document.getElementById('idRad').value;
    var nOpcionesReq = document.getElementById('nOpcionesReq').value;
    var nOpcionesSub = document.getElementById('nOpcionesSub').value;
    var totalArchivosReq = document.getElementById('totalArchivosReq');
    var totalArchivosSub = document.getElementById('totalArchivosSub');
    var numeroProyecto = document.getElementById('numProyecto').value;

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

                msjInforme("Debe adjuntar un archivo a este item.", true);

                $('.collapsible').collapsible({
                    accordion: false,
                    onOpen: function (el) {
                        document.getElementById('REQFILE' + i).focus();
                    }
                });

                if (reqArchivo.getAttribute('data-listFatherId') != null && reqArchivo.getAttribute('data-listFatherId') != "" && !$("#" + reqArchivo.getAttribute('data-listFatherId')).hasClass("active")) {
                    document.getElementById(reqArchivo.getAttribute('data-listFatherId')).click();
                }

                if (!$("#" + reqArchivo.getAttribute('data-listId')).hasClass("active")) {
                    document.getElementById(reqArchivo.getAttribute('data-listId')).click();
                }

                document.getElementById('REQFILE' + i).parentElement.className += " red";

                return;

            } else if (opcionSeleccionada == "SI" && reqArchivo.value != '') {
                var archivoReqRow = new Array(2);
                archivoReqRow[0] = document.getElementById('REQH' + i).value;//id requisito
                archivoReqRow[1] = i;//posicion del contador para recorrer archivos más adelante
                archivosReq.push(archivoReqRow);
            }

            var reqRow = new Array(4);
            reqRow[0] = document.getElementById('REQH' + i).value;//id requisito
            reqRow[1] = document.getElementById('REQ' + i).value;//opción seleccionada        
            reqRow[2] = document.getElementById('REQOBS' + i).value.trim();//observación    
            reqRow[3] = document.getElementById('REQDES' + i).innerHTML.trim();//descripción
            reqRow[4] = reqArchivo.getAttribute('data-listName');//nombre Lista

            reqData.push(reqRow);
        }

    }

    if (reqData.length == 0) {
        msjInforme("Debe realizar cambios la lista general para continuar.", true);
        return;
    }

    for (var i = 1; i <= nOpcionesSub; i++) {
        var opcionSeleccionada = document.getElementById('SUB' + i).value;
        if (opcionSeleccionada != "NA") {

            var subArchivoExist = document.getElementById('SUBFILEEXIST' + i).value;
            var subArchivo = document.getElementById('SUBFILE' + i);

            if (opcionSeleccionada == "SI" && subArchivoExist == "" && subArchivo.value == '') {

                msjInforme("Debe adjuntar un archivo a este item.", true);

                $('.collapsible').collapsible({
                    accordion: false,
                    onOpen: function (el) {
                        document.getElementById('SUBFILE' + i).focus();
                    }
                });

                if (!$("#" + reqArchivo.getAttribute('data-listGFatherId')).hasClass("active")) {
                    document.getElementById(subArchivo.getAttribute('data-listGFatherId')).click();
                }

                if (!$("#" + reqArchivo.getAttribute('data-listFatherId')).hasClass("active")) {
                    document.getElementById(subArchivo.getAttribute('data-listFatherId')).click();
                }

                if (!$("#" + reqArchivo.getAttribute('data-listId')).hasClass("active")) {
                    document.getElementById(subArchivo.getAttribute('data-listId')).click();
                }
                
                document.getElementById('SUBFILE' + i).parentElement.className += " red";

                return;

            } else if (opcionSeleccionada == "SI" && subArchivo.value != '') {
                var archivoSubRow = new Array(2);
                archivoSubRow[0] = document.getElementById('SUBH' + i).value;//id requisito
                archivoSubRow[1] = i;//posicion del contador para recorrer archivos más adelante
                archivosSub.push(archivoSubRow);
            }

            var subRow = new Array(4);
            subRow[0] = document.getElementById('SUBH' + i).value;//id subequisito
            subRow[1] = document.getElementById('SUB' + i).value;//opcion seleccionada
            subRow[2] = document.getElementById('SUBOBS' + i).value.trim();//observacion
            subRow[3] = document.getElementById('SUBDES' + i).innerHTML.trim();//descripción
            subRow[4] = subArchivo.getAttribute('data-listName');//nombre subLista            
            subRow[5] = subArchivo.getAttribute('data-listFatherName');//nombre Lista Padre

            subData.push(subRow);
        }

    }

    totalArchivosReq.value = archivosReq;
    totalArchivosSub.value = archivosSub;

    var waitGuardarProgreso = document.getElementById('waitGuardarProgreso');
    waitGuardarProgreso.style.display = "";

    disBotones(false);

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarListasChequeo.php',
        async: true,
        data: {numeroProyecto: numeroProyecto, idRad: idRad, reqData: reqData, subData: ((subData.length > 0) ? subData : null), noCont: (enviarInfo ? noCont : null)},
        success: function (respuesta) {

            if (respuesta == 1) {

                var formData = new FormData($("#frm_listas")[0]);
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
                            msjInforme("Se ha guardado el progreso con éxito.", false);

                            disBotones(true);

                        } else if (enviarInfo && noCont > 0) {
                            mostrarMensaje('Se ha guardado el progreso con éxito. Sin embargo, hay items sin aprobar, '
                                    + 'por lo tanto se enviará un informe a su correo registrado en bpid.', true);

                            noCont = 0;
                            $("#modal1").modal("close");

                            disBotones(true);

                        } else if (enviarInfo && noCont == 0) {

                            $.ajax({
                                type: 'POST',
                                url: '../../controlador/RegistrarListasChequeo.php',
                                async: true,
                                data: {idRad: idRad, guardarEnviar: true},
                                success: function (respuesta2) {

                                    if (respuesta2) {

                                        document.getElementById('d_ingreso').innerHTML = '<p>Su proyecto ha sido radicado con éxito.</p>';
                                        $("#d_ingreso").dialog({
                                            autoOpen: false,
                                            modal: true,
                                            buttons: {
                                                "Aceptar": function () {
                                                    $(this).dialog("close");
                                                    location.href = "../formularios/frm_consultar_radicacion.php";
                                                }
                                            }
                                        });
                                        $("#d_ingreso").dialog("open");
                                    } else {
                                        mostrarMensaje('No fue posible radicar el proyecto, sus cambios serán guardados.', false);
                                    }

                                    noCont = 0;
                                    $("#modal1").modal("close");

                                    disBotones(true);

                                }, error: function () {
                                    mostrarMensaje('No fue posible radicar el proyecto, sus cambios serán guardados.', false);
                                    $("#modal1").modal("close");
                                    disBotones(true);
                                }
                            });
                        }

                    }, error: function () {

                        mostrarMensaje('Se ha guardado el progreso con éxito, '
                                + 'pero hubo un error en la subida de archivos, vuelta a intentarlo.', true);
                        $("#modal1").modal("close");

                        disBotones(true);
                    }
                });

            } else {

                waitGuardarProgreso.style.display = "none";
                msjInforme("No se pudo guardar el progreso<br>vuelva a intentarlo.", true);
                disBotones(true);

            }

        },
        error: function () {
            mostrarMensaje('Error Inesperado', false);
            $("#modal1").modal("close");
            noCont = 0;
            disBotones(true);
        }
    });

}

function validarExtension(fileNombre) {

    var adjunto = document.getElementById(fileNombre);
    var extension = (adjunto.value.substring(adjunto.value.lastIndexOf("."))).toLowerCase();
    if (extension === '.php' || extension === '.js' || extension === '.sql' || extension === '.java' || extension === '.html' || extension === '.exe' || extension === '.bat' || extension === '.css') {

        msjInforme("El formato del archivo adjunto no es válido", true);
        adjunto.value = null;
        return;
    } else{
        document.getElementById(fileNombre).parentElement.classList.remove("red");
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
        $("#d_ingreso").dialog('open');
    } else {
        document.getElementById('d_error').innerHTML = '<p>' + mensaje + '</p>';
        $("#d_error").dialog("open");
    }
}

function msjInforme(msj, error) {

    var msjInfo = document.getElementById('msjInfo');

    msjInfo.innerHTML = msj;
    msjInfo.style.color = error ? "#E53935" : "#000000";
    msjInfo.style.display = "";

    setTimeout(quitarEtiqueta, 3000);

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

    Materialize.toast((tituloCut == "" ? tituloLista : tituloCut));
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

    Materialize.toast((subtituloCut == "" ? tituloSublista : subtituloCut));
    tituloSublistaOld = tituloSublista;

    var subToast = document.getElementById('toast-container').getElementsByTagName("div")[1];
    subToast.style.color = "black";
    subToast.style.background = "white";
    subToast.style.fontWeight = "400";

}

function disBotones(disabled) {
    document.getElementById("modalg").style.pointerEvents = disabled ? "" : "none";
    document.getElementById("modale").style.pointerEvents = disabled ? "" : "none";

    console.log(disabled ? "Habilitó" : "Deshabilitó");
}