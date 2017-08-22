<?php
require '../librerias/CambiarFormatos.php';
include_once '../librerias/SessionVars.php';
$sess=new SessionVars();
$sess->init();
if($sess->exist() && $sess->varExist('cedula'))
{
$ruta_tmp=$_FILES['frm_archivo']['tmp_name'];//ruta temporal del archivo
$nombre=  $_FILES['frm_archivo']['name'];//verificar si el nombre esta bn escrito
$ruta=$ruta_tmp;
$trozos = explode(".", $nombre); 
$extension = end($trozos); //obtener la extencion del archivo
if($extension=="xml" or $extension=="XML")
{
	$datos=simplexml_load_file($ruta);
	$nombrep=(string)utf8_decode($datos->Name);
	$nombrep=ltrim(utf8_encode($nombrep));
	$numero_proyecto=utf8_decode($datos->Id);
	$sector=(string)utf8_decode($datos->Sector->Description);
	$sector=utf8_encode($sector);
	$problema=tildes($datos->CentralProblem->CentralProblem);
	$departamento=(string)utf8_decode($datos->Localizations->Localization[1]->Department->Name);
	$departamento=utf8_encode($departamento);
	$municipio=(string)utf8_decode($datos->Localizations->Localization[1]->SpecificLocalization);
	$municipio=utf8_encode($municipio);
	$poblacion=utf8_decode($datos->ObjectivePeople);
	$eje=(string)utf8_decode($datos->PublicationContribution->Strategy);
	$eje=utf8_encode($eje);
	$programa=(string)utf8_decode($datos->PublicationContribution->ProgramDescription);
	$programa=utf8_encode($programa);
	$subprograma=(string)utf8_decode($datos->FundingSource->ExpenseType->Description);
	$subprograma=utf8_encode($subprograma);
	$objetivo=tildes($datos->GeneralObjective->GeneralObjective);
	//OBTENER VALOR DEL PROYECTO SUMANDO LAS ACTIVIDADES
	$monto=array();
	$detalle=array();
	$periodo=array();
	$indice=0;
	$val=0;
        $total=0;
	foreach ($datos->FundingSource->Sources->Source as $tipo) 
			{
				$detalle[]=tildes((string)$tipo->ResourceType->Description);
				//echo $a;
				foreach ($datos->FundingSource->Sources->Source[$indice]->SourceProgrammings->SourceProgramming as $valores)
				{
					$monto[]=(string)$valores->Amount;
					$total=$total + $monto[$val];
					$periodo[]=(string)$valores->Period;
					$informacion[$val] = array("Origen" =>$detalle[$indice],"Valor" =>$monto[$val],"Periodo"=>$periodo[$val]);
					//echo $b."<br>";
				$val++;
				}
				$indice++;	
			}	
	$total= number_format($total, 0, '', '.'); 
//	INFORMACION DE LAS ACTIVIDADES DEL PROYECTO
	$actividades=array();
	$numpro=0;
	$numact=0;

$num_elementos=count($datos->Alternatives->Alternative->Products->Product);

if($num_elementos !=0){

foreach ($datos->Alternatives->Alternative->Products->Product as $producto) 
			{
			$actividades[]=tildes((string)$producto->ProductName);
			$informacionProductos[$numpro]=array("id_producto"=>$numpro,"producto"=>$actividades[$numpro]);
			foreach ($datos->Alternatives->Alternative->Products->Product[$numpro]->Activities->Activity as $actividad)
			{
				//echo $numact;
				$nombreact[]=tildes((string)$actividad->Name);
				$costo[]=(string)$actividad->Cost;
				$informacion_act[$numact] = array("id_pro"=>$numpro,"Actividad"=> $nombreact[$numact],"Costo"=>$costo[$numact]); 
				
				
			$numact++;
			}
						
			$numpro++;
			}	
}

	//INFORMACION DE LOS OBJETIVOS ESPECIFICOS

			$ob_especificos=array();
			$jsonespecifico=array();
			$deta=array();
			$val1=0;
			foreach ($datos->CentralProblem->Causes->Cause as $causa) 
			{
			$ob_especificos[]=tildes($causa->SpecificObjective->SpecificObjective);
			$jsonespecifico[$val1]=array("Objetivo"=>$ob_especificos[$val1]);
			$val1++;
			}	
			$jsonEs = CambiarFormatos::convertirAJsonItems($jsonespecifico);			
			$jsonFu  = CambiarFormatos::convertirAJsonItems($informacion);
			$jsonPro  = CambiarFormatos::convertirAJsonItems($informacionProductos);
			$jsonAct  = CambiarFormatos::convertirAJsonItems($informacion_act);
			

	$datos=$nombrep."*/".$sector."*/".$departamento."*/".$municipio."*/".$eje."*/".$programa."*/".$subprograma."*/".$total."*/".$numero_proyecto."*/".$jsonEs."*/".($jsonFu != null ? $jsonFu : "'null'" )."*/".$problema."*/".$poblacion."*/".$objetivo
	."*/".($jsonPro != null ? $jsonPro : "'null'" )."*/".($jsonAct != null ? $jsonAct : "'null'" );
	echo $datos;
	//print_r($jsonespecifico);
}
else
{
	echo "EL ARCHIVO DEBE TENER EXTENCION XML";
}
//echo hash_file('md5',$_FILES['frm_archivo']['name']);
?>
 <?php
}
else {
    header('http://'.$_SERVER['SERVER_NAME']);
}
?>