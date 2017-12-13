var metaCount = 0;

function onLoadBody() {
    
    buscarProyectos(2, null);
    
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
                location.href = "../formularios/frm_viabilidad.php";
            }
        }
    });

}

function buscarProyectos(idEtapa, event) {

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
        url: '../../vistas/formulariosDinamicos/frmMetaProyecto.php',
        async: true,
        data: {value: buscarValue, op: idEtapa},
        success: function (respuesta) {
            //quitarPantalla();                       
            resultado.innerHTML = '<p>' + respuesta + '</p>';
        },
        error: function () {
            //quitarPantalla();
            alert("Error inesperado");
        }
    });
}

function listarMetasProducto(idRad, filtrarSec, numProyecto) {

    $('#modalm').modal('open');

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmMetas.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, filtrarSec: filtrarSec, numProyecto: numProyecto},
        success: function (respuesta) {

            document.getElementById('metaContainer').innerHTML = respuesta;
            var filtrarSec = document.getElementById('idFiltrarSec').value;

            if (filtrarSec == 1) {
                var idSec = document.getElementById('idSec').value;
                traerMetas(idSec);
            }

            $(document).ready(function () {
                $('select').material_select();
            });

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function traerMetas(idSec) {

    displayControles('esperarMetas', 'divMetas', true);
    var divMetas = document.getElementById('divMetas');
    var idRad = document.getElementById('idRad').value;

    jQuery.ajax({
        type: 'POST',
        url: '../../modelo/CargarMetas.php',
        async: true,
        timeout: 0,
        data: {idSecretaria: idSec, idRad: idRad},
        success: function (respuesta) {

            var metaArray = JSON.parse(respuesta);

            var divTit = document.createElement('span');
            divTit.id = "divTit";
            divTit.innerHTML = "Seleccione las Metas de Producto:";
            divMetas.appendChild(divTit);

            for (var i = 0; i < metaArray.length; i++) {

                var metaObject = metaArray[i];


                var opt = document.createElement('p');
                opt.innerHTML = '<input type="checkbox" id="metaCheck' + metaObject.cod + '" value="' + metaObject.cod + '" ' + (metaObject.cr == 1 ? 'checked' : '') + ' />'
                        + '<label for="metaCheck' + metaObject.cod + '" style="color: #000000; "><span style="color: #008643; font-weight: bold;">' + metaObject.nums + '</span> - ' + metaObject.des + '</label>';

                divMetas.appendChild(opt);

            }

            displayControles('esperarMetas', 'divMetas', false);

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function buscarMetas(checkBox, secretaria) {

    if (checkBox.checked) {

        displayControles('esperarMetas', 'divMetas', true);
        var divMetas = document.getElementById('divMetas');

        jQuery.ajax({
            type: 'POST',
            url: '../../modelo/CargarMetas.php',
            async: true,
            timeout: 0,
            data: {idSecretaria: checkBox.value},
            success: function (respuesta) {

                var metaArray = JSON.parse(respuesta);

                var divMeta;
                if (document.getElementById('divMeta' + checkBox.value) == null) {
                    var divMeta = document.createElement('div');
                    divMeta.id = "divMeta" + checkBox.value;
                } else {
                    divMeta = document.getElementById('divMeta' + checkBox.value);
                }

                var secTit = document.createElement('label');
                secTit.innerHTML = secretaria;
                divMeta.appendChild(secTit);

                for (var i = 0; i < metaArray.length; i++) {

                    var metaObject = metaArray[i];
                    var opt = document.createElement('p');
                    opt.innerHTML = '<input type="checkbox" id="metaCheck' + metaObject.cod + '" value="' + metaObject.cod + '" />'
                            + '<label for="metaCheck' + metaObject.cod + '" style="color: #000000;"><span style="color: #008643; font-weight: bold;">' + metaObject.nums + '</span> - ' + metaObject.des + '</label>';

                    divMeta.appendChild(opt);
                }

                if (metaCount == 0) {
                    var divTit = document.createElement('span');
                    divTit.id = "divTit";
                    divTit.innerHTML = "Seleccione las Metas de Producto:";
                    divMetas.appendChild(divTit);
                }

                divMetas.appendChild(divMeta);
                metaCount++;
                displayControles('esperarMetas', 'divMetas', false);

            }, error: function () {
                alert("Error inesperado");
            }
        });

    } else {

        var selectedDiv = document.getElementById('divMeta' + checkBox.value);
        selectedDiv.innerHTML = "";
        metaCount--;

        if (metaCount == 0) {
            document.getElementById('divMetas').style.display = "none";
            document.getElementById('divTit').innerHTML = "";
        }

    }

}

function insertarMetas() {

    var selectedMetas = new Array();
    var idRad = document.getElementById('idRad').value;
    var itemList = document.getElementById('divMetas');
    var metaArray = itemList.getElementsByTagName('p');

    for (var i = 0; i < metaArray.length; i++) {
        var metaCheck = metaArray[i].getElementsByTagName('input');

        if (metaCheck[0].checked) {
            selectedMetas.push(metaCheck[0].value);
        }
    }

    disBotones(false);

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarMetas.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, metas: selectedMetas},
        success: function (respuesta) {

            if (respuesta == 1) {

                $("#modalm").modal("close");
                document.getElementById('d_ingreso').innerHTML = '<p>Las metas guardaron con éxito. Será redirigido a la siguiente etapa.</p>';
                $("#d_ingreso").dialog("open");

            } else {
                document.getElementById('d_error').innerHTML = '<p>No se pudo guardar los cambios, por favor intentelo nuevamente.</p>';
                $("#d_error").dialog("open");
                console.log("Error: " + respuesta);
            }

            disBotones(true);

        }, error: function () {
            alert("Error inesperado");
            disBotones(true);
        }
    });

}

function displayControles(idLogo, idDivSelect, reiniciar) {

    document.getElementById(idLogo).style.display = (reiniciar ? "" : "none");
    document.getElementById(idDivSelect).style.display = (reiniciar ? "none" : "");

}

function cerrar() {
    $('#modalm').modal('close');
}

function disBotones(disabled) {
    document.getElementById("modalg").style.pointerEvents = disabled ? "" : "none";
}