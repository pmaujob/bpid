var metaCount = 0;

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
                window.self.location = "../formularios/frm_meta_producto.php";
            }
        }
    });

}

function buscarProyectos() {
    var resultado = document.getElementById('resultado');
    //temporalmente
    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

    var valorBusqueda = document.getElementById("input_buscar").value;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmMetaProyecto.php',
        async: true,
        data: {value: valorBusqueda},
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

function insertarDatosPrograma() {

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

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarMetas.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, metas: selectedMetas},
        success: function (respuesta) {

            console.log(respuesta);

            if (respuesta == 1) {

            } else {

            }

        }, error: function () {
            alert("Error inesperado");
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