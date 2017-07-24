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
            
            if(respuesta === "Ok"){
                
                location.href = "vistas/index.php";
                
            }else{
                
                alert("El usuario o la contraseña son incorrectos intentelo de nuevo.");
                
            }

        },

        error: function () {
            alert("Error inesperado");
            //window.top.location = "../index.html";
        }

    });

}