var idRad;
var usuariosa = new Array();

function onLoadBody() {

    $(document).ready(function () {

        $('.modal').modal({
            complete: function () {

                document.getElementById('semaforo').style.display = "none";
                document.getElementById('semaforo').style.right = "-60px";

            }
        });

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

function buscarProyectos(op) {

    var resultado = document.getElementById('resultado');

    //temporalmente
    resultado.innerHTML = '<div style="text-align: center; margin-left: auto; margin-right: auto;">'
            + '<img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >'
            + '</div>';

    value = document.getElementById("input_buscar").value;
    //bloquearPantalla();
    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data: {value: value, op: op},
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

function mas(cod, bpid, numProyecto) {

    usuariosa.splice(0);
    document.getElementById('txtBuscarUsuarios').value = "";
    document.getElementById('usua').innerHTML = "";
    document.getElementById('respuestab').innerHTML = "";

    $('#modal1').modal('open');

    idRad = cod;

}

function encontrar() {

    value = document.getElementById('txtBuscarUsuarios').value;

    jQuery.ajax({
        type: 'POST',
        url: '../../vistas/formulariosDinamicos/frmUsuarios.php',
        async: true,
        data: {value: value},
        success: function (respuesta)
        {
            document.getElementById('respuestab').innerHTML = "<p>" + respuesta + "</p>";

        },
        error: function () {
            alert("Error inesperado");
            window.top.location = "../index.html";
        }
    });

}

function agregaru(cedula, nombres, apellidos) {

    if (usuariosa.length > 0)
        for (var i = 0; i < usuariosa.length; i++)
            if (usuariosa[i][0] == cedula)
                return;

    var datosUsuario = new Array(3);
    datosUsuario [0] = cedula;
    datosUsuario [1] = nombres;
    datosUsuario [2] = apellidos;
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