// JavaScript Document
// Desarrollado Ing Dario Santacruz

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

$(document).ready(function () {

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
    $('select').material_select();
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
});
/*
 FUNCION QUE DESPUES DE HACER CLICK EN EL BOTON ENVIAR SE ABRE EL DIALOG
 */
function validar() {
    var nombre_archivo = document.getElementById('frm_archivo').value;
    if (nombre_archivo == "")
    {
        document.getElementById('d_error').innerHTML = '<p>POR FAVOR SELECCIONE EL ARCHIVO XML<p>';
        $("#d_error").dialog("open");
        
        return false;
        nombre_archivo.focus();
    } else
    {
        //codigo para llenar combo de programa

        $.ajax({
            type: "POST",
            url: '../../controlador/ControladorRadicar.php',
            async: true,
            data: {op: 3},
            success: function (datos) {
                $("#frm_programa_inversion").empty();
                var content = JSON.parse(datos);
                for (var i = 0; i < content.length; i++) {
                    var obj = content[i];
                    var option = document.createElement('option');
                    option.value = obj.cod;
                    option.innerHTML = obj.nom;
                    $('#frm_programa_inversion').append(option);
                }
                $("#frm_programa_inversion").material_select('update');
                //  alert(datos);
            }
        });
        //abrir ventana modal
        $('#modal1').modal('open');

    }
}

//FUNCION PARA CARGAR LOS DATOS BASICOS DEL ARCHIVO XML DE FORMA TEMPORAL
function archivo_xml()
{
    //CONTROLES FORMULARIO
    var nombre_proyecto = document.getElementById('frm_nom_proyecto');
    var numero_proyecto = document.getElementById('frm_num_proyecto');
    var sector = document.getElementById('frm_sector');
    var localizacion = document.getElementById('frm_localizacion');
    var valor = document.getElementById('frm_valor');
    var eje = document.getElementById('frm_eje');
    var programa = document.getElementById('frm_programa');
    var subprograma = document.getElementById('frm_subprograma');
    var formData = new FormData($("#frm_radicar")[0]);
    var nombre_archivo = document.getElementById('frm_archivo').value;
    var objetivos = document.getElementById('objetivos').value;
    var extension = (nombre_archivo.substring(nombre_archivo.lastIndexOf("."))).toLowerCase();

    if (extension !== '.xml') {
        document.getElementById('d_error').innerHTML = '<p>EL ARCHIVO DEBE TENER EXTENCION XML<p>';
        $("#d_error").dialog("open");
        //alert("DEBE SELECCIONAR UN ARCHIVO XML ANTES");
        return false;
        nombre_archivo.focus();
    } else
    {
        //bloquear_pantalla();
        var formData = new FormData($("#frm_radicar")[0]);  //lo hago por la validacion
        $.ajax({
            url: '../../controlador/CConsutarExistenciasXml.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (existe)
            {
                // alert(existe)
                //	quitar_pantalla();
                if (existe == 0)//si el archivo existe
                {

                    $.ajax({
                        url: '../../controlador/CConsutarDatosXml.php',
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (datos)
                        {
                            //alert(datos);

                            if (datos != -1)
                            {

                                var cadena = datos.split("*/");

                                nombre_proyecto.focus();
                                nombre_proyecto.value = '';
                                nombre_proyecto.value = cadena[0];
                                numero_proyecto.focus();
                                numero_proyecto.value = '';
                                numero_proyecto.value = cadena[8];
                                sector.focus();
                                sector.value = cadena[1];
                                localizacion.focus();
                                localizacion.value = '';
                                localizacion.value = cadena[2];
                                eje.value = 1;
                                programa.value = cadena[4];
                                subprograma.value = cadena[5];
                                valor.focus();
                                valor.value = '';
                                valor.value = cadena[7];
                                document.getElementById('objetivos').value = cadena[9];
                                document.getElementById('fuentes').value = cadena[10];
                                document.getElementById('problema').value = cadena[11];
                                document.getElementById('poblacion').value = cadena[12];
                                document.getElementById('objetivog').value = cadena[13];
                                document.getElementById('productos').value = cadena[14];
                                document.getElementById('actividades').value = cadena[15];
                                document.getElementById('resumen').value = cadena[16];
                                quitar_pantalla();
                            }
                            if (datos == -1)
                            {

                                $('#modal1').modal('close');
                                quitar_pantalla();
                                document.getElementById('d_ingreso').innerHTML = '<p>ERROR, EL ARCHIVO ESTA INCOMPLETO Y NO PUEDE SER RADICADO</p>';
                                $("#d_ingreso").dialog("open");
                                return false;
                            }
                        }
                    });



                }
                if (existe == 1)
                {
                    $('#modal1').modal('close');
                    quitar_pantalla();
                    document.getElementById('d_ingreso').innerHTML = '<p> EL ARCHIVO YA SE ENCUENTRA RADICADO!, SELECCIONE UNO NUEVO</p>';
                    $("#d_ingreso").dialog("open");
                    return false;

                }
                if (existe == 2)
                {
                    $('#modal1').modal('close');
                    quitar_pantalla();
                    document.getElementById('d_ingreso').innerHTML = '<p> ERROR!, EL ARCHIVO NO PUEDE SER RADICADO</p>';
                    $("#d_ingreso").dialog("open");
                    return false;

                }


            }
        });

    }
}

