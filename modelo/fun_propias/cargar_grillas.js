// JavaScript Document
//Desarollado ING dario santacruz

function cargar_grilla_proyectos(campo)
{
	
   value=1
   jQuery.ajax({		 
            type: "POST",
            url:'../../modelo/consultas/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
            	alert(respuesta)
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
				
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 document.getElementById('frm_proyecto').options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	
}
//
function cargar_grilla_departamentos(campo){
{
   //nombre del campo select
   //carga departamento
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=2
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
function cargar_grilla_municipios_colombia(campo,id){
   //nombre del campo select
   //carga municipios de colombia id de departamento 
   //id hace referencia al id de departamento
   var lista_valores=document.getElementById(campo);
   if(id==""){
	    lista_valores.disabled=true
   }else if(id!=""){
		lista_valores.disabled=false					
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=3+'-'+id
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					lista_valores.options.length = 0;
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
	}//llave de id vacio
 } 
<!------------------------------>
function cargar_grilla_tipos_contrato(campo){
{
   //nombre del campo select
   //carga departamento
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=4
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
function cargar_grilla_tipos_identificacion(campo){
{
   //nombre del campo select
   //carga departamento
   var lista_valores=document.getElementById(campo); 
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=5
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
	}
}
<!------------------------------>
function cargar_grilla_paises(campo){
{
   //nombre del campo select
   //carga paises
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=6
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
function cargar_grilla_ciudades_generales(campo,id)
{
   //nombre del campo select
   //carga ciudades de cualquier pais relacionado por las iniciales del pais 
   //id hace referencia a las iniciales del pais
   id=id.toString();
   var lista_valores=document.getElementById(campo);
   if(id==""){
	    lista_valores.disabled=true
   }else if(id!=""){
		lista_valores.disabled=false					
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=7+'-'+id
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					lista_valores.options.length = 0;
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
	}//llave de id vacio
} 
<!------------------------------>
function cargar_correo_electronico(campo)
{
   //nombre del campo select
   //carga el correo electronico de la tabla de usuarios 
   var div=document.getElementById("d_"+campo)
   var lista_valores=document.getElementById(campo);
   var lista_valores_div=document.getElementById("div_"+campo);
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=8
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					lista_valores_div.innerHTML=respuesta
					lista_valores.value=respuesta
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
       });
}//llave de id vacio
<!------------------------------>
function cargar_grilla_secretarias(campo)
{
   //nombre del campo select
   //carga secretarias o dependencias 1 o 3  
   var div=document.getElementById("d_"+campo)
   var lista_valores=document.getElementById(campo);
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=9
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
			   if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					lista_valores.options.length = 0;
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}	
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
       });
}//llave de id vacio
//cargar grilla usuarios
function cargar_grilla_usuarios(campo){
{
   //nombre del campo select
   //carga usuarios 1 y 3
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=11
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
//cargar grilla usuarios solo operativos creacion
function cargar_grilla_usuarios_op_creacion(campo){
{
   //nombre del campo select
   //carga usuarios 1 y 3
   var lista_valores=document.getElementById(campo);
    var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=12
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
function cargar_grilla_usuarios_por_secretaria(campo,criterio){
{
	
   //nombre del campo select
   //carga usuarios 1 y 3
   var lista_valores=document.getElementById(campo);
    var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=14+'-'+criterio;
     jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
			
			//codigo para liberar el combo de listas
			if(lista_valores.options){
							for (m=lista_valores.options.length-1;m>=0;m--)
							lista_valores.options[m]=null
							}

			//	
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}

//cargar grilla clases
<!------------------------------>
function cargar_grilla_clases(campo){
{
   //nombre del campo select
      var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=13
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
function cargar_grilla_segmento(tipo,campo,criterio)
{
	var value=tipo+"-"+criterio

				 jQuery.ajax({	
		 
            type: "POST",
            url:'../consultas/consultar_listas_procesos.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(tipo==1){document.getElementById('frm_segmento').innerHTML=respuesta	}
										},
            error: function () {
				  alert("Error inesperado")
			  window.self.location ="../formularios/frm_asignar_numeros.php";	
			}
        });
		campo1="frm_familia";
		if(criterio==0){cargar_grilla_familia(2,campo1,10);}
		if(criterio==1){cargar_grilla_familia(2,campo1,11);}
		if(criterio==2){cargar_grilla_familia(2,campo1,20);}
		if(criterio==3){cargar_grilla_familia(2,campo1,30);}
		if(criterio==4){cargar_grilla_familia(2,campo1,42);}
		if(criterio==5){cargar_grilla_familia(2,campo1,70);}
		if(criterio==6){cargar_grilla_familia(2,campo1,95);}
		
}

function cargar_grilla_familia(tipo,campo,criterio)
{
	var value=tipo+"-"+criterio
		
				 jQuery.ajax({	
		 
            type: "POST",
            url:'../consultas/consultar_listas_procesos.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				document.getElementById('frm_familia').innerHTML=respuesta	
										},
            error: function () {
				  alert("Error inesperado")
			  window.self.location ="../formularios/frm_asignar_numeros.php";	
			}
        });
		
}

function cargar_grilla_clase(tipo,campo,criterio)
{
	var value=tipo+"-"+criterio;
		
				 jQuery.ajax({	
		 
            type: "POST",
            url:'../consultas/consultar_listas_procesos.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				document.getElementById('frm_clase').innerHTML=respuesta	
										},
            error: function () {
				  alert("Error inesperado")
			  window.self.location ="../formularios/frm_asignar_numeros.php";	
			}
        });
		
}
//funcion para cargar la lista de los productos
function cargar_grilla_producto(tipo,campo,criterio)
{
	var value=tipo+"-"+criterio;
		
				 jQuery.ajax({	
		 
            type: "POST",
            url:'../consultas/consultar_listas_procesos.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				document.getElementById('frm_producto').innerHTML=respuesta	
										},
            error: function () {
				  alert("Error inesperado")
			  window.self.location ="../formularios/frm_asignar_numeros.php";	
			}
        });
		
}

//funcion para crear lista de clase de contrato
function cargar_grilla_clase_contrato_leg(campo){
{
   //nombre del campo select
   //carga departamento
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=15
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}

//funcion para cargar lista banco de proyectos

function cargar_grilla_sector(campo){
{
   //nombre del campo select
   //carga departamento
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=16
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				
				if(respuesta!=-1){
					
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
<!------------------------------>
function  cargar_grilla_usuarios_dest(campo,criterio){
{
	
   //nombre del campo select
   //carga usuarios 1 y 3
   var lista_valores=document.getElementById(campo);
    var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=17+'-'+criterio;
     jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
			
			//codigo para liberar el combo de listas
			if(lista_valores.options){
							for (m=lista_valores.options.length-1;m>=0;m--)
							lista_valores.options[m]=null
							}

			//	
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
function cargar_grilla_etapas(campo){
{
  
   var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=18;
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				
				if(respuesta!=-1){
					
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
function cargar_grilla_etapas_contratacion(campo,id){
   
   var lista_valores=document.getElementById(campo);
   if(id==""){
	   
	    lista_valores.disabled=true
   }else if(id!=""){
		lista_valores.disabled=false					
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=19+'-'+id
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					lista_valores.options.length = 0;
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
	}//llave de id vacio
 } 
 <!------------------------------>
function  cargar_grilla_contratos_sia(campo){
{
   //nombre del campo select
      var lista_valores=document.getElementById(campo);
   var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=20;
   jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
function cargar_grilla_abogados_por_secretaria(campo,criterio){
{
	
   //nombre del campo select
   //carga usuarios 1 y 3
   var lista_valores=document.getElementById(campo);
    var div=document.getElementById("d_"+campo)
   div.innerHTML='<img src="../css/ajax-loader.gif" width="20" height="20">' 
   value=21+'-'+criterio;
     jQuery.ajax({		 
            type: "POST",
            url:'../cargar/cargar_grillas.php',
			async: false,
			data:{value:value},
            success:function(respuesta){
			
			//codigo para liberar el combo de listas
			if(lista_valores.options){
							for (m=lista_valores.options.length-1;m>=0;m--)
							lista_valores.options[m]=null
							}

			//	
				if(respuesta!=-1){
					var vector_valores = respuesta.split(";");
					for (x=0;x<vector_valores.length;x++){
    					 var objetos = vector_valores[x].split(",");
						 lista_valores.options.add(new Option(objetos[1],objetos[0]));
					}
					div.innerHTML=""
					
				}
				if(respuesta==-1){
					alert("Error en tiempo de Ejecucion, Reportar Error al Administrador");
					window.top.location ="../index.php";
			  	}
			},
            error: function () {
		      alert("Error inesperado")
			  //window.top.location="../index.php";	
			}
        });
			
	}
}
