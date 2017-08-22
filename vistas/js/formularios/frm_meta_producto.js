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
            window.top.location = "../index.html";
        }
    });
}

function listarMetasProducto(idRad, op, numProyecto) {

    $('#modalm').modal('open');

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmMetas.php',
        async: true,
        timeout: 0,
        data: {idRad: idRad, op: op, numProyecto: numProyecto},
        success: function (respuesta) {

            document.getElementById('metaContainer').innerHTML = respuesta;

            $(document).ready(function () {
                $('select').material_select();
            });

        }, error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
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
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });
}

function displayControles(idLogo, idDivSelect, reiniciar) {

    document.getElementById(idLogo).style.display = (reiniciar ? "" : "none");
    document.getElementById(idDivSelect).style.display = (reiniciar ? "none" : "");

}

function buscarMetas(checkBox, subPrograma) {
    
    console.log("entró con el id: "+checkBox.id)

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
                alert("Error inesperado")
                window.top.location = "../index.html";
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

    var codRadicacion;
    var codPrograma = document.getElementById('selectProgramas');

    var divSubProgramas = document.getElementById('divSubprogramas');
    var subprogramasChild = divSubProgramas.getElementsByTagName("p");
    
    var subprogramas = new Array();
    
    for (var i = 0; i < subprogramasChild.length; i++) {        
        var subCheck = subprogramasChild[i].getElementsByTagName('input');
        if (subCheck.checked) {
            subprogramas.push(subCheck.value);
        }
    }

    var metas = new Array();

    for (var i = 0; i < subprogramas.length; i++) {
        var divMetas = document.getElementById('divMeta' + subprogramas[i]);
        var metasChild = divMetas.getElementsByTagName("p");

        for (var i = 0; i < metasChild.length; i++) {
            var metaCheck = metasChild[i].getElementsByTagName('input');
            if (metaCheck.checked) {
                metas.push(metaCheck.value);
            }
        }

    }

    console.log("subprogramas: "+subprogramas.length+", metas: "+metas.length);

    /*jQuery.ajax({
        type: 'POST',
        url: '../../modelo/CargarMetas.php',
        async: true,
        timeout: 0,
        data: {codPrograma: codPrograma, idSubprograma: checkBox.value},
        success: function (respuesta) {

        }, error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });*/

}