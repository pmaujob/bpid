function ingresar() {

    getIp();
    //alert(getIpAddress());

    var ip = getIpAddress();
    var correo = document.getElementById("correo").value;
    var contrasena = document.getElementById("contrasena").value;

    jQuery.ajax({
        type: 'POST',
        url: 'controlador/CLogin.php',
        async: true,
        data: {ip: ip,correo: correo, contrasena: contrasena},
        success: function (respuesta) {
            
            alert(respuesta);

//            if(respuesta=="Ok")
//                alert("inicio de sesion correcto");
//            else
//                alert("inicio de sesion incorrecto");

        },

        error: function () {
            alert("Error inesperado");
            //window.top.location = "../index.html";
        }

    });

}