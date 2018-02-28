function onLoad() {

    document.getElementById('logoc').style.bottom = "0";

}

function ingresar(event) {

    if (event != null && event.keyCode != 13) {
        return;
    }

    //getIp();

    //var ip = getIpAddress();
    var correo = document.getElementById("correo").value;
    var contrasena = document.getElementById("contrasena").value;

    if (correo == "" || contrasena == "") {

        Materialize.toast("Los campos no pueden estar vacios.", 3000, "bluemp");

    } else {

        jQuery.ajax({
            type: 'POST',
            url: 'controlador/Clogin.php',
            async: true,
            data: {ip: '127.0.0.1', correo: correo, contrasena: contrasena},
            success: function (respuesta) {

                if (respuesta === "Ok") {

                    location.href = "vistas/index.php";

                } else if (respuesta === "No") {

                    Materialize.toast("El Usuario o la contraseña son incorrectos.", 3000, "green-toast");


                } else {

                    Materialize.toast("Error inesperado .", 3000, "bluemp");
                    console.log("Error en bpida: " + respuesta);

                }

            },

            error: function () {
                Materialize.toast("Error inesperado .", 3000, "bluemp");
            }

        });
    }

}