function Borrar() {
    document.getElementById("frm_radicar").reset();

}

//FUNCION PARA VALIDAR CAMPOS DE FORMULARIO
function almacenar()
{
    //  bloquear_pantalla();
    //DATOS DEL PROYECTO DEL ARCHIVO XML
    var numero_proyecto = document.getElementById('frm_num_proyecto').value;
    var nombre_proyecto = document.getElementById('frm_nom_proyecto').value;
    var sector = document.getElementById('frm_sector').value;
    var localizacion = document.getElementById('frm_localizacion').value;
    var valor = document.getElementById('frm_valor').value;
    var eje = document.getElementById('frm_eje').value;
    var programa = document.getElementById('frm_programa').value;
    var subprograma = document.getElementById('frm_subprograma').value;
    var poai = document.getElementById('frm_poai').value;
    var entidad_proponente = document.getElementById('frm_entidad').value;
    var entidad_ejecutante = document.getElementById('frm_entidad_ejecuta').value;
    var nom_responsable = document.getElementById('frm_nom_responsable').value;
    var num_id_responsable = document.getElementById('frm_id_responsable').value;
    var cargo_responsable = document.getElementById('frm_cargo_responsable').value;
    var direccion_responsable = document.getElementById('frm_dir_responsable').value;
    var telefono_responsable = document.getElementById('frm_tel_responsable').value;
    if (telefono_responsable === "") {
        telefono_responsable = -1;
    }
    var cel_responsable = document.getElementById('frm_cel_responsable').value;
    var correo_responsable = document.getElementById('frm_correo').value;
    var id_usuario = document.getElementById('frm_id_usuario').value;
    var nombre_usuario = document.getElementById('frm_nom_usuario').value;
    var observaciones = document.getElementById('frm_observaciones').value;
    observaciones = observaciones.trim();
    if (observaciones === "") {
        observaciones = -1;
    }
    var formData = new FormData($("#frm_radicar")[0]);
    var nombre_archivo = document.getElementById('frm_archivo').value;
    var objetivos = document.getElementById('objetivos').value;
    var fuentes = document.getElementById('fuentes').value;
    var problema = document.getElementById('problema').value;
    var poblacion = document.getElementById('poblacion').value;
    var objetivog = document.getElementById('objetivog').value;
    var productos = document.getElementById('productos').value;
    var actividades = document.getElementById('actividades').value;
    var resumen = document.getElementById('resumen').value;
    var tipo_proyecto = document.getElementById('frm_tipo').value;

    if (tipo_proyecto == 1 || tipo_proyecto == 2) {
        var numero_programa_inversion = null;
    }//proyecto General
    else {
        var numero_programa_inversion = document.getElementById('frm_programa_inversion').value;
    }
    if (tipo_proyecto == 3 && numero_programa_inversion == "") {
        Materialize.toast('SELECCIONE EL PROYECTO AL QUE PERTENECE', 4000);
    }//proyecto General


    var value = numero_proyecto + '//' + nombre_proyecto + '//' + sector + '//' + localizacion + '//' + valor + '//' + eje + '//' + programa + '//' + subprograma + '//' + poai + '//' +
            entidad_proponente + '//' + entidad_ejecutante + '//' + num_id_responsable + '//' + nom_responsable + '//' + cargo_responsable + '//' +
            direccion_responsable + '//' + telefono_responsable + '//' + cel_responsable + '//' + correo_responsable + '//' + id_usuario + '//' + nombre_usuario + '//' +
            observaciones + '//' + objetivos + '//' + fuentes + '//' + problema + '//' + poblacion + '//' + objetivog + '//' + productos + '//' + actividades + '//' + resumen + '//' + tipo_proyecto + '//' + numero_programa_inversion;


    $('#modal1').modal('close');
    //bloquear_pantalla();
    jQuery.ajax({
        type: "POST",
        url: '../../controlador/ControladorRadicar.php',
        async: false,
        data: {value: value, op: 1},
        success: function (respuesta) {

            // alert(respuesta);

            if (respuesta == 1) {
                var formData = new FormData($("#frm_radicar")[0]);  //lo hago por la validacion
                $.ajax({
                    url: '../../controlador/ControladorArchivos.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos)
                    {
                        quitar_pantalla();
                        //alert(datos);
                        $('#modal1').modal('close');
                        document.getElementById('d_ingreso').innerHTML = '<p>EL NUMERO BPID ASIGNADO ES ' + datos + '</p>';
                        $("#d_ingreso").dialog("open");

                    }
                });


            } else
            {
                quitar_pantalla();
                console.log(respuesta);
                var mensaje = "Error, Intentelo Nuevamente";
                document.getElementById('d_error').innerHTML = '<p>' + mensaje + '</p>';
                $("#d_error").dialog("open");
                return false;
            }
        },
        error: function () {
            quitar_pantalla();
            alert("Error inesperado")
            window.top.location = "../index.html";
        }
    });

}

