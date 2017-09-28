<?php



$ruta_tmp=	  $_FILES['frm_archivo']['tmp_name'];//ruta temporal del archivo
$nombre=  $_FILES['frm_archivo']['name'];//verificar si el nombre esta bn escrito
$ruta=$ruta_tmp;
$trozos = explode(".", $nombre); 
$extension = end($trozos); //obtener la extencion del archivo
if($extension=="xml" or $extension=="XML")
{
	try {
    $xml = new SimpleXMLElement($buffer);

	$datos=simplexml_load_file($ruta);
	$nombre_proyecto=(string)utf8_decode($datos->Name);
	$nombre_proyecto=strtoupper(utf8_encode($nombre_proyecto));
	$nombre_proyecto = htmlentities($nombre_proyecto);
	$numero_proyecto=utf8_decode($datos->Id);
	$sector=(string)utf8_decode($datos->Sector->Description);
	$sector=strtoupper(utf8_encode($sector));
	$departamento=(string)utf8_decode($datos->Localizations->Localization[1]->Department->Name);
	$departamento=strtoupper(utf8_encode($departamento));
	$municipio=(string)utf8_decode($datos->Localizations->Localization[1]->SpecificLocalization);
	$municipio=strtoupper(utf8_encode($municipio));
	$eje=(string)utf8_decode($datos->PublicationContribution->Strategy);
	$eje=strtoupper(utf8_encode($eje));
	$programa=(string)utf8_decode($datos->PublicationContribution->ProgramDescription);
	$programa=strtoupper(utf8_encode($programa));
	$subprograma=(string)utf8_decode($datos->FundingSource->ExpenseType->Description);
	$subprograma=strtoupper(utf8_encode($subprograma));
	$objetivo=utf8_decode($datos->GeneralObjective->GeneralObjective);
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
				
		foreach ($datos->FundingSource->Sources->Source[$indice]->SourceProgrammings->SourceProgramming =""? null:$datos->FundingSource->Sources->Source[$indice]->SourceProgrammings->SourceProgramming as $valores)
				{
					
					$monto[]=(string)$valores->Amount;
					$total=$total + $monto[$val];
					$periodo[]=(string)$valores->Period;
					$informacion[$val] = array($detalle[$indice] => $monto[$val],"Periodo"=>$periodo[$val]); 
					//echo $b."<br>";
				$val++;
				}
				$indice++;	
			
					
				}	
	$total= number_format($total, 0, '', '.'); 
	$datos=$nombre_proyecto."/".$sector."/".$departamento."/".$municipio."/".$eje."/".$programa."/".$subprograma."/".$total."/".$numero_proyecto;
	echo $datos;
}
else
{
	echo "EL ARCHIVO DEBE TENER EXTENCION XML";
}
} catch (Exception $e) {
    echo $e;
}
?>