var ced;

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

}

function buscarUsuarios() {

    value = document.getElementById('input_buscar').value;

    jQuery.ajax({
        type: 'POST',
        url: '../../../vistas/formulariosDinamicos/admin/frmUsuarios.php',
        async: true,
        data: {value: value},
        success: function (respuesta) {

            document.getElementById('respuesta').innerHTML = respuesta;
            //alert(respuesta);

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

}

function activar(cedula, id) {

    var estado;

    if (document.getElementById(id).checked)
        estado = true;
    else
        estado = false;

    jQuery.ajax({
        type: 'POST',
        url: '../../../controlador/CActualizarUsuario.php',
        async: true,
        data: {op: 1, cedula: cedula, estado: estado},
        success: function (respuesta) {

            if (estado == 0 && respuesta == 0)
                alert("El usuario no ha sido desactivado.");
            else if (estado == 1 && respuesta == 0)
                alert("El usuario no ha sido activado.");
            else if (estado == 0 && respuesta == 1)
                alert("El usuario ha sido desactivado.");
            else if (estado == 1 && respuesta == 1)
                alert("El usuario ha sido activado.");

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

}

function permisos(cedula) {
    
    ced = cedula;

    jQuery.ajax({
        type: 'POST',
        url: '../../../vistas/formulariosDinamicos/admin/frmPermisos.php',
        async: true,
        data: {op: 2, cedula: cedula},
        success: function (respuesta) {

            document.getElementById('funciones').innerHTML = respuesta;

            $('#modal1').modal('open');

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

}

function actualizarPermisosUsuario(cedula) {
    
    ced = cedula;

    var cont = document.getElementById('cont').value;
    var permisosRow = new Array();
    var j = 0;

    for (var i = 0; i < cont; i++) {
        if (document.getElementById('FUN' + i).checked) {
            var idPermiso = document.getElementById('IDFUN' + i).value;
            permisosRow[j] = idPermiso;
            j++;
        }
    }

    if (permisosRow.length > 0) {

        jQuery.ajax({
            type: 'POST',
            url: '../../../controlador/CActualizarUsuario.php',
            async: true,
            data: {op: 2 ,cedula: ced ,permisos: permisosRow},
            success: function (respuesta) {

                alert(respuesta);

                if (respuesta == "1") {
                    document.getElementById('d_error').innerHTML = "Los permisos del usuario se han creado con éxito";
                    $('#d_error').dialog("open");
                } else if(respuesta == "2"){
                    document.getElementById('d_error').innerHTML = "Los permisos del usuario no se han podido registrar intentelo de nuevo.";
                    $('#d_error').dialog("open");
                }else{
                    alert(respuesta);
                }
                
                console.log(respuesta);

                limpiarPermisos();

            },

            error: function () {
                alert("Error inesperado");
                window.top.location = "../index.html";
            }

        });

    } else {
        document.getElementById('d_error').innerHTML = "El usuario no tiene permisos, debe asignar por lo menos un permiso.";
        $('#d_error').dialog("open");
    }

}

function limpiarPermisos() {

    if (document.getElementById('cont')) {
        var cont = document.getElementById('cont').value;

        for (var i = 0; i < cont; i++) {
            document.getElementById('FUN' + i).checked = 0;
        }
    }

}