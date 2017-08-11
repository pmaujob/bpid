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
    
    if(document.getElementById(id).checked)
        estado = true;
    else
        estado = false;

    jQuery.ajax({
        type: 'POST',
        url: '../../../controlador/CActualizarUsuario.php',
        async: true,
        data: {op: 1, cedula: cedula, estado: estado},
        success: function (respuesta) {
            
            if(estado == 0 && respuesta == 0)
                alert("El usuario no ha sido desactivado.");
            else if(estado == 1 && respuesta == 0)
                alert("El usuario no ha sido activado.");
            else if(estado == 0 && respuesta == 1)
                alert("El usuario ha sido desactivado.");
            else if(estado == 1 && respuesta == 1)
                alert("El usuario ha sido activado.");

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });

}

function permisos(cedula){
    
        jQuery.ajax({
        type: 'POST',
        url: '../../../vistas/formulariosDinamicos/admin/frmPermisos.php',
        async: true,
        data: {cedula: cedula},
        success: function (respuesta) {
            
            document.getElementById('funciones').innerHTML = respuesta;

        },

        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }

    });
    
}