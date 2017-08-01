
var cedula;
var nombre;
var apellido;
var correo;
var dependencia;

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

function validar() {

    cedula = document.getElementById('frm_cedula').value;

    nombre = '';
    apellido = '';
    correo = '';
    dependencia = '';

    document.getElementById('btn_permisos').disabled = true;

    document.getElementById('frm_correo').value = '';
    document.getElementById('frm_nombre').value = '';
    document.getElementById('frm_apellido').value = '';
    document.getElementById('frm_dependencia').value = '';

    jQuery.ajax({
        type: 'POST',
        url: '../../../controlador/CGetDatosUsuario.php',
        async: true,
        data: {cedula: cedula},
        success: function (respuesta) {

            if (respuesta == "EBPID")
                document.getElementById('respuesta').innerHTML = "El usuario con la cédula numero " + cedula + " ya existe en la base de datos de bpid.";
            else if (respuesta == "NEG")
                document.getElementById('respuesta').innerHTML = "El usuario con la cédula numero " + cedula + " no existe en la base de datos de la gobernación.";
            else {
                var content = JSON.parse(respuesta);
                document.getElementById('frm_correo').value = content.correo;
                document.getElementById('frm_correo').focus();
                document.getElementById('frm_nombre').value = content.nombres;
                document.getElementById('frm_nombre').focus();
                document.getElementById('frm_apellido').value = content.apellidos;
                document.getElementById('frm_apellido').focus();
                document.getElementById('frm_dependencia').value = content.dependencia;
                document.getElementById('frm_dependencia').focus();

                document.getElementById('respuesta').innerHTML = "Debe asignarle permisos";

                nombre = document.getElementById('frm_nombre').value;
                apellido = document.getElementById('frm_apellido').value;
                correo = document.getElementById('frm_correo').value;
                dependencia = document.getElementById('frm_dependencia').value;

                document.getElementById('btn_permisos').disabled = false;

                document.getElementById('frm_cedula').focus();

                //limpiarPermisos();

            }

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

}

function permisos() {

    jQuery.ajax({
        type: 'POST',
        url: '../../../vistas/formulariosDinamicos/admin/frmPermisos.php',
        async: true,
        success: function (respuesta) {

            document.getElementById('funciones').innerHTML = respuesta;

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

    limpiarPermisos();

    $('#modal1').modal('open');

}

function registrarUsuario() {

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
            url: '../../../controlador/CCrearUsuario.php',
            async: true,
            data: {cedula: cedula, nombre: nombre, apellido: apellido, correo: correo, dependencia: dependencia, permisos: permisosRow},
            success: function (respuesta) {

                if (respuesta == "1") {
                    document.getElementById('d_error').innerHTML = "El usuario ha sido creado con éxito";
                    $('#d_error').dialog("open");
                } else {
                    document.getElementById('d_error').innerHTML = "El usuario no ha podido crear intentelo de nuevo.";
                    $('#d_error').dialog("open");
                }

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

    var cont = document.getElementById('cont').value;

    for (var i = 0; i < cont; i++) {
        document.getElementById('FUN' + i).checked = 0;
    }

}