function buscarUsuario(tipo)
{

    if (tipo == 1) {
        cedula = document.getElementById('frm_id_responsable').value;
    }
    if (tipo == 2) {
        cedula = document.getElementById('frm_id_usuario').value;
    }
    var waitGuardarProgreso = document.getElementById('waitGuardarProgreso');
    waitGuardarProgreso.style.display = "";
    jQuery.ajax({
        type: 'POST',
        url: '../../controlador/ControladorRadicar.php',
        async: true,
        data: {cedula: cedula, op: 2},
        success: function (respuesta) {

            waitGuardarProgreso.style.display = "";
            if (tipo == 1)
            {
                if (respuesta.trim() === "NoData") {
                    waitGuardarProgreso.style.display = 'none';
                      var toasts = document.getElementById('toast-container').getElementsByTagName("div");
                    Materialize.toast('Usuario no Registrado, Por favor Digite los Datos', 4000);
                    toasts.style.background = "#008643";
                    toasts.style.fontWeight = "400";
                  //traer todos los toasts
                    //Cambiar el estilo de uno de todos los toasts
                    toasts.style.background = "#008643";
                    toasts.style.fontWeight = "400";
                    document.getElementById('frm_id_responsable').focus();
                    document.getElementById('frm_nom_responsable').value = '';
                    document.getElementById('frm_cargo_responsable').value = '';
                    document.getElementById('frm_dir_responsable').value = '';
                    document.getElementById('frm_tel_responsable').value = '';
                    document.getElementById('frm_cel_responsable').value = '';
                    document.getElementById('frm_correo').value = '';
                } else {

                    var content = JSON.parse(respuesta);
                    document.getElementById('frm_nom_responsable').value = content.nombres;
                    document.getElementById('frm_nom_responsable').focus();
                    document.getElementById('frm_cargo_responsable').value = content.cargo;
                    document.getElementById('frm_cargo_responsable').focus();
                    document.getElementById('frm_dir_responsable').value = content.direccion;
                    document.getElementById('frm_dir_responsable').focus();
                    document.getElementById('frm_tel_responsable').value = content.telefono;
                    document.getElementById('frm_tel_responsable').focus();
                    document.getElementById('frm_cel_responsable').value = content.celular;
                    document.getElementById('frm_cel_responsable').focus();
                    document.getElementById('frm_correo').value = content.correo;
                    document.getElementById('frm_correo').focus();
                    waitGuardarProgreso.style.display = "none";
                }

            }
            if (tipo == 2)
            {
                if (respuesta.trim() === "NoData") {
                    waitGuardarProgreso.style.display = "none";
                    Materialize.toast('Usuario no Registrado, Por favor Digite los Datos', 4000);
                    var toasts = document.getElementById('toast-container').getElementsByTagName("div");//traer todos los toasts
                    //Cambiar el estilo de uno de todos los toasts
                    toasts[0].style.background = "#008643";
                    toasts[0].style.fontWeight = "400";
                    document.getElementById('frm_id_usuario').focus();
                    document.getElementById('frm_nom_usuario').value = '';

                } else {
                    waitGuardarProgreso.style.display = "none";
                    var content = JSON.parse(respuesta);
                    document.getElementById('frm_nom_usuario').value = content.nombres;
                    document.getElementById('frm_nom_usuario').focus();

                }

            }

        },
        error: function () {
            alert("Error inesperado")
            window.top.location = "../index.html";
        }

    });


}
function verpro(opcion)
{

    fila = document.getElementById("fila_programa");
    if (opcion == 1) {
        fila.style.display = 'none';
    } else {
        fila.style.display = '';
    }
}

