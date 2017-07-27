
var cedula;
var nombre;
var apellido;
var correo;
var dependencia;
var contrasena;

function validar() {

    cedula = document.getElementById('frm_cedula').value;

    nombre = '';
    apellido = '';
    correo = '';
    dependencia = '';

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
                console.log("Respuesta: " + respuesta);
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

            }

        },

        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });

}

function registrarUsuario(){
    
    
    
}