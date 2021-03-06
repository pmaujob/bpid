var idRad;
var codBpid;
var usuariosa = new Array();

function bloquear_pantalla()
{

    document.getElementById("cargando").style.display = "block";
    document.body.style.overflow = "hidden";
}
function quitar_pantalla()
{

    document.getElementById("cargando").style.display = "none";
    document.body.style.overflow = "scroll";
}

function onLoadBody() {

    buscarProyectos(5);

    $(document).ready(function () {

        $('.modal').modal();

        $('.collapsible').collapsible();

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
                window.self.location = "../formularios/frm_listas_radicar.php";
            }
        }
    });

}

function buscarProyectos(op, event) {

    var buscarValue = document.getElementById("input_buscar").value;
    if (event != null && buscarValue.toString().trim().length == 0) {
        return;
    }

    if (event != null && ((event.keyCode != 13) && ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 65 || event.keyCode > 90)))) {
        return;
    }

    var resultado = document.getElementById('resultado');
    var wait = document.getElementById('wait');

    resultado.style.display = "none";
    wait.style.display = "";

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: buscarValue, op: op},
        success: function (respuesta) {
            resultado.innerHTML = '<p>' + respuesta + '</p>';
        }, error: function () {
            alert("Error inesperado");
        }, complete: function () {
            resultado.style.display = "";
            wait.style.display = "none";
        }
    });
}

function mas(cod, bpid, numProyecto) {

    idRad = cod;
    codBpid = bpid;

    usuariosa.splice(0);
    document.getElementById('txtBuscarUsuarios').value = "";
    document.getElementById('usua').innerHTML = "";
    document.getElementById('respuestab').innerHTML = "";

    $('#modal1').modal('open');

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmDatosViabilidad.php',
        async: true,
        data: {idRad: idRad},
        success: function (respuesta)
        {
            document.getElementById('respuestainfo').innerHTML = "<p>" + respuesta + "</p>";

        },
        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }
    });

}

function encontrar(event) {

    var value = document.getElementById('txtBuscarUsuarios').value;
    if (value.toString().trim().length == 0) {
        return;
    }

    if (event.keyCode != 13) {
        return;
    }

    var respuestab = document.getElementById('respuestab');
    respuestab.style.display = "none";
    var esperarListas = document.getElementById('esperarListas');

    esperarListas.style.display = "";

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmUsuarios.php',
        async: true,
        data: {value: value},
        success: function (respuesta)
        {
            respuestab.style.display = "";
            respuestab.innerHTML = "<p>" + respuesta + "</p>";

        },
        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        },
        complete: function () {
            esperarListas.style.display = "none";
        }
    });

}

function agregaru(cedula, nombres, apellidos, cargo) {

    if (document.getElementById(cargo).value.length === 0) {

        if (document.getElementById('toast-container') != null) {
            document.getElementById('toast-container').innerHTML = "";
        }

        Materialize.toast('El cargo no puede estar vacio', 4000);
        var toasts = document.getElementById('toast-container').getElementsByTagName("div");//traer todos los toasts
        //Cambiar el estilo de uno de todos los toasts
        toasts[0].style.background = "#008643";
        toasts[0].style.fontWeight = "400";
        return;
    }

    Materialize.toast('Usuario Agregado', 2000);

    var toasts = document.getElementById('toast-container').getElementsByTagName("div");//traer todos los toasts

    for (var i = 0; i < toasts.length; i++) {
        toasts[i].style.background = "#008643";
        toasts[i].style.fontWeight = "400";
    }

    //Cambiar el estilo de uno de todos los toasts

    for (var i = 0; i < usuariosa.length; i++)
        if (usuariosa[i][0] == cedula)
            return;

    var datosUsuario = new Array(4);
    datosUsuario [0] = cedula;
    datosUsuario [1] = nombres;
    datosUsuario [2] = apellidos;
    datosUsuario [3] = document.getElementById(cargo).value;
    usuariosa.push(datosUsuario);

    document.getElementById('usua').innerHTML = "";

    for (var i = 0; i < usuariosa.length; i++)
        document.getElementById('usua').innerHTML = document.getElementById('usua').innerHTML + "<span>" + usuariosa[i][1] + " " + usuariosa[i][2] + "<a href='#' onclick='eliminar(" + usuariosa[i][0] + ");'><i class='material-icons prefix red-text'>cancel</i></a>  </span>";

}

function eliminar(cedula) {

    if (usuariosa.length > 0)
        for (var i = 0; i < usuariosa.length; i++)
            if (usuariosa[i][0] == cedula) {
                usuariosa.splice(i, 1);
                document.getElementById('usua').innerHTML = "";
                for (var j = 0; j < usuariosa.length; j++)
                    document.getElementById('usua').innerHTML = document.getElementById('usua').innerHTML + "<span>" + usuariosa[j][1] + " " + usuariosa[j][2] + "<a href='#' onclick='eliminar(" + usuariosa[j][0] + ");'><i class='material-icons prefix red-text'>cancel</i></a>  </span>";
                return;
            }

}

function registrarResponsables() {

    bloquear_pantalla();

    var est = document.getElementById('estado').value;

    if (usuariosa.length > 0) {

        document.getElementById("modale").style.pointerEvents = "none";
        jQuery.ajax({
            type: 'POST',
            url: '../../controlador/CFinalizarViabilidad.php',
            async: true,
            data: {idRad: idRad, responsables: usuariosa, est: est, codBpid: codBpid},
            success: function (respuesta)
            {
                quitar_pantalla();
                $('#modal1').modal('close');

                if (respuesta.trim() == "1") {

                    document.getElementById('d_error').innerHTML = "Los responsables del proyecto han sido guardados con exito.";
                    $('#d_error').dialog("open");
                    $('#d_error').dialog({
                        autoOpen: false,
                        modal: true,
                        buttons: {
                            "Cerrar": function () {
                                $(this).dialog("close");
                                location.href = "../../vistas/formularios/frm_certificados_viabilidad.php";
                            }
                        }
                    });

                } else {
                    document.getElementById('d_error').innerHTML = "Los responsables del proyecto no han sido registrados, por favor intentelo de nuevo mas tarde.";
                    $('#d_error').dialog("open");
                }

                quitar_pantalla();
                console.log(respuesta);
                document.getElementById("modale").style.pointerEvents = "";

            },
            error: function () {
                quitar_pantalla();
                alert("Error inesperado");
                document.getElementById("modale").style.pointerEvents = "";
            }
        });

    } else {
        quitar_pantalla();
        document.getElementById('d_error').innerHTML = "Debe haber por lo menos un responsable.";
        $('#modal1').modal('close');
        $('#d_error').dialog("open");
        $('#d_error').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                "Cerrar": function () {
                    $(this).dialog("close");
                    $('#modal1').modal('open');
                }
            }
        });
    }

}

function semaforo(id) {

    var contTotal = 0;
    var contChequeados = 0;
    var res = 0;

    $("#" + id + " input").each(function () {
        contTotal++;
        if ($(this).prop('checked'))
            contChequeados++;
    });

    res = (contChequeados * 100) / contTotal;

    if (res < 50)
        document.getElementById('bonbilla').style.backgroundColor = "red";
    else if (res >= 50 && res < 90)
        document.getElementById('bonbilla').style.backgroundColor = "orange";
    else
        document.getElementById('bonbilla').style.backgroundColor = "green";

}

function cerrarModal() {

    $('#modal1').modal('close');

}