function tipoproyecto()
{
    $('#ventanatipo').modal('open');
}
function validarTipo()
{
    if (document.getElementById('toast-container') != null) {
        toasts = document.getElementById('toast-container').getElementsByTagName("div");
        for (var i = toasts.length - 1; i >= 0; i--) {
            toasts[i].parentNode.removeChild(toasts[i]);
        }
    }


    $('#ventanatipo').modal('close');
    var proyectotipo = document.getElementById('frm_tipo').value;
    if (proyectotipo == 1) {
        Materialize.toast('PROYECTO GENERAL', 14000);
        document.getElementById("filatipoproyecto").style.display = 'none';


    }
    if (proyectotipo == 2) {
        Materialize.toast('PROGRAMA DE INVERSION', 14000);
        document.getElementById("filatipoproyecto").style.display = 'none';
    }
    if (proyectotipo == 3) {
        Materialize.toast('EL PROYECTO PERTENECE A PROYECTO DE INVERSION', 14000);
        document.getElementById("filatipoproyecto").style.display = 'block';
    }


    var toasts = document.getElementById('toast-container').getElementsByTagName("div");//traer
    toasts[0].style.background = "#FFCA04";
    toasts[0].style.fontWeight = "400";

}

function validarProyectoPadre(a)
{
    if (parseInt(a) == 3)
    {
        $.ajax({
            type: 'POST',
            url: '../../controlador/ControladorRadicar.php',
            async: true,
            data: {op: 4},
            
            success: function (datos)
            {
               
                if(parseInt(datos)==0){
                $('#ventanatipo').modal('close');
                document.getElementById('d_ingreso').innerHTML = '<p>NO EXISTEN PROGRAMAS DE INVERSION PARA ESTE PROYECTO</p>';
                $("#d_ingreso").dialog("open");   
                }
                
            }
        });
    }
}
function cerrarModal()
{
    $('#ventanatipo').modal('close');
}