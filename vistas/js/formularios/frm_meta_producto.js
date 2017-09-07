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

function listarMetasProducto(idRad, filtrarDep, numProyecto) {

    $('#modalm').modal('open');
    
    alert("filtrarDep: "+filtrarDep);

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmMetas.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, filtrarDep: filtrarDep, numProyecto: numProyecto},
        success: function (respuesta) {

            document.getElementById('metaContainer').innerHTML = respuesta;

            $(document).ready(function () {
                $('select').material_select();
            });

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function mostrarSubprogramas(select) {

    displayControles('esperarSubprogramas', 'divSubprogramas', true);

    var selPro = document.getElementById(select);
    var value = selPro.options[selPro.selectedIndex].value;

    var divSubprogramas = document.getElementById('divSubprogramas');
    divSubprogramas.innerHTML = "";

    document.getElementById('divMetas').innerHTML = "";
    metaCount = 0;

    jQuery.ajax({
        type: 'POST',
        url: '../../modelo/CargarMetas.php',
        async: true,
        timeout: 0,
        data: {opConsulta: 1, idPrograma: value},
        success: function (respuesta) {

            var subArray = JSON.parse(respuesta);

            var lbl = document.createElement('span');
            lbl.innerHTML = "Seleccione el o los Subprograma(s) del proyecto:";
            divSubprogramas.appendChild(lbl);

            for (var i = 0; i < subArray.length; i++) {

                var subObject = subArray[i];
                var opt = document.createElement('p');
                opt.innerHTML = '<input type="checkbox" id="subProCheck' + subObject.cod + '" value="' + subObject.cod + '" onclick="buscarMetas(this,\'' + subObject.des + '\');" />'
                        + '<label for="subProCheck' + subObject.cod + '">' + subObject.des + '</label>';

                divSubprogramas.appendChild(opt);
            }

            displayControles('esperarSubprogramas', 'divSubprogramas', false);

        }, error: function () {
            alert("Error inesperado");
        }
    });
}

function displayControles(idLogo, idDivSelect, reiniciar) {

    document.getElementById(idLogo).style.display = (reiniciar ? "" : "none");
    document.getElementById(idDivSelect).style.display = (reiniciar ? "none" : "");

}

function buscarMetas(checkBox, subPrograma) {

    if (checkBox.checked) {

        displayControles('esperarMetas', 'divMetas', true);
        var divMetas = document.getElementById('divMetas');

        jQuery.ajax({
            type: 'POST',
            url: '../../modelo/CargarMetas.php',
            async: true,
            timeout: 0,
            data: {opConsulta: 2, idSubprograma: checkBox.value},
            success: function (respuesta) {

                var metaArray = JSON.parse(respuesta);

                var divMeta;
                if (document.getElementById('divMeta' + checkBox.value) == null) {
                    var divMeta = document.createElement('div');
                    divMeta.id = "divMeta" + checkBox.value;
                } else {
                    divMeta = document.getElementById('divMeta' + checkBox.value);
                }

                var subTit = document.createElement('label');
                subTit.innerHTML = subPrograma;
                divMeta.appendChild(subTit);

                for (var i = 0; i < metaArray.length; i++) {

                    var metaObject = metaArray[i];
                    var opt = document.createElement('p');
                    opt.innerHTML = '<input type="checkbox" id="metaCheck' + metaObject.cod + '" value="' + metaObject.cod + '" />'
                            + '<label for="metaCheck' + metaObject.cod + '">' + metaObject.des + '</label>';

                    divMeta.appendChild(opt);
                }

                if (metaCount == 0) {
                    var divTit = document.createElement('span');
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
        }

    }

}

function insertarDatosPrograma() {

    var codRadicacion = document.getElementById('idRad').value;
    var codPrograma = document.getElementById('selectProgramas').value;

    var divSubProgramas = document.getElementById('divSubprogramas');
    var subprogramaChecks = divSubProgramas.getElementsByTagName("input");

    var subprogramas = new Array();

    for (var i = 0; i < subprogramaChecks.length; i++) {
        var subCheck = subprogramaChecks[i];
        if (subCheck.checked) {
            subprogramas.push(subCheck.value);
        }
    }

    var metas = new Array();

    for (var i = 0; i < subprogramas.length; i++) {
        var divMetas = document.getElementById('divMeta' + subprogramas[i]);
        var metasChecks = divMetas.getElementsByTagName("input");

        for (var j = 0; j < metasChecks.length; j++) {
            var metaCheck = metasChecks[j];
            if (metaCheck.checked) {
                metas.push(metaCheck.value);
            }
        }

    }

    if (metas.lenght == 0) {
        console.log('Debe seleccionar una o más metas de producto');
        return;
    }

    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/RegistrarDatosPrograma.php',
        async: true,
        timeout: 0,
        data: {codRadicacion: codRadicacion, codPrograma: codPrograma, subprogramas: subprogramas, metas: metas},
        success: function (respuesta) {
                                   
            console.log(respuesta);

        }, error: function () {
            alert("Error inesperado");
        }
    });

}

function cerrar(){
    $('#modalm').modal('close');
}