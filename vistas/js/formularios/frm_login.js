function ingresar() {

    getIp();
    //alert(getIpAddress());

    var ip = getIpAddress();
    var correo = document.getElementById("correo").value;
    var contrasena = document.getElementById("contrasena").value;

    jQuery.ajax({
        type: 'POST',
        url: 'controlador/Clogin.php',
        async: true,
        data: {ip: ip,correo: correo, contrasena: contrasena},
        success: function (respuesta) {
            
            if(respuesta === "Ok"){
                
                location.href = "vistas/index.php";
                
            }else if(respuesta === "No"){
                
                alert("El usuario o la contraseña son incorrectos intentelo de nuevo.");
                
            }else{
                
                alert("Error inesperado PHP");
                console.log("Error en bpida: " + respuesta);
                
            }

        },

        error: function () {
            alert("Error inesperado ajax");
            //window.top.location = "../index.html";
        }

    });

}