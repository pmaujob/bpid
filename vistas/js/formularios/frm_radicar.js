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
$(document).ready(function() {
	
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
						window.self.location="../formularios/frm_radicar.php";
											  }
								}
						});
});
/*
FUNCION QUE DESPUES DE HACER CLICK EN EL BOTON ENVIAR SE ABRE EL DIALOG
 */
function validar() {
var nombre_archivo=document.getElementById('frm_archivo').value;
				if(nombre_archivo=="")
				{
					document.getElementById('d_error').innerHTML='<p>POR FAVOR SELECCIONE EL ARCHIVO XML<p>';
					$("#d_error").dialog("open");
					//alert("DEBE SELECCIONAR UN ARCHIVO XML ANTES");
					return false;
					nombre_archivo.focus();
				}

				else
				{
				   $('#modal1').modal('open');
				}
}

//FUNCION PARA CARGAR LOS DATOS BASICOS DEL ARCHIVO XML DE FORMA TEMPORAL
function archivo_xml()
{
	//CONTROLES FORMULARIO
	var nombre_proyecto= document.getElementById('frm_nom_proyecto');
	var numero_proyecto= document.getElementById('frm_num_proyecto');
	var sector= document.getElementById('frm_sector');
	var localizacion= document.getElementById('frm_localizacion');
	var valor= document.getElementById('frm_valor');
	var eje= document.getElementById('frm_eje');
	var programa= document.getElementById('frm_programa');
	var subprograma= document.getElementById('frm_subprograma');
	var formData=new FormData($("#frm_radicar")[0]);  
 	var nombre_archivo=document.getElementById('frm_archivo').value;
 	var objetivos=document.getElementById('objetivos').value;
 	var extension = (nombre_archivo.substring(nombre_archivo.lastIndexOf("."))).toLowerCase();

 	if (extension!=='.xml') { 
					document.getElementById('d_error').innerHTML='<p>EL ARCHIVO DEBE TENER EXTENCION XML<p>';
					$("#d_error").dialog("open");
					//alert("DEBE SELECCIONAR UN ARCHIVO XML ANTES");
					return false;
					nombre_archivo.focus();
 	}
 	else
 	{
 		bloquear_pantalla();
 	var formData=new FormData($("#frm_radicar")[0]);  //lo hago por la validacion
										$.ajax({
						  url:'../../modelo/consultar_existencia_xml.php',
										type: "POST",
										data: formData,
										contentType:false,
										processData:false,
										success: function(existe)
										{
											//alert(existe)
										//	quitar_pantalla();
									if(existe==0)//si el archivo existe
									{

											$.ajax({
													 url:'../../modelo/consultar_basico_xml.php',
													type: "POST",
													data: formData,
													contentType:false,
													processData:false,
													success: function(datos)
													{
													//alert(datos)	
													var cadena=datos.split("*/");
													nombre_proyecto.focus();
													nombre_proyecto.value='';
													nombre_proyecto.value=cadena[0];
													numero_proyecto.focus();
													numero_proyecto.value='';
													numero_proyecto.value=cadena[8];
													sector.focus();
													sector.value=cadena[1];
													localizacion.focus();
													localizacion.value='';
													localizacion.value=cadena[2];
													eje.focus();
													eje.value='';
													eje.value=cadena[3];
													programa.focus();
													programa.value='';
													programa.value=cadena[4];
													subprograma.focus();
													subprograma.value='';
													subprograma.value=cadena[5];
													valor.focus();
													valor.value='';
													valor.value=cadena[7];
													document.getElementById('objetivos').value=cadena[9];
													document.getElementById('fuentes').value=cadena[10];
													document.getElementById('problema').value=cadena[11];
													document.getElementById('poblacion').value=cadena[12];
													quitar_pantalla();
													}
													});	



									}
									else
									{
						$('#modal1').modal('close');
						quitar_pantalla();							
						document.getElementById('d_ingreso').innerHTML='<p> EL ARCHIVO YA SE ENCUENTRA RADICADO!, SELECCIONE UNO NUEVO</p>';
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
	//DATOS DEL PROYECTO DEL ARCHIVO XML
	var numero_proyecto= document.getElementById('frm_num_proyecto').value;
	var nombre_proyecto= document.getElementById('frm_nom_proyecto').value;
	var sector= document.getElementById('frm_sector').value;
	var localizacion= document.getElementById('frm_localizacion').value;
	var valor= document.getElementById('frm_valor').value;
	var eje= document.getElementById('frm_eje').value;
	var programa= document.getElementById('frm_programa').value;
	var subprograma= document.getElementById('frm_subprograma').value;
 	var poai=document.getElementById('frm_poai').value;
 	var entidad_proponente=document.getElementById('frm_entidad').value;
 	var entidad_ejecutante=document.getElementById('frm_entidad_ejecuta').value;
 	var nom_responsable=document.getElementById('frm_nom_responsable').value;
 	var num_id_responsable=document.getElementById('frm_id_responsable').value;
 	var cargo_responsable=document.getElementById('frm_cargo_responsable').value;
 	var direccion_responsable=document.getElementById('frm_dir_responsable').value;
 	var telefono_responsable=document.getElementById('frm_tel_responsable').value;
 	if(telefono_responsable===""){telefono_responsable=-1;}
 	var cel_responsable=document.getElementById('frm_cel_responsable').value;
 	var correo_responsable=document.getElementById('frm_correo').value;
 	var id_usuario=document.getElementById('frm_id_usuario').value;
 	var nombre_usuario=document.getElementById('frm_nom_usuario').value;
 	var observaciones=document.getElementById('frm_observaciones').value;
 	observaciones=observaciones.trim();
 	if(observaciones===""){observaciones=-1;}
 	var formData=new FormData($("#frm_radicar")[0]);  
 	var nombre_archivo=document.getElementById('frm_archivo').value;
 	var objetivos=document.getElementById('objetivos').value;
 	var fuentes=document.getElementById('fuentes').value;
 	var problema=document.getElementById('problema').value;
 	var poblacion=document.getElementById('poblacion').value;
 	
 	var value=numero_proyecto+'//'+nombre_proyecto +'//'+sector+'//'+localizacion+'//'+valor+'//'+eje+'//'+programa+'//'+subprograma+'//'+poai+'//'+
 	entidad_proponente+'//'+entidad_ejecutante+'//'+num_id_responsable+'//'+nom_responsable+'//'+cargo_responsable+'//'+
 	direccion_responsable+'//'+telefono_responsable+'//'+cel_responsable+'//'+correo_responsable+'//'+id_usuario+'//'+nombre_usuario+'//'+
 	observaciones+'//'+objetivos+'//'+fuentes+'//'+problema+'//'+poblacion;
 	
 	
 	 $('#modal1').modal('close');
 	bloquear_pantalla();
 	jQuery.ajax({	
		    type: "POST",
              url:'../../controlador/ControladorRadicar.php',
			async: false,
			data:{value:value},
			success:function(respuesta){
			//	alert(respuesta)
				
			if(respuesta==1){ 
				var formData=new FormData($("#frm_radicar")[0]);  //lo hago por la validacion
										$.ajax({
						  url:'../../controlador/ControladorArchivos.php',
										type: "POST",
										data: formData,
										contentType:false,
										processData:false,
										success: function(datos)
										{
										quitar_pantalla();	
										//alert(datos);
			 $('#modal1').modal('close');							
			document.getElementById('d_ingreso').innerHTML='<p>EL NUMERO BPID ASIGNADO ES '+ datos + '</p>';
			$("#d_ingreso").dialog("open");

																}
										});			
			
			
			}
			else
			{
			var mensaje="Error, Intentelo Nuevamente";
			document.getElementById('d_error').innerHTML='<p>'+ mensaje + '</p>';
			$("#d_error").dialog("open");
			return false;
			}
										},
										
            error: function () {
				  alert("Error inesperado")
				  window.top.location ="../index.html";	
			}
        });
        
}	
