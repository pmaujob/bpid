<?php
//session_start();
function autoload($clase)
{
   require_once "../modelo/" . $clase . ".php";
}
spl_autoload_register('autoload');
//datos de conexion
$manejador = new Conexion_BD();
$conexion=$manejador->getconexion();
$conexion->beginTransaction();//iniciar transaccion
$radicar=new m_radicar();
$banco=new m_numero_banco();
$correcto=1;


//----

$valores = trim(($_POST["value"]));
$valores = explode("//", $valores);

$numero_proyecto=$valores[0];
$nombre_proyecto=$valores[1]; 
$sector=$valores[2];
$localizacion=$valores[3];
$valor=$valores[4];
$eje=$valores[5];
$programa=$valores[6];
$subprograma=$valores[7];
$poai=$valores[8];
$entidad_proponente=$valores[9];
$entidad_ejecutante=$valores[10];
$num_id_responsable=$valores[11];
$nom_responsable=$valores[12];
$cargo_responsable=$valores[13];
$direccion_responsable=$valores[14];
$telefono_responsable=$valores[15];
$cel_responsable=$valores[16];
$correo_responsable=$valores[17];
$id_usuario=$valores[18];
$nombre_usuario=$valores[19];
$observaciones=$valores[20];
$fecha_envio=date("Y-m-d");
$hora_envio=date("H:i:s",time());

$cod_usuario_ingreso=2;//codigo temporal del usuario que registra el proyecto
if($numero_proyecto=="" or $nombre_proyecto=="" or $sector=="" or $localizacion=="" or $valor=="" or $eje=="" or $programa=="" or 
	$subprograma=="" or $poai=="" or $entidad_proponente=="" or $entidad_ejecutante=="" or $num_id_responsable=="" or $nom_responsable=="" or 
	$cargo_responsable=="" or $direccion_responsable=="" or $telefono_responsable=="" or $cel_responsable=="" or $correo_responsable=="" or 
	$id_usuario=="" or $nombre_usuario=="" or $observaciones=="")
	{
		$correcto=2;
	}
	
//validacion email usuario
$comprobar_mail=comp_mail($correo_responsable);
if($comprobar_mail==0)
{
	$correcto=3;
}


//OBTENER DATOS DEL NUMERO DEL BPID
if($correcto==1)
	{
		$datos=ver_datos_bpid();
		$info = explode("/*", $datos);
		$cod_ingreso_banco=$info[0];
		$numero_banco=$a=str_pad($info[1],7,"0", STR_PAD_LEFT);
		$banco->cod_ingreso_banco=$cod_ingreso_banco;
		$banco->numero_banco=$numero_banco;
		$cod_departamento=52;
		$banco->cod_departamento=$cod_departamento;
		$fecha_banco=date ("Y");  
		$banco->fecha_banco=$fecha_banco;
		$banco->fecha_creacion=$fecha_envio;
		$banco->hora_creacion=$hora_envio;
		$banco->cod_activacion=1;
		$banco->cod_usuario_ingreso=2;
		//numero_completo
		$numero_completo=$fecha_banco.$cod_departamento.$numero_banco;
		$banco->numero_completo=$numero_completo;
		$sql = $banco->ingresar_banco();
		$insertar=$manejador->consulta(1,$sql); 
		if($insertar==0){
				$correcto=4;
						}

	}
	

//Si la validacion de campos en blanco es correcto
if($correcto==1){
	$campo='cod_radicacion';
	$tabla='radicacion';
	$radicar->cod_ingreso_radicar=ver_codigo_ingreso_radicar($campo,$tabla);
	$radicar->cod_numero_bpid=$cod_ingreso_banco;
	$radicar->numero_proyecto=$numero_proyecto;
	$radicar->nombre_proyecto=$nombre_proyecto;
	$radicar->sector=$sector;
	$radicar->localizacion=$localizacion;
	$radicar->valor=$valor;
	$radicar->eje=$eje;
    $radicar->programa=$programa;
	$radicar->subprograma=$subprograma;
	$radicar->poai=$poai;
	$radicar->entidad_proponente=$entidad_proponente;
	$radicar->entidad_ejecutante=$entidad_ejecutante;
	$radicar->num_id_responsable=$num_id_responsable;
	$radicar->nom_responsable=$nom_responsable;
	$radicar->cargo_responsable=$cargo_responsable;
    $radicar->direccion_responsable=$direccion_responsable;
	$radicar->telefono_responsable=$telefono_responsable;
	$radicar->cel_responsable=$cel_responsable;
	$radicar->correo_responsable=$correo_responsable;
	$radicar->id_usuario=$id_usuario;
	$radicar->nombre_usuario=$nombre_usuario;
	$radicar->observaciones=$observaciones;
	$radicar->cod_usuario_ingreso=$cod_usuario_ingreso;
	$radicar->fecha_envio=$fecha_envio;
	$radicar->hora_envio=$hora_envio;
	$radicar->cod_activacion=1;
	$radicar->cod_secretaria=1;//temporal debo traerla del inicio de sesios
			
			$sql = $radicar->ingresar_radicar();
			$insertar=$manejador->consulta(2,$sql); 
			if($insertar==0){
				$correcto=5;
			}
}

//FUNCIONES DE CLASE
function comp_mail($TestEmailAddress){
if(preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", $TestEmailAddress)){
            return 1;
        } else {
            return 0;
        }
}
function ver_codigo_ingreso_radicar($campo,$tabla)
{
$manejador = new Conexion_BD();
$conexion=$manejador->getconexion();
$query="select max($campo) as numero from $tabla";
$resultado=$manejador->consultar($query);
foreach( $resultado  as $r){
   $numero=$r->numero;
							}
if($numero==""){$numero=1;}
else{$numero=$numero+1;}
return $numero;
}

function ver_datos_bpid()
{
$manejador = new Conexion_BD();
$conexion=$manejador->getconexion();
$query="select cod_numero_bpid as numero,numero_banco from numero_bpid where cod_numero_bpid=(select max(cod_numero_bpid)from numero_bpid)";
$resultado=$manejador->consultar($query);
foreach( $resultado  as $r){
   $numero=$r->numero;
   $banco=$r->numero_banco;
							}
if($numero==""){$numero=1;
				$banco=1;
				}
else{$numero=$numero+1;
		$banco=$banco+1;
	}
return $numero."/*".$banco;
}

if($correcto==1)
{
	$conexion->commit();
	//echo "ingreso Correcto";
}
if($correcto==2)
{
	$conexion->rollBack();
	//echo "ERROR,HAY DATOS EN BLANCO QUE DEBEN REGISTRARSE";
}
if($correcto==3)
{
	$conexion->rollBack();
	//echo "ERROR,EL CORREO ELECTRONICO ES INCORRECTO";
}
if($correcto==4)
{
	$conexion->rollBack();
	//echo "ERROR,LOS DATOS DEL PROYECTO NO FUERON INGRESADOS";
}
if($correcto==5)
{
	$conexion->rollBack();
	//echo "ERROR,LOS DATOS DE RADICACION NO FUERON INGRESADOS";
}
echo $correcto;
?>