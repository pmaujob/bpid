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
	$departamento=(string)utf8_decode($datos->Localizations->Localization[1]->Department->Name);
	$departamento=utf8_encode($departamento);
	$municipio=(string)utf8_decode($datos->Localizations->Localization[1]->SpecificLocalization);
	$municipio=utf8_encode($municipio);
	$eje=(string)utf8_decode($datos->PublicationContribution->Strategy);
	$eje=utf8_encode($eje);
	$programa=(string)utf8_decode($datos->PublicationContribution->ProgramDescription);
	$programa=utf8_encode($programa);
	$subprograma=(string)utf8_decode($datos->FundingSource->ExpenseType->Description);
	$subprograma=utf8_encode($subprograma);
	//OBTENER VALOR DEL PROYECTO SUMANDO LAS ACTIVIDADES
	$monto=array();
	$detalle=array();
	$periodo=array();
	$indice=0;
	$val=0;
	foreach ($datos->FundingSource->Sources->Source as $tipo) 
			{
				$detalle[]=utf8_decode((string)$tipo->ResourceType->Description);
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
	$datos=$nombrep."*/".$sector."*/".$departamento."*/".$municipio."*/".$eje."*/".$programa."*/".$subprograma."*/".$total."*/".$numero_proyecto."*/".$jsonEs."*/".$jsonFu;
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